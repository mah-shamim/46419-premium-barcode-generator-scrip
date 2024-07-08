<?php
defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: KOVATZ Seo Tools
 * @copyright © 2022 KOVATZ.COM
 *
 */
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $pageTitle; ?>  
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php adminLink(); ?>"><i class="<?php getAdminMenuIcon($controller,$menuBarLinks); ?>"></i> Admin</a></li>
        <li class="active"><a href="<?php adminLink($controller); ?>"><?php echo $pageTitle; ?></a> </li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $subTitle; ?></h3>
            </div><!-- /.box-header ba-la-ji -->
            <form action="#" method="POST">
            <div class="box-body">
          
            <?php if(isset($msg)) echo $msg; ?><br />
            

        <div class="row" style="padding-left: 5px;">
            <div class="col-md-8">

				<div class="form-group">
		            <div class="checkbox">
			           <label class="checkbox inline">
				          <input <?php isSelected($enable_reg,true,'2') ?> type="checkbox" name="enable_reg"  /> Enable user registration and login system
                       </label>
		            </div>
  	           </div>
               
				<div class="form-group">
		            <div class="checkbox">
			           <label class="checkbox inline">
				          <input <?php isSelected($enable_oauth,true,'2') ?> type="checkbox" name="enable_oauth"  /> Enable OAuth authentication support(Google, Facebook, Twitter etc)
                       </label>
		            </div>
  	           </div>
               
				<div class="form-group">
		            <div class="checkbox">
			           <label class="checkbox inline">
				          <input <?php isSelected($quick_login,true,'2') ?> type="checkbox" name="enable_quick"  /> Enable quick login windows
                       </label>
		            </div>
  	           </div>
                               
               <br />
               <div class="box-header with-border">
                <h3 class="box-title">Oauth Settings - Google</h3>
               </div><!-- /.box-header -->
                <br />

                <div class="form-group">
                    <label>Client ID</label>
                    <input type="text" placeholder="Enter your google api application id" name="oauth[g_client_id]" value="<?php echo $oauth_keys['oauth']['g_client_id']; ?>" class="form-control" />
                </div>
               <div class="form-group">
                    <label>Client Secret Code</label>
                    <input type="text" placeholder="Enter your google api application secret code" name="oauth[g_client_secret]" value="<?php echo $oauth_keys['oauth']['g_client_secret']; ?>" class="form-control" />
                </div>
                <div class="form-group">
                    <label>Redirect Uri (Callback)</label>
                    <input readonly="" type="text" placeholder="Enter callback link" name="oauth[g_redirect_uri]" value="<?php echo $oauth_keys['oauth']['g_redirect_uri']; ?>" class="form-control" />
                </div>
                
               <br />
               <div class="box-header with-border">
                <h3 class="box-title">Oauth Settings - Facebook</h3>
               </div><!-- /.box-header -->
                <br />
                
                <div class="form-group">
                    <label>Application ID:</label>
                    <input type="text" placeholder="Enter your facebook application id" name="oauth[fb_app_id]" value="<?php echo $oauth_keys['oauth']['fb_app_id']; ?>" class="form-control" />
                </div>
                <div class="form-group">
                    <label>Application Secret Code:</label>
                    <input type="text" placeholder="Enter your facebook application secret code" name="oauth[fb_app_secret]" value="<?php echo $oauth_keys['oauth']['fb_app_secret']; ?>" class="form-control" />
                </div>
                <div class="form-group">
                    <label>Redirect Uri (Callback)</label>
                    <input readonly="" type="text" placeholder="Enter callback link" name="oauth[fb_redirect_uri]" value="<?php echo $oauth_keys['oauth']['fb_redirect_uri']; ?>" class="form-control" />
                </div>
                <br />
                
               <div class="box-header with-border">
                <h3 class="box-title">Oauth Settings - Twitter</h3>
               </div><!-- /.box-header -->
                <br />
                
                <div class="form-group">
                    <label>Consumer Key:</label>
                    <input type="text" placeholder="Enter your twitter consumer key" name="oauth[twitter_key]" value="<?php echo $oauth_keys['oauth']['twitter_key']; ?>" class="form-control">
                </div>
                <div class="form-group">
                    <label>Consumer Secret:</label>
                    <input type="text" placeholder="Enter your twitter consumer secret" name="oauth[twitter_secret]" value="<?php echo $oauth_keys['oauth']['twitter_secret']; ?>" class="form-control">
                </div>
                <div class="form-group">
                    <label>Redirect Uri (Callback)</label>
                    <input readonly="" type="text" placeholder="Enter callback link" name="oauth[twitter_redirect_uri]" value="<?php echo $oauth_keys['oauth']['twitter_redirect_uri']; ?>" class="form-control">
                </div>
                <br />

                <input type="submit" name="save" value="Save" class="btn btn-primary"/>
                <br />
           </div>
           </div>    
            
            <br />
            
            </div><!-- /.box-body -->
            </form>
          </div><!-- /.box -->
  
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->
<?php
$footerAddArr[] = <<<EOD
  <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '100%'
        });
      });
  </script>  
EOD;
?>  