<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<script data-cfasync="false">

// executes this when the DOM is ready
jQuery(document).ready(function() { 
	// handles the click event of the submit highlight
	jQuery('#submit').click(function(){

		var shortcode = '[wpsm_feed';
		var feed_num = jQuery('#feed-num').val();
		var feed_url = jQuery('#feed-url').val();
        shortcode += ' url="'+feed_url+'" number="'+feed_num+'"';

		
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
		<label><?php _e('Number of items to display', 'rehub_framework') ;?></label>
		<select name="feed-num" id="feed-num" size="1">
			<option value="1" selected="selected">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
			<option value="6">6</option>
			<option value="7">7</option>
			<option value="8">8</option>
			<option value="9">9</option>
			<option value="10">10</option>
        </select>
	</p>
    <p>
        <label><?php _e('Url of feed', 'rehub_framework') ;?></label>
        <input type="text" name="feed-url" value="" id="feed-url" />
    </p>
	
	 <p>
        <label>&nbsp;</label>
        <input type="button" id="submit" class="button" value="<?php _e('Insert', 'rehub_framework') ;?>" name="submit" />
    </p>

</form>