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
        <li><a href="<?php adminLink(); ?>"> Admin</a></li>
        <li class="active"><a href="<?php adminLink($controller); ?>"><?php echo $pageBuilderTitle; ?></a></li>
        <li class="active"><a href="<?php adminLink($controller); ?>"><?php echo $pageTitle; ?></a> </li> 
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="<?php echo $page1; ?>"><a href="#general" data-toggle="tab"><i class="fa fa-wrench" aria-hidden="true"></i>&nbsp; General</a></li>
          <li class="hide <?php echo $page2; ?>"><a href="#widgets" data-toggle="tab"><i class="fa fa-tasks" aria-hidden="true"></i>&nbsp; Widgets</a></li>
          <li class="<?php echo $page3; ?>"><a href="#add-new" data-toggle="tab"><i class="fa fa-plus-square-o" aria-hidden="true"></i>&nbsp; Add Custom Stylesheet</a></li>
        </ul>
        <div class="tab-content">
        
        <div class="tab-pane <?php echo $page1; ?>" id="general">
        <br />
        <?php if(isset($msg)) echo $msg; ?>


        <form method="POST" action="#" enctype="multipart/form-data"> 
        
        <div class="row">
        
        <div class="col-md-6">
        
        <div class="row">
            <div class="col-md-6">
            
            <div class="form-group">
                <label>Language Switcher</label> <br />
                <input <?php isSelected($to['general']['langSwitch'], true, 2); ?> type="checkbox" name="langSwitch" id="langSwitch" />
            </div>
            <br />
            <div class="form-group">
                <label>Sponsored Domain (1):</label> <br />
                <input type="text" value="<?php echo $to['general']['example1'][0]; ?>" class="form-control" name="to[general][example1][]" />
            </div> 
            <div class="form-group">
                <label>Sponsored Domain (2):</label> <br />
                <input type="text" value="<?php echo $to['general']['example2'][0]; ?>" class="form-control" name="to[general][example2][]" />
            </div> 
            <div class="form-group">
                <label>Sponsored Domain (3):</label> <br />
                <input type="text" value="<?php echo $to['general']['example3'][0]; ?>" class="form-control" name="to[general][example3][]" />
            </div> 
            
            </div>
            
            <div class="col-md-6">
            
            <div class="form-group">
                <label>Sidebar Position</label> <br />
                <input <?php isSelected($to['general']['sidebar'], true, 2, 'right'); ?> type="checkbox" name="sidebar" id="sidebar" />
            </div> 
            <br />
            <div class="form-group">
                <label>Domain Text:</label> <br />
                <textarea class="form-control inputTextArea" name="to[general][example1][]"><?php echo htmlspecialchars_decode($to['general']['example1'][1]); ?></textarea>
            </div>
            <div class="form-group">
                <label>Domain Text:</label> <br />
                <textarea class="form-control inputTextArea" name="to[general][example2][]"><?php echo htmlspecialchars_decode($to['general']['example2'][1]); ?></textarea>
            </div> 
            <div class="form-group">
                <label>Domain Text:</label> <br />
                <textarea class="form-control inputTextArea" name="to[general][example3][]"><?php echo htmlspecialchars_decode($to['general']['example3'][1]); ?></textarea>
            </div> 
            </div>
        </div>
        
        <div class="box-header with-border">
            <h3 class="box-title">Contact Information<small>(Footer)</small></h3>
        </div>
        <br />
        
        <div class="form-group">
            <label>Address:</label> <br />
            <textarea class="form-control" name="to[contact][address]"><?php echo $to['contact']['address']; ?></textarea>
        </div>
        
        <div class="form-group">
            <label>Phone Number:</label> <br />
            <input type="text" value="<?php echo $to['contact']['phone']; ?>" class="form-control" name="to[contact][phone]" />
        </div>
        
        <div class="form-group">
            <label>Email ID:</label> <br />
            <input type="text" value="<?php echo $to['contact']['email']; ?>" class="form-control" name="to[contact][email]" />
        </div>
        
        </div>
        
        <div class="col-md-6">

        <br />
        <label> Favicon </label> <br />
        <img class="favLogoBox" id="favLogoBox" src="<?php echo $baseURL.$to['general']['favicon']; ?>" />
        <br /> Upload a new favicon
        <input type="file" name="favUpload" id="favUpload" class="btn btn-default" />
        <br />
        <div class="form-group">
            <label> Logo Type </label>
            <select name="to[general][imgLogo]" id="imgLogo" class="form-control">
                <option <?php isSelected($to['general']['imgLogo'],true,'1'); ?> value="on">Image Logo</option>
                <option <?php isSelected($to['general']['imgLogo'],false,'1'); ?> value="off">Text / HTML Logo</option>
            </select>
        </div>
        
        <div class="hide" id="on">  
            <img class="userLogoBox" id="userLogoBox" src="<?php echo $baseURL.$to['general']['logo']; ?>" />
            <br /> Upload a new Logo
            <input type="file" name="logoUpload" id="logoUpload" class="btn btn-default" />
        </div>  
        <div class="hide" id="off">  
            <div class="form-group">
                <label>Logo Text</label>                                        
                <textarea class="form-control inputTextArea" name="to[general][htmlLogo]"><?php echo htmlspecialchars_decode($to['general']['htmlLogo']); ?></textarea>
            </div>
        </div>
        <br />
         <div class="box-header with-border">
            <h3 class="box-title">About Us<small>(Footer)</small></h3>
        </div>
        <br />
        
        <div class="form-group">
            <textarea class="form-control" rows="10" name="to[contact][about]"><?php echo $to['contact']['about']; ?></textarea>
        </div>
        
        </div>
        
        </div>
        <br /><br />
        <div class="text-center">
            <input type="hidden" value="1" name="page1" />
            <input type="submit" name="save" value="Save Settings" class="btn btn-primary"/>
        </div>
        <br /><br />
        </form>

        </div>
        
        <div class="tab-pane <?php echo $page2; ?>" id="widgets">
        <br />
        <?php if(isset($msg)) echo $msg; ?>


        </div>
            
        <div class="tab-pane <?php echo $page3; ?>" id="add-new">
        <br />
        <?php if(isset($msg)) echo $msg; ?>

        <form action="#" method="POST">
            <div class="form-group">
                <label>Enter custom stylesheet code:</label> <br />
                <textarea placeholder=".test{ width: 20px; }" class="form-control" rows="15" name="to[custom][css]"><?php echo htmlspecialchars_decode($to['custom']['css']); ?></textarea>
            </div>
 
        <br /><br />
        <div class="text-center">
            <input type="hidden" value="1" name="page3" />
            <input type="submit" name="save" value="Save Settings" class="btn btn-primary"/>
        </div>
        <br /><br />
        </form> 
                
        </div>
    </div>
  
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->
<?php
$footerAddArr[] = <<<EOD
    <script> 
       var oldSel;
       $(function () {
        var selVal = jQuery('select[id="imgLogo"]').val();
        oldSel = selVal;
        $('#'+selVal).removeClass("hide");
        $('#'+selVal).fadeIn();
       });
        
       $('select[id="imgLogo"]').on('change', function() {
            var selVal = jQuery('select[id="imgLogo"]').val();
            $('#'+oldSel).fadeOut();
            $('#'+selVal).removeClass("hide");
            $('#'+selVal).fadeIn();
            oldSel = selVal;
        });
        function readURL(input,box){
            if (input.files && input.files[0]) {
                var reader = new FileReader();
        
                reader.onload = function (e) {
                    $(box).attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }  
        $("#logoUpload").change(function(){
            readURL(this,'#userLogoBox');
        });
        $("#favUpload").change(function(){
            readURL(this,'#favLogoBox');
        });
        $('#langSwitch').checkboxpicker();
        $('#sidebar').checkboxpicker({onLabel:"Right",offLabel:"Left"});
    </script>
EOD;
?>