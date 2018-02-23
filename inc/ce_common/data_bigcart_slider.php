<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php  wp_enqueue_script('flexslider'); ?>
<div class="flexslider post_slider media_slider blog_slider egg_cart_slider loading">
    <ul class="slides"> 
        <?php foreach ($items as $item): ?>
            <?php $offer_post_url = $item['url'] ;?>
            <?php $afflink = apply_filters('rh_post_offer_url_filter', $offer_post_url );?>
            <?php $aff_thumb = $item['img'] ;?>
            <?php $merchant = (!empty($item['merchant'])) ? $item['merchant'] : ''; ?> 
            <?php if (!empty($item['domain'])):?>
                <?php $domain = $item['domain'];?>
            <?php elseif (!empty($item['extra']['domain'])):?>
                <?php $domain = $item['extra']['domain'];?>
            <?php endif;?>
            <?php $offer_title = wp_trim_words( $item['title'], 20, '...' ); ?>  
            <?php if(rehub_option('rehub_btn_text') !='') :?>
                <?php $btn_txt = rehub_option('rehub_btn_text') ; ?>
            <?php else :?>
                <?php $btn_txt = __('Buy this item', 'rehub_framework') ;?>
            <?php endif ;?>
            <?php $percentageSaved = (!empty($item['percentageSaved'])) ? $item['percentageSaved'] : '';?>
            <?php $availability = (!empty($item['availability'])) ? $item['availability'] : '';?> 
            <?php $offer_price = (!empty($item['price'])) ? $item['price'] : ''; ?>
            <?php $offer_price_old = (!empty($item['priceOld'])) ? $item['priceOld'] : ''; ?>
            <?php $currency = (!empty($item['currency'])) ? $item['currency'] : ''; ?>
            <?php $currency_code = (!empty($item['currencyCode'])) ? $item['currencyCode'] : ''; ?>
            <?php $description = (!empty($item['description'])) ? $item['description'] : '';?>
            <?php $features = (!empty($item['extra']['itemAttributes']['Feature'])) ? $item['extra']['itemAttributes']['Feature'] : ''?>
            <?php $keyspecs = (!empty($item['extra']['keyspecs'])) ? $item['extra']['keyspecs'] : ''?>
            <?php $showtitle = 1; ?>
            <li>
                <?php include(rh_locate_template('inc/ce_common/data_bigcartcontent.php')); ?>
            </li>
        <?php endforeach; ?> 
    </ul>
</div>