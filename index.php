<?php
session_start();
/**
 * @author MD ARIFUL HAQUE
 * @name: Rainbow PHP Framework
 * @copyright 2024 KOVATZ
 *
 */
//Application Path
define('ROOT_DIR', realpath(dirname(__FILE__)) .DIRECTORY_SEPARATOR);
define('APP_DIR', ROOT_DIR .'core'.DIRECTORY_SEPARATOR);
define('CONFIG_DIR', APP_DIR .'config'.DIRECTORY_SEPARATOR);

//Load Configuration & Functions
require CONFIG_DIR.'config.php';
require APP_DIR.'functions.php';

//Check installation
//detectInstaller();

//Database Connection
$con = dbConncet($dbHost,$dbUser,$dbPass,$dbName);

//Start the Application
require APP_DIR.'app.php';

//Theme & Output
require THEME_DIR.'header.php';
require THEME_DIR.VIEW.'.php';
require THEME_DIR.'footer.php';

//Close the database conncetion
mysqli_close($con);