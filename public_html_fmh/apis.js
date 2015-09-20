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
    var activityTable = ''; // if we get result as a full table, just use it!
    // console.log( "carrierTrackingID: ", carrierTrackingID, "carrierName: ", carrierName );

    function carrierCheckError(tracklink,carrierName){
      // display a nice error...
      if( $('#arrivedAtAgent').text() != "" ){
        $('#carrierStatus').text('Delivered');
      }
      else{
        if( carrierStatus ){
          $('#carrierStatus').text(carrierStatus);
        }else{
          if( typeof tracklink != 'undefined' ){
            $('#carrierStatus').replaceWith('<span id="carrierStatus">In Transit: <a target="_blank" href="'+tracklink+'">Check '+carrierName+'.</a></span>');
          }else{
            $('#carrierStatus').text('In Transit');
          }
        }
      }
      $('.unknown').hide();
    }
    // console.log('carrierName',carrierName);
    switch(carrierName){
      /*
      FedEx (Sample PO 00847003947415)
      Main Freight (Sample PO 00847003856922) - MFTM0124033
      USF Reddaway (Sample PO 00847002722929) - 52617536845
      Gencom - same as Genwest - updated URL for tracking
      Central Transport (Sample PO 00847003748610) -  41494611936 - can't automatically fill this in, but can link to window
      Wilson Trucking (Sample PO 00847003461768) - 86814045 (old tracking number works),  2229073 (new tracking number doesn't)
      */
      case "FedEx":
        carrierCheckError('https://www.fedex.com/apps/fedextrack/?action=track&cntry_code=us&trackingnumber='+carrierTrackingID,'FedEx');
        break;
      case "Main Freight":
        carrierCheckError('http://www.mainfreight.com/Track/MSUSS/'+carrierTrackingID,'Main Freight');
        break;
      // case "USF Reddaway": need origin or destination zip code to work
      //   carrierCheckError('http://reddawayregional.com/'+carrierTrackingID,'USF Reddaway');
      //   break;
      case "Central Transport":
        carrierCheckError('http://www.centraltransportint.com/confirm/trace.aspx?_ctl0:traceNumbers='+carrierTrackingID,'Central Transport');
        break;
      case "Wilson Trucking":
        carrierCheckError('http://www.wilsontrucking.com/WilsonWeb/servlet/com.wilsontrucking.mainframe.io.DirectLink?nbrPro0='+carrierTrackingID,'Wilson Trucking');
        break;

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

      case "ABF":
        $.ajax({
          dataType: "json",
          url: APIscriptsURLbase + "abf.php?id="+carrierTrackingID,
          success: function(data){ 
              if( typeof data.SHIPMENTS != 'undefined' ){
                // we have a shipment we can display info for
                // however, we're getting a limited amount of info, due to our account type so streamlining it
                row = data.SHIPMENTS;
                // carrierStatus = row.SHIPMENT.LONGSTATUS; // 011 = delivered
                // carrierLocation = row.SHIPMENT.CONSIGNEEADDRESS1 + ", " + row.SHIPMENT.CONSIGNEECITY + " " + row.SHIPMENT.CONSIGNEESTATE;
                if( typeof row.SHIPMENT.PICKUP != 'object' ){
                  carrierStatus = 'Picked Up on '+row.SHIPMENT.PICKUP;
                  carrierETD = row.SHIPMENT.DUEDATE;
                }
                else{
                  carrierStatus = 'In Transit';
                  carrierETD = row.SHIPMENT.DUEDATE;
                }
                drawCarrierActivity();
              }
              else{
                carrierCheckError();
              }
          },
          error: carrierCheckError 
        });
        break;

      case "Old Dominion":
        $.ajax({
          dataType: "json",
          url: APIscriptsURLbase + "olddom.php?id="+carrierTrackingID,
          success: function(data){ 
              /*
                  proDate, statusCode, status, destAddress, destState, destCity, destZip
              */
              carrierLocation = data.getTraceDataReturn.destAddress + ", " + data.getTraceDataReturn.destCity + " " + data.getTraceDataReturn.destState;              

              if( data.getTraceDataReturn.status == 'Delivered' ) carrierATD = data.getTraceDataReturn.proDate;
              else carrierETD = data.getTraceDataReturn.proDate;

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
            if( data.status == '' ){
              carrierCheckError();
            }
            else{
              /*
                values we get back:
                'shipment_history' => $shipment_history,
                'status' => $status,
                'estimated_delivery' => $ed,
                'actual_delivery' => $ad);
             */
              carrierStatus = data.status;
              if( data.status == 'Delivered' ) carrierATD = data.actual_delivery;
              else carrierETD = data.estimated_delivery;
              activityTable = data.shipment_history;
              drawCarrierActivity();
            }
          },
          error: carrierCheckError 
        });
        break;

      case "Yellow Freight":
        $.ajax({
          dataType: "json",
          url: APIscriptsURLbase + "yrc.php?id="+carrierTrackingID,
          success: function(data){ 
            if( data.status == '' ){
              carrierCheckError();
            }
            else{
              /*
                values we get back:
                'shipment_history' => $shipment_history,
             */
              carrierStatus = data.status;
              activityTable = data.shipment_history;
              carrierETD = data.estimated_delivery;
              drawCarrierActivity();
            }
          },
          error: carrierCheckError()
        });      
        break;

      case "Ceva":
        $.ajax({
          dataType: "json",
          url: APIscriptsURLbase + "ceva.php?id="+carrierTrackingID,
          success: function(data){ 
            if( data.status == '' || data.ship_date.substring(0,14) == 'CEVA Logistics'){
              // bad tracking number
              carrierStatus = "Tracking ID not found.";
              carrierCheckError();
            }
            else{
              /*
                values we get back:
                'shipment_history' (a table)
                'ship_date'
                'estimated_delivery'
                'delivery_type'
                'status' (Delivered / In Transit)
             */
              carrierStatus = data.status;
              carrierETD = data.estimated_delivery;              
              carrierATD = data.actual_delivery;
              activityTable = data.shipment_history;
              drawCarrierActivity();
            }
          },
          error: carrierCheckError 
        });
        break;

      case "Gencom":
      case "Genwest":
        $.ajax({
          dataType: "json",
          url: APIscriptsURLbase + "genwest.php?id="+carrierTrackingID,
          success: function(data){ 
            if( data.status == '' ){
              // we're in somewhere in the transit process
              carrierStatus = data.current_location;
              carrierCheckError();
              // carrierLocation = data.current_location;
              activityTable = data.shipment_history;
              drawCarrierActivity();
            }
            else{
              /*
                values we get back:
                'shipment_history' (a table)
                'status' (long string w/signage info)
                'current_location'
                'delivery_date'
             */
              carrierATD = data.delivery_date;
              carrierStatus = data.status;
              carrierLocation = data.current_location;
              activityTable = data.shipment_history;
              drawCarrierActivity();
            }
          },
          error: carrierCheckError 
        });
        break;

      case "New England MF":
        $.ajax({
          dataType: "json",
          url: APIscriptsURLbase + "nemf.php?id="+carrierTrackingID,
          success: function(data){ 
            if( data.status == '' ){
              carrierCheckError();
            }
            else{
              /*
                values we get back:
                'shipment_history' (a table)
                'status' (long string w/signage info)
             */
              carrierStatus = data.status;
              activityTable = data.shipment_history;
              drawCarrierActivity();
              $('.unknown').hide();
            }
          },
          error: carrierCheckError 
        });
        break;

    case "Averitt":
        $.ajax({
          dataType: "json",
          url: APIscriptsURLbase + "averitt.php?id="+carrierTrackingID,
          success: function(data){ 
            if( data.status == '' ){
              carrierCheckError();
            }
            else{
              /*
                values we get back:
                'shipment_history' (a table)
                'status' (long string w/signage info)
             */
              carrierStatus = data.status;
              activityTable = "<br><br>"+data.shipment_history;
              drawCarrierActivity();
              $('.unknown').hide();
            }
          },
          error: carrierCheckError 
        });
        break;

    case "Conway":
        $.ajax({
          dataType: "json",
          url: APIscriptsURLbase + "conway.php?id="+carrierTrackingID,
          success: function(data){ 
            console.log(data);
            if( !data.Status ){
              carrierStatus = data.Error;
              carrierCheckError();
            }
            else{
              // console.log(data);
              carrierStatus = data.Status;
              carrierETD = data.DeliveryETA;
              if( data.Delivered != "false" ) carrierATD = data.Delivered;
              else carrierATD = false;

              for( var i = 0; i < data.History.length; i++ ){
                row = data.History[i];
                // row: activtyLocation (City, StateProvinceCode), Description, Date, Time, Trailer
                // match this to our table, in case other api formats differ - or normalize this in the PHP
                // location, date, time, activity, trailer
                tablerow = {
                  'location': row.Location,
                  'datetime': row.Date,
                  'activity': row.Status,
                  'trailer': row.Details 
                };
                activityRows.push(tablerow); 
              }

              // activityTable = "<br><br>"+data.shipment_history;
              drawCarrierActivity();
            }
          },
          error: carrierCheckError
        });
        break;

      case "JTS":
        $.ajax({
          dataType: "json",
          url: APIscriptsURLbase + "jts.php?id="+carrierTrackingID,
          success: function(data){ 
            carrierStatus = data.status;
            if( data.success ){
              activityTable = data.shipment_history;
              carrierCheckError();
            }
            else{
              carrierCheckError();
            }
            drawCarrierActivity();
          },
          error: function(error){
            carrierStatus = error.statusText;
            carrierCheckError();
          }
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
        $('#carrierETD').text( carrierETD + " (estimated/due) ");
        $('.unknown').removeClass('unknown');
      }
      if( carrierATD ){
        if( $('#arrivedAtAgent').text() == '' ){
          $('#arrivedAtAgent').text(carrierATD);
        }
        else{
          $('#carrierETD').text( carrierATD + " (actual) ");
        }
        $('.unknown').removeClass('unknown');
      }

      // process activity ... most recent is first
      for( var i = 0; i < activityRows.length; i++ ){
        if( i == 0 ){
          // $('#carrierLocation').text( activityRows[0].location );
          carrierLocation = activityRows[0].location;
          $('#carrierActivity').removeClass('hidden');
        }
        row = activityRows[i];
        // append row to #carrierActivity table: location, datetime, activity, trailer
        $('#carrierActivity tr:last').after('<tr><td>'+row.location+'</td><td>'+row.datetime+'</td><td>'+row.activity+'</td><td>'+row.trailer+'</td></tr>');
      }
      if( activityTable ){
        $('<table>').html
        $('#carrierActivity').replaceWith( activityTable );
      }

      if( carrierLocation ){
        $('#carrierLocation').text( carrierLocation );        
      }else{
        $('#carrierLocation').prev().replaceWith('<span class="title">&nbsp;</span>');
      }

    }

  });
