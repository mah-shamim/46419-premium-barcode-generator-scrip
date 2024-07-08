<?php

defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));
define('TEMP_DIR',APP_DIR.'temp'.D_S);
    
/*
 * @author MD ARIFUL HAQUE
 * @name: KOVATZ Seo Tools
 * @copyright 2022 KOVATZ.COM
 *
 */

//Check User Request
if($argWithPointOut[0] == '' || $argWithPointOut[2] == '')
    header('Location: '.$baseURL);
elseif(strpos($argWithPointOut[0], '.') === false) 
    die(trans('Input site is not valid!',$lang['8'],true));
elseif(strpos($argWithPointOut[2], '.') === false) 
    die(trans('Input site is not valid!',$lang['8'],true));


//Default Value
$firstDomainFound = $secDomainFound = false;
$isOnline = '0';
$shareLink = $pageTitle = $des = $keyword = '';
$nowDate = date('m/d/Y h:i:sA');
$disDate = date('F, j Y h:i:s A');

//True (or) False Image
$true = '<img src="'.themeLink('img/true.png',true).'" alt="'.trans('True',$lang['10'],true).'" />';
$false = '<img src="'.themeLink('img/false.png',true).'" alt="'.trans('False',$lang['9'],true).'" />';

//Get User Request
$first_url = raino_trim($argWithPointOut[0]);
$first_url = 'http://'.clean_url($first_url);
$second_url = raino_trim($argWithPointOut[2]);
$second_url = 'http://'.clean_url($second_url);

//Parse Host
$my_url_parse = parse_url($first_url);
$firstHost = str_replace('www.','',$my_url_parse['host']);
$firstHostLow = strtolower($firstHost);
$firstDomainName = ucfirst($firstHostLow);
$my_url_parse = parse_url($second_url);
$secHost = str_replace('www.','',$my_url_parse['host']);
$secHostLow = strtolower($secHost);
$secDomainName = ucfirst($secHostLow);
$pageTitle = str_replace(array('[domain1]','[domain2]'),array(ucfirst($firstHost),ucfirst($secHost)),$lang['150']);

//Check Empty Host
if($firstHost == '' || $secHost == '')
    die(trans('Input Site is not valid!',$lang['8'],true));

//Get Domain Restriction
$list = getDomainRestriction($con);

//Check Banned Domains 
if(in_array($firstHostLow,$list[4])){
    redirectTo(createLink('warning/restricted-domains/'.$firstHostLow,true));
    die();
}
if(in_array($secHostLow,$list[4])){
    redirectTo(createLink('warning/restricted-domains/'.$secHostLow,true));
    die();
}

//Check Bad Words
$badWordBan = false;
foreach ($list[0] as $badWord){
    if(check_str_contains($firstHostLow, trim($badWord), true))
        $badWordBan = true;
    if(check_str_contains($secHostLow, trim($badWord), true))
        $badWordBan = true;
    if($badWordBan){
        redirectTo(createLink('warning/restricted-words',true));
        die();  
    }
}

//Share Link
$shareLink = createLink('compare/'.$firstHostLow.'/vs/'.$secHostLow,true);

//Load Reviewer Settings
$reviewerSettings = reviewerSettings($con);

//Login Access Check
if(!isset($_SESSION['twebUsername'])){
    $username = trans('Guest',$lang['11'],true);
    $reviewerSettings['reviewer_list'] = unserialize($reviewerSettings['reviewer_list']);
    $freeLimit = (int)$reviewerSettings['free_limit'];
}else{
    $username = $_SESSION['twebUsername'];
}

//Check Domain Name Exists
$firstHost = escapeTrim($con,$firstHost);
$dataFirst = mysqliPreparedQuery($con, "SELECT * FROM domains_data WHERE domain=?",'s',array($firstHost));
if($dataFirst !== false){
    if($dataFirst['completed'] == 'yes')
        $firstDomainFound = true;
}
$secHost = escapeTrim($con,$secHost);
$dataSec = mysqliPreparedQuery($con, "SELECT * FROM domains_data WHERE domain=?",'s',array($secHost));
if($dataSec !== false){
    if($dataSec['completed'] == 'yes')
        $secDomainFound = true;
}

if($firstDomainFound && $secDomainFound){
    //Extract DB Data
    define('DB_DOMAIN',true);
    require(CON_DIR.'compare-domain.php');
        
    //Add to Recent Site List
    addToComRecentSites($con,$firstHost,$secHost,$ip,$username);
    
    $reviewerSettings['compare_data'] = dbStrToArr($reviewerSettings['compare_data']);
    $metaTitle = shortCodeFilter($reviewerSettings['compare_data']['compare']['title']);
    $des = shortCodeFilter($reviewerSettings['compare_data']['compare']['des']);
}else{
    die(trans('Competitor  domain not cached!',$lang['151'],true));
}
?>