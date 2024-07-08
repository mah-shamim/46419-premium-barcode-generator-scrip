<?php
defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: KOVATZ Seo Tools
 * @copyright © 2022 KOVATZ.COM
 *
 */
 
$remUserName = $remPassword = $remBox = '';

if(isset($_SESSION['twebAdminToken'])){
    header('Location: '. $adminBaseURL);
    echo '<meta http-equiv="refresh" content="1;url='.$adminBaseURL.'">';
    exit();
}

if(isset($_COOKIE['tweb_admin_remember']) && $_COOKIE['tweb_admin_remember'] == 'on') {
    $remUserName = raino_trim($_COOKIE['tweb_admin_email']);
    $remPassword = raino_trim($_COOKIE['tweb_admin_password']);
    $remBox = ' checked="" ';
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    if(isset($_POST['email']) && isset($_POST['password'])){
        $emailBox = escapeTrim($con,$_POST['email']);
        $passwordBox = passwordHash(escapeTrim($con,$_POST['password']));
        
        if(isset($_POST['remember'])){
            setcookie('tweb_admin_email', $_POST['email'], time() + (86400 * 300));
            setcookie('tweb_admin_password', $_POST['password'], time() + (86400 * 300)); 
            setcookie('tweb_admin_remember', 'on', time() + (86400 * 300));         
        }else{
             setcookie('tweb_admin_remember', 'off', time() + (86400 * 300));    
        }
        
        $row = mysqliPreparedQuery($con, "SELECT * FROM admin WHERE user=?",'s',array($emailBox));
        if($row !== false) {
            $adminPssword = Trim($row['pass']);
            $adminID =   Trim($row['id']);
            if ($adminPssword == $passwordBox) {
                $msg = successMsgAdmin('Login Successful. Redirect to dashboard page wait...'); 
                $_SESSION['twebAdminToken'] = true;
                $_SESSION['twebAdminID'] = $adminID;
                echo '<meta http-equiv="refresh" content="1;url='.$adminBaseURL.'">';
                $remUserName = $remPassword = $remBox = '';
            } else {
                $msg = errorMsgAdmin('Password is Wrong. Try Again!');
            }
       } else {
         $msg = errorMsgAdmin('Login Failed. Try Again! ');
       }
   }else{
        $msg = errorMsgAdmin('Login Failed. Try Again! ');
   }
}
?>