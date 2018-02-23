<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php global $product, $post;?>

<div class="sections_w_sidebar lightgreybg pb30" id="content">
    <div class="post mb0">
        <?php while ( have_posts() ) : the_post(); ?>
            <?php
                if ( post_password_required() ) {
                    echo get_the_password_form();
                    return;
                }
            ?>
            <div id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

                <?php wp_enqueue_script('stickysidebar');?>
                <div class="content-woo-area rh-container flowhidden rh-stickysidebar-wrapper">                                
                    <div class="rh-336-content-area tabletblockdisplay floatleft pt15 rh-sticky-container">
                        <?php do_action( 'woocommerce_before_main_content' );?>
                        <?php woocommerce_breadcrumb();?>
                        <div class="woo-title-area mb10 flowhidden">
                            <div class="floatleft font90"><?php woocommerce_template_single_title();?></div>
                            <div class="floatright ml30 rtlmr30"><?php woocommerce_template_single_rating();?></div>
                        </div>                        
                        <div class="woo-image-part"><?php woocommerce_show_product_sale_flash();?>
                            <?php $width_woo_main = 840; $height_woo_main = 560; $columns_thumbnails = 10?>
                            <?php include(rh_locate_template('woocommerce/single-product/product-image.php')); ?>
                        </div> 

                        <div class="padd20 summary border-grey whitebg rh_vert_bookable mb20 rhhidden tabletblockdisplay"> 
                            <div class="float_p_trigger woo-price-area"><?php woocommerce_template_single_price();?></div>
                            <div class="woo-button-area mb30"><?php woocommerce_template_single_add_to_cart();?></div>
                            <?php rh_woo_code_zone('button');?>
                            <div class="woo-button-actions-area tabletblockdisplay pt15 border-top mt15">
                                <?php $wishlistadd = __('Add to wishlist', 'rehub_framework');?>
                                <?php $wishlistadded = __('Added to wishlist', 'rehub_framework');?>
                                <?php $wishlistremoved = __('Removed from wishlist', 'rehub_framework');?>
                                <?php echo getHotThumb($post->ID, false, false, true, $wishlistadd, $wishlistadded, $wishlistremoved);?>
                                <?php if(rehub_option('woo_rhcompare') == 1) {echo wpsm_comparison_button(array('class'=>'rhwoosinglecompare'));} ?>                      
                            </div>                            
                        </div>                         


                        <?php $tabs = apply_filters( 'woocommerce_product_tabs', array() );

                        if ( ! empty( $tabs ) ) : ?>
                            <div id="contents-section-woo-area">
                                <ul class="mb20 pl10 pr10 whitebg rehub-main-font clearfix contents-woo-area rh-big-tabs-ul">
                                    <?php $i = 0; foreach ( $tabs as $key => $tab ) : ?>
                                        <li class="<?php if($i == 0) echo 'active '; ?>rh-big-tabs-li <?php echo esc_attr( $key ); ?>_tab" id="tab-title-<?php echo esc_attr( $key ); ?>">
                                            <a href="#section-<?php echo esc_attr( $key ); ?>"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?></a>
                                        </li>
                                        <?php $i ++;?>
                                    <?php endforeach; ?>
                                </ul> 
                            </div> 
                        
                        <?php endif;?>                       

                        <div class="padd20 mb20 whitebg re_wooinner_info font90">
                            <?php rh_woo_code_zone('content');?>
                            <?php woocommerce_template_single_excerpt();?>                                                            
                        </div> 

                        <?php foreach ( $tabs as $key => $tab ) : ?>
                            <div class="padd20 mb20 font90 whitebg content-woo-section--<?php echo esc_attr( $key ); ?>" id="section-<?php echo esc_attr( $key ); ?>">
                                <?php call_user_func( $tab['callback'], $key, $tab ); ?>
                            </div>
                        <?php endforeach; ?> 
                        <div class="other-woo-area">
                            <div class="mb20">
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
                        <?php wp_enqueue_script('customfloatpanel');?>
                        <div class="flowhidden rh-float-panel" id="float-panel-woo-area">
                            <div class="rh-container rh-flex-eq-height">
                                <div class="pt5 pb5 rh-336-content-area rh-flex-center-align">
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
                                </div>
                                <div class="darkbg float-panel-woo-btn rh-flex-center-align mb0 rh-336-sidebar rh-flex-right-align">
                                    <div class="whitecolor float-panel-woo-price font120 margincenter"><?php woocommerce_template_single_price();?>
                                    </div>                                       
                                </div>                                    
                            </div>                           
                        </div>
                        <?php do_action( 'woocommerce_after_main_content' ); ?>             
                    </div>  
                    <div class="rh-336-sidebar mt20 floatright rh-sticky-container tabletblockdisplay">
                        <div class="padd20 summary border-grey whitebg rh_vert_bookable stickyonfloatpanel mb20"> 
                            <div class="float_p_trigger woo-price-area"><?php woocommerce_template_single_price();?></div>
                            <div class="woo-button-area mb30"><?php woocommerce_template_single_add_to_cart();?></div>
                            <?php echo rh_woo_code_zone('button');?>
                            <div class="mb5"><?php woocommerce_template_single_meta();?></div>
                            <?php woocommerce_template_single_sharing();?>  
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
                            <div class="woo-button-actions-area tabletblockdisplay pt15 border-top mt20">
                                <?php $wishlistadd = __('Add to wishlist', 'rehub_framework');?>
                                <?php $wishlistadded = __('Added to wishlist', 'rehub_framework');?>
                                <?php $wishlistremoved = __('Removed from wishlist', 'rehub_framework');?>
                                <?php echo getHotThumb($post->ID, false, false, true, $wishlistadd, $wishlistadded, $wishlistremoved);?>
                                <?php if(rehub_option('woo_rhcompare') == 1) {echo wpsm_comparison_button(array('class'=>'rhwoosinglecompare'));} ?>                      
                            </div>                            
                        </div> 

                        <?php rh_show_vendor_info_single(); ?> 
                    </div>                      
                </div>

            </div><!-- #product-<?php the_ID(); ?> -->

            <?php do_action( 'woocommerce_after_single_product' ); ?>

        <?php endwhile; // end of the loop. ?>               
    </div>
</div>  
<!-- Related -->
<?php include(rh_locate_template( 'woocommerce/single-product/full-width-related.php' ) ); ?>                      
<!-- /Related -->

<!-- Upsell -->
<?php include(rh_locate_template( 'woocommerce/single-product/full-width-upsell.php' ) ); ?>
<!-- /Upsell -->  

<?php rh_woo_code_zone('bottom');?>