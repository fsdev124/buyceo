<?php

return array(
	'id'          => 'mag_builder_page',
	'types'       => array('page'),
	'title'       => __('Page block builder', 'rehubchild'),
	'priority'    => 'high',
	'mode'        => WPALCHEMY_MODE_EXTRACT,
	'template'    => array(

	    array(
			'type'      => 'group',
			'repeating' => true,
			'sortable'  => true,
			'name'      => 'pagebuilders',
			'title'     => __('Block', 'rehubchild'),
			'fields'    => array(

				array(
					'type' => 'radioimage',
					'name' => 'rehub_framework_pb',
					'label' => __('Choose block', 'rehubchild'),
					'description' => '',
					'items' => array(
						array(
							'value' => 'small_thumb_loop',
							'label' => __('Posts string with small thumbs', 'rehubchild'),
							'img' => REHUB_ADMIN_URI . '/public/pb/pb_9.png',
						),
						array(
							'value' => 'grid_loop',
							'label' => __('Posts grid', 'rehubchild'),
							'img' => REHUB_ADMIN_URI . '/public/pb/pb_10.png',
						),
						array(
							'value' => 'slider_block',
							'label' => __('Slider block', 'rehubchild'),
							'img' => REHUB_ADMIN_URI . '/public/pb/pb_12.png',
						),
						array(
							'value' => 'custom_block',
							'label' => __('Custom text or banner', 'rehubchild'),
							'img' => REHUB_ADMIN_URI . '/public/pb/pb_13.png',
						),																								
					),	
					'default' => 'custom_block',
				),


				// two column news block
			    array(
					'type'      => 'group',
					'repeating' => false,
					'sortable'  => false,
					'name'      => 'two_col_news',
					'title'     => __('Two column news block', 'rehubchild'),
					'dependency' => array(
						'field'    => 'rehub_framework_pb',
						'function' => 'rehub_framework_pb_is_two_col_news',
					),					
					'fields'    => array(

						array(
							'type' => 'select',
							'name' => 'two_col_news_module_cats_1',
							'label' => __('Choose category for 1 column', 'rehubchild'),
							'description' => __('Choose the category that you\'d like to include to first column', 'rehubchild'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value'  => 'vp_get_categories',
									),
								),
							),
							'default' => '',
						),

						array(
							'type' => 'select',
							'name' => 'two_col_news_module_formats_1',
							'label' => __('Choose post formats for 1 column', 'rehubchild'),
							'description' => __('Choose post formats to display in first column or leave blank to display all', 'rehubchild'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value'  => 'rehub_framework_post_formats',
									),
								),
							),
							'default' => 'all',
						),	

						array(
							'type' => 'textbox',
							'name' => 'two_col_news_module_offset_1',
							'label' => __('Offset for 1 col', 'rehubchild'),
							'description' => __('Number of posts to offset for first column  or leave blank', 'rehubchild'),
							'default' => '',
							'validation' => 'numeric',
						),											

						array(
							'type' => 'select',
							'name' => 'two_col_news_module_cats_2',
							'label' => __('Choose category for 2 column', 'rehubchild'),
							'description' => __('Choose the category that you\'d like to include to second column', 'rehubchild'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value'  => 'vp_get_categories',
									),
								),
							),
							'default' => '',
						),

						array(
							'type' => 'select',
							'name' => 'two_col_news_module_formats_2',
							'label' => __('Choose post formats for 2 column', 'rehubchild'),
							'description' => __('Choose post formats to display in second column or leave blank to display all', 'rehub_framework'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value'  => 'rehub_framework_post_formats',
									),
								),
							),
							'default' => 'all',
						),


						array(
							'type' => 'textbox',
							'name' => 'two_col_news_module_offset_2',
							'label' => __('Offset for 2 col', 'rehubchild'),
							'description' => __('Number of posts to offset for second column  or leave blank', 'rehubchild'),
							'default' => '',
							'validation' => 'numeric',
						),																		

						array(
							'type' => 'textbox',
							'name' => 'two_col_news_module_fetch',
							'label' => __('Fetch Count', 'rehubchild'),
							'description' => __('How much posts you\'d like to display?', 'rehubchild'),
							'default' => '4',
							'validation' => 'numeric',
						),


						array(
							'type' => 'toggle',
							'name' => 'two_col_news_module_toggle_title',
							'label' => __('Enable title of box?', 'rehubchild'),
						),						



						array(
							'type' => 'textbox',
							'name' => 'two_col_news_module_title',
							'label' => __('Title of block', 'rehubchild'),
							'description' => __('Set title of block (use short titles)', 'rehubchild'),
							'dependency' => array(
                                 'field' => 'two_col_news_module_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),
							'default' => '',
						),

						array(
							'type' => 'radioimage',
							'name' => 'two_col_news_module_title_position',
							'label' => __('Choose style of title', 'rehubchild'),
							'description' => __('Choose position and style of title', 'rehubchild'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value'  => 'rehub_framework_block_title_position',
									),
								),
							),
							'dependency' => array(
                                 'field' => 'two_col_news_module_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),
							'default' => 'top_title',
						),							

						array(
							'type' => 'textbox',
							'name' => 'two_col_news_module_url_text',
							'label' => __('Custom URL Text:', 'rehubchild'),
							'description' => __('Set text of url near title', 'rehubchild'),
							'dependency' => array(
                                 'field' => 'two_col_news_module_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),							
							'default' => '',
						),

						array(
							'type' => 'textbox',
							'name' => 'two_col_news_module_url_url',
							'label' => __('Custom URL:', 'rehubchild'),
							'description' => __('Set url with http://', 'rehubchild'),
							'dependency' => array(
                                 'field' => 'two_col_news_module_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),							
							'default' => '',
							'validation' => 'url',
						),	

					),																			              
                ),

				// Gallery block
			    array(
					'type'      => 'group',
					'repeating' => false,
					'sortable'  => false,
					'name'      => 'gal_carousel',
					'title'     => __('Photo gallery', 'rehubchild'),
					'dependency' => array(
						'field'    => 'rehub_framework_pb',
						'function' => 'rehub_framework_pb_is_gal_carousel',
					),					
					'fields'    => array(																																	

						array(
							'type'      => 'group',
							'repeating' => true,
							'sortable'  => true,
							'name'      => 'gal_carousel_group',
							'title'     => __('Image', 'rehubchild'),
							'fields'    => array(
								array(
									'type' => 'upload',
									'name' => 'gal_carousel_img',
									'label' => __('Upload the Image Here', 'rehubchild'),
									'default' => '',
								),
							    array(
							        'type' => 'textbox',
							        'name' => 'gal_carousel_url',
							        'label' => __('Set url', 'rehubchild'),
							        'description' => __('Set url on image or leave blank', 'rehubchild'),
							        'validation' => 'url',
							    ),								
							),
						),						

						array(
							'type' => 'toggle',
							'name' => 'gal_carousel_toggle_title',
							'label' => __('Enable title of box?', 'rehubchild'),
						),						



						array(
							'type' => 'textbox',
							'name' => 'gal_carousel_module_title',
							'label' => __('Title of block', 'rehubchild'),
							'description' => __('Set title of block (use short titles)', 'rehubchild'),
							'dependency' => array(
                                 'field' => 'gal_carousel_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),
							'default' => '',
						),

						array(
							'type' => 'radioimage',
							'name' => 'gal_carousel_title_position',
							'label' => __('Choose style of title', 'rehubchild'),
							'description' => __('Choose position and style of title', 'rehubchild'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value'  => 'rehub_framework_block_title_position',
									),
								),
							),
							'dependency' => array(
                                 'field' => 'gal_carousel_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),
							'default' => 'top_title',
						),							

						array(
							'type' => 'textbox',
							'name' => 'gal_carousel_url_text',
							'label' => __('Custom URL Text:', 'rehubchild'),
							'description' => __('Set text of url near title', 'rehubchild'),
							'dependency' => array(
                                 'field' => 'gal_carousel_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),							
							'default' => '',
						),

						array(
							'type' => 'textbox',
							'name' => 'gal_carousel_url_url',
							'label' => __('Custom URL:', 'rehubchild'),
							'description' => __('Set url with http://', 'rehubchild'),
							'dependency' => array(
                                 'field' => 'gal_carousel_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),							
							'default' => '',
							'validation' => 'url',
						),	

					),																			              
                ),

				// Video news block
			    array(
					'type'      => 'group',
					'repeating' => false,
					'sortable'  => false,
					'name'      => 'video_mod',
					'title'     => __('Video news block', 'rehubchild'),
					'dependency' => array(
						'field'    => 'rehub_framework_pb',
						'function' => 'rehub_framework_pb_is_video_block',
					),					
					'fields'    => array(
					
						array(
							'type' => 'select',
							'name' => 'video_mod_loop_tags',
							'label' => __('Choose tag for block', 'rehubchild'),
							'description' => __('Choose tag from which to display content in block or leave blank', 'rehubchild'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value'  => 'vp_get_tags',
									),
								),
							),
							'default' => '',
						),						

						array(
							'type' => 'toggle',
							'name' => 'video_mod_toggle_title',
							'label' => __('Enable title of box?', 'rehubchild'),
						),						



						array(
							'type' => 'textbox',
							'name' => 'video_mod_title',
							'label' => __('Title of block', 'rehubchild'),
							'description' => __('Set title of block (use short titles)', 'rehubchild'),
							'dependency' => array(
                                 'field' => 'video_mod_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),
							'default' => '',
						),

						array(
							'type' => 'radioimage',
							'name' => 'video_mod_title_position',
							'label' => __('Choose style of title', 'rehubchild'),
							'description' => __('Choose position and style of title', 'rehubchild'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value'  => 'rehub_framework_block_title_position',
									),
								),
							),
							'dependency' => array(
                                 'field' => 'video_mod_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),
							'default' => 'top_title',
						),							

						array(
							'type' => 'textbox',
							'name' => 'video_mod_url_text',
							'label' => __('Custom URL Text:', 'rehubchild'),
							'description' => __('Set text of url near title', 'rehubchild'),
							'dependency' => array(
                                 'field' => 'video_mod_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),							
							'default' => '',
						),

						array(
							'type' => 'textbox',
							'name' => 'video_mod_url_url',
							'label' => __('Custom URL:', 'rehubchild'),
							'description' => __('Set url with http://', 'rehubchild'),
							'dependency' => array(
                                 'field' => 'video_mod_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),							
							'default' => '',
							'validation' => 'url',
						),	

					),																			              
                ),

				// Tabbed block
			    array(
					'type'      => 'group',
					'repeating' => false,
					'sortable'  => false,
					'name'      => 'tab_mod',
					'title'     => __('Tabbed block', 'rehubchild'),
					'dependency' => array(
						'field'    => 'rehub_framework_pb',
						'function' => 'rehub_framework_pb_is_tab_block',
					),					
					'fields'    => array(

						array(
							'type' => 'select',
							'name' => 'tab_mod_cats_1',
							'label' => __('Choose category for 1 tab', 'rehubchild'),
							'description' => __('Choose the category that you\'d like to include to first tab', 'rehubchild'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value'  => 'vp_get_categories',
									),
								),
							),
							'default' => '',
						),

						array(
							'type' => 'textbox',
							'name' => 'tab_mod_name_1',
							'label' => __('Choose name for 1 tab', 'rehubchild'),
							'description' => __('Note, name must be maximum 15 symbols', 'rehubchild'),
							'validation' => 'maxlength[15]',
						),

						array(
							'type' => 'select',
							'name' => 'tab_mod_cats_2',
							'label' => __('Choose category for 2 tab', 'rehubchild'),
							'description' => __('Choose the category that you\'d like to include to second tab', 'rehubchild'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value'  => 'vp_get_categories',
									),
								),
							),
							'default' => '',
						),

						array(
							'type' => 'textbox',
							'name' => 'tab_mod_name_2',
							'label' => __('Choose name for 2 tab', 'rehubchild'),
							'description' => __('Note, name must be maximum 12 symbols', 'rehubchild'),
							'validation' => 'maxlength[15]',
						),

						array(
							'type' => 'select',
							'name' => 'tab_mod_cats_3',
							'label' => __('Choose category for 3 tab', 'rehubchild'),
							'description' => __('Choose the category that you\'d like to include to third tab', 'rehubchild'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value'  => 'vp_get_categories',
									),
								),
							),
							'default' => '',
						),

						array(
							'type' => 'textbox',
							'name' => 'tab_mod_name_3',
							'label' => __('Choose name for 3 tab', 'rehubchild'),
							'description' => __('Note, name must be maximum 12 symbols', 'rehubchild'),
							'validation' => 'maxlength[15]',
						),

						array(
							'type' => 'select',
							'name' => 'tab_mod_cats_4',
							'label' => __('Choose category for 4 tab', 'rehubchild'),
							'description' => __('Choose the category that you\'d like to include to fourth tab', 'rehubchild'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value'  => 'vp_get_categories',
									),
								),
							),
							'default' => '',
						),

						array(
							'type' => 'textbox',
							'name' => 'tab_mod_name_4',
							'label' => __('Choose name for 4 tab', 'rehubchild'),
							'description' => __('Note, name must be maximum 12 symbols', 'rehubchild'),
							'validation' => 'maxlength[15]',
						),

						array(
							'type' => 'toggle',
							'name' => 'tab_mod_toggle_title',
							'label' => __('Enable title of box?', 'rehubchild'),
						),						



						array(
							'type' => 'textbox',
							'name' => 'tab_mod_title',
							'label' => __('Title of block', 'rehubchild'),
							'description' => __('Set title of block (use short titles)', 'rehubchild'),
							'dependency' => array(
                                 'field' => 'tab_mod_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),
							'default' => '',
						),

						array(
							'type' => 'radioimage',
							'name' => 'tab_mod_title_position',
							'label' => __('Choose style of title', 'rehubchild'),
							'description' => __('Choose position and style of title', 'rehubchild'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value'  => 'rehub_framework_block_title_position',
									),
								),
							),
							'dependency' => array(
                                 'field' => 'tab_mod_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),
							'default' => 'top_title',
						),							

						array(
							'type' => 'textbox',
							'name' => 'tab_mod_url_text',
							'label' => __('Custom URL Text:', 'rehubchild'),
							'description' => __('Set text of url near title', 'rehubchild'),
							'dependency' => array(
                                 'field' => 'tab_mod_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),							
							'default' => '',
						),

						array(
							'type' => 'textbox',
							'name' => 'tab_mod_url_url',
							'label' => __('Custom URL:', 'rehubchild'),
							'description' => __('Set url with http://', 'rehubchild'),
							'dependency' => array(
                                 'field' => 'tab_mod_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),							
							'default' => '',
							'validation' => 'url',
						),


					),
				),	

				// Blog posts with small thumbs left align
			    array(
					'type'      => 'group',
					'repeating' => false,
					'sortable'  => false,
					'name'      => 'small_thumb_loop_mod',
					'title'     => __('Blog posts with small thumbs', 'rehubchild'),
					'dependency' => array(
						'field'    => 'rehub_framework_pb',
						'function' => 'rehub_framework_pb_is_small_thumb_loop',
					),					
					'fields'    => array(

						array(
							'type' => 'multiselect',
							'name' => 'small_thumb_loop_cats',
							'label' => __('Exclude Categories', 'rehubchild'),
							'description' => __('Choose categories that you\'d like to exclude from blog stream', 'rehubchild'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value'  => 'vp_get_categories',
									),
								),
							),
							'default' => '',																																						
						),
						array(
							'type' => 'select',
							'name' => 'small_thumb_loop_cats_in',
							'label' => __('Or Include Category', 'rehubchild'),
							'description' => __('Choose parent category that you\'d like to include to stream. Or leave blank both fields to show posts from all categories', 'rehubchild'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value'  => 'vp_get_categories',
									),
								),
							),
							'default' => '',																																						
						),						
						array(
							'type' => 'select',
							'name' => 'small_thumb_loop_format',
							'label' => __('Choose post formats for block', 'rehubchild'),
							'description' => __('Choose post formats to display in block or leave blank to display all', 'rehubchild'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value'  => 'rehub_framework_post_formats',
									),
								),
							),
							'default' => 'all',
						),						

						array(
							'type' => 'textbox',
							'name' => 'small_thumb_loop_fetch',
							'label' => __('Fetch Count', 'rehubchild'),
							'description' => __('How much posts you\'d like to display in 1 page?', 'rehubchild'),
							'default' => '5',
							'validation' => 'numeric',
						),
						
						array(
							'type' => 'textbox',
							'name' => 'small_thumb_loop_offset',
							'label' => __('Offset for block', 'rehubchild'),
							'description' => __('Enter number of posts to offset or leave blank', 'rehubchild'),
							'default' => '',
							'validation' => 'numeric',
						),						

						array(
							'type' => 'toggle',
							'name' => 'small_thumb_loop_toggle_page',
							'label' => __('Enable pagination?', 'rehubchild'),
						),						

						array(
							'type' => 'toggle',
							'name' => 'small_thumb_loop_toggle_title',
							'label' => __('Enable title of box?', 'rehubchild'),
						),						



						array(
							'type' => 'textbox',
							'name' => 'small_thumb_loop_title',
							'label' => __('Title of block', 'rehubchild'),
							'description' => __('Set title of block (use short titles)', 'rehubchild'),
							'dependency' => array(
                                 'field' => 'small_thumb_loop_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),
							'default' => '',
						),

						array(
							'type' => 'radioimage',
							'name' => 'small_thumb_loop_title_position',
							'label' => __('Choose style of title', 'rehubchild'),
							'description' => __('Choose position and style of title', 'rehubchild'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value'  => 'rehub_framework_block_title_position',
									),
								),
							),
							'dependency' => array(
                                 'field' => 'small_thumb_loop_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),
							'default' => 'top_title',
						),							

						array(
							'type' => 'textbox',
							'name' => 'small_thumb_loop_url_text',
							'label' => __('Custom URL Text:', 'rehubchild'),
							'description' => __('Set text of url near title', 'rehubchild'),
							'dependency' => array(
                                 'field' => 'small_thumb_loop_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),							
							'default' => '',
						),

						array(
							'type' => 'textbox',
							'name' => 'small_thumb_loop_url_url',
							'label' => __('Custom URL:', 'rehubchild'),
							'description' => __('Set url with http://', 'rehubchild'),
							'dependency' => array(
                                 'field' => 'small_thumb_loop_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),							
							'default' => '',
							'validation' => 'url',
						),	

					),																			              
                ),


				// Regular blog posts
			    array(
					'type'      => 'group',
					'repeating' => false,
					'sortable'  => false,
					'name'      => 'regular_blog_loop_mod',
					'title'     => __('Regular blog posts', 'rehubchild'),
					'dependency' => array(
						'field'    => 'rehub_framework_pb',
						'function' => 'rehub_framework_pb_is_regular_blog_loop',
					),					
					'fields'    => array(

						array(
							'type' => 'multiselect',
							'name' => 'regular_blog_loop_cats',
							'label' => __('Exclude Categories', 'rehubchild'),
							'description' => __('Choose categories that you\'d like to exclude from blog stream', 'rehubchild'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value'  => 'vp_get_categories',
									),
								),
							),
							'default' => '',																																						
						),
						array(
							'type' => 'select',
							'name' => 'regular_blog_loop_cats_in',
							'label' => __('Or Include Category', 'rehubchild'),
							'description' => __('Choose parent category that you\'d like to include to stream. Or leave blank both fields to show posts from all categories', 'rehubchild'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value'  => 'vp_get_categories',
									),
								),
							),
							'default' => '',																																						
						),						

						array(
							'type' => 'select',
							'name' => 'regular_blog_loop_format',
							'label' => __('Choose post formats for block', 'rehubchild'),
							'description' => __('Choose post formats to display in block or leave blank to display all', 'rehubchild'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value'  => 'rehub_framework_post_formats',
									),
								),
							),
							'default' => 'all',
						),						

						array(
							'type' => 'textbox',
							'name' => 'regular_blog_loop_fetch',
							'label' => __('Fetch Count', 'rehubchild'),
							'description' => __('How much posts you\'d like to display in 1 page?', 'rehubchild'),
							'default' => '5',
							'validation' => 'numeric',
						),
						
						array(
							'type' => 'textbox',
							'name' => 'regular_blog_loop_offset',
							'label' => __('Offset for block', 'rehubchild'),
							'description' => __('Enter number of posts to offset or leave blank', 'rehubchild'),
							'default' => '',
							'validation' => 'numeric',
						),						

						array(
							'type' => 'toggle',
							'name' => 'regular_blog_loop_toggle_page',
							'label' => __('Enable pagination?', 'rehubchild'),
						),						

						array(
							'type' => 'toggle',
							'name' => 'regular_blog_loop_toggle_title',
							'label' => __('Enable title of box?', 'rehubchild'),
						),						



						array(
							'type' => 'textbox',
							'name' => 'regular_blog_loop_title',
							'label' => __('Title of block', 'rehubchild'),
							'description' => __('Set title of block (use short titles)', 'rehubchild'),
							'dependency' => array(
                                 'field' => 'regular_blog_loop_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),
							'default' => '',
						),

						array(
							'type' => 'radioimage',
							'name' => 'regular_blog_loop_title_position',
							'label' => __('Choose style of title', 'rehubchild'),
							'description' => __('Choose position and style of title', 'rehubchild'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value'  => 'rehub_framework_block_title_position',
									),
								),
							),
							'dependency' => array(
                                 'field' => 'regular_blog_loop_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),
							'default' => 'top_title',
						),							

						array(
							'type' => 'textbox',
							'name' => 'regular_blog_loop_url_text',
							'label' => __('Custom URL Text:', 'rehubchild'),
							'description' => __('Set text of url near title', 'rehubchild'),
							'dependency' => array(
                                 'field' => 'regular_blog_loop_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),							
							'default' => '',
						),

						array(
							'type' => 'textbox',
							'name' => 'regular_blog_loop_url_url',
							'label' => __('Custom URL:', 'rehubchild'),
							'description' => __('Set url with http://', 'rehubchild'),
							'dependency' => array(
                                 'field' => 'regular_blog_loop_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),							
							'default' => '',
							'validation' => 'url',
						),	

					),																			              
                ),

				// Grid blog posts
			    array(
					'type'      => 'group',
					'repeating' => false,
					'sortable'  => false,
					'name'      => 'grid_loop_mod',
					'title'     => __('Grid style posts', 'rehubchild'),
					'dependency' => array(
						'field'    => 'rehub_framework_pb',
						'function' => 'rehub_framework_pb_is_grid_loop',
					),					
					'fields'    => array(

						array(
							'type' => 'multiselect',
							'name' => 'grid_loop_cats',
							'label' => __('Exclude Categories', 'rehubchild'),
							'description' => __('Choose categories that you\'d like to exclude from blog stream', 'rehubchild'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value'  => 'vp_get_categories',
									),
								),
							),
							'default' => '',																																						
						),
						array(
							'type' => 'select',
							'name' => 'grid_loop_cats_in',
							'label' => __('Or Include Category', 'rehubchild'),
							'description' => __('Choose parent category that you\'d like to include to stream. Or leave blank both fields to show posts from all categories', 'rehubchild'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value'  => 'vp_get_categories',
									),
								),
							),
							'default' => '',																																						
						),						
						
						array(
							'type' => 'select',
							'name' => 'grid_loop_format',
							'label' => __('Choose post formats for block', 'rehubchild'),
							'description' => __('Choose post formats to display in block or leave blank to display all', 'rehubchild'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value'  => 'rehub_framework_post_formats',
									),
								),
							),
							'default' => 'all',
						),						

						array(
							'type' => 'textbox',
							'name' => 'grid_loop_fetch',
							'label' => __('Fetch Count', 'rehubchild'),
							'description' => __('How much posts you\'d like to display in 1 page?', 'rehubchild'),
							'default' => '10',
							'validation' => 'numeric',
						),
						
						array(
							'type' => 'textbox',
							'name' => 'grid_loop_offset',
							'label' => __('Offset for block', 'rehubchild'),
							'description' => __('Enter number of posts to offset or leave blank', 'rehubchild'),
							'default' => '',
							'validation' => 'numeric',
						),

						array(
							'type' => 'select',
							'name' => 'grid_loop_toggle_page',
							'label' => __('Pagination type', 'rehubchild'),
							'items' => array(
								array(
									'value' => '1',
									'label' => __('Simple pagination', 'rehubchild'),
								),
								array(
									'value' => '2',
									'label' => __('New item will be added by click', 'rehubchild'),
								),
								array(
									'value' => 'no',
									'label' => __('No pagination', 'rehubchild'),
								),
							),
							'default' => array(
								'no',
							),
						),																	

						array(
							'type' => 'toggle',
							'name' => 'grid_loop_toggle_title',
							'label' => __('Enable title of box?', 'rehubchild'),
						),						



						array(
							'type' => 'textbox',
							'name' => 'grid_loop_title',
							'label' => __('Title of block', 'rehubchild'),
							'description' => __('Set title of block (use short titles)', 'rehubchild'),
							'dependency' => array(
                                 'field' => 'grid_loop_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),
							'default' => '',
						),

						array(
							'type' => 'radioimage',
							'name' => 'grid_loop_title_position',
							'label' => __('Choose style of title', 'rehubchild'),
							'description' => __('Choose position and style of title', 'rehubchild'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value'  => 'rehub_framework_block_title_position',
									),
								),
							),
							'dependency' => array(
                                 'field' => 'grid_loop_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),
							'default' => 'top_title',
						),							

						array(
							'type' => 'textbox',
							'name' => 'grid_loop_url_text',
							'label' => __('Custom URL Text:', 'rehubchild'),
							'description' => __('Set text of url near title', 'rehubchild'),
							'dependency' => array(
                                 'field' => 'grid_loop_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),							
							'default' => '',
						),

						array(
							'type' => 'textbox',
							'name' => 'grid_loop_url_url',
							'label' => __('Custom URL:', 'rehubchild'),
							'description' => __('Set url with http://', 'rehubchild'),
							'dependency' => array(
                                 'field' => 'grid_loop_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),							
							'default' => '',
							'validation' => 'url',
						),	

					),																			              
                ),

				// 1 big + 4 small news with thumbs
			    array(
					'type'      => 'group',
					'repeating' => false,
					'sortable'  => false,
					'name'      => 'news_with_thumbs_mod',
					'title'     => __('News block with thumbs', 'rehubchild'),
					'dependency' => array(
						'field'    => 'rehub_framework_pb',
						'function' => 'rehub_framework_pb_is_news_with_thumbs_block',
					),					
					'fields'    => array(

						array(
							'type' => 'select',
							'name' => 'news_with_thumbs_cats',
							'label' => __('Choose Category', 'rehubchild'),
							'description' => __('Choose the category that you\'d like to include to block', 'rehubchild'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value'  => 'vp_get_categories',
									),
								),
							),
							'default' => '',																																						
						),
						

						array(
							'type' => 'toggle',
							'name' => 'news_with_thumbs_toggle_title',
							'label' => __('Enable title of box?', 'rehubchild'),
						),						



						array(
							'type' => 'textbox',
							'name' => 'news_with_thumbs_title',
							'label' => __('Title of block', 'rehubchild'),
							'description' => __('Set title of block (use short titles)', 'rehubchild'),
							'dependency' => array(
                                 'field' => 'news_with_thumbs_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),
							'default' => '',
						),

						array(
							'type' => 'radioimage',
							'name' => 'news_with_thumbs_title_position',
							'label' => __('Choose style of title', 'rehubchild'),
							'description' => __('Choose position and style of title', 'rehubchild'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value'  => 'rehub_framework_block_title_position',
									),
								),
							),
							'dependency' => array(
                                 'field' => 'news_with_thumbs_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),
							'default' => 'top_title',
						),							

						array(
							'type' => 'textbox',
							'name' => 'news_with_thumbs_url_text',
							'label' => __('Custom URL Text:', 'rehubchild'),
							'description' => __('Set text of url near title', 'rehubchild'),
							'dependency' => array(
                                 'field' => 'news_with_thumbs_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),							
							'default' => '',
						),

						array(
							'type' => 'textbox',
							'name' => 'news_with_thumbs_url_url',
							'label' => __('Custom URL:', 'rehubchild'),
							'description' => __('Set url with http://', 'rehubchild'),
							'dependency' => array(
                                 'field' => 'news_with_thumbs_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),							
							'default' => '',
							'validation' => 'url',
						),	

					),																			              
                ),

				// 1 big + 4 small news no thumbs
			    array(
					'type'      => 'group',
					'repeating' => false,
					'sortable'  => false,
					'name'      => 'news_no_thumbs_mod',
					'title'     => __('News block without small thumbs', 'rehubchild'),
					'dependency' => array(
						'field'    => 'rehub_framework_pb',
						'function' => 'rehub_framework_pb_is_news_no_thumbs_block',
					),					
					'fields'    => array(

						array(
							'type' => 'select',
							'name' => 'news_no_thumbs_cats',
							'label' => __('Choose Category', 'rehubchild'),
							'description' => __('Choose the category that you\'d like to include to block', 'rehubchild'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value'  => 'vp_get_categories',
									),
								),
							),
							'default' => '',																																						
						),
						

						array(
							'type' => 'toggle',
							'name' => 'news_no_thumbs_toggle_title',
							'label' => __('Enable title of box?', 'rehubchild'),
						),						



						array(
							'type' => 'textbox',
							'name' => 'news_no_thumbs_title',
							'label' => __('Title of block', 'rehubchild'),
							'description' => __('Set title of block (use short titles)', 'rehubchild'),
							'dependency' => array(
                                 'field' => 'news_no_thumbs_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),
							'default' => '',
						),

						array(
							'type' => 'radioimage',
							'name' => 'news_no_thumbs_title_position',
							'label' => __('Choose style of title', 'rehubchild'),
							'description' => __('Choose position and style of title', 'rehubchild'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value'  => 'rehub_framework_block_title_position',
									),
								),
							),
							'dependency' => array(
                                 'field' => 'news_no_thumbs_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),
							'default' => 'top_title',
						),							

						array(
							'type' => 'textbox',
							'name' => 'news_no_thumbs_url_text',
							'label' => __('Custom URL Text:', 'rehubchild'),
							'description' => __('Set text of url near title', 'rehubchild'),
							'dependency' => array(
                                 'field' => 'news_no_thumbs_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),							
							'default' => '',
						),

						array(
							'type' => 'textbox',
							'name' => 'news_no_thumbs_url_url',
							'label' => __('Custom URL:', 'rehubchild'),
							'description' => __('Set url with http://', 'rehubchild'),
							'dependency' => array(
                                 'field' => 'news_no_thumbs_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),							
							'default' => '',
							'validation' => 'url',
						),	

					),																			              
                ),

				// posts carousel
			    array(
					'type'      => 'group',
					'repeating' => false,
					'sortable'  => false,
					'name'      => 'post_carousel_mod',
					'title'     => __('Posts carousel block', 'rehubchild'),
					'dependency' => array(
						'field'    => 'rehub_framework_pb',
						'function' => 'rehub_framework_pb_is_post_carousel_block',
					),					
					'fields'    => array(

						array(
							'type' => 'select',
							'name' => 'post_carousel_cats',
							'label' => __('Choose Category', 'rehubchild'),
							'description' => __('Choose the category that you\'d like to include to block', 'rehubchild'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value'  => 'vp_get_categories',
									),
								),
							),
							'default' => '',																																						
						),

						array(
							'type' => 'textbox',
							'name' => 'post_carousel_fetch',
							'label' => __('Fetch Count', 'rehubchild'),
							'description' => __('How much posts you\'d like to display in carousel?', 'rehubchild'),
							'default' => '6',
							'validation' => 'numeric',
						),

						array(
							'type' => 'select',
							'name' => 'post_carousel_formats',
							'label' => __('Choose post formats for carousel', 'rehubchild'),
							'description' => __('Choose post formats to display in carousel or leave blank to display all', 'rehubchild'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value'  => 'rehub_framework_post_formats',
									),
								),
							),
							'default' => 'all',
						),						
						

						array(
							'type' => 'toggle',
							'name' => 'post_carousel_toggle_title',
							'label' => __('Enable title of box?', 'rehubchild'),
						),						



						array(
							'type' => 'textbox',
							'name' => 'post_carousel_title',
							'label' => __('Title of block', 'rehubchild'),
							'description' => __('Set title of block (use short titles)', 'rehubchild'),
							'dependency' => array(
                                 'field' => 'post_carousel_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),
							'default' => '',
						),

						array(
							'type' => 'radioimage',
							'name' => 'post_carousel_title_position',
							'label' => __('Choose style of title', 'rehubchild'),
							'description' => __('Choose position and style of title', 'rehubchild'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value'  => 'rehub_framework_block_title_position',
									),
								),
							),
							'dependency' => array(
                                 'field' => 'post_carousel_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),
							'default' => 'top_title',
						),							

						array(
							'type' => 'textbox',
							'name' => 'post_carousel_url_text',
							'label' => __('Custom URL Text:', 'rehubchild'),
							'description' => __('Set text of url near title', 'rehubchild'),
							'dependency' => array(
                                 'field' => 'post_carousel_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),							
							'default' => '',
						),

						array(
							'type' => 'textbox',
							'name' => 'post_carousel_url_url',
							'label' => __('Custom URL:', 'rehubchild'),
							'description' => __('Set url with http://', 'rehubchild'),
							'dependency' => array(
                                 'field' => 'post_carousel_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),							
							'default' => '',
							'validation' => 'url',
						),	

					),																			              
                ),

				// post slider
			    array(
					'type'      => 'group',
					'repeating' => false,
					'sortable'  => false,
					'name'      => 'slider_mod',
					'title'     => __('Posts slider block', 'rehubchild'),
					'dependency' => array(
						'field'    => 'rehub_framework_pb',
						'function' => 'rehub_framework_pb_is_slider_block',
					),					
					'fields'    => array(						

						array(
							'type' => 'select',
							'name' => 'slider_cats',
							'label' => __('Choose Category', 'rehubchild'),
							'description' => __('Choose the category that you\'d like to include to block', 'rehubchild'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value'  => 'vp_get_categories',
									),
								),
							),							
							'default' => '',																																						
						),

						array(
							'type' => 'textbox',
							'name' => 'slider_fetch',
							'label' => __('Fetch Count', 'rehubchild'),
							'description' => __('How much posts you\'d like to display in slider?', 'rehubchild'),
							'default' => '6',
							'validation' => 'numeric',
						),						
						

						array(
							'type' => 'toggle',
							'name' => 'slider_toggle_title',
							'label' => __('Enable title of box?', 'rehubchild'),
						),						



						array(
							'type' => 'textbox',
							'name' => 'slider_title',
							'label' => __('Title of block', 'rehubchild'),
							'description' => __('Set title of block (use short titles)', 'rehubchild'),
							'dependency' => array(
                                 'field' => 'slider_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),
							'default' => '',
						),

						array(
							'type' => 'radioimage',
							'name' => 'slider_title_position',
							'label' => __('Choose style of title', 'rehubchild'),
							'description' => __('Choose position and style of title', 'rehubchild'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value'  => 'rehub_framework_block_title_position',
									),
								),
							),
							'dependency' => array(
                                 'field' => 'slider_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),
							'default' => 'top_title',
						),							

						array(
							'type' => 'textbox',
							'name' => 'slider_url_text',
							'label' => __('Custom URL Text:', 'rehubchild'),
							'description' => __('Set text of url near title', 'rehubchild'),
							'dependency' => array(
                                 'field' => 'slider_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),							
							'default' => '',
						),

						array(
							'type' => 'textbox',
							'name' => 'slider_url_url',
							'label' => __('Custom URL:', 'rehubchild'),
							'description' => __('Set url with http://', 'rehubchild'),
							'dependency' => array(
                                 'field' => 'slider_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),							
							'default' => '',
							'validation' => 'url',
						),	

					),																			              
                ),


				// custom block
			    array(
					'type'      => 'group',
					'repeating' => false,
					'sortable'  => false,
					'name'      => 'custom_mod',
					'title'     => __('Custom block', 'rehubchild'),
					'dependency' => array(
						'field'    => 'rehub_framework_pb',
						'function' => 'rehub_framework_pb_is_custom_block',
					),					
					'fields'    => array(

						 array(
							'type' => 'textarea',
							'name' => 'custom_mod_area',
							'label' => __('Custom code', 'rehubchild'),
							'description' => __('Insert your custom code (adsense ads, banner, etc.)', 'rehubchild'),
							'default' => '',
						),

						array(
							'type' => 'toggle',
							'name' => 'custom_toggle_border',
							'label' => __('Enable box border?', 'rehubchild'),
						),										

						array(
							'type' => 'toggle',
							'name' => 'custom_toggle_title',
							'label' => __('Enable title of box?', 'rehubchild'),
						),						



						array(
							'type' => 'textbox',
							'name' => 'custom_title',
							'label' => __('Title of block', 'rehubchild'),
							'description' => __('Set title of block (use short titles)', 'rehubchild'),
							'dependency' => array(
                                 'field' => 'custom_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),
							'default' => '',
						),

						array(
							'type' => 'radioimage',
							'name' => 'custom_title_position',
							'label' => __('Choose style of title', 'rehubchild'),
							'description' => __('Choose position and style of title', 'rehubchild'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value'  => 'rehub_framework_block_title_position',
									),
								),
							),
							'dependency' => array(
                                 'field' => 'custom_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),
							'default' => 'top_title',
						),							

						array(
							'type' => 'textbox',
							'name' => 'custom_url_text',
							'label' => __('Custom URL Text:', 'rehubchild'),
							'description' => __('Set text of url near title', 'rehubchild'),
							'dependency' => array(
                                 'field' => 'custom_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),							
							'default' => '',
						),

						array(
							'type' => 'textbox',
							'name' => 'custom_url_url',
							'label' => __('Custom URL:', 'rehubchild'),
							'description' => __('Set url with http://', 'rehubchild'),
							'dependency' => array(
                                 'field' => 'custom_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),							
							'default' => '',
							'validation' => 'url',
						),	

					),																			              
                ),


				// woo block
			    array(
					'type'      => 'group',
					'repeating' => false,
					'sortable'  => false,
					'name'      => 'woo_mod',
					'title'     => __('Woo commerce product carousel', 'rehubchild'),
					'dependency' => array(
						'field'    => 'rehub_framework_pb',
						'function' => 'rehub_framework_pb_is_woo_block',
					),					
					'fields'    => array(


						array(
							'type' => 'slider',
							'name' => 'woo_mod_fetch',
							'label' => __('Number of products to display', 'rehubchild'),
							'min' => '4',
							'max' => '10',
							'step' => '1',
							'default' => '4',
						),

						 array(
							'type' => 'select',
							'name' => 'woo_mod_type',
							'label' => __('Type of products to display in block', 'rehubchild'),
							'items' => array(
								array(
									'value' => 'latest',
									'label' => __('Latest products', 'rehubchild'),
								),
								array(
									'value' => 'featured',
									'label' => __('Featured products', 'rehubchild'),
								),
								array(
									'value' => 'best',
									'label' => __('Best sellers', 'rehubchild'),
								),
							),
							'default' => array(
							'latest',
							),
						),

						array(
							'type' => 'textbox',
							'name' => 'woo_cat',
							'label' => __('Set category', 'rehubchild'),
							'description' => __('Set slug of product category or leave blank', 'rehubchild'),
						),												
									
						array(
							'type' => 'toggle',
							'name' => 'woo_toggle_title',
							'label' => __('Enable title of box?', 'rehubchild'),
						),						

						array(
							'type' => 'textbox',
							'name' => 'woo_title',
							'label' => __('Title of block', 'rehubchild'),
							'description' => __('Set title of block (use short titles)', 'rehubchild'),
							'dependency' => array(
                                 'field' => 'woo_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),
							'default' => '',
						),

						array(
							'type' => 'radioimage',
							'name' => 'woo_title_position',
							'label' => __('Choose style of title', 'rehubchild'),
							'description' => __('Choose position and style of title', 'rehubchild'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value'  => 'rehub_framework_block_title_position',
									),
								),
							),
							'dependency' => array(
                                 'field' => 'woo_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),
							'default' => 'top_title',
						),							

						array(
							'type' => 'textbox',
							'name' => 'woo_url_text',
							'label' => __('Custom URL Text:', 'rehubchild'),
							'description' => __('Set text of url near title', 'rehubchild'),
							'dependency' => array(
                                 'field' => 'woo_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),							
							'default' => '',
						),

						array(
							'type' => 'textbox',
							'name' => 'woo_url_url',
							'label' => __('Custom URL:', 'rehubchild'),
							'description' => __('Set url with http://', 'rehubchild'),
							'dependency' => array(
                                 'field' => 'woo_toggle_title',
                                 'function' => 'vp_dep_boolean',
                            ),							
							'default' => '',
							'validation' => 'url',
						),	

					),																			              
                ),




            ),
        ),
						
    ),
    'include_template' => 'page_builder.php',
);



/**
 * EOF
 */