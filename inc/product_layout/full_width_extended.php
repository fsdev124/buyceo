<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php global $product, $post;?>
<div class="full_width woo_full_width_extended" id="content">
    <div class="post">
        <?php do_action( 'woocommerce_before_main_content' );?>
        <?php while ( have_posts() ) : the_post(); ?>
            <?php
                do_action( 'woocommerce_before_single_product' );
                if ( post_password_required() ) {
                    echo get_the_password_form();
                    return;
                }
            ?>
            <div id="product-<?php echo $post->ID; ?>" <?php post_class(); ?>>

                <div class="top-woo-area rh-container flowhidden mt15 mb35">
                    <?php woocommerce_breadcrumb();?>                
                    <div class="rh-300-content-area floatleft">
                        <div class="woo-title-area mb10 flowhidden">
                            <div class="floatleft"><?php woocommerce_template_single_title();?></div>
                            <div class="floatright ml30 rtlmr30"><?php woocommerce_template_single_rating();?></div>
                        </div>
                        <div class="woo-image-part">
                            <?php $width_woo_main = 760; $height_woo_main = 540; $columns_thumbnails = 1?>
                            <?php include(rh_locate_template('woocommerce/single-product/product-image.php')); ?>
                        </div>                        
                    </div>
                    <div class="rh-300-sidebar summary floatright">
                        <div class="re_wooinner_cta_wrapper lightgreybg"> 
                            <div class="woo-price-area">
                                <?php woocommerce_show_product_sale_flash();?>
                                <?php woocommerce_template_single_price();?>

                            </div>
                            <div class="rh-white-divider"></div>
                            <div class="woo-button-actions-area mb15">
                                <?php $wishlistadd = __('Add to wishlist', 'rehub_framework');?>
                                <?php $wishlistadded = __('Added to wishlist', 'rehub_framework');?>
                                <?php $wishlistremoved = __('Removed from wishlist', 'rehub_framework');?>
                                <?php echo getHotThumb($post->ID, false, false, true, $wishlistadd, $wishlistadded, $wishlistremoved);?>  
                                <?php if(rehub_option('woo_rhcompare') == 1) {echo wpsm_comparison_button(array('class'=>'rhwoosinglecompare'));} ?>
                            </div>
                            <?php rh_show_vendor_info_single(); ?>
                            <div class="rh-white-divider"></div>
                            <?php rh_woo_code_zone('button');?>
                            <div class="woo-button-area mb30"><?php woocommerce_template_single_add_to_cart();?></div>
                            <div class="rh-white-divider"></div>                            
                            <div class="re_wooinner_info">
                                <?php rh_woo_code_zone('content');?>
                                <div class="mb20"><?php woocommerce_template_single_excerpt();?></div>
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
                                <div class="mb20"><?php woocommerce_template_single_meta();?></div>
                                <?php woocommerce_template_single_sharing();?>
                            </div>                                      
                            
                        </div> 
                    </div>                     
                </div>

                <?php $tabs = apply_filters( 'woocommerce_product_tabs', array() );

                if ( ! empty( $tabs ) ) : ?>
                    <?php wp_enqueue_script('customfloatpanel');?>
                    <div id="contents-section-woo-area">
                        <div class="rh-container">
                            <div class="rehub-main-font clearfix rh-big-tabs-ul">
                                <ul class="contents-woo-area rh-big-tabs-ul">
                                    <?php $i = 0; foreach ( $tabs as $key => $tab ) : ?>
                                        <li class="<?php if($i == 0) echo 'active '; ?>rh-big-tabs-li <?php echo esc_attr( $key ); ?>_tab" id="tab-title-<?php echo esc_attr( $key ); ?>">
                                            <a href="#section-<?php echo esc_attr( $key ); ?>"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?></a>
                                        </li>
                                        <?php $i ++;?>
                                    <?php endforeach; ?>
                                </ul> 
                            </div>
                        </div>                                                               
                    </div> 
                    <div class="woo-content-area-full">
                        <div class="content-woo-area">
                            <?php foreach ( $tabs as $key => $tab ) : ?>
                                <div class="content-woo-section pt30 pb20 content-woo-section--<?php echo esc_attr( $key ); ?>" id="section-<?php echo esc_attr( $key ); ?>"><div class="rh-container">
                                    <?php call_user_func( $tab['callback'], $key, $tab ); ?>
                                </div></div>
                            <?php endforeach; ?>

                            <div class="other-woo-area">
                                <div class="rh-container mt20">
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
                                        <div class="float-panel-woo-price rh-flex-center-align font120 rh-flex-right-align"><?php woocommerce_template_single_price();?></div>
                                        <div class="float-panel-woo-button rh-flex-center-align rh-flex-right-align">                
                                            <?php if ( $product->add_to_cart_url() !='') : ?>
                                                <?php if($product->get_type() == 'variable') {
                                                    $url = '#top_ankor';
                                                }else{
                                                    $url = esc_url( $product->add_to_cart_url() );
                                                }

                                                ?>
                                                <?php  echo apply_filters( 'woocommerce_loop_add_to_cart_link',
                                                    sprintf( '<a href="%s" data-product_id="%s" data-product_sku="%s" class="re_track_btn btn_offer_block single_add_to_cart_button %s %s product_type_%s"%s %s>%s</a>',
                                                    $url,
                                                    esc_attr( $product->get_id() ),
                                                    esc_attr( $product->get_sku() ),
                                                    $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                                                    $product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
                                                    esc_attr( $product->get_type() ),
                                                    $product->get_type() =='external' ? ' target="_blank"' : '',
                                                    $product->get_type() =='external' ? ' rel="nofollow"' : '',
                                                    esc_html( $product->add_to_cart_text() )
                                                    ),
                                                $product );?>
                                            <?php endif; ?>
                
                                        </div>                                        
                                    </div>                                    
                                </div>                           
                            </div>
                        </div>
                    </div>
                <?php endif; ?>                

            </div><!-- #product-<?php the_ID(); ?> -->

            <?php do_action( 'woocommerce_after_single_product' ); ?>
        <?php endwhile; // end of the loop. ?>
        <?php do_action( 'woocommerce_after_main_content' ); ?>               
    </div>
</div>  
<!-- Related -->
<?php include(rh_locate_template( 'woocommerce/single-product/full-width-related.php' ) ); ?>                        
<!-- /Related -->

<!-- Upsell -->
<?php include(rh_locate_template( 'woocommerce/single-product/full-width-upsell.php' ) ); ?>
<!-- /Upsell --> 

<?php rh_woo_code_zone('bottom');?>