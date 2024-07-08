<?php
defined('CAP_GEN') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: KOVATZ Seo Tools
 * @copyright � 2022 KOVATZ.COM
 *
 */
 
if($cap_type == 'phpcap'){
    $_SESSION['twebCaptcha'] = elite_captcha($color,$mode,$mul,$allowed);
   
    $captchaCode = '<div id="phpCapCode" class="captchaCode"><label>'.trans('Image Verification',$lang['5'],true).' *</label> <br />
    <img id="capImg" src="'.$_SESSION['twebCaptcha']['image_src'].'" alt="'.trans('Captcha',$lang['41'],true).'" class="imagever" />
    
    <div class="input-group phpCap">
      <input type="text" class="form-control" id="scode" name="scode" />
      <span onclick="reloadCap()" class="input-group-addon reloadCap"><i class="fa fa-refresh"></i></span>
    </div></div>
    <input type="hidden" value="'.$cap_type.'" id="capType" />';
    
}elseif($cap_type == 'recap'){
   
    $captchaCode = '<div id="reCapCode" class="captchaCode">
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <label>'.trans('Image Verification',$lang['5'],true).' *</label> <br />
    <div class="g-recaptcha" data-sitekey="'.$recap_sitekey.'"></div>
    </div>
    <input type="hidden" value="'.$cap_type.'" id="capType" />';
    
}elseif(file_exists($customCapPath)){
    define('CAP_GEN_PLG',1);
    require($customCapPath);
}else{
    stop('Unknown Image Verification System!');
}