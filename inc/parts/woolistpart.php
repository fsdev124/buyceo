<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php global $product; global $post;?>
<?php if (empty( $product ) || ! $product->is_visible() ) {return;}?>
<?php $woolink = ($product->get_type() =='external' && $product->add_to_cart_url() !='') ? $product->add_to_cart_url() : get_post_permalink($post->ID) ;?>
<?php $offer_coupon = get_post_meta( $post->ID, 'rehub_woo_coupon_code', true ) ?>
<?php $offer_coupon_date = get_post_meta( $post->ID, 'rehub_woo_coupon_date', true ) ?>
<?php $offer_coupon_mask = get_post_meta( $post->ID, 'rehub_woo_coupon_mask', true ) ?>
<?php $offer_coupon_url = esc_url( $product->add_to_cart_url() ); ?>
<?php $coupon_style = $expired =''; if(!empty($offer_coupon_date)) : ?>
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
<?php do_action('woo_change_expired', $coupon_style); //Here we update our expired?>
<?php $coupon_mask_enabled = (!empty($offer_coupon) && ($offer_coupon_mask =='1' || $offer_coupon_mask =='on') && $expired!='1') ? '1' : ''; ?>
<?php $reveal_enabled = ($coupon_mask_enabled =='1') ? ' reveal_enabled' : '';?>
<?php $outsidelinkpart = ($coupon_mask_enabled=='1') ? 'data-codeid="'.$product->get_id().'" data-dest="'.$offer_coupon_url.'" data-clipboard-text="'.$offer_coupon.'" class="masked_coupon"' : '';?>
<?php 
if (!empty($offer_coupon)) {
    $deal_type = ' coupontype';
    $deal_type_string = __('Coupon', 'rehub_framework');
}
elseif ($product->is_on_sale()){
    $deal_type = ' saledealtype';
    $deal_type_string = __('Sale', 'rehub_framework');
}
else {
    $deal_type = ' defdealtype';
    $deal_type_string = __('Deal', 'rehub_framework');
}
?>
<?php $syncitem = '';?>
<?php if (rh_is_plugin_active('content-egg/content-egg.php')):?>
    <?php $itemsync = \ContentEgg\application\WooIntegrator::getSyncItem($post->ID);?>
    <?php if(!empty($itemsync)):?>
        <?php                            
            $syncitem = $itemsync;                            
        ?>
    <?php endif;?>
