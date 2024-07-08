<?php

/*
* @author MD ARIFUL HAQUE
* @name AtoZ SEO Tools v2
* @copyright 2022 KOVATZ.COM
*
*/

function alexaRank($site){

    $apiData = simpleCurlGET('https://data.alexa.com/data?cli=10&dat=snbamz&url=' . $site);

    if(trim($apiData) === 'Okay')
        $apiData = simpleCurlGET('https://api.KOVATZ.COM/tweb/alexa.php?domain='.$site.'&code=' . $GLOBALS['item_purchase_code']);

    $xml = simplexml_load_string($apiData);

    $a = $xml->SD[1]->POPULARITY;
    if ($a != null) {
        $alexa_rank = $xml->SD[1]->POPULARITY->attributes()->TEXT;
        $alexa_rank = ($alexa_rank==null ? 'No Global Rank' : $alexa_rank);
    } else {
        $alexa_rank = 'No Global Rank';
    }

    $a1 = $xml->SD[1]->COUNTRY;
    if ($a1 != null) {
        $alexa_pop = $xml->SD[1]->COUNTRY->attributes()->NAME;
        $regional_rank = $xml->SD[1]->COUNTRY->attributes()->RANK;
        $alexa_pop = ($alexa_pop==null ? 'None' : $alexa_pop);
        $regional_rank = ($regional_rank==null ? 'None' : $regional_rank);
    } else {
        $alexa_pop = 'None';
        $regional_rank = 'None';
    }

    $outData = simpleCurlGET("https://www.alexa.com/siteinfo/$site");
    $back = explode('<span class="big data">',$outData);
    $back = explode('</span>',$back[1]);
    $alexa_back = $back[0];

    $alexa_back = ($alexa_back==null ? '0' : $alexa_back);
    return array($alexa_rank,$alexa_pop,$regional_rank,$alexa_back);
}

function cleanText($str){
    $remArr = array("&nbsp;","<br>","<br/>","<br />","\n","\r\n",PHP_EOL);
    $str = str_replace($remArr,"",$str);
    return Trim($str);
}

function getCenterTextC($str1,$str2,$data){
    $data = explode($str1,$data);
    $data = explode($str2,$data[1]);
    return cleanText($data[0]);
}

function alexaExtended($site){
    $outData = simpleCurlGET("https://www.alexa.com/siteinfo/$site");
    $back = explode('<span class="big data">',$outData);
    $back = explode('</span>',$back[1]);
    $alexa_backlinks = $back[0];
    $alexa_backlinks = ($alexa_backlinks==null ? 0 : $alexa_backlinks);

    $cloop = 1;
    $top_countryData_rw = $top_countryData = $countryNameArr = array();
    $countryData = $countryNameData = '';

    $countryData =  getCenterText('<section class="country">', '<div class="Hide">', $outData);
    $top_countryData_rw = explode('<li style="display:flex; justify-content:space-between;">',$countryData);

    foreach($top_countryData_rw as $top_rw) {
        if(!isset($top_countryData_rw[$cloop]))
            break;
        $top_rw = explode('</li>', $top_countryData_rw[$cloop]);

        $countryNameData = getCenterText('<div id="countryName">','</div>', $top_rw[0]);
        $countryNameArr = explode('&nbsp;', $countryNameData);
        $countryPercent = getCenterText('<div id="countryPercent">','</div>', $top_rw[0]);
        $top_countryData[] = array($countryNameArr[0], $countryNameArr[1], $countryPercent);
        $cloop++;
    }
    return $top_countryData;
}