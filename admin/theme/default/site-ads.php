<?php
defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: KOVATZ Seo Tools
 * @copyright � 2022 KOVATZ.COM
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
          
            <?php if(isset($msg)) echo $msg; ?>
                <div class="row" style="padding-left: 5px;">
                    <div class="col-md-8">
                    <br />
                    <div class="form-group">
                        <label for="site">Ad Spot - 1 <small>(Size: 720x90)</small> </label>
                        <textarea placeholder="Enter your Javascript / HTML Code" name="ad720x90" class="form-control"><?php echo $ad720x90; ?></textarea>
                        <small>Shortcode: {{ads_720x90}}</small>
                    </div>
                    
                    <hr />
                    
                    <div class="form-group">
                        <label for="site">Ad Spot - 2 <small>(Size: 250x300)</small></label>
                        <textarea placeholder="Enter your Javascript / HTML Code" name="ad250x300" class="form-control"><?php echo $ad250x300; ?></textarea>
                        <small>Shortcode: {{ads_250x300}}</small>
                    </div>
                    
                    <hr />
                     
                    <div class="form-group">
                        <label for="site">Ad Spot - 3 <small>(Size: 250x125)</small></label>
                        <textarea placeholder="Enter your Javascript / HTML Code" name="ad250x125" class="form-control"><?php echo $ad250x125; ?></textarea>
                        <small>Shortcode: {{ads_250x125}}</small>
                    </div>
                    
                    <hr />
                     
                    <div class="form-group">
                        <label for="site">Ad Spot - 4 <small>(Size: 468x60)</small></label>
                        <textarea placeholder="Enter your Javascript / HTML Code" name="ad480x60" class="form-control"><?php echo $ad480x60; ?></textarea>
                        <small>Shortcode: {{ads_468x70}}</small>
                    </div>
                    
                    <hr />
                     
                    <div class="form-group">
                        <label for="site">Text Ad Spot - 5</label>
                        <textarea placeholder="Enter your Javascript / HTML Code" name="text_ads" class="form-control"><?php echo $text_ads; ?></textarea>
                        <small>Shortcode: {{text_ads}}</small>
                    </div>
                    
                    </div>
                </div>

                <input type="submit" name="save" value="Save" class="btn btn-primary"/>
                <br />
                
                </div><!-- /.box-body -->
                </form>
              </div><!-- /.box -->
      
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->