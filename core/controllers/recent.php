<?php
defined('APP_NAME') or die(header('HTTP/1.1 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: Rainbow PHP Framework
 * @copyright 2021 KOVATZ.COM
 *
 */

$pageTitle = trans('Recent Sites',$lang['133'],true);
$des = '';
$keywords = '';

$perPage = 9;
$totalSitesData =  mysqli_query($con, "SELECT COUNT(DISTINCT domain_name) FROM recent_history");
$totalSitesData = mysqli_fetch_array($totalSitesData);
$totalSites = $totalSitesData[0];

if ($pointOut != '') {
    $pagenumber = intval($pointOut);
    $page = $pagenumber -1;
}else{
    $pagenumber = '1';
    $page = 0;
}

$offset = $perPage * $page;

$pagination = new bootpagination();
$pagination->pagenumber = $pagenumber;
$pagination->pagesize = $perPage;
$pagination->totalrecords = $totalSites;
$pagination->showfirst = true;
$pagination->showlast = true;
$pagination->paginationcss = "pagination-normal";
$pagination->paginationstyle = 0;
$pagination->defaultUrl = createLink($controller,true);
$pagination->paginationUrl = createLink($controller.'/[p]',true);


//$result = mysqli_query($con, "SELECT * FROM recent_history GROUP BY(domain_name) ORDER BY id DESC LIMIT $offset, $perPage");
$domainList = array();
$result = mysqli_query($con, "SELECT *
FROM (
  SELECT id,domain_name,other
  FROM recent_history
  ORDER BY id DESC
) AS recent_history
GROUP BY domain_name ORDER BY id DESC LIMIT $offset, $perPage");
while($row = mysqli_fetch_array($result)) {
    $domainStr = strtolower($row['domain_name']);
    $other = decSerBase($row['other']);
    $domainList[] = array($domainStr,$other[0],number_format($other[1]),$other[2]);
}
