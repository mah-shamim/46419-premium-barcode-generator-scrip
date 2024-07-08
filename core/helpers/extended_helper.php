<?php

/*
* @author MD ARIFUL HAQUE
* @name Rainbow PHP Framework
* @copyright 2021 KOVATZ.COM
*
*/

function helper(){
    return 'I am Helper!';
}

function detectInstaller(){
    $filename = ROOT_DIR.'admin'.D_S.'install'.D_S.'install.php';
    if (file_exists($filename)) {
        echo "Install.php file exists! <br /> <br />  Redirecting to installer panel...";
        header("Location: admin/install/install.php");
        echo '<meta http-equiv="refresh" content="1;url=admin/install/install.php">';
        exit();
    }
    return false; 
}

function getTheme($con){
    $result = mysqli_query($con, "SELECT theme FROM interface where id=1");
    $row = mysqli_fetch_assoc($result);
    return trim($row['theme']);
}

function getThemeOptions($con,$themeName,$baseURL){
    $themeOptions = array();
    $result = mysqli_query($con, "SELECT * FROM themes_data where id=1");
    $row = mysqli_fetch_array($result);
    if(isset($row[$themeName.'_theme'])){
        $themeOptions = dbStrToArr($row[$themeName.'_theme']);
        if(isSelected($themeOptions['general']['imgLogo']))
            $themeOptions['general']['themeLogo'] = '<img class="themeLogoImg" src="'.$baseURL.$themeOptions['general']['logo'].'" />';
        else
           $themeOptions['general']['themeLogo'] = '<span class="themeLogoText">'.htmlspecialchars_decode(shortCodeFilter($themeOptions['general']['htmlLogo'])).'</span>';
         $themeOptions['general']['favicon'] = $baseURL.$themeOptions['general']['favicon'];
    }
    return $themeOptions;
}

function getThemeOptionsDev($con,$themeName){
    $themeOptions = array();
    $result = mysqli_query($con, "SELECT * FROM themes_data where id=1");
    $row = mysqli_fetch_array($result);
    if(isset($row[$themeName.'_theme']))
        $themeOptions = dbStrToArr($row[$themeName.'_theme']);
    return $themeOptions;
}

function getMaintenanceMode($con){

    $siteInfo =  mysqli_query($con, "SELECT * FROM site_info where id=1");
    $siteInfoRow = mysqli_fetch_array($siteInfo);
    $other = dbStrToArr($siteInfoRow['other_settings']);
    
    return array($other['other']['maintenance'],$other['other']['maintenance_mes']);
}

function getMenuBarLinks($con,$userPageUrl=''){
    
    $result = mysqli_query($con, "SELECT * FROM pages");
    $rel = $target = $classActive = $relActive = $targetActive = '';
    $headerLinks = $footerLinks = array();

    while($row = mysqli_fetch_array($result)) {
        $header_show = filter_var($row['header_show'], FILTER_VALIDATE_BOOLEAN);
        $footer_show = filter_var($row['footer_show'], FILTER_VALIDATE_BOOLEAN);
        $linkShow = filter_var($row['status'], FILTER_VALIDATE_BOOLEAN);
        $langCheck = $row['lang'] == '' ? 'all' :  $row['lang'];

        if($linkShow){
            if($header_show || $footer_show){
                if($langCheck == 'all' || $langCheck == ACTIVE_LANG){
                    $classActive = $relActive = $targetActive = '';
                    $sort_order = $row['sort_order'];
                    $page_name = shortCodeFilter($row['page_name']);
                    /*if($row['page_name'] == '{{lang[1]}}'){
                        if(isset($_SESSION['twebUsername'])){
                            $page_name = shortCodeFilter('{{lang[217]}}');
                            $row['page_url'] = createLink('dashboard',true);
                        }
                    }*/
                    if($row['type'] != 'page'){
                        $page_content = decSerBase($row['page_content']);
                        $rel = $page_content[0]; $target = $page_content[1];
                    }
                    
                    if($row['type'] == 'page')
                        $page_url = createLink('page/'.$row['page_url'],true);
                    elseif($row['type'] == 'internal')
                        $page_url = shortCodeFilter($row['page_url']);
                    elseif($row['type'] == 'external'){
                        $page_url = $row['page_url'];
                        if($rel != 'none' && $rel != '')
                            $relActive = ' rel="'.$rel.'"';
                        if($target != 'none' && $target != '')
                            $targetActive = ' target="'.$target.'"';
                    }
        
                    if(rtrim($page_url,'/') == rtrim($userPageUrl,'/'))
                        $classActive = ' class="active"';
                    
                    //Fix - Not needed     
                    $classActive = '';
                    if($header_show)
                        $headerLinks[] = array($sort_order,'<li'.$classActive.'><a'.$relActive.$targetActive.' href="'.$page_url.'">'.$page_name.'</a></li>');
                    sort($headerLinks);
                    
                    if($footer_show)
                        $footerLinks[] = array($sort_order,'<li'.$classActive.'><a'.$relActive.$targetActive.' href="'.$page_url.'">'.$page_name.'</a></li>');
                    sort($footerLinks);
                }
            }
        }
    }
    return array($headerLinks,$footerLinks);
}

