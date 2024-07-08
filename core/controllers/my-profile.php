<?php
defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: Rainbow PHP Framework
 * @copyright � 2022 KOVATZ.COM
 *
 */

$pageTitle = $lang['197'];
$des = $keyword = $countryCode = $country = $userCountry = $address2 = $company = '';

if(!isset($_SESSION['twebUsername'])){
  redirectTo(createLink('account/login',true));
  die();
}

//Get Username
$username = $_SESSION['twebUsername'];
$addInfo = false;
$errorCheckData = true;

require_once (LIB_DIR . 'geoip.inc');
$gi = geoip_open(LIB_DIR.'GeoIP.dat', GEOIP_MEMORY_CACHE);

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

       if(isset($_POST['password'])){
        
        $userPassData = getUserInfo($username,$con);
        $userOldPass = $userPassData['password'];
                    
        $new_pass = passwordHash(escapeTrim($con, $_POST['new_pass']));
        $retype_pass = passwordHash(escapeTrim($con, $_POST['retype_pass']));
        $old_pass = passwordHash(escapeTrim($con, $_POST['old_pass']));
        
        if($new_pass == $retype_pass){
            
        if($old_pass == $userOldPass){
        
        $res = updateToDbPrepared($con, 'users', array('password' => $new_pass), array('username' => $username));    
        if ($res)
            $msg = errorMsg(mysqli_error($con));
        else
            $msg = successMsg($lang['208']);
            
        }else{
            $msg = errorMsg($lang['209']);
        }
        }else{
            $msg = errorMsg($lang['210']);
        }
      }
      
      if(isset($_POST['user'])){
        
        $fullname = escapeTrim($con, $_POST['fullname']);
        $firstname = escapeTrim($con, $_POST['firstname']);
        $lastname = escapeTrim($con, $_POST['lastname']);
        $company = escapeTrim($con, $_POST['company']);
        $telephone = escapeTrim($con, $_POST['telephone']);
        $country = escapeTrim($con, $_POST['country']);
        $address1 = escapeTrim($con, $_POST['address1']);
        $address2 = escapeTrim($con, $_POST['address2']);
        $city = escapeTrim($con, $_POST['city']);
        $postcode = escapeTrim($con, $_POST['postcode']);
        $state = escapeTrim($con, $_POST['state']);
        $stateStr = escapeTrim($con, $_POST['statestr']);
        $userID = getUserID($username,$con);
        $nowDate = date('m/d/Y h:i:sA'); 
        
        if ($address1 != null && $city != null && $postcode != null && $state != null && $firstname != null && $telephone!=null && $country!= null){
            if($userID !== false){               
            
            $res = updateToDbPrepared($con, 'users', array(
                'full_name' => $fullname,
                'firstname' => $firstname, 
                'lastname' => $lastname, 
                'company' => $company, 
                'telephone' => $telephone, 
                'address1' => $address1, 
                'address2' => $address2, 
                'city' => $city, 
                'state' => $state, 
                'statestr' => $stateStr, 
                'postcode' => $postcode, 
                'country' => $country), array('id' => $userID));    
            
                if (!$res) {
                    $errorCheckData = false;
                    if($_FILES["logoUpload"]["name"] != ''){
                     
                        $target_dir = ROOT_DIR."uploads/users/";
                        $target_filename = basename($_FILES["logoUpload"]["name"]);
                        $uploadSs = 1;
                        $check = getimagesize($_FILES["logoUpload"]["tmp_name"]);
                        
                        // Check it is a image
                        if ($check !== false) {
                            // Check if file already exists
                            $target_filename = unqFile($target_dir,$target_filename);
                            $target_file = $target_dir . $target_filename;
                            
                            $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                            // Check file size
                            if ($_FILES["logoUpload"]["size"] > 500000) {
                                $msg = errorMsg($lang['211']);
                                $uploadSs = 0;
                            } else {
                                // Allow certain file formats
                                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType !=
                                    "jpeg" && $imageFileType != "gif"){
                                    $msg = errorMsg($lang['212']); 
                                    $uploadSs = 0;
                                }
                            }
                    
                            // Check if $uploadSs is set to 0 by an error
                            if (!$uploadSs == 0) {
                                if (move_uploaded_file($_FILES["logoUpload"]["tmp_name"], $target_file)) {
                                    //Uploaded
                                     $file_path = 'uploads/users/'.$target_filename;
                                     $query = "UPDATE users SET picture='$file_path' WHERE id='$userID'"; 
                                     mysqli_query($con,$query); 
                                } else {
                                    $msg = errorMsg($lang['213']);
                                }
                            }
                        } else {
                            $msg = errorMsg($lang['214']);
                        }
                    }else{
                        $errorCheckData = false;
                    }
                }
            }
        }
        
        if($errorCheckData){
            //Error
            if(!isset($msg))
                $msg = errorMsg($lang['AN10']);
        }else{
            //Fine
            if(!isset($msg))
                $msg = successMsg($lang['215']);
        }
      }
}

$userInfo = getUserInfo($username,$con);

if(Trim($userInfo['firstname']) != '')
   $addInfo = true;
    
$countryCode = $country;
$userCountry = geoip_country_name_by_addr($gi,$userInfo['ip']);
$country = country_code_to_country($country);

if($userCountry == ''){
    if(isset($country)){
        $userCountry = ucfirst($country);
    }else{
        $userCountry = $lang['216'];
    }
}

//Default Logo
$userDefaultLogo = $baseURL.'theme/default/img/user-default.png';

if($userInfo['picture'] == '' || strtolower($userInfo['picture']) == 'none' || $userInfo['picture'] == null)
    $userLogo = $userDefaultLogo;
else{
    if(!file_exists(ROOT_DIR.$userInfo['picture']))
        $userLogo = $userDefaultLogo;
    else
        $userLogo = $baseURL.$userInfo['picture'];
    
}

geoip_close($gi);
?>