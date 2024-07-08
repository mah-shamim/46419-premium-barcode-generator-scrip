<?php

defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: Tools
 * @copyright © 2024
 *
 */

$fullLayout = 1;
$pageTitle = 'Manage Site';
$subTitle = 'Basic Settings';
$footerAdd = true; $footerAddArr = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if(isset($_POST['title'])){

        $siteInfo =  mysqli_query($con, "SELECT * FROM site_info where id='1'");
        $siteInfoRow = mysqli_fetch_array($siteInfo);
        $other = dbStrToArr($siteInfoRow['other_settings']);

        $title = escapeTrim($con, $_POST['title']);
        $des = escapeTrim($con, $_POST['des']);
        $keyword = escapeTrim($con, $_POST['keyword']);
        $site_name = escapeTrim($con, $_POST['site_name']);
        $email = escapeTrim($con, $_POST['email']);
        $copyright = escapeTrim($con, $_POST['copyright']);
        $ga = escapeTrim($con, $_POST['ga']);
        $other['other']['ga'] = $ga;
        $other_settings = arrToDbStr($con,$other);
        $doForce = arrToDbStr($con,array(raino_trim($_POST['https']),raino_trim($_POST['www'])));
        $social_links =  array_map_recursive(
            function($item) use ($con) { return escapeTrim($con,$item); },
            $_POST['social']
        );
        $socialDB = arrToDbStr($con,$social_links);
        $query = "UPDATE site_info SET title='$title', des='$des', keyword='$keyword', site_name='$site_name', email='$email', copyright='$copyright', other_settings='$other_settings', doForce='$doForce', social_links='$socialDB' WHERE id='1'";
        mysqli_query($con, $query);
    
        if (mysqli_errno($con))
            $msg = errorMsgAdmin(mysqli_error($con));
        else
            $msg = successMsgAdmin('Site information saved successfully');
    }
    
}

//Get site Info
$siteInfo =  mysqli_query($con, "SELECT * FROM site_info where id='1'");
$siteInfoRow = mysqli_fetch_array($siteInfo);

$title = Trim($siteInfoRow['title']);
$des = Trim($siteInfoRow['des']);
$keyword = Trim($siteInfoRow['keyword']);
$site_name = Trim($siteInfoRow['site_name']);
$email = Trim($siteInfoRow['email']);
$social_links = dbStrToArr($siteInfoRow['social_links']);
$other = dbStrToArr($siteInfoRow['other_settings']);
$doForce = dbStrToArr($siteInfoRow['doForce']);
$copyright = htmlspecialchars_decode(Trim($siteInfoRow['copyright']));
$forceHttps = filter_var($doForce[0], FILTER_VALIDATE_BOOLEAN);
$forceWww = filter_var($doForce[1], FILTER_VALIDATE_BOOLEAN);
$ga = $other['other']['ga'];
?>