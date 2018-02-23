<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php global $post;?>
<?php $postid = $post->ID; ?>
<?php $multiofferrows = get_post_meta($postid, 'rehub_multioffer_group', true);?>
<?php if(!empty($multiofferrows[0]['multioffer_url'])): //If multi offer is assigned?>
    <?php foreach ($multiofferrows as $key => $value):?>
        <?php if (isset($value['multioffer_brand']) && $value['multioffer_brand'] == $tagid):?>
            <?php           
                $brand_image_url = $brand_link = $brandtermname = $brandterm = '';
                $offer_post_url = (!empty($value['multioffer_url'])) ? $value['multioffer_url'] : '';
                $offer_url = apply_filters('rh_post_multioffer_url_filter', $offer_post_url );
                $offer_coupon = (!empty($value['multioffer_coupon'])) ? $value['multioffer_coupon'] : '';
                $offer_coupon_date = (!empty($value['multioffer_date'])) ? $value['multioffer_date'] : '';
                $offer_coupon_mask = (!empty($value['multioffer_mask'])) ? $value['multioffer_mask'] : '';
                $offer_price = (!empty($value['multioffer_price'])) ? $value['multioffer_price'] : '';
                $offer_price_old = (!empty($value['multioffer_price_old'])) ? $value['multioffer_price_old'] : '';
                $offer_btn_text = (!empty($value['multioffer_btn_text'])) ? $value['multioffer_btn_text'] : '';
                $offer_desc = (!empty($value['multioffer_desc'])) ? $value['multioffer_desc'] : '';
                $offer_title = (!empty($value['multioffer_name'])) ? $value['multioffer_name'] : '';
                $offer_badge = (!empty($value['featured_multioffer'])) ? $value['featured_multioffer'] : '';
                $offer_thumb = (!empty($value['multioffer_image'])) ? $value['multioffer_image'] : '';
                $offer_user = (!empty($value['multioffer_user'])) ? $value['multioffer_user'] : '';  
                include(rh_locate_template('inc/parts/multiofferpart.php'));
            ?>
        <?php endif;?>
    <?php endforeach;?>
