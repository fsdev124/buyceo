<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php

return array(
	'id'          => 'rehub_catalog',
	'types'       => array('page'),
	'title'       => __('Catalogue constructor', 'rehub_framework'),
	'priority'    => 'low',
	'mode'        => WPALCHEMY_MODE_EXTRACT,
	'template'    => array(	
		array(
			'type' => 'textbox',
			'name' => 'catalog_fetch',
			'label' => __('Fetch Count', 'rehub_framework'),
			'description' => __('How much posts you\'d like to display?', 'rehub_framework'),
			'default' => '',
			'validation' => 'numeric',		
		),
		array(
			'type' => 'textbox',
			'name' => 'catalog_post_type',
			'label' => __('Name of post type', 'rehub_framework'),
			'description' => __('Enter name of your post type. By default, post', 'rehub_framework'),			
		),		
		array(
			'type' => 'textbox',
			'name' => 'catalog_tax',
			'label' => __('Enter taxonomy slug', 'rehub_framework'),
			'description' => __('Enter slug of your taxonomy. Example, taxonomy for posts - is category. Or leave blank', 'rehub_framework'),			
		),
		array(
			'type' => 'textbox',
			'name' => 'catalog_tax_slug',
			'label' => __('Show posts by taxonomy slug', 'rehub_framework'),
			'description' => __('Enter slug of your taxonomy if you want to show only posts from certain taxonomy (from field above)', 'rehub_framework'),			
		),
		array(
			'type' => 'toggle',
			'name' => 'catalog_tax_show',
			'label' => __('Show your taxonomy in meta of posts?', 'rehub_framework'),
			'default' => '0',
		),	
		array(
			'type' => 'textbox',
			'name' => 'catalog_desc',
			'label' => __('Show excerpt', 'rehub_framework'),
			'description' => __('Enter number of symbols for excerpt. Leave blank if you don\'t want to use exerpt' , 'rehub_framework'),
			'validation' => 'numeric',						
		),
		array(
			'type'      => 'group',
			'repeating' => true,
			'sortable'  => true,
			'name'      => 'catalog_fields',
			'title'     => __('Value from custom field', 'rehub_framework'),
			'fields'    => array(
				array(
					'type' => 'select',
					'name' => 'catalog_icon',
					'label' => __('Choose icon', 'rehub_framework'),
					'description' => __('Choose icon before field title or leave blank', 'rehub_framework'),
					'items' => array(
						'data' => array(
							array(
								'source' => 'function',
								'value'  => 'vp_get_fontawesome_icons',
							),
						),
					),
					'default' => '',			
				),				
				array(
					'type'      => 'textbox',
					'name'      => 'catalog_fields_title',
					'label'     => __('Title before value', 'rehub_framework'),
					'description' => __('Set title before value or leave blank', 'rehub_framework'),
				),
				array(
					'type'      => 'textbox',
					'name'      => 'catalog_fields_name',
					'label'     => __('Name of custom field', 'rehub_framework'),
				),				
			),
		),
		array(
			'type' => 'select',
			'name' => 'catalog_readmore',
			'label' => __('Add button to end?', 'rehub_framework'),
			'items' => array(
				array(
					'value' => 'read',
					'label' => __('Read more button', 'rehub_framework'),
				),
				array(
					'value' => 'buybutton',
					'label' => __('Buy/Affiliate Button (use only in Post post type!!!)', 'rehub_framework'),
				),
				array(
					'value' => 'none',
					'label' => __('Disable button', 'rehub_framework'),
				),				
			),
			'default' => 'none',
		),								

	),
    'include_template' => 'catalogue_constructor.php',
);

/**
 * EOF
 */