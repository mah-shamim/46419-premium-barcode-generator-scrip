<?php

defined('APP_NAME') or die(header('HTTP/1.1 403 Forbidden'));
define('TEMP_DIR',APP_DIR.'temp'.D_S);
    
/*
 * @author MD ARIFUL HAQUE
 * @name: Rainbow PHP Framework
 * @copyright 2022 KOVATZ.COM
 *
 */

//POST REQUEST Handler
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['url'])){
        $myUrl = parse_url('http://'.clean_url(raino_trim($_POST['url'])));
        $myUrlHost = strtolower(str_replace('www.','',$myUrl['host']));
        redirectTo(createLink($controller.'/'.$myUrlHost,true));
        die();
    }else{
        die(trans('Input Site is not valid!',$lang['8'],true));
    }
}

//Check User Request
if ($pointOut == '')
    header('Location: '.$baseURL);
elseif(strpos($pointOut, '.') === false) 
    die(trans('Input Site is not valid!',$lang['8'],true));


//Default Value
$domainFound = $updateFound = $customSnapAPI = $newDomain = false;
$pdfUrl = $updateUrl = $shareLink = $pageTitle = $des = $keyword = $customSnapLink = '';
$isOnline = '0';
$nowDate = date('m/d/Y h:i:sA');
$disDate = date('F, j Y h:i:s A');

//True (or) False Image
$true = '<img src="'.themeLink('img/true.png',true).'" alt="'.trans('True',$lang['10'],true).'" />';
$false = '<img src="'.themeLink('img/false.png',true).'" alt="'.trans('False',$lang['9'],true).'" />';

if(isset($route[2])){
   $updateCheck = strtolower(raino_trim($route[2]));
   if($updateCheck == 'update')
       $updateFound = true;
}

//Get User Request
$my_url = raino_trim($pointOut);
$my_url = 'http://'.clean_url($my_url);

//Parse Host
$my_url_parse = parse_url($my_url);
$inputHost = $my_url_parse['scheme'] . "://" . $my_url_parse['host'];
$my_url_host = str_replace('www.','',$my_url_parse['host']);
$domainStr = escapeTrim($con, strtolower($my_url_host));
$pageTitle = $domainName = ucfirst($my_url_host);

//Check Empty Host
if($my_url_host == '')
    die(trans('Input Site is not valid!',$lang['8'],true));

//Get Domain Restriction
$list = getDomainRestriction($con);

//Check Banned Domains 
if(in_array($domainStr,$list[4])){
    redirectTo(createLink('warning/restricted-domains/'.$domainStr,true));
    die();
}

//Check Bad Words
foreach ($list[0] as $badWord){
    if(check_str_contains($domainStr, trim($badWord), true)) {
        redirectTo(createLink('warning/restricted-words',true));
        die();
    }
}

//Share Link
$shareLink = createLink($controller.'/'.$domainStr,true);

//Load Reviewer Settings
$reviewerSettings = reviewerSettings($con);

$updateUrl = createLink($controller.'/'.$domainStr.'/'.'update',true);
$pdfUrl = createLink('genpdf/'.$domainStr,true);

//Login Access Check
if($enable_reg){
    if(!isset($_SESSION['twebUsername'])){
        if($updateFound){
          if(!isset($_SESSION['twebAdminToken'])){
              redirectTo(createLink('account/login',true));
              die();
          }
        }
        $username = trans('Guest',$lang['11'],true);
        $reviewerSettings['reviewer_list'] = unserialize($reviewerSettings['reviewer_list']);
        $freeLimit = (int)$reviewerSettings['free_limit'];
        $pdfUrl = $updateUrl = createLink('account/login',true);
    }else{
        $username = $_SESSION['twebUsername'];
    }
}

//Screenshot API
$reviewerSettings['snap_service'] = dbStrToArr($reviewerSettings['snap_service']);
if($reviewerSettings['snap_service']['options'] == 'FasterSeoTools_pro'){
    $customSnapAPI = true;
    $customSnapLink = $reviewerSettings['snap_service']['FasterSeoTools_pro'];
    $_SESSION['snap'] = $reviewerSettings['snap_service']['FasterSeoTools_pro'];
}elseif($reviewerSettings['snap_service']['options'] == 'custom'){
    $customSnapAPI = true;
    $customSnapLink = $reviewerSettings['snap_service']['custom'];
    $_SESSION['snap'] = $reviewerSettings['snap_service']['custom'];
}else{
    if(isset($_SESSION['snap']))
        unset($_SESSION['snap']);
}

