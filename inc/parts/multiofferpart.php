<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php $coupon_style = $expired =''; if(!empty($offer_coupon_date)) : ?>
<?php ?>
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
<?php $featured_class = ($offer_badge) ? ' featured_multioffer' : ''; ?>
<?php $coupon_mask_enabled = (!empty($offer_coupon) && ($offer_coupon_mask =='1' || $offer_coupon_mask =='on') && $expired!='1') ? '1' : ''; ?>
<?php $reveal_enabled = ($coupon_mask_enabled =='1') ? ' reveal_enabled' : '';?>
<?php $outsidelinkpart = ($coupon_mask_enabled=='1') ? ' data-clipboard-text="'.rawurlencode(esc_html($offer_coupon)).'" data-codetext="'.rawurlencode(esc_html($offer_coupon)).'" data-dest="'.esc_url($offer_url).'"' : '';?>
<?php 
if (!empty($offer_coupon)) {
    $deal_type = ' coupontype';
    $deal_type_string = __('Coupon', 'rehub_framework');
}
elseif (!empty($offer_price_old)){
    $deal_type = ' saledealtype';
    $deal_type_string = __('Sale', 'rehub_framework');
}
else {
    $deal_type = ' defdealtype';
    $deal_type_string = __('Deal', 'rehub_framework');
}
?>
<div class="rehub_feat_block table_view_block <?php echo $reveal_enabled; echo $coupon_style; echo $deal_type; echo $featured_class; ?>">          
    <div class="block_with_coupon <?php echo $deal_type;?>">
    <?php if($offer_badge):?><span class="re-ribbon-badge left-badge multiofferbadge"><span><?php _e('Featured', 'rehub_framework');?></span></span><?php endif;?>
        <div class="offer_thumb">
            <div class="deal_img_wrap">       
            <a href="<?php echo $offer_url; ?>" target="_blank" rel="nofollow" <?php echo $outsidelinkpart; ?>>
            <?php if ($offer_thumb) :?>
                <?php if (!empty($offer_price_old) && !empty($offer_price)) : ?>
                    <?php           
                        $offer_pricesale = rehub_price_clean($offer_price); //Clean price from currence symbols
                        $offer_priceold = rehub_price_clean($offer_price_old); //Clean price from currence symbols
                        if ((int)$offer_priceold !='0' && is_numeric($offer_priceold) && (int)$offer_priceold > (int)$offer_pricesale) {
                            $off_proc = 0 -(100 - ((int)$offer_pricesale / (int)$offer_priceold) * 100);
                            $off_proc = round($off_proc);
                            echo '<span class="sale_a_proc">'.$off_proc.'%</span>';
                        }
                    ?>                    
                <?php endif ?>              
                <?php WPSM_image_resizer::show_static_resized_image(array('lazy'=> false, 'src'=> $offer_thumb, 'crop'=> false, 'height'=> 92));?>
            <?php elseif($brand_image_url) :?>
                <?php WPSM_image_resizer::show_static_resized_image(array('lazy'=> false, 'src'=> $brand_image_url, 'crop'=> false, 'height'=> 60));?> 
            <?php elseif(!empty($offer_price_old) && !empty($offer_price)) :?>
                <?php           
                    $offer_pricesale = rehub_price_clean($offer_price); //Clean price from currence symbols
                    $offer_priceold = rehub_price_clean($offer_price_old); //Clean price from currence symbols
                    if ((int)$offer_priceold !='0' && is_numeric($offer_priceold) && (int)$offer_priceold > (int)$offer_pricesale) {
                        $off_proc = 0 -(100 - ((int)$offer_pricesale / (int)$offer_priceold) * 100);
                        $off_proc = round($off_proc);
                        echo '<span class="sale_tag_inwoolist"><h5>'.$off_proc.'%</h5></span>';
                    }
                ?> 
            <?php elseif($offer_user) :?>
                <?php echo get_avatar( $offer_user, '92' ); ?>
            <?php else :?>
                <?php echo '<span class="sale_tag_inwoolist"><span class="multioffernophoto"></span></span>';?>
            <?php endif;?>
            </a>
            <div class="<?php echo $deal_type;?>_deal_string text-center deal_string"><?php echo $deal_type_string;?></div>
            </div>

        </div>
        <div class="desc_col">
            <h3><a href="<?php echo $offer_url; ?>" target="_blank" rel="nofollow" <?php echo $outsidelinkpart; ?>><?php echo esc_html($offer_title) ;?></a></h3>
            <p>
                <?php echo (esc_html($offer_desc)); ?>
            </p>
            <div class="woolist_meta">
                <?php if ($offer_user):?>
                    <span class="admin_meta">
                        <?php _e('Posted by:', 'rehub_framework');?>
                        <?php if ( class_exists( 'BuddyPress' ) ):?>
                             <a class="admin" href="<?php echo bp_core_get_user_domain( $offer_user ) ?>"><?php the_author_meta( 'display_name', $offer_user ); ?>
                             </a>
                        <?php else:?>
                             <a class="admin" href="<?php echo get_author_posts_url( $offer_user ) ?>"><?php the_author_meta( 'display_name', $offer_user ); ?>
                             </a>
                        <?php endif;?>
                    </span>
                <?php endif;?>
                <?php if ($brand_link):?>
                    <span class="woolist_vendor">
                        <?php _e('in', 'rehub_framework');?> <a class="retailer_multioffer" href="<?php echo $brand_link ?>"> <?php echo $brandtermname; ?></a>
                    </span>
                <?php endif;?>                                                     
            </div>
        </div>
        <div class="price_col">
            <p>
                <span class="price_count">
                    <ins><?php echo esc_html($offer_price) ?></ins>
                    <?php if($offer_price_old !='') :?> <del><?php echo esc_html($offer_price_old) ; ?></del><?php endif ;?>
                </span>
            </p>                                          
        </div>            
        <div class="buttons_col">
            <div class="priced_block">
                <a href="<?php echo $offer_url ?>" class="re_track_btn woo_loop_btn btn_offer_block" target="_blank" rel="nofollow">
                    <?php if($offer_btn_text !='') :?>
                        <?php echo $offer_btn_text ; ?>
                    <?php elseif(rehub_option('rehub_btn_text') !='') :?>
                        <?php echo rehub_option('rehub_btn_text') ; ?>
                    <?php else :?>
                        <?php _e('Buy this item', 'rehub_framework') ?>
                    <?php endif ;?>
                </a>                                    
                <?php if ($coupon_mask_enabled =='1') :?>
                    <?php wp_enqueue_script('zeroclipboard'); wp_enqueue_script('affegg_coupons'); ?>                
                    <a class="woo_loop_btn coupon_btn re_track_btn btn_offer_block rehub_offer_coupon masked_coupon <?php if(!empty($offer_coupon_date)) {echo $coupon_style ;} ?>" href="<?php echo $offer_url; ?>" target="_blank" rel="nofollow" <?php echo $outsidelinkpart; ?>>
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
        </div>
    </div>
</div>