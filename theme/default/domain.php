<?php
defined('APP_NAME') or die(header('HTTP/1.1 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @Theme: Default Style
 * @copyright 2022 KOVATZ.COM
 *
 */

$solveMsg = array($lang['29'],$lang['30'],$lang['31'],$lang['32']);

//Loading Bar
$loadingBar = '<div class="text-center">
            <img src="'.themeLink('img/load.gif',true).'" />
            <br />
            <br />
                '.$lang['33'].'...
            <br />
            <br />
        </div>';

if($updateFound){
    for($i=1;$i<=49;$i++)
        ${'seoBox' . $i} = $loadingBar;
}else{ ?>
<script>
var passScore = '<?php echo makeJavascriptStr($passScore); ?>';
var improveScore = '<?php echo makeJavascriptStr($improveScore); ?>';
var errorScore = '<?php echo makeJavascriptStr($errorScore); ?>';
</script>
<?php } ?>
<script>
var hashCode = '<?php echo $hashCode; ?>';
var inputHost = '<?php echo $my_url_host; ?>';
var isOnline = '<?php echo $isOnline; ?>';
var pdfUrl = '<?php echo $pdfUrl;?>';
var pdfMsg = '<?php echo makeJavascriptStr($lang['34']); ?>';
var domainPath = '<?php createLink('domains'); ?>';
var scoreTxt = '<?php echo makeJavascriptStr($lang['195']); ?>';
var CANV_GAUGE_FONTS_PATH = '<?php themeLink('fonts'); ?>';
</script>

<script src="<?php themeLink('js/circle-progress.js'); ?>"></script>  
<script src="<?php themeLink('js/pagespeed.min.js'); ?>" type="text/javascript"></script>
<link href="<?php themeLink('css/www.css'); ?>" rel="stylesheet" />

<div class="container">
  <div class="row">

    <div class="col-sm-3 mobilefix">
        <nav id="scroll-menu" class="affix-top" data-spy="affix" data-offset-top="205" data-offset-bottom="420">
          <ul id="scroll-nav" class="nav nav-pills nav-stacked">
            <li class="active">        
            <a href="#top" class="scroll-link">
                <span class="scroll-icon"><i class="fa fa-chevron-up"></i></span>
                <span class="scroll-text"><?php trans('Return to top',$lang['13']); ?></span>
                <span class="scroll-arrow"><i class="fa fa-chevron-right"></i></span>
            </a>
            </li>
            <li>        
            <a href="#overview" class="scroll-link">
                <span class="scroll-icon"><i class="fa fa-bar-chart-o"></i></span>
                <span class="scroll-text"><?php trans('Overview',$lang['14']); ?></span>
                <span class="scroll-arrow"><i class="fa fa-chevron-right"></i></span>
            </a>
            </li>
            <li>        
            <a href="#seo" class="scroll-link">
                <span class="scroll-icon"><i class="fa fa-search"></i></span>
                <span class="scroll-text"><?php trans('SEO',$lang['15']); ?></span>
                <span class="scroll-arrow"><i class="fa fa-chevron-right"></i></span>
            </a>
            </li>
            <li>        
            <a href="#usability" class="scroll-link">
                <span class="scroll-icon"><i class="fa fa-hand-o-up"></i></span>
                <span class="scroll-text"><?php trans('Usability',$lang['16']); ?></span>
                <span class="scroll-arrow"><i class="fa fa-chevron-right"></i></span>
            </a>
            </li>
            <li>        
            <a href="#mobile" class="scroll-link">
                <span class="scroll-icon"><i class="fa fa-mobile phonefix"></i></span>
                <span class="scroll-text"><?php trans('Mobile',$lang['17']); ?></span>
                <span class="scroll-arrow"><i class="fa fa-chevron-right"></i></span>
            </a>
            </li>
            <li>        
            <a href="#technologies" class="scroll-link">
                <span class="scroll-icon"><i class="fa fa-rocket"></i></span>
                <span class="scroll-text"><?php trans('Technologies',$lang['18']); ?></span>
                <span class="scroll-arrow"><i class="fa fa-chevron-right"></i></span>
            </a>
            </li>
            <li>        
            <a href="#social" class="scroll-link">
                <span class="scroll-icon"><i class="fa fa-thumbs-o-up"></i></span>
                <span class="scroll-text"><?php trans('Social',$lang['19']); ?></span>
                <span class="scroll-arrow"><i class="fa fa-chevron-right"></i></span>
            </a>
            </li>
            <li>        
            <a href="#visitors" class="scroll-link">
                <span class="scroll-icon"><i class="fa fa-users"></i></span>
                <span class="scroll-text"><?php trans('Visitors',$lang['20']); ?></span>
                <span class="scroll-arrow"><i class="fa fa-chevron-right"></i></span>
            </a>
            </li>
            <li>        
            <a href="#link-analysis" class="scroll-link">
                <span class="scroll-icon"><i class="fa fa-link"></i></span>
                <span class="scroll-text"><?php trans('Link Analysis',$lang['21']); ?></span>
                <span class="scroll-arrow"><i class="fa fa-chevron-right"></i></span>
            </a>
            </li>
          </ul>
          </nav>
    </div>
    
    <div class="col-sm-9">   
           
        <div class="xd_top_box top40 text-center">
         <?php echo $ads_720x90; ?>
        </div>

           <?php
           //Output Block
           if(isset($error)) {
            
            echo '<br/><br/><div class="alert alert-error">
            <strong>'.$lang['53'].'</strong> '.$error.'
            </div><br/><br/>
            <div class="text-center"><a class="btn btn-info" href="'.$baseURL.'">'.trans('Go to homepage',$lang['22'],true).'</a>
            </div><br/>';
            
           } else {
           ?>
           
         <div id="overview">
           
            <br />  
            <?php if($updateFound){ ?>
            <style>.progress-bar-primary { background-color: #3498DC; } .progress { margin-top: 20px; background-color: #d2d2d2; }</style>      
            
            <div class="progress progress-lg" id="progress-bar">
                <div id="progressbar" class="progress-bar progress-bar-primary progress-bar-striped active" role="progressbar" aria-valuemin="5" aria-valuemax="100">
                    <div style="font-weight: bold; position: absolute; width: 100%; color: white;"><?php trans('Analyzing Website', $lang['MS6']); ?> - <span id="progress-label">0%</span> <?php trans('Complete', $lang['MS7']); ?></div>
                </div>
            </div>
            <?php } ?>
            <br />
            
            <div id="scoreBoard" class="row">
                <div class="col-md-4 screenBox">
                    <div id="screenshot">
                        <div id="screenshotData">
                        <div class="loader">
                          <div class="side"></div>
                          <div class="side"></div>
                          <div class="side"></div>
                          <div class="side"></div>
                          <div class="side"></div>
                          <div class="side"></div>
                          <div class="side"></div>
                          <div class="side"></div>
                        </div>
                        <div class="loaderLabel"><?php trans('Loading...',$lang['23']); ?></div>
                        </div>
                        <div class="computer"></div>
                    </div>
                  </div>
                <div class="col-md-5 levelBox">
                <div>
                <a href="http://<?php echo $my_url_host; ?>" target="_blank" rel="nofollow" class="mainLink"><?php echo ucfirst($my_url_host); ?></a>
                </div>
                <div class="timeBox">
                <?php echo $disDate; ?>
                </div>
                <div class="progressBox">
                <span class="scoreProgress-label passedBox"><?php trans('Passed',$lang['26']); ?></span>
                <div class="scoreProgress scoreProgress-xs scoreProgress-success">
                    <div id="passScore" aria-valuemax="100" aria-valuenow="0" aria-valuemin="0" role="progressbar" class="scoreProgress-bar">
                        <span class="scoreProgress-value">0%</span>
                    </div>
                </div>
                </div>
                
                <div class="progressBox">
                <span class="scoreProgress-label improveBox"><?php trans('To Improve',$lang['25']); ?></span>
                <div class="scoreProgress scoreProgress-xs scoreProgress-warning">
                    <div id="improveScore" aria-valuemax="100" aria-valuenow="0" aria-valuemin="0" role="progressbar" class="scoreProgress-bar">
                        <span class="scoreProgress-value">0%</span>
                    </div>
                </div>
                </div>
                
                <div class="progressBox">
                <span class="scoreProgress-label errorBox"><?php trans('Errors',$lang['24']); ?></span>
                <div class="scoreProgress scoreProgress-xs scoreProgress-danger">
                    <div id="errorScore" aria-valuemax="100" aria-valuenow="0" aria-valuemin="0" role="progressbar" class="scoreProgress-bar">
                        <span class="scoreProgress-value">0%</span>
                    </div>
                </div>
                </div>
                
                <br />
                

                
            </div>
            <div class="col-md-2 circleBox">
            <div class="second circle" data-size="130" data-thickness="5"><canvas width="130" height="130"></canvas>
            <strong id="overallscore">0<i class="newI"><?php echo $lang['195']; ?></i></strong>
            </div>
            </div>
            
            </div>
            
            <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-7">
                    <div class="pdfBox">
                    <a href="<?php echo $pdfUrl; ?>" id="pdfLink" class="btn btn-lgreen btn-sm"> <i class="fa fa-cloud-download"></i> <?php trans('Download as PDF',$lang['28']); ?> </a>
                    <a href="<?php echo $updateUrl; ?>" class="btn btn-red btn-sm"> <i class="fa fa-refresh"></i> <?php trans('Update Data',$lang['27']); ?> </a>
                    <a href="<?php createLink('site-vs-site/'.$my_url_host); ?>" class="btn btn-violet btn-sm"> <i class="fa fa-star-half-empty"></i> <?php trans('Compare',$lang['196']); ?> </a>
                    <a id="shareBtn" class="btn btn-blue btn-sm"> <i class="fa fa-share-alt-square"></i> <?php trans('Share',$lang['116']); ?> </a>
                    </div>
                </div>
            </div>

            <div class="shareBox top40">
        	  	<ul class="social-icons icon-circle icon-rotate list-unstyled list-inline text-center"> 
     	          <li><?php trans('SHARE',$lang['122']); ?></li> 
         	      <li> <a target="_blank" rel="nofollow" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $shareLink; ?>"><i class="fa fa-facebook"></i></a></li>  
        	      <li><a target="_blank" rel="nofollow" href="https://twitter.com/home?status=<?php echo $shareLink; ?>"><i class="fa fa-twitter"></i></a> </li> 
        	      <li><a target="_blank" rel="nofollow" href="https://plus.google.com/share?url=<?php echo $shareLink; ?>"><i class="fa fa-google-plus"></i></a> </li>   
        	      <li> <a target="_blank" rel="nofollow" href="https://pinterest.com/pin/create/button/?url=<?php echo $shareLink; ?>"><i class="fa fa-pinterest"></i></a> </li>
        	      <li> <a target="_blank" rel="nofollow" href="https://www.tumblr.com/share/link?url=<?php echo $shareLink; ?>"><i class="fa fa-tumblr"></i></a> </li> 
        	      <li> <a target="_blank" rel="nofollow" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $shareLink; ?>"><i class="fa fa-linkedin"></i></a> </li> 
        	      <li> <a target="_blank" rel="nofollow" href="https://del.icio.us/post?url=<?php echo $shareLink; ?>"><i class="fa fa-delicious"></i></a> </li> 
        	      <li> <a target="_blank" rel="nofollow" href="https://www.stumbleupon.com/submit?url=<?php echo $shareLink; ?>"><i class="fa fa-stumbleupon"></i></a></li> 
        	      <li> <a target="_blank" rel="nofollow" href="https://www.reddit.com/login?dest=https://www.reddit.com/submit?url=<?php echo $shareLink; ?>&title=<?php echo ucfirst($my_url_host); ?>"><i class="fa fa-reddit"></i></a></li> 
        	      <li> <a target="_blank" rel="nofollow" href="https://digg.com/submit?phase=2&url=<?php echo $shareLink; ?>"><i class="fa fa-digg"></i></a></li> 
        	      <li> <a target="_blank" rel="nofollow" href="https://vk.com/share.php?url=<?php echo $shareLink; ?>"><i class="fa fa-vk"></i></a></li>   
        	  	</ul>
            </div>
        </div>
        
        <div class="clearfix"></div>
                 
               <div id="seo">  
                <div class="clearSep"></div>
                <h2 class="seoBox-title">
                    <?php trans('SEO',$lang['35']); ?>
                </h2>
               <div class="seoBox" onclick="javascript:showSuggestion('seoBox1');">
                    <?php outHeadBox($lang['AN1'],$solveMsg,1); ?>
                    <div class="contentBox" id="seoBox1">
                        <?php echo $seoBox1; ?>
                    </div>
                    <?php outQuestionBox($lang['AN4']); ?>
	            </div>
                
                <div class="seoBox" onclick="javascript:showSuggestion('seoBox2');">
                    <?php outHeadBox($lang['AN2'],$solveMsg,1); ?>
                    <div class="contentBox" id="seoBox2">
                        <?php echo $seoBox2; ?>
                    </div>
                    <?php outQuestionBox($lang['AN4']); ?>
	            </div>
                
                <div class="seoBox" onclick="javascript:showSuggestion('seoBox3');">
                    <?php outHeadBox($lang['AN3'],$solveMsg,1); ?>
                    <div class="contentBox" id="seoBox3">
                        <?php echo $seoBox3; ?>
                    </div>
                    <?php outQuestionBox($lang['AN4']); ?>
	            </div>  
                
                <div class="seoBox headingResult" onclick="javascript:showSuggestion('seoBox4');">
                    <?php outHeadBox($lang['AN16'],$solveMsg,2); ?>
                    <div class="contentBox" id="seoBox4">
                        <?php echo $seoBox4; ?>
                    </div>
                    <?php outQuestionBox($lang['AN4']); ?>
	            </div>  
                
                <div class="seoBox" onclick="javascript:showSuggestion('seoBox5');">
                    <?php outHeadBox($lang['AN17'],$solveMsg,4); ?>
                    <div class="contentBox" id="seoBox5">
                        <?php echo $seoBox5; ?>
                    </div>
                    <?php outQuestionBox($lang['AN4']); ?>
	            </div>  
                
                <div class="seoBox altImgResult" onclick="javascript:showSuggestion('seoBox6');">
                    <?php outHeadBox($lang['AN20'],$solveMsg,1); ?>
                    <div class="contentBox" id="seoBox6">
                        <?php echo $seoBox6; ?>
                    </div>
                    <?php outQuestionBox($lang['AN4']); ?>
	            </div>  
                
                <div class="seoBox" onclick="javascript:showSuggestion('seoBox7');">
                    <?php outHeadBox($lang['AN28'],$solveMsg,4); ?>
                    <div class="contentBox" id="seoBox7">
                        <?php echo $seoBox7; ?>
                    </div>
                    <?php outQuestionBox($lang['AN4']); ?>
	            </div>  
                
                <div class="seoBox keyConsResult" onclick="javascript:showSuggestion('seoBox8');">
                    <?php outHeadBox($lang['AN30'],$solveMsg,1); ?>
                    <div class="contentBox" id="seoBox8">
                        <?php echo $seoBox8; ?>
                    </div>
                    <?php outQuestionBox($lang['AN4']); ?>
	            </div>  
                
                <div class="seoBox" onclick="javascript:showSuggestion('seoBox9');">
                    <?php outHeadBox($lang['AN35'],$solveMsg,2); ?>
                    <div class="contentBox" id="seoBox9">
                        <?php echo $seoBox9; ?>
                    </div>
                    <?php outQuestionBox($lang['AN4']); ?>
	            </div> 
                
                <div class="seoBox" onclick="javascript:showSuggestion('seoBox10');">
                    <?php outHeadBox($lang['AN40'],$solveMsg,2); ?>
                    <div class="contentBox" id="seoBox10">
                        <?php echo $seoBox10; ?>
                    </div>
                    <?php outQuestionBox($lang['AN4']); ?>
	            </div> 
                
                <div class="seoBox" onclick="javascript:showSuggestion('seoBox11');">
                    <?php outHeadBox($lang['AN45'],$solveMsg,1); ?>
                    <div class="contentBox" id="seoBox11">
                        <?php echo $seoBox11; ?>
                    </div>
                    <?php outQuestionBox($lang['AN4']); ?>
	            </div> 
                
                <div class="seoBox" onclick="javascript:showSuggestion('seoBox12');">
                    <?php outHeadBox($lang['AN48'],$solveMsg,1); ?>
                    <div class="contentBox" id="seoBox12">
                        <?php echo $seoBox12; ?>
                    </div>
                    <?php outQuestionBox($lang['AN4']); ?>
	            </div> 
                        
                <div class="seoBox" onclick="javascript:showSuggestion('seoBox15');">
                    <?php outHeadBox($lang['AN59'],$solveMsg,1); ?>
                    <div class="contentBox" id="seoBox15">
                        <?php echo $seoBox15; ?>
                    </div>
                    <?php outQuestionBox($lang['AN4']); ?>
	            </div> 
                        
                <div class="seoBox" onclick="javascript:showSuggestion('seoBox16');">
                    <?php outHeadBox($lang['AN60'],$solveMsg,1); ?>
                    <div class="contentBox" id="seoBox16">
                        <?php echo $seoBox16; ?>
                    </div>
                    <?php outQuestionBox($lang['AN4']); ?>
	            </div> 
                
                <div class="seoBox" onclick="javascript:showSuggestion('seoBox17');">
                    <?php outHeadBox($lang['AN61'],$solveMsg,2); ?>
                    <div class="contentBox" id="seoBox17">
                        <?php echo $seoBox17; ?>
                    </div>
                    <?php outQuestionBox($lang['AN4']); ?>
	            </div> 
                
                <div class="seoBox" onclick="javascript:showSuggestion('seoBox18');">
                    <?php outHeadBox($lang['AN62'],$solveMsg,3); ?>
                    <div class="contentBox" id="seoBox18">
                        <?php echo $seoBox18; ?>
                    </div>
                    <?php outQuestionBox($lang['AN4']); ?>
	            </div>
                
                <div class="seoBox" onclick="javascript:showSuggestion('seoBox19');">
                    <?php outHeadBox($lang['AN63'],$solveMsg,1); ?>
                    <div class="contentBox" id="seoBox19">
                        <?php echo $seoBox19; ?>
                    </div>
                    <?php outQuestionBox($lang['AN4']); ?>
	            </div>
                
                <div class="seoBox" onclick="javascript:showSuggestion('seoBox20');">
                    <?php outHeadBox($lang['AN76'],$solveMsg,1); ?>
                    <div class="contentBox" id="seoBox20">
                        <?php echo $seoBox20; ?>
                    </div>
                    <?php outQuestionBox($lang['AN4']); ?>
	            </div>
                
                <div class="seoBox" onclick="javascript:showSuggestion('seoBox21');">
                    <?php outHeadBox($lang['AN81'],$solveMsg,4); ?>
                    <div class="contentBox" id="seoBox21">
                        <?php echo $seoBox21; ?>
                    </div>
                    <?php outQuestionBox($lang['AN4']); ?>
	            </div>
                
                <div class="seoBox whois" onclick="javascript:showSuggestion('seoBox22');">
                    <?php outHeadBox($lang['AN83'],$solveMsg,4); ?>
                    <div class="contentBox" id="seoBox22">
                        <?php echo $seoBox22; ?>
                    </div>
                    <?php outQuestionBox($lang['AN4']); ?>
	            </div>
                
                <div class="seoBox" onclick="javascript:showSuggestion('seoBox42');">
                    <?php outHeadBox($lang['AN110'],$solveMsg,2); ?>
                    <div class="contentBox" id="seoBox42">
                        <?php echo $seoBox42; ?>
                    </div>
                    <?php outQuestionBox($lang['AN4']); ?>
	            </div>
                
                <div class="seoBox" onclick="javascript:showSuggestion('seoBox43');">
                    <?php outHeadBox($lang['AN111'],$solveMsg,4); ?>
                    <div class="contentBox" id="seoBox43">
                        <?php echo $seoBox43; ?>
                    </div>
                    <?php outQuestionBox($lang['AN4']); ?>
	            </div>
                
                </div>
 
                <div id="usability">
                
                <div class="clearSep"></div>
                <h2 class="seoBox-title">
                    <?php trans('Usability',$lang['16']); ?>
                </h2>
                <div class="seoBox" onclick="javascript:showSuggestion('seoBox26');">
                    <?php outHeadBox($lang['AN94'],$solveMsg,4); ?>
                    <div class="contentBox" id="seoBox26">
                        <?php echo $seoBox26; ?>
                    </div>
                    <?php outQuestionBox($lang['AN4']); ?>
	            </div>
                
                <div class="seoBox" onclick="javascript:showSuggestion('seoBox27');">
                    <?php outHeadBox($lang['AN95'],$solveMsg,1); ?>
                    <div class="contentBox" id="seoBox27">
                        <?php echo $seoBox27; ?>
                    </div>
                    <?php outQuestionBox($lang['AN4']); ?>
	            </div>
                
                <div class="seoBox" onclick="javascript:showSuggestion('seoBox28');">
                    <?php outHeadBox($lang['AN96'],$solveMsg,1); ?>
                    <div class="contentBox" id="seoBox28">
                        <?php echo $seoBox28; ?>
                    </div>
                    <?php outQuestionBox($lang['AN4']); ?>
	            </div>
                
                <div class="seoBox" onclick="javascript:showSuggestion('seoBox29');">
                    <?php outHeadBox($lang['AN97'],$solveMsg,2); ?>
                    <div class="contentBox" id="seoBox29">
                        <?php echo $seoBox29; ?>
                    </div>
                    <?php outQuestionBox($lang['AN4']); ?>
	            </div>
                
                <div class="seoBox" onclick="javascript:showSuggestion('seoBox30');">
                    <?php outHeadBox($lang['AN98'],$solveMsg,3); ?>
                    <div class="contentBox" id="seoBox30">
                        <?php echo $seoBox30; ?>
                    </div>
                    <?php outQuestionBox($lang['AN4']); ?>
	            </div>
                
                <div class="seoBox" onclick="javascript:showSuggestion('seoBox48');">
                    <?php outHeadBox($lang['120'],$solveMsg,3); ?>
                    <div class="contentBox" id="seoBox48">
                        <?php echo $seoBox48; ?>
                    </div>
                    <?php outQuestionBox($lang['AN4']); ?>
	            </div> 
                
                <div class="seoBox" onclick="javascript:showSuggestion('seoBox31');">
                    <?php outHeadBox($lang['AN99'],$solveMsg,1); ?>
                    <div class="contentBox" id="seoBox31">
                        <?php echo $seoBox31; ?>
                    </div>
                    <?php outQuestionBox($lang['AN4']); ?>
	            </div>
                
                <div class="seoBox" onclick="javascript:showSuggestion('seoBox32');">
                    <?php outHeadBox($lang['AN100'],$solveMsg,4); ?>
                    <div class="contentBox" id="seoBox32">
                        <?php echo $seoBox32; ?>
                    </div>
                    <?php outQuestionBox($lang['AN4']); ?>
	            </div>
                
                <div class="seoBox" onclick="javascript:showSuggestion('seoBox33');">
                    <?php outHeadBox($lang['AN101'],$solveMsg,4); ?>
                    <div class="contentBox" id="seoBox33">
                        <?php echo $seoBox33; ?>
                    </div>
                    <?php outQuestionBox($lang['AN4']); ?>
	            </div>
                
                <div class="seoBox" onclick="javascript:showSuggestion('seoBox34');">
                    <?php outHeadBox($lang['AN102'],$solveMsg,1); ?>
                    <div class="contentBox" id="seoBox34">
                        <?php echo $seoBox34; ?>
                    </div>
                    <?php outQuestionBox($lang['AN4']); ?>
	            </div>
                
                <div class="seoBox" onclick="javascript:showSuggestion('seoBox35');">
                    <?php outHeadBox($lang['AN103'],$solveMsg,1); ?>
                    <div class="contentBox" id="seoBox35">
                        <?php echo $seoBox35; ?>
                    </div>
                    <?php outQuestionBox($lang['AN4']); ?>
	            </div>
                
                </div>
                
                <div id="mobile">
                    <div class="clearSep"></div>
                    <h2 class="seoBox-title">
                        <?php trans('Mobile',$lang['17']); ?>
                    </h2>
                <div class="seoBox" onclick="javascript:showSuggestion('seoBox23');">
                    <?php outHeadBox($lang['AN91'],$solveMsg,3); ?>
                    <div class="contentBox" id="seoBox23">
                        <?php echo $seoBox23; ?>
                    </div>
                    <?php outQuestionBox($lang['AN4']); ?>
	            </div>
                
                <div class="seoBox" onclick="javascript:showSuggestion('seoBox24');">
                    <?php outHeadBox($lang['AN92'],$solveMsg,4); ?>
                    <div class="contentBox" id="seoBox24">
                        <?php echo $seoBox24; ?>
                    </div>
                    <?php outQuestionBox($lang['AN4']); ?>
	            </div>
                
                <div class="seoBox" onclick="javascript:showSuggestion('seoBox25');">
                    <?php outHeadBox($lang['AN93'],$solveMsg,2); ?>
                    <div class="contentBox" id="seoBox25">
                        <?php echo $seoBox25; ?>
                    </div>
                    <?php outQuestionBox($lang['AN4']); ?>
	            </div>
                
                <div class="seoBox" onclick="javascript:showSuggestion('seoBox49');">
                    <?php outHeadBox($lang['121'],$solveMsg,3); ?>
                    <div class="contentBox" id="seoBox49">
                        <?php echo $seoBox49; ?>
                    </div>
                    <?php outQuestionBox($lang['AN4']); ?>
                </div>
                
                </div>
                
                <div id="technologies">
                <div class="clearSep"></div>
                <h2 class="seoBox-title">
                    <?php trans('Technologies',$lang['18']); ?>
                </h2>
                <div class="seoBox" onclick="javascript:showSuggestion('seoBox36');">
                    <?php outHeadBox($lang['AN104'],$solveMsg,4); ?>
                    <div class="contentBox" id="seoBox36">
                        <?php echo $seoBox36; ?>
                    </div>
                    <?php outQuestionBox($lang['AN4']); ?>
	            </div>
                
                <div class="seoBox" onclick="javascript:showSuggestion('seoBox37');">
                    <?php outHeadBox($lang['AN105'],$solveMsg,3); ?>
                    <div class="contentBox" id="seoBox37">
                        <?php echo $seoBox37; ?>
                    </div>
                    <?php outQuestionBox($lang['AN4']); ?>
	            </div>
                
                <div class="seoBox" onclick="javascript:showSuggestion('seoBox38');">
                    <?php outHeadBox($lang['AN106'],$solveMsg,1); ?>
                    <div class="contentBox" id="seoBox38">
                        <?php echo $seoBox38; ?>
                    </div>
                    <?php outQuestionBox($lang['AN4']); ?>
	            </div>
                
                <div class="seoBox" onclick="javascript:showSuggestion('seoBox39');">
                    <?php outHeadBox($lang['AN107'],$solveMsg,2); ?>
                    <div class="contentBox" id="seoBox39">
                        <?php echo $seoBox39; ?>
                    </div>
                    <?php outQuestionBox($lang['AN4']); ?>
	            </div>
                
                <div class="seoBox" onclick="javascript:showSuggestion('seoBox40');">
                    <?php outHeadBox($lang['AN108'],$solveMsg,4); ?>
                    <div class="contentBox" id="seoBox40">
                        <?php echo $seoBox40; ?>
                    </div>
                    <?php outQuestionBox($lang['AN4']); ?>
	            </div>
                
                <div class="seoBox" onclick="javascript:showSuggestion('seoBox41');">
                    <?php outHeadBox($lang['AN109'],$solveMsg,1); ?>
                    <div class="contentBox" id="seoBox41">
                        <?php echo $seoBox41; ?>
                    </div>
                    <?php outQuestionBox($lang['AN4']); ?>
	            </div>
                
                </div>
                
                <div id="social">
               
                <div class="clearSep"></div>
                <h2 class="seoBox-title">
                    <?php trans('Social',$lang['19']); ?>
                </h2>
                <div class="seoBox" onclick="javascript:showSuggestion('seoBox44');">
                    <?php outHeadBox($lang['AN112'],$solveMsg,3); ?>
                    <div class="contentBox" id="seoBox44">
                        <?php echo $seoBox44; ?>
                    </div>
                    <?php outQuestionBox($lang['AN4']); ?>
	            </div>
                
                </div>
                
                <div id="visitors">
                <div class="clearSep"></div>
                <h2 class="seoBox-title">
                    <?php trans('Visitors',$lang['20']); ?>
                </h2>
                    
                <div class="seoBox" onclick="javascript:showSuggestion('seoBox45');">
                    <?php outHeadBox($lang['AN113'],$solveMsg,4); ?>
                    <div class="contentBox" id="seoBox45">
                        <?php echo $seoBox45; ?>
                    </div>
                    <?php outQuestionBox($lang['AN4']); ?>
	            </div>
                
                <div class="seoBox" onclick="javascript:showSuggestion('seoBox46');">
                    <?php outHeadBox($lang['AN114'],$solveMsg,3); ?>
                    <div class="contentBox" id="seoBox46">
                        <?php echo $seoBox46; ?>
                    </div>
                    <?php outQuestionBox($lang['AN4']); ?>
	            </div>
                
                <div class="seoBox" onclick="javascript:showSuggestion('seoBox47');">
                    <?php outHeadBox($lang['AN115'],$solveMsg,4); ?>
                    <div class="contentBox" id="seoBox47">
                        <?php echo $seoBox47; ?>
                    </div>
                    <?php outQuestionBox($lang['AN4']); ?>
	            </div>
                </div>
                
                <div id="link-analysis">
                    <div class="clearSep"></div>
                    <h2 class="seoBox-title">
                        <?php trans('Link Analysis',$lang['21']); ?>
                    </h2>
                    <div class="seoBox inPage" onclick="javascript:showSuggestion('seoBox13');">
                        <?php outHeadBox($lang['AN51'],$solveMsg,1); ?>
                        <div class="contentBox" id="seoBox13">
                            <?php echo $seoBox13; ?>
                        </div>
                        <?php outQuestionBox($lang['AN4']); ?>
    	            </div> 
                    
                    <div class="seoBox brokenLinks" onclick="javascript:showSuggestion('seoBox14');">
                        <?php outHeadBox($lang['AN58'],$solveMsg,1); ?>
                        <div class="contentBox" id="seoBox14">
                            <?php echo $seoBox14; ?>
                        </div>
                        <?php outQuestionBox($lang['AN4']); ?>
    	            </div> 

               </div>  
                  
                <div class="text-center">
                <br /> &nbsp; <br />
                <h4 style="color: #989ea8;"><?php trans('Try New Site',$lang['38']); ?></h4>
                <form method="POST" action="<?php createLink('domain'); ?>" onsubmit="return fixURL();">
                <div class="input-group reviewBox">
                    <div class="input-container">
                        <input type="text" tabindex="1" placeholder="<?php trans('Website URL to review',$lang['37']); ?>" id="url" name="url" class="form-control reviewIn"/>
                    </div>
                    
                    <div class="input-group-btn">
                        <button tabindex="2" type="submit" name="generate" class="btn btn-info url-lg">
                            <span class="ready"><?php trans('Analyze',$lang['36']); ?></span>
                        </button>
                    </div>
                </div>
                </form>
                <br />
                </div>

            <?php } ?>
            
            <br />
            
            <div class="xd_top_box bottom40 text-center">
            <?php echo $ads_720x90; ?>
            </div>
            
            </div>     
    
  </div>
</div>

<!-- App -->
<?php if($updateFound) { ?>
<script src="<?php themeLink('js/domain.js?v6'); ?>" type="text/javascript"></script>
<?php } else { ?>
<script src="<?php themeLink('js/dbdomain.js?v6'); ?>" type="text/javascript"></script>
<?php } ?>