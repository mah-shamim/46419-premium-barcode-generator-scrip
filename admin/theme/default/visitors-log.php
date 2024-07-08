<?php
defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: KOVATZ Seo Tools
 * @copyright � 2022 KOVATZ.COM
 *
 */
?>
<style>
table {
    table-layout: fixed; width: 100%;
}
td {
  word-wrap: break-word;
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
    <section class="content" id="contentBox">

          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $subTitle; ?></h3>
              <div style="position:absolute; top:4px; right:15px;">
                <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                    <span></span> <b class="caret"></b>
                </div>
              </div>
            </div><!-- /.box-header ba-la-ji -->
            <div class="box-body">
            <?php if(isset($msg)) echo $msg; ?><br />
            
            <div id="loadingBar" class="text-center hide">
                <div>Processing...</div>
                <img src="<?php echo $loadingBar; ?>" />
            </div>
            
              <table id="visitorsTable" class="table table-bordered table-hover visitorsTable">
                <thead>
                  <tr>
                    <th>Visitor Details</th>
                    <th>OS/Browser Details</th>
                    <th>Pages Viewed</th>
                  </tr>
                </thead>
                <tbody id="visitorsTableBody">
                    <?php echo $rainbowTrackAsif; ?>
                </tbody>
              </table> 
            
            <br />
            
            </div><!-- /.box-body -->
          </div><!-- /.box -->
  
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->
<?php 
$trackLink = adminLink('ajax/visitors-range',true);
$footerAddArr[] = <<<EOD
<script type="text/javascript">
var visitTab;
$(function() {
    
    var firstTime = 2;
    var start = moment();
    var end = moment();

    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        if(firstTime != 2){
            $('#loadingBar').removeClass("hide");
            jQuery.get("$trackLink"+"/"+start.format('YYYY-MM-DD')+"/"+end.format('YYYY-MM-DD'),function(data){
                visitTab.destroy();
                $("#visitorsTableBody").html(data);
                visitTab = $('#visitorsTable').DataTable({
                  "paging": true,
                  "lengthChange": false,
                  "searching": false,
                  "ordering": false,
                  "info": true,
                  "autoWidth": false
                });
                $('#loadingBar').addClass("hide");
            });
        }
        firstTime = 3;
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);
    
});

$(function () {
    visitTab = $('#visitorsTable').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": false,
      "info": true,
      "autoWidth": false
    });
});

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});
jQuery(document).ready(function(){
    $(document).on("click",".paginate_button", function(){
        setTimeout(function(){
        var pos = $('#contentBox').offset();
        $('body,html').animate({ scrollTop: pos.top });
        }, 1);
    });
});
</script>
EOD;
?>