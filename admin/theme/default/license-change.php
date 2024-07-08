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

          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $subTitle; ?></h3>
            </div><!-- /.box-header ba-la-ji -->
            <form action="#" method="POST">
            <div class="box-body">
          
            <?php if(isset($msg)) echo $msg; ?><br />
            
            <div class="form-group">
            	<label>Item Purchase Code: <small>(License Key)</small></label>
            	<input value="<?php echo $licArr['code']; ?>" disabled="" type="text" name="domain" class="form-control" />
            </div>      

            <div class="form-group">
            	<label>Registered Domain Name:</label>
            	<input value="<?php echo $licArr['domain']; ?>" disabled="" type="text" name="domain" class="form-control" />
            </div>
            
            <div class="form-group">
            	<label>Registered Link:</label>
            	<input value="<?php echo $licArr['path']; ?>" disabled="" type="text" name="domain" class="form-control" />
            </div>
            
            <a target="_blank" href="http://api.KOVATZ.COM/tweb/reset.php?code=<?php echo $item_purchase_code; ?>" class="btn btn-danger">Reset Domain Name</a>            
            
            <br />
            
            </div><!-- /.box-body -->
            </form>
          </div><!-- /.box -->
  
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->