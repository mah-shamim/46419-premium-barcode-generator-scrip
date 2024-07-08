<?php
defined('APP_NAME') or die(header('HTTP/1.1 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: Rainbow PHP Framework
 * @copyright 2021 KOVATZ.COM
 *
 */

$pageTitle = 'DDoS Protection';
$subTitle = 'Application Level DDoS Detection';
$fullLayout = 1; $footerAdd = true; $footerAddArr = array();
$date = date('Y-m-d');

$siteInfo =  mysqli_query($con, "SELECT other_settings FROM site_info where id=1");
$siteInfoRow = mysqli_fetch_assoc($siteInfo);
$other = dbStrToArr($siteInfoRow['other_settings']);

$noBanned = true;
$ddosData = mysqliPreparedQuery($con, 'SELECT id,ip,date FROM ddos WHERE date=? AND banned=?', 'si', array($date,1), false);

if(count($ddosData) !== 0)
    $noBanned = false;

if($pointOut == 'delete'){
    $delID = intval($args[0]);
    if(isset($args[0]) && $args[0] !== ''){
        $sql = 'DELETE FROM ddos WHERE id=' . $delID;
        if (mysqli_query($con, $sql)) {
            header('Location:' . adminLink($controller, true));
            die();
        }else{
            $msg = errorMsgAdmin(mysqli_error($con));
        }
    }else{
        header('Location:'.adminLink($controller,true));
        die();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $ddos = isSelected(escapeTrim($con, $_POST['ddos']));
    $maxcount = intval($_POST['maxcount']);
    
    $other['other']['ddos'] = $ddos;
    $other['other']['ddosLimit'] = $maxcount;
    $other_settings = arrToDbStr($con,$other);

    $query = "UPDATE site_info SET other_settings='$other_settings' WHERE id=1";
    mysqli_query($con, $query);

    if (mysqli_errno($con))
        $msg = errorMsgAdmin(mysqli_error($con));
    else
        $msg = successMsgAdmin('DDoS settings saved successfully');
}
