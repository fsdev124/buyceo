<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$store_user = get_userdata( get_query_var( 'author' ) );
$vendor_id = $store_user->ID;
$feature_seller = get_user_meta( $vendor_id, 'dokan_feature_seller', true );
$store_info = dokan_get_store_info( $vendor_id );
$store_url = dokan_get_store_url( $vendor_id );
$store_tabs = dokan_get_store_tabs( $vendor_id );
$store_address = dokan_get_seller_address( $vendor_id, TRUE );
$tnc_enable = dokan_get_option( 'seller_enable_terms_and_conditions', 'dokan_general', 'off' );

if ( ! empty( $store_address['state'] ) && ! empty( $store_address['country'] ) ) {
    $short_address = $store_address['state'] . ', ' . $store_address['country'];
} else if ( ! empty( $store_address['country'] ) ) {
    $short_address = $store_address['country'];
} else {
    $short_address = '';
}

$store_address = apply_filters( 'dokan_store_header_adress', $short_address, $store_address );
?>
<div class="wcvendor_store_wrap_bg">
	<style scoped>#wcvendor_image_bg{<?php echo rh_show_vendor_bg( $vendor_id ); ?>}</style>
	<div id="wcvendor_image_bg">	
		<div id="wcvendor_profile_wrap">
			<div class="rh-container">
	    		<div id="wcvendor_profile_logo" class="wcvendor_profile_cell">
	    			<a href="<?php echo $store_url; ?>"><img src="<?php echo rh_show_vendor_avatar($vendor_id, 150, 150); ?>" class="vendor_store_image_single" width=150 height=150 /></a>
	    		</div>
	    		<div id="wcvendor_profile_act_desc" class="wcvendor_profile_cell">
	    			<div class="wcvendor_store_name">
					<?php if ( $feature_seller == 'yes' ) : ?>
						<div class="wcv-verified-vendor">
							<i class="fa fa-check" aria-hidden="true"></i> <?php _e( 'Featured vendor', 'rehub_framework' ); ?>
						</div>
					<?php endif; ?>						
	    				<h1><?php echo esc_html( $store_info['store_name'] ); ?></h1> 	    				
	    			</div>
	    			<div class="wcvendor_store_desc">
						<div class="wcvendor_store_stars woocommerce">
							<?php dokan_get_readable_seller_rating( $vendor_id ); ?>
						</div>
                        <?php if ( isset( $store_address ) && !empty( $store_address ) ) { ?>
                            <i class="fa fa-map-marker"></i> <?php echo $store_address; ?>
					    	<?php if( class_exists( 'Dokan_Store_Location' ) && dokan_get_option( 'store_map', 'dokan_general', 'on' ) == 'on' ) { ?>
								<span class="rh_gmw_map_in_wcv_profile"><?php _e( '(Show on map)', 'rehub_framework' ); ?></span>
							<?php } ?>
                        <?php } ?>	
					</div>
	    		</div>	        			        		
	    		<div id="wcvendor_profile_act_btns" class="wcvendor_profile_cell">
	    			<span class="wpsm-button medium red"><?php echo getShopLikeButton( $vendor_id );?></span>	    			
				    <?php if ( class_exists( 'BuddyPress' ) ) :?>
				    	<?php if ( bp_loggedin_user_id() && bp_loggedin_user_id() != $vendor_id ) :?>
							<?php 
								if ( function_exists( 'bp_follow_add_follow_button' ) ) {
							        bp_follow_add_follow_button( array(
							            'leader_id'   => $vendor_id,
							            'follower_id' => bp_loggedin_user_id(),
							            'link_class'  => 'wpsm-button medium green'
							        ) );
							    }
							?>
						    <?php
						        if ( bp_is_active( 'messages' ) && dokan_get_option( 'contact_seller', 'dokan_general', 'on' ) != 'on' ) {
							    $link = (is_user_logged_in()) ? wp_nonce_url( bp_loggedin_user_domain() . bp_get_messages_slug() . '/compose/?r=' . bp_core_get_username( $vendor_id )) : '#';
							    $class = ( !is_user_logged_in() && rehub_option( 'userlogin_enable' ) == '1' ) ? ' act-rehub-login-popup' : '';
							    echo ' <a href="'. $link .'" class="wpsm-button medium white'.$class.'">'. __( 'Contact vendor', 'rehub_framework' ) .'</a>';
						    }?>
					    <?php endif;?>
					<?php endif;?>
					<?php if ( dokan_get_option( 'contact_seller', 'dokan_general', 'on' ) == 'on' ) {					
						echo ' <span class="wpsm-button rehub_scroll medium white" data-scrollto="#dokan-contact-anchor">'. __( 'Contact vendor', 'rehub_framework' ) .'</span>';
						};?>
	    		</div>	        			
			</div>
		</div>
		<span class="wcvendor-cover-image-mask dokan-cover-image-mask"></span>
	</div>
	
	<div id="wcvendor_profile_menu">
		<div class="rh-container">			
			<form id="wcvendor_search_shops" role="search" action="<?php echo $store_url; ?>" method="get" class="wcvendor-search-inside search-form">
				<input type="text" name="s" placeholder="<?php _e( 'Search in this shop', 'rehub_framework' );?>" value="">
				<button type="submit" class="btnsearch"><i class="fa fa-search"></i></button>					
			</form>
			
			<?php if ( $store_tabs ) { ?>
			<ul class="wcvendor_profile_menu_items">
            <?php foreach( $store_tabs as $key => $tab ) { ?>
				<li>
				<?php if( $key == 'terms_and_conditions' ){ ?>
					<?php if(!empty($store_info['store_tnc']) && isset($store_info['enable_tnc']) && $store_info['enable_tnc'] == 'on' && $tnc_enable == 'on') :?>
						<a href="<?php echo esc_url( $tab['url'] ); ?>" aria-controls="vendor-about" role="tab" data-toggle="tab" aria-expanded="true" data-scrollto="#vendor-about"><?php echo $tab['title']; ?></a>
					<?php endif;?>
				<?php } else { ?>
					<a href="<?php echo esc_url( $tab['url'] ); ?>"><?php echo $tab['title']; ?></a>
				<?php } ?>
				</li>
            <?php } ?>
			
			<?php do_action( 'dokan_after_store_tabs', $vendor_id ); ?>
			
			</ul>
			<?php } ?>
		</div>
	</div>
</div>
