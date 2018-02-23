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
			'location'     : '',
			'zoom'      	: '10',
			'key'      	: '',
			'height'      	: '250px'
			};
		var shortcode = '[wpsm_googlemap';
		
		for( var index in options) {
			var value = jQuery('#form').find('#map-' + index).val();
			
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
        <input type="text" name="map-title" value="" id="map-title" />
    </p>
	
	<p><label><?php _e('Location', 'rehub_framework') ;?></label>
        <input type="text" name="map-location" value="2 Elizabeth St, Melbourne Victoria 3000 Australia" id="map-location" />
    </p>
	<p><label><?php _e('Zoom', 'rehub_framework') ;?></label>
        <input type="text" name="map-zoom" value="10" id="map-zoom" />
    </p>
	
	<p><label><?php _e('Height of map (with px)', 'rehub_framework') ;?></label>
        <input type="text" name="map-height" value="250px" id="map-height" />
    </p>  

	<p><label><?php _e('Google api key', 'rehub_framework') ;?></label>
        <input type="text" name="key" value="10" id="key" />
    </p>      
	 <p>
        <label>&nbsp;</label>
        <input type="button" id="submit" class="button" value="<?php _e('Insert', 'rehub_framework') ;?>" name="submit" />
    </p>
</form>