<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php

VP_Security::instance()->whitelist_function('rehub_framework_pb_is_two_col_news');
function rehub_framework_pb_is_two_col_news($type)
{
	if( $type === 'two_col_news_block' )
		return true;
	return false;
}

VP_Security::instance()->whitelist_function('rehub_framework_pb_is_gal_carousel');
function rehub_framework_pb_is_gal_carousel($type)
{
	if( $type === 'gal_carousel_block' )
		return true;
	return false;
}

VP_Security::instance()->whitelist_function('rehub_framework_pb_is_video_block');
function rehub_framework_pb_is_video_block($type)
{
	if( $type === 'video_block' )
		return true;
	return false;
}

VP_Security::instance()->whitelist_function('rehub_framework_pb_is_tab_block');
function rehub_framework_pb_is_tab_block($type)
{
	if( $type === 'tab_block' )
		return true;
	return false;
}

VP_Security::instance()->whitelist_function('rehub_framework_pb_is_woo_block');
function rehub_framework_pb_is_woo_block($type)
{
	if( $type === 'woo_block' )
		return true;
	return false;
}

VP_Security::instance()->whitelist_function('rehub_framework_pb_is_news_no_thumbs_block');
function rehub_framework_pb_is_news_no_thumbs_block($type)
{
	if( $type === 'news_no_thumbs_block' )
		return true;
	return false;
}

VP_Security::instance()->whitelist_function('rehub_framework_pb_is_post_carousel_block');
function rehub_framework_pb_is_post_carousel_block($type)
{
	if( $type === 'post_carousel_block' )
		return true;
	return false;
}

VP_Security::instance()->whitelist_function('rehub_framework_pb_is_news_with_thumbs_block');
function rehub_framework_pb_is_news_with_thumbs_block($type)
{
	if( $type === 'news_with_thumbs_block' )
		return true;
	return false;
}

VP_Security::instance()->whitelist_function('rehub_framework_pb_is_small_thumb_loop');
function rehub_framework_pb_is_small_thumb_loop($type)
{
	if( $type === 'small_thumb_loop' )
		return true;
	return false;
}

VP_Security::instance()->whitelist_function('rehub_framework_pb_is_grid_loop');
function rehub_framework_pb_is_grid_loop($type)
{
	if( $type === 'grid_loop' )
		return true;
	return false;
}

VP_Security::instance()->whitelist_function('rehub_framework_pb_is_regular_blog_loop');
function rehub_framework_pb_is_regular_blog_loop($type)
{
	if( $type === 'regular_blog_loop' )
		return true;
	return false;
}

VP_Security::instance()->whitelist_function('rehub_framework_pb_is_slider_block');
function rehub_framework_pb_is_slider_block($type)
{
	if( $type === 'slider_block' )
		return true;
	return false;
}

VP_Security::instance()->whitelist_function('rehub_framework_pb_is_custom_block');
function rehub_framework_pb_is_custom_block($type)
{
	if( $type === 'custom_block' )
		return true;
	return false;
}

VP_Security::instance()->whitelist_function('rehub_framework_is_header_six');
function rehub_framework_is_header_six($type)
{
	if( $type === 'header_six' )
		return true;
	return false;
}

VP_Security::instance()->whitelist_function('rehub_framework_is_header_seven');
function rehub_framework_is_header_seven($type)
{
	if( $type === 'header_seven' )
		return true;
	return false;
}


VP_Security::instance()->whitelist_function('rehub_framework_post_formats');
function rehub_framework_post_formats() {
return array(
    
    array(
      'value' => 'all',
      'label' => __('all', 'rehub_framework'),
    ),	

    array(
      'value' => 'regular',
      'label' => __('regular', 'rehub_framework'),
    ),
    array(
      'value' => 'video',
      'label' => __('video', 'rehub_framework'),
    ),
    array(
      'value' => 'gallery',
      'label' => __('gallery', 'rehub_framework'),
    ),
    array(
      'value' => 'review',
      'label' => __('review', 'rehub_framework'),
    ),
    array(
      'value' => 'music',
      'label' => __('music', 'rehub_framework'),
    ),              
);
}


