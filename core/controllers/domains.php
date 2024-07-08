<?php
defined('APP_NAME') or die(header('HTTP/1.1 403 Forbidden'));
define('TEMP_DIR',APP_DIR.'temp'.D_S);


/*
 * @author MD ARIFUL HAQUE
 * @name KOVATZ Seo Tools - PHP Script
 * @copyright 2022 KOVATZ.COM
 *
 */

//GET REQUEST Handler
//Website Thumbnail
if(isset($_GET['getImage'])){
    if(isset($_SESSION['snap'])){
        $customSnapAPI = true;
        $customSnapLink = $_SESSION['snap'];
    }
    session_write_close();
    $my_url = clean_url(raino_trim($_GET['site']));
    $imageData = getMyData(getSiteSnap($my_url,$item_purchase_code,$baseLink,$customSnapAPI,$customSnapLink));
    ob_clean();
    echo base64_encode($imageData);
    die();
}

//Login Box
$seoBoxLogin = '<div class="lowImpactBox">
<div class="msgBox">   
        '.$lang['39'].'
        
    <br /><br /> <div class="altImgGroup"> <a class="btn btn-success forceLogin" target="_blank" href="'.createLink('account/login',true).'" title="'.$lang['40'].'"> '.$lang['40'].' </a></div><br />
</div>
</div>';
    
//POST REQUEST Handler
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 
//Get User Request
$my_url = 'http://'.clean_url(raino_trim($_POST['url']));
$hashCode = raino_trim($_POST['hashcode']);

//Source Data - File Path
$filename = TEMP_DIR.$hashCode.'.tdata';

//Separate Unique Code
$sepUnique = '!!!!8!!!!';

//Parse Host
$my_url_parse = parse_url($my_url);
$inputHost = $my_url_parse['scheme'] . "://" . $my_url_parse['host'];
$my_url_host = str_replace("www.","",$my_url_parse['host']);
$domainStr = escapeTrim($con, strtolower($my_url_host));

//True (or) False Image
$true = '<img src="'.themeLink('img/true.png',true).'" alt="'.trans('True',$lang['10'],true).'" />';
$false = '<img src="'.themeLink('img/false.png',true).'" alt="'.trans('False',$lang['9'],true).'" />';

//Get Data of the URL
$sourceData = getMyData($filename);

//Fix Meta Uppercase Problem
$html = str_ireplace(array("Title","TITLE"),"title",$sourceData);
$html = str_ireplace(array("Description","DESCRIPTION"),"description",$html);
$html = str_ireplace(array("Keywords","KEYWORDS"),"keywords",$html);
$html = str_ireplace(array("Content","CONTENT"),"content",$html);  
$html = str_ireplace(array("Meta","META"),"meta",$html);  
$html = str_ireplace(array("Name","NAME"),"name",$html);      
    
//Check Empty Source Data
if($sourceData == '')
   die($lang['AN10']);

//Meta Data
if(isset($_POST['meta'])){

    $title = $description = $keywords = '';
    $doc = new DOMDocument();
    @$doc->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
    $nodes = $doc->getElementsByTagName('title');
    $title = $nodes->item(0)->nodeValue;
    $metas = $doc->getElementsByTagName('meta');

    for ($i = 0; $i < $metas->length; $i++){
    $meta = $metas->item($i);
    if($meta->getAttribute('name') == 'description')
       $description = $meta->getAttribute('content');
    if($meta->getAttribute('name') == 'keywords')
        $keywords = $meta->getAttribute('content');
    }
    
    $updateStr = serBase(array($title,$description,$keywords));
    updateToDbPrepared($con, 'domains_data', array('meta_data'=>$updateStr), array('domain' => $domainStr));
    
    $lenTitle = mb_strlen($title,'utf8');
    $lenDes = mb_strlen($description,'utf8');
    
    //Check Empty Data
    $site_title = ($title == '' ? $lang['AN11'] : $title);
    $site_description = ($description == '' ? $lang['AN12'] : $description);
    $site_keywords = ($keywords == '' ? $lang['AN15'] : $keywords);
    
    if(isset($_POST['metaOut'])){
    
    $titleMsg = $lang['AN173'];
    $desMsg = $lang['AN174'];
    $keyMsg = $lang['AN175'];
    $googleMsg = $lang['AN177'];
    
    if($lenTitle < 10)
        $classTitle = 'improveBox';
    elseif($lenTitle < 70)
        $classTitle = 'passedBox';
    else
        $classTitle = 'errorBox';
    
    if($lenDes < 70)
        $classDes = 'improveBox';
    elseif($lenDes < 300)
        $classDes = 'passedBox';
    else
        $classDes = 'errorBox';
        
    $classKey = 'lowImpactBox';
    
     if(!isset($_SESSION['twebUsername'])){
        if(!isAllowedStats($con,'seoBox1')){
            die($seoBoxLogin.$sepUnique.$seoBoxLogin.$sepUnique.$seoBoxLogin.$sepUnique.$seoBoxLogin);
        }
    }
    
    echo '<div class="'.$classTitle.'">
    <div class="msgBox bottom10">       
    '.$site_title.'
    <br />
    <b>'.$lang['AN13'].':</b> '.$lenTitle.' '.$lang['AN14'].' 
    </div>
    <div class="seoBox1 suggestionBox">
    '.$titleMsg.'
    </div> 
    </div>';
    
    echo $sepUnique; //Separate
    
    echo '<div class="'.$classDes.'">
    <div class="msgBox padRight10 bottom10">       
    '.$site_description.'
    <br />
    <b>'.$lang['AN13'].':</b> '.$lenDes.' '.$lang['AN14'].' 
    </div>
    <div class="seoBox2 suggestionBox">
    '.$desMsg.'
    </div> 
    </div>';
    
    echo $sepUnique; //Separate
    
    echo '<div class="'.$classKey.'">
    <div class="msgBox padRight10">       
    '.$site_keywords.'
    <br /><br />
    </div>
    <div class="seoBox3 suggestionBox">
    '.$keyMsg.'
    </div> 
    </div>';
    
    echo $sepUnique; //Separate
    
    echo '<div class="'.$classKey.'">
    <div class="msgBox">       
         <div class="googlePreview">
    		<p>'.$site_title.'</p>
    		<p><span class="bold">'.$my_url_parse['host'].'</span>/</p>
    		<p>'.$site_description.'</p>
        </div>
    <br />
    </div>
    <div class="seoBox5 suggestionBox">
    '.$googleMsg.'
    </div> 
    </div>';
    
    die();
    }
}

//Heading Data 
if(isset($_POST['heading'])){
    $doc = new DOMDocument();
    @$doc->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
    
    //Get H1 to H6 Tags
    $tags = array ('h1', 'h2', 'h3', 'h4', 'h5', 'h6');
    $h1Count = $h2Count = $h3Count = $h4Count = $h5Count = $h6Count = 0;
    $elementListData = $texts = array ();
    $hideCount = 0;
    $hideClass = $headStr = '';
    
    foreach($tags as $tag) {
          $elementList = $doc->getElementsByTagName($tag);
          foreach($elementList as $element){
             if($hideCount == 3)
                $hideClass = 'hideTr hideTr1';
             $headContent = strip_tags($element->textContent);
             $texts[$element->tagName][] = $headContent;
             if(strlen($headContent) >= 100)
                $headStr.= '<tr class="'.$hideClass.'"> <td>&lt;'.strtoupper($element->tagName).'&gt; <b>'.truncate($headContent, 20, 100).'</b> &lt;/'.strtoupper($element->tagName).'&gt;</td> </tr>';
             else
                $headStr.= '<tr class="'.$hideClass.'"> <td>&lt;'.strtoupper($element->tagName).'&gt; <b>'.$headContent.'</b> &lt;/'.strtoupper($element->tagName).'&gt;</td> </tr>';
             $elementListData[$tag][] = array(strtoupper($element->tagName),$headContent);
             $hideCount++;
          }
    }
    
    $updateStr = serBase(array($elementListData,$texts));
    updateToDbPrepared($con, 'domains_data', array('headings' => $updateStr), array('domain' => $domainStr));
    
    if(isset($_POST['headingOut'])){
        
    $headMsg = $lang['AN176'];
    
    $h1Count = isset($texts['h1']) ? count($texts['h1']) : 0;
    $h2Count = isset($texts['h2']) ? count($texts['h2']) : 0;
    $h3Count = isset($texts['h3']) ? count($texts['h3']) : 0;
    $h4Count = isset($texts['h4']) ? count($texts['h4']) : 0;
    $h5Count = isset($texts['h5']) ? count($texts['h5']) : 0;
    $h6Count = isset($texts['h6']) ? count($texts['h6']) : 0;

    if($h1Count > 2)
        $class = 'improveBox';
        
    elseif($h1Count != 0 && $h2Count != 0 )
        $class = 'passedBox';
    else
        $class = 'errorBox';
    
     if(!isset($_SESSION['twebUsername'])){
        if(!isAllowedStats($con,'seoBox4')){
            die($seoBoxLogin);
        }
    }
    
    echo '<div class="'.$class.'">
            <div class="msgBox">       
            <table class="table table-striped table-responsive centerTable">
    			<thead>
    				<tr>
                		<th>&lt;H1&gt;</th>
                        <th>&lt;H2&gt;</th>
                        <th>&lt;H3&gt;</th>
                        <th>&lt;H4&gt;</th>
                        <th>&lt;H5&gt;</th>
                        <th>&lt;H6&gt;</th>
          			</tr>
    		    </thead>
      			<tbody>
                    <tr>
            			<td>'.$h1Count.'</td>
                        <td>'.$h2Count.'</td>
                        <td>'.$h3Count.'</td>
                        <td>'.$h4Count.'</td>
                        <td>'.$h5Count.'</td>
                        <td>'.$h6Count.'</td>
                    </tr>
               </tbody>
            </table>
            
            <table class="table table-striped table-responsive">
                <tbody>
                    '.$headStr.'
        	   </tbody>
            </table>
            '.(($hideCount > 3)? '
            <div class="showLinks showLinks1">
                <a class="showMore showMore1">'.$lang['AN18'].' <br /> <i class="fa fa-angle-double-down"></i></a>
                <a class="showLess showLess1"><i class="fa fa-angle-double-up"></i> <br /> '.$lang['AN19'].'</a>
            </div>' : '').'
            
            <br />
            </div>
    <div class="seoBox4 suggestionBox">
    '.$headMsg.'
    </div> 
    </div>';
    die();
  }
}

//Load DOM if needed! 
if(isset($_POST['loaddom'])){
    //Library
    require_once (LIB_DIR . "simple_html_dom.php");
    
    //Load Dom Data
    $domData = load_html($sourceData);
}

