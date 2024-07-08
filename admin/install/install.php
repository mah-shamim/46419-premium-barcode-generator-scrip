<?php
/*
 * @author MD ARIFUL HAQUE
 */

error_reporting(1);

//ROOT Path
define('ROOT_DIR', realpath(dirname(dirname(dirname(__FILE__)))) .DIRECTORY_SEPARATOR);

//Application Path
define('APP_DIR', ROOT_DIR .'core'.DIRECTORY_SEPARATOR);

//Configuration Path
define('CONFIG_DIR', APP_DIR .'config'.DIRECTORY_SEPARATOR);

//Installer Path
define('INSTALL_DIR', ROOT_DIR .'admin'.DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR);

//Date and Link
$date = date('jS F Y');
$ip = $_SERVER['REMOTE_ADDR'];

//Installer Links
if($_SERVER['PHP_SELF'] == '')
    $_SERVER['PHP_SELF'] = $_SERVER['REQUEST_URI'];
$mainLink = $adminLink = $themeLink = $installerLink = $processLink = $finishLink = '';
$adminLink = str_replace('install/install.php','',$_SERVER['PHP_SELF']);
$mainLink = str_replace('admin/install/install.php','',$_SERVER['PHP_SELF']);
$themeLink =  $adminLink.'theme/default/';
$installerLink = str_replace('install.php','',$_SERVER['PHP_SELF']);
$processLink = $installerLink.'process.php';
$finishLink = $installerLink.'finish.php';
$baseLink = urlencode($_SERVER["HTTP_HOST"]).$mainLink;
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>KOVATZ Scripts | Installer panel</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="<?php echo $themeLink; ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?php echo $themeLink; ?>dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />

    <link href="<?php echo $themeLink; ?>dist/css/skins/skin-blue.min.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
    #alert1{ display:none; }
    #alert2{ display:none; }
    #index_1{ display:none; }
    #index_2{ display:none; }
    #index_3{ display:none; }
    #pre_load{ display:none; }
    </style>  
  </head>

  <body class="skin-blue sidebar-mini">
    <div class="wrapper">

      <!-- Main Header -->
      <header class="main-header">

        <!-- Logo -->
        <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>C</b>T</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>KOVATZ</b>Scripts PK</span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <li>
                <a target="_blank" href="https://www.kovatz.com" title="PHP Scripts">Get more PHP script's</a>
              </li>
            </ul>
          </div>
        </nav>
      </header>
            <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <br />
          
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="<?php echo $themeLink; ?>dist/img/admin.jpg" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
              <p>Welcome </p>
              <!-- Status -->
              <p style="font-size:15px;"><a href="#">Admin!</a> </p>
            </div>
          </div>
          
          <!-- Sidebar Menu -->
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="active"><a href="<?php echo $_SERVER['PHP_SELF']; ?>"><i class='fa fa-gears'></i> <span>KOVATZ Scripts Installer</span></a></li>

          </ul><!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
      </aside>
      
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper" id="index">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <small>Installer panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-gears"></i> Admin</a></li>
            <li class="active">Script Installer </li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div id="index_0">  
               <div id="alert1">   
               <div class="alert alert-danger alert-dismissable">
                    <i class="fa fa-ban"></i>
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>
                    <b>Alert!</b> <span id="failMsg"></span>
                </div>
              </div>
              <div id="alert2">  
              <div class="alert alert-success alert-dismissable">
                <i class="fa fa-check"></i>
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>
                <b>Alert!</b> Database connection success.
              </div>  
              </div>
              
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Setup Requirements</h3>
                </div><!-- /.box-header -->

                <div class="box-body">

                <br />
                
                <table class="table table-hover">
                    <tbody><tr>
                        <th>#</th>
                        <th>Extension / Application</th>
                        <th>Status</th>
                    </tr>
                 <tr>
                        <td>1</td>
                        <td>PHP Version (Yours version <?php echo phpversion(); ?>) </td>
                        <?php   
                        if (strnatcmp(phpversion(),'5.4.0') >= 0){
                            echo '<td style="width: 200px;"><span class="label label-success">Available</span></td>';
                        }else {
                            echo '<td style="width: 200px;"><span class="label label-danger">Unavailable</span></td>';
                            $fa = '1';
                        }
                        ?>
                    </tr>
                    
                    <tr>
                        <td>2</td>
                        <td>Mysqli Extension</td>
                        <?php   
                        if(function_exists('mysqli_connect')){
                            echo '<td><span class="label label-success">Available</span></td>';
                        } else {
                            echo '<td><span class="label label-danger">Unavailable</span></td>';
                            $fa = '1';
                        }
                        ?>
                    </tr>
                    
                    <tr>
                        <td>3</td>
                        <td>Multibyte String (Mbstring)</td>
                        <?php   
                        if(extension_loaded('mbstring')){
                            echo '<td><span class="label label-success">Available</span></td>';
                        }else{
                            echo '<td><span class="label label-danger">Unavailable</span></td>';
                            $fa = '1';
                        }
                        ?>
                    </tr>
                    
                    <tr>
                        <td>4</td>
                        <td>file_get_contents()</td>
                        <?php   
                        if(ini_get('allow_url_fopen')){
                            echo '<td><span class="label label-success">Available</span></td>';
                        }else{
                            echo '<td><span class="label label-danger">Unavailable</span></td>';
                            $fa = '1';
                        }
                        ?>
                    </tr>
                    
                    <tr>
                        <td>5</td>
                        <td>PDO Extension</td>
                        <?php   
                        if(extension_loaded('pdo')){
                            echo '<td><span class="label label-success">Available</span></td>';
                        }else{
                            echo '<td><span class="label label-danger">Unavailable</span></td>';
                            $fa = '1';
                        }
                        ?>
                    </tr>
                    
                    <tr>
                        <td>6</td>
                        <td>WHOIS PORT - 43</td>
                        <?php   
                        if($pf = @fsockopen('whois.verisign-grs.com', 43 , $err, $err_string, 1)) {
                            echo '<td><span class="label label-success">Available</span></td>';
                            fclose($pf);
                        }else{
                            echo '<td><span class="label label-danger">Unavailable</span></td>';
                            $fa = '1';
                        }
                        ?>
                    </tr>
                    
                    <tr>
                        <td>7</td>
                        <td>GD Extension</td>
                        <?php   
                        if(extension_loaded('gd')){
                            echo '<td><span class="label label-success">Available</span></td>';
                        }else{
                            echo '<td><span class="label label-danger">Unavailable</span></td>';
                            $fa = '1';
                        }
                        ?>
                    </tr>
                    
                    <tr>
                        <td>8</td>
                        <td>CURL Extension</td>
                        <?php   
                        if(extension_loaded('curl')){
                            echo '<td><span class="label label-success">Available</span></td>';
                        }else{
                            echo '<td><span class="label label-danger">Unavailable</span></td>';
                            $fa = '1';
                        }
                        ?>
                    </tr>
                                        
                </tbody></table>
                                
                </div><!-- /.box-body -->
      
              </div><!-- /.box -->
              
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Directory & Permissions</h3>
                </div><!-- /.box-header -->

                <div class="box-body">
                                
                <table class="table table-hover">
                    <tbody>
                    <tr>
                        <th>#</th>
                        <th>File / Folder Name</th>
                        <th>Status</th>
                    </tr>               
                    <tr>
                       <td>1</td>
                       <td>DB Configuration File <small>("/core/config/db.config.php")</small></td>                  
                       <?php   
                        if (is_writable(CONFIG_DIR.'db.config.php')) {
                            echo '<td style="width: 200px;"><span class="label label-success">Writable</span></td>';
                        } else{
                            echo '<td style="width: 200px;"><span class="label label-danger">Not Writable</span></td>';
                            $fa = '1';
                        }
                        ?>                    
                    </tr>
                    
                    <tr>
                        <td>2</td>
                        <td>Uploads Directory  <small>("/uploads/")</small></td>
                        <?php   
                        if (is_writable(ROOT_DIR.'uploads')) {
                            echo '<td><span class="label label-success">Writable</span></td>';
                        } else {
                            echo '<td><span class="label label-danger">Not Writable</span></td>';
                                $fa = '1';
                        }
                        ?>
                    </tr>
                    
                    <tr>
                        <td>3</td>
                        <td>Temporary Directory  <small>("/core/temp/")</small></td>
                        <?php   
                        if (is_writable(APP_DIR.'temp')) {
                            echo '<td><span class="label label-success">Writable</span></td>';
                        } else {
                            echo '<td><span class="label label-danger">Not Writable</span></td>';
                                $fa = '1';
                        }
                        ?>
                    </tr>
                    
                    <tr>
                        <td>4</td>
                        <td>PDF Reports Cache Directory <small>("/resources/pdf-reports/")</small></td>
                        <?php   
                        if (is_writable(ROOT_DIR.'resources'.DIRECTORY_SEPARATOR.'pdf-reports')) {
                            echo '<td><span class="label label-success">Writable</span></td>';
                        } else {
                            echo '<td><span class="label label-danger">Not Writable</span></td>';
                                $fa = '1';
                        }
                        ?>
                    </tr>
                    
                    <tr>
                        <td>5</td>
                        <td>Snapshot Cache Directory <small>("/core/helpers/site_snapshot/")</small></td>
                        <?php   
                        if (is_writable(APP_DIR.'helpers'.DIRECTORY_SEPARATOR.'site_snapshot')) {
                            echo '<td><span class="label label-success">Writable</span></td>';
                        } else {
                            echo '<td><span class="label label-danger">Not Writable</span></td>';
                                $fa = '1';
                        }
                        ?>
                    </tr>
                    
                    <tr>
                        <td>6</td>
                        <td>Mobile Snapshot Cache Directory <small>("/core/helpers/mobile_preview/")</small></td>
                        <?php   
                        if (is_writable(APP_DIR.'helpers'.DIRECTORY_SEPARATOR.'mobile_preview')) {
                            echo '<td><span class="label label-success">Writable</span></td>';
                        } else {
                            echo '<td><span class="label label-danger">Not Writable</span></td>';
                                $fa = '1';
                        }
                        ?>
                    </tr>
                    
                </tbody></table>
                
                </div><!-- /.box-body -->
                   <div class="text-center box-footer"> 
                     <br /><br />   
                    <?php if(isset($fa)) { ?>
                          <button class="btn btn btn-success" disabled=""><i class="fa fa-paper-plane" aria-hidden="true"></i> &nbsp; Continue</button>
                    <?php } else { ?>                                      
                          <button class="btn btn btn-success" onclick="continueNextStage()"><i class="fa fa-paper-plane" aria-hidden="true"></i> &nbsp; Continue</button>
                     <?php } ?>  
                     <br /><br /> 
                    </div>
              </div><!-- /.box --> 

            </div>   
                                
        <div id="index_1">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Database Connection</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                    <div class="box-body">
                        <div class="form-group">
                            <label for="data_host">Database Host</label> &nbsp; <small>(Mostly "localhost")</small>
                            <input type="text" placeholder="Enter your database hostname" name="data_host" id="data_host" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="data_name">Database Name</label>
                            <input type="text" placeholder="Enter your database name" name="data_name" id="data_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="data_user">Database Username</label>
                            <input type="text" placeholder="Enter your database username" name="data_user" id="data_user" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="data_pass">Database Password</label>
                            <input type="password" placeholder="Enter your database password" name="data_pass" id="data_pass" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label for="data_pass">Website Path</label>
                            <input value="<?php echo urldecode($baseLink); ?>" type="text" placeholder="Enter your base path" name="data_domain" id="data_domain" class="form-control">
                        </div>
                                        
                               
                 <div class="box-header"> <br />
                    <h3 class="box-title">License Verification</h3>
                        </div><!-- /.box-header --> <br />
                    
                        <div class="form-group">
                            <label for="data_sec">Item Purchase Code &nbsp; <small><a target="_blank" href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-can-I-find-my-Purchase-Code-">(Where can I find my Purchase Code?)</a>  &nbsp; | &nbsp; <a target="_blank" href="https://www.kovatz.com">(For more Information)</a></small></label>
                            <input style="border-color: #DDDDDD;" type="text" placeholder="Enter your item purchase code" name="data_sec" id="data_sec" class="form-control">
                        </div>
                    </div><!-- /.box-body -->
                   <div class="box-footer">    
                       <?php if(isset($fa)) { ?>
                          <button class="btn btn btn-primary" disabled >Submit</button>
                    <?php } else { ?>                                      
                              <button class="btn btn btn-primary" onclick="loadXMLDoc()" >Submit</button>
                     <?php } ?>   
                    </div>

                    </div>  
       </div>  <div id="index_2">                
       <div class="box box-primary"><br />
            <div class="box-header">
                <h3 class="box-title">Admin Details</h3>  
            </div><!-- /.box-header --><br />
            <!-- form start -->
                <div class="box-body">
                
                   <div class="form-group">
                        <label for="admin_user">Admin Name</label>
                        <input type="text" placeholder="Enter admin name" name="admin_name" id="admin_name" class="form-control" />
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Admin User ID</label> <small>(Must be Email ID!)</small>
                        <input type="email" placeholder="Enter admin username" name="email" id="email" class="form-control" />
                    </div>
                    
                    <div class="form-group">
                        <label for="admin_pass">Admin Password</label>
                        <input type="password" placeholder="Enter admin password" name="admin_pass" id="admin_pass" class="form-control" />
                    </div>
                    
                </div><!-- /.box-body -->

                <div class="box-footer">   
                       <button class="btn btn btn-primary" onclick="findoc()" >Submit</button>
                </div>

        </div>
    </div>
         <div id="pre_load">
         
         <div class="box box-primary">


        <div class="box-body">
         <br /> 
         <br />      
         <div class="text-center">
          <img title="Loading" alt="Loading" src="<?php echo $themeLink; ?>dist/img/load.gif"/>
          <br /> <br />
          Installing.....  
          <br />
          <small>(Mostly takes few seconds)</small>
         </div>
         <br />
         <br /> 
         </div>
         </div>
       </div>
       
     <div id="index_3"> 
     <div class="box box-primary">


    <div class="box-body">
    <br /> 
    <p>Database Table Creation Log</p>
    <textarea readonly="" id="tableRes" rows="12" class="form-control"></textarea>
    <br /> 
    <p>Installation Complete! </p>
    <br />
    <p>Goto:</p>
    <a href="<?php echo $mainLink; ?>" class="btn btn-primary" >Visit Website</a>   <a href="<?php echo $adminLink; ?>" class="btn btn-danger">Admin Panel</a>
    <br />  
