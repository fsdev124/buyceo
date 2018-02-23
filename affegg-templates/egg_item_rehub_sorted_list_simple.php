<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php
/*
  Name: Sorted list without description
 */
  use Keywordrush\AffiliateEgg\TemplateHelper; 
?>
<?php if (isset($title) && $title): ?>
    <h3 class="cegg-shortcode-title"><?php echo esc_html($title); ?></h3>
<?php endif; ?>
<?php
// sort items by price
usort($items, function($a, $b) {
    if (!$a['price_raw']) return 1;
    if (!$b['price_raw']) return -1;
    return $a['price_raw'] - $b['price_raw'];
});
$product_price_update = $items[0]['last_update'];
?>

<div class="egg_sort_list simple_sort_list re_sort_list"><a name="aff-link-list"></a>
    <div class="aff_offer_links">
        <?php $i=0; foreach ($items as $key => $item): ?>
            <?php $offer_price = (!empty($item['price'])) ? $item['price'] : ''; ?>
            <?php $offer_price_old = (!empty($item['price'])) ? $item['old_price'] : ''; ?>
            <?php $offer_post_url = $item['url'] ;?>
            <?php $afflink = apply_filters('rh_post_offer_url_filter', $offer_post_url );?>
            <?php $aff_thumb = $item['img'] ;?>
            <?php $offer_title = wp_trim_words( $item['title'], 10, '...' ); ?>
            <?php $i++;?>  
            <?php if(rehub_option('rehub_btn_text') !='') :?><?php $btn_txt = rehub_option('rehub_btn_text') ; ?><?php else :?><?php $btn_txt = __('Buy this item', 'rehub_framework') ;?><?php endif ;?>  
            <div class="table_view_block<?php if ($i == 1){echo' best_price_item';}?>">
                
                    <div class="offer_thumb">   
                        <a rel="nofollow" target="_blank" class="re_track_btn" href="<?php echo esc_url($afflink) ?>"<?php echo $item['ga_event'] ?>>
                            <?php WPSM_image_resizer::show_static_resized_image(array('src'=> $aff_thumb, 'height'=> 100, 'title' => $offer_title, 'no_thumb_url' => get_template_directory_uri().'/images/default/noimage_100_70.png'));?>                                    
                        </a>
                    </div>
                    <div class="desc_col desc_simple_col">
                        <div class="simple_title">
                            <a rel="nofollow" target="_blank" class="re_track_btn" href="<?php echo esc_url($afflink) ?>"<?php echo $item['ga_event'] ?>>
                                <?php echo esc_attr($offer_title); ?>
                            </a>
                        </div>                                
                    </div>                    
                    <div class="desc_col price_simple_col">
                        <?php if(!empty($offer_price)) : ?>
                            <div class="rh_price_wrapper">
                                <span class="price_count">
                                    <?php echo TemplateHelper::formatPriceCurrency($item['price_raw'], $item['currency_code'], '', ''); ?>
                                    <?php if(!empty($offer_price_old)) : ?>
                                        <strike><?php echo TemplateHelper::formatPriceCurrency($item['old_price_raw'], $item['currency_code'], '', ''); ?></strike>
                                    <?php endif ;?>                                      
                                </span>                         
                            </div>
                        <?php endif ;?>                        
                    </div>
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
                        <div class="aff_tag"><?php echo rehub_get_site_favicon($item['orig_url']); ?></div> 
                        <small class="small_size available_stock"><?php if ($item['in_stock']): ?><span class="yes_available"><?php _e('In stock', 'rehub_framework') ;?></span><?php endif; ?></small>                        
                    </div>
                                                                          
            </div>
        <?php endforeach; ?>                 
    </div>
    <?php if (!empty($product_price_update)) :?>
        <div class="last_update"><?php _e('Last price update: ', 'rehub_framework'); ?><?php echo $product_price_update ;?></div>
    <?php endif ;?>
    <?php if ($see_more_uri): ?>
            <div class="text-center see-more-cat"> 
                <a rel="nofollow" target="_blank" href="<?php echo $see_more_uri; ?>"><?php _e('See more from category', 'rehub_framework');?></a>
            </div>
    <?php endif; ?>    
</div>
<div class="clearfix"></div>