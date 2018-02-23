<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php
/*
  Name: User comments
 */
?>
<?php if (isset($title) && $title): ?>
    <h3 class="cegg-shortcode-title"><?php echo esc_html($title); ?></h3>
<?php endif; ?>
<?php foreach ($items as $item): ?>
     <?php if (!empty($item['extra']['comments'])) {$import_comments = $item['extra']['comments'];}?>
    <?php include(rh_locate_template('inc/ce_common/user_comments.php')); ?>
<?php endforeach; ?>        