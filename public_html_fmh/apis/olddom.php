<?php
// OLD DOMINION 
/*
No account needed.

https://www.odfl.com/WebServiceSignup/
https://www.odfl.com/Trace/standardResult.faces?pro=28701727555

Carrier = Old Dominion (PO#/Tracking#)
00847009644339 – 28701727530
00847009653607 – 28701727548
00847009653931 – 28701727555
*/
// error_reporting(0);
/*
$statuses = array(
'ACC'=>'Call Local Service Center',
'AFD'=>'Call Local Service Center',
'AGO'=>'Tendered to Agent or Partner',
'AGT'=>'Out for delivery by Agent or Partner APD Arrived at',
'APN'=>'Call Local Service Center ARD Call Local Service Center ARR Arrived at',
'ATD'=>'Recipient Unavailable BIS Call Local Service Center BKD Call Local Service Center Cal Call 1-800-235-5569 CLO Closed out to',
'CPD'=>'Closed out for local delivery D-L Call Local Service Center DEL Delivered',
'ENR'=>'In Transit to',
'EPD'=>'Out for delivery',
'FBE'=>'Entered into billing system',
'H-L'=>'Call Local Service Center',
'HFC'=>'Held For Customs 1-800-235-5569',
'IBP'=>'Interline to Business Partner',
'INT'=>'Interlined to another carrier',
'LSP'=>'Dropped at its destination',
'MPD'=>'Call Local Service Center',
'OFD'=>'Out for delivery',
'OFL'=>'Call Local Service Center',
'ONL'=>'Call Local Service Center',
'OTD'=>'On the dock at',
'P&D'=>'Out for delivery',
'PAD'=>'Picked up at the dock',
'PCS'=>'Call Local Service Center',
'PKU'=>'Picked up',
'RDC'=>'Call Local Service Center',
'RPD'=>'Call Local Service Center',
'SEC'=>'Call Local Service Center',
'SET'=>'Loaded out at',
'SPD'=>'Loaded out for delivery',
'SPP'=>'Dropped at consignee',
'SPT'=>'Dropped at consignee',
'TPD'=>'Awaiting Delivery',
'UNL'=>'Unloading at',
'UPD'=>'Unloading at',
'VOD'=>'Call Local Service Center',
'PKL'=>'FINISHED LOADING AT PU LOCATION DEV DELIVERED',
'BOK'=>'Booking in Process',
'CDC'=>'Cleared Customs',
'CET'=>'On Hold By Customs',
'CFS'=>'On Hold at CFS',
'DMR'=>'In Demurrage',
'DVN'=>'Being Stripped',
'GNO'=>'In General Order',
'HLD'=>'Delayed By Ocean Carrier',
'OWT'=>'On the Water',
'APE'=>'add a pro to an enroute trailer',
'RPE'=>'remove pro from an enroute trailer',
'DCC'=>'DOCUMENTS SUBMITTED TO CUSTOMS EAD Estimated Arrival at Destination Port',
'ADT'=>'ARRIVED AT DESTINATION PORT',
'OTB'=>'Shipment Discharged',
'EPX'=>'Void Out for delivery',
'GTO'=>'ON DEMAND SHPMT - CALL 1-866-ODSPEED BRC'=>'Booking Order Received',
'BCF'=>'Booking Order Confirmed',
'CRL'=>'Carrier Released',
'VAP'=>'Inland Transit',
'ERT'=>'Container Returned Empty',
'SLV'=>'Loaded on Vessel',
'EDS'=>'Empty Equipment Dispatched',
'DSV'=>'At Port Of Discharge',
'APA'=>'Add pro to ARR/RLY trailer',
'BRK'=>'Call 1-800-235-5569',
'ERP'=>'In Tran Pku',
'ERD'=>'In Tran Del',
'APU'=>'Arrive Pick up',
'PCF'=>'Pending Confirmation',
'PRR'=>'PARS Rejected',
'PRA'=>'PARS Accepted',
'PAP'=>'PARS ACC', 'PENDING REL',
'OHF'=>'On hold at Factory',
'OHC'=>'Customs Hold Origin',
'CDS'=>'Released from CFS',
'CEC'=>'Customs Exam Complete',
);
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

  try
  {
  	// getting malformed request errors

    $mode = array
    (
         'soap_version' => 'SOAP_1_1',  // use soap 1.1 client
         'trace' => 1
    );

    // initialize soap client
  	$client = new SoapClient( getcwd() . "/Trace.wsdl", $mode );

  	$params = new stdClass();
	$params->pro = $trackid;
	$params->type = 'P';

	$resp = $client->getTraceData( $params );

    header("HTTP/1.1 200 OK");
    header('Content-Type: application/json');
    $json = json_encode($resp);
    echo $json;

  }
  catch(Exception $ex)
  {

  	$resp = DOMDocument::loadHTMLFile('https://www.odfl.com/Trace/standardResult.faces?pro='.$trackid);
  	/*
	grab everything in:
  	$resp->textContent);
  	between "Detailed Data" and "Email Notification"

	>> Pro Number: 28701727555
	Delivery Date|1/13/2015
	Status|Delivered
	Pieces|2
	Weight|375
	PO#|00847009653931                 
	BOL#|168530
	Signature|DAVID
	Origin|FORT LAUDERDALE, FL 33312
	Origin SC|POM - POMPANO BEACH, FL
	Destination|PHOENIX, AZ 85019
	Destination SC|PHX - PHOENIX, AZ
	*/
	preg_match("'Detailed Data(.*?)Email Notification'si", $resp->textContent, $matches);
	if( sizeof( $matches > 1 ) ){
		// let's at least scrape it & get some baseline info...
		$toparse = $matches[1];
		$resp = array();

		preg_match("'Status(.*?)Pieces'si", $toparse, $matches);
		$resp['status'] = $matches[1];

		if( $resp['status'] == 'Delivered' ){
			// fetch Delivery Date - don't know if this is sent when the status is anything else
			preg_match("'Delivery Date(.*?)Status'si", $toparse, $matches);
			$resp['delivery_date'] = $matches[1];
			$resp['delivered'] = "Y";
		}

		preg_match("'Destination(.*?)Destination SC'si", $toparse, $matches);
		$resp['destAddress'] = $matches[1];  	

	    header("HTTP/1.1 200 OK");
	    header('Content-Type: application/json');

	    $json = json_encode($resp);
	    echo $json;
	}
	else
	{
		// output error
	    header("HTTP/1.1 500 OK");
	    header('Content-Type: application/json');
	    $json = json_encode($ex);
	    echo $json;
	}
  }

?>