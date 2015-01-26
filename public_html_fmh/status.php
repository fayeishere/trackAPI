<?php
	require_once $_SERVER['DOCUMENT_ROOT']. "/globals.php";
	$vendor = "fmh";

    require_once 'fmview.php';
    require_once $_SERVER['DOCUMENT_ROOT'] .'/FileMaker.php';
    require_once 'error.php';

    $cgi = new CGI();
    $cgi->storeFile();
	
    $layoutName = 'view_order';

    require_once $_SERVER['DOCUMENT_ROOT'] .'/databaseSettings.php';
    
    ExitOnError($fm);
    $layout = $fm->getLayout($layoutName);
    ExitOnError($layout);

    // formats for dates and times
    $displayDateFormat = '%m/%d/%Y';
    $displayTimeFormat = '%I:%M:%S %P';
    $displayDateTimeFormat = '%m/%d/%Y %I:%M:%S %P';
    $submitDateOrder = 'mdy';

    $findCommand = NULL;		
	$recid = NULL;
    $record = NULL;
	unset($findCommand);
	unset($recid);
	unset($record);
		    
    // create a find command
	$findCommand = $fm->newFindCommand($layoutName);
	$findCommand->setLogicalOperator(FILEMAKER_FIND_AND);
	if (isset($_GET['order'])) {
	$findCommand->addFindCriterion('po_number', $_GET['order']); }
	if (isset($_GET['tracking'])) {
	$findCommand->addFindCriterion('id', $_GET['tracking']); }

	$result = $findCommand->execute();
	ExitOnError($result);
   
	// get the records
    $records = $result->getRecords();   
	$recnum = 1;
	foreach ($records as $fmrecord) {
		$record = new RecordHighlighter($fmrecord, $cgi);
		$recid = $record->getRecordId();
		$pos = strpos($recid, "RID_!");	
		} 

// Lookup by record ID
		$record = $fm->getRecordById($layoutName, $recid);
		ExitOnError($record);
		
		//get dates
		$date_delivered = $record->getField('date_delivered', 0);
		$date_in_progress = $record->getField('date_inprocess', 0);
		$date_arrived = $record->getField('date_arrived', 0);
		$date_scheduled = $record->getField('date_scheduleddelivery', 0);
		$date_canceled = $record->getField('date_cancel', 0);
		
		
		if (!empty($date_delivered)) {
			$status = "COMPLETE";
		} else if (!empty($date_canceled)) {
			$status = "CANCELED";
		} else if (!empty($date_scheduled)) {
			$status = "SCHEDULED";
		} else if (!empty($date_arrived)) {
			$status = "ARRIVED";
		} else {
			$status = "IN PROCESS";
		}
				  
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
  <title>Status: <?php echo $status; ?></title>
  <meta name="robots" content="index, follow" />
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <meta name="author" content="Heath Schweitzer" />
  <link href="/css/style.css" rel="stylesheet" type="text/css" />
  <!--[if lte IE 7]><link href="/css/iehacks.css" rel="stylesheet" type="text/css" /><![endif]-->
  <script type="text/javascript" src="/js/jquery.js"></script>
  <!--[if IE 6]>
  <script type="text/javascript" src="/js/ie6pngfix.js"></script>
  <script type="text/javascript">
    DD_belatedPNG.fix('img, ul, ol, li, div, p, a, h1, h2, h3, h4, h5, h6, span, input, textarea, td');
  </script>
  <![endif]-->




