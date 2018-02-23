<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php

return array(
	'id'          => 'rehub_framework_woo',
	'types'       => array('product'),
	'title'       => __('Additional Deals panel', 'rehub_framework'),
	'priority'    => 'low',
	'mode'        => WPALCHEMY_MODE_EXTRACT,
	'template'    => array(
		 array(
			'type' => 'notebox',
			'name' => 'rehub_woo_deal_note',
			'label' => __('Note!', 'rehub_framework'),
			'description' => __('You can show additional deals as woocommerce offers, thirstyaffiliate offers or any other data based on shortcode. Please, choose one of field below or leave blank this section. Read more in <a href="http://rehubdocs.wpsoul.com/docs/rehub-theme/affiliate-settings/woocommerce-as-hub-of-deals/" target="_blank">documentation</a>', 'rehub_framework'),
			'status' => 'info',
		),			
		array(
			'type' => 'textbox',
			'name' => 'review_woo_id',
			'label' => __('Set related post ID', 'rehub_framework'),
			'description' => __('Set ID of post with review of this product', 'rehub_framework'),			
			'default' => '',
		),																						
	),
);

/**
 * EOF
 */