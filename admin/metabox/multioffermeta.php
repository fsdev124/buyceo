<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php

return  array(
	'id'          => 'post_rehub_offers',
	'types'       => array('post'),
	'title'       => __('Post Offer Boxes', 'rehub_framework'),
	'priority'    => 'low',
	'mode'        => WPALCHEMY_MODE_EXTRACT,
	'template'    => array(
		array(
			'type'      => 'group',
			'repeating' => true,
			'sortable' => true,
			'name'      => 'rehub_multioffer_group',
			'title'     => __('Post Offer Box', 'rehub_framework'),
			'fields'    => array(
				array(
					'label'=> __('Featured Offer', 'rehub_framework'),
					'description'  => __('If enabled, the Offer will be displayed with Badge', 'rehub_framework'),
					'name'    => 'featured_multioffer',
					'type'  => 'toggle',
					'default' => '0'
				),
				array(
					'label'=>  __('Offer url', 'rehub_framework'),
					'description'  => __('Insert url of offer', 'rehub_framework'),
					'name'    => 'multioffer_url',
					'type'  => 'textbox',
					'validation' => 'url',
				),	
				array(
					'label'=>  __('Name of product', 'rehub_framework'),
					'description'  => __('Insert title or leave blank', 'rehub_framework'),
					'name'    => 'multioffer_name',
					'type'  => 'textbox'
				),
				array(
					'label'=>  __('Short description of product', 'rehub_framework'),
					'description'  => __('Enter description of product or leave blank', 'rehub_framework'),
					'name'    => 'multioffer_desc',
					'type'  => 'textbox'
				), 
				array(
					'label'=>  __('Offer old price', 'rehub_framework'),
					'description'  => __('Insert old price of offer or leave blank', 'rehub_framework'),
					'name'    => 'multioffer_price_old',
					'type'  => 'textbox'
				), 
				array(
					'label'=>  __('Offer sale price', 'rehub_framework'),
					'description'  => __('Insert sale price of offer (example, $55). Please, choose your price pattern in theme options - localizations', 'rehub_framework'),
					'name'    => 'multioffer_price',
					'type'  => 'textbox'
				),  
				array(
					'label'=>  __('Set coupon code', 'rehub_framework'),
					'description'  => __('Set coupon code or leave blank', 'rehub_framework'),
					'name'    => 'multioffer_coupon',
					'type'  => 'textbox'
				),            
				array(
					'label' => __('Coupon End Date', 'rehub_framework'),
					'description'  => __('Choose expiration date of coupon or leave blank', 'rehub_framework'),
					'name'    => 'multioffer_date',
					'type'  => 'date'
				),    
				array(
					'label'=> __('Make coupon reveal?', 'rehub_framework'),
					'name'    => 'multioffer_mask',
					'type'  => 'toggle',
					'default' => '0'
				),				
				array(
					'label'=> __('Button text', 'rehub_framework'),
					'description'  => __('Insert text on button or leave blank to use default text. Use short names (not more than 14 symbols)', 'rehub_framework'),
					'name'    => 'multioffer_btn_text',
					'type'  => 'textbox'
				),
				array(
					'type'      => 'upload',
					'name'      => 'multioffer_image',
					'label'     => __('Add Custom Image of offer', 'rehub_framework'),
				),				
				array(
					'type' => 'radiobutton',
					'name' => 'offer_assign',
					'label' => __('Assign offer to', 'rehub_framework'),
					'items' => array(
						array(
							'value' => '0',
							'label' => __('Admin', 'rehub_framework'),
						),						
						array(
							'value' => 'user',
							'label' => __('Custom User', 'rehub_framework'),
						),
					),
				),	
				array(
					'label'=> __('User ID', 'rehub_framework'),
					'name' => 'multioffer_user',
					'type'  => 'textbox',
					'default' => '',
					'validation' => 'numeric',
					'dependency' => array(
						'field'    => 'offer_assign',
						'function' => 'user_rev_type',
					),					
				),
				array(
					'type' => 'html',
					'name' => 'multioffer_user_info',
					'dependency' => array(
						'field'    => 'offer_assign',
						'function' => 'user_rev_type',
					),					
					'binding' => array(
						'field'    => 'multioffer_user',
						'function' => 'rehub_get_offer_user_info',
					),
				),				
				array(
					'type' => 'select',
					'name' => 'multioffer_brand',
					'label' => __('Choose brand', 'rehub_framework'),
					'description'=> __('You can enable brand(store) taxonomy in Theme option - Affiliate or leave blank', 'rehub_framework'),
					'items' => array(
						'data' => array(
							array(
								'source' => 'function',
								'value'  => 'rehub_get_dealstore_tax_array',
							),
						),
					),					
				),							
			),
		),
		array(
			'type' => 'html',
			'name' => '_multioffer_shortcode',
			'label' => __('Shortcode', 'rehub_framework'),
			'description' => __('Shortcode', 'rehub_framework'),
			'binding' => array(
				'field' => '',
				'function' => 'rh_meta_multioffer_shortcode',
			)
		),
	),
);
