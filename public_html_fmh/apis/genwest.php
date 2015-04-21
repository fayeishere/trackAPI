<?php
// Genwest
/*
http://72.165.143.35:81/cgibin/in1ssi-gen-search.htm
Sample Tracking#’s: 261800, 261835, 261753
*/

if( empty($_GET['id']) ){
	// $trackid = "261835";
	// fail gracefully
	header("HTTP/1.1 404 OK");
	header('Content-Type: application/json');
	$json = "{ 'Response' : 'Error', 'Message' : 'Tracking ID required.' }";
	echo $json;
	exit();
}
else $trackid = $_GET['id'];

$url = "http://72.165.143.35:81/inssi/cobolcgi.dll?runcobol+in1ssi-gen.cob&PRO_NUM1=".$trackid;
$response = array();
// fields that we can get, that we care about
$fields = array('CurrentLocation'=>'current_location','DeliveryStatus'=>'status');
$resp = file_get_contents($url);

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
header('Content-Type: text/plain; charset=utf-8');
$keys = split('<td', html_entity_decode($parseme[0]) );
$values = split('<td', html_entity_decode($parseme[2]) );

// var_dump($keys); die();
foreach($keys as $i => $label){
	$label = str_replace(array(' ',"\t","\n"),'',$label);
	$key = preg_replace('/[^\w-]/', '', strip_tags('<td'.$label));

	$label = str_replace(array(" ","\t","\n","\r"),'',$values[$i]);
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