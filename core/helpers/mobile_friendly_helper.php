<?php

function getMobileFriendly($url){

    $url = str_replace(array('http://','https://'), '', $url);

    $mobile = array('passed' => false, 'score' => 0, 'screenshot' => '', 'url' => $url);

    $cookie = TMP_DIR . unqFile(TMP_DIR, randomPassword() . '_curl.tdata');
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://www.bing.com/webmaster/tools/mobile-friendliness-result');
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.3; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0");
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, Array("X-Requested-With: XMLHttpRequest", "Content-Type: application/x-www-form-urlencoded; charset=UTF-8", "Accept: text/html, */*; q=0.01"));
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_REFERER, 'https://www.bing.com/webmaster/tools/mobile-friendliness');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'url=' . $url . '&retry=0');
    $html = curl_exec($ch);
    curl_close($ch);

    require_once(LIB_DIR . 'simple_html_dom.php');

    $domData = load_html($html);

    if (!empty($domData)) {
        $domContent = $domData->find('div.successGreen');
        if (!empty($domContent))
            $mobile['passed'] = true;

        $imgContent = $domData->find('img');
        if (!empty($imgContent)) {
            foreach ($imgContent as $imgData) {
                $imageLink = trim($imgData->getAttribute('src'));
                if ($imageLink != '') {
                    if (check_str_contains($imageLink, 'GreenCheckLg'))
                        $mobile['score'] = $mobile['score'] + 20;
                }
            }
        }

        $imgContent = $domData->find('img[id=snapshot]');
        if (!empty($imgContent)) {
            foreach ($imgContent as $imgData)
                $mobile['screenshot'] = str_replace(array('data:image/jpeg;base64,','data:image/jpg;base64,','data:image/png;base64,'), '', trim($imgData->getAttribute('src')));
        }
    }
    return $mobile;
}