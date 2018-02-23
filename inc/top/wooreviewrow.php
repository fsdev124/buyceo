<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}?>
<?php global $product;?>
<?php if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes'):?>
    <?php $avg_rate_score   = number_format( $product->get_average_rating(), 1 ) * 20 ;?>
    <?php if ($avg_rate_score):?>
        <div class="rev-in-woocompare">
            <div class="star-big"><span class="stars-rate"><span style="width: <?php echo $avg_rate_score;?>%;"></span></span></div>
        </div>
    <?php else:?>
        -
    <?php endif;?>
<?php else:?>
        -
<?php endif;?>