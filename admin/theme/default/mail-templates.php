<?php
defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: PDF Studio
 * @copyright © 2024 KOVATZ
 *
 */
?>
<style>
.alert-success {
    background-color: #dff0d8 !important;
    border-color: #d6e9c6 !important;
    color: #3c763d !important;
}
.lineCode{
    padding: 5px;
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
            </div><!-- /.box-header ba-la-ji -->
            <form action="#" method="POST">
            <div class="box-body">
          
            <?php if(isset($msg)) echo $msg; ?>
                
                <div class="row">

                    <div class="col-md-12">
                    
                    <div class="alert alert-info">
                        <strong>Note: </strong> Short Codes also supported inside mail templates!
                    </div>
                    
                     <h4>Account Activation - Mail Template</h4>
                    </div>
                    
                    <div class="col-md-8">
                        <div class="form-group">
                          <label for="activationSub">Subject</label>
                          <input class="form-control" type="text" name="activationSub" value="<?php echo $activationSub; ?>" />
                        </div>
                        
                        <div class="form-group">
                          <label for="activation">Mail Content</label>
                          <textarea id="activation" name="activation" class="form-control"><?php echo $activationMail; ?></textarea>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <label>Replacement Codes</label>
                        
                        <div class="well alert-success">
                            <div class="lineCode"><b>{SiteName}</b> - Returns your site name<br /></div>
                            <div class="lineCode"><b>{FullName}</b> - Returns customers name<br /></div>
                            <div class="lineCode"><b>{UserName}</b> - Returns customers username<br /></div>
                            <div class="lineCode"><b>{VerificationUrl}</b> - Returns verification link<br /></div>
                            <div class="lineCode"><b>{UserEmailId}</b> - Returns customers mail id<br /></div>
                            <div class="lineCode"><b>{CustomerIp}</b> - Returns account registered IP<br /></div>
                        </div>
                        
                    </div>
                   
                    <div class="col-md-12">
                        <br /><hr /><br /><h4>Password Reset - Mail Template</h4><br />
                    </div>
                                        
                    <div class="col-md-8">
                        <div class="form-group">
                          <label for="passwordSub">Subject</label>
                          <input class="form-control" type="text" name="passwordSub" value="<?php echo $passwordSub; ?>" />
                        </div>
                        
                        <div class="form-group">
                          <label for="password">Mail Content</label>
                          <textarea id="password" name="password" class="form-control"><?php echo $passwordMail; ?></textarea>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <label>Replacement Codes</label>
                        
                        <div class="well alert-success">
                            <div class="lineCode"><b>{SiteName}</b> - Returns your site name<br /></div>
                            <div class="lineCode"><b>{FullName}</b> - Returns customers name<br /></div>
                            <div class="lineCode"><b>{UserName}</b> - Returns customers username<br /></div>
                            <div class="lineCode"><b>{NewPassword}</b> - Returns new password<br /></div>
                            <div class="lineCode"><b>{UserEmailId}</b> - Returns customers mail id<br /></div>
                        </div>
                        
                    </div>
                
                    <div class="col-md-12">
                        <br /><br />
                        <input type="submit" name="save" value="Update Templates" class="btn btn-primary"/>
                        <br /><br />
                    </div>
                </div>
                </div><!-- /.box-body -->
                </form>

              </div><!-- /.box -->
      
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
<?php
$filebrowserBrowseUrl = createLink('core/library/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',true);
$filebrowserUploadUrl = createLink('core/library/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',true);
$filebrowserImageBrowseUrl = createLink('core/library/filemanager/dialog.php?type=1&editor=ckeditor&fldr=',true);
$footerAddArr[] = <<<EOD
<script type="text/javascript">
    $(function () {
    CKEDITOR.replace('activation',{ filebrowserBrowseUrl : '$filebrowserBrowseUrl', filebrowserUploadUrl : '$filebrowserUploadUrl', filebrowserImageBrowseUrl : '$filebrowserImageBrowseUrl', toolbar : 'Basic' });
    CKEDITOR.on( 'dialogDefinition', function( ev ) {
      var dialogName = ev.data.name;
      var dialogDefinition = ev.data.definition;
      if ( dialogName == 'link' || dialogName == 'image' ){
         dialogDefinition.removeContents( 'Upload' );
      }
   });
    CKEDITOR.replace('password',{ filebrowserBrowseUrl : '$filebrowserBrowseUrl', filebrowserUploadUrl : '$filebrowserUploadUrl', filebrowserImageBrowseUrl : '$filebrowserImageBrowseUrl', toolbar : 'Basic' });
    CKEDITOR.on( 'dialogDefinition', function( ev ) {
      var dialogName = ev.data.name;
      var dialogDefinition = ev.data.definition;
      if ( dialogName == 'link' || dialogName == 'image' ){
         dialogDefinition.removeContents( 'Upload' );
      }
   });
   });
</script>
EOD;
?>