<?php
// SAIA - needs a customer password to call API
/*
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


	DOCUMENTATION
	http://www.saiasecure.com/webservice/shipment/n_GetByProNumber.asp

	WSDL: http://www.saiasecure.com/webservice/shipment/soap.asmx?wsdl

	Saia's Pro number is 11 digits long containing only numbers with no dashes or check-digits. The entry value for the below example would be: 00410252280
	http://www.saiasecure.com/tracing/n_manifest.asp?link=y&pro=(pronumber)
	sample pro number: 00410252280 

	ACCOUNT STATUS: don't have an SAIA account, so opened one & found that it'll take 2 business days, so will see if FMP has one hiding somewhere to use instead
*/

  require_once('./APIconfig.php.inc');
  //Configuration
  $userid = SAIAuserid;
  $passwd = SAIApasswd;

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
    // initialize soap client
  	$client = new SoapClient("http://www.saiasecure.com/webservice/shipment/soap.asmx?wsdl");

	$resp = $client->GetByProNumber( array('request' => array(
  		'UserID' => $userid,
  		'Password' => $passwd,
  		'TestMode' => 'Y',
  		'ProNumber' => $trackid ))
	);
    //get status
    // echo "Response Status: " . $resp->Response->ResponseStatus->Description ."\n";    

    header("HTTP/1.1 200 OK");
    header('Content-Type: application/json');
    $json = json_encode($resp);
    echo $json;

  }
  catch(Exception $ex)
  {
  	print_r ($ex);
  }

?>