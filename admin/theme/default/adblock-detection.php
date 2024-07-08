<?php
defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: KOVATZ Seo Tools
 * @copyright � 2022 KOVATZ.COM
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
          
            <?php if(isset($msg)) echo $msg; ?>
            <div class="col-md-8">
			<div class="form-group">
	            <div class="checkbox">
		           <label class="checkbox inline">
			          <input <?php isSelected($adblock['enable'],true,'2') ?> type="checkbox" name="adblock[enable]"  /> Enable ad-blocker detection and protection system
                   </label>
	            </div>
            </div>
            <div class="form-group">
				<label>Adblock notification type</label>
				<select class="form-control" name="adblock[options]" id="opt">
					<option <?php echo isSelected($adblock['options'], true, 1, 'link'); ?> value="link">Redirect to custom adblock notification page</option>
                    <option <?php echo isSelected($adblock['options'], true, 1, 'close'); ?> value="close">Dialog box with close button (User can continue to access website)</option>
                    <option <?php echo isSelected($adblock['options'], true, 1, 'force'); ?> value="force">Dialog box without close button (User can't continue to access website)</option>	
                </select>
			</div>
            
            <div class="form-group hide" id="opt-link">
                <label>Redirect Link</label>
                <input name="adblock[link]" type="text" placeholder="Type link" value="<?php echo $adblock['link']; ?>" class="form-control" /> 
            </div>
            
            <div class="hide" id="opt-close">
            <div class="form-group">
                <label>Dialog Box - Title</label>
                <input name="adblock[close][title]" type="text" placeholder="Type title" value="<?php echo $adblock['close']['title']; ?>" class="form-control" /> 
            </div>
            
            <div class="form-group">
                <label>Dialog Box - Message</label>
                <textarea rows="6" name="adblock[close][msg]" placeholder="Type description" class="form-control"><?php echo htmlspecialchars_decode($adblock['close']['msg']); ?></textarea>
            </div>
            </div>
            
            <div class="hide" id="opt-force">
            <div class="form-group">
                <label>Dialog Box - Title</label>
                <input name="adblock[force][title]" type="text" placeholder="Type title" value="<?php echo $adblock['force']['title']; ?>" class="form-control" /> 
            </div>
            
            <div class="form-group">
                <label>Dialog Box - Message</label>
                <textarea rows="6" name="adblock[force][msg]" placeholder="Type description" class="form-control"><?php echo htmlspecialchars_decode($adblock['force']['msg']); ?></textarea>
            </div>
            </div>
            
            <input type="submit" value="Save" class="btn btn-primary" />
            
           <br /><br />
               
            </div>
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
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '100%'
        });
        var selVal = jQuery('select[id="opt"]').val();
        oldSel = selVal;
        $('#opt-'+selVal).removeClass("hide");
        $('#opt-'+selVal).fadeIn();
      });      
      $('select[id="opt"]').on('change', function() {
            var selVal = jQuery('select[id="opt"]').val();
            $('#opt-'+oldSel).fadeOut();
            $('#opt-'+selVal).removeClass("hide");
            $('#opt-'+selVal).fadeIn();
            oldSel = selVal;
      });
        
  </script>  
EOD;
?>  