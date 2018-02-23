<?php
/**
 *  Vendor Mini Header - Hooked into single-product page
 *
 *  THIS FILE WILL LOAD ON VENDORS INDIVIDUAL PRODUCT URLs (such as yourdomain.com/shop/product-name/)
 *
 * @author WCVendors
 * @package WCVendors
 * @version 1.3.0
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 

/*
*	Template Variables available 
*   $vendor : 			For pulling additional user details from vendor account.  This is an array.
*   $vendor_id  : 		current vendor user id number
*   $shop_name : 		Store/Shop Name (From Vendor Dashboard Shop Settings)
*   $shop_description : Shop Description (completely sanitized) (From Vendor Dashboard Shop Settings)
*   $seller_info : 		Seller Info(From Vendor Dashboard Shop Settings)
*	$vendor_email :		Vendors email address
*	$vendor_login : 	Vendors user_login name
*/ 

?>

<div id="wcv_mini_header">
	<style scoped>#wcvendor_image_bg{<?php echo rh_show_vendor_bg($vendor_id);?>}</style>
	<div id="wcvendor_image_bg">
		<div class="wcv_mini_header_content" >
			<div class="wcv_mini_header_store floatleft">
				<h5><a href="<?php echo WCV_Vendors::get_vendor_shop_page( $vendor_id );?>"><?php echo WCV_Vendors::get_vendor_sold_by( $vendor_id );?></a></h5>
			</div>
			<span class="wpsm-button small red mb0 floatright"><i class="fa fa-heart"></i> Favorire</span>
		</div>
		<span class="wcvendor-cover-image-mask"></span>
	</div>
</div>