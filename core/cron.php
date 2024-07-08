<?php

/*
 * @author MD ARIFUL HAQUE
 * @name: Rainbow PHP Framework
 * @copyright 2021 KOVATZ.COM
 *
 */

//-------------------------------------------------
//----------------- CRON JOB FILE -----------------
//-------------------------------------------------

//Define CRON 
define('CRON','_1');

//ROOT Path
define('ROOT_DIR', realpath(dirname(dirname(__FILE__))) .DIRECTORY_SEPARATOR);

//Application Path
define('APP_DIR', ROOT_DIR .'core'.DIRECTORY_SEPARATOR);

//Configuration Path
define('CONFIG_DIR', APP_DIR .'config'.DIRECTORY_SEPARATOR);

//Load Configuration & Functions
require CONFIG_DIR.'config.php';
require APP_DIR.'functions.php';

//Log File
$logMyCronFile = LOG_DIR.'cron.tdata';
$msgWithDate = '';
$msgWithDate .= '['. date('d-M-Y H:i:s') . ' ' . getTimeZone() .']' . " Cron job started \r\n\n";
            
//Clear Temp Folder Files
$folderName = APP_DIR.'temp'.D_S;
if (file_exists($folderName)) {
    foreach (new DirectoryIterator($folderName) as $fileInfo) {
        if ($fileInfo->isDot())
            continue;
        if (time() - $fileInfo->getCTime() >= 60 * 60) {
            $fileName = $fileInfo->getFilename();
            if($fileName != '.htaccess' && $fileName != 'index.php'){
                if(is_dir($fileInfo->getRealPath()))
                    delDir($fileInfo->getRealPath());
                else
                    delFile($fileInfo->getRealPath());
            }
        }
    }
}

//Clear PDF Report Folder Files
$folderName = ROOT_DIR.'resources'.D_S.'pdf-reports'.D_S;
if (file_exists($folderName)) {
    foreach (new DirectoryIterator($folderName) as $fileInfo) {
        if ($fileInfo->isDot())
            continue;
        if (time() - $fileInfo->getCTime() >= 60 * 60) {
            $fileName = $fileInfo->getFilename();
            if($fileName != '.htaccess' && $fileName != 'index.php'){
                if(is_dir($fileInfo->getRealPath()))
                    delDir($fileInfo->getRealPath());
                else
                    delFile($fileInfo->getRealPath());
            }
        }
    }
}

//Database Connection
$con = dbConncet($dbHost,$dbUser,$dbPass,$dbName);

//Load Settings
$siteInfo =  mysqli_query($con, "SELECT * FROM site_info where id='1'");
$siteInfoRow = mysqli_fetch_array($siteInfo);
$other = dbStrToArr($siteInfoRow['other_settings']);

$sitemapBuildNow = $dbBackup = false;
if(isSelected($other['other']['sitemap']['cron'])){
    if($other['other']['sitemap']['cronopt'] == 'daily'){
        if((time() - $other['other']['sitemap']['cronlog']) > 86400)
            $sitemapBuildNow = true;
    }
   if($other['other']['sitemap']['cronopt'] == 'weekly'){
        if((time() - $other['other']['sitemap']['cronlog']) > 604800)
            $sitemapBuildNow = true;
    }
   if($other['other']['sitemap']['cronopt'] == 'monthly'){
        if((time() - $other['other']['sitemap']['cronlog']) > 2592000)
            $sitemapBuildNow = true;
    }
}

if(isSelected($other['other']['dbbackup']['cron'])){
    if($other['other']['dbbackup']['cronopt'] == 'daily'){
        if((time() - $other['other']['dbbackup']['cronlog']) > 86400)
            $dbBackup = true;
    }
   if($other['other']['dbbackup']['cronopt'] == 'weekly'){
        if((time() - $other['other']['dbbackup']['cronlog']) > 604800)
            $dbBackup = true;
    }
   if($other['other']['dbbackup']['cronopt'] == 'monthly'){
        if((time() - $other['other']['dbbackup']['cronlog']) > 2592000)
            $dbBackup = true;
    }
}

//Build Sitemap
if($sitemapBuildNow){
    define('ADMIN_CON_DIR', ROOT_DIR.ADMIN_DIR_NAME.D_S.'controllers'.D_S);
    define('SITEMAP_',true);
    require ADMIN_CON_DIR.'sitemap-build.php';
    
    if(file_exists(ROOT_DIR.'sitemap.xml'))
        $msgWithDate .= '['. date('d-M-Y H:i:s') . ' ' . getTimeZone() .']' . " Sitemap generated successfully \r\n\n";
    else
        $msgWithDate .= '['. date('d-M-Y H:i:s') . ' ' . getTimeZone() .']' . " Sitemap generation failed \r\n\n";
            
    //Update sitemap build time on database
    $other['other']['sitemap']['cronlog'] = time();
    $other_settings = arrToDbStr($con,$other);
    $query = "UPDATE site_info SET other_settings='$other_settings' WHERE id='1'";
    mysqli_query($con, $query);
    $dbBackup = false;
}

//Backup Database
if($dbBackup){
    $dbBackupPath = ROOT_DIR.ADMIN_DIR_NAME.D_S.'db-backups'.D_S;
    $filePath = backupMySQLdb($con, $dbName, $dbBackupPath, isSelected($other['other']['dbbackup']['gzip']));
    
    if(file_exists($filePath))
        $msgWithDate .= '['. date('d-M-Y H:i:s') . ' ' . getTimeZone() .']' . " Database backup generated successfully \r\n\n";
    else
        $msgWithDate .= '['. date('d-M-Y H:i:s') . ' ' . getTimeZone() .']' . " Database backup failed \r\n\n";
    
    //Update sitemap build time on database
    $other['other']['dbbackup']['cronlog'] = time();
    $other_settings = arrToDbStr($con,$other);
    $query = "UPDATE site_info SET other_settings='$other_settings' WHERE id='1'";
    mysqli_query($con, $query);
}

//Close the database conncetion
mysqli_close($con);

//Log Ending Time
$msgWithDate .= '['. date('d-M-Y H:i:s') . ' ' . getTimeZone() .']' . " Cron job successfully completed! \r\n\n";
putMyData($logMyCronFile,$msgWithDate,FILE_APPEND);

//-------------------------------------------------
//------------------- B-ALAJ-I --------------------
//-------------------------------------------------

//END
die();
?>