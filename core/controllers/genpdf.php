<?php
defined('APP_NAME') or die(header('HTTP/1.1 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name KOVATZ Seo Tools - PHP Script
 * @copyright 2021 KOVATZ.COM
 *
 */

//Login Check
if(!isset($_SESSION['twebAdminToken'])){
    if($enable_reg){
        if(!isset($_SESSION['twebUsername'])){
          redirectTo(createLink('account/login',true));
          die();
        }
    }
}

$pdfCopyright = $headerLogo = $footerLogo = $trueLink = $falseLink = $pdfFileName = $content = '';
$my_url_path = $my_url_query = $domainStr = $inputHost = $my_url_host = $footerCode = $introductionCode = '';

//Check User Request
if ($pointOut == '')   
    die($lang['8']);

//Get User Request
$my_url = raino_trim($pointOut);
$my_url = 'http://'.clean_url($my_url);

//Parse Host
$my_url_parse = parse_url($my_url);
$inputHost = $my_url_parse['scheme'] . "://" . $my_url_parse['host'];
$my_url_host = str_replace("www.","",$my_url_parse['host']);
if(isset($my_url_parse['path']))
    $my_url_path = $my_url_parse['path'];
if(isset($my_url_parse['query']))
    $my_url_query = $my_url_parse['query']; 
$domainStr = strtolower($my_url_host);

//Check Valid Host
if($my_url_host == '')
    die($lang['8']);

//Theme Path
$theme_path = '';

//Suggestion Icons
$pass = imgTag($theme_path.'resources/pdficons/correct.jpg',false);
$toImprove = imgTag($theme_path.'resources/pdficons/info.jpg',false);
$fail = imgTag($theme_path.'resources/pdficons/wrong.jpg',false);
$low = imgTag($theme_path.'resources/pdficons/low.jpg',false);

//Importance Icons
$star1 = imgTag($theme_path.'resources/pdficons/easy.jpg',false);
$star2 = imgTag($theme_path.'resources/pdficons/little.jpg',false);
$star3 = imgTag($theme_path.'resources/pdficons/hard.jpg',false);
$noStar = imgTag($theme_path.'resources/pdficons/no-action.jpg',false);

//True & False Image
$trueLink = $theme_path.'resources/pdficons/true.jpg';
$falseLink = $theme_path.'resources/pdficons/false.jpg';
$true = imgTag($trueLink,false);
$false = imgTag($falseLink,false);

//Social Media Icons
$facebookIcon = imgTag($theme_path.'resources/pdficons/facebook.jpg',false);
$linkedinIcon = imgTag($theme_path.'resources/pdficons/linkedin.jpg',false);
$plusoneIcon = imgTag($theme_path.'resources/pdficons/plus-one.jpg',false);
$stumbleuponIcon = imgTag($theme_path.'resources/pdficons/stumbleupon.jpg',false);

//Load into Array
$starData = array($star1,$star2,$star3,$noStar);
$sugData = array($pass,$toImprove,$fail,$low);

$reviewerSettings = reviewerSettings($con);
$arrPDF = decSerBase($reviewerSettings['pdf_data']);
$defaultPdfCopyright = $arrPDF[0];
$defaultHeaderLogo = $arrPDF[1];
$defaultFooterLogo = $arrPDF[2];

if($pdfCopyright == '')
    $pdfCopyright = $defaultPdfCopyright;

if($headerLogo == '')
    $headerLogo = $defaultHeaderLogo;
    
if($footerLogo == '')
    $footerLogo = $defaultFooterLogo;

$headerLogo = imgTag($headerLogo,false);
$footerLogo = imgTag($footerLogo,false);

//Replacement Code
$replacementCode = array(
    '{(CopyRight Text)}' => $pdfCopyright,
    '{(InputSite)}' => ucfirst($domainStr),
    '{(CurrentPageNumber)}' => '[[page_cu]]',
    '{(TotalPageNumber)}' => '[[page_nb]]',
    '{(FooterLogo)}' => $footerLogo,
    '{(HeaderLogo)}' => $headerLogo,
    '{(Date)}' => date('F, j Y'),
    '{(Time)}' => date('h:i:s A'),
    '{(DateTime)}' => date('m/d/Y h:i:sA')
);

//Footer Code
$defaultFooterCode = '<table style="font-family: freeserif; width: 100%;  border: none; padding: 15px;">
            <tr>
                <td style="width: 33%; text-align: left;">
                    {(CopyRight Text)}
                </td>
                <td style="width: 34%; text-align: center">
                    Page {(CurrentPageNumber)}/{(TotalPageNumber)}
                </td>
                <td style="width: 33%; text-align: right">
                    {(FooterLogo)} 
                </td>
            </tr>
        </table>';
        
$defaultIntroductionCode = $lang['230'];
    
if($footerCode == '')
    $footerCode = $defaultFooterCode;
    
if($introductionCode == '')
    $introductionCode = $defaultIntroductionCode;
    
$footerCode = html_entity_decode(stripslashes(strEOL(str_replace(array_keys($replacementCode),array_values($replacementCode),$footerCode))));
$introductionCode = html_entity_decode(stripslashes(strEOL(str_replace(array_keys($replacementCode),array_values($replacementCode),$introductionCode))));

$footer = '<page_footer>
            '.$footerCode.'
    </page_footer>';

//Extract DB Data
define('PDF_DOMAIN',true);
require(CON_DIR.'pdf-domain.php');

//Close the Session
session_write_close();

//PDF - HTML Code
ob_start();                                                          
?>
<style type="text/css">
<?php echo getMyData(LIB_DIR.'pdfcss.css'); ?>
</style>
<page orientation="1" backtop="4mm" backbottom="14mm" backleft="8mm" backright="8mm" style="font-size: 12pt">

<bookmark title="<?php echo $lang['231']. ' ' .$domainStr; ?>" level="0" ></bookmark>

<?php echo $footer; ?>

    <div class="main-logo">
        
        <table style="width: 100%; padding: 20px;">
            <tr>
        		<td class="tableHead" style="width: 25%;">
                    <?php echo $headerLogo; ?>
        		</td>
        		<td class="right" style="width: 75%;">
                    <img alt="Logo" src="<?php echo $theme_path; ?>resources/pdficons/per/<?php echo $passScore; ?>.jpg" />
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<h2 style="margin-top: -90px;" class="score"><?php echo $passScore; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h2>
                    <br /><br />
                    <h6 class="webscore"><?php echo $lang['232']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h6>
        		</td>        
        	</tr>
        </table>
    </div>

    <div class="introduction" style="font-family: freeserif" id="introduction">
        <table style="width: 100%;">
            <tr>
        		<td class="tableHead" style="width: 25%;">
                    &nbsp;
        		</td>
        		<td style="width: 85%;">
                    <div class="reHead"><?php echo $lang['231']; ?> <span class="blue"><?php echo ucfirst($domainStr); ?></span></div>
                    <div class="genHead"><?php echo $lang['275'].' '.$disDate; ?></div>
        		</td>        
        	</tr>
        </table>
        
        <div class="clear" style="margin-bottom: 30px;"></div>
        
<bookmark title="<?php trans('Introduction',$lang['276']); ?>" level="1" ></bookmark>

        <table style="width: 100%;">
        	<tr class="tableBody">
        		<td class="sideHead" style="width: 25%;">
                    <?php trans('Introduction',$lang['276']); ?>
        		</td>
        		<td style="width: 85%;">     
                <?php echo $introductionCode; ?>
        		</td>        
        	</tr>
        </table>
        
        <div class="clear" style="margin-bottom: 20px;"></div>
        
<bookmark title="<?php trans('Table of Contents',$lang['277']); ?>" level="1" ></bookmark>

        <table style="width: 100%;" class="icons">
        	<tr class="tableBody">
        		<td class="sideHead" style="width: 25%;">
                    <?php trans('Table of Contents',$lang['277']); ?>
        		</td>
        		<td style="width: 40%;"> 
                  <a href="#*2"><?php trans('Search Engine Optimization',$lang['35']); ?></a> 
        		</td>  
        		<td style="width: 40%;"> 
                <a href="#*10"><?php trans('Usability',$lang['16']); ?></a>
        		</td>      
        	</tr>
        	<tr class="tableBody">
        		<td class="sideHead" style="width: 25%;">
                     &nbsp;
        		</td>
        		<td style="width: 40%;"> 
                <a href="#*14"><?php trans('Mobile',$lang['17']); ?></a>    
        		</td>    
        		<td style="width: 40%;"> 
                <a href="#*16"><?php trans('Technologies',$lang['18']); ?></a>  
        		</td>    
        	</tr>
           	<tr class="tableBody">
        		<td class="sideHead" style="width: 25%;">
                    &nbsp;
        		</td>
        		<td style="width: 40%;"> 
                <a href="#*19"><?php trans('Visitors',$lang['20']); ?></a>   
        		</td>   
        		<td style="width: 40%;"> 
                <a href="#*18"><?php trans('Social',$lang['19']); ?></a> 
        		</td>      
        	</tr> 
        	<tr class="tableBody">
        		<td class="sideHead" style="width: 25%;">
                    &nbsp;
        		</td>
        		<td style="width: 40%;"> 
                <a href="#*20"><?php trans('Link Analysis',$lang['21']); ?></a>
        		</td>   
        		<td style="width: 40%;"> 
                &nbsp;  
        		</td>      
        	</tr>                            
        </table>
        
<bookmark title="<?php trans('Iconography',$lang['278']); ?>" level="1" ></bookmark>
        
        <div class="clear" style="margin-bottom: 30px;"></div>
        
        <table style="width: 100%;" class="icons">
        
        	<tr class="tableBody">
        		<td class="sideHead" style="width: 25%;"> <?php trans('Iconography',$lang['278']); ?> </td>
        		<td style="width: 40%;"> <?php echo $pass .' '. trans('Good',$lang['279'],true); ?> </td>  
        		<td style="width: 40%;"> <?php echo $star3.' '. trans('Hard to solve',$lang['31'],true); ?> </td>      
        	</tr>
            
        	<tr class="tableBody">
        		<td class="sideHead" style="width: 25%;"> &nbsp; </td>
        		<td style="width: 40%;"> <?php echo $toImprove .' '. trans('To Improve',$lang['25'],true); ?> </td>    
        		<td style="width: 40%;"> <?php echo $star2 .' '. trans('Little tough to solve',$lang['30'],true); ?> </td>    
        	</tr>
            
           	<tr class="tableBody">
        		<td class="sideHead" style="width: 25%;"> &nbsp;</td>
        		<td style="width: 40%;"> <?php echo $fail .' '. trans('Errors',$lang['280'],true); ?> </td>   
        		<td style="width: 40%;"> <?php echo $star1 .' '. trans('Easy to solve',$lang['29'],true); ?> </td>      
        	</tr>
            
        	<tr class="tableBody">
        		<td class="sideHead" style="width: 25%;"> &nbsp;</td>
        		<td style="width: 40%;"> <?php echo $low .' '. trans('Not Important',$lang['281'],true); ?> </td> 
        		<td style="width: 40%;"> <?php echo $noStar .' '. trans('No action necessary',$lang['32'],true); ?> </td>        
        	</tr>
                            
        </table>
        
    </div>
</page>

<page orientation="1" backtop="22mm" backbottom="24mm" backleft="8mm" backright="8mm" style="font-size: 12pt; font-family: freeserif;">

    <?php echo pdfHeadBox(trans('Search Engine Optimization',$lang['35'],true),'').$footer; ?>
     
    <div class="seoBox seoBox1">
        <?php pdfOutBox($lang['AN1'], $starData, 1 , $seoBox1, $classTitle, $sugData, $titleMsg); ?>
    </div>
    
    <div class="seoBox seoBox2">
        <?php pdfOutBox($lang['AN2'], $starData, 1 , $seoBox2, $classDes, $sugData, $desMsg); ?>
    </div>
    
    <div class="seoBox seoBox3">
        <?php pdfOutBox($lang['AN3'], $starData, 1 , $seoBox3, $classKey, $sugData, $keyMsg); ?>
    </div>
</page>

<page orientation="1" backtop="14mm" backbottom="24mm" backleft="8mm" backright="8mm" style="font-size: 12pt; font-family: freeserif;">

    <?php echo $footer; ?>
      
    <div class="seoBox seoBox5">
        <?php pdfOutBox($lang['AN17'], $starData, 4 , $seoBox5, $classKey, $sugData, $googleMsg); ?>
    </div>
    
    <div class="seoBox seoBox4">
        <?php pdfOutBox($lang['AN16'], $starData, 2 , $seoBox4, $classHead, $sugData, $headMsg, $headExData); ?>
    </div>
</page>

<page pageset="old" style="font-size: 12pt; font-family: freeserif;">
    <div class="seoBox seoBox7">
        <?php pdfOutBox($lang['AN28'], $starData, 4 , $seoBox7, $keycloudClass, $sugData, $keyCloudMsg); ?>
    </div>

    <div class="seoBox seoBox8">
        <?php pdfOutBox($lang['AN30'], $starData, 1, $seoBox8, $keywordConsistencyClass, $sugData, $keyConsMsg); ?>
    </div>
</page>

<page pageset="old" style="font-size: 12pt; font-family: freeserif;">
    <div class="seoBox seoBox6">
        <?php pdfOutBox($lang['AN20'], $starData, 1 , $seoBox6, $altClass, $sugData, $imageMsg, $imgExData); ?>
    </div>
    
    <div class="seoBox seoBox9">
        <?php pdfOutBox($lang['AN35'], $starData, 2, $seoBox9, $textClass, $sugData, $textMsg); ?>
    </div>
    
    <div class="seoBox seoBox10">
        <?php pdfOutBox($lang['AN40'], $starData, 2, $seoBox10, $gzipClass, $sugData, $gzipMsg); ?>
    </div>

</page>

<page pageset="old" style="font-size: 12pt; font-family: freeserif;">
    <div class="seoBox seoBox12">
        <?php pdfOutBox($lang['AN48'], $starData, 1, $seoBox12, $ipClass, $sugData, $ip_canMsg); ?>
    </div>
    
    <div class="seoBox seoBox17">
        <?php pdfOutBox($lang['AN61'], $starData, 2, $seoBox17, $urlRewritingClass, $sugData, $url_RewritingMsg); ?>
    </div>
    
    <div class="seoBox seoBox18">
        <?php pdfOutBox($lang['AN62'], $starData, 3, $seoBox18, $linkUnderScoreClass, $sugData, $link_UnderScoreMsg); ?>
    </div>
</page>


<page pageset="old" style="font-size: 12pt; font-family: freeserif;">
    
    <div class="seoBox seoBox11">
        <?php pdfOutBox($lang['AN45'], $starData, 2, $seoBox11, $resolveClass, $sugData, $www_resolveMsg); ?>
    </div>
    
    <div class="seoBox seoBox15">
        <?php pdfOutBox($lang['AN59'], $starData, 1, $seoBox15, $robotClass, $sugData, $robot_Msg); ?>
    </div>
    <div class="seoBox seoBox16">
        <?php pdfOutBox($lang['AN60'], $starData, 1, $seoBox16, $sitemapClass, $sugData, $sitemap_Msg); ?>
    </div>
</page>

<page pageset="old" style="font-size: 12pt; font-family: freeserif;">
    <div class="seoBox seoBox19">
        <?php pdfOutBox($lang['AN63'], $starData, 1, $seoBox19, $embeddedClass, $sugData, $embedded_Msg); ?>
    </div>
    <div class="seoBox seoBox20">
        <?php pdfOutBox($lang['AN76'], $starData, 1, $seoBox20, $iframeClass, $sugData, $iframe_Msg); ?>
    </div>
    <div class="seoBox seoBox21">
        <?php pdfOutBox($lang['AN81'], $starData, 4, $seoBox21, $domainClass, $sugData, $domainAgeMsg); ?>
    </div>
</page>

<page pageset="old" style="font-size: 12pt; font-family: freeserif;">
    <div class="seoBox seoBox42">
        <?php pdfOutBox($lang['AN110'], $starData, 2, $seoBox42, $indexedPagesClass, $sugData, $indexedPages_Msg); ?>
    </div>
    <div class="seoBox seoBox43">
        <?php pdfOutBox($lang['AN111'], $starData, 4, $seoBox43, $backlinksClass, $sugData, $backlinks_Msg); ?>
    </div>
</page>

<page orientation="1" backtop="22mm" backbottom="24mm" backleft="8mm" backright="8mm" style="font-size: 12pt; font-family: freeserif;">

    <?php echo pdfHeadBox(trans('Usability',$lang['16'],true),'').$footer; ?>
    
    <div class="seoBox seoBox26">
        <?php pdfOutBox($lang['AN94'], $starData, 4, $seoBox26, $urlLengthClass, $sugData, $urlLength_Msg); ?>
    </div>
    <div class="seoBox seoBox27">
        <?php pdfOutBox($lang['AN95'], $starData, 1, $seoBox27, $favIconClass, $sugData, $favIcon_Msg); ?>
    </div>
    <div class="seoBox seoBox28">
        <?php pdfOutBox($lang['AN96'], $starData, 1, $seoBox28, $errorPageClass, $sugData, $errorPage_Msg); ?>
    </div>
</page>

<page orientation="1" backtop="14mm" backbottom="24mm" backleft="8mm" backright="8mm" style="font-size: 12pt; font-family: freeserif;">

    <?php echo $footer; ?>
    
    <div class="seoBox seoBox29">
        <?php pdfOutBox($lang['AN97'], $starData, 2, $seoBox29, $sizeClass, $sugData, $size_Msg); ?>
    </div>
    <div class="seoBox seoBox30">
        <?php pdfOutBox($lang['AN98'], $starData, 3, $seoBox30, $loadClass, $sugData, $load_Msg); ?>
    </div>
    <div class="seoBox seoBox31">
        <?php pdfOutBox($lang['AN99'], $starData, 1, $seoBox31, $langClass, $sugData, $lang_Msg); ?>
    </div>
</page>

<page pageset="old" style="font-size: 12pt; font-family: freeserif;">
    <div class="seoBox seoBox32">
        <?php pdfOutBox($lang['AN100'], $starData, 4, $seoBox32, $domainClass, $sugData, $domain_Msg); ?>
    </div>
    <div class="seoBox seoBox33">
        <?php pdfOutBox($lang['AN101'], $starData, 4, $seoBox33, $typoClass, $sugData, $typo_Msg); ?>
    </div>
</page>

<page pageset="old" style="font-size: 12pt; font-family: freeserif;">
    <div class="seoBox seoBox34">
        <?php pdfOutBox($lang['AN102'], $starData, 1, $seoBox34, $emailPrivacyClass, $sugData, $emailPrivacy_Msg); ?>
    </div>
    <div class="seoBox seoBox35">
        <?php pdfOutBox($lang['AN103'], $starData, 1, $seoBox35, $safeBrowsingClass, $sugData, $safeBrowsing_Msg); ?>
    </div>
</page>

<page orientation="1" backtop="22mm" backbottom="24mm" backleft="8mm" backright="8mm" style="font-size: 12pt; font-family: freeserif;">

    <?php echo pdfHeadBox(trans('Mobile',$lang['17'],true),'').$footer; ?>
     
    <div class="seoBox seoBox23">
        <?php pdfOutBox($lang['AN91'], $starData, 3, $seoBox23, $mobileClass, $sugData, $mobileCheckMsg); ?>
    </div>
    
    <div class="seoBox seoBox25">
        <?php pdfOutBox($lang['AN93'], $starData, 2, $seoBox25, $mobileComClass, $sugData, $mobileCom_Msg); ?>
    </div>

</page>

<page orientation="1" backtop="14mm" backbottom="24mm" backleft="8mm" backright="8mm" style="font-size: 12pt; font-family: freeserif;">

    <?php echo $footer; ?>
    
    <div class="seoBox seoBox24">
        <?php pdfOutBox($lang['AN92'], $starData, 4, $seoBox24, $mobileScreenClass, $sugData, $mobileScreenClassMsg); ?>
    </div>
</page>

<page orientation="1" backtop="22mm" backbottom="24mm" backleft="8mm" backright="8mm" style="font-size: 12pt; font-family: freeserif;">

    <?php echo pdfHeadBox(trans('Technologies',$lang['18'],true),'').$footer; ?>
    <div class="seoBox seoBox36">
        <?php pdfOutBox($lang['AN104'], $starData, 4, $seoBox36, $serverIPClass, $sugData, $serverIP_Msg); ?>
    </div>
    <div class="seoBox seoBox37">
        <?php pdfOutBox($lang['AN105'], $starData, 3, $seoBox37, $speedTipsClass, $sugData, $speedTips_Msg); ?>
    </div>
    <div class="seoBox seoBox38">
        <?php pdfOutBox($lang['AN106'], $starData, 1, $seoBox38, $analyticsClass, $sugData, $analytics_Msg); ?>
    </div>
</page>

<page orientation="1" backtop="14mm" backbottom="24mm" backleft="8mm" backright="8mm" style="font-size: 12pt; font-family: freeserif;">

    <?php echo $footer; ?>
    <div class="seoBox seoBox40">
        <?php pdfOutBox($lang['AN108'], $starData, 4, $seoBox40, $docTypeClass, $sugData, $docType_Msg); ?>
    </div>
    <div class="seoBox seoBox39">
        <?php pdfOutBox($lang['AN107'], $starData, 2, $seoBox39, $w3cClass, $sugData, $w3c_Msg); ?>
    </div>
    <div class="seoBox seoBox41">
        <?php pdfOutBox($lang['AN109'], $starData, 1, $seoBox41, $encodingClass, $sugData, $encoding_Msg); ?>
    </div>
</page>

<page orientation="1" backtop="22mm" backbottom="24mm" backleft="8mm" backright="8mm" style="font-size: 12pt; font-family: freeserif;">

    <?php echo pdfHeadBox(trans('Social',$lang['19'],true),'').$footer; ?>
     
    <div class="seoBox seoBox44">
        <?php pdfOutBox($lang['AN112'], $starData, 3, $seoBox44, $socialClass, $sugData, $social_Msg); ?>
    </div>

</page>

<page orientation="1" backtop="22mm" backbottom="24mm" backleft="8mm" backright="8mm" style="font-size: 12pt; font-family: freeserif;">

    <?php echo pdfHeadBox(trans('Visitors',$lang['20'],true),'').$footer; ?>
    
    <div class="seoBox seoBox46">
        <?php pdfOutBox($lang['AN114'], $starData, 3, $seoBox46, $alexaClass, $sugData, $alexa_Msg); ?>
    </div>
    
    <div class="seoBox seoBox47">
        <?php pdfOutBox($lang['AN115'], $starData, 4, $seoBox47, $visitorsClass, $sugData, $visitors_Msg); ?>
    </div>
    
    <div class="seoBox seoBox45">
        <?php pdfOutBox($lang['AN113'], $starData, 4, $seoBox45, $worthClass, $sugData, $worth_Msg); ?>
    </div>

</page>

<page orientation="1" backtop="22mm" backbottom="24mm" backleft="8mm" backright="8mm" style="font-size: 12pt; font-family: freeserif;">

    <?php echo pdfHeadBox(trans('Link Analysis',$lang['21'],true),'').$footer; ?>
     
    <div class="seoBox seoBox13">
        <?php pdfOutBox($lang['AN51'], $starData, 1, $seoBox13, $inPageClass, $sugData, $in_pageMsg, $inPageData); ?>
    </div>

</page>

<page orientation="1" backtop="14mm" backbottom="24mm" backleft="8mm" backright="8mm" style="font-size: 12pt; font-family: freeserif;">

    <?php echo $footer; ?>
    
    <div class="seoBox seoBox14">
        <?php pdfOutBox($lang['AN58'], $starData, 1, $seoBox14, $brokenClass, $sugData, $broken_Msg,$brokenLinksData); ?>
    </div>
    
</page> 

<?php
$content = ob_get_clean();
//$content = utf8_decode($content);
try {
    $pdfFileName = $domainStr.'_'.rand(10,999999).'.pdf';
	$html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', array(0, 0, 0, 0));
    //$html2pdf->setModeDebug();
    //$html2pdf->setDefaultFont('arialunicid0');  //Fix for broken characters
    $html2pdf->pdf->SetDisplayMode('real');
    $html2pdf->setTestTdInOnePage(false);
	$html2pdf->writeHTML($content);
	$html2pdf->Output(ROOT_DIR.'resources'.D_S.'pdf-reports'.D_S.$pdfFileName,'F');
    header('Location: '. $baseURL.'resources/pdf-reports/'.$pdfFileName);
}catch(HTML2PDF_exception $e)  { 
    echo $e; 
}
die();
?>