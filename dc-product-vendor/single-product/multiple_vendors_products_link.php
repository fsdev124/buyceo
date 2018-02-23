<?php 
global $post;
$rh_product_layout_style = get_post_meta($post->ID, '_rh_woo_product_layout', true);?>
<?php if ($rh_product_layout_style == '' || $rh_product_layout_style == 'global') {$rh_product_layout_style = rehub_option('product_layout_style');} ?>
<?php if ($rh_product_layout_style == '') :?>
    <?php $rh_product_layout_style = 'default_with_sidebar';?>
<?php endif;?>

<?php if($rh_product_layout_style == 'ce_woo_list' || $rh_product_layout_style == 'ce_woo_sections' || $rh_product_layout_style == 'vendor_woo_list') : ?>
<?php else:?>
<?php
/**
 * Single Product Multiple vendors
 *
 * This template can be overridden by copying it to yourtheme/dc-product-vendor/single-product/multiple_vendors_products_link.php.
 *
 * HOWEVER, on occasion WCMp will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * 
 * @author  WC Marketplace
 * @package dc-woocommerce-multi-vendor/Templates
 * @version 2.3.4
 */
global $WCMp, $wpdb;
$results_str = '';
$searchstr = $post->post_title;
$searchstr = str_replace("'", "", $searchstr);
$searchstr = str_replace('"', '', $searchstr);
$querystr = "select  * from {$wpdb->prefix}wcmp_products_map where replace(replace(product_title, '\'',''), '\"','') = '{$searchstr}'";
$results_obj_arr = $wpdb->get_results($querystr);
if(isset($results_obj_arr) && count($results_obj_arr) > 0 ) {
	$results_str = $results_obj_arr[0]->product_ids;
}

if( !empty( $results_str ) ) {
	$product_id_arr = explode(',',$results_str);
	$args = array(
		'posts_per_page'   => -1,
		'offset'           => 0,	
		'orderby'          => 'date',
		'order'            => 'DESC',	
		'post_type'        => 'product',	
		'post__in'				 => $product_id_arr,
		'post_status'      => 'publish',
		'suppress_filters' => true 
	);
	$results = get_posts( $args );
	if(count($results) > 1){
		$button_text = apply_filters('wcmp_more_vendors', __('More offers','rehub_framework'));
		if($rh_product_layout_style == 'full_width_extended' || $rh_product_layout_style == 'full_photo_booking'){
			echo '<a  href="#section-singleproductmultivendor" class="mb20 inlinestyle goto_more_offer_section button rehub_scroll">'.$button_text.'</a>';
		}else{
			echo '<a  href="#" class="goto_more_offer_tab button">'.$button_text.'</a>';			
		}

	}
} 
?>
                          
                              
<?php endif;?> 