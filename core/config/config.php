<?php
defined('ROOT_DIR') or die(header('HTTP/1.1 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: Rainbow PHP Framework
 * @copyright 2021 KOVATZ.Com
 *
 */
 
//System Default Error Reporting
error_reporting(1);
//error_reporting(E_ALL);
//ini_set("display_errors", "1");

//Database Configuration
require CONFIG_DIR.'db.config.php';

//Application Configuration
require CONFIG_DIR.'app.config.php';

//OS Directory Separator
define('D_S',DIRECTORY_SEPARATOR);

//Define Directories
define('CON_DIR',APP_DIR.'controllers'.D_S);
define('HEL_DIR',APP_DIR.'helpers'.D_S);
define('LIB_DIR',APP_DIR.'library'.D_S);
define('MOD_DIR',APP_DIR.'models'.D_S);
define('PLG_DIR',APP_DIR.'plugins'.D_S);
define('LOG_DIR',APP_DIR.'logs'.D_S);
define('ROU_DIR',APP_DIR.'routes'.D_S);
define('TMP_DIR',APP_DIR.'temp'.D_S);

//Secure Hash Code #61.92.103.92.101.100.103
define('HASH_CODE', md5($item_purchase_code));

//mod_rewrite
define("MOD_REWRITE", true);

//Language Translation
define("LANG_TRANS", true);

//Application Error Reporting
define("ERR_R", true);

//Error Reporting File
define("ERR_R_FILE", "error.tdata");

//Set System Default Error Reporting File
ini_set("error_log", LOG_DIR.ERR_R_FILE);

//Set Default Time Zone #List of Supported Timezones - http://php.net/manual/en/timezones.php
date_default_timezone_set('Asia/Dhaka');

//Custom Router
define("CUSTOM_ROUTE", true);

//Enable Plugin System
define('PLUG_SYS', false);

//CURL Settings
define('CURL_UA', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.141 Safari/537.36');
define('CURL_TIMEOUT', 30);
define('LOG_CURL_ERR', false);

//Outgoing Mail Settings
define('DEFAULT_FROM_ADDRESS','');
define('DEFAULT_FROM_NAME','');

//Admin Path
define('ADMIN_DIR_NAME','admin');
define('ADMIN_PATH',ADMIN_DIR_NAME.'/');

//Cloudflare Fix
if(isset($_SERVER['HTTP_CF_VISITOR'])){
    $visitor = json_decode($_SERVER['HTTP_CF_VISITOR']);
    if($visitor->scheme == 'https')
        $_SERVER["HTTPS"] = 'on';
}
if(isset($_SERVER['HTTP_CF_CONNECTING_IP']))
    $_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_CF_CONNECTING_IP'];

//HTTP Proxy Fix
if(isset($_SERVER['HTTP_HTTPS']))
    $_SERVER["HTTPS"] = $_SERVER['HTTP_HTTPS'];

if(isset($_SERVER['HTTP_X_FORWARDED_PROTO'])){
    if($_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
        $_SERVER["HTTPS"] = 'on';
}

//Fix HTTPS
if(isset($_SERVER["HTTPS"])){
    if($_SERVER["HTTPS"] === 'off')
        unset( $_SERVER["HTTPS"]);
}

//GZIP Fix
if(ini_get('zlib.output_compression'))
    header('Content-Encoding: gzip');

//Domain Host
$parseHost = explode('/',$baseURL);
$serverHost = $parseHost[0];
$subPath = str_replace($serverHost.'/','',$baseURL);

//Base URL
$protocol = isset($_SERVER["HTTPS"]) ? 'https://' : 'http://';
$www = (strpos($_SERVER['HTTP_HOST'], 'www.') === false) ? '' : 'www.';
$baseURL = $protocol.$www.$baseURL;
define('BASEURL',$baseURL);

//Active Link
$currentLink = $protocol.$www.$serverHost.$_SERVER["REQUEST_URI"];

//Hide PHP Version
header('X-Powered-By: Rainbow Framework');