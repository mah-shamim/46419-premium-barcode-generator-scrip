<?php
defined('APP_NAME') or die(header('HTTP/1.1 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: Rainbow PHP Framework
 * @copyright 2021 KOVATZ.COM
 *
 */
 
if(defined('CUSTOM_ROUTE')){
    if(!CUSTOM_ROUTE){
        stop("No Custom Router Enabled");
    }
}

//$custom_route['Route Path Name'] = "Controller Name";

//Basic Controller Routing
//$custom_route['contact'] = "contactus";

//Specific PointOut into Controller Routing
//$custom_route['product/update'] = "update";

//Specific Route Path into Specific PointOut Routing
//$custom_route['product'] = "product/sub";

//Dynamic PointOut Routing
//$custom_route['blog/[:any]'] = "product";

//Hide Real Controller Routing
//$custom_route['product'] = "error";

$custom_route['lang/set'] = "ajax/lang";
$custom_route['theme/set'] = "ajax/theme";
$custom_route['templates/preview'] = "ajax/templates";
$custom_route['theme/unset'] = "ajax/theme/unset";
$custom_route['rainbow/track'] = "track";
$custom_route['rainbow/master-js'] = "ajax/master-js";
$custom_route['upgrade'] = "api/easy-upgrade";
$custom_route['phpcap/reload'] = "ajax/phpcap/reload";
$custom_route['ajax/sitevssite'] = "api/sitevssite";
$custom_route['verify'] = "ajax/account-verify";
$custom_route['warning'] = "api/warning";
$custom_route['check/verfication'] = "api/warning/verfication";
