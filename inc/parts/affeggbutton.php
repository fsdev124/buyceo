<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php
    $re_egg_id = get_post_meta( get_the_ID(), '_affegg_egg_id', true );
    $re_egg_product_id = get_post_meta( get_the_ID(), '_affegg_product_id', true );
    $re_egg_currency = get_post_meta( get_the_ID(), 'affegg_product_currency', true );
    $item = array(
        'id' => $re_egg_product_id,
        'orig_url' => $aff_url_exist,
        'egg_id' => $re_egg_id,
    );
    $offer_url = (rh_is_plugin_active('affiliate-egg/affiliate-egg.php')) ? Keywordrush\AffiliateEgg\LinkHandler::createAffUrl($item) : esc_url($offer_url_exist);
    $offer_price = get_post_meta( get_the_ID(), 'affegg_product_price', true );
    $offer_price_old = get_post_meta( get_the_ID(), 'affegg_product_old_price', true );
    $offer_formated_price = (rh_is_plugin_active('affiliate-egg/affiliate-egg.php')) ? Keywordrush\AffiliateEgg\TemplateHelper::formatPriceCurrency($offer_price, $re_egg_currency) : $re_egg_currency.$offer_price;
    $offer_formated_priceold = (rh_is_plugin_active('affiliate-egg/affiliate-egg.php')) ? Keywordrush\AffiliateEgg\TemplateHelper::formatPriceCurrency($offer_price_old, $re_egg_currency) : $re_egg_currency.$offer_price;    
    $offer_coupon = get_post_meta( get_the_ID(), 'affegg_product_product_coupon', true );
    $offer_coupon_date = get_post_meta( get_the_ID(), 'affegg_product_product_coupon_date', true );
    $offer_last_update = get_post_meta( get_the_ID(), 'affegg_product_last_update', true );
    $offer_coupon_mask = 1;
?>
<?php if(!empty($offer_coupon_date)) : ?>
    <?php
        $timestamp1 = strtotime($offer_coupon_date) + 86399;
        $seconds = $timestamp1 - time();
        $days = floor($seconds / 86400);
        $seconds %= 86400;
        if ($days > 0) {
            $coupon_style = '';
        }
        elseif ($days == 0){
            $coupon_style = '';
        }
        else {
            $coupon_text = __('Expired', 'rehub_framework');
            $coupon_style = 'expired_coupon';
        }
    ?>
<?php endif ;?>
<div class="priced_block clearfix">
    <?php if(!empty($offer_price) && $offer_price !='0' && $showme !='button') : ?>
        <span class="rh_price_wrapper">
            <span class="price_count">
                <ins><?php echo $offer_formated_price;?></ins>
                <?php if(!empty($offer_price_old) && $offer_price_old !='0') :?> <del><?php echo $offer_formated_priceold; ?></del><?php endif ;?>
            </span>
        </span>
    <?php endif ;?>
    <?php if(!empty($offer_last_update)) : ?>
        <span class="offer_last_update"><?php echo esc_html($offer_last_update) ?></span>
    <?php endif ;?>
    <?php if(!empty($offer_coupon) && $offer_coupon !='0') : ?>
        <div class="post_offer_anons">
            <?php wp_enqueue_script('zeroclipboard'); ?>
            <?php if ($offer_coupon_mask !='1' && $offer_coupon_mask !='on') :?>
                <div class="rehub_offer_coupon not_masked_coupon <?php if(!empty($offer_coupon_date)) {echo $coupon_style ;} ?>" data-clipboard-text="<?php echo $offer_coupon ?>"><i class="fa fa-scissors fa-rotate-180"></i><span class="coupon_text"><?php echo $offer_coupon ?></span></div>
            <?php else :?>
                <?php wp_enqueue_script('affegg_coupons'); ?>
                <span class="re_track_btn btn_offer_block rehub_offer_coupon masked_coupon <?php if(!empty($offer_coupon_date)) {echo $coupon_style ;} ?>" data-clipboard-text="<?php echo esc_html ($offer_coupon) ?>" data-codetext="<?php echo esc_html($offer_coupon)?>" data-dest="<?php echo esc_url($offer_url) ?>">
                <?php if(rehub_option('rehub_mask_text') !='') :?>
                    <?php echo rehub_option('rehub_mask_text') ; ?>
                <?php else :?>
                    <?php _e('Reveal coupon', 'rehub_framework') ?>
                <?php endif ;?>
                </span>
            <?php endif;?>
        </div>
    <?php else : ?>
        <?php if($showme !='price') : ?>
        <div>
            <a href="<?php echo $offer_url ?>" class="re_track_btn btn_offer_block" target="_blank" rel="nofollow">
                <?php if(rehub_option('rehub_btn_text') !='') :?>
                    <?php $btn_txt = rehub_option('rehub_btn_text') ; ?>
                <?php else :?>
                    <?php $btn_txt = __('Buy this item', 'rehub_framework') ;?>
                <?php endif ;?>
                <?php echo esc_html($btn_txt ) ;?>
            </a>
        </div>
        <?php endif; ?>
    <?php endif; ?>
</div>