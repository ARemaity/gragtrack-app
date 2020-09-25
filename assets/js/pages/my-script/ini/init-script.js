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
                      KTApp.unblock("#kt_blockui_card");
                          window.top.location.href="https://" + shop_name +"/admin/apps/grag_app/";
                     }else{

                      console.log('error');
                     }
                  }
                
      
                },
              });














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

  return {
    // public functions
    init: function () {
      register();
    },
  };
}();

jQuery(document).ready(function () {
	init_page.init();
});


