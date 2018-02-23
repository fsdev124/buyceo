<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<?php global $mdf_loop;?>
<div class="clearfix"></div>
<div class="rh-flex-eq-height col_wrap_three">
<?php $i=1; while ($mdf_loop->have_posts()) : $mdf_loop->the_post(); ?>
	<?php $boxed = $enable_btn = 1;?>
	<?php $disable_meta = $enable_btn = 0;?>
	<?php $exerpt_count = 120;?>
	<?php include(rh_locate_template('inc/parts/column_grid.php')); ?>
<?php $i++; endwhile; // end of the loop.    ?> 
</div>
<div class="clearfix"></div>