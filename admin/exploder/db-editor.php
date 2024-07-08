<?php
session_start();

//Application Path
define('ROOT_DIR', dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR);
define('APP_DIR', ROOT_DIR .'core'.DIRECTORY_SEPARATOR);
define('CONFIG_DIR', APP_DIR .'config'.DIRECTORY_SEPARATOR);
define('DB_DIR', realpath(dirname(__FILE__)) .DIRECTORY_SEPARATOR);
define('DB_PLG_DIR', DB_DIR .'plugins'.DIRECTORY_SEPARATOR);

//Load Configuration
require CONFIG_DIR.'config.php';

//Check Admin Access
if(!isset($_SESSION['twebAdminToken']))
    die('Admin Access Required!');

$scriptDbDetails =    array(
    $dbHost => array(
        'username'  => $dbUser,
        'pass'      => $dbPass,
        'label'     => 'MySQL',
        'databases' => array(
            $dbName => $dbName
        )
    )
);

function adminer_object() {
    include_once DB_PLG_DIR.'plugin.php';
    include_once DB_PLG_DIR.'oneclick-login.php';

    $plugins = array(
        new OneClickLogin($GLOBALS['scriptDbDetails'])
    );
    return new AdminerPlugin($plugins);
}
include DB_PLG_DIR.'db.php';