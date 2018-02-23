<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php
/*
  Name: Item specification
 */

use Keywordrush\AffiliateEgg\TemplateHelper; 

?>
<?php if (isset($title) && $title): ?>
    <h3 class="cegg-shortcode-title"><?php echo esc_html($title); ?></h3>
<?php endif; ?>
<?php foreach ($items as $item): ?>
    <?php if (!empty ($item['features'])) {
    	$attributes = $item['features'];
    	}
    	elseif(!empty ($item['extra']['features'])) {
    	$attributes = $item['extra']['features'];
    	}
    ?>
    <?php include(rh_locate_template('inc/ce_common/item_specification.php')); ?>
<?php endforeach; ?>     