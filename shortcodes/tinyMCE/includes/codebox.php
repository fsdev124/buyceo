<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<script data-cfasync="false">

// executes this when the DOM is ready
jQuery(document).ready(function() {
	// handles the click event of the submit button
	jQuery('#submit').click(function(){
		// defines the options and their default values
		// again, this is not the most elegant way to do this
		// but well, this gets the job done nonetheless
		var options = { 
			'style'     : '1'
			};
		var codebox_text = jQuery('#codebox-text').val();
		if( ! tinyMCE.activeEditor || tinyMCE.activeEditor.isHidden()) {
		 var selection_codebox = jQuery("textarea.wp-editor-area").selection('get');
		}
		else {
        	var selection_codebox = tinyMCE.activeEditor.selection.getContent();  
        }

		var shortcode = '[wpsm_codebox';
		
		for( var index in options) {
			var value = jQuery('#form').find('#codebox-' + index).val();
			
			if ( value !== '' )
				shortcode += ' ' + index + '="' + value + '"';
			else
				shortcode += ' ' + index + '="' + options[index] + '"'; 	
		}
		shortcode += ']';

		if ( codebox_text !== '' )
			shortcode += codebox_text;
		else if	( selection_codebox !== '' )
			shortcode += selection_codebox;
		else 
			shortcode += 'Sample Text';

		shortcode += '[/wpsm_codebox]';
		
        window.send_to_editor(shortcode);
		
		// closes Thickbox
		tb_remove();
	});
}); 
</script>
<form action="/" method="get" id="form" name="form" accept-charset="utf-8">
	
	<p><label><?php _e('Style', 'rehub_framework') ;?></label>
       	<select name="codebox-style" id="codebox-style" size="1">
			<option value="1" selected="selected"><?php _e('Simple', 'rehub_framework') ;?></option>
			<option value="2"><?php _e('With left blue line', 'rehub_framework') ;?></option>
        </select>
    </p>  
    <p>
        <label><?php _e('Text', 'rehub_framework') ;?></label>
        <textarea type="text" name="codebox-text" value="" id="codebox-text" col="10"></textarea><br />
        <small><?php _e('Leave blank if you selected text in visual editor', 'rehub_framework') ;?></small>
    </p>    
	 <p>
        <label>&nbsp;</label>
        <input type="button" id="submit" class="button" value="<?php _e('Insert', 'rehub_framework') ;?>" name="submit" />
    </p>
</form>