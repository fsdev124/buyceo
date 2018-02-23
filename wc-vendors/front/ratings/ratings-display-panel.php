<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php
/**
 * The Template for displaying the product ratings in the product panel
 *
 * Override this template by copying it to yourtheme/wc-vendors/front/ratings
 *
 * @package    WCVendors_Pro
 * @version    1.2.3
 */

// This outputs the star rating 
$stars = ''; 
for ($i = 1; $i<=stripslashes( $rating ); $i++) { $stars .= "<i class='fa fa-star'></i>"; } 
for ($i = stripslashes( $rating ); $i<5; $i++) { $stars .=  "<i class='fa fa-star-o'></i>"; }
?> 

<div class="wcv-rating-item">
<h4><?php if ( ! empty( $rating_title ) ) echo $rating_title; ?>  <?php echo $stars; ?></h4>
<div class="wcv-rating-posted-by">
<span><?php _e( 'Posted on', 'wcvendors-pro'); ?> <?php echo $post_date; ?></span> <?php _e( ' by ', 'wcvendors-pro'); echo $customer_name; ?>
</div>
<p><?php echo $comment; ?></p>
</div>