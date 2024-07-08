<?php

/*
* @author MD ARIFUL HAQUE
* @name KOVATZ Seo Tools - PHP Script
* @copyright © 2022 KOVATZ.COM
*
*/
 
function getMyGeoInfo($ip,$item_purchase_code, $json=false){
    
    $domain = createLink('',true);
    $url = "http://api.KOVATZ.COM/tweb/ip.php?code=$item_purchase_code&ip=$ip&domain=$domain";
    $outData = curlGET($url);
    
    $city= explode('<div id="city">',$outData);
    $city = explode('</div>',$city[1]);
    $city = ucfirst($city[0]);
    $city = ($city == '' ? 'Not available' : $city);
    
    $region =  explode('<div id="region">',$outData);
    $region = explode('</div>',$region[1]);
    $region = ucfirst($region[0]);
    $region = ($region == '' ? 'Not available' : $region);
    
    $country_code = explode('<div id="country">',$outData);
    $country_code = explode('</div>',$country_code[1]);
    $country_code = strtoupper($country_code[0]);
    
    $isp = explode('<div id="isp">',$outData);
    $isp = explode('</div>',$isp[1]);
    $isp = ucfirst($isp[0]);
    $isp = ($isp == '' ? 'Not available' : $isp);
    
    $latitude = explode('<div id="latitude">',$outData);
    $latitude = explode('</div>',$latitude[1]);
    $latitude = $latitude[0];
    $latitude = ($latitude == '' ? 'Not available' : $latitude);
    
    $longitude = explode('<div id="longitude">',$outData);
    $longitude = explode('</div>',$longitude[1]);
    $longitude = $longitude[0];
    $longitude = ($longitude == '' ? 'Not available' : $longitude);
    
    $country = country_code_to_country(Trim($country_code));
    $country = ($country == '' ? 'Not available' : $country);
    $country_code = ($country_code == '' ? 'Not available' : $country_code);
    
    $geo_info = array($city,$region,$country,$country_code,$isp,$latitude,$longitude);
    
    if($json)
        return json_encode($geo_info);
    else
        return $geo_info;

}
?>