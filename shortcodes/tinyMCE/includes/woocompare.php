<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<script data-cfasync="false">
// executes this when the DOM is ready
jQuery(document).ready(function() {
	// handles the click event of the submit button
	jQuery('#submit').click(function(){
        var idvalue = jQuery('#woocompare-ids').val();       
        var notitle = jQuery('#notitle');
        var logo = jQuery('#logo').val();
		var shortcode = '[wpsm_woocompare';

		if (idvalue !='') {
			shortcode += ' ids="' + idvalue + '"';
		}
		if(notitle.is(":checked")) {
			shortcode += ' notitle="1"';
		}

		shortcode += ' logo="' + logo + '"';				

		shortcode += ']';

		// inserts the shortcode into the active editor
		window.send_to_editor(shortcode);		
		
		// closes Thickbox
		tinyMCEPopup.close();
	});
}); 
</script>
<form action="/" method="get" id="form" name="form" accept-charset="utf-8">
    <p><label><?php _e('Add products', 'rehub_framework') ;?></label>
        <input type="text" name="woocompare-ids" value="" id="woocompare-ids" /><br />
		<small></small>
    </p> 
	<p><label><?php _e('Logo', 'rehub_framework') ;?></label>
       	<select name="logo" id="logo" size="1">
			<option value="vendor" selected="selected"><?php _e('Vendor', 'rehub_framework') ;?></option>
			<option value="product"><?php _e('product', 'rehub_framework') ;?></option>
			<option value="brand"><?php _e('brand', 'rehub_framework') ;?></option>			
        </select>
    </p>     
	<p>
		<label><?php _e('Disable title of products?', 'rehub_framework') ;?></label>

        <input id="notitle" name="notitle" type="checkbox" class="checks" value="false" />
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
	jQuery("#woocompare-ids").tokenInput("$path_script", { 
		minChars: 3,
		preventDuplicates: true,
		theme: "rehub",
		onSend: function(params) {
			params.data.posttype = 'product';
			params.data.postnum = 6;
		}
	});
});
</script>
END;
?>