<?php

defined('PDF_DOMAIN') or die(header('HTTP/1.1 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name KOVATZ Seo Tools - PHP Script
 * @copyright 2022 KOVATZ.COM
 *
 */

//Check Domain Name Exists
$data = mysqliPreparedQuery($con, "SELECT domain,date,meta_data,headings,image_alt,keywords_cloud,ratio_data,gzip,resolve,ip_can,links_analyser,broken_links,robots,sitemap,embedded,iframe,whois,mobile_fri,mobile_com,404_page,load_time,domain_typo,email_privacy,safe_bro,server_loc,speed_tips,analytics,w3c,encoding,indexed,alexa,social,visitors_loc,page_speed_insight,score,completed FROM domains_data WHERE domain=?",'s',array($domainStr));
if($data !== false){
    
    //Meta Data  
    $meta_data = decSerBase($data['meta_data']);
    
    $title = $meta_data[0];
    $description = $meta_data[1];
    $keywords = $meta_data[2];
    
    $lenTitle = mb_strlen($title,'utf8');
    $lenDes = mb_strlen($description,'utf8');
    
    //Check Empty Data
    $site_title = ($title == '' ? $lang['AN11'] : $title);
    $site_description = ($description == '' ? $lang['AN12'] : $description);
    $site_keywords = ($keywords == '' ? $lang['AN15'] : $keywords);
    
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
    $seoBox1 = $site_title.'<br /><br /><b>'.$lang['AN13'].':</b> '.$lenTitle.' '.$lang['AN14'];
    $seoBox2 = $site_description.'<br /><br /><b>'.$lang['AN13'].':</b> '.$lenDes.' '.$lang['AN14'];
    $seoBox3 =  $site_keywords.'<br /><br />';
    $seoBox5 = '<div class="googlePreview">
    		<p class="class1">'.$site_title.'</p>
    		<p class="class2"><span class="bold">'.$domainStr.'</span>/</p>
    		<p>'.$site_description.'</p>
            </div>';
            
    //Heading Data 
    $headings = decSerBase($data['headings']);
    
    //Get H1 to H6 Tags
    $tags = array ('h1', 'h2', 'h3', 'h4', 'h5', 'h6');
    $h1Count = $h2Count = $h3Count = $h4Count = $h5Count = $h6Count = 0;
    $elementListData = $headings[0];
    $texts = $headings[1];
    $hideClass = $headStr = $exData = '';
    
    foreach($tags as $tag)
    {
    if (isset($elementListData[$tag])) {
      foreach($elementListData[$tag] as $element)
      {            
        $exClass= '';
        if(strlen($exData)<120){
            $exData = '&lt;'.$element[0].'&gt; '.Trim($element[1]).' &lt;/'.$element[0].'&gt;';
            $exClass= '';
        }else{
            $exData = wordwrap('&lt;'.$element[0].'&gt; '.Trim($element[1]).' &lt;/'.$element[0].'&gt;', 120, '<br>', true);
            $exClass = 'style="margin-top: 4mm;"';
        }
         if(Trim($element[1]) != '')
            $headStr.= '<div class="exBox" '.$exClass.'><div class="exBoxLeft"></div> <div class="exBoxRight">'.$exData.'</div></div>';
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
        $classHead = 'improveBox';
    elseif($h1Count != 0 && $h2Count != 0 )
        $classHead = 'passedBox';
    else
        $classHead = 'errorBox';

    $seoBox4 = '<table class="headTable">
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
            </table><br><br>';
    $headExData = $headStr;
    
    //Image without Alt Tag
    $image_alt = decSerBase($data['image_alt']);
    
    $imageCount = $image_alt[0];
    $imageWithOutAltTag = 0;
    $hideClass = $imageWithOutAltTagData = '';
    $imageMsg = $lang['AN178'];
    $imgArr = $image_alt[2];
    
    foreach($imgArr as $imgLink){
        if($imageWithOutAltTag == 3)
            $hideClass = 'hideTr hideTr2';
               
        $exClass= '';
        if(strlen($imgLink)<120){
            $exData = $imgLink;
            $exClass= '';
        }else{
            $exData = wordwrap($imgLink, 120, '<br>', true);
            $exClass = 'style="margin-top: 4mm;"';
        }
        
        $imageWithOutAltTagData .= '<div class="exBox" '.$exClass.'><div class="exBoxLeft"></div><div class="exBoxRight">'.$exData.'</div></div>';
        //$imageWithOutAltTagData .= '<table class="linkan"><tr><td style="width: 24.5%;"></td><td style="width: 75.5%;">'.$imgLink.'</td></tr></table>';
        $imageWithOutAltTag++;
    }
    
    $imageWithOutAltTag = $image_alt[1];
    
    if($imageWithOutAltTag == 0)
        $altClass = 'passedBox';
    elseif($imageWithOutAltTag < 2)
        $altClass = 'improveBox';
    else
        $altClass = 'errorBox';
    
    
    $seoBox6 = str_replace('[image-count]',$imageCount,$lang['AN21']).' <br />
        <div class="altImgGroup"> 
        '.(($imageWithOutAltTag == 0)? '
        <img src="'.$trueLink.'" alt="'.$lang['AN24'].'" title="'.$lang['AN25'].'" /> '.$lang['AN27'].'</div><br />': ' 
        <img src="'.$falseLink.'" alt="'.$lang['AN23'].'" title="'.$lang['AN22'].'" />
         '.str_replace('[missing-alt-tag]',$imageWithOutAltTag,$lang['AN26']).'
        </div>
        <br /><br />');
    $imgExData  = $imageWithOutAltTagData;
    
    //Keyword Cloud
    $keywords_cloud = decSerBase($data['keywords_cloud']);
    $outCount = $keywords_cloud[0];
    $outArr = $keywords_cloud[1];
    $keyData = '';
    
    $countKey = 0;     
    foreach($outArr as $outData){
        if($countKey == 5){
             $keyData .= '<br><br>';
             $countKey = 0;  
        }
        $keyData .= '<span class="keywordstag"><span class="keyword">&nbsp;'.$outData[0].'&nbsp;</span><span class="number">&nbsp;'.$outData[1].'&nbsp;</span></span>';
        $countKey++;
    }
        
    $keycloudClass = 'lowImpactBox';
    $keyCloudMsg = $lang['AN179'];
    
    $seoBox7 = (($outCount != 0)? '
  
              '.$keyData.'  
        ' : ' '.$lang['AN29']);
        
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
        
    $keyConsMsg = $lang['AN180'];
    
    $seoBox8 = '<table class="keyTable">
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
        </table>';
    
    //Text to HTML Ratio
    $textRatio = decSerBase($data['ratio_data']);
    
    if(round($textRatio[2]) < 2)
        $textClass = 'errorBox';
    elseif(round($textRatio[2]) < 10)
        $textClass = 'improveBox';
    else
        $textClass = 'passedBox';
        
    $textMsg = $lang['AN181'];
    
    $seoBox9 = $lang['AN36'].': <b>'.round($textRatio[2],2).'%</b><br />
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
        </table><br /><br />';

    //Check GZIP Compression 
    $gzipClass = $gzipHead = $gzipBody = '';
    $outData = decSerBase($data['gzip']);
    $comSize = $outData[0];
    $unComSize = $outData[1];
    $isGzip = $outData[2];
    $gzdataSize = $outData[3];
    $header = $outData[4];
    $body = Trim($outData[5]);
    
    if($body == ''){
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
                
    $seoBox10 = $gzipHead.'
        <br />
        <div class="altImgGroup">
            '.$gzipBody.'
        </div>
        <br /><br />';
    
    
    //WWW Resolve
    $resolve = decSerBase($data['resolve']);
    
    $www_resolveMsg = $lang['AN183'];
    $resolveClass = 'improveBox';
    $resolveMsg = $lang['AN47'];
    $re301 = false;
    $url_with_www = "http://www.$my_url_host";
    $url_no_www = "http://$my_url_host";
    
    $data1 = $resolve[0];
    $data2 = $resolve[1];
    
    
    if($data1 =='301'){
        $re301 = true;
        $resolveClass = 'passedBox';
        $resolveMsg = $lang['AN46'];
    }
    
    if($data2 =='301'){
        $re301= true;
        $resolveClass = 'passedBox';
        $resolveMsg = $lang['AN46'];
    }
    
    $seoBox11 = $resolveMsg.'<br /><br />';

    //IP Canonicalization
    $ip_can = decSerBase($data['ip_can']);
    
    $ip_canMsg = $lang['AN184'];
    $ipClass = 'improveBox';
    $hostIP = $ipMsg = '';
    $tType = $ip_can[1];
    $redirectURLhost = $ip_can[3];
    $hostIP = $ip_can[0];
    
    if($tType){
        if($my_url_host == $redirectURLhost){
            $ipMsg = str_replace(array('[ip]','[host]'),array($hostIP,$my_url_host),$lang['AN50']);
            $ipClass = 'passedBox';
        }else{
           $ipMsg = str_replace(array('[ip]','[host]'),array($hostIP,$my_url_host),$lang['AN49']); 
        }
        $tType = true;
    }else{
        $ipMsg = str_replace(array('[ip]','[host]'),array($hostIP,$my_url_host),$lang['AN49']);
    }
    
    $seoBox12 = $ipMsg.'<br /><br />';

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
    
    $ex_data = decSerBase($data['links_analyser']);
    
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
                && substr($link['href'], 0, 2) != "//" && substr($link['href'], 0, 6) != "mailto" && substr($link['href'], 0, 10) != "javascript") { 
                
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
   
    $exClass = '';
    $loop = 0;
    $inPageData.= '<div class="exBox"><div class="exBoxLeft"></div> <div class="exBox1 f5 bold">'.$lang['AN54'].'</div> <div class="exBox2 f5 bold">'.$lang['AN55'].'</div> <div class="exBox3 f5 bold">'.$lang['AN56'].'</div></div>';
    
    foreach($int_data as $internalData){
        if($loop == 0){
            $exClass = '';
            $loop = 1;
        }else{
            $exClass = '';
            $loop = 0;
        }
        $internalData['href'] = strip_tags($internalData['href']);
        $internalData['text'] = strip_tags($internalData['text']);
        $link = '<a href="'.$internalData['href'].'">'.($internalData['text']=='' ? 'No Anchor Text' : $internalData['text']).'</a>';        
        //$inPageData.= '<div class="exBox"><div class="exBoxLeft"></div> <div class="exBox1 '.$exClass.'">'.$link.'</div> <div class="exBox2 '.$exClass.'">'.$internalData['inorout'].'</div> <div class="exBox3 '.$exClass.'">'.ucfirst($internalData['follow_type']).'</div></div>';
        $inPageData .= '<table style="width: 100%;"><tr><td style="width: 24.5%;"></td><td style="width: 45.5%;">'.$link.'</td><td style="width: 15%;">'.$internalData['inorout'].'</td><td style="width: 15%;">'.ucfirst($internalData['follow_type']).'</td></tr></table>';
    }
    
    foreach($ext_data as $externalData){
        if($loop == 0){
            $exClass = '';
            $loop = 1;
        }else{
            $exClass = '';
            $loop = 0;
        }
        $externalData['href'] = strip_tags($externalData['href']);
        $externalData['text'] = strip_tags($externalData['text']);
        $link = '<a href="'.$externalData['href'].'">'.($externalData['text']=='' ? 'No Anchor Text' : $externalData['text']).'</a>';        
        //$inPageData.= '<div class="exBox"><div class="exBoxLeft"></div> <div class="exBox1 '.$exClass.'">'.$link.'</div> <div class="exBox2 '.$exClass.'">'.$externalData['inorout'].'</div> <div class="exBox3 '.$exClass.'">'.ucfirst($externalData['follow_type']).'</div></div>';
        $inPageData .= '<table class="linkan"><tr><td style="width: 24.5%;"></td><td style="width: 45.5%;">'.$link.'</td><td style="width: 15%;">'.$externalData['inorout'].'</td><td style="width: 15%;">'.ucfirst($externalData['follow_type']).'</td></tr></table>';
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
        
    $seoBox13 =  $inPageMsg.'<br /><br />';
    
    $seoBox17 = $urlRewritingMsg.'<br /><br />';
    
    $seoBox18 = $linkUnderScoreMsg.'<br /><br />';
    
    //Broken Links
    $bLinks = decSerBase($data['broken_links']);
    $broken_Msg = $lang['AN186'];
    $brokenLinksData = $hideMe = $brokenMsg = $brokenClass = $brokenLinks = '';
    $totalDataCount = 0;
    
    foreach($bLinks as $bLink){
        $brokenLinks .= '<table class="linkan"><tr><td style="width: 24.5%;"></td><td style="width: 75.5%;">'.$bLink.'</td></tr></table>';
        $totalDataCount++;
    }
    
    if($totalDataCount == 0){
        $brokenClass = 'passedBox';
        $brokenMsg = $lang['AN68'];
    }else{
        $brokenClass = 'errorBox';
        $brokenMsg = $lang['AN69'];
    }
        
    $seoBox14 = $brokenMsg.'<br /><br />';
    $brokenLinksData = $brokenLinks;
    
    //Robots.txt Checker
    $robot_Msg = $lang['AN187'];
    $robotLink = $robotMsg = $robotClass = '';
    
    $robotLink = $inputHost .'/robots.txt';
    $httpCode = base64_decode($data['robots']);
    
    if($httpCode == '404'){
        $robotClass = 'errorBox';
        $robotMsg = $lang['AN74'] . '<br>' . '<a href="'.$robotLink.'" title="'.$lang['AN75'].'" rel="nofollow" target="_blank">'.$robotLink.'</a>';
    }else{
        $robotClass = 'passedBox';
        $robotMsg = $lang['AN73'] . '<br>' . '<a href="'.$robotLink.'" title="'.$lang['AN75'].'" rel="nofollow" target="_blank">'.$robotLink.'</a>';
    }
    
    $seoBox16 = $robotMsg.'<br /><br />';
    
    
    //Sitemap Checker
    $sitemap_Msg = $lang['AN188'];
    $sitemapLink = $sitemapMsg = $sitemapClass = '';
    
    $sitemapLink = $inputHost .'/sitemap.xml';
    $httpCode = base64_decode($data['sitemap']);
    
    if($httpCode == '404'){
        $sitemapClass = 'errorBox';
        $sitemapMsg = $lang['AN71'] . '<br>' . '<a href="'.$sitemapLink.'" title="'.$lang['AN72'].'" rel="nofollow" target="_blank">'.$sitemapLink.'</a>';
    }else{
        $sitemapClass = 'passedBox';
        $sitemapMsg = $lang['AN70'] . '<br>' . '<a href="'.$sitemapLink.'" title="'.$lang['AN72'].'" rel="nofollow" target="_blank">'.$sitemapLink.'</a>';
    }
    
    $seoBox15 = $sitemapMsg.'<br /><br />';
    
    //Embedded Object Check
    $embedded_Msg = $lang['AN191'];
    $embeddedMsg = $embeddedClass = '';
    $embeddedCheck = false;
    
    $embeddedCheck = filter_var($data['embedded'], FILTER_VALIDATE_BOOLEAN);
    
    if($embeddedCheck){
        $embeddedClass = 'errorBox';
        $embeddedMsg = $lang['AN78'];
    }else{
        $embeddedClass = 'passedBox';
        $embeddedMsg = $lang['AN77'];
    }
    
    $seoBox19 = $embeddedMsg.'<br /><br />';
    
    //iframe Check
    $iframe_Msg = $lang['AN192'];
    $iframeMsg = $iframeClass = '';
    $iframeCheck = false;
        
    $iframeCheck = filter_var($data['iframe'], FILTER_VALIDATE_BOOLEAN);
    
    if($iframeCheck){
        $iframeClass = 'errorBox';
        $iframeMsg = $lang['AN80'];
    }else{
        $iframeClass = 'passedBox';
        $iframeMsg = $lang['AN79'];
    }
    
    $seoBox20 = $iframeMsg.'<br /><br />';
    
    //WHOIS Data
    $domainClass = 'lowImpactBox';
    $whoisData = $hideMe = '';
    $totalDataCount = 0;
    $domainAgeMsg = $lang['AN193'];
    $whoisDataMsg = $lang['AN194'];
    
    $whois_data = decSerBase($data['whois']);
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
    
    $seoBox21 = $lang['AN85'].'<br /><br />
        <div class="altImgGroup">
            <p>'.$lang['AN86'].': '.$domainAge.'</p>
            <p>'.$lang['AN87'].': '.$createdDate.'</p>
            <p>'.$lang['AN88'].': '.$updatedDate.'</p>
            <p>'.$lang['AN89'].': '.$expiredDate.'</p>
        </div>';
        
    //Mobile Friendliness
    $isMobileFriendlyMsg = '';
    $mobileClass = $mobileScreenClass = 'lowImpactBox';
    
    $mobileCheckMsg = $lang['AN195'];
    $mobileScreenClassMsg = $lang['AN196'];;
    
    $mobData = decSerBase($data['mobile_fri']);
    $mobileScore = $mobData[0];
    $isMobileFriendly = filter_var($mobData[1], FILTER_VALIDATE_BOOLEAN);
    
    if($isMobileFriendly){
        $mobileClass = 'passedBox';
        $isMobileFriendlyMsg.=$lang['AN116'].'<br>'.str_replace('[score]',$mobileScore,$lang['AN117']);
    }else{
        $mobileClass = 'errorBox';
        $isMobileFriendlyMsg.=$lang['AN118'].'<br>'.str_replace('[score]',$mobileScore,$lang['AN117']);
    }
    
    $screenData = getMobilePreview($domainStr);
    if($screenData == '')
        $mobileScreenData = '';
    else
        $mobileScreenData  = '<img src="data:image/jpeg;base64,'.$screenData.'" />';
    
    $seoBox23 = $isMobileFriendlyMsg.'<br /><br />';
    
    $seoBox24 = '<br />'.$mobileScreenData.'<br /><br />';
    
    //Mobile Compatibility  
    $mobileCom_Msg = $lang['AN197'];
    $mobileComMsg = $mobileComClass = '';
    $mobileComCheck = false;
        
    $mobileComCheck = filter_var($data['mobile_com'], FILTER_VALIDATE_BOOLEAN);
    
    if($mobileComCheck){
        $mobileComClass = 'errorBox';
        $mobileComMsg = $lang['AN121'];
    }else{
        $mobileComClass = 'passedBox';
        $mobileComMsg = $lang['AN120'];
    }
    
    $seoBox25 = $mobileComMsg.'<br /><br />';
    
    //URL Length & Favicon 
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
    $favIconMsg = '<img src="http://www.google.com/s2/favicons?domain='.$my_url.'" alt="FavIcon" />  '.$lang['AN123'];
    
    $seoBox26 = $urlLengthMsg.'<br /><br />';

    $seoBox27 = $favIconMsg.'<br /><br />';
    
    
    //Custom 404 Page Checker
    $errorPage_Msg = $lang['AN200'];
    $errorPageMsg = $errorPageClass = '';
    $errorPageCheck = false;
    
    $pageSize = base64_decode($data['404_page']);
    
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
    
    $seoBox28 = $errorPageMsg.'<br /><br />';
    
    //Page Size / Load Time / Language
    $size_Msg = $lang['AN201'];
    $load_Msg = $lang['AN202'];
    $lang_Msg = $lang['AN203'];
    
    $sizeMsg = $loadMsg = $langMsg = '';
    $langCode = null;
    
    $load_time_data = decSerBase($data['load_time']);
    $timeTaken = $load_time_data[0];
    $dataSize = $load_time_data[1];
    $langCode = $load_time_data[2];
    
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
    
    $seoBox29 = $sizeMsg.'<br /><br />';
    
    $seoBox30 = $loadMsg.'<br /><br />';
    
    $seoBox31 = $langMsg.'<br /><br />';
    
    //Domain & Typo Availability Checker
    $domain_Msg = $lang['AN204'];
    $typo_Msg = $lang['AN205'] ;
    $typoMsg = $domainMsg = '';
    $typoClass = $domainClass = 'lowImpactBox';
    
    $domain_typo = decSerBase($data['domain_typo']);
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
    
    $seoBox32 = '<table class="lite">
            <tbody>
                <tr> <th>'.$lang['AN134'].'</th> <th>'.$lang['AN135'].'</th> </tr> 
                '.$domainMsg.'
            </tbody>
        </table>
        <br />';
    
    $seoBox33 = '<table class="lite">
            <tbody>
                <tr> <th>'.$lang['AN134'].'</th> <th>'.$lang['AN135'].'</th> </tr> 
                '.$typoMsg.'
            </tbody>
        </table>
        <br />';
        
    //Email Privacy    
    $emailPrivacy_Msg = $lang['AN206'];
    $emailPrivacyMsg = $emailPrivacyClass = '';
    
    $emailCount = $data['email_privacy'];
    
    if($emailCount == 0){
        //No Email
        $emailPrivacyClass = 'passedBox';
        $emailPrivacyMsg = $lang['AN136'];
    }else{
        //Emails Found
        $emailPrivacyClass = 'errorBox';
        $emailPrivacyMsg = $lang['AN137'];
    }
             
    $seoBox34 = $emailPrivacyMsg.'<br /><br />';
    
    //Safe Browsing
        
    $safeBrowsing_Msg = $lang['AN207'];
    $safeBrowsingMsg = $safeBrowsingClass = '';
    
    $safeBrowsingStats = $data['safe_bro'];
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
    
    $seoBox35 = $safeBrowsingMsg.'<br /><br />';
    
    //Server Location Information
    $serverIP_Msg = $lang['AN208'];
    $serverIPClass = 'lowImpactBox';
    
    $getHostIP = gethostbyname($my_url_host);
    $data_list = decSerBase($data['server_loc']);
    $domain_ip = $data_list[0];
    $domain_country =  $data_list[1];
    $domain_isp = $data_list[2];
                
    $seoBox36 = '<table class="lite">
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
        <br /><br />';
        
    //Speed Tips 
    $speedTips_Msg = $lang['AN209'];
    $speedTipsMsg = $speedTipsBody = '';    
    $speedTipsCheck = $cssCount = $jsCount = 0;
    
    $speedData = decSerBase($data['speed_tips']);
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
             
    $seoBox37 = $speedTipsMsg.'<br /><br />'.$speedTipsBody.'<br />';
    
    //Analytics & Doc Type  
    $docType_Msg = $lang['AN212'];
    $analytics_Msg = $lang['AN210'];
    $docType = $analyticsClass = $analyticsMsg = $docTypeClass = $docTypeMsg = '';   
    $anCheck = false;
    $docCheck = false;
    
    $anDataArr = decSerBase($data['analytics']);
    
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
    
    $seoBox38 = $analyticsMsg.'<br /><br />';
             
    $seoBox40 = $docTypeMsg.'<br /><br />';
    
    
    //W3C Validity    
    $w3c_Msg = $lang['AN211'];
    $w3Data = $w3cMsg = '';
    $w3cClass = 'lowImpactBox';
    $w3DataCheck = 0;
    
    $w3DataCheck = Trim($data['w3c']);
    
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
    
    $seoBox39 = $w3cMsg.'<br /><br />';
    
    //Encoding Type
    $encoding_Msg = $lang['AN213'];
    $encodingMsg = $encodingClass = '';
    $charterSet = null;
    
    $charterSet = base64_decode($data['encoding']);
    
    if($charterSet!=null){
        $encodingClass = 'passedBox';
        $encodingMsg = $lang['AN159'] . ' '. $charterSet;
    }
    else{ 
        $encodingClass = 'errorBox';
        $encodingMsg = $lang['AN160'];
    }
    
    $seoBox41 = $encodingMsg.'<br /><br />';
    
    //Indexed Pages
    $indexedPages_Msg = $lang['AN214'];
    $indexProgress = $indexedPagesMsg = $indexedPagesClass = '';
    $datVal = $outData = 0;
    
    $outData = base64_decode($data['indexed']);

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
    
    $indexedPagesMsg = '<div style="width:'.$datVal.'%" class="badge '.$indexProgress.'">
        '.number_format($outData).' '.$lang['AN162'].'
    </div>';
        
    $seoBox42 = $lang['AN161'].'<br />   <br /> 
          <div class="exBox"><div class="exBoxLeft"></div>
            '.$indexedPagesMsg.'</div><br />';

    //Backlink Counter / Traffic / Worth 
    $backlinks_Msg = $lang['AN215'];
    $alexa_Msg =  $lang['AN218'];
    $worth_Msg =  $lang['AN217'];
    $alexaMsg = $worthMsg = $backProgress = $backlinksMsg = $backlinksClass = '';
    $alexaClass = $worthClass = 'lowImpactBox';
    
    $alexa = decSerBase($data['alexa']);
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
    
    $backlinksMsg = '<div style="width:'.$datVal.'%" class="badge '.$backProgress.'">
        '.number_format($alexa_back).' '.$lang['AN163'].'
    </div>';
    
    if($alexa_rank == 'No Global Rank')
        $alexaMsg = $lang['AN165'];
    else
        $alexaMsg = ordinalNum(str_replace(',','',$alexa_rank)) . ' '. $lang['AN164'];
    
    $alexa_rank = ($alexa_rank == 'No Global Rank' ? '0' : $alexa_rank);
    $worthMsg = "$". number_format(calPrice($alexa_rank))." USD";
                
    $seoBox43 = $lang['AN166'].'<br />   <br /> 
          <div class="exBox"><div class="exBoxLeft"></div>
            '.$backlinksMsg.'</div><br />';
    
    $seoBox45 = $worthMsg.'<br /><br />';
    
    $seoBox46 = $alexaMsg.'<br /><br />';
    
    //Social Data
    $social_Msg = $lang['AN216'];
    $socialMsg = '';
    $socialClass = 'lowImpactBox';
    
    $social_count = decSerBase($data['social']);
    $facebook_like = $social_count[0];
    $twit_count = $social_count[1];
    $insta_count = $social_count[2];

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

    $socialMsg = $lang['AN167'];  
            
    $seoBox44 = $socialMsg.'<br />
            <br>'.$facebookIcon.' Facebook: '.$facebook_like.'<br>
            <br>'.$plusoneIcon.' Twitter: '.$twit_count.'<br>
            <br>'.$linkedinIcon.' Instagram: '.$insta_count.'<br>
        <br /><br />';
        
    //Visitors Localization
    $visitors_Msg = $lang['AN219'];
    $visitorsMsg = '';
    $visitorsClass = 'lowImpactBox';
    
    $alexaDatas = decSerBase($data['visitors_loc']); 
    $alexaDataCount = count($alexaDatas);
    
    foreach($alexaDatas as $alexaData)
        $visitorsMsg.='<tr><td>'.$alexaData[1].'</td><td>'.$alexaData[2].'</td></tr>';
    
    $seoBox47 = $lang['AN171'] .'<br /><br />
        '.(($alexaDataCount != 0)? '
        <table class="lite">
            <tbody>
                <tr> 
                    <th>'.$lang['AN168'].'</th> 
                    <th>'.$lang['AN169'].'</th>
                </tr>
                '.$visitorsMsg.'
            </tbody>
        </table>' : $lang['AN170']).'
        <br />';
   
    //Get Final Score Data
    $score = decSerBase($data['score']); 
    $passScore = $score[0];
    $improveScore = $score[1];
    $errorScore = $score[2];
    
    //Get the data
    $date_raw = date_create(Trim($data['date']));
    $disDate = date_format($date_raw,"Y-m-d");

}else{
    die('Domain Not Found');
}