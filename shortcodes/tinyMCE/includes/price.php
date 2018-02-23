<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<script data-cfasync="false">

// executes this when the DOM is ready
jQuery(document).ready(function() {
	// handles the click event of the submit button
	jQuery('#submit').click(function(){
			
		var shortcode = '';
		
		var new_price = jQuery('#price-new').val();
		var content = jQuery('#price-content').val();
		
		if( new_price == 'yes' ){
			shortcode += '[wpsm_price_table]<br />';
		}
		
		shortcode += '[wpsm_price_column';
		
		var options = { 
			'size'        : '1/3',
			'featured'    : 'no',
			'name'        : 'Sample Name',
			'price'       : '$99.95',
			'per'         : 'month',
			'button_color'  : 'orange',
			'button_url'  : '#',
			'button_text' : 'Sign Up'
			};
		
		for( var index in options) {
			var value = jQuery('#form').find('#price-' + index).val();
			
			if ( value !== '' )
				shortcode += ' ' + index + '="' + value + '"';
			else
				shortcode += ' ' + index + '="' + options[index] + '"'; 	
		}
		
		shortcode += ']<ul>';
		
		if ( jQuery('#price-content').val() !== '' ){
			jQuery.each(jQuery('#price-content').val().split('\n'), function(index, value) { 
			  shortcode += '<li>' + value +'</li>';
			});
		}else{
			shortcode += '<li>Sample Item #1</li><li>Sample Item #2</li><li>Sample Item #3</li>';
		}
		
		shortcode += '</ul>[/wpsm_price_column]';
		
		if( new_price == 'yes' ){
			shortcode += '<br />[/wpsm_price_table]';
		}
		
        window.send_to_editor(shortcode);
		
		
		// closes Thickbox
		tb_remove();
	});
}); 
</script>
<form action="/" method="get" id="form" name="form" accept-charset="utf-8">
	<p>
		<label><?php _e('Create new section', 'rehub_framework') ;?></label>
		<select name="price-new" id="price-new" size="1">
            <option value="no" selected="selected"><?php _e('No', 'rehub_framework') ;?></option>
            <option value="yes"><?php _e('Yes', 'rehub_framework') ;?></option>
        </select>
	</p>
	<p><label><?php _e('Column size', 'rehub_framework') ;?></label>
        <select name="price-size" id="price-size" size="1">
            <option value="3" selected="selected">1/3</option>
            <option value="4">1/4</option>
			<option value="5">1/5</option>
			<option value="2">1/2</option>
        </select></small>
    </p>
	
	<p>
		<label><?php _e('Featured', 'rehub_framework') ;?></label>
		<select name="price-featured" id="price-featured" size="1">
            <option value="no" selected="selected"><?php _e('No', 'rehub_framework') ;?></option>
            <option value="yes"><?php _e('Yes', 'rehub_framework') ;?></option>
        </select>
	</p>
	
	<p><label><?php _e('Name', 'rehub_framework') ;?></label>
        <input type="text" name="price-name" value="" id="price-name" />
    </p>
	
	<p><label><?php _e('Price', 'rehub_framework') ;?></label>
        <input type="text" name="price-price" value="" id="price-price" style="width:100px" />
		 / <input type="text" name="price-per" value="" id="price-per" style="width:100px" />
		<br />
		<small><?php _e('Example: $99.95 / month', 'rehub_framework') ;?></small>
    </p>
    	<p>
		<label><?php _e('Color', 'rehub_framework') ;?></label>
		<select name="price-button_color" id="price-button_color" size="1">
			<option value="red"><?php _e('Red', 'rehub_framework') ;?></option>
			<option value="orange" selected="selected"><?php _e('Orange', 'rehub_framework') ;?></option>
			<option value="blue"><?php _e('Blue', 'rehub_framework') ;?></option>
			<option value="green"><?php _e('Green', 'rehub_framework') ;?></option>
			<option value="black"><?php _e('Black', 'rehub_framework') ;?></option>
			<option value="rosy"><?php _e('Rosy', 'rehub_framework') ;?></option>
			<option value="brown"><?php _e('Brown', 'rehub_framework') ;?></option>
			<option value="pink"><?php _e('Pink', 'rehub_framework') ;?></option>
			<option value="purple"><?php _e('Purple', 'rehub_framework') ;?></option>
			<option value="gold"><?php _e('Gold', 'rehub_framework') ;?></option>
			<option value="teal"><?php _e('Teal', 'rehub_framework') ;?></option>
        </select>
	</p>
	
	<p><label><?php _e('Button URL', 'rehub_framework') ;?></label>
        <input type="text" name="price-button_url" value="" id="price-button_url" />
    </p>
	<p><label><?php _e('Button text', 'rehub_framework') ;?></label>
        <input type="text" name="price-button_text" value="" id="price-button_text" />
    </p>
	
	<p><label><?php _e('List of items', 'rehub_framework') ;?></label>
        <textarea name="price-content" id="price-content" rows="6" /></textarea><br /><small><?php _e('Separated by a new-line (press Enter)', 'rehub_framework') ;?></small>
    </p>
	 <p>
        <label>&nbsp;</label>
        <input type="button" id="submit" class="button" value="<?php _e('Insert', 'rehub_framework') ;?>" name="submit" />
    </p>

</form>