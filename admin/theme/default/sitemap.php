<?php
defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: Rainbow PHP Framework
 * @copyright © 2022 KOVATZ.COM
 *
 */
?>
<style>
hr {
    margin: 0 !important;
}
</style>
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
            
                <div class="box-body">
                 <?php
                if(isset($msg))
                    echo $msg;
                ?>
                <br />
                <table class="table table-hover table-bordered">
                <tbody>
                <tr>
                    <td style="width: 300px;">Sitemap URL <br /><small>(Use the link to submit sitemap into search engines)</small></td>
                    <td><?php echo $baseURL.'sitemap.xml'; ?></td>
                </tr>
                <tr>
                    <td style="width: 300px;">Sitemap File</td>
                    <?php if($sitemapData)
                    echo "<td style='color: green; font-weight: bold;'> $siteMapRes <br>
                    <a target='_blank' href='".$baseURL."sitemap.xml' class='btn btn-success btn-sm' title='View Sitemap'><i class='fa fa-link' aria-hidden='true'></i> View Sitemap File</a>
                    </td>";
                    else
                    echo "<td style='color: red; font-weight: bold;'> $siteMapRes </td>";
                    ?>
                </tr> 
                <tr>
                    <td>Build your sitemap</td>
                    <?php if($sitemapData){ ?>
                    <td><a href="<?php adminLink('sitemap/build'); ?>" class="btn btn-primary btn-sm" title="Build Sitemap"><i class="fa fa-sitemap" aria-hidden="true"></i> Rebuild Sitemap</a></td>
                    <?php } else { ?>
                    <td><a href="<?php adminLink('sitemap/build'); ?>" class="btn btn-primary btn-sm" title="Build Sitemap"><i class="fa fa-sitemap" aria-hidden="true"></i> Build Sitemap</a></td>
                    <?php } ?>
                </tr>
                </tbody></table>
                 <br /><br />
                 <div class="box-header">
                    <h4 class="box-title">Sitemap Options</h4>  
                 </div><!-- /.box-header -->            
                 <hr />
                 
                <form method="POST" action="#">
                <div class="box-body">
                <div class="row"> <div class="col-md-6">
                
    			<div class="form-group">
    	            <div class="checkbox">
    		           <label class="checkbox inline">
    			          <input <?php isSelected($other['other']['sitemap']['gzip'],true,'2') ?> type="checkbox" name="other[other][sitemap][gzip]"  /> Compress sitemap files using Gzip
                       </label>
    	            </div>
                </div>
                
    			<div class="form-group">
    	            <div class="checkbox">
    		           <label class="checkbox inline">
    			          <input <?php isSelected($other['other']['sitemap']['cron'],true,'2') ?> type="checkbox" name="other[other][sitemap][cron]" id="cron"  /> Automatically rebuild sitemap using Cron Job
                       </label>
    	            </div>
                </div>
                
                
                <div class="hide" id="optcron">
                <div class="form-group">
    				<select class="form-control" name="other[other][sitemap][cronopt]">
    					<option <?php echo isSelected($other['other']['sitemap']['cronopt'], true, 1, 'daily'); ?> value="daily">Rebuild Daily</option>
                        <option <?php echo isSelected($other['other']['sitemap']['cronopt'], true, 1, 'weekly'); ?> value="weekly">Rebuild Weekly</option>
                        <option <?php echo isSelected($other['other']['sitemap']['cronopt'], true, 1, 'monthly'); ?> value="monthly">Rebuild Monthly</option>	
                    </select>
    			</div>
                </div>
                
    			<div class="form-group">
    	            <div class="checkbox">
    		           <label class="checkbox inline">
    			          <input <?php isSelected($other['other']['sitemap']['multilingual'],true,'2') ?> type="checkbox" name="other[other][sitemap][multilingual]"  /> Enable multilingual link indexing
                       </label>
    	            </div>
                </div>
                
            	<div class="form-group">
    	            <div class="checkbox">
    		           <label class="checkbox inline">
    			          <input <?php isSelected($other['other']['sitemap']['auto'],true,'2') ?> type="checkbox" name="other[other][sitemap][auto]" id="auto"  /> Auto calculate priority level and change frequency
                       </label>
    	            </div>
                </div>
                
                <div class="form-group">
                    <label>Default Change Frequency</label>
    				<select id="freqrange" class="form-control" name="other[other][sitemap][freqrange]">
    					<option <?php echo isSelected($other['other']['sitemap']['freqrange'], true, 1, 'always'); ?> value="always">Always</option>
					    <option <?php echo isSelected($other['other']['sitemap']['freqrange'], true, 1, 'hourly'); ?> value="hourly">Hourly</option>
    					<option <?php echo isSelected($other['other']['sitemap']['freqrange'], true, 1, 'daily'); ?> value="daily">Daily</option>
                        <option <?php echo isSelected($other['other']['sitemap']['freqrange'], true, 1, 'weekly'); ?> value="weekly">Weekly</option>
                        <option <?php echo isSelected($other['other']['sitemap']['freqrange'], true, 1, 'monthly'); ?> value="monthly">Monthly</option>	
                        <option <?php echo isSelected($other['other']['sitemap']['freqrange'], true, 1, 'yearly'); ?> value="yearly">Yearly</option>	
                        <option <?php echo isSelected($other['other']['sitemap']['freqrange'], true, 1, 'never'); ?> value="never">Never</option>	
                    </select>
                </div>
                <div class="form-group">
                    <label>Default Priority Level</label>
                    <input id="priority" type="number" placeholder="Enter priority level" name="other[other][sitemap][priority]" value="<?php echo $other['other']['sitemap']['priority']; ?>" class="form-control" />
                </div>
                <br />
                <div style="text-algin: right;">
                    <button class="btn btn-primary" type="submit">Save Settings</button>
                </div>
                             <br />
                </div> </div>
                      
                </div><!-- /.box-body -->
                </form>                              
                </div><!-- /.box-body -->
      
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
        
        if($('#cron').prop('checked') == true) {
           $('#optcron').removeClass("hide");
           $('#optcron').fadeIn();
        } else {
            $('#optcron').fadeOut();
        }
        
        if($('#auto').prop('checked') == true) {
            $('#freqrange').attr('disabled', 'disabled');
            $('#priority').attr('disabled', 'disabled');
        } else {
            $('#freqrange').removeAttr('disabled');
            $('#priority').removeAttr('disabled');
        }
        
       $('#cron').on('ifChecked', function(){
            $('#optcron').removeClass("hide");
            $('#optcron').fadeIn();
       });
       $('#auto').on('ifChecked', function(){
            $('#freqrange').attr('disabled', 'disabled');
            $('#priority').attr('disabled', 'disabled');
       });
       
       $('#cron').on('ifUnchecked', function(){
            $('#optcron').fadeOut();
       });
       $('#auto').on('ifUnchecked', function(){
            $('#freqrange').removeAttr('disabled');
            $('#priority').removeAttr('disabled');
       });
       
       });   
             
  </script>  
EOD;
?>  