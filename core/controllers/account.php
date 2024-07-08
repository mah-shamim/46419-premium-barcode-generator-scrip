<?php

defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: Rainbow PHP Framework
 * @copyright � 2022 KOVATZ.COM
 *
 */

//Page Title
$pageTitle = $lang['69'];
$des = $keyword = '';

if(!$enable_reg){
    header("Location: ". createLink('',true));
    exit();  
}

//Load Mail Settings
extract(loadMailSettings($con));

//Load Image Verifcation
extract(loadCapthca($con));

//Date
$sDate = date('m/d/Y'); 

$register_page = filBoolean($register_page);
$login_page = filBoolean($login_page);
$reset_pass_page = filBoolean($reset_pass_page);
$resend_act_page = filBoolean($resend_act_page);

if($register_page || $login_page || $reset_pass_page || $resend_act_page){
    $quick_login_check = true;
    if($quick_login && isset($_POST['quick'])) {
        $quick_login_check = quickLoginCheck($con,$ip);
        if($quick_login_check)
            $login_page = $register_page = false;
    }
    $cap_type = strtolower($cap_type);
    $customCapPath = PLG_DIR.'captcha'.DIRECTORY_SEPARATOR.$cap_type.'_cap.php';
    define('CAP_VERIFY',1);
    define('CAP_GEN',1);
}

//Check already login
if(isset($_SESSION['twebUserToken'])) {
    header('Location: '. createLink('',true));
    echo '<meta http-equiv="refresh" content="1;url='.createLink('',true).'">';
    $success = trans('You are already logged in',$lang['70']);
}

//Resend activation
if ($pointOut == 'resend') { 
    
    $pageTitle = $lang['115'];
    
    if (isset($_POST['email'])) {
        
        //Verify image verification.
        if ($resend_act_page)
            require LIB_DIR.'verify-verification.php';  
       
        if(!isset($error)){
            $email = escapeTrim($con,$_POST['email']);
            
            $row = mysqliPreparedQuery($con, "SELECT * FROM users WHERE email_id=?",'s',array($email));
            
            if($row !== false){
            //Username found
            $username = $row['username'];
            $db_email_id = Trim($row['email_id']);
            $db_full_name  = $row['full_name'];
            $db_platform  = $row['platform'];
            $db_password  = Trim($row['password']);
            $db_verified  = $row['verified'];
            $db_picture = $row['picture'];
            $db_date = $row['added_date'];
            $db_ip = $row['ip'];
            $db_id = $row['id'];
            
            if ($db_verified == '0') {
              $arrData  = getMailTemplates($con,'account_activation');
              
            $arrData['subject'] = base64_decode($arrData['subject']);
            $arrData['body'] = base64_decode($arrData['body']);
             
            $verify_url = $baseURL . "verify/$username/".Md5(HASH_CODE . $db_email_id . HASH_CODE);
            
            $replacementCode = array(
            '{SiteName}' => $site_name,
            '{FullName}' => ucfirst($db_full_name),
            '{UserName}' => $username,
            '{VerificationUrl}' => $verify_url,
            '{UserEmailId}' => $db_email_id,
            '{CustomerIp}' => $db_ip
            );
        
            $subject = html_entity_decode(shortCodeFilter(stripslashes(str_replace(array_keys($replacementCode),array_values($replacementCode),$arrData['subject']))));
            $body = html_entity_decode(html_entity_decode(shortCodeFilter(stripslashes(str_replace(array_keys($replacementCode),array_values($replacementCode),$arrData['body'])))));
          
            if ($protocol == '1'){
              if(default_mail ($adminEmail,$site_name,$adminEmail,$site_name,$db_email_id,$subject,$body))
                    $success = $lang['71']; //Activation link successfully sent to your mail id
              else
                    $error = $lang['61']; //Failed to send your message
            }else{
              if(smtp_mail($smtp_host,$smtp_port,isSelected($smtp_auth),$smtp_username,$smtp_password,$smtp_socket,$adminEmail,$site_name,$adminEmail,$site_name,$db_email_id,$subject,$body))
                $success = $lang['71']; //Activation link successfully sent to your mail id
              else
                    $error = $lang['61']; //Failed to send your message
            }
              
            }else{
                $error = $lang['72']; //Email ID already verified!    
            }
            } else{
                $error =  $lang['73']; //Email ID not found!
            }
        }
    }
}

