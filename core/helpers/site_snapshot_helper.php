<?php

/*
* @author MD ARIFUL HAQUE
* @name KOVATZ Seo Tools - PHP Script
* @copyright 2022 KOVATZ.COM
*
*/

// actual script begins here
$ex=false;

function get_ext ($file) {
    //detect type and process accordinally
    global $ex;
    $size=$file;
    switch($size){
        case "image/jpeg":
			$ex = '.jpg';
        break;
        case "image/gif":
			$ex = '.gif';
      break;
      case "image/png":
		  $ex = '.png';
      break;
    default:
        $ex=false;
    break;
    }
    return $ex;
}
 
function getSiteSnap($site,$item_purchase_code,$baseLink,$isCustomApi=false,$customLink=''){
	
	
 $screen_shot_json_data = file_get_contents("https://www.googleapis.com/pagespeedonline/v2/runPagespeed?url=https://".$site."&screenshot=true");
 $screen_shot_result = json_decode($screen_shot_json_data, true);
 $screen_shot = $screen_shot_result['screenshot']['data'];
 $screen_shot_type= $screen_shot_result['screenshot']['mime_type'];
 $screen_shot = str_replace(array('_','-'), array('/', '+'), $screen_shot);

if($isCustomApi)
    $apiLink = str_replace(array('{{site}}','{{baseLink}}','{{item_purchase_code}}'), array($site,$baseLink,$item_purchase_code), $customLink);

$ex = get_ext ($screen_shot_type);

$imagePath = HEL_DIR.'site_snapshot/'.$site.$ex;

if (file_exists($imagePath)){
    $myimage = $imagePath;
}else {

    $name = $imagePath;
    $imgSrc = base64_decode($screen_shot);
    $stringData = $imgSrc;
	
	file_put_contents($imagePath, $stringData);
	
	$ssimage = imagecreatefromjpeg($name);


    if ($imgSrc == ''){
        unlink($name);
        $myimage = HEL_DIR.'site_snapshot/no-preview.png';
    } else {
        $ssimage = imagecreatefromjpeg($name);
        $myimage = $imagePath;
        $name = $myimage;
        $thumb_width = 600;
        $thumb_height = 450;

        $width = imagesx($ssimage);
        $height = imagesy($ssimage);

        $original_aspect = $width / $height;
        $thumb_aspect = $thumb_width / $thumb_height;

        if ($original_aspect >= $thumb_aspect){
            // If image is wider than thumbnail (in aspect ratio sense)
            $new_height = $thumb_height;
            $new_width = $width / ($height / $thumb_height);
        } else {
            // If the thumbnail is wider than the image
            $new_width = $thumb_width;
            $new_height = $height / ($width / $thumb_width);
        }

        $thumb = imagecreatetruecolor($thumb_width, $thumb_height);

        $co = imagecolorallocate($thumb, 241, 241, 241);
        imagefill($thumb, 0, 0, $co);
        $text_color = imagecolorallocate($thumb, 153, 153, 153);
        imagestring($thumb, 200, 400, 300, 'No Preview Available', $text_color);

        // Resize and crop
        imagecopyresampled($thumb, $ssimage, 0,
            //- ($new_width - $thumb_width) / 2, // Center the image horizontally
            0, // - ($new_height - $thumb_height) / 2, // Center the image vertically
            0, 0, $new_width, $new_height, $width, $height);
        
        imagejpeg($thumb, $myimage, 100);

        if (filesize($name) == 0){
            unlink($name);
            $myimage = HEL_DIR.'site_snapshot/no-preview.png';
        } elseif (filesize($name) <= 4){
            unlink($name);
            $myimage = HEL_DIR.'site_snapshot/no-preview.png';
        } else{
            $myimage = $imagePath;
        }
    }
}
return $myimage;
}