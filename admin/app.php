<?php
defined('APP_NAME') or die(header('HTTP/1.1 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: Rainbow PHP Framework
 * @copyright 2021 KOVATZ
 *
 */

//Current Date & User IP
$date = date('jS F Y');
$ip = getUserIP();
$browser = escapeTrim($con,getUA());

//Application Level DDoS Check
$siteInfo =  mysqli_query($con, "SELECT other_settings FROM site_info where id=1");
$siteInfoRow = mysqli_fetch_array($siteInfo);
$other = dbStrToArr($siteInfoRow['other_settings']);

if(filter_var($other['other']['ddos'], FILTER_VALIDATE_BOOLEAN))
    ddosCheck($con,$ip, intval($other['other']['ddosLimit']));

//Interface Settings
$interfaceSettings = getInterfaceSettings($con);
define('DEFAULT_LANG', $interfaceSettings['lang']);
define('DEFAULT_THEME', $interfaceSettings['theme']);

//Theme Settings
$theme_path = $adminBaseURL.'theme' . '/' . $admin_theme . '/';
define('THEMEURL', $theme_path);
$fullLayout = 0;

if(isset($_SESSION['twebAdminToken'])){
    
    $adminID = $_SESSION['twebAdminID'];
    $row = mysqliPreparedQuery($con, "SELECT user,pass,admin_name,admin_logo FROM admin where id=?", 's', array($adminID));
    $adminUser =  Trim($row['user']);
    $adminPssword = Trim($row['pass']);
    $adminName =   Trim($row['admin_name']);
    $adminLogo =   Trim($row['admin_logo']);
    $admin_logo_path = createLink($adminLogo,true);
    
    $last_id = getLastID($con,'admin_history');
    $row = mysqliPreparedQuery($con, "SELECT ip,last_date FROM admin_history where id=?", 's', array($last_id));
    $last_date =  $row['last_date'];
    $last_ip =  $row['ip'];
    
    $logAdmin = false;
    if($last_ip == $ip) {
        if($last_date != $date)
            $logAdmin = true;
    } else 
        $logAdmin = true;
    
    if($logAdmin)
        insertToDbPrepared($con, 'admin_history', array('last_date' => $date,'ip' => $ip,'browser' => $browser));  

//Load Language
$defaultLang = DEFAULT_LANG;
define('ACTIVE_LANG',$defaultLang);
$lang = getLangData($defaultLang,$con);  

$controller = $route = $pointOut = null;
$args = $custom_route = array(); 

if(isset($_GET['route'])) {
    $route = escapeTrim($con,$_GET['route']); 
    $route = explode('/',$route);
    $controller = $route[0];
    if(isset($route[1]))
        $pointOut = $route[1];
    $args = array_slice($route, 2);
    $argWithPointOut = array_slice($route, 1);
    if(trim($controller) == '')
       $controller = 'dashboard';
}else{
    $controller = 'dashboard';  
}
}else{
    $controller = 'login';  
}

//Create Link
$baseLink = createLink('',true);

$path = ADMIN_CON_DIR . $controller . '.php';
   	if(file_exists($path)){
        require($path);
	} else {
        $controller = "error";
        require(ADMIN_CON_DIR. $controller . '.php');
	}

define('VIEW', $controller);
