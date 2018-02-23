<?php
/*
 * Name: Price alert for lowest price product
 * Modules:
 * Module Types: PRODUCT
 * Shortcoded: FALSE
 * 
 */
?>
<?php
use ContentEgg\application\helpers\TemplateHelper;
// sort items by price
?> 
<?php $postid = (isset($post_id)) ? $post_id : get_the_ID();?>
<?php if (get_post_type($postid) == 'product'):?>
    <?php $itemsync = \ContentEgg\application\WooIntegrator::getSyncItem($postid);
        $unique_id = $itemsync['unique_id']; $module_id = $itemsync['module_id'];?>
<?php else:?>
    <?php $unique_id = get_post_meta($postid, '_rehub_product_unique_id', true);?>
    <?php $module_id = get_post_meta($postid, '_rehub_module_ce_id', true);?>
<?php endif;?>

<?php if ($unique_id && $module_id) :?>
    <?php $syncitem = ($unique_id) ? $data[$module_id][$unique_id] : '';?>
    <?php if (TemplateHelper::isPriceAlertAllowed($unique_id, $module_id) && !empty($syncitem)): ?>
        <div class="price-alert-form-ce">
            <div class="alert-form-ce-wrap">
                <h4 id="<?php echo esc_attr($unique_id); ?>"><i class="fa fa-bell-o bigbellalert rehub-main-color" aria-hidden="true"></i><?php _e('Didn\'t find the right price? Set price alert below', 'rehub_framework');?></h4>          
                <div class="cegg-price-alert-wrap">
                    <div class="mb10 font90">
                        <?php _e('Set Alert for Product', 'rehub_framework'); ?>: <?php echo $syncitem['title'];?> - <?php echo TemplateHelper::formatPriceCurrency($syncitem['price'], $syncitem['currencyCode']); ?>
                    </div>              
                    <form>
                        <input type="hidden" name="module_id" value="<?php echo esc_attr($module_id); ?>">
                        <input type="hidden" name="unique_id" value="<?php echo esc_attr($unique_id); ?>">
                        <input type="hidden" name="post_id" value="<?php echo $postid; ?>">        
                        <div class="tabledisplay mobilecenterdisplay mobileblockdisplay flowhidden">
                            <div class="celldisplay pr15 rtlpl15">                    
                                <input type="email" name="email" placeholder="<?php _e('Your Email', 'rehub_framework'); ?>:" class="mb10" value="<?php if(method_exists('ContentEgg\application\helpers\TemplateHelper', 'getCurrentUserEmail')):?><?php echo esc_attr(TemplateHelper::getCurrentUserEmail()); ?><?php endif;?>">
                            </div>
                            <div class="celldisplay pr15 rtlpl15">
                                <input type="text" name="price" placeholder="<?php _e('Desired price', 'rehub_framework'); ?>:" class="mb10">
                            </div> 
                            <div class="celldisplay">
                                <input value="<?php _e('Start tracking', 'rehub_framework'); ?>" type="submit" class="wpsm-button rehub_main_btn small-btn floatright mb10" /> 
                            </div>                                
                        </div>  
                    </form>
                    <div class="cegg-price-loading-image" style="display: none;"><img src="<?php echo get_template_directory_uri() . '/images/ajax-loader.gif' ?>" /></div>
                    <div class="cegg-price-alert-result-succcess" style="display: none; color: green;"></div>
                    <div class="cegg-price-alert-result-error" style="display: none; color: red;"></div>        
                </div>  
            </div>
        </div>
    <?php endif;?>
<?php endif;?>