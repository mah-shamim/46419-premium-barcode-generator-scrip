<?php

defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: Rainbow PHP Framework
 * @copyright � 2022 KOVATZ.COM
 *
 */

$date = date('Y-m-d');
$sess_id = session_id();
$nowHour = date('H'); 
$nowTime = time();
$data = $pageData = array();
$pageCheck = false;
$ref = $screen = $page = $activeCol = $colName = $ipagePageView = $pageView = '';

if(isset($_POST['page']) && Trim($_POST['page']) != '')
    $page = escapeTrim($con, $_POST['page']);
else
    die('No Active Link');
    
if(isset($_POST['ref']) && Trim($_POST['ref']) != '')
    $ref = escapeTrim($con, $_POST['ref']);
    
if(isset($_POST['screen']) && Trim($_POST['screen']) != '')
    $screen = escapeTrim($con, $_POST['screen']);

if(isset($_SESSION['twebUsername']))
    $username = $_SESSION['twebUsername'];
else
    $username = 'Guest';


if ($nowHour % 2 == 0)
    $activeCol = (int)$nowHour;
else
    $activeCol = (int)$nowHour - 1;
$colName = "h$activeCol";

$trackQuery =  mysqli_query($con, "SELECT * FROM rainbow_track where date='$date'");
if(mysqli_num_rows($trackQuery) > 0) {
    //Already date exist
    $records = mysqli_fetch_array($trackQuery);
    if(isset($_SESSION['tweb_rainbow_track'])){
        //Old Session
        $colName = 'h'.$_SESSION['tweb_rainbow_track']['active_col'];
        $records[$colName] = dbStrToArr($records[$colName]);
        //Old Session Check
        if(isset($records[$colName][$ip][$sess_id])){
            //Page Check
            $pageCheck = isPageExistOnArray($page,$records[$colName][$ip][$sess_id]['pages']);
            if($pageCheck[0]){
                //Page Exist
                $ipagePageView = intval($records[$colName][$ip][$sess_id]['pages'][$pageCheck[1]][1]);
                $records[$colName][$ip][$sess_id]['pages'][$pageCheck[1]][1] = $ipagePageView+1;
                $records[$colName][$ip][$sess_id]['pages'][$pageCheck[1]][2] = $nowTime;
            }else{
                //New Page
                $records[$colName][$ip][$sess_id]['pages'][] = array($page,'1',$nowTime);
            }
            //Update Last Visit
            $records[$colName][$ip][$sess_id]['last_visit'] = $nowTime;
            
            //Update Page View
            $pageView = intval($records[$colName][$ip][$sess_id]['pageview']);
            $records[$colName][$ip][$sess_id]['pageview'] = $pageView+1;
            
            //Update Username (If Applicable!)
            if($records[$colName][$ip][$sess_id]['username'] == 'Guest'){
                if(isset($_SESSION['twebUsername']))
                    $records[$colName][$ip][$sess_id]['username'] = $username;
            }
            if(updateToDbPrepared($con, 'rainbow_track', array(
            $colName => arrToDbStr($con,$records[$colName])), array('date' => $date))){
                die('Something Went Wrong!');
            }
        }else{
            session_destroy();
            session_start();
            session_regenerate_id();
            die('Session Not Valid');
        }
    }else{
        //New Session
        $records[$colName] = dbStrToArr($records[$colName]);
        $pageData[] = array($page,'1',$nowTime);
        $records[$colName][$ip][$sess_id] = array(
            'username' => $username,
            'pageview' => '1',
            'pages' => $pageData,
            'ref' => $ref,
            'keyword' => array(
                    'google' => '',
                    'yahoo' => '',
                    'bing' => '',
                    'ask' => ''
            ),
            'ua' => escapeTrim($con, $_SERVER['HTTP_USER_AGENT']),
            'screen' => $screen,
            'time' => $nowTime,
            'last_visit' => $nowTime
        );
        if(updateToDbPrepared($con, 'rainbow_track', array(
        $colName => arrToDbStr($con,$records[$colName])), array('date' => $date))){
            die('Something Went Wrong!');
        }else{
            $_SESSION['tweb_rainbow_track'] = array(
                'active_col' => $activeCol,
                'sess_id' => randomPassword()
            );
        }
    }
}else{
    //Insert New Date & Create New Session
    $pageData[] = array($page,'1',$nowTime);
    $data[$ip][$sess_id] = array(
        'username' => $username,
        'pageview' => '1',
        'pages' => $pageData,
        'ref' => $ref,
        'keyword' => array(
                'google' => '',
                'yahoo' => '',
                'bing' => '',
                'ask' => ''
        ),
        'ua' => escapeTrim($con, $_SERVER['HTTP_USER_AGENT']),
        'screen' => $screen,
        'time' => $nowTime,
        'last_visit' => $nowTime
    );
    
    if(insertToDbPrepared($con, 'rainbow_track', array(
        $colName => arrToDbStr($con,$data),
        'date' => $date))){
            die('Something Went Wrong!');
    }else{
        $_SESSION['tweb_rainbow_track'] = array(
            'active_col' => $activeCol,
            'sess_id' => randomPassword()
        );
    }
}
die();
?>