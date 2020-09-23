"use strict";
// Class definition

var KTBlockUIDemo = (function () {
  // card blocking
  var register = function () {
    $("#plan_regs").on("submit", function (event) {
      event.preventDefault();
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
              console.log(response);
              KTApp.unblock("#kt_blockui_card");
            },
          });

          // window.top.location.href="https://" + shop_name +"/admin/apps/grag_app/";
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
})();

jQuery(document).ready(function () {
  KTBlockUIDemo.init();
});


