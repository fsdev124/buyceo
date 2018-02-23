<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<?php global $mdf_loop;?>
<div class="clearfix"></div>
<div class="ajaxed-mdtf-list">
<?php $i=1; while ($mdf_loop->have_posts()) : $mdf_loop->the_post(); ?>
    <?php include(rh_locate_template('inc/parts/query_type1.php')); ?>
<?php $i++; endwhile; // end of the loop.    ?> 
</div>
<div class="clearfix"></div>