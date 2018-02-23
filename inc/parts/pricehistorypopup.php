<?php if ( ! defined( 'ABSPATH' ) ) {exit;}?>
<?php if(rh_is_plugin_active('content-egg/content-egg.php')):?>
    <?php if (2.8 <= ContentEgg\application\Plugin::version()) :?>

        <?php   $pricesarray = ContentEgg\application\helpers\TemplateHelper::priceHistoryPrices($unique_id, $module_id, $limit = 3);
            $pricescheck = '';
            if (!empty($pricesarray) && is_array($pricesarray)){
                $pricescheck = (count($pricesarray) > 1) ? true : '';
            }
        ?>
        <?php if($pricescheck):?>
            <?php $rand = uniqid();?>
            <span class="csspopuptrigger floatright" data-popup="pricehistory_<?php echo $rand;?>"><i class="fa fa-bar-chart" aria-hidden="true"></i> <?php _e('Price history', 'rehub_framework');?></span>
            <div class="csspopup" id="pricehistory_<?php echo $rand;?>">
                <div class="csspopupinner">
                    <span class="cpopupclose" href="#">×</span>
                    <table class="rh-tabletext-block">
                        <tr>
                        <th class="rh-tabletext-block-heading" colspan="2"><?php _e('Price history for ', 'rehub_framework');?><?php echo $syncitem['title']; ?></th>
                        </tr>
                        <tr>
                        <td class="rh-tabletext-block-left">
                            <div class="rh-tabletext-block-latest"> 
                            <div class="mb10"><strong><?php _e('Latest updates:', 'rehub_framework');?></strong></div>                             
                            <?php $prices = ContentEgg\application\helpers\TemplateHelper::priceHistoryPrices($unique_id, $module_id, $limit = 8); ?>
                            <?php if ($prices): ?>
                                <ul>
                                    <?php foreach ($prices as $price): ?>
                                        <li>
                                            <?php echo ContentEgg\application\helpers\TemplateHelper::formatPriceCurrency($price['price'], $syncitem['currencyCode']); ?>                    
                                            - <?php echo date(get_option('date_format'), $price['date']); ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                            <?php $since = ContentEgg\application\helpers\TemplateHelper::priceHistorySinceDate($unique_id, $module_id); ?>
                            <?php if ($since): ?>
                                <?php _e('Since:', 'rehub_framework');?> <?php echo date(get_option('date_format'), $since); ?>
                            <?php endif; ?>                    
                            </div>
                        </td>
                        <td class="rh-tabletext-block-right">
                            <?php ContentEgg\application\helpers\TemplateHelper::priceHistoryMorrisChart($unique_id, $module_id, 180, array('lineWidth' => 2, 'postUnits' => ' ' . $syncitem['currencyCode'], 'goals' => array((int) $syncitem['price']), 'fillOpacity' => 0.5), array('style' => 'height: 230px;')); ?>
                            <ul class="rh-lowest-highest">
                                <?php $price = ContentEgg\application\helpers\TemplateHelper::priceHistoryMax($unique_id, $module_id); ?>
                                <?php if ($price): ?>
                                    <li>
                                        <b style="color: red;">Highest Price:</b> 
                                        <?php echo ContentEgg\application\helpers\TemplateHelper::formatPriceCurrency($price['price'], $syncitem['currencyCode']); ?> 
                                        - <?php echo date(get_option('date_format'), $price['date']); ?>
                                    </li>
                                <?php endif; ?>

                                <?php $price = ContentEgg\application\helpers\TemplateHelper::priceHistoryMin($unique_id, $module_id); ?>
                                <?php if ($price): ?>
                                    <li>
                                        <b style="color: green;">Lowest Price:</b> 
                                        <?php echo ContentEgg\application\helpers\TemplateHelper::formatPriceCurrency($price['price'], $syncitem['currencyCode']); ?>   
                                        - <?php echo date(get_option('date_format'), $price['date']); ?>
                                    </li>
                                <?php endif; ?>
                            </ul>            
                        </td>
                        </tr>                
                    </table>           
                </div>
            </div>
        <?php endif;?>
    <?php endif;?>
<?php endif;?>