//Forget Password
if ($pointOut == 'forget') {
    
    $pageTitle = $lang['114'];
    
    if (isset($_POST['email'])) {
    
        //Verify image verification.
        if ($reset_pass_page)
            require LIB_DIR.'verify-verification.php'; 
            
        if(!isset($error)){    
            $email = escapeTrim($con,$_POST['email']);
            $row = mysqliPreparedQuery($con, "SELECT * FROM users WHERE email_id=?",'s',array($email));
            
            if($row !== false){
            //Username found
            $username = $row['username'];
            $db_email_id = $row['email_id'];
            $db_full_name  = $row['full_name'];
            $db_platform  = $row['platform'];
            $db_password  = Trim($row['password']);
            $db_verified  = $row['verified'];
            $db_picture = $row['picture'];
            $db_date = $row['added_date'];
            $db_ip = $row['ip'];
            $db_id = $row['id'];
    
            $new_pass = md5(uniqid(rand(), true));  
            $new_pass_md5 = passwordHash($new_pass);
            
            if(updateToDbPrepared($con, 'users', array('password' => $new_pass_md5), array('username' => $username))) {
                $error = $lang['74']; //Database Error! Contact Support!
            } else {
                $success = $lang['75']; //New password sent to your mail
                
                $arrData = getMailTemplates($con,'password_reset'); 
                
                $arrData['subject'] = base64_decode($arrData['subject']);
                $arrData['body'] = base64_decode($arrData['body']);
            
                $replacementCode = array(
                '{SiteName}' => $site_name,
                '{FullName}' => ucfirst($db_full_name),
                '{UserName}' => $username,
                '{NewPassword}' => $new_pass,
                '{UserEmailId}' => $db_email_id,
                '{CustomerIp}' => $db_ip
                );
            
                $subject = html_entity_decode(shortCodeFilter(stripslashes(str_replace(array_keys($replacementCode),array_values($replacementCode),$arrData['subject']))));
                $body = html_entity_decode(html_entity_decode(shortCodeFilter(stripslashes(str_replace(array_keys($replacementCode),array_values($replacementCode),$arrData['body'])))));
              
                if ($protocol == '1')
                  default_mail ($adminEmail,$site_name,$adminEmail,$site_name,$db_email_id,$subject,$body);
                else
                  smtp_mail($smtp_host,$smtp_port,isSelected($smtp_auth),$smtp_username,$smtp_password,$smtp_socket,$adminEmail,$site_name,$adminEmail,$site_name,$db_email_id,$subject,$body);
            }
            
            } else {
                $error = $lang['73']; //Email ID not found!
            }
        }
    }
}

//Register Page
if($pointOut == 'register'){
    $pageTitle = $lang['113'];
}

