<?php

defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: KOVATZ Seo Tools
 * @copyright � 2022 KOVATZ.COM
 *
 */

$pageTitle = 'Visitor Log';
$subTitle = 'Visitor Log';
$fullLayout = 1; $rainbowTrackAsif = ''; $footerAdd = true; $footerAddArr = array();

require_once(LIB_DIR.'geoip.inc');
$gi = geoip_open(LIB_DIR.'GeoIP.dat', GEOIP_MEMORY_CACHE);
$giv6 = geoip_open(LIB_DIR.'GeoIPv6.dat', GEOIP_MEMORY_CACHE);
$flagPath = ROOT_DIR.'resources'.D_S.'flags'.D_S.'default'.D_S.'24'.D_S;
$iconPath = ROOT_DIR.'resources'.D_S.'icons'.D_S;
$flagLink = $baseURL.'resources/flags/default/24/';
$iconLink = $baseURL.'resources/icons/';
$screenLink = $iconLink.'screen.png';
$loadingBar = $iconLink.'load.gif';

$date = date('Y-m-d');
$datas = array_reverse(getTrackRecords($date,$con));

foreach($datas as $ip => $ses){
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
            $pageData .= '<div class="pagesWell"><a target="_blank" href="'.$pageV[0].'">'.$pageV[0].'</a><br>
            Hits: '.$pageV[1].' <br>
            Last Visit: '.date('h:i:s A',$pageV[2]).'</div>
            ';
        }
        
        if($data['ref'] != 'Direct'){
            $data['ref'] = '<a hre="'.$data['ref'].'" target="_blank">'.getDomainName($data['ref']).'</a>';
        }
        
        if(strtolower($data['username']) == 'guest')
            $username = 'Guest Visitor';
        else
            $username = ucfirst($data['username']);
        $rainbowTrackAsif .= '
        <tr>
            <td>
            <img src="'.$coLink.'" alt="'.$userCountryCode.'" />  <strong class="b16">'.ucfirst($userCountry).'</strong><br><br>
            <strong>'.date('F jS Y h:i:s A',$data['time']).'</strong> <br>
            Username: '.$username.'<br>
            Page Views: '.$data['pageview'].'<br>
            IP: <span class="badge" style="background-color: '.rndFlatColor().' !important;">'.$ip.'</span><br><br>
            Entry: '.$data['ref'].'<br>
            </td>
            <td><img data-toggle="tooltip" data-placement="top" title="Operating System: '.$uaInfo['platform'].'" src="'.$osLink.'" alt="'.$uaInfo['platform'].'" />
            <img data-toggle="tooltip" data-placement="top" title="Browser: '.$uaInfo['browser'].' '.$uaInfo['version'].'" src="'.$browserLink.'" alt="'.$uaInfo['browser'].'" />
            <img data-toggle="tooltip" data-placement="top" title="Screen Resolution: '.$data['screen'].'" src="'.$screenLink.'" />
            </td>
            <td>'.$pageData.'</td>
        </tr>
        
        ';
    }
}

geoip_close($gi);
geoip_close($giv6);
?>