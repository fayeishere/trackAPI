<?php
// FedEx. 
/*
https://www.fedex.com/apps/fedextrack/?action=track&trackingnumber=3056440424&cntry_code=us
Sample Tracking#’s: 3893510222, 3056450751, 3056440424     
*/

//Configuration
require_once('./APIconfig.php.inc');

if( empty($_GET['id']) ){
	$trackid = "3893510222";
	// fail gracefully
	// header("HTTP/1.1 404 OK");
	// header('Content-Type: application/json');
	// $json = "{ 'Response' : 'Error', 'Message' : 'Tracking ID required.' }";
	// echo $json;
	// exit();
}
else $trackid = $_GET['id'];

$path_to_wsdl = getcwd() . "/fedEx/TrackService_v9.wsdl"; // case sensitive!

// Copyright 2009, FedEx Corporation. All rights reserved.
// Version 6.0.0

require_once('fedEx/library/fedex-common.php5');

ini_set("soap.wsdl_cache_enabled", "0");

$client = new SoapClient($path_to_wsdl, array('trace' => 1)); // Refer to http://us3.php.net/manual/en/ref.soap.php for more information

$request['WebAuthenticationDetail'] = array(
	'UserCredential' =>array(
		'Key' => FedExKey,
		'Password' => FedExPasswd
	)
);
$request['ClientDetail'] = array(
	'AccountNumber' => '510087909', 
	'MeterNumber' => '118676572'
);
$request['TransactionDetail'] = array('CustomerTransactionId' => '*** Track Request using PHP ***');
$request['Version'] = array(
	'ServiceId' => 'trck', 
	'Major' => '9', 
	'Intermediate' => '1', 
	'Minor' => '0'
);
$request['SelectionDetails'] = array(
	'PackageIdentifier' => array(
		'Type' => 'TRACKING_NUMBER_OR_DOORTAG',
		'Value' => $trackid // Replace 'XXX' with a valid tracking identifier
	)
);

try {
	if(setEndpoint('changeEndpoint')){
		$newLocation = $client->__setLocation(setEndpoint('endpoint'));
	}
	
	$response = $client ->track($request);

    if ($response -> HighestSeverity != 'FAILURE' && $response -> HighestSeverity != 'ERROR'){
		if($response->HighestSeverity != 'SUCCESS'){
			echo '<table border="1">';
			echo '<tr><th>Track Reply</th><th>&nbsp;</th></tr>';
			trackDetails($response->Notifications, '');
			echo '</table>';
		}else{
	    	if ($response->CompletedTrackDetails->HighestSeverity != 'SUCCESS'){
				echo '<table border="1">';
			    echo '<tr><th>Shipment Level Tracking Details</th><th>&nbsp;</th></tr>';
			    trackDetails($response->CompletedTrackDetails, '');
				echo '</table>';
			}else{
				echo '<table border="1">';
			    echo '<tr><th>Package Level Tracking Details</th><th>&nbsp;</th></tr>';
			    trackDetails($response->CompletedTrackDetails->TrackDetails, '');
				echo '</table>';
			}
		}
        printSuccess($client, $response);
    }else{
        printError($client, $response);
    } 

	var_dump($client); die();

    //get response
  	$resp = $client->__soapCall($operation ,array(processTrack()));    
    writeToLog($client);    // Write to log file   

    header("HTTP/1.1 200 OK");
    header('Content-Type: application/json');
    $json = json_encode($resp);
    echo $json;

} catch (SoapFault $exception) {
    printFault($exception, $client);
}
