<?php
defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: Rainbow PHP Framework
 * @copyright 2022 KOVATZ.COM
 *
 */

//AJAX ONLY 

//Theme Switcher
if($pointOut == 'theme'){
    if($args[1] == 'frontend'){
        $themeDirName = $args[2];
        if(setTheme($con,$themeDirName)){
            header('Location: '. adminLink('manage-themes/success',true));
        }else{
            header('Location: '. adminLink('manage-themes/failed',true));
        }
    }
    die();
}

//Upload Handler - Mail Attachments
if($pointOut == 'phpinfo'){
    phpinfo();
    die();
}

//Upload Handler - Mail Attachments
if($pointOut == 'mail-upload'){
    $upload_handler = new uploadhandler();
    die();
}

//Visitors Log
if($pointOut == 'visitors-range'){

$startDate = $args[0];
$endDate = $args[1];

require_once(LIB_DIR.'geoip.inc');
$gi = geoip_open(LIB_DIR.'GeoIP.dat', GEOIP_MEMORY_CACHE);
$giv6 = geoip_open(LIB_DIR.'GeoIPv6.dat', GEOIP_MEMORY_CACHE);
$flagPath = ROOT_DIR.'resources'.D_S.'flags'.D_S.'default'.D_S.'24'.D_S;
$iconPath = ROOT_DIR.'resources'.D_S.'icons'.D_S;
$flagLink = $baseURL.'resources/flags/default/24/';
$iconLink = $baseURL.'resources/icons/';
$screenLink = $iconLink.'screen.png';
$rainbowTrackAsif = '';

if($startDate == $endDate){
$date = $startDate;
$datas = array_reverse(getTrackRecords($date,$con));
foreach($datas as $ip => $ses){
    foreach($ses as $sesID => $data){
        if(isValidIPv6($ip))
            $userCountryCode = geoip_country_code_by_addr_v6($giv6, $ip);
        else
            $userCountryCode = geoip_country_code_by_addr($gi, $ip);
        $userCountry = country_code_to_country($userCountryCode);
        $userCountry = ($userCountry == '') ? 'Unknown' : $userCountry;
        if(file_exists($flagPath.strtolower(Trim($userCountry)).'.png'))
            $coLink = $flagLink.strtolower(Trim($userCountry)).'.png';
        else
            $coLink = $flagLink.'unknown.png';
        $uaInfo = parse_user_agent($data['ua']);
        if(file_exists($iconPath.strtolower($uaInfo['platform']).'.png'))
            $osLink = $iconLink.strtolower($uaInfo['platform']).'.png';
        else
            $osLink = $iconLink.'unknown.png';
        if(file_exists($iconPath.strtolower($uaInfo['browser']).'.png'))
            $browserLink = $iconLink.strtolower($uaInfo['browser']).'.png';
        else
            $browserLink = $iconLink.'unknown.png';  
            
        $pageData = '';
        foreach($data['pages'] as $pageV){
            $pageData .= '<div class="pagesWell"><a target="_blank" href="'.$pageV[0].'">'.$pageV[0].'</a><br>
            Hits: '.$pageV[1].' <br>
            Last Visit: '.date('h:i:s A',$pageV[2]).'</div>
            ';
        }
        
        if($data['ref'] != 'Direct'){
            $data['ref'] = '<a hre="'.$data['ref'].'" target="_blank">'.getDomainName($data['ref']).'</a>';
        }
        
        if(strtolower($data['username']) == 'guest')
            $username = 'Guest Visitor';
        else
            $username = ucfirst($data['username']);
        $rainbowTrackAsif .= '
        <tr>
            <td>
            <img src="'.$coLink.'" alt="'.$userCountryCode.'" />  <strong class="b16">'.ucfirst($userCountry).'</strong><br><br>
            <strong>'.date('F jS Y h:i:s A',$data['time']).'</strong> <br>
            Username: '.$username.'<br>
            Page Views: '.$data['pageview'].'<br>
            IP: <span class="badge" style="background-color: '.rndFlatColor().' !important;">'.$ip.'</span><br><br>
            Entry: '.$data['ref'].'<br>
            </td>
            <td><img data-toggle="tooltip" data-placement="top" title="Operating System: '.$uaInfo['platform'].'" src="'.$osLink.'" alt="'.$uaInfo['platform'].'" />
            <img data-toggle="tooltip" data-placement="top" title="Browser: '.$uaInfo['browser'].' '.$uaInfo['version'].'" src="'.$browserLink.'" alt="'.$uaInfo['browser'].'" />
            <img data-toggle="tooltip" data-placement="top" title="Screen Resolution: '.$data['screen'].'" src="'.$screenLink.'" />
            </td>
            <td>'.$pageData.'</td>
        </tr>
        
        ';
    }
}

}else{
$diff = 0;
$datetime1 = date_create($startDate);
$datetime2 = date_create($endDate);
$interval = date_diff($datetime1, $datetime2);
$diff =  $interval->format('%a');
if($diff >= 366){
    $rainbowTrackAsif = '<tr><td style="color: red;"><b>Date range must not greater than one year between two dates!</b></td><td style="display: none;"></td><td style="display: none;"></td></tr>';
}else{
$masterDatas = array_reverse(getTrackRecordsRange($startDate,$endDate,$con));
foreach($masterDatas as $datas){
foreach($datas as $ip => $ses){
    foreach($ses as $sesID => $data){
        if(isValidIPv6($ip))
            $userCountryCode = geoip_country_code_by_addr_v6($giv6, $ip);
        else
            $userCountryCode = geoip_country_code_by_addr($gi, $ip);
        $userCountry = country_code_to_country($userCountryCode);
        $userCountry = ($userCountry == '') ? 'Unknown' : $userCountry;
        if(file_exists($flagPath.strtolower(Trim($userCountry)).'.png'))
            $coLink = $flagLink.strtolower(Trim($userCountry)).'.png';
        else
            $coLink = $flagLink.'unknown.png';
        $uaInfo = parse_user_agent($data['ua']);
        if(file_exists($iconPath.strtolower($uaInfo['platform']).'.png'))
            $osLink = $iconLink.strtolower($uaInfo['platform']).'.png';
        else
            $osLink = $iconLink.'unknown.png';
        if(file_exists($iconPath.strtolower($uaInfo['browser']).'.png'))
            $browserLink = $iconLink.strtolower($uaInfo['browser']).'.png';
        else
            $browserLink = $iconLink.'unknown.png';  
            
        $pageData = '';
        foreach($data['pages'] as $pageV){
            $pageData .= '<div class="pagesWell"><a target="_blank" href="'.$pageV[0].'">'.$pageV[0].'</a><br>
            Hits: '.$pageV[1].' <br>
            Last Visit: '.date('h:i:s A',$pageV[2]).'</div>
            ';
        }
        
        if($data['ref'] != 'Direct'){
            $data['ref'] = '<a hre="'.$data['ref'].'" target="_blank">'.getDomainName($data['ref']).'</a>';
        }
        
        if(strtolower($data['username']) == 'guest')
            $username = 'Guest Visitor';
        else
            $username = ucfirst($data['username']);
        $rainbowTrackAsif .= '
        <tr>
            <td>
            <img src="'.$coLink.'" alt="'.$userCountryCode.'" />  <strong class="b16">'.ucfirst($userCountry).'</strong><br><br>
            <strong>'.date('F jS Y h:i:s A',$data['time']).'</strong> <br>
            Username: '.$username.'<br>
            Page Views: '.$data['pageview'].'<br>
            IP: <span class="badge" style="background-color: '.rndFlatColor().' !important;">'.$ip.'</span><br><br>
            Entry: '.$data['ref'].'<br>
            </td>
            <td><img data-toggle="tooltip" data-placement="top" title="Operating System: '.$uaInfo['platform'].'" src="'.$osLink.'" alt="'.$uaInfo['platform'].'" />
            <img data-toggle="tooltip" data-placement="top" title="Browser: '.$uaInfo['browser'].' '.$uaInfo['version'].'" src="'.$browserLink.'" alt="'.$uaInfo['browser'].'" />
            <img data-toggle="tooltip" data-placement="top" title="Screen Resolution: '.$data['screen'].'" src="'.$screenLink.'" />
            </td>
            <td>'.$pageData.'</td>
        </tr>
        
        ';
    }
}
    
}

}
}

geoip_close($gi);
geoip_close($giv6);
echo $rainbowTrackAsif;
die();
}

