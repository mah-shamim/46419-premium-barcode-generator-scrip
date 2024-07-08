<?php

defined('BUILDER_CON') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: Tools
 * @copyright © 2022 
 *
 */

$pageTitle = 'Theme Settings';
$footerAdd = true; $to = array();
$page1 = $page2 = $page3 = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if(isset($_POST['page1'])){
        $page1 = 'active';
        $to = array_map_recursive(
            function($item) use ($con) { return escapeTrim($con,$item); },
            $_POST['to']
        );
        
        //Load theme settings
        $tempTo = getThemeOptionsDev($con,$themePathName);
        if(isset($tempTo['custom']['css']))
            $to['custom']['css'] = $tempTo['custom']['css'];
        else
            $to['custom']['css'] = '';
            
        $to['general']['logo'] = $tempTo['general']['logo'];
        $to['general']['favicon'] = $tempTo['general']['favicon'];

        if(isset($_FILES['logoUpload']) && $_FILES['logoUpload']['name'] != ''){
            $isUploaded = secureImageUpload($_FILES['logoUpload']);
            if($isUploaded[0])
                $to['general']['logo'] = $isUploaded[1];
            else
                $msg = errorMsgAdmin($isUploaded[1]);
        }
        if(isset($_FILES['favUpload']) && $_FILES['favUpload']['name'] != ''){
            $isUploaded = secureImageUpload($_FILES['favUpload'],500000,array('png','ico','gif'));
            if($isUploaded[0])
                $to['general']['favicon'] = $isUploaded[1];
            else
                $msg = errorMsgAdmin($isUploaded[1]);
        }
        if(isset($_POST['langSwitch']))
            $to['general']['langSwitch'] = true;
        else
            $to['general']['langSwitch'] = false;
        if(isset($_POST['sidebar']))
            $to['general']['sidebar'] = 'right';
        else
            $to['general']['sidebar'] = 'left'; 

        if(!isset($msg)){
           $themeStr = arrToDbStr($con,$to);
           $sqlQ = updateToDb($con,'themes_data',array($themePathName.'_theme' => $themeStr),array('id' => '1'));
           if($sqlQ)
             $msg = errorMsgAdmin($sqlQ);   
           else
            $msg = successMsgAdmin('Theme settings saved successfully');
        }
    }
    if(isset($_POST['page3'])){
       $page3 = 'active';
        
       //Load theme settings
       $to = getThemeOptionsDev($con,$themePathName);
       $to['custom']['css'] = escapeTrim($con,$_POST['to']['custom']['css']);
       $themeStr = arrToDbStr($con,$to);
       $sqlQ = updateToDb($con,'themes_data',array($themePathName.'_theme' => $themeStr),array('id' => '1'));
       if($sqlQ)
         $msg = errorMsgAdmin($sqlQ);   
       else
        $msg = successMsgAdmin('Theme settings saved successfully');

    }
}else{
    $page1 = 'active';
}

//Load theme settings
$to = getThemeOptionsDev($con,$themePathName);
?>