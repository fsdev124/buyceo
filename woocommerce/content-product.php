<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce_loop;
// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ) {
	if(rehub_option('woo_columns') == '4_col' || rehub_option('woo_columns') == '4_col_side') {
		$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
	}
	else {
		$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 3 );	
	}
}
// Increase loop count
$woocommerce_loop['loop']++;

// Store column count for displaying the grid
if(rehub_option('woo_columns') == '4_col' || rehub_option('woo_columns') == '4_col_side') {
	$columns = '4_col';
}
else {
	$columns = '3_col';
}
if (rehub_option('woo_design') == 'list'){
    include(rh_locate_template('inc/parts/woolistmain.php'));
}
elseif (rehub_option('woo_design') == 'grid'){
    include(rh_locate_template('inc/parts/woogridpart.php'));
}
else{
    include(rh_locate_template('inc/parts/woocolumnpart.php'));
}