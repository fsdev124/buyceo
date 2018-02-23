<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<script data-cfasync="false">

// executes this when the DOM is ready
jQuery(document).ready(function() { 
	// handles the click event of the submit button
	jQuery('#submit').click(function(){

		var options = { 
			'btn_text' : '',
			'btn_url' : '',
			'btn_price' : '',
			'meta_btn_url' : '',
			'meta_btn_price' : '',			
		};	
		var button_from_review = jQuery('#button_from_review');

		var shortcode = '[rehub_affbtn';	
		for( var index in options) {
			var value = jQuery('#form').find('#button-' + index).val();
			if ( value !== '' )
				shortcode += ' ' + index + '="' + value + '"'; 	
		}
		if(button_from_review.is(":checked")) {
			shortcode += ' button_from_review="1"';
		}
		
		shortcode += ']';    
		
		// inserts the shortcode into the active editor
		window.send_to_editor(shortcode);
		
		
		// closes Thickbox
		tb_remove();
	});

}); 
</script>
<form action="/" method="get" id="form" name="form" accept-charset="utf-8">
<div class="affbtn">
    <p>
        <label><?php _e('Text on button', 'rehub_framework') ;?></label>
        <input type="text" name="button-btn_text" value="" id="button-btn_text" /><br />
        <small><?php _e('Or live blank for default', 'rehub_framework') ;?></small>
    </p>
	<div class="clear"></div>
    <p>
        <label><?php _e('Button url', 'rehub_framework') ;?></label>
        <input type="text" name="button-btn_url" value="" id="button-btn_url" /><br />
    </p>
	<div class="clear"></div>
    <p>
        <label><?php _e('Or set name of meta field where you store url', 'rehub_framework') ;?></label>
        <input type="text" name="button-meta_btn_url" value="" id="button-meta_btn_url" /><br />
        <small><?php _e('In this case, leave blank previous field', 'rehub_framework') ;?></small>
    </p>
	<div class="clear"></div>		
    <p>
        <label><?php _e('Price on Button', 'rehub_framework') ;?></label>
        <input type="text" name="button-btn_price" value="" id="button-btn_price" /><br />
    </p>
	<div class="clear"></div>
    <p>
        <label><?php _e('Or set name of meta field where you store price', 'rehub_framework') ;?></label>
        <input type="text" name="button-meta_btn_price" value="" id="button-meta_btn_price" /><br />
        <small><?php _e('In this case, leave blank previous field', 'rehub_framework') ;?></small>
    </p>
	<div class="clear"></div>		

	<p>
		<label><?php _e('Copy data from product review?', 'rehub_framework') ;?></label>
        <input id="button_from_review" name="button_from_review" type="checkbox" class="checks" value="false" />
	</p>
	<div class="clear"></div>
</div>
	 <p>
        <label>&nbsp;</label>
        <input type="button" name="submit" value="<?php _e('Insert', 'rehub_framework') ;?>" class="button" id="submit">
    </p>	
</form>