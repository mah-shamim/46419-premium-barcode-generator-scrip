<?php

defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @theme: Default Style
 * @copyright � 2022 KOVATZ.COM
 *
 */
?> 
<div class="container main-container">
    <div class="row">
    
        <?php
        if($themeOptions['general']['sidebar'] == 'left')
            require_once(THEME_DIR."sidebar.php");
        ?>  
    
        <div class="col-md-9 contentLayer">

            <br /><br />
            <div class="csContent">
                <?php echo $page_content; ?>
            </div>
            
            <div class="top40 xd_top_box text-center">
                <?php echo $ads_720x90; ?>
            </div>

            <br />
        </div>
        <?php
        if($themeOptions['general']['sidebar'] == 'right')
            require_once(THEME_DIR."sidebar.php");
        ?> 
    </div>
</div>
<br />