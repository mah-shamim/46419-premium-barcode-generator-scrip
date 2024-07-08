<?php

defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: KOVATZ Seo Tools
 * @copyright � 2022 KOVATZ.COM
 *
 */

$fullLayout = 1;
$pageTitle = 'Reports';
$subTitle = 'Overall Report';

$stats = array();
$stats['banned_user'] = 0; $stats['unverified'] = 0; $stats['banned_ips'] = 0; $stats['total_users'] = 0;
$stats['cached'] = $stats['competitive'] = $stats['page_view'] = $stats['unique_view'] = 0;

$result = mysqli_query($con, 'SELECT verified FROM users');
while ($row = mysqli_fetch_array($result)){
    $stats['total_users'] = $stats['total_users'] + 1;
    if ($row['verified'] == '2')
        $stats['banned_user'] = $stats['banned_user'] + 1;
    if ($row['verified'] == '0')
        $stats['unverified'] = $stats['unverified'] + 1;
}

$stats['banned_ips'] = dbCountRows($con, 'banned_ip');
$stats['cached'] = dbCountRows($con, 'domains_data');
$stats['competitive'] = dbCountRows($con, 'comp_recent_history');
$stats = array_map("number_format", $stats);

$AsifCount = 1; $tableData = '';
foreach(getTrackViews($con) as $dbDate=>$views){
    $tableData .= '<tr>
        <td>'.$AsifCount.'</td>
        <td>'.date('F jS Y', strtotime($dbDate)).'</td>
        <td>'.$views['unique'].'</td>
        <td>'.$views['ses'].'</td>
        <td>'.$views['views'].'</td>
    </tr>';
    $AsifCount++;
}

?>