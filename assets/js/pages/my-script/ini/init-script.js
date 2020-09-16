$( document ).ready(function() {

	$("#plan_regs").submit(function(event){
		event.preventDefault(); //prevent default action 
		var post_url = $(this).attr("action"); //get form action url
		var form_data = $(this).serialize(); //Encode form elements for submission
		
		$.post( post_url, form_data, function( response ) {

			var fields = response.split(':');

			var account_st = fields[0];
			var setup_st = fields[1];
			var link = fields[2];
console.log(response);
			if(account_st==1&&setup_st==1){
//TODO: must check if the link is URL 
				document.location.assign(link);
			}else{


				console.log("there is problem "+ account_st+" "+setup_st+ ""+link);
			}
		});
	
	});





});