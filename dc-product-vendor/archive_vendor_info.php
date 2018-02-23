<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php
global $WCMp;
$external_store_url = $verified_vendor = '';
$vendor = get_userdata( $vendor_id );
$vendor_name = $vendor->display_name;
$vendor_hide_address = get_user_meta($vendor_id,'_vendor_hide_address', true);
$vendor_hide_phone = get_user_meta($vendor_id,'_vendor_hide_phone', true);
$vendor_hide_email = get_user_meta($vendor_id,'_vendor_hide_email', true);
$vendor_hide_description = get_user_meta($vendor_id,'_vendor_hide_description', true);
$is_block = get_user_meta($vendor_id, '_vendor_turn_off' , true);
$shop_name = get_user_meta($vendor_id, '_vendor_page_title', true);
$totaldeals = count_user_posts( $vendor_id, $post_type = 'product' );
$count_likes = ( get_user_meta( $vendor_id, 'overall_post_likes', true) ) ? get_user_meta( $vendor_id, 'overall_post_likes', true) : '0';
$vendor_address = (!empty($location) && $vendor_hide_address != 'Enable') ? apply_filters( 'vendor_shop_page_location', $location, $vendor_id ) : '';
$vendor_phone = (!empty($mobile) && $vendor_hide_phone != 'Enable') ? apply_filters( 'vendor_shop_page_contact', $mobile, $vendor_id ) : '';
$vendor_email = (!empty($email) && $vendor_hide_email != 'Enable') ? apply_filters( 'vendor_shop_page_email', $email, $vendor_id ) : '';
$is_vendor_add_external_url_field = apply_filters('is_vendor_add_external_url_field', true);

