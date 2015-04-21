<?php
// Averitt
/*
https://www.averittexpress.com/action/trackingDetails?orderId=0742649691&serviceType=LTL
Sample Tracking#’s: 0742649138, 0742649133, 0742649138
*/

if( empty($_GET['id']) ){
	// $trackid = "0742649138";
	// fail gracefully
	header("HTTP/1.1 404 OK");
	header('Content-Type: application/json');
	$json = "{ 'Response' : 'Error', 'Message' : 'Tracking ID required.' }";
	echo $json;
	exit();
}
else $trackid = $_GET['id'];

$url = "https://www.averittexpress.com/action/trackingDetails?serviceType=LTL&orderId=".$trackid;
$response = array();
$resp = file_get_contents($url);

/* 
parse out interesting data: status
----
<p class="h1 branded quote-price">Delivered</p>
*/

preg_match('/<p class="h1 branded quote-price"\>(.*)/', $resp, $matches);
	// $matches[0] will contain the text that matched the full pattern, 
	// $matches[1] will have the text that matched the first captured parenthesized subpattern, and so on.
$response['status'] = strip_tags($matches[1]);

/* 
parse out interesting data: shipment_history
----
<h2 class="field-header" id="shipment-progression">Shipment Progression</h2>
<div class="field-container">
    
        
            <table class="data display-tag-data">
                <thead>
                    <tr>
                        <th scope="col">Location</th>
                        <th scope="col">Date/Time</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                ...
                </tbody>
            </table>
*/

$start = strpos($resp, 'shipment-progression');
$out = substr($resp, $start);

$startsAt = strpos($out, "<table") + strlen("<table");
$endsAt = strpos($out, "</table>", $startsAt);
$out = substr($out, $startsAt-6, $endsAt-$startsAt+14);

$response['shipment_history'] = str_replace('class="data display-tag-data"','width="100%" class="dataTable" id="carrierActivity"',$out);
// id="carrierActivity" border="0" cellpadding="0" cellspacing="0" class="dataTable

header("HTTP/1.1 200 OK");
header('Content-Type: application/json; charset=utf-8');

$json = json_encode($response);
echo $json;
?>