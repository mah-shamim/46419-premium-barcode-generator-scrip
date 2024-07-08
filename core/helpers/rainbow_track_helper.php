<?php

/*
* @author MD ARIFUL HAQUE
* @name Rainbow PHP Framework
* @copyright � 2022 KOVATZ.COM
*
*/

function isPageExistOnArray($elem, $array) {
    foreach($array as $key => $pages){
        if($pages[0] == Trim($elem))
            return array(true,$key);
    }
    return array(false);
}

function getTrackRecords($date,$con){
    $evens = array(0,2,4,6,8,10,12,14,16,18,20,22);
    $finalRecord = array();
    $trackQuery =  mysqli_query($con, "SELECT * FROM rainbow_track where date='$date'");
    if(mysqli_num_rows($trackQuery) > 0) {
        $records = mysqli_fetch_array($trackQuery);
        foreach($evens as $num){
             $records['h'.$num] = dbStrToArr($records['h'.$num]);
        }
        $finalRecord = array_merge_recursive($records['h0'],$records['h2'],$records['h4'],$records['h6'],$records['h8'],
        $records['h10'],$records['h12'],$records['h14'],$records['h16'],$records['h18'],$records['h20'],$records['h22']);
    }
    return $finalRecord;
}

function getTrackRecordsRange($startDate,$endDate,$con){
    $evens = array(0,2,4,6,8,10,12,14,16,18,20,22);
    $finalRecord = array();
    $trackQuery =  mysqli_query($con, "SELECT * FROM rainbow_track where date between '$startDate' and '$endDate'");
    if(mysqli_num_rows($trackQuery) > 0) {
        while($records = mysqli_fetch_array($trackQuery)) {
            foreach($evens as $num){
                 $records['h'.$num] = dbStrToArr($records['h'.$num]);
            }
            $finalRecord[] = array_merge_recursive($records['h0'],$records['h2'],$records['h4'],$records['h6'],$records['h8'],
            $records['h10'],$records['h12'],$records['h14'],$records['h16'],$records['h18'],$records['h20'],$records['h22']);
        }
    }
    return $finalRecord;
}

function getTrackRecordsWithPageViews($date,$con){
    $evens = array(0,2,4,6,8,10,12,14,16,18,20,22);
    $finalRecord = $viewRecord = array();
    $pageView = $uniqueView = $sesCount = 0;
    $trackQuery =  mysqli_query($con, "SELECT * FROM rainbow_track where date='$date'");
    if(mysqli_num_rows($trackQuery) > 0) {
        $records = mysqli_fetch_array($trackQuery);
        foreach($evens as $num){
             $records['h'.$num] = dbStrToArr($records['h'.$num]);
             $tempPageView = $tempUniqueView = $tempSesCount = 0;
             foreach($records['h'.$num] as $ip => $ses){
                $uniqueView++;
                $tempUniqueView++;
                foreach($ses as $sesID => $data){
                    $sesCount++;
                    $tempSesCount++;
                    foreach($data['pages'] as $pageV){
                        $pageView = $pageView + $pageV[1];
                        $tempPageView = $tempPageView + $pageV[1];
                    }
                }
             }
            $viewRecord[$num] = array('views' => $tempPageView, 'unique' => $tempUniqueView, 'ses' => $tempSesCount);
        }
        $viewRecord['total'] = array('views' => $pageView, 'unique' => $uniqueView, 'ses' => $sesCount);
        $finalRecord = array_merge_recursive($records['h0'],$records['h2'],$records['h4'],$records['h6'],$records['h8'],
        $records['h10'],$records['h12'],$records['h14'],$records['h16'],$records['h18'],$records['h20'],$records['h22']);
    }
    return array($viewRecord, $finalRecord);
}

