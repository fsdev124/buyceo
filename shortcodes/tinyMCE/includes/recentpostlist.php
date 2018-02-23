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
			'cat'      	: '1',
			'show'     : '3',
			};
		var shortcode = '[wpsm_recent_posts_list';
		
		for( var index in options) {
			var value = jQuery('#form').find('#recentpostlist-' + index).val();
			
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
	<p><label><?php _e('Cat ID', 'rehub_framework') ;?></label>
        <input type="text" name="recentpostlist-catid" value="" id="recentpostlist-catid" />
    </p>
	
	<p><label><?php _e('Number of posts to show', 'rehub_framework') ;?></label>
        <input type="text" name="recentpostlist-posts" value="" id="recentpostlist-posts" />
    </p>
	 <p>
        <label>&nbsp;</label>
        <input type="button" id="submit" class="button" value="<?php _e('Insert', 'rehub_framework') ;?>" name="submit" />
    </p>
</form>