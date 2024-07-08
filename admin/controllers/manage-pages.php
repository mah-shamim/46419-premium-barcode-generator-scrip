<?php
defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: KOVATZ Seo Tools
 * @copyright © 2016 KOVATZ.COM
 *
 */

$pageTitle = 'Pages';
$subTitle = 'Manage Pages';
$fullLayout = 1; $footerAdd = $status = true; $footerAddArr = array();

//Status Change
if($pointOut == 'status'){
    $status = false;
    if($args[0] == 'disable')
        $status = false;
    else
        $status = true;
    $id = $args[1];
    
    $query = "UPDATE pages SET status='$status' WHERE id='$id'";
    mysqli_query($con, $query);
    header('Location:'.adminLink($controller,true));
    die();
}

//Success
if($pointOut == 'success'){
    $msg = '<div class="alert alert-success alert-dismissable">
    <i class="fa fa-check"></i>
    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>
    <b>Alert!</b> Your action successfully performed!
    </div>';
}

//Delete a Page or Link
if($pointOut == 'delete'){
    $deleteId = $args[0];
    $query = "DELETE FROM pages WHERE id='$deleteId'";
    $result = mysqli_query($con, $query);

    if (mysqli_errno($con)) {
        $msg = '<div class="alert alert-danger alert-dismissable">
        <i class="fa fa-ban"></i>
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>
        <b>Alert!</b> ' . mysqli_error($con) . '
        </div>';
    } else {
        $msg = '
        <div class="alert alert-success alert-dismissable">
        <i class="fa fa-check"></i>
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>
        <b>Alert!</b> Page deleted from database successfully.
        </div>';
    }
}

//Pages
if($pointOut == 'page'){
    
    //Adding new pages
    if($args[0] == 'add'){
        $subTitle = 'Create a New Page';
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $page_title = escapeTrim($con, $_POST['page_title']);
            $page_url = escapeTrim($con, $_POST['page_url']);
            $meta_des = escapeTrim($con, $_POST['meta_des']);
            $header_show = escapeTrim($con, $_POST['header_show']);
            $page_name = escapeTrim($con, $_POST['page_name']);
            $posted_date = escapeTrim($con, $_POST['posted_date']);
            $meta_tags = escapeTrim($con, $_POST['meta_tags']);
            $footer_show = escapeTrim($con, $_POST['footer_show']);
            $page_content = escapeTrim($con, $_POST['page_content']);
            $sort_order = escapeTrim($con,$_POST['sort_order']);
            if($sort_order == '') $sort_order = '1';
            $pageLangCode = escapeTrim($con,$_POST['pageLangCode']);
            $status = escapeTrim($con,$_POST['status']);
            $loginreq = escapeTrim($con,$_POST['loginreq']);
            
            $query = "INSERT INTO pages (sort_order,type,page_title,page_url,meta_des,header_show,page_name,posted_date,meta_tags,footer_show,page_content,lang,status,access) VALUES ('$sort_order','page','$page_title','$page_url','$meta_des','$header_show','$page_name','$posted_date','$meta_tags','$footer_show','$page_content','$pageLangCode','$status','$loginreq')";
        
            if (!mysqli_query($con, $query)) {
                $msg = '<div class="alert alert-danger alert-dismissable">
                <i class="fa fa-ban"></i>
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>
                <b>Alert!</b> Something Went Wrong!
                </div>';
            } else {
                header('Location:'.adminLink($controller.'/success',true));
                die();
            }
        }
        
    } elseif($args[0] == 'edit'){     //Edting exiting page
        $subTitle = 'Page Editor';
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $page_title = escapeTrim($con, $_POST['page_title']);
            $page_url = escapeTrim($con, $_POST['page_url']);
            $meta_des = escapeTrim($con, $_POST['meta_des']);
            $header_show = escapeTrim($con, $_POST['header_show']);
            $page_name = escapeTrim($con, $_POST['page_name']);
            $posted_date = escapeTrim($con, $_POST['posted_date']);
            $meta_tags = escapeTrim($con, $_POST['meta_tags']);
            $footer_show = escapeTrim($con, $_POST['footer_show']);
            $page_content = escapeTrim($con, $_POST['page_content']);
            $editID = escapeTrim($con, $_POST['editID']);
            $sort_order = escapeTrim($con,$_POST['sort_order']);
            if($sort_order == '') $sort_order = '1';
            $pageLangCode = escapeTrim($con,$_POST['pageLangCode']);
            $status = escapeTrim($con,$_POST['status']);
            $loginreq = escapeTrim($con,$_POST['loginreq']);
            
            $query = "UPDATE pages SET status='$status', access='$loginreq', lang='$pageLangCode', sort_order='$sort_order', page_title='$page_title', page_url='$page_url', meta_des='$meta_des', header_show='$header_show', page_name='$page_name', posted_date='$posted_date', meta_tags='$meta_tags', footer_show='$footer_show', page_content='$page_content' WHERE id='$editID'";
        
            if (!mysqli_query($con, $query)) {
                $msg = '<div class="alert alert-danger alert-dismissable">
                <i class="fa fa-ban"></i>
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>
                <b>Alert!</b> Something Went Wrong!
                </div>';
            } else {
                $msg = '<div class="alert alert-success alert-dismissable">
                <i class="fa fa-check"></i>
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>
                <b>Alert!</b> Page data updated successfully!
                </div>';
                $page_title = $page_url = $meta_des = $header_show = $page_name = $posted_date = $meta_tags = $footer_show = $page_content = '';    
            }
        }
        
        $page_id = $args[1];
        $sql = "SELECT * FROM pages where id='$page_id'";
        $result = mysqli_query($con, $sql);
        $sort_order = '1';
        
        while ($row = mysqli_fetch_array($result)) {
            $editID = $row['id'];
            $page_title = $row['page_title'];
            $page_url = $row['page_url'];
            $meta_des = $row['meta_des'];
            $page_name = $row['page_name'];
            $posted_date = $row['posted_date'];
            $meta_tags = $row['meta_tags'];
            $header_show = filter_var($row['header_show'], FILTER_VALIDATE_BOOLEAN);
            $footer_show = filter_var($row['footer_show'], FILTER_VALIDATE_BOOLEAN);
            $page_content = $row['page_content'];
            $sort_order = $row['sort_order'];
            $pageLangCode =  $row['lang'];
            $status = $row['status'];
            $loginreq =  $row['access'];
        } 
    }else{
        header('Location:'.adminLink($controller,true));
        die();
    }
}


