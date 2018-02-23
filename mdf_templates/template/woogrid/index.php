<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<?php global $mdf_loop; ?>
<div class="clearfix"></div>
<div class="woocommerce">
<div class="rh-flex-eq-height grid_woo products col_wrap_three">
<?php while ($mdf_loop->have_posts()) : $mdf_loop->the_post(); ?>
<?php $i=1; ?>
<?php $columns = '3_col'?>
    <?php include(rh_locate_template('inc/parts/woogridpart.php')); ?>
<?php $i++; ?>   
<?php endwhile; // end of the loop.    ?>
</div>
</div>
<div class="clearfix"></div>