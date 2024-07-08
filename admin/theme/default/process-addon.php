<?php
defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: PDF Studio
 * @copyright © 2024 KOVATZ
 *
 */
?>

if(!isset($addonRes))
    die("Not Allowed");
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
            <li><a href="<?php adminLink(); ?>"><i class="fa fa-cogs"></i> Admin</a></li>
            <li class="active"><?php echo $pageTitle; ?> </li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Install Addons</h3>
                </div><!-- /.box-header -->

                <div class="box-body">
                
                <?php if(isset($msg)) echo $msg;?>
                
                <br /> 
                <p>Addon Installation Log File:</p>
                <textarea readonly="" id="tableRes" rows="12" class="form-control"><?php echo $addonRes; ?></textarea>
                <br /> 
                <?php if(isset($addonError)){ 
                if($errType == '2') { ?>
                <p style="color: #d35400;">Addon Installation Completed with Error! </p>
                <?php } elseif($errType == '1'){  ?>
                <p style="color: #c0392b;">Addon Installation Failed! </p>
                <?php } } else{ ?>
                <p style="color: #27ae60;">Addon Installation Completed! </p>
                <?php } ?>
                <br />
                <?php if($customLink){ ?>
                <p>Goto:</p>
                <?php foreach($customLinks as $links){
                echo $links. '  ';
                } } ?>
                <br />  


                </div><!-- /.box-body -->
      
              </div><!-- /.box -->
      
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->