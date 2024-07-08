<?php
defined('SITEMAP_') or die(header('HTTP/1.1 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: KOVATZ Seo Tools
 * @copyright 2021 KOVATZ.COM
 *
 */
 
//Load Basic Settings
$siteInfo =  mysqli_query($con, "SELECT doForce FROM site_info where id=1");
$siteInfoRow = mysqli_fetch_assoc($siteInfo);
$doForce = dbStrToArr($siteInfoRow['doForce']);
$forceHttps = filter_var($doForce[0], FILTER_VALIDATE_BOOLEAN);
$forceWww = filter_var($doForce[1], FILTER_VALIDATE_BOOLEAN);
$baseURL = str_replace(array('http://', 'https://', 'www.'), '', $baseURL);

//WWW
if($forceWww){
    if ((strpos($serverHost, 'www.') === false))
        $baseURL = 'www.'. $baseURL;
}

//HTTPS
if($forceHttps)
    $baseURL = 'https://'. $baseURL;
else
    $baseURL = 'http://'. $baseURL;

$priorityArr = $freqArr = $linkArr = $tempLangList = array();
$tempLangPageCode = $tempLink = ''; $linkArr[] = $baseURL;

if(isSelected($other['other']['sitemap']['auto'])){
    $priorityArr = array('0.5', '0.6', '0.7', '0.8', '0.9');
    $freqArr = array('hourly', 'daily', 'weekly');
}else{
    $priorityArr = array($other['other']['sitemap']['priority']);
    $freqArr = array($other['other']['sitemap']['freqrange']);
}

$langList = getAvailableLanguageCodes($con);
$sitemap = new Sitemap(substr($baseURL,0,-1));
$sitemap->deleteOldSitemaps(true);
$sitemap->setMultilingual(isSelected($other['other']['sitemap']['multilingual']));
$sitemap->setGzip(isSelected($other['other']['sitemap']['gzip']));
$sitemap->addItem('/', '1.0', 'daily', 'Today', $langList);

$query = 'SELECT domain FROM domains_data';
$result = mysqli_query($con, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $tempLink = $baseURL.'domain/'.$row['domain'];
    if(!in_array($tempLink,$linkArr)){
        $sitemap->addItem('/domain/'.$row['domain'], pickUpRandom($priorityArr), pickUpRandom($freqArr), 'Today', $langList);
        $linkArr[] = $tempLink;
    }
}

$query = 'SELECT first_domain,sec_domain FROM comp_recent_history';
$result = mysqli_query($con, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $tempLink = $baseURL.'compare/'.$row['first_domain'].'/vs/'.$row['sec_domain'];
    if(!in_array($tempLink,$linkArr)){
        $sitemap->addItem('/compare/'.$row['first_domain'].'/vs/'.$row['sec_domain'], pickUpRandom($priorityArr), pickUpRandom($freqArr), 'Today', $langList);
        $linkArr[] = $tempLink;
    }
}

$result = mysqli_query($con, 'SELECT id,lang,type,status,page_url FROM pages');

while($row = mysqli_fetch_assoc($result)) {
    $tempLangPageCode = '';
    if($row['type'] == 'page'){
        if(isSelected($row['status'])){
            if($row['lang'] == 'all'){
                $tempLangList = $langList;
                $tempLink = $baseURL.'page/'.$row['page_url'];
            }else{
                $tempLangPageCode = $row['lang'];
                $tempLangList = array($tempLangPageCode);
                $tempLink = $baseURL.$tempLangPageCode.'/page/'.$row['page_url'];
            }
            if(!in_array($tempLink,$linkArr)){
                if($tempLangPageCode == '')
                    $sitemap->addItem('/page/'.$row['page_url'], pickUpRandom($priorityArr), pickUpRandom($freqArr), 'Today', $tempLangList);
                else
                    $sitemap->addItem('/'.$tempLangPageCode.'/page/'.$row['page_url'], pickUpRandom($priorityArr), pickUpRandom($freqArr), 'Today', $tempLangList);
                $linkArr[] = $tempLink;
            }
        }
    }elseif($row['type'] == 'internal'){
        $row['page_url'] = removeShortCodes($row['page_url']);
        if(isSelected($row['status'])){
            if($row['lang'] == 'all'){
                $tempLangList = $langList;
                $tempLink = $baseURL.$row['page_url'];
            }else{
                $tempLangPageCode = $row['lang'];
                $tempLangList = array($tempLangPageCode);
                $tempLink = $baseURL.$tempLangPageCode.'/'.$row['page_url'];
            }
            if(!in_array($tempLink,$linkArr)){
                if($tempLangPageCode == '')
                    $sitemap->addItem('/'.$row['page_url'], pickUpRandom($priorityArr), pickUpRandom($freqArr), 'Today', $tempLangList);
                else
                    $sitemap->addItem('/'.$tempLangPageCode.'/'.$row['page_url'], pickUpRandom($priorityArr), pickUpRandom($freqArr), 'Today', $tempLangList);
                $linkArr[] = $tempLink;
            }
        }
    }
}


$resDa = mysqli_query($con,"SHOW TABLES LIKE 'blog_content'");
if(mysqli_num_rows($resDa) > 0) {
    $result = mysqli_query($con, 'SELECT id,post_enable,post_url,lang FROM blog_content');
    while($row = mysqli_fetch_assoc($result)) {
        $tempLangPageCode = '';
        if(isSelected($row['post_enable'])){
            if($row['lang'] == 'all'){
                $tempLangList = $langList;
                $tempLink = $baseURL.'blog/'.$row['post_url'];
            }else{
                $tempLangPageCode = $row['lang'];
                $tempLangList = array($tempLangPageCode);
                $tempLink = $baseURL.$tempLangPageCode.'/blog/'.$row['post_url'];
            }
            if(!in_array($tempLink,$linkArr)){
                if($tempLangPageCode == '')
                    $sitemap->addItem('/blog/'.$row['post_url'], pickUpRandom($priorityArr), pickUpRandom($freqArr), 'Today', $tempLangList);
                else
                    $sitemap->addItem('/'.$tempLangPageCode.'/blog/'.$row['post_url'], pickUpRandom($priorityArr), pickUpRandom($freqArr), 'Today', $tempLangList);
                $linkArr[] = $tempLink;
            }
        }
    }
}

$sitemap->createSitemapIndex($baseURL, 'Today');