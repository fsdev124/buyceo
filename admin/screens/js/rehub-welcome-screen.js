jQuery(document).ready(function(e) {
   	// If clicked register button, process ajax request to submit data
	jQuery(".rehub-register").click(function(e){
		e.preventDefault();
		var form = jQuery("#rehub_product_registration");
		var loader = jQuery(".rehub-loader");
		var data = form.serialize();
		loader.show();
		jQuery.ajax({
			url: ajaxurl,
			data: data,
			dataType: "HTML",
			type:"POST",
			success: function(result){
				if(result == "Updated"){
					var html = jQuery(".registration-notice-1").html();
					jQuery(".registration-form-container").html('<div class="about-description">' + html + '</div>');
					jQuery(".registration-notice-3, .registration-notice-2, .registration-notice-4").attr("style","display: none !important");
					jQuery( '#wp-admin-bar-product-registration' ).hide();
				} else if(result == "Empty") {
					jQuery(".registration-notice-2").attr("style","display: block !important");
					jQuery(".registration-notice-1, .registration-notice-3, .registration-notice-4").attr("style","display: none !important");
				} else if(result == "Error") {
					jQuery(".registration-notice-3").attr("style","display: block !important");
					jQuery(".registration-notice-1, .registration-notice-2, .registration-notice-4").attr("style","display: none !important");
				}
				else if(result == "Errorbuyer") {
					jQuery(".registration-notice-4").attr("style","display: block !important");
					jQuery(".registration-notice-1, .registration-notice-2, .registration-notice-3").attr("style","display: none !important");
				}				
				loader.hide();
			}
		});
	});
});