function getSidebarWidgets($con){
    $leftWidgets = $rightWidgets = $footerWidgets = array();
    $result = mysqli_query($con,"SELECT * FROM widget ORDER BY CAST(sort_order AS UNSIGNED) ASC");
    while ($row = mysqli_fetch_array($result))
    {
        $widgetType = strtolower(Trim($row['widget_type']));
        $showWidget = filter_var($row['widget_enable'], FILTER_VALIDATE_BOOLEAN);
        if($showWidget) {
            
            $widgetCode = htmlspecialchars_decode($row['widget_code']);
            $widgetName = htmlspecialchars_decode($row['widget_name']);
            
            if(check_str_contains($widgetCode,"shortCode")){
                $shortCode = explode("shortCode(",$widgetCode);
                $shortCode = explode(")",$shortCode[1]);
                $shortCode = Trim($shortCode[0]);
                if(defined($shortCode))
                    $widgetCode = str_replace("shortCode(".$shortCode.")",constant($shortCode),$widgetCode);
                else
                    $widgetCode = "SHORT CODE NOT FOUND!"; 
            }
            
            if($widgetType=="left")
                $leftWidgets[] = array($widgetName,$widgetCode);  
            elseif($widgetType=="right")
                $rightWidgets[] = array($widgetName,$widgetCode);  
            else
                $footerWidgets[] = array($widgetName,$widgetCode);  
        }
    }
    return array($leftWidgets,$rightWidgets,$footerWidgets);
}

function trans($str,$customStr=null,$returnStr=false){
    $noNullCheck = false;  //Enable for testing!
    if($noNullCheck)
        $nullData = 'NoNullCheck-Ba-la-ji';
    else
        $nullData = null;
    if(LANG_TRANS){
        if($customStr != $nullData){
            if($returnStr)
                return $customStr;
            else
                echo $customStr;
        }
        else{
            if($returnStr)
                return $str;
            else
                echo $str;
        }
    }else{
            if($returnStr)
                return $str;
            else
                echo $str; 
    }
    return true;
}

function getInterfaceSettings($con){
    $result = mysqli_query($con, "SELECT lang,theme FROM interface where id=1");
    $row = mysqli_fetch_assoc($result);
    return array('lang' => trim($row['lang']), 'theme'=> trim($row['theme']));
}

function getLang($con){
    $result = mysqli_query($con, "SELECT lang FROM interface where id=1");
    $row = mysqli_fetch_assoc($result);
    return trim($row['lang']);
}

function getThemeList(){
    $dir = ROOT_DIR.'theme';
    $themelist = array();
    $filesAsifArr = scandir($dir);
     foreach($filesAsifArr as $file){
        $themeDir = $dir.D_S.$file;
        if($file != '.' && $file != '..'){
            if (is_dir($themeDir)){
               $themeDetailsFile = $themeDir.D_S.'themeDetails.xml';
               if(file_exists($themeDetailsFile)){
                    $themeDetailsXML = simplexml_load_file($themeDetailsFile, "SimpleXMLElement", LIBXML_NOCDATA);
                    $themeDetails = json_decode(json_encode($themeDetailsXML),true);
                    if(isset($themeDetails['@attributes']['compatibility'])){
                        if($themeDetails['@attributes']['compatibility'] == '1.0'){
                            if(isset($themeDetails['themeDetails']))
                                $themelist[] = array($file,$themeDir,$themeDetails['themeDetails']);
                        }
                    }
               }
            }
        }
     }
    return $themelist;
}

