<?php

/*
* @author MD ARIFUL HAQUE
* @name Rainbow PHP Framework
* @copyright 2022 KOVATZ.COM
*
*/

function GetDirectorySize($path){
    $bytestotal = 0;
    if ($path !== false){
        try{
            foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path,FilesystemIterator::SKIP_DOTS)) as $object){
                $bytestotal += $object->getSize();
            }
        }catch (Exception $e){
            return 'Unavailable';
        }
    }
    return $bytestotal;
}

function successMsgAdmin($msg){
    return '
    <div class="alert alert-success alert-dismissable">
        <i class="fa fa-check"></i>
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>
        <b>Alert!</b> '.$msg.'
    </div>';
}

function errorMsgAdmin($msg){
    return '
    <div class="alert alert-danger alert-dismissable">
        <i class="fa fa-ban"></i>
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>
        <b>Alert!</b> ' . $msg . '
    </div>';
}

function rndColor(){
    $bageColor = array(
        'blue',
        'red',
        'green',
        'purple',
        'light-blue',
        'yellow');
    $rndColor = $bageColor[array_rand($bageColor)];
    return $rndColor;
}

function rndFlatColor(){
    $bageColor = array(
        '#1ccdaa','#2ecc71','#042e52','#9b59b6','#34495e','#16a085','#27ae60','#2980b9','#8e44ad','#2c3e50','purple',
        '#f39c12','#e67e22','#e74c3c','#95a5a6','#7f8c8d','#d35400','#c0392b','#1E8BC3','#1BA39C','#DB0A5B',
        '#96281B');
    $rndColor = $bageColor[array_rand($bageColor)];
    return $rndColor;
}

function pickUpRandom($arr){
    return $arr[array_rand($arr)];
}