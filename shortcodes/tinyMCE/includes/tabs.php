<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<script data-cfasync="false">

// executes this when the DOM is ready
jQuery(document).ready(function() { 
	// handles the click event of the submit button
	jQuery('#submit').click(function(){

		
		var shortcode = '[wpsm_tabgroup]';
		shortcode += '<br />';
        
		jQuery("input[id^=tabs-num]").each(function(index) {
			var tabs_content = jQuery('input.tabs-content:eq(' +index+ ')').val();
			var tabs_title = jQuery('input.tabs-title:eq(' +index+ ')').val();
					shortcode +='[wpsm_tab title="'+tabs_title+'"]'+ tabs_content +'[/wpsm_tab]<br />';
		});
  
       	shortcode += '[/wpsm_tabgroup]';
		
		// inserts the shortcode into the active editor
		window.send_to_editor(shortcode);
		
		
		// closes Thickbox
		tb_remove();
	});

			jQuery("#add-tab").click(function() {
				jQuery('.shortcode_loop').append('<p><label>Title of tab</label><input type="text" name="tabs-title" value="" class="tabs-title" /></p>	<p><label>Content</label><input type="text" name="tabs-content" value="" class="tabs-content" /></p><p style="display:none"><input type="hidden" name="tabs-num[]" value="" id="tabs-num[]" /></p>');
			});

}); 
</script>
<form action="/" method="get" id="form" name="form" accept-charset="utf-8">
<div class="shortcode_loop">
	<p>
		<label><?php _e('Title of tab', 'rehub_framework') ;?></label>
          <input type="text" name="tabs-title" value="" class="tabs-title" />
        </select>
	</p>
	<p>
		<label><?php _e('Content', 'rehub_framework') ;?></label>
        <input type="text" name="tabs-content" value="" class="tabs-content" />
    </p>
    <p style="display:none">
        <input type="hidden" name="tabs-num[]" value="" id="tabs-num[]" />
    </p>
</div>
	<p>
		<strong><a style="cursor: pointer;" id="add-tab">+ <?php _e('Add Tab', 'rehub_framework') ;?></a></strong>
	</p>
	 <p>
        <label>&nbsp;</label>
        <input type="button" name="submit" value="<?php _e('Insert', 'rehub_framework') ;?>" class="button" id="submit">
    </p>	
</form>