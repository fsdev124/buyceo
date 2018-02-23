<?php
/*
  Name: Grid of products (4 column)
 */
?>
<?php if (isset($title) && $title): ?>
    <h3 class="cegg-shortcode-title"><?php echo esc_html($title); ?></h3>
<?php endif; ?>
<?php $columnsgrid = 4;?>
<?php include(rh_locate_template('inc/ce_common/data_grid.php')); ?>