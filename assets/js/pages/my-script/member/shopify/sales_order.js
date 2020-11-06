"use strict";

// Class definition
var KTWidgets = (function () {
  // Private properties
  var _initDaterangepicker = function () {
    if ($("#kt_dashboard_daterangepicker").length == 0) {
      return;
    }

    var picker = $("#kt_dashboard_daterangepicker");
    var start = moment();
    var end = moment();

    function cb(start, end, label) {
      var title = "";
      var range = "";

      if (end - start < 100 || label == "Today") {
        title = "Today:";
        range = start.format("MMM D");
      } else if (label == "Yesterday") {
        title = "Yesterday:";
        range = start.format("MMM D");
      } else {
        range = start.format("MMM D") + " - " + end.format("MMM D");
      }

      $("#kt_dashboard_daterangepicker_date").html(range);
      $("#kt_dashboard_daterangepicker_title").html(title);
    }

    picker.daterangepicker(
      {
        direction: KTUtil.isRTL(),
        startDate: start,
        endDate: end,
        opens: "left",
        applyClass: "btn-primary",
        cancelClass: "btn-light-primary",
        ranges: {
          Today: [moment(), moment()],
          Yesterday: [
            moment().subtract(1, "days"),
            moment().subtract(1, "days"),
          ],
          "Last 7 Days": [moment().subtract(6, "days"), moment()],
          "Last 30 Days": [moment().subtract(29, "days"), moment()],
          "This Month": [moment().startOf("month"), moment().endOf("month")],
          "Last Month": [
            moment().subtract(1, "month").startOf("month"),
            moment().subtract(1, "month").endOf("month"),
          ],
        },
      },
      cb
    );

    cb(start, end, "");
  };

  var _initshopifysales = function () {
    var element = document.getElementById("chart_shopify_mixed");

    if (!element) {
      return;
    }

  var options = {
          series: [{
          name: 'Net Sales',
          data: [31, 40, 28, 51, 42, 109, 100]
        }, {
          name: 'Gross Sales',
          data: [11, 32, 45, 32, 34, 52, 41]
        }],
          chart: {
          height: 350,
          type: 'area'
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'smooth'
        },
        xaxis: {
          type: 'datetime',
          categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z", "2018-09-19T06:30:00.000Z"]
        },
        tooltip: {
          x: {
            format: 'dd/MM/yy'
          },
        },
        };

        var chart = new ApexCharts(element, options);
        chart.render();
  };




  var jsons = {
    type: "map",
    theme: "light",
    dataProvider: {
      map: "worldHigh",
      zoomLevel: 1,
      zoomLongitude: 10,
      zoomLatitude: 52,
      areas: [],
    },

    areasSettings: {
      rollOverOutlineColor: "#FFFFFF",
      rollOverColor: "#CC0000",
      alpha: 0.8,
      unlistedAreasAlpha: 0.1,
      balloonText: "[[title]] has  [[customData]] orders",
    },

    legend: {
      width: "100%",
      marginRight: 27,
      marginLeft: 27,
      equalWidths: false,
      backgroundAlpha: 0.5,
      backgroundColor: "#FFFFFF",
      borderColor: "#ffffff",
      borderAlpha: 1,
      top: 450,
      left: 0,
      horizontalGap: 10,
      data: [
        {
          title: "Strong",
          color: "#67b7dc",
        },
        {
          title: "Good",
          color: "#ebdb8b",
        },
        {
          title: "Normal",
          color: "#83c2ba",
        },
      ],
    },
    export: {
      enabled: false,
    },
  };

  countriesArr.map(function (item) {
    jsons.dataProvider.areas.push({
      title: item.title,
      id: item.id,
      color: item.color,
      customData: item.customData,
      groupId: item.groupId,
    });
  });

  var _initlocationMap = function () {
    var map = AmCharts.makeChart("map_location", jsons);
  };
  var _source_order = function () {
    $(document).ready(function () {
      var sourcename = [];
      var sourcedata = [];
      var sumorder = 0;
      KTApp.block("#blockui_source_order", {
        overlayColor: "#000000",
        state: "secondary",
        message: "Processing...",
      });
      // get the latest order [current all] TODO: add filter paid , cancel
      $.ajax({
        url: path + "action/m/shopify/sales_order/order_source.php",
        type: "POST",
        dataType: "JSON",
        data: { get_mix: 1 },
        success: function (response) {
          console.log(response);

          if (response.isdata == 0) {
            console.log("no data");
            var output =
              '<div class="d-flex flex-center text-center text-muted min-h-200px">' +
              "<br>" +
              "No Records" +
              "</div>";

            $("#order_source_body").append(output);
            KTApp.unblock("#blockui_source_order");
          } else {
            $.each(response.source, function (i, log) {
              sourcedata.push(log.nb);
              if (log.name == "shopify_draft_order") {
                sourcename.push("Draft Order");
              } else {
                sourcename.push(log.name);
              }

              sumorder += parseInt(log.nb);
            });

            //
            const apexChart = "#chart_source";
            var options = {
              series: sourcedata,
              chart: {
                height: 350,
                type: "radialBar",
              },
              plotOptions: {
                radialBar: {
                  dataLabels: {
                    name: {
                      fontSize: "22px",
                    },
                    value: {
                      fontSize: "16px",
                    },
                    total: {
                      show: true,
                      label: "Total",
                      formatter: function (w) {
                        // By default this function returns the average of all series. The below is just an example to show the use of custom formatter function
                        return sumorder;
                      },
                    },
                  },
                },
              },
              labels: sourcename,
            };

            var chart = new ApexCharts(
              document.querySelector(apexChart),
              options
            );
            chart.render();

            KTApp.unblock("#blockui_source_order");
          }
        },
      });
    });
  };
  var _sales_status = function () {
    $(document).ready(function () {
      KTApp.block("#sales_st_container", {
        overlayColor: "#000000",
        state: "secondary",
        message: "Processing...",
      });
      // get the latest order [current all] TODO: add filter paid , cancel
      $.ajax({
        url: path + "action/m/shopify/sales_order/sales_status.php",
        type: "POST",
        dataType: "JSON",
        data: { get_st: 1 },
        success: function (response) {
            var st_img=$('#sales_st_img');
            var st_txt=$('#sales_st_txt');
            var st_counter=$('#sales_st_count');
          console.log(response);

          if (response.isdata == 0) {
            console.log("no data");
            var output =
              '<div class="d-flex flex-center text-center text-muted min-h-200px">' +
              "<br>" +
              "No Records" +
              "</div>";

            $("#sales_st_container").append(output);
            KTApp.unblock("#sales_st_container");
          } else {
            //
            var st_data = response.data;
            if(st_data > 50){
             
                st_img.attr("src","assets/media/bg/giphy.gif");
                st_txt.html("NICE");
                st_counter.html(st_data+" sales");
            }
             else if(st_data < 50 && st_data >= 20){
              
                st_img.attr("src","assets/media/bg/giphy.gif");
                st_txt.html("good");
                st_counter.html(st_data+" sales");
             }
              else if(st_data < 20 && st_data >= 5){
                
                st_img.attr("src","assets/media/bg/giphy.gif");
                st_txt.html("normal");
                st_counter.html(st_data+" sales");
                  }
             else if(st_data < 5){
              
                st_img.attr("src","assets/media/bg/giphy.gif");
                st_txt.html("bad");
                st_counter.html(st_data+" sales");
              }else {
                st_img.attr("src","assets/media/bg/giphy.gif");
                st_txt.html("normal");
                st_counter.html(st_data+" sales");
              }
        
            

            KTApp.unblock("#sales_st_container");
          }
        },
      });
    });
  };

  // Public methods
  return {
    init: function () {
      _initDaterangepicker();
      _initshopifysales();
      _sales_status();
      _initlocationMap();
      _source_order();
    },
  };
})();

