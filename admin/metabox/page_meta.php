<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php

return array(
	'id'          => 'rehub_framework_brand',
	'types'       => array('post', 'page'),
	'title'       => __('Branded page option', 'rehub_framework'),
	'priority'    => 'high',
	'view' => WPALCHEMY_VIEW_START_CLOSED,
	'template'    => array(
						array(
							'type' => 'color',
							'name' => 'rehub_color_background_single',
							'label' => __('Background Color', 'rehub_framework'),
							'description' => __('Choose the background color', 'rehub_framework'),
						),
						array(
							'type' => 'upload',
							'name' => 'rehub_background_image_single',
							'label' => __('Background Image', 'rehub_framework'),
							'description' => __('Upload a background image', 'rehub_framework'),
							'default' => '',
						),
						array(
							'type' => 'select',
							'name' => 'rehub_background_repeat_single',
							'label' => __('Background Repeat', 'rehub_framework'),
							'items' => array(
								array(
									'value' => 'repeat',
									'label' => __('Repeat', 'rehub_framework'),
								),
								array(
									'value' => 'no-repeat',
									'label' => __('No Repeat', 'rehub_framework'),
								),
								array(
									'value' => 'repeat-x',
									'label' => __('Repeat X', 'rehub_framework'),
								),
								array(
									'value' => 'repeat-y',
									'label' => __('Repeat Y', 'rehub_framework'),
								),
							),
						),
						array(
							'type' => 'select',
							'name' => 'rehub_background_position_single',
							'label' => __('Background Position', 'rehub_framework'),
							'items' => array(
								array(
									'value' => 'left',
									'label' => 'Left',
								),
								array(
									'value' => 'center',
									'label' => 'Center',
								),
								array(
									'value' => 'right',
									'label' => 'Right',
								),
							),
						),
						array(
							'type' => 'textbox',
							'name' => 'rehub_background_offset_single',
							'label' => __('Set offset', 'rehub_framework'),
							'description' => __('Set offset from top for background (with px) for avoid header overlap', 'rehub_framework'),
							'validation' => 'numeric',
						),
						array(
							'type' => 'toggle',
							'name' => 'rehub_background_fixed_single',
							'label' => __('Fixed Background Image?', 'rehub_framework'),
							'description' => __('The background is fixed with regard to the viewport.', 'rehub_framework'),
						),
						array(
							'type' => 'toggle',
							'name' => 'rehub_background_sized_single',
							'label' => __('Fit size?', 'rehub_framework'),
							'description' => __('Set background image width and height to fit the size of window', 'rehub_framework'),
						),																			
						array(
							'type' => 'textbox',
							'name' => 'rehub_branded_bg_url_single',
							'label' => __('Url for branded background', 'rehub_framework'),
							'description' => __('Insert url that will be display on background', 'rehub_framework'),
							'default' => '',
							'validation' => 'url',
						),																																
						 array(
							'type' => 'notebox',
							'name' => 'rehub_branded_banner_note_single',
							'label' => __('Note', 'rehub_framework'),
							'description' => __('Branded area displays after header. You can set direct link on image or insert any html code or shortcode', 'rehub_framework'),
							'status' => 'normal',							
						),						
						array(
							'type' => 'textbox',
							'name' => 'rehub_branded_banner_image_single',
							'label' => __('Branded area', 'rehub_framework'),
							'description' => __('Set any custom code or link to image', 'rehub_framework'),
							'default' => '',
						),																
	),
);

/**
 * EOF
 */