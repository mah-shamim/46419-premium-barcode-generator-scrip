<?php
defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/**
 * @author MD ARIFUL HAQUE
 * @Theme: Default Style
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
                
        <div class="row">
            <?php foreach($domainList as $domain){ ?>
            <div class="col-md-4">
                <div class="sites-block sites-recent">
                    <a rel="nofollow" href="<?php createLink('domain/'.$domain[0]); ?>"><img alt="<?php echo $domain[0]; ?>" src="<?php createLink('ajax/snap/'.$domain[0]); ?>" class="image-overlay" /></a>
                    <div class="caption">
                        <a href="<?php createLink('domain/'.$domain[0]); ?>"><?php echo ucfirst($domain[0]); ?></a>
                    </div>
                    <div class="details clearfix">
                          <span><strong class="recentStrong"><?php echo $domain[1]; ?></strong><?php trans('Score',$lang['134']); ?></span>
                          <span><strong class="recentStrong"><?php echo $domain[2]; ?></strong><?php trans('Global Rank',$lang['135']); ?></span>
                          <span><strong class="recentStrong"><?php echo $domain[3]; ?>%</strong><?php trans('Page Speed',$lang['136']); ?></span>
                    </div>
                </div>
            </div>
            <?php } ?>

            </div><!-- /.row -->
        
        <?php echo $pagination->process(); ?>
    
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