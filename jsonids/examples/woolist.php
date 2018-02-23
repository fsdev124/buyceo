<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php require_once(dirName(__FILE__).'/../../../../../../wp-load.php'); ?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/jsonids/css/token-input.css" />
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/jsonids/js/jquery.tokeninput.min.js"></script>

<script data-cfasync="false">

// executes this when the DOM is ready
jQuery(document).ready(function() {
	// handles the click event of the submit button
	jQuery('#submit').click(function(){
        var idvalue = jQuery('#woolist-ids').val();
        var idtag = jQuery('#woolist-tag').val();
        var show = jQuery('#woolist-show').val();        

		var shortcode = '[wpsm_woolist';

		if (idvalue !='') {
			shortcode += ' data_source="ids" ids="' + idvalue + '"';
		}

		else {
			shortcode += ' data_source="tag" tag="' + idtag + '" show="' + show + '"';
		}

		shortcode += ']';

		// inserts the shortcode into the active editor
		window.send_to_editor(shortcode);		
		
		// closes Thickbox
		tinyMCEPopup.close();
	});
}); 
</script>
<form action="/" method="get" id="form" name="form" accept-charset="utf-8">
    <p><label><?php _e('Search products', 'rehub_framework') ;?></label>
        <input type="text" name="woolist-ids" value="" id="woolist-ids" /><br />
		<small></small>
    </p> 
    <p><label><?php _e('Or search product tags', 'rehub_framework') ;?></label>
        <input type="text" name="woolist-tag" value="" id="woolist-tag" /><br />
        <small></small>
    </p>
    <p><label><?php _e('Numbers of posts to show', 'rehub_framework') ;?></label>
        <input type="text" name="woolist-show" value="" id="woolist-show" /><br />
        <small><?php _e('Set number', 'rehub_framework') ;?></small>
    </p>	 <p>
        <label>&nbsp;</label>
        <input type="button" id="submit" class="button" value="<?php _e('Insert', 'rehub_framework') ;?>" name="submit" />
    </p>
</form>

<?php
$path_script = get_template_directory_uri() . '/jsonids/json-ids.php';
print <<<END
<script type="text/javascript">
jQuery(document).ready(function () {
	jQuery("#woolist-ids").tokenInput("$path_script", { 
		minChars: 3,
		preventDuplicates: true,
		theme: "rehub",
		onSend: function(params) {
			params.data.posttype = 'product';
			params.data.postnum = 6;
		}
	});
	jQuery("#woolist-tag").tokenInput("$path_script", { 
		queryParam: "t",
		minChars: 3,
		preventDuplicates: true,
		theme: "rehub",
		onSend: function(params) {
			params.data.taxonomy = 'product_tag';
		}
	});
});
</script>
END;
?>