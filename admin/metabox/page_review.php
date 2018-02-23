<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php

return array(
	'id'          => 'rehub_top_review',
	'types'       => array('page'),
	'title'       => __('Top review settings', 'rehub_framework'),
	'priority'    => 'low',
	'mode'        => WPALCHEMY_MODE_EXTRACT,
	'template'    => array(
		array(
			'type' => 'select',
			'name' => 'top_review_choose',
			'label' => __('Choose by', 'rehub_framework'),
			'items' => array(
				array(
					'value' => 'cat_choose',
					'label' => __('Category and/or tag', 'rehub_framework'),
				),
				array(
					'value' => 'manual_choose',
					'label' => __('Manual select and order', 'rehub_framework'),
				),
			),
			'default' => 'cat_choose',
		),		
		array(
			'type' => 'select',
			'name' => 'top_review_cat',
			'label' => __('Choose category', 'rehub_framework'),
			'description' => __('Choose the category that you\'d like to include to top review page', 'rehub_framework'),
			'items' => array(
				'data' => array(
					array(
						'source' => 'function',
						'value'  => 'vp_get_categories',
					),
				),
			),
			'default' => '',
			'dependency' => array(
				'field'    => 'top_review_choose',
				'function' => 'top_review_choose_is_cat',
			),			
		),
		array(
			'type' => 'textbox',
			'name' => 'top_review_tag',
			'label' => __('Enter tag', 'rehub_framework'),
			'description' => __('Leave blank or set tag of posts', 'rehub_framework'),
			'dependency' => array(
				'field'    => 'top_review_choose',
				'function' => 'top_review_choose_is_cat',
			),			
		),
		array(
			'type' => 'textbox',
			'name' => 'top_review_fetch',
			'label' => __('Fetch Count', 'rehub_framework'),
			'description' => __('How much posts you\'d like to display?', 'rehub_framework'),
			'default' => '',
			'validation' => 'numeric',
			'dependency' => array(
				'field'    => 'top_review_choose',
				'function' => 'top_review_choose_is_cat',
			),			
		),					
		array(
			'type' => 'multiselect',
			'name' => 'manual_ids',
			'label' => __('Choose posts', 'rehub_framework'),
			'description' => __('Choose posts and order', 'rehub_framework'),
			'items' => array(
				'data' => array(
					array(
						'source' => 'function',
						'value'  => 'rehub_manual_ids_func',
					),
				),
			),
			'dependency' => array(
				'field'    => 'top_review_choose',
				'function' => 'top_review_choose_is_manual',
			),			
		),		

		array(
			'type' => 'select',
			'name' => 'top_review_desc',
			'label' => __('Get description from:', 'rehub_framework'),
			'items' => array(
				array(
					'value' => 'post',
					'label' => __('First 120 symbols of post', 'rehub_framework'),
				),
				array(
					'value' => 'review',
					'label' => __('Description of review', 'rehub_framework'),
				),
				array(
					'value' => 'field',
					'label' => __('Custom fields', 'rehub_framework'),
				),				
				array(
					'value' => 'none',
					'label' => __('Disable description', 'rehub_framework'),
				),
			),
			'default' => array(
				'post',
			),
		),
		array(
			'type' => 'textbox',
			'name' => 'top_review_custom_fields',
			'label' => __('Custom field', 'rehub_framework'),
			'description' => __('Enter name of custom field of post. Value of this custom field will be used for description', 'rehub_framework'),
			'dependency' => array(
				'field'    => 'top_review_desc',
				'function' => 'use_fields_as_desc',
			),			
		),				
		array(
			'type' => 'select',
			'name' => 'top_review_circle',
			'label' => __('Design of rating', 'rehub_framework'),
			'items' => array(
				array(
					'value' => '0',
					'label' => __('Simple text', 'rehub_framework'),
				),
				array(
					'value' => '1',
					'label' => __('Circle design', 'rehub_framework'),
				),
				array(
					'value' => '2',
					'label' => __('Square design', 'rehub_framework'),
				),				
			),
			'default' => '1',
		),	

		array(
			'type' => 'textbox',
			'name' => 'top_review_field_sort',
			'label' => __('Base of sorting', 'rehub_framework'),
			'description' => __('By default all posts are sorting by value of overall rating. But you can set name of custom field for sorting. Important! It must have numeric value', 'rehub_framework'),			
		),

		array(
			'type' => 'select',
			'name' => 'top_review_order',
			'label' => __('Order of sorting:', 'rehub_framework'),
			'items' => array(
				array(
					'value' => 'desc',
					'label' => __('from highest to lowest', 'rehub_framework'),
				),
				array(
					'value' => 'asc',
					'label' => __('from lowest to highest', 'rehub_framework'),
				),
			),
			'default' => array(
				'desc',
			),			
		),
		array(
			'type' => 'toggle',
			'name' => 'top_review_pagination',
			'label' => __('Enable pagination?', 'rehub_framework'),
			'default' => '0',
		),
		array(
			'type' => 'toggle',
			'name' => 'top_review_width',
			'label' => __('Full width?', 'rehub_framework'),
			'default' => '1',
		),								
		array(
			'type' => 'html',
			'name' => 'shortcode_top',
			'label' => __('Shortcode', 'rehub_framework'),
			'description' => __('Shortcode', 'rehub_framework'),
			'binding' => array(
				'field' => '',
				'function' => 'top_list_shortcode',
			)
		),
		array(
			'type' => 'toggle',
			'name' => 'shortcode_review_enable',
			'label' => __('If enabled - content of top reviews page will be inserted on page only by shortcode above.', 'rehub_framework'),
			'default' => '0',
		),									
	),
    'include_template' => 'template-toprating.php',
);

/**
 * EOF
 */