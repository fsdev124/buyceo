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
			'author'      	: '',
			'float'     : 'left',
			'width'     : '34%',
			};
		var quote_text = jQuery('#quote-text').val();
		if( ! tinyMCE.activeEditor || tinyMCE.activeEditor.isHidden()) {
		 var selection_quote = jQuery("textarea.wp-editor-area").selection('get');
		}
		else {
        	var selection_quote = tinyMCE.activeEditor.selection.getContent();  
        }

		var shortcode = '[wpsm_quote';
		
		for( var index in options) {
			var value = jQuery('#form').find('#quote-' + index).val();
			
			if ( value !== '' )
				shortcode += ' ' + index + '="' + value + '"';
			else
				shortcode += ' ' + index + '="' + options[index] + '"'; 	
		}
		shortcode += ']';

		if ( quote_text !== '' )
			shortcode += quote_text;
		else if	( selection_quote !== '' )
			shortcode += selection_quote;
		else 
			shortcode += 'Sample Text';

		shortcode += '[/wpsm_quote]';
		
        window.send_to_editor(shortcode);
		
		// closes Thickbox
		tb_remove();
	});
}); 
</script>
<form action="/" method="get" id="form" name="form" accept-charset="utf-8">
	<p><label><?php _e('Author', 'rehub_framework') ;?></label>
        <input type="text" name="quote-author" value="" id="quote-author" /><br />
        <small>Or live blank if you don't want to show author</small>
    </p>
	
	<p><label><?php _e('Float', 'rehub_framework') ;?></label>
       	<select name="quote-float" id="quote-float" size="1">
			<option value="left" selected="selected"><?php _e('left', 'rehub_framework') ;?></option>
			<option value="right"><?php _e('right', 'rehub_framework') ;?></option>
			<option value="none"><?php _e('none', 'rehub_framework') ;?></option>
        </select>
    </p>  
    <p><label><?php _e('Width (with %)', 'rehub_framework') ;?></label>
        <input type="text" name="quote-width" value="" id="quote-width" />
    </p> 
    <p>
        <label><?php _e('Text', 'rehub_framework') ;?></label>
        <input type="text" name="quote-text" value="" id="quote-text" /><br />
        <small><?php _e('Leave blank if you selected text in visual editor', 'rehub_framework') ;?></small>
    </p>    
	 <p>
        <label>&nbsp;</label>
        <input type="button" id="submit" class="button" value="<?php _e('Insert', 'rehub_framework') ;?>" name="submit" />
    </p>
</form>