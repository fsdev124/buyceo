<?php
/**
 * Display the vendor store ratings 
 * 
 * Override this template by copying it to yourtheme/wc-vendors/store
 *
 * @package    WCVendors_Pro
 * @version    1.2.5
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$vendor_shop 		= urldecode( get_query_var( 'vendor_shop' ) );
$vendor_id   		= WCV_Vendors::get_vendor_id( $vendor_shop ); 
$vendor_feedback 	= WCVendors_Pro_Ratings_Controller::get_vendor_feedback( $vendor_id );
$vendor_shop_url	= WCV_Vendors::get_vendor_shop_page( $vendor_id ); 

$shop_name 	       =  get_user_meta( $vendor_id, 'pv_shop_name', true ); 
$has_html          = get_user_meta( $vendor_id, 'pv_shop_html_enabled', true );
$global_html       = WC_Vendors::$pv_options->get_option( 'shop_html_enabled' );
$description       = do_shortcode( get_user_meta( $vendor_id, 'pv_shop_description', true ) );
$shop_description  = ( $global_html || $has_html ) ? wp_kses_post( $description )  : sanitize_text_field( $description );
$shop_description_short = esc_html($description);
if ( class_exists( 'WCVendors_Pro' ) ) {
	$vendor_meta = array_map( function( $a ){ return $a[0]; }, get_user_meta($vendor_id ) );
}


get_header(); ?>

<div class="wcvendor_store_wrap_bg">
	<style scoped>#wcvendor_image_bg{<?php echo rh_show_vendor_bg($vendor_id);?>}</style>
	<div id="wcvendor_image_bg">	
		<div id="wcvendor_profile_wrap">
			<div class="rh-container">
	    		<div id="wcvendor_profile_logo" class="wcvendor_profile_cell">
	    			<a href="<?php echo $vendor_shop_url;?>"><img src="<?php echo rh_show_vendor_avatar($vendor_id, 150, 150);?>" class="vendor_store_image_single" width=150 height=150 />	</a>        
	    		</div>
	    		<div id="wcvendor_profile_act_desc" class="wcvendor_profile_cell">
	    			<div class="wcvendor_store_name"><h1><?php echo esc_html($shop_name);?></h1></div>
				    <?php if ( class_exists( 'WCVendors_Pro' ) ) :?>
					    <div class="wcvendor_store_stars">
						    <?php if ( ! WCVendors_Pro::get_option( 'ratings_management_cap' ) ) echo WCVendors_Pro_Ratings_Controller::ratings_link( $vendor_id, true );?>
					    </div>
					    <?php 
					    $address1 			= ( array_key_exists( '_wcv_store_address1', $vendor_meta ) ) ? $vendor_meta[ '_wcv_store_address1' ] : '';
					    $address2 			= ( array_key_exists( '_wcv_store_address2', $vendor_meta ) ) ? $vendor_meta[ '_wcv_store_address2' ] : '';
					    $city	 			= ( array_key_exists( '_wcv_store_city', $vendor_meta ) ) ? $vendor_meta[ '_wcv_store_city' ]  : '';
					    $state	 			= ( array_key_exists( '_wcv_store_state', $vendor_meta ) ) ? $vendor_meta[ '_wcv_store_state' ] : '';
					    $phone				= ( array_key_exists( '_wcv_store_phone', $vendor_meta ) ) ? $vendor_meta[ '_wcv_store_phone' ]  : '';
					    $store_postcode		= ( array_key_exists( '_wcv_store_postcode', $vendor_meta ) ) ? $vendor_meta[ '_wcv_store_postcode' ]  : '';
					    $address 			= ( $address1 != '') ? $address1 .', ' . $city .', '. $state .', '. $store_postcode : '';
					    ?>
					    <div class="wcvendor_store_desc"><?php echo $address; ?></div>
					<?php else:?>
					    <div class="wcvendor_store_desc"><?php rehub_truncate('maxchar=200&text='.$shop_description_short.''); ?></div>
					<?php endif;?>
	    		</div>	        			        		
	    		<div id="wcvendor_profile_act_btns" class="wcvendor_profile_cell">
	    			<span class="wpsm-button medium red"><?php echo getShopLikeButton($vendor_id);?></span>
				    <?php if ( class_exists( 'BuddyPress' ) ) :?>
					    <?php
					        if ( bp_is_active( 'messages' )){
						    $link = (is_user_logged_in()) ? wp_nonce_url( bp_loggedin_user_domain() . bp_get_messages_slug() . '/compose/?r=' . bp_core_get_username( $vendor_id)) : '#';
						    $class = (!is_user_logged_in() && rehub_option('userlogin_enable') == '1') ? ' act-rehub-login-popup' : '';
						    echo ' <a href="'.$link.'" class="wpsm-button medium white'.$class.'">'. __('Contact vendor', 'rehub_framework') .'</a>';
					    }?>
					<?php endif;?>
	    		</div>	        			
			</div>
		</div>
		<span class="wcvendor-cover-image-mask"></span>
	</div>
	<div id="wcvendor_profile_menu">
		<div class="rh-container">			
			<form id="wcvendor_search_shops" role="search" action="<?php echo $vendor_shop_url;?>" method="get" class="wcvendor-search-inside search-form">
				<input type="text" name="rh_wcv_search" placeholder="<?php _e('Search in this shop', 'rehub_framework');?>" value="">
				<button type="submit" class="btnsearch"><i class="fa fa-search"></i></button>					
			</form>	
			<ul class="wcvendor_profile_menu_items">		
			<li><a href="<?php echo $vendor_shop_url;?>"><?php _e('Return to store', 'rehub_framework');?></a></li>
			<li class="active"><a href="#"><?php _e('Reviews', 'rehub_framework');?></a></li>	
			</ul>

		</div>
	</div>
</div>

<!-- CONTENT -->
<div class="rh-container"> 
    <div class="rh-content-wrap clearfix">
        <!-- Main Side -->
        <div class="main-side woocommerce page clearfix full_width">
            <article class="post" id="page-<?php the_ID(); ?>">

            	<h3 class="page-title mt0"><?php _e( 'Customer Ratings', 'rehub_framework' ); ?></h3>

				<?php if ( $vendor_feedback ) { 

					foreach ( $vendor_feedback as $vf ) {

						$customer 		= get_userdata( $vf->customer_id ); 
						$rating 		= $vf->rating; 
						$rating_title 	= $vf->rating_title; 
						$comment 		= $vf->comments;
						$post_date		= date_i18n( get_option( 'date_format' ), strtotime( $vf->postdate ) );  
						$customer_name 	= ucfirst( $customer->display_name ); 
						$product_link	= get_permalink( $vf->product_id );
						$product_title	= get_the_title( $vf->product_id ); 

						// This outputs the star rating 
						$stars = ''; 
						for ($i = 1; $i<=stripslashes( $rating ); $i++) { $stars .= "<i class='fa fa-star'></i>"; } 
						for ($i = stripslashes( $rating ); $i<5; $i++) { $stars .=  "<i class='fa fa-star-o'></i>"; }
						?> 
						<div class="wcv-rating-item">
						<h4><?php if ( ! empty( $rating_title ) ) { echo $rating_title.' :: '; } ?> <?php echo $stars; ?></h4>

						<div class="wcv-rating-posted-by">
							<span><?php __( 'Posted on', 'wcvendors-pro'); ?> <?php echo $post_date; ?></span> <?php __( 'by', 'wcvendors-pro'); echo $customer_name; ?>
							<p><?php _e( 'Product:', 'wcvendors-pro'); ?><a href="<?php echo $product_link; ?>" target="_blank"><?php echo $product_title; ?></a></p>
						</div>
						<p><?php echo $comment; ?></p>
						</div>

						<?php 
					}

					
				} else {  echo __( 'No ratings have been submitted for this vendor yet.', 'rehub_framework' ); }  ?> 
				
				<a href="<?php echo $vendor_shop_url; ?>"><?php _e( 'Return to store', 'rehub_framework' ); ?></a>           	

    		</article>
    	</div>
	<!-- /Main Side --> 
    </div>
</div>
<!-- /CONTENT -->	

<?php get_footer(); ?>