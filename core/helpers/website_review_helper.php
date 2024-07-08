<?php

/*
* @author MD ARIFUL HAQUE
* @name KOVATZ Seo Tools - PHP Script
* @copyright 2022 KOVATZ.COM
*
*/

function addToRecentSites($con,$domain,$ip,$username,$other){
    $domain = escapeTrim($con, $domain);
    $date = date('m/d/Y h:i:sA');  
    
    if(insertToDbPrepared($con, 'recent_history', array('visitor_ip' => $ip, 'domain_name' => $domain, 'username' => $username, 'date' => $date, 'other' => $other)))
        return false;
    else
        return true;
}

function addToComRecentSites($con,$firstDomain,$secDomain,$ip,$username){
    $firstDomain = escapeTrim($con, $firstDomain);
    $secDomain = escapeTrim($con, $secDomain);

    $row = mysqliPreparedQuery($con, "SELECT * FROM comp_recent_history WHERE first_domain=? AND sec_domain=?", 'ss', array($firstDomain, $secDomain));    
    if($row === false){
        $date = date('m/d/Y h:i:sA');
        if(insertToDbPrepared($con, 'comp_recent_history', array('visitor_ip' => $ip, 'first_domain' => $firstDomain, 'sec_domain' => $secDomain, 'username' => $username, 'date' => $date)))
            return false;
        else
            return true;
    }else{
        return false;
    }
}

function outQuestionBox($str){
    echo '<div class="questionBox" data-original-title="'.$str.'" data-toggle="tooltip" data-placement="top">
        <i class="fa fa-question-circle grayColor"></i>
    </div>';
}

function ordinalNum($num) {
    $num = (int)$num;
    // Special case "teenth"
    if ( ($num / 10) % 10 != 1 )
    {
        // Handle 1st, 2nd, 3rd
        switch( $num % 10 )
        {
            case 1: return $num . 'st';
            case 2: return $num . 'nd';
            case 3: return $num . 'rd'; 
        }
    }
    // Everything else is "nth"
    return number_format($num) . 'th';
}

function outHeadBox($title,array $sugMsg, $type){
    if($type == 1){
        $solveMsg = $sugMsg[0]; 
        $one = 'solveMsgBlue';
        $two = '';
        $three = '';
     }elseif($type == 2){
        $solveMsg = $sugMsg[1]; 
        $one = 'solveMsgBlue';
        $two = 'solveMsgBlue';
        $three = '';
     }elseif($type == 3){
        $solveMsg = $sugMsg[2]; 
        $one = 'solveMsgBlue';
        $two = 'solveMsgBlue';
        $three = 'solveMsgBlue';
     }else{
        $solveMsg = $sugMsg[3]; 
        $one = '';
        $two = '';
        $three = '';
     }
     
    echo '<div class="headBox clearfix">
            <h4 class="titleStr">'.$title.'</h4>
            <h4 class="solveMsg" data-original-title="'.$solveMsg.'" data-toggle="tooltip" data-placement="top">
                <i class="fa fa-gear fa-xs '.$one.'"></i>
                <i class="fa fa-gear fa-xs '.$two.'"></i>
                <i class="fa fa-gear fa-xs '.$three.'"></i>
            </h4>
         </div>';
}

function storeMobilePreview($site,$data){
    $name = HEL_DIR.'mobile_preview'.D_S.$site.'.tdata';
    putMyData($name,$data);
    return true;
}

function getMobilePreview($site){
    $name = HEL_DIR.'mobile_preview'.D_S.$site.'.tdata';
    if(file_exists($name))
        return getMyData($name);  
    return '';
}

function reviewerSettings($con){
    $query = mysqli_query($con, "SELECT * FROM reviewer_settings WHERE id='1'");
    return mysqli_fetch_array($query);
}

function isAllowedStats($con,$reviewer){
    $orderData = reviewerSettings($con);
    $orderData['reviewer_list'] = unserialize($orderData['reviewer_list']);
    
    if (in_array($reviewer, $orderData['reviewer_list']))
        return false;
    else
        return true;
}

