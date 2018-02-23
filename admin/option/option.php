<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php
$theme_options =  array(
	'title' => __('Theme Options', 'rehub_framework'),
	'page' => 'Rehub Theme Options',
	'logo' => '',
	'menus' => array(
		array(
			'title' => __('General Options', 'rehub_framework'),
			'name' => 'menu_1',
			'icon' => 'font-awesome:fa-codepen',
			'controls' => array(
				array(
					'type' => 'section',
					'title' => __('General Options', 'rehub_framework'),
					'fields' => array(				
						array(
							'type' => 'select',
							'name' => 'rehub_framework_archive_layout',
							'label' => __('Select Blog Layout', 'rehub_framework'),
							'description' => __('Select what kind of post string layout you want to use for blog, archives', 'rehub_framework'),
							'items' => array(
								array(
									'value' => 'rehub_framework_archive_blog',
									'label' => __('Blog Layout', 'rehub_framework'),
								),								
								array(
									'value' => 'rehub_framework_archive_list',
									'label' => __('List Layout with left thumbnails', 'rehub_framework'),
								),	
								array(
									'value' => 'rehub_framework_archive_grid',
									'label' => __('Grid layout', 'rehub_framework'),
								),
								array(
									'value' => 'rehub_framework_archive_gridfull',
									'label' => __('Full width Grid layout', 'rehub_framework'),
								),	
								array(
									'value' => 'column_grid',
									'label' => __('Equal height Grid layout', 'rehub_framework'),
								),
								array(
									'value' => 'column_grid_full',
									'label' => __('Equal height Full width Grid layout', 'rehub_framework'),
								),																														
							),
							'default' => array(
								'rehub_framework_archive_list',
							),
						),
						array(
							'type' => 'select',
							'name' => 'rehub_framework_category_layout',
							'label' => __('Select Category Layout', 'rehub_framework'),
							'description' => __('Select what kind of post string layout you want to use for categories', 'rehub_framework'),
							'items' => array(
								array(
									'value' => 'rehub_framework_category_blog',
									'label' => __('Blog Layout', 'rehub_framework'),
								),								
								array(
									'value' => 'rehub_framework_category_list',
									'label' => __('List Layout with left thumbnails', 'rehub_framework'),
								),
								array(
									'value' => 'rehub_framework_category_grid',
									'label' => __('Masonry Grid layout with sidebar', 'rehub_framework'),
								),	
								array(
									'value' => 'rehub_framework_category_gridfull',
									'label' => __('Masonry Full width Grid layout', 'rehub_framework'),
								),
								array(
									'value' => 'column_grid',
									'label' => __('Equal height Grid layout', 'rehub_framework'),
								),
								array(
									'value' => 'column_grid_full',
									'label' => __('Equal height Full width Grid layout', 'rehub_framework'),
								),																																	
							),
							'default' => array(
								'rehub_framework_category_list',
							),
						),
						array(
							'type' => 'select',
							'name' => 'rehub_framework_search_layout',
							'label' => __('Select Search Layout', 'rehub_framework'),
							'description' => __('Select what kind of post string layout you want to use for search pages', 'rehub_framework'),
							'items' => array(							
								array(
									'value' => 'rehub_framework_archive_blog',
									'label' => __('Blog Layout', 'rehub_framework'),
								),								
								array(
									'value' => 'rehub_framework_archive_list',
									'label' => __('List Layout with left thumbnails', 'rehub_framework'),
								),	
								array(
									'value' => 'rehub_framework_archive_grid',
									'label' => __('Grid layout', 'rehub_framework'),
								),
								array(
									'value' => 'rehub_framework_archive_gridfull',
									'label' => __('Full width Grid layout', 'rehub_framework'),
								),	
								array(
									'value' => 'column_grid',
									'label' => __('Equal height Grid layout', 'rehub_framework'),
								),
								array(
									'value' => 'column_grid_full',
									'label' => __('Equal height Full width Grid layout', 'rehub_framework'),
								),		
							),
							'default' => array(
								'rehub_framework_archive_list',
							),
						),
						array(
							'type' => 'select',
							'name' => 'post_layout_style',
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
							'default' => array(
								'default',
							),
						),													
											
						array(
							'type' => 'textarea',
							'name' => 'rehub_custom_css',
							'label' => __('Custom CSS', 'rehub_framework'),
							'description' => __('Write your custom CSS here', 'rehub_framework'),
						),						
						array(
							'type' => 'textarea',
							'name' => 'rehub_analytics',
							'label' => __('Js code for footer', 'rehub_framework'),
							'description' => __('Enter your Analytics code or any html, js code', 'rehub_framework'),
						),	
						array(
							'type' => 'textarea',
							'name' => 'rehub_analytics_header',
							'label' => __('Js code for header (analytics)', 'rehub_framework'),						
						),												
						array(
							'type' => 'toggle',
							'name' => 'rehub_enable_front_vc',
							'label' => __('Enable frontend in visual composer?', 'rehub_framework'),
							'default' => '0',
						),
					),
				),
			),
		),
		array(
			'title' => __('Appearance/Color', 'rehub_framework'),
			'name' => 'menu_6',
			'icon' => 'font-awesome:fa-pencil-square-o',
			'controls' => array(
				array(
					'type' => 'section',
					'title' => __('Color schema of website', 'rehub_framework'),
					'fields' => array(
						array(
							'type' => 'color',
							'name' => 'rehub_custom_color',
							'label' => __('Custom color schema', 'rehub_framework'),
							'description' => __('Default theme color schema is green, but you can set your own main color (it will be used under white text)', 'rehub_framework'),
							'format' => 'hex',
						),
						array(
							'type' => 'color',
							'name' => 'rehub_sec_color',
							'label' => __('Custom secondary color', 'rehub_framework'),
							'description' => __('Set secondary color (for search buttons, tabs, etc).', 'rehub_framework'),
							'format' => 'hex',
							'default'=> '#000000',							

						),							
						array(
							'type' => 'color',
							'name' => 'rehub_btnoffer_color',
							'label' => __('Set offer buttons color', 'rehub_framework'),
							'format' => 'hex',
							'default'=> '#43c801',						
						),	
						array(
							'type' => 'toggle',
							'name' => 'enable_smooth_btn',
							'label' => __('Enable smooth design for inputs?', 'rehub_framework'),
							'default' => '0',
						),						
						array(
							'type' => 'color',
							'name' => 'rehub_color_link',
							'label' => __('Custom color for links inside posts', 'rehub_framework'),
							'format' => 'hex',	
						),											
					),
				),
				array(
					'type' => 'section',
					'title' => __('Layout settings', 'rehub_framework'),
					'fields' => array(
						array(
							'type' => 'toggle',
							'name' => 'rehub_sidebar_left',
							'label' => __('Set sidebar to left side?', 'rehub_framework'),
							'default' => '0',
						),	
						array(
							'type' => 'toggle',
							'name' => 'rehub_body_block',
							'label' => __('Enable boxed version?', 'rehub_framework'),
							'default' => '0',
						),						
						array(
							'type' => 'toggle',
							'name' => 'rehub_content_shadow',
							'label' => __('Disable box borders under content box?', 'rehub_framework'),				
						),													
						array(
							'type' => 'color',
							'name' => 'rehub_color_background',
							'label' => __('Background Color', 'rehub_framework'),
							'description' => __('Choose the background color', 'rehub_framework'),
							'format' => 'hex',
						),
						array(
							'type' => 'upload',
							'name' => 'rehub_background_image',
							'label' => __('Background Image', 'rehub_framework'),
							'description' => __('Upload a background image. Works only if you set also background color above', 'rehub_framework'),
							'default' => '',
						),
						array(
							'type' => 'select',
							'name' => 'rehub_background_repeat',
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
							'default' => array(
								'repeat',
							),
						),
						array(
							'type' => 'select',
							'name' => 'rehub_background_position',
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
							'name' => 'rehub_background_offset',
							'label' => __('Set offset', 'rehub_framework'),
							'description' => __('Set offset from top for background (without px) for avoid header overlap', 'rehub_framework'),
							'validation' => 'numeric',
						),
						array(
							'type' => 'toggle',
							'name' => 'rehub_background_fixed',
							'label' => __('Fixed Background Image?', 'rehub_framework'),
							'description' => __('The background is fixed with regard to the viewport.', 'rehub_framework'),
						),
						array(
							'type' => 'toggle',
							'name' => 'rehub_sized_background',
							'label' => __('Fit size?', 'rehub_framework'),
							'description' => __('Set background image width and height to fit the size of window', 'rehub_framework'),
						),												
						array(
							'type' => 'textbox',
							'name' => 'rehub_branded_bg_url',
							'label' => __('Url for branded background', 'rehub_framework'),
							'description' => __('Insert url that will be display on background', 'rehub_framework'),
							'default' => '',
							'validation' => 'url',
						),																			
					),
				),				
			),
		),
	)
);

$theme_options_common = include(get_template_directory() . '/admin/option/option_common.php');
foreach ($theme_options_common as $theme_options_add) {
    $theme_options['menus'][] = $theme_options_add;
}

return $theme_options;

/**
 *EOF
 */