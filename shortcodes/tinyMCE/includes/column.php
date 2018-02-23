<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<script data-cfasync="false">

// executes this when the DOM is ready
jQuery(document).ready(function() { 
	// handles the click event of the submit button
	jQuery('#submit').click(function(){
		// defines the options and their default values
		// again, this is not the most elegant way to do this
		// but well, this gets the job done nonetheless
        var ColumnType = jQuery('#ColumnType').val();
				var Columnposition = jQuery('#Columnposition');
					if( ! tinyMCE.activeEditor || tinyMCE.activeEditor.isHidden()) {
					 var contentcolumn = jQuery("textarea.wp-editor-area").selection('get');
					}
					else {
			        	var contentcolumn = tinyMCE.activeEditor.selection.getContent();  
			        }				
				var ColumnContent = jQuery('#ColumnContent').val();
				var shortcode = '[wpsm_column ';
		
				if(ColumnType) {
					shortcode += 'size="'+ColumnType+'"';
				}
				if(Columnposition.is(":checked")) {
					shortcode += ' position="last"';
				}

				shortcode += ']<br />'
                
                if ( ColumnContent !== '' )
					shortcode += ColumnContent;
				else if	( contentcolumn !== '' )
					shortcode += contentcolumn;
				else 
					shortcode += 'Sample Text';



				shortcode += '<br />[/wpsm_column]'
		
        window.send_to_editor(shortcode);
		
		// closes Thickbox
		tb_remove();
	});
}); 
</script>
<form action="/" method="get" id="form" name="form" accept-charset="utf-8">
	
	<p>
		<label for="ColumnType"><?php _e('Type of column :', 'rehub_framework') ;?></label>
		<select id="ColumnType" name="ColumnType">
			<option value="one-half"><?php _e('One half', 'rehub_framework') ;?></option>
            <option value="one-third"><?php _e('One third', 'rehub_framework') ;?></option>
            <option value="two-third"><?php _e('Two third', 'rehub_framework') ;?></option>
            <option value="one-fourth"><?php _e('One fourth', 'rehub_framework') ;?></option>
            <option value="three-fourth"><?php _e('Three fourth', 'rehub_framework') ;?></option>
            <option value="one-fifth"><?php _e('One fifth', 'rehub_framework') ;?></option>
            <option value="two-fifth"><?php _e('Two fifth', 'rehub_framework') ;?></option>
            <option value="three-fifth"><?php _e('Three fifth', 'rehub_framework') ;?></option>
            <option value="four-fifth"><?php _e('Four fifth', 'rehub_framework') ;?></option>
            <option value="one-sixth"><?php _e('One sixth', 'rehub_framework') ;?></option>
            <option value="five-sixth"><?php _e('Five sixth', 'rehub_framework') ;?></option>
		</select>
	</p>

	<p>
		<label for="Columnposition"><?php _e('Check if column is last:', 'rehub_framework') ;?> </label>
		<input id="Columnposition" name="Columnposition" type="checkbox" class="checks" value="false" />
	</p>
	<p>
		<label for="ColumnContent"><?php _e('Content :', 'rehub_framework') ;?> </label>
		<textarea id="ColumnContent" name="ColumnContent" col="20"></textarea><br />
		<small><?php _e('Leave blank if you selected text in visual editor', 'rehub_framework') ;?></small>
	</p>
	 <p>
        <label>&nbsp;</label>
        <input type="button" id="submit" class="button" value="<?php _e('Insert', 'rehub_framework') ;?>" name="submit" />
    </p>
</form>