<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<script data-cfasync="false">

// executes this when the DOM is ready
jQuery(document).ready(function() {
	// handles the click event of the submit pos
	jQuery('#submit').click(function(){

		var prostitle = jQuery('#form').find('#pros-title').val();
		var constitle = jQuery('#form').find('#cons-title').val();

		var shortcode = '[wpsm_column size="one-half"]';
		
		if ( jQuery('#pos-text').val() !== '' ){
			shortcode += '[wpsm_pros title="' + prostitle + '"]<ul>';
			jQuery.each(jQuery('#pos-text').val().split('\n'), function(index, value) { 
			  shortcode += '<li>' + value +'</li>';
			});
			shortcode += '</ul>[/wpsm_pros]';
		}else{
			shortcode += '[wpsm_pros title="' + prostitle + '"]<ul><li>Positive #1</li><li>Positive #2</li><li>Positive #3</li></ul>[/wpsm_pros]';
		}
		
		shortcode += '[/wpsm_column]';

		shortcode += '[wpsm_column size="one-half" position="last"]';
		
		if ( jQuery('#neg-text').val() !== '' ){
			shortcode += '[wpsm_cons title="' + constitle + '"]<ul>';
			jQuery.each(jQuery('#neg-text').val().split('\n'), function(index, value) { 
			  shortcode += '<li>' + value +'</li>';
			});
			shortcode += '</ul>[/wpsm_cons]';
		}else{
			shortcode += '[wpsm_cons title="' + constitle + '"]<ul><li>Negative #1</li><li>Negative #2</li><li>Negative #3</li></ul>[/wpsm_cons]';
		}
		
		shortcode += '[/wpsm_column]';		
		
		// inserts the shortcode into the active editor
		window.send_to_editor(shortcode);
		
		
		// closes Thickbox
		tb_remove();
	});
}); 
</script>
<form action="/" method="get" id="form" name="form" accept-charset="utf-8">
    <p>
        <label><?php _e('Positives', 'rehub_framework') ;?></label>
        <textarea name="pos-text" id="pos-text" rows="4"></textarea><br /><small><?php _e('Separated by a new-line (by Enter)', 'rehub_framework') ;?></small>
    </p>
    <p>
        <label><?php _e('Negatives', 'rehub_framework') ;?></label>
        <textarea name="neg-text" id="neg-text" rows="4"></textarea><br /><small><?php _e('Separated by a new-line (by Enter)', 'rehub_framework') ;?></small>
    </p>
    <input id="pros-title" name="pros-title" type="hidden" value="<?php _e('PROS:', 'rehub_framework') ;?>" />
    <input id="cons-title" name="cons-title" type="hidden" value="<?php _e('CONS:', 'rehub_framework') ;?>" />    
	 <p>
        <label>&nbsp;</label>
        <input type="button" id="submit" class="button" value="<?php _e('Insert', 'rehub_framework') ;?>" name="submit" />
    </p>
</form>