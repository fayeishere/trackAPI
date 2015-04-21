<?php
// YRC
/*
http://my.yrc.com/dynamic/national/servlet?CONTROLLER=com.rdwy.ec.rextracking.http.controller.ProcessPublicTrackingController&PRONumber=7632746967&xml=Y
*/
require_once('./APIconfig.php.inc');

if( empty($_GET['id']) ){
	// $trackid = "7632746967";
	// fail gracefully
	header("HTTP/1.1 404 OK");
	header('Content-Type: application/json');
	$json = "{ 'Response' : 'Error', 'Message' : 'Tracking ID required.' }";
	echo $json;
	exit();
}
else $trackid = $_GET['id'];

// Despite following their documentation, it's not returning XML
$url = "http://my.yrc.com/dynamic/national/servlet?CONTROLLER=com.rdwy.ec.rextracking.http.controller.ProcessPublicTrackingController&XML=Y&PRONumber=".$trackid;
/*
<!-- Start of one shipment -->				
					<tr  class="rowodd"  >
						<td valign="top" align="left" class="text reference-number" width="10%" nowrap>
							763-274696-7&nbsp;
						</td>

						<td valign="top" align="left" class="text" width="30%" nowrap>
							DELIVERED DATE: 02/04/2015 TRAILER 531172
						</td>
						<td valign="top" align="left" class="text" width="10%" nowrap>
							01/27/2015&nbsp;
						</td>
						<td valign="top" align="left" class="text" width="10%" nowrap>
							02/04/2015&nbsp;</td>
						<td valign="top" align="left" class="text" width="20%" nowrap>

								OWOSSO, MI 48867 &nbsp;							

						</td>
						<td valign="top" align="left" class="text" width="20%" nowrap>

								PHOENIX, AZ 85019&nbsp;

						</td>
					</tr>


<!--End of one shipment-->	
*/
// $resp = DOMDocument::loadHTMLFile($url);
// var_dump($resp); die();
$resp = file_get_contents($url);
$clean_string = split('<!-- Start of one shipment -->', $resp);
$clean_string = split('<!--End of one shipment-->', $clean_string[1]);

$s = split('</td>', $clean_string[0]);
// 0 - reference number 
// 1 - delivered or estimated date
//  - pickup date
// 2 - estimated date
// 3 - ship from location
// 4 - ship to location
$n = strip_tags($clean_string[0]);
$s = split('&nbsp;', $n);
$shipment_history = '<table>
						 <colgroup>
						    <col style="font-weight: bold; width: 20%;">
						    <col style="font-weight: bold; width: 20%;">
						    <col style="font-weight: bold; width: 30%;">
						  </colgroup>
						  <thead><tr>
							<th class="columnHeader">Pickup Date</th>
							<th class="columnHeader">Ship From</th>
							<th class="columnHeader">Ship To</th>
						</tr></thead><tbody>
							<td>'.substr($s[1], -10).'</td><td>'.trim($s[3]).'</td><td>'.trim($s[4]).'</td>
					</tbody></table>';

$result = array(
  'shipment_history' => $shipment_history,
  'status' => trim(str_replace('&nbsp;', ' ', substr($s[1], 0, -10))),
  'estimated_devlivery' => trim(str_replace('&nbsp;', ' ', strip_tags($s[2]))),
   );

header("HTTP/1.1 200 OK");
header('Content-Type: application/json');

$json = json_encode($result);
echo $json;
?>