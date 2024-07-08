<?php

defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
* @author MD ARIFUL HAQUE
* @name: Rainbow PHP Framework
* @copyright © 2022 KOVATZ.COM
*
*/
$fullLayout = 1;
$pageTitle = 'Email Templates';
$subTitle = 'Templates';
$footerAdd = true; $mailTemplates = true; $footerAddArr = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (isset($_POST['activation']))
    {
        $activationMail = base64_encode(raino_trim($_POST['activation']));
        $activationSub = base64_encode(raino_trim($_POST['activationSub']));
        
        $query = "UPDATE mail_templates SET subject='$activationSub', body='$activationMail' WHERE code='account_activation'"; 
        
        if (!mysqli_query($con, $query))
            $msg = errorMsgAdmin('Something Went Wrong!');
        else 
            $msg = successMsgAdmin('Mail updated successfully');
    }
    
    if (isset($_POST['password']))
    {
        $passwordMail = base64_encode(raino_trim($_POST['password']));
        $passwordSub = base64_encode(raino_trim($_POST['passwordSub']));
        
        $query = "UPDATE mail_templates SET subject='$passwordSub', body='$passwordMail' WHERE code='password_reset'"; 
        
        if (!mysqli_query($con, $query))
            $msg = errorMsgAdmin('Something Went Wrong!');
        else 
            $msg = successMsgAdmin('Mail updated successfully');
    }
}

$query =  'SELECT * FROM mail_templates';
$result = mysqli_query($con,$query);
        
while($row = mysqli_fetch_array($result)) {
    $code =  Trim($row['code']);
    
    if($code == 'account_activation'){
      $activationSub = html_entity_decode(base64_decode($row['subject']));
      $activationMail = html_entity_decode(base64_decode($row['body']));
    }
    
    if($code == 'password_reset'){
      $passwordSub = html_entity_decode(base64_decode($row['subject']));
      $passwordMail = html_entity_decode(base64_decode($row['body']));
    }
}


?>