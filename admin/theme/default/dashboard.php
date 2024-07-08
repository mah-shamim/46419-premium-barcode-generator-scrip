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

            <div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3><?php echo $onlineNow; ?></h3>
                  <p>Users Online</p>
                </div>
                <div class="icon">
                  <i class="fa fa-smile-o"></i>
                </div>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3><?php echo $today_page; ?><sup style="font-size: 20px"></sup></h3>
                  <p>Today Pageviews</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3><?php echo $today_users_count; ?></h3>
                  <p>Today New Users</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h3><?php echo $today_visit; ?></h3>
                  <p>Today Unique Visitors</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
              </div>
            </div><!-- ./col -->
          </div><!-- /.row -->
          
          <!-- Main row -->
          <div class="row">
          <!-- Left col -->
          <section class="col-lg-7 connectedSortable">
          
          
            <!-- Custom tabs (Charts with tabs)-->
              <div class="nav-tabs-custom">
                <!-- Tabs within a box -->
                <ul class="nav nav-tabs pull-right">
                  <li class="pull-left header"><i class="fa fa-signal"></i>  Pageviews History</li>
                </ul>
                <div class="tab-content no-padding">
                 <?php
                 if(count($pageViewHistory) < 2){
                    echo '<div class="text-center"><br><br><br><br><br><br>Not enough Data<br><br><br><br><br><br><br><br></div>';
                    }else{
                 ?>
                  <div class="chart tab-pane active" id="pageviews-chart" style="position: relative; height: 300px;"></div>
                <?php } ?>
                </div>
              </div><!-- /.nav-tabs-custom -->

             <div class="box box-primary customBox">
                        <div class="box-header">
                            <!-- tools box -->
                            <div class="pull-right box-tools">
                                <button title="" data-toggle="tooltip" data-widget="collapse" class="btn btn-primary btn-xs" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
                                <button title="" data-toggle="tooltip" data-widget="remove" class="btn btn-primary btn-xs" data-original-title="Remove"><i class="fa fa-times"></i></button>
                            </div><!-- /. tools -->
                           <i class="fa fa-line-chart"></i>

                            <h3 class="box-title">Recent History</h3>
                        </div><!-- /.box-header -->

                       
                        <div class="box-body">
                            <table class="table table-hover table-bordered">
                                <tbody><tr>
                                    <th>Domain Name</th>
                                    <th>Username</th>
                                    <th>User Location</th>
                                    <th>Time</th>
                                </tr>
                                <?php echo $userHistoryData; ?>
                                </tbody>
                            </table>
                        </div><!-- /.box-body -->
               
         
                        <div class="box-footer">
                 
                        </div><!-- /.box-footer -->
                    </div>
            <div class="box box-success customBox">
                <div class="box-header">
                    <!-- tools box -->
                    <div class="pull-right box-tools">
                        <button title="" data-toggle="tooltip" data-widget="collapse" class="btn btn-success btn-xs" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
                        <button title="" data-toggle="tooltip" data-widget="remove" class="btn btn-success btn-xs" data-original-title="Remove"><i class="fa fa-times"></i></button>
                    </div><!-- /. tools -->
                   <i class="fa fa-th-list"></i>

                    <h3 class="box-title">Admin Login History</h3>
                </div><!-- /.box-header -->

               
                <div class="box-body">
                    <table class="table table-hover table-bordered">
                        <tbody><tr>
                            <th>Login Date</th>
                            <th>IP</th>
                            <th>Country</th>
                            <th>Browser</th>
                        </tr>
                        <?php echo $adminHistoryData; ?>
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
       
 
                <div class="box-footer">
         
                </div><!-- /.box-footer -->
            </div>
                            
          
          </section><!-- /.Left col -->
          
      <section class="col-lg-5 connectedSortable">

             <div id="server-box" class="box box-info customBox">
            <div class="box-header">
                <!-- tools box -->
                <div class="pull-right box-tools">
                    <button title="" data-toggle="tooltip" data-widget="collapse" class="btn btn-info btn-xs" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
                    <button title="" data-toggle="tooltip" data-widget="remove" class="btn btn-info btn-xs" data-original-title="Remove"><i class="fa fa-times"></i></button>
                </div><!-- /. tools -->
               <i class="fa fa-server"></i>

        <h3 class="box-title">Server Information</h3>
            </div><!-- /.box-header -->

           
            <div class="box-body">
             <table class="table table-striped table-bordered">
  
                <tbody> 
                
                  <tr>
                  <td>Server IP</td>
                  <td><strong><?php echo $_SERVER['SERVER_ADDR']; ?></strong></td>
                  </tr>
                  
                  <tr>
                  <td>Server Disk Space</td>
                  <td><strong><?php echo roundsize($ds); ?></strong></td>
                  </tr> 
                  
                  <tr>
                  <td>Free Disk Space</td>
                  <td><strong><?php echo roundsize($df); ?></strong></td>
                  </tr>               
                  
                  <tr>
                  <td>Disk Space used by Script</td>
                  <td><strong><?php echo roundsize(GetDirectorySize(ROOT_DIR)); ?></strong></td>
                  </tr>
                  
                  <tr>
                  <td>Memory Used</td>
                  <td><strong><?php echo getServerMemoryUsage(); ?></strong></td>
                  </tr>               
                  
                  <tr>
                  <td>Current CPU Load</td>
                  <td><strong><?php echo getServerCpuUsage(); ?></strong></td>
                  </tr>               
                  
                  <tr>
                  <td>PHP Version</td>
                  <td><strong><?php echo phpversion(); ?></strong></td>
                  </tr>
                  
                  <tr>
                  <td>MySql Version</td>
                  <td><strong><?php echo mysqli_get_server_info($con); ?></strong></td>
                  </tr>
                  
                  <tr>
                  <td>Database Size</td>
                  <td><strong><?php echo $database_size; ?> MB</strong></td>
                  </tr>
                  
                </tbody>
              </table>
            </div><!-- /.box-body -->
   

            <div class="box-footer">
     
            </div><!-- /.box-footer -->
        </div>
        
        <div class="box box-danger customBox">
            <div class="box-header">
                <!-- tools box -->
                <div class="pull-right box-tools">
                    <button title="" data-toggle="tooltip" data-widget="collapse" class="btn btn-danger btn-xs" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
                    <button title="" data-toggle="tooltip" data-widget="remove" class="btn btn-danger btn-xs" data-original-title="Remove"><i class="fa fa-times"></i></button>
                </div><!-- /. tools -->
               <i class="fa fa-user"></i>

                <h3 class="box-title">Latest New Users</h3>
            </div><!-- /.box-header -->

           
            <div class="box-body">
                <table class="table table-hover table-bordered">
                    <tbody><tr>
                        <th>Username</th>
                        <th>Registered On</th>
                        <th>Country</th>
                    </tr>
                    <?php echo $newUsersData; ?>
                    </tbody>
                </table>
            </div><!-- /.box-body -->
   

            <div class="box-footer">
     
            </div><!-- /.box-footer -->
        </div>
        
        
        <div class="box box-warning customBox">
            <div class="box-header">
                <!-- tools box -->
                <div class="pull-right box-tools">
                    <button title="" data-toggle="tooltip" data-widget="collapse" class="btn btn-warning btn-xs" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
                    <button title="" data-toggle="tooltip" data-widget="remove" class="btn btn-warning btn-xs" data-original-title="Remove"><i class="fa fa-times"></i></button>
                </div><!-- /. tools -->
               <i class="fa fa-paper-plane"></i>

                <h3 class="box-title">More Information
            </div><!-- /.box-header -->

           
            <div class="box-body">
                <br />
                <table class="table table-hover table-bordered">
                    <tbody>
                    <tr>
                        <td>Your Version</td>
                        <td>v<?php echo VER_NO; ?></td>
                    </tr>
                    
                    <tr>
                        <td>Latest Version</td>
                        <td>v<?php echo $latestData['version']; ?></td>
                    </tr>
                    <tr>
                        <td>Update</td>
                        <?php 
                        if($updater)
                            echo '<td><a href="http://codecanyon.net/downloads" target="_blank" class="btn btn-success">Update</a></td>'; 
                        else
                            echo '<td style="color: #c0392b;">Currently no update available!</td>';
                        ?>                                           
                    </tr>
                    
                </tbody></table>
                <br />
                
                <table class="table table-hover table-bordered">
                    <tbody>
                    <tr><th class="text-center">Latest News</th></tr>
                    
                    <tr>
                        <td>- <?php echo $latestData['news1']; ?></td>
                    </tr>
                    <tr>
                        <td>- <?php echo $latestData['news2']; ?></td>
                    </tr>
                    
                </tbody></table>
            </div><!-- /.box-body -->
   

            <div class="box-footer">
     
            </div><!-- /.box-footer -->
        </div>

                            
      </section>
      
      </div><!-- /.Main row -->
  
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->
<?php
$footerAddArr[] = <<<EOD
  <script>
  var CountX = -1;
  var area = new Morris.Area({
    element: 'pageviews-chart',
    resize: true,
    data: [
        $pageViewData
    ],
    xkey: 'y',
    ykeys: ['item1', 'item2'],
    labels: ['Unique Visitorss', 'Page View'],
    lineColors: ['#85CBD6', '#59b9c7'],
    hideHover: 'auto',
    parseTime: false,

  });
 </script> 
EOD;
?>