// Webpack support
if (typeof module !== "undefined") {
  module.exports = KTWidgets;
}

jQuery(document).ready(function () {
  KTWidgets.init();
  $.ajax({
    url: path + "action/m/shopify/sales_order/get_total_sales.php",
    type: "POST",
    data: { get_total: 1 },
    success: function (response) {
      $('#total_sales').html(response+" "+currency);
    },
  });

    KTApp.block("#kt_best_seller", {
        overlayColor: "#000000",
        state: "secondary",
        message: "Processing...",
      });
    // get the latest order [current all] TODO: add filter paid , cancel
    $.ajax({
      url: "action/m/shopify/sales_order/best_seller.php",
      type: "post",
      // dataType: 'JSON',
      data: { get_best: 1 },
      success: function (response) {
        console.log(response);
        var seller = JSON.parse(response);
        if (seller.isdata == 0) {
            console.log('no data');
         var no_data=
                '<div class="d-flex flex-center text-center text-muted min-h-200px">NO RECORDS</div>';

                                              $("#best_seller_body").append(no_data);
                                              KTApp.unblock("#kt_best_seller");
        } else {
   
          $.each(seller.data, function (i, data) {
        
          
            var output_seller =
            '<div class="d-flex mb-8">'+
                                '<div class="symbol symbol-50 symbol-2by3 flex-shrink-0 mr-4">'+
                                    '<div class="d-flex flex-column">'+
                                        '<div class="symbol-label mb-3"'+
                                            'style="background-image: url('+data.url+')">'+
                                        '</div>'+

                                    '</div>'+
                                '</div>'+
                             
                                '<div class="d-flex flex-column flex-grow-1 my-lg-0 my-2 pr-3">'+
                                    '<a href="#"'+
                                        'class="text-dark-75 font-weight-bolder text-hover-primary font-size-lg mb-2">'+data.title+'</a>'+
                                    '<span class="text-muted font-weight-bold font-size-lg">Price:'+
                                      ' <span class="text-dark-75 font-weight-bolder">'+data.price+" "+currency+'</span></span>'+
                                    '<span class="text-muted font-weight-bold font-size-lg">Sales:'+
                                        '<span class="text-dark-75 font-weight-bolder">'+data.sales+'</span></span>'+
                                '</div>'+
                                
                            '</div>';
              $("#best_seller_body").append(output_seller);
          });
          KTApp.unblock("#kt_best_seller");
        }
      },
    });

});
