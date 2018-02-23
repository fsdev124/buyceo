<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php global $product; global $post;?>
<?php if (rh_is_plugin_active('content-egg/content-egg.php')):?>
    <?php $itemsync = \ContentEgg\application\WooIntegrator::getSyncItem($post->ID);?>
    <?php $unique_id = $module_id = $domain = $merchant = $syncitem = '';?>
    <?php if(!empty($itemsync)):?>
        <?php 
            $unique_id = $itemsync['unique_id']; 
            $module_id = $itemsync['module_id'];
            $domain = $itemsync['domain']; 
            $merchant = $itemsync['merchant'];                            
            $syncitem = $itemsync;                            
        ?>
    <?php endif;?>
<?php endif;?>
<?php if (rh_is_plugin_active('content-egg/content-egg.php') && !empty($itemsync)) :?>
<!-- CONTENT -->
<div class="rh-container"> 
    <div class="rh-content-wrap clearfix">
        <!-- Main Side -->
        <div class="main-side page clearfix ce_woo_list full_width" id="content">
            <div class="post">  
                <?php do_action( 'woocommerce_before_main_content' );?>            
                <?php woocommerce_breadcrumb();?>
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php
                        do_action( 'woocommerce_before_single_product' );
                        if ( post_password_required() ) {
                            echo get_the_password_form();
                            return;
                        }
                    ?> 
                    <div id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <?php wp_enqueue_script('stickysidebar');?>
                        <div class="rh-stickysidebar-wrapper">

                            <div class="woo-image-part wpsm-one-half rh-sticky-container modulo-lightbox tabletblockdisplay">
                                <?php 
                                    wp_enqueue_script('modulobox');
                                    wp_enqueue_style('modulobox');
                                ?>                                                         
                                <figure>
                                    <?php woocommerce_show_product_sale_flash();?>
                                    <?php           
                                        $image_id = get_post_thumbnail_id($post->ID);  
                                        $image_url = wp_get_attachment_image_src($image_id,'full');
                                        $image_url = $image_url[0]; 
                                    ?> 
                                    <a data-rel="rh_top_gallery" href="<?php echo $image_url;?>" target="_blank" data-thumb="<?php echo $image_url;?>">            
                                        <?php WPSM_image_resizer::show_static_resized_image(array('lazy'=>true, 'thumb'=> true, 'crop'=> false, 'height'=> 500, 'no_thumb_url' => get_template_directory_uri() . '/images/default/noimage_500_500.png'));?>
                                    </a>
                                </figure>
                                <?php $post_image_gallery = $product->get_gallery_image_ids();?>
                                <?php if(!empty($post_image_gallery)) :?> 
                                    <div class="five-thumbnails rh-flex-eq-height rh_mini_thumbs compare-full-thumbnails mt15 mb25">
                                        <?php foreach($post_image_gallery as $key=>$image_gallery):?>
                                            <?php if(!$image_gallery) continue;?>
                                            <a data-rel="rh_top_gallery" data-thumb="<?php echo wp_get_attachment_url($image_gallery);?>" href="<?php echo wp_get_attachment_url($image_gallery);?>" target="_blank" class="mb10" data-title="<?php echo esc_attr(get_post_field( 'post_excerpt', $image_gallery));?>"> 
                                                <?php WPSM_image_resizer::show_static_resized_image(array('lazy'=>false, 'src'=> wp_get_attachment_url($image_gallery), 'crop'=> false, 'height'=> 60));?>
                                            </a>                               
                                        <?php endforeach;?>                         
                                    </div>                                      
                                <?php else :?>
                                    <?php if (!empty($itemsync['extra']['imageSet'])){
                                        $ceimages = $itemsync['extra']['imageSet'];
                                    }elseif (!empty($itemsync['extra']['images'])){
                                        $ceimages = $itemsync['extra']['images'];
                                    }
                                    else {
                                        $qwantimages = \ContentEgg\application\components\ContentManager::getViewData('GoogleImages', $post->ID);
                                        if(!empty($qwantimages)) {
                                            $ceimages = wp_list_pluck( $qwantimages, 'img' );
                                        }else{
                                            $ceimages = '';                                                
                                        } 
                                    } ?> 
                                    <?php if(!empty($ceimages)):?>
                                        <div class="five-thumbnails rh_mini_thumbs compare-full-thumbnails limited-thumb-number mt15 mb25">
                                            <?php foreach ($ceimages as $key => $gallery_img) :?>
                                                <?php if (isset($gallery_img['LargeImage'])){
                                                    $image = $gallery_img['LargeImage'];
                                                }else{
                                                    $image = $gallery_img;
                                                }?>                                               
                                                <a data-thumb="<?php echo $image?>" data-rel="rh_top_gallery" href="<?php echo $image; ?>" data-title="<?php echo  $itemsync['title'];?>"> 
                                                    <?php WPSM_image_resizer::show_static_resized_image(array('src'=> $image, 'height'=> 65, 'title' => $itemsync['title'], 'no_thumb_url' => get_template_directory_uri().'/images/default/noimage_100_70.png'));?>  
                                                </a>
                                            <?php endforeach;?>     
                                        </div>
                                    <?php endif;?>                
                                <?php endif;?>
                                <div class="re_wooinner_info mb20">
                                    <?php rh_woo_code_zone('content');?>
                                    <?php if(has_excerpt($post->ID)):?>
                                        <?php woocommerce_template_single_excerpt();?>
                                    <?php else :?>
                                        <?php if(!empty($itemsync['extra']['itemAttributes']['Feature'])){
                                            $features = $itemsync['extra']['itemAttributes']['Feature'];
                                        }
                                        elseif(!empty($itemsync['extra']['keySpecs'])){
                                            $features = $itemsync['extra']['keySpecs'];
                                        }
                                        ?> 
                                        <?php if (!empty ($features)) :?>
                                            <ul class="featured_list">
                                                <?php $length = $maxlength = 0;?>
                                                <?php foreach ($features as $k => $feature): ?>
                                                    <?php if(is_array($feature)){continue;}?>
                                                    <?php $length = strlen($feature); $maxlength += $length; ?> 
                                                    <li><?php echo $feature; ?></li>
                                                    <?php if($k >= 5 || $maxlength > 200) break; ?>                             
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php else:?>
                                            <?php echo do_shortcode('[content-egg-block template=price_statistics]');?>
                                        <?php endif ;?> 
                                        <div class="clearfix"></div>                               
                                    <?php endif;?>
                                    <?php
                                        /**
                                         * woocommerce_single_product_summary hook. was removed in theme and added as functions directly in layout
                                         *
                                         * @dehooked woocommerce_template_single_title - 5
                                         * @dehooked woocommerce_template_single_rating - 10
                                         * @dehooked woocommerce_template_single_price - 10
                                         * @dehooked woocommerce_template_single_excerpt - 20
                                         * @dehooked woocommerce_template_single_add_to_cart - 30
                                         * @dehooked woocommerce_template_single_meta - 40
                                         * @dehooked woocommerce_template_single_sharing - 50
                                         * @hooked WC_Structured_Data::generate_product_data() - 60
                                         */
                                        do_action( 'woocommerce_single_product_summary' );
                                    ?>              
                                    <div class="mb20">
                                        <?php woocommerce_template_single_meta();?>
                                    </div>
                                    <?php woocommerce_template_single_sharing();?>
                                </div>
                            </div>

                            <div class="tabletblockdisplay wpsm-column-last wpsm-one-half summary entry-summary rh-sticky-container">
                                <div class="mb10">
                                    <?php woocommerce_template_single_title();?>
                                    <?php woocommerce_template_single_rating();?>            
                                </div>
                                <div class="woo-button-actions-area mb30">
                                    <?php $wishlistadd = __('Add to wishlist', 'rehub_framework');?>
                                    <?php $wishlistadded = __('Added to wishlist', 'rehub_framework');?>
                                    <?php $wishlistremoved = __('Removed from wishlist', 'rehub_framework');?>
                                    <?php echo getHotThumb($post->ID, false, false, true, $wishlistadd, $wishlistadded, $wishlistremoved);?>  
                                    <?php if(rehub_option('woo_rhcompare') == 1) {echo wpsm_comparison_button(array('class'=>'rhwoosinglecompare'));} ?>
                                                                   
                                    <?php if ($unique_id && $module_id && !empty($syncitem)) :?>
                                        <div class="floatleft ml10 font90 pricehw">
                                        <?php include(rh_locate_template( 'inc/parts/pricehistorypopup.php' ) ); ?>
                                        </div>
                                    <?php endif;?>
                                </div> 
                                <div class="clearfix"></div>
                                <?php rh_woo_code_zone('button');?>                            
                                <div class="woo-ce-list-area">
                                    <div class="rh-tabletext-block">
                                    <div class="rh-tabletext-block-heading no-border"><span class="toggle-this-table"></span><h4><?php _e('Price list', 'rehub_framework');?></h4></div>
                                    <?php echo do_shortcode('[content-egg-block template=custom/all_offers_logo]' );?>
                                    </div>
                                </div> 
                                <?php echo do_shortcode('[content-egg-block template=custom/all_pricealert_full]' );?>
                            </div>

                        </div>

                        <?php wp_enqueue_script('customfloatpanel');?> 
                        <div class="flowhidden rh-float-panel" id="float-panel-woo-area">
                            <div class="rh-container rh-flex-center-align pt10 pb10">
                                <div class="float-panel-woo-image">
                                    <?php WPSM_image_resizer::show_static_resized_image(array('lazy'=>false, 'thumb'=> true, 'width'=> 50, 'height'=> 50));?>
                                </div>
                                <div class="float-panel-woo-info wpsm_pretty_colored rh-line-left pl15 ml15">
                                    <div class="float-panel-woo-title rehub-main-font mb5 font110">
                                        <?php the_title();?>
                                    </div>
                                    <?php echo rh_best_syncpost_deal($itemsync, 'mb10 compare-domain-icon', false);?>                                   
                                </div>
                                <div class="float-panel-woo-btn rh-flex-columns rh-flex-right-align">
                                    <div class="float-panel-woo-price rh-flex-center-align rh-flex-right-align font120">
                                        <?php woocommerce_template_single_price();?>
                                    </div>
                                    <div class="float-panel-woo-button rh-flex-center-align rh-flex-right-align">
                                        <a href="#top_ankor" class="single_add_to_cart_button rehub_scroll">
                                            <?php if(rehub_option('rehub_btn_text_aff_links') !='') :?>
                                                <?php echo rehub_option('rehub_btn_text_aff_links') ; ?>
                                            <?php else :?>
                                                <?php _e('Choose offer', 'rehub_framework') ?>
                                            <?php endif ;?>
                                        </a>              
                                    </div>                                        
                                </div>                                    
                            </div>                           
                        </div>
                        <div class="clearfix"></div>
                        <?php 
                            $tabs = apply_filters( 'woocommerce_product_tabs', array() );
                            $youtubecontent = \ContentEgg\application\components\ContentManager::getViewData('Youtube', $post->ID);
                            $googlenews = get_post_meta($post->ID, '_cegg_data_GoogleNews', true);                            
                            if(!empty($youtubecontent)){
                                $tabs['woo-ce-videos'] = array(
                                    'title' => __('Videos', 'rehub_framework'),
                                    'priority' => '21',
                                    'callback' => 'woo_ce_video_output'
                                );
                            } 
                            if(!empty($googlenews)){
                                $tabs['woo-ce-news'] = array(
                                    'title' => __('News', 'rehub_framework'),
                                    'priority' => '23',
                                    'callback' => 'woo_ce_news_output'
                                );
                            }                             
                            uasort( $tabs, '_sort_priority_callback' );                             
                        ?> 
                        <?php if ( ! empty( $tabs ) ) : ?>                        
                            <div id="contents-section-woo-area" class="flowhidden">
                                <div class="clearfix border-lightgrey <?php if ( is_active_sidebar( 'sidebarwooinner' ) ) : ?>tabletblockdisplay rh-300-content-area floatleft<?php else:?>woo_default_no_sidebar<?php endif; ?>">

                                    <div class="woocommerce-tabs wc-tabs-wrapper">
                                        <ul class="tabs wc-tabs wc-tabs-light" role="tablist">
                                            <?php foreach ( $tabs as $key => $tab ) : ?>
                                                <li class="<?php echo esc_attr( $key ); ?>_tab" id="tab-title-<?php echo esc_attr( $key ); ?>" role="tab" aria-controls="tab-<?php echo esc_attr( $key ); ?>">
                                                    <a href="#tab-<?php echo esc_attr( $key ); ?>"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?></a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                        <?php foreach ( $tabs as $key => $tab ) : ?>
                                            <div class="woocommerce-Tabs-panel padd20 woocommerce-Tabs-panel--<?php echo esc_attr( $key ); ?> panel entry-content wc-tab" id="tab-<?php echo esc_attr( $key ); ?>" role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr( $key ); ?>">
                                                <?php call_user_func( $tab['callback'], $key, $tab ); ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    
                                </div>

                                <?php if ( is_active_sidebar( 'sidebarwooinner' ) ) : ?>
                                    <aside class="rh-300-sidebar tabletblockdisplay floatright">            
                                        <?php dynamic_sidebar( 'sidebarwooinner' ); ?>      
                                    </aside> 
                                <?php endif; ?> 

                            </div>
                        <?php endif; ?>                       

                        <?php
                            /**
                             * woocommerce_after_single_product_summary hook.
                             *
                             * @hooked woocommerce_output_product_data_tabs - 10
                             * @hooked woocommerce_upsell_display - 15
                             * @hooked woocommerce_output_related_products - 20
                             */
                            do_action( 'woocommerce_after_single_product_summary' );
                        ?>
                    </div><!-- #product-<?php the_ID(); ?> -->

                    <?php do_action( 'woocommerce_after_single_product' ); ?>
                <?php endwhile; // end of the loop. ?> 
                <?php do_action( 'woocommerce_after_main_content' ); ?>                                                 
            </div>
        </div>  
        <!-- /Main Side --> 

    </div>
</div>
<!-- /CONTENT --> 
<!-- Related -->
<?php include(rh_locate_template( 'woocommerce/single-product/full-width-related.php' ) ); ?>                       
<!-- /Related -->

<!-- Upsell -->
<?php include(rh_locate_template( 'woocommerce/single-product/full-width-upsell.php' ) ); ?> 
<!-- /Upsell -->
<?php else:?>
    <?php echo '<div class="rh-container"><div class="rh-content-wrap clearfix">';echo 'This product layout requires Content Egg Plugin to be active and Product must have Content Egg offers'; echo '</div></div>';?>
<?php endif;?>   
<?php rh_woo_code_zone('bottom');?>