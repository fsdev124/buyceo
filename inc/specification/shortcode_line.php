<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php 
$shortcode_line = (!empty($row['shortcode_line'])) ? $row['shortcode_line'] : '';
?>
<?php if ($shortcode_line):?>
    <div class="wpsm_spec_shortcode_line mt20 mb20"><?php echo do_shortcode($shortcode_line);?></div>
<?php endif;?>