VP_Security::instance()->whitelist_function('rehub_framework_block_title_position');
function rehub_framework_block_title_position() {
return array(
    
    array(
      'value' => 'top_title',
      'label' => __('above line', 'rehub_framework'),
      'img' => REHUB_ADMIN_URI . '/public/pb/title_1.png',
    ),	

    array(
      'value' => 'left_title',
      'label' => __('left position inside line', 'rehub_framework'),
      'img' => REHUB_ADMIN_URI . '/public/pb/title_2.png',      
    ),
    array(
      'value' => 'center_title',
      'label' => __('center position inside line', 'rehub_framework'),
      'img' => REHUB_ADMIN_URI . '/public/pb/title_3.png',      
    ),             
);
}


VP_Security::instance()->whitelist_function('rehub_framework_post_type_is_regular');
function rehub_framework_post_type_is_regular($type)
{
	if( $type === 'regular' )
		return true;
	return false;
}

VP_Security::instance()->whitelist_function('rehub_framework_post_type_is_video');
function rehub_framework_post_type_is_video($type)
{
	if( $type === 'video' )
		return true;
	return false;
}
VP_Security::instance()->whitelist_function('rehub_framework_post_type_is_gallery');
function rehub_framework_post_type_is_gallery($type)
{
	if( $type === 'gallery' )
		return true;
	return false;
}
VP_Security::instance()->whitelist_function('rehub_framework_post_type_is_review');
function rehub_framework_post_type_is_review($type)
{
	if( $type === 'review' )
		return true;
	return false;
}
VP_Security::instance()->whitelist_function('rehub_framework_post_type_is_music');
function rehub_framework_post_type_is_music($type)
{
	if( $type === 'music' )
		return true;
	return false;
}

VP_Security::instance()->whitelist_function('rehub_framework_post_type_is_link');
function rehub_framework_post_type_is_link($type)
{
	if( $type === 'link' )
		return true;
	return false;
}

VP_Security::instance()->whitelist_function('review_post_schema_type_is_product');
function review_post_schema_type_is_product($type)
{
	if( $type === 'review_post_review_product' )
		return true;
	return false;
}
VP_Security::instance()->whitelist_function('review_post_schema_type_is_woo_list');
function review_post_schema_type_is_woo_list($type)
{
	if( $type === 'review_woo_list' )
		return true;
	return false;
}
VP_Security::instance()->whitelist_function('review_post_schema_type_is_woo');
function review_post_schema_type_is_woo($type)
{
	if( $type === 'review_woo_product' )
		return true;
	return false;
}
VP_Security::instance()->whitelist_function('review_post_schema_type_is_aff_product');
function review_post_schema_type_is_aff_product($type)
{
	if( $type === 'review_aff_product' )
		return true;
	return false;
}


VP_Security::instance()->whitelist_function('rehub_framework_post_music_is_soundcloud');
function rehub_framework_post_music_is_soundcloud($type)
{
	if( $type === 'music_post_soundcloud' )
		return true;
	return false;
}
VP_Security::instance()->whitelist_function('rehub_framework_post_music_is_spotify');
function rehub_framework_post_music_is_spotify($type)
{
	if( $type === 'music_post_spotify' )
		return true;
	return false;
}

//Functions for affiliate links

VP_Security::instance()->whitelist_function('rehub_manual_ids_func');
function rehub_manual_ids_func($top_review_cat='')
{
	$args = array(
		'meta_query' => array(
			array(
				'key' => 'rehub_framework_post_type',
				'value' => 'review'
			),
		),
		'posts_per_page' => -1,
	);
	$query = new WP_Query( $args );
	$data  = array();
	foreach ($query->posts as $post)
	{
		$data[] = array(
			'value' => $post->ID,
			'label' => $post->post_title,
		);
	}
	return $data;
}

