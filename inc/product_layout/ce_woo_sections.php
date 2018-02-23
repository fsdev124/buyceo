<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php global $product, $post;?>
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
        <div class="ce_woo_auto ce_woo_auto_sections full_width" id="content">
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
                        <div class="rh_post_layout_compare_full padd20">
                            <div class="wpsm-one-third wpsm-column-first tabletblockdisplay compare-full-images modulo-lightbox">
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
                                        <?php WPSM_image_resizer::show_static_resized_image(array('lazy'=>true, 'thumb'=> true, 'crop'=> false, 'height'=> 350, 'no_thumb_url' => get_template_directory_uri() . '/images/default/noimage_500_500.png'));?>
                                    </a>
                                </figure>
                                <?php $post_image_gallery = $product->get_gallery_image_ids();?>
                                <?php if(!empty($post_image_gallery)) :?> 
                                    <div class="rh-flex-eq-height rh_mini_thumbs compare-full-thumbnails mt15 mb15">
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
                                        <div class="rh_mini_thumbs compare-full-thumbnails limited-thumb-number mt15 mb15">
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
                            </div>
                            <div class="wpsm-two-third tabletblockdisplay wpsm-column-last">
                                <div class="title_single_area">
                                <h1 class="<?php if(rehub_option('hotmeter_disable') !='1') :?><?php echo getHotIconclass($post->ID); ?><?php endif ;?>"><?php the_title(); ?></h1>
                                </div>
                                <div class="meta-in-compare-full rh-flex-center-align">
                                    <div class="floatleft mr10"><?php woocommerce_template_single_rating();?></div>
                                    <span class="floatleft meta post-meta mt0 mb0">
                                        <?php
                                        $categories = wp_get_post_terms($post->ID, 'product_cat', array("fields" => "all"));
                                        $separator = '';
                                        $output = '';
                                        if ( ! empty( $categories ) ) {
                                            foreach( $categories as $category ) {
                                                $output .= '<a class="mr5 ml5 rh-cat-'.$category->term_id.'" href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . esc_attr( sprintf( __( 'View all posts in %s', 'rehub_framework' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a>' . $separator;
                                            }
                                            echo trim( $output, $separator );
                                        }
                                        ?>                                     
                                    </span>
                                    <span class="rh-flex-right-align">
                                        <?php if(rehub_option('woo_rhcompare') == 1) {echo wpsm_comparison_button(array('class'=>'rhwoosinglecompare'));} ?>                   
                                    </span>
                                </div>                
                                <div class="wpsm-one-half wpsm-column-first">
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


                                    <div class="compare-button-holder">
                                        <?php if (!empty($itemsync)):?>
                                            <?php woocommerce_template_single_price();?>
                                            <?php echo rh_best_syncpost_deal($itemsync, 'mb10 compare-domain-icon', true);?>
                                            <?php $offer_post_url = $itemsync['url'] ;?>
                                            <?php $afflink = apply_filters('rh_post_offer_url_filter', $offer_post_url );?>                                            
                                            <?php $buy_best_text = (rehub_option('buy_best_text') !='') ? esc_html(rehub_option('buy_best_text')) : __('Buy for best price', 'rehub_framework'); ?>                        
                                            <a href="<?php echo esc_url($afflink);?>" class="re_track_btn wpsm-button rehub_main_btn btn_offer_block" target="_blank" rel="nofollow"><?php echo $buy_best_text;?>
                                            </a>            
                                        <?php endif;?>                
                                    </div>
                                </div>
                                <div class="wpsm-one-half wpsm-column-last summary"> 
                                    <?php echo do_shortcode('[content-egg-block template=custom/all_merchant_widget]');?>
                                    <?php rh_woo_code_zone('button');?>
                                    <div class="woo-button-actions-area floatright mt15 pr5 pl10">
                                        <?php $wishlistadd = __('Add to wishlist', 'rehub_framework');?>
                                        <?php $wishlistadded = __('Added to wishlist', 'rehub_framework');?>
                                        <?php $wishlistremoved = __('Removed from wishlist', 'rehub_framework');?>
                                        <?php echo getHotThumb($post->ID, false, false, true, $wishlistadd, $wishlistadded, $wishlistremoved);?>                                        
                                    </div>
                                    <div class="top_share floatleft notextshare mt20">
                                        <?php woocommerce_template_single_sharing();?>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="woo-single-meta font80">
                                        <?php do_action( 'woocommerce_product_meta_start' ); ?>
                                        <?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>
                                            <span class="sku_wrapper"><?php esc_html_e( 'SKU:', 'rehub_framework' ); ?> <span class="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'rehub_framework' ); ?></span></span>
                                        <?php endif; ?>
                                        <?php echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'rehub_framework' ) . ' ', '</span>' ); ?>                                
                                        <?php do_action( 'woocommerce_product_meta_end' ); ?>
                                    </div>                                     
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
                                </div>                                                                                                
                            </div>
                        </div> 
                        
                        <div id="contents-section-woo-area" class="rh-stickysidebar-wrapper">                      
                            <div class="main-side rh-sticky-container clearfix <?php if ( is_active_sidebar( 'sidebarwooinner' ) ) : ?>woo_default_w_sidebar<?php else:?>full_width woo_default_no_sidebar<?php endif; ?>">
                                <?php $tabs = apply_filters( 'woocommerce_product_tabs', array() );

                                if ( ! empty( $tabs ) ) : ?>

                                    <?php 
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
                                        $tabs['woo-ce-pricehistory'] = array(
                                            'title' => __('Price History', 'rehub_framework'),
                                            'priority' => '22',
                                            'callback' => 'woo_ce_history_output'
                                        );                                            
                                        uasort( $tabs, '_sort_priority_callback' );                                 
                                    ?>

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
                                                <ul class="float-panel-woo-links list-unstyled list-line-style font80 fontbold lineheight15">
                                                    <?php foreach ( $tabs as $key => $tab ) : ?>
                                                        <li class="<?php echo esc_attr( $key ); ?>_tab" id="tab-title-<?php echo esc_attr( $key ); ?>">
                                                            <a href="#section-<?php echo esc_attr( $key ); ?>"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?></a>
                                                        </li>                                                
                                                    <?php endforeach; ?>                                        
                                                </ul>                                  
                                            </div>
                                            <div class="float-panel-woo-btn rh-flex-columns rh-flex-right-align">
                                                <div class="float-panel-woo-price rh-flex-center-align font120 rh-flex-right-align">
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

                                    <div class="content-woo-area">
                                        <?php foreach ( $tabs as $key => $tab ) : ?>
                                            <div class="rh-tabletext-block rh-tabletext-wooblock" id="section-<?php echo esc_attr( $key ); ?>">
                                                <div class="rh-tabletext-block-heading">
                                                    <span class="toggle-this-table"></span>
                                                    <h4 class="rh-heading-icon"><?php echo $tab['title'];?></h4>
                                                </div>
                                                <div class="rh-tabletext-block-wrapper">
                                                    <?php call_user_func( $tab['callback'], $key, $tab ); ?>
                                                </div>
                                            </div>                                            
                                        <?php endforeach; ?>
                                    </div>

                                <?php endif; ?>

                            </div>
                            <?php if ( is_active_sidebar( 'sidebarwooinner' ) ) : ?>
                                <?php wp_enqueue_script('stickysidebar');?>
                                <aside class="sidebar rh-sticky-container">            
                                    <?php dynamic_sidebar( 'sidebarwooinner' ); ?>      
                                </aside> 
                            <?php endif; ?>                           
                        </div>    

                        <div class="other-woo-area">
                            <div class="rh-container mt30">
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
                            </div>  
                        </div>                            


                    </div><!-- #product-<?php the_ID(); ?> -->

                    <?php do_action( 'woocommerce_after_single_product' ); ?>
                <?php endwhile; // end of the loop. ?>
                <?php do_action( 'woocommerce_after_main_content' ); ?>                              
            </div>
        </div>  
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