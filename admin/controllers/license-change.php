<?php

defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: KOVATZ Seo Tools
 * @copyright � 2022 KOVATZ.COM
 *
 */


$pageTitle = 'Domain License';
$subTitle = 'License Change';
$fullLayout = 1; $footerAdd = false;

//Domain License Info
$jsonData = simpleCurlGET('http://api.KOVATZ.COM/tweb/info.php?link='.createLink('',true).'&code='.$item_purchase_code);
$licArr = json_decode($jsonData,true);

?>