<?php

/*
* @author MD ARIFUL HAQUE
* @name KOVATZ Seo Tools - PHP Script
* @copyright 2022 KOVATZ.COM
*
*/

function pageSpeedInsightChecker($url,$type='desktop',$screenshot=false){
    
    $pageSpeedInsightUrl = $desktopUrl = $mobileUrl = $score = $jsonData = '';
    
    if(isset($GLOBALS['con'])){
        $db = reviewerSettings($GLOBALS['con']);
        $apiKey = urldecode($db['insights_api']);
    }else{
        $apiKey = urldecode('AIzaSyB921qf7VUO-mlqlmRQVASImxS5nWgvaUg');
    }
    
    $url = urldecode($url);
    
    if($screenshot)
        $screenshot = 'true';
    else
        $screenshot = 'false';
    
    $mobileUrl = 'https://www.googleapis.com/pagespeedonline/v5/runPagespeed?key='.$apiKey.'&screenshot='.$screenshot.'&snapshots='.$screenshot.'&locale=en_US&url='.$url.'&strategy=mobile';
    
    $desktopUrl = 'https://www.googleapis.com/pagespeedonline/v5/runPagespeed?key='.$apiKey.'&screenshot='.$screenshot.'&snapshots='.$screenshot.'&locale=en_US&url='.$url.'&strategy=desktop';
    
    if($type === 'desktop')
        $pageSpeedInsightUrl = $desktopUrl;
    else if($type === 'mobile')
        $pageSpeedInsightUrl = $mobileUrl;
    else
        stop('Unkown Page Speed Insight Checker Error!');

    $jsonData = curlGET($pageSpeedInsightUrl);

    if($jsonData != '') {
        $arr = json_decode($jsonData, true);

        if (isset($arr['lighthouseResult']['categories']['performance']['score']))
            return $arr['lighthouseResult']['categories']['performance']['score'] * 100;
    }
    return 0;

}