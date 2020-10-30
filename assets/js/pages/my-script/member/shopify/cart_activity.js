"use strict";

// Class definition
var KTCartActivities = (function () {
    var _initcartgraph = function() {
        var element = document.getElementById("graph_cart_mixed");

        if (!element) {
            return;
        }

        var options = {
            series: [{
            name: 'Sales',
            type: 'column',
            data: [23, 11, 22, 27, 13, 22, 37, 21, 44, 22, 30]
          }, {
            name: 'Abandoned Cart',
            type: 'area',
            data: [44, 55, 41, 67, 22, 43, 21, 41, 56, 27, 43]
          }, {
            name: 'Checkout Cart',
            type: 'line',
            data: [30, 25, 36, 30, 45, 35, 64, 52, 59, 36, 39]
          }],
            chart: {
            height: 350,
            type: 'line',
            stacked: false,
          },
          stroke: {
            width: [0, 2, 5],
            curve: 'smooth'
          },
          plotOptions: {
            bar: {
              columnWidth: '50%'
            }
          },
          
          fill: {
            opacity: [0.85, 0.25, 1],
            gradient: {
              inverseColors: false,
              shade: 'light',
              type: "vertical",
              opacityFrom: 0.85,
              opacityTo: 0.55,
              stops: [0, 100, 100, 100]
            }
          },
          labels: ['01/01/2003', '02/01/2003', '03/01/2003', '04/01/2003', '05/01/2003', '06/01/2003', '07/01/2003',
            '08/01/2003', '09/01/2003', '10/01/2003', '11/01/2003'
          ],
          markers: {
            size: 0
          },
          xaxis: {
            type: 'datetime'
          },
          yaxis: {
            title: {
              text: 'Points',
            },
            min: 0
          },
          tooltip: {
            shared: true,
            intersect: false,
            y: {
              formatter: function (y) {
                if (typeof y !== "undefined") {
                  return y.toFixed(0) + " points";
                }
                return y;
          
              }
            }
          }
          };
  
       
        var chart = new ApexCharts(element, options);
        chart.render();
    }
    var Abandonedcart = function() {
var id_cart='';
      // begin first table
      var table = $('#kt_abon_table').DataTable({
        responsive: true,
  
        buttons: [
          'print',
          'copyHtml5',
          'excelHtml5',
          'csvHtml5',
          'pdfHtml5',
        ],
        processing: true,
        serverSide: true,
        ajax: {
          url: path + "action/m/shopify/cart_activities/get_abond.php",
          type: 'POST',
          data: {
            // parameters for custom backend script demo
            columnsDef: [
              'id' ,'email','cart_name',
               'name', 'created_at','total_price','customer_id',
              
          
             ],
             
          
          },
        },
        columns: [
          {data: 'id'},
          {data: 'cart_name'},
          {data: 'name'},
          {data: 'email'},
          {data: 'created_at'},
          {data: 'total_price'},
          {data: 'customer_id'},
         
      
        ],
        columnDefs: [
          {
            targets:0,
            "visible": false,
          },
          {
            targets:1,
// TODO: currenlty il removw # from name to create String

            render: function(data, type, full, meta) {
              id_cart=data.substring(1);
           console.log(full[1]);
              return '\
                <a href="'+shop+'checkouts/'+id_cart+'" target="_blank">\
                '+data+'\
                </a>\
              ';
            },
          }, {
            targets:5,

       
            render: function(data, type, full, meta) {
           
              return data+' '+currency;
            },
          },
          {
            targets:-1,
            title: 'Actions',
            orderable: false,
            render: function(data, type, full, meta) {
         
              return '\
                <a href="'+shop+'customers/'+data+'" class="btn btn-sm btn-clean btn-icon" target="_blank" title="View Customer">\
                  <i class="la la-eye"></i>\
                </a>\
              ';
            },
          },
        ],
       
      });
  
      $('#export_print').on('click', function(e) {
        e.preventDefault();
        table.button(0).trigger();
      });
  
      $('#export_copy').on('click', function(e) {
        e.preventDefault();
        table.button(1).trigger();
      });
  
      $('#export_excel').on('click', function(e) {
        e.preventDefault();
        table.button(2).trigger();
      });
  
      $('#export_csv').on('click', function(e) {
        e.preventDefault();
        table.button(3).trigger();
      });
  
      $('#export_pdf').on('click', function(e) {
        e.preventDefault();
        table.button(4).trigger();
      });
  
    };
  
  // Public methods
  return {
    init: function () {
        _initcartgraph();
        Abandonedcart();
    
    },
  };
})();

// Webpack support
if (typeof module !== "undefined") {
  module.exports = KTWidgets;
}

jQuery(document).ready(function () {

    $.ajax({
      url: path + "action/m/shopify/cart_activities/load_js.php",
      type: "POST",
      data: { get_json: 1 },
      success: function (response) {
        if(response=='1'){

          console.log('well done');

        }
      },
    });
    KTCartActivities.init();
});
