<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}?>
<?php if (class_exists('WCV_Vendor_Shop')) :?>
    <?php if(method_exists('WCV_Vendor_Shop', 'template_loop_sold_by')) :?>
        <span class="woolist_vendor"><?php WCV_Vendor_Shop::template_loop_sold_by(get_the_ID()); ?></span>
    <?php endif;?>
<?php else:?>
    <?php echo get_bloginfo( 'name' );?>
<?php endif;?>