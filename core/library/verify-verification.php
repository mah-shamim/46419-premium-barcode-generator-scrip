<?php
defined('CAP_VERIFY') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: KOVATZ Seo Tools
 * @copyright � 2022 KOVATZ.COM
 *
 */
 
if($cap_type == 'phpcap'){
    $userVerifycode = strtolower(raino_trim($_POST['scode']));
    $capVerifyCode = strtolower($_SESSION['twebCaptcha']['code']);
    
    if(!empty($userVerifycode)){
        if ($userVerifycode != $capVerifyCode)
            $error = $lang['6']; //Your image verification code is wrong!
    }else{
        //Please verify your image verification.
        $error = $lang['62'];
    }
        
}elseif($cap_type == 'recap'){
    $userVerifycode = raino_trim($_POST['g-recaptcha-response']);
        if(!empty($userVerifycode)){
        $capResult = get_recaptcha_response($userVerifycode,$recap_seckey,$ip);
            if($capResult['success']){
                //reCaptcha Verified.
            }else{
                //Your image verification code is wrong!
                $error = $lang['6'];
            }
        }else{
            //Please verify your image verification.
            $error = $lang['62'];
        }
}elseif(file_exists($customCapPath)){
    define('CAP_VERIFY_PLG',1);
    require($customCapPath);
}else{
    stop('Unknown Image Verification System!');
}  