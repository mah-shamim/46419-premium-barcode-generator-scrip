<?php

/*
* @author MD ARIFUL HAQUE
* @name Rainbow PHP Framework
* @copyright � 2022 KOVATZ.COM
*
*/

function get_recaptcha_response($response,$secret_key,$ip){
	$google_url="https://www.google.com/recaptcha/api/siteverify";
	$url= $google_url."?secret=".$secret_key."&response=".$response."&remoteip=".$ip;
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_TIMEOUT, 10);
	curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16");
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	$curlData = curl_exec($curl);
	curl_close($curl);
	$result = json_decode($curlData, true);
	return $result;
}

?>