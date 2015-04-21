<?php
// Genwest
/*
http://72.165.143.35:81/cgibin/in1ssi-gen-search.htm
Sample Tracking#’s: 261800, 261835, 261753
*/

if( empty($_GET['id']) ){
	$trackid = "261835";
	// fail gracefully
	// header("HTTP/1.1 404 OK");
	// header('Content-Type: application/json');
	// $json = "{ 'Response' : 'Error', 'Message' : 'Tracking ID required.' }";
	// echo $json;
	// exit();
}
else $trackid = $_GET['id'];

$url = "http://72.165.143.35:81/inssi/cobolcgi.dll?runcobol+in1ssi-gen.cob&PRO_NUM1=".$trackid;
$response = array();
// fields that we can get, that we care about
$fields = array('CurrentLocation'=>'current_location','DeliveryStatus'=>'status');
// $resp = file_get_contents($url);

$resp = '<html>
<head>

<SCRIPT LANGUAGE="JavaScript"> function popUp(URL) {day = new Date(); id = day.getTime(); eval("page" + id + " = window.open(URL, \'" + id + "\', \'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=600,height=400\');");} </script>

<title>Gencom Transportation - Shipment Tracking - Multiple Results - Data Provided By www.aurorasoftware.com - Aurora Software, Inc.</title>
</head>

<p>
<body style="color: #003399; font-family: Arial; font-size: 12pt" bgcolor="#373737" link="#0099FF" alink="#0099FF" vlink="#FFFFFF">

<div align="center">
	<table border="0" id="table4" cellspacing="0" cellpadding="0">
		<tr>
			<td><div align="center">
				<img border="0" src="banner.jpg" width="800" height="125"></div></td>
		</tr>
	</table>
</div>

<table cellSpacing=0 cellPadding=0 width="100%" border=0 id="table3">
<tbody>
</tbody></table>
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="4" bordercolorlight="#003399" bordercolordark="#FFFFFF" bgcolor="#003399" style="font-family: Arial; font-size: 18pt; ">
  <tr>
    <td width="201" valign="top" nowrap>
    <b><font size="4" color="#FFFFFF">Shipment Tracking<br></font>
	<font color="#FFFFFF" size="2"><br>
		Showing :&nbsp; All Results</font></b></td>
    <td width="377" height="1" nowrap></td>
    <td width="376" height="1" valign="top" nowrap>
	<p align="right"><b><font size="3" color="#FFFFFF"></font></b></td>
</table>
  
<table border="0" width="100%" id="table8" cellspacing="0" cellpadding="2" bgcolor="#003399">
	<tr>
		<td width="356" style="color: #FFFFFF; font-family: Arial; font-size: 10pt; font-weight: bold" nowrap>
		&nbsp;</td>
		
		<td style="color: #FFFFFF; font-family: Arial; font-size: 10pt; font-weight: bold" nowrap>&nbsp;</td>
		<td width="557" style="color: #FFFFFF; font-family: Arial; font-size: 10pt; font-weight: bold" nowrap>
		&nbsp;</td>
	</tr>
</table>

