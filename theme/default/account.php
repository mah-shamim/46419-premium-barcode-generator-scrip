<?php
defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: Rainbow PHP Framework
 * @copyright � 2022 KOVATZ.COM
 *
 */
?>
<script src="<?php themeLink('js/validator.js'); ?>" type="text/javascript"></script>
<script type="text/javascript">$(function () { $('.loginme-form').validator(); });</script>

<div class="container">
    <div class="row">
      	
    <?php
    if($themeOptions['general']['sidebar'] == 'left')
        require_once(THEME_DIR."sidebar.php");
    ?>   

  	<div class="col-md-9 top40">
            
        <div class="xd_top_box text-center">
            <?php echo $ads_720x90; ?>
        </div>
        
        <br />
                    
        <?php 
        if (isset($success)) {
            echo '<div class="alert alert-success">
            <strong>'.$lang['53'].'</strong> '.$success.'
            </div>'; 
            
            if ($pointOut == 'login') {
                if(!isset($args[0])){
                    if($args[0] != 'verification-success'){
                        echo '<br/> <div class="alert alert-info">
                        <strong>'.$lang['53'].'</strong> '.$lang['91'].'
                        </div>'; 
                        header('Location: '. createLink('',true));
                        echo '<meta http-equiv="refresh" content="1;url='.createLink('',true).'">';
                    }
                }   
            }
            
            if ($pointOut == 'register') {
                echo '<br/> <div class="alert alert-info">
                <strong>'.$lang['53'].'</strong> '.$lang['92'].'
                </div>'; 
            }
        } elseif (isset($error)) {
            echo '<div class="alert alert-error">
            <strong>'.$lang['53'].'</strong> '.$error.'
            </div>'; 
        }
        
        if ($pointOut == 'login') {
        ?>
        <form method="POST" action="<?php createLink('account/login'); ?>" class="loginme-form">
		<div class="loginpage">
            <?php if($enable_oauth){ ?>
			<div class="form-group connect-with">
				<div class="info"><?php trans('Sign in using social network',$lang['94']); ?></div>
				<a href="<?php createLink('facebook/login'); ?>" class="connect facebook" title="<?php trans('Sign in using Facebook',$lang['95']); ?>"><?php trans('Facebook',$lang['98']); ?></a>
	        	<a href="<?php createLink('google/login'); ?>" class="connect google" title="<?php trans('Sign in using Google',$lang['96']); ?>"><?php trans('Google',$lang['99']); ?></a>  	
	        	<a href="<?php createLink('twitter/login'); ?>" class="connect twitter" title="<?php trans('Sign in using Twitter',$lang['97']); ?>"><?php trans('Twitter',$lang['100']); ?></a>		        
		    </div>
            <?php } ?>
			<div class="info"><?php trans('Sign in with your username',$lang['101']); ?></div>
			<div class="form-group">
				<label><?php trans('Username',$lang['102']); ?> * <br />
					<input required="required" type="text" name="username" class="form-input width96" />
				</label>
			</div>	
			<div class="form-group">
				<label><?php trans('Password',$lang['103']); ?> * <br />
					<input required="required" type="password" name="password" class="form-input width96" />
				</label>
			</div>
		</div>
        <?php if ($login_page) { echo $captchaCode; } ?>
		<div class="login-footer bottom70">
			<button type="submit" class="btn btn-primary pull-left"><?php trans('Sign In',$lang['93']); ?></button>
			<div class="pull-right align-right">
			    <a href="<?php createLink('account/forget'); ?>"><?php trans('Forgot Password',$lang['104']); ?></a><br />
				<a href="<?php createLink('account/resend'); ?>"><?php trans('Resend Activation Email',$lang['105']); ?></a>
			</div>
		</div>
		 <input type="hidden" name="signin" value="<?php echo md5($date.$ip); ?>" />
		</form> 
                        
        <?php } elseif ($pointOut == 'register')  {?>
			<form action="<?php createLink('account/register'); ?>" method="POST" class="loginme-form">
			<div class="loginpage">
                <?php if($enable_oauth){ ?>
				<div class="form-group connect-with">
					<div class="info"><?php trans('Sign in using social network',$lang['94']); ?></div>
					<a href="<?php createLink('facebook/login'); ?>" class="connect facebook" title="<?php trans('Sign in using Facebook',$lang['95']); ?>"><?php trans('Facebook',$lang['98']); ?></a>
		        	<a href="<?php createLink('google/login'); ?>" class="connect google" title="<?php trans('Sign in using Google',$lang['96']); ?>"><?php trans('Google',$lang['99']); ?></a>  	
		        	<a href="<?php createLink('twitter/login'); ?>" class="connect twitter" title="<?php trans('Sign in using Twitter',$lang['97']); ?>"><?php trans('Twitter',$lang['100']); ?></a>		        
			    </div>
                <?php } ?>
   				<div class="info"><?php trans('Sign up with your email address',$lang['107']); ?></div>
				<div class="form-group">
					<label><?php trans('Username',$lang['102']); ?> * <br />
						<input required="required" type="text" name="username" class="form-input width96" />
					</label>
				</div>	
				<div class="form-group">
					<label><?php trans('Email',$lang['109']); ?> * <br />
						<input required="required" type="text" name="email" class="form-input width96" />
					</label>
				</div>
				<div class="form-group">
					<label><?php trans('Full Name',$lang['108']); ?> * <br />
						<input required="required" type="text" name="full" class="form-input width96" />
					</label>
				</div>
				<div class="form-group">
					<label><?php trans('Password',$lang['103']); ?> * <br />
						<input required="required" type="password" name="password" class="form-input width96" />
					</label>
				</div>
				</div>
                <?php if ($register_page) { echo $captchaCode; } ?>
			<div class="login-footer">
				<button type="submit" class="btn btn-primary"><?php trans('Sign Up',$lang['106']); ?></button>	
			</div>
			<input type="hidden" name="signup" value="<?php echo md5($date.$ip); ?>" />
			</form>
            
            <?php } elseif ($pointOut == 'forget')  {?>

            <form action="<?php createLink('account/forget'); ?>" method="POST" class="loginme-form">
		
        	<div class="loginpage">
				<div class="infoshort"><b><?php trans('Forgot Password',$lang['114']); ?></b></div><br />
	
	            <div class="form-group">
					<label><?php trans('Enter your email address',$lang['110']); ?> <br />
						<input required="required" type="text" name="email" class="form-input width96" />
					</label>
				</div>
            </div>
            
            <?php if ($reset_pass_page) { echo $captchaCode; } ?>
            
			<div class="login-footer">
				<button type="submit" class="btn btn-primary"><?php trans('Submit',$lang['7']); ?></button>	
			</div>
			 <input type="hidden" name="forget" value="<?php echo md5($date.$ip); ?>" />
			</form>
            
            <?php } elseif ($pointOut == 'resend')  {?>   
            <form action="<?php createLink('account/resend'); ?>" method="POST" class="loginme-form">
        		
        	<div class="loginpage">

				<div class="infoshort"><b><?php trans('Resend activation email',$lang['115']); ?></b></div><br />
	
                <div class="form-group">
					<label><?php trans('Enter your email address',$lang['110']); ?> * <br />
						<input required="required" type="text" name="email" class="form-input width96" />
					</label>
				</div>
            </div>
            <?php if ($resend_act_page) { echo $captchaCode; } ?>
			<div class="login-footer">
				<button type="submit" class="btn btn-primary"><?php trans('Submit',$lang['7']); ?></button>	
			</div>
			 <input type="hidden" name="resend" value="<?php echo md5($date.$ip); ?>" />
			</form>   
           
            <?php } else  {?> <br />
            
            <h4><?php trans('Options:',$lang['111']); ?></h4>
            <a href="<?php createLink('account/login'); ?>"><?php trans('Login to your Account',$lang['112']); ?></a><br />
            <a href="<?php createLink('account/register'); ?>"><?php trans('Register an account',$lang['113']); ?></a> <br />     
            <a href="<?php createLink('account/forget'); ?>"><?php trans('Forgot Password',$lang['114']); ?></a><br />
            <a href="<?php createLink('account/resend'); ?>"><?php trans('Resend activation email',$lang['115']); ?></a><br />
            <br /><br />
            <?php  } ?>
                
            <div class="xd_top_box text-center">
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