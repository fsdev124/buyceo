<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php global $product; global $post;?>
<?php if (empty( $product ) || ! $product->is_visible() ) {return;}?>
<?php $classes = array('product', 'col_item', 'woo_grid_compact', 'two_column_mobile');?>
<?php if (rehub_option('woo_btn_disable') == '1'){$classes[] = 'no_btn_enabled';}?>
<?php $woolinktype = (isset($woolinktype)) ? $woolinktype : '';?>
<?php $woolink = ($woolinktype == 'aff' && $product->get_type() =='external') ? $product->add_to_cart_url() : get_post_permalink($post->ID) ;?>
<?php $wootarget = ($woolinktype == 'aff' && $product->get_type() =='external') ? ' target="_blank" rel="nofollow"' : '' ;?>
<?php $offer_coupon_date = get_post_meta( $post->ID, 'rehub_woo_coupon_date', true ) ?>
<?php $offer_url = esc_url( $product->add_to_cart_url() ); ?>
<?php $custom_img_width = (isset($custom_img_width)) ? $custom_img_width : '';?>
<?php $custom_img_height = (isset($custom_img_height)) ? $custom_img_height : '';?>
<?php $custom_col = (isset($custom_col)) ? $custom_col : '';?>
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
        $coupon_style = ' expired';
        $expired = '1';
    }                 
    ?>
<?php endif ;?>
<?php do_action('woo_change_expired', $expired); //Here we update our expired?>
<?php $classes[] = $coupon_style;?>
<div <?php post_class( $classes ); ?>>
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
    <?php if ( $product->is_on_sale()) : ?>
        <?php 
        $percentage=0;
        if ($product->get_regular_price()) {
            $percentage = round( ( ( $product->get_regular_price() - $product->get_price() ) / $product->get_regular_price() ) * 100 );
        }
        if ($percentage && $percentage>0  && !$product->is_type( 'variable' )) {
            $sales_html = apply_filters( 'woocommerce_sale_flash', '<span class="onsale"><span>- ' . $percentage . '%</span></span>', $post, $product );
        } else {
            $sales_html = apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html__( 'Sale!', 'rehub_framework' ) . '</span>', $post, $product );
        }
        ?>
        <?php echo $sales_html; ?>
    <?php endif; ?>     
    <figure class="mb15 mt25 position-relative">    
        <a class="img-centered-flex rh-flex-center-align rh-flex-justify-center" href="<?php echo $woolink ;?>"<?php echo $wootarget ;?>>
            <?php 
            $showimg = new WPSM_image_resizer();
            $showimg->use_thumb = true; 
            $showimg->no_thumb = rehub_woocommerce_placeholder_img_src('');                                   
            ?>
            <?php if($custom_col) : ?>
                <?php $showimg->width = (int)$custom_img_width;?>
                <?php $showimg->height = (int)$custom_img_height;?>                                 
            <?php else : ?>
                <?php $showimg->width = '250';?> 
                <?php $showimg->height = '180';?>   
                <?php $showimg->crop = false;?>                                   
            <?php endif ; ?>           
            <?php $showimg->show_resized_image(); ?>
        </a>  
        <?php do_action( 'rh_woo_thumbnail_loop' ); ?> 
        <div class="gridcountdown"><?php rehub_woo_countdown();?></div>        
    </figure>
    <div class="cat_for_grid">
        <?php $categories = wp_get_post_terms($post->ID, 'product_cat');  ?>
        <?php if (!empty($categories)) {
            $first_cat = $categories[0]->term_id;
            echo '<a href="'.get_term_link((int)$categories[0]->term_id, 'product_cat').'" class="woocat">'.$categories[0]->name.'</a>'; 
        } ?>                         
    </div>
    <?php do_action('woocommerce_before_shop_loop_item');?> 
    <h3 class="<?php echo getHotIconclass($post->ID); ?>">
        <?php echo rh_expired_or_not($post->ID, 'span');?>
        <?php if ( $product->is_featured() ) : ?>
            <i class="fa fa-bolt mr5 ml5 orangecolor" aria-hidden="true"></i>
        <?php endif; ?>
        <a href="<?php echo $woolink;?>"<?php echo $wootarget;?>><?php the_title();?></a></h3>
    <?php wc_get_template( 'loop/rating.php' );?> 
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
    <div class="border-top mb15 mt15"></div>

    <div class="grid_desc_and_btn rh-flex-center-align">
        <div class="price_for_grid floatleft rehub-main-font mr10">
            <?php wc_get_template( 'loop/price.php' ); ?>
        </div>
        <div class="rh-flex-right-align btn_for_grid floatright">
            <?php if (rehub_option('woo_btn_disable') != '1'):?> 
                <?php if(!empty($syncitem)):?>

                    <?php $countoffers = rh_ce_found_total_offers($post->ID);?>
                    <?php if ($countoffers > 1) :?>
                        <span class="font90 greencolor">+ <?php echo $countoffers - 1; ?> <?php _e('more', 'rehub_framework');?></span>
                    <?php endif;?>

                <?php elseif ( $product->add_to_cart_url() !='') : ?>
                    <?php  echo apply_filters( 'woocommerce_loop_add_to_cart_link',
                        sprintf( '<a href="%s" data-product_id="%s" data-product_sku="%s" class="re_track_btn woo_loop_btn btn_offer_block %s %s product_type_%s"%s %s><i class="fa fa-shopping-bag" aria-hidden="true"></i> %s</a>',
                        esc_url( $product->add_to_cart_url() ),
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
                <?php do_action( 'rh_woo_button_loop' ); ?>                    
            <?php endif;?>            
        </div>            
    </div>
    <?php do_action( 'woocommerce_after_shop_loop_item' );?>       
</div>