//Fix for PDO connection with custom port number
$dbHostArr = explode(':',$dbHost);
if(isset($dbHostArr[1]))
    $dbHost = $dbHostArr[0].';port='.$dbHostArr[1];

//Get all customers informations
if($pointOut == 'manageUsers'){
    // DB table to use
    $table = 'users';
    
    // Table's primary key
    $primaryKey = 'id';
    
    // Database columns
    $columns = array(
    	array( 'db' => 'username', 'dt' => 0 ),
    	array( 'db' => 'full_name', 'dt' => 1 ),
    	array( 'db' => 'email_id',  'dt' => 2 ),
    	array( 'db' => 'added_date',  'dt' => 3),
    	array( 'db' => 'platform',   'dt' => 4 ),
    	array( 'db' => 'oauth_uid',   'dt' => 5 ),
    	array( 'db' => 'id',   'dt' => 6 ),
    	array( 'db' => 'verified',   'dt' => 7 )
    );
    
    $columns2 = array(
    	array( 'db' => 'username', 'dt' => 0 ),
    	array( 'db' => 'full_name', 'dt' => 1 ),
    	array( 'db' => 'email_id',  'dt' => 2 ),
    	array( 'db' => 'added_date',  'dt' => 3),
    	array( 'db' => 'platform',   'dt' => 4 ),
    	array( 'db' => 'oauth_uid',   'dt' => 5 ),
    	array( 'db' => 'ban',  'dt' => 6 ),
    	array( 'db' => 'actions',   'dt' => 7)
    );
    
    
    // SQL connection information
    $sql_details = array(
    	'user' => $dbUser,
    	'pass' => $dbPass,
    	'db'   => $dbName,
    	'host' => $dbHost
    );
    
    echo json_encode(
    	SSPUSER::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $columns2 )
    );
    die();   
}

