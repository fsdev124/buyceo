<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header(); ?>

<?php global $post;?>
<?php $rh_product_layout_style = get_post_meta($post->ID, '_rh_woo_product_layout', true);?>
<?php if ($rh_product_layout_style == '' || $rh_product_layout_style == 'global') {$rh_product_layout_style = rehub_option('product_layout_style');} ?>
<?php if ($rh_product_layout_style == '') :?>
    <?php $rh_product_layout_style = 'default_with_sidebar';?>
<?php endif;?>

<?php if($rh_product_layout_style == 'default_with_sidebar') : ?>
    <?php include(rh_locate_template('inc/product_layout/default_with_sidebar.php')); ?>
<?php elseif($rh_product_layout_style == 'default_no_sidebar') : ?>
    <?php include(rh_locate_template('inc/product_layout/default_no_sidebar.php')); ?>
<?php elseif($rh_product_layout_style == 'full_width_extended') : ?>
    <?php include(rh_locate_template('inc/product_layout/full_width_extended.php')); ?>   
<?php elseif($rh_product_layout_style == 'ce_woo_list') : ?>
    <?php include(rh_locate_template('inc/product_layout/ce_woo_list.php')); ?> 
<?php elseif($rh_product_layout_style == 'ce_woo_sections') : ?>
    <?php include(rh_locate_template('inc/product_layout/ce_woo_sections.php')); ?> 
<?php elseif($rh_product_layout_style == 'ce_woo_blocks') : ?>
    <?php include(rh_locate_template('inc/product_layout/ce_woo_blocks.php')); ?>     
<?php elseif($rh_product_layout_style == 'full_photo_booking') : ?>
    <?php include(rh_locate_template('inc/product_layout/full_photo_booking.php')); ?>  
<?php elseif($rh_product_layout_style == 'vendor_woo_list') : ?>
    <?php include(rh_locate_template('inc/product_layout/vendor_woo_list.php')); ?>   
<?php elseif($rh_product_layout_style == 'sections_w_sidebar') : ?>
    <?php include(rh_locate_template('inc/product_layout/sections_w_sidebar.php')); ?>                              
<?php else:?>
    <?php include(rh_locate_template('inc/product_layout/default_with_sidebar.php')); ?>                               
<?php endif;?>   

<!-- FOOTER -->
<?php get_footer(); ?>