<hr color="#003399" noshade size="3">
  <table width="100%" border="0" align="center" cellpadding="4" bordercolor="#003399" bordercolorlight="#003399" bordercolordark="#FFFFFF" bgcolor="#003399" id="table7">
    <tr>
      <td width="3%"style="color: #FFFFFF" align="center" ><b>&nbsp;</b></td>
      <td width="12%"style="color: #FFFFFF" align="center" ><b>Pro Number</b></td>
      <td width="12%" style="color: #FFFFFF" align="left"><p align="center"><b>Current Location</b></td>
      <td width="8%" style="color: #FFFFFF" align="left"><p align="center"><b>Delivery<br>
		Status</b></td>
      <td width="23%" style="color: #FFFFFF" align="left"><b>Shipper</b></td>
      <td width="21%" style="color: #FFFFFF" align="left"><b>Consignee</b></td>
      <td width="6%" style="color: #FFFFFF" align="right"><b>Pieces</b></td>
      <td width="6%" style="color: #FFFFFF" align="right"><b>Weight</b></td>
      <td width="3%" style="color: #FFFFFF" align="right">&nbsp;</td>
    </tr>


    <tr>
      <td width="3%"style="color: #FFFFFF" align="center" bgcolor="#FFFFFF" colspan="9" ></td>
    </tr>

    <tr>
      <td width="3%"style="color: #FFFFFF" align="center" bgcolor="#003399" ><b>
		  1</b></td>
      <td width="12%"style="color: #FFFFFF" align="center" bgcolor="#003399" ><b>
		SAN   261835</b></td>
      <td width="12%" style="color: #FFFFFF" align="left" bgcolor="#003399"><p align="center">
		<b>Delivered</b></td>
      <td width="8%" style="color: #FFFFFF" align="left" bgcolor="#003399"><p align="center">
		<b>04/08/2015 @ 13:51<br>Signed By: <br>JENNIFER FOSTER</b></td>
      <td width="23%" style="color: #FFFFFF" align="left" bgcolor="#003399"><b>
		ACE<BR> ONTARIO, CA<BR>91764</b></td>
      <td width="21%" style="color: #FFFFFF" align="left" bgcolor="#003399"><b>
		WHITE<BR> FRESNO, CA<BR>93706</b></td>
      <td width="6%" style="color: #FFFFFF" align="right" bgcolor="#003399"><b>
		    3</b></td>
      <td width="6%" style="color: #FFFFFF" align="right" bgcolor="#003399"><b>
		    242.00</b></td>
      <td width="3%" style="color: #FFFFFF" align="right" bgcolor="#003399">&nbsp;</td>
    </tr>


<table border="0" width="100%" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" height="1" id="table9">
	<tr>
	<td>
	
<hr noshade color="#003399" size="3"><font color="#003399">
	</td>
	</tr>
</table>

<table border="0" width="100%" bgcolor="#003399" style="font-family: Arial; font-size: 18pt; " cellpadding="5" bordercolorlight="#003399" bordercolordark="#FFFFFF" cellspacing="4">
  <tr>
    <td width="201" valign="top" nowrap>
    &nbsp;<p><b><font color="#FFFFFF" size="2">Showing :&nbsp; All Results</font></b></td>
    <td width="377" height="1" nowrap></td>
    <td width="376" height="1" valign="top" nowrap>
	<p align="right"><b><font size="3" color="#FFFFFF"></font></b></td>
  </table>
  
