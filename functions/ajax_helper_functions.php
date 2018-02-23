<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php

//////////////////////////////////////////////////////////////////
// POST VIEW FUNCTION
//////////////////////////////////////////////////////////////////

if (rehub_option('post_view_disable') !='1') {
    add_action('wp_enqueue_scripts', 'rehub_postview_enqueue');
}
if (!function_exists('rehub_postview_enqueue')){
    function rehub_postview_enqueue() {
        global $post;
        if ( is_single()) {     
            wp_register_script( 'rehub-postview', get_template_directory_uri() . '/js/postviews.js', array( 'jquery' ) );
            wp_localize_script( 'rehub-postview', 'postviewvar', array('rhpost_ajax_url' => get_template_directory_uri() . '/functions/rhpostviewcounter.php', 'post_id' => intval($post->ID))); 
            wp_enqueue_script ( 'rehub-postview');      
        }
    } 
} 

//////////////////////////////////////////////////////////////////
// AJAX SEARCH
//////////////////////////////////////////////////////////////////

if (!function_exists('rehub_ajax_search')){
function rehub_ajax_search() {
    $buffer = $buffer_msg = '';

    //the search string
    if (!empty($_POST['re_string'])) {
        $re_string = $_POST['re_string'];
    } else {
        $re_string = '';
    }

    //the post types for search    
    if (!empty($_POST['posttypesearch'])) {
        $posttypes = $_POST['posttypesearch'];
        $posttypes = explode(',', $posttypes);
    } else {
        $posttypes = array('post');
    }

    //get the data
    $args = array(
        's' => $re_string,
        'post_type' => $posttypes,
        'posts_per_page' => 5,
        'post_status' => 'publish',
        'cache_results' => false,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
        'no_found_rows' => true     
    );

    if (!empty($_POST['catid'])) {
        $args['cat'] = ''.esc_html($_POST['catid']).'';
    }   

    $search_query = new WP_Query($args);

    //build the results
    if (!empty($search_query->posts)) {
        foreach ($search_query->posts as $post) {
            $the_price = '';
            $title = get_the_title( $post->ID );
            $url = get_permalink( $post->ID );
            $posttypeitem = get_post_type($post->ID);
            if($posttypeitem == 'product'){
                $the_price = get_post_meta( $post->ID, '_price', true);  
                if ( '' != $the_price ) {
                    $the_price = strip_tags( wc_price( $the_price ) );
                }                
                $terms = get_the_terms($post->ID, 'product_visibility' );
                if ( ! is_wp_error($terms) && $terms ){
                    $termnames = array();
                    foreach ($terms as $term) {
                        $termnames[] = $term->name;
                    }
                    if (in_array('exclude-from-search', $termnames)){
                        continue;
                    }
                }
            }else{
                $offer_price = get_post_meta( $post->ID, 'rehub_offer_product_price', true );
                if($offer_price){
                   $the_price = $offer_price; 
                }
            }      
            if ( has_post_thumbnail($post->ID) ){
                $image_id = get_post_thumbnail_id($post->ID);  
                $image_url = wp_get_attachment_image_src($image_id, 'med_thumbs');  
                $image_url = $image_url[0];
                $image_url = apply_filters('rh_thumb_url', $image_url );
            }
            else {
                $image_url = get_template_directory_uri() . '/images/default/noimage_123_90.png' ;
                $image_url = apply_filters('rh_no_thumb_url', $image_url, $post->ID);
            } 

            $buffer .= '<div class="re-search-result-div">';
            $buffer .= '<div class="re-search-result-thumb"><a href="'.$url.'"><img src="'.$image_url.'" alt=""/></a></div>';
            $buffer .= '<div class="re-search-result-info"><h3 class="re-search-result-title">'.rh_expired_or_not($post->ID, "span").'<a href="'.$url.'">'.$title.'</a></h3>';
            if ( empty( $post->post_excerpt ) ) {
                $buffer .= '<div class="re-search-result-excerpt">'.rehub_truncate("maxchar=150&text=$post->post_content&echo=false").'</div>';
            } else {
                $buffer .= '<div class="re-search-result-excerpt">'.rehub_truncate("maxchar=150&text=$post->post_excerpt&echo=false").'</div>'; 
            }          
            if ( '' != $the_price ) {
                $buffer .= '<span class="re-search-result-price">'.$the_price.'</span>';
                if(!empty($_POST['enable_compare'])){
                    $buffer .= '<span class="re-search-result-compare">'.do_shortcode('[wpsm_compare_button id='.$post->ID.']').'</span>';
                }                
            }
            elseif(!empty($_POST['enable_compare'])){
                $buffer .= '<span class="re-search-result-compare">'.do_shortcode('[wpsm_compare_button id='.$post->ID.']').'</span>';
            }
            else {
                $buffer .= '<span class="re-search-result-meta">'.get_the_time(get_option( 'date_format' ), $post->ID).'</span>';
            }         
            $buffer .= '</div></div>';
        }
    }

    if (count($search_query->posts) == 0) {
        //no results
        $buffer = '<div class="re-aj-search-result-msg no-result">' . __('No results', 'rehub_framework') . '</div>';
    } else {
        if(is_array($posttypes)){
            $posttypes = implode(',', $posttypes);
        }
        $buffer_msg .= '<div class="re-aj-search-result-msg"><a href="' . esc_url(home_url('/?s=' . $re_string.'&post_type='.$posttypes )) . '">' . __('View all results', 'rehub_framework') . '</a></div>';
        //add wrap
        $buffer = '<div class="re-aj-search-wrap-results">' . $buffer . '</div>' . $buffer_msg;
    }

    //prepare array for ajax
    $bufferArray = array(
        're_data' => $buffer,
        're_total_inlist' => count($search_query->posts),
        're_search_query'=> $re_string
    );

    //Return the String
    die(json_encode($bufferArray));
}
add_action( 'wp_ajax_nopriv_rehub_ajax_search', 'rehub_ajax_search' );
add_action( 'wp_ajax_rehub_ajax_search', 'rehub_ajax_search' );
}