function capPages(){
    
    $arr = array(
        'register_page' => 'Registration Page', 
        'login_page' => 'Login Page', 
        'contact_page' => 'Contact Us Page', 
        'reviewer_page' => ' Index Reviewer Page', 
        'competitive_page' => 'Competitive Analysis Page', 
        'reset_pass_page' => 'Forgot Password Page', 
        'resend_act_page' => 'Resend Activation Mail Page'
    );
    return $arr;
}

function getBadWordsList($con){
    $curArr = $dominBadWordArr = $titleBadWordArr = $desBadWordArr = $keyBadWordArr = array();
    $badWordsData =  mysqli_query($con, "SELECT words FROM domain_restriction WHERE id='1'");
    $badWordsDataDB = mysqli_fetch_array($badWordsData);
    $badWordList = decSerBase(Trim($badWordsDataDB['words']));
    foreach($badWordList as $badWord){
        $curArr = explode(',',$badWord[0]);
        if(isSelected($badWord[2]))
            $dominBadWordArr = array_merge($dominBadWordArr, $curArr);
        if(isSelected($badWord[3]))
            $titleBadWordArr = array_merge($titleBadWordArr, $curArr);
        if(isSelected($badWord[4]))
            $desBadWordArr = array_merge($desBadWordArr, $curArr);
        if(isSelected($badWord[5]))
            $keyBadWordArr = array_merge($keyBadWordArr, $curArr);
    }
    return array($dominBadWordArr,$titleBadWordArr,$desBadWordArr,$keyBadWordArr);
}

function getBannedDomainList($con){
    $badWordsData =  mysqli_query($con, "SELECT domains FROM domain_restriction WHERE id='1'");
    $badWordsDataDB = mysqli_fetch_array($badWordsData);
    return dbStrToArr($badWordsDataDB['domains']);
}

function getDomainRestriction($con){
    $curArr = $dominBadWordArr = $titleBadWordArr = $desBadWordArr = $keyBadWordArr = $bannedDomains = array();
    $badWordsData =  mysqli_query($con, "SELECT * FROM domain_restriction WHERE id='1'");
    $badWordsDataDB = mysqli_fetch_array($badWordsData);
    $badWordList = decSerBase(Trim($badWordsDataDB['words']));
    foreach($badWordList as $badWord){
        $curArr = explode(',',$badWord[0]);
        if(isSelected($badWord[2]))
            $dominBadWordArr = array_merge($dominBadWordArr, $curArr);
        if(isSelected($badWord[3]))
            $titleBadWordArr = array_merge($titleBadWordArr, $curArr);
        if(isSelected($badWord[4]))
            $desBadWordArr = array_merge($desBadWordArr, $curArr);
        if(isSelected($badWord[5]))
            $keyBadWordArr = array_merge($keyBadWordArr, $curArr);
    }
    $bannedDomains = array_keys(dbStrToArr($badWordsDataDB['domains']));
    return array($dominBadWordArr,$titleBadWordArr,$desBadWordArr,$keyBadWordArr,$bannedDomains);
}

