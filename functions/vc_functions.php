<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php
//////////////////////////////////////////////////////////////////
// Visual Composer functions
//////////////////////////////////////////////////////////////////

//REMOVE SOME DEFAULT ELEMENTS
vc_remove_element( 'vc_images_carousel' );
vc_remove_element( 'vc_teaser_grid' );
vc_remove_element( 'vc_posts_grid' );
vc_remove_element( 'vc_carousel' );
vc_remove_element( 'vc_posts_slider' );
vc_remove_element( 'vc_wp_recentcomments' );
vc_remove_element( 'vc_wp_calendar' );
vc_remove_element( 'vc_wp_tagcloud' );
vc_remove_element( 'vc_wp_text' );
vc_remove_element( 'vc_wp_meta' );
vc_remove_element( 'vc_wp_posts' );
vc_remove_element( 'vc_wp_pages' );
vc_remove_element( 'vc_wp_links' );
vc_remove_element( 'vc_wp_archives' );
vc_remove_element( 'vc_cta_button' );
vc_remove_element( 'vc_basic_grid' );
vc_remove_element( 'vc_media_grid' );
vc_remove_element( 'vc_masonry_grid' );
vc_remove_element( 'vc_masonry_media_grid' );
vc_remove_element( 'vc_hoverbox' );
function rehub_vc_remove_woocommerce() {
    if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
        vc_remove_element( 'woocommerce_cart' );
        vc_remove_element( 'woocommerce_checkout' );
        vc_remove_element( 'woocommerce_order_tracking' );
        vc_remove_element( 'woocommerce_my_account' );
        vc_remove_element( 'recent_products' );
        vc_remove_element( 'featured_products' );
        vc_remove_element( 'product' );
        vc_remove_element( 'products' );

        vc_remove_element( 'add_to_cart_url' );
        vc_remove_element( 'product_page' );
        vc_remove_element( 'product_category' );
        vc_remove_element( 'product_categories' );
        vc_remove_element( 'sale_products' );
        vc_remove_element( 'best_selling_products' );
        vc_remove_element( 'top_rated_products' );
        vc_remove_element( 'product_attribute' );
    }
}
add_action( 'vc_build_admin_page', 'rehub_vc_remove_woocommerce', 11 );
add_action( 'vc_load_shortcode', 'rehub_vc_remove_woocommerce', 11 );


add_filter( 'vc_load_default_templates', 'rh_delete_vc_default_templates' ); // we deleted default templates of VC
function rh_delete_vc_default_templates( $data ) {
    return array(); 
}

add_action( 'vc_load_default_templates_action','rh_custom_default_templates_for_vc' ); // We added our templates
function rh_custom_default_templates_for_vc() {
    include (rh_locate_template( 'functions/vc_templates/basic_templates.php' ) );
}

//Disable frontend
if(rehub_option('rehub_enable_front_vc') !='1'){
    vc_disable_frontend();
}

//Set default post types
vc_set_default_editor_post_types( array('page') );

$dir_for_vc = get_template_directory() . '/functions/vc_templates';
vc_set_shortcodes_templates_dir( $dir_for_vc );

//WIDGET BLOCK
vc_remove_param("vc_widget_sidebar", "title");

//ROW BLOCK
add_action( 'vc_after_init_base', 'add_more_rehub_layouts' );
function add_more_rehub_layouts() {
    global $vc_row_layouts;
    array_push( $vc_row_layouts, array(
        'cells' => '34_14',
        'mask' => '212',
        'title' => '3/4 + 1/4',
        'icon_class' => 'l_34_14')
    );    
}

vc_remove_param("vc_row", "full_width");
vc_add_params("vc_row", array(
    array(
        "type" => "checkbox",
        "class" => "",
        "group" => __("Type of row", "rehub_framework"),
        "heading" => __("Container with sidebar?", "rehub_framework"),
        "value" => array(__("Yes", "rehub_framework") => "true" ),
        "param_name" => "rehub_container",
        "description" => __("Is this container with sidebar? Enable this option and use 2/3 + 1/3 layout for better compatibility if you want to add sidebar widget area.", "rehub_framework")
    ),
    array(
        "type" => "checkbox",
        "class" => "",
        "group" => __("Type of row", "rehub_framework"),
        "heading" => __("Make sidebar with smart scroll function?", "rehub_framework"),
        "value" => array(__("Yes", "rehub_framework") => "true" ),
        "param_name" => "stickysidebar",
        'dependency' => array(
            'element' => 'rehub_container',
            'not_empty' => true,
        ),
    ),    
    array(
        "type" => "checkbox",
        "class" => "",
        "group" => __("Type of row", "rehub_framework"),        
        "heading" => __("Disable center alignment?", "rehub_framework"),
        "value" => array(__("Yes", "rehub_framework") => "true" ),
        "param_name" => "disable_centered_container",
        "description" => __("By default, all post modules have center alignment and max width as 1200px, you can disable this.", "rehub_framework")
    )        

));

$setting_row = array (
  'show_settings_on_create' => true,
);
$deprecate_sep = array (
  'deprecated' => '4.9',
);
vc_map_update( 'vc_row', $setting_row ); 
vc_map_update( 'vc_text_separator', $deprecate_sep );

//Filter autocompletes for default modules
$autocompletemoduleids = array('small_thumb_loop', 'regular_blog_loop', 'grid_loop_mod', 'columngrid_loop', 'compactgrid_loop_mod', 'wpsm_featured', 'post_carousel_mod', 'wpsm_recent_posts_list', 'wpsm_three_col_posts');
foreach ($autocompletemoduleids as $autocompletemoduleid) {
    add_filter( 'vc_autocomplete_'.$autocompletemoduleid.'_ids_callback',
    'rehub_post_search_vc', 10, 1 );
    add_filter( 'vc_autocomplete_'.$autocompletemoduleid.'_ids_render',
    'rehub_post_render_vc', 10, 1 );
    add_filter( 'vc_autocomplete_'.$autocompletemoduleid.'_cat_callback',
    'rehub_cat_search_vc', 10, 1 );
    add_filter( 'vc_autocomplete_'.$autocompletemoduleid.'_cat_render',
    'rehub_cat_render_vc', 10, 1 );
    add_filter( 'vc_autocomplete_'.$autocompletemoduleid.'_cat_exclude_callback',
    'rehub_cat_search_vc', 10, 1 );
    add_filter( 'vc_autocomplete_'.$autocompletemoduleid.'_cat_exclude_render',
    'rehub_cat_render_vc', 10, 1 );  
    add_filter( 'vc_autocomplete_'.$autocompletemoduleid.'_tag_callback',
    'rehub_tag_search_vc', 10, 1 );
    add_filter( 'vc_autocomplete_'.$autocompletemoduleid.'_tag_render',
    'rehub_tag_render_vc', 10, 1 );
    add_filter( 'vc_autocomplete_'.$autocompletemoduleid.'_tag_exclude_callback',
    'rehub_tag_search_vc', 10, 1 );
    add_filter( 'vc_autocomplete_'.$autocompletemoduleid.'_tag_exclude_render',
    'rehub_tag_render_vc', 10, 1 );          
}

//Filter autocompletes for news modules
$autocompletemodulenews = array('news_with_thumbs_mod');
foreach ($autocompletemodulenews as $autocompletemodulenew) {

    add_filter( 'vc_autocomplete_'.$autocompletemodulenew.'_module_cats_callback',
    'rehub_cat_search_vc', 10, 1 );
    add_filter( 'vc_autocomplete_'.$autocompletemodulenew.'_module_cats_render',
    'rehub_cat_render_vc', 10, 1 );
    add_filter( 'vc_autocomplete_'.$autocompletemodulenew.'_cat_exclude_callback',
    'rehub_cat_search_vc', 10, 1 );
    add_filter( 'vc_autocomplete_'.$autocompletemodulenew.'_cat_exclude_render',
    'rehub_cat_render_vc', 10, 1 );
    add_filter( 'vc_autocomplete_'.$autocompletemodulenew.'_module_tags_callback',
    'rehub_tag_search_vc', 10, 1 );
    add_filter( 'vc_autocomplete_'.$autocompletemodulenew.'_module_tags_render',
    'rehub_tag_render_vc', 10, 1 );
    add_filter( 'vc_autocomplete_'.$autocompletemodulenew.'_tag_exclude_callback',
    'rehub_tag_search_vc', 10, 1 );
    add_filter( 'vc_autocomplete_'.$autocompletemodulenew.'_tag_exclude_render',
    'rehub_tag_render_vc', 10, 1 );    
}

//Filter autocompletes for two col news module
$numberarraytwocols = array('first', 'second');
foreach ($numberarraytwocols as $numberarraytwocol) {
    add_filter( 'vc_autocomplete_two_col_news_module_cats_'.$numberarraytwocol.'_callback',
    'rehub_cat_search_vc', 10, 1 );
    add_filter( 'vc_autocomplete_two_col_news_module_cats_'.$numberarraytwocol.'_render',
    'rehub_cat_render_vc', 10, 1 );
    add_filter( 'vc_autocomplete_two_col_news_cat_exclude_'.$numberarraytwocol.'_callback',
    'rehub_cat_search_vc', 10, 1 );
    add_filter( 'vc_autocomplete_two_col_news_cat_exclude_'.$numberarraytwocol.'_render',
    'rehub_cat_render_vc', 10, 1 );

    add_filter( 'vc_autocomplete_two_col_news_module_tags_'.$numberarraytwocol.'_callback',
    'rehub_tag_search_vc', 10, 1 );
    add_filter( 'vc_autocomplete_two_col_news_module_tags_'.$numberarraytwocol.'_render',
    'rehub_tag_render_vc', 10, 1 );
    add_filter( 'vc_autocomplete_two_col_news_tag_exclude_'.$numberarraytwocol.'_callback',
    'rehub_tag_search_vc', 10, 1 );
    add_filter( 'vc_autocomplete_two_col_news_tag_exclude_'.$numberarraytwocol.'_render',
    'rehub_tag_render_vc', 10, 1 );        
}

//Filter autocompletes for tab news module
$numberarrays = array('first', 'second', 'third', 'fourth');
foreach ($numberarrays as $numberarray) {
    add_filter( 'vc_autocomplete_tab_mod_module_cats_'.$numberarray.'_callback',
    'rehub_cat_search_vc', 10, 1 );
    add_filter( 'vc_autocomplete_tab_mod_module_cats_'.$numberarray.'_render',
    'rehub_cat_render_vc', 10, 1 );
    add_filter( 'vc_autocomplete_tab_mod_cat_exclude_'.$numberarray.'_callback',
    'rehub_cat_search_vc', 10, 1 );
    add_filter( 'vc_autocomplete_tab_mod_cat_exclude_'.$numberarray.'_render',
    'rehub_cat_render_vc', 10, 1 );  
    add_filter( 'vc_autocomplete_tab_mod_module_tags_'.$numberarray.'_callback',
    'rehub_tag_search_vc', 10, 1 );
    add_filter( 'vc_autocomplete_tab_mod_module_tags_'.$numberarray.'_render',
    'rehub_tag_render_vc', 10, 1 );
    add_filter( 'vc_autocomplete_tab_mod_tag_exclude_'.$numberarray.'_callback',
    'rehub_tag_search_vc', 10, 1 );
    add_filter( 'vc_autocomplete_tab_mod_tag_exclude_'.$numberarray.'_render',
    'rehub_tag_render_vc', 10, 1 );        
}

//Filter autocompletes for woo modules
$autocompletewooids = array('wpsm_woorows', 'wpsm_woolist', 'wpsm_woogrid', 'wpsm_woocolumns', 'woo_mod', 'wpsm_woofeatured');
foreach ($autocompletewooids as $autocompletewooid) {
    add_filter( 'vc_autocomplete_'.$autocompletewooid.'_ids_callback',
        'rehub_woopost_search_vc', 10, 1 );
    add_filter( 'vc_autocomplete_'.$autocompletewooid.'_ids_render',
        'rehub_woopost_render_vc', 10, 1 );   
    add_filter( 'vc_autocomplete_'.$autocompletewooid.'_cat_callback',
        'rehub_catwoo_search_vc', 10, 1 );
    add_filter( 'vc_autocomplete_'.$autocompletewooid.'_cat_render',
        'rehub_catwoo_render_vc', 10, 1 ); 
    add_filter( 'vc_autocomplete_'.$autocompletewooid.'_tag_callback',
        'rehub_tagwoo_search_vc', 10, 1 );
    add_filter( 'vc_autocomplete_'.$autocompletewooid.'_tag_render',
        'rehub_tagwoo_render_vc', 10, 1 );                     
}
add_filter( 'vc_autocomplete_wpsm_woobox_id_callback',
    'rehub_woopost_search_vc', 10, 1 );
add_filter( 'vc_autocomplete_wpsm_woobox_id_render',
    'rehub_woopost_render_vc', 10, 1 );

add_filter( 'vc_autocomplete_wpsm_woo_versus_ids_callback',
    'rehub_woopost_search_vc', 10, 1 );
add_filter( 'vc_autocomplete_wpsm_woo_versus_ids_render',
    'rehub_woopost_render_vc', 10, 1 );

add_filter( 'vc_autocomplete_wpsm_woo_versus_attr_callback',
    'rehub_search_woo_attributes', 10, 1 );
add_filter( 'vc_autocomplete_wpsm_woo_versus_attr_render',
    'rehub_render_woo_attributes', 10, 1 );

function rehub_post_search_vc( $search_string ) {
    $query = $search_string;
    $data = array();
    $args = array( 's' => $query, 'post_type' => 'any' );
    $args['vc_search_by_title_only'] = true;
    $args['numberposts'] = - 1;
    if ( strlen( $args['s'] ) == 0 ) {
        unset( $args['s'] );
    }
    add_filter( 'posts_search', 'vc_search_by_title_only', 500, 2 );
    $posts = get_posts( $args );
    foreach ( $posts as $post ) {
        $data[] = array(
            'value' => $post->ID,
            'label' => $post->post_title,
        );
    }
    return $data;
}

function rehub_post_render_vc( $value ) {
    $post = get_post( $value['value'] );

    return is_null( $post ) ? false : array(
        'label' => $post->post_title,
        'value' => $post->ID,
    );
}

function rehub_woopost_search_vc( $search_string ) {
    $query = $search_string;
    $data = array();
    $args = array( 's' => $query, 'post_type' => 'product' );
    $args['vc_search_by_title_only'] = true;
    $args['numberposts'] = - 1;
    if ( strlen( $args['s'] ) == 0 ) {
        unset( $args['s'] );
    }
    add_filter( 'posts_search', 'vc_search_by_title_only', 500, 2 );
    $posts = get_posts( $args );
    foreach ( $posts as $post ) {
        $data[] = array(
            'value' => $post->ID,
            'label' => $post->post_title,
        );
    }
    return $data;
}

function rehub_woopost_render_vc( $value ) {
    $post = get_post( $value['value'] );

    return is_null( $post ) ? false : array(
        'label' => $post->post_title,
        'value' => $post->ID,
    );
}

