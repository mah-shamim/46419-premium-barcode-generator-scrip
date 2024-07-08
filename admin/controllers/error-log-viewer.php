<?php

defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: Rainbow PHP Framework
 * @copyright © 2022 KOVATZ.COM
 *
 */

$fullLayout = 1;
$pageTitle = 'Error Log File Viewer';
$subTitle = 'Error Log';


//Clear Error Log File
if($pointOut == 'clear'){
    putMyData(LOG_DIR.ERR_R_FILE,'');
    $msg = successMsgAdmin('Error Log cleared successfully!');    
}

$errData = getMyData(LOG_DIR.ERR_R_FILE);
if($errData == '')
    $errData = 'Error log is empty!';
?>