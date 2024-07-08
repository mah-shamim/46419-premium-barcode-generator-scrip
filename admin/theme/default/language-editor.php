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
              <?php if($pointOut == 'edit') { ?>
                <div style="position:absolute; top:4px; right:15px;">
                  <a class="btn btn-primary btn-sm" href="<?php adminLink($controller.'/add-custom-text/'.$args[0]); ?>"><i class="fa fa-plus-square-o"></i> &nbsp; Add Custom Text</a>
                  <a class="btn btn-danger btn-sm" href="<?php adminLink($controller.'/backup/'.$args[0]); ?>"><i class="fa fa-download"></i> &nbsp; Backup Language</a>
                </div>
              <?php } elseif($pointOut == '') { ?>
                <div style="position:absolute; top:4px; right:15px;">
                  <a class="btn btn-success btn-sm" href="<?php adminLink($controller.'/add'); ?>"><i class="fa fa-plus"></i> &nbsp; Create New Language</a>
                  <a class="btn btn-primary btn-sm" href="<?php adminLink($controller.'/add-custom-text'); ?>"><i class="fa fa-plus-square-o"></i> &nbsp; Add Custom Text</a>
                  <a class="btn btn-warning btn-sm" href="<?php adminLink($controller.'/import'); ?>"><i class="fa fa-upload"></i> &nbsp; Import Language</a>
              </div>
              <?php } ?>
            </div><!-- /.box-header ba-la-ji -->
            <form action="#" method="POST" <?php if($pointOut == 'import') { echo 'enctype="multipart/form-data"';} ?>>
            <div class="box-body">
          
            <?php if(isset($msg)) echo $msg; ?><br />
            
            <?php if($pointOut == 'edit'){ ?>
            
           <div class="box-header with-border">
            <h3 class="box-title">General Settings</h3>
           </div>
           
           <br />
           
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <td><label for="language_name" class="newCenter">Language Name:</label></td>
                        <td><input required="required" value="<?php echo $generalLangSet[3]; ?>" type="text" placeholder="Type language name" name="language_name" id="language_name" class="form-control" /></td>
                    </tr>
                    <tr>
                        <td><label for="language_code" class="newCenter">Language Code: </label></td>
                        <td><input required="required" value="<?php echo $generalLangSet[2]; ?>" maxlength="2" type="text" placeholder="Type language code" id="language_code" name="language_code" class="form-control" /></td>
                    </tr>
                    <tr>
                        <td><label class="newCenter">Hreflang Attribute: </label></td>
                        <td><input value="<?php echo $generalLangSet[7]; ?>" maxlength="6" type="text" placeholder="Type hreflang attribute" name="hreflang" class="form-control" /></td>
                    </tr>
                    <tr>
                        <td><label for="sort_order" class="newCenter">Sort Order:</label></td>
                        <td><input type="text" name="sort_order" id="sort_order" value="<?php echo $generalLangSet[0]; ?>" class="form-control"/></td>
                    </tr>
                    <tr>
                        <td><label for="direction" class="newCenter">Text Direction:</label></td>
                        <td><select name="direction" class="form-control">
                        <option <?php isSelected($generalLangSet[6], true, 1, 'ltr'); ?> value="ltr">Left to Right</option>
                        <option <?php isSelected($generalLangSet[6], true, 1, 'rtl'); ?> value="rtl">Right to Left</option>
                    </select></td>
                    </tr>
                    <tr>
                        <td><label for="status" class="newCenter">Status:</label></td>
                        <td><select name="status" class="form-control">
                        <option <?php isSelected($generalLangSet[5], true, 1); ?> value="1">Enabled</option>
                        <option <?php isSelected($generalLangSet[5], false, 1); ?> value="0">Disabled</option>
                    </select></td>
                    </tr>
                </tbody>
            </table>
            <br />
               <div class="box-header with-border">
                <h3 class="box-title">Language Data</h3>
               </div>
            <br />
            
            <table class="table table-hover table-bordered">
                <thead>
                    <th>UID</th>
                    <th>Default String</th>
                    <th><?php echo strtoupper($args[0]); ?> Language String</th>
                </thead>
                <tbody>
                    <?php foreach($langDataArr as $lang){
                    if(strlen($lang[2]) < 150) $row = 2; 
                    elseif(strlen($lang[2]) < 250) $row = 4;    
                    elseif(strlen($lang[2]) < 450) $row = 6; 
                    elseif(strlen($lang[2]) < 650) $row = 8;   
                    else $row = 10;   
                    echo '<tr><td style="width: 140px;">'.$lang[1].'</td><td>'.$lang[2].'</td>
                    <td><textarea name="'.$lang[0].'" id="'.$lang[0].'" class="form-control" cols="2000" rows="'.$row.'">'.$lang[3].'</textarea></td></tr>';
                    }?>
                </tbody>
                </table>
                
                <br />
                
                <div class="text-center">
                    <input type="submit" value="Save" class="btn btn-primary btn-lg"/>
                    <a class="btn btn-danger btn-lg" href="<?php adminLink($controller); ?>">Cancel</a>
                </div>
                
                <br />
                <br />
            <?php } elseif($pointOut == 'add'){ ?>
                
                <div class="form-group">
                    <label for="language_name">Language Name</label>
                    <input required="required" type="text" placeholder="Type language name" name="language_name" id="language_name" class="form-control" />
                </div>
                
                <div class="form-group">
                    <label for="language_code">Language Code <small> ( 2 Letter <span style="color: #e74c3c;">ISO 639-1</span> Language Code - <a target="_blank" rel="nofollow" href="http://www.w3schools.com/tags/ref_language_codes.asp">Reference</a> )</small></label>
                    <input required="required" maxlength="2" type="text" placeholder="Type language code" id="language_code" name="language_code" class="form-control" />
                </div>

                <div class="form-group">
                    <label>Hreflang Attribute <small> ( <a target="_blank" rel="nofollow" href="https://moz.com/learn/seo/hreflang-tag">More information</a> )</small></label>
                    <input maxlength="6" type="text" placeholder="Type hreflang attribute (General targeting with x-default)" name="hreflang" class="form-control" />
                </div>

                <div class="form-group">
                    <label for="language_author">Your Name</label>
                    <input type="text" placeholder="Type your name" id="language_author" name="language_author" class="form-control" />
                </div>
                
                <div class="form-group">
                    <label for="direction">Text Direction</label>
                    <select name="direction" class="form-control">
                        <option selected="" value="ltr">Left to Right</option>
                        <option value="rtl">Right to Left</option>
                    </select>
                </div>
                                
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" class="form-control">
                        <option selected="" value="1">Enabled</option>
                        <option value="0">Disabled</option>
                    </select>
                </div>
                <br />
                <input type="submit" name="save" value="Create Language File" class="btn btn-primary"/>
                <a class="btn btn-danger" href="<?php adminLink($controller); ?>">Cancel</a>
                <br />
                <br />
                
            
            <?php } elseif($pointOut == 'add-custom-text'){ ?>
                <div class="form-group">
                    <label for="csnumber">UID</label>
                    <input type="text" readonly="" id="csnumber" name="csnumber" value="<?php echo $customNumber; ?>" class="form-control" />
                </div>
                
                <div class="form-group">
                    <label for="default_string">Default String</label>
                    <input required="required" type="text" placeholder="Type your text" id="default_string" name="default_string" class="form-control" />
                </div>
                
                <br />
                <input type="submit" name="save" value="Add" class="btn btn-primary"/>
                <a class="btn btn-danger" href="<?php adminLink($controller); ?>">Cancel</a>
                <br />
                <br />   
            <?php } elseif($pointOut == 'import'){ ?>
            
                <div class="form-group text-center">																	
                    <label for="langID">Select language file to upload:</label>
                        <div class="controls">		   
                         <input type="file" name="langUpload" id="langUpload" class="btn btn-default" style=" display: inline-block;" />
                         <input type="hidden" name="langID" id="langID" value="1" /> <br />
                         <br />
                            <label class="checkbox-inline"><input type="checkbox" name="customStr" />Include Custom Language Strings ?</label>	
                            <br />   <br />                 
                         <button type="submit" class="btn btn-warning"><i class="fa fa-upload"></i> Import</button>
                        </div> <!-- /controls -->	
				</div> <!-- /control-group -->
            <?php } else { ?>

                <table class="table table-hover table-bordered table-striped">
                    <thead>
                        <th>Sort Order</th>
                        <th>Language Code</th>
                        <th>Language Name</th>
                        <th>Author</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>
                        <?php foreach($allLangs as $lang){  
                        echo '<tr>
                        <td style="width: 100px;">'.$lang[0].'</td>
                        <td>'.strtoupper($lang[2]).'</td>
                        <td>'.$lang[3].'</td>
                        <td>'.$lang[4].'</td>
                        <td>'.($lang[5] ? '<a href="'.adminLink($controller.'/status/disable/'.$lang[2],true).'" class="label label-success">Enabled</a>' : '<a href="'.adminLink($controller.'/status/enable/'.$lang[2],true).'" class="label label-danger">Disabled</a>').'</td>
                        <td style="width: 200px;">
                        <a class="btn btn-info btn-xs" href="'.adminLink($controller.'/edit/'.$lang[2],true).'" title="Edit Language "><i class="fa fa-edit"></i> Edit</a>
                        <a class="btn btn-success btn-xs" href="'.createLink($lang[2],true).'" target="_blank" title="Preview your website with this language"><i class="fa fa-external-link"></i> Preview</a>
                        <a class="delete btn btn-danger btn-xs" data-confirm="Are you sure you want to delete this item?" href="'.adminLink($controller.'/delete/'.$lang[2],true).'" title="Delete Language"><i class="fa fa-trash-o"></i> Delete</a>
                        </td>
                        </tr>';
                        }?>
                </tbody>
                </table>
            <?php } ?>
            
            <br />
            
            </div><!-- /.box-body -->
            </form>
          </div><!-- /.box -->
  
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->