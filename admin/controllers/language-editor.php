<?php

defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: KOVATZ Seo Tools
 * @copyright 2022 KOVATZ.COM
 *
 */

$fullLayout = 1;
$pageTitle = 'Language Editor';
$subTitle = 'Available Languages';

if($pointOut == 'backup'){
    
    if(isset($args[0]))
        $code = $args[0];
    else
        die('Language code missing!');
        
    $langInfo = getSelectedLang($code,$con);
    $langDataRainbow = gzcompress(base64_encode(serialize(array($langInfo,getLangData($code,$con)))));   
    header('Content-Description: File Transfer');
    header('Content-Type: text/html; charset=UTF-8');
    header('Content-Length: ' . strlen($langDataRainbow));
    header('Content-disposition: attachment; filename='.$code.'.lbak');
    ob_clean();
    flush();
    echo $langDataRainbow;
    die();
}

if($pointOut == 'import'){
    $subTitle = 'Import Language File';
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $customStr = raino_trim($_POST['customStr']);
        $customStr = filter_var($customStr, FILTER_VALIDATE_BOOLEAN);
        
        $target_dir = ADMIN_DIR . "addons".D_S;
        $target_filename = basename($_FILES["langUpload"]["name"]);
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
        if ($_FILES["langUpload"]["size"] > 999500000)
        {
            $msg = errorMsgAdmin('Sorry, your file is too large.');
            $uploadSs = 0;
        } else {
            // Allow certain file formats
            if ($imageFileType != "lbak" && $imageFileType != "ldata"){
                $msg = errorMsgAdmin('Sorry, only LBAK and LDATA files are allowed.');
                $uploadSs = 0;
            }
        }
    
        // Check if $uploads is set to 0 by an error
        if (!$uploadSs == 0)
        {
            //No Error - Move the file to addon directory
            if (move_uploaded_file($_FILES["langUpload"]["tmp_name"], $target_file))
            {
                
                //Language File Path
                $file_path = $target_dir . $target_filename;
                
                $importData = unserialize(base64_decode(gzuncompress(getMyData($file_path))));
                
                $importLangInfo = $importData[0];
                $importLangData = $importData[1];
                $importLangInfo[2] = strtolower($importLangInfo[2]);
                
                if(is_array($importLangInfo) && is_array($importLangData)){
                    if(!isLangExists($importLangInfo[2],$con)){
                        addLang(array('2','',$importLangInfo[2],$importLangInfo[3],$importLangInfo[4],$importLangInfo[5],$importLangInfo[6]),$con);
                        
                        $langAsif = $importLangInfo[2];
                        
                        //Update Language Data
                        foreach($importLangData as $langCode=>$langVal){
                            if($customStr){
                                $langVal = escapeTrim($con,$langVal);
                                $query = "UPDATE lang SET $langAsif='$langVal' WHERE code='$langCode'";
                                mysqli_query($con,$query);
                            }else{
                                if(!check_str_contains($langCode,'CS')){
                                    $langVal = escapeTrim($con,$langVal);
                                    $query = "UPDATE lang SET $langAsif='$langVal' WHERE code='$langCode'";
                                    mysqli_query($con,$query);
                                }
                            }
                        }

                        $msg = successMsgAdmin('Language file was successfully imported');
                    }else{
                        $msg = errorMsgAdmin('Sorry, language already exist.');
                    }
                }else{
                    $msg = errorMsgAdmin('Language Data Error!');
                }
                
                //Delete the language file
                delFile($file_path);  

            } else {
                $msg = errorMsgAdmin('Sorry, there was an error uploading your file.');
            }
        }
    }
    
}

if($pointOut == 'status'){
    $status = false;
    if($args[0] == 'disable')
        $status = false;
    else
        $status = true;
    $code = $args[1];
    $defaultLang = getLang($con);
    if($code != $defaultLang){
        langStatusChange($code,$status,$con);
        header('Location:'.adminLink($controller,true));
        die();
    }else{
        $msg = errorMsgAdmin('Sorry, you can\'t able to disable default lang (Change default from here: Interface -> Interface Settings)');
    }
}

if($pointOut == 'delete'){
    if(isset($args[0]) && $args[0] != ''){
        $code = $args[0];
        $defaultLang = getLang($con);
        if($code != $defaultLang){
            removeLang($code,$con);
            header('Location:'.adminLink($controller,true));
            die();
        }else{
            $msg = errorMsgAdmin('Sorry, you can\'t able to disable default lang (Change default from here: Interface -> Interface Settings)');
        }
    }
}

