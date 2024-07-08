<?php
defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name KOVATZ Seo Tools
 * @copyright � 2022 KOVATZ.COM
 *
 */
?>

<script src="<?php themeLink('js/validator.js'); ?>" type="text/javascript"></script>
<script type="text/javascript">$(function () { $('#contact-form').validator(); });</script>

<div class="container">
    <div class="row">
      	
    <?php
    if($themeOptions['general']['sidebar'] == 'left')
        require_once(THEME_DIR."sidebar.php");
    ?>  

  	<div class="col-md-9 top40">

        <div id="message">
            <?php if(isset($success)) { ?>
            <div class="alert alert-success">
                <button data-dismiss="alert" class="close" type="button">x</button>
                <i class="fa fa-check green"></i>							
                <b><?php trans('Alert!',$lang['53']); ?></b> <?php echo $success ?>
            </div>
            <?php } elseif(isset($error)) { ?>
            <div class="alert alert-danger">
                <button data-dismiss="alert" class="close" type="button">x</button>
                <i class="fa fa-ban red"></i>							
                <b><?php trans('Alert!',$lang['53']); ?></b> <?php echo $error ?>
            </div>
            <?php } ?>
        </div>

        <form id="contact-form" method="post" action="#">

            <h4> <?php trans('We value all the feedbacks received from our customers.',$lang['42']); ?></h4>
            <?php trans('If you have any queries, comments, suggestions or have anything to talk about.',$lang['43']); ?>
            <br/>
            <br/>

            <div class="controls">
    
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="form_name"><?php trans('Name *',$lang['54']); ?></label>
                            <input value="<?php echo $name; ?>" id="form_name" type="text" name="name" class="form-control" placeholder="<?php trans('Please enter your fullname *',$lang['44']); ?>" required="required" data-error="<?php trans('Fullname is required',$lang['45']); ?>" />
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="form_email"><?php trans('Email *',$lang['55']); ?></label>
                            <input value="<?php echo $from; ?>" id="form_email" type="email" name="email" class="form-control" placeholder="<?php trans('Please enter your email *',$lang['46']); ?>" required="required" data-error="<?php trans('Valid email is required',$lang['47']); ?>" />
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="form_sub"><?php trans('Subject *',$lang['56']); ?></label>
                            <input value="<?php echo $sub; ?>" id="form_sub" type="text" name="sub" class="form-control" placeholder="<?php trans('Please enter your subject *',$lang['49']); ?>" required="required" data-error="<?php trans('Subject is required',$lang['48']); ?>" />
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="form_message"><?php trans('Message *',$lang['57']); ?></label>
                            <textarea id="form_message" name="message" class="form-control" placeholder="<?php trans('Please enter your message *',$lang['50']); ?>" rows="4" required="required" data-error="<?php trans('Please leave some message',$lang['51']); ?>"><?php echo $message; ?></textarea>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <?php if ($cap_contact) { echo $captchaCode; } ?>
                            <button type="submit" class="btn btn-success btn-send"><i class="fa fa-envelope"></i> <?php trans('Send message',$lang['52']); ?></button>
                    </div>
                </div>
    
             </div>
        </form>  
    
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