"use strict";
// Class definition

var m_index_page = function () {
  // card blocking
  var latest_order = function () {
    $( document ).ready(function() {
        KTApp.block("#kt_blockui_card", {
            overlayColor: "#000000",
            state: "secondary",
            message: "Processing...",
          });
// get the latest order [current all] TODO: add filter paid , cancel 
$.ajax({
    url: "../action/m/index/latest_orders.php",
    type: "post",
    dataType: 'JSON',
    data: { init: 1 },
    success: function(response){
        var len = response.length;
        var fname;
            var lname;
            var ccountry;
        for(var i=0; i<len; i++){
            if(response[i].fname=='null'){
                 fname ='--' ;
            }else{
               fname = response[i].fname;
            }


            if(response[i].lname=='null'){
                lname ='--' ;
            }else{
                lname = response[i].lname;
            }

            if(response[i].ccountry=='null'){
                ccountry ='--' ;
            }else{
                ccountry = response[i].cn;
            }
            var cid = response[i].cid;
            var nbitem = response[i].nbitem;
            var total = response[i].total;

            var tr_str = "<tr>"+                               
            "<td class='align-middle pb-6'>"+
               " <div class='font-size-lg font-weight-bolder text-dark-75 mb-1'>"+fname+" "+lname+"</div>"+
               " <div class='font-weight-bold text-muted'>"+ccountry+"</div>"+
           " </td>"+
            "<td class='font-weight-bold text-muted align-middle text-right pb-6'>"+
"<span class='text-success font-size-h5 font-weight-bolder ml-1'>"+nbitem+"</span>"+
            "</td>"+
            "<td class='text-right align-middle pb-6'>"+
                "<div class='font-size-lg font-weight-bolder text-dark-75'>$"+total+"</div>"+
            "</td>"+
        "</tr>";

            $("#latest_order tbody").append(tr_str);
        }
        KTApp.unblock("#kt_blockui_card");

    }
  });



      });
  };


  var mix_sales = function () {
    $( document ).ready(function() {
        var gross_sales=0;
        var net_sales=0;
        var total_sales=0;
        var Net_quantity=0;
        KTApp.block("#blockui_mix_sales", {
            overlayColor: "#000000",
            state: "secondary",
            message: "Processing...",
          });
// get the latest order [current all] TODO: add filter paid , cancel 
$.ajax({
    url: "../action/m/index/mix_sales.php",
    type: "POST",
    dataType: 'JSON',
    data: { get_mix: 1 },
    success: function(response){
       

        console.log(response);
         
            gross_sales=response.grosale;
            net_sales=response.net_sales;
            total_sales=response.total_sales;
            Net_quantity=response.net_qty;
 $('#gross_sales').html(gross_sales);
 $('#net_sales').html(net_sales);
 $('#total_sales').html(total_sales);
 $('#net_quantity').html(Net_quantity);

        KTApp.unblock("#blockui_mix_sales");

    }
  });



      });
  };
  return {
    // public functions
    init: function () {
        latest_order();
        mix_sales();
    },
  };
}();

jQuery(document).ready(function () {
	m_index_page.init();
});


