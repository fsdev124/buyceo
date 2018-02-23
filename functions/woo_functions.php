<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php
// Woo custom widget
include (locate_template( 'inc/widgets/woocategory.php' ));

//CREATE BRAND TAXONOMY
include( 'woo_store_taxonomy_class.php' );

//////////////////////////////////////////////////////////////////
// WooCommerce css
//////////////////////////////////////////////////////////////////
add_filter( 'woocommerce_enqueue_styles', '__return_false' );

//////////////////////////////////////////////////////////////////
// Display number products per page.
//////////////////////////////////////////////////////////////////
if(rehub_option('woo_number') == '16') {
	add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 16;' ), 20 );
}
elseif(rehub_option('woo_number') == '24') {
	add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 24;' ), 20 );
}
else {
	add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 12;' ), 20 );	
}

add_action('woocommerce_before_shop_loop', 'rehub_woocommerce_wrapper_start3', 33);
function rehub_woocommerce_wrapper_start3() {
  echo '<div class="clear"></div>';
}

remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
//remove_action( 'woocommerce_single_product_summary', array('WC_Structured_Data', 'generate_product_data'), 60 );

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

add_action( 'woocommerce_checkout_before_customer_details', 'rehub_woo_before_checkout' );
add_action( 'woocommerce_checkout_after_customer_details', 'rehub_woo_average_checkout' );
add_action( 'woocommerce_checkout_after_order_review', 'rehub_woo_after_checkout' );
add_action( 'woocommerce_after_add_to_cart_button', 'rehub_woo_countdown' );
add_action( 'woocommerce_product_query', 'rh_change_product_query', 99 ); //Here we change and extend product loop data

add_filter( 'woocommerce_breadcrumb_defaults', 'rh_change_breadcrumb_delimiter' );
function rh_change_breadcrumb_delimiter( $defaults ) {
	// Change the breadcrumb delimeter from '/' to '>'
	$defaults['delimiter'] = '<span class="delimiter"><i class="fa fa-angle-right"></i></span>';
	return $defaults;
}

if (defined('wcv_plugin_dir')) {	
	if ( class_exists( 'WCVendors_Pro' ) ) {
		remove_action( 'woocommerce_before_single_product', array($wcvendors_pro->wcvendors_pro_vendor_controller, 'store_single_header'));		
		remove_action( 'woocommerce_after_shop_loop_item', array('WCV_Vendor_Shop', 'template_loop_sold_by'), 9 );
		remove_action( 'woocommerce_product_meta_start', array( 'WCV_Vendor_Cart', 'sold_by_meta' ), 10, 2 );
		add_action( 'rehub_vendor_show_action', array('WCV_Vendor_Shop', 'template_loop_sold_by'), 9);
		add_action( 'wcvendors_settings_before_form', 'rh_show_gmw_form_before_wcvendor');
	}
	else{
		add_action('wcvendors_before_dashboard', 'rehub_woo_wcv_before_dash');
		add_action('wcvendors_after_dashboard', 'rehub_woo_wcv_after_dash');
		remove_action( 'woocommerce_before_single_product', array('WCV_Vendor_Shop', 'vendor_mini_header'));
		remove_action( 'woocommerce_after_shop_loop_item', array('WCV_Vendor_Shop', 'template_loop_sold_by'), 9 );
		remove_action( 'woocommerce_product_meta_start', array( 'WCV_Vendor_Cart', 'sold_by_meta' ), 10, 2 );
		add_action( 'rehub_vendor_show_action', array('WCV_Vendor_Shop', 'template_loop_sold_by'), 9);
	}
	remove_action( 'woocommerce_before_main_content', array('WCV_Vendor_Shop', 'vendor_main_header'), 20 );
	remove_action( 'woocommerce_before_main_content', array('WCV_Vendor_Shop', 'shop_description'), 30 );
	if( !class_exists('WCVendors_Pro') && class_exists('WC_Vendors') ) {
		require_once ( locate_template( 'inc/wcvendor/wc-vendor-free-brand/class-shop-branding.php' ) );
	}	
} 


if (class_exists('WCMp')){
	add_action( 'init', 'wcmp_remove_rh_hook_vendor', 11 );
	add_action( 'rehub_vendor_show_action', 'wcmprh_loop_sold_by' );
	function wcmp_remove_rh_hook_vendor(){
   		global $WCMp;
   		remove_action( 'woocommerce_product_meta_start', array( $WCMp->vendor_caps, 'wcmp_after_add_to_cart_form' ), 25);
   		remove_action( 'woocommerce_after_shop_loop_item_title', array( $WCMp->vendor_caps, 'wcmp_after_add_to_cart_form' ), 30);
   		remove_action( 'woocommerce_after_shop_loop', array( $WCMp->review_rating, 'wcmp_seller_review_rating_form' ), 30);   		
   		   
	}
	function wcmprh_loop_sold_by() {
		$vendor_id = get_the_author_meta( 'ID' );
		$is_vendor = is_user_wcmp_vendor( $vendor_id );
		if($is_vendor){
			$vendorobj = get_wcmp_vendor($vendor_id);
			$store_url = $vendorobj->permalink;
			$store_name = get_user_meta($vendor_id, '_vendor_page_title', true); 
		}
		$wcmp_option = get_option("wcmp_frontend_settings_name");
		$sold_by_label = (!empty($wcmp_option['sold_by_text'])) ? $wcmp_option['sold_by_text'] : __( 'Sold by', 'rehub_framework' );		
		$sold_by = $is_vendor
			? sprintf( '<a href="%s">%s</a>', $store_url, esc_html( $store_name ) )
			: get_bloginfo( 'name' );		

		?>
		<small class="wcvendors_sold_by_in_loop"><span><?php echo $sold_by_label ?></span> <?php echo $sold_by; ?></small><br />
		<?php
	}

}

//Change position of YITH Buttons
if ( defined( 'YITH_WCWL' )){
	add_filter('yith_wcwl_positions', 'rh_wishlist_change_position');
	function rh_wishlist_change_position($so_array=array()){
        $so_array   =   array(
            "shortcode" => array('hook'=>'shortcode', 'priority'=>0),
            "add-to-cart"=> array('hook'=>'shortcode', 'priority'=>0),
            "thumbnails"=> array('hook'=>'shortcode', 'priority'=>0),
            "summary"=> array('hook'=>'shortcode', 'priority'=>0),
        );
	    return $so_array;
	}	
}
if ( class_exists('YITH_Woocompare_Frontend')){
	//$frontend = new YITH_Woocompare_Frontend();
	global $yith_woocompare;
	remove_action( 'woocommerce_single_product_summary', array( $yith_woocompare->obj , 'add_compare_link' ), 35 );
}

function rehub_woo_before_checkout() {
	echo '<div class="re_woocheckout_details">';
}
function rehub_woo_average_checkout() {
	echo '</div><div class="re_woocheckout_order">';
}
function rehub_woo_after_checkout() {
	echo '</div>';
}
function rehub_woo_wcv_before_dash() {
	echo '<div class="rh_wcv_dashboard_page">';
}
function rehub_woo_wcv_after_dash() {
	echo '</div>';
}

