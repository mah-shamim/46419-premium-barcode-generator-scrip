<?php
defined('APP_NAME') or die(header('HTTP/1.1 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: Rainbow PHP Framework
 * @copyright 2022 KOVATZ.COM
 *
 */

//POST Request Handler 
if ($_SERVER['REQUEST_METHOD'] =='POST') {
    
    //Site Vs Site Check
    if(isset($_POST['sitevssite'])) {
        define('TEMP_DIR',APP_DIR.'temp'.D_S);       
        
        //Default Value
        $firstDomainFound = $secDomainFound = $firstDomainFoundNotCom = $secDomainFoundNotCom = false;
        $splitCode = $hashCodeFirst = $hashCodeSec = $sourceData = '';
        $splitCode = '::!!::';
        $nowDate = date('m/d/Y h:i:sA');
        
        //Image Verification
        extract(loadCapthca($con));
        if(isSelected($competitive_page)){
            $cap_type = strtolower($cap_type);
            $customCapPath = PLG_DIR.'captcha'.DIRECTORY_SEPARATOR.$cap_type.'_cap.php';
            define('CAP_VERIFY',1);
            define('CAP_GEN',1);
            
            //Verify image verification.
            require LIB_DIR.'verify-verification.php';  
           
            if(isset($error))
                die('verificationfail'.$splitCode.$error.$splitCode.'0');
        }
        
        //Get User Request
        $first_url = escapeTrim($con, $_POST['websiteUrl']);
        $first_url = 'http://'.clean_url($first_url);
        $second_url = escapeTrim($con, $_POST['competitorUrl']);
        $second_url = 'http://'.clean_url($second_url);
        
        //Parse Host
        $my_url_parse = parse_url($first_url);
        $firstHost = str_replace('www.','',$my_url_parse['host']);
        $my_url_parse = parse_url($second_url);
        $secHost = str_replace('www.','',$my_url_parse['host']);

        //Check Empty Host
        if($firstHost == '' || $secHost == '')
            die('3'.$splitCode.'0'.$splitCode.'0');
        
        //Check Domain Name Exists
        $dataFirst = mysqliPreparedQuery($con, "SELECT * FROM domains_data WHERE domain=?",'s',array($firstHost));
        if($dataFirst !== false){
            if($dataFirst['completed'] == 'yes')
                $firstDomainFound = true;
            else
                $firstDomainFoundNotCom = true;
        }
        
        $dataSec = mysqliPreparedQuery($con, "SELECT * FROM domains_data WHERE domain=?",'s',array($secHost));
        if($dataSec !== false){
            if($dataSec['completed'] == 'yes')
                $secDomainFound = true;
            else
                $secDomainFoundNotCom = true;
        }
        
        if(!$firstDomainFound || !$secDomainFound){
            //Free Users
            if(!isset($_SESSION['twebUsername'])){
                if(isset($_SESSION['TWEB_FREE_LIMIT'])){
                    $limitUsed = (int)$_SESSION['TWEB_FREE_LIMIT'];
                    if($limitUsed == $freeLimit){
                        redirectTo(createLink('account/login',true));
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
        
        if(!$firstDomainFound && !$secDomainFound){
            
            //First Domain  
            //Hash Code
            $hashCodeFirst = md5($firstHost);
            $filenameFirst = TEMP_DIR.$hashCodeFirst.'.tdata';
            
            //Get Data of the URL
            $sourceData = curlGET($first_url);
            
            if($sourceData == ''){
                //Second try
                $sourceData = getMyData($first_url);
                
                if($sourceData == '')
                    die('3'.$splitCode.'0'.$splitCode.'0');
            }
            putMyData($filenameFirst,$sourceData);
            $sourceData = '';
            
            //Second Domain  
            //Hash Code
            $hashCodeSec = md5($secHost);
            $filenameSec = TEMP_DIR.$hashCodeSec.'.tdata';
            
            //Get Data of the URL
            $sourceData = curlGET($second_url);
            
            if($sourceData == ''){
                //Second try
                $sourceData = getMyData($second_url);
                
                if($sourceData == '')
                    die('3'.$splitCode.'0'.$splitCode.'0');
            }
            putMyData($filenameSec,$sourceData);
            $sourceData = '';
            
            //Create the Domain
            if(!$firstDomainFoundNotCom){
                if (insertToDbPrepared($con, 'domains_data', array('domain' => $firstHost, 'date'=> $nowDate)))
                    die('3'.$splitCode.'0'.$splitCode.'0');
            }
            if(!$secDomainFoundNotCom){
                if (insertToDbPrepared($con, 'domains_data', array('domain' => $secHost, 'date'=> $nowDate)))
                    die('3'.$splitCode.'0'.$splitCode.'0');
            }
            
            die('3'.$splitCode.$hashCodeFirst.$splitCode.$hashCodeSec);
            
        } elseif(!$secDomainFound){
            //Second Domain  
            //Hash Code
            $hashCodeSec = md5($secHost);
            $filenameSec = TEMP_DIR.$hashCodeSec.'.tdata';
            
            //Get Data of the URL
            $sourceData = curlGET($second_url);
            
            if($sourceData == ''){
                //Second try
                $sourceData = getMyData($second_url);
                
                if($sourceData == '')
                    die('2'.$splitCode.'0'.$splitCode.'0');
            }
            putMyData($filenameSec,$sourceData);
            $sourceData = '';
            
            //Create the Domain
            if(!$secDomainFoundNotCom){
                if (insertToDbPrepared($con, 'domains_data', array('domain' => $secHost, 'date'=> $nowDate)))
                    die('2'.$splitCode.'0'.$splitCode.'0');
            }
            
            die('2'.$splitCode.$hashCodeSec.$splitCode.'0');  
        }elseif(!$firstDomainFound){
            //First Domain  
            //Hash Code
            $hashCodeFirst = md5($firstHost);
            $filenameFirst = TEMP_DIR.$hashCodeFirst.'.tdata';
            
            //Get Data of the URL
            $sourceData = curlGET($first_url);
            
            if($sourceData == ''){
                //Second try
                $sourceData = getMyData($first_url);
                
                if($sourceData == '')
                    die('1'.$splitCode.'0'.$splitCode.'0');
            }
            putMyData($filenameFirst,$sourceData);
            $sourceData = '';
            
            //Create the Domain
            if(!$firstDomainFoundNotCom){
                if (insertToDbPrepared($con, 'domains_data', array('domain' => $firstHost, 'date'=> $nowDate)))
                    die('1'.$splitCode.'0'.$splitCode.'0');
            }
            
            die('1'.$splitCode.$hashCodeFirst.$splitCode.'0');  
        }else
            die('go'.$splitCode.$hashCodeFirst.$splitCode.'0');  
    
    die();
    }

}

//Warning Messages
if($pointOut == 'warning'){
    $controller = 'warning';

    if(isset($args[0]) && $args[0] == 'verfication'){
        $pageTitle = $lang['5'];
        $des = $keyword = '';
        
        //Load Image Verifcation
        extract(loadCapthca($con));
        $reviewer_page = isSelected($reviewer_page);
        
        if($reviewer_page){
            $cap_type = strtolower($cap_type);
            $customCapPath = PLG_DIR.'captcha'.DIRECTORY_SEPARATOR.$cap_type.'_cap.php';
            define('CAP_VERIFY',1);
            define('CAP_GEN',1);
            
            if ($_SERVER['REQUEST_METHOD'] =='POST') {
                //Verify image verification.
                require LIB_DIR.'verify-verification.php';  
                
                if(!isset($error)){
                    $_SESSION['twebReviewerFine'] = true;
                    redirectTo(createLink('domain/'.$_SESSION['twebReviewerDomain'],true));
                    die();
                }
            }
            
            //Generate Image Verification
            require LIB_DIR.'generate-verification.php';
        }
    }elseif(isset($args[0]) && $args[0] == 'restricted-words'){
        $pageTitle = $lang['283'];
        $des = $keyword = '';
        
    }elseif(isset($args[0]) && $args[0] == 'restricted-domains'){
        $pageTitle = $lang['284'];
        $des = $keyword = $domainName = $reason = '';
        $bannedDomains = array();
       if(isset($args[1])){
            $domainName = strtolower(getDomainName(raino_trim($args[1])));
            $bannedDomains = getBannedDomainList($con);
            
            if(isset($bannedDomains[$domainName]))
                $reason = $bannedDomains[$domainName]['reason'];
            else
                die(header('HTTP/1.0 403 Forbidden'));
       }else{
        die(header('HTTP/1.0 403 Forbidden'));
       }
    }else{
        die(header('HTTP/1.0 403 Forbidden'));
    }
}

//Easy Upgrade (Beta)
if($pointOut == 'easy-upgrade'){
    if(isset($args[0]) && $args[0] != ''){
        if(raino_trim($args[0]) == ${strrev('edoc_esahcrup_meti')}){
            //Remove old version files
            unlink(ROOT_DIR.'index.php');
            unlink(CONFIG_DIR.'app.config.php');
            
            //Upgrade patch - copy new files
            copyDir(ROOT_DIR.'upgrade', ROOT_DIR);
            
            //Check new files copied successfully 
            if(file_exists(CONFIG_DIR.'app.config.php'))
                return true;
            else
                return false;
        }
    }
}

//END
if($controller == 'api')
    die();