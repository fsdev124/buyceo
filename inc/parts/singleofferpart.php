<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
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
<?php do_action('post_change_expired', $expired); //Here we update our expired?>
<?php $coupon_mask_enabled = (!empty($offer_coupon) && ($offer_coupon_mask =='1' || $offer_coupon_mask =='on') && $expired!='1') ? '1' : ''; ?> <?php $reveal_enabled = ($coupon_mask_enabled =='1') ? ' reveal_enabled' : '';?>
<div class="rehub_feat_block table_view_block quick-offer-block <?php echo $reveal_enabled; echo $coupon_style; ?>"><a name="quick-offer"></a>
    <div class="block_with_coupon">
            <div class="offer_thumb">
            <a href="<?php echo $offer_url ?>" target="_blank" rel="nofollow" class="re_track_btn">
                <?php if (!empty($offer_thumb) ) :?>
                    <img src="<?php $params = array( 'width' => 120, 'height' => 120 ); echo bfi_thumb( $offer_thumb, $params ); ?>" alt="<?php the_title_attribute(); ?>" />
                <?php else :?>
                    <?php wpsm_thumb ('med_thumbs') ?>
                <?php endif ;?>
            </a>
            </div>
        <div class="desc_col">
            <div class="offer_title"><?php echo esc_html($offer_title) ;?></div>
            <p><?php echo wp_kses_post($offer_desc);  ?></p>
        </div>
        <div class="price_col">
            <p><span class="price_count"><ins><?php echo esc_html($offer_price) ?></ins><?php if($offer_price_old !='') :?> <del><?php echo esc_html($offer_price_old) ; ?></del><?php endif ;?></span></p>
            <div class="brand_logo_small">              
                <?php WPSM_Postfilters::re_show_brand_tax('logo'); //show brand logo?>                 
            </div>
        </div>
        <div class="buttons_col">
            <div class="priced_block clearfix">
                <div>
                    <a href="<?php echo esc_url ($offer_url) ?>" class="re_track_btn btn_offer_block" target="_blank" rel="nofollow">
                        <?php if($offer_btn_text !='') :?>
                            <?php echo $offer_btn_text ; ?>
                        <?php elseif(rehub_option('rehub_btn_text') !='') :?>
                            <?php echo rehub_option('rehub_btn_text') ; ?>
                        <?php else :?>
                            <?php _e('Buy this item', 'rehub_framework') ?>
                        <?php endif ;?>
                    </a>
                </div>
            <?php if ($coupon_mask_enabled =='1') :?>
                <?php wp_enqueue_script('zeroclipboard'); ?>
                <a class="coupon_btn re_track_btn btn_offer_block rehub_offer_coupon masked_coupon <?php if(!empty($offer_coupon_date)) {echo $coupon_style ;} ?>" data-clipboard-text="<?php echo $offer_coupon ?>" data-codeid="<?php echo $postid?>" data-dest="<?php echo esc_url($offer_url) ?>">
                    <?php if($offer_btn_text !='') :?>
                        <?php echo esc_html ($offer_btn_text) ; ?>
                    <?php elseif(rehub_option('rehub_mask_text') !='') :?>
                        <?php echo rehub_option('rehub_mask_text') ; ?>
                    <?php else :?>
                        <?php _e('Reveal coupon', 'rehub_framework') ?>
                    <?php endif ;?>                 
                </a>
            <?php else :?>
                <?php if(!empty($offer_coupon)) : ?>
                    <?php wp_enqueue_script('zeroclipboard'); ?>
                    <div class="rehub_offer_coupon not_masked_coupon <?php if(!empty($offer_coupon_date)) {echo $coupon_style ;} ?>" data-clipboard-text="<?php echo $offer_coupon ?>"><i class="fa fa-scissors fa-rotate-180"></i><span class="coupon_text"><?php echo $offer_coupon ?></span>
                    </div>
                <?php endif;?>
            <?php endif;?>                  
            <?php if(!empty($offer_coupon_date)) {echo '<div class="time_offer">'.$coupon_text.'</div>';} ?>
            </div>
        </div>
    </div>
</div>
<?php //save clean price to post meta
    $offer_price_clean = rehub_price_clean($offer_price); 
    $offer_price_clean_old = get_post_meta( $postid, 'rehub_main_product_price', true );
    if ( $offer_price_clean !='' && $offer_price_clean_old !='' && $offer_price_clean != $offer_price_clean_old ){
        update_post_meta($postid, 'rehub_main_product_price', $offer_price_clean); 
    }
    elseif($offer_price_clean !='' && $offer_price_clean_old =='') {
        update_post_meta($postid, 'rehub_main_product_price', $offer_price_clean); 
    }
 ?> 