if (!function_exists('rh_woo_code_zone')){
function rh_woo_code_zone($zone='button'){
	if($zone == 'button'){
		global $post;
        $code_incart = get_post_meta($post->ID, 'rh_code_incart', true );
        if ( !empty($code_incart)) {
            echo '<div class="rh_woo_code_zone_button">';
            echo do_shortcode($code_incart);
            echo '</div>';
        }else{
	    	$code_incart = rehub_option('woo_code_zone_button');
	    	if ( !empty($code_incart)) {
	        	echo '<div class="rh_woo_code_zone_button">';
	        	echo do_shortcode($code_incart);
	        	echo '</div>'; 
	        }
        }       		
	}elseif($zone =='content'){
		global $post;
		$code_in_content = get_post_meta($post->ID, 'rehub_woodeals_short', true );
	    if(!empty ($code_in_content)){
	    	echo '<div class="rh_woo_code_zone_content">';
	    		echo do_shortcode($code_in_content);
	    	echo '</div>';
	    }else{
	    	$code_in_content = rehub_option('woo_code_zone_content');
	    	if ( !empty($code_in_content)) {
		    	echo '<div class="rh_woo_code_zone_content">';
		    		echo do_shortcode($code_in_content);
		    	echo '</div>';
	    	}	    	
	    }	    		
	}
	elseif($zone =='bottom'){
		global $post;
		$code_bottom = get_post_meta($post->ID, 'woo_code_zone_footer', true );
	    if(!empty ($code_bottom)){
	    	echo '<div class="rh_woo_code_zone_bottom">';
	    		echo do_shortcode($code_bottom);
	    	echo '</div>';
	    }else{
	    	$code_bottom = rehub_option('woo_code_zone_footer');
	    	if ( !empty($code_bottom)) {
		    	echo '<div class="rh_woo_code_zone_bottom">';
		    		echo do_shortcode($code_bottom);
		    	echo '</div>';
	    	}		    	
	    } 		
	}	
} 
} 

if (!function_exists('woo_ce_video_output')){
function woo_ce_video_output(){
	echo do_shortcode('[content-egg module=Youtube template=custom/slider]' );
}}

if (!function_exists('woo_ce_news_output')){
function woo_ce_news_output(){
	echo do_shortcode('[content-egg module=GoogleNews template=custom/grid]' );
}}

if (!function_exists('woo_ce_history_output')){
function woo_ce_history_output(){
	echo do_shortcode('[content-egg-block template=custom/all_pricehistory_full]' );
}}

if (!function_exists('woo_photo_booking_out')){
function woo_photo_booking_out(){
	global $product;	
	$attachment_ids = $product->get_gallery_image_ids();
	$galleryids = implode(',', $attachment_ids);
	echo '<div class="rh-woo-section-title"><h2 class="rh-heading-icon">'.__('Photos', 'rehub_framework').': <span class="rh-woo-section-sub">'.get_the_title().'</span></h2></div>';
	echo rh_get_post_thumbnails(array('galleryids' => $galleryids, 'columns' => 4, 'height' => 150));
}}


if (!function_exists('rehub_woo_countdown')){
function rehub_woo_countdown(){
	global $post;
	$endshedule = get_post_meta($post->ID, '_sale_price_dates_to', true );	
	if($endshedule){
		$endshedule = date_i18n( 'Y-m-d', $endshedule );
		$countdown = explode('-', $endshedule);
		$year = $countdown[0];
		$month = $countdown[1];
		$day  = $countdown[2];
		$startshedule = get_post_meta($post->ID, '_sale_price_dates_from', true );
		if ($startshedule){			
			$startshedule = strtotime(date_i18n( 'Y-m-d', $startshedule )); 
			$current = time();
			if($startshedule > $current){
				return;
			}
		}
		echo wpsm_countdown(array('year'=> $year, 'month'=>$month, 'day'=>$day));
	}
	else {
		$rehub_woo_expiration = get_post_meta( $post->ID, 'rehub_woo_coupon_date', true );
		if ($rehub_woo_expiration){
			$countdown = explode('-', $rehub_woo_expiration);
			$year = $countdown[0];
			$month = $countdown[1];
			$day  = $countdown[2];	
			echo wpsm_countdown(array('year'=> $year, 'month'=>$month, 'day'=>$day));		
		}
	}	
} 
} 

function rh_show_gmw_form_before_wcvendor(){
	if ( class_exists( 'GMW_Members_Locator_Component' ) ) {
		echo rh_add_map_gmw(array());
		echo '<div class="mb25"></div>';
	}
}


//////////////////////////////////////////////////////////////////
// Woo default thumbnail
//////////////////////////////////////////////////////////////////
add_filter('woocommerce_placeholder_img_src', 'rehub_woocommerce_placeholder_img_src');
function rehub_woocommerce_placeholder_img_src( $src ) {
	global $post;
	if (is_object($post)) {
		if (get_post_meta($post->ID, 'rehub_woo_coupon_code', true) !=''){
			$src = get_template_directory_uri() . '/images/default/woocouponph.png';
		}
		elseif (get_post_meta($post->ID, '_sale_price', true) !=''){
			$src = get_template_directory_uri() . '/images/default/woodealph.png';
		}
		else {
			$src = get_template_directory_uri() . '/images/default/wooproductph.png';
		} 
	}
	else {
		$src = get_template_directory_uri() . '/images/default/wooproductph.png';
	}	
	return $src;
}

//////////////////////////////////////////////////////////////////
// Woo update cart in header
//////////////////////////////////////////////////////////////////
if (rehub_option('woo_cart_place') =='1' || rehub_option('woo_cart_place') =='2' || rehub_option('rehub_header_style') =='header_seven'){
	add_filter('woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');
	if( !function_exists('woocommerce_header_add_to_cart_fragment') ) { 
	function woocommerce_header_add_to_cart_fragment( $fragments ) {
		global $woocommerce;
		ob_start();
		?>
		<?php if (rehub_option('woo_cart_place') =='1'):?>
			<a class="cart-contents cart_count_<?php echo $woocommerce->cart->cart_contents_count; ?>" href="<?php echo wc_get_cart_url(); ?>"><i class="fa fa-shopping-cart"></i> <?php _e( 'Cart', 'rehub_framework' ); ?> (<?php echo $woocommerce->cart->cart_contents_count; ?>) - <?php echo $woocommerce->cart->get_cart_total(); ?></a>		
		<?php elseif (rehub_option('woo_cart_place') =='2' || rehub_option('rehub_header_style') =='header_seven'):?>
			<a class="rh-flex-center-align rh_woocartmenu-link icon-in-main-menu menu-item-one-line cart-contents cart_count_<?php echo $woocommerce->cart->cart_contents_count; ?>" href="<?php echo wc_get_cart_url(); ?>"><span class="rh_woocartmenu-icon"><strong><?php echo $woocommerce->cart->cart_contents_count;?></strong><span class="rh_woocartmenu-icon-handle"></span></span><span class="rh_woocartmenu-amount"><?php echo $woocommerce->cart->get_cart_total();?></span></a>
		<?php endif;?>
		<?php
		$fragments['a.cart-contents'] = ob_get_clean();
		return $fragments;
	}
	}	
}


//////////////////////////////////////////////////////////////////
// Redirect Vendors to Vendor Dashboard on Login
//////////////////////////////////////////////////////////////////
if (rehub_option('rehub_wcv_dash_redirect') == 1){
	add_filter('woocommerce_login_redirect', 'rh_wcv_login_redirect', 10, 2);
	function rh_wcv_login_redirect( $redirect_to, $user ) {
		if( class_exists( 'WeDevs_Dokan' ) ){
			$redirect_to = dokan_get_navigation_url();
		}
	    elseif (class_exists('WCV_Vendors') && class_exists('WCVendors_Pro') && WCV_Vendors::is_vendor( $user->id ) ) {
	        $redirect_to = get_permalink(WCVendors_Pro::get_option( 'dashboard_page_id' ));
	    }
	    elseif (class_exists('WCV_Vendors') && WCV_Vendors::is_vendor( $user->id ) ) {
	    	$redirect_to = get_permalink(WC_Vendors::$pv_options->get_option( 'vendor_dashboard_page' ));
	    }
	    elseif (class_exists('WCMp') && is_user_wcmp_vendor( $user->id) ) {
			$wcmp_option = get_option("wcmp_vendor_general_settings_name");
			$dashlink = (!empty($wcmp_option['wcmp_vendor'])) ? $wcmp_option['wcmp_vendor'] : '';        		
    		if ($dashlink > 0){
        		$redirect_to = get_permalink($dashlink); 
    		}
	    }	    
	    return $redirect_to;
	}
}


