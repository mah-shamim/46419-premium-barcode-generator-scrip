<?php
defined('ADMIN_LINKS') or die(header('HTTP/1.1 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: KOVATZ Seo Tools
 * @copyright 2021 KOVATZ.COM
 *
 */
 
$menuBarLinks = array();

$menuBarLinks['0'] = array(true, 'MAIN NAVIGATION','header-li','fa fa-lock');
$menuBarLinks['1'] = array(true, 'Dashboard','dashboard','fa fa-dashboard');
$menuBarLinks['2'] = array(true, 'Manage Site','#','fa fa-cogs', array(
                        array('Basic Settings','basic-settings','fa fa-circle-o'),
                        array('Maintenance','maintenance','fa fa-circle-o'),
                        array('Captcha Protection','captcha-protection','fa fa-circle-o'),
                        array('Ban IP Address','ban-ip-address','fa fa-circle-o'),
                        array('DDoS Protection','ddos-protection','fa fa-circle-o'),
                        array('Adblock Detection','adblock-detection','fa fa-circle-o'),
                  ));

$menuBarLinks['3'] = array(true, 'Analytics','#','fa fa-bar-chart', array(
                        array('Overview','analytics-overview','fa fa-circle-o'),
                        array('Overall Report','overall-report','fa fa-circle-o'),
                        array('Visitors Log','visitors-log','fa fa-circle-o'),
                        array('Recent History','recent-history','fa fa-circle-o'),
                        array('Who\'s Online','who-online','fa fa-circle-o'),
                ));
                        
$menuBarLinks['4'] = array(true, 'Website Reviewer','#','fa fa-search', array(
                        array('All Domains','all-domains','fa fa-circle-o'),
                        array('Banned Domains','banned-domains','fa fa-circle-o'),
                        array('Bad Word Filter','bad-word-filter','fa fa-circle-o'),
                        array('Reviewer Settings','reviewer-settings','fa fa-circle-o'),
                  ));
$menuBarLinks['5'] = array(true, 'Advertisements','site-ads','fa fa-usd');
$menuBarLinks['6'] = array(true, 'Email Setup','#','fa fa-envelope-o', array(
                        array('Send Email','send-email','fa fa-circle-o'),
                        array('Email Templates','mail-templates','fa fa-circle-o'),
                        array('Mail Settings','mail-settings','fa fa-circle-o'),
                        
                  ));
$menuBarLinks['7'] = array(true, 'Administrators','admin-accs','fa fa-server');
$menuBarLinks['8'] = array(true, 'Users','#','fa fa-group', array(
                        array('Add User','add-user','fa fa-circle-o'),
                        array('Manage Users','manage-users','fa fa-circle-o'),
                        array('Settings','user-settings','fa fa-circle-o'),
                        
                  ));

$menuBarLinks['9'] = array(true, 'Pages','#','fa fa-file-o', array(
                        array('Create a Page','manage-pages/page/add','fa fa-circle-o'),
                        array('Create a Link','manage-pages/link/add','fa fa-circle-o'),
                        array('Manage Pages','manage-pages','fa fa-circle-o'),
                  ));
                  
$menuBarLinks['10'] = array(true, 'Interface','#','fa fa-desktop', array(
                        array('Create New Language','language-editor/add','fa fa-circle-o'),
                        array('Language Editor','language-editor','fa fa-circle-o'),
                        array('Manage Themes','manage-themes','fa fa-circle-o'),
                        array('Interface Settings','interface','fa fa-circle-o'),
                  ));
                  
$menuBarLinks['11'] = array(true, 'Sitemap','sitemap','fa fa-sitemap');
                 
$menuBarLinks['12'] = array(true, 'Miscellaneous','miscellaneous','fa fa-bolt');
$menuBarLinks['13'] = array(true, 'Addons','#','fa fa-plus-circle', array(
                        array('Install Addons','manage-addons','fa fa-circle-o'),
                        array('Shop Addons','shop-addons','fa fa-circle-o'),
                  ));
$menuBarLinks['14'] = array(true, 'Cron Job','cron-job','fa fa-cogs');     
$menuBarLinks['15'] = array(true, 'Error Log Viewer','error-log-viewer','fa fa-exclamation-triangle');
$menuBarLinks['16'] = array(true, 'PHP Information','php-info-viewer','fa fa-info-circle');      

$menuBarLinks['17'] = array(true, 'ADVANCED FEATURES (BETA)','header-li','fa fa-lock');
$menuBarLinks['18'] = array(true, 'File Manager','exploder/index.php?login','fa fa-file');
$menuBarLinks['18A'] = array(true, 'Database Editor','exploder/db-editor.php','fa fa-database');
$menuBarLinks['19'] = array(true, 'Database Backup','database-backup','fa fa-hdd-o');
$menuBarLinks['20'] = array(true, 'License Change','license-change','fa fa-key');