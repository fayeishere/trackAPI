<?php

  require_once('./APIconfig.php.inc');
  //Configuration
  $access = UPSaccess;
  $userid = UPSuserid;
  $passwd = UPSpasswd;

  $wsdl = getcwd() . "/Track.wsdl"; // case sensitive!
  $operation = "ProcessTrack";
  $endpointurl = 'https://onlinetools.ups.com/webservices/Track';
  $outputFileName = getcwd() . "/XOLTResult.xml";

  if( empty($_GET['id']) ){
    // fail gracefully
    header("HTTP/1.1 404 OK");
    header('Content-Type: application/json');
    $json = "{ 'Response' : 'Error', 'Message' : 'Tracking ID required.' }";
    echo $json;
    exit();
  }

  function processTrack()
  {
      //create soap request
    $req['RequestOption'] = '15';
    $tref['CustomerContext'] = 'Add description here';
    $req['TransactionReference'] = $tref;
    $request['Request'] = $req;
    $request['InquiryNumber'] = $_GET['id'];
 	  $request['TrackingOption'] = '02';

    // echo "Request.......\n";
    // print_r($request);
    // echo "\n\n";

    return $request;
  }

  try
  {

    $mode = array
    (
         'soap_version' => 'SOAP_1_1',  // use soap 1.1 client
         'trace' => 1
    );

    // initialize soap client
  	$client = new SoapClient($wsdl , $mode);

  	//set endpoint url
  	$client->__setLocation($endpointurl);


    //create soap header
    $usernameToken['Username'] = $userid;
    $usernameToken['Password'] = $passwd;
    $serviceAccessLicense['AccessLicenseNumber'] = $access;
    $upss['UsernameToken'] = $usernameToken;
    $upss['ServiceAccessToken'] = $serviceAccessLicense;

    $header = new SoapHeader('http://www.ups.com/XMLSchema/XOLTWS/UPSS/v1.0','UPSSecurity',$upss);
    $client->__setSoapHeaders($header);


    //get response
  	$resp = $client->__soapCall($operation ,array(processTrack()));

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