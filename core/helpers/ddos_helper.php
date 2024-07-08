<?php
/*
* @author MD ARIFUL HAQUE
* @name Rainbow PHP Framework
* @copyright 2021 KOVATZ.COM
*
*/

function ddosCheck($con, $ip, $limit=15, $date=false){

    $banned = 0;

    if(!($date))
        $date = date('Y-m-d');
    $time = time();

    $query = mysqli_query($con, 'SELECT id,data,banned FROM ddos WHERE ip="'.$ip.'" AND date="'.$date.'"');
    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);
        $isIPbanned = filter_var($data['banned'], FILTER_VALIDATE_BOOLEAN);

        if(!$isIPbanned){
            $dData = dbStrToArr($data['data']);
            if(isset($dData[$time])){
                $dData[$time] = $dData[$time] + 1;
                if($dData[$time] > $limit)
                    $banned = 1;
            }else{
                $dData[$time] = 1;
            }
            $dStr = arrToDbStr($con, $dData);
            updateToDbPrepared($con, 'ddos', array('banned' => $banned, 'data' => $dStr), array('id' => $data['id']));
        }else{
            header('HTTP/1.1 503 Service Unavailable');
            echo '503 Service Unavailable!';
            die();
        }
    }else{
        $data = arrToDbStr($con, array($time => 1));
        insertToDbPrepared($con, 'ddos', array('banned' => 0, 'data' => $data, 'ip' => $ip, 'date' => $date));
    }
    return true;
}