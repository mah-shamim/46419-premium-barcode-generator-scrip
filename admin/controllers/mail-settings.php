<?php

defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: Rainbow PHP Framework
 * @copyright © 2022 KOVATZ.COM
 *
 */

$pageTitle = 'Mail Settings';
$subTitle = 'General Settings';
$fullLayout = 1; $footerAdd = true; $footerAddArr = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $smtp_host =   escapeTrim($con,$_POST['smtp_host']);
    $smtp_port =  escapeTrim($con,$_POST['smtp_port']);
    $smtp_username =  escapeTrim($con,$_POST['smtp_user']);
    $smtp_password =  escapeTrim($con,$_POST['smtp_pass']);
    $socket =  escapeTrim($con,$_POST['socket']);
    $auth =  escapeTrim($con,$_POST['auth']);
    $protocol =  escapeTrim($con,$_POST['protocol']);
    
    $query = "UPDATE mail SET smtp_host='$smtp_host', smtp_port='$smtp_port', smtp_username='$smtp_username', smtp_password='$smtp_password', smtp_socket='$socket', protocol='$protocol', smtp_auth='$auth' WHERE id='1'"; 
    mysqli_query($con,$query); 
      
    if (mysqli_errno($con))
        $msg = errorMsgAdmin(mysqli_error($con));
    else
        $msg = successMsgAdmin('Mail information saved successfully');
}

$mailInfo =  mysqli_query($con, "SELECT * FROM mail WHERE id='1'");
$row = mysqli_fetch_array($mailInfo);

$smtp_host = Trim($row['smtp_host']);
$smtp_username = Trim($row['smtp_username']);
$smtp_password = Trim($row['smtp_password']);
$smtp_port = Trim($row['smtp_port']);
$protocol = Trim($row['protocol']);
$auth = Trim($row['smtp_auth']);
$socket = Trim($row['smtp_socket']);

?>