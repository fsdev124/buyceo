<?php
//CREATE BRAND TAXONOMY

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if (!class_exists('WC_RH_Store_Taxonomy')) {
class WC_RH_Store_Taxonomy {
	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'woocommerce_register_taxonomy', array( $this, 'woo_product_store_init' ) );
		add_action( 'current_screen', array( $this, 'conditional_includes' ) );
	}
	/**
	* Create Store Taxonomy
	*/
	public function woo_product_store_init() {
		
		$permalinks = get_option( 'woocommerce_permalinks' );
		register_taxonomy(
			'store',
			'product',
			array(
				'labels' => array(
					'name'              => __( 'Affiliate Store', 'rehub_framework' ),
					'singular_name'     => __( 'Affiliate Store', 'rehub_framework' ),
					'search_items'      => __( 'Search store', 'rehub_framework' ),
					'all_items'         => __( 'All stores', 'rehub_framework' ),
					'parent_item'       => __( 'Parent store', 'rehub_framework' ),
					'parent_item_colon' => __( 'Parent store:', 'rehub_framework' ),
					'edit_item'         => __( 'Edit store', 'rehub_framework' ),
					'update_item'       => __( 'Update store', 'rehub_framework' ),
					'add_new_item'      => __( 'Add new store', 'rehub_framework' ),
					'new_item_name'     => __( 'New store name', 'rehub_framework' ),
					'menu_name'         => __( 'Affiliate Store', 'rehub_framework' ),
				),		
				'show_ui' => true,
				'show_admin_column' => true,
				'update_count_callback' => '_update_post_term_count',
				'hierarchical' => true,
				'public' => true,
				'query_var' => empty( $permalinks['store_base'] ) ? 'merchants' : $permalinks['store_base'],
				'show_in_quick_edit' => true,
				'rewrite' =>array(
					'slug' => empty( $permalinks['store_base'] ) ? 'merchants' : $permalinks['store_base'],
					'with_front'   => false,
					'hierarchical' => true,
				),
			)
		);
	}
	/**
	 * Include admin files conditionally.
	 */
	public function conditional_includes() {
		if ( ! $screen = get_current_screen() ) {
			return;
		}
		switch ( $screen->id ) {
			case 'options-permalink' :
				include( 'woo_store_permalink_class.php' );
			break;
		}
	}
}
}
return new WC_RH_Store_Taxonomy();