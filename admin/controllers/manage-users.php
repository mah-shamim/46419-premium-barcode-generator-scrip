<?php
defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: Rainbow PHP Framework
 * @copyright © 2022 KOVATZ.COM
 *
 */

$pageTitle = 'Manage Users';
$subTitle = 'User List';
$fullLayout = 1; $footerAdd = true; $footerAddArr = array();

//Success Action
if($pointOut == 'new-user-success'){
    $msg = successMsgAdmin('New user added successfully!');
}

//Delete Action
if($pointOut == 'delete'){
    $user_id = $args[0];
    if($args[0] != ''){
        $query = "DELETE FROM users WHERE id=$user_id";
        $result = mysqli_query($con, $query);
        if (mysqli_errno($con)){
            $msg = errorMsgAdmin(mysqli_error($con));
        } else {
            header('Location:'.adminLink($controller,true));
            die();
        }
    }
}

//Ban Action
if($pointOut == 'ban'){
    $ban_id = $args[0];
    if($args[0] != ''){
        $query = "UPDATE users SET verified='2' WHERE id='$ban_id'";
        $result = mysqli_query($con, $query);
        if (mysqli_errno($con)){
            $msg = errorMsgAdmin(mysqli_error($con));
        } else {
            header('Location:'.adminLink($controller,true));
            die();
        }
    }
}


//UnBan Action
if($pointOut == 'unban'){
    $ban_id = $args[0];
    if($args[0] != ''){
    $query = "UPDATE users SET verified='1' WHERE id='$ban_id'";
        $result = mysqli_query($con, $query);
        if (mysqli_errno($con)){
            $msg = errorMsgAdmin(mysqli_error($con));
        } else {
            header('Location:'.adminLink($controller,true));
            die();
        }
    }
}

//Export Action
if($pointOut == 'export'){
    
    function sendHeaders($filename) {
        //Disable caching
        $now = gmdate("D, d M Y H:i:s");
        header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
        header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
        header("Last-Modified: {$now} GMT");
    
        //Force download  
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
    
        //Disposition / encoding on response body
        header("Content-Disposition: attachment;filename={$filename}");
        header("Content-Transfer-Encoding: binary");
    }
    
    sendHeaders("data_export_" . date("Y-m-d") . ".csv");
    
    $idsList = array();
    $out = fopen('php://output', 'w');
    $query = "SELECT * FROM users";
    $result = mysqli_query($con, $query);
    while ($row = mysqli_fetch_array($result)) {
        $idsList = array($row['email_id']);
        fputs($file, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
        fputcsv($out, $idsList);
    }
    fclose($out);
    die();
}

//Profile Action
if($pointOut == 'info'){
    $subTitle = 'User Profile';
    
    require_once (LIB_DIR . 'geoip.inc');
    $gi = geoip_open(LIB_DIR.'GeoIP.dat', GEOIP_MEMORY_CACHE);
    
    $user_id = $args[0];
    if($args[0] != ''){
        $result =  mysqli_query($con, "SELECT * FROM users WHERE id='$user_id'");
        $userInfo = mysqli_fetch_array($result,MYSQLI_ASSOC); 
        $userInfo['picture'] = trim($userInfo['picture']);
        if($userInfo['picture'] == '' || strtoupper($userInfo['picture']) == 'NONE' || strtoupper($userInfo['picture']) == 'NULL' || $userInfo['picture'] == null)
            $userInfo['picture'] =  themeLink('dist/img/user-default.png',true);
        else
            $userInfo['picture'] =  createLink($userInfo['picture'],true);
        
        if ($userInfo['oauth_uid'] == '0' || $userInfo['oauth_uid'] == '')
            $userInfo['oauth_uid'] = 'None';
            
        if ($userInfo['verified'] == '0')
            $userInfo['verified'] = '<span style="color: #d35400;">Unverified User</span>';
        elseif ($userInfo['verified'] == '1')
            $userInfo['verified'] = '<span style="color: #27ae60;">Active User</span>';
         elseif ($userInfo['verified'] == '2')
            $userInfo['verified'] = '<span style="color: #c0392b;">Banned User</span>';

        $date_raw = date_create($userInfo['added_date']);
        $registeredAt  = date_format($date_raw,"jS F Y");
        if($userInfo['country'] == '')
            $userInfo['country'] = 'Not Mentioned!';
        $detectedUserCountry = geoip_country_name_by_addr($gi,$userInfo['ip']);
        
        if($detectedUserCountry == '')
            $detectedUserCountry = 'Unknown';
            
        geoip_close($gi);
    }
}

?>