<?php
/**
 * The Template for displaying products in a product category. Simply includes the archive template.
 *
 * Override this template by copying it to yourtheme/dc-product-vendor/taxonomy-dc_vendor_shop.php
 *
 * @author 		WC Marketplace
 * @package 	WCMp/Templates
 * @version   2.2.0
 */
global $WCMp;
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
// Get vendor ID
$vendor = get_wcmp_vendor_by_term(get_queried_object()->term_id);
$is_block = get_user_meta($vendor->id, '_vendor_turn_off' , true);
if($is_block) {
	get_header(); ?>
	<!-- CONTENT -->
	<div class="rh-container"> 
		<div class="rh-content-wrap clearfix">
			<!-- Main Side -->
			<div class="main-side woocommerce page clearfix full_width">
				<article class="post" id="page-<?php the_ID(); ?>">
                	<?php do_action( 'woocommerce_before_main_content' );?>
                	<?php woocommerce_breadcrumb();?>
					<?php do_action( 'woocommerce_archive_description' ); 
					$block_vendor_desc = $WCMp->vendor_caps->frontend_cap['block_vendor_desc'];
					?>
					<p class="blocked_desc"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <?php echo esc_attr($block_vendor_desc); ?><p>
					<?php
					/**
					 * woocommerce_after_main_content hook
					 *
					 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
					 */
					do_action( 'woocommerce_after_main_content' );
				?>
				</article>
			</div>
			<!-- /Main Side --> 
			
		</div>
	</div>
	<!-- /CONTENT -->
	
	<?php get_footer(); ?>
	
<?php
} else {
	include(rh_locate_template('dc-product-vendor/wcm-store.php'));
}