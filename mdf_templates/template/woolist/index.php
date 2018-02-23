<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<?php global $mdf_loop; ?>
<div class="clearfix"></div>
<div class="woo_offer_list">
<?php while ($mdf_loop->have_posts()) : $mdf_loop->the_post(); ?>
<?php $i=1; ?>
    <?php include(rh_locate_template('inc/parts/woolistpart.php')); ?>
<?php $i++; ?>   
<?php endwhile; // end of the loop.    ?>
</div>
<div class="clearfix"></div>