<?php
defined('APP_NAME') or die(header('HTTP/1.1 403 Forbidden'));

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
            <form action="#" method="POST">
            <div class="box-body">
          
            <?php if(isset($msg)) echo $msg; ?><br />
            
            <div class="form-group">
            <label>Captcha protection for following pages:</label>
                <select name="cap_pages[]" class="form-control select2" multiple="multiple" data-placeholder="Which pages need image verifications?" style="width: 100%;">
                  <?php 
                    foreach($capList as $capName=>$capRaw){
                        echo '<option '.isSelected($cap_options[$capName], true, 1,null,true).' value="'.$capName.'">'.$capRaw.'</option>';
                    }
                  ?>
                </select>
            </div>
            
            <div class="form-group">
                <label> Select Capthca Service </label>
                <select name="sel_cap" class="form-control">
                <?php foreach($cap_data as $capbasename => $cap){
                    echo '<option '. isSelected($cap_type, true, 1, $capbasename,true).' value="'.$capbasename.'" >'.$cap['cap_name'].'</option>';
                }?>
                </select>
            </div>
            
            <div class="hide" id="recap"> 
                <input type="hidden" value="Google reCAPTCHA" name="cap[recap][cap_name]" />            
                <div class="form-group">
                    <label>reCAPTCHA Secret Key</label>
                    <input type="text" placeholder="Enter your reCAPTCHA secret key" name="cap[recap][recap_seckey]" value="<?php echo $recap_seckey; ?>" class="form-control" />
                </div>
                <div class="form-group">
                    <label>reCAPTCHA Site Key</label>
                    <input type="text" placeholder="Enter your reCAPTCHA site key" name="cap[recap][recap_sitekey]" value="<?php echo $recap_sitekey; ?>" class="form-control" />
                </div>
            </div> 
            
            <div class="hide" id="phpcap">  
                <input type="hidden" value="Built-in PHP Image Verification" name="cap[phpcap][cap_name]" />  
				<div class="form-group">
					<label>Difficulty type</label>
					<select class="form-control" name="cap[phpcap][mode]">
    					<option <?php echo isSelected($mode, true, 1, 'Easy'); ?> value="Easy">Easy</option>
                        <option <?php echo isSelected($mode, true, 1, 'Normal'); ?> value="Normal">Normal</option>
                        <option <?php echo isSelected($mode, true, 1, 'Tough'); ?> value="Tough">Tough</option>	
                    </select>
				</div>         
                <div class="form-group">
                    <label>Allowed characters</label>
                    <input type="text" placeholder="Enter your characters" name="cap[phpcap][allowed]" value="<?php echo $allowed; ?>" required="" class="form-control" />
                </div>
                <div class="form-group">
                    <label>Captcha text color</label>                                        
                    <input type="text" value="<?php echo $color; ?>" class="form-control  my-colorpicker1 colorpicker-element" name="cap[phpcap][color]" />
                </div>
				<div class="form-group">
					<label>Multiple background images</label>
					<select class="form-control" name="cap[phpcap][mul]">
    					<option <?php echo isSelected($mul, true, 1); ?> value="yes">Yes</option>
                        <option <?php echo isSelected($mul, false, 1); ?> value="no">No</option>
                    </select>
				</div>   
            </div>
            
            <input type="submit" name="save" value="Save Settings" class="btn btn-primary"/>
            <br /><br />
        </div><!-- /.box-body -->
        </form>
          </div><!-- /.box -->
  
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->
  
<?php
$footerAddArr[] = <<<EOD
    <script> 
       var oldSel;
       $(function () {
        $(".select2").select2();
        $(".my-colorpicker1").colorpicker();
        var selVal = jQuery('select[name="sel_cap"]').val();
        oldSel = selVal;
        $('#'+selVal).removeClass("hide");
        $('#'+selVal).fadeIn();
       });
        
       $('select[name="sel_cap"]').on('change', function() {
            var selVal = jQuery('select[name="sel_cap"]').val();
            $('#'+oldSel).fadeOut();
            $('#'+selVal).removeClass("hide");
            $('#'+selVal).fadeIn();
            oldSel = selVal;
        });
    </script>
EOD;
?>