function rehub_cat_search_vc( $query, $slug = false ) {
    global $wpdb;
    $cat_id = (int) $query;
    $query = trim( $query );
    $post_meta_infos = $wpdb->get_results( $wpdb->prepare( "SELECT a.term_id AS id, b.name as name, b.slug AS slug
                    FROM {$wpdb->term_taxonomy} AS a
                    INNER JOIN {$wpdb->terms} AS b ON b.term_id = a.term_id
                    WHERE a.taxonomy = 'category' AND (a.term_id = '%d' OR b.slug LIKE '%%%s%%' OR b.name LIKE '%%%s%%' )", $cat_id > 0 ? $cat_id : - 1, stripslashes( $query ), stripslashes( $query ) ), ARRAY_A );

    $result = array();
    if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
        foreach ( $post_meta_infos as $value ) {
            $data = array();
            $data['value'] = $slug ? $value['slug'] : $value['id'];
            $data['label'] = __( 'Id', 'rehub_framework' ) . ': ' . $value['id'] . ( ( strlen( $value['name'] ) > 0 ) ? ' - ' . __( 'Name', 'rehub_framework' ) . ': ' . $value['name'] : '' ) . ( ( strlen( $value['slug'] ) > 0 ) ? ' - ' . __( 'Slug', 'rehub_framework' ) . ': ' . $value['slug'] : '' );
            $result[] = $data;
        }
    }
    return $result;
}

function rehub_tag_search_vc( $query, $slug = false ) {
    global $wpdb;
    $cat_id = (int) $query;
    $query = trim( $query );
    $post_meta_infos = $wpdb->get_results( $wpdb->prepare( "SELECT a.term_id AS id, b.name as name, b.slug AS slug
                    FROM {$wpdb->term_taxonomy} AS a
                    INNER JOIN {$wpdb->terms} AS b ON b.term_id = a.term_id
                    WHERE a.taxonomy = 'post_tag' AND (a.term_id = '%d' OR b.slug LIKE '%%%s%%' OR b.name LIKE '%%%s%%' )", $cat_id > 0 ? $cat_id : - 1, stripslashes( $query ), stripslashes( $query ) ), ARRAY_A );

    $result = array();
    if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
        foreach ( $post_meta_infos as $value ) {
            $data = array();
            $data['value'] = $slug ? $value['slug'] : $value['id'];
            $data['label'] = __( 'Id', 'rehub_framework' ) . ': ' . $value['id'] . ( ( strlen( $value['name'] ) > 0 ) ? ' - ' . __( 'Name', 'rehub_framework' ) . ': ' . $value['name'] : '' ) . ( ( strlen( $value['slug'] ) > 0 ) ? ' - ' . __( 'Slug', 'rehub_framework' ) . ': ' . $value['slug'] : '' );
            $result[] = $data;
        }
    }
    return $result;
}

function rehub_catwoo_search_vc( $query, $slug = false ) {
    global $wpdb;
    $cat_id = (int) $query;
    $query = trim( $query );
    $post_meta_infos = $wpdb->get_results( $wpdb->prepare( "SELECT a.term_id AS id, b.name as name, b.slug AS slug
                    FROM {$wpdb->term_taxonomy} AS a
                    INNER JOIN {$wpdb->terms} AS b ON b.term_id = a.term_id
                    WHERE a.taxonomy = 'product_cat' AND (a.term_id = '%d' OR b.slug LIKE '%%%s%%' OR b.name LIKE '%%%s%%' )", $cat_id > 0 ? $cat_id : - 1, stripslashes( $query ), stripslashes( $query ) ), ARRAY_A );

    $result = array();
    if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
        foreach ( $post_meta_infos as $value ) {
            $data = array();
            $data['value'] = $slug ? $value['slug'] : $value['id'];
            $data['label'] = __( 'Id', 'rehub_framework' ) . ': ' . $value['id'] . ( ( strlen( $value['name'] ) > 0 ) ? ' - ' . __( 'Name', 'rehub_framework' ) . ': ' . $value['name'] : '' ) . ( ( strlen( $value['slug'] ) > 0 ) ? ' - ' . __( 'Slug', 'rehub_framework' ) . ': ' . $value['slug'] : '' );
            $result[] = $data;
        }
    }
    return $result;
}

function rehub_tagwoo_search_vc( $query, $slug = false ) {
    global $wpdb;
    $cat_id = (int) $query;
    $query = trim( $query );
    $post_meta_infos = $wpdb->get_results( $wpdb->prepare( "SELECT a.term_id AS id, b.name as name, b.slug AS slug
                    FROM {$wpdb->term_taxonomy} AS a
                    INNER JOIN {$wpdb->terms} AS b ON b.term_id = a.term_id
                    WHERE a.taxonomy = 'product_tag' AND (a.term_id = '%d' OR b.slug LIKE '%%%s%%' OR b.name LIKE '%%%s%%' )", $cat_id > 0 ? $cat_id : - 1, stripslashes( $query ), stripslashes( $query ) ), ARRAY_A );

    $result = array();
    if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
        foreach ( $post_meta_infos as $value ) {
            $data = array();
            $data['value'] = $slug ? $value['slug'] : $value['id'];
            $data['label'] = __( 'Id', 'rehub_framework' ) . ': ' . $value['id'] . ( ( strlen( $value['name'] ) > 0 ) ? ' - ' . __( 'Name', 'rehub_framework' ) . ': ' . $value['name'] : '' ) . ( ( strlen( $value['slug'] ) > 0 ) ? ' - ' . __( 'Slug', 'rehub_framework' ) . ': ' . $value['slug'] : '' );
            $result[] = $data;
        }
    }
    return $result;
}

function rehub_cat_render_vc( $query ) {
    $query = $query['value'];
    $cat_id = (int) $query;
    $term = get_term( $cat_id, 'category' );
    return rehubTaxTermOutput( $term );
}

function rehub_tag_render_vc( $query ) {
    $query = $query['value'];
    $cat_id = (int) $query;
    $term = get_term( $cat_id, 'post_tag' );
    return rehubTaxTermOutput( $term );
}

function rehub_catwoo_render_vc( $query ) {
    $query = $query['value'];
    $cat_id = (int) $query;
    $term = get_term( $cat_id, 'product_cat' );
    return rehubTaxTermOutput( $term );
}

function rehub_tagwoo_render_vc( $query ) {
    $query = $query['value'];
    $cat_id = (int) $query;
    $term = get_term( $cat_id, 'product_tag' );
    return rehubTaxTermOutput( $term );
}

function rehubTaxTermOutput( $term ) {
    $term_slug = $term->slug;
    $term_title = $term->name;
    $term_id = $term->term_id;

    $term_slug_display = '';
    if ( ! empty( $term_slug ) ) {
        $term_slug_display = ' - ' . __( 'Slug', 'rehub_framework' ) . ': ' . $term_slug;
    }

    $term_title_display = '';
    if ( ! empty( $term_title ) ) {
        $term_title_display = ' - ' . __( 'Title', 'rehub_framework' ) . ': ' . $term_title;
    }

    $term_id_display = __( 'Id', 'rehub_framework' ) . ': ' . $term_id;

    $data = array();
    $data['value'] = $term_id;
    $data['label'] = $term_id_display . $term_title_display . $term_slug_display;

    return ! empty( $data ) ? $data : false;
}

function rehub_search_woo_attributes ($query, $slug = false){
    global $wpdb;
    $query = trim( $query );
    $attribute_taxonomies = $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies WHERE attribute_name LIKE '%".$query."%'" );

    $attribute_taxonomies = array_filter( $attribute_taxonomies  ) ;
    $result = array();
    if ( is_array( $attribute_taxonomies ) && ! empty( $attribute_taxonomies ) ) {
        foreach ( $attribute_taxonomies as $value ) {
            $data = array();
            $data['value'] = $value->attribute_name;
            $data['label'] = $value->attribute_label;
            $result[] = $data;
        }
    }  
    return $result;  
}

function rehub_render_woo_attributes( $value ) {

    return array(
        'label' =>  $value['value'],
        'value' => $value['label'],
    );
}



//FILTER FUNCTIONS
if( !function_exists('rehub_vc_filter_formodules') ) {
    function rehub_vc_filter_formodules() {
    $post_formats = array(   
        __('all', 'rehub_framework') => 'all',
        __('regular', 'rehub_framework') => 'regular',
        __('video', 'rehub_framework') => 'video',
        __('gallery', 'rehub_framework') => 'gallery',
        __('review', 'rehub_framework') => 'review',
        __('music', 'rehub_framework') => 'music',              
    );        
    return array(         
        array(
            "type" => "dropdown",
            "class" => "",
            "admin_label" => true,
            "heading" => __('Data source', 'rehub_framework'),
            "param_name" => "data_source",
            "value" => array(
                __('Category or tag', 'rehub_framework') => "cat",
                __('Manual select and order', 'rehub_framework') => "ids",
                __('Is editor choice', 'rehub_framework') => "badge",
                __('Custom post type and taxonomy', 'rehub_framework') => "cpt",                    
            ), 
        ),
        array(
            'type' => 'autocomplete',
            'heading' => __( 'Category', 'rehub_framework' ),
            'param_name' => 'cat',
            'settings' => array(
                'multiple' => true,
                'sortable' => true,
                'groups' => false,
            ),
            "admin_label" => true,
            'description' => __( 'Enter names of categories. Or leave blank to show all', 'rehub_framework' ),
            'dependency' => array(
                'element' => 'data_source',
                'value' => array( 'cat' ),
            ),          
        ),
        array(
            'type' => 'autocomplete',
            "admin_label" => true,
            'heading' => __( 'Category exclude', 'rehub_framework' ),
            'param_name' => 'cat_exclude',
            'settings' => array(
                'multiple' => true,
                'sortable' => true,
                'groups' => false,
            ),
            'description' => __( 'Enter names of categories to exclude', 'rehub_framework' ),
            'dependency' => array(
                'element' => 'data_source',
                'value' => array( 'cat' ),
            ),          
        ),        
        array(
            'type' => 'autocomplete',
            'heading' => __( 'Tags', 'rehub_framework' ),
            'param_name' => 'tag',
            "admin_label" => true,
            'settings' => array(
                'multiple' => true,
                'sortable' => true,
                'groups' => false,
            ),
            'description' => __( 'Enter names of tags. Or leave blank to show all', 'rehub_framework' ),
            'dependency' => array(
                'element' => 'data_source',
                'value' => array( 'cat' ),
            ),          
        ),  
        array(
            'type' => 'autocomplete',
            'heading' => __( 'Tags exclude', 'rehub_framework' ),
            'param_name' => 'tag_exclude',
            "admin_label" => true,
            'settings' => array(
                'multiple' => true,
                'sortable' => true,
                'groups' => false,
            ),
            'description' => __( 'Enter names of tags to exclude.', 'rehub_framework' ),
            'dependency' => array(
                'element' => 'data_source',
                'value' => array( 'cat' ),
            ),          
        ),                  
        array(
            'type' => 'autocomplete',
            'heading' => __( 'Post names', 'rehub_framework' ),
            'param_name' => 'ids',
            'settings' => array(
                'multiple' => true,
                'sortable' => true,
                'groups' => false,
            ),
            "admin_label" => true,
            'description' => __( 'Or enter names of posts.', 'rehub_framework' ),
            'dependency' => array(
                'element' => 'data_source',
                'value' => array( 'ids' ),
            ),                          
        ), 
        array(
            'type' => 'dropdown',
            "admin_label" => true,
            'heading' => __( 'Editor label', 'rehub_framework' ),
            'param_name' => 'badge_label',
            'value' => array(
                __( 'Editor choice', 'rehub_framework' ) => '1',
                __( 'Custom label 2', 'rehub_framework' ) => '2',
                __( 'Custom label 3', 'rehub_framework' ) => '3',
                __( 'Custom label 4', 'rehub_framework' ) => '4',
            ),
            'description' => __( 'Select admin label. You can customize labels in theme option - custom badges for posts', 'rehub_framework' ),
            'dependency' => array(
                'element' => 'data_source',
                'value' => array( 'badge' ),
            ),
        ),         
        array(
            'type' => 'dropdown',
            "admin_label" => true,
            'heading' => __( 'Post type', 'rehub_framework' ),
            'param_name' => 'post_type',
            'value' => rehub_post_type_vc(),
            'dependency' => array(
                'element' => 'data_source',
                'value' => array( 'cpt'),
            ),            
        ),   
        array(
            'type' => 'textfield',
            "admin_label" => true,
            'heading' => __( 'Taxonomy slug', 'rehub_framework' ),
            'param_name' => 'tax_name',
            'description' => __( 'Enter slug of your taxonomy. Examples: if you want to use post categories - use <strong>category</strong>. If you want to use woocommerce product category - use <strong>product_cat</strong>, woocommerce tags - <strong>product_tag</strong>', 'rehub_framework' ),
            'dependency' => array(
                'element' => 'data_source',
                'value' => array( 'cpt'),
            ),
        ), 
        array(
            'type' => 'textfield',
            "admin_label" => true,
            'heading' => __( 'Taxonomy term slug', 'rehub_framework' ),
            'param_name' => 'tax_slug',
            'description' => __( 'Enter term slug of your taxonomy if you want to show only posts from this taxonomy term', 'rehub_framework' ),
            'dependency' => array(
                'element' => 'tax_name',
                'not_empty' => true,
            ),
        ),  
        array(
            'type' => 'textfield',
            "admin_label" => true,
            'heading' => __( 'Taxonomy term slug exclude', 'rehub_framework' ),
            'param_name' => 'tax_slug_exclude',
            'description' => __( 'Enter slug of your taxonomy term to exclude', 'rehub_framework' ),
            'dependency' => array(
                'element' => 'tax_name',
                'not_empty' => true,
            ),
        ), 
        array(
            "type" => "dropdown",
            "class" => "",
            "heading" => __('Deal filter', 'rehub_framework'),
            "admin_label" => true,
            "param_name" => "show_coupons_only",
            "value" => array(
                __('Show all', 'rehub_framework') => "all",
                __('Show discounts (not expired)', 'rehub_framework') => "1",
                __('Only offers, excluding coupons (not expired)', 'rehub_framework') => "5",                
                __('Only coupons (not expired)', 'rehub_framework') => "2",                  
                __('Show all except expired', 'rehub_framework') => "3", 
                __('Only expired offers (which have expired date)', 'rehub_framework') => "4",
                __('Only with reviews', 'rehub_framework') => "6",                 
            ), 
            'description' => __( 'Choose deal type if you use Posts as offers', 'rehub_framework' ),
        ),    
        array(
            'type' => 'textfield',
            "admin_label" => true,
            'heading' => __( 'Price range', 'rehub_framework' ),
            'param_name' => 'price_range',
            'description' => __( 'Set price range to show. Works only for posts with Main Post offer section. Example of using: 0-100. Will show products with price under 100', 'rehub_framework' ),
            'group' => __( 'Data settings', 'js_composer' ),
        ),                                             
        array(
            'type' => 'dropdown',
            'heading' => __( 'Order by', 'js_composer' ),
            'param_name' => 'orderby',
            "admin_label" => true,
            'value' => array(
                __( 'Date', 'js_composer' ) => 'date',
                __( 'Order by post ID', 'js_composer' ) => 'ID',
                __( 'Title', 'js_composer' ) => 'title',
                __( 'Last modified date', 'js_composer' ) => 'modified',
                __( 'Number of comments', 'js_composer' ) => 'comment_count',               
                __( 'Meta value', 'js_composer' ) => 'meta_value',
                __( 'Meta value number', 'js_composer' ) => 'meta_value_num',
                __( 'Views', 'rehub_framework' ) => 'view',  
                __( 'Thumb/Hot counter', 'rehub_framework' ) => 'thumb',
                __( 'Price', 'rehub_framework' ) => 'price',                    
                __( 'Discount', 'rehub_framework' ) => 'discount',                                            
                __( 'Random order', 'js_composer' ) => 'rand',
            ),
            'description' => __( 'Select order type. If "Meta value" or "Meta value Number" is chosen then meta key is required.', 'js_composer' ),
            'group' => __( 'Data settings', 'js_composer' ),
            'dependency' => array(
                'element' => 'data_source',
                'value_not_equal_to' => array( 'ids'),
            ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Sorting', 'js_composer' ),
            'param_name' => 'order',
            'group' => __( 'Data settings', 'js_composer' ),
            'value' => array(
                __( 'Descending', 'js_composer' ) => 'DESC',
                __( 'Ascending', 'js_composer' ) => 'ASC',
            ),
            'description' => __( 'Select sorting order.', 'js_composer' ),
            'dependency' => array(
                'element' => 'data_source',
                'value_not_equal_to' => array( 'ids' ),
            ),
        ),
        array(
            'type' => 'textfield',
            "admin_label" => true,
            'heading' => __( 'Meta key', 'js_composer' ),
            'param_name' => 'meta_key',
            'description' => __( 'Input meta key for ordering.', 'rehub_framework' ),
            'group' => __( 'Data settings', 'js_composer' ),
            'dependency' => array(
                'element' => 'orderby',
                'value' => array( 'meta_value', 'meta_value_num' ),
            ),
        ),
        array(
            "type" => "dropdown",
            "admin_label" => true,
            "heading" => __('Choose post formats', 'rehub_framework'),
            "param_name" => "post_formats",
            "value" => $post_formats,
            'description' => __('Choose post formats to display or leave blank to display all', 'rehub_framework'),
            'group' => __( 'Data settings', 'js_composer' ),            
            'dependency' => array(
                'element' => 'data_source',
                'value' => array( 'cat', 'badge' ),
            ),          
        ),  
        array(
            "type" => "textfield",
            "heading" => __('Offset', 'rehub_framework'),
            "param_name" => "offset",
            "value" => '',
            'description' => __('Number of products to offset', 'rehub_framework'),
            'group' => __( 'Data settings', 'js_composer' ),          
        ),                  
        array(
            "type" => "dropdown",
            "class" => "",
            "heading" => __('Filter by date', 'rehub_framework'),
            "param_name" => "show_date",
            "value" => array(
                __('All', 'rehub_framework') => "all",
                __('Published last 24 hours', 'rehub_framework') => "day",
                __('Published last 7 days', 'rehub_framework') => "week", 
                __('Published last month', 'rehub_framework') => "month",  
                __('Published last year', 'rehub_framework') => "year",                                                
            ),
            'group' => __( 'Data settings', 'js_composer' ),
            'dependency' => array(
                'element' => 'data_source',
                'value_not_equal_to' => array( 'ids' ),
            ),          
        ),                 
        array(
            "type" => "textfield",
            "heading" => __('Fetch Count', 'rehub_framework'),
            "param_name" => "show",
            "admin_label" => true,
            "value" => '12',
            'description' => __('Number of products to display', 'rehub_framework'),
            'group' => __( 'Data settings', 'js_composer' ),
            'dependency' => array(
                'element' => 'data_source',
                'value_not_equal_to' => array( 'ids' ),
            ),          
        ),  
        array(
            "type" => "dropdown",
            "class" => "",
            "heading" => __('Pagination type', 'rehub_framework'),
            "param_name" => "enable_pagination",
            "value" => array(
                __('No pagination', 'rehub_framework') => "no",
                __('Simple pagination', 'rehub_framework') => "1",
                __('Infinite scroll', 'rehub_framework') => "2",  
                __('New item will be added by click', 'rehub_framework') => "3",                                  
            ),
            'group' => __( 'Data settings', 'js_composer' ),
            'dependency' => array(
                'element' => 'data_source',
                'value_not_equal_to' => array( 'ids' ),
            ),          
        ),                                                                   
    );       
    }
}

//FILTER WOO FUNCTIONS
if( !function_exists('rehub_woo_vc_filter_formodules') ) {
    function rehub_woo_vc_filter_formodules() {
        return array(
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __('Data source', 'rehub_framework'),
                "param_name" => "data_source",
                "value" => array(
                    __('Category', 'rehub_framework') => "cat",
                    __('Tag', 'rehub_framework') => "tag",                
                    __('Manual select and order', 'rehub_framework') => "ids",  
                    __('Type of products', 'rehub_framework') => "type",                
                ), 
            ),      
            array(
                'type' => 'autocomplete',
                'heading' => __( 'Category', 'rehub_framework' ),
                'param_name' => 'cat',
                "admin_label" => true,
                'settings' => array(
                    'multiple' => true,
                    'sortable' => true,
                    'groups' => false,
                ),
                'description' => __( 'Enter names of categories', 'rehub_framework' ),
                'dependency' => array(
                    'element' => 'data_source',
                    'value' => array( 'cat' ),
                ),          
            ),
            array(
                'type' => 'autocomplete',
                'heading' => __( 'Tag', 'rehub_framework' ),
                'param_name' => 'tag',
                "admin_label" => true,
                'settings' => array(
                    'multiple' => true,
                    'sortable' => true,
                    'groups' => false,
                ),
                'description' => __( 'Enter names of tags', 'rehub_framework' ),
                'dependency' => array(
                    'element' => 'data_source',
                    'value' => array( 'tag' ),
                ),          
            ),         
            array(
                'type' => 'autocomplete',
                'heading' => __( 'Product names', 'rehub_framework' ),
                'param_name' => 'ids',
                "admin_label" => true,
                'settings' => array(
                    'multiple' => true,
                    'sortable' => true,
                    'groups' => false,
                ),
                'dependency' => array(
                    'element' => 'data_source',
                    'value' => array( 'ids' ),
                ),                          
            ), 
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __('Type of product', 'rehub_framework'),
                "param_name" => "type",
                "admin_label" => true,
                "value" => array(
                    __('Recent products', 'rehub_framework') => "recent",
                    __('Featured products', 'rehub_framework') => "featured",   
                    __('Sale products', 'rehub_framework') => "sale",
                    __('Best selling products', 'rehub_framework') => "best_sale"                               
                ), 
                'dependency' => array(
                    'element' => 'data_source',
                    'value' => array( 'type' ),
                ),          
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __('Deal filter', 'rehub_framework'),
                "admin_label" => true,
                "param_name" => "show_coupons_only",
                "value" => array(
                    __('Show all', 'rehub_framework') => "all",
                    __('Show discounts (not expired)', 'rehub_framework') => "1",
                    __('Only offers, excluding coupons (not expired)', 'rehub_framework') => "5",                
                    __('Only coupons (not expired)', 'rehub_framework') => "4",                  
                    __('Show all except expired', 'rehub_framework') => "2", 
                    __('Only expired offers (which have expired date)', 'rehub_framework') => "3",         
                ), 
                "description" => __( 'Choose deal type if you use Posts as offers', 'rehub_framework' ),         
            ),
            array(
                'type' => 'textfield',
                "admin_label" => true,
                'heading' => __( 'Price range', 'rehub_framework' ),
                'param_name' => 'price_range',
                'description' => __( 'Set price range to show. Works only for posts with Main Post offer section. Example of using: 0-100. Will show products with price under 100', 'rehub_framework' ),
                'group' => __( 'Data settings', 'js_composer' ),
            ),                          
            array(
                'type' => 'dropdown',
                'heading' => __( 'Order by', 'js_composer' ),
                'param_name' => 'orderby',
                "admin_label" => true,
                'value' => array(
                    __( 'Date', 'js_composer' ) => 'date',
                    __( 'Order by post ID', 'js_composer' ) => 'ID',
                    __( 'Title', 'js_composer' ) => 'title',
                    __( 'Last modified date', 'js_composer' ) => 'modified',
                    __( 'Number of comments', 'js_composer' ) => 'comment_count',               
                    __( 'Meta value', 'js_composer' ) => 'meta_value',
                    __( 'Meta value number', 'js_composer' ) => 'meta_value_num',
                    __( 'Random order', 'js_composer' ) => 'rand',
                ),
                'group' => __( 'Data settings', 'js_composer' ),
                'dependency' => array(
                    'element' => 'data_source',
                    'value_not_equal_to' => array( 'ids'),
                ),
            ),
            array(
                'type' => 'textfield',
                "admin_label" => true,
                'heading' => __( 'Meta key', 'js_composer' ),
                'param_name' => 'meta_key',
                'description' => __( 'Input meta key for ordering.', 'rehub_framework' ),
                'group' => __( 'Data settings', 'js_composer' ),
                'dependency' => array(
                    'element' => 'orderby',
                    'value' => array( 'meta_value', 'meta_value_num' ),
                ),
            ),  
            array(
                'type' => 'textfield',
                "admin_label" => true,
                'heading' => __( 'User ID', 'rehub_framework' ),
                'param_name' => 'user_id',
                'description' => __( 'Add user ID to show only his posts', 'rehub_framework' ),
                'group' => __( 'Data settings', 'js_composer' ),
            ),                      
            array(
                'type' => 'dropdown',
                'heading' => __( 'Sorting', 'js_composer' ),
                'param_name' => 'order',
                'group' => __( 'Data settings', 'js_composer' ),
                'value' => array(
                    __( 'Descending', 'js_composer' ) => 'DESC',
                    __( 'Ascending', 'js_composer' ) => 'ASC',
                ),
                'description' => __( 'Select sorting order.', 'js_composer' ),
                'dependency' => array(
                    'element' => 'data_source',
                    'value_not_equal_to' => array( 'ids' ),
                ),
            ),  
            array(
                "type" => "textfield",
                "heading" => __('Fetch Count', 'rehub_framework'),
                "param_name" => "show",
                "admin_label" => true,
                "value" => '12',
                'description' => __('Number of products to display', 'rehub_framework'),
                'group' => __( 'Data settings', 'js_composer' ),
                'dependency' => array(
                    'element' => 'data_source',
                    'value_not_equal_to' => array( 'ids' ),
                ),          
            ),   
            array(
                "type" => "textfield",
                "admin_label" => true,
                "heading" => __('Offset', 'rehub_framework'),
                "param_name" => "offset",
                "value" => '',
                'description' => __('Number of products to offset', 'rehub_framework'),
                'group' => __( 'Data settings', 'js_composer' ),          
            ),   
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __('Show by date', 'rehub_framework'),
                "param_name" => "show_date",
                "value" => array(
                    __('All', 'rehub_framework') => "all",
                    __('Published last 24 hours', 'rehub_framework') => "day",
                    __('Published last 7 days', 'rehub_framework') => "week", 
                    __('Published last month', 'rehub_framework') => "month",  
                    __('Published last year', 'rehub_framework') => "year",                                                
                ),
                'group' => __( 'Data settings', 'js_composer' ),
                'dependency' => array(
                    'element' => 'data_source',
                    'value_not_equal_to' => array( 'ids' ),
                ),          
            ),                                                         
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __('Pagination type', 'rehub_framework'),
                "param_name" => "enable_pagination",
                "value" => array(
                    __('No pagination', 'rehub_framework') => "0",
                    __('Simple pagination', 'rehub_framework') => "1",
                    __('Infinite scroll', 'rehub_framework') => "2",  
                    __('New item will be added by click', 'rehub_framework') => "3",                      
                ),
                'group' => __( 'Data settings', 'js_composer' ),
                'dependency' => array(
                    'element' => 'data_source',
                    'value_not_equal_to' => array( 'ids' ),
                ),          
            ),
            array(
                'type' => 'textfield',
                'group' => __( 'Taxonomy', 'rehub_framework' ),
                "admin_label" => true,
                'heading' => __( 'Taxonomy slug', 'rehub_framework' ),
                'param_name' => 'tax_name',
                'description' => __( 'Enter slug of your taxonomy. Example, taxonomy for product store - is <strong>store</strong>. For color attribute - <strong>pa_color</strong>, for product tags - <strong>product_tag</strong>', 'rehub_framework' ),
            ), 
            array(
                'type' => 'textfield',
                'group' => __( 'Taxonomy', 'rehub_framework' ),
                "admin_label" => true,
                'heading' => __( 'Taxonomy term slug', 'rehub_framework' ),
                'param_name' => 'tax_slug',
                'description' => __( 'Enter slug of your taxonomy term if you want to show only posts from certain taxonomy term. Example, for store taxonomy - amazon, for color - black', 'rehub_framework' ),
                'dependency' => array(
                    'element' => 'tax_name',
                    'not_empty' => true,
                ),
            ),
            array(
                'type' => 'textfield',
                "admin_label" => true,
                'heading' => __( 'Taxonomy term slug exclude', 'rehub_framework' ),
                'param_name' => 'tax_slug_exclude',
                'description' => __( 'Enter slug of your taxonomy term to exclude', 'rehub_framework' ),
                'dependency' => array(
                    'element' => 'tax_name',
                    'not_empty' => true,
                ),
            ),                         

        );
    }
}

//FILTER PANEL FUNCTIONS
if( !function_exists('rehub_vc_aj_filter_btns_formodules') ) {
    function rehub_vc_aj_filter_btns_formodules() {
        return array(
        array(
            "type" => "checkbox",
            "class" => "",
            "group" => __('Filter panel', 'rehub_framework'),        
            "heading" => __('Enable panel?', 'rehub_framework'),
            "value" => array(__("Yes", "rehub_framework") => true ),
            "param_name" => "filterpanelenable",         
        ),            
        array(
            'type' => 'param_group',
            "group" => __('Filter panel', 'rehub_framework'),             
            'heading' => __( 'Filter panel', 'rehub_framework' ),
            'param_name' => 'filterpanel',
            'dependency' => array(
                'element' => 'filterpanelenable',
                'not_empty' => true,
            ),             
            'value' => urlencode( json_encode( array(
                array(
                    'filtertitle' => __( 'Show all', 'rehub_framework' ),
                    'filtertype' => 'all',
                    'filterorder' => 'DESC',
                    'filterdate'=> 'all',
                ),
            ) ) ),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'heading' => __( 'Label', 'rehub_framework' ),
                    'param_name' => 'filtertitle',
                    'description' => __( 'Enter title for filter button', 'rehub_framework' ),
                    'admin_label' => true,
                ),
                array(
                    "type" => "dropdown",
                    "class" => "",
                    "heading" => __('Type of filter', 'rehub_framework'),
                    "param_name" => "filtertype",
                    "value" => array(
                        __('Show all posts', 'rehub_framework') => "all",
                        __('Sort by comments count', 'rehub_framework') => "comment",
                        __('Sort by meta field', 'rehub_framework') => "meta", 
                        __('Sort by expiration date', 'rehub_framework') => "expirationdate",
                        __('Sort by price range', 'rehub_framework') => "pricerange", 
                        __('Show hottest sorted by date', 'rehub_framework') => "hot",           
                        __('Sort by taxonomy', 'rehub_framework') => "tax", 
                        __('Show only deals', 'rehub_framework') => "deals", 
                        __('Show only coupons', 'rehub_framework') => "coupons",            
                    ), 
                    "description" =>  __('Some important meta keys: <br /><strong>rehub_main_product_price</strong> - key where stored price of main offer, <br /><strong>rehub_review_overall_score</strong> - key for overall review score, <br /><strong>post_hot_count</strong> - hot or thumb counter, <br /><strong>post_user_average</strong> - user rating score(based on full review criterias), <br /><strong>rehub_views</strong> - post view counter, <br /><strong>rehub_views_mon, rehub_views_day, rehub_views_year</strong> - post view counter by day, month, year <br /><strong>affegg_product_price</strong> - price of main offer for Affiliate Egg plugin, <br /><strong>_price</strong> - key for price of woocommerce products, <br /><strong>total_sales</strong> - key for sales of woocommerce products', 'rehub_framework'),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __( 'Type key for meta', 'rehub_framework' ),
                    'param_name' => 'filtermetakey',
                    "dependency" => Array('element' => "filtertype", 'value' => array('meta')),
                ), 
                array(
                    'type' => 'textfield',
                    'heading' => __( 'Price range', 'rehub_framework' ),
                    'param_name' => 'filterpricerange',
                    'description' => __( 'Set price range to show. Works only for posts with Main Post offer section. Example of using: 0-100. Will show products with price under 100', 'rehub_framework' ),                   
                    "dependency" => Array('element' => "filtertype", 'value' => array('pricerange')),
                ), 
                array(
                    "type" => "dropdown",
                    "class" => "",
                    "heading" => __('Order by', 'rehub_framework'),
                    "param_name" => "filterorderby",
                    'value' => array(
                        __( 'Date', 'js_composer' ) => 'date',
                        __( 'Order by post ID', 'js_composer' ) => 'ID',
                        __( 'Title', 'js_composer' ) => 'title',
                        __( 'Last modified date', 'js_composer' ) => 'modified',
                        __( 'Number of comments', 'js_composer' ) => 'comment_count',
                        __( 'Views', 'rehub_framework' ) => 'view',  
                        __( 'Thumb/Hot counter', 'rehub_framework' ) => 'thumb',
                        __( 'Price', 'rehub_framework' ) => 'price',                    
                        __( 'Discount', 'rehub_framework' ) => 'discount',        
                        __( 'Random order', 'js_composer' ) => 'rand',
                    ),
                    "dependency" => Array('element' => "filtertype", 'value' => array('pricerange')),
                ),                                
                array(
                    'type' => 'textfield',
                    'heading' => __( 'Taxonomy slug', 'rehub_framework' ),
                    'param_name' => 'filtertaxkey',
                    'description' => __( 'Enter slug of your taxonomy. Examples: if you want to use post categories - use <strong>category</strong>. If you want to use woocommerce product category - use <strong>product_cat</strong>, woocommerce tags - <strong>product_tag</strong>', 'rehub_framework' ),
                    "dependency" => Array('element' => "filtertype", 'value' => array('tax')),
                ), 
                array(
                    'type' => 'textfield',
                    'heading' => __( 'Taxonomy term slug', 'rehub_framework' ),
                    'param_name' => 'filtertaxtermslug',
                    'description' => __( 'Enter term slug of your taxonomy if you want to show only posts from this taxonomy term', 'rehub_framework' ),
                    "dependency" => Array('element' => "filtertype", 'value' => array('tax')),
                ),                 
                array(
                    'type' => 'dropdown',
                    'heading' => __( 'Sorting', 'js_composer' ),
                    'param_name' => 'filterorder',
                    'value' => array(
                        __( 'Descending', 'js_composer' ) => 'DESC',
                        __( 'Ascending', 'js_composer' ) => 'ASC',
                    ),
                    'description' => __( 'Select sorting order.', 'js_composer' ),
                ),
                array(
                    "type" => "dropdown",
                    "class" => "",
                    "heading" => __('Filter by date of publishing', 'rehub_framework'),
                    "param_name" => "filterdate",
                    "value" => array(
                        __('All', 'rehub_framework') => "all",
                        __('Published last 24 hours', 'rehub_framework') => "day",
                        __('Published last 7 days', 'rehub_framework') => "week", 
                        __('Published last month', 'rehub_framework') => "month",  
                        __('Published last year', 'rehub_framework') => "year",                                                
                    ), 
                ),                                                             
            ),
            'description' => 'Don\'t use more than 4-5 filters!!!!! Settings for first tab must be the same as main post settings of block'
        ),
        array(
            "type" => "textfield",
            "heading" => __('Taxonomy dropdown', 'rehub_framework'),
            "param_name" => "taxdrop",
            "group" => __('Filter panel', 'rehub_framework'),             
            "description" => __('Type here taxonomy slug if you want to show dropdown', 'rehub_framework'),
            'dependency' => array(
                'element' => 'filterpanelenable',
                'not_empty' => true,
            ),             
        ),
        array(
            "type" => "textfield",
            "heading" => __('Taxonomy ids', 'rehub_framework'),
            "param_name" => "taxdropids",
            "group" => __('Filter panel', 'rehub_framework'),             
            "description" => __('Type here ids of taxonomy separated by comma  which you need to show. Leave empty to show all', 'rehub_framework'),
            'dependency' => array(
                'element' => 'taxdrop',
                'not_empty' => true,
            ),             
        ),        
        array(
            "type" => "textfield",
            "heading" => __('Taxonomy dropdown label', 'rehub_framework'),
            "param_name" => "taxdroplabel",
            "group" => __('Filter panel', 'rehub_framework'),             
            "description" => __('Type here label for dropdown', 'rehub_framework'),
            'dependency' => array(
                'element' => 'taxdrop',
                'not_empty' => true,
            ),             
        ),        

        );
    }
}

