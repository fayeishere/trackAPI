<?


require_once('ups.php');

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
  <title>Status: IN PROCESS</title>
  <meta name="robots" content="index, follow" />
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <meta name="author" content="Heath Schweitzer" />
  <base href="http://fmhtracking.com" />
  <link href="/css/style.css" rel="stylesheet" type="text/css" />
  <!--[if lte IE 7]><link href="/css/iehacks.css" rel="stylesheet" type="text/css" /><![endif]-->
  <script type="text/javascript" src="/js/jquery.js"></script>
  <!--[if IE 6]>
  <script type="text/javascript" src="/js/ie6pngfix.js"></script>
  <script type="text/javascript">
    DD_belatedPNG.fix('img, ul, ol, li, div, p, a, h1, h2, h3, h4, h5, h6, span, input, textarea, td');
  </script>
  <![endif]-->
  <style>
    #carrier-tracking tr.header { background-color: #e8e8e8; }
    #carrier-tracking td { color: #333; }
  </style>
</head>

<body>

<!-- wrapper -->
<div class="siwpr">

  <!-- header -->
  	<script type="text/javascript" src="/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
	<script type="text/javascript" src="/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<link href="/fancybox/jquery.fancybox-1.3.4.css" rel="stylesheet" type="text/css" media="screen" />
    <div id="header">
    
        <!-- fmh logo -->
    <div class="fmh_logo">
      <!--<a href="/fmh">--><img src="/images/FMH_WeHaul_Truck_Blk-2a.png" alt="" /></a>
    </div>
    <!-- gr logo -->
    
    <!-- logo -->
    <div class="logo">
      <h1><!--<a href="/">-->Welcome to FMH Tracking</a></h1>
      <h3><a href="http://www.fmhtracking.com">Delivery Status for FinalMileHome.com</a></h3>
    </div>
    <!-- / logo -->
    

    
    </div>
  <!-- / header -->
  
  <!-- nav bar -->
  <div class="nav_bar">
  
    <!-- headlinks -->
    <div class="headlinks">
    <ul>
      <li><a href="/index.php">Home</a></li>
<!--      <li><a id="fancyURL" href="/contact-fmh.php">Contact</a></li>
-->    </ul>
    </div>
    <!-- / headlinks -->
    
 <!--   <div class="customer_support">Customer Support <span class="number">1-866-660-7800</span></div> -->
  
  </div>
  <!-- / nav bar -->
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
	      <h1>Status: <span>IN PROCESS</span> &nbsp;<a id="fancyURLstatus" href="/status_notification.php?statusId=IN+PROCESS" style="border:thin; border-color:#009FAF; color:#009FAF;"><img src="/images/help2.jpeg" border="0" width="20" height="20"></a></h1>
      <div class="status_form">
        <form action="" method="get">
          <ul>
            <li>
              <label>Tracking #</label> <input name="" type="text" value="20150116-071618-74610307" class="input_item" /></li>
            <li><label>Customer Name:</label> <input name="" type="text" value="SPENCER&nbsp; ARTON" class="input_item" /></li>
            <li><label>PO # </label><input name="" type="text" value="00847009796412" class="input_item" /></li>
            <li><label>Ship to City:</label> <input name="" type="text" value="BELMONT" class="input_item" /></li>
 			<li>
 			  <label>Order Type </label><input name="" type="text" value="Delivery" class="input_item" /></li>
            <li>
              <label>Waybill #: </label><input name="" type="text" value="" class="input_item" /></li>
            <!--
            <li><label>date: </label><input name="" type="text" value="" class="input_item" /></li>
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

        <li><span class="title">Carrier:</span> UPS</li>
        <li><span class="title">Status: </span> IN TRANSIT</li>

        <li><span class="title">Tracking #:</span> 576235903
</li>
        <li><span class="title">Location: </span>Kettleman City, CA</li>

        <li><span class="title">&nbsp;</span></li>
        <li><span class="title">Estimated Delivery: </span> 01/08/2015</li>

        <li><span class="title">&nbsp;</span></li>
        <li><span class="title">&nbsp;</span></li>

        <li><span class="title">&nbsp;</span></li>
        <li><span class="title">&nbsp;</span></li>
        <li><span class="title">&nbsp;</span></li>
        <li><span class="title">&nbsp;</span></li>

        </ul>