//////////////////////////////////////////////////////////////////
// Filter ajax function
//////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_re_filterpost', 'ajax_action_re_filterpost' );
add_action( 'wp_ajax_nopriv_re_filterpost', 'ajax_action_re_filterpost' );
if( !function_exists('ajax_action_re_filterpost') ) {
function ajax_action_re_filterpost() {  

    $args = (!empty($_POST['filterargs'])) ? $_POST['filterargs'] : array();
    $innerargs = (!empty($_POST['innerargs'])) ? $_POST['innerargs'] : array();
    $offset = (!empty($_POST['offset'])) ? $_POST['offset'] : 0;
    $template = (!empty($_POST['template'])) ? $_POST['template'] : '';
    $sorttype = (!empty($_POST['sorttype'])) ? $_POST['sorttype'] : '';
    $containerid = (!empty($_POST['containerid'])) ? $_POST['containerid'] : '';
    if ($template == '') return;
    $response = $page_sorting = '';

    if ($offset !='') {$args['offset'] = $offset;}
    $offsetnext = (!empty($args['posts_per_page'])) ? (int)$offset + $args['posts_per_page'] : (int)$offset + 12;
    $perpage = (!empty($args['posts_per_page'])) ? $args['posts_per_page'] : 12;
    $args['no_found_rows'] = true;
    $args['post_status'] = 'publish';   
    if(!empty($sorttype) && is_array($sorttype)) { //if sorting panel  
        $filtertype = $filtermetakey = $filtertaxkey = $filtertaxtermslug = $filterorder = $filterdate = $filterorderby = $filterpricerange = '';
        $page_sorting = ' data-sorttype=\''.json_encode($sorttype).'\'';
        extract($sorttype);
        if(!empty($filtertype) && $filtertype =='comment') {
            $args['orderby'] = 'comment_count';
        }
        if($filtertype =='meta' && !empty($filtermetakey)) { //if meta key sorting
            $args['orderby'] = 'meta_value_num date';
            $args['meta_key'] = $filtermetakey;
        }
        if($filtertype =='expirationdate') { //if meta key sorting
            unset($args['meta_key']);
            unset($args['orderby']);            
            $args['meta_query'] = array(array(
                'key' => 'rehub_offer_coupon_date',
                'value' => date('Y-m-d'),
                'compare' => '>',
                'type' => 'DATE'
            ));
            $args['orderby'] = 'meta_value';
            $args['meta_key'] = 'rehub_offer_coupon_date';            
        }        
        if($filtertype =='pricerange' && !empty($filterpricerange)) { //if meta key sorting
            $price_range_array = array_map( 'trim', explode( "-", $filterpricerange ) );
            $keymeta = (!empty($args['post_type']) && $args['post_type']=='product') ? '_price' : 'rehub_main_product_price';
            $args['meta_query'][] = array(
                'key'     => $keymeta,
                'value'   => $price_range_array,
                'type'    => 'numeric',
                'compare' => 'BETWEEN',
            );
            if($filterorderby){
                $args['orderby'] = $filterorderby;
            }
            if ($filterorderby == 'view' || $filterorderby == 'thumb' || $filterorderby == 'discount' || $filterorderby == 'price'){
                $args['orderby'] = 'meta_value_num';
            }       
            if ($filterorderby == 'view'){
                $args['meta_key'] = 'rehub_views';
            }
            if ($filterorderby == 'thumb'){
                $args['meta_key'] = 'post_hot_count';
            }
            if ($filterorderby == 'discount'){
                $args['meta_key'] = '_rehub_offer_discount';
            }
            if ($filterorderby == 'price'){
                $args['meta_key'] = $keymeta;
            }            
        }        
        if($filtertype =='deals') { //if meta key sorting
            unset($args['meta_key']);
            unset($args['orderby']);
            $keymeta = (!empty($args['post_type']) && $args['post_type']=='product') ? 'rehub_woo_coupon_code' : 'rehub_offer_product_coupon';            
            $args['meta_query']['relation'] = 'AND';  
            $args['meta_query'][] = array(
                'key'     => $keymeta,
                'compare' => 'NOT EXISTS',
            );                
            $args['meta_query'][] = array(
                'key'     => 're_post_expired',
                'value'   => '1',
                'compare' => '!=',
            );
        }  
        if($filtertype =='sales') { //if meta key sorting
            $keymeta = (!empty($args['post_type']) && $args['post_type']=='product') ? '_sale_price' : 'rehub_offer_product_price_old';
            unset($args['meta_key']);
            unset($args['orderby']);
            $args['meta_query']['relation'] = 'AND';  
            $args['meta_query'][] = array(
                'key' => $keymeta,
                'value' => '',
                'compare' => '!=',
            );                
            $args['meta_query'][] = array(
                'key'     => 're_post_expired',
                'value'   => '1',
                'compare' => '!=',
            );
        }
        if($filtertype =='expired') { //if meta key sorting
            unset($args['meta_key']);
            unset($args['orderby']);
            $args['meta_query'][] = array(
                'key'     => 're_post_expired',
                'value'   => '1',
                'compare' => '=',
            );
        }                  
        if($filtertype =='coupons') { //if meta key sorting
            unset($args['meta_key']);
            unset($args['orderby']);            
            $args['meta_query']['relation'] = 'AND';  
            $keymeta = (!empty($args['post_type']) && $args['post_type']=='product') ? 'rehub_woo_coupon_code' : 'rehub_offer_product_coupon';
            $args['meta_query'][] = array(
                'key'     => $keymeta,
                'value' => '',
                'compare' => '!=',
            );                
            $args['meta_query'][] = array(
                'key'     => 're_post_expired',
                'value'   => '1',
                'compare' => '!=',
            );
        }              
        if($filtertype =='tax' && !empty($filtertaxkey) && !empty($filtertaxtermslug)) { //if taxonomy sorting
            if (!empty($args['tax_query'])) {
                unset($args['tax_query']);
            }  
            if(is_array($filtertaxtermslug)){
                $filtertaxtermslugarray = $filtertaxtermslug;
            }  
            else{
                $filtertaxtermslugarray = array_map( 'trim', explode( ",", $filtertaxtermslug) );
            }      
            $args['tax_query'] = array (
                array(
                    'taxonomy' => $filtertaxkey,
                    'field'    => 'slug',
                    'terms'    => $filtertaxtermslugarray,
                )
            );
        }
        if($filtertype =='hot') { //if meta key sorting
            $rehub_max_temp = (rehub_option('hot_max')) ? rehub_option('hot_max') : 50;
            $args['meta_query'] = array (
                array (
                    'key'     => 'post_hot_count',
                    'value'   => $rehub_max_temp,
                    'type'    => 'numeric',
                    'compare' => '>=',
                    )
                );
            $args['orderby'] = 'date';
        }         
        if($filterorder =='ASC') { //if ASC order
            $args['order'] = 'ASC';
        }
        if($filterdate) { //if date sorting
            if (!empty($args['date_query']) || $filterdate =='all') {
                if(isset($args['date_query'])){
                    unset($args['date_query']);
                }
            }
            if ($filterdate == 'day') {     
                $args['date_query'][] = array(
                    'after'  => '1 day ago',
                );
            }
            if ($filterdate == 'week') {    
                $args['date_query'][] = array(
                    'after'  => '7 days ago',
                );
            }   
            if ($filterdate == 'month') {     
                $args['date_query'][] = array(
                    'after'  => '1 month ago',
                );
            }   
            if ($filterdate == 'year') {     
                $args['date_query'][] = array(
                    'after'  => '1 year ago',
                );
            }
        }
    }   

    $wp_query = new WP_Query($args);
    $i=1;

    if ( $wp_query->have_posts() ) {
        while ($wp_query->have_posts() ) {
            $wp_query->the_post();
            ob_start();
            if(!empty($innerargs)) {extract($innerargs);}

            include(rh_locate_template('inc/parts/'.$template.'.php'));
            $i++;
            $response .= ob_get_clean();
        }
        wp_reset_query();
        if ($i >= $perpage){
            $response .='<div class="re_ajax_pagination"><span data-offset="'.$offsetnext.'" data-containerid="'.$containerid.'"'.$page_sorting.' class="re_ajax_pagination_btn def_btn">' . __('Next', 'rehub_framework') . '</span></div>';
        } 
    }           
    else {
        $response .= '<div class="clearfix flexbasisclear"><span class="no_more_posts">'.__('No more!', 'rehub_framework').'<span></div>';
    }       

    echo $response ;
    exit;
}
}


