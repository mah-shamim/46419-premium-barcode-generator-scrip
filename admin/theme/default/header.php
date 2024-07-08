<?php
defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: Tools
 * @copyright © 2024 KOVATZ
 *
 */
 
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/png" href="<?php themeLink('dist/img/favicon.png'); ?>" />
    <title><?php echo $pageTitle .' | '. APP_NAME; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport' />
    <!-- Bootstrap 3.3.4 -->
    <link href="<?php themeLink('bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- Morris chart -->
    <link href="<?php themeLink('plugins/morris/morris.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- DATA TABLES -->
    <link href="<?php themeLink('plugins/datatables/dataTables.bootstrap.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- daterange picker -->
    <link href="<?php themeLink('plugins/daterangepicker/daterangepicker.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- colorpicker -->
    <link href="<?php themeLink('plugins/colorpicker/bootstrap-colorpicker.min.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?php themeLink('dist/css/AdminLTE.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php themeLink('dist/css/custom.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php themeLink('dist/css/skins/skin-black.min.css'); ?>" rel="stylesheet" type="text/css" />
    
    <!-- iCheck -->
    <link href="<?php themeLink('plugins/iCheck/square/grey.css'); ?>" rel="stylesheet" type="text/css" />
     
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php themeLink('plugins/select2/select2.min.css'); ?>" />
    
    <!-- jQuery 2.1.4 -->
    <?php scriptLink('plugins/jQuery/jQuery-2.1.4.min.js'); ?>
    
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body class="skin-blue sidebar-mini">
    <div class="wrapper">

      <!-- Main Header -->
      <header class="main-header">

        <!-- Logo -->
        <a href="<?php adminLink(); ?>" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>C</b>T</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">KOVATZ</span>
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

              <!-- User Account Menu -->
              <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="<?php adminLink('admin-accs'); ?>" >
                  <!-- The user image in the navbar-->
                  <img src="<?php echo $admin_logo_path; ?>" class="user-image" alt="User Image"/>
                  <!-- hidden-xs hides the username on small devices so only the image appears. -->
                  <span class="hidden-xs"><?php echo $adminName; ?></span>
                </a>

              </li>
              <!-- Control Sidebar Toggle Button -->
              <li>
                <a href="<?php createLink(); ?>" title="View Site" target="_blank"><i class="glyphicon glyphicon-globe"></i></a>
              </li>
              <li>
                <a href="<?php adminLink('?logout'); ?>" title="Logout"><i class="glyphicon glyphicon-off"></i></a>
              </li>
            </ul>
          </div>
        </nav>
      </header>
            <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

          <!-- Sidebar user panel (optional) -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="<?php echo $admin_logo_path; ?>" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
              <p>Welcome </p>
              <!-- Status -->
              <p style="font-size:15px;"><a href="#"><?php echo $adminName; ?>!</a> </p>
            </div>
          </div>

          <!-- Sidebar Menu -->
          <ul class="sidebar-menu">
            <!-- Optionally, you can add icons to the links -->
            <?php 
            define('ADMIN_LINKS',true);
            require ADMIN_CON_DIR.'links.php';
            ksort($menuBarLinks);
            foreach($menuBarLinks as $menuBarLink){
                $isActive = $subMenuLinkData = '';
                $subMenuConNames = array();
                if($menuBarLink[0]){
                    if(isset($menuBarLink[4])){
                        foreach($menuBarLink[4] as $subMenuLink){
                            $subMenuLinkData .= '<li><a href="'.$adminBaseURL.$subMenuLink[1].'"><i class="'.$subMenuLink[2].'"></i>'.$subMenuLink[0].'</a></li>';
                            $subMenuConNames[] = $subMenuLink[1];
                        }
                        if (in_array($controller,$subMenuConNames)) $isActive = 'active';
                        echo '<li class="treeview '.$isActive.'">
                          <a href="#"><i class="'.$menuBarLink[3].'"></i> <span> '.$menuBarLink[1].'</span> <i class="fa fa-angle-left pull-right"></i></a>
                          <ul class="treeview-menu">
                              '.$subMenuLinkData.'
                          </ul>
                        </li>';
                    } else {
                        if($controller == $menuBarLink[2]) $isActive = 'active';
                        if($menuBarLink[2] == 'dashboard') $menuBarLink[2] = '';
                        if($menuBarLink[2] == 'header-li')
                            echo '<li class="header">'.$menuBarLink[1].'</li>';
                        else
                            echo '<li class="'.$isActive.'"><a href="'.$adminBaseURL.$menuBarLink[2].'"><i class="'.$menuBarLink[3].'"></i> <span> '.$menuBarLink[1].'</span></a></li>';
                    }   
                }
            }
            ?>
          </ul><!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
      </aside>