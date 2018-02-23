<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<script data-cfasync="false">
jQuery(document).ready(function() {
	// handles the click event of the submit box
	jQuery('#submit').click(function(){

				var promoBoxback = jQuery('#promoBoxback').val();
				var promoBoxborder = jQuery('#promoBoxborder');
				var promoBoxbordersize = jQuery('#promoBoxbordersize').val();
				var promoBoxbordercolor = jQuery('#promoBoxbordercolor').val();
				var promoBoxhighlightcheck = jQuery('#promoBoxhighlightcheck');
				var promoBoxhighlightcolor = jQuery('#promoBoxhighlightcolor').val();
				var promoBoxhighlightpos = jQuery('#promoBoxhighlightpos').val();
				var promoBoxbtn = jQuery('#promoBoxbtn');
				var promoBoxbtnlink = jQuery('#promoBoxbtnlink').val();
				var promoBoxbtntext = jQuery('#promoBoxbtntext').val();
				var promoBoxtitle = jQuery('#promoBoxtitle').val();
				var promoBoxcontent = jQuery('#promoBoxcontent').val();
				if( ! tinyMCE.activeEditor || tinyMCE.activeEditor.isHidden()) {
					 var contentpromobox = jQuery("textarea.wp-editor-area").selection('get');
					}
				else {
			        var contentpromobox = tinyMCE.activeEditor.selection.getContent();
			        }

				var shortcode = '[wpsm_promobox ';
                shortcode += 'background="'+promoBoxback+'" ';
				
				if(promoBoxborder.is(":checked")) {
					shortcode += 'border_size="'+promoBoxbordersize+'" ';
					shortcode += 'border_color="'+promoBoxbordercolor+'" ';
				}
				
				if(promoBoxhighlightcheck.is(":checked")) {
					shortcode += 'highligh_color="'+promoBoxhighlightcolor+'" ';
					shortcode += 'highlight_position="'+promoBoxhighlightpos+'" ';
				}				
				
				if(promoBoxbtn.is(":checked")) {
					shortcode += 'button_link="'+promoBoxbtnlink+'" ';
					shortcode += 'button_text="'+promoBoxbtntext+'" ';
				}
				
				if(promoBoxtitle !== '') {
					shortcode += 'title="'+promoBoxtitle+'" ';
				}

		        if ( promoBoxcontent !== '' )
				   shortcode += 'description="'+promoBoxcontent+'" ';
		        else if	( contentpromobox !== '' )
			       shortcode += 'description="'+contentpromobox+'" ';		
		        else	
			       shortcode += 'description="Sample content"';
				
				shortcode += ']';							

		// inserts the shortcode into the active editor
		window.send_to_editor(shortcode);
		
		
		// closes Thickbox
		tb_remove();
				
			});

		jQuery(".bordercheck").css("display","none");

	    jQuery("#promoBoxborder").click(function(){
               // If checked
		       if (jQuery("#promoBoxborder").is(":checked"))
		       {
			     //show the hidden div
			     jQuery(".bordercheck").show("slow");
		       }
		       else
		       {
			     //otherwise, hide it
			     jQuery(".bordercheck").hide("slow");
		       }
	    });
			
		jQuery(".highlightcheck").css("display","none");

	    jQuery("#promoBoxhighlightcheck").click(function(){
               // If checked
		       if (jQuery("#promoBoxhighlightcheck").is(":checked"))
		       {
			     //show the hidden div
			     jQuery(".highlightcheck").show("slow");
		       }
		       else
		       {
			     //otherwise, hide it
			     jQuery(".highlightcheck").hide("slow");
		       }
	    });
			
		jQuery(".btncheck").css("display","none");

	    jQuery("#promoBoxbtn").click(function(){
               // If checked
		       if (jQuery("#promoBoxbtn").is(":checked"))
		       {
			     //show the hidden div
			     jQuery(".btncheck").show("slow");
		       }
		       else
		       {
			     //otherwise, hide it
			     jQuery(".btncheck").hide("slow");
		       }
	    });
			
});

</script>

