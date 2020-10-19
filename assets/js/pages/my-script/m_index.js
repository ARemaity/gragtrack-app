"use strict";
// Class definition

var m_index_page = (function () {
  // card blocking
  var latest_order = function () {
    $(document).ready(function () {
      KTApp.block("#kt_blockui_card", {
        overlayColor: "#000000",
        state: "secondary",
        message: "Processing...",
      });
      // get the latest order [current all] TODO: add filter paid , cancel
      $.ajax({
        url: "../action/m/index/latest_orders.php",
        type: "post",
        dataType: "JSON",
        data: { init: 1 },
        success: function (response) {
          var len = response.length;
          var fname;
          var lname;
          var ccountry;
          for (var i = 0; i < len; i++) {
            if (response[i].fname == "null") {
              fname = "NUll";
            } else {
              fname = response[i].fname;
            }

            if (response[i].lname == "null") {
              lname = "Name";
            } else {
              lname = response[i].lname;
            }

            if (response[i].ccountry == "null") {
              ccountry = "Null";
            } else {
              ccountry = response[i].cn;
            }
            var cid = response[i].cid;
            var nbitem = response[i].nbitem;
            var total = response[i].total;

            var tr_str =
              "<tr>" +
              "<td class='align-middle pb-6'>" +
              " <div class='font-size-lg font-weight-bolder text-dark-75 mb-1'>" +
              fname +
              " " +
              lname +
              "</div>" +
              " <div class='font-weight-bold text-muted'>" +
              ccountry +
              "</div>" +
              " </td>" +
              "<td class='font-weight-bold text-muted align-middle text-right pb-6'>" +
              "<span class='text-success font-size-h5 font-weight-bolder ml-1'>" +
              nbitem +
              "</span>" +
              "</td>" +
              "<td class='text-right align-middle pb-6'>" +
              "<div class='font-size-lg font-weight-bolder text-dark-75'>" +
              currency +
              " " +
              total +
              "</div>" +
              "</td>" +
              "<td class='text-right align-middle pb-6'>" +
              "<div class='font-size-lg font-weight-bolder text-dark-75'>" +
              "<div class='dropdown dropdown-inline'>"+
              "<button type='button' class='btn btn-light-primary btn-icon btn-sm' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>"+
                  "<i class='ki ki-bold-more-ver'></i>"+
              "</button>"+
             " <div class='dropdown-menu'>"+
             "<a class='dropdown-item' href='#'>View Order</a>"+
             "<a class='dropdown-item' href='#'>View Customer</a>"+
             " </div>"+
          "</div>"+
              "</div>" +
              "</td>" +
              "</tr>";

            $("#latest_order tbody").append(tr_str);
          }
          KTApp.unblock("#kt_blockui_card");
        },
      });
    });
  };

  var mix_sales = function () {
    $(document).ready(function () {
      var gross_sales = 0;
      var net_sales = 0;
      var total_sales = 0;
      var Net_quantity = 0;
      KTApp.block("#blockui_mix_sales", {
        overlayColor: "#000000",
        state: "secondary",
        message: "Processing...",
      });
      // get the latest order [current all] TODO: add filter paid , cancel
      $.ajax({
        url: "../action/m/index/mix_sales.php",
        type: "POST",
        dataType: "JSON",
        data: { get_mix: 1 },
        success: function (response) {
          console.log(response);
          gross_sales = response.grosale;
          net_sales = response.net_sales;
          total_sales = response.total_sales;
          Net_quantity = response.net_qty;
          $("#gross_sales").html(gross_sales + " " + currency);
          $("#net_sales").html(net_sales + " " + currency);
          $("#total_sales").html(total_sales + " " + currency);
          $("#net_quantity").html(Net_quantity + " product");
          KTApp.unblock("#blockui_mix_sales");
        },
      });
    });
  };

  // card blocking
  var webhook_log = function () {
    $(document).ready(function () {
      KTApp.block("#kt_wh_logs_card", {
          overlayColor: "#000000",
          state: "secondary",
          message: "Processing...",
        });
      // get the latest order [current all] TODO: add filter paid , cancel
      $.ajax({
        url: "../action/m/index/log_webhook.php",
        type: "post",
        // dataType: 'JSON',
        data: { get_log: 1 },
        success: function (response) {
          console.log(response);
          var logs_js = JSON.parse(response);
          if (logs_js.isdata == 0) {
              console.log('no data');
           var logs_no=
                  '<div class="d-flex flex-center text-center text-muted min-h-200px">'+
                                                    'All caught up!'+
                                                    '<br>'+
                                                    'No new notifications.'+
                                                '</div>';

                                                $("#m_wh_logs").append(logs_no);
                                                KTApp.unblock("#kt_wh_logs_card");
          } else {
     
            $.each(logs_js.logs, function (i, log) {
              var type = "";
              var color="";
              switch (log.type) {
                case 1:
                    color="primary";
                    
                  break;
                case 2:
                    color="success";
                  break;
                case 3:
                    color="warning";
                  break;
                case 4:
                    color="danger";
                  break;
                  
                  
                default:
                  break;
              }
              var output_logs =
                '<div class="mb-6">' +
                '<div class="d-flex align-items-center flex-grow-1">' +
                ' <div class="d-flex flex-wrap align-items-center justify-content-between w-100">' +
                '<div class="d-flex flex-column align-items-cente py-2 w-75">' +
                '<a href="#"' +
                'class="text-dark-75 font-weight-bold text-hover-primary font-size-lg mb-1">' +
               
                log.sub_title +
                "</a>" +
                '<span class="text-muted font-weight-bold">' +
                log.time +
                "</span>" +
                " </div>" +
                "<span " +
                'class="label label-lg label-light-'+color+' label-inline font-weight-bold py-4">' +
                log.title+
                "</span>" +
                "</div>" +
                "</div>" +
                "</div>";
                $("#m_wh_logs").append(output_logs);
            });
            KTApp.unblock("#kt_wh_logs_card");
          }
        },
      });
    });
  };

  var event_log = function () {
    $(document).ready(function () {
      KTApp.block("#kt_event_logs_card", {
          overlayColor: "#000000",
          state: "secondary",
          message: "Processing...",
        });
      // get the latest order [current all] TODO: add filter paid , cancel
      $.ajax({
        url: "../action/m/index/log_event.php",
        type: "post",
        // dataType: 'JSON',
        data: { get_log: 1 },
        success: function (response) {
          console.log(response);
          var logs_js = JSON.parse(response);
          if (logs_js.isdata == 0) {
              console.log('no data');
           var logs_no=
                  '<div class="d-flex flex-center text-center text-muted min-h-200px">'+
                                                    'All caught up!'+
                                                    '<br>'+
                                                    'No new notifications.'+
                                                '</div>';

                                                $("#event_main_body").append(logs_no);
                                                KTApp.unblock("#kt_event_logs_card");
          } else {
     
            $.each(logs_js.logs, function (i, log) {
             var id=0;
             var sub_id=0;
             var sub_type='';
             var verbs='';
             var msg=log.message;
             var labels='';
             var icon='';
switch (log.subject_type) {
  case 'Product':
    icon="<i class='flaticon2-box-1 text-primary'></i>";
    switch (log.verb) {
      case 'create':
        labels="<span class='label label-inline label-success font-weight-bolder'>Create</span>";
        break;
        case 'destroy':
          labels="<span class='label label-inline label-danger font-weight-bolder'>Destroy</span>";
          break;

          case 'published':
            labels="<span class='label label-inline label-success font-weight-bolder'>Published</span>";
            break;
            case 'unpublished':
              labels="<span class='label label-inline label-warning font-weight-bolder'>Unpublished</span>";
              break;
  
      default:
        labels="<span class='label label-inline label-secondary font-weight-bolder'>"+log.verb+"</span>";
        break;
    }
    break;
    case 'Order':
      icon="<i class='flaticon2-shopping-cart text-primary'></i>";
    switch (log.verb) {
      case 'authorization_success':
      case 'capture_success':
      case 'confirmed':
      case 'fulfillment_success':
      case 'refund_success':
      case 'sale_success':
        labels="<span class='label label-inline label-success font-weight-bolder'>"+log.verb+"</span>";
        break;
      case 'authorization_failure':
      case 'capture_failure':
      case 'fulfillment_cancelled':
      case 'refund_failure':
      case 'sale_failure':
      case 'void_failure':
          labels="<span class='label label-inline label-danger font-weight-bolder'>"+log.verb+"</span>";
          break;

      default:
        labels="<span class='label label-inline label-secondary font-weight-bolder'>"+log.verb+"</span>";
        break;
    }
    break;

  default:
    break;
}
var href_index=msg.indexOf('<a');
if(href_index>0){
  msg=[msg.slice(0,href_index+2), " target='_blank'", msg.slice(href_index+2)].join('');
  
}
              var output_logs =
              "<div class='timeline-item'>"+
              "<div class='timeline-badge'>"+

           icon+"</div>"+
              "<div class='timeline-content d-flex align-items-center justify-content-between'>"+
                 " <span class='mr-3'>"+
                 msg+
                "<span class='label label-inline label-primary font-weight-bolder'>"+log.subject_type+"</span>"+
                labels+
                  "</span>"+
                  "<span class='text-muted text-right'>"+log.time+"</span>"+
              "</div>"+
          "</div>";

                $("#event_log_card").append(output_logs);
            });
            KTApp.unblock("#kt_event_logs_card");
          }
        },
      });
    });
  };

  return {
    // public functions
    init: function () {
      latest_order();
      mix_sales();
      webhook_log();
      event_log();
    },
  };
})();

jQuery(document).ready(function () {
  m_index_page.init();
});
