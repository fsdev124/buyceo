<?php
/**
 * Adds settings to the permalinks admin settings page
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if (!class_exists('WC_RH_Admin_Permalink_Stores')) {
class WC_RH_Admin_Permalink_Stores {
	/**
	 * Hook in tabs.
	 */
	public function __construct() {
		$this->settings_init();
		$this->settings_save();
	}
	/**
	 * Init settings.
	 */
	public function settings_init() {
		
		add_settings_field(
			'woocommerce_product_store_slug',            // id
			__( 'Brand Store base', 'rehub_framework' ),   // setting title
			array( $this, 'product_store_slug_input' ),  // display callback
			'permalink',                                    // settings page
			'optional'                                      // settings section
		);
	}
	/**
	 * Show a slug input box.
	 */
	public function product_store_slug_input() {
		$permalinks = get_option( 'woocommerce_permalinks' );
		?>
		<input name="woocommerce_product_store_slug" type="text" class="regular-text code" value="<?php if ( isset( $permalinks['store_base'] ) ) echo esc_attr( $permalinks['store_base'] ); ?>" placeholder="merchants" />
		<?php
	}
	/**
	 * Save the settings.
	 */
	public function settings_save() {
		if ( ! is_admin() ) {
			return;
		}

		// We need to save the options ourselves; settings api does not trigger save for the permalinks page.
		if ( isset( $_POST['permalink_structure'] ) ) {
			$permalinks = get_option( 'woocommerce_permalinks' );

			if ( ! $permalinks ) {
				$permalinks = array();
			}

			$permalinks['store_base']    = wc_sanitize_permalink( trim( $_POST['woocommerce_product_store_slug'] ) );

			update_option( 'woocommerce_permalinks', $permalinks );
		}
	}
}
}
return new WC_RH_Admin_Permalink_Stores();