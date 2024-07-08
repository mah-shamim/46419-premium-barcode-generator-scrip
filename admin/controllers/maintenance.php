<?php

defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
* @author MD ARIFUL HAQUE
* @name: Faster Seo Tools
* @copyright © 2022 KOVATZ.COM
*
*/

$pageTitle = 'Maintenance Settings';
$subTitle = 'Site Online / Offline';
$fullLayout = 1; $footerAdd = true; $footerAddArr = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    $siteInfo =  mysqli_query($con, "SELECT * FROM site_info where id='1'");
    $siteInfoRow = mysqli_fetch_array($siteInfo);
    $other = dbStrToArr($siteInfoRow['other_settings']);
        
    $other['other']['maintenance'] = escapeTrim($con, $_POST['maintenance_mode']);
    $other['other']['maintenance_mes'] = escapeTrim($con, $_POST['maintenance_mes']);
    $other_settings = arrToDbStr($con,$other);
            
    $query = "UPDATE site_info SET other_settings='$other_settings' WHERE id='1'";
    mysqli_query($con, $query);

    if (mysqli_errno($con))
        $msg = errorMsgAdmin(mysqli_error($con));
    else
        $msg = successMsgAdmin('Maintenance settings saved successfully');

}

//Load Maintenance Settings
$siteInfo =  mysqli_query($con, "SELECT * FROM site_info where id='1'");
$siteInfoRow = mysqli_fetch_array($siteInfo);
$other = dbStrToArr($siteInfoRow['other_settings']);
     
$maintenance_mode = isSelected($other['other']['maintenance']);
$maintenance_mes =  $other['other']['maintenance_mes'];
?>