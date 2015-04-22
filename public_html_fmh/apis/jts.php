<?php
// JTS
/*
http://www.jtsexpress.com/cgi-bin/wbprotrk?wbfbnumber=10391850&idbutton=Submit
Sample Tracking#’s: 10391850
*/

if( empty($_GET['id']) ){
	// $trackid = "10391850";
	// fail gracefully
	header("HTTP/1.1 404 OK");
	header('Content-Type: application/json');
	$json = "{ 'Response' : 'Error', 'Message' : 'Tracking ID required.' }";
	echo $json;
	exit();
}
else $trackid = $_GET['id'];
$response = array();

$url = "http://www.jtsexpress.com/cgi-bin/wbprotrk?idbutton=Submit&wbfbnumber=".$trackid;
$resp = file_get_contents($url);

if( stristr($resp, 'bill not found. Please try again') ){
	$response['success'] = false;
	$response['status'] = 'Tracking ID not found.';
}
else{
	$response['success'] = true;
	$resp = str_replace("\n", '', $resp);
	$start = strpos($resp, '<TABLE WIDTH="100%" CELLPADDING=0 CELLSPACING=0 BGCOLOR="#840000" BORDER=0><TR><TD WIDTH="16%"><B><FONT SIZE=2 COLOR="#FFFFFF">Signature</FONT></B></TD>');
	$end = strrpos($resp, "</TR></TABLE>");
	$out = substr($resp, $start, $end-$start+13);

/* -- of interest --

<BR><TABLE WIDTH="100%" CELLPADDING=0 CELLSPACING=0 BGCOLOR="#840000" BORDER=0><TR>
<TD WIDTH="16%"><B><FONT SIZE=2 COLOR="#FFFFFF">Signature</FONT></B></TD>
<TD WIDTH="28%"><B><FONT SIZE=2 COLOR="#FFFFFF">Status</FONT></B></TD>
<TD WIDTH="16%"><B><FONT SIZE=2 COLOR="#FFFFFF">Condition</FONT></B></TD>
<TD WIDTH="16%"><B><FONT SIZE=2 COLOR="#FFFFFF">Date</FONT></B></TD>
<TD WIDTH="10%"><B><FONT SIZE=2 COLOR="#FFFFFF">In</FONT></B></TD>
<TD WIDTH="10%"><B><FONT SIZE=2 COLOR="#FFFFFF">Out</FONT></B></TD>
</TR>
</TABLE>
<TABLE WIDTH="100%" CELLPADDING=0 CELLSPACING=0 BGCOLOR="#E7E7CF" BORDER=0><TR>
<TD WIDTH="16%" VALIGN="top"><FONT SIZE=2 COLOR="#000000">PICK UP</FONT></TD>
<TD WIDTH="28%" VALIGN="top"><FONT SIZE=2 COLOR="#000000">PU</FONT></TD>
<TD WIDTH="16%" VALIGN="top"><FONT SIZE=2 COLOR="#000000">&nbsp;</FONT></TD>
<TD WIDTH="16%" VALIGN="top"><FONT SIZE=2 COLOR="#000000">2015/03/16</FONT></TD>
<TD WIDTH="10%" VALIGN="top"><FONT SIZE=2 COLOR="#000000">0000</FONT></TD>
<TD WIDTH="10%" VALIGN="top"><FONT SIZE=2 COLOR="#000000">0000</FONT></TD>
</TR>
</TABLE>
<TABLE WIDTH="100%" CELLPADDING=0 CELLSPACING=0 BGCOLOR="#E7E7CF" BORDER=0><TR>
<TD WIDTH="16%" VALIGN="top"><FONT SIZE=2 COLOR="#000000">MIKE DRUMM</FONT></TD>
<TD WIDTH="28%" VALIGN="top"><FONT SIZE=2 COLOR="#000000">DELV</FONT></TD>
<TD WIDTH="16%" VALIGN="top"><FONT SIZE=2 COLOR="#000000">&nbsp;</FONT></TD>
<TD WIDTH="16%" VALIGN="top"><FONT SIZE=2 COLOR="#000000">2015/03/26</FONT></TD>
<TD WIDTH="10%" VALIGN="top"><FONT SIZE=2 COLOR="#000000">0000</FONT></TD>
<TD WIDTH="10%" VALIGN="top"><FONT SIZE=2 COLOR="#000000">0000</FONT></TD>
</TR>
</TABLE>

*/
	$out = str_replace("<TABLE", '<TABLE CLASS="dataTable" ID="carrierActivity"', $out);
	$response['shipment_history'] = str_replace(array('BGCOLOR="#840000"','BGCOLOR="#E7E7CF"','COLOR="#000000"','COLOR="#FFFFFF"'),'',$out);
}
header("HTTP/1.1 200 OK");
header('Content-Type: application/json; charset=utf-8');

$json = json_encode($response);
echo $json;
?>