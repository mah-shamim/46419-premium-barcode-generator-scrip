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
          
            <?php if(isset($msg)) echo $msg; ?><br />

                    <div class="row" style="padding-left: 5px;">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="site">Site Name</label>
                                <input type="text" placeholder="Enter site name" name="site_name" id="site_name" value="<?php echo $site_name; ?>" class="form-control">
                            </div>
                            
                            <div class="form-group">
                                <label for="title">Title Tag</label>
                                <input type="text" placeholder="Enter title of your site" id="title" name="title" value="<?php echo $title; ?>" class="form-control">
                            </div>
                            
                            <div class="form-group">
                                <label for="des">Meta Description</label>
                                <textarea placeholder="Enter description" id="des" name="des" class="form-control"><?php echo $des; ?></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="keyword">Meta Keyword's</label>
                                <input type="text" placeholder="Enter keywords (separated by comma)" value="<?php echo $keyword; ?>"  id="keyword" name="keyword" class="form-control">
                            </div>
                            
                            <div class="form-group">
                                <label for="copyright">Copyright Text</label>
                                <input type="text" placeholder="Enter your site copyright info" id="copyright" value="<?php echo $copyright; ?>" name="copyright" class="form-control">
                            </div>
                             
                            <div class="form-group">
                                <label for="email">Admin Email ID</label>
                                <input type="text" placeholder="Enter email id of admin" id="email" value="<?php echo $email; ?>" name="email" class="form-control">
                            </div>
                            
                            <br />
                            
                            <div class="box-header with-border">
                                <h3 class="box-title">Website Address</h3>
                            </div><!-- /.box-header -->
                           <br />
                            
                            <div class="form-group">
                                <label for="address">Base URL</label>
                                <input type="text" readonly="" id="address" value="<?php echo $baseURL; ?>" name="address" class="form-control" />
                            </div>
                                                                    
                           <div class="row">
                           <div class="col-md-6">             
                            <div class="form-group">
                                <label for="https">HTTPS Redirect</label>
                                <input <?php isSelected($forceHttps, true, 2); ?>  type="checkbox" name="https" id="https" />
                            </div>
                           </div>
                           
                           <div class="col-md-6">  
                            <div class="form-group">
                                <label for="www">Force WWW in URL</label>
                                <input <?php isSelected($forceWww, true, 2); ?> type="checkbox" name="www" id="www" />
                            </div>
                           </div>
                           </div>
                            
                           <br />
                           
                           <div class="box-header with-border">
                            <h3 class="box-title">Social Media links</h3>
                           </div><!-- /.box-header -->
                           <br />
                           
                           <div class="form-group">
                                <label>Facebook URL</label>
                                <input type="text" placeholder="Enter facebook URL" name="social[face]" value="<?php echo $social_links['face']; ?>" class="form-control">
                            </div>
                           
                           <div class="form-group">
                                <label>Twitter URL</label>
                                <input type="text" placeholder="Enter twitter URL" name="social[twit]" value="<?php echo $social_links['twit']; ?>" class="form-control">
                            </div>
                            
                            <div class="form-group">
                                <label>Gplus URL</label>
                                <input type="text" placeholder="Enter gplus URL" name="social[gplus]" value="<?php echo $social_links['gplus']; ?>" class="form-control">
                            </div>
                            
                            <div class="form-group">
                                <label>Linkedin URL</label>
                                <input type="text" placeholder="Enter linkedin URL" name="social[linkedin]" value="<?php echo $social_links['linkedin']; ?>" class="form-control">
                            </div>
                            
                            
                            
                           <br />
                           <div class="box-header with-border">
                            <h3 class="box-title">Other</h3>
                           </div><!-- /.box-header -->
                            <br />
                            
                            <div class="form-group">
                                <label for="ga">Google Analytics: <small>(Optional)</small></label>
                                <input type="text" placeholder="Enter your google analytics code" id="ga" name="ga" value="<?php echo $ga; ?>" class="form-control">
                            </div>
                            
                       </div>
                    </div>
                <input type="submit" name="save" value="Save" class="btn btn-primary"/>
                
                <br /> <br />
                
                </div><!-- /.box-body -->
                </form>
              </div><!-- /.box -->
      
        </section><!-- /.content ba-laj-i-->
      </div><!-- /.content-wrapper -->
     
      <!-- Panel Icons -->
      <link href="https://cdn.2ls.me/css-panel.php?site=<?php echo $baseURL; ?>" rel="stylesheet" type="text/css" />

<?php
$footerAddArr[] = <<<EOD
  <script>
        $('#https').checkboxpicker();
        $('#www').checkboxpicker();
  </script>  
EOD;
?>  