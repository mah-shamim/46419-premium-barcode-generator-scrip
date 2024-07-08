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
<br /><br />
'.$lang['33'].'...
<br /><br />
</div>';
?>
<script>
var passScore = '<?php echo makeJavascriptStr($passScore); ?>';
var improveScore = '<?php echo makeJavascriptStr($improveScore); ?>';
var errorScore = '<?php echo makeJavascriptStr($errorScore); ?>';
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
<script src="<?php themeLink('js/chart.min.js'); ?>" type="text/javascript"></script>
<link href="<?php themeLink('css/www.css'); ?>" rel="stylesheet" />

<div class="container">
  <div class="row">
  
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
    
  <div class="col-sm-12 top40"> 
 
    <div class="row" id="overview">
      <div class="col-sm-3">
        <?php echo $ads_250x300; ?> 
      </div>
      <div class="col-sm-5">
        <div id="container">
            <canvas id="canvas" height="200"></canvas>
        </div>
      </div>
      <div class="col-sm-4 top40" id="scoreBoard">
        
        <div class="proWebBox">
            <span><?php echo ucfirst($firstHost); ?></span>
            <span class="text-right"><?php echo $first_passScore; ?></span>
            
            <div class="progress bo5">
              <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $first_passScore; ?>"
              aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $first_passScore; ?>%">
              </div>
            </div>
            <small><span><?php echo $lang['282']. ' ' .$firstDate; ?></span></small>
        </div>
        
        <div class="proWebBox top20">
            <span><?php echo ucfirst($secHost); ?></span>
            <span class="text-right"><?php echo $sec_passScore; ?></span>
            
            <div class="progress bo5">
              <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?php echo $sec_passScore; ?>"
              aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $sec_passScore; ?>%">
              </div>
            </div>
            <small><span><?php echo $lang['282']. ' ' .$secDate; ?></span></small>
        </div>
        
        <div class="text-center top30">
            <a id="shareBtn" class="btn btn-blue"> <i class="fa fa-share-alt-square"></i> <?php trans('Share',$lang['116']); ?> </a> 
        </div>
      </div>
      
      <div class="col-sm-12">
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
      
    </div>

    <div class="row" id="seo">
        <div class="clearSep"></div>
        <h2 class="seoBox-title">
            <?php trans('SEO',$lang['35']); ?>
        </h2>
    
        <div class="col-sm-12"> 
           <div class="seoBox" onclick="javascript:showSuggestion('seoBox1');">
                <?php outHeadBox($lang['AN1'],$solveMsg,1); ?>
                <div class="contentBox" id="seoBox1">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox1; ?></td><td><?php echo $sec_seoBox1; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div>
        
        <div class="col-sm-12"> 
            <div class="seoBox" onclick="javascript:showSuggestion('seoBox2');">
                <?php outHeadBox($lang['AN2'],$solveMsg,1); ?>
                <div class="contentBox" id="seoBox2">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox2; ?></td><td><?php echo $sec_seoBox2; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div> 
        
        <div class="col-sm-12"> 
            <div class="seoBox" onclick="javascript:showSuggestion('seoBox3');">
                <?php outHeadBox($lang['AN3'],$solveMsg,1); ?>
                <div class="contentBox" id="seoBox3">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox3; ?></td><td><?php echo $sec_seoBox3; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div> 
        
        <div class="col-sm-12"> 
            <div class="seoBox headingResult" onclick="javascript:showSuggestion('seoBox4');">
                <?php outHeadBox($lang['AN16'],$solveMsg,2); ?>
                <div class="contentBox" id="seoBox4">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox4; ?></td><td><?php echo $sec_seoBox4; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div> 
        
        <div class="col-sm-12"> 
            <div class="seoBox" onclick="javascript:showSuggestion('seoBox5');">
                <?php outHeadBox($lang['AN17'],$solveMsg,4); ?>
                <div class="contentBox" id="seoBox5">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox5; ?></td><td><?php echo $sec_seoBox5; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div> 
        
        <div class="col-sm-12"> 
            <div class="seoBox altImgResult" onclick="javascript:showSuggestion('seoBox6');">
                <?php outHeadBox($lang['AN20'],$solveMsg,1); ?>
                <div class="contentBox" id="seoBox6">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox6; ?></td><td><?php echo $sec_seoBox6; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div> 
        
        <div class="col-sm-12"> 
            <div class="seoBox" onclick="javascript:showSuggestion('seoBox7');">
                <?php outHeadBox($lang['AN28'],$solveMsg,4); ?>
                <div class="contentBox" id="seoBox7">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox7; ?></td><td><?php echo $sec_seoBox7; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div> 
        
        <div class="col-sm-12"> 
            <div class="seoBox keyConsResult" onclick="javascript:showSuggestion('seoBox8');">
                <?php outHeadBox($lang['AN30'],$solveMsg,1); ?>
                <div class="contentBox" id="seoBox8">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox8; ?></td><td><?php echo $sec_seoBox8; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div>  
        
        <div class="col-sm-12"> 
            <div class="seoBox" onclick="javascript:showSuggestion('seoBox9');">
                <?php outHeadBox($lang['AN35'],$solveMsg,2); ?>
                <div class="contentBox" id="seoBox9">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox9; ?></td><td><?php echo $sec_seoBox9; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div> 
        
        <div class="col-sm-12"> 
            <div class="seoBox" onclick="javascript:showSuggestion('seoBox10');">
                <?php outHeadBox($lang['AN40'],$solveMsg,2); ?>
                <div class="contentBox" id="seoBox10">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox10; ?></td><td><?php echo $sec_seoBox10; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div> 
        
        <div class="col-sm-12"> 
            <div class="seoBox" onclick="javascript:showSuggestion('seoBox11');">
                <?php outHeadBox($lang['AN45'],$solveMsg,1); ?>
                <div class="contentBox" id="seoBox11">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox11; ?></td><td><?php echo $sec_seoBox11; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div> 
        
        <div class="col-sm-12"> 
            <div class="seoBox" onclick="javascript:showSuggestion('seoBox12');">
                <?php outHeadBox($lang['AN48'],$solveMsg,1); ?>
                <div class="contentBox" id="seoBox12">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox12; ?></td><td><?php echo $sec_seoBox12; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div> 
        
        <div class="col-sm-12"> 
            <div class="seoBox" onclick="javascript:showSuggestion('seoBox15');">
                <?php outHeadBox($lang['AN59'],$solveMsg,1); ?>
                <div class="contentBox" id="seoBox15">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox15; ?></td><td><?php echo $sec_seoBox15; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div> 
        
        <div class="col-sm-12"> 
            <div class="seoBox" onclick="javascript:showSuggestion('seoBox16');">
                <?php outHeadBox($lang['AN60'],$solveMsg,1); ?>
                <div class="contentBox" id="seoBox16">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox16; ?></td><td><?php echo $sec_seoBox16; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div>  
        
        <div class="col-sm-12"> 
            <div class="seoBox" onclick="javascript:showSuggestion('seoBox17');">
                <?php outHeadBox($lang['AN61'],$solveMsg,2); ?>
                <div class="contentBox" id="seoBox17">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox17; ?></td><td><?php echo $sec_seoBox17; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div>  
        
        <div class="col-sm-12"> 
            <div class="seoBox" onclick="javascript:showSuggestion('seoBox18');">
                <?php outHeadBox($lang['AN62'],$solveMsg,3); ?>
                <div class="contentBox" id="seoBox18">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox18; ?></td><td><?php echo $sec_seoBox18; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div> 
        
        <div class="col-sm-12"> 
            <div class="seoBox" onclick="javascript:showSuggestion('seoBox19');">
                <?php outHeadBox($lang['AN63'],$solveMsg,1); ?>
                <div class="contentBox" id="seoBox19">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox19; ?></td><td><?php echo $sec_seoBox19; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div> 
        
        <div class="col-sm-12"> 
            <div class="seoBox" onclick="javascript:showSuggestion('seoBox20');">
                <?php outHeadBox($lang['AN76'],$solveMsg,1); ?>
                <div class="contentBox" id="seoBox20">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox20; ?></td><td><?php echo $sec_seoBox20; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div>
        
        <div class="col-sm-12"> 
            <div class="seoBox" onclick="javascript:showSuggestion('seoBox21');">
                <?php outHeadBox($lang['AN81'],$solveMsg,4); ?>
                <div class="contentBox" id="seoBox21">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox21; ?></td><td><?php echo $sec_seoBox21; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div>  
        
        <div class="col-sm-12"> 
            <div class="seoBox whois" onclick="javascript:showSuggestion('seoBox22');">
                <?php outHeadBox($lang['AN83'],$solveMsg,4); ?>
                <div class="contentBox" id="seoBox22">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox22; ?></td><td><?php echo $sec_seoBox22; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div>  
        
        <div class="col-sm-12"> 
            <div class="seoBox" onclick="javascript:showSuggestion('seoBox42');">
                <?php outHeadBox($lang['AN110'],$solveMsg,2); ?>
                <div class="contentBox" id="seoBox42">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox42; ?></td><td><?php echo $sec_seoBox42; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div> 
        
        <div class="col-sm-12"> 
            <div class="seoBox" onclick="javascript:showSuggestion('seoBox43');">
                <?php outHeadBox($lang['AN111'],$solveMsg,4); ?>
                <div class="contentBox" id="seoBox43">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox43; ?></td><td><?php echo $sec_seoBox43; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div> 
        
    </div>  
    <div class="row" id="usability">
        <div class="clearSep"></div>
        <h2 class="seoBox-title">
            <?php trans('Usability',$lang['16']); ?>
        </h2>
        
        <div class="col-sm-12"> 
            <div class="seoBox" onclick="javascript:showSuggestion('seoBox26');">
                <?php outHeadBox($lang['AN94'],$solveMsg,4); ?>
                <div class="contentBox" id="seoBox26">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox26; ?></td><td><?php echo $sec_seoBox26; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div> 
        
        <div class="col-sm-12"> 
            <div class="seoBox" onclick="javascript:showSuggestion('seoBox27');">
                <?php outHeadBox($lang['AN95'],$solveMsg,1); ?>
                <div class="contentBox" id="seoBox27">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox27; ?></td><td><?php echo $sec_seoBox27; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div>
        
        <div class="col-sm-12"> 
            <div class="seoBox" onclick="javascript:showSuggestion('seoBox28');">
                <?php outHeadBox($lang['AN96'],$solveMsg,1); ?>
                <div class="contentBox" id="seoBox28">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox28; ?></td><td><?php echo $sec_seoBox28; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div> 
        
        <div class="col-sm-12"> 
            <div class="seoBox" onclick="javascript:showSuggestion('seoBox29');">
                <?php outHeadBox($lang['AN97'],$solveMsg,2); ?>
                <div class="contentBox" id="seoBox29">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox29; ?></td><td><?php echo $sec_seoBox29; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div>
        
        <div class="col-sm-12"> 
            <div class="seoBox" onclick="javascript:showSuggestion('seoBox30');">
                <?php outHeadBox($lang['AN98'],$solveMsg,3); ?>
                <div class="contentBox" id="seoBox30">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox30; ?></td><td><?php echo $sec_seoBox30; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div>
        
        <div class="col-sm-12"> 
            <div class="seoBox" onclick="javascript:showSuggestion('seoBox48');">
                <?php outHeadBox($lang['120'],$solveMsg,3); ?>
                <div class="contentBox" id="seoBox48">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox48; ?></td><td><?php echo $sec_seoBox48; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div>
        
        <div class="col-sm-12"> 
            <div class="seoBox" onclick="javascript:showSuggestion('seoBox31');">
                <?php outHeadBox($lang['AN99'],$solveMsg,1); ?>
                <div class="contentBox" id="seoBox31">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox31; ?></td><td><?php echo $sec_seoBox31; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div>
        
        <div class="col-sm-12"> 
            <div class="seoBox" onclick="javascript:showSuggestion('seoBox32');">
                <?php outHeadBox($lang['AN100'],$solveMsg,4); ?>
                <div class="contentBox" id="seoBox32">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox32; ?></td><td><?php echo $sec_seoBox32; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div>
        
        <div class="col-sm-12"> 
            <div class="seoBox" onclick="javascript:showSuggestion('seoBox33');">
                <?php outHeadBox($lang['AN101'],$solveMsg,4); ?>
                <div class="contentBox" id="seoBox33">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox33; ?></td><td><?php echo $sec_seoBox33; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div>
        
        <div class="col-sm-12"> 
            <div class="seoBox" onclick="javascript:showSuggestion('seoBox34');">
                <?php outHeadBox($lang['AN102'],$solveMsg,1); ?>
                <div class="contentBox" id="seoBox34">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox34; ?></td><td><?php echo $sec_seoBox34; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div>
        
        <div class="col-sm-12"> 
            <div class="seoBox" onclick="javascript:showSuggestion('seoBox35');">
                <?php outHeadBox($lang['AN103'],$solveMsg,1); ?>
                <div class="contentBox" id="seoBox35">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox35; ?></td><td><?php echo $sec_seoBox35; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div>
        
    </div>
    
    <div class="row" id="mobile">
        <div class="clearSep"></div>
        <h2 class="seoBox-title">
            <?php trans('Mobile',$lang['17']); ?>
        </h2>
        
        <div class="col-sm-12"> 
            <div class="seoBox" onclick="javascript:showSuggestion('seoBox23');">
                <?php outHeadBox($lang['AN91'],$solveMsg,3); ?>
                <div class="contentBox" id="seoBox23">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox23; ?></td><td><?php echo $sec_seoBox23; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div>
        
        <div class="col-sm-12"> 
            <div class="seoBox" onclick="javascript:showSuggestion('seoBox24');">
                <?php outHeadBox($lang['AN92'],$solveMsg,4); ?>
                <div class="contentBox" id="seoBox24">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox24; ?></td><td><?php echo $sec_seoBox24; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div>
        
        <div class="col-sm-12"> 
            <div class="seoBox" onclick="javascript:showSuggestion('seoBox25');">
                <?php outHeadBox($lang['AN93'],$solveMsg,2); ?>
                <div class="contentBox" id="seoBox25">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox25; ?></td><td><?php echo $sec_seoBox25; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div>
        
        <div class="col-sm-12"> 
            <div class="seoBox" onclick="javascript:showSuggestion('seoBox49');">
                <?php outHeadBox($lang['121'],$solveMsg,3); ?>
                <div class="contentBox" id="seoBox49">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox49; ?></td><td><?php echo $sec_seoBox49; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div>
        
    </div>
    
    <div class="row" id="technologies">
        <div class="clearSep"></div>
        <h2 class="seoBox-title">
            <?php trans('Technologies',$lang['18']); ?>
        </h2>
        
        <div class="col-sm-12"> 
            <div class="seoBox" onclick="javascript:showSuggestion('seoBox36');">
                <?php outHeadBox($lang['AN104'],$solveMsg,4); ?>
                <div class="contentBox" id="seoBox36">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox36; ?></td><td><?php echo $sec_seoBox36; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div>
        
        <div class="col-sm-12"> 
            <div class="seoBox" onclick="javascript:showSuggestion('seoBox37');">
                <?php outHeadBox($lang['AN105'],$solveMsg,3); ?>
                <div class="contentBox" id="seoBox37">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox37; ?></td><td><?php echo $sec_seoBox37; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div>
        
        <div class="col-sm-12"> 
            <div class="seoBox" onclick="javascript:showSuggestion('seoBox38');">
                <?php outHeadBox($lang['AN106'],$solveMsg,1); ?>
                <div class="contentBox" id="seoBox38">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox38; ?></td><td><?php echo $sec_seoBox38; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div>
        
        <div class="col-sm-12"> 
            <div class="seoBox" onclick="javascript:showSuggestion('seoBox39');">
                <?php outHeadBox($lang['AN107'],$solveMsg,2); ?>
                <div class="contentBox" id="seoBox39">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox39; ?></td><td><?php echo $sec_seoBox39; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div>
        
        <div class="col-sm-12"> 
            <div class="seoBox" onclick="javascript:showSuggestion('seoBox40');">
                <?php outHeadBox($lang['AN108'],$solveMsg,4); ?>
                <div class="contentBox" id="seoBox40">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox40; ?></td><td><?php echo $sec_seoBox40; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div>
        
        <div class="col-sm-12"> 
            <div class="seoBox" onclick="javascript:showSuggestion('seoBox41');">
                <?php outHeadBox($lang['AN109'],$solveMsg,1); ?>
                <div class="contentBox" id="seoBox41">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox41; ?></td><td><?php echo $sec_seoBox41; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div>

    </div>
    
    <div class="row" id="social">
        <div class="clearSep"></div>
        <h2 class="seoBox-title">
            <?php trans('Social',$lang['19']); ?>
        </h2>
        
        <div class="col-sm-12"> 
            <div class="seoBox" onclick="javascript:showSuggestion('seoBox44');">
                <?php outHeadBox($lang['AN112'],$solveMsg,3); ?>
                <div class="contentBox" id="seoBox44">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox44; ?></td><td><?php echo $sec_seoBox44; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div> 
        
    </div>
    
    <div class="row" id="visitors">
        <div class="clearSep"></div>
        <h2 class="seoBox-title">
            <?php trans('Visitors',$lang['20']); ?>
        </h2>
        
        <div class="col-sm-12"> 
            <div class="seoBox" onclick="javascript:showSuggestion('seoBox45');">
                <?php outHeadBox($lang['AN113'],$solveMsg,4); ?>
                <div class="contentBox" id="seoBox45">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox45; ?></td><td><?php echo $sec_seoBox45; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div> 
        
        <div class="col-sm-12"> 
            <div class="seoBox" onclick="javascript:showSuggestion('seoBox46');">
                <?php outHeadBox($lang['AN114'],$solveMsg,3); ?>
                <div class="contentBox" id="seoBox46">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox46; ?></td><td><?php echo $sec_seoBox46; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div>
        
        <div class="col-sm-12"> 
            <div class="seoBox" onclick="javascript:showSuggestion('seoBox47');">
                <?php outHeadBox($lang['AN115'],$solveMsg,4); ?>
                <div class="contentBox" id="seoBox47">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox47; ?></td><td><?php echo $sec_seoBox47; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div>  
        
    </div>
    
    <div class="row" id="link-analysis">
        <div class="clearSep"></div>
        <h2 class="seoBox-title">
            <?php trans('Link Analysis',$lang['21']); ?>
        </h2>
        
        <div class="col-sm-12"> 
                <div class="seoBox inPage" onclick="javascript:showSuggestion('seoBox13');">
                    <?php outHeadBox($lang['AN51'],$solveMsg,1); ?>
                    <div class="contentBox" id="seoBox13">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox13; ?></td><td><?php echo $sec_seoBox13; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div>
        
        <div class="col-sm-12"> 
                <div class="seoBox brokenLinks" onclick="javascript:showSuggestion('seoBox14');">
                    <?php outHeadBox($lang['AN58'],$solveMsg,1); ?>
                    <div class="contentBox" id="seoBox14">
                    <table class="table compare-table"><tbody><tr>
                        <td><?php echo $first_seoBox14; ?></td><td><?php echo $sec_seoBox14; ?></td>
                    </tr></tbody></table>
                </div>
                <?php outQuestionBox($lang['AN4']); ?>
            </div>
        </div>
        
    </div>
    
