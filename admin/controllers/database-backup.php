<?php

defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: Rainbow PHP Framework
 * @copyright � 2022 KOVATZ.COM
 *
 */
 
$pageTitle = 'Database Backup';
$subTitle = 'DB Backup Settings';
$fullLayout = 1;$footerAdd = true; $footerAddArr = array();

$dbBackupPath = ADMIN_DIR.'db-backups'.D_S;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $siteInfo =  mysqli_query($con, "SELECT * FROM site_info where id='1'");
    $siteInfoRow = mysqli_fetch_array($siteInfo);
    $other = dbStrToArr($siteInfoRow['other_settings']);

    $myValues = array_map_recursive(
        function($item) use ($con) { return escapeTrim($con,$item); },
        $_POST['other']
    );
    
    unset($other['other']['dbbackup']);

    if(!isset($myValues['other']['dbbackup']['gzip']))
        $myValues['other']['sitemap']['gzip'] = false;
    if(!isset($myValues['other']['dbbackup']['cron']))
        $myValues['other']['sitemap']['cron'] = false;
    if(!isset($myValues['other']['dbbackup']['cronopt']))
        $myValues['other']['dbbackup']['cronopt'] = 'daily';
          
    $other = array_merge_recursive($other,$myValues);
    
    $other_settings = arrToDbStr($con,$other);
            
    $query = "UPDATE site_info SET other_settings='$other_settings' WHERE id='1'";
    mysqli_query($con, $query);

    if (mysqli_errno($con))
        $msg = errorMsgAdmin(mysqli_error($con));
    else
        $msg = successMsgAdmin('Database settings saved successfully');
}

//Load Database Settings
$siteInfo =  mysqli_query($con, "SELECT * FROM site_info where id='1'");
$siteInfoRow = mysqli_fetch_array($siteInfo);
$other = dbStrToArr($siteInfoRow['other_settings']);

if($pointOut == 'backup-now'){
    $filePath = backupMySQLdb($con, $dbName, $dbBackupPath, isSelected($other['other']['dbbackup']['gzip']));
    
    if(file_exists($filePath))
        $msg = successMsgAdmin('Database backup saved Successfully');
    else
        $msg = errorMsgAdmin('Database backup failed');
}

if($pointOut == 'backup-download'){
    $filePath = backupMySQLdb($con, $dbName, $dbBackupPath, isSelected($other['other']['dbbackup']['gzip']));
    
    if(file_exists($filePath)){
        $onlyFilename = end(explode(D_S,$filePath));
        header('Content-Type: application/octet-stream');   
        header("Content-Transfer-Encoding: Binary"); 
        header("Content-disposition: attachment; filename=\"".$onlyFilename."\"");  
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit();
    }else{
        $msg = errorMsgAdmin('Database backup failed'); 
    }
}

if($pointOut == 'download'){
    if(isset($args[0]) && $args != ''){
        $filePath = $dbBackupPath.trim($args[0]);
        if(file_exists($filePath)){
            header('Content-Type: application/octet-stream');   
            header("Content-Transfer-Encoding: Binary"); 
            header("Content-disposition: attachment; filename=\"".trim($args[0])."\"");  
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filePath));
            readfile($filePath);
            exit();
        }
    }
}

if($pointOut == 'delete'){
    if(isset($args[0]) && $args != ''){
        $filePath = $dbBackupPath.trim($args[0]);
        if(file_exists($filePath)) unlink($filePath);
        
        if(!file_exists($filePath))
            $msg = successMsgAdmin('Backup file deleted Successfully');
        else
            $msg = errorMsgAdmin('Unable to remove backup file');
    }
}

$tableData = '';
function doTableData($filename,$controller){
    $onlyFilename = explode(D_S,$filename);
    $onlyFilename = end($onlyFilename);
    return '<tr>
        <td>'.$onlyFilename.'</td>
        <td>'.date ("F d Y h:i:s A", filemtime($filename)).'</td>
        <td><a class="btn btn-primary btn-xs" href="'.adminLink($controller.'/download/'.$onlyFilename.'/now',true).'"> <i class="fa fa-download"></i> &nbsp; Download </a></td>
        <td><a class="btn btn-danger btn-xs" onclick="return confirm(\'Are you sure you want to delete this item?\');" href="'.adminLink($controller.'/delete/'.$onlyFilename.'/now',true).'"> <i class="fa fa-trash-o"></i> &nbsp; Delete </a></td>
    </tr>';
}

foreach(glob($dbBackupPath.'{'.$dbName.'}*.sql',GLOB_BRACE) as $filename)
    $tableData .= doTableData($filename,$controller);
    
foreach(glob($dbBackupPath.'{'.$dbName.'}*.sql.gz',GLOB_BRACE) as $filename)
    $tableData .= doTableData($filename,$controller);
?>