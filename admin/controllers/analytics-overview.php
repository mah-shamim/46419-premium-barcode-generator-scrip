<?php

defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author Balaji
 * @name: Turbo Website Reviewer
 * @copyright © 2017 ProThemes.Biz
 *
 */

$fullLayout = 1; $footerAdd = true; $footerAddArr = array();
$pageTitle = 'Overview';
$subTitle = 'Analytics Overview';

$date = date('Y-m-d');
//$date = date('Y-m-d', strtotime('-9 days'));
$countryCodes = $browsersList = $platformList = $refererList = $pageList = $valRes = array();
$totalHit = $totalBrowser = $totalPlatform = 0;
$table1 = $table2 = $table3 = $table4 = $table5 = '';

require_once(LIB_DIR.'geoip.inc');
$gi = geoip_open(LIB_DIR.'GeoIP.dat', GEOIP_MEMORY_CACHE);
$giv6 = geoip_open(LIB_DIR.'GeoIPv6.dat', GEOIP_MEMORY_CACHE);
$flagPath = ROOT_DIR.'resources'.D_S.'flags'.D_S.'default'.D_S.'20'.D_S;
$iconPath = ROOT_DIR.'resources'.D_S.'icons'.D_S;
$flagLink = $baseURL.'resources/flags/default/20/';
$iconLink = $baseURL.'resources/icons/';
$screenLink = $iconLink.'screen.png';
$loadingBar = $iconLink.'load.gif';

$valRes = getTrackRecordsWithPageViews($date,$con);

$datas = array_reverse($valRes[1]);
foreach($datas as $ip => $ses){
    foreach($ses as $sesID => $data){
        
        if(isValidIPv6($ip))
            $userCountryCode = geoip_country_code_by_addr_v6($giv6, $ip);
        else
            $userCountryCode = geoip_country_code_by_addr($gi, $ip);
        
        $countryCodes[] = $userCountryCode;
        $uaInfo = parse_user_agent($data['ua']);
        $platformList[] = $uaInfo['platform'];
        $browsersList[] = $uaInfo['browser'];
        $refererList[] = $data['ref'];
        
        foreach($data['pages'] as $pageV){
            if(array_key_exists($pageV[0],$pageList))
                $pageV[1] = $pageList[$pageV[0]] + $pageV[1];
            $pageList[$pageV[0]] = $pageV[1];
        }
    }
}

$countryCodes = array_count_values($countryCodes);
arsort($countryCodes);
$totalHit = array_sum($countryCodes);

$browsersList  = array_count_values($browsersList);
arsort($browsersList);
$totalBrowser = array_sum($browsersList);

$platformList  = array_count_values($platformList);
arsort($platformList);
$totalPlatform = array_sum($platformList);

$refererList  = array_count_values($refererList);
arsort($refererList);
$totalReferer = array_sum($refererList);

arsort($pageList);
$totalPages = array_sum($pageList);

foreach($refererList as $referer=>$ses) {
    if($referer == 'Direct')
        $referer = '<td>(Direct)</td>';
    else
        $referer = '<td><a title="'.$referer.'" target="_blank" href="'.$referer.'">'.getDomainName($referer).'</a></td>';
    $table5 .= '
    <tr>
    '.$referer.'
    <td>'.$ses.'</td>
    <td>'.round(($ses/$totalReferer)*100,2).'%</td>
    </tr>
    ';
}

foreach($pageList as $page=>$views) {
    $table4 .= '
    <tr>
    <td><a target="_blank" href="'.$page.'">'.$page.'</a></td>
    <td>'.$views.'</td>
    <td>'.round(($views/$totalPages)*100,2).'%</td>
    </tr>
    ';
}

foreach($platformList as $platform=>$hits) {
    if(file_exists($iconPath.strtolower($platform).'.png'))
        $osLink = $iconLink.strtolower($platform).'.png';
    else
        $osLink = $iconLink.'unknown.png';
    $table3 .= '
    <tr>
    <td><img src="'.$osLink.'" alt="'.$platform.'" />  '.ucfirst($platform).'</td>
    <td>'.$hits.'</td>
    <td>'.round(($hits/$totalPlatform)*100,2).'%</td>
    </tr>
    ';
}

foreach($browsersList as $browser=>$hits) {
    if(file_exists($iconPath.strtolower($browser).'.png'))
        $browserLink = $iconLink.strtolower($browser).'.png';
    else
        $browserLink = $iconLink.'unknown.png';
    $table2 .= '
    <tr>
    <td><img src="'.$browserLink.'" alt="'.$browser.'" />  '.ucfirst($browser).'</td>
    <td>'.$hits.'</td>
    <td>'.round(($hits/$totalBrowser)*100,2).'%</td>
    </tr>
    ';
}

foreach($countryCodes as $userCountryCode=>$hits) {
    $userCountry = country_code_to_country($userCountryCode);
    $userCountry = ($userCountry == '') ? 'Unknown' : $userCountry;
    if(file_exists($flagPath.strtolower(Trim($userCountry)).'.png'))
        $coLink = $flagLink.strtolower(Trim($userCountry)).'.png';
    else
        $coLink = $flagLink.'unknown.png';
    $table1 .= '
    <tr>
    <td><img src="'.$coLink.'" alt="'.$userCountryCode.'" />  '.ucfirst($userCountry).'</td>
    <td>'.$hits.'</td>
    <td>'.round(($hits/$totalHit)*100,2).'%</td>
    </tr>
    ';
}


geoip_close($gi);
geoip_close($giv6);
?>