//Image without Alt Tag
if(isset($_POST['image'])){
    
    //Image without "alt" tag
    $imageCount = 0;
    $imageWithOutAltTag = 0;
    $hideClass = $imageWithOutAltTagData = '';
    $imageMsg = $lang['AN178'];
    $imgArr = array();

    if (!empty($domData)) {
        $domContent = $domData->find('img');
        if (!empty($domContent)) {
            foreach ($domContent as $imgData) {
                if (Trim($imgData->getAttribute('src')) != "") {
                    //Valid Image
                    $imageCount++;
                    if (Trim($imgData->getAttribute('alt')) == "") {
                        //Without "alt" tag!
                        if ($imageWithOutAltTag == 3) $hideClass = 'hideTr hideTr2';
                        $imageWithOutAltTagData .= '<tr class="' . $hideClass . '"> <td>' . Trim($imgData->getAttribute('src')) . '</td> </tr>';
                        $imgArr[] = Trim($imgData->getAttribute('src'));
                        $imageWithOutAltTag++;
                    }
                }
            }
        }
    }
    
    $updateStr = serBase(array($imageCount,$imageWithOutAltTag,$imgArr));
    updateToDbPrepared($con, 'domains_data', array('image_alt'=> $updateStr), array('domain' => $domainStr));
    
    if($imageWithOutAltTag == 0)
        $altClass = 'passedBox';
    elseif($imageWithOutAltTag < 2)
        $altClass = 'improveBox';
    else
        $altClass = 'errorBox';
    
    //Clean up memory
    $domData = null;
    
     if(!isset($_SESSION['twebUsername'])){
        if(!isAllowedStats($con,'seoBox6')){
            die($seoBoxLogin);
        }
    }
    
    echo '<div class="'.$altClass.'">
    <div class="msgBox">       
        '.str_replace('[image-count]',$imageCount,$lang['AN21']).' <br />
        <div class="altImgGroup"> 
        '.(($imageWithOutAltTag == 0)? '
        <img src="'.$theme_path.'img/true.png" alt="'.$lang['AN24'].'" title="'.$lang['AN25'].'" /> '.$lang['AN27'].'<br />': ' 
        <img src="'.$theme_path.'img/false.png" alt="'.$lang['AN23'].'" title="'.$lang['AN22'].'" />
         '.str_replace('[missing-alt-tag]',$imageWithOutAltTag,$lang['AN26']).'
        </div>
        <br />
        <table class="table table-striped table-responsive">
            <tbody>
                  '.$imageWithOutAltTagData.'
    	   </tbody>
        </table>').'
        
        '.(($imageWithOutAltTag > 3)? '
        <div class="showLinks showLinks2">
            <a class="showMore showMore2">'.$lang['AN18'].' <br /> <i class="fa fa-angle-double-down"></i></a>
            <a class="showLess showLess2"><i class="fa fa-angle-double-up"></i> <br /> '.$lang['AN19'].'</a>
        </div>' : '').'
        
        <br />
    </div>
    <div class="seoBox6 suggestionBox">
    '.$imageMsg.'
    </div> 
    </div>';
    die();
}

//Keyword Cloud
if(isset($_POST['keycloud'])){
    $obj = new KD();
    $obj->domain = $my_url;
    $obj->domainData = $sourceData;
    $resdata = $obj->result(); 
    $keyData = '';
    $blockChars = $blockWords = $outArr = array();
    $keyCount = 0;
    
    foreach($resdata as $outData){
        if(isset($outData['keyword'])){
        $outData['keyword'] = Trim($outData['keyword']);
        if($outData['keyword'] != null || $outData['keyword'] != "") {
            
            $blockChars = array('~','=','+','?',':','_','[',']','"','.','!','@','#','$','%','^','&','*','(',')','<','>','{','}','|','\\','/',',');
            $blockWords = array('and', 'is', 'was', 'to', 'into', 'with', 'without', 'than', 'then', 'that', 'these', 'this', 'their', 'them', 'from', 'your', 'able', 'which', 'when', 'what', 'who');
            $blockCharsBol = false;
            foreach($blockChars as $blockChar){
                if(check_str_contains($outData['keyword'],$blockChar))
                {
                    $blockCharsBol = true;
                    break;
                }
            }
    
            if (!preg_match('/[0-9]+/', $outData['keyword'])){
                if(!$blockCharsBol){
                 if (!in_array($outData['keyword'], $blockWords)) {
                    if($keyCount == 15)
                        break;
                    $outArr[] = array($outData['keyword'], $outData['count'], $outData['percent']);
                    $keyData .= '<li><span class="keyword">'.$outData['keyword'].'</span><span class="number">'.$outData['count'].'</span></li>';
                    $keyCount++;
                 }
                }
            }   
         }
         }
    }
    $outCount = count($outArr);
    
    $updateStr = serBase(array($outCount,$outArr));
    updateToDbPrepared($con, 'domains_data', array('keywords_cloud'=> $updateStr), array('domain' => $domainStr)); 
    
    if(isset($_POST['keycloudOut'])){
        
    $keycloudClass = 'lowImpactBox';
    $keyMsg = $lang['AN179'];
    
     if(!isset($_SESSION['twebUsername'])){
        if(!isAllowedStats($con,'seoBox7')){
            die($seoBoxLogin);
        }
    }
    
    echo '<div class="'.$keycloudClass.'">
    <div class="msgBox padRight10 bottom5">       
         '.(($outCount != 0)? '
        <ul class="keywordsTags">
              '.$keyData.'  
        </ul>' : ' '.$lang['AN29']).'  
    </div>
    <div class="seoBox7 suggestionBox">
    '.$keyMsg.'
    </div> 
    </div>';
    die();
    }
}

//Keyword Consistency
if(isset($_POST['keyConsistency'])){
    
    $hideClass = $keywordConsistencyTitle = $keywordConsistencyDes = $keywordConsistencyH = $keywordConsistencyData = '';
    
    $hideCount = 1;
    $keywordConsistencyScore = 0;
    
    foreach($outArr as $outKey){
        if(check_str_contains($title, $outKey[0], true)){
            $keywordConsistencyTitle = $true;
            $keywordConsistencyScore++;
        }else{
            $keywordConsistencyTitle = $false;
        }
       
        if(check_str_contains($description, $outKey[0], true)){
            $keywordConsistencyDes = $true;
            $keywordConsistencyScore++;
        }else{
            $keywordConsistencyDes = $false;
        } 
        
        $keywordConsistencyH = $false;
        
        foreach($texts as $htags){
            foreach($htags as $htag){
                if(check_str_contains($htag, $outKey[0], true)){
                    $keywordConsistencyH = $true;
                    break 2;
                }
            }
        }
            
        if($hideCount == 5)
            $hideClass = 'hideTr hideTr3';
                
        $keywordConsistencyData .= '<tr class="'.$hideClass.'"> 
                <td>'.$outKey[0].'</td> 
                <td>'.$outKey[1].'</td> 
                <td>'.$keywordConsistencyTitle.'</td>
                <td>'.$keywordConsistencyDes.'</td>
                <td>'.$keywordConsistencyH.'</td>   
                </tr>';
        $hideCount++;
    }
    
    if($keywordConsistencyScore == 0)
        $keywordConsistencyClass = 'errorBox';
    elseif($keywordConsistencyScore < 4)
        $keywordConsistencyClass = 'improveBox';
    else
        $keywordConsistencyClass = 'passedBox';
        
    $keyMsg = $lang['AN180'];
    
     if(!isset($_SESSION['twebUsername'])){
        if(!isAllowedStats($con,'seoBox8')){
            die($seoBoxLogin);
        }
    }
    
    echo '<div class="'.$keywordConsistencyClass.'">
    <div class="msgBox">       
        <table class="table table-striped table-responsive">
		    <thead>
				<tr>
            		<th>'.$lang['AN31'].'</th>
                    <th>'.$lang['AN32'].'</th>
                    <th>'.$lang['AN33'].'</th>
                    <th>'.$lang['AN34'].'</th>
                    <th>&lt;H&gt;</th>
      			</tr>
		    </thead>
            <tbody>
                '.$keywordConsistencyData.'
    	   </tbody>
        </table>
        
        '.(($hideCount > 5)? '
            <div class="showLinks showLinks3">
                <a class="showMore showMore3">'.$lang['AN18'].' <br /> <i class="fa fa-angle-double-down"></i></a>
                <a class="showLess showLess3"><i class="fa fa-angle-double-up"></i> <br /> '.$lang['AN19'].'</a>
        </div>' : '').'
        
    </div>
    <div class="seoBox8 suggestionBox">
    '.$keyMsg.'
    </div> 
    </div>';
    die();
}

//Text to HTML Ratio
if(isset($_POST['textRatio'])){
    $textRatio = calTextRatio($sourceData);
    
    $updateStr = serBase($textRatio);
    updateToDbPrepared($con, 'domains_data', array('ratio_data'=> $updateStr), array('domain' => $domainStr)); 
      
    if(round($textRatio[2]) < 2)
        $textClass = 'errorBox';
    elseif(round($textRatio[2]) < 10)
        $textClass = 'improveBox';
    else
        $textClass = 'passedBox';
        
    $textMsg = $lang['AN181'];
    
     if(!isset($_SESSION['twebUsername'])){
        if(!isAllowedStats($con,'seoBox9')){
            die($seoBoxLogin);
        }
    }
    
    echo '<div class="'.$textClass.'">
    <div class="msgBox">       
        '.$lang['AN36'].': <b>'.round($textRatio[2],2).'%</b><br />
        <br />
        <table class="table table-responsive">
            <tbody>
                <tr> 
                <td>'.$lang['AN37'].'</td> 
                <td>'.$textRatio[1].' '.$lang['AN39'].'</td> 
                </tr>
                
                <tr> 
                <td>'.$lang['AN38'].'</td> 
                <td>'.$textRatio[0].' '.$lang['AN39'].'</td>  
                </tr>
    	   </tbody>
        </table>
    </div>
    <div class="seoBox9 suggestionBox">
    '.$textMsg.'
    </div> 
    </div>';
    die();
}

//Check GZIP Compression 
if(isset($_POST['gzip'])){
    
    $gzipClass = $gzipHead = $gzipBody = '';
    $outData = compressionTest($my_url_host);
    
    $comSize = $outData[0];
    $unComSize = $outData[1];
    $isGzip = $outData[2];
    $gzdataSize = $outData[3];
    $header = $outData[4];
    $body = Trim($outData[5]);
    
    if($body == ""){
        $gzipHead = $lang['AN10'];
        $gzipClass = 'improveBox';
    }else{
    $body = 'Data!';
    if($isGzip){
        $percentage = round(((((int)$unComSize - (int)$comSize) / (int)$unComSize) * 100),1);
        $gzipClass = 'passedBox';
        $gzipHead = $lang['AN42'];
        $gzipBody = $true . ' ' . str_replace(array('[total-size]','[compressed-size]','[percentage]'),array(size_as_kb($unComSize),size_as_kb($comSize),$percentage),$lang['AN41']);
    }else{
        $percentage = round(((((int)$unComSize - (int)$gzdataSize) / (int)$unComSize) * 100),1);
        $gzipClass = 'errorBox';
        $gzipHead = $lang['AN43'];
        $gzipBody = $false . ' ' . str_replace(array('[total-size]','[compressed-size]','[percentage]'),array(size_as_kb($unComSize),size_as_kb($gzdataSize),$percentage),$lang['AN44']);
    }
    }
    $header = 'Data!';
    
    $updateStr = serBase(array($outData[0],$outData[1],$outData[2],$outData[3],$header,$body));
    updateToDbPrepared($con, 'domains_data', array('gzip'=> $updateStr), array('domain' => $domainStr)); 
   
    $gzipMsg = $lang['AN182'];
    
     if(!isset($_SESSION['twebUsername'])){
        if(!isAllowedStats($con,'seoBox10')){
            die($seoBoxLogin);
        }
    }
            
    echo '<div class="'.$gzipClass.'">
    <div class="msgBox">       
         '.$gzipHead.'
        <br />
        <div class="altImgGroup">
            '.$gzipBody.'
        </div>
        <br />
    </div>
    <div class="seoBox10 suggestionBox">
    '.$gzipMsg.'
    </div> 
    </div>';
    die();
}

