<?php
/*
* @author MD ARIFUL HAQUE
* @name KOVATZ Seo Tools - PHP Script
* @copyright 2022 KOVATZ.COM
*
*/

function clearSocialData($data){
    $data = str_replace(array(',','.','-','+','_', ' ', '$', '%', '<', '>','<br>','?','/','!','@','#','~',"'",'"'), '', $data);
    return intval(trim($data));
}

function getSocialData($source){
    $matches = array();
    $fbCount = 0;
    $fbLink = $twiLink = $instaLink = '';
    $fbData = $tData = $iData = '-';
    $fbMatch = '#https?\://(?:www\.)?facebook\.com/(\d+|[A-Za-z0-9\.]+)/?#';
    $twiMatch = '#https?\://(?:www\.)?twitter\.com/(\d+|[A-Za-z0-9\.]+)/?#';
    $instaMatch = '#https?\://(?:www\.)?instagram\.com/(\d+|[A-Za-z0-9\.]+)/?#';

    preg_match_all($fbMatch,$source,$matches);

    if(isset($matches[1])){

        if(isset($matches[1][0]) && $matches[1][0] != ''){
            if($matches[1][0] === 'sharer'){
                if(isset($matches[1][1]))
                    $fbLink = $matches[0][1];
            }else{
                $fbLink = $matches[0][0];
            }
        }

        if($fbLink != ''){
            $fbData = "<a target=\"_blank\" href=\"$fbLink\" rel=\"nofollow\">".ucfirst($matches[1][0])."</a>";
            $fxdata = curlGET($fbLink);
            if($fxdata != '') {
                if (preg_match_all('/>([0-9,]+) people like this</i', $fxdata, $matches))
                    $fbCount = clearSocialData($matches[1][0]);
                else
                    $fbCount = clearSocialData(getCenterText('_4bl9"><div>', ' ', $fxdata));
                if($fbCount != '' && $fbCount != 0) {
                    $fbCount = number_format($fbCount);
                    $fbData .= " (Likes: $fbCount)";
                }
            }
        }
    }


    preg_match_all($twiMatch,$source,$matches);
    if(isset($matches[1])){
        if(isset($matches[1][0]) && $matches[1][0] != ''){
            if($matches[1][0] === 'share' || $matches[1][0] === 'intent' ){
                if(isset($matches[1][1]))
                    $twiLink = $matches[0][1];
            }else{
                $twiLink = $matches[0][0];
            }
        }
    }

    if($twiLink != '')
        $tData = "<a target=\"_blank\" href=\"$twiLink\" rel=\"nofollow\">".ucfirst($matches[1][0])."</a>";


    preg_match_all($instaMatch,$source,$matches);
    if(isset($matches[1])){
        if(isset($matches[1][0]) && $matches[1][0] != '')
            $instaLink = $matches[0][0];
    }

    if($instaLink != '')
        $iData = "<a target=\"_blank\" href=\"$instaLink\" rel=\"nofollow\">".ucfirst($matches[1][0])."</a>";

    return array('fb' => $fbData, 'twit' => $tData, 'insta' => $iData);
}