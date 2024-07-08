<?php

defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: KOVATZ Seo Tools
 * @copyright � 2022 KOVATZ.COM
 *
 */

$pageTitle = 'Adblock Detection';
$subTitle = 'Detect & Ban - Ad Blocking Users';
$fullLayout = 1; $footerAdd = true; $footerAddArr = array();

$taskData =  mysqli_query($con, "SELECT * FROM rainbowphp_temp where task='adblock'");
$taskRow = mysqli_fetch_array($taskData);
$adblock = dbStrToArr($taskRow['data'],true);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $myValues = array_map_recursive(
        function($item) use ($con) { return escapeTrim($con,$item); },
        $_POST
    );

    if(!isset($myValues['adblock']['enable']))
        $myValues['adblock']['enable'] = 'off';

    $adblock = $myValues['adblock'];
    $strData = arrToDbStr($con, $adblock);
    $adblock = array_map_recursive('stripcslashes',$adblock);

    $query = "UPDATE rainbowphp_temp SET data='$strData' WHERE task='adblock'";
    mysqli_query($con, $query);

    if (mysqli_errno($con))
        $msg = errorMsgAdmin(mysqli_error($con));
    else
        $msg = successMsgAdmin('Captcha settings saved successfully'); 
    
}

?>