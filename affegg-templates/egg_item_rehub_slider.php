<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php
/*
  Name: Slider
 */
use Keywordrush\AffiliateEgg\TemplateHelper;   
?>
<?php if (isset($title) && $title): ?>
    <h3 class="cegg-shortcode-title"><?php echo esc_html($title); ?></h3>
<?php endif; ?>
<?php
//$product_price_update = get_post_meta( get_the_ID(), 'affegg_product_last_update', true );
//$best_price_value = $items[0]['price'];
//$best_price_currency = $items[0]['currency'];
?>
<?php  wp_enqueue_script('flexslider'); ?>

<div class="post_slider media_slider blog_slider egg_cart_slider loading">
    <ul class="slides">        
        <?php foreach ($items as $item): ?>
            <?php $offer_price = (!empty($item['price'])) ? $item['price'] : ''; ?>
            <?php $offer_price_old = (!empty($item['price'])) ? $item['old_price'] : ''; ?>
            <?php $offer_post_url = $item['url'] ;?>
            <?php $afflink = apply_filters('rh_post_offer_url_filter', $offer_post_url );?>
            <?php $aff_thumb = $item['img'] ;?>
            <?php $offer_title = wp_trim_words( $item['title'], 20, '...' ); ?>
            <?php $offer_desc = $item['description'] ;?>  
            <?php if(rehub_option('rehub_btn_text') !='') :?><?php $btn_txt = rehub_option('rehub_btn_text') ; ?><?php else :?><?php $btn_txt = __('Buy this item', 'rehub_framework') ;?><?php endif ;?>   
        <li>
            <div class="col_wrap_two">
                <div class="product_egg">
                    <div class="image col_item">
                        <?php if(!empty($offer_price_old) && $offer_price_old !='0') : ?>
                            <span class="sale_a_proc">
                                <?php   
                                    $offer_price_calc = intval(str_replace(',', '', $item['price']));
                                    $offer_price_old_calc = intval(str_replace(',', '', $item['old_price']));
                                    $sale_proc = 0 -(100 - ($offer_price_calc / $offer_price_old_calc) * 100); 
                                    $sale_proc = round($sale_proc); 
                                    echo $sale_proc; echo '%';
                                ;?>
                            </span>
                        <?php endif ;?>                     
                        <a rel="nofollow" target="_blank" class="re_track_btn" href="<?php echo esc_url($afflink) ?>"<?php echo $item['ga_event'] ?>>
                            <?php WPSM_image_resizer::show_static_resized_image(array('src'=> $aff_thumb, 'width'=> 500, 'title' => $offer_title, 'no_thumb_url' => get_template_directory_uri().'/images/default/noim_gray.png'));?> 
                            <span class="show_more_images"><?php _e('Show more images', 'rehub_framework'); ?></span>                                   
                        </a>
                    </div>

                    <div class="product-summary col_item">
                    
                        <h2 class="product_title entry-title"><?php echo esc_attr($offer_title); ?> </h2>

                        <?php if(!empty($offer_price)) : ?>
                            <div class="deal-box-price">
                                <?php $format_offer_price = $offer_price; ?>
                                <?php echo TemplateHelper::formatPriceCurrency($item['price_raw'], $item['currency_code'], '', ''); ?>
                                <?php if(!empty($offer_price_old)) : ?>
                                <span class="retail-old">
                                    <strike><?php echo TemplateHelper::formatPriceCurrency($item['old_price_raw'], $item['currency_code'], '', ''); ?></strike>
                                </span>
                                <?php endif ;?>                                       
                            </div>                
                        <?php endif ;?>

                        <?php if ($offer_desc): ?>
                            <p><?php rehub_truncate('maxchar=200&text='.$offer_desc.''); ?></p>
                            <small class="small_size"><?php if ($item['in_stock']): ?><?php _e('Available: ', 'rehub_framework') ;?><span class="yes_available"><?php _e('In stock', 'rehub_framework') ;?></span><?php endif; ?></small>
                        <?php endif; ?>             

                        <div class="buttons_col">
                            <div class="priced_block clearfix">
                                <div>
                                    <a class="re_track_btn btn_offer_block" href="<?php echo esc_url($afflink) ?>"<?php echo $item['ga_event'] ?> target="_blank" rel="nofollow">
                                        <?php echo $btn_txt ; ?>
                                    </a>
                                    <?php $offer_coupon_mask = 1 ?>
                                    <?php if(!empty($item['extra']['coupon']['code_date'])) : ?>
                                        <?php 
                                        $timestamp1 = strtotime($item['extra']['coupon']['code_date']); 
                                        $seconds = $timestamp1 - time(); 
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
                                          $coupon_text = __('Coupon is Expired', 'rehub_framework');
                                          $coupon_style = 'expired_coupon';
                                        }                 
                                        ?>
                                    <?php endif ;?>
                                    <?php  if(!empty($item['extra']['coupon']['code'])) : ?>
                                        <?php wp_enqueue_script('zeroclipboard'); ?>
                                        <?php if ($offer_coupon_mask !='1' && $offer_coupon_mask !='on') :?>
                                            <div class="rehub_offer_coupon not_masked_coupon <?php if(!empty($item['extra']['coupon']['code_date'])) {echo $coupon_style ;} ?>" data-clipboard-text="<?php echo $item['extra']['coupon']['code'] ?>"><i class="fa fa-scissors fa-rotate-180"></i><span class="coupon_text"><?php echo $item['extra']['coupon']['code'] ?></span></div>   
                                        <?php else :?>
                                            <?php wp_enqueue_script('affegg_coupons'); ?>
                                            <div class="rehub_offer_coupon masked_coupon <?php if(!empty($item['extra']['coupon']['code_date'])) {echo $coupon_style ;} ?>" data-clipboard-text="<?php echo $item['extra']['coupon']['code'] ?>" data-codetext="<?php echo $item['extra']['coupon']['code'] ?>" data-dest="<?php echo esc_url($item['url']) ?>"<?php echo $item['ga_event'] ?>><?php if(rehub_option('rehub_mask_text') !='') :?><?php echo rehub_option('rehub_mask_text') ; ?><?php else :?><?php _e('Reveal coupon', 'rehub_framework') ?><?php endif ;?><i class="fa fa-external-link-square"></i></div>   
                                        <?php endif;?>
                                        <?php if(!empty($item['extra']['coupon']['code_date'])) {echo '<div class="time_offer">'.$coupon_text.'</div>';} ?>    
                                    <?php endif ;?>                                                  
                                </div>
                            </div>
                            <span class="aff_tag"><?php echo rehub_get_site_favicon($item['orig_url']); ?></span>                            
                        </div> 
                    </div>           
                </div> 
            </div>  
        </li>
        <?php endforeach; ?>                   
    </ul>
</div>