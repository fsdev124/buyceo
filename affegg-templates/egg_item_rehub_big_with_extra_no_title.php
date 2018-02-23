<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php
/*
  Name: Big product card with extra (without title)
 */
use Keywordrush\AffiliateEgg\TemplateHelper;  
?>
<?php if (isset($title) && $title): ?>
    <h3 class="cegg-shortcode-title"><?php echo esc_html($title); ?></h3>
<?php endif; ?>
<?php foreach ($items as $item): ?>
    <?php $offer_price = (!empty($item['price'])) ? $item['price'] : ''; ?>
    <?php $offer_price_old = (!empty($item['price'])) ? $item['old_price'] : ''; ?>
    <?php $offer_post_url = $item['url'] ;?>
    <?php $afflink = apply_filters('rh_post_offer_url_filter', $offer_post_url );?>
    <?php $aff_thumb = $item['img'] ;?>
    <?php $offer_title = wp_trim_words( $item['title'], 20, '...' ); ?>
    <?php $offer_desc = $item['description'] ;?>  
    <?php if(rehub_option('rehub_btn_text') !='') :?><?php $btn_txt = rehub_option('rehub_btn_text') ; ?><?php else :?><?php $btn_txt = __('Buy this item', 'rehub_framework') ;?><?php endif ;?>
    <?php if (!empty ($item['features'])) {$attributes = $item['features'];}  ?>
    <?php if (!empty ($item['extra']['images'])) {$gallery_images = $item['extra']['images'];}  ?>
    <?php if (!empty($item['extra']['comments'])) {$import_comments = $item['extra']['comments'];}  ?>   

    <div class="col_wrap_two">
        <div class="product_egg">

            <div class="image col_item">
                <a rel="nofollow" target="_blank" class="re_track_btn" href="<?php echo esc_url($afflink) ?>"<?php echo $item['ga_event'] ?>>
                    <?php WPSM_image_resizer::show_static_resized_image(array('src'=> $aff_thumb, 'width'=> 500, 'title' => $offer_title, 'no_thumb_url' => get_template_directory_uri().'/images/default/noim_gray.png'));?>                                    
                    <span class="show_more_images"><?php _e('Show more images', 'rehub_framework'); ?></span>
                    <?php if(!empty($offer_price_old) && $offer_price_old !='0') : ?>
                        <span class="sale_a_proc">
                            <?php   
                                $offer_price_calc = intval(str_replace(',', '', $item['price']));
                                $offer_price_old_calc = intval(str_replace(',', '', $item['old_price']));
                                $sale_proc = 0 -(100 - ($offer_price_calc / $offer_price_old_calc) * 100); 
                                $sale_proc = round($sale_proc); 
                                echo $sale_proc; echo '%';
                            ;?>
                        </span>
                    <?php endif ;?>                                   
                </a>
            </div>

            <div class="product-summary col_item">

                <?php if(!empty($offer_price)) : ?>
                    <div class="deal-box-price">
                        <?php echo TemplateHelper::formatPriceCurrency($item['price_raw'], $item['currency_code'], '<span class="cegg-currency">', '</span>'); ?>
                        <?php if(!empty($offer_price_old)) : ?>
                        <span class="retail-old">
                          <strike><?php echo $item['old_price_raw']; ?></strike>
                        </span>
                        <?php endif ;?>                                       
                    </div>                
                <?php endif ;?>

                <?php if ($offer_desc): ?>
                    <p><?php rehub_truncate('maxchar=200&text='.$offer_desc.''); ?></p>
                    <small class="small_size"><?php if ($item['in_stock']): ?><?php _e('Available: ', 'rehub_framework') ;?><span class="yes_available"><?php _e('In stock', 'rehub_framework') ;?></span><?php endif; ?></small>
                <?php endif; ?>             

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
                    <span class="aff_tag"><?php echo rehub_get_site_favicon($item['orig_url']); ?></span>                    
                </div> 

            </div>           

        </div> 
    </div>  

    <?php if (!empty ($attributes) || !empty ($gallery_images) || !empty ($import_comments)) :?>
    <div class="rehub_woo_review">
        
            <ul class="rehub_woo_tabs_menu">
                <?php if (!empty ($attributes)) :?><li class="affspec"><?php _e('Specification', 'rehub_framework') ?></li><?php endif ;?>
                <?php if (!empty ($gallery_images)) :?><li class="pretty_woo"><?php _e('Photos', 'rehub_framework') ?></li><?php endif ;?>
                <?php if (!empty ($import_comments)) :?><li class="affrev"><?php _e('Last reviews', 'rehub_framework') ?></li><?php endif ;?>                
            </ul>
        
        <div class="table_view_block">
            <?php if (!empty ($attributes)) :?>
                <div class="rehub_woo_review_tabs affspec">
                    <div>
                        <table class="shop_attributes">
                            <tbody>
                            <?php foreach ($attributes as $feature): ?>
                                <tr>
                                    <th><?php echo esc_html($feature['name']) ?></th>
                                    <td><p><?php echo esc_html($feature['value']) ?></p></td>
                                </tr>
                            <?php endforeach; ?>                                        
                            </tbody>
                        </table>
                    </div>                               
                </div>
            <?php endif ;?>
            <?php if (!empty ($gallery_images)) :?>
                <div class="rehub_woo_review_tabs pretty_woo modulo-lightbox">
                    <?php $randomgallery = 'rh_ceam_gallery'.rand(1, 50);?>                
                    <?php wp_enqueue_script('modulobox'); wp_enqueue_style('modulobox');
                        foreach ($gallery_images as $gallery_img) {
                            ?> 
                            <a data-rel="<?php echo $randomgallery;?>" href="<?php echo esc_attr($gallery_img) ;?>" data-thumb="<?php echo $gallery_img;?>" data-title="<?php echo $offer_title;?>">                        
                                <?php WPSM_image_resizer::show_static_resized_image(array('src'=> $gallery_img, 'width'=> 100, 'height'=> 100, 'title' => $offer_title_first, 'no_thumb_url' => get_template_directory_uri().'/images/default/noimage_100_70.png'));?> 
                            </a>
                            <?php
                        }
                    ?>
                </div>           
            <?php endif ;?>
            <?php if (!empty ($import_comments)) :?>
                <div class="rehub_woo_review_tabs affrev">
                    <?php foreach ($import_comments as $key => $comment): ?>
                        <div class="helpful-review black">
                            <div class="quote-top"><i class="fa fa-quote-left"></i></div>
                            <div class="quote-bottom"><i class="fa fa-quote-right"></i></div>
                            <div class="text-elips">
                                <span><?php echo $comment['comment']; ?></span>
                            </div>
                            <?php if (!empty($comment['date'])): ?>
                                <span class="helpful-date"><?php echo gmdate("F j, Y", $comment['date']); ?></span>
                            <?php endif ;?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif ;?>                        
        </div>        
    </div>
    <?php endif ;?>
    <div class="clearfix"></div>
<?php endforeach; ?>         