<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php 
    $meta_line_type = (!empty($row['acfmeta_line_type'])) ? $row['acfmeta_line_type'] : '';
    $meta_line_label = (!empty($row['acfmeta_line_label'])) ? $row['acfmeta_line_label'] : '';
    $meta_line_key = (!empty($row['acfmeta_line_key'])) ? $row['acfmeta_line_key'] : '';  
    $meta_line_tooltip = (!empty($row['acfmeta_line_tooltip'])) ? $row['acfmeta_line_tooltip'] : '';        
?>

<?php if ($meta_line_key && function_exists('get_field')):?>
    <div class="wpsm_spec_meta_row">
        <div class="wpsm_spec_meta_label">
            <?php echo $meta_line_label;?>
            <?php if ($meta_line_tooltip) :?>
                <span class="wpsm_spec_meta_tooltip"><?php echo do_shortcode('[wpsm_tooltip text="ℹ"]'.$meta_line_tooltip.'[/wpsm_tooltip]');?></span>
            <?php endif;?>
        </div>
        <div class="wpsm_spec_meta_value">

        <?php $value = get_field($meta_line_key, $postID); ?>
        <?php if (!empty($value) && $meta_line_type =='text') :?>
            <span class="wpsm_spec_meta_value_s"><?php echo $value ?></span>
        <?php elseif ($meta_line_type =='checkbox') :?>
            <?php $field_value_check = (!empty($value)) ? '<i class="fa fa-check"></i>' : '<i class="fa fa-ban"></i>' ?>
            <span class="wpsm_spec_meta_value_icon"><?php echo $field_value_check; ?></span>
        <?php elseif ($meta_line_type =='array' && !empty($value)) :?>
            <span class="wpsm_spec_meta_value_s"><?php the_field($meta_line_key, $postID); ?></span>            
        <?php endif;?>
        </div>
    </div>
<?php endif;?>