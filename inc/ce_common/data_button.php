<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php foreach ($items as $item): ?>
	<?php $domain = $merchant = '';?>
	<?php $offer_post_url = $item['url'] ;?>
	<?php $afflink = apply_filters('rh_post_offer_url_filter', $offer_post_url );?> 
	<?php $merchant = (!empty($item['merchant'])) ? $item['merchant'] : ''; ?>
	<?php if (!empty($item['domain'])):?>
	    <?php $domain = $item['domain'];?>
	<?php elseif (!empty($item['extra']['domain'])):?>
	    <?php $domain = $item['extra']['domain'];?>
	<?php endif;?>  
	<?php if(rehub_option('rehub_btn_text') !='') :?><?php $btn_txt = rehub_option('rehub_btn_text') ; ?><?php else :?><?php $btn_txt = __('Buy this item', 'rehub_framework') ;?><?php endif ;?>   	    
	<div class="text-center mt20 mb20">
	<a href="<?php echo esc_url($afflink) ?>" class="re_track_btn wpsm-button rehub_main_btn btn_offer_block" target="_blank" rel="nofollow">
		<span><strong><?php echo esc_html($btn_txt) ?></strong></span>
		<?php if($merchant):?>
			<span class="aff_tag mtinside">@<?php echo $merchant; ?></span>
		<?php else:?>
			<span class="aff_tag mtinside">@<?php echo $domain; ?></span>
		<?php endif;?>
	</a>    
	</div>                                                                    
<?php endforeach; ?>  