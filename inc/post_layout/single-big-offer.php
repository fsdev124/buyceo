<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<!-- CONTENT -->
<div class="rh-container"> 
    <div class="rh-content-wrap clearfix">
	    <!-- Main Side -->
        <div class="main-side single<?php if(get_post_meta($post->ID, 'post_size', true) == 'full_post') : ?> full_width<?php endif; ?> clearfix">            
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <article class="post post-inner <?php $category = get_the_category($post->ID); if ($category) {$first_cat = $category[0]->term_id; echo 'category-'.$first_cat.'';} ?><?php echo rh_expired_or_not($post->ID, 'class');?>" id="post-<?php the_ID(); ?>">               
                        <div class="rh_post_layout_big_offer">
                            <div class="title_single_area">
                                <?php if(rehub_option('compare_btn_single') !='' && is_singular('post')) :?>
                                    <?php $cmp_btn_args = array();?>
                                    <?php if(rehub_option('compare_btn_cats') != '') {
                                        $cmp_btn_args['cats'] = esc_html(rehub_option('compare_btn_cats'));
                                    }?>
                                    <div class="floatright ml10">
                                        <?php echo wpsm_comparison_button($cmp_btn_args); ?>
                                    </div> 
                                <?php endif;?>                            
                                <?php 
                                    $crumb = '';
                                    if( function_exists( 'yoast_breadcrumb' ) ) {
                                        $crumb = yoast_breadcrumb('<div class="breadcrumb">','</div>', false);
                                    }
                                    if( ! is_string( $crumb ) || $crumb === '' ) {
                                        if(rehub_option('rehub_disable_breadcrumbs') == '1' || vp_metabox('rehub_post_side.disable_parts') == '1') {echo '';}
                                        elseif (function_exists('dimox_breadcrumbs')) {
                                            dimox_breadcrumbs(); 
                                        }
                                    }
                                    echo $crumb;  
                                ?> 
                                <?php echo re_badge_create('labelsmall'); ?><?php rh_post_header_cat('post', true);?>
                            </div>

                            <?php   
                            $offer_post_url = get_post_meta( $post->ID, 'rehub_offer_product_url', true );
                            $offer_post_url = apply_filters('rehub_create_btn_url', $offer_post_url);
                            $offer_url = apply_filters('rh_post_offer_url_filter', $offer_post_url );
                            $offer_price = get_post_meta( $post->ID, 'rehub_offer_product_price', true );
                            $offer_price = apply_filters('rehub_create_btn_price', $offer_price);
                            $offer_title = get_post_meta( $post->ID, 'rehub_offer_name', true );
                            $offer_thumb = get_post_meta( $post->ID, 'rehub_offer_product_thumb', true );
                            $offer_btn_text = get_post_meta( $post->ID, 'rehub_offer_btn_text', true );
                            $offer_price_old = get_post_meta( $post->ID, 'rehub_offer_product_price_old', true );
                            $offer_price_old = apply_filters('rehub_create_btn_price_old', $offer_price_old);
                            $offer_coupon = get_post_meta( $post->ID, 'rehub_offer_product_coupon', true );
                            $offer_coupon_date = get_post_meta( $post->ID, 'rehub_offer_coupon_date', true );
                            $offer_coupon_mask = get_post_meta( $post->ID, 'rehub_offer_coupon_mask', true );
                            $offer_desc = get_post_meta( $post->ID, 'rehub_offer_product_desc', true );                   
                            ?>  

                            <?php $coupon_style = $expired = ''; if(!empty($offer_coupon_date)) : ?>
                                <?php
                                    $timestamp1 = strtotime($offer_coupon_date) + 86399;
                                    $seconds = $timestamp1 - (int)current_time('timestamp',0);
                                    $days = floor($seconds / 86400);
                                    $seconds %= 86400;
                                    if ($days > 0) {
                                        $coupon_text = $days.' '.__('days left', 'rehub_framework');
                                        $coupon_style = '';
                                    }
                                    elseif ($days == 0){
                                        $coupon_text = __('Last day', 'rehub_framework');
                                        $coupon_style = '';
                                    }
                                    else {
                                        $coupon_text = __('Expired', 'rehub_framework');
                                        $coupon_style = ' expired_coupon';
                                        $expired = '1';
                                    }
                                ?>
                            <?php endif ;?> 
                            <?php do_action('post_change_expired', $expired); //Here we update our expired?>
                            <?php $coupon_mask_enabled = (!empty($offer_coupon) && ($offer_coupon_mask =='1' || $offer_coupon_mask =='on') && $expired!='1') ? '1' : ''; ?> 
                            <?php $reveal_enabled = ($coupon_mask_enabled =='1') ? ' reveal_enabled' : '';?>
                            <?php $outsidelinkpart = ($coupon_mask_enabled=='1') ? 'data-codeid="'.$post->ID.'" data-dest="'.$offer_url.'" data-clipboard-text="'.$offer_coupon.'" class="masked_coupon"' : '';?>                    
                            <div class="rh_post_layout_compare_holder mb25 <?php echo $reveal_enabled; echo $coupon_style; ?>">
                                <?php if(vp_metabox('rehub_post_side.show_featured_image') != '1')  : ?>
                                    <div class="featured_compare_left">
                                        <figure>                                 
                                                <?php   
                                                if(!empty($offer_price_old)){
                                                    if ( !empty($offer_price)) {
                                                        $offer_pricesale = rehub_price_clean($offer_price); //Clean price from currence symbols
                                                        $offer_priceold = rehub_price_clean($offer_price_old); //Clean price from currence symbols
                                                        if ((int)$offer_priceold !='0' && is_numeric($offer_priceold) && (int)$offer_priceold > (int)$offer_pricesale) {
                                                            $off_proc = 0 -(100 - ((int)$offer_pricesale / (int)$offer_priceold) * 100);
                                                            $off_proc = round($off_proc);
                                                            echo '<span class="sale_a_proc">'.$off_proc.'%</span>';
                                                        }
                                                    }
                                                }?>                                   
                                            <a href="<?php echo $offer_url ?>" target="_blank" rel="nofollow" class="re_track_btn" <?php echo $outsidelinkpart;?>>
                                                <?php if ( has_post_thumbnail()) :?>
                                                    <?php WPSM_image_resizer::show_static_resized_image(array('lazy'=> true, 'thumb'=> true, 'crop'=> false, 'height'=> 500, 'width'=> 500));?>                                            
                                                <?php elseif(!empty($offer_thumb)) :?>
                                                    <?php WPSM_image_resizer::show_static_resized_image(array('lazy'=> true, 'src'=> $offer_thumb, 'crop'=> false, 'height'=> 500, 'width'=> 500));?>
                                                <?php endif ;?>
                                            </a>
                                        </figure>
                                        <div class="compare-full-images">  
                                            <?php echo rh_get_post_thumbnails(array('video'=>1, 'columns'=>4, 'height'=>60));?>
                                        </div>                                                                    
                                    </div>
                                <?php endif;?>
                                <div class="single_compare_right">
                                    <div class="title_single_area">
                                    <h1>
                                        <?php the_title(); ?>                           
                                    </h1> 
                                    </div>                                                      
                                    <div class="offer-box-price">
                                        <h5>
                                            <?php echo esc_html($offer_price) ?>
                                            <?php if($offer_price_old !='') :?>
                                            <span class="retail-old">
                                                <strike><span class="value"><?php echo esc_html($offer_price_old) ; ?></span></strike>
                                            </span>
                                            <?php endif;?>                                                                    
                                        </h5>                                               
                                    </div>
                                    <?php $itemsync = ''; if (rh_is_plugin_active('content-egg/content-egg.php')) :?>
                                        <?php $unique_id =  get_post_meta($post->ID, '_rehub_product_unique_id', true);?>
                                        <?php $module_id = get_post_meta($post->ID, '_rehub_module_ce_id', true);?>
                                        <?php if($unique_id && $module_id):?>
                                            <?php $itemsync = \ContentEgg\application\components\ContentManager::getProductbyUniqueId($unique_id, $module_id, $post->ID);?>
                                        <?php endif;?>
                                    <?php endif;?>                                    
                                    <?php if (!empty($itemsync)):?>
                                        <?php echo rh_best_syncpost_deal($itemsync);?>                                  
                                    <?php else :?>                            
                                        <div class="brand_logo_small"> 
                                            <?php WPSM_Postfilters::re_show_brand_tax('logo'); //show brand logo?>
                                        </div>
                                    <?php endif;?>                                
                                    <?php if($offer_url):?>                            
                                    <div class="buttons_col mb25">
                                        <div class="priced_block clearfix">
                                            <?php if ($coupon_mask_enabled =='1') :?>
                                                <?php wp_enqueue_script('zeroclipboard'); ?>
                                                <a class="coupon_btn mb15 re_track_btn btn_offer_block rehub_offer_coupon masked_coupon <?php if(!empty($offer_coupon_date)) {echo $coupon_style ;} ?>" <?php echo $outsidelinkpart;?>>
                                                    <?php if($offer_btn_text !='') :?>
                                                        <?php echo esc_html ($offer_btn_text) ; ?>
                                                    <?php elseif(rehub_option('rehub_mask_text') !='') :?>
                                                        <?php echo rehub_option('rehub_mask_text') ; ?>
                                                    <?php else :?>
                                                        <?php _e('Reveal coupon', 'rehub_framework') ?>
                                                    <?php endif ;?>                 
                                                </a>
                                            <?php else :?>
                                                <?php if(!empty($offer_coupon)) : ?>
                                                    <?php wp_enqueue_script('zeroclipboard'); ?>
                                                    <div class="rehub_offer_coupon mb15px not_masked_coupon <?php if(!empty($offer_coupon_date)) {echo $coupon_style ;} ?>" data-clipboard-text="<?php echo $offer_coupon ?>"><i class="fa fa-scissors fa-rotate-180"></i><span class="coupon_text"><?php echo $offer_coupon ?></span>
                                                    </div>
                                                <?php endif;?>
                                            <?php endif;?>                                 
                                            <div>
                                                <a class="re_track_btn btn_offer_block" href="<?php echo esc_url ($offer_url) ?>" target="_blank" rel="nofollow" <?php echo $outsidelinkpart;?>>
                                                    <?php if($offer_btn_text !='') :?>
                                                        <?php echo $offer_btn_text ; ?>
                                                    <?php elseif(rehub_option('rehub_btn_text') !='') :?>
                                                        <?php echo rehub_option('rehub_btn_text') ; ?>
                                                    <?php else :?>
                                                        <?php _e('Buy this item', 'rehub_framework') ?>
                                                    <?php endif ;?>
                                                </a>                                                
                                            </div>
                                        </div>
                                    </div>  
                                    <?php endif;?>
                                    <?php if(!empty($offer_coupon_date)) {echo '<div class="time_offer">'.$coupon_text.'</div>';} ?>
                                    <p class="big-offer-desc"><?php echo wp_kses_post($offer_desc);  ?></p>
                                    <?php if(rehub_option('rehub_disable_share_top') =='1' || vp_metabox('rehub_post_side.disable_parts') == '1')  : ?>
                                    <?php else :?>
                                        <div class="top_share notextshare"><?php include(rh_locate_template('inc/parts/post_share.php')); ?></div>
                                        <div class="clearfix"></div> 
                                    <?php endif; ?>                                                                  
                                </div>                    
                            </div>   
                            <div class="meta post-meta-big">
                                <?php rh_post_header_meta_big();?> 
                            </div>
                        </div>             
                    <?php $no_featured_image_layout = 1;?>
                    <?php include(rh_locate_template('inc/parts/top_image.php')); ?>                                                        

                    <?php if(rehub_option('rehub_single_before_post') && vp_metabox('rehub_post_side.show_banner_ads') != '1') : ?><div class="mediad mediad_before_content"><?php echo do_shortcode(rehub_option('rehub_single_before_post')); ?></div><?php endif; ?>

                    <?php the_content(); ?>

                </article>
                <div class="clearfix"></div>
                <?php include(rh_locate_template('inc/post_layout/single-common-footer.php')); ?>                    
            <?php endwhile; endif; ?>
            <?php comments_template(); ?>
		</div>	
        <!-- /Main Side -->  
        <!-- Sidebar -->
        <?php if(get_post_meta($post->ID, 'post_size', true) == 'full_post') : ?><?php else : ?><?php get_sidebar(); ?><?php endif; ?>
        <!-- /Sidebar -->
    </div>
</div>
<!-- /CONTENT -->     