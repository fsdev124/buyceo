<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php 
/*
*	Template Variables available 
*   $shop_name : pv_shop_name
*   $shop_description : pv_shop_description (completely sanitized)
*   $shop_link : the vendor shop link 
*   $vendor_id  : current vendor id for customization 
*/
?>
<?php 
$store_bg = '';
if ( class_exists( 'WCVendors_Pro' ) ) {
	$vendor_meta = array_map( function( $a ){ return $a[0]; }, get_user_meta($vendor_id ) );
	$store_icon_src 	= wp_get_attachment_image_src( get_user_meta( $vendor_id, '_wcv_store_banner_id', true ), 'full');
	if ( is_array( $store_icon_src ) ) { 
		$store_bg= $store_icon_src[0]; 
	}	
}
else {
	$store_banner_src  = wp_get_attachment_image_src( get_user_meta( $vendor_id, 'rh_vendor_free_header', true ), 'full');
	if ( is_array( $store_banner_src ) ) { 
		$store_bg= $store_banner_src[0]; 
	}	
}
$bg_styles = (!empty($store_bg)) ? ' style="background-image: url('.$store_bg.'); background-repeat: no-repeat;background-size: cover;"' : '';
?>
<li class="col_item">
	<div class="member-inner-list">
		<div class="vendor-list-like"><?php echo getShopLikeButton($vendor_id);?></div>
		<a href="<?php echo $shop_link; ?>">
			<span class="cover_logo"<?php echo $bg_styles; ?>></span>
		</a>
		<div class="member-details">
			<div class="item-avatar">
				<a href="<?php echo $shop_link; ?>">
					<img src="<?php echo rh_show_vendor_avatar($vendor_id, 80, 80);?>" class="vendor_store_image_single" width=80 height=80 />
				</a>
			</div>		
	    	<a href="<?php echo $shop_link; ?>" class="wcv-grid-shop-name"><?php echo $shop_name; ?></a>
	    	<?php if ( class_exists( 'WCVendors_Pro' ) ) {
	    		if ( ! WCVendors_Pro::get_option( 'ratings_management_cap' ) ) {
	    			echo '<div class="wcv_grid_rating">';
	    			echo WCVendors_Pro_Ratings_Controller::ratings_link( $vendor_id, true );
	    			echo '</div>';
	    		}
	    	}?>
	    	<div class="store-desc">
	    	<?php if ( class_exists( 'WCVendors_Pro' ) ):?>
	    		<?php $shop_description = $vendor_meta[ 'pv_shop_description' ]; rehub_truncate('maxchar=100&text='.$shop_description.''); ?>
	    	<?php else: ?>
	    		<?php rehub_truncate('maxchar=100&text='.$shop_description.''); ?>
	    	<?php endif;?>
	    	</div>		
		</div>
		<?php $totaldeals = count_user_posts( $vendor_id, $post_type = 'product' ) - 3; ?>
		<div class="last-vendor-products">
			<?php
			$args = array(
				'post_type' => 'product',
				'posts_per_page' => 3,
				'author' => $vendor_id,
				'ignore_sticky_posts'=> true,
				'no_found_rows'=> true
			);
			$looplatest = new WP_Query($args); $i = 0;
			if ( $looplatest->have_posts() ){
				while ( $looplatest->have_posts() ) : $looplatest->the_post();
					$i++;
					echo '<a href="'.get_permalink($looplatest->ID).'">';
			            $showimg = new WPSM_image_resizer();
			            $showimg->use_thumb = true;
			            $showimg->height = 70;
			            $showimg->width = 70;
			            $showimg->crop = true;           
			            $img = $showimg->get_resized_url();
			            echo '<img src="'.$img.'" width=70 height=70 alt="'.get_the_title($looplatest->ID).'"/>';
			            if ($i==3 && $totaldeals > 0){echo '<span class="product_count_in_member">+'.$totaldeals.'</span>';}
					echo '</a>';

				endwhile;
			}
			wp_reset_query();?>		
		</div>
    </div>
</li>