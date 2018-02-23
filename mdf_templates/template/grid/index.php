<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<?php global $mdf_loop;?>
<div class="clearfix"></div>
<div class="rh-flex-eq-height col_wrap_three eq_grid post_eq_grid">
<?php $i=1; while ($mdf_loop->have_posts()) : $mdf_loop->the_post(); ?>
	<?php include(rh_locate_template('inc/parts/compact_grid.php')); ?>
<?php $i++; endwhile; // end of the loop.    ?> 
</div>
<div class="clearfix"></div>