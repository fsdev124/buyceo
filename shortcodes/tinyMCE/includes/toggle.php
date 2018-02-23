<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<script data-cfasync="false">

// executes this when the DOM is ready
jQuery(document).ready(function() { 
	// handles the click event of the submit button
	jQuery('#submit').click(function(){

		var shortcode = '[wpsm_toggle';
		
		var title = jQuery('#toggle-title').val();
		var content = jQuery('#toggle-content').val();
		var opened = jQuery('#toggle-opened');
		if( ! tinyMCE.activeEditor || tinyMCE.activeEditor.isHidden()) {
		 var contenttogle = jQuery("textarea.wp-editor-area").selection('get');
		}
		else {
        	var contenttogle = tinyMCE.activeEditor.selection.getContent();	
        }

		if(opened.is(":checked")) {
			shortcode += ' class="active"';
		}        
			
		if(title !== '')
			shortcode += ' title="' + title +'"';
		else 
			shortcode += ' title="Toggle title..."';
				
		shortcode += ']<br />';
		
		if(content !== '')
			shortcode += content;
		else if	( contenttogle !== '' )
			shortcode += contenttogle;
		else 
			shortcode += 'Toggle content...';
		
		shortcode += '<br />[/wpsm_toggle]';
		
		// inserts the shortcode into the active editor
		window.send_to_editor(shortcode);
		
		
		// closes Thickbox
		tb_remove();
	});
}); 
</script>
<form action="/" method="get" id="form" name="form" accept-charset="utf-8">
	<p><label><?php _e('Title', 'rehub_framework') ;?></label>
        <input type="text" name="toggle-title" value="" id="toggle-title" />
    </p>
	
	<p><label><?php _e('Content', 'rehub_framework') ;?></label>
        <textarea name="toggle-content" id="toggle-content" rows="6"></textarea><br />
        <small><?php _e('Leave blank if you selected text in visual editor', 'rehub_framework') ;?></small>
    </p>
	<p>
		<label><?php _e('Make opened?', 'rehub_framework') ;?></label>
        <input id="toggle-opened" name="toggle-opened" type="checkbox" class="checks" value="false" />
	</p>    
	 <p>
        <label>&nbsp;</label>
        <input type="button" id="submit" class="button" value="<?php _e('Insert', 'rehub_framework') ;?>" name="submit" />
    </p>	
</form>