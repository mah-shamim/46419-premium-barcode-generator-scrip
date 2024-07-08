<?php
defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: Rainbow PHP Framework
 * @copyright � 2022 KOVATZ.COM
 *
 */

$pageTitle = $des = $keyword = '';
$pageSuccess = false;
$data = mysqliPreparedQuery($con, "SELECT * FROM pages WHERE page_url=? AND type=?",'ss',array($pointOut,'page'));

if($data !== false){   
    if(isSelected($data['status'])){
        if($data['lang'] == 'all' || $data['lang'] == ACTIVE_LANG){
            if($data['access'] == 'all' || isset($_SESSION['twebUsername'])){
                $editID = $data['id'];
                $page_title = shortCodeFilter($data['page_title']);
                $page_url = $data['page_url'];
                $meta_des = shortCodeFilter($data['meta_des']);
                $page_name = shortCodeFilter($data['page_name']);
                $posted_date = $data['posted_date'];
                $meta_tags = shortCodeFilter($data['meta_tags']);
                $header_show = filter_var($data['header_show'], FILTER_VALIDATE_BOOLEAN);
                $footer_show = filter_var($data['footer_show'], FILTER_VALIDATE_BOOLEAN);
                $page_content = shortCodeFilter(htmlspecialchars_decode($data['page_content']));
                $pageSuccess = true;
            }else{
                redirectTo(createLink('account/login',true));
                die();
            }
        }
    }
}

if(!$pageSuccess){
    require_once (CON_DIR . "error.php");
}

$posted_date_raw = date_create($posted_date);
$post_month = date_format($posted_date_raw,"M");
$post_day = date_format($posted_date_raw,"j");

$pageTitle = $page_title;
$des = $meta_des;
$keyword = $meta_tags;

?>