//WWW Resolve
if(isset($_POST['www_resolve'])){

    $www_resolveMsg = $lang['AN183'];
    $resolveClass = 'improveBox';
    $resolveMsg = $lang['AN47'];
    $re301 = false;
    $url_with_www = "http://www.$my_url_host";
    $url_no_www = "http://$my_url_host";
    
    $data1 = getHttpCode($url_with_www,false);
    $data2 = getHttpCode($url_no_www,false);
    
    $updateStr = serBase(array($data1,$data2));
    updateToDbPrepared($con, 'domains_data', array('resolve'=> $updateStr), array('domain' => $domainStr));

    if($data1 == '301'){
        $re301 = true;
        $resolveClass = 'passedBox';
        $resolveMsg = $lang['AN46'];
    }
    
    if($data2 == '301'){
        $re301= true;
        $resolveClass = 'passedBox';
        $resolveMsg = $lang['AN46'];
    }
    
     if(!isset($_SESSION['twebUsername'])){
        if(!isAllowedStats($con,'seoBox11')){
            die($seoBoxLogin);
        }
    }
    
    echo '<div class="'.$resolveClass.'">
    <div class="msgBox">       
         '.$resolveMsg.'
        <br />
        <br />
    </div>
    <div class="seoBox11 suggestionBox">
    '.$www_resolveMsg.'
    </div> 
    </div>';
    die();
}

//IP Canonicalization
if(isset($_POST['ip_can'])){
    
    $ip_canMsg = $lang['AN184'];
    $ipClass = 'improveBox';
    $hostIP = $ipMsg = $redirectURLhost = '';
    $tType = false;
    
    $hostIP = gethostbyname($my_url_host);
    $ch = curl_init($hostIP);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    $response = curl_exec($ch);
    preg_match_all('/^Location:(.*)$/mi', $response, $matches);
    curl_close($ch);
    
    if(!empty($matches[1])){
        $redirectURL = 'http://'.clean_url(trim($matches[1][0]));
        $redirectURLparse = parse_url($redirectURL);
        if(!isset($redirectURLparse['host']))
            $redirectURLparse['host'] = '';
        $redirectURLhost = str_replace('www.','',$redirectURLparse['host']);
        if($my_url_host == $redirectURLhost){
            $ipMsg = str_replace(array('[ip]','[host]'),array($hostIP,$my_url_host),$lang['AN50']);
            $ipClass = 'passedBox';
        }else{
           $ipMsg = str_replace(array('[ip]','[host]'),array($hostIP,$my_url_host),$lang['AN49']); 
        }
        $tType = true;
    }else{
        $ipMsg = str_replace(array('[ip]','[host]'),array($hostIP,$my_url_host),$lang['AN49']);
        $tType = false;
    }
    
    $updateStr = serBase(array($hostIP,$tType,$my_url_host,$redirectURLhost));
    updateToDbPrepared($con, 'domains_data', array('ip_can'=> $updateStr), array('domain' => $domainStr));

     if(!isset($_SESSION['twebUsername'])){
        if(!isAllowedStats($con,'seoBox12')){
            die($seoBoxLogin);
        }
    }
    
    echo '<div class="'.$ipClass.'">
    <div class="msgBox">       
         '.$ipMsg.'
        <br />
        <br />
    </div>
    <div class="seoBox12 suggestionBox">
    '.$ip_canMsg.'
    </div> 
    </div>';
    die();
}

//In-Page Links analyser
if(isset($_POST['in_page'])){

    $in_pageMsg = $lang['AN185'];
    $link_UnderScoreMsg = $lang['AN190'];
    $url_RewritingMsg = $lang['AN189'];
    $inPageClass = 'improveBox';
    $urlRewritingClass= $urlRewritingMsg = $linkUnderScoreMsg = $linkUnderScoreClass = $hideMe = $inPageData = $inPageMsg = '';
    $totalDataCount = 0;
    
    //Define Variables
    $ex_data_arr = $ex_data = array();
    $t_count = $i_links = $e_links = $i_nofollow = $e_nofollow = 0;
    
    //URL Rewriting
    $urlRewriting = true;
    $webFormats = array('html', 'htm', 'xhtml', 'xht', 'mhtml', 'mht','asp', 'aspx','cgi', 
    'ihtml', 'jsp', 'las','pl', 'php', 'php3', 'phtml', 'shtml');
    
    //Underscore on URL's
    $linkUnderScore = false;

    if (!empty($domData)) {
        $domContent = $domData->find("a");
        if (!empty($domContent)) {
            foreach ($domContent as $href) {
                if (!in_array($href->href, $ex_data_arr)) {
                    if (substr($href->href, 0, 1) != "" && $href->href != "#") {
                        $ex_data_arr[] = $href->href;
                        $ex_data[] = array('href' => $href->href, 'rel' => $href->rel, 'innertext' => Trim(strip_tags($href->plaintext)));
                    }
                }
            }
        }
    }

    $updateStr = serBase($ex_data);
    updateToDbPrepared($con, 'domains_data', array('links_analyser'=> $updateStr), array('domain' => $domainStr));
    
    //Internal Links
    foreach ($ex_data as $count => $link) {
        $t_count++;
        $parse_urls = parse_url($link['href']);
        $type = strtolower($link['rel']);
        $myIntHost = $path = '';
        if(isset($parse_urls['path']))
            $path = $parse_urls['path'];
            
        if(isset($parse_urls['host']))
            $myIntHost = $parse_urls['host'];
        
        if ($myIntHost == $my_url_host || $myIntHost == "www." . $my_url_host) {
            $i_links++;
            
            $int_data[$i_links]['inorout'] = $lang['AN52'];
            $int_data[$i_links]['href'] = $link['href'];
            $int_data[$i_links]['text'] = $link['innertext'];
            
            if(mb_strpos($link['href'], "_") !== false)
                $linkUnderScore = true;
            
            $dotStr = $exStr = '';
            $exStr = explode('.',$path);
            $dotStr = Trim(end($exStr));
            if($dotStr != $path){
                if(in_array($dotStr,$webFormats))
                    $urlRewriting = false;
            }
            
            if ($type == 'dofollow' || ($type != 'dofollow' && $type != 'nofollow'))
                $int_data[$i_links]['follow_type'] = "dofollow";
    
            if ($type == 'nofollow'){
                $i_nofollow++;
                $int_data[$i_links]['follow_type'] = "nofollow";
            }
            
        } elseif ((substr($link['href'], 0, 2) != "//") && (substr($link['href'], 0, 1) == "/")) {
            $i_links++;
            $int_data[$i_links]['inorout'] = $lang['AN52'];
            $int_data[$i_links]['href'] = $inputHost.$link['href'];
            $int_data[$i_links]['text'] = $link['innertext'];
            
            if(mb_strpos($link['href'], "_") !== false)
                $linkUnderScore = true;
                
            $dotStr = $exStr = '';
            $exStr = explode('.',$path);
            $dotStr = Trim(end($exStr));
            if($dotStr != $path){
                if(in_array($dotStr,$webFormats))
                    $urlRewriting = false;
            }
            
            if ($type == 'dofollow' || ($type != 'dofollow' && $type != 'nofollow'))
                $int_data[$i_links]['follow_type'] = "dofollow";
                
            if ($type == 'nofollow') {
                $i_nofollow++;
                $int_data[$i_links]['follow_type'] = "nofollow";
            }
        } else{
                if(substr($link['href'], 0, 7) != "http://" && substr($link['href'], 0, 8) != "https://" &&
                substr($link['href'], 0, 2) != "//" && substr($link['href'], 0, 1) != "/" && substr($link['href'], 0, 1) != "#"
                && substr($link['href'], 0, 2) != "//" && substr($link['href'], 0, 6) != "mailto" && substr($link['href'], 0, 4) != "tel:" && substr($link['href'], 0, 10) != "javascript") {
                
                    $i_links++;
                    $int_data[$i_links]['inorout'] = $lang['AN52'];
                    $int_data[$i_links]['href'] = $inputHost.'/'.$link['href'];
                    $int_data[$i_links]['text'] = $link['innertext'];
                    if(mb_strpos($link['href'], "_") !== false)
                        $linkUnderScore = true;
                    
                    $dotStr = $exStr = '';
                    $exStr = explode('.',$path);
                    $dotStr = Trim(end($exStr));
                    if($dotStr != $path){
                        if(in_array($dotStr,$webFormats))
                            $urlRewriting = false;
                    }
                    
                    if ($type == 'dofollow' || ($type != 'dofollow' && $type != 'nofollow'))
                        $int_data[$i_links]['follow_type'] = "dofollow";
                        
                    if ($type == 'nofollow') {
                        $i_nofollow++;
                        $int_data[$i_links]['follow_type'] = "nofollow";
                    }
                }
    		}
    }
    
    //External Links
    foreach ($ex_data as $count => $link)
    {
        $parse_urls = parse_url($link['href']);
        $type = strtolower($link['rel']);
        
        if ($parse_urls !== false && isset($parse_urls['host']) && $parse_urls['host'] !=
            $my_url_host && $parse_urls['host'] != "www." . $my_url_host) {
            $e_links++;
            $ext_data[$e_links]['inorout'] = $lang['AN53'];
            $ext_data[$e_links]['href'] = $link['href'];
            $ext_data[$e_links]['text'] = $link['innertext'];
            if ($type == 'dofollow' || ($type != 'dofollow' && $type != 'nofollow'))
                $ext_data[$e_links]['follow_type'] = "dofollow";
            if ($type == 'nofollow') {
                $e_nofollow++;
                $ext_data[$e_links]['follow_type'] = "nofollow";
            }
        } elseif ((substr($link['href'], 0, 2) == "//") && (substr($link['href'], 0, 1) != "/")) {
            $e_links++;
            $ext_data[$e_links]['inorout'] = $lang['AN53'];
            $ext_data[$e_links]['href'] = $link['href'];
            $ext_data[$e_links]['text'] = $link['innertext'];
            if ($type == 'dofollow' || ($type != 'dofollow' && $type != 'nofollow'))
                $ext_data[$e_links]['follow_type'] = "dofollow";
            if ($type == 'nofollow') {
                $e_nofollow++;
                $ext_data[$e_links]['follow_type'] = "nofollow";
            }
        }
    }
    
    //Clean up memory
    $domData = null;
    
    if(isset($_POST['inPageoutput'])){
    foreach($int_data as $internalData){
        if($totalDataCount == 5)
            $hideMe = 'hideTr hideTr4';
        $inPageData.= '<tr class="'.$hideMe.'"><td><a target="_blank" href="'.$internalData['href'].'" title="'.$internalData['text'].'" rel="nofollow">'.($internalData['text']=='' ? $internalData['href'] : $internalData['text']).'</a></td><td>'.$internalData['inorout'].'</td><td>'.ucfirst($internalData['follow_type']).'</td></tr>';
        $totalDataCount++;
    }
    
    foreach($ext_data as $externalData){
        if($totalDataCount == 5)
            $hideMe = 'hideTr hideTr4';
        $inPageData.= '<tr class="'.$hideMe.'"><td><a target="_blank" href="'.$externalData['href'].'" title="'.$externalData['text'].'" rel="nofollow">'.($externalData['text']=='' ? $externalData['href'] : $externalData['text']).'</a></td><td>'.$externalData['inorout'].'</td><td>'.ucfirst($externalData['follow_type']).'</td></tr>';
        $totalDataCount++;
    }
   
    if($t_count < 200)
        $inPageClass = 'passedBox';
        
    $inPageMsg = str_replace('[count]',$t_count,$lang['AN57']);
    
    if($linkUnderScore){
        $linkUnderScoreClass = 'errorBox';
        $linkUnderScoreMsg = $lang['AN65'];
    } else{
        $linkUnderScoreClass = 'passedBox';
        $linkUnderScoreMsg = $lang['AN64'];
    }
    
    if($urlRewriting){
        $urlRewritingClass = 'passedBox';
        $urlRewritingMsg = $lang['AN66'];
    }else{
        $urlRewritingClass  = 'errorBox';
        $urlRewritingMsg = $lang['AN67'];
    }
        
    $seoBox13 = '<div class="'.$inPageClass.'">
    <div class="msgBox">       
         '.$inPageMsg.'
        <br /><br />
        <table class="table table-responsive">
            <thead>
                <tr>
                <th>'.$lang['AN54'].'</th>
                <th>'.$lang['AN55'].'</th>
                <th>'.$lang['AN56'].'</th>
                </tr>
            </thead>
            <tbody>
                '.$inPageData.'
    	   </tbody>
        </table>
        
        '.(($totalDataCount > 5)? '
            <div class="showLinks showLinks4">
                <a class="showMore showMore4">'.$lang['AN18'].' <br /> <i class="fa fa-angle-double-down"></i></a>
                <a class="showLess showLess4"><i class="fa fa-angle-double-up"></i> <br /> '.$lang['AN19'].'</a>
        </div>' : '').'
        
    </div>
    <div class="seoBox13 suggestionBox">
    '.$in_pageMsg.'
    </div> 
    </div>';
        
    $seoBox17 = '<div class="'.$urlRewritingClass.'">
    <div class="msgBox">       
         '.$urlRewritingMsg.'
        <br />
        <br />
    </div>
    <div class="seoBox17 suggestionBox">
    '.$url_RewritingMsg.'
    </div> 
    </div>';
    
    $seoBox18 = '<div class="'.$linkUnderScoreClass.'">
    <div class="msgBox">       
         '.$linkUnderScoreMsg.'
        <br />
        <br />
    </div>
    <div class="seoBox18 suggestionBox">
    '.$link_UnderScoreMsg.'
    </div> 
    </div>';
    
     if(!isset($_SESSION['twebUsername'])){
        if(!isAllowedStats($con,'seoBox13'))
            $seoBox13 = $seoBoxLogin;
            
        if(!isAllowedStats($con,'seoBox17'))
            $seoBox17 = $seoBoxLogin;
        
        if(!isAllowedStats($con,'seoBox18'))
            $seoBox18 = $seoBoxLogin;
    }
    
    echo $seoBox13.$sepUnique.$seoBox17.$sepUnique.$seoBox18;
    die(); 
    }
}

