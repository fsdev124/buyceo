<?php
/*
 * Name: Offers grid from all affiliate modules
 * Modules:
 * Module Types: PRODUCT
 * 
 */
?>

<?php
use ContentEgg\application\helpers\TemplateHelper;
// sort items by price
?>      
<?php 
    $all_items = array(); 
    foreach ($data as $module_id => $items) {
        foreach ($items as $item_ar) {
            $item_ar['module_id'] = $module_id;
            $all_items[] = $item_ar;

        }       
    }
    usort($all_items, function($a, $b) {
        if (!$a['price']) return 1;
        if (!$b['price']) return -1;
        return ($a['price'] < $b['price']) ? -1 : 1;
    }); 
               
?>
<?php  wp_enqueue_script('masonry'); wp_enqueue_script('imagesloaded'); wp_enqueue_script('masonry_init'); ?>
<div class="masonry_grid_fullwidth col_wrap_fourth egg_grid">
<?php $i=0; foreach ($all_items as $key => $item): ?>
    <?php $offer_price = (!empty($item['price'])) ? $item['price'] : ''; ?>
    <?php $offer_price_old = (!empty($item['priceOld'])) ? $item['priceOld'] : ''; ?>
    <?php $currency_code = (!empty($item['currencyCode'])) ? $item['currencyCode'] : ''; ?>
    <?php $percentageSaved = (!empty($item['percentageSaved'])) ? $item['percentageSaved'] : ''; ?>
    <?php $availability = (!empty($item['availability'])) ? $item['availability'] : ''; ?>
    <?php $afflink = (!empty($item['url'])) ? $item['url'] : '' ;?>
    <?php $aff_thumb = (!empty($item['img'])) ? $item['img'] : '' ;?>
    <?php $offer_title = (!empty($item['title'])) ? wp_trim_words( $item['title'], 12, '...' ) : ''; ?>
    <?php $merchant = (!empty($item['merchant'])) ? $item['merchant'] : ''; ?> 
    <?php if (!empty($item['domain'])):?>
        <?php $domain = $item['domain'];?>
    <?php elseif (!empty($item['extra']['domain'])):?>
        <?php $domain = $item['extra']['domain'];?>
    <?php else:?>
        <?php $domain = '';?>
    <?php endif;?>     
    <?php if(rehub_option('rehub_btn_text') !='') :?><?php $btn_txt = rehub_option('rehub_btn_text') ; ?><?php else :?><?php $btn_txt = __('Buy this item', 'rehub_framework') ;?><?php endif ;?>
    <?php $i++;?>     
        
    <?php $offer_price = (!empty($item['price'])) ? $item['price'] : ''; ?>
    <?php $offer_price_old = (!empty($item['priceOld'])) ? $item['priceOld'] : ''; ?>
    <?php $currency_code = (!empty($item['currencyCode'])) ? $item['currencyCode'] : ''; ?>
    <?php $percentageSaved = (!empty($item['percentageSaved'])) ? $item['percentageSaved'] : ''; ?>
    <?php $availability = (!empty($item['availability'])) ? $item['availability'] : ''; ?>
    <?php $offer_post_url = $item['url'] ;?>
    <?php $afflink = apply_filters('rh_post_offer_url_filter', $offer_post_url );?>
    <?php $aff_thumb = (!empty($item['img'])) ? $item['img'] : '' ;?>
    <?php $offer_title = (!empty($item['title'])) ? wp_trim_words( $item['title'], 12, '...' ) : ''; ?>
    <?php $merchant = (!empty($item['merchant'])) ? $item['merchant'] : ''; ?> 
    <?php if (!empty($item['domain'])):?>
        <?php $domain = $item['domain'];?>
    <?php elseif (!empty($item['extra']['domain'])):?>
        <?php $domain = $item['extra']['domain'];?>
    <?php endif;?>     
    <?php if(rehub_option('rehub_btn_text') !='') :?><?php $btn_txt = rehub_option('rehub_btn_text') ; ?><?php else :?><?php $btn_txt = __('Buy this item', 'rehub_framework') ;?><?php endif ;?>
    <?php $i++;?>  
    <div class="small_post col_item">
        <figure>
            <?php if($percentageSaved) : ?>
                <span class="sale_a_proc">
                    <?php    
                        echo '-'; echo $percentageSaved; echo '%';
                    ;?>
                </span>
            <?php endif ;?>                 
            <a rel="nofollow" target="_blank" class="re_track_btn" href="<?php echo esc_url($afflink) ?>">
                <?php WPSM_image_resizer::show_static_resized_image(array('src'=> $aff_thumb, 'width'=> 336, 'title' => $offer_title, 'no_thumb_url' => get_template_directory_uri().'/images/default/noimage_336_220.png'));?>                                    
            </a>
        </figure>
        <div class="affegg_grid_title">
            <a rel="nofollow" target="_blank" class="re_track_btn" href="<?php echo esc_url($afflink) ?>">
                <?php echo esc_attr($offer_title); ?>
            </a>
        </div>
        <div class="buttons_col">
            <div class="priced_block clearfix">
                <?php if(!empty($offer_price)) : ?>
                    <div class="rh_price_wrapper">
                        <span class="price_count">
                            <ins>                        
                                <?php echo TemplateHelper::formatPriceCurrency($offer_price, $currency_code, '<span class="cur_sign">', '</span>'); ?>
                            </ins>
                            <?php if(!empty($offer_price_old)) : ?>
                            <del>
                                <span class="amount">
                                    <?php echo TemplateHelper::formatPriceCurrency($offer_price_old, $currency_code, '<span class="value">', '</span>'); ?>
                                </span>
                            </del>
                            <?php endif ;?>                                      
                        </span>
                        <?php if (!empty($item['extra']['totalUsed'])): ?>
                            <span class="val_sim_price_used_merchant">
                            <?php echo $item['extra']['totalUsed']; ?>
                            <?php _e('used', 'rehub_framework'); ?> <?php _e('from', 'rehub_framework'); ?>
                                <?php echo TemplateHelper::formatPriceCurrency($item['extra']['lowestUsedPrice'], $item['currencyCode']); ?>
                            </span>
                        <?php endif; ?>                                                  
                    </div>
                <?php endif ;?>                 
                <div>
                    <a class="re_track_btn btn_offer_block" href="<?php echo esc_url($afflink) ?>" target="_blank" rel="nofollow">
                        <?php echo $btn_txt ; ?>
                    </a> 
                    <div class="aff_tag mt10 small_size">
                        <img src="<?php echo esc_attr(TemplateHelper::getMerhantIconUrl($item, true)); ?>" alt="<?php echo esc_attr($module_id);?>" />
                        <?php if ($merchant):?>
                            <?php echo esc_html($merchant); ?>
                        <?php elseif($domain):?>
                            <?php echo esc_html($domain); ?>                                     
                        <?php endif;?>                            
                    </div>                            
                </div>
            </div>
        </div>            
    </div>
           
<?php endforeach; ?> 
</div>  
<div class="clearfix"></div>