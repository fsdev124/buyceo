<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<script data-cfasync="false">

// executes this when the DOM is ready
jQuery(document).ready(function() {
	// handles the click event of the submit list
	jQuery('#submit').click(function(){
		var idsvalue = jQuery('#slider-ids').val();
		var shortcode = '[wpsm_quick_slider';

		if ( idsvalue !== '' ) {
			shortcode += ' ids="' + idsvalue + '"';
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
    <p><label><?php _e('Images ids', 'rehub_framework') ;?></label>
        <input type="text" name="slider-ids" value="" id="slider-ids" /><br />
        <small><?php _e('Insert ids of images with commas.', 'rehub_framework') ;?>. <a href="http://rehub.wpsoul.com/documentation/docs.html#51" target="_blank">Tip - How to get images ids very fast</a></small>
    </p>      
	 <p>
        <label>&nbsp;</label>
        <input type="button" id="submit" class="button" value="<?php _e('Insert', 'rehub_framework') ;?>" name="submit" />
    </p>
</form>