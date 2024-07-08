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

//Load Configuration & Functions
require CONFIG_DIR.'config.php';
require APP_DIR.'functions.php';

//Database Connection
$con = dbConncet($dbHost,$dbUser,$dbPass,$dbName);

$resDa = mysqli_query($con,"SHOW TABLES LIKE 'site_info'");
if(mysqli_num_rows($resDa) > 0) {
    echo 'Error! Already tables exists on database! <br />';
    die();
}

echo 'Installing database tables and queries <br />';

$completed = true;

$completed = installMySQLdb($con, INSTALL_DIR.'twebinstall.sql');

$admin_user = escapeTrim($con, $_POST['admin_user']);
$admin_pass = passwordHash(escapeTrim($con, $_POST['admin_pass']));
$admin_name = escapeTrim($con, $_POST['admin_name']);
$admin_reg_date = date('jS F Y');
$admin_reg_ip = $_SERVER['REMOTE_ADDR'];

if(insertToDbPrepared($con, 'admin', array(
    'user' => $admin_user, 
    'pass' => $admin_pass, 
    'admin_name' => $admin_name, 
    'admin_logo' => 'admin/theme/default/dist/img/admin.jpg', 
    'admin_reg_date' => $admin_reg_date, 
    'admin_reg_ip' => $admin_reg_ip
))){
    echo 'Error creating administrator record <br />';
    $completed = false;
}

if($completed)
    echo 'Installation Completed!';  
else
    echo 'Installation Completed with Errors!';  

if($completed){
//Clear the Installer Files
    unlink(INSTALL_DIR.'install.php');
    unlink(INSTALL_DIR.'process.php');
    unlink(INSTALL_DIR.'finish.php');
    unlink(INSTALL_DIR.'twebinstall.sql');
    
    if(file_exists(INSTALL_DIR.'install.php'))
        echo '<br /> Alert: Unable to delete installation files.<br /> 
        Manually delete installation folder ("/admin/install/") before accessing your site.';
}
die();
?>