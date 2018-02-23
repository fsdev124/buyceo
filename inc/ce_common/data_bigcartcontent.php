<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php use ContentEgg\application\helpers\TemplateHelper;?>

<div class="col_wrap_two">
    <div class="product_egg single_product_egg">

        <div class="image col_item">
            <a rel="nofollow" target="_blank" class="re_track_btn" href="<?php echo esc_url($afflink) ?>">
                <?php WPSM_image_resizer::show_static_resized_image(array('src'=> $aff_thumb, 'width'=> 500, 'title' => $offer_title));?>
                <?php if($percentageSaved) : ?>
                    <span class="sale_a_proc">
                        <?php    
                            echo '-'; echo $percentageSaved; echo '%';
                        ;?>
                    </span>
                <?php endif ;?>                                   
            </a>  
            <?php if (!empty($item['extra']['itemLinks'][3])): ?>
                <span class="add_wishlist_ce">
                    <a href="<?php echo $item['extra']['itemLinks'][3]['URL'];?>" rel="nofollow" target="_blank" ><i class="fa fa-heart-o"></i> <?php echo $item['extra']['itemLinks'][3]['Description'];?></a>
                </span>
            <?php endif; ?>                           
        </div>

        <div class="product-summary col_item">
        
            <?php if($showtitle == 1):?> 
                <h2 class="product_title entry-title">
                    <a rel="nofollow" target="_blank" class="re_track_btn" href="<?php echo esc_url($afflink) ?>">
                        <?php echo esc_attr($offer_title); ?> 
                    </a>
                </h2>
            <?php endif;?> 

            <?php  if ((int) $item['rating'] > 0 && (int) $item['rating'] <= 5): ?>
                <div class="cegg-rating">
                    <?php
                    echo str_repeat("<span>&#x2605;</span>", (int) $item['rating']);
                    echo str_repeat("<span>☆</span>", 5 - (int) $item['rating']);
                    ?>
                </div>
            <?php elseif (!empty($item['extra']['data']['rating'])): ?>
                <div class="cegg-rating">
                    <?php
                    echo str_repeat("<span>&#x2605;</span>", $item['extra']['data']['rating']);
                    echo str_repeat("<span>☆</span>", 5 - $item['extra']['data']['rating']);
                    ?>        
                </div>   
            <?php endif; ?>            

            <?php if($offer_price) : ?>
                <div class="deal-box-price">
                    <?php echo TemplateHelper::formatPriceCurrency($offer_price, $currency_code, '<span class="cur_sign">', '</span>'); ?>
                    <?php if($offer_price_old) : ?>
                    <span class="retail-old">
                      <strike><?php echo TemplateHelper::formatPriceCurrency($offer_price_old, $currency_code, '<span class="value">', '</span>'); ?></strike>
                    </span>
                    <?php endif ;?>                                      
                </div>                
            <?php endif ;?>

            <?php if($module_id == 'Ebay') : ?>
                <?php $time_left = TemplateHelper::getTimeLeft($item['extra']['listingInfo']['endTimeGmt']); ?>
                <small class="small_size">  
                    <?php if ($time_left): ?>
                        <span class="time_left_ce yes_available">
                            <i class="fa fa-clock-o"></i> <?php _e('Time left:', 'rehub_framework'); ?>
                            <span <?php if (strstr($time_left, __('m', 'content-egg-tpl'))) echo 'class="text-danger"'; ?>><?php echo $time_left; ?></span>
                        </span>
                        <br />
                    <?php else: ?>
                        <span class="time_left_ce">
                            <span class='text-warning'>
                                <?php _e('Ended:', 'rehub_framework'); ?>
                                <?php echo date('M j, H:i', strtotime($item['extra']['listingInfo']['endTime'])); ?> <?php echo $item['extra']['listingInfo']['timeZone']; ?>
                            </span>
                        </span>
                        <br />
                    <?php endif; ?>                                          
                    <?php if (!empty($item['extra']['conditionDisplayName'])): ?>
                        <?php _e('Condition: ', 'rehub_framework') ;?><span><?php echo $item['extra']['conditionDisplayName'] ;?></span>
                        <br />
                    <?php endif; ?>                        
                </small>
            <?php endif; ?>

            <?php if (!empty($item['extra']['totalNew'])): ?>
                <span class="new-or-used-amazon">
                <?php echo $item['extra']['totalNew']; ?>
                <?php _e('new', 'rehub_framework'); ?>
                <?php if($item['extra']['lowestNewPrice']): ?>
                    <?php _e(' from', 'rehub_framework'); ?>
                    <?php echo TemplateHelper::formatPriceCurrency($item['extra']['lowestNewPrice'], $item['currencyCode']); ?> 
                <?php endif; ?>
                <br>
                </span>
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
            <div class="buttons_col">
                <div class="priced_block clearfix">
                    <div>
                        <a class="re_track_btn btn_offer_block" href="<?php echo esc_url($afflink) ?>" target="_blank" rel="nofollow">
                            <?php echo $btn_txt ; ?>
                        </a>                                                
                    </div>
                </div>
                <span class="aff_tag">
                    <img src="<?php echo esc_attr(TemplateHelper::getMerhantIconUrl($item, true)); ?>" alt="<?php echo $module_id;?>" />
                    <?php if ($merchant):?>
                        <?php echo esc_html($merchant); ?>
                    <?php elseif($domain):?>
                        <?php echo esc_html($domain); ?>                                      
                    <?php endif;?>
                </span>                
            </div> 

            <div class="font80 rh_opacity_7 mb15"><?php _e('Last update was in: ', 'rehub_framework'); ?><?php echo TemplateHelper::getLastUpdateFormatted($module_id, $post_id); ?></div>    

            <?php if ($features): ?>  
                <p>
                    <ul class="featured_list">
                        <?php $length = $maxlength = 0;?>
                        <?php foreach ($item['extra']['itemAttributes']['Feature'] as $k => $feature): ?>
                            <?php if(is_array($feature)){continue;}?>
                            <?php $length = strlen($feature); $maxlength += $length; ?> 
                            <li><?php echo $feature; ?></li>
                            <?php if($k >= 5 || $maxlength > 400) break; ?>                                    
                    <?php endforeach; ?>
                    </ul>
                </p>
            <?php elseif($keyspecs):?>
                <p>
                    <ul class="featured_list">
                        <?php foreach ($keyspecs as $keyspec) :?>
                            <li><?php echo $keyspec; ?></li>
                        <?php endforeach; ?>   
                    </ul>
                </p>                
            <?php elseif ($description): ?>
                <p><?php echo $description; ?></p>                                                   
            <?php endif; ?>              
        </div>           
    </div> 
</div>  
<div class="clearfix"></div>   