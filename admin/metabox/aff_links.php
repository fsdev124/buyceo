<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php

return array(
	'id'          => 'rehub_framework_aff',
	'types'       => array('thirstylink'),
	'title'       => __('Price and description', 'rehub_framework'),
	'priority'    => 'low',
	'mode'        => WPALCHEMY_MODE_EXTRACT,
	'template'    => array(
						array(
							'type' => 'textbox',
							'name' => 'rehub_aff_price',
							'label' => __('Set sale price', 'rehub_framework'),
							'description' => __('Set sale price of offer (optional), example, 28.22$. Please, use dot in price (not comma)', 'rehub_framework'),
						),
						array(
							'type' => 'textbox',
							'name' => 'rehub_aff_price_old',
							'label' => __('Set old price', 'rehub_framework'),
							'description' => __('Set old price of offer (optional), example, 24.33$. Please, use dot in price (not comma).', 'rehub_framework'),
						),
						array(
							'type' => 'textbox',
							'name' => 'rehub_aff_coupon',
							'label' => __('Set coupon code', 'rehub_framework'),
							'description' => __('Set coupon code or leave blank', 'rehub_framework'),
						),	
					    array(
					        'type' => 'date',
					        'name' => 'rehub_aff_coupon_date',
					        'label' => __('Coupon End Date', 'rehub_framework'),
					        'format' => 'yy-mm-dd',
					    ),	
						array(
							'type' => 'toggle',
							'name' => 'rehub_aff_coupon_mask',
							'label' => __('Mask coupon code?', 'rehub_framework'),
							'description' => __('If this option is enabled, coupon code will be hidden.', 'rehub_framework'),
							'default' => '0',
						),					    																
						array(
							'type' => 'toggle',
							'name' => 'rehub_aff_sticky',
							'label' => __('Top link in list?', 'rehub_framework'),
							'description' => __('If this option is enabled, link will be visible on top of offers list', 'rehub_framework'),
							'default' => '0',
						),
						array(
							'type' => 'textbox',
							'name' => 'rehub_aff_desc',
							'label' => __('Description', 'rehub_framework'),
							'description' => __('Insert some description (optional)', 'rehub_framework'),
							'default' => '',
						),	
						array(
							'type' => 'textbox',
							'name' => 'rehub_aff_rel',
							'label' => __('Link to related review', 'rehub_framework'),
							'description' => __('Add link to related review or leave blank', 'rehub_framework'),
							'default' => '',
							'validation' => 'url',
						),						
						array(
							'type'      => 'textbox',
							'name'      => 'rehub_aff_btn_text',
							'label'     => __('Button text', 'rehub_framework'),
							'description' => __('Insert text on button or leave blank to use default text. Use short names', 'rehub_framework'),
							'validation' => 'maxlength[14]',														
						),																					
	),
);

/**
 * EOF
 */