//////////////////////////////////////////////////////////////////
// Add the Meta Box to woocommerce for using coupons
//////////////////////////////////////////////////////////////////
add_action( 'woocommerce_product_options_pricing', 'show_rehub_woo_meta_box_inner' );

// Field Array
$wooprefixrehub = 'rehub_woo_coupon_';
$woo_custom_meta_fields = array(
    array(
        'label'=>  __('Set coupon code', 'rehub_framework'),
        'desc'  => __('Set coupon code or leave blank', 'rehub_framework'),
        'id'    => $wooprefixrehub.'code',
        'type'  => 'text'
    ),
	array(
	    'label' => __('Offer End Date', 'rehub_framework'),
	    'desc'  => __('Choose expiration date of product or leave blank', 'rehub_framework'),
	    'id'    => $wooprefixrehub.'date',
	    'type'  => 'date'
	),    
    array(
        'label'=> __('Mask coupon code?', 'rehub_framework'),
        'desc'  => __('If this option is enabled, coupon code will be hidden.', 'rehub_framework'),
        'id'    => $wooprefixrehub.'mask',
        'type'  => 'checkbox'
    ),
    array(
        'label'=> __('Offer is expired?', 'rehub_framework'),
        'desc'  => __('This option depends on expiration date, but you can also enable expiration manually if you check this', 'rehub_framework'),
        'id'    => 're_post_expired',
        'type'  => 'checkbox'
    ),     
    array(
        'label'=> __('Brand logo url', 'rehub_framework'),
        'desc'  => __('Fallback for brand logo (better to add brand logo in Affiliate store fields)', 'rehub_framework'),
        'id'    => $wooprefixrehub.'logo_url',
        'type'  => 'text'
    ),
        
);
if(rehub_option('rehub_woo_print') =='1') {
	$woo_custom_meta_fields[] = array(
        'label'=> __('Additional coupon image url', 'rehub_framework'),
        'desc'  => __('Used for printable coupon function. To enable it, you must have any coupon code above', 'rehub_framework'),
        'id'    => $wooprefixrehub.'coupon_img_url',
        'type'  => 'text'
    );
}

