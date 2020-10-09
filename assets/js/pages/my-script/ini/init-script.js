"use strict";
// Class definition

var init_page = function () {
  // card blocking
  var register = function () {
    $("#plan_regs").bind('submit', function(event) {
	  event.preventDefault();
	  event.stopImmediatePropagation();
      var post_url = $(this).attr("action");
      var form_data = $(this).serialize();
      $("#submit_btn").attr("disabled", true);

      KTApp.block("#kt_blockui_card", {
        overlayColor: "#000000",
        state: "primary",
        message: "Processing...Setting Up The Account",
      });
      $.post(post_url, form_data, function (response) {
        var shop_name = $.cookie("shop_name");
        var fields = response.split(":");
        var account_st = fields[0];
        var setup_st = fields[1];
        if (account_st == 1 && setup_st == 1) {
          $.ajax({
            url: "webhook/startup_hooks.php",
            type: "post",
            data: { register: 1 },
            success: function (response) {
              response = response.replace(/\s/g, '');
              let res=parseInt(response);
              if (isNaN(res)) {
                console.log('error');
              }else{
                if(res==1){
   

$('#fetch_order_modal').modal('show');
KTApp.unblock("#kt_blockui_card");
             }
            }            
            },
          });

         
        } else {
          console.log("there is problem " + account_st + " " + setup_st);
        }
      });
    });
  };
  var fetch_order = function () {
    $('#fetch_choice1, #fetch_choice2').on('click', function() {
      var id = $(this).attr('id');
      $('#'+id).prop('disabled',true);
      var shop_name = $.cookie("shop_name");
      var val = $(this).val();
      if(val==0){
        console.log('fetch_later');
        window.top.location.href="https://" + shop_name +"/admin/apps/grag_app/";
      }else{
        KTApp.block("#kt_blockui_body", {
          overlayColor: "#000000",
          state: "primary",
          message: "Fetching The Orders,Please Don't Close Your Browser",
        });
   $.ajax({
                url: "action/ini/init_order.php",
                type: "post",
                data: { init: 1 },
                success: function (response) {
                  response = response.replace(/\s/g, '');
                  let res=parseInt(response);
                  if (isNaN(res)) {
                    console.log('error');
                  }else{
                    if(res==1){
                      KTApp.unblock("#kt_blockui_body");
                          window.top.location.href="https://" + shop_name +"/admin/apps/grag_app/";
                     }else{
                      console.log('error');
                     }
                  }
                
      
                },
              });

      }
  });
  };
  return {
    // public functions
    init: function () {
      register();
      fetch_order();
    },
  };
}();

jQuery(document).ready(function () {



  var disable=(name)=>{

let slect='#'+name;
$(slect).prop('disabled',true);

  }
	init_page.init();
});