//Links
if($pointOut == 'link'){
    //Adding a new link
    
    if($args[0] == 'add'){
        $subTitle = 'Create a New Link';
        $url = '{{baseLink}}';
        $sort_order = '1';
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $url_type = escapeTrim($con,$_POST['url_type']);
            $url_name = escapeTrim($con,$_POST['url_name']);
            $url = escapeTrim($con,$_POST['url']);
            $status = escapeTrim($con,$_POST['status']);
            $target = escapeTrim($con,$_POST['target']);
            $header_show = escapeTrim($con,$_POST['header_show']);
            $sort_order = escapeTrim($con,$_POST['sort_order']);
            $rel = escapeTrim($con,$_POST['rel']);
            $footer_show = escapeTrim($con,$_POST['footer_show']);
            $page_content = serBase(array($rel,$target));
            
            $query = "INSERT INTO pages (sort_order,type,page_title,page_url,meta_des,header_show,page_name,posted_date,meta_tags,footer_show,page_content,lang,status) VALUES 
            ('$sort_order','$url_type','$url_name','$url','-','$header_show','$url_name','$date','-','$footer_show','$page_content','all','$status')";
           
            if (!mysqli_query($con, $query)) {
                $msg = '<div class="alert alert-danger alert-dismissable">
                <i class="fa fa-ban"></i>
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>
                <b>Alert!</b> Something Went Wrong!
                </div>';
            } else {
                header('Location:'.adminLink($controller.'/success',true));
                die();
            }
        }
    } elseif($args[0] == 'edit'){     //Edting exiting link
        $subTitle = 'Page Editor';
        $sort_order = '1';
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $editID = escapeTrim($con, $_POST['editID']);
            $url_type = escapeTrim($con,$_POST['url_type']);
            $url_name = escapeTrim($con,$_POST['url_name']);
            $url = escapeTrim($con,$_POST['url']);
            $status = escapeTrim($con,$_POST['status']);
            $target = escapeTrim($con,$_POST['target']);
            $header_show = escapeTrim($con,$_POST['header_show']);
            $sort_order = escapeTrim($con,$_POST['sort_order']);
            $rel = escapeTrim($con,$_POST['rel']);
            $footer_show = escapeTrim($con,$_POST['footer_show']);
            $page_content = serBase(array($rel,$target));
            
            $query = "UPDATE pages SET type='$url_type', status='$status', access='all', sort_order='$sort_order', page_title='$url_name', page_url='$url', header_show='$header_show', page_name='$url_name', posted_date='$date', footer_show='$footer_show', page_content='$page_content' WHERE id='$editID'";
        
            if (!mysqli_query($con, $query)) {
                $msg = '<div class="alert alert-danger alert-dismissable">
                <i class="fa fa-ban"></i>
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>
                <b>Alert!</b> Something Went Wrong!
                </div>';
            } else {
                $msg = '<div class="alert alert-success alert-dismissable">
                <i class="fa fa-check"></i>
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>
                <b>Alert!</b> Link data updated successfully!
                </div>';
                $url_type = $url_name = $posted_date = $header_show = $sort_order = $posted_date = $meta_tags = $footer_show = $page_content = '';    
            }
            
        }
        
        $page_id = $args[1];
        $sql = "SELECT * FROM pages where id='$page_id'";
        $result = mysqli_query($con, $sql);
        
        while ($row = mysqli_fetch_array($result)) {
            $editID = $row['id'];
            $url_type = $row['type'];
            $url = $row['page_url'];
            $url_name = $row['page_name'];
            $posted_date = $row['posted_date'];
            $header_show = filter_var($row['header_show'], FILTER_VALIDATE_BOOLEAN);
            $footer_show = filter_var($row['footer_show'], FILTER_VALIDATE_BOOLEAN);
            $page_content = decSerBase($row['page_content']);
            $rel = $page_content[0]; $target = $page_content[1];
            $sort_order = $row['sort_order'];
            $status = $row['status'];
        }
    }else{
        header('Location:'.adminLink($controller,true));
        die();
    }
    
}
?>