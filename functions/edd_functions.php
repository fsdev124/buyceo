<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php

// EDD functions
if( !function_exists('twentytwelve_edd_shortcode_atts_downloads') ) {
function twentytwelve_edd_shortcode_atts_downloads( $atts ) {
	$atts[ 'columns' ]      = '1';
	$atts[ 'full_content' ] = 'no';
	$atts[ 'excerpt' ]      = 'no';
	return $atts;
}
}
add_filter( 'shortcode_atts_downloads', 'twentytwelve_edd_shortcode_atts_downloads' );

if( !function_exists('rate_edd') ) {
function rate_edd() {
  	echo rehub_get_user_rate('user');	
}
}
add_action( 'edd_product_details_widget_before_purchase_button', 'rate_edd' );

if( !function_exists('rehub_edd_show_download_sales') ) {
function rehub_edd_show_download_sales() {
	if(rehub_option('rehub_framework_edd_counter') =='1'){
		echo '<p>';
		echo edd_get_download_sales_stats( get_the_ID() ) . ' sales';
		echo '<br/>';
		echo sumobi_edd_get_download_count( get_the_ID() ) . ' downloads';
		echo '</p>';
	}
}
}
add_action( 'edd_product_details_widget_before_purchase_button', 'rehub_edd_show_download_sales' );

if( !function_exists('sumobi_edd_get_download_count') ) { 
function sumobi_edd_get_download_count( $download_id = 0 ) {
	global $edd_logs;
	$meta_query = array(
		'relation'	=> 'AND',
		array(
			'key' => '_edd_log_file_id'
		),
		array(
			'key' => '_edd_log_payment_id'
		)
	);
	return $edd_logs->get_log_count( $download_id, 'file_download', $meta_query );
}
}