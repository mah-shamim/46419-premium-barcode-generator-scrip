<?php
defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: KOVATZ Seo Tools
 * @copyright � 2022 KOVATZ.COM
 *
 */

//Page Title
$pageTitle = trans('Contact Us',$lang['3'],true);
$des = $keyword = $name = $from = $to = $replyTo = $sub = $message = '';

//Load Image Verifcation
extract(loadCapthca($con));

$cap_contact = filter_var($contact_page, FILTER_VALIDATE_BOOLEAN);

if($cap_contact){
    $cap_type = strtolower($cap_type);
    $customCapPath = PLG_DIR.'captcha'.DIRECTORY_SEPARATOR.$cap_type.'_cap.php';
    define('CAP_VERIFY',1);
    define('CAP_GEN',1);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $name = raino_trim($_POST['name']);
    $from = $replyTo = raino_trim($_POST['email']);
    $sub = raino_trim($_POST['sub']);
    $message = raino_trim($_POST['message']);
    $nowDate = date('m/d/Y h:i:sA'); 
    
    if(isset($_SESSION['twebUsername']))
        $username = $_SESSION['twebUsername'];
    else
        $username = $lang['59'];
    
    //Verify image verification.
    if ($cap_contact)
        require LIB_DIR.'verify-verification.php';  
    
    if(!isset($error)){
        //No Error - Continue
        if ($name != null && $replyTo != null && $sub != null && $message != null && $adminEmail != null){
            
            $htmlMessage = '<html><body><p><b>'.$lang['63'].':</b> <br> '.nl2br($message).'</p><p><b>'.$lang['64'].':</b> <br>'.$lang['65'].': '.$username.' <br>'.$lang['66'].':'.$ip.' <br>'.$lang['67'].': '.$nowDate.'</p></body></html>';
        
            //Load Mail Settings
            extract(loadMailSettings($con));
            
            if($protocol == '1'){
                //PHP Mail
                if(default_mail($adminEmail, $name, $replyTo, $name, $adminEmail, $sub, $htmlMessage)){
                    //Your message has been sent successfully
                    $success = $lang['60'];
                    $message = $body = $from = $name = $sub = '';
                }else{
                    //Failed to send your message
                    $error = $lang['61'];
                }
            }else{
                //SMTP Mail
                if(smtp_mail($smtp_host, $smtp_port, isSelected($smtp_auth), $smtp_username, $smtp_password, $smtp_socket,
                        $adminEmail, $name, $replyTo, $name, $adminEmail, $sub, $htmlMessage)){
                    //Your message has been sent successfully   
                    $success = $lang['60'];
                    $message = $body = $from = $name = $sub = '';
                }else{
                    //Failed to send your message
                    $error = $lang['61'];
                }
            }
        }else{
            $error = $lang['58'];
        }
    }
}

//Generate Image Verification
if ($cap_contact)
    require LIB_DIR.'generate-verification.php';
?>