<form action="/" method="get" id="form" name="form" accept-charset="utf-8">
	<p>
		<label for="promoBoxback"><?php _e('Background-color :', 'rehub_framework') ;?></label>
		<select id="promoBoxback" name="promoBoxback">
			<option value="#f8f8f8"><?php _e('Grey', 'rehub_framework') ;?></option>			
			<option value="#ffffff"><?php _e('White', 'rehub_framework') ;?></option>
		</select>
	</p>
    
    <p>
		<label for="promoBoxborder"><?php _e('Show border?', 'rehub_framework') ;?></label>
		<input id="promoBoxborder" name="promoBoxborder" type="checkbox" class="checks" value="false" />
	</p>
    
    <p class="bordercheck half_left">
		<label for="promoBoxbordersize"><?php _e('Border size :', 'rehub_framework') ;?></label>
		<select id="promoBoxbordersize" name="promoBoxbordersize">
			<option value="1px">1px</option>			
			<option value="2px">2px</option>
            <option value="3px">3px</option>
            <option value="4px">4px</option>
            <option value="5px">5px</option>
		</select>
	</p>
    
    <p class="bordercheck half_left second_half">
		<label for="promoBoxbordercolor"><?php _e('Border color :', 'rehub_framework') ;?></label>
        <select id="promoBoxbordercolor" name="promoBoxbordercolor">
			<option value="#dddddd"><?php _e('grey', 'rehub_framework') ;?></option>			
			<option value="#fb7203"><?php _e('orange', 'rehub_framework') ;?></option>
            <option value="#000000"><?php _e('black', 'rehub_framework') ;?></option>
		</select>
	</p>
	<div class="clear"></div>
    
    <p>
		<label for="promoBoxhighlightcheck"><?php _e('Show highlight border?', 'rehub_framework') ;?> </label>
		<input id="promoBoxhighlightcheck" name="promoBoxhighlightcheck" type="checkbox" class="checks" value="true" />
	</p>
    
    <p class="highlightcheck half_left">
		<label for="promoBoxhighlightcolor"><?php _e('Highlight color :', 'rehub_framework') ;?></label>
        <select id="promoBoxhighlightcolor" name="promoBoxhighlightcolor">
            <option value="#fb7203"><?php _e('orange', 'rehub_framework') ;?></option>			
            <option value="#dddddd"><?php _e('grey', 'rehub_framework') ;?></option>			
            <option value="#000000"><?php _e('black', 'rehub_framework') ;?></option>
		</select>
	</p>
    
    <p class="highlightcheck half_left second_half">
		<label for="promoBoxhighlightpos"><?php _e('Highlight position :', 'rehub_framework') ;?></label>
        <select id="promoBoxhighlightpos" name="promoBoxhighlightpos">
            <option value="left"><?php _e('left', 'rehub_framework') ;?></option>			
            <option value="top"><?php _e('top', 'rehub_framework') ;?></option>			
            <option value="right"><?php _e('right', 'rehub_framework') ;?></option>
            <option value="bottom"><?php _e('bottom', 'rehub_framework') ;?></option>
		</select>
	</p>
    <div class="clear"></div>
   <p>
		<label for="promoBoxbtn"><?php _e('Show button?', 'rehub_framework') ;?></label>
		<input id="promoBoxbtn" name="promoBoxbtn" type="checkbox" class="checks" value="false" />
	</p>

    <p class="btncheck">
		<label for="promoBoxbtnlink"><?php _e('Button link :', 'rehub_framework') ;?></label>
		<input id="promoBoxbtnlink" name="promoBoxbtnlink" type="text" value="" />
	</p> 
    
    <p class="btncheck">
		<label for="promoBoxbtntext"><?php _e('Button text :', 'rehub_framework') ;?></label>
		<input id="promoBoxbtntext" name="promoBoxbtntext" type="text" value="Purchase Now" />
	</p>   

	<p>
		<label for="promoBoxtitle"><?php _e('Title of box :', 'rehub_framework') ;?></label>
		<input id="promoBoxtitle" name="promoBoxtitle" type="text" value="" />
	</p>
    
    	<p>
		<label for="promoBoxcontent"><?php _e('Box content :', 'rehub_framework') ;?></label>
		<textarea id="promoBoxcontent" name="promoBoxcontent" type="text" col="10" value=""></textarea>
	</p>
	 <p>
        <label>&nbsp;</label>
        <input type="button" id="submit" class="button" value="<?php _e('Insert', 'rehub_framework') ;?>" name="submit" />
    </p>
</form>