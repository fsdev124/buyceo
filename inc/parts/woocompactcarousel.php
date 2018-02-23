<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php $woolink = ($aff_link == '1' && $product->get_type() =='external') ? $product->add_to_cart_url() : get_post_permalink(get_the_ID()) ;?>
<?php $target = ($aff_link == '1' && $product->get_type() =='external') ? ' target="_blank" rel="nofollow"' : '' ;?>
<?php $offer_coupon = get_post_meta( get_the_ID(), 'rehub_woo_coupon_code', true ) ?>
<?php $offer_coupon_date = get_post_meta( get_the_ID(), 'rehub_woo_coupon_date', true ) ?>
<?php $offer_coupon_mask = get_post_meta( get_the_ID(), 'rehub_woo_coupon_mask', true ) ?>
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
<?php $outsidelinkpart = ($coupon_mask_enabled=='1') ? ' data-codeid="'.$product->get_id().'" data-dest="'.$offer_coupon_url.'" data-clipboard-text="'.$offer_coupon.'" class="masked_coupon"' : '';?>                                                         
<?php 
$showimg = new WPSM_image_resizer();
$showimg->use_thumb = true;
$showimg->width = '154';
$showimg->crop = true;
$showimg->lazy = false;                                    
?>
<div class="deal-item-wrap<?php echo $reveal_enabled; echo $coupon_style; ?>">
    <div class="deal-item">
        <?php if ($product->is_on_sale() && !$product->is_type( 'variable' ) && $product->get_regular_price() && $product->get_price() > 0) : ?>
            <span class="small_sale_a_proc">
                <?php   
                    $offer_price_calc = (float) $product->get_price();
                    $offer_price_old_calc = (float) $product->get_regular_price();
                    $sale_proc = 0 -(100 - ($offer_price_calc / $offer_price_old_calc) * 100); 
                    $sale_proc = round($sale_proc); 
                    echo $sale_proc; echo '%';
                ;?>
            </span>
        <?php endif ?>                      
        <a href="<?php echo $woolink;?>"<?php echo $target;?>>
            <img class="owl-lazy" data-src="<?php echo $showimg->get_resized_url();?>" alt="<?php the_title_attribute(); ?>">
        </a>                    
        <div class="info-overlay">
            <?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>
            <?php do_action( 'rehub_after_woo_carousel_price' ); ?>
        </div>                                                                       
    </div>
    <div class="deal-detail">
        <h3><a href="<?php echo $woolink;?>"<?php echo $target;?>><?php the_title();?></a></h3>
        <?php do_action('woocommerce_before_shop_loop_item');?>
        <?php do_action( 'rehub_after_woo_carousel_title' ); ?>
        <?php if ( $product->is_in_stock() &&  $product->add_to_cart_url() !='') : ?>
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
        <?php do_action( 'rehub_after_woo_carousel_module' ); ?>
        <?php do_action('woocommerce_after_shop_loop_item');?>    
    </div>                  
</div>              