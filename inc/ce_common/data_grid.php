<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php use ContentEgg\application\helpers\TemplateHelper;?>

<?php
$product_update = TemplateHelper::getLastUpdateFormatted($module_id, $post_id);
usort($items, function($a, $b) {
    if (!$a['price']) return 1;
    if (!$b['price']) return -1;
    return ($a['price'] < $b['price']) ? -1 : 1;
});
?>
<?php  wp_enqueue_script('masonry'); wp_enqueue_script('imagesloaded'); wp_enqueue_script('masonry_init'); ?>
<?php $columns_class = ($columnsgrid == 4) ? 'col_wrap_fourth' : 'col_wrap_three';?>
<div class="masonry_grid_fullwidth mb0 egg_grid <?php echo $columns_class;?>">
    <?php $i=0; foreach ($items as $key => $item): ?>
        <?php $domain = $merchant = '';?>
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
<?php if (!empty($product_update)) :?>
    <div class="last_update font80 rh_opacity_7 mb30">
        <?php _e('Last update was on: ', 'rehub_framework'); ?><?php echo $product_update;?>
    </div>
<?php endif ;?>
<div class="clearfix"></div>