function isThemeExists($themeDirName){
    $themeDir = ROOT_DIR.'theme'.D_S.$themeDirName;
    $themeDetailsFile = $themeDir.D_S.'themeDetails.xml';
    if(file_exists($themeDir) && is_dir($themeDir)){
       if(file_exists($themeDetailsFile)){
            $themeDetailsXML = simplexml_load_file($themeDetailsFile, "SimpleXMLElement", LIBXML_NOCDATA);
            $themeDetails = json_decode(json_encode($themeDetailsXML),true);
            if(isset($themeDetails['@attributes']['compatibility'])){
                if($themeDetails['@attributes']['compatibility'] == '1.0'){
                    if(isset($themeDetails['themeDetails']))
                        return true;
                }
            }
       }
    }
    return false;
}

function setTheme($con,$themeName){
    $themeName = escapeTrim($con,$themeName);
    $themeArr = getThemeList();
    if (in_multiarray($themeName,$themeArr)) {        
        if (updateToDbPrepared($con, 'interface', array('theme' => $themeName), array('id' => '1')))
            return false;
        else
            return true;
    }else{
        return false;
    }
}

function setLang($con,$lang){
    $lang = escapeTrim($con,$lang);
    $langArr = getAvailableLanguages($con);

    if (in_multiarray($lang,$langArr)) {            
        if (updateToDbPrepared($con, 'interface', array('lang' => $lang), array('id' => '1')))
            return false;
        else
            return true;
    }else{
        return false;
    }
}

function ipBanCheck($con,$ip,$site_name) {
    $query = mysqli_query($con, "SELECT * FROM banned_ip WHERE ip='$ip'");
    if (mysqli_num_rows($query) > 0){
        $row = mysqli_fetch_array($query);
        if($row['reason'] != '')
            die("You have been banned from ".$site_name." <br>"."Reason: ".$row['reason']); 
        else
            die("You have been banned from ".$site_name); 
    }
}

function errStop() {
    echo 'S'.'o'.'m'.'e'.'t'.'h'.'i'.'n'.'g'.' '.'W'.'e'.'n'.'t'.' '.'W'.'r'.'o'.'n'.'g'.'!';
    die();
}

function secureImageUpload($fileData,$maxFileSize=500000,$allowedTypes = array('jpg','png','jpeg','gif')){
    $itIsImage = false; $uploadMeAsif = true;
    $targetDir = $targetFileName = $msg = '';

    if(isset($fileData["name"]) && $fileData["name"] != ''){
     
        $targetDir = ROOT_DIR.'uploads'.D_S;
        $targetFileName = basename($fileData["name"]);
        $itIsImage = getimagesize($fileData["tmp_name"]);
        
        //Check it is a image
        if ($itIsImage !== false) {
           
            //Check if file already exists
            $targetFileName = unqFile($targetDir,$targetFileName);
            $targetFile = $targetDir . $targetFileName;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            
            //Check file size
            if ($fileData["size"] > $maxFileSize){
                $msg = 'Sorry, your file is too large.';
                $uploadMeAsif = false;
            } else {
                //Allow only certain file formats
                if(!in_array($imageFileType, $allowedTypes)){
                    $msg = 'Sorry, only '.implode(', ',$allowedTypes).' file types are allowed.';
                    $uploadMeAsif = false;
                }
            }
    
            //Start Upload
            if ($uploadMeAsif){
                if (move_uploaded_file($fileData["tmp_name"], $targetFile)){
                    //Uploaded
                    $msg = 'uploads/'.$targetFileName;
                } else{
                    $msg = 'Sorry, there was an error uploading your file.';
                    $uploadMeAsif = false;
                }
            }
        } else {
            $msg = 'File is not an image.';
            $uploadMeAsif = false;
        }
    }else{
        $msg = 'Unknown File';
        $uploadMeAsif = false;
    }
    
    return array($uploadMeAsif, $msg);
}

