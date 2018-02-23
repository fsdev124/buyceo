<?php
/*
 * Name: Offers list from all affiliate modules
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
<div class="rehub_feat_block"><a name="aff-link-list"></a>
<div class="egg_sort_list re_sort_list simple_sort_list notitle_sort_list">
    <div class="aff_offer_links">
        <?php  foreach ($all_items as $key => $item): ?>
            <?php $offer_post_url = $item['url'] ;?>
            <?php $afflink = apply_filters('rh_post_offer_url_filter', $offer_post_url );?>
            <?php $aff_thumb = $item['img'] ;?>
            <?php $modulecode = (!empty($item['module_id'])) ? $item['module_id'] : ''; ?>            
            <?php $offer_title = wp_trim_words( $item['title'], 10, '...' ); ?>
            <?php $merchant = (!empty($item['merchant'])) ? $item['merchant'] : ''; ?>
            <?php $manufacturer = (!empty($item['manufacturer'])) ? $item['manufacturer'] : ''; ?>
            <?php if (!empty($item['domain'])):?>
                <?php $domain = $item['domain'];?>
            <?php elseif (!empty($item['extra']['domain'])):?>
                <?php $domain = $item['extra']['domain'];?>
            <?php else:?>
                <?php $domain = '';?>        
            <?php endif;?>              
            <?php $logo = TemplateHelper::getMerhantLogoUrl($item, true);?>
            <?php if(rehub_option('rehub_btn_text') !='') :?><?php $btn_txt = rehub_option('rehub_btn_text') ; ?><?php else :?><?php $btn_txt = __('Buy this item', 'rehub_framework') ;?><?php endif ;?>  
            <div class="table_view_block module_class_<?php echo $modulecode;?>">
                
                    <div class="offer_thumb">   
                        <a rel="nofollow" target="_blank" class="re_track_btn" href="<?php echo esc_url($afflink) ?>">
                            <?php WPSM_image_resizer::show_static_resized_image(array('src'=> $aff_thumb, 'height'=> 100, 'title' => $offer_title, 'no_thumb_url' => get_template_directory_uri().'/images/default/noimage_100_70.png'));?>                                    
                        </a>
                    </div>
                    <div class="desc_col desc_simple_col">
                        <div class="simple_title rehub-main-font">
                            <a rel="nofollow" target="_blank" class="re_track_btn" href="<?php echo esc_url($afflink) ?>">
                                <?php echo esc_attr($offer_title); ?>
                            </a>
                        </div>
                        <?php if (!empty($item['extra']['estimatedDeliveryTime'])): ?>
                            <small class="small_size">
                                <span class="yes_available"><?php echo $item['extra']['estimatedDeliveryTime'] ;?></span>
                            <br />
                            </small>
                        <?php endif; ?>                          
                        <?php if (!empty($item['extra']['offers'])): ?>
                            <?php $offers_flipkart = $item['extra']['offers'];?>
                            <?php foreach ($offers_flipkart as $offer_flipkart):?>
                                <div class="font80 flipkart_offers_extra lineheight15">
                                    <i class="fa fa-check-square-o greencolor" aria-hidden="true"></i> <span><?php echo $offer_flipkart;?></span>
                                </div>
                            <?php endforeach ;?>
                        <?php endif; ?>                              
                    </div>                    
                    <div class="desc_col price_simple_col">
                        <?php if(!empty($item['price'])) : ?>
                            <span class="price_count">
                                <?php echo TemplateHelper::formatPriceCurrency($item['price'], $item['currency'], '<span class="cur_sign">', '</span>'); ?>
                                <?php if(!empty($item['priceOld'])) : ?>
                                <strike>
                                    <span class="amount"><?php echo TemplateHelper::formatPriceCurrency($item['priceOld'], $item['currency']); ?></span>
                                </strike>
                                <?php endif ;?>                                      
                            </span>                   
                        <?php endif ;?> 
                        <?php if (!empty($item['extra']['totalUsed'])): ?>
                            <span class="val_sim_price_used_merchant">
                            <?php echo $item['extra']['totalUsed']; ?>
                            <?php _e('used', 'rehub_framework'); ?> <?php _e('from', 'rehub_framework'); ?>
                                <?php echo TemplateHelper::formatPriceCurrency($item['extra']['lowestUsedPrice'], $item['currencyCode']); ?>
                            </span>
                        <?php endif; ?>   
                        <?php if (!empty($item['extra']['totalNew'])): ?>
                            <br />
                            <span class="val_sim_price_used_merchant">
                                <?php echo $item['extra']['totalNew']; ?>
                                <?php _e('new', 'rehub_framework'); ?> 
                                <?php if ($item['extra']['lowestNewPrice']): ?>
                                     <?php _e('from', 'rehub_framework'); ?> <?php echo TemplateHelper::formatPriceCurrency($item['extra']['lowestNewPrice'], $item['currency']); ?>
                                <?php endif; ?>
                            </span>
                        <?php endif; ?>                                                                     
                    </div>
                    <div class="desc_col shop_simple_col">
                        <?php if($logo) :?>
                            <div class="egg-logo"><img src="<?php echo $logo; ?>" alt="<?php echo esc_attr($offer_title); ?>" width=70 /></div>
                        <?php elseif ($merchant) :?>
                            <div class="aff_tag"><?php echo $merchant; ?></div>
                        <?php elseif ($manufacturer) :?>
                            <div class="aff_tag"><?php echo $manufacturer; ?></div>                            
                        <?php endif ;?>                         
                    </div>
                    <div class="buttons_col">
                        <div class="priced_block clearfix">
                            <div>
                                <a class="re_track_btn btn_offer_block" href="<?php echo esc_url($afflink) ?>" target="_blank" rel="nofollow">
                                    <?php echo $btn_txt ; ?>
                                </a>                                                        
                            </div>
                        </div>
                    </div>
                                                                          
            </div>
        <?php endforeach; ?>               
    </div>    
</div>
</div>
<div class="clearfix"></div>