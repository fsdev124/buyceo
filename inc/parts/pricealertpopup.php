<?php if ( ! defined( 'ABSPATH' ) ) {exit;}?>
<?php if(rh_is_plugin_active('content-egg/content-egg.php')):?>
    <?php if (2.8 <= ContentEgg\application\Plugin::version()) :?>
        <?php if (ContentEgg\application\helpers\TemplateHelper::isPriceAlertAllowed($unique_id, $module_id)): ?>
            <?php $rand = uniqid();?>
            <div class="pricealertpopup-wrap flowhidden">
                <span class="csspopuptrigger floatright mb10 greencolor" data-popup="pricealert_<?php echo $rand;?>"><i class="fa fa-bell-o mr5" aria-hidden="true"></i> <?php _e('Set Lowest Price Alert', 'rehub_framework');?></span>
                <div class="csspopup" id="pricealert_<?php echo $rand;?>">
                    <div class="csspopupinner cegg-price-alert-popup">
                        <span class="cpopupclose" href="#">×</span>            
                        <div class="cegg-price-alert-wrap">                       
                            <div class="re_title_inmodal"><i class="fa fa-bell-o" aria-hidden="true"></i> <?php _e('Notify me, when price drops', 'rehub_framework'); ?></div>
                            <div class="rh-line mb20"></div>
                            <div class="mb20 font90">
                                <?php _e('Set Alert for Product', 'rehub_framework'); ?>: <?php echo $syncitem['title'];?> - <?php echo ContentEgg\application\helpers\TemplateHelper::formatPriceCurrency($syncitem['price'], $syncitem['currencyCode']); ?>
                            </div>                     
                            <form>
                                <input type="hidden" name="module_id" value="<?php echo esc_attr($module_id); ?>">
                                <input type="hidden" name="unique_id" value="<?php echo esc_attr($unique_id); ?>">
                                <input type="hidden" name="post_id" value="<?php echo $postid; ?>">
                                <div class="re-form-group mb20">                               
                                    <label><?php _e('Your Email', 'rehub_framework'); ?>:</label>
                                    <input type="email" name="email" class="re-form-input">
                                </div>
                                <div class="re-form-group mb20">
                                    <label><?php _e('Desired price', 'rehub_framework'); ?>:</label> 
                                    <input type="text" name="price" class="re-form-input">
                                </div>
                                <input value="<?php _e('Start tracking', 'rehub_framework'); ?>" type="submit" class="wpsm-button rehub_main_btn" />            
                            </form>
                            <div class="cegg-price-loading-image" style="display: none;"><img src="<?php echo get_template_directory_uri() . '/images/ajax-loader.gif' ?>" /></div>
                            <div class="cegg-price-alert-result-succcess" style="display: none; color: green;"></div>
                            <div class="cegg-price-alert-result-error" style="display: none; color: red;"></div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif;?>
    <?php endif;?>
<?php endif;?>