//IMAGE SLIDER
add_action( 'vc_after_init', 're_remove_slider_type' ); 
function re_remove_slider_type() {
    $param = WPBMap::getParam( 'vc_gallery', 'type' );
    unset($param['value'][__( 'Flex slider fade', 'js_composer' )]);
    unset($param['value'][__( 'Nivo slider', 'js_composer' )]);
    vc_update_shortcode_param( 'vc_gallery', $param );
}

add_action( 'vc_before_init', 'rehub_integrateWithVC' );
function rehub_integrateWithVC() { 

vc_remove_param("vc_gallery", "interval");
vc_add_param("vc_gallery", 
    array(
        "type" => "checkbox",
        "class" => "",
        "heading" => __('Autoplay?', 'rehub_framework'),
        "value" => array(__("Yes", "rehub_framework") => true ),
        "param_name" => "autoplay",         
    ) 
);

//Where to open window
$target_arr = array(__("Same window", "js_composer") => "_self", __("New window", "js_composer") => "_blank");

//Post format chooser
$post_formats = array(   
    __('all', 'rehub_framework') => 'all',
    __('regular', 'rehub_framework') => 'regular',
    __('video', 'rehub_framework') => 'video',
    __('gallery', 'rehub_framework') => 'gallery',
    __('review', 'rehub_framework') => 'review',
    __('music', 'rehub_framework') => 'music',              
);

//CPT chooser
if( !function_exists('rehub_post_type_vc') ) {
    function rehub_post_type_vc() {
        $post_types = get_post_types( array('public'   => true) );
        $post_types_list = array();
        foreach ( $post_types as $post_type ) {
            if ( $post_type !== 'revision' && $post_type !== 'nav_menu_item' && $post_type !== 'attachment') {
                $label = ucfirst( $post_type );
                $post_types_list[$label] = $post_type;
            }
        }
        return $post_types_list;
    }
}

//TITLE FOR CUSTOM BLOCK
vc_map( array(
    "name" => __('Module title', 'rehub_framework'),
    "base" => "title_mod",
    "icon" => "icon-title-mod",
    "category" => __('Content modules', 'rehub_framework'),
    'description' => __('Title for modules', 'rehub_framework'), 
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __('Title', 'rehub_framework'),
            "param_name" => "title_name",
            "admin_label" => true,
        ),
        array(
            'type' => 'colorpicker',
            "admin_label" => true,
            'heading' => __( 'Color for title', 'rehub_framework' ),
            'description' => __('Default is black', 'rehub_framework'),
            'param_name' => 'title_color',        
        ),
        array(
            'type' => 'colorpicker',
            "admin_label" => true,
            'heading' => __( 'Color for title background', 'rehub_framework' ),
            'description' => __('Default is transparent', 'rehub_framework'),
            'param_name' => 'title_background_color',        
        ),   
        array(
            "type" => "dropdown",
            "class" => "",
            "heading" => __('Size of title', 'rehub_framework'),
            "param_name" => "title_size",
            "value" => array(
                __('Middle', 'rehub_framework') => "middle",
                __('Big', 'rehub_framework') => "big",
                __('Small', 'rehub_framework') => "small",  
                __('Extra Big', 'rehub_framework') => "extrabig", 
                __('Extra Small', 'rehub_framework') => "extrasmall",               
            ), 
        ), 
        array(
            "type" => "checkbox",
            "class" => "",
            "heading" => __('Disable bold?', 'rehub_framework'),
            "value" => array(__("Yes", "rehub_framework") => true ),
            "param_name" => "title_bold",         
        ),                 
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'rehub_framework' ),
            'param_name' => 'title_icon',
            'value' => '',
            'settings' => array(
                'emptyIcon' => true,
                'iconsPerPage' => 100,
            ),
            'group'=> 'Icon',            
        ),              
        array(
            "type" => "dropdown",
            "class" => "",
            "heading" => __('Title Position', 'rehub_framework'),
            "param_name" => "title_pos",
            "value" => array(
                __('Left', 'rehub_framework') => "left",
                __('Right', 'rehub_framework') => "right",
                __('Center', 'rehub_framework') => "center",                
            ), 
        ),                             
        array(
            "type" => "dropdown",
            "class" => "",
            "heading" => __('Title line', 'rehub_framework'),
            "param_name" => "title_line",
            "value" => array(
                __('Under title', 'rehub_framework') => "under-title",
                __('Above title', 'rehub_framework') => "above-title",  
                __('Title inside line', 'rehub_framework') => "inside-title",
                __('Small line under title', 'rehub_framework') => "small-line",
                __('No line', 'rehub_framework') => "no-line",
            )
        ),
        array(
            "type" => "colorpicker",
            "heading" => __('Color for line', 'rehub_framework' ),
            "description" => __('Default is grey', 'rehub_framework'),
            "param_name" => 'title_line_color',
            "admin_label" => true,    
            'dependency' => array(
                'element' => 'title_line',
                'value_not_equal_to' => array( 'no-line' ),
            ),                 
        ),        
        array(
            "type" => "vc_link",
            "heading" => __('Custom URL:', 'rehub_framework'),
            "param_name" => "vc_link",
            'description' => __('Set url near title or leave blank', 'rehub_framework'),
            "admin_label" => true,
        ),   
        array(
            "type" => "textfield",
            "heading" => __('Additional class', 'rehub_framework'),
            "param_name" => "title_class_add",
            "description" => __('Use mb5, mb10, mb15, mb20, mb25, mt10, mt15, mt20 to change margins', 'rehub_framework'),
            "admin_label" => true,
        ),                                           
    )
) );

