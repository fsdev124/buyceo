<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php
if (class_exists('WCVendors_Pro')) {
    $vendor_dasboard = get_permalink(WCVendors_Pro::get_option( 'dashboard_page_id' ));
}
else {
    $vendor_dasboard = get_permalink(WC_Vendors::$pv_options->get_option( 'vendor_dashboard_page' ));
}?>
<p class="wc_vendors_dash_links rh_tab_links">
        <a href="<?php echo $vendor_dasboard;?>" class="active"><?php echo _e( 'Dashboard', 'rehub_framework' ); ?></a>
        <a href="<?php echo $shop_page; ?>"><?php echo _e( 'View Your Store', 'rehub_framework' ); ?></a>
        <a href="<?php echo $settings_page; ?>"><?php _e('Store Settings', 'rehub_framework') ;?></a>

<?php if ( $can_submit ) { ?>
	<?php if (rehub_option('url_for_add_product') !=''):?>
		<?php $submit_link = esc_url(rehub_option('url_for_add_product')); ?>
        <a target="_TOP" href="<?php echo $submit_link; ?>"><?php _e('Add New Product', 'rehub_framework') ;?></a>
	<?php endif;?>
	<?php if (rehub_option('url_for_edit_product') !=''):?>
		<?php $edit_link = esc_url(rehub_option('url_for_edit_product')); ?>
        <a target="_TOP" href="<?php echo $edit_link; ?>"><?php _e('Edit Products', 'rehub_framework') ;?></a>
	<?php endif;?>	
<?php } ?>