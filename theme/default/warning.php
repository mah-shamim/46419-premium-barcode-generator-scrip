<?php
defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name KOVATZ Seo Tools
 * @copyright � 2022 KOVATZ.COM
 *
 */
?>
<div class="container">
    <div class="row">
      	
    <?php
    if($themeOptions['general']['sidebar'] == 'left')
        require_once(THEME_DIR."sidebar.php");
    ?>   

  	<div class="col-md-9 top40">

        <div id="message">
            <?php if(isset($success)) 
                echo successMsg($success);
            elseif(isset($error))
                echo errorMsg($error);
            ?>
        </div>
        
        <?php if($args[0] == 'verfication'){ ?>
        <form id="contact-form" method="post" action="#">
            <div class="">
                <?php if ($reviewer_page) { echo $captchaCode; } ?>
                <button type="submit" class="btn btn-success btn-send"><i class="fa fa-mail-forward"></i> <?php trans('Continue',$lang['225']); ?></button>
            </div>
        </form>  
        <?php }elseif($args[0] == 'restricted-words'){ ?>
         
        <div class="top30 text-center alert alert-danger alert-dismissable alert-premium">
            <i style="color: #e74c3c; font-size: 120px;" class="fa fa-ban" aria-hidden="true"></i>
            <b><p style="color: #e74c3c;"><?php echo $lang['224']; ?></p></b>
            <div class="top20">
                <a class="btn btn-danger" href="<?php createLink(); ?>"><?php echo $lang['38']; ?></a>
            </div>
        </div>
        
        <?php }elseif($args[0] == 'restricted-domains'){ ?>
 
        <div class="top30 text-center alert alert-danger alert-dismissable alert-premium">
            <i style="color: #e74c3c; font-size: 120px;" class="fa fa-ban" aria-hidden="true"></i>
            <p style="color: #e74c3c;"><?php echo ucfirst($domainName). ' - ' . $lang['285']; ?> <br />
            <b><?php echo $reason; ?></b></p>
            <div class="top20">
                <a class="btn btn-danger" href="<?php createLink(); ?>"><?php echo $lang['38']; ?></a>
            </div>
        </div>
        
        <?php } ?>
    
        <br />
        
        <div class="xd_top_box text-center">
        <?php echo $ads_720x90; ?>
        </div>

    </div>  
     
    <?php
    if($themeOptions['general']['sidebar'] == 'right')
        require_once(THEME_DIR."sidebar.php");
    ?>
        	
    </div>
</div> <br />