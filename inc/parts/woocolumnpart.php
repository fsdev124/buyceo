<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php global $product; global $post;?>
<?php if (empty( $product ) || ! $product->is_visible() ) {return;}?>
<?php $classes = array('product', 'col_item', 'woo_column_item', 'two_column_mobile');?>
<?php if (rehub_option('woo_btn_disable') == '1'){$classes[] = 'non_btn';}?>
<?php $woolinktype = (isset($woolinktype)) ? $woolinktype : '';?>
<?php $custom_img_width = (isset($custom_img_width)) ? $custom_img_width : '';?>
<?php $custom_img_height = (isset($custom_img_height)) ? $custom_img_height : '';?>
<?php $custom_col = (isset($custom_col)) ? $custom_col : '';?>
<?php $woolinktype = (isset($woolinktype)) ? $woolinktype : '';?>
<?php $woolink = ($woolinktype == 'aff' && $product->get_type() =='external') ? $product->add_to_cart_url() : get_post_permalink($post->ID) ;?>
<?php $wootarget = ($woolinktype == 'aff' && $product->get_type() =='external') ? ' target="_blank" rel="nofollow"' : '' ;?>
<?php $offer_coupon = get_post_meta( $post->ID, 'rehub_woo_coupon_code', true ) ?>
<?php $offer_coupon_date = get_post_meta( $post->ID, 'rehub_woo_coupon_date', true ) ?>
<?php $offer_coupon_mask = '1' ?>
<?php $offer_url = esc_url( $product->add_to_cart_url() ); ?>
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
<?php do_action('woo_change_expired', $expired); //Here we update our expired?>
<?php $classes[] = $coupon_style;?>
<?php $coupon_mask_enabled = (!empty($offer_coupon) && ($offer_coupon_mask =='1' || $offer_coupon_mask =='on') && $expired!='1') ? '1' : ''; ?>
<?php if($coupon_mask_enabled =='1') {$classes[] = 'reveal_enabled';}?>
<div class="<?php echo implode(' ', $classes); ?>">
    <figure class="full_image_woo">
        <div class="button_action">
            <div class="floatleft mr5">
                <?php $wishlistadded = __('Added to wishlist', 'rehub_framework');?>
                <?php $wishlistremoved = __('Removed from wishlist', 'rehub_framework');?>
                <?php echo getHotThumb($post->ID, false, false, true, '', $wishlistadded, $wishlistremoved);?>  
            </div>
            <?php if(rehub_option('woo_rhcompare') == true) :?>
                <span class="compare_for_grid floatleft">            
                    <?php $cmp_btn_args = array(); $cmp_btn_args['class']= 'comparecompact';?>
                    <?php echo wpsm_comparison_button($cmp_btn_args); ?> 
                </span>
            <?php endif;?>                                                            
        </div>  
        <?php if ( $product->is_featured() ) : ?>
                <?php echo apply_filters( 'woocommerce_featured_flash', '<span class="onfeatured">' . __( 'Featured!', 'rehub_framework' ) . '</span>', $post, $product ); ?>
        <?php endif; ?>        
        <?php if ( $product->is_on_sale()) : ?>
            <?php 
            $percentage=0;
            $featured = ($product->is_featured()) ? ' onsalefeatured' : '';
            if ($product->get_regular_price()) {
                $percentage = round( ( ( $product->get_regular_price() - $product->get_price() ) / $product->get_regular_price() ) * 100 );
            }
            if ($percentage && $percentage>0 && !$product->is_type( 'variable' )) {
                $sales_html = apply_filters( 'woocommerce_sale_flash', '<span class="onsale'.$featured.'"><span>- ' . $percentage . '%</span></span>', $post, $product );
            }
            else{
                $sales_html = apply_filters( 'woocommerce_sale_flash', '<span class="onsale'.$featured.'">' . esc_html__( 'Sale!', 'rehub_framework' ) . '</span>', $post, $product );  
            }              
            ?>
            <?php echo $sales_html; ?>
        <?php endif; ?>                   
        <a class="img-centered-flex" href="<?php echo $woolink ;?>"<?php echo $wootarget ;?>>

            <?php 
            $showimg = new WPSM_image_resizer();
            $showimg->use_thumb = true; 
            $showimg->no_thumb = rehub_woocommerce_placeholder_img_src('');                                   
            ?>
            <?php if($custom_col) : ?>
                <?php $showimg->width = (int)$custom_img_width;?>
                <?php $showimg->height = (int)$custom_img_height;?>                                                 
            <?php else : ?>
                <?php $showimg->width = '275';?>
                <?php $showimg->height = '275';?>                                                       
            <?php endif ; ?>  
            <?php $showimg->crop = true;?>          
            <?php $showimg->show_resized_image(); ?>
        </a>          
        <?php do_action( 'rehub_after_woo_brand' ); ?>
        <?php do_action( 'rh_woo_thumbnail_loop' ); ?>
    </figure>
    <div class="woo_column_desc">
        <?php do_action('woocommerce_before_shop_loop_item');?>      
        <h3 class="<?php echo getHotIconclass($post->ID); ?>">
            <?php echo rh_expired_or_not($post->ID, 'span');?>
            <?php if ( $product->is_featured() ) : ?>
                <i class="fa fa-bolt mr5 ml5 orangecolor" aria-hidden="true"></i>
            <?php endif; ?>
            <a href="<?php echo $woolink;?>"<?php echo $wootarget;?>><?php the_title();?></a>
        </h3> 
        <?php $syncitem = '';?>
        <?php if (rh_is_plugin_active('content-egg/content-egg.php')):?>
            <?php $itemsync = \ContentEgg\application\WooIntegrator::getSyncItem($post->ID);?>
            <?php if(!empty($itemsync)):?>
                <?php                            
                    $syncitem = $itemsync;                            
                ?>
            <?php endif;?>
        <?php endif;?>
        <?php if(!empty($syncitem)):?>
            <div class="font80 greycolor lineheight15">
            <?php echo rh_best_syncpost_deal($itemsync, 'mb10 compare-domain-icon', false);?>
            </div>
        <?php else:?>
            <?php do_action( 'rehub_vendor_show_action' ); ?>        
        <?php endif;?> 
        <?php $loop_code_zone = rehub_option('woo_code_zone_loop');?>        
        <?php if ($loop_code_zone):?>
            <div class="woo_code_zone_loop">
                <?php echo do_shortcode($loop_code_zone);?>
            </div>
        <?php endif;?>                
        <div class="woo_column_price mt15">
            <?php
                /**
                 * woocommerce_after_shop_loop_item_title hook.
                 *
                 * @hooked woocommerce_template_loop_rating - 5
                 * @hooked woocommerce_template_loop_price - 10
                 */
                do_action( 'woocommerce_after_shop_loop_item_title' );
            ?>
        </div>          

        <?php if (rehub_option('woo_btn_disable') != '1'):?>
            <div class="woo_column_btn">   
                <?php if(!empty($syncitem)):?>

                    <a href="<?php echo get_post_permalink($post->ID);?>" data-product_id="<?php echo esc_attr( $product->get_id() );?>" data-product_sku="<?php echo esc_attr( $product->get_sku() );?>" class="re_track_btn woo_loop_btn btn_offer_block product_type_cegg">
                        <?php if(rehub_option('rehub_btn_text_aff_links') !='') :?>
                            <?php echo rehub_option('rehub_btn_text_aff_links') ; ?>
                        <?php else :?>
                            <?php _e('Choose offer', 'rehub_framework') ?>
                        <?php endif ;?>
                    </a>

                <?php elseif ( $product->add_to_cart_url() !='') : ?>               
                    <?php  echo apply_filters( 'woocommerce_loop_add_to_cart_link',
                            sprintf( '<a href="%s" data-product_id="%s" data-product_sku="%s" class="re_track_btn woo_loop_btn btn_offer_block %s %s product_type_%s"%s %s>%s</a>',
                            esc_url( $product->add_to_cart_url() ),
                            esc_attr( $product->get_id() ),
                            esc_attr( $product->get_sku() ),
                            $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                            $product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
                            esc_attr( $product->get_type() ),
                            $product->get_type() =='external' ? ' target="_blank"' : '',
                            $product->get_type() =='external' ? ' rel="nofollow"' : '',
                            esc_html( $product->add_to_cart_text() )
                            ), $product );?>                 
                    <?php if ($coupon_mask_enabled =='1') :?>
                        <?php wp_enqueue_script('zeroclipboard'); ?>
                        <a class="woo_loop_btn coupon_btn re_track_btn btn_offer_block rehub_offer_coupon masked_coupon <?php if(!empty($offer_coupon_date)) {echo $coupon_style ;} ?>" data-clipboard-text="<?php echo $offer_coupon ?>" data-codeid="<?php echo $product->get_id() ?>" data-dest="<?php echo $offer_url ?>"><?php if(rehub_option('rehub_mask_text') !='') :?><?php echo rehub_option('rehub_mask_text') ; ?><?php else :?><?php _e('Reveal coupon', 'rehub_framework') ?><?php endif ;?>
                        </a>
                    <?php else :?>
                        <?php if(!empty($offer_coupon)) : ?>
                            <?php wp_enqueue_script('zeroclipboard'); ?>
                            <div class="rehub_offer_coupon not_masked_coupon <?php if(!empty($offer_coupon_date)) {echo $coupon_style ;} ?>" data-clipboard-text="<?php echo $offer_coupon ?>"><i class="fa fa-scissors fa-rotate-180"></i><span class="coupon_text"><?php echo $offer_coupon ?></span>
                            </div>
                        <?php endif;?>
                    <?php endif;?>                     
                <?php endif;?>
                <?php do_action( 'rh_woo_button_loop' ); ?>            
            </div>
        <?php endif; ?>
        <?php do_action( 'woocommerce_after_shop_loop_item' );?>
    </div>    
</div>