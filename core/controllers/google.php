<?php
defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: Rainbow PHP Framework
 * @copyright © 2022 KOVATZ.COM
 *
 */
 
$pageTitle = $lang['199'];  //'Google Oauth';

if(isset($_SESSION['twebUsername'])){
  redirectTo(createLink('',true));
  die();
}

if(!$enable_reg){
    header("Location: ". createLink('',true));
    exit();  
}

if(!$enable_oauth){
    header("Location: ". createLink('',true));
    exit();  
}

if($oauth_keys['oauth']['g_redirect_uri'] == '')
    $oauth_keys['oauth']['g_redirect_uri'] = $baseURL. '?route=google';
    
// Oauth Google 
define('G_Client_ID', $oauth_keys['oauth']['g_client_id']);  // Enter your google api application id
define('G_Client_Secret', $oauth_keys['oauth']['g_client_secret']); // Enter your google api application secret code
define('G_Redirect_Uri', $oauth_keys['oauth']['g_redirect_uri']);
define('G_Application_Name', 'Rainbow_PHP_By_Asif');

//Google Oauth Library
require_once (LIB_DIR . 'Google/Client.php');

$client = new Google_Client();
$client->setScopes(array(
    "https://www.googleapis.com/auth/userinfo.profile",
    "https://www.googleapis.com/auth/userinfo.email"
));

if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  $redirect = $baseURL . $_SERVER['PHP_SELF'];
  header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
  $access_token = json_decode($_SESSION['access_token'], 1);
  $access_token = $access_token['access_token'];
  $resp = file_get_contents('https://www.googleapis.com/oauth2/v1/userinfo?access_token='.$access_token);
  $user = json_decode($resp, 1);  
  $client_email = filter_var($user['email'], FILTER_SANITIZE_EMAIL);
  $client_name = filter_var($user['name'], FILTER_SANITIZE_STRING);
  $client_id = filter_var($user['id']);
  $client_plat = "Google";
  $client_pic = $user['picture'];
  $content = $user;
  $token = $client->getAccessToken();
} else {
  $authUrl = $client->createAuthUrl();
}
if ($client->getAccessToken() && isset($_GET['url'])) {

  $_SESSION['access_token'] = $client->getAccessToken();
}


if (isset($client_email)) {
$row = mysqliPreparedQuery($con, "SELECT * FROM users WHERE oauth_uid=?",'s',array($client_id));
if($row !== false){
  $user_username  = $row['username'];
  $db_verified  = $row['verified'];
  
  if ($db_verified == "2"){
      die($lang['79']);
  } else {    
      $_SESSION['twebUsername'] = $user_username;
      $_SESSION['twebToken'] = $token;
      $_SESSION['twebOauth_uid'] = $client_id;
      $_SESSION['twebUserToken'] = passwordHash($db_id . $username);
      $old_user =1;
      header("Location: ". createLink('',true));
      exit();
  }

} else {
  $new_user= 1;
  $last_id = getLastID($con, 'users');
  if ($last_id== '' || $last_id==null){
      $username = "User1";
  } else {
      $last_id = $last_id+1;  
      $username = "User$last_id";
  }
  $_SESSION['twebUsername'] = $username;
  $_SESSION['twebToken'] = $token;
  $_SESSION['twebOauth_uid'] = $client_id;
  $_SESSION['twebUserToken'] = passwordHash($db_id . $username);
  $nowDate = date('m/d/Y h:i:sA'); 
  $sDate = date('m/d/Y'); 
  $res = insertToDbPrepared($con, 'users', array(
        'oauth_uid' => $client_id, 
        'username' => $username, 
        'email_id' => $client_email, 
        'full_name' => $client_name, 
        'platform' => $client_plat, 
        'password' => $password, 
        'verified' => '1', 
        'picture' => 'NONE', 
        'date' => $sDate, 
        'added_date' => $nowDate, 
        'ip' => $ip
    ));
  header("Location: ".createLink('',true));
  exit();
}

} else {
    if($pointOut == 'login') {
        header('Location: '.$authUrl);
        exit();
    }
}
die();
?>