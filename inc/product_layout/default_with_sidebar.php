<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php global $product;?>
<!-- CONTENT -->
<div class="rh-container"> 
    <div class="rh-content-wrap clearfix">
        <!-- Main Side -->
        <div class="main-side clearfix woo_default_w_sidebar" id="content">
            <div class="post">
                <?php do_action( 'woocommerce_before_main_content' );?>
                <?php woocommerce_breadcrumb();?> 
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php
                        /**
                         * woocommerce_before_single_product hook.
                         *
                         * @hooked wc_print_notices - 10
                         */
                         do_action( 'woocommerce_before_single_product' );

                         if ( post_password_required() ) {
                            echo get_the_password_form();
                            return;
                         }
                    ?>
                    <div id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

                        <div class="woo-image-part">
                            <?php
                                /**
                                 * woocommerce_before_single_product_summary hook.
                                 *
                                 * @hooked woocommerce_show_product_sale_flash - 10
                                 * @hooked woocommerce_show_product_images - 20
                                 */
                                do_action( 'woocommerce_before_single_product_summary' );
                            ?>
                        </div>

                        <div class="summary entry-summary">

                            <div class="re_wooinner_info mb30">
                                <div class="re_wooinner_title_compact">
                                    <?php woocommerce_template_single_title();?>
                                    <?php woocommerce_template_single_rating();?>
                                    <div class="woo-button-actions-area mb15">
                                        <?php $wishlistadd = __('Add to wishlist', 'rehub_framework');?>
                                        <?php $wishlistadded = __('Added to wishlist', 'rehub_framework');?>
                                        <?php $wishlistremoved = __('Removed from wishlist', 'rehub_framework');?>
                                        <?php echo getHotThumb($post->ID, false, false, true, $wishlistadd, $wishlistadded, $wishlistremoved);?>  
                                        <?php if(rehub_option('woo_rhcompare') == 1) {echo wpsm_comparison_button(array('class'=>'rhwoosinglecompare'));} ?>
                                    </div>
                                </div>
                                <div class="clear"></div>
                                <?php rh_show_vendor_info_single();?>
                                <?php rh_woo_code_zone('content');?>
                                <?php woocommerce_template_single_excerpt();?>                  
                            </div>
                            <div class="re_wooinner_cta_wrapper mb20">
                                <div class="woo-price-area"><?php woocommerce_template_single_price();?></div>
                                <div class="woo-button-area"><?php woocommerce_template_single_add_to_cart();?></div>
                                <?php rh_woo_code_zone('button');?> 
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
                            <div class="mb20"><?php woocommerce_template_single_meta();?></div>
                            <?php woocommerce_template_single_sharing();?>

                        </div><!-- .summary -->

                        <?php woocommerce_output_product_data_tabs();?>

                        <!-- Related -->
                            <?php include(rh_locate_template( 'woocommerce/single-product/related-with-sidebar.php' ) ); ?>                         
                        <!-- /Related --> 

                        <!-- Upsell -->
                            <?php include(rh_locate_template( 'woocommerce/single-product/upsell-with-sidebar.php' ) ); ?>
                        <!-- /Upsell -->                                               

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
        <!-- Sidebar -->
        <?php get_sidebar('shopinner'); ?>
        <!-- /Sidebar --> 

    </div>
</div>
<!-- /CONTENT --> 
<?php rh_woo_code_zone('bottom');?>