VP_Security::instance()->whitelist_function('top_review_choose_is_cat');
function top_review_choose_is_cat($type)
{
	if( $type === 'cat_choose' )
		return true;
	return false;
}
VP_Security::instance()->whitelist_function('top_review_choose_is_manual');
function top_review_choose_is_manual($type)
{
	if( $type === 'manual_choose' )
		return true;
	return false;
}
VP_Security::instance()->whitelist_function('top_review_choose_is_custompost');
function top_review_choose_is_custompost($type)
{
	if( $type === 'custom_post' )
		return true;
	return false;
}
VP_Security::instance()->whitelist_function('rehub_get_cpost_type');
function rehub_get_cpost_type()
{
    $post_types = get_post_types( array('public'   => true) );
    $data  = array();
    foreach ( $post_types as $post_type ) {
        if ( $post_type !== 'revision' && $post_type !== 'nav_menu_item' && $post_type !== 'attachment') {
			$data[] = array(
				'value' => $post_type,
				'label' => $post_type,
			);
        }
    }
	return $data;
}

VP_Security::instance()->whitelist_function('top_list_shortcode');
function top_list_shortcode()
{
	$result = ''.__("You can use shortcode to insert this top list to another page", "rehub_framework").' <strong>[wpsm_top id="'.$_GET['post'].'" full_width="1"]</strong><br />'.__("Delete full_width attribute if you insert shortcode in page with sidebar", "rehub_framework").'';
	return $result;
}

VP_Security::instance()->whitelist_function('top_table_shortcode');
function top_table_shortcode()
{
	
		$result = ''.__("You can use shortcode to insert this top table to another page", "rehub_framework").' <strong>[wpsm_toptable id="'.$_GET['post'].'" full_width="1"]</strong><br />'.__("Delete full_width attribute if you insert shortcode in page with sidebar", "rehub_framework").'';

	return $result;
}

VP_Security::instance()->whitelist_function('top_charts_shortcode');
function top_charts_shortcode()
{
	
		$result = ''.__("You can use shortcode to insert this top charts to another page", "rehub_framework").' <strong>[wpsm_charts id="'.$_GET['post'].'"]</strong>';

	return $result;
}

VP_Security::instance()->whitelist_function('rh_meta_multioffer_shortcode');
function rh_meta_multioffer_shortcode()
{
	$result = ''.__("You can use shortcode to insert this offer list in content or to another page - ", "rehub_framework").' <strong>[quick_offer id='.$_GET['post'].']</strong>';
	return $result;
}

VP_Security::instance()->whitelist_function('use_fields_as_desc');
function use_fields_as_desc($type)
{
	if( $type === 'field' )
		return true;
	return false;
}

VP_Security::instance()->whitelist_function('rehub_framework_rev_type');
function rehub_framework_rev_type($type)
{
	if( $type === 'full_review' || $type === 'simple')
		return true;
	return false;
}

VP_Security::instance()->whitelist_function('user_rev_type');
function user_rev_type($type)
{
	if( $type === 'user' )
		return true;
	return false;
}

VP_Security::instance()->whitelist_function('rehub_framework_rev_color_is_mono');
function rehub_framework_rev_color_is_mono($type)
{
	if( $type === 'simple' )
		return true;
	return false;
}

VP_Security::instance()->whitelist_function('rehub_framework_rev_color_is_multi');
function rehub_framework_rev_color_is_multi($type)
{
	if( $type === 'multicolor' )
		return true;
	return false;
}

VP_Security::instance()->whitelist_function('rehub_column_is_meta_value');
function rehub_column_is_meta_value($type)
{
	if( $type === 'meta_value' )
		return true;
	return false;
}

VP_Security::instance()->whitelist_function('rehub_column_is_short');
function rehub_column_is_short($type)
{
	if( $type === 'shortcode' )
		return true;
	return false;
}

VP_Security::instance()->whitelist_function('rehub_column_is_review_function');
function rehub_column_is_review_function($type)
{
	if( $type === 'review_function' )
		return true;
	return false;
}

VP_Security::instance()->whitelist_function('rehub_column_is_image');
function rehub_column_is_image($type)
{
	if( $type === 'image' )
		return true;
	return false;
}

VP_Security::instance()->whitelist_function('rehub_column_is_tax');
function rehub_column_is_tax($type)
{
	if( $type === 'taxonomy_value' )
		return true;
	return false;
}

VP_Security::instance()->whitelist_function('rehub_column_is_attr');
function rehub_column_is_attr($type)
{
	if( $type === 'woo_attribute' )
		return true;
	return false;
}

