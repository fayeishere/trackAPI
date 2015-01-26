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

    function carrierCheckError(tracklink){
      // display a nice error...
      $('#carrierStatus').text('Unknown');
      $('.unknown').hide();
      if( tracklink ){
        console.log('do something');
        // if there's a manuall tracking link, output it here
      }
    }

    switch(carrierName){
      case "UPS Freight":
        $.ajax({
          dataType: "json",
          url: APIscriptsURLbase + "ups.php?id="+carrierTrackingID,
          success: function(data){ 
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

      case "Old Dominion":
        $.ajax({
          dataType: "json",
          url: APIscriptsURLbase + "olddom.php?id="+carrierTrackingID,
          success: function(data){ 
              console.log(data.getTraceDataReturn);  
              /*
                  proDate, statusCode, status, destAddress, destState, destCity, destZip
              */
              carrierLocation = data.getTraceDataReturn.destAddress + ", " + data.getTraceDataReturn.destCity + " " + data.getTraceDataReturn.destState;
              carrierETD = data.getTraceDataReturn.proDate;
              carrierStatus = data.getTraceDataReturn.status;
              drawCarrierActivity();
            },
          error: carrierCheckError 
        });
        break;

      case "Saia":
        $.ajax({
          dataType: "json",
          url: APIscriptsURLbase + "saia.php?id="+carrierTrackingID,
          success: function(data){ 
              console.log(data.GetByProNumberResult);  
              carrierCheckError(); // not ready to draw the results yet
              // drawCarrierActivity();
            },
          error: carrierCheckError 
        });
        break;

      default:
        carrierCheckError();
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
      if( carrierLocation ){
        $('#carrierLocation').text( carrierLocation );        
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