function calTextRatio($pageData) {
    $orglen = strlen($pageData);
    $pageData = preg_replace('/(<script.*?>.*?<\/script>|<style.*?>.*?<\/style>|<.*?>|\r|\n|\t)/ms', '', $pageData);  
    $pageData = preg_replace('/ +/ms', ' ', $pageData);  
    $textlen = strlen($pageData);
    $per = (($textlen * 100) / $orglen);
    return array($orglen,$textlen,$per);
}

function serBase($arr=array()){
    return base64_encode(serialize($arr));
}

function decSerBase($str){
    return unserialize(base64_decode($str));
}

function fixJSON($json) {
    $regex = <<<'REGEX'
~
    "[^"\\]*(?:\\.|[^"\\]*)*"
    (*SKIP)(*F)
  | '([^'\\]*(?:\\.|[^'\\]*)*)'
~x
REGEX;

    return preg_replace_callback($regex, function($matches) {
        return '"' . preg_replace('~\\\\.(*SKIP)(*F)|"~', '\\"', $matches[1]) . '"';
    }, $json);
}

function arrToDbStr($con,$dataBala_ji){
    return escapeMe($con, json_encode($dataBala_ji));
}

function dbStrToArr($dataBal_aji){
    $dataBal_aji = Trim($dataBal_aji);
    if($dataBal_aji == '')
        return array();
    else{
        //return json_decode(stripcslashes($dataBal_aji),true);
        $dataBal_aji = str_replace('\"','"',$dataBal_aji);
        $dataBal_aji = json_decode($dataBal_aji,true);
        $dataBal_aji = array_map_recursive('stripcslashes',$dataBal_aji);
        return $dataBal_aji;
    }
}

function filBoolean($val){
    return filter_var($val, FILTER_VALIDATE_BOOLEAN);
}

function dlSendHeaders($filename) {
    //Disable caching
    $now = gmdate("D, d M Y H:i:s");
    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
    header("Last-Modified: {$now} GMT");

    //Force download  
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");

    //Disposition / encoding on response body
    header("Content-Disposition: attachment;filename={$filename}");
    header("Content-Transfer-Encoding: binary");
}

function getPageSize($url){ 
   $return = strlen(getMyData($url));
   return $return; 
}

function size_as_kb($yoursize) {
    $size_kb = round($yoursize/1024);
    return $size_kb;
}

function calPrice($global_rank) {
    $monthly_inc =round((pow($global_rank, -1.008)* 104943144672)/524); 
    $monthly_inc = (is_infinite($monthly_inc)? '5' :$monthly_inc);
    $daily_inc  =round($monthly_inc/30);
    $daily_inc = (is_infinite($daily_inc)? '0':$daily_inc);
    $yearly_inc =round($monthly_inc*12);
    $yearly_inc = (is_infinite($yearly_inc)? '0':$yearly_inc);
    $yearly_inc = ($yearly_inc < 9 ? 10 : $yearly_inc);
    return $yearly_inc;
}

function calPageSpeed($myUrl,$refUrl) {
		
    $timeStart = microtime(true);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $myUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:36.0) Gecko/20100101 Firefox/36.0');
    curl_setopt($ch, CURLOPT_REFERER, $refUrl);
    $html = curl_exec($ch);
    curl_close($ch);
    $timeEnd = microtime(true);
    $timeTaken = $timeEnd - $timeStart;
		
    return $timeTaken;
}

function getHttp($headers) {
    $headers = explode("\r\n", $headers);
    $http_code = explode(' ', $headers[0]);
    return (int)trim($http_code[1]);
}

function loadCapthca($con){
    $query = mysqli_query($con, "SELECT * FROM capthca where id=1");
    $row = mysqli_fetch_array($query);
    $cap_options = dbStrToArr($row['cap_options']);
    $cap_data = dbStrToArr($row['cap_data']);
    $cap_type = Trim($row['cap_type']);
    return array_merge($cap_options,$cap_data[$cap_type],array('cap_type'=>$cap_type));
}

function loadAllCapthca($con){
    $query = mysqli_query($con, "SELECT * FROM capthca where id=1");
    return mysqli_fetch_array($query);
}

function loadMailSettings($con){
    $query = mysqli_query($con, "SELECT * FROM mail WHERE id=1");
    return mysqli_fetch_array($query);
}

function getMailTemplates($con,$code){
    $query = mysqli_query($con, "SELECT * FROM mail_templates WHERE code='$code'");
    return mysqli_fetch_array($query);
}

function in_multiarray($elem, $array) {
    $top = sizeof($array) - 1;
    $bottom = 0;
    while($bottom <= $top)
    {
        if($array[$bottom] == $elem)
            return true;
        else
            if(is_array($array[$bottom]))
                if(in_multiarray($elem, ($array[$bottom])))
                    return true;
               
        $bottom++;
    }       
    return false;
}

function createLink($link='',$return=false, $noLang=false){
    $langShortCode = '';
    if(!defined('BASEURL'))
        die('Base URL not set!');
    if(!$noLang){
        if(defined('LANG_SHORT_CODE'))
            $langShortCode = LANG_SHORT_CODE.'/';
    }
    if($return)
        return BASEURL.$langShortCode.$link;
    else
        echo BASEURL.$langShortCode.$link;
}

function getAdminMenuIcon($ba_laji, $array) {
   foreach ($array as $key => $val) {
   if(isset($val[4])){
       foreach ($val[4] as $arrKey => $arrVal) {
            if ($arrVal[1] === $ba_laji){
                echo $array[$key][3];
                return true;
            }
       }
   }else{
    if ($val[2] === $ba_laji){ 
        echo $array[$key][3];
        return true;
        }
   }
   }
   return null;
}

function adminLink($link='',$return=false){
    if(!defined('BASEURL'))
        die('Base URL not set!');
    if(!defined('ADMIN_PATH'))
        die('Admin Path not set!');
    if($return)
        return BASEURL.ADMIN_PATH.$link;
    else
        echo BASEURL.ADMIN_PATH.$link;
}

function themeLink($link='',$return=false){
    if(!defined('THEMEURL'))
        die('Theme URL not set!');
    if($return)
        return THEMEURL.$link;
    else
        echo THEMEURL.$link;
}

function scriptLink($link='',$type=false,$isExternal=false,$typeStr=null,$return=false){
    $finalStr = $finalTypeStr = '';
    if(!defined('THEMEURL'))
        die('Theme URL not set!');
    if($type){
        if($typeStr == null)
            $finalTypeStr = 'type="text/javascript"';
        else
            $finalTypeStr = 'type="'.$typeStr.'"';
    }
    if($isExternal)
        $finalStr = '<script src="'.$link.'" '.$finalTypeStr.'></script>';
    else
        $finalStr = '<script src="'.THEMEURL.$link.'" '.$finalTypeStr.'></script>';
    if($return)
        return $finalStr;
    else
        echo $finalStr;
}

function genCanonicalData($baseURL, $currentLink, $loadedLanguages=array(), $return = false, $langSwitch=true){
    $data = $activeLang = $activeLangSlash = '';
    if(defined('ACTIVE_LANG')){
        $activeLangSlash = ACTIVE_LANG.'/';
        $activeLang = ACTIVE_LANG;
    }

    $activeLink = str_replace(array($baseURL.$activeLangSlash, $baseURL.$activeLang, $baseURL), '', $currentLink);

    $data .= '<link rel="canonical" href="'.$currentLink.'" />'.PHP_EOL;
    $data .= '        <link rel="alternate" hreflang="x-default" href="'.$baseURL.$activeLink.'" />'.PHP_EOL;

    if($langSwitch) {
        foreach ($loadedLanguages as $language) {
            if (!isset($language[7]))
                $language[7] = $language[2];
            elseif ($language[7] === NULL)
                $language[7] = $language[2];
            if($language[2] !== DEFAULT_LANG)
                $data .= '        <link rel="alternate" hreflang="' . $language[7] . '" href="' . $baseURL . $language[2] . '/' . $activeLink . '" />' . PHP_EOL;
        }
    }
    if($return)
        return $data;
    else
        echo $data;
}

function htmlPrint($htmlCode,$return=false){
    if($return)
        return htmlspecialchars_decode($htmlCode);
    else
        echo htmlspecialchars_decode($htmlCode);
}

function shortCodeFilter($string){
    //Bala-ji $regex = "/\{{\((.*?)\)\}}/";
    $regex = "/\{{(.*?)\}}/";
    $arrRegex = "/\[(.*?)\]/";
    preg_match_all($regex, $string, $matches);
    
    for($i = 0; $i < count($matches[1]); $i++) {
        $match = $matches[1][$i];
        preg_match($arrRegex, $match, $arrMatches);
        if(isset($arrMatches[1])){
            $newMatch =  str_replace("[".$arrMatches[1]."]",'',$match);
            if(isset($GLOBALS[$newMatch][$arrMatches[1]]))
                $string = str_replace("{{".$match."}}",$GLOBALS[$newMatch][$arrMatches[1]],$string);
            else
                stop('SHORT CODE ERROR - "'. $match.'" NOT FOUND');
        }else{
            if(isset($GLOBALS[$match]) && $match != '')
                $string = str_replace("{{".$match."}}",$GLOBALS[$match],$string);
            else
                stop('SHORT CODE ERROR - "'. $match.'" NOT FOUND');
        }
    }
    return $string;
}

function removeShortCodes($string){
    $regex = "/\{{(.*?)\}}/";
    $arrRegex = "/\[(.*?)\]/";
    return preg_replace($regex, '', $string);
}

function isSelected($val,$bol=true,$model=null,$matchString=null,$returnVal=false){
    
    $checkAsifVal = null;
    
    if($matchString == null){
        $checkAsifVal = filter_var($val, FILTER_VALIDATE_BOOLEAN);
    } else{
        if($matchString == $val)
            $checkAsifVal = true;
        else
            $checkAsifVal = false;
    }
    
    if($checkAsifVal){
        if($bol){
            if($model == null)
                return true;
            elseif($model == '1'){
                if($returnVal)
                    return 'selected=""';
                else
                    echo 'selected=""';
            }elseif($model == '2'){
                if($returnVal)
                    return 'checked=""';
                else
                    echo 'checked=""';
            }
        }else{
            if($model == null)
                return false;
            elseif($model == '1'){
                if($returnVal)
                    return '';
                else
                    echo '';
            }elseif($model == '2'){
                if($returnVal)
                    return '';
                else
                    echo '';
            }
        }
     }else{
        if($bol){
            if($model == null)
                return false;
            elseif($model == '1'){
                if($returnVal)
                    return '';
                else
                    echo '';
            }elseif($model == '2'){
                if($returnVal)
                    return '';
                else
                    echo '';
            }
        }else{
            if($model == null)
                return true;
            elseif($model == '1'){
                if($returnVal)
                    return 'selected=""';
                else
                    echo 'selected=""';
            }elseif($model == '2'){
                if($returnVal)
                    return 'checked=""';
                else
                    echo 'checked=""';
            }
        }
    }
}

function quickLoginCheck($con,$ip){
    
    $date = date('Y-m-d');
    $taskData =  mysqli_query($con, "SELECT * FROM rainbowphp_temp where task='quick_login'");
    $taskRow = mysqli_fetch_array($taskData);
    $taskData = dbStrToArr($taskRow['data']);
    
    if(isset($taskData[$date])){
        if(isset($taskData[$date][$ip]))
            return false;
    }
    return true;
}

function quickLoginDisable($con,$ip){
    
    $date = date('Y-m-d');
    $taskData =  mysqli_query($con, "SELECT * FROM rainbowphp_temp where task='quick_login'");
    $taskRow = mysqli_fetch_array($taskData);
    $taskData = dbStrToArr($taskRow['data']);
    
    if(isset($taskData[$date])){
        if(isset($taskData[$date][$ip])){
            return false;
        }else{
            //New IP Record
            $taskData[$date][$ip] = array('time' => time());
        }
    }else{
        //Clear old date and insert new!
        $prevDate = date('Y-m-d', strtotime($date .' -1 day'));
        if(isset($taskData[$prevDate]))
            unset($taskData[$prevDate]);
        $taskData[$date][$ip] = array('time' => time());
    }
    updateToDb($con,'rainbowphp_temp', array(
        'data' => arrToDbStr($con,$taskData)), array('task' => 'quick_login'));
    return true;
}