//Broken Links
if(isset($_POST['brokenlinks'])){
    session_write_close();
    
    $broken_Msg = $lang['AN186'];
    $hideMe = $brokenMsg = $brokenClass = $brokenLinks = '';
    $bLinks = array();
    $totalDataCount = 0;
    
    foreach($int_data as $internal_link){

        $iLink = Trim($internal_link['href']);

        if(substr($iLink, 0, 4) == "tel:")
            continue;

        if(substr($iLink, 0, 2) == "//") {
            $iLink = 'http:' . $iLink;
        } elseif(substr($iLink, 0, 1) == "/") {
            $iLink = $inputHost . $iLink;
        }

        $httpCode = getHttpCode($iLink);
        
        if($httpCode == 404){
            if($totalDataCount == 3)
                $hideMe = 'hideTr hideTr5';
        $brokenLinks.= '<tr class="'.$hideMe.'"><td>'.$iLink.'</td></tr>';
        $bLinks[] = $iLink;
        $totalDataCount++;
        }
    }
    
    foreach($ext_data as $external_link){
        $eLink = Trim($external_link['href']);
        
        $httpCode = getHttpCode($eLink);
        
        if($httpCode == 404){
            if($totalDataCount == 3)
                $hideMe = 'hideTr hideTr5';
            $brokenLinks.= '<tr class="'.$hideMe.'"><td>'.$eLink.'</td></tr>';
            $bLinks[] = $eLink;
            $totalDataCount++;
        }
    }
    
    $updateStr = serBase($bLinks);
    updateToDbPrepared($con, 'domains_data', array('broken_links'=> $updateStr), array('domain' => $domainStr));
 
    if($totalDataCount == 0){
        $brokenClass = 'passedBox';
        $brokenMsg = $lang['AN68'];
    }else{
        $brokenClass = 'errorBox';
        $brokenMsg = $lang['AN69'];
    }
    
     if(!isset($_SESSION['twebUsername'])){
        if(!isAllowedStats($con,'seoBox14')){
            die($seoBoxLogin);
        }
    }
    
    echo '<div class="'.$brokenClass.'">
    <div class="msgBox">       
         '.$brokenMsg.'
        <br /><br />
        
        '.(($totalDataCount != 0)? '
        <table class="table table-responsive">
            <tbody>
                '.$brokenLinks.'
    	   </tbody>
        </table>' : '').'
                
        '.(($totalDataCount > 3)? '
            <div class="showLinks showLinks5">
                <a class="showMore showMore5">'.$lang['AN18'].' <br /> <i class="fa fa-angle-double-down"></i></a>
                <a class="showLess showLess5"><i class="fa fa-angle-double-up"></i> <br /> '.$lang['AN19'].'</a>
        </div>' : '').'
        
    </div>
    <div class="seoBox14 suggestionBox">
    '.$broken_Msg.'
    </div> 
    </div>';
    die();
}

//Robots.txt Checker
if(isset($_POST['robot'])){
    $robot_Msg = $lang['AN187'];
    $robotLink = $robotMsg = $robotClass = '';

    $robotLink = $inputHost .'/robots.txt';
    $httpCode = getHttpCode($robotLink);
  
    $updateStr = base64_encode($httpCode);
    updateToDbPrepared($con, 'domains_data', array('robots'=> $updateStr), array('domain' => $domainStr));
 
    if($httpCode == '404'){
        $robotClass = 'errorBox';
        $robotMsg = $lang['AN74'] . '<br>' . '<a href="'.$robotLink.'" title="'.$lang['AN75'].'" rel="nofollow" target="_blank">'.$robotLink.'</a>';
    }else{
        $robotClass = 'passedBox';
        $robotMsg = $lang['AN73'] . '<br>' . '<a href="'.$robotLink.'" title="'.$lang['AN75'].'" rel="nofollow" target="_blank">'.$robotLink.'</a>';
    }
    
     if(!isset($_SESSION['twebUsername'])){
        if(!isAllowedStats($con,'seoBox16')){
            die($seoBoxLogin);
        }
    }
    
    echo '<div class="'.$robotClass.'">
    <div class="msgBox">       
         '.$robotMsg.'
        <br /><br />
    </div>
    <div class="seoBox16 suggestionBox">
    '.$robot_Msg.'
    </div> 
    </div>';
    die();
}

//Sitemap Checker
if(isset($_POST['sitemap'])){
    $sitemap_Msg = $lang['AN188'];
    $sitemapLink = $sitemapMsg = $sitemapClass = '';

    $sitemapInfo = getSitemapInfo($inputHost);
    $httpCode = $sitemapInfo['httpCode'];
    $sitemapLink = $sitemapInfo['sitemapLink'];

    $updateStr = base64_encode($httpCode);
    updateToDbPrepared($con, 'domains_data', array('sitemap'=> $updateStr), array('domain' => $domainStr));
  
    if($httpCode == '404'){
        $sitemapClass = 'errorBox';
        $sitemapMsg = $lang['AN71'] . '<br>' . '<a href="'.$sitemapLink.'" title="'.$lang['AN72'].'" rel="nofollow" target="_blank">'.$sitemapLink.'</a>';
    }else{
        $sitemapClass = 'passedBox';
        $sitemapMsg = $lang['AN70'] . '<br>' . '<a href="'.$sitemapLink.'" title="'.$lang['AN72'].'" rel="nofollow" target="_blank">'.$sitemapLink.'</a>';
    }
    
     if(!isset($_SESSION['twebUsername'])){
        if(!isAllowedStats($con,'seoBox15')){
            die($seoBoxLogin);
        }
    }
    
    echo '<div class="'.$sitemapClass.'">
    <div class="msgBox">       
         '.$sitemapMsg.'
        <br /><br />
    </div>
    <div class="seoBox15 suggestionBox">
    '.$sitemap_Msg.'
    </div> 
    </div>';
    die();
}

//Embedded Object Check
if(isset($_POST['embedded'])){
    
    $embedded_Msg = $lang['AN191'];
    $embeddedMsg = $embeddedClass = '';
    $embeddedCheck = false;

    if (!empty($domData)) {
        $domContent = $domData->find('object');
        if (!empty($domContent)) {
            foreach ($domContent as $embedded)
                $embeddedCheck = true;
        }
        $domContent = $domData->find('embed');
        if (!empty($domContent)) {
            foreach ($domContent as $embedded)
                $embeddedCheck = true;
        }
    }

    updateToDbPrepared($con, 'domains_data', array('embedded'=> $embeddedCheck), array('domain' => $domainStr));

    if($embeddedCheck){
        $embeddedClass = 'errorBox';
        $embeddedMsg = $lang['AN78'];
    }else{
        $embeddedClass = 'passedBox';
        $embeddedMsg = $lang['AN77'];
    }
    
    //Clean up memory
    $domData = null;
    
     if(!isset($_SESSION['twebUsername'])){
        if(!isAllowedStats($con,'seoBox19')){
            die($seoBoxLogin);
        }
    }
    
    echo '<div class="'.$embeddedClass.'">
    <div class="msgBox">       
         '.$embeddedMsg.'
        <br /><br />
    </div>
    <div class="seoBox19 suggestionBox">
    '.$embedded_Msg.'
    </div> 
    </div>';
    die();
}

//iframe Check
if(isset($_POST['iframe'])){
    
    $iframe_Msg = $lang['AN192'];
    $iframeMsg = $iframeClass = '';
    $iframeCheck = false;


    if (!empty($domData)) {
        $domContent = $domData->find('iframe');
        if (!empty($domContent)) {
            foreach ($domContent as $iframe)
                $iframeCheck = true;
        }
    }

    updateToDbPrepared($con, 'domains_data', array('iframe'=> $iframeCheck), array('domain' => $domainStr));
  
    if($iframeCheck){
        $iframeClass = 'errorBox';
        $iframeMsg = $lang['AN80'];
    }else{
        $iframeClass = 'passedBox';
        $iframeMsg = $lang['AN79'];
    }
   
    //Clean up memory
    $domData = null;
    
     if(!isset($_SESSION['twebUsername'])){
        if(!isAllowedStats($con,'seoBox20')){
            die($seoBoxLogin);
        }
    }
    
    echo '<div class="'.$iframeClass.'">
    <div class="msgBox">       
         '.$iframeMsg.'
        <br /><br />
    </div>
    <div class="seoBox20 suggestionBox">
    '.$iframe_Msg.'
    </div> 
    </div>';
    die();
}

