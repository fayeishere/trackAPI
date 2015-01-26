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

  if( empty($_GET['id']) ){
    // fail gracefully
    $trackid = '28701727555';

    // header("HTTP/1.1 404 OK");
    // header('Content-Type: application/json');
    // $json = "{ 'Response' : 'Error', 'Message' : 'Tracking ID required.' }";
    // echo $json;
    // exit();
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