<br><br>
<table id="carrier-tracking" border="0" cellpadding="0" cellspacing="0" class="dataTable">
      <tbody><tr class="header">
      <th>Location</th>
      <th>Date</th>
      <th>Time</th>
      <th class="full">Activity</th>
      <th>Trailer</th>
      </tr>
      <tr valign="top" class="odd">
      <td class="nowrap" id="loc0">
      Commerce,&nbsp;
       CA,&nbsp;
      United States
      </td>
      <td class="nowrap" id="date0">01/08/2015</td>
      <td class="nowrap" id="time0">11:57 A.M.</td>
      <td id="descr0">Shipment has been delivered to consignee</td>
      <td class="nowrap" id="trailer0">
        929539
        UPGF
      </td>
      </tr>
      <tr valign="top">
      <td class="nowrap" id="loc1">
      Commerce,&nbsp;
       CA,&nbsp;

      United States

      </td>
      <td class="nowrap" id="date1">01/08/2015</td>
      <td class="nowrap" id="time1">8:31 A.M.</td>
      <td>Out for Delivery</td>

      <td class="nowrap" id="trailer1">
        929539
        UPGF
      </td>
      </tr>
      
      
      
      
      
      
      
      <tr valign="top" class="odd">
      
      
      
      
      <td class="nowrap">
      
      Commerce,&nbsp;
      
      
       CA,&nbsp;
      
      
      United States
      
      </td>
      <td class="nowrap">01/07/2015</td>
      <td class="nowrap">8:34 A.M.</td>
      <td>Shipment has arrived at a Service Center</td>
      
      <td class="nowrap">
        
        294322
        
        UPGF
      </td>
      
      </tr>   
      
      
      
      
      
      
      
      
      
      <tr valign="top">
      
      
      <td class="nowrap">
      
      Kettleman City,&nbsp;
      
      
       CA,&nbsp;
      
      
      United States
      
      </td>
      <td class="nowrap">01/07/2015</td>
      <td class="nowrap">4:38 A.M.</td>
      <td>Departure</td>
      
      <td class="nowrap">
        
        294322
        
        UPGF
      </td>
      
      </tr>         
      </tbody></table>

      </div>

      <div class="status_info">
        <h3>Delivery Agent to Customer</h3>
        <ul>  

        <li><span class="title">&nbsp;</span></li>
        <li><span class="title">&nbsp;</span></li>

        <li><span class="title">Delivery Agent: </span>Dependable&nbsp; Delivery&nbsp; Service</li>
        <li><span class="title">Arrived at Agent: </span> </li>

        <li><span class="title">Phone: </span>510-532-0828</li>
        <li><span class="title">Scheduled Delivery: </span></li>

    	  <li><span class="title"></span></li>
        <li><span class="title">Completed Delivery:  </span></li>

        <li><span class="title"></span></li>
    	  <li><span class="title">Canceled Date:    </span></li>

        </ul>
      </div><!--    		
      </div>
      <div class="status_info">
        <h3>Agent and Schedule Information:</h3>
        <ul>  
          <li>Dependable&nbsp; Delivery&nbsp; Service</li>
          <li><span class="title">Est. Arrival at Agent: </span></li>
          <li><span class="title">Arrived at Agent: </span></li>
          <li><span class="title">Scheduled Delivery: </span></li>
          <li><span class="title">Phone: </span></li>
          <li><span class="title">Delivery: </span></li>
        </ul>
      </div><!--
      <div class="status_info">
        <h3>Delivery Location:</h3>
        <ul>  
          <li><span class="title">Name: </span> SPENCER&nbsp; ARTON</li>
          <li><span class="title">Address: </span>3438&nbsp; LODGE&nbsp; DR</li>
          <li><span class="title">Phone: </span>650-283-0788</li>
          <li><span class="title">City: </span>BELMONT</li>
          <li><span class="title">Email: </span></li>
          <li><span class="title">State: </span>CA</li>
        </ul>
      </div>-->
      <div class="status_info">
        <h3>Product Information</h3>
        <table cellpadding="0" cellspacing="0" border="0" bordercolor="#d9d9d9" width="100%">
        	<tr>
            	<th><span class="title">Line</span></th>
                <th><span class="title">Qty.</span></th>
                <th><span class="title">Description</span></th>
            </tr>
		        	<tr class="table_row">
                <td>1</td>
                <td>
                    1                </td>
                <td>
                    Travers&nbsp; 5-piece&nbsp; Fire&nbsp; Pit&nbsp; Set                </td>
            </tr>
            	        </table>
      </div>
    </div>
    <!-- / status page -->
  
  </div>
  <!-- / main body -->

  <!-- bottom links -->
  	<script type="text/javascript">
		$(document).ready(function() {
			$("#fancyURL").fancybox({
				'width'				: '50%',
				'height'			: '50%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
			$("#fancyURL2").fancybox({
				'width'				: '50%',
				'height'			: '50%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
		});
	</script>
    <div class="bottom_links">
    <ul>
      <li><a id="fancyURL" href="/contact-fmh.php">Contact</a></li>
      <li><a id="fancyURL2" href="/privacy-policy.php">Privacy Policy</a></li>
      <li><a href="http://finalmilehome.com">Back to finalmilehome.com</a></li>
<!--      <li><a href="/agent_access/home.php">Agent Home</a></li>-->
    </ul>
   <!-- <ul class="img">
         <li><img src="/images/logo_sealy.png" alt="" /></li>
    </ul>-->
    </div>  <!-- / bottom links -->

</div>
<!-- / wrapper -->

<!-- footer -->
<div id="footer">
    Powered by <a href="/">Final Mile Home</a>
</div>
<!-- / footer -->

<script type="text/javascript">
	var jsonObj = '<?=$json?>';
	var obj = JSON.parse(jsonObj).Shipment;
	console.log(obj);
	var tracking_number = obj.InquiryNumber.Value;
	// PO not needed yet
	// var po_number = obj.ReferenceNumber.Value;
	var carier = obj.Service.Description;
	var count = 0;
	// List of locations and activities:  We should loop this
	var activityArr = obj.Activity;
	var recent_activity = activityArr[count];

	var activity_date;
	var activity_description;
	var activity_time;
	var activity_trailer;
	var activity_location_city;
	var activity_location_state;

	var recent_activityId;
	var recent_dateId;
	var recent_timeId;
	var recent_descrId;
	var recent_trailerId;


	function initData(){
		recent_activity = activityArr[count];
		activity_date = recent_activity.Date;
		activity_description = recent_activity.Description;
		activity_time = recent_activity.Time;
		activity_trailer = recent_activity.Trailer;
		activity_location_city = recent_activity.ActivityLocation.City;
		activity_location_state = recent_activity.ActivityLocation.StateProvinceCode;

		recent_activityId = document.getElementById('loc' + count);
		recent_dateId = document.getElementById('date' + count);
		recent_timeId = document.getElementById('time' + count);
		recent_descrId = document.getElementById('descr' + count);
		recent_trailerId = document.getElementById('trailer' + count);

		formatDateTime();
	}

	// Date and time adjustments:
	function formatDateTime(){
		var date = activity_date;
		var year = date.substring(0,4);
		var month = date.substring(4,6);
		var day = date.substring(6,8);
		var format_date = month + "/" + day + "/" + year;
		var hour = activity_time.substring(0,2);
		var minutes = activity_time.substring(2,4);
		if(hour < 12){
			var format_time = hour + ":" + minutes + ' A.M.';
		}
		else{
			var format_time = hour + ":" + minutes + ' P.M.';
		}
		setHTML(format_date, format_time);

	}
	function setHTML(format_date, format_time){
		recent_dateId.innerHTML = format_date;
		recent_activityId.innerHTML = activity_location_city + ",&nbsp; " + activity_location_state;
		recent_timeId.innerHTML = format_time;
		recent_descrId.innerHTML = activity_description;
		recent_trailerId.innerHTML = activity_trailer;
		console.log(activity_trailer);

	}

	// this will error out if array is larger than ids. we should dynamically add them, append etc OR agree on a limit of say 4 but this will look weird with only 1 or 2 and a big blank
	var limit = activityArr.length;
	var limit = 2;
	for (var i = 0; i < limit; i++) {
		count = i;
		console.log(count);
		initData();
	}

</script>
</body>
</html>