<?php else: //If single offer?>
<?php $offer_post_url = esc_url(get_post_meta( $postid, 'rehub_offer_product_url', true ));?>
<?php $offer_url = apply_filters('rh_post_offer_url_filter', $offer_post_url ); ?>
<?php if(empty($offer_url)) {$offer_url = get_the_permalink($postid);}?>
<?php $offer_coupon = get_post_meta( $postid, 'rehub_offer_product_coupon', true ); ?>
<?php $offer_coupon_date = get_post_meta( $postid, 'rehub_offer_coupon_date', true ); ?>
<?php $offer_coupon_mask = get_post_meta( $postid, 'rehub_offer_coupon_mask', true ); ?>
<?php $offer_price = get_post_meta( $postid, 'rehub_offer_product_price', true );$offer_price = apply_filters('rehub_create_btn_price', $offer_price);?>
<?php $offer_price_old = get_post_meta( $postid, 'rehub_offer_product_price_old', true );$offer_price_old = apply_filters('rehub_create_btn_price_old', $offer_price_old);?>
<?php $offer_btn_text = get_post_meta( $postid, 'rehub_offer_btn_text', true );?>
<?php $offer_desc_meta = get_post_meta( $postid, 'rehub_offer_product_desc', true );?>
<?php $offer_title_meta = $offer_title = get_post_meta( $postid, 'rehub_offer_name', true );?>
<?php $offer_desc = (!empty($offer_desc_meta)) ? $offer_desc_meta : kama_excerpt('maxchar=150&echo=false');?>
<?php $offer_title = (!empty($offer_title_meta)) ? $offer_title_meta : get_the_title(); ?>
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
<?php $inner_link_enable = (isset($inner_link_enable)) ? $inner_link_enable : '';?>
<?php 
if ($inner_link_enable == '1') {
    $link = get_the_permalink();
    $target = '';    
}
else {
    $link = $offer_url;
    $target = ' rel="nofollow" target="_blank"';        
}
?>
<?php do_action('post_change_expired', $expired); //Here we update our expired?>
<?php $coupon_mask_enabled = (!empty($offer_coupon) && ($offer_coupon_mask =='1' || $offer_coupon_mask =='on') && $expired!='1') ? '1' : ''; ?>
<?php $reveal_enabled = ($coupon_mask_enabled =='1') ? ' reveal_enabled' : '';?>
<?php $outsidelinkpart = ($coupon_mask_enabled=='1') ? ' data-codeid="'.$postid.'" data-dest="'.$offer_url.'" data-clipboard-text="'.$offer_coupon.'" class="masked_coupon"' : '';?>
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
<div class="rehub_feat_block table_view_block <?php echo $reveal_enabled; echo $coupon_style; echo $deal_type; ?>">          
    <div class="block_with_coupon <?php echo $deal_type;?>">
        <div class="offer_thumb"> 
            <div class="deal_img_wrap">       
            <a href="<?php echo $link; ?>" <?php echo $target;?> <?php echo $outsidelinkpart; ?>>
            <?php if (!has_post_thumbnail() && !empty($offer_price_old) && !empty($offer_price)) :?>
                <?php           
                    $offer_pricesale = rehub_price_clean($offer_price); //Clean price from currence symbols
                    $offer_priceold = rehub_price_clean($offer_price_old); //Clean price from currence symbols
                    if ((int)$offer_priceold !='0' && is_numeric($offer_priceold) && (int)$offer_priceold > (int)$offer_pricesale) {
                        $off_proc = 0 -(100 - ((int)$offer_pricesale / (int)$offer_priceold) * 100);
                        $off_proc = round($off_proc);
                        echo '<span class="sale_tag_inwoolist"><h5>'.$off_proc.'%</h5></span>';
                    }
                ?>
            <?php else :?>
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
                <?php WPSM_image_resizer::show_static_resized_image(array('lazy'=> false, 'thumb'=> true, 'crop'=> false, 'height'=> 92));?>
            <?php endif;?>
            </a>
            <div class="<?php echo $deal_type;?>_deal_string text-center deal_string"><?php echo $deal_type_string;?></div>
            </div>

        </div>
        <div class="desc_col">             
            <h3><a href="<?php echo $link; ?>" <?php echo $target;?> <?php echo $outsidelinkpart; ?>><?php echo wp_trim_words( $offer_title, 10, '...' ) ;?></a></h3>
            <p>
                <?php echo (esc_html($offer_desc)); ?>
            </p>
            <div class="woolist_meta mb10">
                <?php meta_all(false, false, 'full', false);?>
                <span class="date_ago">
                    <i class="fa fa-clock-o"></i> <?php printf( __( '%s ago', 'rehub_framework' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) ); ?>
                </span>                                                  
            </div>
            <?php if(rehub_option('hotmeter_disable') !='1') :?><?php echo getHotThumb(get_the_ID(), false);?><?php endif ;?>
        </div>        
        <div class="buttons_col">
            <p>
                <span class="price_count">
                    <ins><?php echo esc_html($offer_price) ?></ins>
                    <?php if($offer_price_old !='') :?> <del><?php echo esc_html($offer_price_old) ; ?></del><?php endif ;?>
                </span>
            </p>        
            <div class="priced_block">
                <a href="<?php echo $link ?>" class="re_track_btn woo_loop_btn btn_offer_block" <?php echo $target;?>>
                    <?php if($offer_btn_text !='') :?>
                        <?php echo $offer_btn_text ; ?>
                    <?php elseif(rehub_option('rehub_btn_text') !='') :?>
                        <?php echo rehub_option('rehub_btn_text') ; ?>
                    <?php else :?>
                        <?php _e('Buy this item', 'rehub_framework') ?>
                    <?php endif ;?>
                </a>                                    
                <?php if ($coupon_mask_enabled =='1') :?>
                    <?php wp_enqueue_script('zeroclipboard'); ?>                
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
                <?php if(rehub_option('compare_btn_single') !='' && 'post' == get_post_type($post->ID)) :?>
                    <div class="clearfix"></div>
                    <?php $cmp_btn_args = array();?>
                    <?php if(rehub_option('compare_btn_cats') != '') {
                        $cmp_btn_args['cats'] = esc_html(rehub_option('compare_btn_cats'));
                    }?>
                    <?php echo wpsm_comparison_button($cmp_btn_args); ?> 
                <?php endif;?>
            </div>
        </div>
    </div>
</div>
<?php endif;?>