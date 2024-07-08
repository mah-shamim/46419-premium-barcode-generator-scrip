<?php

defined('APP_NAME') or die(header('HTTP/1.1 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: KOVATZ Seo Tools
 * @copyright 2021 KOVATZ.COM
 *
 */

$pageTitle = 'Administrators Accounts';
$subTitle = 'Admin Details';
$fullLayout = 1; $footerAdd = $avatarPage = $passPage = false; $footerAddArr = array();

require_once (LIB_DIR . 'geoip.inc');
$gi = geoip_open(LIB_DIR.'GeoIP.dat', GEOIP_MEMORY_CACHE);
$giv6 = geoip_open(LIB_DIR.'GeoIPv6.dat', GEOIP_MEMORY_CACHE);

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    if(isset($_FILES['logoUpload']) && $_FILES['logoUpload']['name'] != ''){
        $isUploaded = secureImageUpload($_FILES['logoUpload']);
        if($isUploaded[0]){
             $query = "UPDATE admin SET admin_logo='".$isUploaded[1]."' WHERE id='1'"; 
             mysqli_query($con,$query); 
        }else
            $msg = errorMsgAdmin($isUploaded[1]);
    }
        
    if(isset($_POST['passChange'])){
        $passPage = true;    
        $query =  mysqli_query($con, "SELECT * FROM admin WHERE id='1'");
        $infoRow = mysqli_fetch_array($query);
        $admin_oldPass = Trim($infoRow['pass']);
       
        $admin_user = escapeTrim($con, $_POST['admin_user']);
        $admin_name = escapeTrim($con, $_POST['admin_name']);
        $new_pass = passwordHash(escapeTrim($con, $_POST['new_pass']));
        $retype_pass = passwordHash(escapeTrim($con, $_POST['retype_pass']));
        $old_pass = passwordHash(escapeTrim($con, $_POST['old_pass']));
    
        if($new_pass == $retype_pass){  
            if($old_pass == $admin_oldPass){
                $query = "UPDATE admin SET user='$admin_user', pass='$new_pass', admin_name='$admin_name' WHERE id='1'";
                mysqli_query($con, $query);
            
                if (mysqli_errno($con))
                    $msg = errorMsgAdmin(mysqli_error($con));
                else
                    $msg = successMsgAdmin('New Passwors saved successfully!');
            }else{
                $msg = errorMsgAdmin('Old admin panel password is wrong!');
            }
        }else{
            $msg = errorMsgAdmin('New Password field / Retype password field can\'t matched!');
        }
  }
}

$query =  mysqli_query($con, "SELECT * FROM admin WHERE id='1'");
$infoRow = mysqli_fetch_array($query);
$admin_user = Trim($infoRow['user']);
$admin_pass = Trim($infoRow['pass']);
$admin_name = Trim($infoRow['admin_name']);
$admin_logo = Trim($infoRow['admin_logo']);
$admin_reg_date = Trim($infoRow['admin_reg_date']);
$admin_reg_ip = Trim($infoRow['admin_reg_ip']);


$query = "SELECT count(id) FROM admin_history";
$retval = mysqli_query($con,$query);
$row = mysqli_fetch_array($retval);
$rec_count = Trim($row[0]);
$lastID_Admin = getLastID($con,"admin_history");

$result = mysqli_query($con, "SELECT * FROM admin_history WHERE id='$lastID_Admin'");
$row = mysqli_fetch_array($result);
$admin_last_login_date = Trim($row['last_date']);
$admin_last_login_ip = Trim($row['ip']);

if ($passPage){
    $page1 = $page3 = '';
    $page2 = "active";
}elseif($avatarPage){
    $page1 = $page2 = '';
    $page3 = "active";
}else{
    $page1 = "active";
    $page2 = $page3 = '';
}