//HOME FEATURED SECTION
vc_map( array(
    "name" => __('Featured section', 'rehub_framework'),
    "base" => "wpsm_featured",
    "icon" => "icon-featured",
    "category" => __('Content modules', 'rehub_framework'),
    "description" => __('For full width row', 'rehub_framework'),
    "params" => rehub_vc_filter_formodules() 
) );
vc_remove_param("wpsm_featured", "enable_pagination");
vc_remove_param("wpsm_featured", "show");
vc_remove_param("wpsm_featured", "offset");
vc_add_params("wpsm_featured", array(
    array(
        "type" => "dropdown",
        "class" => "",
        "heading" => __('Type of area', 'rehub_framework'),
        "group" =>  __('Control', 'rehub_framework'),
        "param_name" => "feat_type",
        "admin_label" => true,
        "value" => array(
            __('Featured area (slider + 2 posts)', 'rehub_framework') => "1",
            __('Featured full width slider', 'rehub_framework') => "2",
            __('Featured grid', 'rehub_framework') => "3",                 
        ),
        'description' => __('Featured area works only in full width row', 'rehub_framework'), 
    ),   
    array(
        "type" => "checkbox",
        "heading" => __('Show only featured products?', 'rehub_framework'),
        "value" => array(__("Yes", "rehub_framework") => true ),
        "param_name" => "show_featured_products",
        "dependency" => Array('element' => "post_type", 'value' => array('product')),
    ),      
    array(
        "type" => "checkbox",
        "heading" => __('Disable exerpt?', 'rehub_framework'),
        "group" =>  __('Control', 'rehub_framework'),
        "value" => array(__("Yes", "rehub_framework") => true ),
        "param_name" => "dis_excerpt",
        "dependency" => Array('element' => "feat_type", 'value' => array('1', '2')),
    ), 
    array(
        "type" => "checkbox",
        "heading" => __('Show text in left bottom side?', 'rehub_framework'),
        "group" =>  __('Control', 'rehub_framework'),
        "value" => array(__("Yes", "rehub_framework") => true ),
        "param_name" => "bottom_style",
        "dependency" => Array('element' => "feat_type", 'value' => array('1', '2')),
    ),    
    array(
        "type" => "textfield",
        "heading" => __("Number of posts to show in slider", "rehub_framework"),
        "param_name" => "show",
        "group" =>  __('Control', 'rehub_framework'),
        "value" => '5',
        "dependency" => Array('element' => "feat_type", 'value' => array('1', '2')),       
    ),   
    array(
        "type" => "textfield",
        "heading" => __("Custom height (default is 490) in px", "rehub_framework"),
        "param_name" => "custom_height",
        "group" =>  __('Control', 'rehub_framework'),
        "dependency" => Array('element' => "feat_type", 'value' => array('2')),       
    ),            
        
));

//DEAL CAROUSEL BLOCK
vc_map( array(
    "name" => __('Deal and Post carousel', 'rehub_framework'),
    "base" => "post_carousel_mod",
    "icon" => "icon-p-c-mod",
    "category" => __('Deal helper', 'rehub_framework'),
    'description' => __('Shows post deals', 'rehub_framework'), 
    "params" => rehub_vc_filter_formodules(),
));
vc_add_params("post_carousel_mod", array(
    array(
        "type" => "dropdown",
        "class" => "",
        "heading" => __('Carousel style', 'rehub_framework'),
        "group" => __('Carousel control', 'rehub_framework'),    
        "param_name" => "style",
        "value" => array(
            __('Horizontal items (use for areas without sidebar)', 'rehub_framework') => "1",              
            __('Deal grid', 'rehub_framework') => "2",  
            __('Simple Post', 'rehub_framework') => "simple",                                                  
        ),
    ),    
    array(
        "type" => "dropdown",
        "class" => "",
        "heading" => __('Number of items in row', 'rehub_framework'),
        "group" => __('Carousel control', 'rehub_framework'),    
        "param_name" => "showrow",
        'dependency' => array(
            'element' => 'style',
            'value_not_equal_to' => array( '1' ),
        ),        
        "value" => array(
            __('5', 'rehub_framework') => "5",   
            __('4', 'rehub_framework') => "4",
            __('6', 'rehub_framework') => "6",
            __('3 (Only if you use inside row with sidebar)', 'rehub_framework') => "3",                                                   
        ),
    ), 
    array(
        "type" => "checkbox",
        "class" => "",
        "group" => __('Carousel control', 'rehub_framework'),        
        "heading" => __('Disable navigation?', 'rehub_framework'),
        "value" => array(__("Yes", "rehub_framework") => true ),
        "param_name" => "nav_dis",         
    ),         
    array(
        "type" => "checkbox",
        "class" => "",
        "group" => __('Carousel control', 'rehub_framework'),        
        "heading" => __('Make autorotate?', 'rehub_framework'),
        "value" => array(__("Yes", "rehub_framework") => true ),
        "param_name" => "autorotate",         
    ),     
    array(
        "type" => "checkbox",
        "class" => "",
        "heading" => __('Make link as affiliate?', 'rehub_framework'),
        "group" => __('Carousel control', 'rehub_framework'),        
        "value" => array(__("Yes", "rehub_framework") => true ),
        "param_name" => "aff_link", 
        "description" => __('This will change all inner post links to affiliate link of post offer', 'rehub_framework'),        
    ),            
));
vc_remove_param("post_carousel_mod", "enable_pagination");

//NEWS Ticker
vc_map( array(
    "name" => __("News with thumbnails", "rehub_framework"),
    "base" => "news_with_thumbs_mod",
    "category" => __('Content modules', 'rehub_framework'), 
    'description' => __('News block', 'rehub_framework'), 
    "icon" => "icon-n-w-thumbs",
    "params" => array(
        array(
            'type' => 'autocomplete',
            'heading' => __( 'Category', 'rehub_framework' ),
            'param_name' => 'module_cats',
            "admin_label" => true,
            'settings' => array(
                'multiple' => true,
                'sortable' => true,
                'groups' => false,
            ),
            'description' => __( 'Enter names of categories. Or leave blank to show all', 'rehub_framework' ),         
        ),
        array(
            'type' => 'autocomplete',
            'heading' => __( 'Category exclude', 'rehub_framework' ),
            'param_name' => 'cat_exclude',
            "admin_label" => true,
            'settings' => array(
                'multiple' => true,
                'sortable' => true,
                'groups' => false,
            ),
            'description' => __( 'Enter names of categories to exclude', 'rehub_framework' ),         
        ),        
        array(
            'type' => 'autocomplete',
            'heading' => __( 'Tags', 'rehub_framework' ),
            'param_name' => 'module_tags',
            "admin_label" => true,
            'settings' => array(
                'multiple' => true,
                'sortable' => true,
                'groups' => false,
            ),
            'description' => __( 'Enter names of tags. Or leave blank to show all', 'rehub_framework' ),         
        ),  
        array(
            'type' => 'autocomplete',
            'heading' => __( 'Tags exclude', 'rehub_framework' ),
            'param_name' => 'tag_exclude',
            "admin_label" => true,
            'settings' => array(
                'multiple' => true,
                'sortable' => true,
                'groups' => false,
            ),
            'description' => __( 'Enter names of tags to exclude.', 'rehub_framework' ),         
        ), 
        array(
            "type" => "dropdown",
            "heading" => __('Choose post formats', 'rehub_framework'),
            "param_name" => "post_formats",
            "value" => $post_formats,
            "admin_label" => true,
            'description' => __('Choose post formats to display or leave blank to display all', 'rehub_framework'),          
        ),        
        array(
            'type' => 'colorpicker',
            "admin_label" => true,
            'heading' => __( 'Color for category label', 'rehub_framework' ),
            'param_name' => 'color_cat',        
        ),        
    )
) );

//NEWS WITHOUT THUMBNAILS BLOCK
vc_map( array(
    "name" => __("News ticker", "rehub_framework"),
    "base" => "wpsm_news_ticker",
    "category" => __('Content modules', 'rehub_framework'), 
    'description' => __('News ticker', 'rehub_framework'),
    "icon" => "icon-n-n-thumbs",    
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __('Label', 'rehub_framework'),
            "param_name" => "label",
            'description' => __('Label before news ticker', 'rehub_framework'),
            "admin_label" => true,            
        ), 
        array(
            "type" => "textfield",
            "heading" => __('Category name', 'rehub_framework'),
            "param_name" => "catname",
            'description' => __('Category name to show in ticker', 'rehub_framework'),
            "admin_label" => true,            
        ), 
        array(
            "type" => "textfield",
            "heading" => __('Category taxonomy', 'rehub_framework'),
            "param_name" => "catslug",
            'description' => __('Category taxonomy name. Leave blank if you need Post category. For post tags - set as post_tag', 'rehub_framework'),
        ),
        array(
            "type" => "textfield",
            "heading" => __('Number of posts to show', 'rehub_framework'),
            "param_name" => "fetch",
            'description' => __('Default is 5', 'rehub_framework'),
        ),                               
       
    )
) );

//TWO COLUMN NEWS BLOCK
vc_map( array(
    "name" => __('Column news block', 'rehub_framework'),
    "base" => "two_col_news",
    "icon" => "icon-t-c-news",
    "category" => __('Content modules', 'rehub_framework'),
    'description' => __('News in columns', 'rehub_framework'), 
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __('Offset for 2 column', 'rehub_framework'),
            "param_name" => "module_offset_second",
            'description' => __('Number of posts to offset for second column  or leave blank', 'rehub_framework'),
        ), 
        array(
            "type" => "textfield",
            "heading" => __('Fetch Count', 'rehub_framework'),
            "param_name" => "module_fetch",
            "value" => '4',
            'description' => __('How much posts you\'d like to display?', 'rehub_framework'),
        ),  
        array(
            "type" => "checkbox",
            "class" => "",
            "heading" => __('Show first post as compact?', 'rehub_framework'),
            "value" => array(__("Yes", "rehub_framework") => true ),
            "param_name" => "compact",         
        ), 
        array(
            "type" => "checkbox",
            "class" => "",
            "heading" => __('Disable second column?', 'rehub_framework'),
            "value" => array(__("Yes", "rehub_framework") => true ),
            "param_name" => "only_one",         
        ),        

        array(
            'type' => 'autocomplete',
            'heading' => __( 'Category first', 'rehub_framework' ),
            'param_name' => 'module_cats_first',
            "admin_label" => true,
            'group' => __( 'First column', 'rehub_framework' ),
            'settings' => array(
                'multiple' => true,
                'sortable' => true,
                'groups' => false,
            ),
            'description' => __( 'Enter names of categories. Or leave blank to show all', 'rehub_framework' ),         
        ),
        array(
            'type' => 'autocomplete',
            'heading' => __( 'Category exclude first', 'rehub_framework' ),
            'param_name' => 'cat_exclude_first',
            "admin_label" => true,
            'group' => __( 'First column', 'rehub_framework' ),            
            'settings' => array(
                'multiple' => true,
                'sortable' => true,
                'groups' => false,
            ),
            'description' => __( 'Enter names of categories to exclude', 'rehub_framework' ),         
        ),        
        array(
            'type' => 'autocomplete',
            'heading' => __( 'Tags first', 'rehub_framework' ),
            'param_name' => 'module_tags_first',
            "admin_label" => true,
            'group' => __( 'First column', 'rehub_framework' ),            
            "admin_label" => true,
            'settings' => array(
                'multiple' => true,
                'sortable' => true,
                'groups' => false,
            ),
            'description' => __( 'Enter names of tags. Or leave blank to show all', 'rehub_framework' ),         
        ),  
        array(
            'type' => 'autocomplete',
            'heading' => __( 'Tags exclude first', 'rehub_framework' ),
            'param_name' => 'tag_exclude_first',
            "admin_label" => true,
            'group' => __( 'First column', 'rehub_framework' ),            
            "admin_label" => true,
            'settings' => array(
                'multiple' => true,
                'sortable' => true,
                'groups' => false,
            ),
            'description' => __( 'Enter names of tags to exclude.', 'rehub_framework' ),         
        ),
        array(
            "type" => "dropdown",
            "heading" => __('Choose post formats first', 'rehub_framework'),
            "param_name" => "post_formats_first",
            'group' => __( 'First column', 'rehub_framework' ),            
            "value" => $post_formats,
            "admin_label" => true,
            'description' => __('Choose post formats to display or leave blank to display all', 'rehub_framework'),          
        ),   
        array(
            'type' => 'colorpicker',
            'heading' => __( 'Color for category label', 'rehub_framework' ),
            'param_name' => 'color_cat_first',
            'group' => __( 'First column', 'rehub_framework' ),         
        ),             
        array(
            'type' => 'autocomplete',
            'heading' => __( 'Category second', 'rehub_framework' ),
            'param_name' => 'module_cats_second',
            'group' => __( 'Second column', 'rehub_framework' ),
            'settings' => array(
                'multiple' => true,
                'sortable' => true,
                'groups' => false,
            ),
            'dependency' => array(
                'element' => 'only_one',
                'value_not_equal_to' => array( '1' ),
            ),            
            'description' => __( 'Enter names of categories. Or leave blank to show all', 'rehub_framework' ),         
        ),
        array(
            'type' => 'autocomplete',
            'heading' => __( 'Category exclude second', 'rehub_framework' ),
            'param_name' => 'cat_exclude_second',
            "admin_label" => true,
            'group' => __( 'Second column', 'rehub_framework' ),            
            'settings' => array(
                'multiple' => true,
                'sortable' => true,
                'groups' => false,
            ),
            'dependency' => array(
                'element' => 'only_one',
                'value_not_equal_to' => array( '1' ),
            ),             
            'description' => __( 'Enter names of categories to exclude', 'rehub_framework' ),         
        ),        
        array(
            'type' => 'autocomplete',
            'heading' => __( 'Tags second', 'rehub_framework' ),
            'param_name' => 'module_tags_second',
            "admin_label" => true,
            'group' => __( 'Second column', 'rehub_framework' ),            
            "admin_label" => true,
            'settings' => array(
                'multiple' => true,
                'sortable' => true,
                'groups' => false,
            ),
            'dependency' => array(
                'element' => 'only_one',
                'value_not_equal_to' => array( '1' ),
            ),             
            'description' => __( 'Enter names of tags. Or leave blank to show all', 'rehub_framework' ),         
        ),  
        array(
            'type' => 'autocomplete',
            'heading' => __( 'Tags exclude second', 'rehub_framework' ),
            'param_name' => 'tag_exclude_second',
            'group' => __( 'Second column', 'rehub_framework' ),            
            "admin_label" => true,
            "admin_label" => true,
            'settings' => array(
                'multiple' => true,
                'sortable' => true,
                'groups' => false,
            ),
            'dependency' => array(
                'element' => 'only_one',
                'value_not_equal_to' => array( '1' ),
            ),             
            'description' => __( 'Enter names of tags to exclude.', 'rehub_framework' ),         
        ), 
        array(
            "type" => "dropdown",
            "heading" => __('Choose post formats second', 'rehub_framework'),
            "param_name" => "post_formats_second",
            'group' => __( 'Second column', 'rehub_framework' ),            
            "value" => $post_formats,
            "admin_label" => true,
            'dependency' => array(
                'element' => 'only_one',
                'value_not_equal_to' => array( '1' ),
            ),             
            'description' => __('Choose post formats to display or leave blank to display all', 'rehub_framework'),          
        ),
        array(
            'type' => 'colorpicker',
            'dependency' => array(
                'element' => 'only_one',
                'value_not_equal_to' => array( '1' ),
            ),             
            'heading' => __( 'Color for category label', 'rehub_framework' ),
            'param_name' => 'color_cat_second', 
            'group' => __( 'Second column', 'rehub_framework' ),       
        ),                                               

    )
) );

//VIDEO NEWS BLOCK
vc_map( array(
    "name" => __('Video playlist block', 'rehub_framework'),
    "base" => "video_mod",
    "icon" => "icon-v-n-block",
    "category" => __('Content modules', 'rehub_framework'),
    'description' => __('Youtube/Vimeo gallery', 'rehub_framework'), 
    "params" => array(
        array(
            'type' => 'exploded_textarea',
            'heading' => __( 'Links on videos', 'rehub_framework' ),
            'description' => __( 'Each link must be from new line. Works with youtube and vimeo. Example for youtube: https://www.youtube.com/watch?v=ZZZZZZZZZZZ. Example for vimeo: https://vimeo.com/111111111', 'rehub_framework' ),
            'param_name' => 'videolinks',
            "admin_label" => true,
        ), 
        array(
            "param_name" => "playlist_type",
            "type" => "dropdown",
            "value" => array('Playlist' => 'playlist', 'Slider' => 'slider'),
            "admin_label" => true,
            "heading" => __('Playlist type', 'rehub_framework' ),
            "description" => __('Video gallery works only with youtube or vimeo, but not at once. Also, playlist type can be only one on page. Slider type can have multiple instances', 'rehub_framework' ),
        ),            
        array(
            "param_name" => "playlist_auto_play",
            "type" => "dropdown",
            "value" => array('OFF' => '0', 'ON' => '1'),
            "heading" => "Autoplay ON / OFF:",
            "admin_label" => true,
            "description" => __('Autoplay does not work on mobile devices (android, windows phone, iOS)', 'rehub_framework' ),
            'dependency' => array(
                'element' => 'playlist_type',
                'value_not_equal_to' => array( 'slider' ),
            ),             
        ),
        array(
            "param_name" => "playlist_width",
            "type" => "dropdown",
            "value" => array('Full width' => 'full', 'Stack' => 'stack'),
            "admin_label" => true,
            "heading" => __('Column style', 'rehub_framework' ),
            'dependency' => array(
                'element' => 'playlist_type',
                'value_not_equal_to' => array( 'slider' ),
            ),             
        ),               
        array(
            "param_name" => "playlist_host",
            "type" => "dropdown",
            "value" => array('youtube' => 'youtube', 'vimeo' => 'vimeo'),
            "heading" => "Video host",
            "admin_label" => true,            
        ),                                     
    )
) );

