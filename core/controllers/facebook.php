<?php
defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: Rainbow PHP Framework
 * @copyright © 2022 KOVATZ.COM
 *
 */

$pageTitle = $lang['198']; //'Facebook Oauth';

if(isset($_SESSION['twebUsername'])){
  redirectTo($baseURL);
  die();
}

if(!$enable_reg){
    header("Location: ". $baseURL);
    exit();  
}

if(!$enable_oauth){
    header("Location: ". $baseURL);
    exit();  
}

// Oauth Facebook
define('FB_APP_ID', $oauth_keys['oauth']['fb_app_id']);   // Enter your facebook application id
define('FB_APP_SECRET', $oauth_keys['oauth']['fb_app_secret']);    // Enter your facebook application secret code
define('FB_REDIRECT_URI', $oauth_keys['oauth']['fb_redirect_uri']);    // Enter your facebook application redirect url

//Facebook Oauth Library
require_once (LIB_DIR . 'facebook/autoload.php');

$fb = new Facebook\Facebook(array(
  'app_id' => FB_APP_ID,
  'app_secret' => FB_APP_SECRET
));

if($pointOut == 'login'){
    
    // Get the FacebookRedirectLoginHelper
    $helper = $fb->getRedirectLoginHelper();
    
    $permissions = array('email'); // optional
    $loginUrl = $helper->getLoginUrl(FB_REDIRECT_URI, $permissions);
    header('Location: '. $loginUrl);
    exit();
    
}else{
    
    // Get the FacebookRedirectLoginHelper
    $helper = $fb->getRedirectLoginHelper();
    
    try {
        $accessToken = $helper->getAccessToken(FB_REDIRECT_URI);
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
        // When Graph returns an error
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
        // When validation fails or other local issues
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }
    
    
    if (isset($accessToken)) {
        // Logged in
        
        try {
            // Returns a `Facebook\FacebookResponse` object
            $response = $fb->get('/me?fields=id,name,email,first_name,last_name', $accessToken);
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        
        // Returns a `Facebook\GraphNodes\GraphUser` collection
        $user = $response->getGraphUser();
        
        if (!empty($user)){
            $client_name = $user['name'];
            $client_id = $user['id'];
            $client_email = $user['email'];
            $client_plat = 'Facebook';
            
            $row = mysqliPreparedQuery($con, "SELECT * FROM users WHERE oauth_uid=?",'s',array($client_id));
            
            if($row !== false){
                $user_username = $row['username'];
                $db_verified = $row['verified'];
                
                if ($db_verified == "2"){
                    die($lang['79']);
                } else {
                    $_SESSION['twebUsername'] = $user_username;
                    $_SESSION['twebToken'] = Md5($db_id . $username);
                    $_SESSION['twebOauth_uid'] = $client_id;
                    $_SESSION['twebUserToken'] = passwordHash($db_id . $username);
                    $old_user = 1;
                    header("Location: ". createLink('',true));
                    exit();
                }
            } else {
                $new_user = 1;
                #user not present.
                $last_id = getLastID($con, 'users');
                if ($last_id == '' || $last_id == null){
                    $username = "User1";
                } else {
                    $last_id = $last_id + 1;
                    $username = "User$last_id";
                }
                $_SESSION['twebUsername'] = $username;
                $_SESSION['twebOauth_uid'] = $client_id;
                $_SESSION['twebToken'] = Md5($db_id . $username);
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
        } else{
            die($lang['201']);
        }
    } elseif ($helper->getError()) {
        // There was an error (user probably rejected the request)
        echo '<p>Error: ' . $helper->getError();
        echo '<p>Code: ' . $helper->getErrorCode();
        echo '<p>Reason: ' . $helper->getErrorReason();
        echo '<p>Description: ' . $helper->getErrorDescription();
        exit;
    }
}
die();
?>