//Get all pages informations
if($pointOut == 'managePages'){
    // DB table to use
    $table = 'pages';
    
    // Table's primary key
    $primaryKey = 'id';
    
    // Database columns
    $columns = array(
    	array( 'db' => 'sort_order',   'dt' => 0 ),
    	array( 'db' => 'page_name',  'dt' => 1 ),
    	array( 'db' => 'page_title',  'dt' => 2),
    	array( 'db' => 'posted_date', 'dt' => 3 ),
    	array( 'db' => 'type',   'dt' => 4 ),
    	array( 'db' => 'status',   'dt' => 5 ),
    	array( 'db' => 'id',   'dt' => 6 ),
    	array( 'db' => 'page_url',   'dt' => 7 )
    );
    
    $columns2 = array(
    	array( 'db' => 'sort_order',  'dt' => 0 ),
    	array( 'db' => 'page_name',  'dt' => 1 ),
    	array( 'db' => 'page_title',  'dt' => 2),
    	array( 'db' => 'type',  'dt' => 3),
    	array( 'db' => 'posted_date', 'dt' => 4),
    	array( 'db' => 'status',   'dt' => 5 ),
    	array( 'db' => 'actions',   'dt' => 6 )
    );
    
    
    // SQL connection information
    $sql_details = array(
    	'user' => $dbUser,
    	'pass' => $dbPass,
    	'db'   => $dbName,
    	'host' => $dbHost
    );
    
    echo json_encode(
    	SSPPAGE::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $columns2 )
    );
    die();   
}

//Get all domains informations
if($pointOut == 'allDomains'){
    // DB table to use
    $table = 'domains_data';
    
    // Table's primary key
    $primaryKey = 'id';
    
    // Database columns
    $columns = array(
    	array( 'db' => 'domain',   'dt' => 0 ),
    	array( 'db' => 'date',  'dt' => 1 ),
    	array( 'db' => 'completed',  'dt' => 2),
    	array( 'db' => 'score', 'dt' => 3 ),
    	array( 'db' => 'id',   'dt' => 4 )
    );
    
    $columns2 = array(
    	array( 'db' => 'domain',  'dt' => 0 ),
    	array( 'db' => 'date',  'dt' => 1 ),
    	array( 'db' => 'completed',  'dt' => 2),
    	array( 'db' => 'score',  'dt' => 3),
    	array( 'db' => 'export', 'dt' => 4),
    	array( 'db' => 'actions',   'dt' => 5 )
    );
    
    
    // SQL connection information
    $sql_details = array(
    	'user' => $dbUser,
    	'pass' => $dbPass,
    	'db'   => $dbName,
    	'host' => $dbHost
    );
    
    echo json_encode(
    	ALLDOMAINS::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $columns2 )
    );
    die();   
}