<?php /* --------------- START API TRACKING CODE HERE -------------------- */ ?>

  <style>
    #carrierActivity {font-size: 12px; width: 100%;}
    #carrierActivity tr.header { background-color: #e8e8e8; }
    #carrierActivity td { color: #333; }
    .hidden { visibility: hidden; }
  </style>

  <script type="text/javascript">

  function formatDateTime( myDate, myTime ){
    var year = myDate.substring(0,4);
    var month = myDate.substring(4,6);
    var day = myDate.substring(6,8);
    var format_date = year + "-" + month + "-" + day;

    if( typeof myTime != 'undefined' ){
      var hour = myTime.substring(0,2);
      var minutes = myTime.substring(2,4);
      if(hour < 12){
        var format_time = hour + ":" + minutes + ' A.M.';
      }
      else{
        if( hour > 12 ) hour = hour - 12; // since we're showing PM
        var format_time = hour + ":" + minutes + ' P.M.';
      }
      format_date += " " + format_time;
    }
    return format_date;
  }  

  // fields set on page load: carrierName, carrierTrackingID
  // additional fields we can write to: carrierLocation, carrierStatus, carrierETD, carrierActivity (table)
  $(document).ready ( function(){

    // 1. look for carrierName and pull in appropriate data
    var carrierName = $("#carrierName").text();
    var carrierTrackingID = $("#carrierTrackingID").text();
    var carrierStatus = ''; // delivery status
    var carrierLocation = ''; // current delivery location (e.g. where in transit or final delivery address)
    var carrierETD = ''; // estimated date/time of delivery
    var carrierATD = ''; // actual date/time of delivery
    var activityRows = [];
    console.log( "carrierTrackingID: ", carrierTrackingID, "carrierName: ", carrierName );

    function carrierCheckError(){
      // display a nice error...
      $('#carrierStatus').text('Unknown');
    }

    switch(carrierName){
      case "UPS Freight":

        $.ajax({
          dataType: "json",
          // -- MAKE SURE TO CHANGE THIS WHEN COPYING TO STATUS.PHP -- should be a local URL
          url: "http://www.fmhtracking.com/fmh/apis/ups.php?id="+carrierTrackingID,
          success: function(data){ 
              console.log('getJSON called and succeeded');  

              for( var i = 0; i < data.Shipment.Activity.length; i++ ){
                row = data.Shipment.Activity[i];
                // row: activtyLocation (City, StateProvinceCode), Description, Date, Time, Trailer
                // match this to our table, in case other api formats differ - or normalize this in the PHP
                // location, date, time, activity, trailer
                tablerow = {
                  'location': row.ActivityLocation.City + " " + row.ActivityLocation.StateProvinceCode,
                  'datetime': formatDateTime(row.Date,row.Time),
                  'activity': row.Description,
                  'trailer': row.Trailer 
                };
                activityRows.push(tablerow); 
              }

              carrierStatus = data.Shipment.CurrentStatus.Description; // 011 = delivered

              for( var i = 0; i < data.Shipment.DeliveryDetail.length; i++ ){
                var row = data.Shipment.DeliveryDetail[i];
                if( row.Type.Description == 'Delivery' ){
                  // actual date of delivery
                  carrierATD = formatDateTime(row.Date);
                }
                else{
                  if( row.Type.Description == 'Estimated Delivery' ){
                    // estimated date of delivery
                    carrierETD = formatDateTime(row.Date);
                  }
                }
              }
              drawCarrierActivity();
            },
          error: carrierCheckError 
        });

      break;

      // add other carrier handling here

      default:
        // handle error & the unknown
      break;
    }

    function drawCarrierActivity(){
      $('#carrierStatus').text( carrierStatus );
      if( carrierETD ){        
        $('#carrierETD').text( carrierETD + " (estimated) ");
      }
      if( carrierATD ){
        $('#carrierATD').text( carrierATD + " (actual) ");        
      }

      // process activity ... most recent is first
      for( var i = 0; i < activityRows.length; i++ ){
        if( i == 0 ){
          $('#carrierLocation').text( activityRows[0].location );
          $('#carrierActivity').removeClass('hidden');
        }
        row = activityRows[i];
        // append row to #carrierActivity table: location, datetime, activity, trailer
        $('#carrierActivity tr:last').after('<tr><td>'+row.location+'</td><td>'+row.datetime+'</td><td>'+row.activity+'</td><td>'+row.trailer+'</td></tr>');
      }
    }

  });

  </script>

<?php /* --------------- END API TRACKING CODE HERE -------------------- */ ?>

</head>

<body>

