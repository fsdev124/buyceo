<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<script data-cfasync="false">

// executes this when the DOM is ready
jQuery(document).ready(function() { 
	// handles the click event of the submit list
	jQuery('#submit').click(function(){

		var shortcode = '[wpsm_list';
		
			var value = jQuery('#form').find('#list-type').val();
			shortcode += ' type="' + value + '"';

			if(jQuery('#list-hover').is(":checked")) {
				shortcode += ' hover="1"';
			}

			if(jQuery('#list-dark').is(":checked")) {
				shortcode += ' darklink="1"';
			}	

			if(jQuery('#list-gap').is(":checked")) {
				shortcode += ' gap="small"';
			}									
		
		shortcode += ']<ul>';
		
		if ( jQuery('#list-text').val() !== '' ){
			jQuery.each(jQuery('#list-text').val().split('\n'), function(index, value) { 
			  shortcode += '<li>' + value +'</li>';
			});
		}else{
			shortcode += '<li>Sample Item #1</li><li>Sample Item #2</li><li>Sample Item #3</li>';
		}
		
		shortcode += '</ul>[/wpsm_list]';
		
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
		<select name="list-type" id="list-type" size="1">
            <option value="arrow" selected="selected"><?php _e('Arrow', 'rehub_framework') ;?></option>
            <option value="check"><?php _e('Check', 'rehub_framework') ;?></option>
			<option value="star"><?php _e('Star', 'rehub_framework') ;?></option>
			<option value="bullet"><?php _e('Bullet', 'rehub_framework') ;?></option>			
        </select>
	</p>
    <p>
        <label><?php _e('List Text', 'rehub_framework') ;?></label>
        <textarea name="list-text" id="list-text" rows="6"></textarea><br /><small><?php _e('Separated by a new-line (by Enter)', 'rehub_framework') ;?></small>
    </p>
	<p class="half_left">
		<label><?php _e('Pretty hover?', 'rehub_framework') ;?></label>
        <input id="list-hover" name="list-hover" type="checkbox" class="checks" value="false" />
	</p> 
	<p class="half_left second_half">
		<label><?php _e('Make links dark?', 'rehub_framework') ;?></label>
        <input id="list-dark" name="list-dark" type="checkbox" class="checks" value="false" />
	</p> 
	<p>
		<label><?php _e('Make small gap between items?', 'rehub_framework') ;?></label>
        <input id="list-gap" name="list-gap" type="checkbox" class="checks" value="false" />
	</p> 
	 <p>
        <label>&nbsp;</label>
        <input type="button" id="submit" class="button" value="<?php _e('Insert', 'rehub_framework') ;?>" name="submit" />
    </p>
</form>