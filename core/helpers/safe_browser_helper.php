<?php

/*
* @author MD ARIFUL HAQUE
* @name KOVATZ Seo Tools - PHP Script
* @copyright 2022 KOVATZ.COM
*
*/

define('SAFE_API_KEY', "AIzaSyDzLJL3bihm7si5GwCQGelqhMiQRdaNiFQ");
define('SAFE_CLIENT', 'checkURLapp');
define('SAFE_APP_VER', '1.0');

function get_data_safe($url, $post) {
    $ch=curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", 'Content-Length: ' . strlen($post)));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result=curl_exec($ch);
    return $result;
}

function send_response($input) {
    if (!empty($input)) {
        $urlToCheck = urlencode($input);

        $url = 'https://safebrowsing.googleapis.com/v4/threatMatches:find?key=' . SAFE_API_KEY;

        $postData = '{
    "client": {
     "clientId": "' . SAFE_CLIENT . '",
     "clientVersion": "' . SAFE_APP_VER . '"
    },
    "threatInfo": {
     "threatTypes":      ["THREAT_TYPE_UNSPECIFIED","MALWARE", "SOCIAL_ENGINEERING","UNWANTED_SOFTWARE","POTENTIALLY_HARMFUL_APPLICATION"],
     "platformTypes":    ["LINUX"],
     "threatEntryTypes": ["URL"],
     "threatEntries":    [
      {"url": "http://'.$urlToCheck.'"}
     ]
  }
}';
        $responseJson = get_data_safe($url, $postData);
        $response = json_decode($responseJson);

        if (property_exists($response, 'matches')) {
            return json_encode(array('status' => 200, 'checkedUrl' => $urlToCheck, 'message' => 'The website is blacklisted as "' . str_replace("_", " ", $response->matches[0]->threatType) . '".'));
        } else {
            return json_encode(array('status' => 204, 'checkedUrl' => $urlToCheck, 'message' => 'The website is not blacklisted and looks safe to use.'));
        }

    }else {
        return json_encode(array(
            'status' => 401, 'checkedUrl' => '', 'message' => 'Please enter URL.'));
    }
}

function safeBrowsing($site) {
    $checkMalware = send_response($site);
    $checkMalware = json_decode($checkMalware, true);
    $malwareStatus = $checkMalware['status'];
    return $malwareStatus;
}