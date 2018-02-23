<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php
/*
*	Template Variables available 
*   $shop_name : pv_shop_name
*   $shop_description : pv_shop_description (completely sanitized)
*   $shop_link : the vendor shop link 
*   $vendor_id  : current vendor id for customization 
*   $vendor_meta
*/
?>
<?php $vendor_user_link = ( class_exists( 'BuddyPress' ) ) ? bp_core_get_user_domain( $vendor_id ) : get_author_posts_url( $vendor_id ); ?>
<?php 	
	$vendor = get_userdata( $vendor_id );
	$vendor_email = $vendor->user_email;
?>
<div class="vendor_store_in_bp">
	<div class="vendor_store_in_bp_image">
		<a href="<?php echo $vendor_user_link ?>">
			<?php echo get_avatar( $vendor_email, '70' ); ?>
		</a>
	</div>
	<div class="vendor_store_in_bp_single">
		<div class="vendor_user_meta">
			<h5>
				<a href="<?php echo $vendor_user_link; ?>" class="wcvendors_cart_sold_by_meta">
					<?php the_author_meta( 'display_name', $vendor_id ); ?>
				</a>
			</h5>
			<?php if ( class_exists( 'WCVendors_Pro' ) ) : ?>
				<div class="profile-socbutton">
					<div class="social_icon small_i">
						<?php
						// Get store details including social, adddresses and phone number
						$twitter_username 	= get_user_meta( $vendor_id , '_wcv_twitter_username', true );
						$instagram_username = get_user_meta( $vendor_id , '_wcv_instagram_username', true );
						$facebook_url 		= get_user_meta( $vendor_id , '_wcv_facebook_url', true );
						$linkedin_url 		= get_user_meta( $vendor_id , '_wcv_linkedin_url', true );
						$youtube_url 		= get_user_meta( $vendor_id , '_wcv_youtube_url', true );
						$googleplus_url 	= get_user_meta( $vendor_id , '_wcv_googleplus_url', true );
						$pinterest_url 		= get_user_meta( $vendor_id , '_wcv_pinterest_url', true );
						?>
						<?php if ( $facebook_url != '') { ?><a href="<?php echo $facebook_url; ?>" target="_blank" class="author-social fb" rel="nofollow"><i class="fa fa-facebook"></i></a><?php } ?>
						<?php if ( $instagram_username != '') { ?><a href="//instagram.com/<?php echo $instagram_username; ?>" target="_blank" class="author-social fb" rel="nofollow"><i class="fa fa-instagram"></i></a><?php } ?>
						<?php if ( $twitter_username != '') { ?><a href="//twitter.com/<?php echo $twitter_username; ?>" target="_blank" class="author-social tw" rel="nofollow"><i class="fa fa-twitter"></i></a><?php } ?>
						<?php if ( $googleplus_url != '') { ?><a href="<?php echo $googleplus_url; ?>" target="_blank" class="author-social gp" rel="nofollow"><i class="fa fa-google-plus"></i></a><?php } ?>
						<?php if ( $pinterest_url != '') { ?><a href="<?php echo $pinterest_url; ?>" target="_blank" class="author-social gp" rel="nofollow"><i class="fa fa-pinterest"></i></a><?php } ?>
						<?php if ( $youtube_url != '') { ?><a href="<?php echo $youtube_url; ?>" target="_blank" class="author-social yt" rel="nofollow"><i class="fa fa-youtube"></i></a><?php } ?>
						<?php if ( $linkedin_url != '') { ?><a href="<?php echo $linkedin_url; ?>" target="_blank" class="author-social fb" rel="nofollow"><i class="fa fa-linkedin"></i></a><?php } ?>
					</div>
				</div>
			<?php endif; ?>


		</div>

	</div>
	<div class="vendor_store_in_bp_shopname">
		<div class="tabledisplay">
			<div class="celldisplay shop_avatar_v_store">
				<div class="vendor-list-like"><?php echo getShopLikeButton( $vendor_id ); ?></div>
				<a href="<?php echo $shop_link; ?>" class="wcvendors_cart_sold_by_meta">
					<img src="<?php echo rh_show_vendor_avatar( $vendor_id, 50, 50 ) ?>" class="vendor_store_image_single"
				     width=50 height=50/>
				</a>
			</div>
			<div class="celldisplay vendor_storelist_name">
				<span><?php _e( 'Shop', 'rehub_framework' ); ?></span>
				<a href="<?php echo $shop_link; ?>"><?php echo $shop_name; ?></a>
			</div>
		</div>
	</div>
	<div class="vendor_store_in_bp_last_products">
		<?php
		$totaldeals = count_user_posts( $vendor_id, $post_type = 'product' );
		$totaldeals = $totaldeals - 4;
		$args       = array(
			'post_type'           => 'product',
			'posts_per_page'      => 4,
			'author'              => $vendor_id,
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true
		);
		$looplatest = new WP_Query( $args );
		if ( $looplatest->have_posts() ) {
			while ( $looplatest->have_posts() ) : $looplatest->the_post();
				echo '<a href="' . get_permalink( $looplatest->ID ) . '">';
				$showimg            = new WPSM_image_resizer();
				$showimg->use_thumb = true;
				$showimg->height    = 70;
				$showimg->width     = 70;
				$showimg->crop      = true;
				$showimg->no_thumb = rehub_woocommerce_placeholder_img_src('');
				$img                = $showimg->get_resized_url();
				echo '<img src="' . $img . '" width=70 height=70 alt="' . get_the_title( $looplatest->ID ) . '"/>';
				echo '</a>';
			endwhile;
			if ( $totaldeals > 0 ) {
				echo '<a class="vendor_store_in_bp_count_pr" href="' . $shop_link . '"><span>+' . $totaldeals . '</span></a>';
			}

		}
		wp_reset_query(); ?>

	</div>
</div>	