//1-4 tabed block
vc_map( array(
    "name" => __('Tabbed block', 'rehub_framework'),
    "base" => "tab_mod",
    "icon" => "icon-tab-block",
    "category" => __('Content modules', 'rehub_framework'),
    'description' => __('4 tab content block', 'rehub_framework'), 
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __('Name for 1 tab*', 'rehub_framework'),
            "param_name" => "module_name_first",
            "admin_label" => true,
            'group' => __( 'First tab', 'rehub_framework' ),
        ),
        array(
            'type' => 'autocomplete',
            'heading' => __( 'Category', 'rehub_framework' ),
            'param_name' => 'module_cats_first',
            'group' => __( 'First tab', 'rehub_framework' ),
            'settings' => array(
                'multiple' => true,
                'sortable' => true,
                'groups' => false,
            ),
            'description' => __( 'Enter names of categories. Or leave blank to show all', 'rehub_framework' ),         
        ),
        array(
            'type' => 'autocomplete',
            'heading' => __( 'Category exclude', 'rehub_framework' ),
            'param_name' => 'cat_exclude_first',
            'group' => __( 'First tab', 'rehub_framework' ),
            'settings' => array(
                'multiple' => true,
                'sortable' => true,
                'groups' => false,
            ),
            'description' => __( 'Enter names of categories to exclude', 'rehub_framework' ),         
        ),        
        array(
            'type' => 'autocomplete',
            'heading' => __( 'Tags', 'rehub_framework' ),
            'param_name' => 'module_tags_first',
            'group' => __( 'First tab', 'rehub_framework' ),
            'settings' => array(
                'multiple' => true,
                'sortable' => true,
                'groups' => false,
            ),
            'description' => __( 'Enter names of tags. Or leave blank to show all', 'rehub_framework' ),         
        ),  
        array(
            'type' => 'autocomplete',
            'heading' => __( 'Tags exclude', 'rehub_framework' ),
            'param_name' => 'tag_exclude_first',
            'group' => __( 'First tab', 'rehub_framework' ),
            'settings' => array(
                'multiple' => true,
                'sortable' => true,
                'groups' => false,
            ),
            'description' => __( 'Enter names of tags to exclude.', 'rehub_framework' ),         
        ), 
        array(
            'type' => 'colorpicker',            
            'heading' => __( 'Color for first tab label', 'rehub_framework' ),
            'param_name' => 'color_cat_first',
            'group' => __( 'First tab', 'rehub_framework' ),        
        ),
        array(
            "type" => "textfield",
            "heading" => __('Name for 2 tab*', 'rehub_framework'),
            "param_name" => "module_name_second",
            "admin_label" => true,
            'group' => __( 'Second tab', 'rehub_framework' ),
        ),
        array(
            'type' => 'autocomplete',
            'heading' => __( 'Category', 'rehub_framework' ),
            'param_name' => 'module_cats_second',
            'group' => __( 'Second tab', 'rehub_framework' ),
            'settings' => array(
                'multiple' => true,
                'sortable' => true,
                'groups' => false,
            ),
            'description' => __( 'Enter names of categories. Or leave blank to show all', 'rehub_framework' ),         
        ),
        array(
            'type' => 'autocomplete',
            'heading' => __( 'Category exclude', 'rehub_framework' ),
            'param_name' => 'cat_exclude_second',
            'group' => __( 'Second tab', 'rehub_framework' ),
            'settings' => array(
                'multiple' => true,
                'sortable' => true,
                'groups' => false,
            ),
            'description' => __( 'Enter names of categories to exclude', 'rehub_framework' ),         
        ),        
        array(
            'type' => 'autocomplete',
            'heading' => __( 'Tags', 'rehub_framework' ),
            'param_name' => 'module_tags_second',
            'group' => __( 'Second tab', 'rehub_framework' ),
            'settings' => array(
                'multiple' => true,
                'sortable' => true,
                'groups' => false,
            ),
            'description' => __( 'Enter names of tags. Or leave blank to show all', 'rehub_framework' ),         
        ),  
        array(
            'type' => 'autocomplete',
            'heading' => __( 'Tags exclude', 'rehub_framework' ),
            'param_name' => 'tag_exclude_second',
            'group' => __( 'Second tab', 'rehub_framework' ),
            'settings' => array(
                'multiple' => true,
                'sortable' => true,
                'groups' => false,
            ),
            'description' => __( 'Enter names of tags to exclude.', 'rehub_framework' ),         
        ), 
        array(
            'type' => 'colorpicker',
            'heading' => __( 'Color for tab label', 'rehub_framework' ),
            'param_name' => 'color_cat_second',
            'group' => __( 'Second tab', 'rehub_framework' ),        
        ),
       array(
            "type" => "textfield",
            "heading" => __('Name for 3 tab*', 'rehub_framework'),
            "param_name" => "module_name_third",
            "admin_label" => true,
            'group' => __( 'Third tab', 'rehub_framework' ),
        ),
        array(
            'type' => 'autocomplete',
            'heading' => __( 'Category', 'rehub_framework' ),
            'param_name' => 'module_cats_third',
            'group' => __( 'Third tab', 'rehub_framework' ),
            'settings' => array(
                'multiple' => true,
                'sortable' => true,
                'groups' => false,
            ),
            'description' => __( 'Enter names of categories. Or leave blank to show all', 'rehub_framework' ),         
        ),
        array(
            'type' => 'autocomplete',
            'heading' => __( 'Category exclude', 'rehub_framework' ),
            'param_name' => 'cat_exclude_third',
            'group' => __( 'Third tab', 'rehub_framework' ),
            'settings' => array(
                'multiple' => true,
                'sortable' => true,
                'groups' => false,
            ),
            'description' => __( 'Enter names of categories to exclude', 'rehub_framework' ),         
        ),        
        array(
            'type' => 'autocomplete',
            'heading' => __( 'Tags', 'rehub_framework' ),
            'param_name' => 'module_tags_third',
            'group' => __( 'Third tab', 'rehub_framework' ),
            'settings' => array(
                'multiple' => true,
                'sortable' => true,
                'groups' => false,
            ),
            'description' => __( 'Enter names of tags. Or leave blank to show all', 'rehub_framework' ),         
        ),  
        array(
            'type' => 'autocomplete',
            'heading' => __( 'Tags exclude', 'rehub_framework' ),
            'param_name' => 'tag_exclude_third',
            'group' => __( 'Third tab', 'rehub_framework' ),
            'settings' => array(
                'multiple' => true,
                'sortable' => true,
                'groups' => false,
            ),
            'description' => __( 'Enter names of tags to exclude.', 'rehub_framework' ),         
        ), 
        array(
            'type' => 'colorpicker',
            'heading' => __( 'Color for tab label', 'rehub_framework' ),
            'param_name' => 'color_cat_third',
            'group' => __( 'Third tab', 'rehub_framework' ),        
        ),
       array(
            "type" => "textfield",
            "heading" => __('Name for 4 tab*', 'rehub_framework'),
            "param_name" => "module_name_fourth",
            "admin_label" => true,
            'group' => __( 'Fourth tab', 'rehub_framework' ),
        ),
        array(
            'type' => 'autocomplete',
            'heading' => __( 'Category', 'rehub_framework' ),
            'param_name' => 'module_cats_fourth',
            'group' => __( 'Fourth tab', 'rehub_framework' ),
            'settings' => array(
                'multiple' => true,
                'sortable' => true,
                'groups' => false,
            ),
            'description' => __( 'Enter names of categories. Or leave blank to show all', 'rehub_framework' ),         
        ),
        array(
            'type' => 'autocomplete',
            'heading' => __( 'Category exclude', 'rehub_framework' ),
            'param_name' => 'cat_exclude_fourth',
            'group' => __( 'Fourth tab', 'rehub_framework' ),
            'settings' => array(
                'multiple' => true,
                'sortable' => true,
                'groups' => false,
            ),
            'description' => __( 'Enter names of categories to exclude', 'rehub_framework' ),         
        ),        
        array(
            'type' => 'autocomplete',
            'heading' => __( 'Tags', 'rehub_framework' ),
            'param_name' => 'module_tags_fourth',
            'group' => __( 'Fourth tab', 'rehub_framework' ),
            'settings' => array(
                'multiple' => true,
                'sortable' => true,
                'groups' => false,
            ),
            'description' => __( 'Enter names of tags. Or leave blank to show all', 'rehub_framework' ),         
        ),  
        array(
            'type' => 'autocomplete',
            'heading' => __( 'Tags exclude', 'rehub_framework' ),
            'param_name' => 'tag_exclude_fourth',
            "admin_label" => true,
            'group' => __( 'Fourth tab', 'rehub_framework' ),
            'settings' => array(
                'multiple' => true,
                'sortable' => true,
                'groups' => false,
            ),
            'description' => __( 'Enter names of tags to exclude.', 'rehub_framework' ),         
        ), 
        array(
            'type' => 'colorpicker',
            'heading' => __( 'Color for tab label', 'rehub_framework' ),
            'param_name' => 'color_cat_fourth',
            'group' => __( 'Fourth tab', 'rehub_framework' ),        
        ),

      
    )
) );

//POSTS LOOP WITH LEFT SMALL THUMBNAILS
vc_map( array(
    "name" => __('Posts with small thumbs', 'rehub_framework'),
    "base" => "small_thumb_loop",
    "icon" => "icon-s-t-loop",
    "category" => __('Content modules', 'rehub_framework'),
    "description" => __('Left thumbnail', 'rehub_framework'), 
    "params" => rehub_vc_filter_formodules()
));
vc_add_param("small_thumb_loop", 
    array(
        "type" => "dropdown",
        "class" => "",
        "heading" => __('Set type', 'rehub_framework'),
        "group" => __('Type', 'rehub_framework'),
        "param_name" => "type",
        "value" => array(
            __('Blocked', 'rehub_framework') => "1",
            __('no border', 'rehub_framework') => "2",                 
        ),
    )
);
vc_add_params("small_thumb_loop", rehub_vc_aj_filter_btns_formodules()); 
        
//BLOG STYLE LOOP
vc_map( array(
    "name" => __('Regular blog posts', 'rehub_framework'),
    "base" => "regular_blog_loop",
    "icon" => "icon-r-b-loop",
    "category" => __('Content modules', 'rehub_framework'),
    "description" => __('Full width thumbnail', 'rehub_framework'), 
    "params" => rehub_vc_filter_formodules()
)); 
vc_add_params("regular_blog_loop", rehub_vc_aj_filter_btns_formodules());            

//GRID STYLE LOOP
vc_map( array(
    "name" => __('Masonry grid', 'rehub_framework'),
    "base" => "grid_loop_mod",
    "icon" => "icon-g-l-loop",
    "category" => __('Content modules', 'rehub_framework'),
    "description" => __('Masonry grid', 'rehub_framework'),
    "params" => rehub_vc_filter_formodules() 
) );
vc_add_params("grid_loop_mod", array(
    array(
        "type" => "dropdown",
        "class" => "",
        "group" => __('Control', 'rehub_framework'),
        "heading" => __('Set columns', 'rehub_framework'),
        "param_name" => "columns",
        "value" => array(
            __('2 columns', 'rehub_framework') => "2_col",
            __('3 columns', 'rehub_framework') => "3_col",
            __('4 columns', 'rehub_framework') => "4_col", 
            __('5 columns', 'rehub_framework') => "5_col",                 
        ),
        'description' => __('Use 4 columns only for full width row', 'rehub_framework'), 
    ),
    array(
        "type" => "checkbox",
        "class" => "",
        "group" => __('Control', 'rehub_framework'),        
        "heading" => __('Make link as affiliate?', 'rehub_framework'),       
        "value" => array(__("Yes", "rehub_framework") => true ),
        "param_name" => "aff_link", 
        "description" => __('This will change all inner post links to affiliate link of post offer', 'rehub_framework'),        
    ), 
));
vc_add_params("grid_loop_mod", rehub_vc_aj_filter_btns_formodules());

//COLUMN GRID
vc_map( array(
    "name" => __('Posts grid in columns', 'rehub_framework'),
    "base" => "columngrid_loop",
    "icon" => "icon-columngrid",
    "category" => __('Content modules', 'rehub_framework'),
    "description" => __('Columned grid', 'rehub_framework'), 
    "params" => rehub_vc_filter_formodules() 
));
vc_add_params("columngrid_loop", array(
    array(
        'type' => 'textfield',
        'heading' => __( 'Symbols in exerpt', 'js_composer' ),
        'param_name' => 'exerpt_count',
        'group' => __('Control', 'rehub_framework'),
        'value' => '110',
        'description' => __('Set 0 to disable exerpt', 'rehub_framework'),
    ),        
    array(
        "type" => "checkbox",
        "class" => "",
        "heading" => __('Disable post meta?', 'rehub_framework'),
        "value" => array(__("Yes", "rehub_framework") => true ),
        "param_name" => "disable_meta",  
        'group' => __('Control', 'rehub_framework'),               
    ),  
    array(
        "type" => "checkbox",
        "class" => "",
        "heading" => __('Enable affiliate button?', 'rehub_framework'),
        "value" => array(__("Yes", "rehub_framework") => true ),
        "param_name" => "enable_btn",  
        'group' => __('Control', 'rehub_framework'),               
    ),      
    array(
        "type" => "dropdown",
        "class" => "",
        "heading" => __('Set columns', 'rehub_framework'),
        "param_name" => "columns",
        'group' => __('Control', 'rehub_framework'),        
        "value" => array(
            __('3 columns', 'rehub_framework') => "3_col",
            __('2 columns', 'rehub_framework') => "2_col",
            __('4 columns', 'rehub_framework') => "4_col",
            __('5 columns', 'rehub_framework') => "5_col", 
            __('6 columns', 'rehub_framework') => "6_col",                 
        ),
        'description' => __('4 columns is good only for full width row', 'rehub_framework'), 
    ),
    array(
        "type" => "checkbox",
        "class" => "",
        "group" => __('Control', 'rehub_framework'),        
        "heading" => __('Make link as affiliate?', 'rehub_framework'),       
        "value" => array(__("Yes", "rehub_framework") => true ),
        "param_name" => "aff_link", 
        "description" => __('This will change all inner post links to affiliate link of post offer', 'rehub_framework'),        
    ),  
    array(
        "type" => "checkbox",
        "class" => "",
        "group" => __('Control', 'rehub_framework'),        
        "heading" => __('Make boxed', 'rehub_framework'),       
        "value" => array(__("Yes", "rehub_framework") => true ),
        "param_name" => "boxed", 
        "description" => __('This will make each item as boxed design', 'rehub_framework'),        
    ),              
));
vc_add_params("columngrid_loop", rehub_vc_aj_filter_btns_formodules());

//COMPACT GRID STYLE LOOP
vc_map( array(
    "name" => __('Deals grid block', 'rehub_framework'),
    "base" => "compactgrid_loop_mod",
    "icon" => "icon-cg-l-loop",
    "category" => __('Deal helper', 'rehub_framework'),
    "description" => __('Compact grid', 'rehub_framework'),
    "params" => rehub_vc_filter_formodules()  
));
vc_add_params("compactgrid_loop_mod", array( 
    array(
        "type" => "checkbox",
        "class" => "",
        "heading" => __('Make link as affiliate?', 'rehub_framework'),
        "value" => array(__("Yes", "rehub_framework") => true ),
        "param_name" => "aff_link", 
        "group" => __('Control', 'rehub_framework'),
        "description" => __('This will change all inner post links to affiliate link of post offer', 'rehub_framework'),        
    ), 
    array(
        "type" => "checkbox",
        "class" => "",
        "heading" => __('Disable button?', 'rehub_framework'),
        "value" => array(__("Yes", "rehub_framework") => true ),
        "param_name" => "disable_btn", 
        "group" => __('Control', 'rehub_framework'),
        "description" => __('This will disable button in grid', 'rehub_framework'),        
    ),  
    array(
        "type" => "checkbox",
        "class" => "",
        "heading" => __('Disable actions?', 'rehub_framework'),
        "value" => array(__("Yes", "rehub_framework") => true ),
        "param_name" => "disable_act", 
        "group" => __('Control', 'rehub_framework'),
        "description" => __('This will disable thumbs and comment count in bottom', 'rehub_framework'),        
    ),    
    array(
        "type" => "dropdown",
        "class" => "",
        "heading" => __('Show near price', 'rehub_framework'),
        "param_name" => "price_meta",
        "group" => __('Control', 'rehub_framework'),        
        "value" => array(
            __('Admin avatar', 'rehub_framework') => "admin",
            __('Deal Store image (only for Recash child theme)', 'rehub_framework') => "store",
            __('Nothing', 'rehub_framework') => "no",                               
        ),
    ),         
    array(
        "type" => "dropdown",
        "class" => "",
        "heading" => __('Set columns', 'rehub_framework'),
        "param_name" => "columns",
        "group" => __('Control', 'rehub_framework'),        
        "value" => array(
            __('3 columns', 'rehub_framework') => "3_col",
            __('4 columns', 'rehub_framework') => "4_col",
            __('5 columns', 'rehub_framework') => "5_col", 
            __('6 columns', 'rehub_framework') => "6_col",                              
        ),
        'description' => __('4 columns is good only for full width row', 'rehub_framework'), 
    ),
)); 
vc_add_params("compactgrid_loop_mod", rehub_vc_aj_filter_btns_formodules()); 

//SMALL NEWS WITHOUT THUMBNAIL
vc_map( array(
    "name" => __('Simple list of posts', 'rehub_framework'),
    "base" => "wpsm_recent_posts_list",
    "category" => __('Content modules', 'rehub_framework'),
    "icon" => "icon-s-l-post",
    "description" => __('Without thumbnails', 'rehub_framework'), 
    "params" => rehub_vc_filter_formodules()
));
vc_remove_param("wpsm_recent_posts_list", "enable_pagination");
vc_add_param("wpsm_recent_posts_list", array(
    "type" => "checkbox",
    "class" => "",
    "group" => __('Control', 'rehub_framework'), 
    "heading" => __("Make center alignment?", "rehub_framework"),
    "value" => array(__("Yes", "rehub_framework") => true ),
    "param_name" => "center",
));
vc_add_param("wpsm_recent_posts_list", array(
    "type" => "checkbox",
    "class" => "",
    "group" => __('Control', 'rehub_framework'), 
    "heading" => __("Add image?", "rehub_framework"),
    "value" => array(__("Yes", "rehub_framework") => true ),
    "param_name" => "image",
));
vc_add_param("wpsm_recent_posts_list", array(
    "type" => "checkbox",
    "class" => "",
    "group" => __('Control', 'rehub_framework'), 
    "heading" => __("Disable meta", "rehub_framework"),
    "value" => array(__("Yes", "rehub_framework") => true ),
    "param_name" => "nometa",
));
vc_add_params("wpsm_recent_posts_list", rehub_vc_aj_filter_btns_formodules());

//3 COLUMN BLOCK
vc_map( array(
    "name" => __('3 column posts', 'rehub_framework'),
    "base" => "wpsm_three_col_posts",
    "category" => __('Content modules', 'rehub_framework'),
    "icon" => "icon-t-c-post",
    "description" => __('Use for full width row!', 'rehub_framework'), 
    "params" => rehub_vc_filter_formodules()
));
vc_remove_param("wpsm_three_col_posts", "enable_pagination");
vc_remove_param("wpsm_three_col_posts", "show");
vc_add_params("wpsm_three_col_posts", array(
   array(
        "type" => "textfield",
        "heading" => __('Custom label', 'rehub_framework'),
        "param_name" => "custom_label",
        "admin_label" => true,
        'group' => __( 'Additional', 'rehub_framework' ),
    ),
    array(
        'type' => 'colorpicker',
        'heading' => __( 'Color for label', 'rehub_framework' ),
        'param_name' => 'custom_label_color',
        'group' => __( 'Additional', 'rehub_framework' ),        
    ),
));

