<?php
// Conway. Include me like you would any JS script.
/*
https://www.con-way.com/webapp/manifestrpts_p_app/shipmentTracking.do?PRO=690788560
Sample Tracking#’s: 690788663, 690788560, 690788523
*/

if( empty($_GET['id']) ){
	// $trackid = "690788523";
	// fail gracefully
	header("HTTP/1.1 404 OK");
	header('Content-Type: application/json');
	$json = "{ 'Response' : 'Error', 'Message' : 'Tracking ID required.' }";
	echo $json;
	exit();
}
else $trackid = $_GET['id'];

$url = "https://www.con-way.com/webapp/manifestrpts_p_app/shipmentTracking.do?PRO=".$trackid;
$response = array();
$out = file_get_contents($url);

if( stristr($out, 'No results found') ){
  $response['Status'] = false;
  $response['Error'] = "Tracking ID not found.";
  $out = json_encode($response);
}
else{
  $startsAt = strpos($out, "var myCustData = [") + strlen("var myCustData = [");
  $endsAt = strpos($out, "];", $startsAt);
  $out = substr($out, $startsAt, $endsAt-$startsAt);
}

header("HTTP/1.1 200 OK");
header('Content-Type: application/json; charset=utf-8');

echo $out;

/*
<!-- Datagrid Data Set Here -->
    <script id="data" type="text/javascript">
    function custData() {
			var myCustData = [{
  "SearchNum" : "PRO# 690788523",
  "proNum" : "690788523",
  "Status" : "Delivered",
  "shipmentStatus" : "<b>Delivered by</b> Renton, WA ",
  "DeliveryETA" : "",
  "DestAdr" : "Renton,WA",
  "Type" : "",
  "PickupDate" : "04/06/2015",
  "PickedUp" : "04/06/2015",
  "InTransit" : "false",
  "OutForDeliv" : "false",
  "Delivered" : "04/14/2015",
  "isGuaranteed" : "false",
  "isExceptionStatus" : "false",
  "LastModified" : "04/14/2015",
  "ShipperName" : "Poly Wood Inc ",
  "ShipperAddr" : "1018 W Brooklyn St Syracuse  IN 46567",
  "ShipperPhone" : "",
  "ShipperEmail" : "",
  "ConsigneeName" : "Charles Hirschman ",
  "ConsigneeAddr" : "3854 NE 98th St Seattle  WA 98115",
  "ConsigneePhone" : "",
  "ConsigneeEmail" : "",
  "ConsigneeSignature" : "C Hirschman signed on 04/14/2015 04:06 PM",
  "BillToName" : "Poly-Wood Inc ",
  "BillToAddr" : "1001 W Brooklyn St Syracuse  IN 46567 - 1433",
  "BillToPhone" : "",
  "BillToEmail" : "",
  "isBrokerDisplayed" : "false",
  "CollPrePd" : "Prepaid",
  "Notes" : "1 Pcs weighing 314.0 lbs",
  "exceptionNotes" : "",
  "HistoryHref" : "/webapp/manifestrpts_p_app/Tracking/ShipmentHistory.jsp?proNbr=690788523",
  "History" : [ {
    "Date" : "04/14/2015 04:06 PM",
    "StatusCode" : null,
    "Status" : "Delivered",
    "Details" : "The shipment has been delivered to the recipient.",
    "Location" : "Renton,WA",
    "sic" : "USE",
    "sicCity" : "Renton",
    "sicState" : "WA",
    "sicCtry" : "US",
    "sicHREF" : "/webapp/servicecenter_app/ServiceCenterInfo/ServiceCenterDetail.jsp?dest=fastmap2000display&logotoggle=S&SICInfo=Y&TTMapInfo=N&SIC=USE"
  }, {
    "Date" : "04/14/2015 10:53 AM",
    "StatusCode" : null,
    "Status" : "Out for Delivery",
    "Details" : "The shipment is out for delivery to the recipient.",
    "Location" : "Renton,WA",
    "sic" : "USE",
    "sicCity" : "Renton",
    "sicState" : "WA",
    "sicCtry" : "US",
    "sicHREF" : "/webapp/servicecenter_app/ServiceCenterInfo/ServiceCenterDetail.jsp?dest=fastmap2000display&logotoggle=S&SICInfo=Y&TTMapInfo=N&SIC=USE"
  }, {
    "Date" : "04/10/2015 11:29 AM",
    "StatusCode" : null,
    "Status" : "Pending Delivery",
    "Details" : "The shipment is being held at the destination service center until an appointment for delivery has been set or met at the request of the recipient.",
    "Location" : "Renton,WA",
    "sic" : "USE",
    "sicCity" : "Renton",
    "sicState" : "WA",
    "sicCtry" : "US",
    "sicHREF" : "/webapp/servicecenter_app/ServiceCenterInfo/ServiceCenterDetail.jsp?dest=fastmap2000display&logotoggle=S&SICInfo=Y&TTMapInfo=N&SIC=USE"
  }, {
    "Date" : "04/09/2015 10:14 PM",
    "StatusCode" : null,
    "Status" : "In Transit",
    "Details" : "The shipment has arrived at an interim service center.",
    "Location" : "Renton,WA",
    "sic" : "USE",
    "sicCity" : "Renton",
    "sicState" : "WA",
    "sicCtry" : "US",
    "sicHREF" : "/webapp/servicecenter_app/ServiceCenterInfo/ServiceCenterDetail.jsp?dest=fastmap2000display&logotoggle=S&SICInfo=Y&TTMapInfo=N&SIC=USE"
  }, {
    "Date" : "04/09/2015 12:10 AM",
    "StatusCode" : null,
    "Status" : "Exception",
    "Details" : "Service Exemption is processed by the Con-way Freight with exclusive discretion under the following circumstances:<br/> 1.When freight movement is significantly delayed due to acts of God, weather, or due to the intervention of a governmental authority, including when freight movement is delayed due to the closure of a road or highway on the scheduled route by federal, state or local authorities.<br/> 2. When Customs delays freight movement at border crossings. Exemption allowed only if the delay is 2 hours or more and is caused by Customs clearing the freight at the border-crossing point, assuming that the shipment arrived on-time at the border.",
    "Location" : "Renton,WA",
    "sic" : "USE",
    "sicCity" : "Renton",
    "sicState" : "WA",
    "sicCtry" : "US",
    "sicHREF" : "/webapp/servicecenter_app/ServiceCenterInfo/ServiceCenterDetail.jsp?dest=fastmap2000display&logotoggle=S&SICInfo=Y&TTMapInfo=N&SIC=USE"
  }, {
    "Date" : "04/07/2015 03:58 AM",
    "StatusCode" : null,
    "Status" : "In Transit",
    "Details" : "The shipment is en route to an interim service center.",
    "Location" : "Fremont,IN",
    "sic" : "XCW",
    "sicCity" : "Fremont",
    "sicState" : "IN",
    "sicCtry" : "US",
    "sicHREF" : "/webapp/servicecenter_app/ServiceCenterInfo/ServiceCenterDetail.jsp?dest=fastmap2000display&logotoggle=S&SICInfo=Y&TTMapInfo=N&SIC=XCW"
  }, {
    "Date" : "04/06/2015 06:26 PM",
    "StatusCode" : null,
    "Status" : "In Transit",
    "Details" : "The shipment has arrived at an interim service center.",
    "Location" : "Fremont,IN",
    "sic" : "XCW",
    "sicCity" : "Fremont",
    "sicState" : "IN",
    "sicCtry" : "US",
    "sicHREF" : "/webapp/servicecenter_app/ServiceCenterInfo/ServiceCenterDetail.jsp?dest=fastmap2000display&logotoggle=S&SICInfo=Y&TTMapInfo=N&SIC=XCW"
  }, {
    "Date" : "04/06/2015 05:27 PM",
    "StatusCode" : null,
    "Status" : "In Transit",
    "Details" : "The shipment is en route to an interim service center.",
    "Location" : "Fort Wayne,IN",
    "sic" : "XFW",
    "sicCity" : "Fort Wayne",
    "sicState" : "IN",
    "sicCtry" : "US",
    "sicHREF" : "/webapp/servicecenter_app/ServiceCenterInfo/ServiceCenterDetail.jsp?dest=fastmap2000display&logotoggle=S&SICInfo=Y&TTMapInfo=N&SIC=XFW"
  }, {
    "Date" : "04/06/2015 02:05 PM",
    "StatusCode" : null,
    "Status" : "Pickup",
    "Details" : "The shipment has been picked up and recorded in our system by the origin service center.",
    "Location" : "Fort Wayne,IN",
    "sic" : "XFW",
    "sicCity" : "Fort Wayne",
    "sicState" : "IN",
    "sicCtry" : "US",
    "sicHREF" : "/webapp/servicecenter_app/ServiceCenterInfo/ServiceCenterDetail.jsp?dest=fastmap2000display&logotoggle=S&SICInfo=Y&TTMapInfo=N&SIC=XFW"
  } ],
  "Documents" : [ {
    "title" : "Bill of Lading",
    "addr" : "/webapp/imaging_app/imageretrieverequest.do?dest=fastdocview&PRO1=690788523&DocType1=BL"
  }, {
    "title" : "Bill of Lading and LOA (Letter of Authority)",
    "addr" : "/webapp/imaging_app/imageretrieverequest.do?dest=fastdocview&PRO1=690788523&DocType1=BL&PRO2=690788523&DocType2=LOABL"
  }, {
    "title" : "Bill of Lading, LOA, DR (Delivery Receipt)",
    "addr" : "/webapp/imaging_app/imageretrieverequest.do?dest=fastdocview&PRO1=690788523&DocType1=BL&PRO2=690788523&DocType2=LOA&PRO3=690788523&DocType3=DRBL"
  }, {
    "title" : "Customs Documents",
    "addr" : "/webapp/imaging_app/imageretrieverequest.do?dest=fastdocview&PRO1=690788523&DocType1=CUST"
  }, {
    "title" : "Delivery Receipt",
    "addr" : "/webapp/imaging_app/imageretrieverequest.do?dest=fastdocview&PRO1=690788523&DocType1=DR"
  }, {
    "title" : "Return Receipt",
    "addr" : "/webapp/imaging_app/imageretrieverequest.do?dest=fastdocview&PRO1=690788523&DocType1=DRRR"
  }, {
    "title" : "Inspection Report",
    "addr" : "/webapp/imaging_app/imageretrieverequest.do?dest=fastdocview&PRO1=690788523&DocType1=IR"
  }, {
    "title" : "Letter of Authority",
    "addr" : "/webapp/imaging_app/imageretrieverequest.do?dest=fastdocview&PRO1=690788523&DocType1=LOA"
  }, {
    "title" : "NMFC Certificate",
    "addr" : "/webapp/imaging_app/imageretrieverequest.do?dest=fastdocview&PRO1=690788523&DocType1=NCIC"
  }, {
    "title" : "Weight Correction Certificate",
    "addr" : "/webapp/imaging_app/imageretrieverequest.do?dest=fastdocview&PRO1=690788523&DocType1=WI"
  }, {
    "title" : "Weight & Research Photos",
    "addr" : "/webapp/imaging_app/imageretrieverequest.do?dest=fastdocview&PRO1=690788523&DocType1=WRFO"
  }, {
    "title" : "Freight Bill Copy",
    "addr" : "/webapp/corrections_app/shipments/freight_bill_copy/show.jsp?dest=freightbillrs&PROnumber=690788523"
  } ],
  "shipmentRefNumbers" : [ {
    "referenceType" : "PO#",
    "referenceNumber" : "00847002368105"
  }, {
    "referenceType" : "SN#",
    "referenceNumber" : "E083235"
  } ],
  "PURConfirmed" : "true",
  "usbrokerName" : "",
  "usbrokerAddr" : "",
  "usbrokerSignature" : "",
  "usbrokerSignatureDate" : "",
  "mxbrokerName" : "",
  "mxbrokerAddr" : ""
}];
			return myCustData;
    };
    
    function labelData() {
			var myLabelData = [{
  "lblTrackingResultsTitle" : "Tracking",
  "lblTrackingResultsColSearchedFor" : "Searched For",
  "lblTrackingResultsColStatus" : "Status",
  "lblTrackingResultsColDeliveryETA" : "Delivery / ETA",
  "lblTrackingResultsColPickupDate" : "Pickup Date",
  "lblTrackingResultsColRefNumbers" : "Reference Numbers",
  "lblTrackingResultsRecipientName" : "Recipient Name",
  "lblTrackingResultsRecipientAddr" : "Destination Address",
  "lblTrackingDetailTitle" : "Tracking",
  "lblTrackingDetailImgMSDelivered" : "DELIVERED",
  "lblTrackingDetailImgMSInTransit" : "IN TRANSIT",
  "lblTrackingDetailImgMSOutForDelivery" : "OUT FOR DELIVERY",
  "lblTrackingDetailImgMSPickedUp" : "PICKED UP",
  "lblTrackingDetailImgMSPickupReqConfirmed" : "PICKUP REQUEST CONFIRMED",
  "lblTrackingDetailImgTxtDelivered" : "Delivered",
  "lblTrackingDetailImgTxtInTransit" : "In Transit",
  "lblTrackingDetailImgTxtOutForDelivery" : "Out For Delivery",
  "lblTrackingDetailImgTxtPickedUp" : "Picked up",
  "lblTrackingDetailImgTxtPickupReqConfirmed" : "Pickup Request Confirmed",
  "lblTrackingDetailImgDelivered" : "Delivered",
  "lblTrackingDetailImgETA" : "ETA",
  "lblTrackingDetailImgLastModified" : "Last Modified on",
  "lblTrackingDetailTabDetail" : "Details",
  "lblTrackingDetailTabHistory" : "History",
  "lblTrackingDetailTabDocuments" : "Documents (Log in Required)",
  "lblTrackingDetailShipper" : "Shipper Name and Address",
  "lblTrackingDetailRecipient" : "Recipient Name and Address",
  "lblTrackingDetailRecipientSignature" : "Recipient Signature",
  "lblTrackingDetailBillTo" : "Bill To Name and Address",
  "lblTrackingDetailUSBroker" : "US Broker",
  "lblTrackingDetailUSBrokerSignature" : "US Broker Signature",
  "lblTrackingDetailMexicoBroker" : "Mexico Broker",
  "lblTrackingDetailExceptionNotes" : "Exceptions",
  "lblTrackingDetailShipmentDetail" : "Shipment Details",
  "lblTrackingDetailTabHistoryDate" : "Date",
  "lblTrackingDetailTabHistoryStatus" : "Status of Shipment",
  "lblTrackingDetailTabHistoryLocation" : "Location"
}];
			return myLabelData;
    };
    
	$(document).ready(function(){
   		$("#btnPrntFx").click(function() {
			window.open ('/webapp/manifestrpts_p_app/shipmentTracking.do?printDetails=Y', '_blank', config='width=1000, toolbar=yes, menubar=yes, scrollbars=yes, resizable=yes, location=no, directories=no, status=yes');
 		});
 		$("#btnEmail").click(function() {
			window.open ('/webapp/manifestrpts_p_app/shipmentTracking.do?detailsEmailFax=Y', '_blank', config='width=1000, toolbar=yes, menubar=yes, scrollbars=yes, resizable=yes, location=no, directories=no, status=yes');
 		});
   	});
    </script>
    <!-- Datagrid Data Set End -->
    */
