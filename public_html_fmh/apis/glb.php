<?php
// GLB
/*
Sample Tracking#’s: 116748314, 1500041276, 116562101
http://glbtrucking.com/TrackingCentral.aspx?hawb=116562101
*/

if( empty($_GET['id']) ){
	$trackid = "116562101";
	// fail gracefully
	// header("HTTP/1.1 404 OK");
	// header('Content-Type: application/json');
	// $json = "{ 'Response' : 'Error', 'Message' : 'Tracking ID required.' }";
	// echo $json;
	// exit();
}
else $trackid = $_GET['id'];
$response = array();

$url = "http://glbtrucking.com/TrackingCentral.aspx?hawb=".$trackid;
$resp = file_get_contents($url);
var_dump($resp); die();

// chunk of interesting data is between two "hr" tags
$start = strpos($resp, "<hr");
$end = strrpos($resp, "<hr");

$out = substr($resp, $start, $end-$start);

// then, we just want to look at the first table
$start = strpos($out, "<tr");
$end = strrpos($out, "<table");

$out = substr($out, $start, $end-$start);

$parseme = split('</tr>', $out);
$out = "<table>".str_replace('bgcolor="#003399"','bgcolor="#efefef"',$out)."</table>";
$out = str_replace('style="color: #FFFFFF"','style="color: #333"',$out);
$response['shipment_history'] = str_replace(array('style="color: #FFFFFF"','<b>','</b>'),'',$out);
/*
	$parseme is now an array
		[0] = keys 
		[1] = blank
		[2] = values
*/
$keys = split('<td', html_entity_decode($parseme[0]) );
$values = split('<td', html_entity_decode($parseme[2]) );

// var_dump($keys); die();
foreach($keys as $i => $label){
	$label = str_replace(array(' ',"\t","\n"),'',$label);
	$key = preg_replace('/[^\w-]/', '', strip_tags('<td'.$label));

	$label = str_replace(array(" ","\t","\r"),'',$values[$i]);
	$label = str_replace(array("<br>","\n"),' ',$label);
	$val = trim(strip_tags('<td'.$label));

	// echo $i.": ".$key." - ".$val."\n";

	if( !empty($key) && !empty($fields[$key]) ){
		$response[ $fields[$key] ] = $val;
	}
}
/*
Now that we have our data, let's prep it for the apis.js script to handle
shipment_history' (a table)
                'status' (long string w/signage info)
                'current_location'
                'delivery_date'
*/
if( $response['current_location'] == 'Delivered' ){
	// move the data in "status" to another field & set status as "Delivered"
	$response['current_location'] = '';
	$response['delivery_date'] = str_replace('SignedBy',' -- SignedBy',$response['status']);
	$response['status'] = "Delivered";
}else{
	$response['delivery_date'] = '';
}

header("HTTP/1.1 200 OK");
header('Content-Type: application/json; charset=utf-8');

$json = json_encode($response);
echo $json;
?>