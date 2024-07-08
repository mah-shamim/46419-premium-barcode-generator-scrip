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
          
            <?php if(isset($msg)) echo $msg; ?><br />
            
            <div class="form-group">
                <select id="type" class="form-control">
                    <option value="" disabled="" selected="">Select your option</option>
                    <option value="custom">Custom Email</option>
                    <option value="customers">Email to Customers</option>
                </select>
            </div>
            
            <div id="optionType" class="hide form-group">
                <input placeholder="Type your customer name (autocomplete)" type="text" name="customer" id="customer" class="form-control" />
            </div>
            
             <div class="form-group">
                <input value="<?php echo $to; ?>" type="email" required="" class="form-control" placeholder="To:" id="to" name="to" />
             </div> 
             
             <div class="form-group">
                <input value="<?php echo $sub; ?>" required="" class="form-control" placeholder="Subject:" name="sub" />
             </div>
            
            <div class="form-group">
                <textarea required="" class="form-control" id="mailcontent" name="mailcontent"><?php echo $message; ?></textarea>
            </div>
                        
            </div><!-- /.box-body -->
            
            <div class="box-footer">
              <div class="pull-right">
                <a type="reset" href="<?php adminLink($controller); ?>" class="btn btn-default"><i class="fa fa-times"></i> Discard</a>
                <button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Send</button>
              </div>
            </div>
            </form>
          </div><!-- /.box -->
  
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->
<?php
$ajaxLink = adminLink('?route=ajax/getCustomers',true); 
$filebrowserBrowseUrl = createLink('core/library/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',true);
$filebrowserUploadUrl = createLink('core/library/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',true);
$filebrowserImageBrowseUrl = createLink('core/library/filemanager/dialog.php?type=1&editor=ckeditor&fldr=',true);
$footerAddArr[] = <<<EOD
<script type="text/javascript">
    var selVal;
    $(function () {
    CKEDITOR.replace('mailcontent',{ filebrowserBrowseUrl : '$filebrowserBrowseUrl', filebrowserUploadUrl : '$filebrowserUploadUrl', filebrowserImageBrowseUrl : '$filebrowserImageBrowseUrl', toolbar : 'Basic' });
    CKEDITOR.on( 'dialogDefinition', function( ev ) {
      var dialogName = ev.data.name;
      var dialogDefinition = ev.data.definition;
      if ( dialogName == 'link' || dialogName == 'image' ){
         dialogDefinition.removeContents( 'Upload' );
      }
   });
  });
  $('select[id="type"]').on('change', function() {
  selVal = jQuery('select[id="type"]').val();
   if(selVal == 'customers'){
       $('#optionType').removeClass("hide");
       $('#optionType').fadeIn();
       $('#to').attr('readonly', 'readonly');
   }else{
        $('#optionType').fadeOut();
       $('#to').removeAttr('readonly');
   }
  });
   </script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" />
<style>
.ui-autocomplete {
z-index: 100 !important;
}
</style>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<script type="text/javascript">
$('#customer').autocomplete({
	source: function( request, response ) {
  		$.ajax({
  			url : '$ajaxLink',
  			dataType: "json",
			data: {
			   term: request.term,
			   type: 'plan_table'
			},
			 success: function( data ) {
				 response( $.map( data, function( item ) {
				 	var code = item.split("|");
					return {
						label: code[0],
						value: code[0],
						data : item
					}
				}));
			}
  		});
  	},
  	autoFocus: true,	      	
  	minLength: 2,
  	select: function( event, ui ) {
		var names = ui.item.data.split("|");						
            $('#to').val(names[1]);
        }
});		      	
</script>
EOD;
?>