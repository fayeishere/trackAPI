<?php
// ceva
/*
http://www.cevalogistics.com/en-US/toolsresources/Pages/CEVATrak.aspx?sv
sample tracking #s - 69391627, 69540662, 68614634
*/

if( empty($_GET['id']) ){
	// $trackid = "69391627";
	// fail gracefully
	header("HTTP/1.1 404 OK");
	header('Content-Type: application/json');
	$json = "{ 'Response' : 'Error', 'Message' : 'Tracking ID required.' }";
	echo $json;
	exit();
}
else $trackid = $_GET['id'];

$url = "http://etracking.cevalogistics.com/eTrackResults.aspx?sv=".$trackid."&sf=HouseWaybill&st=1&pageReferrer=ceva.com";
$response = array();
$resp = file_get_contents($url);

/*
first chunk of interesting data:
---
Waybill Number: 
69391627

Ship Date: 
31-MAR-15              

Estimated Arrival Date: 
07-APR-15

Shipper Location
---
*/
$out = strip_tags($resp);

$startsAt = strpos($out, "Ship Date:") + strlen("Ship Date:");
$endsAt = strpos($out, "Estimated Arrival Date:", $startsAt);
$result = substr($out, $startsAt, $endsAt - $startsAt);

$response['ship_date'] = trim($result);

$startsAt = strpos($out, "Estimated Arrival Date:") + strlen("Estimated Arrival Date:");
$endsAt = strpos($out, "Shipper Location", $startsAt);
$result = substr($out, $startsAt, $endsAt - $startsAt);

$response['estimated_delivery'] = trim($result);

$startsAt = strpos($out, "Delivery Type:") + strlen("Delivery Type:");
$endsAt = strpos($out, "Movement Type", $startsAt);
$result = substr($out, $startsAt, $endsAt - $startsAt);

$response['delivery_type'] = trim($result);

/*
second chunk of interesting data (history)
---

<table cellSpacing="0" width="100%" border="0" cellPadding="0">
        <tr>
          <td width="100%"> </td>
        </tr>
        <tr>
          <td align="center" width="100%" vAlign="top" CLASS="portlet-section-header">Key Event History</td>
        </tr>
      </table>
      <table cellSpacing="1" width="100%" border="0" class="bottomblockgrey" cellPadding="0">
        <tr>
          <td align="left" width="30%" CLASS="portlet-table-header">Event</td>
          <td align="left" width="10%" CLASS="portlet-table-header">Date</td>
          <td align="left" width="10%" CLASS="portlet-table-header">Time</td>
          <td align="left" width="20%" CLASS="portlet-table-header">Event Location</td>
          <td align="left" width="30%" CLASS="portlet-table-header">Signature / Remarks</td>
        </tr>
      </table>
      <table cellSpacing="1" width="100%" border="0" cellPadding="0">
        <tr>
          <td class="lblnavy" width="30%" align="left">Delivered</td>
          <td class="lblnavy" width="10%" align="left">07-APR-15</td>
          <td class="lblnavy" width="10%" align="left">11:44</td>
          <td class="lblnavy" width="20%" align="left">EWR
													 
												</td>
          <td class="lblnavy" width="30%" align="left">RNUNEZ</td>
        </tr>
        <tr bgcolor="#E7E3E7">
          <td class="lblnavy" width="30%" align="left">Out For Delivery</td>
          <td class="lblnavy" width="10%" align="left">07-APR-15</td>
          <td class="lblnavy" width="10%" align="left">10:25</td>
          <td class="lblnavy" width="20%" align="left">EWR
													 
												</td>
          <td class="lblnavy" width="30%" align="left"></td>
        </tr>
        <tr>
          <td class="lblnavy" width="30%" align="left">On-Hand At Destination</td>
          <td class="lblnavy" width="10%" align="left">07-APR-15</td>
          <td class="lblnavy" width="10%" align="left">09:43</td>
          <td class="lblnavy" width="20%" align="left">EWR
													 
												</td>
          <td class="lblnavy" width="30%" align="left">Harilall, Beram</td>
        </tr>
        <tr bgcolor="#E7E3E7">
          <td class="lblnavy" width="30%" align="left">Pickup</td>
          <td class="lblnavy" width="10%" align="left">31-MAR-15</td>
          <td class="lblnavy" width="10%" align="left">16:00</td>
          <td class="lblnavy" width="20%" align="left">ON2
													 
												</td>
          <td class="lblnavy" width="30%" align="left"></td>
        </tr>
        <tr>
          <td class="lblnavy" width="30%" align="left">Booking Received</td>
          <td class="lblnavy" width="10%" align="left">31-MAR-15</td>
          <td class="lblnavy" width="10%" align="left">15:59</td>
          <td class="lblnavy" width="20%" align="left">ON2
													 
												</td>
          <td class="lblnavy" width="30%" align="left"></td>
        </tr>
      </table>
      <table cellSpacing="0" width="100%" border="0" cellPadding="0">
        <tr>
          <td class="boldx"> </td>
        </tr>
        <tr>
          <td class="boldx"> </td>
        </tr>
        <tr>
          <td align="center" width="100%" CLASS="portlet-form-field-label">For informational purposes only. Actual charges, Bill To parties and other details may change as necessary. </td>
        </tr>
      </table>

---
*/

$startsAt = strpos($resp, "Key Event History") + strlen("Key Event History");
$endsAt = strpos($resp, "For informational purposes only.", $startsAt);
$result = substr($resp, $startsAt, $endsAt - $startsAt);
// this has "</table>" before the table we want and an extra "<table>" at the end

$start = strpos($result, "</table>");
$end = strrpos($result, "<table");
$response['shipment_history'] = substr($result, $start+8, $end-$start-8);
// fix table for display
$response['shipment_history'] = str_replace('10%', '15%', $response['shipment_history']);
$response['shipment_history'] = str_replace('20%', '10%', $response['shipment_history']);
$response['shipment_history'] = str_replace('table cellSpacing="1"', 'table cellSpacing="0" CLASS="dataTable" ID="carrierActivity"', $response['shipment_history']);

if( stristr($response['shipment_history'], 'Delivered') ) $response['status'] = 'Delivered';
else $response['status'] = 'In Transit';

header("HTTP/1.1 200 OK");
header('Content-Type: application/json');

$json = json_encode($response);
echo $json;
?>