//CUSTOM TEXT BLOCK
vc_add_param("vc_column_text", array(
    "type" => "checkbox",
    "class" => "",
    "heading" => __("Add border to block?", "rehub_framework"),
    "value" => array(__("Yes", "rehub_framework") => true ),
    "param_name" => "bordered",
));

//OFFER BOX
vc_map( array(
    "name" => __('Offer Box', 'rehub_framework'),
    "base" => "wpsm_offerbox",
    "icon" => "icon-offer-box",
    "category" => __('Deal helper', 'rehub_framework'),
    'description' => __('Offer box', 'rehub_framework'), 
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __('Offer sale price', 'rehub_framework'),
            "admin_label" => true,
            "param_name" => "price",
        ),  
        array(
            "type" => "textfield",
            "heading" => __('Offer old price', 'rehub_framework'),
            "admin_label" => true,
            "param_name" => "price_old",
        ),        
        array(
            "type" => "textfield",
            "heading" => __('Offer url', 'rehub_framework'),
            "param_name" => "button_link",
        ), 
        array(
            "type" => "textfield",
            "heading" => __('Button text', 'rehub_framework'),
            "param_name" => "button_text",
        ), 
        array(
            "type" => "textfield",
            "heading" => __('Name of product', 'rehub_framework'),
            "admin_label" => true,
            "param_name" => "title",
        ),
        array(
            "type" => "textfield",
            "heading" => __('Short description of product', 'rehub_framework'),
            "admin_label" => true,
            "param_name" => "description",
        ),   
        array(
            'type' => 'attach_image',
            'heading' => __('Upload thumbnail', 'rehub_framework'),
            'param_name' => 'image_id',
            'value' => '',
        ), 
        array(
            "type" => "textfield",
            "heading" => __('Set coupon code', 'rehub_framework'),
            "admin_label" => true,
            "param_name" => "offer_coupon",
        ),
        array(
            "type" => "checkbox",
            "class" => "",
            "heading" => __('Mask coupon code?', 'rehub_framework'),
            "value" => array(__("Yes", "rehub_framework") => true ),
            "param_name" => "offer_coupon_mask",
        ),
        array(
            "type" => "textfield",
            "heading" => __('Set text on mask', 'rehub_framework'),
            "admin_label" => false,
            "param_name" => "offer_coupon_mask_text",
            'dependency' => array(
                'element' => 'offer_coupon_mask',
                'not_empty' => true,
            ),            
        ), 
        array(
            "type" => "textfield",
            "heading" => __('Expiration Date', 'rehub_framework'),
            "description" => __( 'Format date-month-year. Example, 20-12-2015', 'js_composer' ),
            "admin_label" => false,
            "param_name" => "offer_coupon_date",
        ), 
        array(
            'type' => 'attach_image',
            'heading' => __('Brand logo', 'rehub_framework'),
            'param_name' => 'logo_image_id',
            'value' => '',
        ),                                                                                                              
    )
) );


if(class_exists( 'WooCommerce' )) {//WOOBLOCKS

//HOME FEATURED SECTION
vc_map( array(
    "name" => __('Woo Featured section', 'rehub_framework'),
    "base" => "wpsm_woofeatured",
    "icon" => "icon-woofeatured",
    "category" => __('Woocommerce', 'rehub_framework'),
    "params" => rehub_woo_vc_filter_formodules(),
) );
vc_remove_param("wpsm_woofeatured", "enable_pagination");
vc_remove_param("wpsm_woofeatured", "show");
vc_remove_param("wpsm_woofeatured", "offset");
vc_add_params("wpsm_woofeatured", array(
    array(
        "type" => "dropdown",
        "class" => "",
        "heading" => __('Type of area', 'rehub_framework'),
        "group" =>  __('Control', 'rehub_framework'),
        "param_name" => "feat_type",
        "admin_label" => true,
        "value" => array(
            __('Featured full width slider', 'rehub_framework') => "1",
            __('Featured grid', 'rehub_framework') => "2",                 
        ),
        'description' => __('Featured area works only in full width row', 'rehub_framework'), 
    ),        
    array(
        "type" => "checkbox",
        "heading" => __('Disable exerpt?', 'rehub_framework'),
        "group" =>  __('Control', 'rehub_framework'),
        "value" => array(__("Yes", "rehub_framework") => true ),
        "param_name" => "dis_excerpt",
        "dependency" => Array('element' => "feat_type", 'value' => array('1', '2')),
    ), 
    array(
        "type" => "checkbox",
        "heading" => __('Show text in left bottom side?', 'rehub_framework'),
        "group" =>  __('Control', 'rehub_framework'),
        "value" => array(__("Yes", "rehub_framework") => true ),
        "param_name" => "bottom_style",
        "dependency" => Array('element' => "feat_type", 'value' => array('1')),
    ),    
    array(
        "type" => "textfield",
        "heading" => __("Number of posts to show in slider", "rehub_framework"),
        "param_name" => "show",
        "group" =>  __('Control', 'rehub_framework'),
        "value" => '5',
        "dependency" => Array('element' => "feat_type", 'value' => array('1')),       
    ), 
    array(
        "type" => "textfield",
        "heading" => __("Custom height (default is 490) in px", "rehub_framework"),
        "param_name" => "custom_height",
        "group" =>  __('Control', 'rehub_framework'),
        "dependency" => Array('element' => "feat_type", 'value' => array('1')),       
    ),              
        
));    

//WOO CAROUSEL
vc_map( array(
    "name" => __('Woo commerce product carousel', 'rehub_framework'),
    "base" => "woo_mod",
    "icon" => "icon-woo-mod",
    "category" => __('Woocommerce', 'rehub_framework'),
    'description' => __('Works only with Woocommerce', 'rehub_framework'), 
    "params" => rehub_woo_vc_filter_formodules(),
) );
vc_remove_param("woo_mod", "enable_pagination");
vc_add_params("woo_mod", array( 
    array(
        "type" => "checkbox",
        "class" => "",
        "group"  => __('Control', 'rehub_framework'),
        "heading" => __('Make link as affiliate?', 'rehub_framework'),       
        "value" => array(__("Yes", "rehub_framework") => true ),
        "param_name" => "aff_link", 
        "description" => __('This will change all inner post links to affiliate link of post offer', 'rehub_framework'),        
    ),               
    array(
        "type" => "checkbox",
        "class" => "",      
        "heading" => __('Make autorotate?', 'rehub_framework'),
        "group"  => __('Control', 'rehub_framework'),
        "value" => array(__("Yes", "rehub_framework") => true ),
        "param_name" => "autorotate",         
    ),  
    array(
        "type" => "dropdown",
        "class" => "",
        "group"  => __('Control', 'rehub_framework'),
        "heading" => __('Type', 'rehub_framework'),    
        "param_name" => "carouseltype",
        "value" => array(
            __('Columned grid', 'rehub_framework') => "columned",   
            __('Simple grid', 'rehub_framework') => "simple",                                                   
        ),
    ),    
    array(
        "type" => "dropdown",
        "class" => "",
        "group"  => __('Control', 'rehub_framework'),
        "heading" => __('Number of items in row', 'rehub_framework'),    
        "param_name" => "showrow",
        "value" => array(
            __('5', 'rehub_framework') => "5",            
            __('4', 'rehub_framework') => "4",
            __('3', 'rehub_framework') => "3",   
            __('6', 'rehub_framework') => "6",                                                   
        ),
    ),        
)); 

//WOO OFFER BOX
vc_map( array(
    "name" => __('Woo Box', 'rehub_framework'),
    "base" => "wpsm_woobox",
    "icon" => "icon-woo-offer-box",
    "category" => __('Woocommerce', 'rehub_framework'),
    'description' => __('Woocommerce product box', 'rehub_framework'), 
    "params" => array(
        array(
            'type' => 'autocomplete',
            'heading' => __( 'Set Product name', 'rehub_framework' ),
            'param_name' => 'id',
            "admin_label" => true,
            'settings' => array(
                'multiple' => false,
                'sortable' => false,
                'groups' => false,
            ),
            'description' => __( 'Type name of product', 'rehub_framework' ),                           
        ),                                                              
    )
) );

//WOO LIST
vc_map( array(
    "name" => __('List of woo products', 'rehub_framework'),
    "base" => "wpsm_woolist",
    "icon" => "icon-woolist",
    "category" => __('Woocommerce', 'rehub_framework'),
    'description' => __('Works only with Woocommerce', 'rehub_framework'), 
    "params" => rehub_woo_vc_filter_formodules(),
));

//WOO ROWS
vc_map( array(
    "name" => __('Rows of woo products', 'rehub_framework'),
    "base" => "wpsm_woorows",
    "icon" => "icon-woolist",
    "category" => __('Woocommerce', 'rehub_framework'),
    'description' => __('Works only with Woocommerce', 'rehub_framework'), 
    "params" => rehub_woo_vc_filter_formodules(),
));

//WOO GRID
vc_map( array(
    "name" => __('Grid of woocommerce products', 'rehub_framework'),
    "base" => "wpsm_woogrid",
    "icon" => "icon-woogrid",
    "category" => __('Woocommerce', 'rehub_framework'),
    'description' => __('Works only with Woocommerce', 'rehub_framework'),
    "params" => rehub_woo_vc_filter_formodules(),
));
vc_add_params("wpsm_woogrid", array( 
    array(
        "type" => "dropdown",
        "class" => "",
        "heading" => __('Set columns', 'rehub_framework'),
        "param_name" => "columns",
        "group"  => __('Control', 'rehub_framework'),
        "value" => array(
            __('3 columns', 'rehub_framework') => "3_col",
            __('4 columns', 'rehub_framework') => "4_col",
            __('5 columns', 'rehub_framework') => "5_col",
            __('6 columns', 'rehub_framework') => "6_col",                  
        ), 
    ),  
    array(
        "type" => "dropdown",
        "class" => "",
        "heading" => __('Show link from title and image on', 'rehub_framework'),
        "param_name" => "woolinktype",
        "group"  => __('Control', 'rehub_framework'),        
        "value" => array(
            __('Product page', 'rehub_framework') => "product",                
            __('Affiliate link', 'rehub_framework') => "aff",                              
        ), 
    ),                  
)); 
vc_add_params("wpsm_woogrid", rehub_vc_aj_filter_btns_formodules());

//WOO COLUMNS
vc_map( array(
    "name" => __('Columns of woocommerce products', 'rehub_framework'),
    "base" => "wpsm_woocolumns",
    "icon" => "icon-woocolumns",
    "category" => __('Woocommerce', 'rehub_framework'),
    'description' => __('Works only with Woocommerce', 'rehub_framework'),
    "params" => rehub_woo_vc_filter_formodules(),
));
vc_add_params("wpsm_woocolumns", array( 
    array(
        "type" => "dropdown",
        "class" => "",
        "heading" => __('Set columns', 'rehub_framework'),
        "param_name" => "columns",
        "group"  => __('Control', 'rehub_framework'),
        "value" => array(
            __('3 columns', 'rehub_framework') => "3_col",
            __('4 columns', 'rehub_framework') => "4_col", 
            __('5 columns', 'rehub_framework') => "5_col", 
            __('6 columns', 'rehub_framework') => "6_col",                                         
        ), 
    ),  
    array(
        "type" => "dropdown",
        "class" => "",
        "heading" => __('Show link from title and image on', 'rehub_framework'),
        "param_name" => "woolinktype",
        "group"  => __('Control', 'rehub_framework'),        
        "value" => array(
            __('Product page', 'rehub_framework') => "product",                
            __('Affiliate link', 'rehub_framework') => "aff",                              
        ), 
    ),
    array(
        "type" => "checkbox",
        "class" => "",      
        "heading" => __('Custom image size?', 'rehub_framework'),
        "description"=> 'Use only if your image is blured',
        "group"  => __('Control', 'rehub_framework'),
        "value" => array(__("Yes", "rehub_framework") => true ),
        "param_name" => "custom_col",         
    ), 
    array(
        "type" => "textfield",
        "heading" => __('Width of image in px', 'rehub_framework'),
        "group"  => __('Control', 'rehub_framework'),        
        "param_name" => "custom_img_width", 
        "dependency" => Array('element' => "custom_col", 'not_empty' => true),        
    ),
    array(
        "type" => "textfield",
        "heading" => __('Height of image in px', 'rehub_framework'),
        "param_name" => "custom_img_height", 
        "group"  => __('Control', 'rehub_framework'),        
        "dependency" => Array('element' => "custom_col", 'not_empty' => true),                 
    ),        
)); 
vc_add_params("wpsm_woocolumns", rehub_vc_aj_filter_btns_formodules());

//Compare Bars
vc_map( array(
    'name' => __('Woo Compare Bars', 'rehub_framework'),
    'base' => 'wpsm_woo_versus',
    'icon' => 'icon-wpsm-woo-versus',
    "category" => __('Helper modules', 'rehub_framework'),
    'description' => __('Woo attribute comparisons', 'rehub_framework'), 
    'params' => array(
        array(
            'type' => 'colorpicker',
            'heading' => __( 'Color', 'rehub_framework' ),
            'param_name' => 'color', 
            'description' => 'Set default color or leave empty to leave default color as grey'                
        ), 
        array(
            'type' => 'colorpicker',
            'heading' => __( 'Highlight Color', 'rehub_framework' ),
            'param_name' => 'markcolor', 
            'description' => 'Set highlighted color or leave empty to leave default color as orange'                
        ), 
        array(
            'type' => 'autocomplete',
            'heading' => __( 'Product names for compare', 'rehub_framework' ),
            'param_name' => 'ids',
            "admin_label" => true,
            'settings' => array(
                'multiple' => true,
                'sortable' => true,
                'groups' => false,
            ),                     
        ),   
        array(
            'type' => 'autocomplete',
            'heading' => __( 'Attribute names', 'rehub_framework' ),
            'description' => 'Choose attributes which have numeric values, other will have errors',
            'param_name' => 'attr',
            "admin_label" => true,
            'settings' => array(
                'multiple' => true,
                'sortable' => true,
                'groups' => false,
            ),                         
        ), 
        array(
            'type' => 'textfield',           
            'heading' => __('Attribute for minimum priority', 'rehub_framework'),
            'param_name' => 'min',
            'description' => 'By default, bar with maximum value will be highlighted. You can set here number of attribute which will be highlighted with minimum value. For example, if you choosed 5 attributes above, set number 3 if you want to highlight minimum in third attribute. For multiple, use comma divider. For example: 3,5'                
        ),                                    

    )
) );

}

//PROS BLOCK
vc_map( array(
    "name" => __('Pros block', 'rehub_framework'),
    "base" => "wpsm_pros",
    "icon" => "icon-pros",
    "category" => __('Helper modules', 'rehub_framework'),
    'description' => __('List of positives', 'rehub_framework'), 
    "params" => array(  
        array(
            "type" => "textfield",
            "heading" => __('Pros title', 'rehub_framework'),
            "param_name" => "title",
            "value" => __('PROS:', 'rehub_framework'),           
        ),
        array(
            'type' => 'textarea_html',
            'heading' => __( 'Content', 'rehub_framework' ),
            'param_name' => 'content',
            "admin_label" => true,
            'value' => __( '<ul><li>Positive 1</li><li>Positive 2</li><li>Positive 3</li><li>Positive 4</li></ul>', 'rehub_framework' ),
        ),                                                              
    )
) );

//CONS BLOCK
vc_map( array(
    "name" => __('Cons block', 'rehub_framework'),
    "base" => "wpsm_cons",
    "icon" => "icon-cons",
    "category" => __('Helper modules', 'rehub_framework'),
    'description' => __('List of negatives', 'rehub_framework'), 
    "params" => array(  
        array(
            "type" => "textfield",
            "heading" => __('Cons title', 'rehub_framework'),
            "param_name" => "title",
            "value" => __('CONS:', 'rehub_framework'),           
        ),
        array(
            'type' => 'textarea_html',
            'heading' => __( 'Content', 'rehub_framework' ),
            'param_name' => 'content',
            "admin_label" => true,
            'value' => __( '<ul><li>Negative 1</li><li>Negative 2</li><li>Negative 3</li><li>Negative 4</li></ul>', 'rehub_framework' ),
        ),                                                              
    )
) );

//IMAGE CAROUSEL BLOCK
vc_map( array(
    "name" => __("Image carousel", "rehub_framework"),
    "base" => "gal_carousel",
    'deprecated' => '5.0',
    "icon" => "icon-gal-carousel",
    "category" => __('Helper modules', 'rehub_framework'),
    'description' => __('For row with sidebar', 'rehub_framework'), 
    "params" => array(
        array(
            "type" => "attach_images",
            "heading" => __("Images", "rehub_framework"),
            "param_name" => "images",
            "value" => "",
            "description" => __("Select images from media library.", "rehub_framework")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("On click", "rehub_framework"),
            "param_name" => "onclick",
            "value" => array(__("Open Lightbox", "rehub_framework") => "link_image", __("Do nothing", "rehub_framework") => "link_no", __("Open custom link", "rehub_framework") => "custom_link"),
            "description" => __("What to do when slide is clicked?", "rehub_framework")
        ),
        array(
            "type" => "exploded_textarea",
            "heading" => __("Custom links", "rehub_framework"),
            "param_name" => "custom_links",
            "description" => __('Enter links for each slide here. Divide links with linebreaks (Enter).', 'rehub_framework'),
            "dependency" => Array('element' => "onclick", 'value' => array('custom_link'))
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Custom link target", "rehub_framework"),
            "param_name" => "custom_links_target",
            "description" => __('Select where to open  custom links.', 'rehub_framework'),
            "dependency" => Array('element' => "onclick", 'value' => array('custom_link')),
            'value' => $target_arr
        ),
        array(
            "type" => "textfield",
            "heading" => __("Extra class name", "rehub_framework"),
            "param_name" => "el_class",
            "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "rehub_framework")
        )
    )
) );
require_once vc_path_dir('SHORTCODES_DIR', 'vc-gallery.php');
if ( class_exists( 'WPBakeryShortCode_VC_gallery' ) ) {
    class WPBakeryShortCode_Gal_Carousel extends WPBakeryShortCode_VC_gallery {

    }
}