//////////////////////////////////////////////////////////////////
// Get full content
//////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_re_getfullcontent', 'ajax_action_re_getfullcontent' );
add_action( 'wp_ajax_nopriv_re_getfullcontent', 'ajax_action_re_getfullcontent' );
if( !function_exists('ajax_action_re_getfullcontent') ) {
function ajax_action_re_getfullcontent() {  
    $postid = intval($_POST['postid']);
    if ($postid) {
        $wp_query = new WP_Query(array('p'=>$postid, 'no_found_rows'=>1, 'ignore_sticky_posts'=>1));
        if ( $wp_query->have_posts() ) {
            while ($wp_query->have_posts() ) {
                $wp_query->the_post();
                global $post;
                
                ?>
                <article class="post"><?php echo apply_filters('the_content', $post->post_content); ?></article>;
                <?php 
                
            }
        }
        wp_reset_query();           
    }
    exit;
}
}

//////////////////////////////////////////////////////////////////
// AJAX COUPON
//////////////////////////////////////////////////////////////////

if( !function_exists('coupon_get_code') ) {
function coupon_get_code(){
    if ( 'GET' != $_SERVER['REQUEST_METHOD'] ) {
        $response = __( 'Sorry, only get method allowed', 'rehub_framework' );
        echo  $response;
        die;
    }
    $codeid = $_GET['codeid'];
    $code = get_post( $codeid );
    $shop = $thumb_enable = $printout = '';
    if( !empty( $code ) ){
        if ('product' == get_post_type($codeid)) {
            $offer_coupon = get_post_meta( $code->ID, 'rehub_woo_coupon_code', true );
            $term_ids =  wp_get_post_terms($code->ID, 'store', array("fields" => "ids")); 
            if (!empty($term_ids) && ! is_wp_error($term_ids)) {
                $term_id = $term_ids[0];
                $termobj = get_term_by('id', $term_id, 'store');
                $termname = $termobj->name;             
                $brand_url = get_term_meta( $term_id, 'brandimage', true );
                $brand_link = get_term_link( $term_id );
            }
            if (!empty ($brand_url)) {
                $term_brand_image = esc_url($brand_url);
            }   
             
            if (!empty($brand_link)){
                $shop .= '<a href="' . esc_url( $brand_link ) . '" class="shop_in_cpn">';
            }
            if (!empty($term_brand_image)) :
                $showbrandimg = new WPSM_image_resizer();
                $showbrandimg->height = '30';
                $showbrandimg->src = $term_brand_image;
                $shop .= '<img src="'.$showbrandimg->get_resized_url().'" alt="" style="max-width:100px" /> ';                                    
            endif;
            if (!empty($brand_link)){
                $shop .= $termname.'</a>';
            }

            $args = array(
                'post_type'         => 'product',
                'posts_per_page'    => 1,
                'no_found_rows'     => 1,
                'post_status'       => 'publish',
                'p'                 => $codeid,

            );          
            $products = new WP_Query( $args );
            if ( $products->have_posts() ) : while ( $products->have_posts() ) : $products->the_post();
            global $product;
            $offer_link = esc_url( $product->add_to_cart_url() );
            $offer_link = apply_filters('rh_post_offer_url_filter', $offer_link, $codeid );
            if(rehub_option('rehub_woo_print') =='1') :
                $printid = uniqid().'printid';                
                $offer_coupon_date = get_post_meta(get_the_ID(), 'rehub_woo_coupon_date', true );
                $offer_coupon = get_post_meta(get_the_ID(), 'rehub_woo_coupon_code', true );
                $offer_couponimgurl = get_post_meta(get_the_ID(), 'rehub_woo_coupon_coupon_img_url', true );
                $printout .= '<div id="printcoupon'.$printid.'" class="printmecoupondiv"><div class="printcoupon"><div class="printcouponwrap"><div class="printcouponheader"><div class="printcoupontitle">'.get_the_title().'</div>';
                $printout .= '<div class="expired_print_coupon">';
                if(!empty($offer_coupon_date)):
                    $printout .= __('Use before:', 'rehub_framework').$offer_coupon_date;
                endif;
                $printout .= '</div>';
                $printout .= '<div class="storeprint">'.$shop.'</div>';
                $printout .= '</div><div class="printcouponcentral">';
                if ($product->is_on_sale() && !$product->is_type( 'variable' ) && $product->get_regular_price() && $product->get_price() > 0 ) :
                    $printout .= '<span class="save_proc_woo_print">';   
                    $offer_price_calc = (float) $product->get_price();
                    $offer_price_old_calc = (float) $product->get_regular_price();
                    $sale_proc = 100 - ($offer_price_calc / $offer_price_old_calc) * 100; 
                    $sale_proc = round($sale_proc); 
                    $printout .= '<span class="countprintsale">'.$sale_proc.'</span><span class="procprintsale">%</span><span class="wordprintsale">'.__('Save', 'rehub_framework').'</span></span>'; 
                endif;
                $printout .= '<div class="printcoupon_wrap">'.$offer_coupon.'</div></div>';                     
                $printout .= '<div class="printcoupondesc"><div class="printimage">'.get_the_post_thumbnail( 'shop_thumbnail' ).'</div>';  
                $printout .= '<span>'.$post->post_excerpt.'</span></div>';                                              
                $printout .= '<div class="couponprintend">'.__('Get more coupons on:', 'rehub_framework').'<span> '.site_url().'</span></div></div></div>';
                if($offer_couponimgurl !='') :
                $printout .= '<div class="printcouponimg"><img src="'.esc_url($offer_couponimgurl).'" alt="Use coupon image" /></div>';
                endif ;                 
                $printout .= '</div><div class="print_coupon_icon_inside_c"><span class="printthecoupon" data-printid="'.$printid.'">'.__('Print coupon', 'rehub_framework').'</span></div>';
            endif;             
            endwhile; endif;  wp_reset_postdata();
        }
        else{
            $thumb_enable = '1';
            $offer_coupon = get_post_meta( $codeid, 'rehub_offer_product_coupon', true ); 
            $offer_link = get_post_meta( $codeid, 'rehub_offer_product_url', true );
            $offer_link = apply_filters('rh_post_offer_url_filter', $offer_link, $codeid );
            $term_ids =  wp_get_post_terms($code->ID, 'dealstore', array("fields" => "ids")); 
            if (!empty($term_ids) && ! is_wp_error($term_ids)) {
                $term_id = $term_ids[0];
                $termobj = get_term_by('id', $term_id, 'dealstore');
                $termname = $termobj->name;             
                $brand_url = get_term_meta( $term_id, 'brandimage', true );
                $brand_link = get_term_link( $term_id );
            }
            if (!empty ($brand_url)) {
                $term_brand_image = esc_url($brand_url);
            }   
             
            if (!empty($brand_link)){
                $shop .= '<a href="' . esc_url( $brand_link ) . '" class="shop_in_cpn">';
            }
            if (!empty($term_brand_image)) :
                $showbrandimg = new WPSM_image_resizer();
                $showbrandimg->height = '30';
                $showbrandimg->src = $term_brand_image;
                $shop .= '<img src="'.$showbrandimg->get_resized_url().'" alt="" /> ';                                    
            endif;
            if (!empty($brand_link)){
                $shop .= $termname.'</a>';
            }           
        } 
         
        $offer_coupon_clicks = get_post_meta( $code->ID, 'rehub_offer_clicks_count', true );
        if (empty($offer_coupon_clicks)){$offer_coupon_clicks = 0;}
        $offer_coupon_clicks = $offer_coupon_clicks + 1;
        update_post_meta($code->ID, 'rehub_offer_clicks_count', $offer_coupon_clicks);

        $response = '<div class="coupon_code_in_modal"><div class="re_title_inmodal">'.__('Here is your coupon code', 'rehub_framework').'</div>';
        $response .= '<div class="add_modal_coupon"><span class="text_copied_coupon">'.__('Code is copied. ', 'rehub_framework').'</span> <a href="'.$offer_link.'" target="_blank" rel="nofollow">'.__('Use code on page', 'rehub_framework').'</a> '.__('at checkout.', 'rehub_framework').'</div>';      

        $response .= '<div class="coupon_modal_coupon"><input type="text" class="code" value="'.$offer_coupon.'" readonly=""><span class="buttoncpd"><i class="fa fa-check-square"></i></span></div>';
        $response .= $printout;
        $response .= '<div class="cpn_info">';
        $response .= '<div class="cpn_post_title">'.get_the_title($code->ID).$shop.'</div>';
        $response .='<div class="thumb_in_modalcoupon">'.getHotThumb($codeid, false, true).'</div>';
        $response .='</div>';
        if(rehub_option('rehub_ads_coupon_area') !=''){
            $response .='<div class="mt25 rh-line"></div><div class="coupon_custom_code_area">'.do_shortcode(rehub_option('rehub_ads_coupon_area')).'</div>';

        }

        $response .='</div>';
        $response .='</div>';
    }
    else{
        $response = __( 'Offer does not exists', 'rehub_framework' );
    }

    echo  $response ;
die();
}
}
add_action('wp_ajax_ajax_code', 'coupon_get_code');
add_action('wp_ajax_nopriv_ajax_code', 'coupon_get_code');


