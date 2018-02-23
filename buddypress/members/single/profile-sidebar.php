<?php if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<div class="rh-mini-sidebar floatleft tabletblockdisplay">
	<?php 	
		$vendor_id = bp_displayed_user_id();
		$count_likes = ( get_user_meta( $author_ID, 'overall_post_likes', true) ) ? get_user_meta( $author_ID, 'overall_post_likes', true) : '0';
		$is_vendor = '';
		
		if( class_exists( 'WeDevs_Dokan' ) ) {
			$is_vendor = dokan_is_user_seller( $vendor_id );
			$shop_url = dokan_get_store_url( $vendor_id );
			$sold_by = get_user_meta( $vendor_id, 'dokan_store_name', true );
		}
		elseif(class_exists('WCMp')){
			$is_vendor = is_user_wcmp_vendor( $vendor_id );
			if($is_vendor){
				$vendorobj = get_wcmp_vendor($vendor_id);
				$shop_url = $vendorobj->permalink;
				$sold_by = get_user_meta($vendor_id, '_vendor_page_title', true); 
			}
		}
		elseif(defined('wcv_plugin_dir')) {
			$is_vendor = WCV_Vendors::is_vendor( $vendor_id );
			$shop_url = WCV_Vendors::get_vendor_shop_page( $vendor_id );
			$sold_by = WCV_Vendors::get_vendor_sold_by( $vendor_id );
		}

	?>
	<?php if( $is_vendor ) : ?>
		<div class="rh-cartbox user-profile-div text-center widget">
			<div class="widget-inner-title rehub-main-font"><?php _e('Owner of shop', 'rehub_framework');?></div>
			<div class="mb20"><a href="<?php echo $shop_url; ?>"><img src="<?php echo rh_show_vendor_avatar($vendor_id, 150, 150);?>" class="vendor_store_image_single" width=150 height=150 /></a>
			</div>
			<div class="profile-usertitle-name mb20">
            	<a href="<?php echo $shop_url;?>">
            		<?php echo $sold_by; ?>
            	</a>	                    
            </div>
            <div class="profile-stats">
				<div><i class="fa fa-heartbeat"></i><?php _e( 'Product Votes', 'rehub_framework' ); echo ': ' . $count_likes; ?></div>
                <div><i class="fa fa-briefcase"></i><?php _e( 'Total products', 'rehub_framework' ); echo ': ' . count_user_posts( $vendor_id, $post_type = 'product' ); ?></div>	  	
            </div>                    						
		</div>
	<?php endif;?>
    <?php if ( is_active_sidebar( 'bprh-profile-sidebar' ) ) : ?>
        <?php dynamic_sidebar( 'bprh-profile-sidebar' ); ?>
    <?php endif;?>	        		
</div>