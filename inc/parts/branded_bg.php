<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php if (rehub_option('rehub_branded_bg_url') ) :?>
  <?php $branded_bg_url = rehub_option('rehub_branded_bg_url');?>
  <a id="branded_bg" href="<?php echo $branded_bg_url; ?>" target="_blank" rel="nofollow"></a>
<?php endif; ?>