if($pointOut == 'add'){
    $subTitle = 'Create New Language';
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $language_name = raino_trim($_POST['language_name']);
        $language_code = strtolower(raino_trim($_POST['language_code']));
        
        if(!isLangExists($language_code,$con)){
            $language_author = raino_trim($_POST['language_author']);
           // $sort_order = raino_trim($_POST['sort_order']);
            $status = raino_trim($_POST['status']);
            $text_direction = raino_trim($_POST['direction']);
            $hreflang = raino_trim($_POST['hreflang']);
            if($hreflang == '') $hreflang = $language_code;
            $status = filter_var($status, FILTER_VALIDATE_BOOLEAN);
            addLang(array('2','',$language_code,$language_name,$language_author,$status,$text_direction,$hreflang),$con);
            header('Location:'.adminLink($controller.'/edit/'.$language_code,true));
            die();
        }else{
            $msg = errorMsgAdmin('Sorry, language already exist.');
        }
    }
}

if($pointOut == 'add-custom-text'){
    $subTitle = 'Add New Custom String';
    $customNumber = getLastID($con,'lang') + 1;
    $customNumber = 'CS'.$customNumber;
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $csnumber = raino_trim($_POST['csnumber']);
        $default_string = raino_trim($_POST['default_string']);
        $query = "INSERT INTO lang (code,default_text) VALUES ('$csnumber','$default_string')";
        mysqli_query($con, $query);
        if($args[0] != '')
            header('Location:'.adminLink($controller.'/edit/'.$args[0],true));
        else
            header('Location:'.adminLink($controller,true));
        die();
        
    }
}

if($pointOut == 'edit'){
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        $language_name = escapeTrim($con,$_POST['language_name']);
        $language_code = strtolower(escapeTrim($con,$_POST['language_code']));
        $sort_order = escapeTrim($con,$_POST['sort_order']);
        $direction = escapeTrim($con,$_POST['direction']);
        $status = escapeTrim($con,$_POST['status']);
        $hreflang = escapeTrim($con,$_POST['hreflang']);
        if($hreflang == '') $hreflang = $language_code;
        $updateLangArr = array($sort_order,$language_code,$language_name,$status,$direction, $hreflang);
        $postCount = 1;

        //Update Language Data
        foreach($_POST as $langCode=>$langVal){
            if($postCount > 5){
                $langAsif = $args[0];
                $langVal = escapeTrim($con,$langVal);
                $query = "UPDATE lang SET $langAsif='$langVal' WHERE id='$langCode'";
                mysqli_query($con,$query);
            }
            $postCount++;
        }

        //Update General Settings
        $defaultLang = getLang($con);
        if($language_code != $defaultLang){
            langUpdateAll($args[0],$updateLangArr,$con);
            $msg = successMsgAdmin('Language data updated successfully.');
        }else{
            if(isSelected($status)) {
                langUpdateAll($args[0],$updateLangArr,$con);
                $msg = successMsgAdmin('Language data updated successfully.');
            }else{
                $msg = errorMsgAdmin('Sorry, you can\'t able to disable default lang (Change default from here: Interface -> Interface Settings)');
            }
        }
    }
    
    if($args[0] != ''){
       $subTitle = strtoupper($args[0]).' - Language Editor';
       $langCodes = $langDataArr = array();
       $langAsifCheck = false; 
       $code = 0;
       $langTable =  mysqli_query($con, "SELECT * FROM lang where id='1'");
       $langTableRow = mysqli_fetch_array($langTable,MYSQLI_ASSOC);
       
       foreach($langTableRow as $langTableCode => $langTableVal){
           if($code == 3)
                $langAsifCheck = true;
           if($langAsifCheck)
                $langCodes[] = $langTableCode;
           $code++;
       }
       if(in_array($args[0],$langCodes)){
           $langCodeData = mysqli_query($con, "SELECT id, code, default_text, $args[0] FROM lang");
           while($langCodeDataRow = mysqli_fetch_array($langCodeData,MYSQLI_NUM)) {
           $langDataArr[] = array($langCodeDataRow[0],$langCodeDataRow[1],$langCodeDataRow[2],$langCodeDataRow[3]);
           }
           $generalLangSet = getSelectedLang($args[0],$con);
       }else
        die('Language code not valid!');
       
    }else
        header('Location: '.adminLink($controller,true));
    
}else{
    $allLangs = getAllLang($con);
}