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
              <div style="position:absolute; top:4px; right:15px;">
                <?php if($pointOut == ''){ ?>
                <a href="<?php adminLink($controller.'/export'); ?>" class="btn btn-primary"><i class="fa fa-fw fa-share-square"></i> Export</a>
                <?php } ?>
              </div>
            </div><!-- /.box-header ba-la-ji -->
            <div class="box-body">
            <?php if(isset($msg)) echo $msg; ?><br />
            
            <?php if($pointOut == 'info'){ ?>

            <div class="row">
                <div class="col-md-3">
                  <!-- Profile Image -->
                  <div class="box box-default">
                    <div class="box-body box-profile">
                      <img class="profile-user-img img-responsive img-circle" src="<?php echo $userInfo['picture']; ?>" alt="User profile picture">
        
                      <h3 class="profile-username text-center"><?php echo $userInfo['full_name']; ?></h3>
        
                      <p class="text-muted text-center"><?php echo $userInfo['verified']; ?></p>
        
                      <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                          <b>Registered At </b> <a class="pull-right"><?php echo $registeredAt; ?></a>
                        </li>
                        <li class="list-group-item">
                          <b>IP Address </b> <a class="pull-right"><?php echo $userInfo['ip']; ?></a>
                        </li>
                        <li class="list-group-item">
                          <b>Detected Country</b> <a class="pull-right"><?php echo $detectedUserCountry; ?></a>
                        </li>
                      </ul>
        
                      <a target="_blank" href="<?php createLink('ajax/user-acc/login/'.$userInfo['username']); ?>" class="btn btn-primary btn-block"><b>Login into User Account</b></a>
                    </div>
                    <!-- /.box-body -->
                  </div>    
                </div>
                <div class="col-md-9">
                  <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                      <li class="active"><a href="#overview" data-toggle="tab">Overview</a></li>
                    </ul>
                    <div class="tab-content">
                      <div class="active tab-pane" id="overview">
                            <br />
                            <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <td colspan="1" class="bold">General Information</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="width: 200px;">UID</td>
                                    <td><span><?php echo $userInfo['id']; ?></span></td>
                                </tr> 
                                <tr>
                                    <td style="width: 200px;">Username</td>
                                    <td><span><?php echo $userInfo['username']; ?></span></td>         
                                </tr> 
                                <tr>
                                    <td style="width: 200px;">Email ID</td>
                                    <td><span><?php echo $userInfo['email_id']; ?></span></td>         
                                </tr>
                                <tr>
                                    <td style="width: 200px;">Registration Type</td>
                                    <td><span><?php echo $userInfo['platform']; ?></span></td>
                                </tr> 
                             <tr>
                                    <td style="width: 200px;">Oauth ID</td>
                                    <td><span><?php echo $userInfo['oauth_uid']; ?></span></td>
                                </tr> 
                                <tr>
                                    <td style="width: 200px;">Full Name</td>
                                    <td><span><?php echo $userInfo['full_name']; ?></span></td>
                                </tr>
                                <tr>
                                    <td style="width: 200px;">User Country</td>
                                    <td><span><?php echo country_code_to_country($userInfo['country']); ?></span></td>         
                                </tr>
                                <tr>
                                    <td style="width: 200px;">Joined on</td>
                                    <td><span><?php echo $userInfo['added_date']; ?></span></td>         
                                </tr>  
                            </tbody>
                            </table>
                            <br />
                            <?php if($userInfo['address1'] != ''){ ?>
                            <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <td colspan="1" class="bold">Personal Information</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="width: 30%;">First Name</td>
                                    <td><span><?php echo $userInfo['firstname']; ?></span></td>
                                </tr> 
                                <tr>
                                    <td style="width: 200px;">Last Name</td>
                                    <td><span><?php echo $userInfo['lastname']; ?></span></td>         
                                </tr> 
                                <?php if($userInfo['company'] != '') { ?>
                                <tr>
                                    <td style="width: 200px;">Company</td>
                                    <td><span><?php echo $userInfo['company']; ?></span></td>         
                                </tr> 
                                <?php } ?>
                                <tr>
                                    <td style="width: 200px;">Address Line 1</td>
                                    <td><span><?php echo $userInfo['address1']; ?></span></td>         
                                </tr> 
                                <?php if($userInfo['address2'] != '') { ?>
                                <tr>
                                    <td style="width: 200px;">Address Line 2</td>
                                    <td><span><?php echo $userInfo['address2']; ?></span></td>         
                                </tr> 
                                <?php } ?>
                                <tr>
                                    <td style="width: 200px;">City</td>
                                    <td><span><?php echo $userInfo['city']; ?></span></td>         
                                </tr>
                                <tr>
                                    <td style="width: 200px;">State</td>
                                    <td><span><?php echo $userInfo['statestr']; ?></span></td>         
                                </tr> 
                                <tr>
                                    <td style="width: 200px;">Country</td>
                                    <td><span><?php echo $userInfo['country']; ?></span></td>         
                                </tr>  
                                <tr>
                                    <td style="width: 200px;">Post Code</td>
                                    <td><span><?php echo $userInfo['postcode']; ?></span></td>         
                                </tr> 
                                <tr>
                                    <td style="width: 200px;">Telephone</td>
                                    <td><span><?php echo $userInfo['telephone']; ?></span></td>         
                                </tr> 
                            </tbody>
                            </table>
                            <?php } else { ?>
                                <strong>Personal information not mentioned!</strong>
                            <?php } ?>
                      </div>
                      <div class="tab-pane" id="activity">
                      </div>
                    </div>  </div>  </div> 
            </div>        
            
            <?php } else { ?>
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="mySitesTable">
            	<thead>
            		<tr>
                          <th>Username</th>
                          <th>Full Name</th>
                          <th>Email ID</th>
                          <th>Joined Date</th>
                          <th>Platform</th>
                          <th>Oauth ID</th>
                          <th>Ban Access</th>
                          <th>Actions</th>
            		</tr>
            	</thead>         
                <tbody>                        
                </tbody>
            </table>
            <?php } ?>

            <br />
            
            </div><!-- /.box-body -->
          </div><!-- /.box -->
  
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->
<?php 
$ajaxLink = adminLink('?route=ajax/manageUsers',true); 
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
EOD;
?>