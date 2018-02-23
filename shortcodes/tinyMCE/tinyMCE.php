<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WPS_Shortcode
{
	function __construct() {
		add_action( 'admin_init', array( $this, 'action_admin_init' ) );
	}
	
	function action_admin_init() {
		// only hook up these filters if we're in the admin panel, and the current user has permission
		// to edit posts and pages
		if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {
			add_filter( 'mce_buttons_3', array( $this, 'filter_mce_button' ) );
			add_filter( 'mce_external_plugins', array( $this, 'filter_mce_plugin' ) );
			add_action('media_buttons_context',  array( $this, 'add_my_custom_button' ));
			add_action( 'admin_footer', array( $this, 'wpsm_generator_popup' ));
			add_action( 'wp_ajax_shortcode_generate', array( $this, 'ajax_shortcode_generate' ) );
		}
	}
	
	function filter_mce_button( $buttons ) {
		// add a separation before our button, here our button's id is "kt_shortcode_button"
		array_push(
				$buttons,
				"toplist",	
				"contents",
				"sticky",				
				"linkhider",	
				"update",
				"award"
			); 
			return $buttons;
	}
	
	function filter_mce_plugin( $plugins ) {
		// this plugin file will work the magic of our button
		$plugins['wpsm_shortcode'] = get_template_directory_uri(). '/shortcodes/tinyMCE/tinyMCE_script.js';
		return $plugins;
	}

	function add_my_custom_button( ) {
		echo '<a href="#TB_inline?width=590&height=500&inlineId=wpsm-generator-wrap" class="thickbox button" title="WPS shortcode generator"><img src="'.get_template_directory_uri().'/shortcodes/icon.png" style="padding-bottom:3px" /></a>';
	}


	function wpsm_generator_popup() {
		?>
         <?php wp_enqueue_script('jquery'); ?>
		<div id="wpsm-generator-wrap" style="display:none">
        <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/shortcodes/tinyMCE/tinyMCE.css" />
        <script data-cfasync="false" src="<?php echo get_template_directory_uri(); ?>/shortcodes/tinyMCE/jquery.selection.js"></script>        
		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/jsonids/css/token-input.css" />
		<script data-cfasync="false" src="<?php echo get_template_directory_uri(); ?>/jsonids/js/jquery.tokeninput.min.js"></script>         
			<?php 
			$ajaxs_nonce = wp_create_nonce( "shortcodename" );
			echo '
			<script>
			 jQuery(document).ready(function($){
				//select shortcode
				$("#select-shortcode").change(function () {
					  var shortcodeName = "";
					  var shortcodeSelectText = "";
					  $("#select-shortcode option:selected").each(function () {
							shortcodeName += $(this).val();
							shortcodeSelectText += $(this).text();
						  });
						  if( shortcodeName != "none") {
							$("#shortcode-content").load(ajaxurl + "?action=shortcode_generate&security='.$ajaxs_nonce.'&shortcode_name=" + shortcodeName, function(){
								$(".shortcode-title").text(shortcodeSelectText + " '.__('Shortcode Generator', 'rehub_framework').'");
							});
						  } else {
						  	$("#shortcode-content").text("'.__('Select your shortcode above to get started', 'rehub_framework').'").addClass("padding-bottom");
							$(".shortcode-title").text("'.__('Shortcode Generator', 'rehub_framework').'");
						  }
					})
					.trigger("change");
			 });
			</script>' ?>
			<div id="mainbox">
			<div class="inner-wpsm-shortcode">	
				<form action="/" method="get" accept-charset="utf-8">
					<ul class="form_table head">
						<li>
							<label><strong><?php _e('Select shortcode', 'rehub_framework') ;?></strong></label>
							<span><select name="select-shortcode" id="select-shortcode">
							<option value="none" selected="selected"><?php _e('Select shortcode', 'rehub_framework') ;?></option>
							<option value="none" class="shortcode_titles"><?php _e('Elements and typography', 'rehub_framework') ;?></option>
							<option class="shortcode_option" value="button"><?php _e('Button', 'rehub_framework') ;?></option>
							<option class="shortcode_option" value="affbutton"><?php _e('Affiliate Button', 'rehub_framework') ;?></option>
							<option class="shortcode_option" value="highlight"><?php _e('Highlight', 'rehub_framework') ;?></option>	
							<option class="shortcode_option" value="quote"><?php _e('Quote', 'rehub_framework') ;?></option>
							<option class="shortcode_option" value="dropcap"><?php _e('Dropcap', 'rehub_framework') ;?></option>
							<option class="shortcode_option" value="testimonial"><?php _e('Testimonial', 'rehub_framework') ;?></option>
							<option class="shortcode_option" value="list"><?php _e('List', 'rehub_framework') ;?></option>
							<option class="shortcode_option" value="tooltip"><?php _e('Tooltip', 'rehub_framework') ;?></option>	
							<option class="shortcode_option" value="divider"><?php _e('Divider', 'rehub_framework') ;?></option>																				
							<option class="shortcode_option" value="column"><?php _e('Columns', 'rehub_framework') ;?></option>
							<option class="shortcode_option" value="numberheading"><?php _e('Numbered Headings', 'rehub_framework') ;?></option>
							<option value="none" class="shortcode_titles"><?php _e('Boxes', 'rehub_framework') ;?></option>							
							<option class="shortcode_option" value="box"><?php _e('Box', 'rehub_framework') ;?></option>
                            <option class="shortcode_option" value="promobox"><?php _e('Promobox', 'rehub_framework') ;?></option>	
							<option class="shortcode_option" value="numberbox"><?php _e('Box with number', 'rehub_framework') ;?></option>
							<option class="shortcode_option" value="titlebox"><?php _e('Box with title', 'rehub_framework') ;?></option> 
							<option class="shortcode_option" value="codebox"><?php _e('Code box', 'rehub_framework') ;?></option>
							<option class="shortcode_option" value="cartbox"><?php _e('Card Box', 'rehub_framework') ;?></option>
							<option class="shortcode_option" value="itinerary"><?php _e('Itinerary (timeline) box', 'rehub_framework') ;?></option>								
							<option class="shortcode_option" value="offerbox"><?php _e('Offer box', 'rehub_framework') ;?></option>
							<option class="shortcode_option" value="reviewbox"><?php _e('Review box', 'rehub_framework') ;?></option>							
							<option class="shortcode_option" value="offerscorebox"><?php _e('Post/Product offer scorebox', 'rehub_framework') ;?></option>	
							<option class="shortcode_option" value="reviewlistbox"><?php _e('Review list boxes', 'rehub_framework') ;?></option>													
							<option class="shortcode_option" value="woobox"><?php _e('Woocommerce Offer box', 'rehub_framework') ;?></option>
							<option class="shortcode_option" value="woolist"><?php _e('Woocommerce Offers list', 'rehub_framework') ;?></option>
							<option class="shortcode_option" value="woocompare"><?php _e('Woocommerce Comparison list', 'rehub_framework') ;?></option>							
							<option class="shortcode_option" value="proscons"><?php _e('Pros Cons box', 'rehub_framework') ;?></option>														
							<option class="shortcode_option" value="colortable"><?php _e('Table with color header', 'rehub_framework') ;?></option>
							<option value="none" class="shortcode_titles"><?php _e('Media', 'rehub_framework') ;?></option>
							<option class="shortcode_option" value="video"><?php _e('Video', 'rehub_framework') ;?></option>
							<option class="shortcode_option" value="lightbox"><?php _e('Lightbox', 'rehub_framework') ;?></option>
							<option class="shortcode_option" value="slider"><?php _e('Slider', 'rehub_framework') ;?></option>
							<option class="shortcode_option" value="postimagesslider"><?php _e('Slider from post images', 'rehub_framework') ;?></option>
							<option class="shortcode_option" value="recentpostcarousel"><?php _e('Carousel of recent posts', 'rehub_framework') ;?></option>	
							<option class="shortcode_option" value="gallerycarousel"><?php _e('Gallery carousel', 'rehub_framework') ;?></option>																				
							<option value="none" class="shortcode_titles"><?php _e('Interactive', 'rehub_framework') ;?></option>
							<option class="shortcode_option" value="accordion"><?php _e('Accordion', 'rehub_framework') ;?></option>
							<option class="shortcode_option" value="tabs"><?php _e('Tabs', 'rehub_framework') ;?></option>
							<option class="shortcode_option" value="toggle"><?php _e('Toggle', 'rehub_framework') ;?></option>
							<option class="shortcode_option" value="bars"><?php _e('Bar with percentage', 'rehub_framework') ;?></option>
							<option class="shortcode_option" value="compare-bars"><?php _e('Compare Bars', 'rehub_framework') ;?></option>								
							<option class="shortcode_option" value="countdown"><?php _e('Countdown', 'rehub_framework') ;?></option>
							<option value="none" class="shortcode_titles"><?php _e('Functions', 'rehub_framework') ;?></option>
							<option class="shortcode_option" value="categorizator"><?php _e('Categories directory', 'rehub_framework') ;?></option>
							<option class="shortcode_option" value="recentpostlist"><?php _e('List of recent posts', 'rehub_framework') ;?></option>
							<option class="shortcode_option" value="map"><?php _e('Google map', 'rehub_framework') ;?></option>
							<option class="shortcode_option" value="price"><?php _e('Price Table', 'rehub_framework') ;?></option>
							<option class="shortcode_option" value="rss"><?php _e('RSS grabber', 'rehub_framework') ;?></option>
							<option class="shortcode_option" value="membercontent"><?php _e('Content for members', 'rehub_framework') ;?></option>						

							</select></span>
							<div class="clear"></div>
						</li>
					</ul>
				</form>	
				<div id="wpsm-generator-settings">
					<h3 class="shortcode-title"></h3>
					<div id="shortcode-content"></div>
				</div>
			</div>
			</div>
        </div>

		<?php
	}

	function ajax_shortcode_generate() {
		check_ajax_referer( 'shortcodename', 'security' );
		$shortcode_name = sanitize_text_field($_GET['shortcode_name']);
		$shortcode_content = rh_locate_template( 'shortcodes/tinyMCE/includes/'. $shortcode_name .'.php' );
		
		if ( $shortcode_content ) {
			load_template( $shortcode_content );
		} else {
			printf( '<span style="color:red">%s</span>', __( 'The shortcode file not found!', 'rehub_framework' ) );
		}
		wp_die();
	}

}

$wpsm_shortcode = new WPS_Shortcode();

?>