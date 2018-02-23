<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<script data-cfasync="false">

// executes this when the DOM is ready
jQuery(document).ready(function() {
	// handles the click event of the submit button
	jQuery('#submit').click(function(){

		
		var shortcode = '[wpsm_accordion]';
		shortcode += '<br />';
        
		jQuery("input[id^=accordion-num]").each(function(index) {
			var accordion_content = jQuery('input.accordion-content:eq(' +index+ ')').val();
			var accordion_title = jQuery('input.accordion-title:eq(' +index+ ')').val();
					shortcode +='[wpsm_accordion_section title="'+accordion_title+'"]'+ accordion_content +'[/wpsm_accordion_section]<br />';
		});
  
       	shortcode += '[/wpsm_accordion]';
		
		// inserts the shortcode into the active editor
		window.send_to_editor(shortcode);
		
		
		// closes Thickbox
		tb_remove();
	});

			jQuery("#add-tab").click(function() {
				jQuery('.shortcode_loop').append('<p><label>Title of section</label><input type="text" name="accordion-title" value="Sample title" class="accordion-title" /></p>	<p><label>Content</label><input type="text" name="accordion-content" value="Sample content" class="accordion-content" /></p><p style="display:none"><input type="hidden" name="accordion-num[]" value="" id="accordion-num[]" /></p>');
			});

}); 
</script>
<form action="/" method="get" id="form" name="form" accept-charset="utf-8">
<div class="shortcode_loop">
	<p>
		<label><?php _e('Title of section', 'rehub_framework') ;?></label>
          <input type="text" name="accordion-title" value="Sample title" class="accordion-title" />
        </select>
	</p>
	<p>
		<label><?php _e('Content', 'rehub_framework') ;?></label>
        <input type="text" name="accordion-content" value="Sample content" class="accordion-content" />
    </p>
    <p style="display:none">
        <input type="hidden" name="accordion-num[]" value="" id="accordion-num[]" />
    </p>
</div>
	<p>
		<strong><a style="cursor: pointer;" id="add-tab">+ <?php _e('Add Accordition', 'rehub_framework') ;?></a></strong>
	</p>
	 <p>
        <label>&nbsp;</label>
        <input type="button" name="submit" value="<?php _e('Insert', 'rehub_framework') ;?>" class="button" id="submit">
    </p>	
</form>