VP_Security::instance()->whitelist_function('rehub_column_is_btn');
function rehub_column_is_btn($type)
{
	if( $type === 'affiliate_btn' )
		return true;
	return false;
}


//Functions for woocommerce select

VP_Security::instance()->whitelist_function('rehub_woo_select_one');
function rehub_woo_select_one()
{
$woo_product_select = array(
	'type' => 'textbox',
	'name' => 'review_woo_link',
	'label' => __('Set woocommerce product ID', 'rehub_framework'),
	'description' => __('Type name of woocommerce product', 'rehub_framework'),
	'default' => '',
);

return $woo_product_select;
}

VP_Security::instance()->whitelist_function('rehub_woo_select_two');
function rehub_woo_select_two()
{
$woo_products_select =	array(
	'type' => 'textbox',
	'name' => 'review_woo_list_links',
	'label' => __('Set woocommerce product IDs', 'rehub_framework'),
	'description' => __('Insert woocommerce names of offers that you want to show in list with commas. Example, 22,33,45', 'rehub_framework'),		
);
return $woo_products_select;
}

VP_Security::instance()->whitelist_function('rehub_custom_badge_admin');
function rehub_custom_badge_admin()
{
$custom_badge_admin = array(
	'type' => 'radiobutton',
	'name' => 'is_editor_choice',
	'label' => __('Post badge', 'rehub_framework'),
	'description' => __('Check this box if you want to show post badge. You can customize them in theme option', 'rehub_framework'),
	'items' => array(
	    array(
	        'value' => '0',
	        'label' => __('No', 'rehub_framework'),
	    ),				
	    array(
	        'value' => '1',
	        'label' => (rehub_option ('badge_label_1') !='') ? rehub_option ('badge_label_1') : __('Editor choice', 'rehub_framework'),
	    ),
	    array(
	        'value' => '2',
	        'label' => (rehub_option ('badge_label_2') !='') ? rehub_option ('badge_label_2') : __('Best seller', 'rehub_framework'),
	    ),
	    array(
	        'value' => '3',
	        'label' => (rehub_option ('badge_label_3') !='') ? rehub_option ('badge_label_3') : __('Best value', 'rehub_framework'),
	    ),
	    array(
	        'value' => '4',
	        'label' => (rehub_option ('badge_label_4') !='') ? rehub_option ('badge_label_4') : __('Best price', 'rehub_framework'),
	    ),			    
	),			
);	
return $custom_badge_admin;
}

VP_Security::instance()->whitelist_function('admin_badge_preview_html');
function admin_badge_preview_html($label = '', $color = '')
{
	if(empty($label)) {$result = '';}
	else {
		$background = ($color) ? ' style="background-color:'.$color.'"' : '';
		$result = '<div class="starburst_admin_wrapper">';
		$result .= '<span class="re-ribbon-badge"><span'.$background.'>'.$label.'</span></span>';
		$result .= '</div>';
	}
	return $result;
}

VP_Security::instance()->whitelist_function('get_ce_modules_id_for_sinc');
function get_ce_modules_id_for_sinc()
{
	$data  = array();
	if(!rh_is_plugin_active('content-egg/content-egg.php')){
		$data[] = array(
			'value' => '',
			'label' => 'Content Egg is not installed',
		);		
	}
	else{
		$modules = \ContentEgg\application\components\ModuleManager::getInstance()->getAffiliateParsers();
		if (!empty($modules)) {
			foreach ($modules as $module) {
				$data[] = array(
					'value' => $module->getId(),
					'label' => $module->getName(),
				);
		    } 			
		}else{
			$data[] = array(
				'value' => '',
				'label' => 'Content Egg modules not found',
			);			
		}
		
	}

	return $data;
}

VP_Security::instance()->whitelist_function('rehub_get_offer_user_info');
function rehub_get_offer_user_info( $user_id ){
	if( empty($user_id) || !is_numeric($user_id) )
		return;
	$author_obj = get_userdata($user_id );
	if($author_obj){
		$user_data = '<strong>User name: </strong>' . $author_obj->display_name . '<br>';
		$user_data .= '<strong>User roles: </strong>' . implode(', ', $author_obj->roles) . '<br>';
		return $user_data;		
	}

}

