<?php
defined('DB_DOMAIN') or die(header('HTTP/1.1 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: KOVATZ Seo Tools
 * @copyright 2021 KOVATZ.COM
 *
 */

//Login Box
$seoBoxLogin = '<div class="lowImpactBox">
<div class="msgBox">   
        '.$lang['39'].'
        
    <br /><br /> <div class="altImgGroup"> <a class="btn btn-success forceLogin" target="_blank" href="'.createLink('account/login',true).'" title="'.$lang['40'].'"> '.$lang['40'].' </a></div><br />
</div>
</div>';


//First Domain
    
//Meta Data  
$metatitle = $metadescription = $metakeywords = $firstTitle = $firstDes = $firstKey = $firstDate = $secDate = '';
$meta_data = decSerBase($dataFirst['meta_data']);

$metatitle = $meta_data[0];
$metadescription = $meta_data[1];
$metakeywords = $meta_data[2];

$firstTitle = strtolower($metatitle);
$firstDes = strtolower($metadescription);
$firstKey = strtolower($metakeywords);

$lenTitle = mb_strlen($metatitle,'utf8');
$lenDes = mb_strlen($metadescription,'utf8');

//Check Empty Data
$site_title = ($metatitle == '' ? $lang['AN11'] : $metatitle);
$site_description = ($metadescription == '' ? $lang['AN12'] : $metadescription);
$site_keywords = ($metakeywords == '' ? $lang['AN15'] : $metakeywords);

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


$first_seoBox1 = '<div class="'.$classTitle.'">
<div class="msgBox bottom10">       
'.$site_title.'
<br />
<b>'.$lang['AN13'].':</b> '.$lenTitle.' '.$lang['AN14'].' 
</div>
<div class="seoBox1 suggestionBox">
'.$titleMsg.'
</div> 
</div>';


$first_seoBox2 = '<div class="'.$classDes.'">
<div class="msgBox padRight10 bottom10">       
'.$site_description.'
<br />
<b>'.$lang['AN13'].':</b> '.$lenDes.' '.$lang['AN14'].' 
</div>
<div class="seoBox2 suggestionBox">
'.$desMsg.'
</div> 
</div>';

$first_seoBox3 = '<div class="'.$classKey.'">
<div class="msgBox padRight10">       
'.$site_keywords.'
<br /><br />
</div>
<div class="seoBox3 suggestionBox">
'.$keyMsg.'
</div> 
</div>';


$first_seoBox5 = '<div class="'.$classKey.'">
<div class="msgBox">       
     <div class="googlePreview">
		<p>'.$site_title.'</p>
		<p><span class="bold">'.$firstHost.'</span>/</p>
		<p>'.$site_description.'</p>
    </div>
<br />
</div>
<div class="seoBox5 suggestionBox">
'.$googleMsg.'
</div> 
</div>';


//Heading Data 
$headings = decSerBase($dataFirst['headings']);

//Get H1 to H6 Tags
$tags = array ('h1', 'h2', 'h3', 'h4', 'h5', 'h6');
$h1Count = $h2Count = $h3Count = $h4Count = $h5Count = $h6Count = 0;
$elementListData = $headings[0];
$texts = $headings[1];
$hideCount = 0;
$hideClass = $headStr = '';

foreach($tags as $tag)
{
  if (isset($elementListData[$tag])) {
  foreach($elementListData[$tag] as $element)
  {
     if($hideCount == 3)
        $hideClass = 'hideTr hideTr1';
     $headStr.= '<tr class="'.$hideClass.'"> <td>&lt;'.$element[0].'&gt; <b>'.$element[1].'</b> &lt;/'.$element[0].'&gt;</td> </tr>';
     $hideCount++;
  }
  }
}

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

$first_seoBox4 = '<div class="'.$class.'">
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

//Image without Alt Tag
$image_alt = decSerBase($dataFirst['image_alt']);

$imageCount = $image_alt[0];
$imageWithOutAltTag = 0;
$hideClass = $imageWithOutAltTagData = '';
$imageMsg = $lang['AN178'];
$imgArr = $image_alt[2];

foreach($imgArr as $imgLink){
    if($imageWithOutAltTag == 3)
        $hideClass = 'hideTr hideTr2';
    $imageWithOutAltTagData .= '<tr class="'.$hideClass.'"> <td>'.$imgLink.'</td> </tr>';
    $imageWithOutAltTag++;
}

$imageWithOutAltTag = $image_alt[1];

if($imageWithOutAltTag == 0)
    $altClass = 'passedBox';
elseif($imageWithOutAltTag < 2)
    $altClass = 'improveBox';
else
    $altClass = 'errorBox';


$first_seoBox6 = '<div class="'.$altClass.'">
<div class="msgBox">       
    '.str_replace('[image-count]',$imageCount,$lang['AN21']).' <br />
    <div class="altImgGroup"> 
    '.(($imageWithOutAltTag == 0)? '
    <img src="'.$theme_path.'img/true.png" alt="'.$lang['AN24'].'" title="'.$lang['AN25'].'" /> '.$lang['AN27'].'</div><br />': ' 
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

//Keyword Cloud
$keywords_cloud = decSerBase($dataFirst['keywords_cloud']);
$outCount = $keywords_cloud[0];
$outArr = $keywords_cloud[1];
$keyData = '';
    
foreach($outArr as $outData){
    $keyData .= '<li><span class="keyword">'.$outData[0].'</span><span class="number">'.$outData[1].'</span></li>';
}
    
$keycloudClass = 'lowImpactBox';
$keyMsg = $lang['AN179'];

$first_seoBox7 = '<div class="'.$keycloudClass.'">
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

    
$hideClass = $keywordConsistencyTitle = $keywordConsistencyDes = $keywordConsistencyH = $keywordConsistencyData = '';

$hideCount = 1;
$keywordConsistencyScore = 0;

foreach($outArr as $outKey){
    if(check_str_contains($metatitle, $outKey[0], true)){
        $keywordConsistencyTitle = $true;
        $keywordConsistencyScore++;
    }else{
        $keywordConsistencyTitle = $false;
    }
   
    if(check_str_contains($metadescription, $outKey[0], true)){
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

$first_seoBox8 = '<div class="'.$keywordConsistencyClass.'">
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

//Text to HTML Ratio
$textRatio = decSerBase($dataFirst['ratio_data']);

if(round($textRatio[2]) < 2)
    $textClass = 'errorBox';
elseif(round($textRatio[2]) < 10)
    $textClass = 'improveBox';
else
    $textClass = 'passedBox';
    
$textMsg = $lang['AN181'];

$first_seoBox9 = '<div class="'.$textClass.'">
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

//Check GZIP Compression 
$gzipClass = $gzipHead = $gzipBody = '';
$outData = decSerBase($dataFirst['gzip']);
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

$gzipMsg = $lang['AN182'];
            
$first_seoBox10 = '<div class="'.$gzipClass.'">
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


//WWW Resolve
$resolve = decSerBase($dataFirst['resolve']);

$www_resolveMsg = $lang['AN183'];
$resolveClass = 'improveBox';
$resolveMsg = $lang['AN47'];
$re301 = false;
$url_with_www = "http://www.$firstHostLow";
$url_no_www = "http://$firstHostLow";

$dataFirst1 = $resolve[0];
$dataFirst2 = $resolve[1];


if(check_str_contains($dataFirst1,'301')){
    $re301 = true;
    $resolveClass = 'passedBox';
    $resolveMsg = $lang['AN46'];
}

if(check_str_contains($dataFirst2,'301')){
    $re301= true;
    $resolveClass = 'passedBox';
    $resolveMsg = $lang['AN46'];
}

$first_seoBox11 = '<div class="'.$resolveClass.'">
<div class="msgBox">       
     '.$resolveMsg.'
    <br />
    <br />
</div>
<div class="seoBox11 suggestionBox">
'.$www_resolveMsg.'
</div> 
</div>';


//IP Canonicalization
$ip_can = decSerBase($dataFirst['ip_can']);

$ip_canMsg = $lang['AN184'];
$ipClass = 'improveBox';
$hostIP = $ipMsg = '';
$tType = $ip_can[1];
$redirectURLhost = $ip_can[3];
$hostIP = $ip_can[0];

if($tType){
    if($firstHost == $redirectURLhost){
        $ipMsg = str_replace(array('[ip]','[host]'),array($hostIP,$firstHost),$lang['AN50']);
        $ipClass = 'passedBox';
    }else{
       $ipMsg = str_replace(array('[ip]','[host]'),array($hostIP,$firstHost),$lang['AN49']); 
    }
    $tType = true;
}else{
    $ipMsg = str_replace(array('[ip]','[host]'),array($hostIP,$firstHost),$lang['AN49']);
}

$first_seoBox12 = '<div class="'.$ipClass.'">
<div class="msgBox">       
     '.$ipMsg.'
    <br />
    <br />
</div>
<div class="seoBox12 suggestionBox">
'.$ip_canMsg.'
</div> 
</div>';


//In-Page Links analyser
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

$ex_data = decSerBase($dataFirst['links_analyser']);

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
            
    if ($myIntHost == $firstHostLow || $myIntHost == "www." . $firstHostLow) {
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
        $int_data[$i_links]['href'] = $first_url.$link['href'];
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
                $int_data[$i_links]['href'] = $first_url.'/'.$link['href'];
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
        $firstHostLow && $parse_urls['host'] != "www." . $firstHostLow) {
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
    
$first_seoBox13 = '<div class="'.$inPageClass.'">
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

$first_seoBox17 = '<div class="'.$urlRewritingClass.'">
<div class="msgBox">       
     '.$urlRewritingMsg.'
    <br />
    <br />
</div>
<div class="seoBox17 suggestionBox">
'.$url_RewritingMsg.'
</div> 
</div>';

$first_seoBox18 = '<div class="'.$linkUnderScoreClass.'">
<div class="msgBox">       
     '.$linkUnderScoreMsg.'
    <br />
    <br />
</div>
<div class="seoBox18 suggestionBox">
'.$link_UnderScoreMsg.'
</div> 
</div>';


//Broken Links
$bLinks = decSerBase($dataFirst['broken_links']);
$broken_Msg = $lang['AN186'];
$hideMe = $brokenMsg = $brokenClass = $brokenLinks = '';
$totalDataCount = 0;

foreach($bLinks as $bLink){
    
    if($totalDataCount == 3)
        $hideMe = 'hideTr hideTr5';
    $brokenLinks.= '<tr class="'.$hideMe.'"><td>'.$bLink.'</td></tr>';
    $totalDataCount++;
}

if($totalDataCount == 0){
    $brokenClass = 'passedBox';
    $brokenMsg = $lang['AN68'];
}else{
    $brokenClass = 'errorBox';
    $brokenMsg = $lang['AN69'];
}
    
$first_seoBox14 = '<div class="'.$brokenClass.'">
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


//Robots.txt Checker
$robot_Msg = $lang['AN187'];
$robotLink = $robotMsg = $robotClass = '';

$robotLink = $first_url .'/robots.txt';
$httpCode = base64_decode($dataFirst['robots']);

if($httpCode == '404'){
    $robotClass = 'errorBox';
    $robotMsg = $lang['AN74'] . '<br>' . '<a href="'.$robotLink.'" title="'.$lang['AN75'].'" rel="nofollow" target="_blank">'.$robotLink.'</a>';
}else{
    $robotClass = 'passedBox';
    $robotMsg = $lang['AN73'] . '<br>' . '<a href="'.$robotLink.'" title="'.$lang['AN75'].'" rel="nofollow" target="_blank">'.$robotLink.'</a>';
}

$first_seoBox16 = '<div class="'.$robotClass.'">
<div class="msgBox">       
     '.$robotMsg.'
    <br /><br />
</div>
<div class="seoBox16 suggestionBox">
'.$robot_Msg.'
</div> 
</div>';


//Sitemap Checker
$sitemap_Msg = $lang['AN188'];
$sitemapLink = $sitemapMsg = $sitemapClass = '';

$sitemapLink = $first_url .'/sitemap.xml';
$httpCode = base64_decode($dataFirst['sitemap']);

if($httpCode == '404'){
    $sitemapClass = 'errorBox';
    $sitemapMsg = $lang['AN71'] . '<br>' . '<a href="'.$sitemapLink.'" title="'.$lang['AN72'].'" rel="nofollow" target="_blank">'.$sitemapLink.'</a>';
}else{
    $sitemapClass = 'passedBox';
    $sitemapMsg = $lang['AN70'] . '<br>' . '<a href="'.$sitemapLink.'" title="'.$lang['AN72'].'" rel="nofollow" target="_blank">'.$sitemapLink.'</a>';
}

$first_seoBox15 = '<div class="'.$sitemapClass.'">
<div class="msgBox">       
     '.$sitemapMsg.'
    <br /><br />
</div>
<div class="seoBox15 suggestionBox">
'.$sitemap_Msg.'
</div> 
</div>';

//Embedded Object Check
$embedded_Msg = $lang['AN191'];
$embeddedMsg = $embeddedClass = '';
$embeddedCheck = false;

$embeddedCheck = filter_var($dataFirst['embedded'], FILTER_VALIDATE_BOOLEAN);

if($embeddedCheck){
    $embeddedClass = 'errorBox';
    $embeddedMsg = $lang['AN78'];
}else{
    $embeddedClass = 'passedBox';
    $embeddedMsg = $lang['AN77'];
}

$first_seoBox19 = '<div class="'.$embeddedClass.'">
<div class="msgBox">       
     '.$embeddedMsg.'
    <br /><br />
</div>
<div class="seoBox19 suggestionBox">
'.$embedded_Msg.'
</div> 
</div>';

//iframe Check
$iframe_Msg = $lang['AN192'];
$iframeMsg = $iframeClass = '';
$iframeCheck = false;
    
$iframeCheck = filter_var($dataFirst['iframe'], FILTER_VALIDATE_BOOLEAN);

if($iframeCheck){
    $iframeClass = 'errorBox';
    $iframeMsg = $lang['AN80'];
}else{
    $iframeClass = 'passedBox';
    $iframeMsg = $lang['AN79'];
}

$first_seoBox20 = '<div class="'.$iframeClass.'">
<div class="msgBox">       
     '.$iframeMsg.'
    <br /><br />
</div>
<div class="seoBox20 suggestionBox">
'.$iframe_Msg.'
</div> 
</div>';

//WHOIS Data
$class = 'lowImpactBox';
$whoisData = $hideMe = '';
$totalDataCount = 0;
$domainAgeMsg = $lang['AN193'];
$whoisDataMsg = $lang['AN194'];

$whois_data = decSerBase($dataFirst['whois']);
$whoisRaw = $whois_data[0];
$domainAge = $whois_data[1];
$createdDate = $whois_data[2];
$updatedDate = $whois_data[3];
$expiredDate = $whois_data[4];

$myLines = preg_split("/\r\n|\n|\r/", $whoisRaw);
foreach($myLines as $line){
    if(!empty($line)){
    if($totalDataCount == 5)
        $hideMe = 'hideTr hideTr6';
    $whoisData.='<tr class="'.$hideMe.'"><td>'.$line.'</td></tr>';
    $totalDataCount++;
    }
}

$first_seoBox21 = '<div class="'.$class.'">
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


$first_seoBox22 = '<div class="'.$class.'">
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

//Mobile Friendliness
$isMobileFriendlyMsg = '';
$mobileClass = $mobileScreenClass = 'lowImpactBox';

$mobileCheckMsg = $lang['AN195'];
$mobileScreenClassMsg = $lang['AN196'];;

$mobData = decSerBase($dataFirst['mobile_fri']);
$mobileScore = $mobData[0];
$isMobileFriendly = filter_var($mobData[1], FILTER_VALIDATE_BOOLEAN);

if($isMobileFriendly){
    $mobileClass = 'passedBox';
    $isMobileFriendlyMsg.=$lang['AN116'].'<br>'.str_replace('[score]',$mobileScore,$lang['AN117']);
}else{
    $mobileClass = 'errorBox';
    $isMobileFriendlyMsg.=$lang['AN118'].'<br>'.str_replace('[score]',$mobileScore,$lang['AN117']);
}

$screenData = getMobilePreview($firstHost);
if($screenData == '')
    $mobileScreenData = '';
else
    $mobileScreenData  = '<img src="data:image/jpeg;base64,'.$screenData.'" />';

$first_seoBox23 = '<div class="'.$mobileClass.'">
<div class="msgBox">       
    '.$isMobileFriendlyMsg.'
    <br /><br />
</div>
<div class="seoBox23 suggestionBox">
'.$mobileCheckMsg.'
</div> 
</div>';

$first_seoBox24 = '<div class="'.$mobileScreenClass.'">
<div class="msgBox">       
    <div class="mobileView">'.$mobileScreenData.'</div>
    <br />
</div>
<div class="seoBox24 suggestionBox">
'.$mobileScreenClassMsg.'
</div> 
</div>';


//Mobile Compatibility  
$mobileCom_Msg = $lang['AN197'];
$mobileComMsg = $mobileComClass = '';
$mobileComCheck = false;
    
$mobileComCheck = filter_var($dataFirst['mobile_com'], FILTER_VALIDATE_BOOLEAN);

if($mobileComCheck){
    $mobileComClass = 'errorBox';
    $mobileComMsg = $lang['AN121'];
}else{
    $mobileComClass = 'passedBox';
    $mobileComMsg = $lang['AN120'];
}

$first_seoBox25 = '<div class="'.$mobileComClass.'">
<div class="msgBox">       
     '.$mobileComMsg.'
    <br /><br />
</div>
<div class="seoBox25 suggestionBox">
'.$mobileCom_Msg.'
</div> 
</div>';


//URL Length & Favicon 
$favIconMsg = $urlLengthMsg = '';
$favIconClass = 'lowImpactBox';
$urlLength_Msg = $lang['AN198'];
$favIcon_Msg = $lang['AN199'];

$hostWord = explode('.',$firstHost);

if(strlen($hostWord[0]) < 15){
    $urlLengthClass = 'passedBox';
}else{
    $urlLengthClass = 'errorBox';
}
$urlLengthMsg = $first_url .'<br>'.str_replace('[count]',strlen($hostWord[0]),$lang['AN122']);
$favIconMsg = '<img src="https://www.google.com/s2/favicons?domain='.$first_url.'" alt="FavIcon" />  '.$lang['AN123'];

$first_seoBox26 = '<div class="'.$urlLengthClass.'">
<div class="msgBox">       
     '.$urlLengthMsg.'
    <br /><br />
</div>
<div class="seoBox26 suggestionBox">
'.$urlLength_Msg.'
</div> 
</div>';

$first_seoBox27 = '<div class="'.$favIconClass.'">
<div class="msgBox">       
    '.$favIconMsg.'
    <br /><br />
</div>
<div class="seoBox27 suggestionBox">
'.$favIcon_Msg.'
</div> 
</div>';


//Custom 404 Page Checker
$errorPage_Msg = $lang['AN200'];
$errorPageMsg = $errorPageClass = '';
$errorPageCheck = false;

$pageSize = base64_decode($dataFirst['404_page']);

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

$first_seoBox28 = '<div class="'.$errorPageClass.'">
<div class="msgBox">       
     '.$errorPageMsg.'
    <br /><br />
</div>
<div class="seoBox28 suggestionBox">
'.$errorPage_Msg.'
</div> 
</div>';

//Page Size / Load Time / Language
$size_Msg = $lang['AN201'];
$load_Msg = $lang['AN202'];
$lang_Msg = $lang['AN203'];

$sizeMsg = $loadMsg = $langMsg = '';
$langCode = null;

$load_time_data = decSerBase($dataFirst['load_time']);
$timeTaken = $load_time_data[0];
$dataFirstSize = $load_time_data[1];
$langCode = $load_time_data[2];

$dataFirstSize = size_as_kb($dataFirstSize);
if($dataFirstSize < 320){
    $sizeClass = 'passedBox'; 
}else{
    $sizeClass = 'errorBox'; 
}

$sizeMsg = str_replace('[size]',$dataFirstSize,$lang['AN126']);

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

$first_seoBox29 = '<div class="'.$sizeClass.'">
<div class="msgBox">       
     '.$sizeMsg.'
    <br /><br />
</div>
<div class="seoBox29 suggestionBox">
'.$size_Msg.'
</div> 
</div>';

$first_seoBox30 = '<div class="'.$loadClass.'">
<div class="msgBox">       
     '.$loadMsg.'
    <br /><br />
</div>
<div class="seoBox30 suggestionBox">
'.$load_Msg.'
</div> 
</div>';

$first_seoBox31 = '<div class="'.$langClass.'">
<div class="msgBox">       
     '.$langMsg.'
    <br /><br />
</div>
<div class="seoBox31 suggestionBox">
'.$lang_Msg.'
</div> 
</div>';


//Domain & Typo Availability Checker
$domain_Msg = $lang['AN204'];
$typo_Msg = $lang['AN205'] ;
$typoMsg = $domainMsg = '';
$typoClass = $domainClass = 'lowImpactBox';

$domain_typo = decSerBase($dataFirst['domain_typo']);
$doArr = $domain_typo[0];
$tyArr = $domain_typo[1];

foreach($doArr as $doStr){
    
    //Get the status of domain name
    $topDomain = $doStr[0];
    $domainAvailabilityStats = $doStr[1];
    
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
}

foreach($tyArr as $tyStr){
    
    //Get the status of domain name
    $topDomain = $tyStr[0];
    $domainAvailabilityStats = $tyStr[1];
    
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
}

$first_seoBox32 = '<div class="'.$domainClass.'">
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

$first_seoBox33 = '<div class="'.$typoClass.'">
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

//Email Privacy    
$emailPrivacy_Msg = $lang['AN206'];
$emailPrivacyMsg = $emailPrivacyClass = '';

$emailCount = $dataFirst['email_privacy'];

if($emailCount == 0){
    //No Email
    $emailPrivacyClass = 'passedBox';
    $emailPrivacyMsg = $lang['AN136'];
}else{
    //Emails Found
    $emailPrivacyClass = 'errorBox';
    $emailPrivacyMsg = $lang['AN137'];
}
         
$first_seoBox34 = '<div class="'.$emailPrivacyClass.'">
<div class="msgBox">       
     '.$emailPrivacyMsg.'
    <br /><br />
</div>
<div class="seoBox34 suggestionBox">
'.$emailPrivacy_Msg.'
</div> 
</div>';

//Safe Browsing
    
$safeBrowsing_Msg = $lang['AN207'];
$safeBrowsingMsg = $safeBrowsingClass = '';

$safeBrowsingStats = $dataFirst['safe_bro'];
//204 The website is not blacklisted 
//200 The website is blacklisted
//501 Something went wrong

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

$first_seoBox35 = '<div class="'.$safeBrowsingClass.'">
<div class="msgBox">       
     '.$safeBrowsingMsg.'
    <br /><br />
</div>
<div class="seoBox35 suggestionBox">
'.$safeBrowsing_Msg.'
</div> 
</div>';

//Server Location Information
$serverIP_Msg = $lang['AN208'];
$serverIPClass = 'lowImpactBox';

$getHostIP = gethostbyname($firstHostLow);
$dataFirst_list = decSerBase($dataFirst['server_loc']);
$domain_ip = $dataFirst_list[0];
$domain_country =  $dataFirst_list[1];
$domain_isp = $dataFirst_list[2];
            
$first_seoBox36 = '<div class="'.$serverIPClass.'">
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

//Speed Tips 
$speedTips_Msg = $lang['AN209'];
$speedTipsMsg = $speedTipsBody = '';    
$speedTipsCheck = $cssCount = $jsCount = 0;

$speedData = decSerBase($dataFirst['speed_tips']);
$cssCount = $speedData[0];
$jsCount = $speedData[1];
$nestedTables = $speedData[2];
$inlineCss = $speedData[3];

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
         
$first_seoBox37 = '<div class="'.$speedTipsClass.'">
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


//Analytics & Doc Type  
$docType_Msg = $lang['AN212'];
$analytics_Msg = $lang['AN210'];
$docType = $analyticsClass = $analyticsMsg = $docTypeClass = $docTypeMsg = '';   
$anCheck = false;
$docCheck = false;

$anDataArr = decSerBase($dataFirst['analytics']);

$anCheck = filter_var($anDataArr[0], FILTER_VALIDATE_BOOLEAN);
$docCheck = filter_var($anDataArr[1], FILTER_VALIDATE_BOOLEAN);
$docType = $anDataArr[2];

if ($anCheck){
    //Found
    $analyticsClass = 'passedBox';
    $analyticsMsg = $lang['AN154'];
}else{
    ///Not Found
    $analyticsClass = 'errorBox';
    $analyticsMsg = $lang['AN153'];
}

if(!$docCheck){
   $docTypeMsg = $lang['AN155'];
   $docTypeClass = 'improveBox';
}else{
    $docTypeMsg = $lang['AN156'] . ' ' . $docType;
    $docTypeClass = 'passedBox';
}

$first_seoBox38 = '<div class="'.$analyticsClass.'">
<div class="msgBox">
    '.$analyticsMsg.'
    <br /><br />
</div>
<div class="seoBox38 suggestionBox">
'.$analytics_Msg.'
</div> 
</div>';
         
$first_seoBox40 = '<div class="'.$docTypeClass.'">
<div class="msgBox">
    '.$docTypeMsg.'
    <br /><br />
</div>
<div class="seoBox40 suggestionBox">
'.$docType_Msg.'
</div> 
</div>';

//W3C Validity    
$w3c_Msg = $lang['AN211'];
$w3Data = $w3cMsg = '';
$w3cClass = 'lowImpactBox';
$w3DataCheck = 0;

$w3DataCheck = Trim($dataFirst['w3c']);

if($w3DataCheck == '1'){
    //Valid
    $w3cMsg = $lang['AN157'];
}elseif($w3DataCheck == '2'){
    //Not Valid
   $w3cMsg = $lang['AN158'];
}else{
    //Error
    $w3cMsg = $lang['AN10'];  
}

$first_seoBox39 = '<div class="'.$w3cClass.'">
<div class="msgBox">       
     '.$w3cMsg.'
    <br /><br />
</div>
<div class="seoBox39 suggestionBox">
'.$w3c_Msg.'
</div> 
</div>';

//Encoding Type
$encoding_Msg = $lang['AN213'];
$encodingMsg = $encodingClass = '';
$charterSet = null;

$charterSet = base64_decode($dataFirst['encoding']);

if($charterSet!=null){
    $encodingClass = 'passedBox';
    $encodingMsg = $lang['AN159'] . ' '. $charterSet;
}
else{ 
    $encodingClass = 'errorBox';
    $encodingMsg = $lang['AN160'];
}

$first_seoBox41 = '<div class="'.$encodingClass.'">
<div class="msgBox">       
     '.$encodingMsg.'
    <br /><br />
</div>
<div class="seoBox41 suggestionBox">
'.$encoding_Msg.'
</div> 
</div>';

//Indexed Pages
$indexedPages_Msg = $lang['AN214'];
$indexProgress = $indexedPagesMsg = $indexedPagesClass = '';
$datVal = $outData = 0;

$outData = base64_decode($dataFirst['indexed']);

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

$indexedPagesMsg = '<div style="width:'.$datVal.'%" aria-valuemax="'.$datVal.'" aria-valuemin="0" aria-valuenow="'.$datVal.'" role="progressbar" class="progress-bar progress-bar-'.$indexProgress.'">
    '.number_format($outData).' '.$lang['AN162'].'
</div>';
    
$first_seoBox42 = '<div class="'.$indexedPagesClass.'">
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

//Backlink Counter / Traffic / Worth 
$backlinks_Msg = $lang['AN215'];
$alexa_Msg =  $lang['AN218'];
$worth_Msg =  $lang['AN217'];
$alexaMsg = $worthMsg = $backProgress = $backlinksMsg = $backlinksClass = '';
$alexaClass = $worthClass = 'lowImpactBox';

$alexa = decSerBase($dataFirst['alexa']);
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
        
$first_seoBox43 = '<div class="'.$backlinksClass.'">
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

$first_seoBox45 = '<div class="'.$worthClass.'">
<div class="msgBox">       
     '.$worthMsg.'
    <br /><br />
</div>
<div class="seoBox45 suggestionBox">
'.$worth_Msg.'
</div> 
</div>';

$first_seoBox46 = '<div class="'.$alexaClass.'">
<div class="msgBox">       
     '.$alexaMsg.'
    <br /><br />
</div>
<div class="seoBox46 suggestionBox">
'.$alexa_Msg.'
</div> 
</div>';


//Social Data
$social_Msg = $lang['AN216'];
$socialMsg = '';
$socialClass = 'lowImpactBox';

$social_count = decSerBase($dataFirst['social']);
$facebook_like = $social_count[0];
$twit_count = $social_count[1];
$insta_count = $social_count[2];

$socialMsg = $lang['AN167'];

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

$first_seoBox44 = '<div class="'.$socialClass.'">
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

//Visitors Localization
$visitors_Msg = $lang['AN219'];
$visitorsMsg = '';
$visitorsClass = 'lowImpactBox';

$alexaDatas = decSerBase($dataFirst['visitors_loc']); 
$alexaDataCount = count($alexaDatas);

foreach($alexaDatas as $alexaData)
    $visitorsMsg.='<tr><td>'.$alexaData[1].'</td><td>'.$alexaData[2].'</td><tr>';

$first_seoBox47 = '<div class="'.$visitorsClass.'">
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

//Page Speed Insight Checker
$pageSpeedInsightDesktop_Msg = $lang['AN220'];
$pageSpeedInsightMobile_Msg = $lang['AN221'];
$desktopMsg = $mobileMsg = $pageSpeedInsightData = $first_seoBox48 = $first_seoBox49 = '';
$desktopClass = $mobileClass = $desktopSpeed = $mobileSpeed = '';
$speedStr = $lang['117']; $mobileStr = $lang['119']; $desktopStr = $lang['118'];

$pageSpeedInsightData = decSerBase($dataFirst['page_speed_insight']); 

$desktopScore = $pageSpeedInsightData[0];
$mobileScore = $pageSpeedInsightData[1];

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
    
$desktopMsg = <<< EOT
<script type="text/javascript">var firstDesktopPageSpeed = new Gauge({
	renderTo  : 'firstDesktopPageSpeed',
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

firstDesktopPageSpeed.onready = function() {
    firstDesktopPageSpeed.setValue($desktopScore);
};


firstDesktopPageSpeed.draw();</script>
EOT;

$mobileMsg = <<< EOT
<script>var firstMobilePageSpeed = new Gauge({
	renderTo  : 'firstMobilePageSpeed',
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

firstMobilePageSpeed.onready = function() {
    firstMobilePageSpeed.setValue($mobileScore);
};


firstMobilePageSpeed.draw();</script>
EOT;

    
$first_seoBox48 = '<div class="'.$desktopClass.'">
<div class="msgBox">
    <div class="row">
        <div class="col-sm-6 text-center">
            <canvas id="firstDesktopPageSpeed"></canvas>
            '.$desktopMsg.'
        </div>
        <div class="col-sm-6">
        <h2>'.$desktopScore.' / 100</h2>
        <h4>'.$lang['123'].'</h4>
        <p><strong>'.ucfirst($firstHost).'</strong> '.$lang['127'].' <strong>'.$desktopSpeed.'</strong>. '.$lang['128'].'</p>
        </div>
    </div>   
</div>
<div class="seoBox48 suggestionBox">
'.$pageSpeedInsightDesktop_Msg.'
</div> 
</div>';

$first_seoBox49 = '<div class="'.$mobileClass.'">
<div class="msgBox">   
    <div class="row">
        <div class="col-sm-6 text-center">
            <canvas id="firstMobilePageSpeed"></canvas>
            '.$mobileMsg.'
        </div>
    <div class="col-sm-6">
        <h2>'.$mobileScore.' / 100</h2>
        <h4>'.$lang['123'].'</h4>
        <p><strong>'.ucfirst($firstHost).'</strong> '.$lang['129'].' <strong>'.$mobileSpeed.'</strong>. '.$lang['128'].'</p>
    </div>
    </div>
</div>
<div class="seoBox49 suggestionBox">
'.$pageSpeedInsightMobile_Msg.'
</div> 
</div>';

//Get Final Score Data
$first_score = decSerBase($dataFirst['score']); 
$first_passScore = $first_score[0];
$first_improveScore = $first_score[1];
$first_errorScore = $first_score[2];

//Get the data
$date_raw = date_create(Trim($dataFirst['date']));
$firstDate = date_format($date_raw,"jS F Y");

//Login Access Check
if(!isset($_SESSION['twebUsername'])){
    if($enable_reg){
        foreach($reviewerSettings['reviewer_list'] as $reviewer)
            ${'first_'.$reviewer} = $seoBoxLogin;
    }
}

//Second Domain
    
//Meta Data  
$metatitle = $metadescription = $metakeywords = $secTitle = $secDes = $secKey = '';
$meta_data = decSerBase($dataSec['meta_data']);

$metatitle = $meta_data[0];
$metadescription = $meta_data[1];
$metakeywords = $meta_data[2];

$secTitle = strtolower($metatitle);
$secDes = strtolower($metadescription);
$secKey = strtolower($metakeywords);

//Bad Word Filter - Patch - START
foreach ($list[1] as $badWord){
    if(check_str_contains($firstTitle, trim($badWord), true))
        $badWordBan = true;
    if(check_str_contains($secTitle, trim($badWord), true))
        $badWordBan = true;
}
if(!$badWordBan){
    foreach ($list[2] as $badWord){
        if(check_str_contains($firstDes, trim($badWord), true))
            $badWordBan = true;
        if(check_str_contains($secDes, trim($badWord), true))
            $badWordBan = true;
    }
}
if(!$badWordBan){
    foreach ($list[3] as $badWord){
        if(check_str_contains($firstKey, trim($badWord), true))
            $badWordBan = true;
        if(check_str_contains($secKey, trim($badWord), true))
            $badWordBan = true;
    }
}
if($badWordBan){
    redirectTo(createLink('warning/restricted-words',true));
    die();  
}
//Bad Word Filter - Patch - END

$lenTitle = mb_strlen($metatitle,'utf8');
$lenDes = mb_strlen($metadescription,'utf8');

//Check Empty Data
$site_title = ($metatitle == '' ? $lang['AN11'] : $metatitle);
$site_description = ($metadescription == '' ? $lang['AN12'] : $metadescription);
$site_keywords = ($metakeywords == '' ? $lang['AN15'] : $metakeywords);

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
elseif($lenDes < 160)
    $classDes = 'passedBox';
else
    $classDes = 'errorBox';
    
$classKey = 'lowImpactBox';


$sec_seoBox1 = '<div class="'.$classTitle.'">
<div class="msgBox bottom10">       
'.$site_title.'
<br />
<b>'.$lang['AN13'].':</b> '.$lenTitle.' '.$lang['AN14'].' 
</div>
<div class="seoBox1 suggestionBox">
'.$titleMsg.'
</div> 
</div>';


$sec_seoBox2 = '<div class="'.$classDes.'">
<div class="msgBox padRight10 bottom10">       
'.$site_description.'
<br />
<b>'.$lang['AN13'].':</b> '.$lenDes.' '.$lang['AN14'].' 
</div>
<div class="seoBox2 suggestionBox">
'.$desMsg.'
</div> 
</div>';

$sec_seoBox3 = '<div class="'.$classKey.'">
<div class="msgBox padRight10">       
'.$site_keywords.'
<br /><br />
</div>
<div class="seoBox3 suggestionBox">
'.$keyMsg.'
</div> 
</div>';


$sec_seoBox5 = '<div class="'.$classKey.'">
<div class="msgBox">       
     <div class="googlePreview">
		<p>'.$site_title.'</p>
		<p><span class="bold">'.$secHost.'</span>/</p>
		<p>'.$site_description.'</p>
    </div>
<br />
</div>
<div class="seoBox5 suggestionBox">
'.$googleMsg.'
</div> 
</div>';


//Heading Data 
$headings = decSerBase($dataSec['headings']);

//Get H1 to H6 Tags
$tags = array ('h1', 'h2', 'h3', 'h4', 'h5', 'h6');
$h1Count = $h2Count = $h3Count = $h4Count = $h5Count = $h6Count = 0;
$elementListData = $headings[0];
$texts = $headings[1];
$hideCount = 0;
$hideClass = $headStr = '';

foreach($tags as $tag)
{
  if (isset($elementListData[$tag])) {
  foreach($elementListData[$tag] as $element)
  {
     if($hideCount == 3)
        $hideClass = 'hideTr hideTr1';
     $headStr.= '<tr class="'.$hideClass.'"> <td>&lt;'.$element[0].'&gt; <b>'.$element[1].'</b> &lt;/'.$element[0].'&gt;</td> </tr>';
     $hideCount++;
  }
  }
}

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

$sec_seoBox4 = '<div class="'.$class.'">
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

//Image without Alt Tag
$image_alt = decSerBase($dataSec['image_alt']);

$imageCount = $image_alt[0];
$imageWithOutAltTag = 0;
$hideClass = $imageWithOutAltTagData = '';
$imageMsg = $lang['AN178'];
$imgArr = $image_alt[2];

foreach($imgArr as $imgLink){
    if($imageWithOutAltTag == 3)
        $hideClass = 'hideTr hideTr2';
    $imageWithOutAltTagData .= '<tr class="'.$hideClass.'"> <td>'.$imgLink.'</td> </tr>';
    $imageWithOutAltTag++;
}

$imageWithOutAltTag = $image_alt[1];

if($imageWithOutAltTag == 0)
    $altClass = 'passedBox';
elseif($imageWithOutAltTag < 2)
    $altClass = 'improveBox';
else
    $altClass = 'errorBox';


$sec_seoBox6 = '<div class="'.$altClass.'">
<div class="msgBox">       
    '.str_replace('[image-count]',$imageCount,$lang['AN21']).' <br />
    <div class="altImgGroup"> 
    '.(($imageWithOutAltTag == 0)? '
    <img src="'.$theme_path.'img/true.png" alt="'.$lang['AN24'].'" title="'.$lang['AN25'].'" /> '.$lang['AN27'].'</div><br />': ' 
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

//Keyword Cloud
$keywords_cloud = decSerBase($dataSec['keywords_cloud']);
$outCount = $keywords_cloud[0];
$outArr = $keywords_cloud[1];
$keyData = '';
    
foreach($outArr as $outData){
    $keyData .= '<li><span class="keyword">'.$outData[0].'</span><span class="number">'.$outData[1].'</span></li>';
}
    
$keycloudClass = 'lowImpactBox';
$keyMsg = $lang['AN179'];

$sec_seoBox7 = '<div class="'.$keycloudClass.'">
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

    
$hideClass = $keywordConsistencyTitle = $keywordConsistencyDes = $keywordConsistencyH = $keywordConsistencyData = '';

$hideCount = 1;
$keywordConsistencyScore = 0;

foreach($outArr as $outKey){
    if(check_str_contains($metatitle, $outKey[0], true)){
        $keywordConsistencyTitle = $true;
        $keywordConsistencyScore++;
    }else{
        $keywordConsistencyTitle = $false;
    }
   
    if(check_str_contains($metadescription, $outKey[0], true)){
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

$sec_seoBox8 = '<div class="'.$keywordConsistencyClass.'">
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

//Text to HTML Ratio
$textRatio = decSerBase($dataSec['ratio_data']);

if(round($textRatio[2]) < 2)
    $textClass = 'errorBox';
elseif(round($textRatio[2]) < 10)
    $textClass = 'improveBox';
else
    $textClass = 'passedBox';
    
$textMsg = $lang['AN181'];

$sec_seoBox9 = '<div class="'.$textClass.'">
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

//Check GZIP Compression 
$gzipClass = $gzipHead = $gzipBody = '';
$outData = decSerBase($dataSec['gzip']);
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

$gzipMsg = $lang['AN182'];
            
$sec_seoBox10 = '<div class="'.$gzipClass.'">
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


//WWW Resolve
$resolve = decSerBase($dataSec['resolve']);

$www_resolveMsg = $lang['AN183'];
$resolveClass = 'improveBox';
$resolveMsg = $lang['AN47'];
$re301 = false;
$url_with_www = "http://www.$secHostLow";
$url_no_www = "http://$secHostLow";

$dataSec1 = $resolve[0];
$dataSec2 = $resolve[1];


if(check_str_contains($dataSec1,'301')){
    $re301 = true;
    $resolveClass = 'passedBox';
    $resolveMsg = $lang['AN46'];
}

if(check_str_contains($dataSec2,'301')){
    $re301= true;
    $resolveClass = 'passedBox';
    $resolveMsg = $lang['AN46'];
}

$sec_seoBox11 = '<div class="'.$resolveClass.'">
<div class="msgBox">       
     '.$resolveMsg.'
    <br />
    <br />
</div>
<div class="seoBox11 suggestionBox">
'.$www_resolveMsg.'
</div> 
</div>';


//IP Canonicalization
$ip_can = decSerBase($dataSec['ip_can']);

$ip_canMsg = $lang['AN184'];
$ipClass = 'improveBox';
$hostIP = $ipMsg = '';
$tType = $ip_can[1];
$redirectURLhost = $ip_can[3];
$hostIP = $ip_can[0];

if($tType){
    if($secHost == $redirectURLhost){
        $ipMsg = str_replace(array('[ip]','[host]'),array($hostIP,$secHost),$lang['AN50']);
        $ipClass = 'passedBox';
    }else{
       $ipMsg = str_replace(array('[ip]','[host]'),array($hostIP,$secHost),$lang['AN49']); 
    }
    $tType = true;
}else{
    $ipMsg = str_replace(array('[ip]','[host]'),array($hostIP,$secHost),$lang['AN49']);
}

$sec_seoBox12 = '<div class="'.$ipClass.'">
<div class="msgBox">       
     '.$ipMsg.'
    <br />
    <br />
</div>
<div class="seoBox12 suggestionBox">
'.$ip_canMsg.'
</div> 
</div>';


//In-Page Links analyser
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

$ex_data = decSerBase($dataSec['links_analyser']);

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
        
    if ($myIntHost == $secHostLow || $myIntHost == "www." . $secHostLow) {
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
        $int_data[$i_links]['href'] = $second_url.$link['href'];
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
                $int_data[$i_links]['href'] = $second_url.'/'.$link['href'];
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
        $secHostLow && $parse_urls['host'] != "www." . $secHostLow) {
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
    
$sec_seoBox13 = '<div class="'.$inPageClass.'">
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

$sec_seoBox17 = '<div class="'.$urlRewritingClass.'">
<div class="msgBox">       
     '.$urlRewritingMsg.'
    <br />
    <br />
</div>
<div class="seoBox17 suggestionBox">
'.$url_RewritingMsg.'
</div> 
</div>';

$sec_seoBox18 = '<div class="'.$linkUnderScoreClass.'">
<div class="msgBox">       
     '.$linkUnderScoreMsg.'
    <br />
    <br />
</div>
<div class="seoBox18 suggestionBox">
'.$link_UnderScoreMsg.'
</div> 
</div>';


//Broken Links
$bLinks = decSerBase($dataSec['broken_links']);
$broken_Msg = $lang['AN186'];
$hideMe = $brokenMsg = $brokenClass = $brokenLinks = '';
$totalDataCount = 0;

foreach($bLinks as $bLink){
    
    if($totalDataCount == 3)
        $hideMe = 'hideTr hideTr5';
    $brokenLinks.= '<tr class="'.$hideMe.'"><td>'.$bLink.'</td></tr>';
    $totalDataCount++;
}

if($totalDataCount == 0){
    $brokenClass = 'passedBox';
    $brokenMsg = $lang['AN68'];
}else{
    $brokenClass = 'errorBox';
    $brokenMsg = $lang['AN69'];
}
    
$sec_seoBox14 = '<div class="'.$brokenClass.'">
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


//Robots.txt Checker
$robot_Msg = $lang['AN187'];
$robotLink = $robotMsg = $robotClass = '';

$robotLink = $second_url .'/robots.txt';
$httpCode = base64_decode($dataSec['robots']);

if($httpCode == '404'){
    $robotClass = 'errorBox';
    $robotMsg = $lang['AN74'] . '<br>' . '<a href="'.$robotLink.'" title="'.$lang['AN75'].'" rel="nofollow" target="_blank">'.$robotLink.'</a>';
}else{
    $robotClass = 'passedBox';
    $robotMsg = $lang['AN73'] . '<br>' . '<a href="'.$robotLink.'" title="'.$lang['AN75'].'" rel="nofollow" target="_blank">'.$robotLink.'</a>';
}

$sec_seoBox16 = '<div class="'.$robotClass.'">
<div class="msgBox">       
     '.$robotMsg.'
    <br /><br />
</div>
<div class="seoBox16 suggestionBox">
'.$robot_Msg.'
</div> 
</div>';


//Sitemap Checker
$sitemap_Msg = $lang['AN188'];
$sitemapLink = $sitemapMsg = $sitemapClass = '';

$sitemapLink = $second_url .'/sitemap.xml';
$httpCode = base64_decode($dataSec['sitemap']);

if($httpCode == '404'){
    $sitemapClass = 'errorBox';
    $sitemapMsg = $lang['AN71'] . '<br>' . '<a href="'.$sitemapLink.'" title="'.$lang['AN72'].'" rel="nofollow" target="_blank">'.$sitemapLink.'</a>';
}else{
    $sitemapClass = 'passedBox';
    $sitemapMsg = $lang['AN70'] . '<br>' . '<a href="'.$sitemapLink.'" title="'.$lang['AN72'].'" rel="nofollow" target="_blank">'.$sitemapLink.'</a>';
}

$sec_seoBox15 = '<div class="'.$sitemapClass.'">
<div class="msgBox">       
     '.$sitemapMsg.'
    <br /><br />
</div>
<div class="seoBox15 suggestionBox">
'.$sitemap_Msg.'
</div> 
</div>';

//Embedded Object Check
$embedded_Msg = $lang['AN191'];
$embeddedMsg = $embeddedClass = '';
$embeddedCheck = false;

$embeddedCheck = filter_var($dataSec['embedded'], FILTER_VALIDATE_BOOLEAN);

if($embeddedCheck){
    $embeddedClass = 'errorBox';
    $embeddedMsg = $lang['AN78'];
}else{
    $embeddedClass = 'passedBox';
    $embeddedMsg = $lang['AN77'];
}

$sec_seoBox19 = '<div class="'.$embeddedClass.'">
<div class="msgBox">       
     '.$embeddedMsg.'
    <br /><br />
</div>
<div class="seoBox19 suggestionBox">
'.$embedded_Msg.'
</div> 
</div>';

//iframe Check
$iframe_Msg = $lang['AN192'];
$iframeMsg = $iframeClass = '';
$iframeCheck = false;
    
$iframeCheck = filter_var($dataSec['iframe'], FILTER_VALIDATE_BOOLEAN);

if($iframeCheck){
    $iframeClass = 'errorBox';
    $iframeMsg = $lang['AN80'];
}else{
    $iframeClass = 'passedBox';
    $iframeMsg = $lang['AN79'];
}

$sec_seoBox20 = '<div class="'.$iframeClass.'">
<div class="msgBox">       
     '.$iframeMsg.'
    <br /><br />
</div>
<div class="seoBox20 suggestionBox">
'.$iframe_Msg.'
</div> 
</div>';

//WHOIS Data
$class = 'lowImpactBox';
$whoisData = $hideMe = '';
$totalDataCount = 0;
$domainAgeMsg = $lang['AN193'];
$whoisDataMsg = $lang['AN194'];

$whois_data = decSerBase($dataSec['whois']);
$whoisRaw = $whois_data[0];
$domainAge = $whois_data[1];
$createdDate = $whois_data[2];
$updatedDate = $whois_data[3];
$expiredDate = $whois_data[4];

$myLines = preg_split("/\r\n|\n|\r/", $whoisRaw);
foreach($myLines as $line){
    if(!empty($line)){
    if($totalDataCount == 5)
        $hideMe = 'hideTr hideTr6';
    $whoisData.='<tr class="'.$hideMe.'"><td>'.$line.'</td></tr>';
    $totalDataCount++;
    }
}

$sec_seoBox21 = '<div class="'.$class.'">
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


$sec_seoBox22 = '<div class="'.$class.'">
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

//Mobile Friendliness
$isMobileFriendlyMsg = '';
$mobileClass = $mobileScreenClass = 'lowImpactBox';

$mobileCheckMsg = $lang['AN195'];
$mobileScreenClassMsg = $lang['AN196'];;

$mobData = decSerBase($dataSec['mobile_fri']);
$mobileScore = $mobData[0];
$isMobileFriendly = filter_var($mobData[1], FILTER_VALIDATE_BOOLEAN);

if($isMobileFriendly){
    $mobileClass = 'passedBox';
    $isMobileFriendlyMsg.=$lang['AN116'].'<br>'.str_replace('[score]',$mobileScore,$lang['AN117']);
}else{
    $mobileClass = 'errorBox';
    $isMobileFriendlyMsg.=$lang['AN118'].'<br>'.str_replace('[score]',$mobileScore,$lang['AN117']);
}

$screenData = getMobilePreview($secHost);
if($screenData == '')
    $mobileScreenData = '';
else
    $mobileScreenData  = '<img src="data:image/jpeg;base64,'.$screenData.'" />';

$sec_seoBox23 = '<div class="'.$mobileClass.'">
<div class="msgBox">       
    '.$isMobileFriendlyMsg.'
    <br /><br />
</div>
<div class="seoBox23 suggestionBox">
'.$mobileCheckMsg.'
</div> 
</div>';

$sec_seoBox24 = '<div class="'.$mobileScreenClass.'">
<div class="msgBox">       
    <div class="mobileView">'.$mobileScreenData.'</div>
    <br />
</div>
<div class="seoBox24 suggestionBox">
'.$mobileScreenClassMsg.'
</div> 
</div>';


//Mobile Compatibility  
$mobileCom_Msg = $lang['AN197'];
$mobileComMsg = $mobileComClass = '';
$mobileComCheck = false;
    
$mobileComCheck = filter_var($dataSec['mobile_com'], FILTER_VALIDATE_BOOLEAN);

if($mobileComCheck){
    $mobileComClass = 'errorBox';
    $mobileComMsg = $lang['AN121'];
}else{
    $mobileComClass = 'passedBox';
    $mobileComMsg = $lang['AN120'];
}

$sec_seoBox25 = '<div class="'.$mobileComClass.'">
<div class="msgBox">       
     '.$mobileComMsg.'
    <br /><br />
</div>
<div class="seoBox25 suggestionBox">
'.$mobileCom_Msg.'
</div> 
</div>';


//URL Length & Favicon 
$favIconMsg = $urlLengthMsg = '';
$favIconClass = 'lowImpactBox';
$urlLength_Msg = $lang['AN198'];
$favIcon_Msg = $lang['AN199'];

$hostWord = explode('.',$secHost);

if(strlen($hostWord[0]) < 15){
    $urlLengthClass = 'passedBox';
}else{
    $urlLengthClass = 'errorBox';
}
$urlLengthMsg = $second_url .'<br>'.str_replace('[count]',strlen($hostWord[0]),$lang['AN122']);
$favIconMsg = '<img src="https://www.google.com/s2/favicons?domain='.$second_url.'" alt="FavIcon" />  '.$lang['AN123'];

$sec_seoBox26 = '<div class="'.$urlLengthClass.'">
<div class="msgBox">       
     '.$urlLengthMsg.'
    <br /><br />
</div>
<div class="seoBox26 suggestionBox">
'.$urlLength_Msg.'
</div> 
</div>';

$sec_seoBox27 = '<div class="'.$favIconClass.'">
<div class="msgBox">       
    '.$favIconMsg.'
    <br /><br />
</div>
<div class="seoBox27 suggestionBox">
'.$favIcon_Msg.'
</div> 
</div>';


//Custom 404 Page Checker
$errorPage_Msg = $lang['AN200'];
$errorPageMsg = $errorPageClass = '';
$errorPageCheck = false;

$pageSize = base64_decode($dataSec['404_page']);

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

$sec_seoBox28 = '<div class="'.$errorPageClass.'">
<div class="msgBox">       
     '.$errorPageMsg.'
    <br /><br />
</div>
<div class="seoBox28 suggestionBox">
'.$errorPage_Msg.'
</div> 
</div>';

//Page Size / Load Time / Language
$size_Msg = $lang['AN201'];
$load_Msg = $lang['AN202'];
$lang_Msg = $lang['AN203'];

$sizeMsg = $loadMsg = $langMsg = '';
$langCode = null;

$load_time_data = decSerBase($dataSec['load_time']);
$timeTaken = $load_time_data[0];
$dataSecSize = $load_time_data[1];
$langCode = $load_time_data[2];

$dataSecSize = size_as_kb($dataSecSize);
if($dataSecSize < 320){
    $sizeClass = 'passedBox'; 
}else{
    $sizeClass = 'errorBox'; 
}

$sizeMsg = str_replace('[size]',$dataSecSize,$lang['AN126']);

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

$sec_seoBox29 = '<div class="'.$sizeClass.'">
<div class="msgBox">       
     '.$sizeMsg.'
    <br /><br />
</div>
<div class="seoBox29 suggestionBox">
'.$size_Msg.'
</div> 
</div>';

$sec_seoBox30 = '<div class="'.$loadClass.'">
<div class="msgBox">       
     '.$loadMsg.'
    <br /><br />
</div>
<div class="seoBox30 suggestionBox">
'.$load_Msg.'
</div> 
</div>';

$sec_seoBox31 = '<div class="'.$langClass.'">
<div class="msgBox">       
     '.$langMsg.'
    <br /><br />
</div>
<div class="seoBox31 suggestionBox">
'.$lang_Msg.'
</div> 
</div>';


//Domain & Typo Availability Checker
$domain_Msg = $lang['AN204'];
$typo_Msg = $lang['AN205'] ;
$typoMsg = $domainMsg = '';
$typoClass = $domainClass = 'lowImpactBox';

$domain_typo = decSerBase($dataSec['domain_typo']);
$doArr = $domain_typo[0];
$tyArr = $domain_typo[1];

foreach($doArr as $doStr){
    
    //Get the status of domain name
    $topDomain = $doStr[0];
    $domainAvailabilityStats = $doStr[1];
    
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
}

foreach($tyArr as $tyStr){
    
    //Get the status of domain name
    $topDomain = $tyStr[0];
    $domainAvailabilityStats = $tyStr[1];
    
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
}

$sec_seoBox32 = '<div class="'.$domainClass.'">
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

$sec_seoBox33 = '<div class="'.$typoClass.'">
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

//Email Privacy    
$emailPrivacy_Msg = $lang['AN206'];
$emailPrivacyMsg = $emailPrivacyClass = '';

$emailCount = $dataSec['email_privacy'];

if($emailCount == 0){
    //No Email
    $emailPrivacyClass = 'passedBox';
    $emailPrivacyMsg = $lang['AN136'];
}else{
    //Emails Found
    $emailPrivacyClass = 'errorBox';
    $emailPrivacyMsg = $lang['AN137'];
}
         
$sec_seoBox34 = '<div class="'.$emailPrivacyClass.'">
<div class="msgBox">       
     '.$emailPrivacyMsg.'
    <br /><br />
</div>
<div class="seoBox34 suggestionBox">
'.$emailPrivacy_Msg.'
</div> 
</div>';

//Safe Browsing
    
$safeBrowsing_Msg = $lang['AN207'];
$safeBrowsingMsg = $safeBrowsingClass = '';

$safeBrowsingStats = $dataSec['safe_bro'];
//204 The website is not blacklisted 
//200 The website is blacklisted
//501 Something went wrong

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

$sec_seoBox35 = '<div class="'.$safeBrowsingClass.'">
<div class="msgBox">       
     '.$safeBrowsingMsg.'
    <br /><br />
</div>
<div class="seoBox35 suggestionBox">
'.$safeBrowsing_Msg.'
</div> 
</div>';

//Server Location Information
$serverIP_Msg = $lang['AN208'];
$serverIPClass = 'lowImpactBox';

$getHostIP = gethostbyname($secHostLow);
$dataSec_list = decSerBase($dataSec['server_loc']);
$domain_ip = $dataSec_list[0];
$domain_country =  $dataSec_list[1];
$domain_isp = $dataSec_list[2];
            
$sec_seoBox36 = '<div class="'.$serverIPClass.'">
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

//Speed Tips 
$speedTips_Msg = $lang['AN209'];
$speedTipsMsg = $speedTipsBody = '';    
$speedTipsCheck = $cssCount = $jsCount = 0;

$speedData = decSerBase($dataSec['speed_tips']);
$cssCount = $speedData[0];
$jsCount = $speedData[1];
$nestedTables = $speedData[2];
$inlineCss = $speedData[3];

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
         
$sec_seoBox37 = '<div class="'.$speedTipsClass.'">
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


//Analytics & Doc Type  
$docType_Msg = $lang['AN212'];
$analytics_Msg = $lang['AN210'];
$docType = $analyticsClass = $analyticsMsg = $docTypeClass = $docTypeMsg = '';   
$anCheck = false;
$docCheck = false;

$anDataArr = decSerBase($dataSec['analytics']);

$anCheck = filter_var($anDataArr[0], FILTER_VALIDATE_BOOLEAN);
$docCheck = filter_var($anDataArr[1], FILTER_VALIDATE_BOOLEAN);
$docType = $anDataArr[2];

if ($anCheck){
    //Found
    $analyticsClass = 'passedBox';
    $analyticsMsg = $lang['AN154'];
}else{
    ///Not Found
    $analyticsClass = 'errorBox';
    $analyticsMsg = $lang['AN153'];
}

if(!$docCheck){
   $docTypeMsg = $lang['AN155'];
   $docTypeClass = 'improveBox';
}else{
    $docTypeMsg = $lang['AN156'] . ' ' . $docType;
    $docTypeClass = 'passedBox';
}

$sec_seoBox38 = '<div class="'.$analyticsClass.'">
<div class="msgBox">
    '.$analyticsMsg.'
    <br /><br />
</div>
<div class="seoBox38 suggestionBox">
'.$analytics_Msg.'
</div> 
</div>';
         
$sec_seoBox40 = '<div class="'.$docTypeClass.'">
<div class="msgBox">
    '.$docTypeMsg.'
    <br /><br />
</div>
<div class="seoBox40 suggestionBox">
'.$docType_Msg.'
</div> 
</div>';

//W3C Validity    
$w3c_Msg = $lang['AN211'];
$w3Data = $w3cMsg = '';
$w3cClass = 'lowImpactBox';
$w3DataCheck = 0;

$w3DataCheck = Trim($dataSec['w3c']);

if($w3DataCheck == '1'){
    //Valid
    $w3cMsg = $lang['AN157'];
}elseif($w3DataCheck == '2'){
    //Not Valid
   $w3cMsg = $lang['AN158'];
}else{
    //Error
    $w3cMsg = $lang['AN10'];  
}

$sec_seoBox39 = '<div class="'.$w3cClass.'">
<div class="msgBox">       
     '.$w3cMsg.'
    <br /><br />
</div>
<div class="seoBox39 suggestionBox">
'.$w3c_Msg.'
</div> 
</div>';

//Encoding Type
$encoding_Msg = $lang['AN213'];
$encodingMsg = $encodingClass = '';
$charterSet = null;

$charterSet = base64_decode($dataSec['encoding']);

if($charterSet!=null){
    $encodingClass = 'passedBox';
    $encodingMsg = $lang['AN159'] . ' '. $charterSet;
}
else{ 
    $encodingClass = 'errorBox';
    $encodingMsg = $lang['AN160'];
}

$sec_seoBox41 = '<div class="'.$encodingClass.'">
<div class="msgBox">       
     '.$encodingMsg.'
    <br /><br />
</div>
<div class="seoBox41 suggestionBox">
'.$encoding_Msg.'
</div> 
</div>';

//Indexed Pages
$indexedPages_Msg = $lang['AN214'];
$indexProgress = $indexedPagesMsg = $indexedPagesClass = '';
$datVal = $outData = 0;

$outData = base64_decode($dataSec['indexed']);

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

$indexedPagesMsg = '<div style="width:'.$datVal.'%" aria-valuemax="'.$datVal.'" aria-valuemin="0" aria-valuenow="'.$datVal.'" role="progressbar" class="progress-bar progress-bar-'.$indexProgress.'">
    '.number_format($outData).' '.$lang['AN162'].'
</div>';
    
$sec_seoBox42 = '<div class="'.$indexedPagesClass.'">
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

//Backlink Counter / Traffic / Worth 
$backlinks_Msg = $lang['AN215'];
$alexa_Msg =  $lang['AN218'];
$worth_Msg =  $lang['AN217'];
$alexaMsg = $worthMsg = $backProgress = $backlinksMsg = $backlinksClass = '';
$alexaClass = $worthClass = 'lowImpactBox';

$alexa = decSerBase($dataSec['alexa']);
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
        
$sec_seoBox43 = '<div class="'.$backlinksClass.'">
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

$sec_seoBox45 = '<div class="'.$worthClass.'">
<div class="msgBox">       
     '.$worthMsg.'
    <br /><br />
</div>
<div class="seoBox45 suggestionBox">
'.$worth_Msg.'
</div> 
</div>';

$sec_seoBox46 = '<div class="'.$alexaClass.'">
<div class="msgBox">       
     '.$alexaMsg.'
    <br /><br />
</div>
<div class="seoBox46 suggestionBox">
'.$alexa_Msg.'
</div> 
</div>';


//Social Data
$social_Msg = $lang['AN216'];
$socialMsg = '';
$socialClass = 'lowImpactBox';

$social_count = decSerBase($dataSec['social']);
$facebook_like = $social_count[0];
$twit_count = $social_count[1];
$insta_count = $social_count[2];

$socialMsg = $lang['AN167'];

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

$sec_seoBox44 = '<div class="'.$socialClass.'">
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

//Visitors Localization
$visitors_Msg = $lang['AN219'];
$visitorsMsg = '';
$visitorsClass = 'lowImpactBox';

$alexaDatas = decSerBase($dataSec['visitors_loc']); 
$alexaDataCount = count($alexaDatas);

foreach($alexaDatas as $alexaData)
    $visitorsMsg.='<tr><td>'.$alexaData[1].'</td><td>'.$alexaData[2].'</td><tr>';

$sec_seoBox47 = '<div class="'.$visitorsClass.'">
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

//Page Speed Insight Checker
$pageSpeedInsightDesktop_Msg = $lang['AN220'];
$pageSpeedInsightMobile_Msg = $lang['AN221'];
$desktopMsg = $mobileMsg = $pageSpeedInsightData = $sec_seoBox48 = $sec_seoBox49 = '';
$desktopClass = $mobileClass = $desktopSpeed = $mobileSpeed = '';
$speedStr = $lang['117']; $mobileStr = $lang['119']; $desktopStr = $lang['118'];

$pageSpeedInsightData = decSerBase($dataSec['page_speed_insight']); 

$desktopScore = $pageSpeedInsightData[0];
$mobileScore = $pageSpeedInsightData[1];

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
    
$desktopMsg = <<< EOT
<script type="text/javascript">var secDesktopPageSpeed = new Gauge({
	renderTo  : 'secDesktopPageSpeed',
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

secDesktopPageSpeed.onready = function() {
    secDesktopPageSpeed.setValue($desktopScore);
};


secDesktopPageSpeed.draw();</script>
EOT;

$mobileMsg = <<< EOT
<script>var secMobilePageSpeed = new Gauge({
	renderTo  : 'secMobilePageSpeed',
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

secMobilePageSpeed.onready = function() {
    secMobilePageSpeed.setValue($mobileScore);
};


secMobilePageSpeed.draw();</script>
EOT;

    
$sec_seoBox48 = '<div class="'.$desktopClass.'">
<div class="msgBox">
    <div class="row">
        <div class="col-sm-6 text-center">
            <canvas id="secDesktopPageSpeed"></canvas>
            '.$desktopMsg.'
        </div>
        <div class="col-sm-6">
        <h2>'.$desktopScore.' / 100</h2>
        <h4>'.$lang['123'].'</h4>
        <p><strong>'.ucfirst($secHost).'</strong> '.$lang['127'].' <strong>'.$desktopSpeed.'</strong>. '.$lang['128'].'</p>
        </div>
    </div>   
</div>
<div class="seoBox48 suggestionBox">
'.$pageSpeedInsightDesktop_Msg.'
</div> 
</div>';

$sec_seoBox49 = '<div class="'.$mobileClass.'">
<div class="msgBox">   
    <div class="row">
        <div class="col-sm-6 text-center">
            <canvas id="secMobilePageSpeed"></canvas>
            '.$mobileMsg.'
        </div>
    <div class="col-sm-6">
        <h2>'.$mobileScore.' / 100</h2>
        <h4>'.$lang['123'].'</h4>
        <p><strong>'.ucfirst($secHost).'</strong> '.$lang['129'].' <strong>'.$mobileSpeed.'</strong>. '.$lang['128'].'</p>
    </div>
    </div>
</div>
<div class="seoBox49 suggestionBox">
'.$pageSpeedInsightMobile_Msg.'
</div> 
</div>';

//Get Final Score Data
$sec_score = decSerBase($dataSec['score']); 
$sec_passScore = $sec_score[0];
$sec_improveScore = $sec_score[1];
$sec_errorScore = $sec_score[2];

//Get the data
$date_raw = date_create(Trim($dataSec['date']));
$secDate = date_format($date_raw,"jS F Y");

//Login Access Check
if(!isset($_SESSION['twebUsername'])){
    if($enable_reg){
        foreach($reviewerSettings['reviewer_list'] as $reviewer)
            ${'sec_'.$reviewer} = $seoBoxLogin;
    }
}