//SEARCHBOX
vc_map( array(
    "name" => __('Search box', 'rehub_framework'),
    "base" => "wpsm_searchbox",
    "icon" => "icon-searchbox",
    "category" => __('Helper modules', 'rehub_framework'),
    'description' => __('Searchbox', 'rehub_framework'), 
    "params" => array(
        array(
            "type" => "dropdown",
            "class" => "",
            "heading" => __('Type of search', 'rehub_framework'),
            "param_name" => "search_type",
            "value" => array(
                __('Posts', 'rehub_framework') => "post",
                __('Taxonomy', 'rehub_framework') => "tax",                 
            ), 
        ),     
        array(
            "type" => "dropdown",
            "class" => "",
            "heading" => __('Where to search', 'rehub_framework'),
            "param_name" => "by",
            "dependency" => array("element" => "search_type", "value" => array("post")),
            'value' => rehub_post_type_vc(),
        ), 
        array(
            "type" => "textfield",
            "heading" => __('Place taxonomy', 'rehub_framework'),
            "description" => __('You can set several with commas. Be aware of taxonomies with too much items.', 'rehub_framework'),
            "param_name" => "tax",
            "dependency" => array("element" => "search_type", "value" => array("tax")),          
        ),  
        array(
            "type" => "textfield",
            "heading" => __('Only inside category', 'rehub_framework'),
            "description" => __('You can search items only in category Ids, separate by comma', 'rehub_framework'),
            "param_name" => "catid",
            "dependency" => array("element" => "by", "value" => array("post")),          
        ),                
        array(
            "type" => "checkbox",
            "class" => "",
            "heading" => __('Enable ajax search?', 'rehub_framework'),
            "value" => array(__("Yes", "rehub_framework") => true ),
            "dependency" => array("element" => "search_type", "value" => array("post")),            
            "param_name" => "enable_ajax",         
        ),        
        array(
            "type" => "checkbox",
            "class" => "",
            "heading" => __('Add compare button in results?', 'rehub_framework'),
            "description" => __('Check this only if you use dynamic comparison function of theme (Theme option - dynamic comparison) and want to have compare button in results', 'rehub_framework'),            
            "value" => array(__("Yes", "rehub_framework") => true ),
            "dependency" => array("element" => "enable_ajax", 'not_empty' => true),            
            "param_name" => "enable_compare",         
        ),                  
        array(
            "type" => "textfield",
            "heading" => __('Placeholder', 'rehub_framework'),
            "admin_label" => true,
            "param_name" => "placeholder",          
        ), 
        array(
            "type" => "textfield",
            "heading" => __('Text on button', 'rehub_framework'),
            "description" => __('Or leave blank to show search icon only', 'rehub_framework'),
            "param_name" => "label",         
        ),         
        array(
            "type" => "dropdown",
            "class" => "",
            "heading" => __('Color of button', 'rehub_framework'),
            "param_name" => "color",
            "value" => array(
                __('orange', 'rehub_framework') => "orange",
                __('gold', 'rehub_framework') => "gold",
                __('black', 'rehub_framework') => "black",  
                __('blue', 'rehub_framework') => "blue",
                __('red', 'rehub_framework') => "red",
                __('green', 'rehub_framework') => "green",  
                __('rosy', 'rehub_framework') => "rosy",
                __('brown', 'rehub_framework') => "brown",
                __('pink', 'rehub_framework') => "pink",
                __('purple', 'rehub_framework') => "purple",
                __('teal', 'rehub_framework') => "teal",                
            )
        ),                                                                          
    )
) );

//TESTIMONIAL
vc_map( array(
    "name" => __('Testimonial', 'rehub_framework'),
    "base" => "wpsm_testimonial",
    "icon" => "icon-testimonial",
    "category" => __('Helper modules', 'rehub_framework'),
    'description' => __('Testimonial box', 'rehub_framework'), 
    "params" => array(  
        array(
            "type" => "textfield",
            "heading" => __('Author', 'rehub_framework'),
            "param_name" => "by",
            'description' => __('Add author or leave blank.', 'rehub_framework'),            
        ),
        array(
            'type' => 'textarea_html',
            'heading' => __( 'Content', 'rehub_framework' ),
            "admin_label" => true,
            'param_name' => 'content',
            'value' => __( 'Content goes here, click edit button to change this text.', 'rehub_framework' ),
        ),                                                              
    )
) );

//LIST
vc_map( array(
    "name" => __('Styled list', 'rehub_framework'),
    "base" => "wpsm_list",
    "icon" => "icon-s-list",
    "category" => __('Helper modules', 'rehub_framework'),
    'description' => __('Styled simple list', 'rehub_framework'), 
    "params" => array(  
        array(
            "type" => "dropdown",
            "class" => "",
            "heading" => __('Type of list', 'rehub_framework'),
            "param_name" => "type",
            "value" => array(
                __('Arrow', 'rehub_framework') => "arrow",
                __('Check', 'rehub_framework') => "check",  
                __('Star', 'rehub_framework') => "star",
                __('Bullet', 'rehub_framework') => "bullet"
            )
        ),
        array(
            "type" => "dropdown",
            "class" => "",
            "heading" => __('Type of gap', 'rehub_framework'),
            "param_name" => "gap",
            "value" => array(
                __('Default', 'rehub_framework') => "default",
                __('Small', 'rehub_framework') => "small"
            )
        ), 
        array(
            "type" => "checkbox",
            "class" => "",
            "heading" => __('Pretty hover?', 'rehub_framework'),
            "value" => array(__("Yes", "rehub_framework") => true ),
            "param_name" => "hover",         
        ), 
        array(
            "type" => "checkbox",
            "class" => "",
            "heading" => __('Make link with dark color?', 'rehub_framework'),
            "value" => array(__("Yes", "rehub_framework") => true ),
            "param_name" => "darklink",         
        ),                        
        array(
            'type' => 'textarea_html',
            'heading' => __( 'Content', 'rehub_framework' ),
            "admin_label" => true,
            'param_name' => 'content',
            'value' => __( '<ul><li>Item 1</li><li>Item 2</li><li>Item 3</li><li>Item 4</li></ul>', 'rehub_framework' ),
        ),                                                              
    )
) );

//NUMBERED HEADING
vc_map( array(
    "name" => __('Numbered Headings', 'rehub_framework'),
    "base" => "wpsm_numhead",
    "icon" => "icon-numhead",
    'deprecated' => '4.9',
    "category" => __('Helper modules', 'rehub_framework'),
    'description' => __('Numbered Headings', 'rehub_framework'), 
    "params" => array(  
        array(
            "type" => "textfield",
            "heading" => __('Number', 'rehub_framework'),
            "param_name" => "num",
            "value" => '1',           
        ),
        array(
            "type" => "dropdown",
            "class" => "",
            "heading" => __('Style of number', 'rehub_framework'),
            "param_name" => "style",
            "admin_label" => true,
            "value" => array(
                __('Orange', 'rehub_framework') => "3",
                __('Black', 'rehub_framework') => "2",  
                __('Grey', 'rehub_framework') => "1",
                __('Blue', 'rehub_framework') => "4"
            )
        ), 
        array(
            "type" => "dropdown",
            "class" => "",
            "heading" => __('Heading', 'rehub_framework'),
            "param_name" => "heading",
            "value" => array(
                "H2" => "2",    
                "H1" => "1",
                "H3" => "3",
                "H4" => "4",
            )
        ),             
        array(
            "type" => "textarea",
            "heading" => __('Text', 'rehub_framework'),
            "param_name" => "content",
            "admin_label" => true,
            "value" => 'Lorem ipsum dolor sit amet',           
        ),                                                              
    )
) );

//NUMBERED BOX
vc_map( array(
    "name" => __('Box with number', 'rehub_framework'),
    "base" => "wpsm_numbox",
    "icon" => "icon-numbox",
    'deprecated' => '4.9',
    "category" => __('Helper modules', 'rehub_framework'),
    'description' => __('Box with number', 'rehub_framework'), 
    "params" => array(  
        array(
            "type" => "textfield",
            "heading" => __('Number', 'rehub_framework'),
            "param_name" => "num",
            "value" => '1',           
        ),
        array(
            "type" => "dropdown",
            "class" => "",
            "heading" => __('Style of number', 'rehub_framework'),
            "param_name" => "style",
            "admin_label" => true,
            "value" => array(
                __('Orange', 'rehub_framework') => "3",
                __('Black', 'rehub_framework') => "2",  
                __('Grey', 'rehub_framework') => "1",
                __('Blue', 'rehub_framework') => "4",
                __('White no border', 'rehub_framework') => "5",
                __('Black no border', 'rehub_framework') => "6"
            )
        ), 
        array(
            'type' => 'textarea_html',
            'heading' => __( 'Content', 'rehub_framework' ),
            'param_name' => 'content',
            "admin_label" => true,
            'value' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim',
        ),                     
                                                            
    )
) );

//CART BOX
vc_map( array(
    "name" => __('Card box', 'rehub_framework'),
    "base" => "wpsm_cartbox",
    "icon" => "icon-cartbox",
    "category" => __('Helper modules', 'rehub_framework'),
    'description' => __('Box with image', 'rehub_framework'), 
    "params" => array(  
        array(
            "type" => "textfield",
            "heading" => __('Title', 'rehub_framework'),
            "param_name" => "title",
            "value" => '', 
            "admin_label" => true,                      
        ),
        array(
            "type" => "textfield",
            "heading" => __('Description', 'rehub_framework'),
            "param_name" => "description",
            "value" => '', 
            "admin_label" => true,          
        ), 
        array(
            'type' => 'attach_image',
            'heading' => __('Image', 'rehub_framework'),
            'param_name' => 'image',
            'value' => '',
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Choose design', 'rehub_framework' ),
            'param_name' => 'design',
            'value' => array(
                __( 'Full width image', 'rehub_framework' ) => '1',
                __( 'Image in Right (compact)', 'rehub_framework' ) => '2',
            ),
        ),
        array(
            "type" => "vc_link",
            "heading" => __('URL:', 'rehub_framework'),
            "param_name" => "link",
            'description' => __('Will be used on image and title', 'rehub_framework'),
            "admin_label" => true,
        ),                
        array(
            "type" => "checkbox",
            "class" => "",
            "heading" => __('Make background image contain?', 'rehub_framework'),
            "value" => array(__("Yes", "rehub_framework") => true ),
            "param_name" => "bg_contain", 
            "dependency" => array("element" => "design", "value" => array("1")),                     
        ),  
        array(
            "type" => "checkbox",
            "class" => "",
            "heading" => __('Show image first?', 'rehub_framework'),
            "value" => array(__("Yes", "rehub_framework") => true ),
            "param_name" => "revert_image", 
            "dependency" => array("element" => "design", "value" => array("1")),                     
        ),               
                                              
                                                            
    )
) );

//CATEGORY BOX
vc_map( array(
    "name" => __('Category box', 'rehub_framework'),
    "base" => "wpsm_catbox",
    "icon" => "icon-cartbox",
    "category" => __('Helper modules', 'rehub_framework'),
    'description' => __('Box for category cart', 'rehub_framework'), 
    "params" => array(  
        array(
            "type" => "textfield",
            "heading" => __('Title', 'rehub_framework'),
            "param_name" => "title",
            "value" => '', 
            "admin_label" => true,                      
        ),
        array(
            'type' => 'attach_image',
            'heading' => __('Image', 'rehub_framework'),
            'param_name' => 'image',
            'value' => '',
        ),        
        array(
            "type" => "textfield",
            "heading" => __('Image size', 'rehub_framework'),
            "description" => __('Leave blank or try to change size to better fit for image. Example, 170px or 50%', 'rehub_framework'),
            "param_name" => "size_img",
            "value" => '',           
        ), 
        array(
            "type" => "checkbox",
            "class" => "",
            "heading" => __('Disable link from title', 'rehub_framework'),
            "value" => array(__("Yes", "rehub_framework") => true ),
            "param_name" => "disablelink",         
        ),  
        array(
            "type" => "checkbox",
            "class" => "",
            "heading" => __('Disable child elements', 'rehub_framework'),
            "value" => array(__("Yes", "rehub_framework") => true ),
            "param_name" => "disablechild",         
        ),                      
        array(
            "type" => "textfield",
            "heading" => __('Category ID:', 'rehub_framework'),
            "param_name" => "category",
            'description' => __('Place ID of category to get sub child', 'rehub_framework'),
        ),                                              
                                                            
    )
) );

//TITLED BOX
vc_map( array(
    "name" => __('Titled box', 'rehub_framework'),
    "base" => "wpsm_titlebox",
    "icon" => "icon-titlebox",
    "category" => __('Helper modules', 'rehub_framework'),
    'description' => __('Box with border and title', 'rehub_framework'), 
    "params" => array(  
        array(
            "type" => "textfield",
            "heading" => __('Title', 'rehub_framework'),
            "param_name" => "title",
            "value" => __('Title of box', 'rehub_framework'),           
        ),
        array(
            "type" => "dropdown",
            "class" => "",
            "heading" => __('Style', 'rehub_framework'),
            "param_name" => "style",
            "admin_label" => true,
            "value" => array(
                __('Grey', 'rehub_framework') => "1",
                __('Black', 'rehub_framework') => "2",  
                __('Orange', 'rehub_framework') => "3",
                __('Double dotted', 'rehub_framework') => "4"
            )
        ), 
        array(
            'type' => 'textarea_html',
            'heading' => __( 'Content', 'rehub_framework' ),
            'param_name' => 'content',
            "admin_label" => true,
            'value' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim',
        ),                     
                                                            
    )
) );

//COLORED TABLE
vc_map( array(
    "name" => __('Colored Table', 'rehub_framework'),
    "base" => "wpsm_colortable",
    "icon" => "icon-colortable",
    'deprecated' => '4.9',
    "category" => __('Helper modules', 'rehub_framework'),
    'description' => __('Table with color header', 'rehub_framework'), 
    "params" => array(  
        array(
            "type" => "dropdown",
            "class" => "",
            "heading" => __('Color of heading table :', 'rehub_framework'),
            "param_name" => "color",
            "admin_label" => true,
            "value" => array(
                __('grey', 'rehub_framework') => "grey",
                __('black', 'rehub_framework') => "black",  
                __('yellow', 'rehub_framework') => "yellow",
                __('blue', 'rehub_framework') => "blue",
                __('red', 'rehub_framework') => "red",
                __('green', 'rehub_framework') => "green",  
                __('orange', 'rehub_framework') => "orange",
                __('purple', 'rehub_framework') => "purple",                
            )
        ), 
        array(
            'type' => 'textarea_html',
            'heading' => __( 'Content', 'rehub_framework' ),
            'param_name' => 'content',
            'value' => '<table>
                            <thead>
                                <tr>
                                    <th style="width: 25%;">Heading 1</th>
                                    <th style="width: 25%;">Heading 2</th>
                                    <th style="width: 25%;">Heading 3</th>
                                    <th style="width: 25%;">Heading 4</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Value</td>
                                    <td>Value</td>
                                    <td>Value</td>
                                    <td>Value</td>
                                </tr>
                                <tr class="odd">
                                    <td>Value</td>
                                    <td>Value</td>
                                    <td>Value</td>
                                    <td>Value</td>
                                </tr>
                                <tr>
                                    <td>Value</td>
                                    <td>Value</td>
                                    <td>Value</td>
                                    <td>Value</td>
                                </tr>
                                <tr class="odd">
                                    <td>Value</td>
                                    <td>Value</td>
                                    <td>Value</td>
                                    <td>Value</td>
                                </tr>
                            </tbody>
                        </table>',
        ),                                                                              
    )
) );

//PRICE TABLES
vc_map( array(
    "name" => __("Price table", "rehub_framework"),
    "base" => "wpsm_price_table",
    "category" => __('Helper modules', 'rehub_framework'),
    "icon" => "icon-pricetable",    
    "as_parent" => array('only' => 'wpsm_price_column'),
    "content_element" => true,
    "show_settings_on_create" => false,
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __("Extra class name", "rehub_framework"),
            "param_name" => "el_class",
        )
    ),
    "js_view" => 'VcColumnView'
) );
vc_map( array(
    "name" => __("Price table column", "rehub_framework"),
    "base" => "wpsm_price_column",
    "icon" => "icon-pricetable", 
    "content_element" => true,
    "as_child" => array('only' => 'wpsm_price_table'), 
    "params" => array(
        array(
            "type" => "dropdown",
            "heading" => __('Column size', 'rehub_framework'),
            "param_name" => "size",
            "value" => array(
                '1/3' => "3",
                "1/4" => "4",   
                "1/5" => "5",
                "1/2" => "2"
            )
        ),
        array(
            "type" => "dropdown",
            "heading" => __('Featured', 'rehub_framework'),
            "param_name" => "featured",
            "value" => array(
                __('No', 'rehub_framework') => "no",
                __('Yes', 'rehub_framework') => "yes",  
            )
        ),
        array(
            "type" => "textfield",
            "heading" => __('Title', 'rehub_framework'),
            "admin_label" => true,
            "param_name" => "name",
            "value" => __('Title of box', 'rehub_framework'),           
        ),
        array(
            "type" => "textfield",
            "heading" => __('Price', 'rehub_framework'),
            "admin_label" => true,
            "param_name" => "price",
            'edit_field_class' => 'vc_col-md-6 vc_column',
            "value" => __('$99.99', 'rehub_framework'),           
        ),  
        array(
            "type" => "textfield",
            "heading" => __('Per', 'rehub_framework'),
            "param_name" => "per",
            'edit_field_class' => 'vc_col-md-6 vc_column',
            "value" => __('month', 'rehub_framework'),           
        ),  
        array(
            "type" => "dropdown",
            "class" => "",
            "heading" => __('Color', 'rehub_framework'),
            "param_name" => "color",
            "value" => array(
                __('orange', 'rehub_framework') => "orange",
                __('gold', 'rehub_framework') => "gold",
                __('black', 'rehub_framework') => "black",  
                __('blue', 'rehub_framework') => "blue",
                __('red', 'rehub_framework') => "red",
                __('green', 'rehub_framework') => "green",  
                __('rosy', 'rehub_framework') => "rosy",
                __('brown', 'rehub_framework') => "brown",
                __('pink', 'rehub_framework') => "pink",
                __('purple', 'rehub_framework') => "purple",
                __('teal', 'rehub_framework') => "teal",                
            )
        ), 
        array(
            "type" => "textfield",
            "heading" => __('Button URL', 'rehub_framework'),
            "param_name" => "button_url",       
        ),
        array(
            "type" => "textfield",
            "heading" => __('Button text', 'rehub_framework'),
            "param_name" => "button_text",
            "value" => "Buy this",       
        ), 
        array(
            'type' => 'textarea_html',
            'heading' => __( 'List of items', 'rehub_framework' ),
            'param_name' => 'content',
            'value' => __( '<ul><li>Item 1</li><li>Item 2</li><li>Item 3</li><li>Item 4</li></ul>', 'rehub_framework' ),
        ),                                                          
    )
) );

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_Wpsm_Price_Table extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_Wpsm_Price_Column extends WPBakeryShortCode {
    }
}

