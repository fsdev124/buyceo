<?php if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}?>
<?php 
$wooattr = (isset($row['woo_attr'])) ? $row['woo_attr'] : '';
if ($wooattr !='') :?>
    <div class="woo-attr-value"> 
        <?php if ($wooattr):?>
            <?php 
                global $product;
                $woo_attr = $product->get_attribute(esc_html($wooattr));
                if(!is_wp_error($woo_attr)){
                    echo $woo_attr;
                }
            ?>
        <?php endif ;?>
    </div>
<?php endif ;?>