//WHOIS Data
if(isset($_POST['whois'])){
    $class = 'lowImpactBox';
    $whoisData = $hideMe = '';
    $totalDataCount = 0;
    $domainAgeMsg = $lang['AN193'];
    $whoisDataMsg = $lang['AN194'];
    
    $whois = new whois;
    $site = $whois->cleanUrl($my_url_host);
    $whois_data = $whois->whoislookup($site);
    $whoisRaw = $whois_data[0];
    $domainAge = $whois_data[1];
    $createdDate = $whois_data[2];
    $updatedDate = $whois_data[3];
    $expiredDate = $whois_data[4];
    
    $updateStr = serBase($whois_data);
    updateToDbPrepared($con, 'domains_data', array('whois'=>$updateStr ), array('domain' => $domainStr));

    $myLines = preg_split("/\r\n|\n|\r/", $whoisRaw);
    foreach($myLines as $line){
        if(!empty($line)){
        if($totalDataCount == 5)
            $hideMe = 'hideTr hideTr6';
        $whoisData.='<tr class="'.$hideMe.'"><td>'.$line.'</td></tr>';
        $totalDataCount++;
        }
    }
    
    $seoBox21 = '<div class="'.$class.'">
    <div class="msgBox">       
         '.$lang['AN85'].'
        <br /><br />
        <div class="altImgGroup">
            <p><i class="fa fa-paw solveMsgGreen"></i> '.$lang['AN86'].': '.$domainAge.'</p>
            <p><i class="fa fa-paw solveMsgGreen"></i> '.$lang['AN87'].': '.$createdDate.'</p>
            <p><i class="fa fa-paw solveMsgGreen"></i> '.$lang['AN88'].': '.$updatedDate.'</p>
            <p><i class="fa fa-paw solveMsgGreen"></i> '.$lang['AN89'].': '.$expiredDate.'</p>
        </div>
    </div>
    <div class="seoBox21 suggestionBox">
    '.$domainAgeMsg.'
    </div> 
    </div>';
    
    $seoBox22 = '<div class="'.$class.'">
    <div class="msgBox">       
         '.$lang['AN84'].'
        <br /><br />

        '.(($totalDataCount != 0)? '
        <table class="table table-hover table-bordered table-striped">
            <tbody>
                '.$whoisData.'
            </tbody>
        </table>' : $lang['AN90']).'
                
        '.(($totalDataCount > 5)? '
            <div class="showLinks showLinks6">
                <a class="showMore showMore6">'.$lang['AN18'].' <br /> <i class="fa fa-angle-double-down"></i></a>
                <a class="showLess showLess6"><i class="fa fa-angle-double-up"></i> <br /> '.$lang['AN19'].'</a>
        </div>' : '').'
        
    </div>
    <div class="seoBox22 suggestionBox">
    '.$whoisDataMsg.'
    </div> 
    </div>';
    
     if(!isset($_SESSION['twebUsername'])){
        if(!isAllowedStats($con,'seoBox21'))
            $seoBox21 = $seoBoxLogin;
        if(!isAllowedStats($con,'seoBox22'))
            $seoBox22 = $seoBoxLogin;   
    }
    
    echo $seoBox21.$sepUnique.$seoBox22;
    
    die();
}

//Mobile Friendliness
if(isset($_POST['mobileCheck'])){
    $isMobileFriendlyMsg = '';
    $mobileClass = $mobileScreenClass = 'lowImpactBox';
    
    $mobileCheckMsg = $lang['AN195'];
    $mobileScreenClassMsg = $lang['AN196'];;

    $jsonData = getMobileFriendly($my_url);
    $mobileScore = intval($jsonData['score']);
    $isMobileFriendly = $jsonData['passed'];

    if($jsonData != null || $jsonData == ""){

        if($isMobileFriendly){
            $mobileClass = 'passedBox';
            $isMobileFriendlyMsg.=$lang['AN116'].'<br>'.str_replace('[score]',$mobileScore,$lang['AN117']);
        }else{
            $mobileClass = 'errorBox';
            $isMobileFriendlyMsg.=$lang['AN118'].'<br>'.str_replace('[score]',$mobileScore,$lang['AN117']);
        }

        $screenData = $jsonData['screenshot'];
        
        //Store Mobile Preview
        storeMobilePreview($domainStr,$screenData);
        
        if($screenData == '')
            $mobileScreenData = '';
        else
            $mobileScreenData  = '<img src="data:image/jpeg;base64,'.$screenData.'" />';
    }else{
        $isMobileFriendlyMsg = $lang['AN10'];
        $mobileScreenData = $lang['AN119'];
    }
    
    $mobData = array($mobileScore,$isMobileFriendly);
    $updateStr = serBase($mobData);
    updateToDbPrepared($con, 'domains_data', array('mobile_fri'=> $updateStr), array('domain' => $domainStr));
  
    $seoBox23 = '<div class="'.$mobileClass.'">
    <div class="msgBox">       
        '.$isMobileFriendlyMsg.'
        <br /><br />
    </div>
    <div class="seoBox23 suggestionBox">
    '.$mobileCheckMsg.'
    </div> 
    </div>';
    
    $seoBox24 = '<div class="'.$mobileScreenClass.'">
    <div class="msgBox">       
        <div class="mobileView">'.$mobileScreenData.'</div>
        <br />
    </div>
    <div class="seoBox24 suggestionBox">
    '.$mobileScreenClassMsg.'
    </div> 
    </div>';
    
     if(!isset($_SESSION['twebUsername'])){
        if(!isAllowedStats($con,'seoBox23'))
            $seoBox23 = $seoBoxLogin;
        if(!isAllowedStats($con,'seoBox24'))
            $seoBox24 = $seoBoxLogin;   
    }
    
    echo $seoBox23.$sepUnique.$seoBox24;
    
    die();
}

//Mobile Compatibility
if(isset($_POST['mobileCom'])){
    
    $mobileCom_Msg = $lang['AN197'];
    $mobileComMsg = $mobileComClass = '';
    $mobileComCheck = false;

    if (!empty($domData)) {
        $domContent = $domData->find('iframe');
        if (!empty($domContent)) {
            foreach ($domContent as $iframe)
                $mobileComCheck = true;
        }

        $domContent = $domData->find('object');
        if (!empty($domContent)) {
            foreach ($domContent as $embedded)
                $mobileComCheck = true;
        }

        $domContent = $domData->find('embed');
        if (!empty($domContent)) {
            foreach ($domContent as $embedded)
                $mobileComCheck = true;
        }
    }

    updateToDbPrepared($con, 'domains_data', array('mobile_com'=> $mobileComCheck), array('domain' => $domainStr));

    if($mobileComCheck){
        $mobileComClass = 'errorBox';
        $mobileComMsg = $lang['AN121'];
    }else{
        $mobileComClass = 'passedBox';
        $mobileComMsg = $lang['AN120'];
    }
   
    //Clean up memory
    $domData = null;
    
     if(!isset($_SESSION['twebUsername'])){
        if(!isAllowedStats($con,'seoBox25')){
            die($seoBoxLogin);
        }
    }
    
    echo '<div class="'.$mobileComClass.'">
    <div class="msgBox">       
         '.$mobileComMsg.'
        <br /><br />
    </div>
    <div class="seoBox25 suggestionBox">
    '.$mobileCom_Msg.'
    </div> 
    </div>';
    die();
}

//URL Length & Favicon
if(isset($_POST['urlLength'])){
    
    $favIconMsg = $urlLengthMsg = '';
    $favIconClass = 'lowImpactBox';
    $urlLength_Msg = $lang['AN198'];
    $favIcon_Msg = $lang['AN199'];
    
    $hostWord = explode('.',$my_url_host);
    
    if(strlen($hostWord[0]) < 15){
        $urlLengthClass = 'passedBox';
    }else{
        $urlLengthClass = 'errorBox';
    }
    $urlLengthMsg = $my_url .'<br>'.str_replace('[count]',strlen($hostWord[0]),$lang['AN122']);
    $favIconMsg = '<img src="https://www.google.com/s2/favicons?domain='.$my_url.'" alt="FavIcon" />  '.$lang['AN123'];
    
    echo '<div class="'.$urlLengthClass.'">
    <div class="msgBox">       
         '.$urlLengthMsg.'
        <br /><br />
    </div>
    <div class="seoBox26 suggestionBox">
    '.$urlLength_Msg.'
    </div> 
    </div>';
    
    echo $sepUnique; //Separate
    
    echo '<div class="'.$favIconClass.'">
    <div class="msgBox">       
        '.$favIconMsg.'
        <br /><br />
    </div>
    <div class="seoBox27 suggestionBox">
    '.$favIcon_Msg.'
    </div> 
    </div>';
    
    die();
}

//Custom 404 Page Checker
if(isset($_POST['errorPage'])){
    
    $errorPage_Msg = $lang['AN200'];
    $errorPageMsg = $errorPageClass = '';
    $errorPageCheck = false;
    $pageSize = strlen(curlGET($my_url.'/404error-test-page-by-atoz-seo-tools'));
    
    $updateStr = base64_encode($pageSize);
    updateToDbPrepared($con, 'domains_data', array('404_page'=> $updateStr), array('domain' => $domainStr));    
    
    if($pageSize < 1500){
        //Default Error Page
        $errorPageCheck = false;
        $errorPageClass = 'errorBox';
        $errorPageMsg = $lang['AN125'];
    }else{
       //Custom Error Page 
       $errorPageCheck = true;
       $errorPageClass = 'passedBox';
       $errorPageMsg = $lang['AN124'];
    }
    
     if(!isset($_SESSION['twebUsername'])){
        if(!isAllowedStats($con,'seoBox28')){
            die($seoBoxLogin);
        }
    }
    
    echo '<div class="'.$errorPageClass.'">
    <div class="msgBox">       
         '.$errorPageMsg.'
        <br /><br />
    </div>
    <div class="seoBox28 suggestionBox">
    '.$errorPage_Msg.'
    </div> 
    </div>';
    die();
}

//Page Size / Load Time / Language
if(isset($_POST['pageLoad'])){
    
    $size_Msg = $lang['AN201'];
    $load_Msg = $lang['AN202'];
    $lang_Msg = $lang['AN203'];
    
    $sizeMsg = $loadMsg = $langMsg = '';
    $langCode = null;
    
    $timeStart = microtime(true);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $my_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:36.0) Gecko/20100101 Firefox/36.0');
    curl_setopt($ch, CURLOPT_REFERER, $my_url);
    $html = curl_exec($ch);
    curl_close($ch);
    $timeEnd = microtime(true);
    $timeTaken = $timeEnd - $timeStart;
    $dataSize = strlen($html);

  		
    $patternCode = '<html[^>]+lang=[\'"]?(.*?)[\'"]?[\/\s>]';
	preg_match("#{$patternCode}#is", $html, $matches);
	if(isset($matches[1])) {
	  $langCode = Trim(mb_substr($matches[1], 0, 5));
	}else{
		$patternCode = '<meta[^>]+http-equiv=[\'"]?content-language[\'"]?[^>]+content=[\'"]?(.*?)[\'"]?[\/\s>]';
		preg_match("#{$patternCode}#is", $html, $matches);
		$langCode = isset($matches[1]) ? Trim(mb_substr($matches[1], 0, 5)) : null;
    }
    
    $updateStr = serBase(array($timeTaken,$dataSize,$langCode));
    updateToDbPrepared($con, 'domains_data', array('load_time'=> $updateStr), array('domain' => $domainStr));
  
    $dataSize = size_as_kb($dataSize);
    if($dataSize < 320){
        $sizeClass = 'passedBox'; 
    }else{
        $sizeClass = 'errorBox'; 
    }

    $sizeMsg = str_replace('[size]',$dataSize,$lang['AN126']);

    $timeTaken = round($timeTaken,2);
  
    if($timeTaken < 1){
        $loadClass = 'passedBox'; 
    }else{
        $loadClass = 'errorBox';
    }
    $loadMsg = str_replace('[time]',$timeTaken,$lang['AN127']);

    if($langCode == null){
        //Error 
        $langClass = 'errorBox';
        $langMsg.= $lang['AN129'] . '<br>';
    }else{
        //Passed
        $langClass = 'passedBox';
        $langMsg.= $lang['AN128'] . '<br>';
    }
    $langCode  = lang_code_to_lnag($langCode);
    $langMsg.= str_replace('[language]',$langCode,$lang['AN130']);
    
    $seoBox29 = '<div class="'.$sizeClass.'">
    <div class="msgBox">       
         '.$sizeMsg.'
        <br /><br />
    </div>
    <div class="seoBox29 suggestionBox">
    '.$size_Msg.'
    </div> 
    </div>';
        
    $seoBox30 = '<div class="'.$loadClass.'">
    <div class="msgBox">       
         '.$loadMsg.'
        <br /><br />
    </div>
    <div class="seoBox30 suggestionBox">
    '.$load_Msg.'
    </div> 
    </div>';
    
    $seoBox31 = '<div class="'.$langClass.'">
    <div class="msgBox">       
         '.$langMsg.'
        <br /><br />
    </div>
    <div class="seoBox31 suggestionBox">
    '.$lang_Msg.'
    </div> 
    </div>';
    
     if(!isset($_SESSION['twebUsername'])){
        if(!isAllowedStats($con,'seoBox29'))
            $seoBox29 = $seoBoxLogin;
        if(!isAllowedStats($con,'seoBox30'))
            $seoBox30 = $seoBoxLogin;
        if(!isAllowedStats($con,'seoBox31'))
            $seoBox31 = $seoBoxLogin;
    }
    
    echo $seoBox29.$sepUnique.$seoBox30.$sepUnique.$seoBox31;
    
    die();
}

