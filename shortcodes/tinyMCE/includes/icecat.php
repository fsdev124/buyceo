<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<script data-cfasync="false">

// executes this when the DOM is ready
jQuery(document).ready(function() {
	// handles the click event of the submit button
	jQuery('#submit').click(function(){

		var options = { 
			'ean' : '',
			'language' : '',
			'username' : '',
			'password' : '',						
		};	

		var shortcode = '[wpsm_icecat';	
		for( var index in options) {
			var value = jQuery('#form').find('#button-' + index).val();
			if ( value !== '' )
				shortcode += ' ' + index + '="' + value + '"'; 	
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
<div>
	<p><?php _e('This shortcode shows specification from Icecat.biz', 'rehub_framework') ;?></p>
    <p>
        <label><?php _e('Set EAN code of product', 'rehub_framework') ;?></label>
        <input type="text" name="button-ean" value="" id="button-ean" /><br />
    </p>
	<div class="clear"></div>
    <p>
        <label><?php _e('Language', 'rehub_framework') ;?></label>
        <input type="text" name="button-language" value="" id="button-language" /><br />
        <small><?php _e('By default, your site language will be used', 'rehub_framework') ;?></small>
    </p>
	<div class="clear"></div>	
    <p>
        <label><?php _e('Your login on Icecat.biz', 'rehub_framework') ;?></label>
        <input type="text" name="button-username" value="" id="button-username" /><br />
        <small><?php _e('Set this if you have PRO account on Icecat', 'rehub_framework') ;?></small>
    </p>
	<div class="clear"></div>
    <p>
        <label><?php _e('Your password on Icecat.biz', 'rehub_framework') ;?></label>
        <input type="text" name="button-password" value="" id="button-password" /><br />
        <small><?php _e('Set this if you have PRO account on Icecat', 'rehub_framework') ;?></small>
    </p>
	<div class="clear"></div>	
</div>
	 <p>
        <label>&nbsp;</label>
        <input type="button" name="submit" value="<?php _e('Insert', 'rehub_framework') ;?>" class="button" id="submit">
    </p>	
</form>