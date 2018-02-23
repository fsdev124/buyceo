<?php
/**
 * External product add to cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
<?php  global $product, $post; $offer_coupon = get_post_meta( $post->ID, 'rehub_woo_coupon_code', true ) ?>
<?php $offer_coupon_date = get_post_meta( $post->ID, 'rehub_woo_coupon_date', true ) ?>
<?php $offer_coupon_mask = get_post_meta( $post->ID, 'rehub_woo_coupon_mask', true ) ?>
<?php $offer_url = $product->add_to_cart_url(); ?>
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
<?php do_action('woo_change_expired', $expired); //Here we update our expired?>
<?php $coupon_mask_enabled = (!empty($offer_coupon) && ($offer_coupon_mask =='1' || $offer_coupon_mask =='on') && $expired!='1') ? '1' : ''; ?>
<?php $reveal_enabled = ($coupon_mask_enabled =='1') ? ' reveal_enabled' : '';?>
<div class="coupon_woo_rehub <?php echo $reveal_enabled; echo $coupon_style?>">
  	<?php if ($coupon_mask_enabled =='1') :?>
  		<?php wp_enqueue_script('zeroclipboard'); ?>
	  	<div class="rehub_offer_coupon masked_coupon coupon_btn re_track_btn <?php if(!empty($offer_coupon_date)) {echo $coupon_style ;} ?>" data-clipboard-text="<?php echo $offer_coupon ?>" data-codeid="<?php echo $product->get_id() ?>" data-dest="<?php echo $offer_url ?>"><?php if(rehub_option('rehub_mask_text') !='') :?><?php echo rehub_option('rehub_mask_text') ; ?><?php else :?><?php _e('Reveal coupon', 'rehub_framework') ?><?php endif ;?>
	  	</div>
	<?php else :?>
		<?php if(!empty($offer_coupon)) : ?>
			<?php wp_enqueue_script('zeroclipboard'); ?>
		  	<div class="rehub_offer_coupon not_masked_coupon <?php if(!empty($offer_coupon_date)) {echo $coupon_style ;} ?>" data-clipboard-text="<?php echo $offer_coupon ?>"><i class="fa fa-scissors fa-rotate-180"></i><span class="coupon_text"><?php echo $offer_coupon ?></span>
		  	</div>
		  	<?php if(rehub_option('rehub_woo_print') =='1') :?>
		  		<?php $printid = uniqid().'printid'; ?>
			  	<div id="printcoupon<?php echo $printid;?>" class="printmecoupondiv">
			  		<div class="printcoupon">
			  			<div class="printcouponwrap">
				  			<div class="printcouponheader">
				  				<div class="printcoupontitle"><?php the_title(); ?></div>
				  				<div class="expired_print_coupon"><?php if(!empty($offer_coupon_date)):?><?php _e('Use before:', 'rehub_framework');?><?php echo $offer_coupon_date ?><?php endif;?></div>
				  				<div class="storeprint"><?php WPSM_Woohelper::re_show_brand_tax(); //show brand taxonomy?></div>
				  			</div>
				  			<div class="printcouponcentral">
								<?php if ($product->is_on_sale() && $product->get_regular_price() && $product->get_price() > 0 && !$product->is_type( 'variable' )) : ?>
								    <span class="save_proc_woo_print">
								        <?php   
								            $offer_price_calc = (float) $product->get_price();
								            $offer_price_old_calc = (float) $product->get_regular_price();
								            $sale_proc = 100 - ($offer_price_calc / $offer_price_old_calc) * 100; 
								            $sale_proc = round($sale_proc); 
								            echo '<span class="countprintsale">'.$sale_proc.'</span>'; 
								            echo '<span class="procprintsale">%</span>';
								            echo '<span class="wordprintsale">'.__('Save', 'rehub_framework').'</span>';
										?>
								    </span>
								<?php endif ?>
								<div class="printcoupon_wrap"><?php echo $offer_coupon ?></div>		  				
				  			</div>
				  			<div class="printcoupondesc">
					  			<div class="printimage">
					  				<?php the_post_thumbnail( 'shop_thumbnail' ); ?>
					  			</div>	
					  			<span><?php echo $post->post_excerpt;?></span>				  				  				
				  			</div>
				  			<div class="couponprintend"><?php _e('Get more coupons on:', 'rehub_framework');?><span> <?php echo site_url();?></span></div>	
			  			</div>
			  		</div>
		  			<?php $offer_couponimgurl = get_post_meta( $post->ID, 'rehub_woo_coupon_coupon_img_url', true ); ?>
		  			<?php if($offer_couponimgurl !='') :?>
		  				<div class="printcouponimg"><img src="<?php echo esc_url($offer_couponimgurl);?>" alt="Use coupon image" /></div>
		  			<?php endif ;?>			  		
			  	</div>
			  	<span class="printthecoupon" data-printid="<?php echo $printid;?>"><?php _e('Print coupon', 'rehub_framework');?></span>
		  	<?php endif ;?>
	  	<?php endif;?>
	<?php endif;?>
	<?php if($product_url):?>
	<p class="cart">
		<?php $product_url = apply_filters('rh_post_offer_url_filter', $product_url);?>
		<a href="<?php echo esc_url( $product_url ); ?>" rel="nofollow" class="single_add_to_cart_button button alt" target="_blank"><?php echo esc_html( $button_text ); ?>
		</a>
	</p>
	<?php endif;?>	
<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?> 
</div>