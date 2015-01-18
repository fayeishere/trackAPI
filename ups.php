<?php

  //Configuration
  $access = "";
  $userid = "";
  $passwd = "";

  $wsdl = "track.wsdl";
  $operation = "ProcessTrack";
  $endpointurl = 'https://onlinetools.ups.com/webservices/Track';
  $outputFileName = "XOLTResult.xml";

  function processTrack()
  {
      //create soap request
    $req['RequestOption'] = '15';
    $tref['CustomerContext'] = 'Add description here';
    $req['TransactionReference'] = $tref;
    $request['Request'] = $req;
    $request['InquiryNumber'] = '576235903';
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

$xml = $client->__getLastResponse();
// header('Content-Type: text/xml');
// print_r($xml);
$json = json_encode($resp);
// $jsonObj = json_encode((array)$resp );
// $array = json_decode($json,TRUE);

//     //save soap request and response to file
//     $xml = $client->__getLastResponse();


// $p = xml_parser_create();
// xml_parse($p,$xml,true);

// xml_parse_into_struct($p, $xml, $vals, $index);
// xml_parser_free($p);
// echo "Index array\n";
// print_r($index);
// echo "\nVals array\n";
// print_r($vals);




    // echo $xml;

    // $xml = simplexml_load_string($client->__last_response);
    // if ($xml === false) {
    //     echo "Failed loading XML: ";
    //     foreach(libxml_get_errors() as $error) {
    //         echo "<br>", $error->message;
    //     }
    // } else {
    //     print_r($xml);
    // }

    // header('Content-Type: application/json');
    // echo json_encode($client);
    // $fw = fopen($outputFileName , 'w');
    // fwrite($fw , "Request: \n" . $client->__getLastRequest() . "\n");
    // fwrite($fw , "Response: \n" . $client->__getLastResponse() . "\n");
    // fclose($fw);

  }
  catch(Exception $ex)
  {
  	print_r ($ex);
  }

?>
