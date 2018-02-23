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
			'num'      	: '1',
			'style'     : '3',
			'heading'     : '2',
			};
		var numhead_text = jQuery('#numhead-text').val();
		if( ! tinyMCE.activeEditor || tinyMCE.activeEditor.isHidden()) {
		 var selection_numhead = jQuery("textarea.wp-editor-area").selection('get');
		}
		else {
        	var selection_numhead = tinyMCE.activeEditor.selection.getContent();  
        }

		var shortcode = '[wpsm_numhead';
		
		for( var index in options) {
			var value = jQuery('#form').find('#numhead-' + index).val();
			
			if ( value !== '' )
				shortcode += ' ' + index + '="' + value + '"';
			else
				shortcode += ' ' + index + '="' + options[index] + '"'; 	
		}
		shortcode += ']';

		if ( numhead_text !== '' )
			shortcode += numhead_text;
		else if	( selection_numhead !== '' )
			shortcode += selection_numhead;
		else 
			shortcode += 'Sample Text';

		shortcode += '[/wpsm_numhead]';
		
        window.send_to_editor(shortcode);
		
		// closes Thickbox
		tb_remove();
	});
}); 
</script>
<form action="/" method="get" id="form" name="form" accept-charset="utf-8">
	<p><label><?php _e('Number', 'rehub_framework') ;?></label>
        <input type="text" name="numhead-num" value="1" id="numhead-num" />
    </p>
	
	<p><label><?php _e('Style of number', 'rehub_framework') ;?></label>
       	<select name="numhead-style" id="numhead-style" size="1">
			<option value="1"><?php _e('Grey', 'rehub_framework') ;?></option>
			<option value="2"><?php _e('Black', 'rehub_framework') ;?></option>
			<option value="3" selected="selected"><?php _e('Orange', 'rehub_framework') ;?></option>
			<option value="4"><?php _e('Blue', 'rehub_framework') ;?></option>
        </select>
    </p> 
	<p><label><?php _e('Heading', 'rehub_framework') ;?></label>
       	<select name="numhead-heading" id="numhead-heading" size="1">
			<option value="1">H1</option>
			<option value="2" selected="selected">H2</option>
			<option value="3">H3</option>
			<option value="4">H4</option>
			<option value="5">H5</option>
        </select>
    </p>     
    <p>
        <label><?php _e('Text', 'rehub_framework') ;?></label>
        <textarea type="text" name="numhead-text" value="" id="numhead-text" col="10"></textarea><br />
        <small><?php _e('Leave blank if you selected text in visual editor', 'rehub_framework') ;?></small>
    </p>    
	 <p>
        <label>&nbsp;</label>
        <input type="button" id="submit" class="button" value="<?php _e('Insert', 'rehub_framework') ;?>" name="submit" />
    </p>
</form>