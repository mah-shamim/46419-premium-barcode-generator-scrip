<?php

defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: KOVATZ Seo Tools
 * @copyright � 2022 KOVATZ.COM
 *
 */

$pageTitle = 'Dashboard';
$subTitle = 'Dashboard';
$todayArr = $footerAddArr = $pageViewHistory = $pageViewDate = array(); $userHistoryData = ''; 
$today_page = $today_users_count = $today_visit = $onlineNow = 0; $footerAdd = $updater = true;
$fullLayout = 1; $newUsersData = $newsLink = $jsonData = $latestData = $pageViewData = $adminHistoryData = '';

//Load GEO Library
require_once(LIB_DIR.'geoip.inc');
$gi = geoip_open(LIB_DIR.'GeoIP.dat', GEOIP_MEMORY_CACHE);
$giv6 = geoip_open(LIB_DIR.'GeoIPv6.dat', GEOIP_MEMORY_CACHE);

//Icons
$flagPath = ROOT_DIR.'resources'.D_S.'flags'.D_S.'default'.D_S.'24'.D_S;
$iconPath = ROOT_DIR.'resources'.D_S.'icons'.D_S;
$flagLink = $baseURL.'resources/flags/default/24/';
$iconLink = $baseURL.'resources/icons/';

//Database Size
$query = "SELECT table_schema '$dbName', SUM(data_length + index_length) / 1024 / 1024 'db_size_in_mb' FROM information_schema.TABLES WHERE table_schema='$dbName' GROUP BY table_schema";
$result = mysqli_query($con, $query);
while ($row = mysqli_fetch_array($result)){
    $database_size = round(Trim($row['db_size_in_mb']), 1);
}

//Disk Size
$ds = disk_total_space("/");
$df = disk_free_space("/");

//Online Now
$onlineData = getOnlineUsers($con);
$onlineNow = $onlineData[0];

//Today Page / Unique View
$todayArr = getTodayViews($con);
$today_page = $todayArr['views'];
$today_visit = $todayArr['unique'];

//Today New Users
$result = mysqli_query($con, "SELECT * FROM users where date='".date('m/d/Y')."'");
while ($row = mysqli_fetch_array($result)){
    $today_users_count = $today_users_count + 1;
}

//Admin History
$result = mysqli_query($con, 'SELECT * FROM admin_history ORDER BY id DESC LIMIT 9');
while ($row = mysqli_fetch_array($result)){
    $adminCountryCode = $adminBrowser = $adminCountry = $version = '';    
    if(isValidIPv6($row['ip']))
        $adminCountryCode = geoip_country_code_by_addr_v6($giv6, $row['ip']);
    else
        $adminCountryCode = geoip_country_code_by_addr($gi, $row['ip']);        
    $adminCountry = country_code_to_country($adminCountryCode);
    $adminCountry = (!empty($adminCountry)) ? $adminCountry : 'Unknown';
    $adminBrowser = parse_user_agent($row['browser']);
    extract($adminBrowser);
    $adminBrowser = (!empty($browser)) ? $browser : 'Unknown';
    
    if(file_exists($flagPath.strtolower(Trim($adminCountry)).'.png'))
        $coLink = $flagLink.strtolower(Trim($adminCountry)).'.png';
    else
        $coLink = $flagLink.'unknown.png';

    if(file_exists($iconPath.strtolower($browser).'.png'))
        $browserLink = $iconLink.strtolower($browser).'.png';
    else
        $browserLink = $iconLink.'unknown.png';  
        
    $adminHistoryData .= '<tr>
        <td>'.$row['last_date'].'</td>
        <td><span class=\'badge bg-'.rndColor().'\'>'.$row['ip'].'</span></td>
        <td><img src="'.$coLink.'" alt="'.$adminCountryCode.'" /> '.ucfirst($adminCountry).'</td>
        <td><img data-toggle="tooltip" data-placement="top" title="Browser: '.$browser.' '.$version.'" src="'.$browserLink.'" alt="'.$browser.'" /> '.$browser.'</td>
    </tr>';
}

//Pageview History
$pageViewHistory = array_reverse(getTrackViews($con,7));
foreach($pageViewHistory as $dbDate => $dbArr){
    $dbDate = date('jS M', strtotime($dbDate));
    $pageViewData.= '{y: \''.$dbDate.'\', item1: '.$dbArr['unique'].', item2: '.$dbArr['views'].'},'.PHP_EOL;
    $pageViewDate[] = $dbDate;
}
$pageViewDate = array_reverse($pageViewDate);
$dateStr = makeJavascriptArray($pageViewDate).'[CountX]';

//Update Check & News Panel
$newsLink = 'http://api.KOVATZ.COM/tweb/latest-news.php';
$jsonData = simpleCurlGET($newsLink.'?link='.createLink('',true).'&code='.$item_purchase_code);
$latestData = json_decode($jsonData,true);

if($latestData['version'] == VER_NO)
    $updater = false;

//User History
$result = mysqli_query($con, 'SELECT * FROM users ORDER BY id DESC LIMIT 7');
while ($row = mysqli_fetch_array($result)){
    $userCountry =  $userCountryCode = '';  
      
    if(isValidIPv6($row['ip']))
        $userCountryCode = geoip_country_code_by_addr_v6($giv6, $row['ip']);
    else
        $userCountryCode = geoip_country_code_by_addr($gi, $row['ip']);    
    $userCountry = country_code_to_country($userCountryCode);
    $userCountry = (!empty($userCountry)) ? $userCountry : 'Unknown';

    if(file_exists($flagPath.strtolower(Trim($userCountry)).'.png'))
        $coLink = $flagLink.strtolower(Trim($userCountry)).'.png';
    else
        $coLink = $flagLink.'unknown.png';
    
    $row['added_date'] = date('jS M Y h:i:sA', strtotime($row['added_date']));    
    $newUsersData .= '<tr>
        <td>'.$row['username'].'</td>
        <td>'.$row['added_date'].'</td>
        <td><img src="'.$coLink.'" alt="'.$userCountryCode.'" /> '.ucfirst($userCountry).'</td>
    </tr>';
}

//Recent Access History    
$result = mysqli_query($con, 'SELECT * FROM recent_history ORDER BY id DESC LIMIT 7');
while ($row = mysqli_fetch_array($result)){
    $userCountry =  $userCountryCode = '';  
      
    if(isValidIPv6($row['visitor_ip']))
        $userCountryCode = geoip_country_code_by_addr_v6($giv6, $row['visitor_ip']);
    else
        $userCountryCode = geoip_country_code_by_addr($gi, $row['visitor_ip']);    
    $userCountry = country_code_to_country($userCountryCode);
    $userCountry = (!empty($userCountry)) ? $userCountry : 'Unknown';

    if(file_exists($flagPath.strtolower(Trim($userCountry)).'.png'))
        $coLink = $flagLink.strtolower(Trim($userCountry)).'.png';
    else
        $coLink = $flagLink.'unknown.png';
    
    $row['date'] = date('jS M Y', strtotime($row['date']));    
    $userHistoryData .= '<tr>
        <td style="color: '. rndFlatColor() .';">'.$row['domain_name'].'</td>
        <td>'.$row['username'].'</td>
        <td><img src="'.$coLink.'" alt="'.$userCountryCode.'" /> '.ucfirst($userCountry).'</td>
        <td>'.$row['date'].'</td>
    </tr>'; 
}

geoip_close($gi);
geoip_close($giv6);
?>