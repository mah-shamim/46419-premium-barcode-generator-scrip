<?php

defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
* @author MD ARIFUL HAQUE
* @name: Rainbow PHP Framework
* @copyright © 2022 KOVATZ.COM
*
*/

$activeTheme = getTheme($con);

$pageTitle = "Manage Addons";
$subTitle = "Install Add-on";
$fullLayout = 1; $footerAdd = false;

$addonDir = ADMIN_DIR.'addons';

//Check Htaccess File
//if(!file_exists($addonDir.D_S.'.htaccess')) copy(APP_DIR.'data'.D_S.'htaccessAddon.tdata', $addonDir.D_S.'.htaccess');

$minError = false;
if(!class_exists('ZipArchive')){
    $minError = true;
    $minMsg[] = array('ZipArchive Extension','<span class="label label-danger">Not Found</span>'); 
}else{
    $minMsg[] = array('ZipArchive Extension','<span class="label label-success">Found</span>'); 
}

if (is_writable($addonDir)) {
    $minMsg[] = array('Directory - "<b>/admin/addons</b>"','<span class="label label-success">Writable</span>'); 
} else {
    $minError = true;
    $minMsg[] = array('Directory - "<b>/admin/addons</b>"','<span class="label label-danger">Not Writable</span>'); 
}

//Install Addon
if (isset($_POST['addonID']))
{
    $target_dir = ADMIN_DIR . "addons/";
    $target_filename = basename($_FILES["addonUpload"]["name"]);
    $target_file = $target_dir . $target_filename;
    $uploadSs = 1;
    // Check if file already exists
    if (file_exists($target_file))
    {
        $target_filename = rand(1, 99999) . "_" . $target_filename;
        $target_file = $target_dir . $target_filename;
    }
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
    // Check file size
    if ($_FILES["addonUpload"]["size"] > 999500000){
        $msg = errorMsgAdmin('Sorry, your file is too large.');
        $uploadSs = 0;
    } else
    {
        // Allow certain file formats
        if ($imageFileType != "zip" && $imageFileType != "zipx" && $imageFileType != "addonpk")
        {
            $msg = errorMsgAdmin('Sorry, only ZIP, ZIPX and ADDONPK files are allowed.');
            $uploadSs = 0;
        }
    }

    // Check if $uploads is set to 0 by an error
    if (!$uploadSs == 0)
    {
        //No Error - Move the file to addon directory
        if (move_uploaded_file($_FILES["addonUpload"]["tmp_name"], $target_file))
        {
            $msg = successMsgAdmin('Adddon was successfully uploaded');
            
            //Package File Path
            $file_path = $target_dir . $target_filename;
            
            //Temporarily extract Addons Data
            $addon_path = ADMIN_DIR . "addons/" . "ad_" . rand(1000, 999999);
            extractZip($file_path, $addon_path);
            
            //Check Addons Installer is exists 
            if (file_exists($addon_path . "/tweb.tdata")){
                if (file_exists($addon_path . "/install.php"))
                {
                    //Found - Process Installer
                    require_once ($addon_path . "/install.php");
                    
                    if($activeTheme != 'default' && $activeTheme != 'simpleX'){
                        $addonRes.= "Copying Theme Files to $activeTheme<br>";
                        recurse_copy($addon_path."/theme/default",ROOT_DIR."/theme/$activeTheme");
                    }
                }else{
                    //Not Found
                    $addonRes = "Addons Installer is not detected!";
                    $addonError = true;
                    $errType = 1;
                }
            }else{
                //Not Found
                $addonRes = "Not compatible add-on!";
                $addonError = true;
                $errType = 1; 
            }
            $addonRes = str_replace(array("<br>","<br/>","<br />"),PHP_EOL,$addonRes);
            //Delete the Addons Data
            delDir($addon_path);
            
            //Delete the package file
            delFile($file_path);
            $controller = "process-addon";

        } else{
            $msg = errorMsgAdmin('Sorry, there was an error uploading your file.');
        }
    }
}

?>