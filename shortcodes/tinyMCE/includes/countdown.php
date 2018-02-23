<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<script data-cfasync="false">
jQuery(document).ready(function() {
	// handles the click event of the submit box
	jQuery('#submit').click(function(){

				var count_year = jQuery('#count_year').val();
				var count_month = jQuery('#count_month').val();
				var count_day = jQuery('#count_day').val();
				var count_hour = jQuery('#count_hour').val();												

				var shortcode = '[wpsm_countdown';

				if(count_year !== '') {
					shortcode += ' year="'+count_year+'"';
				}

				if(count_month !== '') {
					shortcode += ' month="'+count_month+'"';
				}

				if(count_day !== '') {
					shortcode += ' day="'+count_day+'"';
				}

				if(count_hour !== '') {
					shortcode += ' hour="'+count_hour+'"';
				}												
							
				shortcode += ']';							

		// inserts the shortcode into the active editor
		window.send_to_editor(shortcode);
		
		
		// closes Thickbox
		tb_remove();
				
	});

			
});

</script>

<form action="/" method="get" id="form" name="form" accept-charset="utf-8">
	<p>
		<label for="count_year"><?php _e('Year of countdown finish :', 'rehub_framework') ;?></label>
		<input id="count_year" name="count_year" type="text" value="" />
		<small><?php _e('Example - 2015', 'rehub_framework') ;?></small>
	</p>
	<p>
		<label for="count_month"><?php _e('Month of countdown finish :', 'rehub_framework') ;?></label>
		<input id="count_month" name="count_month" type="text" value="" />
		<small><?php _e('Example - 6. Note! Without zero in start', 'rehub_framework') ;?></small>
	</p>
	<p>
		<label for="count_day"><?php _e('Day of countdown finish :', 'rehub_framework') ;?></label>
		<input id="count_day" name="count_day" type="text" value="" />
		<small><?php _e('Example - 6', 'rehub_framework') ;?></small>
	</p>
	<p>
		<label for="count_hour"><?php _e('Hour of countdown finish :', 'rehub_framework') ;?></label>
		<input id="count_hour" name="count_hour" type="text" value="" />
		<small><?php _e('Example - 12', 'rehub_framework') ;?></small>
	</p>			
	 <p>
        <label>&nbsp;</label>
        <input type="button" id="submit" class="button" value="<?php _e('Insert', 'rehub_framework') ;?>" name="submit" />
    </p>
</form>