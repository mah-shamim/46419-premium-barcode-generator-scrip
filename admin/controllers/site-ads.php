<?php

defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
* @author MD ARIFUL HAQUE
* @name: Faster Seo Tools
* @copyright © 2022 KOVATZ.COM
*
*/

$pageTitle = 'Website Advertisement';
$subTitle = "Site Ads Settings";
$fullLayout = 1; $footerAdd = false; $footerAddArr = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    $ad720x90 = escapeTrim($con, $_POST['ad720x90']);
    $ad250x300 = escapeTrim($con, $_POST['ad250x300']);
    $ad250x125 = escapeTrim($con, $_POST['ad250x125']);
    $ad480x60 = escapeTrim($con, $_POST['ad480x60']);
    $text_ads = escapeTrim($con, $_POST['text_ads']);

    $query = "UPDATE ads SET ad720x90='$ad720x90', ad250x300='$ad250x300', ad250x125='$ad250x125', ad480x60='$ad480x60', text_ads='$text_ads' WHERE id='1'";
    mysqli_query($con, $query);

    if (mysqli_errno($con))
        $msg = errorMsgAdmin(mysqli_error($con));
     else
        $msg = successMsgAdmin('Ads Settings saved successfully');
}

//Load AD Codes
$dbAd = mysqli_query($con, "SELECT * FROM ads where id='1'");
$dbAdRow = mysqli_fetch_array($dbAd);
$ad720x90 = Trim($dbAdRow['ad720x90']);
$ad250x300 = Trim($dbAdRow['ad250x300']);
$ad250x125 = Trim($dbAdRow['ad250x125']);
$ad480x60 = Trim($dbAdRow['ad480x60']);
$text_ads = Trim($dbAdRow['text_ads']);
?>