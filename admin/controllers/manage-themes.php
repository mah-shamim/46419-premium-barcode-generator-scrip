<?php

defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: Tools
 * @copyright 2024
 *
 */

$pageTitle = 'Manage Themes';
$subTitle = 'All Themes';
$defaultTheme = getTheme($con);
$fullLayout = 1; $footerAdd = false; $footerAddArr = array();

if($pointOut === 'success')
    $msg = successMsgAdmin('Selected theme applied successfully.');

if($pointOut === 'failed')
    $msg = successMsgAdmin('Something went wrong!');

if($pointOut === 'clone') {

    $subTitle = 'Clone Theme';

    if (isset($args[0]) && $args[0] != '') {

        $themeDir = ROOT_DIR.'theme'.D_S.$args[0];

        $themeDetails = array();

        if (is_dir($themeDir)) {
            $themeDetailsFile = $themeDir . D_S . 'themeDetails.xml';
            if (file_exists($themeDetailsFile)) {
                $themeDetailsXML = simplexml_load_file($themeDetailsFile, "SimpleXMLElement", LIBXML_NOCDATA);
                $themeDetails = json_decode(json_encode($themeDetailsXML), true);
                if (isset($themeDetails['@attributes']['compatibility'])) {
                    if ($themeDetails['@attributes']['compatibility'] == '1.0') {
                        if (isset($themeDetails['themeDetails']))
                            $themeDetails = $themeDetails['themeDetails'];
                    }
                }
            }
        }

        $srcTheme = explode('/',$themeDetails['builder']);
        $srcTheme = $srcTheme[count($srcTheme) - 1];

        $builderControllers = ADMIN_CON_DIR.'builder';
        $builderTheme = ADMIN_THEME_DIR.'builder';
        $themePath = ROOT_DIR.'theme';

        $minMsg = array();
        $minError = false;
        if (is_writable($builderControllers)) {
            $minMsg[] = array('"/admin/controllers/builder/"','<span class="label label-success">Writable</span>');
        } else {
            $minError = true;
            $minMsg[] = array('"/admin/controllers/builder/"','<span class="label label-danger">Not Writable</span>');
        }
        if (is_writable($builderTheme)) {
            $minMsg[] = array('"/admin/theme/default/builder/"','<span class="label label-success">Writable</span>');
        } else {
            $minError = true;
            $minMsg[] = array('"/admin/theme/default/builder/"','<span class="label label-danger">Not Writable</span>');
        }
        if (is_writable($themePath)) {
            $minMsg[] = array('"/theme/"','<span class="label label-success">Writable</span>');
        } else {
            $minError = true;
            $minMsg[] = array('"/theme/"','<span class="label label-danger">Not Writable</span>');
        }


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $log = array();
            $myValues = array_map_recursive(function ($item) use ($con) {
                return escapeTrim($con, $item);
            }, $_POST['theme']);

            $myValues['dir'] = mb_strtolower($myValues['dir']);

            $cloneThemePath = $themePath. D_S . $myValues['dir'];
            $cloneThemeBaseName = themeBaseName($myValues['name']);

if (is_writable($cloneThemePath) || mkdir($cloneThemePath, 0755)) {
  chmod($cloneThemePath, 0755);
                //Copy Theme Files
                themeCopyFiles($themeDir, $cloneThemePath);

                //Copy Theme Builder Files
                if(!copy($builderControllers.D_S.$srcTheme.'.php',$builderControllers.D_S.$cloneThemeBaseName.'.php'))
                    $log[] = "Copy Failed: ".$builderControllers.D_S.$cloneThemeBaseName.'.php'.PHP_EOL;

                if(!copy($builderTheme.D_S.$srcTheme.'.php',$builderTheme.D_S.$cloneThemeBaseName.'.php'))
                    $log[] = "Copy Failed: ".$builderTheme.D_S.$cloneThemeBaseName.'.php'.PHP_EOL;

                //Update Theme Details
                $themeDetailsXMLFile = $cloneThemePath .D_S.'themeDetails.xml';
                $themeDetailsXML = simplexml_load_file($themeDetailsXMLFile, "SimpleXMLElement", LIBXML_NOCDATA);
                $themeDetailsXML->themeDetails->name = $myValues['name'];
                $themeDetailsXML->themeDetails->themeBaseName = $cloneThemeBaseName;
                $themeDetailsXML->themeDetails->description = $myValues['des'];
                $themeDetailsXML->themeDetails->author = $myValues['author'];
                $themeDetailsXML->themeDetails->authorEmail = $myValues['email'];
                $themeDetailsXML->themeDetails->authorWebsite = $myValues['link'];
                $themeDetailsXML->themeDetails->copyright = $myValues['copy'];
                $themeDetailsXML->themeDetails->builder = 'builder/client/'.$myValues['dir'].'/'.$cloneThemeBaseName;
                $themeDetailsXML->asXML($themeDetailsXMLFile);

                //Create theme database
                $colName = $myValues['dir'].'_theme';
                $oldColName = $args[0].'_theme';
                if (mysqli_query($con, "ALTER TABLE themes_data ADD $colName BLOB")) {
                    if(mysqli_query($con, "UPDATE themes_data SET $colName = CAST($oldColName AS CHAR)")){
                        $log[] = "Completed!".PHP_EOL;
                    }else{
                        $log[] = "Cloning template database settings are failed!". PHP_EOL;
                    }
                }else{
                    $log[] = "Creating database column failed!".PHP_EOL;
                }

            }else{
                $log[] = 'The directory "' . $cloneThemePath . '" isn\'t writable.';
            }

            $logData = '';
            foreach($log as $line)
                $logData .= $line;
        }

    }else{
        header('Location:'.adminLink($controller,true));
        die();
    }
}

function themeBaseName($name){
    $name = mb_strtolower($name);
    return str_replace(array('~','!','@','#','$','%','^','&','.','"','*','(',')','_', ' ', '|', '{', '}', '<', '>', '?', ';', ':', "'", '=','+'),'-',$name);
}

function themeCopyFiles($src,$dst) {
    $dir = opendir($src);
    if(!is_writable($dst))
        @mkdir($dst);
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
            if ( is_dir($src . '/' . $file) ) {
                themeCopyFiles($src . '/' . $file,$dst . '/' . $file);
            } else {
                if(!copy($src . '/' . $file,$dst . '/' . $file)){
                    $GLOBALS['log'][] = "Copy Failed: ".$dst . '/' . $file.PHP_EOL;
                }
            }
        }
    }
    closedir($dir);
}