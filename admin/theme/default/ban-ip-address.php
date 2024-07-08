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
            </div><!-- /.box-header ba-la-ji -->
            <form action="#" method="POST">
            <div class="box-body">
          
            <?php if(isset($msg)) echo $msg; ?><br />
                <div class="form-group">
                    <div class="form-group">
                        <label for="ban_ip">IP Address to Ban:</label>
                        <input required="" type="ip" class="form-control" id="ban_ip" name="ban_ip" placeholder="Enter user ip to ban" />
                    </div>
                    <div class="form-group">
                        <label for="reason">Reason: <small>(Optional)</small></label>
                        <textarea class="form-control" id="reason" name="reason" placeholder="Reason to ban?"></textarea>
                    </div>
                    <p> Note: Banned IP's can't able to access your site!</p>
                </div><button type="submit" class="btn btn-primary">Add</button>
                 </div><!-- /.box-body -->
            </form>
        </div>
                            
         <div class="box box-danger">
            <div class="box-header with-border">
                <!-- tools box -->

                <h3 class="box-title">
                    Recently banned IP's
                </h3>
            </div>

            <div class="box-body">
                  <table id="seoToolTable" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Banned IP</th>
                        <th>Banned Reason</th>
                        <th>Added Date</th>
                        <th>Delete</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php if(count($bannedList) == 0){
                        echo '<tr><td colspan="4" class="text-center">Empty!</td></tr>';
                    }else{
                        foreach($bannedList as $bannedIp){                
                            echo '<tr>
                            <td>'.$bannedIp["ip"].'</td>
                            <td>'.$bannedIp["reason"].'</td>
                            <td>'.$bannedIp["added_at"].'</td>
                            <td><a class="btn btn-danger btn-xs" onclick="return confirm(\'Are you sure you want to delete this item?\');" title="Delete" href='.adminLink('ban-ip-address/delete/'.$bannedIp['id'],true).'> <i class="fa fa-trash-o"></i> &nbsp; Delete </a></td>
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