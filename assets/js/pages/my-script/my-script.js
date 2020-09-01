"use strict";

// Class definition
var KTWidgets = function() {
    // Private properties
    var _initDaterangepicker = function() {
        if ($('#kt_dashboard_daterangepicker').length == 0) {
            return;
        }

        var picker = $('#kt_dashboard_daterangepicker');
        var start = moment();
        var end = moment();

        function cb(start, end, label) {
            var title = '';
            var range = '';

            if ((end - start) < 100 || label == 'Today') {
                title = 'Today:';
                range = start.format('MMM D');
            } else if (label == 'Yesterday') {
                title = 'Yesterday:';
                range = start.format('MMM D');
            } else {
                range = start.format('MMM D') + ' - ' + end.format('MMM D');
            }

            $('#kt_dashboard_daterangepicker_date').html(range);
            $('#kt_dashboard_daterangepicker_title').html(title);
        }

        picker.daterangepicker({
            direction: KTUtil.isRTL(),
            startDate: start,
            endDate: end,
            opens: 'left',
            applyClass: 'btn-primary',
            cancelClass: 'btn-light-primary',
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end, '');
    }
    var _initmonthorder = function() {
        var element = document.getElementById("kt_charts_month_order");

        if (!element) {
            return;
        }

        var options = {
            series: [ {
                name: 'Order',
                data: [76, 85, 101, 98, 87, 150,32,45,21,42,66,78]
            }],
            chart: {
                type: 'bar',
                height: 350,
                toolbar: {
                    show: true
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: ['30%'],
                    endingShape: 'rounded'
                },
            },
            legend: {
                show: false
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: ['Jan','Mar', 'Feb', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Oct', 'Nov'],
                axisBorder: {
                    show: false,
                },
                axisTicks: {
                    show: false
                },
                labels: {
                    style: {
                        colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                        fontSize: '12px',
                        fontFamily: KTApp.getSettings()['font-family']
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                        fontSize: '12px',
                        fontFamily: KTApp.getSettings()['font-family']
                    }
                }
            },
            fill: {
                opacity: 1
            },
            states: {
                normal: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                hover: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                active: {
                    allowMultipleDataPointsSelection: false,
                    filter: {
                        type: 'none',
                        value: 0
                    }
                }
            },
            tooltip: {
                style: {
                    fontSize: '12px',
                    fontFamily: KTApp.getSettings()['font-family']
                },
                y: {
                    formatter: function(val) {
                        return  val + " Orders in this Month"
                    }
                }
            },
            colors: [KTApp.getSettings()['colors']['theme']['base']['warning']],
            grid: {
                borderColor: KTApp.getSettings()['colors']['gray']['gray-200'],
                strokeDashArray: 4,
                yaxis: {
                    lines: {
                        show: true
                    }
                }
            }
        };

        var chart = new ApexCharts(element, options);
        chart.render();
    }



    var _initweekorder = function() {
        var element = document.getElementById("kt_charts_week_order");

        if (!element) {
            return;
        }

        var options = {
            series: [ {
                name: 'Order',
                data: [45,65, 154, 91 ]
            }],
            chart: {
                type: 'area',
                height: 350,
                toolbar: {
                    show: true
                }
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                    columnWidth: ['30%'],
                    endingShape: 'rounded'
                },
            },
            legend: {
                show: false
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: ['1st Week','2nd Week','3rd Week','4th Week'],
                axisBorder: {
                    show: false,
                },
                axisTicks: {
                    show: false
                },
                labels: {
                    style: {
                        colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                        fontSize: '12px',
                        fontFamily: KTApp.getSettings()['font-family']
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                        fontSize: '12px',
                        fontFamily: KTApp.getSettings()['font-family']
                    }
                }
            },
            fill: {
                opacity: 1
            },
            states: {
                normal: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                hover: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                active: {
                    allowMultipleDataPointsSelection: false,
                    filter: {
                        type: 'none',
                        value: 0
                    }
                }
            },
            tooltip: {
                style: {
                    fontSize: '12px',
                    fontFamily: KTApp.getSettings()['font-family']
                },
                y: {
                    formatter: function(val) {
                        return  val + " Orders in this Week"
                    }
                }
            },
            colors: [ KTApp.getSettings()['colors']['theme']['base']['primary']],
            grid: {
                borderColor: KTApp.getSettings()['colors']['gray']['gray-200'],
                strokeDashArray: 4,
                yaxis: {
                    lines: {
                        show: true
                    }
                }
            }
        };

        var chart = new ApexCharts(element, options);
        chart.render();
    }


// dayorder
    var _initdayorder = function() {
        var element = document.getElementById("kt_charts_day_order");

        if (!element) {
            return;
        }

        var options = {
            series: [ {
                name: 'Order',
                data: [53,42,61,20,13,10,7 ]
            }],
            chart: {
                type: 'bar',
                height: 350,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: ['30%'],
                    endingShape: 'rounded'
                },
            },
            legend: {
                show: false
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: false,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
                axisBorder: {
                    show: false,
                },
                axisTicks: {
                    show: false
                },
                labels: {
                    style: {
                        colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                        fontSize: '12px',
                        fontFamily: KTApp.getSettings()['font-family']
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                        fontSize: '12px',
                        fontFamily: KTApp.getSettings()['font-family']
                    }
                }
            },
            fill: {
                opacity: 1
            },
            states: {
                normal: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                hover: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                active: {
                    allowMultipleDataPointsSelection: false,
                    filter: {
                        type: 'none',
                        value: 0
                    }
                }
            },
            tooltip: {
                style: {
                    fontSize: '12px',
                    fontFamily: KTApp.getSettings()['font-family']
                },
                y: {
                    formatter: function(val) {
                        return  val + " Orders in this Day"
                    }
                }
            },
            colors: [ KTApp.getSettings()['colors']['theme']['light']['danger']],
            grid: {
                borderColor: KTApp.getSettings()['colors']['gray']['gray-200'],
                strokeDashArray: 4,
                yaxis: {
                    lines: {
                        show: true
                    }
                }
            }
        };

        var chart = new ApexCharts(element, options);
        chart.render();
    }

    // location at index.php
    var _mixedsales = function() {
        var element = document.getElementById("chart_sales_mixed");
        var height = parseInt(KTUtil.css(element, 'height'));

        if (!element) {
            return;
        }

        var options = {
            series: [{
                name: 'Net Profit',
                data: [30, 25, 45, 30, 55, 55]
            }],
            chart: {
                type: 'area',
                height: height,
                toolbar: {
                    show: false
                },
                zoom: {
                    enabled: false
                },
                sparkline: {
                    enabled: true
                }
            },
            plotOptions: {},
            legend: {
                show: false
            },
            dataLabels: {
                enabled: false
            },
            fill: {
                type: 'solid',
                opacity: 1
            },
            stroke: {
                curve: 'smooth',
                show: true,
                width: 3,
                colors: [KTApp.getSettings()['colors']['theme']['base']['info']]
            },
            xaxis: {
                categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                axisBorder: {
                    show: false,
                },
                axisTicks: {
                    show: false
                },
                labels: {
                    show: false,
                    style: {
                        colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                        fontSize: '12px',
                        fontFamily: KTApp.getSettings()['font-family']
                    }
                },
                crosshairs: {
                    show: false,
                    position: 'front',
                    stroke: {
                        color: KTApp.getSettings()['colors']['gray']['gray-300'],
                        width: 1,
                        dashArray: 3
                    }
                },
                tooltip: {
                    enabled: true,
                    formatter: undefined,
                    offsetY: 0,
                    style: {
                        fontSize: '12px',
                        fontFamily: KTApp.getSettings()['font-family']
                    }
                }
            },
            yaxis: {
                min: 0,
                max: 60,
                labels: {
                    show: false,
                    style: {
                        colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                        fontSize: '12px',
                        fontFamily: KTApp.getSettings()['font-family']
                    }
                }
            },
            states: {
                normal: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                hover: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                active: {
                    allowMultipleDataPointsSelection: false,
                    filter: {
                        type: 'none',
                        value: 0
                    }
                }
            },
            tooltip: {
                style: {
                    fontSize: '12px',
                    fontFamily: KTApp.getSettings()['font-family']
                },
                y: {
                    formatter: function(val) {
                        return "$" + val + " thousands"
                    }
                }
            },
            colors: [KTApp.getSettings()['colors']['theme']['light']['info']],
            markers: {
                colors: [KTApp.getSettings()['colors']['theme']['light']['info']],
                strokeColor: [KTApp.getSettings()['colors']['theme']['base']['info']],
                strokeWidth: 3
            }
        };

        var chart = new ApexCharts(element, options);
        chart.render();
    }

// recommandation widget location in index.php
    var _initrecommandation = function() {
        var element = document.getElementById("chart_recommandation");
        var height = parseInt(KTUtil.css(element, 'height'));

        if (!element) {
            return;
        }

        var options = {
            series: [74],
            chart: {
                height: height,
                type: 'radialBar',
            },
            plotOptions: {
                radialBar: {
                    hollow: {
                        margin: 0,
                        size: "65%"
                    },
                    dataLabels: {
                        showOn: "always",
                        name: {
                            show: false,
                            fontWeight: '700'
                        },
                        value: {
                            color: KTApp.getSettings()['colors']['gray']['gray-700'],
                            fontSize: "30px",
                            fontWeight: '700',
                            offsetY: 12,
                            show: true
                        }
                    },
                    track: {
                        background: KTApp.getSettings()['colors']['theme']['light']['success'],
                        strokeWidth: '100%'
                    }
                }
            },
            colors: [KTApp.getSettings()['colors']['theme']['base']['success']],
            stroke: {
                lineCap: "round",
            },
            labels: ["Progress"]
        };

        var chart = new ApexCharts(element, options);
        chart.render();
    }

    var _initshopifysales = function() {
        var element = document.getElementById("chart_shopify_mixed");

        if (!element) {
            return;
        }

        var options = {
            series: [{
                name: 'Net Profit',
                data: [30, 30, 50, 50, 35, 35]
            }, {
                name: 'Revenue',
                data: [55, 20, 20, 20, 70, 70]
            }, {
                name: 'Expenses',
                data: [60, 60, 40, 40, 30, 30]
            }, ],
            chart: {
                type: 'area',
                height: 300,
                toolbar: {
                    show: false
                },
                zoom: {
                    enabled: false
                },
                sparkline: {
                    enabled: true
                }
            },
            plotOptions: {},
            legend: {
                show: false
            },
            dataLabels: {
                enabled: false
            },
            fill: {
                type: 'solid',
                opacity: 1
            },
            stroke: {
                curve: 'smooth',
                show: true,
                width: 2,
                colors: ['transparent', 'transparent', 'transparent']
            },
            xaxis: {
                x: 0,
                offsetX: 0,
                offsetY: 0,
                padding: {
                    left: 0,
                    right: 0,
                    top: 0,
                },
                categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                axisBorder: {
                    show: false,
                },
                axisTicks: {
                    show: false
                },
                labels: {
                    show: false,
                    style: {
                        colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                        fontSize: '12px',
                        fontFamily: KTApp.getSettings()['font-family']
                    }
                },
                crosshairs: {
                    show: false,
                    position: 'front',
                    stroke: {
                        color: KTApp.getSettings()['colors']['gray']['gray-300'],
                        width: 1,
                        dashArray: 3
                    }
                },
                tooltip: {
                    enabled: true,
                    formatter: undefined,
                    offsetY: 0,
                    style: {
                        fontSize: '12px',
                        fontFamily: KTApp.getSettings()['font-family']
                    }
                }
            },
            yaxis: {
                y: 0,
                offsetX: 0,
                offsetY: 0,
                padding: {
                    left: 0,
                    right: 0
                },
                labels: {
                    show: false,
                    style: {
                        colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                        fontSize: '12px',
                        fontFamily: KTApp.getSettings()['font-family']
                    }
                }
            },
            states: {
                normal: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                hover: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                active: {
                    allowMultipleDataPointsSelection: false,
                    filter: {
                        type: 'none',
                        value: 0
                    }
                }
            },
            tooltip: {
                style: {
                    fontSize: '12px',
                    fontFamily: KTApp.getSettings()['font-family']
                },
                y: {
                    formatter: function(val) {
                        return "$" + val + " thousands"
                    }
                }
            },
            colors: [KTApp.getSettings()['colors']['theme']['light']['success'], KTApp.getSettings()['colors']['theme']['light']['danger'], KTApp.getSettings()['colors']['theme']['light']['info']],
            grid: {
                borderColor: KTApp.getSettings()['colors']['gray']['gray-200'],
                strokeDashArray: 4,
                padding: {
                    top: 0,
                    bottom: 0,
                    left: 0,
                    right: 0
                }
            },
            markers: {
                colors: [KTApp.getSettings()['colors']['theme']['light']['success'], KTApp.getSettings()['colors']['theme']['light']['danger'], KTApp.getSettings()['colors']['theme']['light']['info']],
                strokeColor: [KTApp.getSettings()['colors']['theme']['base']['success'], KTApp.getSettings()['colors']['theme']['base']['danger'], KTApp.getSettings()['colors']['theme']['base']['info']],
                strokeWidth: 3
            }
        };

        var chart = new ApexCharts(element, options);
        chart.render();
    }

    
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
   // Public methods
   return {
    init: function() {
        _initmonthorder();
        _initweekorder();
        _initdayorder();
        _mixedsales();
        _initrecommandation();
        _initDaterangepicker();
        _initshopifysales();
        _initcartgraph();
    }
}
}();

