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
          
            <?php if(isset($msg)) echo $msg; ?>
                <div class="col-md-8">
					<div class="form-group">
			            <div class="checkbox">
				           <label class="checkbox inline">
					          <input <?php isSelected($other['other']['ddos'],true,'2') ?> type="checkbox" name="ddos"  /> Enable application level DDoS protection
                           </label>
			            </div>
	  	           </div>
                    <div class="form-group">
                        <label>Maximum number of request per second consider as attack: </label>
                        <input value="<?php echo intval($other['other']['ddosLimit']); ?>" required="" type="number" class="form-control" name="maxcount" />
                    </div>
                                      
                   <div class="callout callout-danger">
	                  <p> - It is not real DDoS protection. It can't helpful for medium or large level DDoS attacks. It only enable application level protection that helps to protect from application layer attackers. </p>
                      <p> - Never set minimum number as attack. Web pages generally makes multiple request for loading CSS / Images / JS etc... So valid request consider as attack on lower number.</p>
                   </div>
                                       
                    <input type="submit" value="Save" class="btn btn-primary" />
                    
                   <br /><br />
                   
                </div>
                 </div><!-- /.box-body -->
            </form>
        </div>
                            
         <div class="box box-danger">
            <div class="box-header with-border">
                <!-- tools box -->

                <h3 class="box-title">
                    Suspicious IP's <small>(Below IP address are banned by DDoS detection. It will be reset every day automatically)</small>
                </h3>
            </div>

             <div class="box-body">
                 <table id="seoToolTable" class="table table-bordered table-striped">
                     <thead>
                     <tr>
                         <th>Banned IP</th>
                         <th>Added Date</th>
                         <th>Delete</th>
                     </tr>
                     </thead>
                     <tbody>
                     <?php if($noBanned){
                         echo '<tr><td colspan="3" class="text-center">List Empty!</td></tr>';
                     }else{
                         foreach($ddosData as $bannedKey => $bannedData){
                             echo '<tr>
                            <td>'.$bannedData['ip'].'</td>
                            <td>'.$bannedData['date'].'</td>
                            <td><a class="btn btn-danger btn-xs" onclick="return confirm(\'Are you sure you want to delete this item?\');" title="Delete" href='.adminLink($controller.'/delete/'.$bannedData['id'],true).'> <i class="fa fa-trash-o"></i> &nbsp; Delete </a></td>
                          </tr>';
                         }
                     }
                     ?>

                     </tbody>
                 </table>
             </div><!-- /.box-body -->
            </div>
      
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