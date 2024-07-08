<?php

/*
 * @author MD ARIFUL HAQUE
 * @name: Rainbow PHP
 * @copyright 2021 KOVATZ.COM
 *
 */


function getSitemapInfo($inputHost){

    $httpCode = '';
    $sitemapPresent = false;
    $sitemapLink = $inputHost .'/robots.txt';
    $data = curlGET($sitemapLink);

    if(check_str_contains($data, 'Sitemap:')){
        preg_match_all('/Sitemap: ([^\s]+)/', $data, $match);
        $sitemapLink = $match[1][0];
        $httpCode = getHttpCode($sitemapLink);
        if($httpCode != '404')
            $sitemapPresent = true;
    }else{
        $sitemapLink = $inputHost .'/sitemap.xml';
        $httpCode = getHttpCode($sitemapLink);

        if($httpCode == '404') {
            $sitemapLink = $inputHost . '/sitemap_index.xml';
            $httpCode = getHttpCode($sitemapLink);
            if($httpCode != '404')
                $sitemapPresent = true;
        }else{
            $sitemapPresent = true;
        }
    }
    return array('isPresent' => $sitemapPresent, 'httpCode' => $httpCode, 'sitemapLink' => $sitemapLink);
}

function isSitemapPresent($inputHost){

    $sitemapPresent = false;

    $sitemapLink = $inputHost .'/robots.txt';
    $data = curlGET($sitemapLink);

    if(check_str_contains($data, 'Sitemap:')){
        preg_match_all('/Sitemap: ([^\s]+)/', $data, $match);
        $sitemapLink = $match[1][0];
        $httpCode = getHttpCode($sitemapLink);
        if($httpCode != '404')
            $sitemapPresent = true;
    }else{
        $sitemapLink = $inputHost .'/sitemap.xml';
        $httpCode = getHttpCode($sitemapLink);

        if($httpCode == '404') {
            $sitemapLink = $inputHost . '/sitemap_index.xml';
            $httpCode = getHttpCode($sitemapLink);
            if($httpCode != '404')
                $sitemapPresent = true;
        }else{
            $sitemapPresent = true;
        }
    }
    return $sitemapPresent;
}