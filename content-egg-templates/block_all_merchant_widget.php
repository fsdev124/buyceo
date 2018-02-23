<?php
/*
 * Name: List widget with merchants
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
<?php if(!empty($all_items)):?>

    <?php $postid = (isset($post_id)) ? $post_id : get_the_ID();?>
    <?php if (get_post_type($postid) == 'product'):?>
        <?php $itemsync = \ContentEgg\application\WooIntegrator::getSyncItem($postid);
            $unique_id = $itemsync['unique_id']; $module_id = $itemsync['module_id'];?>
    <?php else:?>
        <?php $unique_id = get_post_meta($postid, '_rehub_product_unique_id', true);?>
        <?php $module_id = get_post_meta($postid, '_rehub_module_ce_id', true);?>
    <?php endif;?>
    <?php $syncitem = ($unique_id) ? $data[$module_id][$unique_id] : '';?>

    <?php $rand = uniqid();?>
    <?php $countitems = count($all_items);?>
    <?php if ($unique_id && $module_id && !empty($syncitem)) :?>
        <?php include(rh_locate_template( 'inc/parts/pricealertpopup.php' ) ); ?>                                
    <?php endif;?>
    <div class="widget_merchant_list<?php if ($countitems > 7):?> expandme<?php endif;?>">
        <div class="tabledisplay">
            <?php  foreach ($all_items as $key => $item): ?>
                <?php $offer_post_url = $item['url'] ;?>
                <?php $afflink = apply_filters('rh_post_offer_url_filter', $offer_post_url );?>
                <?php $merchant = (!empty($item['merchant'])) ? $item['merchant'] : ''; ?>
                <?php $offer_price = (!empty($item['price'])) ? $item['price'] : ''; ?>
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
                <?php if(rehub_option('rehub_btn_text') !='') :?><?php $btn_txt = rehub_option('rehub_btn_text') ; ?><?php else :?><?php $btn_txt = __('See it', 'rehub_framework') ;?><?php endif ;?>  
                <div class="table_merchant_list module_class_<?php echo $modulecode;?>">               
                    <div class="merchant_thumb">   
                        <a rel="nofollow" target="_blank" href="<?php echo esc_url($afflink) ?>" class="re_track_btn">
                            <img src="<?php echo esc_attr(TemplateHelper::getMerhantIconUrl($item, true)); ?>" alt="<?php echo $modulecode;?>" />
                            <?php if (!empty($merchant)):?>
                                <?php echo esc_html($merchant); ?>
                            <?php elseif(!empty($domain)):?>
                                <?php echo esc_html($domain); ?>                                      
                            <?php endif;?>                                                          
                        </a>
                    </div>                  
                    <div class="price_simple_col">
                        <?php if(!empty($item['price'])) : ?>
                            <div>
                                <a rel="nofollow" target="_blank" href="<?php echo esc_url($afflink) ?>" class="re_track_btn">
                                    <span class="val_sim_price">
                                        <?php echo TemplateHelper::formatPriceCurrency($offer_price, $currency_code); ?>
                                    </span>
                                    <?php if (!empty($item['extra']['totalUsed'])): ?>
                                        <span class="val_sim_price_used_merchant">
                                        <?php echo $item['extra']['totalUsed']; ?>
                                        <?php _e('used', 'rehub_framework'); ?> <?php _e('from', 'rehub_framework'); ?>
                                            <?php echo TemplateHelper::formatPriceCurrency($item['extra']['lowestUsedPrice'], $item['currencyCode']); ?>
                                        </span>
                                    <?php endif; ?>                                                           
                                </a>                       
                            </div>
                        <?php endif ;?>                       
                    </div>
                    <div class="buttons_col">
                        <a class="re_track_btn" href="<?php echo esc_url($afflink) ?>" target="_blank" rel="nofollow">
                            <?php echo $btn_txt ; ?>
                        </a>                        			                        
                    </div>
                                                                              
                </div>
            <?php endforeach; ?> 
        </div>     
        <div class="additional_line_merchant flowhidden">
            <?php if ($countitems > 7):?>
            <span class="expand_all_offers"><?php _e('Show all', 'rehub_framework');?> <span class="expandme">+</span></span>
            <?php endif;?>
            <?php if ($unique_id && $module_id && !empty($syncitem)) {
                include(rh_locate_template( 'inc/parts/pricehistorypopup.php' ) );
            } ?>    
        </div>         
    </div>
    <div class="clearfix"></div>
    <?php $product_update = TemplateHelper::getLastUpdateFormatted('Amazon', $postid);?>
    <?php if($product_update):?>
        <div class="font60 lineheight20"><?php _e('Last Amazon price update was:', 'rehub_framework');?> <?php echo $product_update;?> <span class="csspopuptrigger" data-popup="ce-amazon-disclaimer">(<?php _e('Info', 'rehub_framework');?>)</span></div>
        <div class="csspopup" id="ce-amazon-disclaimer">
            <div class="csspopupinner">
                <span class="cpopupclose" href="#">×</span>
                <?php _e('Product prices and availability are accurate as of the date/time indicated and are subject to change. Any price and availability information displayed on Amazon.com (Amazon.in, Amazon.co.uk, Amazon.de, etc) at the time of purchase will apply to the purchase of this product.', 'rehub_framework');?>
            </div>
        </div>
    <?php endif;?>                
<?php endif;?>