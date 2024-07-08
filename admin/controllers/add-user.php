<?php
defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: Rainbow PHP Framework
 * @copyright � 2022 KOVATZ.COM
 *
 */

$pageTitle = 'Add User';
$subTitle = 'New User';
$fullLayout = 1; $footerAdd = true; $footerAddArr = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $myValues = array_map_recursive(
        function($item) use ($con) { return escapeTrim($con,$item); },
        $_POST
    );
    $newUser = array_filter($myValues['users']);
    $newUser['password'] = passwordHash($newUser['password']);
    $newUser['ip'] = getUserIP();
    $newUser['platform'] = 'Direct';
    $newUser['oauth_uid'] = '0';
    $newUser['verified'] = '1';
    $newUser['added_date'] = date('m/d/Y h:i:sA');

    $result = mysqli_query($con,"SELECT * FROM users WHERE email_id='".$newUser['email_id']."'");
    
    if(mysqli_num_rows($result) > 0) {
        $msg = errorMsgAdmin('Email ID already exists');
    } else {  
        $result = mysqli_query($con,"SELECT * FROM users WHERE username='".$newUser['username']."'");
        
        if(mysqli_num_rows($result) > 0) {
            $msg = errorMsgAdmin('Username already taken');
        } else {
            $res = insertToDb($con,'users',$newUser);
            if($res){
                $msg = errorMsgAdmin($res);
            }else{
                header('Location:'.adminLink('manage-users/new-user-success',true));
                die();
            }
        }
    }
    extract($myValues['users']);
}
?>