<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php global $product, $post;?>

<div class="woo_full_photo_booking" id="content">
    <?php do_action( 'woocommerce_before_main_content' );?>
    <?php while ( have_posts() ) : the_post(); ?>
        <?php
            if ( post_password_required() ) {
                echo get_the_password_form();
                return;
            }
        ?>
        <div id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

            <div class="rh_post_layout_fullimage mb0">
                <?php           
                    $image_id = get_post_thumbnail_id(get_the_ID());  
                    $image_url = wp_get_attachment_image_src($image_id,'full');
                    $image_url = $image_url[0];
                ?>  
                <style scoped>#rh_post_layout_inimage{background-image: url(<?php echo $image_url;?>);}</style>
                <div id="rh_post_layout_inimage">
                    <div class="rh-container">
                        <div class="rh_post_breadcrumb_holder tabletrelative">
                            <?php woocommerce_breadcrumb();?>
                        </div>                        
                        <div class="rh-flex-eq-height rh-woo-fullimage-holder tabletrelative tabletblockdisplay">

                            <div class="rh-336-content-area tabletblockdisplay disablefloattablet floatleft mb20">
                                <div class="woo-title-area mb10 flowhidden">
                                    <div class="rh-cat-list-title woo-cat-string-block">
                                        <?php
                                        $categories = wp_get_post_terms($post->ID, 'product_cat', array("fields" => "all"));
                                        $separator = '';
                                        $output = '';
                                        if ( ! empty( $categories ) ) {
                                            foreach( $categories as $category ) {
                                                $output .= '<a class="rh-cat-label-title rh-cat-'.$category->term_id.'" href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . esc_attr( sprintf( __( 'View all posts in %s', 'rehub_framework' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a>' . $separator;
                                            }
                                            echo trim( $output, $separator );
                                        }
                                        ?> 
                                        <?php if ( $product->is_on_sale()) : ?>
                                            <?php 
                                            $percentage=0;
                                            if ($product->get_regular_price()) {
                                                $percentage = round( ( ( $product->get_regular_price() - $product->get_price() ) / $product->get_regular_price() ) * 100 );
                                            }
                                            if ($percentage && $percentage>0 && !$product->is_type( 'variable' )) {
                                                $sales_html = apply_filters( 'woocommerce_sale_flash', '<span class="rh-label-string redbg"><span>- ' . $percentage . '%</span></span>', $post, $product );
                                            } else {
                                                $sales_html = apply_filters( 'woocommerce_sale_flash', '<span class="rh-label-string redbg">' . esc_html__( 'Sale!', 'rehub_framework' ) . '</span>', $post, $product );
                                            }
                                            ?>
                                            <?php echo $sales_html; ?>
                                        <?php endif; ?>                                                                                     
                                    </div>
                                    <div>

                                        <h1 class="product_title entry-title">
                                        <?php if ( $product->is_featured() ) : ?>
                                            <i class="fa fa-bolt mr5 ml5 orangecolor" aria-hidden="true"></i>
                                        <?php endif; ?>                                            
                                        <?php the_title();?>
                                        </h1>
                                    </div>
                                    <div><?php woocommerce_template_single_rating();?></div>
                                </div>
                            </div>
                            <div class="floatright tabletblockdisplay position-relative mb0 rh-336-sidebar disablefloattablet rh-flex-right-align">
                                
                                <div class="woo-price-area tabletrelative darkhalfopacitybg text-center">
                                     
                                    <div class="rehub-main-font font130">
                                        <?php woocommerce_template_single_price();?>
                                    </div>
                                    
                                </div> 
                            </div>                     
                        </div>
                    </div>
                    <span class="rh-post-layout-image-mask"></span>
                </div>
            </div>

            <?php wp_enqueue_script('stickysidebar');?>
            <div class="content-woo-area rh-container flowhidden mb35 rh-stickysidebar-wrapper">
                <div class="rh-336-sidebar floatright rh-sticky-container tabletblockdisplay">
                    <div class="padd20 summary border-grey whitebg rh_vert_bookable stickyonfloatpanel mb30"> 
                        <?php rh_show_vendor_info_single(); ?>
                        <div class="woo-button-area mb10"><?php woocommerce_template_single_add_to_cart();?></div>
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
                        <?php rh_woo_code_zone('button');?>
                    </div> 
                    <div class="woo-button-actions-area tabletblockdisplay padd20 summary border-grey whitebg mb30 text-center">
                        <?php $wishlistadd = __('Add to wishlist', 'rehub_framework');?>
                        <?php $wishlistadded = __('Added to wishlist', 'rehub_framework');?>
                        <?php $wishlistremoved = __('Removed from wishlist', 'rehub_framework');?>
                        <?php echo getHotThumb($post->ID, false, false, true, $wishlistadd, $wishlistadded, $wishlistremoved);?>
                        <?php if(rehub_option('woo_rhcompare') == 1) {echo wpsm_comparison_button(array('class'=>'rhwoosinglecompare mb15'));} ?> 
                        <div class="woo-single-meta font80">
                            <?php do_action( 'woocommerce_product_meta_start' ); ?>
                            <?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>
                                <span class="sku_wrapper"><?php esc_html_e( 'SKU:', 'rehub_framework' ); ?> <span class="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'rehub_framework' ); ?></span></span>
                            <?php endif; ?>
                            <?php echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'rehub_framework' ) . ' ', '</span>' ); ?>                                
                            <?php do_action( 'woocommerce_product_meta_end' ); ?>
                        </div>                            
                        <?php woocommerce_template_single_sharing();?>                      
                    </div>
                </div>                                
                <div class="rh-336-content-area post tabletblockdisplay floatleft pt5 rh-sticky-container">
                    <?php $tabs = apply_filters( 'woocommerce_product_tabs', array() );
                    $attachment_ids = $product->get_gallery_image_ids();
                    if(!empty($attachment_ids)){
                        $tabs['woo-photo-booking'] = array(
                            'title' => __('Photos', 'rehub_framework'),
                            'priority' => '22',
                            'callback' => 'woo_photo_booking_out'
                        );                                            
                        uasort( $tabs, '_sort_priority_callback' );                             
                    }

                    if ( ! empty( $tabs ) ) : ?>
                        <div class="rehub-main-font clearfix rh-big-tabs-ul" id="contents-section-woo-area">
                            <ul class="contents-woo-area rh-big-tabs-ul">
                                <?php $i = 0; foreach ( $tabs as $key => $tab ) : ?>
                                    <li class="<?php if($i == 0) echo 'active '; ?>rh-big-tabs-li <?php echo esc_attr( $key ); ?>_tab" id="tab-title-<?php echo esc_attr( $key ); ?>">
                                        <a href="#section-<?php echo esc_attr( $key ); ?>"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?></a>
                                    </li>
                                    <?php $i ++;?>
                                <?php endforeach; ?>
                            </ul> 
                        </div> 
                        <div class="rh-line mb20"></div>
                    
                    <?php endif;?>               

                    <div class="re_wooinner_info">
                        <?php rh_woo_code_zone('content');?> 
                        <?php woocommerce_template_single_excerpt();?>            
                    </div> 

                    <?php foreach ( $tabs as $key => $tab ) : ?>
                        <div class="rh-line mb30 mt20"></div>
                        <div class="pb20 content-woo-section--<?php echo esc_attr( $key ); ?>" id="section-<?php echo esc_attr( $key ); ?>">
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
                </div>    
            </div>

        </div><!-- #product-<?php the_ID(); ?> -->

        <?php do_action( 'woocommerce_after_single_product' ); ?>
    <?php endwhile; // end of the loop. ?> 
    <?php do_action( 'woocommerce_after_main_content' ); ?>              
</div>  
<!-- Related -->
<?php include(rh_locate_template( 'woocommerce/single-product/full-width-related.php' ) ); ?>                     
<!-- /Related -->

<!-- Upsell -->
<?php include(rh_locate_template( 'woocommerce/single-product/full-width-upsell.php' ) ); ?>
<!-- /Upsell -->  

<?php rh_woo_code_zone('bottom');?>