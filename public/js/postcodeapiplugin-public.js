
jQuery(document).ready(function($) {  
	$("#checkavailability").click(function(e) {
		e.preventDefault();
		postcode = $('#postcode').val();
		$.ajax({
			type:'POST',
			url:p_public_param.ajaxurl,
			data:{ 
				action:'check_availability',
				postcode:postcode,
				_ajax_nonce: p_public_param.nonce,
			},
			success: function( response ){
				$resp = JSON.parse( response );
				 
				$resp.forEach(element => {
					$("#pdata").append(element[0]);
					$("#pdata").append(element[1]);
					$('#pdata').append('<br>');
				});
			}
		});
	});
});