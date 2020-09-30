"use strict";
// Class definition

var m_index_page = function () {
  // card blocking
  var latest_order = function () {
    $( window ).load(function() {
       
// get the latest order [current all] TODO: add filter paid , cancel 
$.ajax({
    url: "../action/m/index/latest_orders.php",
    type: "post",
    data: { init: 1 },
    success: function (response) {

        alert(response);
        
    },
  });



      });
  };

  return {
    // public functions
    init: function () {
        latest_order();
    },
  };
}();

jQuery(document).ready(function () {
	m_index_page.init();
});


