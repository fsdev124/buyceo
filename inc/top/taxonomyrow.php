<?php if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}?>
<?php 
$catalog_tax = (isset($row['tax_name'])) ? $row['tax_name'] : '';
$catalog_tax_prefix = (isset($row['tax_name_prefix'])) ? $row['tax_name_prefix'] : '';
$catalog_tax_postfix = (isset($row['tax_name_postfix'])) ? $row['tax_name_postfix'] : '';
$is_attr = (isset($row['is_attribute'])) ? $row['is_attribute'] : '';
if ($catalog_tax !='') :?>
    <div class="post-tax"> 
        <?php if (!empty($catalog_tax_prefix)) {echo do_shortcode($catalog_tax_prefix);}?>

        <?php if ($is_attr):?>
            <?php 
                global $product;
                $woo_attr = $product->get_attribute(esc_html($catalog_tax));
                if(!is_wp_error($woo_attr)){
                    echo $woo_attr;
                }
            ?>
        <?php else:?>
            <?php $terms = get_the_terms(get_the_ID(), $catalog_tax );
            if ($terms && ! is_wp_error($terms)) :
                $term_slugs_arr = array();
                foreach ($terms as $term) {
                    $term_slugs_arr[] = ''.$term->name.'';
                }
                $terms_slug_str = join(", ", $term_slugs_arr);
                echo $terms_slug_str;
            endif;
            ?> 
        <?php endif ;?>
        <?php if (!empty($catalog_tax_postfix)) {echo do_shortcode($catalog_tax_postfix);}?>
    </div>
<?php endif ;?>