//Login Page
if($pointOut == 'login'){
    $pageTitle = $lang['112'];
    
    if(isset($args[0])){
        if($args[0] == 'verification-success')
            $success = $lang['207'];
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    //Already login
    if(isset($_SESSION['twebUserToken'])){
        
        header('Location: ' . createLink('',true));
        echo '<meta http-equiv="refresh" content="1;url='.createLink('',true).'">';
        $success = $lang['77']; //You are already logged in
    
    }else{

    //Login Process
    if (isset($_POST['signin'])) {
        
        $username = escapeTrim($con,$_POST['username']);
        $password = passwordHash(raino_trim($_POST['password']));
        
        if ($username != null && $password!= null) {
            
        //Verify image verification.
        if ($login_page)
            require LIB_DIR.'verify-verification.php';  
       
        if(!isset($error)){
            $row = mysqliPreparedQuery($con, "SELECT * FROM users WHERE username=?",'s',array($username));
            
            if($row !== false){
            //Username found
            $db_oauth_uid = $row['oauth_uid'];
            $db_email_id = $row['email_id'];
            $db_full_name  = $row['full_name'];
            $db_platform  = $row['platform'];
            $db_password  = Trim($row['password']);
            $db_verified  = $row['verified'];
            $db_picture = $row['picture'];
            $db_date = $row['added_date'];
            $db_ip = $row['ip'];
            $db_id = $row['id'];
    
            if ($password == $db_password) {
                if ($db_verified == "1"){
                    // Login Success
                    $_SESSION['twebUserToken'] = passwordHash($db_id . $username);
                    $_SESSION['twebToken'] = Md5($db_id.$username);
                    $_SESSION['twebOauth_uid'] = $db_oauth_uid;
                    $_SESSION['twebUsername'] = $username;
                    $success = $lang['78']; //Login Successful..
                }elseif ($db_verified == "2") {
                    //Account Banned
                    $error = $lang['79']; //Oh, no your account was banned! Contact Support..
                } else {
                    //Account not verified
                    $error = $lang['80']; //Oh, no account not verified
                } 
                             
            } else{
                //Password wrong
                $error =  $lang['81']; //Oh, no password is wrong
            }
            } else {
                //Username not found
                $error =  $lang['83']; //Username not found
            }
        }
        } else {
            $error = $lang['82']; //All fields must be filled out!
        }
    }
    
    //Register process
    if (isset($_POST['signup'])) {
        
        $username = escapeTrim($con,$_POST['username']);
        $password = passwordHash(raino_trim($_POST['password']));
        $email = escapeTrim($con,$_POST['email']);
        $full_name = escapeTrim($con,$_POST['full']);

        if ($username != null && $password!= null && $full_name!=null && $email!= null) {
        
        //Verify image verification.
        if ($register_page)
            require LIB_DIR.'verify-verification.php';  
       
        if(!isset($error)){   
            if(isValidEmail($email)){  
                if (isValidUsername($username)) {
                
                $result = mysqliPreparedQuery($con, "SELECT * FROM users WHERE username=?",'s',array($username));
                if($result !== false){
                    $error = $lang['84']; //Username already taken
                } else {   
                    
                $result = mysqliPreparedQuery($con, "SELECT * FROM users WHERE email_id=?",'s',array($email));
                if($result !== false){
                    $error =  $lang['85']; //Email ID already registered
                } else {
                                   
                $result = mysqliPreparedQuery($con, "SELECT * FROM users WHERE date=? AND ip=?",'ss',array($sDate,$ip));
                if($result !== false){
                    $error =  $lang['86']; //It looks like your IP has already been used to register an account today!
                } else{
                
                $nowDate = date('m/d/Y h:i:sA'); 
                

                $res = insertToDbPrepared($con, 'users', array(
                        'oauth_uid' => '0', 
                        'username' => $username, 
                        'email_id' => $email, 
                        'full_name' => $full_name, 
                        'platform' => 'Direct', 
                        'password' => $password, 
                        'verified' => '0', 
                        'picture' => 'NONE', 
                        'date' => $sDate, 
                        'added_date' => $nowDate, 
                        'ip' => $ip
                    ));
                
                if ($res)
                    $error = $lang['74'];
                else {
                $arrData = getMailTemplates($con,'account_activation');
                
                $arrData['subject'] = base64_decode($arrData['subject']);
                $arrData['body'] = base64_decode($arrData['body']);
                
                $verify_url = $baseURL . "verify/$username/".Md5(HASH_CODE . $email . HASH_CODE);
                
                $replacementCode = array(
                '{SiteName}' => $site_name,
                '{FullName}' => ucfirst($full_name),
                '{UserName}' => $username,
                '{VerificationUrl}' => $verify_url,
                '{UserEmailId}' => $email,
                '{CustomerIp}' => $ip
                );
            
                $subject = html_entity_decode(shortCodeFilter(stripslashes(str_replace(array_keys($replacementCode),array_values($replacementCode),$arrData['subject']))));
                $body = html_entity_decode(html_entity_decode(shortCodeFilter(stripslashes(str_replace(array_keys($replacementCode),array_values($replacementCode),$arrData['body'])))));

                $success = $lang['90']; //Your account was successfully registered. An activation link successfully sent to your mail id!

                if ($protocol == '1')
                  default_mail ($adminEmail,$site_name,$adminEmail,$site_name,$email,$subject,$body);
                else
                  smtp_mail($smtp_host,$smtp_port,isSelected($smtp_auth),$smtp_username,$smtp_password,$smtp_socket,$adminEmail,$site_name,$adminEmail,$site_name,$email,$subject,$body);
                  
                }
                }
                }
                }
            }else{
            $error =  $lang['88']; //"Username not valid! Username can't contain special characters..";
            }
        } else {
        $error =  $lang['89']; //"Email ID not valid!";
        }
    }
    
    }else {
        $error = $lang['82']; //"All fields must be filled out!";
    }
    }
    }
}

if($pointOut == 'login' || $pointOut == 'register'){
    if($quick_login && isset($_POST['quick'])) {
        if(isset($error)){
            if($quick_login_check){
                quickLoginDisable($con,$ip);
                $register_page = $login_page = true;
            }
        }
        if($pointOut == 'register'){
            quickLoginDisable($con,$ip);
            $register_page = $login_page = true;
        }
    }
}

//Generate Image Verification
if($register_page || $login_page || $reset_pass_page || $resend_act_page)
    require LIB_DIR.'generate-verification.php';
?>