add_action('admin_head','rehub_add_woo_custom_scripts',11);
if ( !function_exists( 'rehub_add_woo_custom_scripts' ) ) {
function rehub_add_woo_custom_scripts() {
    global $woo_custom_meta_fields, $post, $pagenow;
    if ( $pagenow=='post-new.php' || $pagenow=='post.php' ) {
	    if ( 'product' === $post->post_type ) { 
		    $output = '<script type="text/javascript">
		                jQuery(function() {';	                 
		    foreach ($woo_custom_meta_fields as $field) { // loop through the fields looking for certain types
		        if($field['type'] == 'date')
		            $output .= 'jQuery(".rehubdatepicker").each(function(){jQuery(this).datepicker({dateFormat: "yy-mm-dd"});});';
		    };	     
		    $output .= '});
		        </script>';	         
		    echo $output;
		}
	    if ( 'post' === $post->post_type ) { //Easy woo chooser for reviews
	    	if(REHUB_NAME_ACTIVE_THEME == 'RECASH' || REHUB_NAME_ACTIVE_THEME == 'REDIRECT' ){

	    	}
	    	else{
		    	$path_script = get_template_directory_uri() . '/jsonids/json-ids.php';
	            $review_woo_link = vp_metabox('rehub_post.review_post.0.review_woo_product.0.review_woo_link');
	            $review_woo_links = vp_metabox('rehub_post.review_post.0.review_woo_list.0.review_woo_list_links');
	            if(!empty($review_woo_link)){
	            	$woobox_array = array();
					$woobox_title = get_the_title($review_woo_link);
					$woobox_array[] = array( 'id' => $review_woo_link, 'name' => $woobox_title );  		       	
	            	$wooboxpre = json_encode( $woobox_array );   
	            }
	            if(!empty($review_woo_links)){
	            	$review_woo_linkss = explode(',', $review_woo_links);
	            	$woolist_array = array();
					foreach($review_woo_linkss as $review_woo_linksid){
						$woolist_title = get_the_title($review_woo_linksid);
						$woolist_array[] = array( 'id' => $review_woo_linksid, 'name' => $woolist_title );
					}  		       	
	            	$woolistpre = json_encode( $woolist_array );   
	            }            
	            $wooboxprep = (!empty($wooboxpre)) ? $wooboxpre : 'null';	
	            $woolistprep = (!empty($woolistpre)) ? $woolistpre : 'null';    	
			    $output = '
			    <link rel="stylesheet" href="'.get_template_directory_uri().'/jsonids/css/token-input.css" />
			    <script data-cfasync="false" src="'.get_template_directory_uri().'/jsonids/js/jquery.tokeninput.min.js"></script>         
			    <script data-cfasync="false">
					jQuery(function () {
						jQuery("input[name=\"rehub_post[review_post][0][review_woo_product][0][review_woo_link]\"]").tokenInput("'.$path_script.'", { 
							minChars: 3,
							preventDuplicates: true,
							theme: "rehub",
							prePopulate: '.$wooboxprep.',
							tokenLimit: 1,
							onSend: function(params) {
								params.data.posttype = "product";
								params.data.postnum = 5;
							}
						});
						jQuery("input[name=\"rehub_post[review_post][0][review_woo_list][0][review_woo_list_links]\"]").tokenInput("'.$path_script.'", { 
							minChars: 3,
							preventDuplicates: true,
							theme: "rehub",
							prePopulate: '.$woolistprep.',
							onSend: function(params) {
								params.data.posttype = "product";
								params.data.postnum = 5;
							}
						});					
					});
				</script>';	         
			    echo $output;
	    	}
		}		
	}
}
}

// The Callback for external products
function show_rehub_woo_meta_box_inner() {
global $woo_custom_meta_fields, $post;
// Use nonce for verification
echo '<input type="hidden" name="custom_woo_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
     
    // Begin the field table and loop
    echo '<div class="options_group show_if_external">';
    foreach ($woo_custom_meta_fields as $field) {
        // get value of this field if it exists for this post
        $meta = get_post_meta($post->ID, $field['id'], true);
        // begin a table row with
        echo '<p class="form-field rh_woo_meta_'.$field['id'].'">
                <th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
                <td>';
                switch($field['type']) {
                    // text
					case 'text':
					    echo '<input class="short" type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="70" />
					        <span class="description">'.$field['desc'].'</span>';
					break;
					case 'textbox':
					    echo '<textarea cols=20 rows=2 class="short" name="'.$field['id'].'" id="'.$field['id'].'">'.$meta.'</textarea>
					        <span class="description">'.$field['desc'].'</span>';
					break;					
					// checkbox
					case 'checkbox':
					    echo '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" ',$meta ? ' checked="checked"' : '','/>
					        <span class="description">'.$field['desc'].'</span>';
					break;
					// date
					case 'date':
						echo '<input class="short rehubdatepicker" type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="70" />
								<span class="description">'.$field['desc'].'</span>';
					break;															
                } //end switch
        echo '</p>';
    } // end foreach
    echo '</div>'; // end table
    woocommerce_wp_textarea_input( array( 'id' => 'rh_code_incart', 'class' => 'short', 'label' => __( 'Custom shortcode', 'rehub_framework' ), 'description' => __( 'Will be rendered near button', 'rehub_framework' )  ));
    woocommerce_wp_textarea_input( array( 'id' => 'rehub_woodeals_short', 'class' => 'short', 'label' => __( 'Custom shortcode', 'rehub_framework' ), 'description' => __( 'Will be rendered before Content', 'rehub_framework' )  ));
    woocommerce_wp_textarea_input( array( 'id' => 'woo_code_zone_footer', 'class' => 'short', 'label' => __( 'Custom shortcode', 'rehub_framework' ), 'description' => __( 'Will be rendered before Footer', 'rehub_framework' )  ));        
}

//Add meta panel with Product layouts
function add_rehub_woo_metabox() {   
    add_meta_box(
        'product_rh_woo', // $id
        'Product Layout', // $title 
        'show_rehub_woo_meta_box_side', // $callback
        array('product'),
        'side', // $context
        'high'); // $priority
}
add_action('add_meta_boxes', 'add_rehub_woo_metabox');

function show_rehub_woo_meta_box_side(){
	global $post;
	$meta = get_post_meta($post->ID, '_rh_woo_product_layout', true);
	echo '<select name="_rh_woo_product_layout" id="_rh_woo_product_layout" style="width:100%; margin: 10px 0">'; 
		$product_layouts = apply_filters( 'rehub_product_layout_array', array(
			'global' => __('Global from Theme option - Shop', 'rehub_framework'),
			'default_sidebar' => __('Default with sidebar', 'rehub_framework'), 
			'default_no_sidebar' => __('Default full width', 'rehub_framework'),
			'full_width_extended' => __('Full width Extended', 'rehub_framework'),
			'sections_w_sidebar' => __('Sections with sidebar', 'rehub_framework'),
			'ce_woo_list' => __('Content Egg List', 'rehub_framework'),
			'ce_woo_sections' => __('Content Egg Auto Sections', 'rehub_framework'),
			'vendor_woo_list' => __('Compare Prices', 'rehub_framework'),
			'full_photo_booking' => __('Full width Photo (booking)', 'rehub_framework'),						
			)
		);
		foreach ($product_layouts as $key => $value) {
	    	echo '<option value="'.$key.'" '.selected($key, $meta).'>'.$value.'</option>';			
		}
    echo '</select>';
}


// Save the Data
function save_rehub_woo_custom_meta($post_id) {
    global $woo_custom_meta_fields;
     
    // verify nonce
	if ( ! isset( $_POST['custom_woo_meta_box_nonce'] ) ) {
		return $post_id;
	}
    if (!wp_verify_nonce($_POST['custom_woo_meta_box_nonce'], basename(__FILE__))) 
        return $post_id;
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;
    // check permissions
    if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
    }

    if (isset ($_POST['rh_code_incart'])) {
		$woo_custom_meta_fields[] = array(
	        'id'    => 'rh_code_incart',
	    ); 
    }

    if (isset ($_POST['_rh_woo_product_layout'])) {
		$woo_custom_meta_fields[] = array(
	        'id'    => '_rh_woo_product_layout',
	    ); 
    }       

    if (isset ($_POST['rehub_woodeals_short'])) {
		$woo_custom_meta_fields[] = array(
	        'id'    => 'rehub_woodeals_short',
	    ); 
    }  

    if (isset ($_POST['woo_code_zone_footer'])) {
		$woo_custom_meta_fields[] = array(
	        'id'    => 'woo_code_zone_footer',
	    ); 
    }        
     
    // loop through fields and save the data
    foreach ($woo_custom_meta_fields as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        if (isset ($_POST[$field['id']])) {
        	if($field['id'] == 'rh_code_incart' || $field['id'] == 'rehub_woodeals_short' || $field['id'] == 'woo_code_zone_footer'){
            	$new = $_POST[$field['id']];
        	}else{
            	$new = sanitize_text_field($_POST[$field['id']]);        		
        	}
        }
        else {
           $new =''; 
        }
        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    } // end foreach

}
add_action('save_post', 'save_rehub_woo_custom_meta');


//////////////////////////////////////////////////////////////////
//EXPIRE FUNCTION
//////////////////////////////////////////////////////////////////

add_action('woo_change_expired', 'woo_change_expired_function', 10, 1);
if (!function_exists('woo_change_expired_function')) {
function woo_change_expired_function($expired=''){
	global $post;
	$expired_exist = get_post_meta($post->ID, 're_post_expired', true);
	if($expired ==1 && $expired_exist !=1){
		update_post_meta($post->ID, 're_post_expired', 1);
	}
	elseif($expired =='' && $expired_exist == 1){
		update_post_meta($post->ID, 're_post_expired', 0);
	}	
	elseif($expired_exist==''){
		update_post_meta($post->ID, 're_post_expired', 0);
	}
}
}

add_filter( 'post_class', 're_expired_post_classes' );
function re_expired_post_classes( $classes ){
	if(is_singular('product')){
		$expired = get_post_meta(get_the_ID(), 're_post_expired', true);
		if ($expired == '1'){
			$classes[] = 're_post_expired';
		}
	}
    return $classes;
}

if ( !function_exists('rh_show_vendor_info_single') ) {
	function rh_show_vendor_info_single() {
		$vendor_verified_label = $vacation_mode = $vacation_msg = '';
		$verified_vendor = $featured_vendor = false;		
		if( class_exists( 'WeDevs_Dokan' ) ) {
			$vendor_id = get_the_author_meta( 'ID' );
			$store_info = dokan_get_store_info( $vendor_id );
			$store_url = dokan_get_store_url( $vendor_id );
			$sold_by_label = apply_filters( 'dokan_sold_by_label', __( 'Sold by', 'rehub_framework' ) );
			$is_vendor = dokan_is_user_seller( $vendor_id );
			$store_name = esc_html( $store_info['store_name'] );
			$featured_vendor = get_user_meta( $vendor_id, 'dokan_feature_seller', true );
		}elseif (class_exists('WCMp')){
			$vendor_id = get_the_author_meta( 'ID' );
			$is_vendor = is_user_wcmp_vendor( $vendor_id );
			if($is_vendor){
				$vendorobj = get_wcmp_vendor($vendor_id);
				$store_url = $vendorobj->permalink;
				$store_name = get_user_meta($vendor_id, '_vendor_page_title', true); 				
			}
			$wcmp_option = get_option("wcmp_frontend_settings_name");
			$sold_by_label = (!empty($wcmp_option['sold_by_text'])) ? $wcmp_option['sold_by_text'] : __( 'Sold by', 'rehub_framework' );
		}
		elseif (defined( 'wcv_plugin_dir' )) {
			$vendor_id = get_the_author_meta( 'ID' );
			$store_url = WCV_Vendors::get_vendor_shop_page( $vendor_id );
			$sold_by_label = WC_Vendors::$pv_options->get_option( 'sold_by_label' );
			$is_vendor = WCV_Vendors::is_vendor( $vendor_id );
			$store_name = WCV_Vendors::get_vendor_sold_by( $vendor_id );
			
			if ( class_exists( 'WCVendors_Pro' ) ) {
				$vendor_meta = array_map( function( $a ){ return $a[0]; }, get_user_meta($vendor_id ) );
				$verified_vendor = ( array_key_exists( '_wcv_verified_vendor', $vendor_meta ) ) ? $vendor_meta[ '_wcv_verified_vendor' ] : false;
				$vacation_mode = get_user_meta( $vendor_id , '_wcv_vacation_mode', true ); 
				$vacation_msg = ( $vacation_mode ) ? get_user_meta( $vendor_id , '_wcv_vacation_mode_msg', true ) : '';		
			}		
		}
		else{
			return false;
		}

		if($is_vendor){
			if ( $verified_vendor || $featured_vendor == 'yes' ) {
				$vendor_verified_label = '<i class="fa fa-check-square-o" aria-hidden="true"></i>';
			} 		
			$sold_by = sprintf( '<h5><a href="%s" class="wcvendors_cart_sold_by_meta">%s</a></h5>', $store_url, $store_name );
			
			/* HTML output */
			echo '<div class="vendor_store_details">';
			echo '<div class="vendor_store_details_image"><a href="'. $store_url  .'"><img src="'. rh_show_vendor_avatar( $vendor_id, 50, 50 ) .'" class="vendor_store_image_single" width=50 height=50 /></a></div>';
			echo '<div class="vendor_store_details_single">';
			echo '<div class="vendor_store_details_nameshop">';
			echo '<span class="vendor_store_details_label">'. $sold_by_label .'</span>';
			echo '<span class="vendor_store_details_title">'. $vendor_verified_label . $sold_by .'</span>';
			echo '</div>';

			if(class_exists( 'WeDevs_Dokan' ) && dokan_get_option( 'contact_seller', 'dokan_general', 'on' ) == 'on'){
				echo '<span class="vendor_store_details_contact">';
				echo '<span class="vendor_store_owner_label">@ <span class="vendor_store_owner_name">'.get_the_author_meta('display_name') .'</span></span>';
				$class = ( !is_user_logged_in() && rehub_option( 'userlogin_enable' ) == '1' ) ? ' act-rehub-login-popup' : '';						
				echo ' <a href="'.$store_url.'#dokan-contact-anchor" class="vendor_store_owner_contactlink'.$class.'"><i class="fa fa-envelope-o" aria-hidden="true"></i> <span>'. __('Ask owner', 'rehub_framework') .'</span></a>';									
				echo '</span>';					
			}	
			elseif(class_exists( 'BuddyPress' ) ) {
				echo '<span class="vendor_store_details_contact"><span class="vendor_store_owner_label">@ </span>';
				echo '<a href="'. bp_core_get_user_domain( $vendor_id ) .'" class="vendor_store_owner_name"><span>'. get_the_author_meta('display_name') .'</span></a> ';
				if ( bp_is_active( 'messages' )){
					$link = (is_user_logged_in()) ? wp_nonce_url( bp_loggedin_user_domain() . bp_get_messages_slug() . '/compose/?r=' . bp_core_get_username( $vendor_id) .'&ref='. urlencode(get_permalink())) : '#';
					$class = (!is_user_logged_in() && rehub_option('userlogin_enable') == '1') ? ' act-rehub-login-popup' : '';
						echo ' <a href="'.$link.'" class="vendor_store_owner_contactlink'.$class.'"><i class="fa fa-envelope-o" aria-hidden="true"></i> <span>'. __('Ask owner', 'rehub_framework') .'</span></a>';			
				}
				echo '</span>';		
			}
			
			echo '</div></div>';
			if ($vacation_msg) :
				echo '<div class="wpsm_box green_type nonefloat_box"><div>'. $vacation_msg .'</div></div>';
			endif;
		}
	
	}
}

if ( !function_exists('rh_show_vendor_ministore') ) {
	function rh_show_vendor_ministore( $vendor_id, $label='' ) { 
		$totaldeals = count_user_posts( $vendor_id, $post_type = 'product' );
		$vendor_verified_label = '';
		$verified_vendor = $featured_vendor = false;
		
		if( class_exists( 'WeDevs_Dokan' ) ){
			$store_url = dokan_get_store_url( $vendor_id );
			$is_vendor = dokan_is_user_seller( $vendor_id );
			$store_info = dokan_get_store_info( $vendor_id );
			$store_name = esc_html( $store_info['store_name'] );
			$featured_vendor = get_user_meta( $vendor_id, 'dokan_feature_seller', true );
		}
		else {
			$store_url = WCV_Vendors::get_vendor_shop_page( $vendor_id );
			$is_vendor = WCV_Vendors::is_vendor( $vendor_id );
			$store_name = WCV_Vendors::get_vendor_sold_by( $vendor_id );
			if ( class_exists( 'WCVendors_Pro' ) ) {
				$vendor_meta = array_map( function( $a ){ return $a[0]; }, get_user_meta($vendor_id ) );
				$verified_vendor = ( array_key_exists( '_wcv_verified_vendor', $vendor_meta ) ) ? $vendor_meta[ '_wcv_verified_vendor' ] : false;
			}
		}
		
		if( $totaldeals > 0 ){
			if ( $verified_vendor || $featured_vendor == 'yes' ) {
				$vendor_verified_label = '<i class="fa fa-check-square-o" aria-hidden="true"></i>';
			} 
			$sold_by = ( $is_vendor ) ? sprintf( '<h5><a href="%s" class="wcvendors_cart_sold_by_meta">%s</a></h5>', $store_url, $store_name ) : get_bloginfo( 'name' );
			
			/* HTML output */
			echo '<div class="vendor_store_in_bp">';
			echo '<div class="vendor-list-like">'. getShopLikeButton( $vendor_id ) .'</div>';
			echo '<div class="vendor_store_in_bp_image"><a href="'. $store_url .'"><img src="'. rh_show_vendor_avatar( $vendor_id, 80, 80 ) .'" class="vendor_store_image_single" width=80 height=80 /></a></div>';
			echo '<div class="vendor_store_in_bp_single">';
			echo '<span class="vendor_store_in_bp_label"><span class="vendor_store_owner_label">'. $label .'</span></span>';		
			echo '<span class="vendor_store_in_bp_title">'. $vendor_verified_label . $sold_by.'</span>';
			echo '</div>';
			echo '<div class="vendor_store_in_bp_last_products">';
				$totaldeals = $totaldeals - 4;
				$args = array(
					'post_type' => 'product',
					'posts_per_page' => 4,
					'author' => $vendor_id,
					'ignore_sticky_posts'=> true,
					'no_found_rows'=> true
				);
				$looplatest = new WP_Query($args);
				if ( $looplatest->have_posts() ){
					while ( $looplatest->have_posts() ) : $looplatest->the_post();
						echo '<a href="'. get_permalink( $looplatest->ID ) .'">';
							$showimg = new WPSM_image_resizer();
							$showimg->use_thumb = true;
							$showimg->height = 70;
							$showimg->width = 70;
							$showimg->crop = true;
							$showimg->no_thumb = rehub_woocommerce_placeholder_img_src('');
							$img = $showimg->get_resized_url();
							echo '<img src="'. $img .'" width=70 height=70 alt="'. get_the_title( $looplatest->ID ) .'"/>';
						echo '</a>';
					endwhile;
					echo '<a class="vendor_store_in_bp_count_pr" href="'. $store_url .'"><span>+'. $totaldeals .'</span></a>';
				}
				wp_reset_query();
			echo '</div>';
			echo '</div>';		
		}
	}
}

if ( !function_exists('rh_show_vendor_avatar') ) {
	function rh_show_vendor_avatar( $vendor_id, $width=150, $height=150 ) {
		if( !$vendor_id ) 
			return;
		$store_icon_url = '';
		if( class_exists( 'WeDevs_Dokan' ) ) {
			$store_info = dokan_get_store_info( $vendor_id );
			if( !empty( $store_info['gravatar'] ) AND $store_info['gravatar'] !=0 ) {
				$store_icon_src 	= wp_get_attachment_image_src( $store_info['gravatar'], array( 150, 150 ) );
				if ( is_array( $store_icon_src ) ) { 
					$store_icon_url = $store_icon_src[0]; 
				}			
			}
		}
		elseif (class_exists('WCMp')){
			$store_icon_url = get_user_meta($vendor_id, '_vendor_image', true);
		}		
		elseif(defined( 'wcv_plugin_dir' )) {
			if( class_exists( 'WCVendors_Pro' ) ) {
				$store_icon_src 	= wp_get_attachment_image_src( get_user_meta( $vendor_id, '_wcv_store_icon_id', true ), array( 150, 150 ) );
				if ( is_array( $store_icon_src ) ) { 
					$store_icon_url= $store_icon_src[0]; 
				}
			}
			else{
				$store_icon_src 	= wp_get_attachment_image_src( get_user_meta( $vendor_id, 'rh_vendor_free_logo', true ), array( 150, 150 ) );
				if ( is_array( $store_icon_src ) ) { 
					$store_icon_url= $store_icon_src[0]; 
				}
			}
		}
		else{
			return;
		}
		if( !$store_icon_url ) {
			if( rehub_option('wcv_vendor_avatar') !='' ){
				$store_icon_url = esc_url( rehub_option( 'wcv_vendor_avatar' ) );
			}
			else{
				$store_icon_url = get_template_directory_uri() . '/images/default/wcvendoravatar.png';
			}	
		}
		$showimg = new WPSM_image_resizer();
		$showimg->src = $store_icon_url;
		$showimg->use_thumb = false;
		$showimg->height = $height;
		$showimg->width = $width;
		$showimg->crop = true;           
		$img = $showimg->get_resized_url();
		return $img;	
	}
}

if( !function_exists( 'rh_show_vendor_bg' ) ) {
	function rh_show_vendor_bg( $vendor_id ) {
		$store_bg_styles = '';
		if( !$vendor_id )
			return;
		if( class_exists( 'WeDevs_Dokan' ) ) {
			$store_info = dokan_get_store_info( $vendor_id );
			$store_bg = wp_get_attachment_url( $store_info['banner'] );
			if( $store_bg ) {
				$store_bg_styles = 'background-image: url('. $store_bg .'); background-repeat: no-repeat;background-size: cover;';
			}
		}
		elseif (class_exists('WCMp')){
			$store_bg = get_user_meta($vendor_id, '_vendor_banner', true);
			$store_bg_styles = 'background-image: url('. $store_bg .'); background-repeat: no-repeat;background-size: cover;';
		}		
		elseif(defined( 'wcv_plugin_dir' )) {
			if ( class_exists( 'WCVendors_Pro' ) ) {
				$store_banner_src 	= wp_get_attachment_image_src( get_user_meta( $vendor_id, '_wcv_store_banner_id', true ), 'full'); 
				if ( is_array( $store_banner_src ) ) { 
					$store_bg= $store_banner_src[0]; 
				}
				else { 
					//  Getting default banner 
					$default_banner_src = WCVendors_Pro::get_option( 'default_store_banner_src' ); 
					$store_bg= $default_banner_src; 
				}	
				$store_bg_styles = 'background-image: url('.$store_bg.'); background-repeat: no-repeat;background-size: cover;';	
			}
			else {
				$store_banner_src  = wp_get_attachment_image_src( get_user_meta( $vendor_id, 'rh_vendor_free_header', true ), 'full');
				if ( is_array( $store_banner_src ) ) { 
					$store_bg= $store_banner_src[0]; 
					$store_bg_styles = 'background-image: url('.$store_bg.'); background-repeat: no-repeat;background-size: cover;';
				}
			}
		}
		else{
			return;
		}
		if( !$store_bg_styles ) {
			if( rehub_option('wcv_vendor_bg') !='' ){
				$store_bg = esc_url(rehub_option('wcv_vendor_bg'));
				$store_bg_styles = 'background-image: url('.$store_bg.'); background-repeat: no-repeat;background-size: cover;';
			}
			else{
				$store_bg_styles = 'background-image: url('.get_template_directory_uri() . '/images/default/brickwall.png); background-repeat:repeat;';
			}	
		}		
		return $store_bg_styles;	
	}
}

if (!function_exists('rh_change_product_query')){
	function rh_change_product_query($q){
    	if (empty($q->query_vars['wc_query']))
			return;
		
		$search_string = isset($_GET['rh_wcv_search']) ? esc_html($_GET['rh_wcv_search']) : '';
		$cat_string = (isset($_GET['rh_wcv_vendor_cat'])) ? esc_html($_GET['rh_wcv_vendor_cat']) : '';
		
		if($search_string){
			$q->set( 's', $search_string);
		}
		if($cat_string){
			$catarray = array(
				array(
					'taxonomy' => 'product_cat', 
					'terms' => array($cat_string), 
					'field' => 'term_id'				
					)
				);
			$q->set('tax_query', $catarray);
		}
		if (rehub_option('woo_exclude_expired') == '1') {
			//exclude from woo archives expired products
		    if (is_post_type_archive('product') || is_product_category()) {
		    	$meta_query = $q->get( 'meta_query' );
			    $meta_query[] = array(
			    	'relation' => 'OR',
			    	array(
			       		'key' => 're_post_expired',
			       		'value' => '1',
			       		'compare' => '!=',
			    	),
			    	array(
			       		'key' => 're_post_expired',
			       		'compare' => 'NOT EXISTS',
			    	),				    	 				    	   	
			    );
			    $q->set( 'meta_query', $meta_query );
			}
		}
		if (is_tax('store')){ //Here we change number of posts in brand store archives
			$q->set( 'posts_per_page', 30);
		}	
	}
}

if (rehub_option('wooregister_xprofile') == 1){

	//Synchronization with Woocommerce register form and Xprofiles
	add_action('woocommerce_register_form','rh_add_xprofile_to_woocommerce_register');
	add_action('wcvendors_settings_before_paypal','rh_add_xprofile_to_wcvendor');
	add_action('dokan_settings_form_bottom', 'rh_add_xprofile_to_dokan');

	function rh_add_xprofile_to_woocommerce_register() {
	if ( class_exists( 'BuddyPress' ) ) {
		?>
		<?php if ( bp_is_active( 'xprofile' ) ) : ?>
			<div id="xp-woo-profile-details-section"<?php if(rehub_option('wooregister_xprofile_hidename') == 1){echo ' class="xprofile_hidename"';}?>>
				<?php if ( bp_has_profile( array( 'profile_group_id' => 1, 'fetch_field_data' => false ) ) ) : while ( bp_profile_groups() ) : bp_the_profile_group(); ?>
					<?php while ( bp_profile_fields() ) : bp_the_profile_field(); ?>
						<div<?php bp_field_css_class( 'editfield form-row' ); ?>>
							<?php
								$field_type = bp_xprofile_create_field_type( bp_get_the_profile_field_type() );
								$field_type->edit_field_html();
							?>
						</div>
					<?php endwhile; ?>
					<input type="hidden" name="signup_profile_field_ids" id="signup_profile_field_ids" value="<?php bp_the_profile_field_ids(); ?>" />
				<?php endwhile; endif; ?>
				<?php do_action( 'bp_signup_profile_fields' ); ?>
			</div><!-- #profile-details-section -->
			<?php do_action( 'bp_after_signup_profile_fields' ); ?>
		<?php endif; ?>
		<?php
	}
	}

	function rh_add_xprofile_to_wcvendor() {
	if ( class_exists( 'BuddyPress' ) ) {
		?>
		<?php if ( bp_is_active( 'xprofile' ) ) : ?>
			<div id="xp-wcvendor-profile"<?php if(rehub_option('wooregister_xprofile_hidename') == 1){echo ' class="xprofile_hidename"';}?>>
				<?php $user_id = get_current_user_id();?>
				<?php if ( bp_has_profile( array( 'user_id'=> $user_id, 'profile_group_id' => 1, 'fetch_field_data' => true, 'fetch_fields'=>true ) ) ) : while ( bp_profile_groups() ) : bp_the_profile_group(); ?>
					<?php while ( bp_profile_fields() ) : bp_the_profile_field(); ?>
						<div<?php bp_field_css_class( 'editfield form-row' ); ?>>
							<?php
								$field_type = bp_xprofile_create_field_type( bp_get_the_profile_field_type() );
								$field_type->edit_field_html(array( 'user_id'=> $user_id));
							?>
						</div>
					<?php endwhile; ?>
					<input type="hidden" name="signup_profile_field_ids" id="signup_profile_field_ids" value="<?php bp_the_profile_field_ids(); ?>" />
				<?php endwhile; endif; ?>
				<?php do_action( 'bp_signup_profile_fields' ); ?>
			</div><!-- #profile-details-section -->
			<?php do_action( 'bp_after_signup_profile_fields' ); ?>
		<?php endif; ?>
		<?php
	}
	}	

	function rh_add_xprofile_to_dokan( $user_id ) {
		if ( class_exists( 'BuddyPress' ) ) {
			?>
			<?php if ( bp_is_active( 'xprofile' ) ) : ?>
			<!-- Xprofile fields -->
			<div class="dokan-form-group xprofile-area<?php if(rehub_option('wooregister_xprofile_hidename') == 1){echo ' xprofile_hidename';}?>">
			<h2><?php _e( 'Extended Profile', 'buddypress' ); ?></h2>
				<?php if ( bp_has_profile( array( 'user_id'=> $user_id, 'profile_group_id' => 1, 'hide_empty_fields' => false, 'fetch_field_data' => true, 'fetch_fields'=>true ) ) ) : ?>
					<?php while ( bp_profile_groups() ) : bp_the_profile_group(); ?>
						<?php while ( bp_profile_fields() ) : bp_the_profile_field(); ?>
						<div class="dokan-w6 dokan-text-left">
							<div <?php bp_field_css_class( 'editfield form-row' ); ?>>
								<?php
									$field_type = bp_xprofile_create_field_type( bp_get_the_profile_field_type() );
									$field_type->edit_field_html( array( 'user_id'=> $user_id ) );
								?>
								<p class="description"><?php bp_the_profile_field_description(); ?></p>
							</div>
						</div>
						<?php endwhile; ?>
						<input type="hidden" name="signup_profile_field_ids" id="signup_profile_field_ids" value="<?php bp_the_profile_field_ids(); ?>" />
					<?php endwhile; ?>
				<?php endif; ?>
				<?php do_action( 'bp_signup_profile_fields' ); ?>
			</div>
			<?php do_action( 'bp_after_signup_profile_fields' ); ?>
				<script type="text/javascript">
				jQuery('[aria-required]').each(function() {
					jQuery(this).prop('required',true);
				});
				</script>
			<?php endif; ?>
			<?php
		}
	}	

	//Validating required Xprofile fields
	add_action( 'woocommerce_register_post', 'rh_validate_xprofile_to_woocommerce_register', 10, 3 );
	function rh_validate_xprofile_to_woocommerce_register( $username, $email, $validation_errors ) {
		if ( class_exists( 'BuddyPress' ) ) {
			if (!empty($_POST['signup_profile_field_ids']) && rehub_option('wooregister_xprofile_hidename') !=1){
				$user_error_req_fields = array();
				$signup_profile_field_ids = explode(',', $_POST['signup_profile_field_ids']);
				foreach ((array)$signup_profile_field_ids as $field_id) {
					if ( ! isset( $_POST['field_' . $field_id] ) ) {
						if ( ! empty( $_POST['field_' . $field_id . '_day'] ) && ! empty( $_POST['field_' . $field_id . '_month'] ) && ! empty( $_POST['field_' . $field_id . '_year'] ) ) {
							// Concatenate the values.
							$date_value = $_POST['field_' . $field_id . '_day'] . ' ' . $_POST['field_' . $field_id . '_month'] . ' ' . $_POST['field_' . $field_id . '_year'];

							// Turn the concatenated value into a timestamp.
							$_POST['field_' . $field_id] = date( 'Y-m-d H:i:s', strtotime( $date_value ) );
							
						}
					}
					// Create errors for required fields without values.
					if ( xprofile_check_is_required_field( $field_id ) && empty( $_POST[ 'field_' . $field_id ] ) && ! bp_current_user_can( 'bp_moderate' ) ){
						$field_data = xprofile_get_field($field_id );
						if(is_object($field_data)){
							$user_error_req_fields[]= $field_data->name;
						}		
					}
				}
				if(!empty($user_error_req_fields)){
		        	$validation_errors->add( 'billing_first_name_error', __( ' Next fields are required: ', 'rehub_framework' ).implode(', ',$user_error_req_fields) );									
				}			
			}
		}	 
	    return $validation_errors;
	} 	

	//Updating use meta after registration successful registration
	add_action('woocommerce_created_customer','rh_save_xprofile_to_woocommerce_register');
	add_action( 'wcvendors_shop_settings_saved', 'rh_save_xprofile_to_woocommerce_register' );
	add_action( 'dokan_store_profile_saved', 'rh_save_xprofile_to_woocommerce_register' );
	function rh_save_xprofile_to_woocommerce_register($user_id) {
		if (!empty($_POST['signup_profile_field_ids'])){
			$signup_profile_field_ids = explode(',', $_POST['signup_profile_field_ids']);
			foreach ((array)$signup_profile_field_ids as $field_id) {
				if ( ! isset( $_POST['field_' . $field_id] ) ) {
					if ( ! empty( $_POST['field_' . $field_id . '_day'] ) && ! empty( $_POST['field_' . $field_id . '_month'] ) && ! empty( $_POST['field_' . $field_id . '_year'] ) ) {
						// Concatenate the values.
						$date_value = $_POST['field_' . $field_id . '_day'] . ' ' . $_POST['field_' . $field_id . '_month'] . ' ' . $_POST['field_' . $field_id . '_year'];

						// Turn the concatenated value into a timestamp.
						$_POST['field_' . $field_id] = date( 'Y-m-d H:i:s', strtotime( $date_value ) );
						
					}
				}
				if(!empty($_POST['field_' . $field_id])){
					$field_val = $_POST['field_' . $field_id];
					xprofile_set_field_data($field_id, $user_id, $field_val);
					$visibility_level = ! empty( $_POST['field_' . $field_id . '_visibility'] ) ? $_POST['field_' . $field_id . '_visibility'] : 'public';
					xprofile_set_field_visibility_level( $field_id, $user_id, $visibility_level );					
				}			
			}
		}
	}	
}

//////////////////////////////////////////////////////////////////
//DOKAN FUNCTIONS
//////////////////////////////////////////////////////////////////

if( class_exists( 'WeDevs_Dokan' ) ) {

	add_action('dokan_dashboard_wrap_before', 'rh_dokan_edit_page_before', 9);
	add_action('dokan_dashboard_wrap_after', 'rh_dokan_edit_page_after', 9);
	add_action('dokan_edit_product_wrap_before', 'rh_dokan_edit_page_before');
	add_action('dokan_edit_product_wrap_after', 'rh_dokan_edit_page_after');
	add_action('woocommerce_account_dashboard', 'rh_dokan_add_button_to_dash');

	if(!function_exists('rh_dokan_add_button_to_dash')){
		function rh_dokan_add_button_to_dash(){
			$user_id  = get_current_user_id();
			if(dokan_is_user_seller( $user_id )){
				$textbutton = __('Manage your shop', 'rehub_framework');
				$out = '<a href="'. dokan_get_navigation_url() .'">'. $textbutton.'</a>';
				echo apply_filters('rh_dokan_add_button_to_dash', $out);				
			}
		}		
	}

	
	function rh_dokan_edit_page_before(){
		echo '<div class="rh-container">';
	}
	function rh_dokan_edit_page_after(){
		echo '</div>';
	}	
	
	/* 
	 * Set defailt theme value for banner sizes
	 */
	 function custom_dokan_set_banner_size() {
		$general_settings = get_option( 'dokan_general' );
		
		if( !isset( $general_settings['store_banner_width'] ) OR empty( $general_settings['store_banner_width'] ) ) {
			$general_settings['store_banner_width'] = 1900;
			$theme_width = true;
		} else {
			$theme_width = false;
		}
			
        if( !isset( $general_settings['store_banner_height'] ) OR empty( $general_settings['store_banner_height'] ) ) {
			$general_settings['store_banner_height'] = 300;
			$theme_height = true;
		} else {
			$theme_height = false;
		}
			
		if( $theme_width AND $theme_height )
			update_option( 'dokan_general', $general_settings );
		return false;
	 }
	 add_action( 'init', 'custom_dokan_set_banner_size' );
	 
	/*
	* Save / Delete location to / from GEO my WP plugin
	*/
	function custom_dokan_gwm_save_location( $store_id, $dokan_settings ){
		if( !$store_id OR !class_exists( 'GMW' ) ) return;

		$address_arr = ( isset( $dokan_settings['address'] ) AND is_array( $dokan_settings['address'] ) ) ? $dokan_settings['address'] : array();
		$find_address = ( isset( $dokan_settings['find_address']  ) AND !empty( $dokan_settings['find_address'] ) ) ? $dokan_settings['find_address'] : '';
		if( !empty( $address_arr ) OR !empty( $find_address ) ) {
			require_once ( GMW_PATH . '/includes/geo-my-wp-user-update-location.php' );
			$args = array(
				'user_id'         => $store_id,
				'address'         => empty( $find_address ) ? $address_arr : $find_address,
				'map_icon'        => '_default.png',
			);
			if(function_exists('gmw_update_user_location')){
				gmw_update_user_location( $args );
			}
		}
	}
	add_action( 'dokan_store_profile_saved', 'custom_dokan_gwm_save_location', 10, 2 );
	 
	/* 
	 * Change store map description in plugin settings
	 */
	function custom_dokan_admin_settings( $settings_fields ){
		$settings_fields['dokan_general']['store_map']['desc']  = __( 'Enable showing link to Store location map on store', 'dokan' );
			unset($settings_fields['dokan_general']['enable_theme_store_sidebar']);

		return $settings_fields;
	}
	add_filter( 'dokan_settings_fields', 'custom_dokan_admin_settings' );

	/* 
	 * Remove while Appearance tab in plugin settings
	 */
	function custom_dokan_remove_section( $sections ){
		for( $i=0; $i < count( $sections ); $i++ ) {
			if( $sections[$i]['id'] == 'dokan_appearance' )
				unset( $sections[$i] );
		}
		return $sections;
	}
	add_filter( 'dokan_settings_sections', 'custom_dokan_remove_section' );

	/* 
	 * Change URL and Title of the About store tab 
	 */
	function custom_dokan_toc_url( $tabs ){
		$tabs['terms_and_conditions'] = array(
			'title' => apply_filters( 'dokan_about_store_title', __( 'Terms and Conditions', 'rehub_framework' ) ),
			'url'   => '#vendor-about'
		);
		return $tabs;
	}
	add_filter( 'dokan_store_tabs', 'custom_dokan_toc_url' );

	/* 
	 * Output Sold by <store_name> label in loop
	 */
	function dokan_loop_sold_by() {
		$vendor_id = get_the_author_meta( 'ID' );
		$store_info = dokan_get_store_info( $vendor_id );
		$sold_by = dokan_is_user_seller( $vendor_id )
			? sprintf( '<a href="%s">%s</a>', dokan_get_store_url( $vendor_id ), esc_html( $store_info['store_name'] ) )
			: get_bloginfo( 'name' );
		?>
		<small class="wcvendors_sold_by_in_loop"><span><?php echo apply_filters( 'dokan_sold_by_label', __( 'Sold by', 'rehub_framework' ) ); ?></span> <?php echo $sold_by; ?></small><br />
		<?php
	}
	add_action( 'rehub_vendor_show_action', 'dokan_loop_sold_by' );

}

//////////////////////////////////////////////////////////////////
//WC Marketplace Functions
//////////////////////////////////////////////////////////////////
if( class_exists('WCMp')) {
	add_filter('wcmp_vendor_dashboard_nav', 'rh_wcmp_vendor_dashboard_nav' );
	if(!function_exists('rh_wcmp_vendor_dashboard_nav')) {
		function rh_wcmp_vendor_dashboard_nav($vendor_nav) {
			if(class_exists('WCFM'))
				return $vendor_nav;		
			if(current_user_can('edit_products')) {
				$userlogin_submit_page = rehub_option('url_for_add_product');
				$userlogin_edit_page = rehub_option('url_for_edit_product');
				if(!empty($userlogin_submit_page) || !empty($userlogin_edit_page) ) {
					$vendor_nav['vendor-products']['url'] = '#';
				}
				if(!empty($userlogin_submit_page)) {
					$vendor_nav['vendor-products']['submenu']['add-new-product'] = array(
						'label' => __('Add Product', 'rehub_framework'),
						'url' => esc_url($userlogin_submit_page),
						'capability' => apply_filters('wcmp_vendor_dashboard_menu_add_new_product_capability', 'edit_products'), 
						'position' => 10, 
						'link_target' => '_self'
					);
				}
				if(!empty($userlogin_edit_page)) {
					$vendor_nav['vendor-products']['submenu']['edit-products'] = array(
						'label' => __('Products', 'rehub_framework'),
						'url' => esc_url($userlogin_edit_page),
						'capability' => apply_filters('wcmp_vendor_dashboard_menu_vendor_products_capability', 'edit_products'), 
						'position' => 20, 
						'link_target' => '_self'
					);
				}
			} else {
				unset($vendor_nav['vendor-products']);
			}
		return $vendor_nav;
		}
	}

	if(!function_exists('rh_wcmp_gwm_save_adress')) {
		function rh_wcmp_gwm_save_adress($user_id = '') {
			if(class_exists( 'GMW' )){
				$location = array();
				$vendor_id = (is_admin() && !empty($user_id)) ? $user_id : get_current_user_id();
				if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {
					global $wpdb;
					if ($_POST['vendor_address_1'])
						$location['gmw_street'] = $_POST['vendor_address_1'];
					if ($_POST['vendor_address_2'])
						$location['gmw_apt'] = $_POST['vendor_address_2'];
					if ($_POST['vendor_city'])
						$location['gmw_city'] = $_POST['vendor_city'];
					if ($_POST['vendor_state'])
						$location['gmw_state'] = $_POST['vendor_state'];
					if ($_POST['vendor_postcode'])
						$location['gmw_zipcode'] = $_POST['vendor_postcode'];
					if ($_POST['vendor_country'])
						$location['gmw_country'] = $_POST['vendor_country'];
					
					
					$formatted_address = implode(', ', $location);
					if( !empty($formatted_address)) {
						require_once ( GMW_PATH . '/includes/geo-my-wp-user-update-location.php' );
						$args = array(
							'user_id'         => $vendor_id,
							'address'         => $formatted_address,
							'map_icon'        => '_default.png',
						);
						if(function_exists('gmw_update_user_location')){
							gmw_update_user_location( $args );
						}
					}
				}
			}
		}
		add_action('before_wcmp_vendor_dashboard', 'rh_wcmp_gwm_save_adress');
		add_action('edit_user_profile_update', 'rh_wcmp_gwm_save_adress');
	}

}


?>