<?php
defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @Theme: Default Style
 * @copyright 2024
 *
 */
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta http-equiv="Content-Language" content="<?php echo (ACTIVE_LANG); ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <link rel="icon" type="image/png" href="<?php echo $themeOptions['general']['favicon']; ?>" />

        <!-- Meta Data-->
        <title><?php echo $metaTitle; ?></title>
                
        <meta property="site_name" content="<?php echo $site_name; ?>"/>
        <meta name="description" content="<?php echo $des; ?>" />
        <meta name="keywords" content="<?php echo $keyword; ?>" />
        <meta name="author" content="Asif" />
        
        <!-- Open Graph -->
        <meta property="og:title" content="<?php echo $metaTitle; ?>" />
        <meta property="og:site_name" content="<?php echo $site_name; ?>" />
        <meta property="og:type" content="website" />
        <meta property="og:description" content="<?php echo $des; ?>" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Lora:400italic" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        
        <?php genCanonicalData($baseURL, $currentLink, $loadedLanguages, false, isSelected($themeOptions['general']['langSwitch'])); ?>

        <!-- Main style -->
        <link href="<?php themeLink('css/bootstrap.min.css'); ?>" rel="stylesheet" />
        
        <!-- Font-Awesome -->
        <link href="<?php themeLink('css/font-awesome.min.css'); ?>" rel="stylesheet" />
        
        <!-- Custom Theme style -->
        <link href="<?php themeLink('css/custom.css'); ?>" rel="stylesheet" type="text/css" />
        
        <?php if($isRTL) echo '<link href="'.themeLink('css/rtl.css',true).'" rel="stylesheet" type="text/css" />'; ?>
        
        <!-- jQuery 1.10.2 -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        
        <?php if($themeOptions['custom']['css'] != '') echo '<style>'.htmlPrint($themeOptions['custom']['css'],true).'</style>'; ?>
    </head>

<body data-spy="scroll" data-target="#scroll-menu" data-offset="50" id="top">  

<!-- mobile-nav -->
<nav class="mobile-nav">

	<ul class="main-nav">
        <?php 
            foreach($headerLinks as $headerLink)
            echo $headerLink[1];
        ?>
	</ul>
    

			
	<ul class="main-nav">
		<li class="wrapper-submenu">
            <?php if(isSelected($themeOptions['general']['langSwitch'])){ ?>
			<a href="javascript:void(0)"><?php echo strtoupper(ACTIVE_LANG); ?> <i class="fa fa-angle-down"></i></a>
			<div class="submenu">
				<ul class="submenu-nav">
                    <?php foreach($loadedLanguages as $language){
					      echo '<li><a href="'.$baseURL.$language[2].'">'.$language[3].'</a></li>';
                    }?>
				</ul>
				<span class="arrow"></span>
			</div>
            <?php } ?>
		</li>
	</ul>

	
</nav>


<div class="main-content">
    <!-- desktop-nav -->
    <div class="wrapper-header navbar-fixed-top">
	  	
		<div class="container main-header" id="header">
		
			<a href="<?php createLink(); ?>">
                <div class="logo">
                    <?php echo $themeOptions['general']['themeLogo']; ?>
                </div>
			</a>
            
            <a href="javascript:void(0)" class="start-mobile-nav"><span class="fa fa-bars"></span></a>	
          
			<nav class="desktop-nav">
			
				<ul class="main-nav">
                    <?php 
                        foreach($headerLinks as $headerLink)
                        echo $headerLink[1];
                    ?>
				</ul>
				
				<ul class="login-nav">
                    <?php if(isSelected($themeOptions['general']['langSwitch'])){ ?>
					<li class="dropdown">
						<a href="javascript:void(0)" data-toggle="dropdown" class="dropdown-toggle" aria-expanded="false"><i class="fa fa-globe fa-lg"></i></a>
						<ul class="dropdown-menu">
                            <?php foreach($loadedLanguages as $language){
							      echo '<li><a href="'.$baseURL.$language[2].'">'.$language[3].'</a></li>';
                            }?>
						</ul>
					</li>
					<li class="lang-li"><a><?php echo strtoupper(ACTIVE_LANG); ?></a></li>
                    <?php } ; ?>
				</ul>
				
			</nav>
			
		</div>		
	</div>
    
    
    
    
    
    
    <?php if($controller == CON_MAIN){ ?>
    
    
    
            
                
    

    <div class="tophero">
    
    
    <h1>Welcom To Our Online Web Tools Platform</h1>
    <center><b>Explore a diverse array of powerful and user-friendly tools designed to simplify your digital tasks.</b></center>
    
    
    
    </div>
    
    
  
    
    
  
    <?php } else { ?>
    <div class="bg-primary-color page-block"> 
    	<div class="container"> 
    		<h1 class="pageTitle text-center"><?php echo $pageTitle; ?></h1>
    	</div>
    </div>
    <?php } ?>
</div>