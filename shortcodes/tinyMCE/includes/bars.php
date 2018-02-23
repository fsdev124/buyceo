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
			'title'      	: '',
			'percentage'     : '90',
			'color'      	: '#fb7203'
			};

		var shortcode = '[wpsm_bar';
		
		for( var index in options) {
			var value = jQuery('#form').find('#bar-' + index).val();
			
			if ( value !== '' )
				shortcode += ' ' + index + '="' + value + '"';
			else
				shortcode += ' ' + index + '="' + options[index] + '"'; 	
		}
		shortcode += ']';
		
        window.send_to_editor(shortcode);
		
		// closes Thickbox
		tb_remove();
	});
}); 
</script>
<form action="/" method="get" id="form" name="form" accept-charset="utf-8">
	<p><label><?php _e('Title', 'rehub_framework') ;?></label>
        <input type="text" name="bar-title" value="wordpress" id="bar-title" />
    </p>
	
	<p><label><?php _e('Style', 'rehub_framework') ;?></label>
       	<select name="bar-color" id="bar-color" size="1">
			<option value="#fb7203" selected="selected"><?php _e('orange', 'rehub_framework') ;?></option>
			<option value="#00aae9"><?php _e('blue', 'rehub_framework') ;?></option>
			<option value="#222222"><?php _e('black', 'rehub_framework') ;?></option>
			<option value="#dd0007"><?php _e('red', 'rehub_framework') ;?></option>
            <option value="#77bb0f"><?php _e('green', 'rehub_framework') ;?></option>			
        </select>
    </p>  
    <p>
        <label><?php _e('Percentage', 'rehub_framework') ;?></label>
        <input type="text" name="bar-percentage" value="" id="bar-percentage" /><br />
        <small><?php _e('type without %', 'rehub_framework') ;?></small>
    </p>    
	 <p>
        <label>&nbsp;</label>
        <input type="button" id="submit" class="button" value="<?php _e('Insert', 'rehub_framework') ;?>" name="submit" />
    </p>
</form>