VP_Security::instance()->whitelist_function('rehub_get_dealstore_tax_array');
function rehub_get_dealstore_tax_array($type)
{
	$args = array( 'hide_empty' => false, 'order' => 'ASC', 'taxonomy'=> 'dealstore');
	$terms = get_terms($args );
    $data  = array();
    if(!empty( $terms ) && !is_wp_error($terms)){
		foreach ($terms as $term) {
			$data[] = array(
				'value' => $term->term_id,
				'label' => $term->name,
			);
	    } 	
    }
	return $data;    
}

VP_Security::instance()->whitelist_function('rehub_get_post_layout_array');
function rehub_get_post_layout_array($type)
{
	$postlayout = apply_filters( 'rehub_post_layout_array', array(
		array(
			'value' => 'default',
			'label' => __('Simple', 'rehub_framework'),
		),
		array(
			'value' => 'meta_outside',
			'label' => __('Title is outside content', 'rehub_framework'),
		),
		array(
			'value' => 'meta_center',
			'label' => __('Center aligned (Rething style)', 'rehub_framework'),
		),	
		array(
			'value' => 'default_text_opt',
			'label' => __('Full width, optimized for reading', 'rehub_framework'),
		),			
		array(
			'value' => 'meta_compact',
			'label' => __('Compact (Recash style)', 'rehub_framework'),
		),
		array(
			'value' => 'meta_compact_dir',
			'label' => __('Compact (Redirect style)', 'rehub_framework'),
		),				
		array(
			'value' => 'corner_offer',
			'label' => __('Button in corner (Repick style)', 'rehub_framework'),
		),								
		array(
			'value' => 'meta_in_image',
			'label' => __('Title Inside image', 'rehub_framework'),
		),	
		array(
			'value' => 'meta_in_imagefull',
			'label' => __('Title Inside full image', 'rehub_framework'),
		),
		array(
			'value' => 'big_post_offer',
			'label' => __('Big post offer block in top', 'rehub_framework'),
		),		
		array(
			'value' => 'offer_and_review',
			'label' => __('Offer and review score', 'rehub_framework'),
		),				
	));

	if (rh_is_plugin_active('content-egg/content-egg.php')){
		$postlayoutce = array(
			array(
				'value' => 'meta_ce_compare',
				'label' => __('Price comparison (compact)', 'rehub_framework'),
			),			
			array(
				'value' => 'meta_ce_compare_full',
				'label' => __('Price comparison (Full width)', 'rehub_framework'),
			),		
			array(
				'value' => 'meta_ce_compare_auto',
				'label' => __('Auto Tabs Content Egg', 'rehub_framework'),
			),
			array(
				'value' => 'meta_ce_compare_auto_sec',
				'label' => __('Auto content Content Egg', 'rehub_framework'),
			),				
		);
		$postlayout = array_merge($postlayout, $postlayoutce);
	}

	return $postlayout;   
}

VP_Security::instance()->whitelist_function('rehub_get_product_layout_array');
function rehub_get_product_layout_array($type)
{
	$productlayout = apply_filters( 'rehub_global_product_layout_array', array(
		array(
			'value' => 'default_with_sidebar',
			'label' => __('Default with sidebar', 'rehub_framework'),
		),
		array(
			'value' => 'default_no_sidebar',
			'label' => __('Default without sidebar', 'rehub_framework'),
		),
		array(
			'value' => 'full_width_extended',
			'label' => __('Full width Extended', 'rehub_framework'),
		),
		array(
			'value' => 'sections_w_sidebar',
			'label' => __('Sections with sidebar', 'rehub_framework'),
		),		
		array(
			'value' => 'vendor_woo_list',
			'label' => __('Compare prices', 'rehub_framework'),
		),		
		array(
			'value' => 'ce_woo_list',
			'label' => __('Content Egg List', 'rehub_framework'),
		),	
		array(
			'value' => 'ce_woo_sections',
			'label' => __('Content Egg Auto Sections', 'rehub_framework'),
		),
		array(
			'value' => 'full_photo_booking',
			'label' => __('Full width Photo (booking)', 'rehub_framework'),
		),							
	));

	return $productlayout;   
}

////////



/**
 * EOF
 */