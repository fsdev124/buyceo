<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php 
$map_line_location = !empty( $row['map_line_location'] ) ? $row['map_line_location'] : '';
$map_line_longitude = !empty( $row['map_line_longitude'] ) ? $row['map_line_longitude'] : '';
$map_line_latitude = !empty( $row['map_line_latitude'] ) ? $row['map_line_latitude'] : '';
$map_line_key = !empty( $row['map_line_key'] ) ? ' key="'. $row['map_line_key'] .'"' : '';
$map_line_zoom = !empty( $row['map_line_zoom'] ) ? $row['map_line_zoom'] : 10;
?>

<?php if ($map_line_location || $map_line_longitude):?>
    <?php if($map_line_location):?>
    <div class="wpsm_spec_map_row mt20 mb20">
        <?php $location = get_post_meta($postID, $map_line_location, true);?>
        <?php echo do_shortcode('[wpsm_googlemap zoom="'. $map_line_zoom .'" location="'. $location .'"'. $map_line_key .']');?>
    </div>
    <?php elseif($map_line_longitude && $map_line_latitude):?>
        <?php $lat = get_post_meta($postID, $map_line_latitude, true);?>
        <?php $lng = get_post_meta($postID, $map_line_longitude, true);?>        
        <?php echo do_shortcode('[wpsm_googlemap zoom="'. $map_line_zoom .'" lat="'.$lat.'" lng="'.$lng.'"'. $map_line_key .']');?>  
    <?php endif;?>
<?php endif;?>