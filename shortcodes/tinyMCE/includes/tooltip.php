<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<script data-cfasync="false">

// executes this when the DOM is ready
jQuery(document).ready(function() {
	// handles the click event of the submit button
	jQuery('#submit').click(function(){
		// defines the options and their default values
		// again, this is not the most elegant way to do this
		// but well, this gets the job done nonetheless
		var Text = jQuery('#Text').val();
		var gravity = jQuery('#Gravities').val();
		var Content = jQuery('#Content').val();
		if( ! tinyMCE.activeEditor || tinyMCE.activeEditor.isHidden()) {
		 var contenttooltip = jQuery("textarea.wp-editor-area").selection('get');
		}
		else {
        	var contenttooltip = tinyMCE.activeEditor.selection.getContent(); 
        }

		var shortcode = '[wpsm_tooltip ';
				

				if(Text) {
					shortcode += 'text="'+Text+'"';
				}


				if(gravity) {
					shortcode += ' gravity="'+gravity+'"';
				}
                shortcode += ']'
                if ( Content !== '' )
					shortcode += Content;
				else if	( contenttooltip !== '' )
					shortcode += contenttooltip;
				else 
					shortcode += 'Sample Text';


				shortcode += '[/wpsm_tooltip]';
		
        window.send_to_editor(shortcode);
		
		// closes Thickbox
		tb_remove();
	});
}); 
</script>
<form action="/" method="get" id="form" name="form" accept-charset="utf-8">
	
	<p>
		<label for="Text"><?php _e('Content of tooltip', 'rehub_framework') ;?></label>
		<input id="Text" name="Text" type="Text" value="Sample title" />
	</p>
	<p>
		<label for="Gravities"><?php _e('Gravities :', 'rehub_framework') ;?></label>
		<select id="Gravities" name="Gravities">
			<option value="nw"><?php _e('Northwest', 'rehub_framework') ;?></option>
			<option value="n"><?php _e('North', 'rehub_framework') ;?></option>
			<option value="ne"><?php _e('Northeast', 'rehub_framework') ;?></option>
			<option value="w"><?php _e('West', 'rehub_framework') ;?></option>
			<option value="e"><?php _e('East', 'rehub_framework') ;?></option>
			<option value="sw" selected="selected"><?php _e('Southwest', 'rehub_framework') ;?></option>
			<option value="s"><?php _e('South', 'rehub_framework') ;?></option>
			<option value="se"><?php _e('Southeast', 'rehub_framework') ;?></option>
		</select>
	</p>
	<p>
		<label for="Content"><?php _e('Content :', 'rehub_framework') ;?> </label>
		<textarea id="Content" name="Content" col="10"></textarea><br />
		<small><?php _e('Leave blank if you selected text in visual editor', 'rehub_framework') ;?></small>
	</p>
	 <p>
        <label>&nbsp;</label>
        <input type="button" id="submit" class="button" value="<?php _e('Insert', 'rehub_framework') ;?>" name="submit" />
    </p>
</form>