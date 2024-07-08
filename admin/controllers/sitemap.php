<?php

defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: Rainbow PHP Framework
 * @copyright © 2022 KOVATZ.COM
 *
 */
 
$pageTitle = 'Sitemap';
$subTitle = 'Build Sitemap';
$fullLayout = 1;$footerAdd = true; $footerAddArr = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $siteInfo =  mysqli_query($con, "SELECT * FROM site_info where id='1'");
    $siteInfoRow = mysqli_fetch_array($siteInfo);
    $other = dbStrToArr($siteInfoRow['other_settings']);

    $myValues = array_map_recursive(
        function($item) use ($con) { return escapeTrim($con,$item); },
        $_POST['other']
    );
    
    unset($other['other']['sitemap']);

    if(!isset($myValues['other']['sitemap']['gzip']))
        $myValues['other']['sitemap']['gzip'] = false;
    if(!isset($myValues['other']['sitemap']['cron']))
        $myValues['other']['sitemap']['cron'] = false;
    if(!isset($myValues['other']['sitemap']['multilingual']))
        $myValues['other']['sitemap']['multilingual'] = false;
    if(!isset($myValues['other']['sitemap']['auto']))
        $myValues['other']['sitemap']['auto'] = false;
    if(!isset($myValues['other']['sitemap']['priority']))
        $myValues['other']['sitemap']['priority'] = '0.9';
    if(!isset($myValues['other']['sitemap']['freqrange']))
        $myValues['other']['sitemap']['freqrange'] = 'daily';
          
    $other = array_merge_recursive($other,$myValues);
    
    $other_settings = arrToDbStr($con,$other);
            
    $query = "UPDATE site_info SET other_settings='$other_settings' WHERE id='1'";
    mysqli_query($con, $query);

    if (mysqli_errno($con))
        $msg = errorMsgAdmin(mysqli_error($con));
    else
        $msg = successMsgAdmin('Sitemap settings saved successfully');
}

//Load Sitemap Settings
$siteInfo =  mysqli_query($con, "SELECT * FROM site_info where id='1'");
$siteInfoRow = mysqli_fetch_array($siteInfo);
$other = dbStrToArr($siteInfoRow['other_settings']);

//Build Sitemap 
if ($pointOut == 'build') {
    
    define('SITEMAP_',true);
    require ADMIN_CON_DIR.'sitemap-build.php';
   
    if(file_exists(ROOT_DIR.'sitemap.xml'))
        redirectTo(adminLink($controller.'/build-success',true));
    else
        redirectTo(adminLink($controller.'/build-failed',true));
}

if($pointOut == 'build-success')
    $msg = successMsgAdmin('Sitemap generated successfully');
    
if($pointOut == 'build-failed')
    $msg = errorMsgAdmin('Sitemap generation failed');

//Check Sitemap
$sitemapData = false;
if(file_exists(ROOT_DIR.'sitemap.xml')){
    $siteMapRes = 'File Found';
    $sitemapData = true;
}else{
    $siteMapRes = 'File Not Found';
}
?>