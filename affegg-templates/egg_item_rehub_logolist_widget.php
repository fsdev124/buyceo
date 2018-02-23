<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php
/*
  Name: List widget with store logos 
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
<div class="widget_logo_list">    
    <?php $i=0; foreach ($items as $key => $item): ?>
        <?php $offer_price = (!empty($item['price'])) ? $item['price'] : ''; ?>
        <?php $offer_price_old = (!empty($item['price'])) ? $item['old_price'] : ''; ?>
        <?php $afflink = $item['url']; $domain = str_ireplace('www.', '', parse_url($item['orig_url'], PHP_URL_HOST)); ?>
        <?php $offer_title = wp_trim_words( $item['title'], 10, '...' ); ?>
        <?php $aff_thumb = rh_ae_logo_get($item['orig_url']); if (empty($aff_thumb)) {$aff_thumb = $item['img'];} ?>
        <?php $i++;?>  
        <?php if(rehub_option('rehub_btn_text') !='') :?><?php $btn_txt = rehub_option('rehub_btn_text') ; ?><?php else :?><?php $btn_txt = __('See it', 'rehub_framework') ;?><?php endif ;?>  
        <div class="table_div_list<?php if ($i == 1){echo' best_price_item';}?>">
            <a rel="nofollow" class="re_track_btn" target="_blank" href="<?php echo esc_url($afflink) ?>"<?php echo $item['ga_event'] ?>>               
                <div class="offer_thumb">   
                    <?php WPSM_image_resizer::show_static_resized_image(array('src'=> $aff_thumb, 'lazy'=>false, 'height'=> 35, 'title' => $offer_title, 'crop'=>false, 'no_thumb_url' => get_template_directory_uri().'/images/default/noimage_100_70.png'));?>                      
                </div>                  
                <div class="price_simple_col">
                    <?php if(!empty($offer_price)) : ?>
                        <div>
                            <?php echo TemplateHelper::formatPriceCurrency($item['price_raw'], $item['currency_code'], '', ''); ?>                                                             
                        </div>
                    <?php endif ;?> 
                    <span class="vendor_sim_price"><?php echo $domain;?> </span>                       
                </div>
                <div class="buttons_col">
                    <i class="fa fa-chevron-circle-right" aria-hidden="true"></i>                       			
                </div>
            </a>                                                
        </div>
    <?php endforeach; ?>                 
    <?php if (!empty($product_price_update)) :?>
        <div class="last_update"><?php _e('Last price update: ', 'rehub_framework'); ?><?php echo $product_price_update ;?></div>
    <?php endif ;?>    
</div>
<div class="clearfix"></div>