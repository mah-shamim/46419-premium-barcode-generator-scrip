<?php
defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: PDF Studio
 * @copyright � 202KOVATZra
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

          
    <?php if(isset($msg)) echo $msg; ?><br />
    
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info customBox">
                <div class="box-header">
                    <!-- tools box -->
                    <div class="pull-right box-tools">
                        <button title="" data-toggle="tooltip" data-widget="collapse" class="btn btn-info btn-xs" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
                        <button title="" data-toggle="tooltip" data-widget="remove" class="btn btn-info btn-xs" data-original-title="Remove"><i class="fa fa-times"></i></button>
                    </div><!-- /. tools -->
                   <i class="fa fa-line-chart"></i>
                    <h3 class="box-title"> Hourly Traffic </h3>
                </div><!-- /.box-header -->
    
                <div class="box-body">
                    <div class="chart tab-pane active" id="pageviews-chart" style="position: relative; height: 300px;"></div>
                </div><!-- /.box-body -->
      
            </div>
        </div>
      </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info customBox">
                <div class="box-header">
                    <!-- tools box -->
                    <div class="pull-right box-tools">
                        <button title="" data-toggle="tooltip" data-widget="collapse" class="btn btn-info btn-xs" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
                        <button title="" data-toggle="tooltip" data-widget="remove" class="btn btn-info btn-xs" data-original-title="Remove"><i class="fa fa-times"></i></button>
                    </div><!-- /. tools -->
                   <i class="fa fa-file-o"></i>
                    <h3 class="box-title"> Pages </h3>
                </div><!-- /.box-header -->
    
                <div class="box-body">
                 <table id="platform" class="table table-striped table-bordered">
                    <thead>
                        <th>Link</th>
                        <th>Pageviews</th>
                        <th>Percentage</th>
                    </thead>
                    <tbody> 
                        <?php echo $table4; ?>                        
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
      
            </div>
        </div>
      </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="box box-info customBox">
                <div class="box-header">
                    <!-- tools box -->
                    <div class="pull-right box-tools">
                        <button title="" data-toggle="tooltip" data-widget="collapse" class="btn btn-info btn-xs" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
                        <button title="" data-toggle="tooltip" data-widget="remove" class="btn btn-info btn-xs" data-original-title="Remove"><i class="fa fa-times"></i></button>
                    </div><!-- /. tools -->
                   <i class="fa fa-globe"></i>
                    <h3 class="box-title"> Countries </h3>
                </div><!-- /.box-header -->
    
                <div class="box-body">
                 <table id="countries" class="table table-striped table-bordered">
                    <thead>
                        <th>Country</th>
                        <th>Sessions</th>
                        <th>Percentage</th>
                    </thead>
                    <tbody> 
                        <?php echo $table1; ?>                        
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
      
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-info customBox">
                <div class="box-header">
                    <!-- tools box -->
                    <div class="pull-right box-tools">
                        <button title="" data-toggle="tooltip" data-widget="collapse" class="btn btn-info btn-xs" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
                        <button title="" data-toggle="tooltip" data-widget="remove" class="btn btn-info btn-xs" data-original-title="Remove"><i class="fa fa-times"></i></button>
                    </div><!-- /. tools -->
                   <i class="fa fa-list-alt"></i>
                    <h3 class="box-title">  Browsers </h3>
                </div><!-- /.box-header -->
    
                <div class="box-body">
                 <table id="browsers" class="table table-striped table-bordered">
                    <thead>
                        <th>Browser</th>
                        <th>Sessions</th>
                        <th>Percentage</th>
                    </thead>
                    <tbody> 
                        <?php echo $table2; ?>                        
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
      
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="box box-info customBox">
                <div class="box-header">
                    <!-- tools box -->
                    <div class="pull-right box-tools">
                        <button title="" data-toggle="tooltip" data-widget="collapse" class="btn btn-info btn-xs" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
                        <button title="" data-toggle="tooltip" data-widget="remove" class="btn btn-info btn-xs" data-original-title="Remove"><i class="fa fa-times"></i></button>
                    </div><!-- /. tools -->
                   <i class="fa fa-desktop"></i>
                    <h3 class="box-title"> Operating Systems </h3>
                </div><!-- /.box-header -->
    
                <div class="box-body">
                 <table id="platform" class="table table-striped table-bordered">
                    <thead>
                        <th>Platform</th>
                        <th>Sessions</th>
                        <th>Percentage</th>
                    </thead>
                    <tbody> 
                        <?php echo $table3; ?>                        
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
      
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-info customBox">
                <div class="box-header">
                    <!-- tools box -->
                    <div class="pull-right box-tools">
                        <button title="" data-toggle="tooltip" data-widget="collapse" class="btn btn-info btn-xs" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
                        <button title="" data-toggle="tooltip" data-widget="remove" class="btn btn-info btn-xs" data-original-title="Remove"><i class="fa fa-times"></i></button>
                    </div><!-- /. tools -->
                   <i class="fa fa-list-alt"></i>
                    <h3 class="box-title">  Referer </h3>
                </div><!-- /.box-header -->
    
                <div class="box-body">
                 <table id="referer" class="table table-striped table-bordered">
                    <thead>
                        <th>Referral</th>
                        <th>Sessions</th>
                        <th>Percentage</th>
                    </thead>
                    <tbody> 
                        <?php echo $table5; ?>                        
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
      
            </div>
        </div>
    </div>
  
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->
<?php 

