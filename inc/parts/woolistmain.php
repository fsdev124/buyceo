<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php global $product; global $post; ?>
<?php if (empty( $product ) || ! $product->is_visible() ) {return;}?>
<?php $classes = array();?>
<?php $offer_coupon = get_post_meta( get_the_ID(), 'rehub_woo_coupon_code', true ) ?>
<?php $offer_coupon_date = get_post_meta( get_the_ID(), 'rehub_woo_coupon_date', true ) ?>
<?php $offer_coupon_mask = '1' ?>
<?php $offer_url = esc_url( $product->add_to_cart_url() ); ?>
<?php $coupon_style = $expired = ''; if(!empty($offer_coupon_date)) : ?>
    <?php 
    $timestamp1 = strtotime($offer_coupon_date) + 86399; 
    $seconds = $timestamp1 - (int)current_time('timestamp',0); 
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
        $coupon_text = __('Expired', 'rehub_framework');
        $coupon_style = ' expired_coupon';
        $expired = '1';
    }                 
    ?>
<?php endif ;?>
<?php $coupon_mask_enabled = (!empty($offer_coupon) && ($offer_coupon_mask =='1' || $offer_coupon_mask =='on') && $expired!='1') ? '1' : ''; ?>
<?php if($coupon_mask_enabled =='1') {$classes[] = 'reveal_enabled';}?>
<?php do_action('woo_change_expired', $expired); //Here we update our expired?>
<div class="news-community clearfix <?php echo rh_expired_or_not($post->ID, 'class');?> <?php echo implode(' ', $classes); ?>">
    <div class="button_action">
        <div class="floatleft mr5">
            <?php $wishlistadded = __('Added to wishlist', 'rehub_framework');?>
            <?php $wishlistremoved = __('Removed from wishlist', 'rehub_framework');?>
            <?php echo getHotThumb($post->ID, false, false, true, '', $wishlistadded, $wishlistremoved);?>  
        </div>
        <?php if(rehub_option('woo_rhcompare') == true) :?>
            <span class="compare_for_grid floatleft">            
                <?php $cmp_btn_args = array(); $cmp_btn_args['class']= 'comparecompact';?>
                <?php echo wpsm_comparison_button($cmp_btn_args); ?> 
            </span>
        <?php endif;?>                                                            
    </div>
	<div class="newscom_wrap_table">		
        <div class="featured_newscom_left">
        	<div>
            <figure>
                <a href="<?php the_permalink();?>">
                    <?php if ( $product->is_on_sale()) : ?>
                        <?php 
                        $percentage=0;
                        if ($product->get_regular_price()) {
                            $percentage = round( ( ( $product->get_regular_price() - $product->get_price() ) / $product->get_regular_price() ) * 100 );
                        }
                        if ($percentage && $percentage>0 && !$product->is_type( 'variable' )) {
                            $sales_html = '<span class="onsale"><span>- ' . $percentage . '%</span></span>';
                        } else {
                            $sales_html = apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html__( 'Sale!', 'woocommerce' ) . '</span>', $post, $product );
                        }
                        ?>
                        <?php echo $sales_html; ?>
                    <?php endif; ?>
                    <?php if ( $product->is_featured() ) : ?>
                        <?php if ($product->is_on_sale()) :?>
                            <?php echo apply_filters( 'woocommerce_featured_flash', '<span class="onfeatured onsalefeatured">' . esc_html__( 'Featured!', 'rehub_framework' ) . '</span>', $post, $product ); ?>
                        <?php else :?>
                            <?php echo apply_filters( 'woocommerce_featured_flash', '<span class="onfeatured">' . __( 'Featured!', 'rehub_framework' ) . '</span>', $post, $product ); ?>
                        <?php endif ;?>
                    <?php endif; ?>        
                    <?php 
                        $showimg = new WPSM_image_resizer();
                        $showimg->use_thumb = true;
                        $showimg->no_thumb = rehub_woocommerce_placeholder_img_src('');
                        $height_figure_single = apply_filters( 're_woolistmain_height', 138 );
                        $showimg->height = $height_figure_single;
                        $showimg->width = $height_figure_single;
                        $showimg->crop = false;           
                        $showimg->show_resized_image();                                    
                    ?>
                </a>
                <?php do_action( 'rh_woo_thumbnail_loop' ); ?>
            </figure> 
            </div>                                    
        </div>
        <div class="newscom_detail">
            <?php do_action('woocommerce_before_shop_loop_item');?>
            <?php $syncitem = '';?>
            <?php if (rh_is_plugin_active('content-egg/content-egg.php')):?>
                <?php $itemsync = \ContentEgg\application\WooIntegrator::getSyncItem($post->ID);?>
                <?php if(!empty($itemsync)):?>
                    <?php                            
                        $syncitem = $itemsync;                            
                    ?>
                <?php endif;?>
            <?php endif;?>          
        	<div class="newscom_head">
    		    <?php echo rh_expired_or_not($post->ID, 'span');?><h2><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
                <div class="meta post-meta">
                    <?php rh_post_header_meta( true, true, false, false, true ); ?>                               
                </div>    
            </div>           
            <?php $loop_code_zone = rehub_option('woo_code_zone_loop');?>        
            <?php if ($loop_code_zone):?>
                <div class="woo_code_zone_loop">
                    <?php echo do_shortcode($loop_code_zone);?>
                </div>
            <?php endif;?>                
    	    <p><?php kama_excerpt('maxchar=180'); ?></p>
            <div class="clearfix"><?php wc_get_template( 'loop/rating.php' );?></div> 
            <?php do_action('woocommerce_after_shop_loop_item');?>       
        </div>
        <div class="newscom_btn_block">
            <div class="rewise-box-price rehub-main-font mb10"><?php wc_get_template( 'loop/price.php' ); ?></div>
            <div class="woobtn_block_part">
                <?php if(!empty($syncitem)):?>

                    <a href="<?php echo get_post_permalink($post->ID);?>" data-product_id="<?php echo esc_attr( $product->get_id() );?>" data-product_sku="<?php echo esc_attr( $product->get_sku() );?>" class="re_track_btn woo_loop_btn btn_offer_block product_type_cegg">
                        <?php if(rehub_option('rehub_btn_text_aff_links') !='') :?>
                            <?php echo rehub_option('rehub_btn_text_aff_links') ; ?>
                        <?php else :?>
                            <?php _e('Choose offer', 'rehub_framework') ?>
                        <?php endif ;?>
                    </a>

                <?php elseif ( $product->add_to_cart_url() !='') : ?>
                    <?php  echo apply_filters( 'woocommerce_loop_add_to_cart_link',
                        sprintf( '<a href="%s" data-product_id="%s" data-product_sku="%s" class="re_track_btn woo_loop_btn btn_offer_block %s %s product_type_%s"%s %s>%s</a>',
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
                <?php if ($coupon_mask_enabled =='1') :?>
                    <?php wp_enqueue_script('zeroclipboard'); ?>
                    <a class="woo_loop_btn coupon_btn re_track_btn btn_offer_block rehub_offer_coupon masked_coupon <?php if(!empty($offer_coupon_date)) {echo $coupon_style ;} ?>" data-clipboard-text="<?php echo $offer_coupon ?>" data-codeid="<?php echo $product->get_id() ?>" data-dest="<?php echo $offer_url ?>"><?php if(rehub_option('rehub_mask_text') !='') :?><?php echo rehub_option('rehub_mask_text') ; ?><?php else :?><?php _e('Reveal coupon', 'rehub_framework') ?><?php endif ;?>
                    </a>
                <?php else :?>
                    <?php if(!empty($offer_coupon)) : ?>
                        <?php wp_enqueue_script('zeroclipboard'); ?>
                        <div class="rehub_offer_coupon not_masked_coupon <?php if(!empty($offer_coupon_date)) {echo $coupon_style ;} ?>" data-clipboard-text="<?php echo $offer_coupon ?>"><i class="fa fa-scissors fa-rotate-180"></i><span class="coupon_text"><?php echo $offer_coupon ?></span>
                        </div>
                    <?php endif;?>
                <?php endif;?> 
                <?php do_action( 'rh_woo_button_loop' ); ?>
                <div class="mt5">
                    <?php if(!empty($syncitem)):?>
                        <div class="font80 greycolor lineheight15">
                        <?php echo rh_best_syncpost_deal($itemsync, 'mb10 compare-domain-icon', false);?>
                        </div>
                    <?php else:?>
                        <?php do_action( 'rehub_vendor_show_action' ); ?>        
                    <?php endif;?>  
                 </div>
            </div>            
        </div>    
    </div>   
</div>