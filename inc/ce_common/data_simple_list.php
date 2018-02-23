<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php use ContentEgg\application\helpers\TemplateHelper;?>

<?php $product_update = TemplateHelper::getLastUpdateFormatted($module_id, $post_id);?>

<div class="egg_sort_list re_sort_list simple_sort_list mb20">
    <div class="aff_offer_links">
        <?php $i=0; foreach ($items as $key => $item): ?>
            <?php $domain = $merchant = '';?>
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
            <?php $i++;?>
            <div class="table_view_block<?php if ($i == 1){echo' best_price_item';}?>">               
                <div class="offer_thumb">   
                    <a rel="nofollow" target="_blank" class="re_track_btn" href="<?php echo esc_url($afflink) ?>">
                        <?php WPSM_image_resizer::show_static_resized_image(array('src'=> $aff_thumb, 'height'=> 100, 'title' => $offer_title, 'no_thumb_url' => get_template_directory_uri().'/images/default/noimage_100_70.png'));?>                                    
                    </a>
                </div>
                <div class="desc_col desc_simple_col">
                    <div class="simple_title mb15">
                        <a rel="nofollow" target="_blank" class="re_track_btn" href="<?php echo esc_url($afflink) ?>">
                            <?php echo esc_attr($offer_title); ?>
                        </a>
                    </div>
                    <?php if (!empty($item['extra']['totalUsed'])): ?>
                        <div class="mb5 font80 lineheight15 rh_opacity_7">
                        <?php echo $item['extra']['totalUsed']; ?>
                        <?php _e('used', 'rehub_framework'); ?> <?php _e('from', 'rehub_framework'); ?>
                            <?php echo TemplateHelper::formatPriceCurrency($item['extra']['lowestUsedPrice'], $item['currencyCode']); ?>
                        </div>
                    <?php endif; ?>                                                   
                </div>                    
                <div class="desc_col price_simple_col">
                    <?php if($offer_price) : ?>
                        <p>
                            <span class="price_count">
                                <?php echo TemplateHelper::formatPriceCurrency($offer_price, $currency_code, '<span class="cur_sign">', '</span>'); ?>
                                <?php if(!empty($offer_price_old)) : ?>
                                <strike>
                                    <span class="amount"><?php echo TemplateHelper::formatPriceCurrency($offer_price_old, $currency_code, '<span class="value">', '</span>'); ?></span>
                                </strike>
                                <?php endif ;?>                                      
                            </span>                      
                        </p>
                    <?php endif ;?>                        
                </div>
                <div class="buttons_col">
                    <div class="priced_block clearfix">
                        <a class="re_track_btn btn_offer_block" href="<?php echo esc_url($afflink) ?>" target="_blank" rel="nofollow">
                            <?php echo $btn_txt ; ?>
                        </a>                                                        
                    </div>
                    <?php if($module_id == 'Amazon'):?>
                        <div class="font70 mb15"><?php echo $product_update = TemplateHelper::getLastUpdateFormatted($module_id, get_the_ID());?></div>
                    <?php endif;?>                    
                    <?php if(!empty($logo)) :?>
                        <div class="egg-logo"><img src="<?php echo $logo; ?>" alt="<?php echo esc_attr($offer_title); ?>" /></div>
                    <?php else :?>
                        <div class="aff_tag">
                            <img src="<?php echo esc_attr(TemplateHelper::getMerhantIconUrl($item, true)); ?>" alt="<?php echo $module_id;?>" />
                            <?php if ($merchant):?>
                                <?php echo esc_html($merchant); ?>
                            <?php elseif($domain):?>
                                <?php echo esc_html($domain); ?>                                     
                            <?php endif;?>
                        </div>
                    <?php endif ;?>              
                </div>                                           
            </div>
        <?php endforeach; ?>               
    </div>
    <?php if (!empty($product_update)) :?>
        <div class="last_update"><?php _e('Last update was on: ', 'rehub_framework'); ?><?php echo $product_update;?></div>
    <?php endif ;?>    
</div>
<div class="clearfix"></div>