<?php
defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: KOVATZ Seo Tools
 * @copyright 2022 KOVATZ.COM
 *
 */

$pageTitle = 'Send Email';
$subTitle = 'Send Email to Customers';
$fullLayout = 1; $footerAdd = true; $footerAddArr = array();
$from = $replyTo = $message = $to = $sub = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $to = raino_trim($_POST['to']);
    $sub = raino_trim($_POST['sub']);
    $message = raino_trim($_POST['mailcontent']);
        
    //Load Site Info
    $siteInfo =  mysqli_query($con, "SELECT * FROM site_info where id='1'");
    $siteInfoRow = mysqli_fetch_array($siteInfo);
    $site_name = shortCodeFilter($siteInfoRow['site_name']);
    $adminEmail = trim($siteInfoRow['email']);
    $from = $replyTo = $adminEmail;
    
    if ($to != null && $sub != null && $message != null && $adminEmail != null){

        $htmlMessage = '<html><body><p>'.nl2br(html_entity_decode($message)).'</p></body></html>';

        //Load Mail Settings
        extract(loadMailSettings($con));
        
        if($protocol == '1'){
            //PHP Mail
            if(default_mail($from, $site_name, $replyTo, $site_name, $to, $sub, $htmlMessage)){
                $msg = successMsgAdmin('Your message has been sent successfully');
                $success = $lang['60'];
                $message = $to = $sub = '';
            }else{
                $msg = errorMsgAdmin('Failed to send your message');
            }
        }else{
            //SMTP Mail
            if(smtp_mail($smtp_host, $smtp_port, isSelected($smtp_auth), $smtp_username, $smtp_password, $smtp_socket,
                    $from, $site_name, $replyTo, $site_name, $to, $sub, $htmlMessage)){
                //Your message has been sent successfully   
                $msg = successMsgAdmin('Your message has been sent successfully');
                $message = $to = $sub = '';
            }else{
                $msg = errorMsgAdmin('Failed to send your message');
            }
        }
    }else{
        $msg = errorMsgAdmin('Failed to send your message');
    }
}