<table border="0" width="100%" id="table8" cellspacing="0" cellpadding="2" bgcolor="#003399">
	<tr>
		<td width="356" style="color: #FFFFFF; font-family: Arial; font-size: 10pt; font-weight: bold" nowrap>
		<table border="0" width="356" id="table12" cellspacing="0" style="font-family: Arial; font-size: 10pt; color: #FFFFFF; font-weight: bold" cellpadding="2">
			<tr>
				<td align="right" width="97" bgcolor="#FFFFFF" style="color: #003399">
				<font size="2" color="#003399"><b>
				T O T A L S</b></font></td>
				<td align="right" width="60" bgcolor="#FFFFFF" style="color: #003399">
				<font color="#003399">Loads</td>
				<td align="right" width="100" bgcolor="#FFFFFF" style="color: #003399">Weight</td>
				<td align="right" width="85" bgcolor="#FFFFFF" style="color: #003399">Pieces</font></td>
			</tr>
			<tr>
				<td align="right" width="97">Shipper :</td>
				<td align="right" width="60">    1</td>
				<td align="right" width="100">      242.00</td>
				<td align="right" width="85">        3</td>
			</tr>
			<tr>
				<td align="right" width="97">Consignee :</td>
				<td align="right" width="60">    0</td>
				<td align="right" width="100">        0.00</td>
				<td align="right" width="85">        0</td>
			</tr>
			<tr>
				<td align="right" width="97">Bill To :</td>
				<td align="right" width="60">    0</td>
				<td align="right" width="100">        0.00</td>
				<td align="right" width="85">        0</td>
			</tr>
			<tr>
				<td align="right" width="97" height="1"></td>
				<td align="right" width="60" height="1" bgcolor="#FFFFFF"></td>
				<td align="right" width="100" height="1" bgcolor="#FFFFFF"></td>
				<td align="right" width="85" height="1" bgcolor="#FFFFFF"></td>
			</tr>
			<tr>
				<td align="right" width="97">All :</td>
				<td align="right" width="60">    1</td>
				<td align="right" width="100">      242.00</td>
				<td align="right" width="85">        3</td>
			</tr>
		</table>
		</td>
		
		<td style="color: #FFFFFF; font-family: Arial; font-size: 10pt; font-weight: bold" nowrap>&nbsp;
		</td>
		<td width="557" style="color: #FFFFFF; font-family: Arial; font-size: 10pt; font-weight: bold" nowrap>
		<table border="0" width="100%" id="table15" cellspacing="0" style="font-family: Arial; font-size: 10pt; color: #FFFFFF; font-weight: bold" cellpadding="2">
			<tr>
				<td align="right" width="90" style="font-family: Arial; font-size: 10pt; color: #003399; font-weight: bold" bgcolor="#FFFFFF">
				<font size="2"><b>
				O P T I O N S </b></font></td>
				<td align="left" style="font-family: Arial; font-size: 10pt; color: #003399; font-weight: bold" bgcolor="#FFFFFF">&nbsp;</td>
			</tr>
			<tr>
				<td align="right" width="90">Account Id :</td>
				<td align="left"></td>
			</tr>
			<tr>
				<td align="right" width="90">Dates :</td>
				<td align="left">04/20/15 @ 23:20</td>
			</tr>
			<tr>
				<td align="right" width="90">Options :</td>
				<td align="left">Pro Number Lookup</td>
			</tr>

			<tr>
				<td align="right" width="90" height="1"></td>
				<td align="left"></td>
			</tr>

			<tr>
				<td align="right" width="90">&nbsp;</td>
				<td align="left">&nbsp;</td>
			</tr>
		</table>
		</td>
	</tr>
	</table>

		</td>
	</tr>
</table>
<font face="Arial" size="1"><b>|Start:2320.1051|Stop:2320.1052|Total Run Time:0000.0001 Seconds|<BR><BR></b></font></b>
<p>*</p>

</body>
</html>';

// chunk of interesting data is between two "hr" tags
$start = strpos($resp, "<hr");
$end = strrpos($resp, "<hr");

$out = substr($resp, $start, $end-$start);

// then, we just want to look at the first table
$start = strpos($out, "<tr");
$end = strrpos($out, "<table");

$out = substr($out, $start, $end-$start);
$response['shipment_history'] = "<table>".$out."</table>";

$parseme = split('</tr>', $out);
/*
	$parseme is now an array
		[0] = keys 
		[1] = blank
		[2] = values
*/
header('Content-Type: text/plain; charset=utf-8');
$keys = split('<td', html_entity_decode($parseme[0]) );
$values = split('<td', html_entity_decode($parseme[2]) );

foreach($keys as $i => $label){
	$label = str_replace(array(' ',"\t","\n"),'',$label);
	$key = trim(strip_tags('<td'.$label));

	if( !empty($key) && !empty($fields[$key]) ){
		$label = str_replace(array(' ',"\t","\n"),'',$values[$i]);
		$val = trim(strip_tags('<td'.$label));

		$response[ $fields[$key] ] = $val;
	}
}
/*
shipment_history' (a table)
                'status' (long string w/signage info)
                'current_location'
                'delivery_date'
*/
if( $response['current_location'] == 'Delivered' ){
	// move the data in "status" to another field & set status as "Delivered"
	$response['current_location'] = '';
	$response['delivery_date'] = str_replace('SignedBy',' -- SignedBy',$response['status']);
	$response['status'] = "Delivered";
}else{
	$response['delivery_date'] = '';
}

header("HTTP/1.1 200 OK");
header('Content-Type: application/json; charset=utf-8');

$json = json_encode($response);
echo $json;
?>