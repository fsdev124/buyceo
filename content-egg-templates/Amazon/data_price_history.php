<?php
/*
  Name: Price history full table
 */

use ContentEgg\application\helpers\TemplateHelper;
?>

<?php if (2.8 <= ContentEgg\application\Plugin::version()) :?>

<?php foreach ($items as $item): ?>
    <?php 
        $pricesarray = TemplateHelper::priceHistoryPrices($item['unique_id'], $module_id, $limit = 2);
        $pricescheck = '';
        if (!empty($pricesarray) && is_array($pricesarray)){
            $pricescheck = (count($pricesarray) > 1) ? true : '';
        }        
    ?>
    <?php if (!empty($pricescheck)) :?>
    <table class="rh-tabletext-block">
        <tr>
        <th class="rh-tabletext-block-heading" colspan="2"><?php _e('Price history for ', 'rehub_framework');?><?php echo $item['title']; ?></th>
        </tr>
        <tr>
        <td class="rh-tabletext-block-left">
 
            <div class="rh-tabletext-block-latest"> 
            <div class="mb10"><strong><?php _e('Latest updates:', 'rehub_framework');?></strong></div>                             
            <?php $prices = TemplateHelper::priceHistoryPrices($item['unique_id'], $module_id, $limit = 7); ?>
            <?php if ($prices): ?>
                <ul>
                    <?php foreach ($prices as $price): ?>
                        <li>
                            <?php echo TemplateHelper::formatPriceCurrency($price['price'], $item['currencyCode']); ?>                    
                            - <?php echo date(get_option('date_format'), $price['date']); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <?php $since = TemplateHelper::priceHistorySinceDate($item['unique_id'], $module_id); ?>
            <?php if ($since): ?>
                <?php _e('Since:', 'rehub_framework');?> <?php echo date(get_option('date_format'), $since); ?>
            <?php endif; ?>                    
            </div>
        </td>
        <td class="rh-tabletext-block-right">
            <div class="rh-table-price-graph">
            <?php TemplateHelper::priceHistoryMorrisChart($item['unique_id'], $module_id, 180, array('lineWidth' => 2, 'postUnits' => ' ' . $item['currencyCode'], 'goals' => array((int) $item['price']), 'fillOpacity' => 0.5), array('style' => 'height: 230px;')); ?>
            </div>
            <ul class="rh-lowest-highest">
                <?php $price = TemplateHelper::priceHistoryMax($item['unique_id'], $module_id); ?>
                <?php if ($price): ?>
                    <li>
                        <b style="color: red;">Highest Price:</b> 
                        <?php echo TemplateHelper::formatPriceCurrency($price['price'], $item['currencyCode']); ?> 
                        - <?php echo date(get_option('date_format'), $price['date']); ?>
                    </li>
                <?php endif; ?>

                <?php $price = TemplateHelper::priceHistoryMin($item['unique_id'], $module_id); ?>
                <?php if ($price): ?>
                    <li>
                        <b style="color: green;">Lowest Price:</b> 
                        <?php echo TemplateHelper::formatPriceCurrency($price['price'], $item['currencyCode']); ?>   
                        - <?php echo date(get_option('date_format'), $price['date']); ?>
                    </li>
                <?php endif; ?>
            </ul>            
        </td>
        </tr>                
    </table>
    <?php endif;?>
<?php endforeach; ?>

<?php endif;?>