</div> 

</div>

   <?php } ?>  
<br />

<div class="xd_top_box bottom40 text-center">
<?php echo $ads_720x90; ?>
</div>
</div>

<script>
    var color = Chart.helpers.color;
    var barChartData = {
        labels: ["<?php echo ucfirst($firstHost); ?>", "<?php echo ucfirst($secHost); ?>"],
        datasets: [{
            label: '<?php echo $lang['26']; ?>',
            backgroundColor: color('#27ae60').alpha(0.5).rgbString(),
            borderColor: color('#27ae60').rgbString(),
            borderWidth: 1,
            data: [
                '<?php echo $first_passScore; ?>', 
                '<?php echo $sec_passScore; ?>'
            ]
        }, {
            label: '<?php echo $lang['25']; ?>',
            backgroundColor: color('#f39c12').alpha(0.5).rgbString(),
            borderColor: color('#f39c12').rgbString(),
            borderWidth: 1,
            data: [
                '<?php echo $first_improveScore; ?>',
                '<?php echo $sec_improveScore; ?>'
            ]
        },{
            label: '<?php echo $lang['24']; ?>',
            backgroundColor: color('#e74b3b').alpha(0.5).rgbString(),
            borderColor: color('#e74b3b').rgbString(),
            borderWidth: 1,
            data: [
                '<?php echo $first_errorScore; ?>',
                '<?php echo $sec_errorScore; ?>'
            ]
        }]

    };

    window.onload = function() {
        var ctx = document.getElementById("canvas").getContext("2d");
        window.myBar = new Chart(ctx, {
            type: 'bar',
            data: barChartData,
            options: {
                responsive: true,
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: '<?php echo $lang['143']; ?>'
                }
            }
        });

    };

</script>
<script src="<?php themeLink('js/dbdomain.js?v6'); ?>" type="text/javascript"></script>