//Domain & Typo Availability Checker
if(isset($_POST['availabilityChecker'])){
    
    $domain_Msg = $lang['AN204'];
    $typo_Msg = $lang['AN205'] ;
    $typoMsg = $domainMsg = '';
    $typoClass = $domainClass = 'lowImpactBox';
    
    $doArr = $tyArr = array();
    
    //Server List Path
    $path = LIB_DIR.'domainAvailabilityservers.tdata';
            
    if (file_exists($path)) {
        $contents = file_get_contents($path);
        $serverList = json_decode($contents, true);
    }
    $tldCodes = array('com','net','org','biz','us','info','eu');
    $domainWord = explode('.',$my_url_host);
    $hostTLD = Trim(end($domainWord));
    $domainWord = $domainWord[0];
    $tldCount = 0;
    foreach($tldCodes as $tldCode){
        if($tldCount == 5)
            break;
        if($tldCode != $hostTLD){
            $topDomain = $domainWord.'.'.$tldCode;
            //Get the status of domain name
            $domainAvailabilityChecker = new domainAvailability($serverList);
            $domainAvailabilityStats = $domainAvailabilityChecker->isAvailable($topDomain);
            $doArr[] = array($topDomain,$domainAvailabilityStats);
            //Response Code - Reason
            //2 - Domain is already taken!
            //3 - Domain is available
            //4 - No WHOIS entry was found for that TLD
            //5 - WHOIS Query failed
            if($domainAvailabilityStats=='2')
                $domainStatsMsg = $lang['AN132'];
            elseif($domainAvailabilityStats=='3')
                $domainStatsMsg = $lang['AN131'];
            else
                 $domainStatsMsg = $lang['AN133'];
            
           $domainMsg.= '<tr> <td>'.$topDomain.'</td> <td>'.$domainStatsMsg.'</td> </tr>';
           $tldCount++; 
        }
    }
    
    $typo = new typos();
    $domainTypoWords = $typo->get($domainWord);
    
    $typoCount = 0;
    foreach($domainTypoWords as $domainTypoWord){
        if($typoCount == 5)
            break;
        $topDomain = $domainTypoWord.'.'.$hostTLD;
        //Get the status of domain name
        $domainAvailabilityChecker = new domainAvailability($serverList);
        $domainAvailabilityStats = $domainAvailabilityChecker->isAvailable($topDomain);
        $tyArr[] = array($topDomain,$domainAvailabilityStats);
        //Response Code - Reason
        //2 - Domain is already taken!
        //3 - Domain is available
        //4 - No WHOIS entry was found for that TLD
        //5 - WHOIS Query failed
        if($domainAvailabilityStats=='2')
            $domainStatsMsg = $lang['AN132'];
        elseif($domainAvailabilityStats=='3')
            $domainStatsMsg = $lang['AN131'];
        else
             $domainStatsMsg = $lang['AN133'];
        
       $typoMsg.= '<tr> <td>'.$topDomain.'</td> <td>'.$domainStatsMsg.'</td> </tr>';
       $typoCount++; 
    }
    
    $updateStr = serBase(array($doArr,$tyArr));
    updateToDbPrepared($con, 'domains_data', array('domain_typo'=> $updateStr), array('domain' => $domainStr));
    
    $seoBox32 = '<div class="'.$domainClass.'">
    <div class="msgBox"> 
        <table class="table table-hover table-bordered table-striped">
            <tbody>
                <tr> <th>'.$lang['AN134'].'</th> <th>'.$lang['AN135'].'</th> </tr> 
                '.$domainMsg.'
            </tbody>
        </table>
        <br />
    </div>
    <div class="seoBox32 suggestionBox">
    '.$domain_Msg.'
    </div> 
    </div>';
    
    $seoBox33 = '<div class="'.$typoClass.'">
    <div class="msgBox"> 
        <table class="table table-hover table-bordered table-striped">
            <tbody>
                <tr> <th>'.$lang['AN134'].'</th> <th>'.$lang['AN135'].'</th> </tr> 
                '.$typoMsg.'
            </tbody>
        </table>
        <br />
    </div>
    <div class="seoBox33 suggestionBox">
    '.$typo_Msg.'
    </div> 
    </div>';
    
     if(!isset($_SESSION['twebUsername'])){
        if(!isAllowedStats($con,'seoBox32'))
            $seoBox32 = $seoBoxLogin;
        if(!isAllowedStats($con,'seoBox33'))
            $seoBox33 = $seoBoxLogin;
    }
    
    echo $seoBox32.$sepUnique.$seoBox33;
    
    die();
}

//Email Privacy
if(isset($_POST['emailPrivacy'])){
    
    $emailPrivacy_Msg = $lang['AN206'];
    $emailPrivacyMsg = $emailPrivacyClass = '';

    preg_match_all("/([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6})/", $sourceData, $matches,PREG_SET_ORDER);
    
    $emailCount = count($matches);
    
    updateToDbPrepared($con, 'domains_data', array('email_privacy'=> $emailCount), array('domain' => $domainStr));
 
    if($emailCount == 0){
        //No Email
        $emailPrivacyClass = 'passedBox';
        $emailPrivacyMsg = $lang['AN136'];
    }else{
        //Emails Found
        $emailPrivacyClass = 'errorBox';
        $emailPrivacyMsg = $lang['AN137'];
    }
    
     if(!isset($_SESSION['twebUsername'])){
        if(!isAllowedStats($con,'seoBox34')){
            die($seoBoxLogin);
        }
    }   
           
    echo '<div class="'.$emailPrivacyClass.'">
    <div class="msgBox">       
         '.$emailPrivacyMsg.'
        <br /><br />
    </div>
    <div class="seoBox34 suggestionBox">
    '.$emailPrivacy_Msg.'
    </div> 
    </div>';
    die();
}

//Safe Browsing
if(isset($_POST['safeBrowsing'])){
    
    $safeBrowsing_Msg = $lang['AN207'];
    $safeBrowsingMsg = $safeBrowsingClass = '';
    
    $safeBrowsingStats = safeBrowsing($my_url_host);
    //204 The website is not blacklisted 
    //200 The website is blacklisted
    //501 Something went wrong
    
    updateToDbPrepared($con, 'domains_data', array('safe_bro'=> $safeBrowsingStats), array('domain' => $domainStr));
    
    if($safeBrowsingStats == 204){
        $safeBrowsingMsg = $lang['AN138'];
        $safeBrowsingClass = 'passedBox';
    }elseif($safeBrowsingStats == 200){
        $safeBrowsingMsg = $lang['AN139'];
        $safeBrowsingClass = 'errorBox';
    }else{
        $safeBrowsingMsg = $lang['AN140'];
        $safeBrowsingClass = 'improveBox';
    } 
    
     if(!isset($_SESSION['twebUsername'])){
        if(!isAllowedStats($con,'seoBox35')){
            die($seoBoxLogin);
        }
    }
    
    echo '<div class="'.$safeBrowsingClass.'">
    <div class="msgBox">       
         '.$safeBrowsingMsg.'
        <br /><br />
    </div>
    <div class="seoBox35 suggestionBox">
    '.$safeBrowsing_Msg.'
    </div> 
    </div>';
    die();
}

//Server Location Information
if(isset($_POST['serverIP'])){
    
    $serverIP_Msg = $lang['AN208'];
    $serverIPClass = 'lowImpactBox';
    
    $getHostIP = gethostbyname($my_url_host);
    $data_list = host_info($my_url_host);
    
    $updateStr = serBase($data_list);
    updateToDbPrepared($con, 'domains_data', array('server_loc'=> $updateStr), array('domain' => $domainStr));

    $domain_ip = $data_list[0];
    $domain_country =  $data_list[1];
    $domain_isp = $data_list[2];
    
     if(!isset($_SESSION['twebUsername'])){
        if(!isAllowedStats($con,'seoBox36')){
            die($seoBoxLogin);
        }
    }   
             
    echo '<div class="'.$serverIPClass.'">
    <div class="msgBox">   
        <table class="table table-hover table-bordered table-striped">
            <tbody>
                <tr> 
                    <th>'.$lang['AN141'].'</th> 
                    <th>'.$lang['AN142'].'</th>
                    <th>'.$lang['AN143'].'</th>
                </tr> 
                <tr> 
                    <td>'.$getHostIP.'</td> 
                    <td>'.$domain_country.'</td>
                    <td>'.$domain_isp.'</td>
                </tr> 
            </tbody>
        </table>
        <br />
    </div>
    <div class="seoBox36 suggestionBox">
    '.$serverIP_Msg.'
    </div> 
    </div>';
    die();
}

//Speed Tips
if(isset($_POST['speedTips'])){
    
    $speedTips_Msg = $lang['AN209'];
    $speedTipsMsg = $speedTipsBody = '';    
    $speedTipsCheck = $cssCount = $jsCount = 0;
    
    //JS/CSS/Table Pattern Code
    $cssTagPatternCode = '<link[^>]*>';
    $cssPatternCode = '(?=.*\bstylesheet\b)(?=.*\bhref=("[^"]*"|\'[^\']*\')).*';
   	$jsTagPatternCode = '<script[^>]*>';
    $jsPatternCode = 'src=("[^"]*"|\'[^\']*\')';
    $tablePatternCode = "<(td|th)(?:[^>]*)>(.*?)<table(?:[^>]*)>(.*?)</table(?:[^>]*)>(.*?)</(td|th)(?:[^>]*)>";
    $inlineCssPatternCode = "<(.+)style=\"[^\"].+\"[^>]*>(.*?)<\/[^>]*>";
   
    //Parse CSS Count
    preg_match_all("#{$cssTagPatternCode}#is", $sourceData, $matches);
    if(!isset($matches[0]))
        $cssCount = 0;
    else{
    foreach($matches[0] as $tagVal) {
    if(preg_match("#{$cssPatternCode}#is", $tagVal))
        $cssCount++;
    }
    }
            
    //Parse JS Count
    preg_match_all("#{$jsTagPatternCode}#is", $sourceData, $matches);
    if(!isset($matches[0]))
    	$jsCount = 0;
    else{
    foreach($matches[0] as $tagVal) {
    	if(preg_match("#{$jsPatternCode}#is", $tagVal))
    		$jsCount++;
    }
    }
       
    //Nested Tables
    $nestedTables = preg_match("#{$tablePatternCode}#is", $sourceData);
   	
    //Inline CSS
    $inlineCss	= preg_match("#{$inlineCssPatternCode}#is", $sourceData);
    
    $updateStr = serBase(array($cssCount,$jsCount,$nestedTables,$inlineCss));
    updateToDbPrepared($con, 'domains_data', array('speed_tips'=> $updateStr), array('domain' => $domainStr));
    
    $speedTipsBody.= '<br>';
    
    if($cssCount > 5){
        $speedTipsCheck++;
        $speedTipsBody.=  $false . ' ' . $lang['AN145'];
    }else
        $speedTipsBody.=  $true . ' ' . $lang['AN144'];
    
    $speedTipsBody.= '<br><br>';
        
    if($jsCount > 5){
        $speedTipsCheck++;
        $speedTipsBody.=  $false . ' ' . $lang['AN147'];
    }else
        $speedTipsBody.=  $true . ' ' . $lang['AN146'];
        
    $speedTipsBody.= '<br><br>';
    
    if($nestedTables == 1){
        $speedTipsCheck++;
        $speedTipsBody.=  $false . ' ' . $lang['AN149'];
    }else
        $speedTipsBody.=  $true . ' ' . $lang['AN148'];
    
    $speedTipsBody.= '<br><br>';    
    
    if($inlineCss == 1){
        $speedTipsCheck++;
        $speedTipsBody.=  $false . ' ' . $lang['AN151'];
    }else
        $speedTipsBody.=  $true . ' ' . $lang['AN150'];
   
    if($speedTipsCheck == 0)
           $speedTipsClass = 'passedBox';
    elseif($speedTipsCheck > 2) 
           $speedTipsClass = 'errorBox';
    else
           $speedTipsClass = 'improveBox';
    
    $speedTipsMsg = $lang['AN152'];
    
     if(!isset($_SESSION['twebUsername'])){
        if(!isAllowedStats($con,'seoBox37')){
            die($seoBoxLogin);
        }
    }
                
    echo '<div class="'.$speedTipsClass.'">
    <div class="msgBox">       
        '.$speedTipsMsg.'
        <br />
        <div class="altImgGroup">
            '.$speedTipsBody.'
        </div>
        <br />
    </div>
    <div class="seoBox37 suggestionBox">
    '.$speedTips_Msg.'
    </div> 
    </div>';
    die();
}

