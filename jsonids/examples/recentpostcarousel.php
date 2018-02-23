<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php require_once(dirName(__FILE__).'/../../../../../../wp-load.php'); ?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/jsonids/css/token-input.css" />
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/jsonids/js/jquery.tokeninput.min.js"></script>

<script data-cfasync="false">

// executes this when the DOM is ready
jQuery(document).ready(function() {
	// handles the click event of the submit list
	jQuery('#submit').click(function(){

                var Postslidernumber = jQuery('#Postslidernumber').val();
				var Postslidercat = jQuery('#Postslidercat').val();

				var shortcode = '[wpsm_recent_posts';
		
				if(Postslidernumber) {
					shortcode += ' number_posts="'+Postslidernumber+'"';
				}
				if(Postslidercat) {
					shortcode += ' cat_id="'+Postslidercat+'"';
				}

				shortcode += ']';
				window.send_to_editor(shortcode);

		tb_remove();
	});
}); 
</script>
<form action="/" method="get" id="form" name="form" accept-charset="utf-8">
    <p>
		<label for="Postslidernumber"><?php _e('Number of posts to show', 'rehub_framework') ;?></label>
		<input id="Postslidernumber" name="Postslidernumber" type="text" />
		<small><?php _e('Minimum 4', 'rehub_framework') ;?></small>
	</p>
	<p>
		<label for="Postslidercat"><?php _e('Category ID (optional) :', 'rehub_framework') ;?></label>
		<input id="Postslidercat" name="Postslidercat" type="text" />
	</p>
	 <p>
        <label>&nbsp;</label>
        <input type="button" id="submit" class="button" value="<?php _e('Insert', 'rehub_framework') ;?>" name="submit" />
    </p>
</form>

<?php
$path_script = get_template_directory_uri() . '/jsonids/json-ids.php';
print <<<END
<script type="text/javascript">
jQuery(document).ready(function () {
	jQuery("#Postslidernumber").tokenInput("$path_script", { 
		minChars: 3,
		preventDuplicates: true,
		theme: "rehub",
		onSend: function(params) {
			params.data.posttype = 'post';
			params.data.postnum = 6;
		}
	});
	jQuery("#Postslidercat").tokenInput("$path_script", { 
		queryParam: "t",
		minChars: 3,
		preventDuplicates: true,
		theme: "rehub",
		onSend: function(params) {
			params.data.taxonomy = 'category';
		}
	});
});
</script>
END;
?>