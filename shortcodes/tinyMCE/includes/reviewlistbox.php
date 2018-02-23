<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<script data-cfasync="false">
jQuery(document).ready(function() { 
	// handles the click event of the submit box
	jQuery('#submit').click(function(){
		//var offerlinkid = jQuery('#offerlinkid').val();
		var offerid = jQuery('#offerid').val();
		var shortcode = '[wpsm_top postid="'+offerid+'"] ';																															

		// inserts the shortcode into the active editor
		window.send_to_editor(shortcode);
		
		
		// closes Thickbox
		tb_remove();
				
			});
			
});

</script>

<form action="/" method="get" id="form" name="form" accept-charset="utf-8">
	
	<p>
	<label for="offerid"><?php _e('Type post name', 'rehub_framework') ;?></label>
	<input id="offerid" name="offerid" type="text" value="" />
	<small>You can choose several for reviews list</small>
	</p>
   				

	 <p>
        <label>&nbsp;</label>
        <input type="button" id="submit" class="button" value="<?php _e('Insert', 'rehub_framework') ;?>" name="submit" />
    </p>
</form>
<?php
$path_script = get_template_directory_uri() . '/jsonids/json-ids.php';
print <<<END
<script data-cfasync="false">
jQuery(document).ready(function () {
	jQuery("#offerid").tokenInput("$path_script", { 
		minChars: 3,
		preventDuplicates: true,
		theme: "rehub",
		onSend: function(params) {
			params.data.posttype = 'post';
			params.data.postnum = 6;
		}
	});
});
</script>
END;
?>