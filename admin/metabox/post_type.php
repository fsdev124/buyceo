<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php $def_p_types = rehub_option('rehub_ptype_formeta');?>
<?php $def_p_types = (!empty($def_p_types)) ? (array)$def_p_types : array('post', 'blog')?>
<?php
return array(
	'id'          => 'rehub_post',
	'types'       => $def_p_types,
	'title'       => __('Post Type', 'rehub_framework'),
	'priority'    => 'high',
	'mode'        => WPALCHEMY_MODE_EXTRACT,
	'template'    => array(
		array(
			'type' => 'radioimage',
			'name' => 'rehub_framework_post_type',
			'label' => __('Choose Type of Post', 'rehub_framework'),
			'description' => '',
			'items' => array(
				array(
					'value' => 'regular',
					'label' => __('Regular', 'rehub_framework'),
					'img' => REHUB_ADMIN_URI . '/public/img/regular_post_icon.png',
				),
				array(
					'value' => 'video',
					'label' => __('Video', 'rehub_framework'),
					'img' => REHUB_ADMIN_URI . '/public/img/video_post_icon.png',
				),
				array(
					'value' => 'gallery',
					'label' => __('Gallery', 'rehub_framework'),
					'img' => REHUB_ADMIN_URI . '/public/img/gallery_post_icon.png',
				),
				array(
					'value' => 'review',
					'label' => __('Review', 'rehub_framework'),
					'img' => REHUB_ADMIN_URI . '/public/img/review_post_icon.png',
				),
				array(
					'value' => 'music',
					'label' => __('Music', 'rehub_framework'),
					'img' => REHUB_ADMIN_URI . '/public/img/music_post_icon.png',
				),
			),
			'default' => 'regular'
		),
		
		
		// video group
		array(
			'type'      => 'group',
			'repeating' => false,
			'length'    => 1,
			'name'      => 'video_post',
			'title'     => __('Video Post', 'rehub_framework'),
			'dependency' => array(
				'field'    => 'rehub_framework_post_type',
				'function' => 'rehub_framework_post_type_is_video',
			),
			'fields'    => array(
				// embed
				array(
					'type' => 'textbox',
					'name' => 'video_post_embed_url',
					'description' => __('Insert youtube or vimeo link on page with video', 'rehub_framework'),
					'label' => __('Video Url', 'rehub_framework'),
				),				
				array(
					'type' => 'toggle',
					'name' => 'video_post_schema_thumb',
					'label' => __('Auto thumbnail', 'rehub_framework'),
					'description' => __('Enable auto featured image from video (will not work on some servers)', 'rehub_framework'),					
				),
				array(
					'type' => 'toggle',
					'name' => 'video_post_schema',
					'label' => __('Enable schema.org for video?', 'rehub_framework'),
					'description' => __('Check this box if you want to enable videoobject schema', 'rehub_framework'),
				),	
				array(
					'type' => 'textbox',
					'name' => 'video_post_schema_title',
					'label' => __('Title', 'rehub_framework'),
					'description' => __('Set title of video block or leave blank to use post title', 'rehub_framework'),					
					'dependency' => array(
                         'field' => 'video_post_schema',
                         'function' => 'vp_dep_boolean',
                    ),
					'default' => '',
				),
				array(
					'type' => 'textbox',
					'name' => 'video_post_schema_desc',
					'label' => __('Description', 'rehub_framework'),
					'description' => __('Set description of video block or leave blank to use post excerpt', 'rehub_framework'),					
					'dependency' => array(
                         'field' => 'video_post_schema',
                         'function' => 'vp_dep_boolean',
                    ),
					'default' => '',
				),																			
			),
		),
		// gallery group
		array(
			'type'      => 'group',
			'repeating' => false,
			'length'    => 1,
			'name'      => 'gallery_post',
			'title'     => __('Gallery Post', 'rehub_framework'),
			'dependency' => array(
				'field'    => 'rehub_framework_post_type',
				'function' => 'rehub_framework_post_type_is_gallery',
			),
			
			'fields'    => array(
				array(
					'type' => 'toggle',
					'name' => 'gallery_post_images_resize',
					'label' => __('Disable height resize for slider', 'rehub_framework'),
					'description' => __('This option disable resize of photo. By default, photos are resized for 400 px height', 'rehub_framework'),												
				),				
				array(
					'type'      => 'group',
					'repeating' => true,
					'name'      => 'gallery_post_images',
					'title'     => __('Image', 'rehub_framework'),
					'fields'    => array(
						array(
							'type'      => 'upload',
							'name'      => 'gallery_post_image',
							'label'     => __('Add Image', 'rehub_framework'),
						),
						array(
							'type'      => 'textbox',
							'name'      => 'gallery_post_image_caption',
							'label'     => __('Caption', 'rehub_framework'),
						),
						array(
							'type' => 'textbox',
							'name' => 'gallery_post_video',
							'description' => __('Insert youtube link of page with video. If you set this field, image and caption will be ignored for this slide', 'rehub_framework'),
							'label' => __('Video Url', 'rehub_framework'),
						),													
					),
				),
			),
		),
		// review group
		array(
			'type'      => 'group',
			'repeating' => false,
			'length'    => 1,
			'name'      => 'review_post',
			'title'     => 'Review Post',
			'dependency' => array(
				'field'    => 'rehub_framework_post_type',
				'function' => 'rehub_framework_post_type_is_review',
			),
			'fields'    => array(
				array(
					'type' => 'toggle',
					'name' => 'rehub_review_slider',
					'label' => __('Add slider of images to top of review page?', 'rehub_framework'),
					'default' => '0',
				),
				array(
					'type' => 'toggle',
					'name' => 'rehub_review_slider_resize',
					'label' => __('Disable height resize for slider', 'rehub_framework'),
					'description' => __('This option disable resize of photo. By default, photos are resized for 400 px height', 'rehub_framework'),
					'dependency' => array(
                         'field' => 'rehub_review_slider',
                         'function' => 'vp_dep_boolean',
                    ),										
				),				
				array(
					'type'      => 'group',
					'repeating' => true,
					'sortable'  => true,
					'name'      => 'rehub_review_slider_images',
					'title'     => __('Images', 'rehub_framework'),
					'fields'    => array(
						array(
							'type'      => 'upload',
							'name'      => 'review_post_image',
							'label'     => __('Add Image', 'rehub_framework'),
						),
						array(
							'type'      => 'textbox',
							'name'      => 'review_post_image_caption',
							'label'     => __('Caption', 'rehub_framework'),
						),	
						array(
							'type'      => 'textbox',
							'name'      => 'review_post_image_url',
							'label'     => __('Url for image', 'rehub_framework'),
						),						
						array(
							'type' => 'textbox',
							'name' => 'review_post_video',
							'description' => __('Insert youtube link of page with video. If you set this field, image and caption will be ignored for this slide', 'rehub_framework'),
							'label' => __('Video Url', 'rehub_framework'),
						),											
					),
					'dependency' => array(
                         'field' => 'rehub_review_slider',
                         'function' => 'vp_dep_boolean',
                    ),					
				),


				 array(
					'type' => 'select',
					'name' => 'review_post_schema_type',
					'label' => __('Connect review to offer', 'rehub_framework'),
					'items' => array(
						array(
						'value' => 'review_post_review_simple',
						'label' => __('No connections', 'rehub_framework'),
						),
						array(
						'value' => 'review_woo_product',
						'label' => __('Woocommerce offer review', 'rehub_framework'),
						),	
						array(
						'value' => 'review_woo_list',
						'label' => __('Woocommerce offers list review', 'rehub_framework'),
						),																		
					),
					'default' => array(
						'review_post_review_simple',
					),
				),

				array(
					'type' => 'notebox',
					'name' => 'offer_add',
					'label' => __('Important', 'rehub_framework'),
					'description' => __('You can connect review with woocommerce product in select above. If you want to add offer directly to post, use Post offer section below or Content Egg Offer module. Check <a href="http://rehubdocs.wpsoul.com/docs/rehub-theme/affiliate-settings/" target="_blank">help for affiliate functions of theme</a>', 'rehub_framework'),
					'status' => 'info',
				),				 

				array(
					'type' => 'notebox',
					'name' => 'review_countdown_note',
					'label' => __('Note', 'rehub_framework'),
					'description' => __('You can add countdown before offer with shortcode. Example - [wpsm_countdown year="2015" month="04" day="03" hour="14"]', 'rehub_framework'),
					'status' => 'normal',
				),				 	

				array(
					'type'      => 'group',
					'repeating' => false,
					'length'    => 1,
					'name'      => 'review_woo_product',
					'title'     => __('Woocommerce offer', 'rehub_framework'),
					'dependency' => array(
						'field'    => 'review_post_schema_type',
						'function' => 'review_post_schema_type_is_woo',
					),
					'fields'    => array(
						
						array(
							'type' => 'textbox',
							'name' => 'review_woo_link',
							'label' => __('Set woocommerce product', 'rehub_framework'),
							'description' => __('Type name of woocommerce product', 'rehub_framework'),
							'default' => '',
						),
						array(
							'type' => 'toggle',
							'name' => 'review_woo_slider',
							'label' => __('Enable slider', 'rehub_framework'),
							'description' => __('This option enables slider in top of review page with images from woocommerce gallery', 'rehub_framework'),					
						),	

						array(
							'type' => 'toggle',
							'name' => 'review_woo_slider_resize',
							'label' => __('Disable height resize for slider', 'rehub_framework'),
							'description' => __('This option disable resize of photo. By default, photos are resized for 400 px height', 'rehub_framework'),
							'dependency' => array(
		                         'field' => 'review_woo_slider',
		                         'function' => 'vp_dep_boolean',
		                    ),												
						),																								

						array(
							'type' => 'toggle',
							'name' => 'review_woo_offer_shortcode',
							'label' => __('Enable shortcode inserting', 'rehub_framework'),
							'description' => __('If enable you can insert offer box in any place of content with shortcode [woo_offer_product]. If disable - it will be before review box.', 'rehub_framework'),					
						),																																																

					),
				),

				array(
					'type'      => 'group',
					'repeating' => false,
					'length'    => 1,
					'name'      => 'review_woo_list',
					'title'     => __('Woocommerce offers list', 'rehub_framework'),
					'dependency' => array(
						'field'    => 'review_post_schema_type',
						'function' => 'review_post_schema_type_is_woo_list',
					),
					'fields'    => array(
						array(
							'type' => 'textbox',
							'name' => 'review_woo_list_links',
							'label' => __('Set woocommerce products', 'rehub_framework'),
							'description' => __('Type woocommerce names', 'rehub_framework'),		
						),					
						array(
							'type' => 'toggle',
							'name' => 'review_woo_list_shortcode',
							'label' => __('Enable shortcode inserting', 'rehub_framework'),
							'description' => __('If enable you can insert offers list in any place of content with shortcode [woo_offer_list]. If disable - it will be before review box.', 'rehub_framework'),					
						),																																																

					),
				),												 

				array(
					'type'      => 'textbox',
					'name'      => 'review_post_heading',
					'label'     => __('Review Heading', 'rehub_framework'),
					'description' => __('Short review heading (e.g. Excellent!)', 'rehub_framework'),
				),
				array(
					'type'      => 'textarea',
					'name'      => 'review_post_summary_text',
					'label'     => __('Summary Text', 'rehub_framework'),
				),
				array(
					'type'      => 'textarea',
					'name'      => 'review_post_pros_text',
					'label'     => __('PROS. Place each from separate line (optional)', 'rehub_framework'),
				),
				array(
					'type'      => 'textarea',
					'name'      => 'review_post_cons_text',
					'label'     => __('CONS. Place each from separate line (optional)', 'rehub_framework'),
				),								

				array(
					'type' => 'toggle',
					'name' => 'review_post_product_shortcode',
					'label' => __('Enable shortcode inserting', 'rehub_framework'),
					'description' => __('If enable you can insert review box in any place of content with shortcode [review]. If disable - it will be after content.', 'rehub_framework'),					
				),

				array(
					'type'      => 'slider',
					'name'      => 'review_post_score_manual',
					'label'     => __('Set overall score', 'rehub_framework'),
					'description' => __('Enter overall score of review or leave blank to auto calculation based on criterias score', 'rehub_framework'),
					'min'       => 0,
					'max'       => 10,
					'step'      => 0.5,					
				),

				array(
					'type'      => 'group',
					'repeating' => true,
					'sortable'  => true,
					'name'      => 'review_post_criteria',
					'title'     => __('Review Criterias', 'rehub_framework'),
					'fields'    => array(
						array(
							'type'      => 'textbox',
							'name'      => 'review_post_name',
							'label'     => __('Name', 'rehub_framework'),
						),
						array(
							'type'      => 'slider',
							'name'      => 'review_post_score',
							'label'     => __('Score', 'rehub_framework'),
							'min'       => 0,
							'max'       => 10,
							'step'      => 0.5,
						),
					),
				),
			),
		),
		
		// music group
		array(
			'type'      => 'group',
			'repeating' => false,
			'length'    => 1,
			'name'      => 'music_post',
			'title'     => __('Music Post', 'rehub_framework'),
			'dependency' => array(
				'field'    => 'rehub_framework_post_type',
				'function' => 'rehub_framework_post_type_is_music',
			),
			'fields'    => array(
				array(
					'type' => 'radiobutton',
					'name' => 'music_post_source',
					'label' => __('Music Source', 'rehub_framework'),
					'items' => array(
						array(
							'value' => 'music_post_soundcloud',
							'label' => __('Music from Soundcloud', 'rehub_framework'),
						),
						array(
							'value' => 'music_post_spotify',
							'label' => __('Music from Spotify', 'rehub_framework'),
						),
					),
				),

				array(
					'type' => 'textarea',
					'name' => 'music_post_soundcloud_embed',
					'description' => __('Insert full Soundcloud embed code.', 'rehub_framework'),
					'label' => __('Soundcloud embed code', 'rehub_framework'),
					'dependency' => array(
						'field'    => 'music_post_source',
						'function' => 'rehub_framework_post_music_is_soundcloud',
					),
				),
				array(
					'type' => 'textbox',
					'name' => 'music_post_spotify_embed',
					'description' => __('To get the Spotify Song URI go to <strong>Spotify</strong> > Right click on the song you want to embed > Click <strong>Copy Spotify URI</strong> > Paste code in this field.)', 'rehub_framework'),
					'label' => __('Spotify Song URI', 'rehub_framework'),
					'dependency' => array(
						'field'    => 'music_post_source',
						'function' => 'rehub_framework_post_music_is_spotify',
					),
				),

			),
		),
		
	),
);

/**
 * EOF
 */