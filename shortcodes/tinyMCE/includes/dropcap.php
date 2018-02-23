<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<script data-cfasync="false">

// executes this when the DOM is ready
jQuery(document).ready(function() { 
	// handles the click event of the submit button
	jQuery('#submit').click(function(){
		// defines the options and their default values
		// again, this is not the most elegant way to do this
		// but well, this gets the job done nonetheless
		var dropcap_text = jQuery('#dropcap-text').val();
		if( ! tinyMCE.activeEditor || tinyMCE.activeEditor.isHidden()) {
		 var selection_dropcap = jQuery("textarea.wp-editor-area").selection('get');
		}
		else {
        	var selection_dropcap = tinyMCE.activeEditor.selection.getContent();  
        }

		var shortcode = '[wpsm_dropcap]';

		if ( dropcap_text !== '' )
			shortcode += dropcap_text;
		else if	( selection_dropcap !== '' )
			shortcode += selection_dropcap;
		else 
			shortcode += 'Sample Text';

		shortcode += '[/wpsm_dropcap]';
		
        window.send_to_editor(shortcode);
		
		// closes Thickbox
		tb_remove();
	});
}); 
</script>
<form action="/" method="get" id="form" name="form" accept-charset="utf-8">
	
    <p>
        <label>Text</label>
        <input type="text" name="dropcap-text" value="" id="dropcap-text" /><br />
        <small><?php _e('Leave blank if you selected text in visual editor', 'rehub_framework') ;?></small>
    </p>    
	 <p>
        <label>&nbsp;</label>
        <input type="button" id="submit" class="button" value="<?php _e('Insert', 'rehub_framework') ;?>" name="submit" />
    </p>
</form>