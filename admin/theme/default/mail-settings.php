<?php
defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: PDF Studio
 * @copyright © 2024 KOVATZ
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
            <form onsubmit="return protocolCheck('0');" action="#" method="POST">
            <div class="box-body">
          
            <?php if(isset($msg)) echo $msg; ?><br />
                <div class="row" style="padding-left: 5px;">
                    <div class="col-md-8">
                    <div class="form-group">
                    <label>Select your Mail Protocol: </label>
                    <select name="protocol" class="form-control"> 
       					<option <?php echo isSelected($protocol, true, 1, '1'); ?> value="1">PHP Mail</option>
     					<option <?php echo isSelected($protocol, true, 1, '2'); ?> value="2">SMTP</option>
                    </select>                     
                </div>                                              
                <br />
                   <div class="box-header with-border">
                    <h3 class="box-title">SMTP Information </h3>
                   </div><!-- /.box-header -->
                    <br />
                       
                    <div class="form-group">
                        <label for="smtp_host">SMTP Host</label>
                        <input type="text" placeholder="Enter smtp host" name="smtp_host" value="<?php echo $smtp_host; ?>" class="form-control">
                    </div>
                <div class="form-group">											
                  <label for="smtp_auth">SMTP Auth</label>
			      <select name="auth" class="form-control">  
                       <option <?php echo isSelected($auth, true, 1); ?> value="true">True</option>
                       <option <?php echo isSelected($auth, false, 1); ?> value="false">False</option>
                   </select>				
					</div> <!-- /form-group -->
                    
                   <div class="form-group">
                        <label for="smtp_port">SMTP Port</label>
                        <input type="text" placeholder="Enter smtp port" name="smtp_port" value="<?php echo $smtp_port; ?>" class="form-control">
                    </div>
                       <div class="form-group">
                        <label for="smtp_user">SMTP Username</label>
                        <input type="text" placeholder="Enter smtp username" name="smtp_user" value="<?php echo $smtp_username; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="smtp_pass">SMTP Password</label>
                        <input type="password" placeholder="Enter smtp password" name="smtp_pass" value="<?php echo $smtp_password; ?>" class="form-control">
                    </div>       
                    
                 <div class="form-group">											
                <label for="smtp_socket">SMTP Secure Socket</label>
			    <select name="socket" class="form-control">
                    <option <?php echo isSelected($socket, true, 1, 'tls'); ?> value="tls">TLS</option>
                    <option <?php echo isSelected($socket, true, 1, 'ssl'); ?> value="ssl">SSL</option>
                </select>				
					</div> <!-- /form-group -->      
                    </div> </div>                                     
                <input type="submit" name="save" value="Save" class="btn btn-primary"/>
                <br />
                
                </div><!-- /.box-body -->
                </form>
              </div><!-- /.box -->
      
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
<?php
$footerAddArr[] = <<<EOD
  <script>
      function protocolCheck(val){
        if(val == '1'){
            $('input[name=smtp_port]').attr('disabled', 'disabled');
            $('input[name=smtp_user]').attr('disabled', 'disabled');
            $('input[name=smtp_pass]').attr('disabled', 'disabled');
            $('select[name=socket]').attr('disabled', 'disabled');
            $('select[name=auth]').attr('disabled', 'disabled');
            $('input[name=smtp_host]').attr('disabled', 'disabled');
        }else{
            $('input[name=smtp_port]').removeAttr('disabled');
            $('input[name=smtp_user]').removeAttr('disabled');
            $('input[name=smtp_pass]').removeAttr('disabled');
            $('select[name=socket]').removeAttr('disabled');
            $('select[name=auth]').removeAttr('disabled');
            $('input[name=smtp_host]').removeAttr('disabled');
        }
        return true;
      }
      var selVal;  
      $(function () {
        selVal = jQuery('select[name="protocol"]').val();
        protocolCheck(selVal);
      });      
      $('select[name="protocol"]').on('change', function() {
        selVal = jQuery('select[name="protocol"]').val();
        protocolCheck(selVal);
      });
  </script>  
EOD;
?>  