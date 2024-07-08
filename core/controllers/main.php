<?php
defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: Rainbow PHP Framework
 * @copyright 2022 KOVATZ.COM
 *
 */

$_SESSION['TWEB_HOMEPAGE'] = 1;

$perPage = 6; $count = 0;
$domainList = $onlyDomainName = array();
$screenShotCheck = true;

$result = mysqli_query($con, 'SELECT id,domain_name,other FROM recent_history ORDER BY id DESC LIMIT 20');
while($row = mysqli_fetch_array($result)) {
    $domainStr = strtolower($row['domain_name']);
    if(!in_array($domainStr,$onlyDomainName)){
        if($screenShotCheck){
            if (file_exists(HEL_DIR."site_snapshot/$domainStr.jpg")) {
                $other = decSerBase($row['other']);
                $onlyDomainName[] = $domainStr;
                $domainList[] = array($domainStr,$other[0],number_format($other[1]),$other[2]);
                $count++;
            }
        }else{
            $other = decSerBase($row['other']);
            $onlyDomainName[] = $domainStr;
            $domainList[] = array($domainStr,$other[0],number_format($other[1]),$other[2]);
            $count++;
        }
        if($count == $perPage)
            break;
    }
}
$count = 0;