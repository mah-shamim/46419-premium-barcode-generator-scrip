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
            <div class="box-body">
          
            <?php if(isset($msg)) echo $msg; ?><br />

            <table class="table table-bordered">
                <tbody>
                
                <tr>
                    <th>#</th>
                    <th>Task</th>
                    <th>Overall Stats</th>
                </tr>
                
                <tr>
                    <td>1</td>
                    <td>Cached Domains</td>
                    <td><span class="label label-primary"><?php echo $stats['cached']; ?></span></td>
                </tr>
                
                <tr>
                    <td>2</td>
                    <td>Competitive Analysis</td>
                    <td><span class="label label-danger"><?php echo $stats['competitive']; ?></span></td>
                </tr>
                
                <tr>
                    <td>3</td>
                    <td>Users</td>
                    <td><span class="label label-warning"><?php echo $stats['total_users']; ?></span></td>
                </tr>
                
                <tr>
                    <td>4</td>
                    <td>Banned Users</td>
                    <td><span class="label label-success"><?php echo $stats['banned_user']; ?></span></td>
                </tr> 
                
                <tr>
                    <td>5</td>
                    <td>Unverified Users</td>
                    <td><span class="label label-danger"><?php echo $stats['unverified']; ?></span></td>
                </tr> 
                
                <tr>
                    <td>6</td>
                    <td>Banned IPs</td>
                    <td><span class="label label-info"><?php echo $stats['banned_ips']; ?></span></td>
                </tr> 
                <!--   
                <tr>
                    <td>7</td>
                    <td>Page Views</td>
                    <td><span class="label label-success"><?php echo $stats['page_view']; ?></span></td>
                </tr>  
                
                <tr>
                    <td>8</td>
                    <td>Unique Visitors</td>
                    <td><span class="label label-info"><?php echo $stats['unique_view']; ?></span></td>
                </tr>   -->
                  
            </tbody></table>      
            
            <br />  
            
            <div class="box-header with-border">
              <h3 class="box-title">Last 10 days Pageview status</h3>
            </div>
            
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Date</th>
                        <th>Unique Visitors</th>
                        <th>Sessions</th>
                        <th>Page Views</th>
                    </tr>
                    <?php echo $tableData; ?>
                </tbody>
            </table>
            <br /> <br />
            </div><!-- /.box-body -->
          </div><!-- /.box -->
  
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->