<p>Please keep it mind your admin login is yourwebsite.com/admin</p>
    </div>
              
                               
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->


     <!-- Main Footer -->
      <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
          Your Version v2.4
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2024 <a href="https://www.kovatz.com/">KOVATZ</a></strong> All rights reserved.
      </footer>

      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class='control-sidebar-bg'></div>
    </div><!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo $themeLink; ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?php echo $themeLink; ?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo $themeLink; ?>dist/js/app.min.js" type="text/javascript"></script>
    <script>
    function continueNextStage(){
        $("#index_0").hide();
        $("#index_1").show();
        setTimeout(function(){
		var pos = $('#index').offset();
		 $('body,html').animate({ scrollTop: pos.top });
		}, 100);
    }
    function loadXMLDoc()
    {
    var xmlhttp;
    var sql_host = $('input[name=data_host]').val();
    var sql_name = $('input[name=data_name]').val();
    var sql_user = $('input[name=data_user]').val();
    var sql_pass = $('input[name=data_pass]').val();
    var sql_sec = $('input[name=data_sec]').val();
    var data_domain = $('input[name=data_domain]').val();
    if(sql_host == ""){
        alert("Enter your database hostname!");
        return false;
    }
    if(sql_name == ''){
        alert("Enter your database name!");
        return false;
    }
    if(sql_user == ''){
        alert("Enter your database username!");
        return false;
    }
    if(sql_pass == ''){
        alert("Enter your database password!");
        return false;
    }
    if(sql_sec == ''){
        alert("Enter your item purchase code!");
        return false;
    }
    if (window.XMLHttpRequest)
      {// code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp=new XMLHttpRequest();
      }
    else
      {// code for IE6, IE5
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
    xmlhttp.onreadystatechange=function()
      {
      if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
        }
      }
    $.post("<?php echo $processLink; ?>", {data_host:sql_host,data_name:sql_name,data_user:sql_user,data_pass:sql_pass,data_sec:sql_sec,data_domain:data_domain}, function(results){
    if (results == 1) {
         $("#alert1").hide();
         $("#alert2").show();
         $("#index_1").hide();
         $("#index_2").show();
    }else{
         $("#failMsg").html(results)
         $("#alert1").show();
         $("#index_1").show();
         $("#index_2").hide();
         alert(results);
    }
    });
    }
    </script>   

    <script>
    function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
    return pattern.test(emailAddress);
    }
    function findoc()
    {
    var xmlhttp;
    var adminName = $('input[name=admin_name]').val();
    var user = $('input[name=email]').val();
    var pass = $('input[name=admin_pass]').val();
    if(adminName == ''){
        alert("Enter admin name!");
        return false;
    }
    if(user == ''){
        alert("Enter admin username!");
        return false;
    }
    if(pass == ''){
        alert("Enter admin password!");
        return false;
    }
    if( !isValidEmailAddress( user ) ) 
    { 
        alert("Your admin email id is not valid!");
        return false;
    }
    if (window.XMLHttpRequest)
      {// code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp=new XMLHttpRequest();
      }
    else
      {// code for IE6, IE5
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
    xmlhttp.onreadystatechange=function()
      {
      if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
        }
      }
    $("#alert1").hide();
    $("#alert2").hide();
    $("#index_1").hide();
    $("#index_2").hide();
    $("#pre_load").show();
    $.post("<?php echo $finishLink; ?>", {admin_name:adminName,admin_user:user,admin_pass:pass}, function(results){
         $("#index_3").show();
         results = results.replace(/<br *\/?>/gi, '\n');
         $("#tableRes").append(results);
         $("#pre_load").hide();
    });
    }
    </script>   
  

  </body>
</html>