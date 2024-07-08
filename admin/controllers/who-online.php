<?php

defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: KOVATZ Seo Tools
 * @copyright � 2022 KOVATZ.COM
 *
 */

$pageTitle = 'Who\'s Online';
$subTitle = 'Active Users';
$fullLayout = 1; $onlineNow = 0; $rainbowTrackAsif = ''; $footerAdd = true; $footerAddArr = array();

$onlineData = getOnlineUsers($con);
$onlineNow = $onlineData[0];
$activeUsersInfo = $onlineData[1];

require_once(LIB_DIR.'geoip.inc');
$gi = geoip_open(LIB_DIR.'GeoIP.dat', GEOIP_MEMORY_CACHE);
$giv6 = geoip_open(LIB_DIR.'GeoIPv6.dat', GEOIP_MEMORY_CACHE);
$flagPath = ROOT_DIR.'resources'.D_S.'flags'.D_S.'default'.D_S.'20'.D_S;
$iconPath = ROOT_DIR.'resources'.D_S.'icons'.D_S;
$flagLink = $baseURL.'resources/flags/default/20/';
$iconLink = $baseURL.'resources/icons/';
$screenLink = $iconLink.'screen.png';
$loadingBar = $iconLink.'load.gif';

if(count($activeUsersInfo) != 0){
foreach($activeUsersInfo as $ip => $ses){
    foreach($ses as $sesID => $data){
        if(isValidIPv6($ip))
            $userCountryCode = geoip_country_code_by_addr_v6($giv6, $ip);
        else
            $userCountryCode = geoip_country_code_by_addr($gi, $ip);
        $userCountry = country_code_to_country($userCountryCode);
        $userCountry = ($userCountry == '') ? 'Unknown' : $userCountry;
        if(file_exists($flagPath.strtolower(Trim($userCountry)).'.png'))
            $coLink = $flagLink.strtolower(Trim($userCountry)).'.png';
        else
            $coLink = $flagLink.'unknown.png';
        $uaInfo = parse_user_agent($data['ua']);
        if(file_exists($iconPath.strtolower($uaInfo['platform']).'.png'))
            $osLink = $iconLink.strtolower($uaInfo['platform']).'.png';
        else
            $osLink = $iconLink.'unknown.png';
        if(file_exists($iconPath.strtolower($uaInfo['browser']).'.png'))
            $browserLink = $iconLink.strtolower($uaInfo['browser']).'.png';
        else
            $browserLink = $iconLink.'unknown.png';  
            
        $pageData = '';
        foreach($data['pages'] as $pageV){
            if($pageV[2] == $data['last_visit'])
            $pageData .= '<a target="_blank" href="'.$pageV[0].'">'.$pageV[0].'</a>';
        }
        
        if(strtolower($data['username']) == 'guest')
            $username = 'Guest';
        else
            $username = ucfirst($data['username']);
            
        if($data['ref'] != 'Direct'){
            $data['ref'] = '<a hre="'.$data['ref'].'" target="_blank">'.$data['ref'].'</a>';
        }
        
        $rainbowTrackAsif .= '
        <tr>
            <td>'.$ip.'</td>
            <td><img src="'.$coLink.'" alt="'.$userCountryCode.'" /> '.ucfirst($userCountry).'</td>
            <td>'.$username.'</td>
            <td><img data-toggle="tooltip" data-placement="top" title="Browser: '.$uaInfo['browser'].' '.$uaInfo['version'].'" src="'.$browserLink.'" alt="'.$uaInfo['browser'].'" /> '.$uaInfo['browser'].' '.$uaInfo['version'].'</td>
            <td>'.$pageData.'</td>
            <td>'.$data['ref'].'</td>
            <td>'.date('F jS Y h:i:s A',$data['last_visit']).'</td>
        </tr>
        
        ';
    }
}
}else{
    $rainbowTrackAsif .= '<tr><td class="hide"><td class="hide"><td class="hide"></td><td>No users online</td><td class="hide"><td class="hide"><td class="hide"></tr>';
}

geoip_close($gi);
geoip_close($giv6);

?>