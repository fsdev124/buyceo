<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php use ContentEgg\application\helpers\TemplateHelper;?>

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
    <?php $features = (!empty($item['extra']['itemAttributes']['Feature'])) ? $item['extra']['itemAttributes']['Feature'] : ''?>
    <?php $keyspecs = (!empty($item['extra']['keyspecs'])) ? $item['extra']['keyspecs'] : ''?>                         
    <?php $i++;?>  

    <div class="rehub_woo_review compact_w_deals">
        <div class="rehub_feat_block table_view_block">
            <div class="rehub_woo_review_tabs" style="display:table-row">
                <div class="offer_thumb">   
                    <a rel="nofollow" target="_blank" class="re_track_btn" href="<?php echo esc_url($afflink) ?>">
                        <?php WPSM_image_resizer::show_static_resized_image(array('src'=> $aff_thumb, 'width'=> 120, 'title' => $offer_title));?>                                   
                    </a> 
                    <?php if (!empty($item['extra']['itemLinks'][3])): ?>
                        <span class="add_wishlist_ce">
                            <a href="<?php echo $item['extra']['itemLinks'][3]['URL'];?>" rel="nofollow" target="_blank" ><i class="fa fa-heart-o"></i></a>
                        </span>
                    <?php endif; ?>                                                                  
                </div>
                <div class="desc_col">
                    <h4 class="offer_title">
                        <a rel="nofollow" target="_blank" class="re_track_btn" href="<?php echo esc_url($afflink) ?>">
                            <?php echo esc_attr($offer_title); ?>
                        </a>
                    </h4> 
                    <?php if($keyspecs):?>
                        <p class="featured_list">
                            <?php $total_spec = count($keyspecs); $count = 0;?>
                            <?php foreach ($keyspecs as $keyspec) :?>
                                <?php echo $keyspec; $count ++; ?><?php if ($count != $total_spec) :?>, <?php endif;?>
                            <?php endforeach; ?>   
                        </p>
                    <?php elseif ($features): ?>  
                        <ul class="featured_list">
                            <?php $length = $maxlength = 0;?>
                            <?php foreach ($features as $k => $feature): ?>
                                <?php if(is_array($feature)){continue;}?>
                                <?php $length = strlen($feature); $maxlength += $length; ?> 
                                <li><?php echo $feature; ?></li>
                                <?php if($k >= 4 || $maxlength > 200) break; ?>                                    
                        <?php endforeach; ?>
                        </ul> 
                    <?php elseif ($description): ?>
                        <p><?php kama_excerpt('maxchar=180&text='.$description); ?></p>
                    <?php endif; ?>  
                    <?php if (!empty($item['extra']['conditionDisplayName'])): ?>
                        <small class="small_size">
                        <?php _e('Condition: ', 'rehub_framework') ;?><span class="yes_available"><?php echo $item['extra']['conditionDisplayName'] ;?></span>
                        <br />
                        </small>
                    <?php endif; ?>
                    <?php if (!empty($item['extra']['totalUsed'])): ?>
                        <span class="new-or-used-amazon">
                        <?php echo $item['extra']['totalUsed']; ?>
                        <?php _e('used', 'rehub_framework'); ?> <?php _e('from', 'rehub_framework'); ?>
                            <?php echo TemplateHelper::formatPriceCurrency($item['extra']['lowestUsedPrice'], $item['currencyCode']); ?>
                        <br>
                        </span>
                    <?php endif; ?> 
                    <?php if (!empty($item['extra']['IsEligibleForSuperSaverShipping'])): ?>
                        <small class="small_size"><span class="yes_available"><?php _e('Free shipping', 'content-egg-tpl'); ?></span></small><br>
                    <?php endif; ?>
                    <?php if($module_id == 'Amazon'):?>
                        <div class="font80 rh_opacity_7">
                            <?php _e('Last update was in: ', 'rehub_framework'); ?><?php echo TemplateHelper::getLastUpdateFormatted('Amazon', $post_id); ?>
                        </div> 
                    <?php endif; ?>                                                                                 
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
                            </div>
                        <?php endif ;?>
                        <div>
                            <a class="re_track_btn btn_offer_block" href="<?php echo esc_url($afflink) ?>" target="_blank" rel="nofollow">
                                <?php echo $btn_txt ; ?>
                            </a>
                            <?php $logo = TemplateHelper::getMerhantLogoUrl($item, false);?>
                            <?php if(!empty($logo)) :?>
                                <div class="egg-logo mt10">
                                <img src="<?php echo esc_attr(TemplateHelper::getMerhantLogoUrl($item, true)); ?>" alt="<?php echo esc_attr($offer_title); ?>" />
                                </div>
                            <?php endif;?>                     
                        </div>
                    </div>
                </div>
            </div>                                             
        </div>
    </div>
    <div class="clearfix"></div>


<?php endforeach; ?>