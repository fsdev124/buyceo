<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php
/*
  Name: Just button
 */
?>
<?php foreach ($items as $item): ?>
<?php $offer_post_url = $item['url'] ;?>
<?php $afflink = apply_filters('rh_post_offer_url_filter', $offer_post_url );?>  
<?php if(rehub_option('rehub_btn_text') !='') :?><?php $btn_txt = rehub_option('rehub_btn_text') ; ?><?php else :?><?php $btn_txt = __('Buy this item', 'rehub_framework') ;?><?php endif ;?>   	    
<a href="<?php echo esc_url($afflink) ?>" class="re_track_btn wpsm-button rehub_main_btn btn_offer_block" target="_blank" rel="nofollow">
	<span><strong><?php echo esc_html($btn_txt) ?></strong></span>
	<span class="aff_tag mtinside"><?php echo rehub_get_site_favicon($item['orig_url']); ?></span>	
</a>                                                                  
<?php endforeach; ?>          