<!-- wrapper -->
<div class="siwpr">

  <!-- header -->
  <?php include($_SERVER['DOCUMENT_ROOT'] ."/header.php"); ?>

  <!-- main body -->
  <div id="middle">
  
    <!-- status page -->
    <div class="status_page">
	<script type="text/javascript">
		$(document).ready(function() {
			$("#fancyURLstatus").fancybox({
				'width'				: '50%',
				'height'			: '25%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
		});
	</script>
	<?php  $statuslink = "/status_notification.php?statusId=". urlencode($status); ?>
      <h1>Status: <span><?php echo $status; ?></span> &nbsp;<a id="fancyURLstatus" href="<?php echo $statuslink; ?>" style="border:thin; border-color:#009FAF; color:#009FAF;"><img src="/images/help2.jpeg" border="0" width="20" height="20"></a></h1>
      <div class="status_form">
        <form action="" method="get">
          <ul>
            <li>
              <label>Tracking #</label> <input name="" type="text" value="<?php echo nl2br(str_replace('', '&nbsp; ', storeFieldNames('id', 0, $record, false, 'EDITTEXT', 'text')))?>" class="input_item" /></li>
            <li><label>Customer Name:</label> <input name="" type="text" value="<?php echo nl2br(str_replace('', '&nbsp; ', storeFieldNames('customer_name', 0, $record, false, 'EDITTEXT', 'text')))?>" class="input_item" /></li>
            <li><label>PO # </label><input name="" type="text" value="<?php echo nl2br(str_replace('', '&nbsp; ', storeFieldNames('po_number', 0, $record, true, 'EDITTEXT', 'text')))?>" class="input_item" /></li>
            <li><label>Ship to City:</label> <input name="" type="text" value="<?php echo nl2br(str_replace('', '&nbsp; ', storeFieldNames('customer_city', 0, $record, true, 'EDITTEXT', 'text')))?>" class="input_item" /></li>
 			<li>
 			  <label>Order Type </label><input name="" type="text" value="<?php echo nl2br(str_replace('', '&nbsp; ', storeFieldNames('order_type', 0, $record, true, 'EDITTEXT', 'text')))?>" class="input_item" /></li>
            <li>
              <!--<label>Waybill #: </label><input name="" type="text" value="<?php echo nl2br(str_replace('', '&nbsp; ', storeFieldNames('waybill', 0, $record, true, 'EDITTEXT', 'text')))?>" class="input_item" /></li>-->
            <!--
            <li><label>date: </label><input name="" type="text" value="<?php echo nl2br(str_replace('', '&nbsp; ', storeFieldNames('date_scheduleddelivery', 0, $record, 
			true, 'EDITTEXT', 'text')))?>" class="input_item" /></li>
            <li><input type="submit" value="" class="submit" /></li>
          -->	  
          </ul>
        </form>
      </div>

      <div class="floatbox">	
      </div>

      <div class="status_info">
        <h3>Supplier to Delivery Agent</h3>
        <ul>  
        <li><span class="title">&nbsp;</span></li>
        <li><span class="title">&nbsp;</span></li>

        <li><span class="title">Carrier:</span> <span id="carrierName"><?php echo nl2br(str_replace('', '&nbsp; ', storeFieldNames('ltl_carrier', 0, $record, true, 'EDITTEXT', 'text')))?></span></li>
        <li><span class="title">Status: </span> <span id="carrierStatus">checking...</span></li>

        <li><span class="title">Tracking #:</span> <span id="carrierTrackingID"><?php echo nl2br(str_replace('', '&nbsp; ', storeFieldNames('ltl_tracking', 0, $record, true, 'EDITTEXT', 'text')))?></span></li>
        <li><span class="title">Location:</span> <span id="carrierLocation"></span></li>

        <li><span class="title">&nbsp;</span></li>
        <li><span class="title">Delivery Date:</span> <span id="carrierETD"></span></li>

        <li><span class="title">&nbsp;</span></li>
        <li><span class="title">&nbsp;</span></li>
        </ul>

        <table id="carrierActivity" border="0" cellpadding="0" cellspacing="0" class="dataTable hidden">
        <tbody><tr class="header">
        <th>Location</th>
        <th>Date Time</th>
        <th class="full">Activity</th>
        <th>Trailer</th>
        </tr></tbody></table>
      </div>

      <div class="status_info">
        <h3>Delivery Agent to Customer:</h3>
        <ul>  
        <li><span class="title">Name: </span><?php echo nl2br(str_replace('', '&nbsp; ', storeFieldNames('delivery_agents::company', 0, $record, true, 'EDITTEXT', 'text')))?></li>
	<!--<li><span class="title">ETA to Agent:       </span><a href="<?php echo nl2br(str_replace('', '&nbsp; ', storeFieldNames('date_inprocess', 0, $record, false, 'EDITTEXT', 'text')))?>"target="_blank">Track Arrival Date</a></li>-->
	  <!--<li><span class="title">Tracking #</label> <input name="" type="href" value="<?php echo nl2br(str_replace('', '&nbsp; ', storeFieldNames('date_inprocess', 0, $record, false, 'EDITTEXT', 'text')))?>" class="input_item" /></li>-->
          <li><span class="title">ETA to Agent:     </span><?php echo displayDate(storeFieldNames('date_inprocess', 0, $record, true, 'EDITTEXT', 'date'), $displayDateFormat)?></li>
          <li><span class="title">Location: </span><?php echo nl2br(str_replace('', '&nbsp; ', storeFieldNames('delivery_agents::city', 0, $record, true, 'EDITTEXT', 'text')))?><span class="title">, </span><?php echo nl2br(str_replace('', '&nbsp; ', storeFieldNames('delivery_agents::state', 0, $record, true, 'EDITTEXT', 'text')))?></li>
          <li><span class="title">Arrived at Agent: </span><?php echo displayDate(storeFieldNames('date_arrived', 0, $record, true, 'EDITTEXT', 'date'), $displayDateFormat)?></li>
          <li><span class="title">Phone: </span><?php echo nl2br(str_replace('', '&nbsp; ', storeFieldNames('delivery_agents::phone', 0, $record, true, 'EDITTEXT', 'text')))?></li>
          <li><span class="title">Scheduled Date:   </span><?php echo displayDate(storeFieldNames('date_scheduleddelivery', 0, $record, true, 'EDITTEXT', 'date'), $displayDateFormat)?></li>
          <li></li>
          <li><span class="title">Completion Date:  </span><?php echo displayDate(storeFieldNames('date_delivered', 0, $record, true, 'EDITTEXT', 'date'), $displayDateFormat)?></li>
	  <li><span class="title"></span><?php echo displayDate(storeFieldNames('filler', 0, $record, true, 'EDITTEXT', 'date'), $displayDateFormat)?></li>
	  <li><span class="title">Canceled Date:    </span><?php echo displayDate(storeFieldNames('date_cancel', 0, $record, true, 'EDITTEXT', 'date'), $displayDateFormat)?></li>
        </ul>
      </div><!--    		
      </div>

      </div>-->
      <div class="status_info">
        <h3>Product Information:</h3>
        <table cellpadding="0" cellspacing="0" border="0" bordercolor="#d9d9d9" width="100%">
        	<tr>
            	<th><span class="title">Line</span></th>
                <th><span class="title">Qty.</span></th>
                <th><span class="title">Description</span></th>
            </tr>
		<?php
		$relatedRecords = $record->getRelatedSet("order_line_items");
		$portal = $layout->getRelatedSet("order_line_items");
		if (FileMaker::isError($relatedRecords) === false) {
			$recnum = 0;
			$master_record = $record;
			foreach ($relatedRecords as $record) {
				$rowclass = ($recnum % 2 == 0) ? "table_row" : "c";
				$recnum++; 
				?>
        	<tr class="<?php echo $rowclass ?>">
                <td><?php echo $recnum; ?></td>
                <td>
                    <?php echo nl2br(str_replace('', '&nbsp; ', storeFieldNames('order_line_items::qty', 0, $record, true, 'EDITTEXT', 'number')))?>
                </td>
                <td>
                    <?php echo nl2br(str_replace('', '&nbsp; ', storeFieldNames('inventory::description', 0, $record, true, 'EDITTEXT', 'text')))?>
                </td>
            </tr>
            	<?php 
			}
			$record = $master_record;
		} ?>
        </table>
      </div>
    </div>
    <!-- / status page -->
  
  </div>
  <!-- / main body -->

  <!-- bottom links -->
  <?php include($_SERVER['DOCUMENT_ROOT'] ."/bottomlinks.php"); ?>
  <!-- / bottom links -->

</div>
<!-- / wrapper -->

<!-- footer -->
<?php include($_SERVER['DOCUMENT_ROOT'] ."/footer.php"); ?>
<!-- / footer -->
</body>
</html>