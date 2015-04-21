<?php
// ABF 
/*
https://www.abfs.com/xml/tracexml.asp?DL=2&ID=[ABFsecureid]&RefNum=[trackid]&RefType=A
Seems like API will limit tracking to an account, such that we need to know the account used to create these tracking codes

https://www.abfs.com/tools/trace/default.asp - will let you track w/out an account number

<ABF> 	  	ABF Track Data Type Definition.
  	<SHIPMENTS> 	  	Group of shipments.
  	  	<SHIPMENT> 	  	A single shipment.
  	  	<PRONUMBER> 	  	ABF pro number.
  	  	<REASSIGNMENT> 	  	"Y" if the shipment has been reassigned.
  	  	<PICKUP> 	  	Date the shipment was picked up from the shipper.
  	  	<PICKUPTIME> 	  	Time the shipment was picked up from the shipper.
  	  	<PICKUPDELAYCODE> 	  	If the pickup was delayed, the reason for the delay.
  	  	<DELIVERYDATE> 	  	Date the shipment was delivered (applies only to delivered shipments).
  	  	<DELIVERYTIME> 	  	Time the shipment was delivered (applies only to delivered shipments).
  	  	<DUEDATE> 	  	Date the shipment is due for delivery.
  	  	<EXPECTEDDELIVERYDATE> 	  	Expected delivery date for the shipment.
  	  	<APPOINTMENT> 	  	"Y" if the shipment is associated with an appointment.
  	  	<APPTDATE> 	  	Date ABF and the consignee have agreed upon for the shipment to be delivered (arrival notify).
  	  	<APPTTIME> 	  	Time ABF and the consignee have agreed upon for the shipment to be delivered (arrival notify).
  	  	<NOTIFYNAME> 	  	Name of the person ABF contacted to setup an appointment date and time to deliver the shipment (arrival notify).
  	  	<WEIGHT> 	  	Weight of the shipment.
  	  	<PIECES> 	  	Number of pieces within the shipment.
  	  	<SHORTSTATUS> 	  	The 5-character status code of the shipment.
  	  	<LONGSTATUS> 	  	A descriptive summary of the shipment status.
  	  	<OSDEXCEPTION> 	  	Over, short & damage (OS&D) exception code.
  	  	<EXCEPTIONDESCRIPTION> 	  	Description of the OS&D condition of the shipment.
  	  	<LATESTTTECODE> 	  	Current transit time exception (TTE) code.
  	  	<LATESTTTEDESCRIPTION> 	  	Current TTE description.
  	  	<NUMBEROFBOLNUMBERS> 	  	Number of BOL#s associated with the shipment.
  	  	<NUMBEROFPONUMBERS> 	  	Number of PO#s associated with the shipment.
  	  	<DELIVSIGFIRSTNAME> 	  	First name of the delivery signature.
  	  	<DELIVSIGLASTNAME> 	  	Last name of the delivery signature.
  	  	<SHIPPERNAME> 	  	ABF assigned name for the shipper.
  	  	<SHIPPERADDRESS1> 	  	Address line 1 of the shipper/origin.
  	  	<SHIPPERADDRESS2> 	  	Address line 2 of the shipper/origin.
  	  	<SHIPPERCITY> 	  	City of the shipper/origin.
  	  	<SHIPPERSTATE> 	  	State code of the shipper/origin.
  	  	<SHIPPERZIP> 	  	Zip code for the location of the shipper.
  	  	<SHIPPERACCOUNT> 	  	ABF six-digit account number assigned to the shipper.
  	  	<CONSIGNEEname> 	  	ABF assigned name for the consignee.
  	  	<CONSIGNEEADDRESS1> 	  	Address line 1 of the consignee/destination.
  	  	<CONSIGNEEADDRESS2> 	  	Address line 2 of the consignee/destination.
  	  	<CONSIGNEECITY> 	  	City of the consignee/destination.
  	  	<CONSIGNEESTATE> 	  	State code of the consignee/destination.
  	  	<CONSIGNEEZIP> 	  	Zip code for the location of the consignee.
  	  	<CONSIGNEEACCOUNT> 	  	ABF six-digit account number assigned to the consignee.
  	  	<SFBTPBACCOUNT> 	  	ABF six-digit account number assigned to the third party/SFB.
  	  	<STADESTINATION> 	  	The 3-digit ABF assigned destination station number.
  	  	<STAORIGIN> 	  	The 3-digit ABF assigned origin station number.
  	  	<BLINDSHIPMENT> 	  	"Y" if the shipment is a blind shipment.
  	  	<PREPAIDCOLLECT> 	  	"P" if the shipment is prepaid; "C" if the shipment is collect.
  	  	<STAORIGINALPHA> 	  	The 3-character airline code for the origin station.
  	  	<STADESTALPHA> 	  	The 3-character airline code for the destination station.
  	  	<BOLNUMBERS> 	  	Group of BOL#s.
  	  	<BOLNUMBER> 	  	A single BOL# associated with the shipment.
  	  	</BOLNUMBERS> 	  	
  	  	<PONUMBERS> 	  	Group of PO#s.
  	  	<PONUMBER> 	  	A single PO# associated with the shipment.
  	  	</PONUMBERS> 	  	
  	  	</SHIPMENT> 	  	
  	</SHIPMENTS> 	  	
  	<NUMERRORS> 	  	Number of errors associated with request. Must be "0" to return shipment data.
  	<ERRORS> 	  	Group of errors. This section will only be returned if NUMERRORS > 0.
Click here for a list of possible error codes and messages.
  	  	<ERRORCODE> 	  	Code associated with error.
  	  	<ERRORMESSAGE> 	  	Message assigned to error code.
  	</ERRORS> 	  	
</ABF>
*/
require_once('./APIconfig.php.inc');

if( empty($_GET['id']) ){
	// fail gracefully
	header("HTTP/1.1 404 OK");
	header('Content-Type: application/json');
	$json = "{ 'Response' : 'Error', 'Message' : 'Tracking ID required.' }";
	echo $json;
	exit();
}
else $trackid = $_GET['id'];

// let's get our XML document. RefType P = PO #; A = ABF Pro #;
$url = "https://www.abfs.com/xml/tracexml.asp?DL=2&ID=".ABFsecureid."&RefNum=".$trackid."&RefType=A";

$resp = file_get_contents($url);
$xml = simplexml_load_string($resp);

header("HTTP/1.1 200 OK");
header('Content-Type: application/json');

$json = json_encode($xml);
echo $json;
?>