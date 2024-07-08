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
            <form action="#" method="POST" onsubmit="return finalFixedLink();">
            <div class="box-body">
          
            <?php if(isset($msg)) echo $msg; ?> <br />
            
            <?php if($pointOut == 'page') { ?>   
            
            <div class="row">
                <div class="col-md-6">
                <div class="form-group">
                  <label for="page_title">Page Title</label>
                  <input required="required" type="text" placeholder="Enter your page title" value="<?php echo $page_title; ?>" name="page_title" class="form-control" />
                </div>
                <div class="form-group">
                  <label for="page_url">Page URL</label><small id="linkBox"> (<?php createLink('page'); ?>) </small>
                  <input required="required" type="text" id="pageUrlBox" placeholder="Enter your page url" value="<?php echo $page_url; ?>" name="page_url" class="form-control" />
                </div>
                
                <div class="form-group">
                  <label for="meta_des">Meta Description</label>
                  <textarea placeholder="Description must be within 150 Characters" rows="3" name="meta_des" class="form-control"><?php echo $meta_des; ?></textarea>
               </div>
               
               <div class="form-group"> 
                  <label for="loginreq">Who can access this page?</label>
                  <select class="form-control" name="loginreq">
                    <option <?php isSelected($loginreq,true,'1','all'); ?> value="all">All Users</option>
                    <option <?php isSelected($loginreq,true,'1','registered'); ?> value="registered">Only Registered Users</option>
                  </select>
               </div>
               
               <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control"> 
                        <option <?php isSelected($status,true,'1'); ?> value="on">Published</option>
                        <option <?php isSelected($status,false,'1'); ?> value="off">Unpublished</option>
                    </select>             
                </div>
               
           	    <div class="form-group">
					<div class="checkbox">
						<label class="checkbox inline">
							<input <?php isSelected($header_show,true,'2'); ?> type="checkbox" name="header_show" /> <strong>Display the page link on header menu bar.</strong>
						</label>
					</div>
				</div>
                
                </div><!-- /.col-md-6 -->
                
                <div class="col-md-6">
                
                <div class="form-group">
                  <label for="page_name">Page Name</label>
                  <input required="required" type="text" placeholder="Enter the page name" value="<?php echo $page_name; ?>" name="page_name" class="form-control" />
                </div>
                
                <div class="form-group">
                  <label for="posted_date">Posted Date</label>
                  <?php if($posted_date == '') { ?>
                  <input type="text" placeholder="Enter your posted date" id="postedDate" name="posted_date" class="form-control" />
                  <?php } else { ?>
                  <input type="text" placeholder="Enter your posted date" value="<?php echo $posted_date; ?>" id="postedDate" name="posted_date" class="form-control" />
                  <?php } ?>
                </div>
                
                <div class="form-group">
                  <label for="meta_tags">Meta Keywords (Separate with commas)</label>
                  <textarea placeholder="keywords1, keywords2, keywords3" rows="3" name="meta_tags" class="form-control"><?php echo $meta_tags; ?></textarea>
               </div>
               
               <div class="form-group"> 
                  <label for="pageLangCode">Show the page for all language users ?</label>
                  <select class="form-control" name="pageLangCode">
                    <option value="all">All Languages</option>
                    <option disabled="">Available Languages</option>
                    <?php foreach(getAvailableLanguages($con) as $langAsif){
                        echo '<option '. isSelected($pageLangCode,true,'1',$langAsif[2],true).' value="'.$langAsif[2].'">'.$langAsif[3].' Only</option>';
                    }
                    ?>
                  </select>
               </div>
               
               <div class="form-group"> 
                  <label for="sort_order">Sort Order</label> <small>(Optional)</small>
                  <input type="text" placeholder="Type your sort order number" value="<?php echo $sort_order; ?>" name="sort_order" class="form-control" />
               </div>

            	<div class="form-group">
					<div class="checkbox">
						<label class="checkbox inline">
							<input <?php isSelected($footer_show,true,'2'); ?> type="checkbox" name="footer_show" /> <strong>Display the page link on footer menu bar.</strong>
						</label>
					</div>
				</div>

                </div>
                
            </div><!-- /.row -->
            
            <div class="row">
             
             <div class="form-group" style="margin: 12px;">
                  <label for="page_content">Page Content</label>
                  <textarea id="editor1" name="page_content" class="form-control"><?php echo $page_content; ?></textarea>
             </div>
             
             </div>
             <?php if($args[0] == 'edit'){ ?>
             <input type="hidden" name="editPage" value="1" />
             <input type="hidden" name="editID" value="<?php echo $editID; ?>" />
             <?php } else { ?>
             <input type="hidden" name="newPage" value="1" />
             <?php } ?>
             <input type="submit" name="save" value="Save" class="btn btn-primary"/>
             <a class="btn btn-danger" href="<?php adminLink($controller); ?>" title="Cancel">Cancel</a>
            <br />
            <br />
            
            <?php } elseif($pointOut == 'link') { ?>
                
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                
                <div class="form-group">
                  <label for="url_type">URL Type</label>
                      <select class="form-control" name="url_type">
                        <option <?php isSelected($url_type,true,'1','internal'); ?> value="internal">Internal Link</option>
                        <option <?php isSelected($url_type,true,'1','external'); ?> value="external">External Link</option>
                      </select>
                </div>
                
                <div class="form-group">
                  <label for="url_name">URL Title</label>
                  <input required="required" type="text" placeholder="Type your URL title" value="<?php echo $url_name; ?>" name="url_name" class="form-control" />
                </div>
                
                <div class="form-group">
                  <label for="url">URL</label>
                  <input required="required" type="text" placeholder="Type your link" value="<?php echo $url; ?>" name="url" class="form-control" />
                </div>
                    
                <div class="alert alert-success" id="linkAlertBox">
                    <b>{{baseLink}} will be replaced to website base path ("<?php createLink(); ?>")</b>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                    
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control"> 
                                <option <?php isSelected($status,true,'1'); ?> value="on">Published</option>
                                <option <?php isSelected($status,false,'1'); ?> value="off">Unpublished</option>
                            </select>             
                        </div>
                        
                        <div class="form-group">
                          <label for="target">"target" attribute</label> <small>(Optional)</small>
                          <select class="form-control" name="target">
                            <option <?php isSelected($target,true,'1','none'); ?> value="none">None</option>
                            <option <?php isSelected($target,true,'1','_blank'); ?> value="_blank">_blank</option>
                            <option <?php isSelected($target,true,'1','_self'); ?> value="_self">_self</option>
                            <option <?php isSelected($target,true,'1','_parent'); ?> value="_parent">_parent</option>
                            <option <?php isSelected($target,true,'1','_top'); ?> value="_top">_top</option>
                          </select>
                        </div>

                    	<div class="form-group">
        					<div class="checkbox">
        						<label class="checkbox inline">
							         <input <?php isSelected($header_show,true,'2'); ?> type="checkbox" name="header_show" /> <strong>Display the page link on header menu bar.</strong>
        						</label>
        					</div>
        				</div>
                
                    </div>
                    <div class="col-md-6">
                        
                        <div class="form-group"> 
                          <label for="sort_order">Sort Order</label> <small>(Optional)</small>
                          <input type="text" placeholder="Type your sort order number" value="<?php echo $sort_order; ?>" name="sort_order" class="form-control" />
                        </div>
                
                        <div class="form-group">
                          <label for="rel">"rel" attribute</label> <small>(Optional)</small>
                          <select class="form-control" name="rel">
                            <option <?php isSelected($rel,true,'1','none'); ?> value="none">None</option>
                            <option <?php isSelected($rel,true,'1','nofollow'); ?> value="nofollow">nofollow</option>
                            <option <?php isSelected($rel,true,'1','noreferrer'); ?> value="noreferrer">noreferrer</option>
                            <option <?php isSelected($rel,true,'1','external'); ?> value="external">external</option>
                            <option <?php isSelected($rel,true,'1','bookmark'); ?> value="bookmark">bookmark</option>
                            <option <?php isSelected($rel,true,'1','author'); ?> value="author">author</option>
                            <option <?php isSelected($rel,true,'1','help'); ?> value="help">help</option>
                            <option <?php isSelected($rel,true,'1','license'); ?> value="license">license</option>
                          </select>
                        </div>
                        
                    	<div class="form-group">
        					<div class="checkbox">
        						<label class="checkbox inline">
							         <input <?php isSelected($footer_show,true,'2'); ?> type="checkbox" name="footer_show" /> <strong>Display the page link on footer menu bar.</strong>
        						</label>
        					</div>
        				</div>

                    </div>
                </div>
                
                <div class="text-center">
                    <?php if($args[0] == 'edit'){ ?>
                    <input type="hidden" name="editLink" value="1" />
                    <input type="hidden" name="editID" value="<?php echo $editID; ?>" />
                    <input type="submit" name="save" value="Save" class="btn btn-primary"/>
                    <?php } else { ?>
                    <input type="hidden" name="newLink" value="1" />
                    <input type="submit" name="save" value="Create Link" class="btn btn-primary"/>
                    <?php } ?>
                    <a class="btn btn-danger" href="<?php adminLink($controller); ?>" title="Cancel">Cancel</a>
                    <br /> <br />
                </div>   
                      
                </div><!-- /.col-md-6 -->
            </div>  
                
            <?php } else { ?>
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="mySitesTable">
            	<thead>
            		<tr>
                          <th>Sort Order</th>
                          <th>Page Name</th>
                          <th>Page Title</th>
                          <th>Type</th>
                          <th>Added Date</th>
                          <th>Status</th>
                          <th>Actions</th>
            		</tr>
            	</thead>         
                <tbody>                        
                </tbody>
            </table>
            <?php } ?>
            </div><!-- /.box-body -->
            </form>
          </div><!-- /.box -->
            
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      
<?php 
$pageLink = createLink('page/',true);
$ajaxLink = adminLink('?route=ajax/managePages',true); 
$filebrowserBrowseUrl = createLink('core/library/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',true);
$filebrowserUploadUrl = createLink('core/library/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',true);
$filebrowserImageBrowseUrl = createLink('core/library/filemanager/dialog.php?type=1&editor=ckeditor&fldr=',true);
$footerAddArr[] = <<<EOD
    <script type="text/javascript" language="javascript" class="init">
    $(document).ready(function() {
    	$('#mySitesTable').dataTable( {
    		"processing": true,
    		"serverSide": true,
    		"ajax": "$ajaxLink"
    	} );
    } );
    </script>
  <script>
         $(function () {
            $('#postedDate').daterangepicker({locale: {
            format: 'MM/DD/YYYY h:mm A'
            },singleDatePicker: true, timePicker: true, format: 'MM/DD/YYYY h:mm A'});
            var selVal = jQuery('select[name="url_type"]').val();
            if(selVal == 'internal'){
                $('#linkAlertBox').show();
            }else if(selVal == 'external'){
                $('#linkAlertBox').hide();
            }
         });
        
        $('select[name="url_type"]').on('change', function() { 
            var selVal = jQuery('select[name="url_type"]').val();
            if(selVal == 'internal'){
                $('#linkAlertBox').show();
                $('input[name="url"]').val('{{baseLink}}');
            }else if(selVal == 'external'){
                $('#linkAlertBox').hide();
                $('input[name="url"]').val('http://');
            }
        });
            
        var mainLink = "$pageLink";
        
        $("#pageUrlBox").focus(function (){
            fixLinkBox()
            });
        $("#pageUrlBox").keypress(function (){
            fixLinkBox()
            });
        $("#pageUrlBox").blur(function (){
            fixLinkBox(); 
            });
        $("#pageUrlBox").click(function (){
            fixLinkBox()
            });
            
        function fixLinkBox(){
            var pageUrl= jQuery.trim($('input[name=page_url]').val());
            var ref = uriFix(pageUrl);
            $("#linkBox").html(" (" + mainLink + ref + ") "); 
        }
        
        function finalFixedLink(){
            var pageUrl= jQuery.trim($('input[name=page_url]').val());
            var ref = uriFix(pageUrl);
            $("#pageUrlBox").val(ref); 
            return true;
        }
        
        </script>
    
EOD;
if($pointOut == 'page'){
$footerAddArr[] = <<<EOD
      <script type="text/javascript">
      $(function () {
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace('editor1',{ filebrowserBrowseUrl : '$filebrowserBrowseUrl', filebrowserUploadUrl : '$filebrowserUploadUrl', filebrowserImageBrowseUrl : '$filebrowserImageBrowseUrl' });
      CKEDITOR.on( 'dialogDefinition', function( ev )
   {
      // Take the dialog name and its definition from the event
      // data.
      var dialogName = ev.data.name;
      var dialogDefinition = ev.data.definition;

      // Check if the definition is from the dialog we're
      // interested on (the Link and Image dialog).
      if ( dialogName == 'link' || dialogName == 'image' )
      {
         // remove Upload tab
         dialogDefinition.removeContents( 'Upload' );
      }
   });
      
      });
    </script>
EOD;
}
$footerAddArr[] = <<<EOD
  <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%'
        });
      });
  </script>  
EOD;
?> 