//Analytics & Doc Type
if(isset($_POST['docType'])){
    
    $docType_Msg = $lang['AN212'];
    $analytics_Msg = $lang['AN210'];
    $docType = $analyticsClass = $analyticsMsg = $docTypeClass = $docTypeMsg = '';   
    $anCheck = false;
    $docCheck = false;
    
    $doctypes = array(
		'HTML 5' => '<!DOCTYPE html>',
		'HTML 4.01 Strict' => '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">',
		'HTML 4.01 Transitional' => '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">',
		'HTML 4.01 Frameset' => '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">',
		'XHTML 1.0 Strict' => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">',
		'XHTML 1.0 Transitional' => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">',
		'XHTML 1.0 Frameset' => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">',
		'XHTML 1.1' => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">',
	);
    
   	if (preg_match("/\bua-\d{4,9}-\d{1,4}\b/i", $sourceData)){
   	    //Found
        $analyticsClass = 'passedBox';
        $analyticsMsg = $lang['AN154'];
        $anCheck = true;
    }else{
        ///Not Found
        $analyticsClass = 'errorBox';
        $analyticsMsg = $lang['AN153'];
    }

    $patternCode = "<!DOCTYPE[^>]*>";
    preg_match("#{$patternCode}#is", $sourceData, $matches);
    if(!isset($matches[0])){
	   $docTypeMsg = $lang['AN155'];
       $docTypeClass = 'improveBox';
    }else{
        $docType = array_search(strtolower(preg_replace('/\s+/', ' ', Trim($matches[0]))), array_map('strtolower', $doctypes));
        $docTypeMsg = $lang['AN156'] . ' ' . $docType;
        $docTypeClass = 'passedBox';
        $docCheck = true;
    }
    
    $updateStr = serBase(array($anCheck,$docCheck,$docType));
    updateToDbPrepared($con, 'domains_data', array('analytics'=> $updateStr), array('domain' => $domainStr));
    
    $seoBox38 = '<div class="'.$analyticsClass.'">
    <div class="msgBox">
        '.$analyticsMsg.'
        <br /><br />
    </div>
    <div class="seoBox38 suggestionBox">
    '.$analytics_Msg.'
    </div> 
    </div>';
                 
    $seoBox40 = '<div class="'.$docTypeClass.'">
    <div class="msgBox">
        '.$docTypeMsg.'
        <br /><br />
    </div>
    <div class="seoBox40 suggestionBox">
    '.$docType_Msg.'
    </div> 
    </div>';
    
     if(!isset($_SESSION['twebUsername'])){
        if(!isAllowedStats($con,'seoBox38'))
            $seoBox38 = $seoBoxLogin;
        if(!isAllowedStats($con,'seoBox40'))
            $seoBox40 = $seoBoxLogin;
    }
    
    echo $seoBox38.$sepUnique.$seoBox40;
    
    die();
}

//W3C Validity
if(isset($_POST['w3c'])){
    
    $w3c_Msg = $lang['AN211'];
    $w3Data = $w3cMsg = '';
    $w3cClass = 'lowImpactBox';
    $w3DataCheck = 0;
    
    $w3Data = curlGET('https://validator.w3.org/nu/?doc=http%3A%2F%2F'.$my_url_host.'%2F');
    if($w3Data != ''){
    if(check_str_contains($w3Data,'document validates')){
        //Valid
        $w3cMsg = $lang['AN157'];
        $w3DataCheck = '1';
    }else{
        //Not Valid
       $w3cMsg = $lang['AN158'];
       $w3DataCheck = '2';
    }
    }else{
        //Error
        $w3cMsg = $lang['AN10'];  
        $w3DataCheck = '3';
    }
    
    updateToDbPrepared($con, 'domains_data', array('w3c'=> $w3DataCheck), array('domain' => $domainStr));
   
     if(!isset($_SESSION['twebUsername'])){
        if(!isAllowedStats($con,'seoBox39')){
            die($seoBoxLogin);
        }
    }
        
    echo '<div class="'.$w3cClass.'">
    <div class="msgBox">       
         '.$w3cMsg.'
        <br /><br />
    </div>
    <div class="seoBox39 suggestionBox">
    '.$w3c_Msg.'
    </div> 
    </div>';
    die();
}

//Encoding Type
if(isset($_POST['encoding'])){
    
    $encoding_Msg = $lang['AN213'];
    $encodingMsg = $encodingClass = '';
    $charterSet = null;
    
    $charterSetPattern = '<meta[^>]+charset=[\'"]?(.*?)[\'"]?[\/\s>]';
    preg_match("#{$charterSetPattern}#is", $sourceData, $matches);
   
    if(isset($matches[1])) 
        $charterSet = Trim(mb_strtoupper($matches[1]));
    if($charterSet!=null){
        $encodingClass = 'passedBox';
        $encodingMsg = $lang['AN159'] . ' '. $charterSet;
    }
    else{ 
        $encodingClass = 'errorBox';
        $encodingMsg = $lang['AN160'];
    }
    
    $updateStr = base64_encode($charterSet);
    updateToDbPrepared($con, 'domains_data', array('encoding'=> $updateStr), array('domain' => $domainStr));
    
     if(!isset($_SESSION['twebUsername'])){
        if(!isAllowedStats($con,'seoBox41')){
            die($seoBoxLogin);
        }
    }
          
    echo '<div class="'.$encodingClass.'">
    <div class="msgBox">       
         '.$encodingMsg.'
        <br /><br />
    </div>
    <div class="seoBox41 suggestionBox">
    '.$encoding_Msg.'
    </div> 
    </div>';
    die();
}

//Indexed Pages
if(isset($_POST['indexedPages'])){
    
    $indexedPages_Msg = $lang['AN214'];
    $indexProgress = $indexedPagesMsg = $indexedPagesClass = '';
    $datVal = $outData = 0;
    
    $outData = Trim(str_replace(',','',googleIndex($my_url_host)));
    
    if(intval($outData) < 50){
        $datVal = 25;
        $indexedPagesClass = 'errorBox';
        $indexProgress = 'danger';
    }elseif(intval($outData) < 200){
        $datVal = 75;
        $indexedPagesClass = 'improveBox';
        $indexProgress = 'warning';
    }else{
        $datVal = 100;
        $indexedPagesClass = 'passedBox';
        $indexProgress = 'success';
    }
    
    $updateStr = base64_encode($outData);
    updateToDbPrepared($con, 'domains_data', array('indexed'=> $updateStr), array('domain' => $domainStr));
  
    $indexedPagesMsg = '<div style="width:'.$datVal.'%" aria-valuemax="'.$datVal.'" aria-valuemin="0" aria-valuenow="'.$datVal.'" role="progressbar" class="progress-bar progress-bar-'.$indexProgress.'">
        '.number_format($outData).' '.$lang['AN162'].'
    </div>';
    
     if(!isset($_SESSION['twebUsername'])){
        if(!isAllowedStats($con,'seoBox42')){
            die($seoBoxLogin);
        }
    }
        
    echo '<div class="'.$indexedPagesClass.'">
    <div class="msgBox">    
        '.$lang['AN161'].'<br />   <br /> 
         <div class="progress">
            '.$indexedPagesMsg.'
         </div>
        <br />
    </div>
    <div class="seoBox42 suggestionBox">
    '.$indexedPages_Msg.'
    </div> 
    </div>';
    die();
}

//Backlink Counter / Traffic / Worth
if(isset($_POST['backlinks'])){
    
    $backlinks_Msg = $lang['AN215'];
    $alexa_Msg =  $lang['AN218'];
    $worth_Msg =  $lang['AN217'];
    $alexaMsg = $worthMsg = $backProgress = $backlinksMsg = $backlinksClass = '';
    $alexaClass = $worthClass = 'lowImpactBox';
    
    $alexa = alexaRank($my_url_host);
    
    $updateStr = serBase(array((string)$alexa[0],(string)$alexa[1],(string)$alexa[2],(string)$alexa[3]));
    updateToDbPrepared($con, 'domains_data', array('alexa'=> $updateStr), array('domain' => $domainStr));

    $alexa_rank = $alexa[0];
    $alexa_pop = $alexa[1];
    $regional_rank = $alexa[2];    
    $alexa_back = Trim(str_replace(',','',$alexa[3]));
    
    if(intval($alexa_back) < 50){
        $datVal = 25;
        $backlinksClass = 'errorBox';
        $backProgress = 'danger';
    }elseif(intval($alexa_back) < 100){
        $datVal = 75;
        $backlinksClass = 'improveBox';
        $backProgress = 'warning';
    }else{
        $datVal = 100;
        $backlinksClass = 'passedBox';
        $backProgress = 'success';
    }
    
    $backlinksMsg = '<div style="width:'.$datVal.'%" aria-valuemax="'.$datVal.'" aria-valuemin="0" aria-valuenow="'.$datVal.'" role="progressbar" class="progress-bar progress-bar-'.$backProgress.'">
        '.number_format($alexa_back).' '.$lang['AN163'].'
    </div>';
    
    if($alexa_rank == 'No Global Rank')
        $alexaMsg = $lang['AN165'];
    else
        $alexaMsg = ordinalNum(str_replace(',','',$alexa_rank)) . ' '. $lang['AN164'];
    
    $alexa_rank = ($alexa_rank == 'No Global Rank' ? '0' : $alexa_rank);
    $worthMsg = "$". number_format(calPrice($alexa_rank))." USD";
            
    $seoBox43 = '<div class="'.$backlinksClass.'">
    <div class="msgBox">     
        '.$lang['AN166'].'<br />   <br /> 
         <div class="progress">  
         '.$backlinksMsg.'
         </div>
         <br />
    </div>
    <div class="seoBox43 suggestionBox">
    '.$backlinks_Msg.'
    </div> 
    </div>';
        
    $seoBox45 = '<div class="'.$worthClass.'">
    <div class="msgBox">       
         '.$worthMsg.'
        <br /><br />
    </div>
    <div class="seoBox45 suggestionBox">
    '.$worth_Msg.'
    </div> 
    </div>';
        
    $seoBox46 = '<div class="'.$alexaClass.'">
    <div class="msgBox">       
         '.$alexaMsg.'
        <br /><br />
    </div>
    <div class="seoBox46 suggestionBox">
    '.$alexa_Msg.'
    </div> 
    </div>';
    
     if(!isset($_SESSION['twebUsername'])){
        if(!isAllowedStats($con,'seoBox43'))
            $seoBox43 = $seoBoxLogin;
        if(!isAllowedStats($con,'seoBox45'))
            $seoBox45 = $seoBoxLogin;
        if(!isAllowedStats($con,'seoBox46'))
            $seoBox46 = $seoBoxLogin;
    }
    
    echo $seoBox43.$sepUnique.$seoBox45.$sepUnique.$seoBox46;
    
    die();
}

