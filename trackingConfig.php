<?php

// Switch if carrier is UPS run ups.php etc and set tracking number from form
	require "ups.php";

	// just fucking around with nonsense

	// http://www.saiasecure.com/webservice/shipment/soap.asmx?op=GetByPONumber
	$thiswsdl = "trace.wsdl";
	$end = "http://www.saiasecure.com/tracing/b_manifest.asp?link=y&pro=00847009743600";
	$thismode = array
    (
         'soap_version' => 'SOAP_1_1',  // use soap 1.1 client
         'trace' => 1
    );
	$thisclient = new SoapClient($thiswsdl , $thismode);
	$thisclient->__setLocation($end);

?>
