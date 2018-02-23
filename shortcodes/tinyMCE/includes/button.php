<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<script data-cfasync="false">

// executes this when the DOM is ready
jQuery(document).ready(function() {
	// handles the click event of the submit button
	jQuery('#submit').click(function(){

		var options = { 
			'color'      : 'orange',
			'size'       : 'small',
			'link'     : '#',
			'icon'     : '',
			'class'	: '',
			};
		var button_text = jQuery('#button-text').val();	
		var button_class = jQuery('#button-class').val();
		var button_rel = jQuery('#button-rel');
		var button_target = jQuery('#button-target');
		var border_radius = jQuery('#button-border_radius').val();
		if( ! tinyMCE.activeEditor || tinyMCE.activeEditor.isHidden()) {
		 var contenthighlight = jQuery("textarea.wp-editor-area").selection('get');
		}
		else {
        	var contenthighlight = tinyMCE.activeEditor.selection.getContent();	
        }

		var shortcode = '[wpsm_button';
		
		for( var index in options) {
			var value = jQuery('#form').find('#button-' + index).val();
			
			if ( value !== '' )
				shortcode += ' ' + index + '="' + value + '"';
			else
				shortcode += ' ' + index + '="' + options[index] + '"'; 	
		}
		if(border_radius !='') {
					shortcode += ' border_radius="' + border_radius + '"';
		}
		if(button_target.is(":checked")) {
					shortcode += ' target="_blank"';
		}
		if(button_rel.is(":checked")) {
					shortcode += ' rel="nofollow"';
		}
		
		shortcode += ']';
		
		
		if ( button_text !== '' )
			shortcode += button_text;
		else if	( contenthighlight !== '' )
			shortcode += contenthighlight;
		else 
			shortcode += 'Button';

		shortcode += '[/wpsm_button]';
        
		
		// inserts the shortcode into the active editor
		window.send_to_editor(shortcode);
		
		
		// closes Thickbox
		tb_remove();
	});

}); 
</script>
<form action="/" method="get" id="form" name="form" accept-charset="utf-8">
<div class="tabss">
	<p>
		<label>Color</label>
		<select name="button-color" id="button-color" size="1">
			<option value="red"><?php _e('Red', 'rehub_framework') ;?></option>
			<option value="orange" selected="selected"><?php _e('Orange', 'rehub_framework') ;?></option>
			<option value="blue"><?php _e('Blue', 'rehub_framework') ;?></option>
			<option value="green"><?php _e('Green', 'rehub_framework') ;?></option>
			<option value="black"><?php _e('Black', 'rehub_framework') ;?></option>
			<option value="rosy"><?php _e('Rosy', 'rehub_framework') ;?></option>
			<option value="brown"><?php _e('Brown', 'rehub_framework') ;?></option>
			<option value="pink"><?php _e('Pink', 'rehub_framework') ;?></option>
			<option value="purple"><?php _e('Purple', 'rehub_framework') ;?></option>
			<option value="gold"><?php _e('Gold', 'rehub_framework') ;?></option>
			<option value="teal"><?php _e('Teal', 'rehub_framework') ;?></option>
			<option value="white"><?php _e('White', 'rehub_framework') ;?></option>
        </select>
	</p>
    <p>
		<label>Button Size :</label>
		<select id="button-size" name="button-size">
			<option value="small"><?php _e('Small', 'rehub_framework') ;?></option>
			<option value="medium"><?php _e('Medium', 'rehub_framework') ;?></option>
			<option value="big"><?php _e('Big', 'rehub_framework') ;?></option>
		</select>
	</p>
	<p>
		<label><?php _e('Button Link :', 'rehub_framework') ;?></label>
		<input id="button-link" name="button-link" type="text" value="http://" />
	</p>
	<p  class="half_left">
		<label><?php _e('Border radius (with px) :', 'rehub_framework') ;?></label>
		<input id="button-border_radius" name="button-border_radius" type="text" value="" />
	</p>
	<p class="half_left second_half">
		<label>Icon</label>
        <select name="button-icon" id="button-icon" size="1">
            <option value="none" selected="selected"><?php _e('None', 'rehub_framework') ;?></option>
            <option value="download"><?php _e('Download', 'rehub_framework') ;?></option>
            <option value="check-circle"><?php _e('Tick', 'rehub_framework') ;?></option>
            <option value="save"><?php _e('Save', 'rehub_framework') ;?></option>
            <option value="heart"><?php _e('Heart', 'rehub_framework') ;?></option>
            <option value="star"><?php _e('Star', 'rehub_framework') ;?></option>
            <option value="map-marker"><?php _e('Map marker', 'rehub_framework') ;?></option>
            <option value="thumbs-up"><?php _e('Thumbs Up', 'rehub_framework') ;?></option>
            <option value="thumbs-down"><?php _e('Thumbs Down', 'rehub_framework') ;?></option>
            <option value="phone"><?php _e('Phone', 'rehub_framework') ;?></option>
            <option value="link"><?php _e('Link', 'rehub_framework') ;?></option>
            <option value="paperclip"><?php _e('Paper clip', 'rehub_framework') ;?></option>
            <option value="key"><?php _e('Key', 'rehub_framework') ;?></option>
        </select>
	</p>
	<div class="clear"></div>
	<p class="half_left">
		<label><?php _e('Open in a new window :', 'rehub_framework') ;?></label>
        <input id="button-target" name="button-target" type="checkbox" class="checks" value="false" />
	</p>
	<p class="half_left second_half">
		<label><?php _e('Add rel=nofollow :', 'rehub_framework') ;?></label>
        <input id="button-rel" name="button-rel" type="checkbox" class="checks" value="false" />
	</p>
	<div class="clear"></div>
	<p>
		<label><?php _e('Additional class :', 'rehub_framework') ;?></label>
		<input id="button-class" name="button-class" type="text" value="" />
	</p>	
    <p>
        <label>Text</label>
        <input type="text" name="button-text" value="" id="button-text" /><br />
        <small><?php _e('Or live blank if you selected a text in visual editor', 'rehub_framework') ;?></small>
    </p>
</div>
	 <p>
        <label>&nbsp;</label>
        <input type="button" name="submit" value="<?php _e('Insert', 'rehub_framework') ;?>" class="button" id="submit">
    </p>	
</form>