<?php
/*
 * Name: List widget with store logos
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

<div class="widget_logo_list">
    
    <?php  foreach ($all_items as $key => $item): ?>
        <?php $offer_post_url = $item['url'] ;?>
        <?php $afflink = apply_filters('rh_post_offer_url_filter', $offer_post_url );?>
        <?php $aff_thumb = $item['img'] ;?>
        <?php $offer_title = wp_trim_words( $item['title'], 10, '...' ); ?>
        <?php $merchant = (!empty($item['merchant'])) ? $item['merchant'] : ''; ?>
        <?php $manufacturer = (!empty($item['manufacturer'])) ? $item['manufacturer'] : ''; ?>
        <?php $offer_price = (!empty($item['price'])) ? $item['price'] : ''; ?>
        <?php $offer_price_old = (!empty($item['priceOld'])) ? $item['priceOld'] : ''; ?> 
        <?php $currency_code = (!empty($item['currencyCode'])) ? $item['currencyCode'] : ''; ?>
        <?php $modulecode = (!empty($item['module_id'])) ? $item['module_id'] : ''; ?>        
        <?php if (!empty($item['domain'])):?>
            <?php $domain = $item['domain'];?>
        <?php elseif (!empty($item['extra']['domain'])):?>
            <?php $domain = $item['extra']['domain'];?>
        <?php else:?>
            <?php $domain = '';?>        
        <?php endif;?>    
        <?php $domain = rh_fix_domain($merchant, $domain);?> 
        <?php if(empty($merchant) && !empty($domain)) {
            $merchant = $domain;
        }
        ?>
        <?php $logo = TemplateHelper::getMerhantLogoUrl($item, true);?>    
        <div class="table_div_list module_class_<?php echo $modulecode;?>">
            <a rel="nofollow" target="_blank" href="<?php echo esc_url($afflink) ?>" class="re_track_btn">               
                <div class="offer_thumb<?php if(!$logo) {echo ' nologo_thumb';}?>">   
                    <?php if($logo) :?>
                        <img src="<?php echo esc_attr(TemplateHelper::getMerhantLogoUrl($item, true)); ?>" alt="<?php echo esc_attr($offer_title); ?>" height="30" />
                    <?php endif ;?>                                                           
                </div>                  
                <div class="price_simple_col">
                    <?php if(!empty($item['price'])) : ?>
                        <div>
                            <span class="val_sim_price">
                                <?php echo TemplateHelper::formatPriceCurrency($offer_price, $currency_code); ?>
                            </span>
                            <?php if (!empty($item['extra']['totalUsed'])): ?>
                                <span class="val_sim_price_used_merchant">
                                <?php _e('Used', 'rehub_framework'); ?> - <?php echo TemplateHelper::formatPriceCurrency($item['extra']['lowestUsedPrice'], $item['currencyCode']); ?>
                                </span>
                            <?php endif; ?>                                                                       
                        </div>
                    <?php else:?>
                        -
                    <?php endif ;?> 
                    <span class="vendor_sim_price"><?php echo $merchant;?> </span>                       
                </div>
                <div class="buttons_col">
                    <i class="fa fa-chevron-circle-right" aria-hidden="true"></i>                        			
                </div>
            </a>                                                     
        </div>
    <?php endforeach; ?>                   
</div>
<div class="clearfix"></div>