// Webpack support
if (typeof module !== 'undefined') {
module.exports = KTWidgets;
}

jQuery(document).ready(function() {
KTWidgets.init();
});




// apex chart

// Shared Colors Definition
const primary = '#6993FF';
const success = '#1BC5BD';
const info = '#8950FC';
const warning = '#FFA800';
const danger = '#F64E60';



var KTApexChartsDemo = function () {
// location in index.php
    var _donut_product = function () {
		const apexChart = "#chart_product";
		var options = {
			series: [44, 55, 41, 17, 15],
			chart: {
				width: 380,
				type: 'donut',
            },
            labels: ['Product 1', 'Product 2', 'Product 3', 'Product 4', 'Product 5'],
			responsive: [{
				breakpoint: 480,
				options: {
					chart: {
						width: 200
					},
					legend: {
						position: 'bottom'
					}
				}
			}],
			colors: [primary, success, warning, danger, info]
		};

		var chart = new ApexCharts(document.querySelector(apexChart), options);
		chart.render();
    }
    // location in shopify_sales
    var _shopify_chart_source = function () {
		const apexChart = "#chart_source";
        var options = {
            series: [44, 55, 67, 83],
            chart: {
            height: 350,
            type: 'radialBar',
          },
          plotOptions: {
            radialBar: {
              dataLabels: {
                name: {
                  fontSize: '22px',
                },
                value: {
                  fontSize: '16px',
                },
                total: {
                  show: true,
                  label: 'Total',
                  formatter: function (w) {
                    // By default this function returns the average of all series. The below is just an example to show the use of custom formatter function
                    return 249
                  }
                }
              }
            }
          },
          labels: ['Facebook', 'Twitter', 'Instagram', 'Organic'],
          };
  
          var chart = new ApexCharts(document.querySelector(apexChart), options);
          chart.render();

	}
	// Private functions
return {
    // public functions
    init: function () {
        _donut_product();
        _shopify_chart_source();
    }
};
}();