$footerAddArr[] = <<<EOD
<script type="text/javascript">
    $(function () {
        $('#countries').DataTable({
          "paging": true, "pagingType":"full", "lengthChange": false, "searching": false,
          "ordering": false, "info": true, "autoWidth": false, "pageLength": 6
        });
        $('#browsers').DataTable({
          "paging": true, "pagingType":"full", "lengthChange": false, "searching": false,
          "ordering": false, "info": true, "autoWidth": false, "pageLength": 6
        });
        $('#platform').DataTable({
          "paging": true, "pagingType":"full", "lengthChange": false, "searching": false,
          "ordering": false, "info": true, "autoWidth": false, "pageLength": 6
        });
        $('#referer').DataTable({
          "paging": true, "pagingType":"full", "lengthChange": false, "searching": false,
          "ordering": false, "info": true, "autoWidth": false, "pageLength": 6
        });
    });
</script>    
EOD;

$chartData = "
    data: [
      {y: '12AM - 2AM', item1: ".$valRes[0][0]['unique'].", item2: ".$valRes[0][0]['views']."},
      {y: '2AM - 4AM', item1: ".$valRes[0][2]['unique'].", item2: ".$valRes[0][2]['views']."},
      {y: '4AM - 6AM', item1: ".$valRes[0][4]['unique'].", item2: ".$valRes[0][4]['views']."},
      {y: '6AM - 8AM', item1: ".$valRes[0][6]['unique'].", item2: ".$valRes[0][6]['views']."},
      {y: '8AM - 10AM', item1: ".$valRes[0][8]['unique'].", item2: ".$valRes[0][8]['views']."},
      {y: '10AM - 12PM', item1: ".$valRes[0][10]['unique'].", item2: ".$valRes[0][10]['views']."},
      {y: '12PM - 2PM', item1: ".$valRes[0][12]['unique'].", item2: ".$valRes[0][12]['views']."},
      {y: '2PM - 4PM', item1: ".$valRes[0][14]['unique'].", item2: ".$valRes[0][14]['views']."},
      {y: '4PM - 6PM', item1: ".$valRes[0][16]['unique'].", item2: ".$valRes[0][16]['views']."},
      {y: '6PM - 8PM', item1: ".$valRes[0][18]['unique'].", item2: ".$valRes[0][18]['views']."},
      {y: '8PM - 10PM', item1: ".$valRes[0][20]['unique'].", item2: ".$valRes[0][20]['views']."},
      {y: '10PM - 12AM', item1: ".$valRes[0][22]['unique'].", item2: ".$valRes[0][22]['views']."}
    ],";

$footerAddArr[] = <<<EOD
  <script>
   /* Morris.js Charts */
  // Sales chart
  var CountX = -1;
  var area = new Morris.Area({
    element: 'pageviews-chart',
    resize: true,
    $chartData
    xkey: 'y',
    ykeys: ['item1', 'item2'],
    labels: ['Unique Visitors', 'Page Views'],
    lineColors: ['#85CBD6', '#59b9c7'],
    hideHover: 'auto',
    parseTime: false,
    xLabelMargin: 10,
    padding: 40,
    xLabelAngle: 30,
    xLabelFormat: function(d) {
    CountX = CountX+1;
    return ['12AM - 2AM','2AM - 4AM','4AM - 6AM','6AM - 8AM','8AM - 10AM','10AM - 12PM','12PM - 2PM','2PM - 4PM','4PM - 6PM','6PM - 8PM','8PM - 10PM','10PM - 12AM'][CountX];
    }
  });
 </script> 
EOD;
?>