function getReviewerList(){
    
    $arr = array(
        'seoBox1' => 'Meta Data Information',
        'seoBox4' => 'Headings',
        'seoBox5' => 'Google Preview',
        'seoBox6' => 'Alt Attribute',
        'seoBox7' => 'Keywords Cloud',
        'seoBox8' => 'Keyword Consistency',
        'seoBox9' => 'Text/HTML Ratio',
        'seoBox10' => 'GZIP Compression',
        'seoBox11' => 'WWW Resolve',
        'seoBox12' => 'IP Canonicalization',
        'seoBox13' => 'In-Page Links',
        'seoBox14' => 'Broken Links',
        'seoBox15' => 'XML Sitemap',
        'seoBox16' => 'Robots.txt',
        'seoBox17' => 'URL Rewrite',
        'seoBox18' => 'Underscores in the URLs',
        'seoBox19' => 'Embedded Objects',
        'seoBox20' => 'Iframe',
        'seoBox21' => 'Domain Registration',
        'seoBox22' => 'WHOIS Data',
        'seoBox23' => 'Mobile Friendliness',
        'seoBox24' => 'Mobile View',
        'seoBox25' => 'Mobile Compatibility',
        'seoBox28' => 'Custom 404 Page',
        'seoBox29' => 'Page Size',
        'seoBox30' => 'Load Time',
        'seoBox31' => 'Language',
        'seoBox32' => 'Domain Availability',
        'seoBox33' => 'Typo Availability',
        'seoBox34' => 'Email Privacy',
        'seoBox35' => 'Safe Browsing',
        'seoBox36' => 'Server IP',
        'seoBox37' => 'Speed Tips',
        'seoBox38' => 'Analytics',
        'seoBox39' => 'W3C Validity',
        'seoBox40' => 'Doc Type',
        'seoBox41' => 'Encoding',
        'seoBox42' => 'Indexed Pages',
        'seoBox43' => 'Backlinks Counter',
        'seoBox44' => 'Social Data',
        'seoBox45' => 'Estimated Worth',
        'seoBox46' => 'Traffic Rank',
        'seoBox47' => 'Visitors Localization',
        'seoBox48' => 'PageSpeed Insights (Desktop)',
        'seoBox49' => 'PageSpeed Insights (Mobile)'
    );
    return $arr;
}

//-------------------------PDF-------------------------

function strEOL($str){
    return str_replace(array('\r\n','\n','\r'),PHP_EOL,$str);
}

function imgTag($path,$echo=true,$alt=null){
    if(is_null($alt)){
        if($echo)
            echo '<img src="'.$path.'" />';
        else
            return '<img src="'.$path.'" />';
    }else{
        if($echo)
            echo '<img alt="'.$alt.'" src="'.$path.'" />';
        else
            return '<img alt="'.$alt.' src="'.$path.'" />';
    }    
}

function pdfOutBox($title,array $starData, $type, $mainData, $sugClass, array $sugData, $sugMsg,$exData=null){
    $exCode = '';
    if($type == 1)
        $star = $starData[0]; 
     elseif($type == 2)
        $star = $starData[1]; 
     elseif($type == 3)
        $star = $starData[2]; 
     else
        $star = $starData[3]; 
        
     if($sugClass == 'passedBox')
        $sugType =  $sugData[0];
     elseif($sugClass == 'improveBox')
        $sugType =  $sugData[1];
     elseif($sugClass == 'errorBox')
        $sugType =  $sugData[2];
     else
        $sugType =  $sugData[3];
     
     
    if(!is_null($exData)){
        $exCode = $exData;
    } 
      
    $outData = '<br /><br /><bookmark title="'.$title.'" level="2" ></bookmark>   
    <table style="width: 100%;" class="icons">
	   <tr class="tableBody">
		<td style="width: 4.5%;"> '.$sugType.' </td>
		<td class="sideHead" style="width: 20%;">
            '.$title.' <br />
            '.$star.'
        </td>
		<td style="width: 75.5%;">'.$mainData.'</td>      
 	  </tr>                       
     </table>
      '.$exCode.'
    <div class="suggestionBox '.$sugClass.'">
            '.$sugMsg.'
    </div>';
    echo $outData;
    
}

function pdfHeadBox($leftTitle,$rightTitle){
    
    $outData = '<page_header>
        <bookmark title="'.$leftTitle.'" level="1" ></bookmark>
        <table class="page_header">
            <tr>
                <td style="font-family: freeserif; width: 50%; text-align: left"> '.$leftTitle.' </td>
                <td style="font-family: freeserif; width: 47%; text-align: right"> '.$rightTitle.' </td>
            </tr>
        </table>
    </page_header>';
    return $outData;
}