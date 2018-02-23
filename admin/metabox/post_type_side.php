<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php $def_p_types = rehub_option('rehub_ptype_formeta');?>
<?php $def_p_types = (!empty($def_p_types)) ? (array)$def_p_types : array('post', 'blog')?>
<?php

return array(
	'id'          => 'rehub_post_side',
	'types'       => $def_p_types,
	'title'       => __('Post settings', 'rehub_framework'),
	'priority'    => 'low',
	'mode'        => WPALCHEMY_MODE_EXTRACT,
	'context'     => 'side',
	'template'    => array(

		array(
			'type' => 'textbox',
			'name' => 'read_more_custom',
			'label' => __('Read More custom text', 'rehub_framework'),
			'description' => __('Will be used in some blocks instead of default read more text', 'rehub_framework'),
			'default' => '',
		),	

		array(
			'type' => 'select',
			'name' => '_post_layout',
			'label' => __('Post layout', 'rehub_framework'),
			'default' => 'normal_post',
			'items' => array(
				'data' => array(
					array(
						'source' => 'function',
						'value'  => 'rehub_get_post_layout_array',
					),
				),
			),			
		),			

		array(
			'type' => 'radiobutton',
			'name' => 'post_size',
			'label' => __('Post w/ sidebar or Full width', 'rehub_framework'),
			'default' => 'normal_post',
			'items' => array(
				array(
					'value' => 'normal_post',
					'label' => __('Post w/ Sidebar', 'rehub_framework'),
				),
				array(
					'value' => 'full_post',
					'label' => __('Full Width Post', 'rehub_framework'),
				)
			)
		),

		rehub_custom_badge_admin(),

		array(
			'type' => 'toggle',
			'name' => 'show_featured_image',
			'label' => __('Disable Featured Image, Video or Gallery in top part on post page', 'rehub_framework'),
			'default' => '0',
		),		
		array(
			'type' => 'textbox',
			'name' => 'rehub_branded_banner_image_single',
			'label' => __('Branded area', 'rehub_framework'),
			'description' => __('Set any custom code or link to image for branded banner after header ', 'rehub_framework'),
			'default' => '',
		),
		array(
			'type' => 'toggle',
			'name' => 'disable_parts',
			'label' => __('Disable parts?', 'rehub_framework'),
			'description' => __('Check this box if you want to disable tags, breadcrumbs, author box, share buttons in post', 'rehub_framework'),
		), 		

		array(
			'type' => 'toggle',
			'name' => 'show_banner_ads',
			'label' => __('Disable global ads in post', 'rehub_framework'),
			'description' => '',
			'default' => '0',			
		),		
	),
);

/**
 * EOF
 */