if ( $WCMp->vendor_caps->vendor_capabilities_settings('is_vendor_add_external_url') && $is_vendor_add_external_url_field ) {
	$get_external_store_url = get_user_meta( $vendor_id, '_vendor_external_store_url', true );
	$external_store_url = apply_filters( 'vendor_shop_page_external_store', esc_url_raw($get_external_store_url ), $vendor_id ); 
}
wp_enqueue_style('rhwcvendor');
$adaptive_class = ( rehub_option('woo_columns') =='4_col' ) ? '' : ' main-side-wcmp';
?>
<div class="wcvendor_store_wrap_bg wcmp-container clearfix">
	<style scoped>#wcvendor_image_bg{<?php echo rh_show_vendor_bg( $vendor_id ); ?>}</style>
	<div id="wcvendor_image_bg">
		<div id="wcvendor_profile_wrap">
			<div class="pl20 pr20 tabledisplay <?php echo $adaptive_class; ?>">
	    		<div id="wcmvendor_profile_logo" class="wcvendor_profile_cell">
				<?php if( $external_store_url ) : ?><a href="<?php echo $external_store_url; ?>" rel="nofollow"><?php endif; ?>
					<img src="<?php echo rh_show_vendor_avatar($vendor_id, 140, 140); ?>" width=150 height=150 />
				<?php if( $external_store_url ) : ?></a><?php endif; ?>
	    		</div>
	    		<div id="wcvendor_profile_act_desc" class="wcvendor_profile_cell">
	    			<div class="wcvendor_store_name">
						<?php if ( $verified_vendor ) : ?>	   			
							<div class="wcv-verified-vendor">
								<i class="fa fa-check" aria-hidden="true"></i> <?php // echo $verified_vendor_label; ?>
							</div>
						<?php endif; ?>	    			
	    				<h1><?php echo esc_html( $shop_name ); ?></h1> 	    				
	    			</div>
    				<div class="wcmvendor_store_ratings">
					<?php 
					if(get_wcmp_vendor_settings('is_sellerreview', 'general') == 'Enable') {
						$queried_object = get_queried_object();
						if(isset($queried_object->term_id) && !empty($queried_object)) {		
							$rating_val_array = wcmp_get_vendor_review_info($queried_object->term_id); 
							$WCMp->template->get_template( 'review/rating.php', array('rating_val_array' => $rating_val_array)); 
						}
					}?>
					</div>
					<div class="wcvendor_store_desc mb10">
						<?php echo $vendor_address; ?>
					</div>
					<div class="wcmvendor_store_phones font80 lineheight15">
						<?php if ($vendor_phone) : ?>
							<i class="fa fa-phone"></i> <?php echo $vendor_phone; ?><br />
						<?php endif; ?>
						<?php if ($vendor_email ) : ?>
							<i class="fa fa-envelope"></i> <?php echo $vendor_email; ?><br />
						<?php endif; ?>
						<?php if ($external_store_url ) : ?>
							<i class="fa fa-globe"></i> <?php echo $external_store_url; ?>
						<?php endif; ?>
					</div>
	    		</div>
	    		<div id="wcvendor_profile_act_btns" class="wcvendor_profile_cell">
					<?php
					$vendor_fb_profile = get_user_meta($vendor_id,'_vendor_fb_profile', true);
					$vendor_twitter_profile = get_user_meta($vendor_id,'_vendor_twitter_profile', true);
					$vendor_linkdin_profile = get_user_meta($vendor_id,'_vendor_linkdin_profile', true);
					$vendor_google_plus_profile = get_user_meta($vendor_id,'_vendor_google_plus_profile', true);
					$vendor_youtube = get_user_meta($vendor_id,'_vendor_youtube', true);
					$vendor_instagram = get_user_meta($vendor_id,'_vendor_instagram', true);
					$social_icons = empty( $vendor_twitter_profile ) && empty( $vendor_instagram ) && empty( $vendor_fb_profile ) && empty( $vendor_linkdin_profile ) && empty( $vendor_youtube ) && empty( $vendor_google_plus_profile ) ? false : true;
					?>
					<?php if ($social_icons) :?>
					<div class="profile-socbutton">
						<div class="social_icon small_i">
							<?php if ( $vendor_fb_profile != '') { ?><a href="<?php echo $vendor_fb_profile; ?>" target="_blank" class="author-social fb" rel="nofollow"><i class="fa fa-facebook"></i></a><?php } ?>
							<?php if ( $vendor_instagram != '') { ?><a href="//instagram.com/<?php echo $vendor_instagram; ?>" target="_blank" class="author-social fb" rel="nofollow"><i class="fa fa-instagram"></i></a><?php } ?>
							<?php if ( $vendor_twitter_profile != '') { ?><a href="//twitter.com/<?php echo $vendor_twitter_profile; ?>" target="_blank" class="author-social tw" rel="nofollow"><i class="fa fa-twitter"></i></a><?php } ?>
							<?php if ( $vendor_google_plus_profile != '') { ?><a href="<?php echo $vendor_google_plus_profile; ?>" target="_blank" class="author-social gp" rel="nofollow"><i class="fa fa-google-plus"></i></a><?php } ?>
							<?php if ( $vendor_youtube != '') { ?><a href="<?php echo $vendor_youtube; ?>" target="_blank" class="author-social yt" rel="nofollow"><i class="fa fa-youtube"></i></a><?php } ?>
							<?php if ( $vendor_linkdin_profile != '') { ?><a href="<?php echo $vendor_linkdin_profile; ?>" target="_blank" class="author-social fb" rel="nofollow"><i class="fa fa-linkedin"></i></a><?php } ?>
						 </div>
					</div>
					<?php endif; ?>
	    			<span class="wpsm-button medium red"><?php echo getShopLikeButton($vendor_id); ?></span>	    			
				    <?php if ( class_exists( 'BuddyPress' ) ) : ?>
				    	<?php if ( bp_loggedin_user_id() && bp_loggedin_user_id() != $vendor_id ) : ?>
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
						        if ( bp_is_active( 'messages' )){
							    $link = (is_user_logged_in()) ? wp_nonce_url( bp_loggedin_user_domain() . bp_get_messages_slug() . '/compose/?r=' . bp_core_get_username( $vendor_id)) : '#';
							    $class = (!is_user_logged_in() && rehub_option('userlogin_enable') == '1') ? ' act-rehub-login-popup' : '';
							    echo ' <a href="'.$link.'" class="wpsm-button medium white'.$class.'">'. __('Contact vendor', 'rehub_framework') .'</a>';
						    }?>
					    <?php endif;?>
					<?php endif;?>
	    		</div>	        			
			</div>
		</div>
		<span class="wcvendor-cover-image-mask wcmvendor-cover-mask"></span>
	</div>
	<div class="padd20 lightgreybg flowhidden">
		<?php $about_width = $is_block ? ' style="width:100%"' : ''; ?>
		<?php if ( !$vendor_hide_description ) { ?>
		<div id="vendor-about" class="rh-mini-sidebar-content-area font90 floatleft"<?php echo $about_width; ?>><?php printf('<strong>%s</strong> %s', __('Description:', 'rehub_framework'), stripslashes($description) ); ?></div>
		<?php } ?>
		<?php if( !$is_block ) : ?>
		<form id="wcvendor_search_shops" role="search" action="" method="get" class="wcvendor-search-inside mt0 search-form">
			<input type="text" name="rh_wcv_search" placeholder="<?php _e('Search in this shop', 'rehub_framework');?>" value="">
			<button type="submit" class="btnsearch"><i class="fa fa-search"></i></button>					
		</form>
		<?php endif; ?>
	</div>
</div>
<div class="clearfix"></div>