function getTrackViews($con,$reportLimit = 10){
    $evens = array(0,2,4,6,8,10,12,14,16,18,20,22);
    $viewRecord = array();
    $trackQuery =  mysqli_query($con, 'SELECT * FROM rainbow_track ORDER BY id DESC LIMIT '. $reportLimit);
    while ($records = mysqli_fetch_array($trackQuery)){
        $pageView = $uniqueView = $sesCount = 0;
        foreach($evens as $num){
             $records['h'.$num] = dbStrToArr($records['h'.$num]);
             $tempPageView = $tempUniqueView = $tempSesCount = 0;
             foreach($records['h'.$num] as $ip => $ses){
                $uniqueView++;
                $tempUniqueView++;
                foreach($ses as $sesID => $data){
                    $sesCount++;
                    $tempSesCount++;
                    foreach($data['pages'] as $pageV){
                        $pageView = $pageView + $pageV[1];
                        $tempPageView = $tempPageView + $pageV[1];
                    }
                }
             }
        }
        $viewRecord[$records['date']] = array('views' => $pageView, 'unique' => $uniqueView, 'ses' => $sesCount);
    }
    return $viewRecord;
}

function getTodayViews($con){
    $date = date('Y-m-d');
    $evens = array(0,2,4,6,8,10,12,14,16,18,20,22);
    $pageView = $uniqueView = $sesCount = 0;
    $trackQuery =  mysqli_query($con, "SELECT * FROM rainbow_track WHERE date='$date'");
    if(mysqli_num_rows($trackQuery) > 0) {
        $records = mysqli_fetch_array($trackQuery);
        foreach($evens as $num){
             $records['h'.$num] = dbStrToArr($records['h'.$num]);
             $tempPageView = $tempUniqueView = $tempSesCount = 0;
             foreach($records['h'.$num] as $ip => $ses){
                $uniqueView++;
                $tempUniqueView++;
                foreach($ses as $sesID => $data){
                    $sesCount++;
                    $tempSesCount++;
                    foreach($data['pages'] as $pageV){
                        $pageView = $pageView + $pageV[1];
                        $tempPageView = $tempPageView + $pageV[1];
                    }
                }
             }
        }
    }
    return array('views' => $pageView, 'unique' => $uniqueView, 'ses' => $sesCount);
}

function getOnlineUsers($con,$time="-30 minutes"){
    $date = date('Y-m-d');
    $onlineUsersCount = 0;
    $evens = array(0,2,4,6,8,10,12,14,16,18,20,22);
    $finalRecord = array();
    $trackQuery =  mysqli_query($con, "SELECT * FROM rainbow_track where date='$date'");
    if(mysqli_num_rows($trackQuery) > 0) {
        $records = mysqli_fetch_array($trackQuery);
        foreach($evens as $num){
             $records['h'.$num] = dbStrToArr($records['h'.$num]);
             foreach($records['h'.$num] as $ip => $ses){
                foreach($ses as $sesID => $data){
                    if($data['last_visit'] >= strtotime($time)){
                        $finalRecord[$ip][$sesID] = $data;
                        $onlineUsersCount++;
                    }
                }
             }
        }
    }
    if(date('H') == '00'){
        if(date('i') <= '30'){
            $date = date('Y-m-d', strtotime('-1 days'));
            $evens = array(0,2,4,6,8,10,12,14,16,18,20,22);
            $trackQuery =  mysqli_query($con, "SELECT * FROM rainbow_track where date='$date'");
            if(mysqli_num_rows($trackQuery) > 0) {
                $records = mysqli_fetch_array($trackQuery);
                foreach($evens as $num){
                     $records['h'.$num] = dbStrToArr($records['h'.$num]);
                     foreach($records['h'.$num] as $ip => $ses){
                        foreach($ses as $sesID => $data){
                            if($data['last_visit'] >= strtotime($time)){
                                $finalRecord[$ip][$sesID] = $data;
                                $onlineUsersCount++;
                            }
                        }
                     }
                }
            }
        }
    }
    
    return array($onlineUsersCount, $finalRecord);
}

