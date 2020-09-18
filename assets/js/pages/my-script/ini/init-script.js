



$( document ).ready(function() {

	$("#plan_regs").submit(function(event){
		event.preventDefault(); //prevent default action 
		var post_url = $(this).attr("action"); //get form action url
		var form_data = $(this).serialize(); //Encode form elements for submission
		
		$.post( post_url, form_data, function( response ) {
		

		var shop_name=$.cookie('shop_name');


			var fields = response.split(':');

			var account_st = fields[0];
			var setup_st = fields[1];
		

			if(account_st==1&&setup_st==1){

				$.ajax({
					url: 'webhook/app_uninstalled.php',
					type: 'post',
					data: {register:1},
					success: function(response){
						console.log(response);
					}
				});

				// window.top.location.href="https://" + shop_name +"/admin/apps/grag_app/";
			}else{


				console.log("there is problem "+ account_st+" "+setup_st);
			}
		});
	
	});





});