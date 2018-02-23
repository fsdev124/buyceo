<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<script data-cfasync="false">

// executes this when the DOM is ready
jQuery(document).ready(function() { 
	// handles the click event of the submit button
	jQuery('#submit').click(function(){
		// defines the options and their default values
		// again, this is not the most elegant way to do this
		// but well, this gets the job done nonetheless
				var VideoUrl = jQuery('#VideoUrl').val();
				var width = jQuery('#width').val();
				var height = jQuery('#height').val();
				var videotitle = jQuery('#videotitle').val();
				var videodesc = jQuery('#videodesc').val();
				var formatcheck = jQuery('#formatcheck');

				var shortcode = '[wpsm_video';
				
				if(width) {
					shortcode += ' width="'+width+'"';
				}
				if(height) {
					shortcode += ' height="'+height+'"';
				}

				if(formatcheck.is(":checked")) {
					shortcode += ' schema="yes" title ="'+videotitle+'" description ="'+videodesc+'"';
				}

				shortcode += ']'+ VideoUrl + '[/wpsm_video]';
		
        window.send_to_editor(shortcode);
		
		// closes Thickbox
		tb_remove();
	});
}); 

jQuery(document).ready(function() {
			
            jQuery(".schecklive").css("display","none");
            jQuery("#formatcheck").click(function(){
               // If checked
		       if (jQuery("#formatcheck").is(":checked"))
		       {
			     //show the hidden div
			     jQuery(".schecklive").show("slow");
		       }
		       else
		       {
			     //otherwise, hide it
			     jQuery(".schecklive").hide("slow");
		       }
	        });
});

</script>
<form action="/" method="get" id="form" name="form" accept-charset="utf-8">
	<p>
		<label for="VideoUrl"><?php _e('Video Url :', 'rehub_framework') ;?></label>
		<input id="VideoUrl" name="VideoUrl" type="text" value="http://" />

	</p>	
	<p id="scheck">
		<label for="formatcheck"><?php _e('With schema?', 'rehub_framework') ;?> </label>
		<input id="formatcheck" name="formatcheck" type="checkbox" class="checks" value="false"/>
	</p>
	<p class="schecklive">
		<label for="videotitle"><?php _e('Title of video :', 'rehub_framework') ;?></label>
		<input id="videotitle" name="videotitle" type="text" value="" />
	</p>
	<p class="schecklive">
		<label for="videodesc"><?php _e('Description of video :', 'rehub_framework') ;?></label>
		<input id="videodesc" name="videodesc" type="text" value="" />
	</p>
	<p>
		<label for="width"><?php _e('Width (with px):', 'rehub_framework') ;?></label>
		<input style="width:70px;" id="width" name="width" type="text" value="" />
	</p>
	<p>
		<label for="height"><?php _e('Height (with px):', 'rehub_framework') ;?></label>
		<input style="width:70px;"  id="height" name="height" type="text" value="" />
	</p>
	<p><small><?php _e('You can leave blank width and height for using default value', 'rehub_framework') ;?></small></p>		
	 <p>
        <label>&nbsp;</label>
        <input type="button" id="submit" class="button" value="<?php _e('Insert', 'rehub_framework') ;?>" name="submit" />
    </p>
</form>