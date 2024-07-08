<?php
session_start();

/*
 * @author MD ARIFUL HAQUE
 * @name: Rainbow PHP Framework
 * @copyright 2022 KOVATZ
 *
 */
 
//Application Admin Path 
define('ADMIN_DIR', realpath(dirname(__FILE__)) .DIRECTORY_SEPARATOR);
define('ROOT_DIR', realpath(dirname(dirname(__FILE__))) .DIRECTORY_SEPARATOR);
define('APP_DIR', ROOT_DIR .'core'.DIRECTORY_SEPARATOR);
define('CONFIG_DIR', APP_DIR .'config'.DIRECTORY_SEPARATOR);
define('ADMIN_CON_DIR', ADMIN_DIR.'controllers'.DIRECTORY_SEPARATOR);

//Load Configuration
require CONFIG_DIR.'config.php';

//Admin Base URL
$adminBaseURL = $baseURL.ADMIN_PATH;

//Admin Theme Path
$admin_theme = 'default';
define('ADMIN_THEME_DIR', ADMIN_DIR.'theme' . DIRECTORY_SEPARATOR . $admin_theme . DIRECTORY_SEPARATOR);

if(isset($_GET['logout'])) {
    if(isset($_SESSION['twebAdminToken'])){
        unset($_SESSION['twebAdminToken']);
        unset($_SESSION['twebAdminID']);
    }
    session_destroy();
    session_start();
    session_regenerate_id();
    header('Location: '.$adminBaseURL);
    echo '<meta http-equiv="refresh" content="1;url='.$adminBaseURL.'">';
    exit();
}

//Load Functions
require APP_DIR.'functions.php';

//Database Connection
$con = dbConncet($dbHost,$dbUser,$dbPass,$dbName);

//Start the Application
require ADMIN_DIR.'app.php';

if($fullLayout){
    //Theme & Output
    require ADMIN_THEME_DIR.'header.php';
    require ADMIN_THEME_DIR.VIEW.'.php';
    require ADMIN_THEME_DIR.'footer.php';
}else{
    require ADMIN_THEME_DIR.VIEW.'.php';
}

//Close the database conncetion
mysqli_close($con);