jQuery(document).ready(function () {
KTApexChartsDemo.init();
});



var KTamChartsMapsDemo = function() {
// AMChart script//
var _initlocationMap = function() {
    var map = AmCharts.makeChart("map_location", {
        "type": "map",
        "theme": "light",
        "dataProvider": {
            "map": "worldHigh",
            "zoomLevel": 4,
            "zoomLongitude": 10,
            "zoomLatitude": 52,
            "areas": [{
                "title": "Austria",
                "id": "AT",
                "color": "#67b7dc",
                "customData": "2",
                "groupId": "Strong"
            }, {
                "title": "Ireland",
                "id": "IE",
                "color": "#67b7dc",
                "customData": "4",
                "groupId": "Stong"
            }, {
                "title": "Denmark",
                "id": "DK",
                "color": "#67b7dc",
                "customData": "53",
                "groupId": "Stong"
            }, {
                "title": "Finland",
                "id": "FI",
                "color": "#67b7dc",
                "customData": "532",
                "groupId": "Stong"
            }, {
                "title": "Sweden",
                "id": "SE",
                "color": "#67b7dc",
                "customData": "3234",
                "groupId": "Stong"
            }, {
                "title": "Great Britain",
                "id": "GB",
                "color": "#67b7dc",
                "customData": "42",
                "groupId": "Stong"
            }, {
                "title": "Italy",
                "id": "IT",
                "color": "#67b7dc",
                "customData": "323",
                "groupId": "Stong"
            }, {
                "title": "France",
                "id": "FR",
                "color": "#67b7dc",
                "customData": "42",
                "groupId": "Stong"
            }, {
                "title": "Spain",
                "id": "ES",
                "color": "#67b7dc",
                "customData": "134",
                "groupId": "Stong"
            }, {
                "title": "Greece",
                "id": "GR",
                "color": "#67b7dc",
                "customData": "3",
                "groupId": "Stong"
            }, {
                "title": "Germany",
                "id": "DE",
                "color": "#67b7dc",
                "customData": "1",
                "groupId": "Stong"
            }, {
                "title": "Belgium",
                "id": "BE",
                "color": "#67b7dc",
                "customData": "121",
                "groupId": "Stong"
            }, {
                "title": "Luxembourg",
                "id": "LU",
                "color": "#67b7dc",
                "customData": "1454",
                "groupId": "Stong"
            }, {
                "title": "Netherlands",
                "id": "NL",
                "color": "#67b7dc",
                "customData": "124",
                "groupId": "Stong"
            }, {
                "title": "Portugal",
                "id": "PT",
                "color": "#67b7dc",
                "customData": "14",
                "groupId": "Stong"
            }, {
                "title": "Lithuania",
                "id": "LT",
                "color": "#ebdb8b",
                "customData": "314",
                "groupId": "2004"
            }, {
                "title": "Latvia",
                "id": "LV",
                "color": "#ebdb8b",
                "customData": "13",
                "groupId": "2004"
            }, {
                "title": "Czech Republic ",
                "id": "CZ",
                "color": "#ebdb8b",
                "customData": "521",
                "groupId": "2004"
            }, {
                "title": "Slovakia",
                "id": "SK",
                "color": "#ebdb8b",
                "customData": "312",
                "groupId": "2004"
            }, {
                "title": "Slovenia",
                "id": "SI",
                "color": "#ebdb8b",
                "customData": "124",
                "groupId": "2004"
            }, {
                "title": "Estonia",
                "id": "EE",
                "color": "#ebdb8b",
                "customData": "2134",
                "groupId": "2004"
            }, {
                "title": "Hungary",
                "id": "HU",
                "color": "#ebdb8b",
                "customData": "32",
                "groupId": "2004"
            }, {
                "title": "Cyprus",
                "id": "CY",
                "color": "#ebdb8b",
                "customData": "1331",
                "groupId": "2004"
            }, {
                "title": "Malta",
                "id": "MT",
                "color": "#ebdb8b",
                "customData": "1324",
                "groupId": "2004"
            }, {
                "title": "Poland",
                "id": "PL",
                "color": "#ebdb8b",
                "customData": "1325",
                "groupId": "2004"
            }, {
                "title": "Romania",
                "id": "RO",
                "color": "#83c2ba",
                "customData": "1253",
                "groupId": "2007"
            }, {
                "title": "Bulgaria",
                "id": "BG",
                "color": "#83c2ba",
                "customData": "35",
                "groupId": "421"
            }, {
                "title": "Croatia",
                "id": "HR",
                "color": "#db8383",
                "customData": "32",
                "groupId": "2013"
            }]
        },

        "areasSettings": {
            "rollOverOutlineColor": "#FFFFFF",
            "rollOverColor": "#CC0000",
            "alpha": 0.8,
            "unlistedAreasAlpha": 0.1,
            "balloonText": "[[title]] is Top  [[customData]]  in Sales"
        
        },


        "legend": {
            "width": "100%",
            "marginRight": 27,
            "marginLeft": 27,
            "equalWidths": false,
            "backgroundAlpha": 0.5,
            "backgroundColor": "#FFFFFF",
            "borderColor": "#ffffff",
            "borderAlpha": 1,
            "top": 450,
            "left": 0,
            "horizontalGap": 10,
            "data": [{
                "title": "Strong",
                "color": "#67b7dc"
            }, {
                "title": "Good",
                "color": "#ebdb8b"
            }, {
                "title": "Normal",
                "color": "#83c2ba"
            }, {
                "title": "Other",
                "color": "#db8383"
            }]
        },
        "export": {
            "enabled": false
        }

    });
}



return {
    // public functions
    init: function() {
        _initlocationMap();
    }
};
}();

jQuery(document).ready(function() {
KTamChartsMapsDemo.init();
});