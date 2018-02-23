<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */
global $product, $woocommerce_loop;
// Store column count for displaying the grid

$classes = array();
if(rehub_option('woo_columns') == '4_col' || rehub_option('woo_columns') == '4_col_side') {
	if (rehub_option('woo_design') != 'list') {
		$classes[] = 'col_wrap_fourth';
	}
}
else {
	if (rehub_option('woo_design') != 'list') {
		$classes[] = 'col_wrap_three';
	}
}
if (rehub_option('woo_design') == 'grid') {
	$classes[] = 'rh-flex-eq-height grid_woo';
}
elseif (rehub_option('woo_design') == 'list') {
	$classes[] = 'list_woo';
}
else {
	$classes[] = 'rh-flex-eq-height column_woo';
}
?>

<div class="products <?php echo implode(' ',$classes);?>">