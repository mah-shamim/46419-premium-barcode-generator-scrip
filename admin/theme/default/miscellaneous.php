
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

              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo $subTitle; ?></h3>
                </div><!-- /.box-header -->
                
                <form action="#" method="POST">
                <div class="box-body">
                 <?php if(isset($msg)) echo $msg;?>
                <br />
                <div class="alert alert-warning">
                <strong>Warning!</strong> All actions are irreversible! 
                </div>
                <div class="text-center">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="form-group">
                            <label>Select your action</label>
                            <select name="action" class="form-control">
                                <option value="temp">Clean up all temporary directories</option>
                                <option value="screen">Clean up all cached screenshots</option>
                                <option value="mobile">Clean up all cached mobile preview screenshots</option>
                                <option value="recent">Clear all recent history data</option>
                                <option value="analytics">Clear all analytics data</option>
                                <option value="admin">Clear all admin login history data</option>
                                <option value="unverified">Clear all unverified users accounts</option>
                                <option value="users">Clear all users accounts</option>
                                <option value="incomplete">Clear all incomplete (non-cached) domain names</option>
                                <option value="domain">Clear all cached domains</option>
                            </select>
                            </div>
                           <button class="btn btn-danger" onclick="return confirm('Are you sure you want to process?');">Process</button>
                        </div>
                    </div>
                    
                </div>
                <br /> <br />
                </div><!-- /.box-body -->
                </form>
              </div><!-- /.box -->
      
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
