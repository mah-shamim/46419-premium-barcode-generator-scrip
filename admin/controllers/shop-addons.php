<?php
defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));


/*
 * @author MD ARIFUL HAQUE
 * @name: Rainbow PHP Framework
 * @copyright © 2022 KOVATZ.COM
 *
 */
 
$pageTitle = 'Shop Addons';
$subTitle = 'Faster Seo Tools Addons';
$fullLayout = 1; $footerAdd = true; $footerAddArr = array();

if($pointOut == 'ajax'){
    $query = http_build_query($_GET) . "\n";
    echo getMyData('http://api.KOVATZ.COM/tweb/shop_addon.php?'.$query);
    die();
}


?>