//////////////////////////////////////////////////////////////////
// Frontend deal submit
//////////////////////////////////////////////////////////////////

if( !function_exists('rh_ajax_action_send_offer') ) {
    function rh_ajax_action_send_offer() {
        
        if ( empty($_POST) || !wp_verify_nonce($_POST['offer_nonce'], 'rh_ajax_action_send_offer') ) {
            die('Sorry, but the inspection data is not match.');
            exit;
           
        } else {
            $postid = intval( $_POST['post_id'] );
            $from_user = intval( $_POST['from_user'] );
            $product_name = sanitize_text_field( $_POST['rehub_product_name'] );
            $product_url = esc_url( $_POST['rehub_product_url'] );
            $product_price = sanitize_text_field( $_POST['rehub_product_price'] );
            $product_desc = sanitize_text_field( $_POST['rehub_product_desc'] );
            
            $set_user_offer_array = array(
                'show_offer' => 0,
                'featured_multioffer' => 0,
                'multioffer_url' => $product_url,
                'multioffer_name' => $product_name,
                'multioffer_desc' => $product_desc,
                'multioffer_price_old' => '',
                'multioffer_price' => $product_price,
                'multioffer_coupon' => '',
                'multioffer_date' => '',
                'multioffer_btn_text' => '',
                'multioffer_user' => $from_user,
                'offer_assign'=> 'user'
            );
            
            $offer_group_array = (array)get_post_meta( $postid, 'rehub_multioffer_group', true );
            $multioffer_names = array();
            if (!empty($offer_group_array)){
                $multioffer_names = wp_list_pluck( $offer_group_array, 'multioffer_user' );
                if (true === in_array($from_user, $multioffer_names)){
                    return;
                }                
            }
            
            if( !empty($offer_group_array)) {
                if( array_filter($offer_group_array[0]) ) {
                     array_unshift( $offer_group_array, $set_user_offer_array );
                } else {
                    $offer_group_array[0] = $set_user_offer_array;
                }
            } else {
                $offer_group_array[] = $set_user_offer_array;
            }
            $postarray = array('rehub_multioffer_group', '_multioffer_shortcode');
            update_post_meta( $postid, 'post_rehub_offers_fields', $postarray);            
            update_post_meta( $postid, 'rehub_multioffer_group', $offer_group_array );
            $emailto = get_option('admin_email');
            $subject = __('Someone added offer in your post', 'rehub_framework');
            $message = '';
            $user_info = get_userdata($from_user);
            if ($user_info && $emailto){
                $message .=  $user_info->user_login;
                $message .= __(' added offer in you post: ', 'rehub_framework');
                $message .= '<a href="'.get_admin_url().'post.php?post='.$postid.'&action=edit">'.get_the_title($postid).'</a>';
                $message .= get_the_title($postid);
                $mail = wp_mail($emailto, $subject, $message);
            }
            
        }
        exit;
    }
    add_action( 'wp_ajax_rh_ajax_action_send_offer', 'rh_ajax_action_send_offer' );
    add_action( 'wp_ajax_nopriv_rh_ajax_action_send_offer', 'rh_ajax_action_send_offer' );
}