jQuery(document).ready(function() {

	jQuery(".user-review-vote").on("click", ".us-rev-vote-up:not(.alreadycomment)", function(e){
		e.preventDefault();
		var post_id = jQuery(this).data("post_id");	
		var informer = jQuery(this).data("informer");
		jQuery(this).addClass('alreadycomment').parent().find('.us-rev-vote-down').addClass('alreadycomment');
		jQuery('#commhelp' + post_id + ' .fa-thumbs-up').removeClass('fa-thumbs-up').addClass('fa-spinner fa-spin');				
		jQuery.ajax({
			type: "post",
			url: cplus_var.url,
			data: "action=commentplus&cplusnonce="+cplus_var.nonce+"&comm_help=plus&post_id="+post_id,
			success: function(count){
				jQuery('#commhelp' + post_id + ' .fa-spinner').removeClass('fa-spinner fa-spin').addClass('fa-thumbs-up');			
				informer=informer+1;
				jQuery('#commhelpplus' + post_id + '').text(informer);       	
			}
		});
		
		return false;
	})

	jQuery(".user-review-vote").on("click", ".us-rev-vote-down:not(.alreadycomment)", function(e){
		e.preventDefault();
		var post_id = jQuery(this).data("post_id");	
		var informer = jQuery(this).data("informer");
		jQuery(this).addClass('alreadycomment').parent().find('.us-rev-vote-up').addClass('alreadycomment');
		jQuery('#commhelp' + post_id + ' .fa-thumbs-down').removeClass('fa-thumbs-down').addClass('fa-spinner fa-spin');
		jQuery.ajax({
			type: "post",
			url: cplus_var.url,
			data: "action=commentplus&cplusnonce="+cplus_var.nonce+"&comm_help=minus&post_id="+post_id,
			success: function(count){
				jQuery('#commhelp' + post_id + ' .fa-spinner').removeClass('fa-spinner fa-spin').addClass('fa-thumbs-down');				
				informer=informer+1;
				jQuery('#commhelpminus' + post_id + '').text(informer);        	
			}
		});
		
		return false;
	});

	jQuery(".user-review-vote").on("click", ".alreadycomment", function(e){
		jQuery(this).parent().find('.already_commhelp').fadeIn().fadeOut(1000);
	});

})