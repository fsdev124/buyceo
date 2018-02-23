<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<script data-cfasync="false">

// executes this when the DOM is ready
jQuery(document).ready(function() {
	// handles the click event of the submit button
	jQuery('#submit').click(function(){
		// defines the options and their default values
		// again, this is not the most elegant way to do this
		// but well, this gets the job done nonetheless
				var colortable = jQuery('#colortable').val();
                var contenttable = jQuery('#TableContent').val();
				var Columnposition = jQuery('#Columnposition');
					if( ! tinyMCE.activeEditor || tinyMCE.activeEditor.isHidden()) {
					 var tablecontent = jQuery("textarea.wp-editor-area").selection('get');
					}
					else {
			        	var tablecontent = tinyMCE.activeEditor.selection.getContent();
			        }				
				
				var shortcode = '[wpsm_colortable ';
				
				if(colortable) {
					shortcode += 'color="'+colortable+'"]';
				}
				
				if ( contenttable !== '' )
					shortcode += contenttable;
				else if	( tablecontent !== '' )
					shortcode += tablecontent;
				else 
					shortcode += '<table><tr><th>Sample heading</th><th>Sample heading</th></tr><tr><td>Sample text</td><td>Sample text</td></tr><tr><td>Sample text</td><td>Sample text</td></tr></table>';

				shortcode += '[/wpsm_colortable]';
		
        window.send_to_editor(shortcode);
		
		// closes Thickbox
		tb_remove();
	});
}); 
</script>
<form action="/" method="get" id="form" name="form" accept-charset="utf-8">	
	<p>
		<label for="colortable"><?php _e('Color of heading table :', 'rehub_framework') ;?></label>
		<select id="colortable" name="colortable">
			<option value="grey"><?php _e('grey-default', 'rehub_framework') ;?></option>
			<option value="black"><?php _e('black', 'rehub_framework') ;?></option>
            <option value="yellow"><?php _e('yellow', 'rehub_framework') ;?></option>
			<option value="blue"><?php _e('blue', 'rehub_framework') ;?></option>
			<option value="red"><?php _e('red', 'rehub_framework') ;?></option>
			<option value="green"><?php _e('green', 'rehub_framework') ;?></option>
            <option value="orange"><?php _e('orange', 'rehub_framework') ;?></option>
            <option value="purple"><?php _e('purple', 'rehub_framework') ;?></option>
		</select>
	</p>
    <p>
		<label for="TableContent"><?php _e('Content :', 'rehub_framework') ;?></label>
		<textarea id="TableContent" name="TableContent" col="20"></textarea><br />
		<small><?php _e('Leave blank if you selected text in visual editor', 'rehub_framework') ;?></small>
	</p>
	 <p>
        <label>&nbsp;</label>
        <input type="button" id="submit" class="button" value="<?php _e('Insert', 'rehub_framework') ;?>" name="submit" />
    </p>
</form>