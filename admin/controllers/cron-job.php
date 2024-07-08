<?php

defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: Rainbow PHP Framework
 * @copyright � 2022 KOVATZ.COM
 *
 */

$fullLayout = 1;
$pageTitle = 'Cron Job Viewer';
$subTitle = 'Cron Job';


//Clear Cron Log File
if($pointOut == 'clear'){
    putMyData(LOG_DIR.'cron.tdata','');
    $msg = successMsgAdmin('Cron Log cleared successfully!');    
}

$errData = getMyData(LOG_DIR.'cron.tdata');
if($errData == '')
    $errData = 'Cron log is empty!';
    
$cronPath = APP_DIR.'cron.php';
?>