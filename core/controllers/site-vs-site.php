<?php
defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: KOVATZ Seo Tools
 * @copyright � 2022 KOVATZ.COM
 *
 */
 
$pageTitle = trans('Competitive Analysis',$lang['143'],true);
$des = $keyword = $firstHost = '';
    
//Image Verification
extract(loadCapthca($con));
$competitive_page = isSelected($competitive_page);
if($competitive_page){
    $cap_type = strtolower($cap_type);
    $customCapPath = PLG_DIR.'captcha'.DIRECTORY_SEPARATOR.$cap_type.'_cap.php';
    define('CAP_VERIFY',1);
    define('CAP_GEN',1);
    
    //Generate Image Verification
    require LIB_DIR.'generate-verification.php';
}
    
//Check User Request
if(isset($pointOut) && $pointOut != ''){
    if(strpos($pointOut, '.') === false) 
        die(trans('Input site is not valid!',$lang['8'],true));
        
    //Get User Request
    $first_url = raino_trim($pointOut);
    $first_url = 'http://'.clean_url($first_url);
    
    //Parse Host
    $my_url_parse = parse_url($first_url);
    $firstHost = str_replace('www.','',$my_url_parse['host']);
}

?>