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
      case "UPS":

        $.ajax({
          dataType: "json",
          url: "http://localhost:8000/ups.php?id="+carrierTrackingID,
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
        'width'       : '50%',
        'height'      : '25%',
        'autoScale'     : false,
        'transitionIn'    : 'none',
        'transitionOut'   : 'none',
        'type'        : 'iframe'
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

        <li><span class="title">Carrier:</span> <span id="carrierName">UPS</span></li>
        <li><span class="title">Status: </span> <span id="carrierStatus">checking...</span></li>

        <li><span class="title">Tracking #:</span> <span id="carrierTrackingID">576235903</span></li>
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
        'width'       : '50%',
        'height'      : '50%',
        'autoScale'     : false,
        'transitionIn'    : 'none',
        'transitionOut'   : 'none',
        'type'        : 'iframe'
      });
      $("#fancyURL2").fancybox({
        'width'       : '50%',
        'height'      : '50%',
        'autoScale'     : false,
        'transitionIn'    : 'none',
        'transitionOut'   : 'none',
        'type'        : 'iframe'
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
</body>
</html>