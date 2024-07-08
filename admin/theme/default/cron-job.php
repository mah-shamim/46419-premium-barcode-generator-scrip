<?php
defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: PDF Studio
 * @copyright � 202KOVATZra
 *
 */
?>
<style>
.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
    background-color: #fdfdfd;
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
                <div style="position:absolute; top:4px; right:15px;">
                  <a class="btn btn-primary btn-sm" href="<?php adminLink($controller.'/clear'); ?>"><i class="fa fa-trash"></i> &nbsp; Clear Cron Log</a>
                </div>
            </div><!-- /.box-header ba-la-ji -->
            <form action="#" method="POST">
            <div class="box-body">
            <br />
                <div class="alert alert-warning">
                    <strong>Note: </strong> Intervals between cron jobs is 10 to 30 miniutes(Maxmium). Don't setup Cron Job more than 30 minutes!
                </div>
                    
            <?php if(isset($msg)) echo $msg; ?>
            <div class="form-group">
                <label for="cronPath">Cron Job Path:</label>
                <input readonly="" id="cronPath" name="cronPath" value="<?php echo $cronPath; ?>" class="form-control" type="text" />
            </div>
            
            <label>Cron Execution Log:</label>
            <textarea readonly="" class="form-control" rows="10"><?php echo $errData; ?></textarea>
            <br />
            <br />
            </div><!-- /.box-body -->
            </form>
          </div><!-- /.box -->
  
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->