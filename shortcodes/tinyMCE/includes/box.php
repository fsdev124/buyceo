<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<script data-cfasync="false">

// executes this when the DOM is ready
jQuery(document).ready(function() { 
	// handles the click event of the submit box
	jQuery('#submit').click(function(){
		var options = { 
			'type'       : 'info',
			'float'       : 'none',
			'text_align'       : 'left'
			};
		
					if( ! tinyMCE.activeEditor || tinyMCE.activeEditor.isHidden()) {
					 var contentbox = jQuery("textarea.wp-editor-area").selection('get');
					}
					else {
			        	var contentbox = tinyMCE.activeEditor.selection.getContent();
			        }
		var box_width = jQuery('#box-width').val();		
		var shortcode = '[wpsm_box';
		
		for( var index in options) {
			var value = jQuery('#form').find('#box-' + index).val();
			
			if ( value !== '' )
				shortcode += ' ' + index + '="' + value + '"';
			else
				shortcode += ' ' + index + '="' + options[index] + '"'; 	
		}

		if(box_width !='') {
					shortcode += ' width="' + box_width + '" ';
		}
		
		shortcode += ']<br />';
		
		var box_text = jQuery('#box-text').val();
		if ( box_text !== '' )
			shortcode += box_text;
		else if	( contentbox !== '' )
			shortcode += contentbox;		
		else	
			shortcode += 'Sample content';
						
		shortcode += '<br />[/wpsm_box]';
		
		// inserts the shortcode into the active editor
		window.send_to_editor(shortcode);
		
		
		// closes Thickbox
		tb_remove();
	});
}); 
</script>
<form action="/" method="get" id="form" name="form" accept-charset="utf-8">
	<p>
		<label><?php _e('Type', 'rehub_framework') ;?></label>
		<select name="box-type" id="box-type" size="1">
            <option value="info" selected="selected"><?php _e('Info', 'rehub_framework') ;?></option>			
            <option value="download"><?php _e('Download', 'rehub_framework') ;?></option>
            <option value="error"><?php _e('Error', 'rehub_framework') ;?></option>
            <option value="warning"><?php _e('Warning', 'rehub_framework') ;?></option>
            <option value="yellow"><?php _e('Yellow color box', 'rehub_framework') ;?></option>
            <option value="green"><?php _e('Green color box', 'rehub_framework') ;?></option>
            <option value="gray"><?php _e('Gray color box', 'rehub_framework') ;?></option>
            <option value="blue"><?php _e('Blue color box', 'rehub_framework') ;?></option>
            <option value="red"><?php _e('Red color box', 'rehub_framework') ;?></option>  
            <option value="dashed_border"><?php _e('Dashed border box', 'rehub_framework') ;?></option>
            <option value="solid_border"><?php _e('Solid border box', 'rehub_framework') ;?></option>
            <option value="transparent"><?php _e('Transparent background box', 'rehub_framework') ;?></option>                       
        </select>
	</p>
	<p>
		<label>Float</label>
		<select name="box-float" id="box-float" size="1">
            <option value="none" selected="selected"><?php _e('None', 'rehub_framework') ;?></option>  			
            <option value="left"><?php _e('Left', 'rehub_framework') ;?></option>			
            <option value="right"><?php _e('Right', 'rehub_framework') ;?></option>                    
        </select>
	</p>
	<p>
		<label>Text-align</label>
		<select name="box-text_align" id="box-text_align" size="1">
            <option value="left" selected="selected"><?php _e('Left', 'rehub_framework') ;?></option>			
            <option value="right"><?php _e('Right', 'rehub_framework') ;?></option>
            <option value="center"><?php _e('Center', 'rehub_framework') ;?></option>   
            <option value="justify"><?php _e('Justify', 'rehub_framework') ;?></option>                    
        </select>
	</p>
	<p>
        <label><?php _e('Width (with %)', 'rehub_framework') ;?></label>
        <input type="text" name="box-width" value="" id="box-width" /><br />
        <small><?php _e('Or live blank for full width', 'rehub_framework') ;?></small>
    </p>		
    <p>
        <label>Text</label>
        <textarea type="text" name="box-text" value="" id="box-text" col="10"></textarea><br />
        <small><?php _e('Leave blank if you selected text in visual editor', 'rehub_framework') ;?></small>
    </p>
	
	 <p>
        <label>&nbsp;</label>
        <input type="button" id="submit" class="button" value="<?php _e('Insert', 'rehub_framework') ;?>" name="submit" />
    </p>

</form>