<?php endif;?> 
<div class="border-grey woocommerce table_view_block <?php echo $reveal_enabled; echo $coupon_style; echo $deal_type; ?>">
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
    <div class="block_with_coupon <?php echo $deal_type;?>">
        <div class="offer_thumb"> 
            <div class="deal_img_wrap">       
            <a href="<?php echo get_permalink(); ?>">
            <?php if (!has_post_thumbnail() && $product->is_on_sale() && $product->get_regular_price() && $product->get_price() > 0 && !$product->is_type( 'variable' )) :?>
                <span class="sale_tag_inwoolist">
                    <h5>
                    <?php   
                        $offer_price_calc = (float) $product->get_price();
                        $offer_price_old_calc = (float) $product->get_regular_price();
                        $sale_proc = 0 -(100 - ($offer_price_calc / $offer_price_old_calc) * 100); 
                        $sale_proc = round($sale_proc); 
                        echo $sale_proc; echo '%';
                    ;?>
                    </h5>
                </span>
            <?php else :?>
                <?php if ($product->is_on_sale() && !$product->is_type( 'variable' ) && $product->get_regular_price() && $product->get_price() > 0) : ?>
                <span class="sale_a_proc">
                    <?php   
                        $offer_price_calc = (float) $product->get_price();
                        $offer_price_old_calc = (float) $product->get_regular_price();
                        $sale_proc = 0 -(100 - ($offer_price_calc / $offer_price_old_calc) * 100); 
                        $sale_proc = round($sale_proc); 
                        echo $sale_proc; echo '%';
                    ;?>
                </span> 
                <?php endif ?>              
                <?php WPSM_image_resizer::show_static_resized_image(array('lazy'=> false, 'thumb'=> true, 'crop'=> false, 'height'=> 92, 'no_thumb_url' => rehub_woocommerce_placeholder_img_src('')));?>
            <?php endif;?>
            </a>
            <div class="<?php echo $deal_type;?>_deal_string text-center deal_string"><?php echo $deal_type_string;?></div>
            </div>
            <?php do_action( 'rh_woo_thumbnail_loop' ); ?>
        </div>
        <div class="desc_col">  
            <?php do_action('woocommerce_before_shop_loop_item');?>           
            <h3><a href="<?php echo get_permalink(); ?>"><?php echo rh_expired_or_not($post->ID, 'span');?><?php $title = get_the_title(); echo wp_trim_words( $title, 10, '...' ) ?></a></h3>
            <?php $loop_code_zone = rehub_option('woo_code_zone_loop');?>        
            <?php if ($loop_code_zone):?>
                <div class="woo_code_zone_loop">
                    <?php echo do_shortcode($loop_code_zone);?>
                </div>
            <?php endif;?>            
            <p>
                <?php kama_excerpt('maxchar=150'); ?>
            </p>
            <div class="woolist_meta mb10">
                <span class="comm_count_meta"><?php comments_popup_link( __('no comments','rehub_framework'), __('1 comment','rehub_framework'), __('% comments','rehub_framework'), 'comm_meta', ''); ?></span>                
                <span class="date_ago"><i class="fa fa-clock-o"></i> <?php printf( __( '%s ago', 'rehub_framework' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) ); ?></span>             
                <span class="woolist_vendor">

                    <?php if(!empty($syncitem)):?>
                        <div class="font80 greycolor lineheight15">
                        <?php echo rh_best_syncpost_deal($itemsync, 'mb10 compare-domain-icon', false);?>
                        </div>
                    <?php else:?>
                        <?php do_action( 'rehub_vendor_show_action' ); ?>        
                    <?php endif;?>                     
                </span>
                               
            </div>
            <?php do_action('woocommerce_after_shop_loop_item');?>
        </div>
        <div class="price_col">
            <?php if ($product->get_price() !='') : ?>
            <p><span class="price_count"><?php echo $product->get_price_html(); ?></span></p>
            <?php endif ;?> 
            <div class="brand_logo_small">       
                <?php WPSM_Woohelper::re_show_brand_tax('list'); //show brand taxonomy?>
            </div>                                          
        </div>            
        <div class="buttons_col">
            <div class="priced_block">
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
                        ),
                    $product );?> 
                <?php endif; ?>                    
                <?php if ($coupon_mask_enabled =='1') :?>
                    <?php wp_enqueue_script('zeroclipboard'); ?>                
                    <a class="woo_loop_btn coupon_btn re_track_btn btn_offer_block rehub_offer_coupon masked_coupon <?php if(!empty($offer_coupon_date)) {echo $coupon_style ;} ?>" href="<?php echo $woolink; ?>"<?php if ($product->get_type() =='external'){echo ' target="_blank" rel="nofollow"'; echo $outsidelinkpart; } ?>>
                        <?php if(rehub_option('rehub_mask_text') !='') :?><?php echo rehub_option('rehub_mask_text') ; ?><?php else :?><?php _e('Reveal coupon', 'rehub_framework') ?><?php endif ;?>
                    </a>
                <?php else :?> 
                    <?php if(!empty($offer_coupon)) : ?>
                        <?php wp_enqueue_script('zeroclipboard'); ?>
                        <div class="rehub_offer_coupon not_masked_coupon <?php if(!empty($offer_coupon_date)) {echo $coupon_style ;} ?>" data-clipboard-text="<?php echo $offer_coupon ?>">
                            <i class="fa fa-scissors fa-rotate-180"></i>
                            <span class="coupon_text"><?php echo $offer_coupon ?></span>
                        </div>
                    <?php endif ;?>                                               
                <?php endif;?>
                <?php if(!empty($offer_coupon_date)) {echo '<div class="time_offer">'.$coupon_text.'</div>';} ?>
            </div>
            <?php do_action( 'rh_woo_button_loop' ); ?>
        </div>
    </div>
</div>