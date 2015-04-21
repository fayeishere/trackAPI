<?php
// New England MF
/*
http://nemfweb.nemf.com/shptrack.nsf/request?openagent=1&pro=16033632&submit=Track
Sample Tracking#’s: 16033631, 16033632, 20891989
*/

if( empty($_GET['id']) ){
	// fail gracefully
	header("HTTP/1.1 404 OK");
	header('Content-Type: application/json');
	$json = "{ 'Response' : 'Error', 'Message' : 'Tracking ID required.' }";
	echo $json;
	exit();
}
else $trackid = $_GET['id'];

$url = "http://nemfweb.nemf.com/shptrack.nsf/request?openagent=1&submit=Track&pro=".$trackid;
$response = array();
$resp = file_get_contents($url);

// chunk of interesting data is in the only table in our 'contentBox' div
$start = strpos($resp, "contentBox");
$out = substr($resp, $start);

// then, we just want to look at the first table
$start = strpos($out, "<TABLE");
$end = strrpos($out, "</TABLE");

$out = substr($out, $start, $end-$start+8);
$response['shipment_history'] = str_replace('<TABLE', '<TABLE CLASS="dataTable" ID="carrierActivity" WIDTH="100%" BGCOLOR="#EFEFEF"', strip_tags($out,'<TABLE><TH><TR><TD><BR><BR/>'));

$parseme = split('<TR', $out);
/*
	$parseme is now an array
		[0] = keys 
		[1] = values

	there's one link we could use... <a href="RequestHistory?OpenAgent&amp;16033631&amp;04/06/2015">16033631</a>
*/
if( stristr($parseme[1], 'SIGNED BY:') ){
	// Status is Delivered
	$response['status'] = 'Delivered';
}
else{
	$response['status'] = 'See Activity';
}

header("HTTP/1.1 200 OK");
header('Content-Type: application/json; charset=utf-8');

$json = json_encode($response);
echo $json;
?>