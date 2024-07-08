<?php
defined('APP_NAME') or die(header('HTTP/1.1 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: Rainbow PHP Framework
 * @copyright 2021 KOVATZ.COM
 *
 */

$fullLayout = 1;
$pageTitle = 'Captcha Protection';
$subTitle = 'Captcha Settings';
$footerAdd = true; $footerAddArr = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $myValues = array_map_recursive(
        function($item) use ($con) { return escapeTrim($con,$item); },
        $_POST
    );

    $capthcaData = arrToDbStr($con, $myValues['cap']);
    $capthcaPagesArr = array();
    
    foreach(capPages() as $capName=>$capRaw){
        if(in_array($capName,$myValues['cap_pages']))
            $capthcaPagesArr[$capName] = true;
        else
            $capthcaPagesArr[$capName] = false;
    }
    $capthcaPages = arrToDbStr($con, $capthcaPagesArr);
    $cap_type = strtolower($myValues['sel_cap']);
    
    $query = "UPDATE capthca SET cap_options='$capthcaPages', cap_data='$capthcaData', cap_type='$cap_type' WHERE id='1'";
    mysqli_query($con, $query);

    if (mysqli_errno($con))
        $msg = errorMsgAdmin(mysqli_error($con));
    else
        $msg = successMsgAdmin('Captcha settings saved successfully');    
}

extract(loadAllCapthca($con));

$cap_options = dbStrToArr($cap_options);
$cap_data = dbStrToArr($cap_data);
$capList = capPages();

foreach($cap_data as $capEx)
    extract($capEx);