//Social Data
if(isset($_POST['socialData'])){
    
    $social_Msg = $lang['AN216'];
    $socialMsg = '';
    $socialClass = 'lowImpactBox';

    $socialData = getSocialData($sourceData);

    $facebook_like = $socialData['fb'];
    $twit_count = $socialData['twit'];
    $insta_count = $socialData['insta'];
    $stumble_count = 0;
    $socialMsg = $lang['AN167'];

    $updateStr = serBase(array($facebook_like,$twit_count,$insta_count,$stumble_count));
    updateToDbPrepared($con, 'domains_data', array('social'=> $updateStr), array('domain' => $domainStr));

     if(!isset($_SESSION['twebUsername'])){
        if(!isAllowedStats($con,'seoBox44')){
            die($seoBoxLogin);
        }
    }

    if($facebook_like === '-')
        $facebook_like = $false;
    else
        $facebook_like = $true.' '.$facebook_like;

    if($twit_count === '-')
        $twit_count = $false;
    else
        $twit_count = $true.' '.$twit_count;

    if($insta_count === '-')
        $insta_count = $false;
    else
        $insta_count = $true.' '.$insta_count;

    echo '<div class="'.$socialClass.'">
    <div class="msgBox">   
            '.$socialMsg.'
        <br />
        <div class="altImgGroup">
            <br><div class="social-box"><i class="fa fa-facebook social-facebook"></i> Facebook: '.$facebook_like.'</div><br>
            <div class="social-box"><i class="fa fa-twitter social-linkedin"></i> Twitter: '.$twit_count.' </div><br>
            <div class="social-box"><i class="fa fa-instagram social-google"></i> Instagram: '.$insta_count.'</div>
        </div>
        <br />
    </div>
    <div class="seoBox44 suggestionBox">
    '.$social_Msg.'
    </div> 
    </div>';
    die();
}

//Visitors Localization
if(isset($_POST['visitorsData'])){
    
    $visitors_Msg = $lang['AN219'];
    $visitorsMsg = '';
    $visitorsClass = 'lowImpactBox';
    
    $alexaDatas = alexaExtended($my_url_host);
    
    $updateStr = serBase($alexaDatas);
    updateToDbPrepared($con, 'domains_data', array('visitors_loc'=> $updateStr), array('domain' => $domainStr));
  
    $alexaDataCount = count($alexaDatas);
    
    foreach($alexaDatas as $alexaData)
        $visitorsMsg.='<tr><td>'.$alexaData[1].'</td><td>'.$alexaData[2].'</td><tr>';
    
     if(!isset($_SESSION['twebUsername'])){
        if(!isAllowedStats($con,'seoBox47')){
            die($seoBoxLogin);
        }
    }
    
    echo '<div class="'.$visitorsClass.'">
    <div class="msgBox">   
        '.$lang['AN171'] .'<br /><br />
        '.(($alexaDataCount != 0)? '
        <table class="table table-hover table-bordered table-striped">
            <tbody>
                <tr> 
                    <th>'.$lang['AN168'].'</th> 
                    <th>'.$lang['AN169'].'</th>
                </tr>
                '.$visitorsMsg.'
            </tbody>
        </table>' : $lang['AN170']).'
        <br />
    </div>
    <div class="seoBox47 suggestionBox">
    '.$visitors_Msg.'
    </div> 
    </div>';
    die();
}

//Page Speed Insight Checker
if(isset($_POST['pageSpeedInsightChecker'])){

    $pageSpeedInsightDesktop_Msg = $lang['AN220'];
    $pageSpeedInsightMobile_Msg = $lang['AN221'];
    $desktopMsg = $mobileMsg = $pageSpeedInsightData = $seoBox48 = $seoBox49 = '';
    $desktopClass = $mobileClass = $desktopSpeed = $mobileSpeed = '';
    $speedStr = $lang['117']; $mobileStr = $lang['119']; $desktopStr = $lang['118'];
    
    $desktopScore = pageSpeedInsightChecker($inputHost,'desktop');
    $mobileScore = pageSpeedInsightChecker($inputHost,'mobile');
    
    if(intval($desktopScore) < 50){
        $desktopClass = 'errorBox';
        $desktopSpeed = $lang['125'];
    }elseif(intval($desktopScore) < 79){
        $desktopClass = 'improveBox';
        $desktopSpeed = $lang['126'];
    }else{
        $desktopClass = 'passedBox';
        $desktopSpeed = $lang['124'];
    }
        
    if(intval($mobileScore) < 50){
        $mobileClass = 'errorBox';
        $mobileSpeed = $lang['125'];
    }elseif(intval($mobileScore) < 79){
        $mobileClass = 'improveBox';
        $mobileSpeed = $lang['126'];
    }else{
        $mobileClass = 'passedBox';
        $mobileSpeed = $lang['126'];
    }
    
    $pageSpeedInsightData = array($desktopScore, $mobileScore); 
       
    $updateStr = serBase($pageSpeedInsightData);
    updateToDbPrepared($con, 'domains_data', array('page_speed_insight'=> $updateStr), array('domain' => $domainStr));
    
$desktopMsg = <<< EOT
<script>var desktopPageSpeed = new Gauge({
	renderTo  : 'desktopPageSpeed',
	width     : 250,
	height    : 250,
	glow      : true,
	units     : '$speedStr',
    title       : '$desktopStr',
    minValue    : 0,
    maxValue    : 100,
    majorTicks  : ['0','20','40','60','80','100'],
    minorTicks  : 5,
    strokeTicks : true,
    valueFormat : {
        int : 2,
        dec : 0,
        text : '%'
    },
    valueBox: {
        rectStart: '#888',
        rectEnd: '#666',
        background: '#CFCFCF'
    },
    valueText: {
        foreground: '#CFCFCF'
    },
	highlights : [{
		from  : 0,
		to    : 40,
		color : '#EFEFEF'
	},{
		from  : 40,
		to    : 60,
		color : 'LightSalmon'
	}, {
		from  : 60,
		to    : 80,
		color : 'Khaki'
	}, {
		from  : 80,
		to    : 100,
		color : 'PaleGreen'
	}],
	animation : {
		delay : 10,
		duration: 300,
		fn : 'bounce'
	}
});

desktopPageSpeed.onready = function() {
    desktopPageSpeed.setValue($desktopScore);
};


desktopPageSpeed.draw();</script>
EOT;

$mobileMsg = <<< EOT
<script>var mobilePageSpeed = new Gauge({
	renderTo  : 'mobilePageSpeed',
	width     : 250,
	height    : 250,
	glow      : true,
	units     : '$speedStr',
    title       : '$mobileStr',
    minValue    : 0,
    maxValue    : 100,
    majorTicks  : ['0','20','40','60','80','100'],
    minorTicks  : 5,
    strokeTicks : true,
    valueFormat : {
        int : 2,
        dec : 0,
        text : '%'
    },
    valueBox: {
        rectStart: '#888',
        rectEnd: '#666',
        background: '#CFCFCF'
    },
    valueText: {
        foreground: '#CFCFCF'
    },
	highlights : [{
		from  : 0,
		to    : 40,
		color : '#EFEFEF'
	},{
		from  : 40,
		to    : 60,
		color : 'LightSalmon'
	}, {
		from  : 60,
		to    : 80,
		color : 'Khaki'
	}, {
		from  : 80,
		to    : 100,
		color : 'PaleGreen'
	}],
	animation : {
		delay : 10,
		duration: 300,
		fn : 'bounce'
	}
});

mobilePageSpeed.onready = function() {
    mobilePageSpeed.setValue($mobileScore);
};


mobilePageSpeed.draw();</script>
EOT;

    
    $seoBox48 = '<div class="'.$desktopClass.'">
    <div class="msgBox">
        <div class="row">
            <div class="col-sm-6 text-center">
                <canvas id="desktopPageSpeed"></canvas>
                '.$desktopMsg.'
            </div>
            <div class="col-sm-6">
            <h2>'.$desktopScore.' / 100</h2>
            <h4>'.$lang['123'].'</h4>
            <p><strong>'.ucfirst($my_url_host).'</strong> '.$lang['127'].' <strong>'.$desktopSpeed.'</strong>. '.$lang['128'].'</p>
            </div>
        </div>   
    </div>
    <div class="seoBox48 suggestionBox">
    '.$pageSpeedInsightDesktop_Msg.'
    </div> 
    </div>';
    
    $seoBox49 = '<div class="'.$mobileClass.'">
    <div class="msgBox">   
        <div class="row">
            <div class="col-sm-6 text-center">
                <canvas id="mobilePageSpeed"></canvas>
                '.$mobileMsg.'
            </div>
        <div class="col-sm-6">
            <h2>'.$mobileScore.' / 100</h2>
            <h4>'.$lang['123'].'</h4>
            <p><strong>'.ucfirst($my_url_host).'</strong> '.$lang['129'].' <strong>'.$mobileSpeed.'</strong>. '.$lang['128'].'</p>
        </div>
        </div>
    </div>
    <div class="seoBox49 suggestionBox">
    '.$pageSpeedInsightMobile_Msg.'
    </div> 
    </div>';
    
    if(!isset($_SESSION['twebUsername'])){
        if(!isAllowedStats($con,'seoBox48'))
            $seoBox48 = $seoBoxLogin;
        if(!isAllowedStats($con,'seoBox49'))
            $seoBox49 = $seoBoxLogin;
    }
    
    echo $seoBox48.$sepUnique.$seoBox49;
    
    die();
    
}

if(isset($_POST['cleanOut'])){
    $passscore = raino_trim($_POST['passscore']);
    $improvescore = raino_trim($_POST['improvescore']);
    $errorscore = raino_trim($_POST['errorscore']);
    
    $score = array($passscore,$improvescore,$errorscore);
    
    $updateStr = serBase($score);
    updateToDbPrepared($con, 'domains_data', array('score' => $updateStr, 'completed' => 'yes'), array('domain' => $domainStr));
   
    $data = mysqliPreparedQuery($con, "SELECT * FROM domains_data WHERE domain=?",'s',array($domainStr));
    if($data !== false){
        $pageSpeedInsightData = decSerBase($data['page_speed_insight']); 
        $alexa = decSerBase($data['alexa']);
        
        $finalScore = ($passscore == '') ? '0' : $passscore;
        $globalRank = ($alexa[0] == '') ? '0' : $alexa[0];
        $pageSpeed = ($pageSpeedInsightData[0] == '') ? '0' : $pageSpeedInsightData[0];
        
        //Username
        if(!isset($_SESSION['twebUsername']))
            $username = trans('Guest',$lang['11'],true);
        else
            $username = $_SESSION['twebUsername'];
        
        if($globalRank == 'No Global Rank')    
            $globalRank = 0;
            
        $other = serBase(array($finalScore,$globalRank,$pageSpeed));
        
        //Add the site into recent history
        addToRecentSites($con,$domainStr,$ip,$username,$other);
    }
    
    //Clear Cached Data
    delFile($filename);
}

} //End of Post Handler

//End of AJAX Handler
die();
?>