//Check Domain Name Exists
$data = mysqliPreparedQuery($con, "SELECT * FROM domains_data WHERE domain=?",'s',array($domainStr));
if($data !== false){
    if($data['completed'] == 'yes'){
        $domainFound = true;
    }else{
        $updateFound = true;
        $domainFound = false;
    }
}else{
    $updateFound = true;
    $domainFound = false;
    $newDomain = true;
}

//Hash Code
$hashCode = md5($my_url_host);
$filename = TEMP_DIR.$hashCode.'.tdata';

//Get Data of the URL
if($updateFound){
    
    $capOkay = true;
    extract(loadCapthca($con));
    if(isSelected($reviewer_page)){
        if(!isset($_SESSION['twebReviewerFine'])){
            $capOkay = false;
            $_SESSION['twebReviewerDomain'] = $domainStr;
            redirectTo(createLink('check/verfication',true));
            die();
        }else{
            unset($_SESSION['twebReviewerFine']);
            unset($_SESSION['twebReviewerDomain']);
            $capOkay = true;
        }
    }
    
    if($capOkay){
        $sourceData = curlGET($my_url);
        
        if($sourceData == ''){
            //Second try
            $sourceData = getMyData($my_url);
            
            if($sourceData == '')
                $error  = trans('Input Site is not valid!',$lang['8'],true);
        }
        
        if(!isset($error)){
            $isOnline = '1';
            putMyData($filename,$sourceData);
            
            //Bad Word Filter - Patch - START
            $title = $description = $keywords = '';
            $badWordBan = false;
            $doc = new DOMDocument();
            @$doc->loadHTML(mb_convert_encoding($sourceData, 'HTML-ENTITIES', 'UTF-8'));
            $nodes = $doc->getElementsByTagName('title');
            $title = strtolower($nodes->item(0)->nodeValue);
            $metas = $doc->getElementsByTagName('meta');
        
            for ($i = 0; $i < $metas->length; $i++){
            $meta = $metas->item($i);
            if($meta->getAttribute('name') == 'description')
               $description = strtolower($meta->getAttribute('content'));
            if($meta->getAttribute('name') == 'keywords')
                $keywords = strtolower($meta->getAttribute('content'));
            }
    
            foreach ($list[1] as $badWord){
                if(check_str_contains($title, trim($badWord), true))
                    $badWordBan = true;
            }
            if(!$badWordBan){
                foreach ($list[2] as $badWord){
                    if(check_str_contains($description, trim($badWord), true))
                        $badWordBan = true;
                }
            }
            if(!$badWordBan){
                foreach ($list[3] as $badWord){
                    if(check_str_contains($keywords, trim($badWord), true))
                        $badWordBan = true;
                }
            }
            if($badWordBan){
                redirectTo(createLink('warning/restricted-words',true));
                die();  
            }
            //Bad Word Filter - Patch - END

            //Create the Domain
            if($newDomain) {

                if(!isset($_SESSION['TWEB_HOMEPAGE'])){
                    $_SESSION['TWEB_HOMEPAGE'] = 1;
                    redirectTo(createLink('',true));
                    die();
                }

                if (insertToDbPrepared($con, 'domains_data', array('domain' => $domainStr, 'date' => $nowDate)))
                    $error = trans('Database Error - Contact Support!', $lang['12'], true);
            }
        }
    }
    
}

if(!isset($error)){
    if($updateFound){
        //New or Update the data
        
        if(!isset($_SESSION['twebAdminToken'])){
            //Free Users
            if(!isset($_SESSION['twebUsername'])){
                if(isset($_SESSION['TWEB_FREE_LIMIT'])){
                    $limitUsed = (int)$_SESSION['TWEB_FREE_LIMIT'];
                    if($limitUsed == $freeLimit){
                        redirectTo($updateUrl);
                        die();
                    }else{
                        $limitUsed++;
                        $_SESSION['TWEB_FREE_LIMIT'] = $limitUsed;
                    }
                }else{
                    $_SESSION['TWEB_FREE_LIMIT'] = 1;
                }
            }
        }
        
    }else{
        //Extract DB Data
        define('DB_DOMAIN',true);
        require(CON_DIR.'db-domain.php');
        $reviewerSettings['domain_data'] = dbStrToArr($reviewerSettings['domain_data']);
        $metaTitle = shortCodeFilter($reviewerSettings['domain_data']['domain']['title']);
        $des = shortCodeFilter($reviewerSettings['domain_data']['domain']['des']);
    }
}else{
    $_SESSION['TWEB_CALLBACK_ERR'] = $error;
    redirectTo(createLink('',true));
    die();
}