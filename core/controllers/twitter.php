<?php
defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: Rainbow PHP Framework
 * @copyright 2022 KOVATZ.COM
 *
 */

$pageTitle = $lang['200'];
$oauth_keys['oauth']['twitter_redirect_uri'] = $baseURL . 'twitter';

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

// Oauth Twitter
define('TWITTER_KEY', $oauth_keys['oauth']['twitter_key']);   // Enter your twitter application id
define('TWITTER_SECRET', $oauth_keys['oauth']['twitter_secret']);    // Enter your twitter application secret code

//Twitter Oauth Library
require_once (LIB_DIR . 'twitter/TwitterOAuth.php');

if($pointOut == 'login'){
    // create TwitterOAuth object
    $twitteroauth = new TwitterOAuth(TWITTER_KEY, TWITTER_SECRET);
     
    // request token of application
    $request_token = $twitteroauth->oauth(
        'oauth/request_token', [
            'oauth_callback' => $oauth_keys['oauth']['twitter_redirect_uri']
        ]
    );
     
    // throw exception if something gone wrong
    if($twitteroauth->getLastHttpCode() != 200) {
        throw new \Exception($lang['202']);
    }
     
    // save token of application to session
    $_SESSION['oauth_token'] = $request_token['oauth_token'];
    $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
     
    // generate the URL to make request to authorize our application
    $url = $twitteroauth->url(
        'oauth/authorize', [
            'oauth_token' => $request_token['oauth_token']
        ]
    );

    // and redirect
    header('Location: '. $url);
    die();
}

$oauth_verifier = filter_input(INPUT_GET, 'oauth_verifier');
if (empty($oauth_verifier) || empty($_SESSION['oauth_token']) || empty($_SESSION['oauth_token_secret'])){
    //Error
    die($lang['201']);
}else{
    $connection = new TwitterOAuth(TWITTER_KEY, TWITTER_SECRET,$_SESSION['oauth_token'],$_SESSION['oauth_token_secret']);
    //request user token
    $token = $connection->oauth(
        'oauth/access_token', [
            'oauth_verifier' => $oauth_verifier
        ]
    );
    $connection = new TwitterOAuth(TWITTER_KEY, TWITTER_SECRET,$token['oauth_token'],$token['oauth_token_secret']);
    $params = array('include_email' => 'true', 'include_entities' => 'false', 'skip_status' => 'true');
    $content = $connection->get('account/verify_credentials',$params);
    $client_name = $content->name;
    $client_id = $content->id;
    $client_email = $content->email;
    $client_plat = 'Twitter';
    
    $row = mysqliPreparedQuery($con, "SELECT * FROM users WHERE oauth_uid=?",'s',array($client_id));
    if($row !== false){
        $user_username = $row['username'];
        $db_verified = $row['verified'];
       
        if ($db_verified == "2"){
            die($lang['79']);
        } else{
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
        $last_id = getLastID($con, 'users');
        if ($last_id== '' || $last_id==null){
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
}
die();
?>