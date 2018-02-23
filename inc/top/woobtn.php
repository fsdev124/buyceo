<?php if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}?>
<?php global $product, $post?>
<div class="price-in-compare-flip mt10 woocommerce">
 
    <?php if ($product->get_price() !='') : ?>
        <span class="price-woo-compare-chart rehub-main-font"><?php echo $product->get_price_html(); ?></span>
        <div class="mb10"></div>
    <?php endif;?>
    <?php $syncitem = '';?>
    <?php if (rh_is_plugin_active('content-egg/content-egg.php')):?>
        <?php $itemsync = \ContentEgg\application\WooIntegrator::getSyncItem($post->ID);?>
        <?php if(!empty($itemsync)):?>
            <?php                            
                $syncitem = $itemsync;                            
            ?>
        <?php endif;?>
    <?php endif;?>
    <?php if(!empty($syncitem)):?>
        <a href="<?php the_permalink();?>" class="btn_offer_block btn-woo-compare-chart woo_loop_btn add_to_cart_button">
            <?php if(rehub_option('rehub_btn_text_aff_links') !='') :?><?php echo rehub_option('rehub_btn_text_aff_links') ; ?><?php else :?><?php _e('Choose offer', 'rehub_framework') ?><?php endif ;?>
        </a>
    <?php else:?>    
        <?php if ($product->add_to_cart_url() !='') : ?>
            <?php  echo apply_filters( 'woocommerce_loop_add_to_cart_link',
                sprintf( '<a href="%s" data-product_id="%s" data-product_sku="%s" class="re_track_btn btn_offer_block btn-woo-compare-chart woo_loop_btn %s %s product_type_%s"%s%s>%s</a>',
                esc_url( $product->add_to_cart_url() ),
                esc_attr( $product->get_id() ),
                esc_attr( $product->get_sku() ),
                $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                $product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
                esc_attr( $product->get_type() ),
                $product->get_type() =='external' ? ' target="_blank"' : '',
                $product->get_type() =='external' ? ' rel="nofollow"' : '',
                esc_html( $product->add_to_cart_text() )
                ),
            $product );?>
        <?php endif; ?>
    <?php endif; ?>
    <div class="yith_woo_chart mt10"> 
        <?php $wishlistadd = __('Add to wishlist', 'rehub_framework');?>
        <?php $wishlistadded = __('Added to wishlist', 'rehub_framework');?>
        <?php $wishlistremoved = __('Removed from wishlist', 'rehub_framework');?>
        <?php echo getHotThumb($post->ID, false, false, true, $wishlistadd, $wishlistadded, $wishlistremoved);?> 
	</div> 
                     
</div> 