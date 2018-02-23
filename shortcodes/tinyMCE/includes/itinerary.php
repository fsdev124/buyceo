<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<script data-cfasync="false">
jQuery(document).ready(function() {
	jQuery('#submit').click(function(){
		var shortcode = '[wpsm_itinerary]';
		jQuery("input[id^=itinerary-num]").each(function(index) {
			var itinerary_content = jQuery('textarea.itinerary-content:eq('+index+')').val();
			var itinerary_icon = jQuery('input.itinerary-icon:eq('+index+')').val().replace(/\s/g, '');
			var itinerary_color = jQuery('input.itinerary-color:eq('+index+')').val().replace(/\s/g, '');
			shortcode +='<br />[wpsm_itinerary_item icon="'+itinerary_icon+'" color="'+itinerary_color+'"]<br />'+itinerary_content+'<br />[/wpsm_itinerary_item]<br />';
		});
       	shortcode += '[/wpsm_itinerary]';
		window.send_to_editor(shortcode);
		tb_remove();
	});
	jQuery("#add-tab").click(function() {
		jQuery('.shortcode_loop').append('<p><label><?php _e('Icon', 'rehub_framework'); ?></label><input type="text" name="itinerary-icon" value="" class="itinerary-icon" /></p><p><label><?php _e('Color', 'rehub_framework'); ?></label><input type="text" name="itinerary-color" value="" class="itinerary-color" /></p><p><label><?php _e('Content', 'rehub_framework'); ?></label><textarea type="text" name="itinerary-content" value="" class="itinerary-content" col="10"></textarea></p><p style="display:none"><input type="hidden" name="itinerary-num[]" value="" id="itinerary-num[]" /></p>');
	});
}); 
</script>
<form action="/" method="get" id="form" name="form" accept-charset="utf-8">
	<div class="shortcode_loop">
		<p><label><?php _e('Icon', 'rehub_framework'); ?></label><input type="text" name="itinerary-icon" value="" class="itinerary-icon" /><br /><small><?php printf( '%s %s <a href="//fontawesome.io/icons/" target="_blank">%s</a>', __('Set icon class like "fa-circle".', 'rehub_framework'), __('Or leave blank.', 'rehub_framework'), __('More detail...', 'rehub_framework') ); ?></small></p>
		<p><label><?php _e('Color', 'rehub_framework'); ?></label><input type="text" name="itinerary-color" value="" class="itinerary-color" /><br /><small><?php printf( '%s %s <a href="//www.w3schools.com/colors/colors_picker.asp" target="_blank">%s</a>', __('Set HEX color like "#409cd1".', 'rehub_framework'), __('Or leave blank.', 'rehub_framework'), __('More detail...', 'rehub_framework') ); ?></small></p>
		<p><label><?php _e('Content', 'rehub_framework'); ?></label><textarea type="text" name="itinerary-content" value="" class="itinerary-content" col="10"></textarea></p>
		<p style="display:none"><input type="hidden" name="itinerary-num[]" value="" id="itinerary-num[]" /></p>
	</div>
	<p><strong><a style="cursor: pointer;" id="add-tab">+ <?php _e('Add Item', 'rehub_framework') ;?></a></strong></p>
	<p><label>&nbsp;</label><input type="button" name="submit" value="<?php _e('Insert', 'rehub_framework') ;?>" class="button" id="submit"></p>	
</form>