//Domains History
if($pointOut == 'domainHistory'){
    // DB table to use
    $table = 'recent_history';
    
    // Table's primary key
    $primaryKey = 'id';
    
    //Load GEO Library
    require_once(LIB_DIR.'geoip.inc');
    $gi = geoip_open(LIB_DIR.'GeoIP.dat', GEOIP_MEMORY_CACHE);
    $giv6 = geoip_open(LIB_DIR.'GeoIPv6.dat', GEOIP_MEMORY_CACHE);
    
    // Database columns
    $columns = array(
    	array( 'db' => 'domain_name',   'dt' => 0 ),
    	array( 'db' => 'username',  'dt' => 1 ),
    	array( 'db' => 'date',  'dt' => 2),
    	array( 'db' => 'visitor_ip', 'dt' => 3 ),
    	array( 'db' => 'id',   'dt' => 4 )
    );
    
    $columns2 = array(
    	array( 'db' => 'domain_name',  'dt' => 0 ),
    	array( 'db' => 'username',  'dt' => 1 ),
    	array( 'db' => 'date',  'dt' => 2),
    	array( 'db' => 'visitor_ip',  'dt' => 3),
    	array( 'db' => 'country', 'dt' => 4),
    	array( 'db' => 'actions',   'dt' => 5)
    );
    
    
    // SQL connection information
    $sql_details = array(
    	'user' => $dbUser,
    	'pass' => $dbPass,
    	'db'   => $dbName,
    	'host' => $dbHost
    );
    
    echo json_encode(
    	DOMAINHISTORY::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $columns2,$gi,$giv6)
    );
    geoip_close($gi);
    geoip_close($giv6);
    die();   
}

//Competitive Analysis History
if($pointOut == 'comHistory'){
    // DB table to use
    $table = 'comp_recent_history';
    
    // Table's primary key
    $primaryKey = 'id';
    
    //Load GEO Library
    require_once(LIB_DIR.'geoip.inc');
    $gi = geoip_open(LIB_DIR.'GeoIP.dat', GEOIP_MEMORY_CACHE);
    $giv6 = geoip_open(LIB_DIR.'GeoIPv6.dat', GEOIP_MEMORY_CACHE);
    
    // Database columns
    $columns = array(
    	array( 'db' => 'first_domain',   'dt' => 0 ),
    	array( 'db' => 'sec_domain',   'dt' => 1 ),
    	array( 'db' => 'username',  'dt' => 2 ),
    	array( 'db' => 'date',  'dt' => 3),
    	array( 'db' => 'visitor_ip', 'dt' => 4 ),
    	array( 'db' => 'id',   'dt' => 5 )
    );
    
    $columns2 = array(
    	array( 'db' => 'first_domain',   'dt' => 0 ),
    	array( 'db' => 'sec_domain',   'dt' => 1 ),
    	array( 'db' => 'username',  'dt' => 2 ),
    	array( 'db' => 'date',  'dt' => 3),
    	array( 'db' => 'visitor_ip',  'dt' => 4),
    	array( 'db' => 'country', 'dt' => 5),
    	array( 'db' => 'actions',   'dt' => 6)
    );
    
    
    // SQL connection information
    $sql_details = array(
    	'user' => $dbUser,
    	'pass' => $dbPass,
    	'db'   => $dbName,
    	'host' => $dbHost
    );
    
    echo json_encode(
    	COMHISTORY::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $columns2,$gi,$giv6)
    );
    geoip_close($gi);
    geoip_close($giv6);
    die();   
}

if($pointOut == 'getCustomers'){
    $data = array();
    $term = escapeTrim($con,$_GET['term']);
    $qstring = "SELECT username,id,email_id,date FROM users WHERE username LIKE '%".$term."%'";
    $result = mysqli_query($con,$qstring);
    
    while ($row = mysqli_fetch_array($result)){
            $data[] = $row['username'].'|'.$row['email_id'].'|'.$row['date'].'|'.$row['id'];
    }
    echo json_encode($data);
    die();
}

die();