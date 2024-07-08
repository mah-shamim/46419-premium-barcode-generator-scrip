<?php

defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: KOVATZ Seo Tools
 * @copyright � 2022 KOVATZ.COM
 *
 */

$pageTitle = 'Recent History';
$subTitle = 'Domain Cached History';
$fullLayout = 1; $footerAdd = $status = true; $footerAddArr = array();

//Delete a Domain
if($pointOut == 'delete'){
    if(isset($args[1])){
        $deleteId = escapeTrim($con, $args[1]);
        
        if($args[0] == 'domain')
            $query = "DELETE FROM recent_history WHERE id='$deleteId'";
        else if($args[0] == 'compare')
            $query = "DELETE FROM comp_recent_history WHERE id='$deleteId'";

        $result = mysqli_query($con, $query);
        
        if (mysqli_errno($con))
            $msg = errorMsgAdmin(mysqli_error($con));
        else 
            $msg = successMsgAdmin('Domain deleted from history list');
    }
}

?>