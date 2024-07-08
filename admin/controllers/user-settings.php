<?php

defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: KOVATZ Seo Tools
 * @copyright 2022 KOVATZ.COM
 *
 */

$pageTitle = 'User Account Settings';
$subTitle = 'Users Settings';
$fullLayout = 1; $footerAdd = true; $footerAddArr = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $enable_reg = escapeTrim($con, $_POST['enable_reg']);
    $enable_oauth = escapeTrim($con, $_POST['enable_oauth']);
    $enable_quick = escapeTrim($con, $_POST['enable_quick']);
    $fb_app_secret = escapeTrim($con, $_POST['fb_app_secret']);
    $myOauth = array();
    $myOauth['oauth'] = array_map_recursive(
        function($item) use ($con) { return escapeTrim($con,$item); },
        $_POST['oauth']
    );
    
    $oauth_keys = arrToDbStr($con, $myOauth);

    $query = "UPDATE user_settings SET enable_reg='$enable_reg', enable_oauth='$enable_oauth', enable_quick='$enable_quick', oauth_keys='$oauth_keys' WHERE id='1'";
    mysqli_query($con, $query);

    if (mysqli_errno($con))
        $msg = errorMsgAdmin(mysqli_error($con));

    else
        $msg = successMsgAdmin('User settings saved successfully');   
}

//Load User Settings
$result = mysqli_query($con,"SELECT * FROM user_settings WHERE id='1'");   
$row = mysqli_fetch_array($result);

$enable_reg =  filter_var(Trim($row['enable_reg']), FILTER_VALIDATE_BOOLEAN);
$enable_oauth =  filter_var(Trim($row['enable_oauth']), FILTER_VALIDATE_BOOLEAN);
$quick_login =  filter_var(Trim($row['enable_quick']), FILTER_VALIDATE_BOOLEAN);
$oauth_keys = dbStrToArr($row['oauth_keys']);

//if($oauth_keys['oauth']['fb_redirect_uri'] == '')
    $oauth_keys['oauth']['fb_redirect_uri'] = $baseURL. '?route=facebook';
    
//if($oauth_keys['oauth']['g_redirect_uri'] == '')
    $oauth_keys['oauth']['g_redirect_uri'] = $baseURL. '?route=google';
    
//if($oauth_keys['oauth']['twitter_redirect_uri'] == '')
    $oauth_keys['oauth']['twitter_redirect_uri'] = $baseURL. 'twitter';
