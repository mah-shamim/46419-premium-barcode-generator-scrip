<?php
defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: Rainbow PHP Framework
 * @copyright � 2022 KOVATZ.COM
 *
 */
?>
  <link href="<?php themeLink('dist/css/bootstrap-formhelpers.min.css'); ?>" rel="stylesheet" type="text/css" />
  
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
            <form action="#" method="POST" onclick="return fixState();">
            <div class="box-body">
          
            <?php if(isset($msg)) echo $msg; ?><br />
            
                <div class="col-md-6">

				<div class="form-group">
					Username *<br />
						<input pattern=".{3,}" placeholder="Type username" required="" value="<?php echo $username; ?>" type="text" class="form-control" name="users[username]" />
				</div>	
				
                <div class="form-group">
					Email * <br />
						<input pattern=".{3,}" placeholder="Type user mail id" required="" value="<?php echo $email_id; ?>" type="text" class="form-control" name="users[email_id]" />
				</div>

                 <div class="form-group">
					First Name <br />
					<input value="<?php echo $firstname; ?>" placeholder="Type first name (optional)" type="text" name="users[firstname]" class="form-control"  style="width: 96%;"/>
				</div>	
                
                 <div class="form-group">
					Last Name <br />
					<input value="<?php echo $lastname; ?>" placeholder="Type last name (optional)" type="text" name="users[lastname]" class="form-control"  style="width: 96%;"/>
				</div>
                
                <div class="form-group">
			         Company <br />
					 <input value="<?php echo $company; ?>" placeholder="Type company name (optional)" type="text" name="users[company]" class="form-control"  style="width: 96%;"/>
				</div>  
                
                <div class="form-group">
			          Telephone <br />
					 <input value="<?php echo $telephone; ?>" placeholder="Type phone no. (optional)" type="text" name="users[telephone]" class="form-control bfh-phone" data-country="country" style="width: 96%;" />
				</div>
                
                <div class="form-group">
			         Country <br />
					 <select id="country" name="users[country]" class="form-control bfh-countries" data-country="<?php echo $country != '' ? $country : 'IN'; ?>" style="width: 96%;"></select>
				</div>
                
            </div><!-- /.col-md-6 -->
            
            <div class="col-md-6">
               
				<div class="form-group">
					Full Name * <br />
						<input placeholder="Type full name" required="" value="<?php echo $full_name; ?>" type="text" class="form-control" name="users[full_name]" />
				</div>
				
                <div class="form-group">
					Password *<br />
						<input placeholder="Type password" required="" type="password" class="form-control" name="users[password]" />
				</div>
                    
                <div class="form-group">
    		          Address 1 <br />
    				 <input value="<?php echo $address1; ?>" placeholder="Type home address (optional)" type="text" name="users[address1]" class="form-control"  style="width: 96%;"/>
    			</div>    
                
                <div class="form-group">
    		         Address 2 <br />
    				 <input value="<?php echo $address2; ?>" placeholder="Type Address line 2 (optional)" type="text" name="users[address2]" class="form-control"  style="width: 96%;"/>
    			</div> 
                
                <div class="form-group">
    		        City <br />
    	 	        <input value="<?php echo $city; ?>" placeholder="Type city (optional)" type="text" name="users[city]" class="form-control"  style="width: 96%;"/>
    			</div>
                
                <div class="form-group">
    		         Post Code <br />
    				 <input value="<?php echo $postcode; ?>" placeholder="Type postal code (optional)" type="text" name="users[postcode]" class="form-control"  style="width: 96%;"/>
    			</div>  
                
                <div class="form-group">
    		          Region / State <br />
                      <?php $state = ($state != '' ? 'data-state="'.$state.'"' : ''); ?>
    				 <select name="users[state]" id="state" class="form-control bfh-states" data-country="country" <?php echo $state; ?> style="width: 96%;"></select>
    			</div>
                    
            </div><!-- /.col-md-6 --> 
            <div class="col-md-12">
                <br /> 
                <input type="hidden" value="1" name="addUser" />
                <input type="hidden" value="No State" name="users[stateStr]" id="stateStr" />
                <input class="btn btn-primary" type="submit" value="Add User" /> 
                <br /> <br />
            </div>        
            
            <br />
            
            </div><!-- /.box-body -->
            </form>
          </div><!-- /.box -->
  
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->
<?php 
$jsLink = themeLink('dist/js/bootstrap-formhelpers.min.js',true);
$footerAddArr[] = <<<EOD
    <script src="$jsLink" type="text/javascript"></script>
    <script>
    function fixState(){
        var stateStr = $.trim($('select[id=state] option:selected').text());
        $('#stateStr').val(stateStr);
        return true;
    }
    </script>
EOD;
?>