//MEMBER BLOCK CONTENT
vc_map( array(
    "name" => __('Text for members block', 'rehub_framework'),
    "base" => "wpsm_member",
    "icon" => "icon-memberbox",
    "category" => __('Helper modules', 'rehub_framework'),
    'description' => __('Hide from guests', 'rehub_framework'), 
    "params" => array(  
        array(
            "type" => "textfield",
            "heading" => __('Text for guests', 'rehub_framework'),
            "admin_label" => true,
            "param_name" => "guest_text",
            "value" => __('Please, login or register to view this content', 'rehub_framework'),           
        ),
        array(
            'type' => 'textarea_html',
            'heading' => __( 'Content', 'rehub_framework' ),
            'param_name' => 'content',
            "admin_label" => true,
            'value' => __( 'Text for members', 'rehub_framework' ),
        ),                                                              
    )
) );

//POPUP BUTTON
vc_map( array(
    "name" => __('Button with popup', 'rehub_framework'),
    "base" => "wpsm_button_popup",
    "icon" => "icon-button_popup",
    "category" => __('Helper modules', 'rehub_framework'),
    'description' => __('Popup on button click', 'rehub_framework'), 
    "params" => array( 
        array(
            "type" => "dropdown",
            "class" => "",
            "heading" => __('Color of button', 'rehub_framework'),
            "param_name" => "color",
            "value" => array(
                __('orange', 'rehub_framework') => "orange",
                __('gold', 'rehub_framework') => "gold",
                __('black', 'rehub_framework') => "black",  
                __('blue', 'rehub_framework') => "blue",
                __('red', 'rehub_framework') => "red",
                __('green', 'rehub_framework') => "green",  
                __('rosy', 'rehub_framework') => "rosy",
                __('brown', 'rehub_framework') => "brown",
                __('pink', 'rehub_framework') => "pink",
                __('purple', 'rehub_framework') => "purple",
                __('teal', 'rehub_framework') => "teal",                
            )
        ),
        array(
            "type" => "dropdown",
            "class" => "",
            "heading" => __('Button Size', 'rehub_framework'),
            "param_name" => "size",
            "value" => array(
                __('Medium', 'rehub_framework') => "medium",                
                __('Small', 'rehub_framework') => "small",
                __('Big', 'rehub_framework') => "big",                  
            )
        ),
        array(
            "type" => "checkbox",
            "class" => "",
            "heading" => __('Enable icon in button?', 'rehub_framework'),
            "value" => array(__("Yes", "rehub_framework") => true ),
            "param_name" => "enable_icon",         
        ),        
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'rehub_framework' ),
            'param_name' => 'icon',
            'value' => '',
            'settings' => array(
                'emptyIcon' => true,
                'iconsPerPage' => 100,
            ),
            "dependency" => Array('element' => "enable_icon", 'not_empty' => true),
        ),                     
        array(
            "type" => "textfield",
            "heading" => __('Button text', 'rehub_framework'),
            "admin_label" => true,
            "param_name" => "btn_text",         
        ),
        array(
            "type" => "textfield",
            "heading" => __('Max width of popup', 'rehub_framework'),
            "param_name" => "max_width",
            "value" => 500         
        ),        
        array(
            'type' => 'textarea_html',
            'heading' => __( 'Content', 'rehub_framework' ),
            'param_name' => 'content',
            "admin_label" => true,
            'value' => __( 'Content of popup. You can use also shortcode', 'rehub_framework' ),
        ),                                                              
    )
) );

//CTA BLOCK
vc_add_param("vc_cta_button2", array(
    'type' => 'colorpicker',
    'heading' => __( 'Text Color', 'rehub_framework' ),
    'param_name' => 'text_color',
));

//TABS BLOCK
if (defined('WPB_VC_VERSION') && version_compare(WPB_VC_VERSION, '4.6.0', '>=')) {
    vc_remove_param("vc_tta_tabs", "title");
    vc_add_param("vc_tta_tabs", array(
        "type" => "checkbox",
        "heading" => __('Overwrite design of tabs with theme settings?', 'rehub_framework'),
        "value" => array(__("Yes", "rehub_framework") => true ),
        "weight" => 100,
        "param_name" => "style_rehub",
    ));
    vc_add_param("vc_tta_tabs", array(
        "type" => "checkbox",
        "heading" => __('Enable design of tabs without border?', 'rehub_framework'),
        "value" => array(__("Yes", "rehub_framework") => true ),
        "weight" => 99,
        "param_name" => "style_sec",
    ));
        
}

//MDTF
vc_map( array(
    "name" => __('MDTF shortcode', 'rehub_framework'),
    "base" => "mdtf_shortcode",
    "icon" => "icon-mdtf",
    "category" => __('Helper modules', 'rehub_framework'),
    'description' => __('Works only with MDTF', 'rehub_framework'), 
    "params" => array(
        array(
            "type" => "dropdown",
            "class" => "",
            "heading" => __('Output template', 'rehub_framework'),
            "param_name" => "data_source",
            "value" => array(
                __('Columned grid loop', 'rehub_framework') => "template/column",
                __('Deal grid', 'rehub_framework') => "template/grid",  
                __('Full width Deal grid', 'rehub_framework') => "template/grid_full",                 
                __('List loop', 'rehub_framework') => "template/list",
                __('Review list - use only for posts', 'rehub_framework') => "template/reviewlist",                
                __('Woocommerce column - use only with woocommerce enabled', 'rehub_framework') => "template/woocolumn",
                __('Woocommerce grid - use only with woocommerce enabled', 'rehub_framework') => "template/woogrid",
                __('Woocommerce list - use only with woocommerce enabled', 'rehub_framework') => "template/woolist",                
            ), 
            "admin_label" => true,
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Choose post type', 'rehub_framework' ),
            'param_name' => 'post_type',
            'value' => rehub_post_type_vc(),
            'dependency' => array(
                'element' => 'data_source',
                'value_not_equal_to' => array( 'woocommerce'),
            ),            
        ),              
            
        array(
            'type' => 'dropdown',
            'heading' => __( 'Order by', 'js_composer' ),
            'param_name' => 'orderby',
            'value' => array(
                __( 'Date', 'js_composer' ) => 'date',
                __( 'Order by post ID', 'js_composer' ) => 'ID',
                __( 'Title', 'js_composer' ) => 'title',
                __( 'Last modified date', 'js_composer' ) => 'modified',
                __( 'Number of comments', 'js_composer' ) => 'comment_count',
                __( 'Menu order/Page Order', 'js_composer' ) => 'menu_order',
                __( 'Random order', 'js_composer' ) => 'rand',
            ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Sorting', 'js_composer' ),
            'param_name' => 'order',
            'value' => array(
                __( 'Descending', 'js_composer' ) => 'DESC',
                __( 'Ascending', 'js_composer' ) => 'ASC',
            ),
            'description' => __( 'Select sorting order.', 'js_composer' ),
        ),  
        array(
            "type" => "textfield",
            "heading" => __('Fetch Count', 'rehub_framework'),
            "param_name" => "show",
            "value" => '9',
            'description' => __('Number of products to display', 'rehub_framework'),         
        ),                                       
        array(
            'type' => 'dropdown',
            'heading' => __( 'Pagination position', 'rehub_framework' ),
            'param_name' => 'pag_pos',
            'value' => array(
                __( 'Top and bottom', 'rehub_framework' ) => 'tb',
                __( 'Top', 'rehub_framework' ) => 't',
                __( 'Bottom', 'rehub_framework' ) => 'b',
            ),            
        ), 
        array(
            "type" => "textfield",
            "heading" => __('Taxonomies', 'rehub_framework'),
            "param_name" => "tax",
            "value" => '',
            'description' => __('if you want to show posts of any custom taxonomies. Example of setting this field: taxonomies=product_cat+77,96,12', 'rehub_framework'),         
        ), 
        array(
            "type" => "textfield",
            "heading" => __('ID of sort panel', 'rehub_framework'),
            "param_name" => "sortid",
            "value" => '',
            'description' => __('if you want to sort panel before posts, write id of panel', 'rehub_framework'),         
        ),                        
        array(
            "type" => "checkbox",
            "heading" => __('Enable ajax?', 'rehub_framework'),
            "value" => array(__("Yes", "rehub_framework") => true ),
            "param_name" => "ajax",   
        ),                                                             
    )
) );
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_Mdtf_Shortcode extends WPBakeryShortCode {
    }
}

//WPSM HOVER BANNER
vc_map( array(
    'name' => __('Hover Banner', 'rehub_framework'),
    'base' => 'wpsm_hover_banner',
    'icon' => 'icon-banner-hover',
    "category" => __('Helper modules', 'rehub_framework'),
    'description' => __('Animated Hover banner', 'rehub_framework'), 
    'params' => array(
        array(
            'type' => 'textfield',
            'heading' => __('Title', 'rehub_framework'),
            'admin_label' => true,
            'param_name' => 'title',
        ), 
        array(
            'type' => 'textfield',
            'heading' => __('Size', 'rehub_framework'),
            'param_name' => 'firstsize',
            'description' => __( 'With px, em, etc. Example: 2em. Default is 1.7em', 'rehub_framework' ),            
        ),          
        array(
            'type' => 'textfield',
            'heading' => __('Subtitle', 'rehub_framework'),
            'admin_label' => true,
            'param_name' => 'subtitle',
        ),
        array(
            'type' => 'textfield',
            'heading' => __('Size', 'rehub_framework'),
            'param_name' => 'secondsize',
            'description' => __( 'With px, em, etc. Example: 2em. Default is 1.1em', 'rehub_framework' ),              
        ),        
        array(
            'type' => 'attach_image',
            'heading' => __('Upload background', 'rehub_framework'),
            'param_name' => 'image_id',
            'value' => '',
        ),
        array(
            'type' => 'colorpicker',
            'heading' => __( 'Or set background color', 'rehub_framework' ),
            'param_name' => 'bg',                 
        ),         
        array(
            'type' => 'checkbox',
            'class' => '',
            'heading' => __('Enable Icon?', 'rehub_framework'),
            'value' => array(__('Yes', 'rehub_framework') => true ),
            'param_name' => 'enable_icon',         
        ),        
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'rehub_framework' ),
            'param_name' => 'icon',
            'value' => 'fa fa-gift',
            'settings' => array(
                'emptyIcon' => true,
                'iconsPerPage' => 100,
            ),
            'dependency' => Array('element' => 'enable_icon', 'not_empty' => true),
        ),
        array(
            'type' => 'colorpicker',
            'heading' => __( 'Icon and Hover border Color', 'rehub_framework' ),
            'param_name' => 'color',                 
        ), 
        array(
            'type' => 'colorpicker',
            'heading' => __( 'Text Color', 'rehub_framework' ),
            'param_name' => 'colortext',                  
        ),         
        array(
            'type' => 'textfield',
            'heading' => __('Height, px', 'rehub_framework'),
            'param_name' => 'height',
            'value' => '',
        ),
        array(
            'type' => 'textfield',
            'heading' => __('Padding, px', 'rehub_framework'),
            'param_name' => 'padding',
            'value' => '40',
        ),
        array(
            'type' => 'dropdown',
            'class' => '',
            'heading' => __('Text Position', 'rehub_framework'),
            'param_name' => 'align',
            'value' => array(
                __('Left', 'rehub_framework') => 'left',
                __('Right', 'rehub_framework') => 'right',
                __('Center', 'rehub_framework') => 'center',                
            ), 
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Vertical align', 'rehub_framework' ),
            'param_name' => 'vertical',
            'value' => array(
                __( 'Middle', 'rehub_framework' ) => 'middle',
                __( 'Top', 'rehub_framework' ) => 'top',
                __( 'Bottom', 'rehub_framework' ) => 'bottom',
            ),
        ),        
        array(
            'type' => 'textfield',
            'heading' => __('Banner URL', 'rehub_framework'),
            'param_name' => 'url',
            'value' => '',
        ),
        array(
            'type' => 'checkbox',
            'class' => '',
            'heading' => __('Enable Overlay?', 'rehub_framework'),
            'value' => array(__('Yes', 'rehub_framework') => true ),
            'param_name' => 'overlay',
        )
    )
) );

//VERSUS LINE
vc_map( array(
    'name' => __('Versus Line', 'rehub_framework'),
    'base' => 'wpsm_versus',
    'icon' => 'icon-wpsm-versus',
    "category" => __('Helper modules', 'rehub_framework'),
    'description' => __('Versus lines builder', 'rehub_framework'), 
    'params' => array(
        array(
            'type' => 'textfield',
            'heading' => __('Heading', 'rehub_framework'),
            'admin_label' => true,
            'param_name' => 'heading',
        ),           
        array(
            'type' => 'textfield',
            'heading' => __('Subheading', 'rehub_framework'),
            'admin_label' => true,
            'param_name' => 'subheading',
        ),
        array(
            'type' => 'colorpicker',
            'heading' => __( 'Background color (optional)', 'rehub_framework' ),
            'param_name' => 'bg',                 
        ), 
        array(
            'type' => 'colorpicker',
            'heading' => __( 'Text color (optional)', 'rehub_framework' ),
            'param_name' => 'color',                 
        ),
        array(
            'type' => 'dropdown',
            'class' => '',
            'heading' => __('Type', 'rehub_framework'),
            'param_name' => 'type',
            'value' => array(
                __('Two Column', 'rehub_framework') => 'two',
                __('Three Column', 'rehub_framework') => 'three',               
            ), 
        ),        
        array(
            'type' => 'dropdown',
            'class' => '',
            'heading' => __('First Column Type', 'rehub_framework'),
            'param_name' => 'firstcolumntype',
            "group" =>  __('First Column', 'rehub_framework'),
            'value' => array(
                __('Text (html and shortcode supported)', 'rehub_framework') => 'text',
                __('Image', 'rehub_framework') => 'image', 
                __('Check Icon', 'rehub_framework') => 'tick',
                __('Cross Icon', 'rehub_framework') => 'times',                                               
            ), 
        ),
        array(
            'type' => 'textfield',
            "group" =>  __('First Column', 'rehub_framework'),            
            'heading' => __('Place content or shortcode', 'rehub_framework'),
            'description' => 'Helper shortcodes: <br><br>[wpsm_custom_meta field=post_hot_count post_id=22] will get value of custom field post_hot_count from post with ID=22]<br>[wpsm_custom_meta field=brand type=attribute post_id=22] will get value of woocommerce attribute brand from product with ID=22',
            'param_name' => 'firstcolumncont',
            "dependency" => array("element" => "firstcolumntype", "value" => array("text")),             
        ),        
        array(
            'type' => 'attach_image',
            "group" =>  __('First Column', 'rehub_framework'),            
            'heading' => __('Upload Image', 'rehub_framework'),
            'param_name' => 'firstcolumnimg',
            'value' => '',
            "dependency" => array("element" => "firstcolumntype", "value" => array("image")),            
        ),
        array(
            'type' => 'checkbox',
            'class' => '',
            "group" =>  __('First Column', 'rehub_framework'),            
            'heading' => __('Make first column unhighlighted?', 'rehub_framework'),
            'value' => array(__('Yes', 'rehub_framework') => true ),
            'param_name' => 'firstcolumngrey',         
        ),  

        array(
            'type' => 'dropdown',
            'class' => '',
            "group" =>  __('Second Column', 'rehub_framework'),            
            'heading' => __('Second Column Type', 'rehub_framework'),
            'description' => 'Helper shortcodes: <br><br>[wpsm_custom_meta field=post_hot_count post_id=22] will get value of custom field post_hot_count from post with ID=22]<br>[wpsm_custom_meta field=brand type=attribute post_id=22] will get value of woocommerce attribute brand from product with ID=22',            
            'param_name' => 'secondcolumntype',
            'value' => array(
                __('Text (html and shortcode supported)', 'rehub_framework') => 'text',
                __('Image', 'rehub_framework') => 'image', 
                __('Check Icon', 'rehub_framework') => 'tick',
                __('Cross Icon', 'rehub_framework') => 'times',                                               
            ), 
        ),
        array(
            'type' => 'textfield',
            "group" =>  __('Second Column', 'rehub_framework'),            
            'heading' => __('Place content or shortcode', 'rehub_framework'),
            'param_name' => 'secondcolumncont',
            "dependency" => array("element" => "secondcolumntype", "value" => array("text")),             
        ),        
        array(
            'type' => 'attach_image',
            "group" =>  __('Second Column', 'rehub_framework'),            
            'heading' => __('Upload Image', 'rehub_framework'),
            'param_name' => 'secondcolumnimg',
            'value' => '',
            "dependency" => array("element" => "secondcolumntype", "value" => array("image")),            
        ),
        array(
            'type' => 'checkbox',
            'class' => '',
            "group" =>  __('Second Column', 'rehub_framework'),            
            'heading' => __('Make second column unhighlighted?', 'rehub_framework'),
            'value' => array(__('Yes', 'rehub_framework') => true ),
            'param_name' => 'secondcolumngrey',         
        ),


        array(
            'type' => 'dropdown',
            'class' => '',
            "group" =>  __('Third Column', 'rehub_framework'),            
            'heading' => __('Third Column Type', 'rehub_framework'),
            'description' => 'Helper shortcodes: <br><br>[wpsm_custom_meta field=post_hot_count post_id=22] will get value of custom field post_hot_count from post with ID=22]<br>[wpsm_custom_meta field=brand type=attribute post_id=22] will get value of woocommerce attribute brand from product with ID=22',            
            'param_name' => 'thirdcolumntype',
            'value' => array(
                __('Text (html and shortcode supported)', 'rehub_framework') => 'text',
                __('Image', 'rehub_framework') => 'image', 
                __('Check Icon', 'rehub_framework') => 'tick',
                __('Cross Icon', 'rehub_framework') => 'times',                                               
            ), 
            "dependency" => array("element" => "type", "value" => array("three")),            
        ),
        array(
            'type' => 'textfield',
            "group" =>  __('Third Column', 'rehub_framework'),            
            'heading' => __('Place content or shortcode', 'rehub_framework'),
            'param_name' => 'thirdcolumncont',
            "dependency" => array("element" => "thirdcolumntype", "value" => array("text")),             
        ),        
        array(
            'type' => 'attach_image',
            "group" =>  __('Third Column', 'rehub_framework'),            
            'heading' => __('Upload Image', 'rehub_framework'),
            'param_name' => 'thirdcolumnimg',
            'value' => '',
            "dependency" => array("element" => "thirdcolumntype", "value" => array("image")),            
        ),
        array(
            'type' => 'checkbox',
            "group" =>  __('Third Column', 'rehub_framework'),            
            'class' => '',
            'heading' => __('Make third column unhighlighted?', 'rehub_framework'),
            'value' => array(__('Yes', 'rehub_framework') => true ),
            'param_name' => 'thirdcolumngrey', 
            "dependency" => array("element" => "type", "value" => array("three")),                     
        ),           

    )
) );



//CUSTOM BLOCKS FOR CHILD THEMES
include ( rh_locate_template( 'functions/vc_functions_theme.php' ) );

}
?>