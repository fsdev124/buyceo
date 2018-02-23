<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php 
    $meta_line_type = (!empty($row['meta_line_type'])) ? $row['meta_line_type'] : '';
    $meta_line_label = (!empty($row['meta_line_label'])) ? $row['meta_line_label'] : '';
    $meta_line_key = (!empty($row['meta_line_key'])) ? $row['meta_line_key'] : ''; 
    $meta_line_prefix = (!empty($row['meta_line_prefix'])) ? $row['meta_line_prefix'] : '';
    $meta_line_postfix = (!empty($row['meta_line_postfix'])) ? $row['meta_line_postfix'] : '';
    $meta_line_customize = (!empty($row['meta_line_customize'])) ? $row['meta_line_customize'] : '';    
    $meta_line_size = (!empty($row['meta_line_size'])) ? $row['meta_line_size'] : '';    
    $meta_line_color = (!empty($row['meta_line_color'])) ? $row['meta_line_color'] : '';  
    $meta_line_tooltip = (!empty($row['meta_line_tooltip'])) ? $row['meta_line_tooltip'] : '';        
?>

<?php if ($meta_line_key):?>
    <?php if ($meta_line_type =='usermeta'):?>
        <?php 
            $post_tmp = get_post($postID);
            $author_id = $post_tmp->post_author;
            $value = get_user_meta($author_id, $meta_line_key, true);
        ?>
    <?php elseif ($meta_line_type =='bpmeta'):?>
        <?php 
            $post_tmp = get_post($postID);
            $author_id = $post_tmp->post_author;
            $args = array(
                'field'   => $meta_line_key, // Field name or ID.
                'user_id' => $author_id
            );                
            $value = (function_exists('bp_get_profile_field_data')) ? bp_get_profile_field_data( $args ) : '';
        ?>            
    <?php else:?>
        <?php $value = get_post_meta($postID, $meta_line_key, true);?>
    <?php endif;?> 
    <?php $visible_class = ($value == '') ? ' meta_row_empty' : '';?>   
    <div class="wpsm_spec_meta_row<?php echo $visible_class;?>">
        <?php if($meta_line_label):?>
            <div class="wpsm_spec_meta_label">
                <?php echo $meta_line_label;?>
                <?php if ($meta_line_tooltip) :?>
                    <span class="wpsm_spec_meta_tooltip"><?php echo do_shortcode('[wpsm_tooltip text="ℹ"]'.$meta_line_tooltip.'[/wpsm_tooltip]');?></span>
                <?php endif;?>
            </div>
        <?php endif;?>
        <div class="wpsm_spec_meta_value">
        <?php if ($meta_line_customize) :?>
        <style scoped>
            .wpsm_spec_row_<?php echo $id;?>_<?php echo $pbid;?> .wpsm_spec_meta_value{font-size: <?php echo $meta_line_size;?>px; color: <?php echo $meta_line_color;?>; line-height: <?php echo $meta_line_size;?>px;}
        </style>
        <?php endif;?>

        <?php if ($value && $meta_line_type =='text') :?>
            <?php if ($meta_line_prefix) :?><span class="wpsm_spec_meta_value_pre"><?php echo $meta_line_prefix;?></span><?php endif;?> 
            <span class="wpsm_spec_meta_value_s"><?php echo $value ?></span>
            <?php if ($meta_line_postfix) :?><span class="wpsm_spec_meta_value_after"><?php echo $meta_line_postfix;?></span><?php endif;?>
        <?php elseif ($value && $meta_line_type =='usermeta') :?>
            <?php if ($meta_line_prefix) :?><span class="wpsm_spec_meta_value_pre"><?php echo $meta_line_prefix;?></span><?php endif;?> 
            <span class="wpsm_spec_meta_value_s"><?php echo $value ?></span>
            <?php if ($meta_line_postfix) :?><span class="wpsm_spec_meta_value_after"><?php echo $meta_line_postfix;?></span><?php endif;?>
        <?php elseif ($value && $meta_line_type =='bpmeta') :?>
            <?php if ($meta_line_prefix) :?><span class="wpsm_spec_meta_value_pre"><?php echo $meta_line_prefix;?></span><?php endif;?> 
            <span class="wpsm_spec_meta_value_s"><?php echo $value ?></span>
            <?php if ($meta_line_postfix) :?><span class="wpsm_spec_meta_value_after"><?php echo $meta_line_postfix;?></span><?php endif;?>
        <?php elseif ($meta_line_type =='checkbox') :?>
            <?php $field_value_check = ($value =='1' || $value =='on') ? '<i class="fa fa-check"></i>' : '<i class="fa fa-ban"></i>' ?>
            <?php $emptyclass = ($value =='1' || $value =='on') ? '' : ' wpsm_no_checkbox_value'; ?>            
            <?php if ($meta_line_prefix) :?><span class="wpsm_spec_meta_value_pre<?php echo $emptyclass;?>"><?php echo $meta_line_prefix;?></span><?php endif;?>
            <span class="wpsm_spec_meta_value_icon<?php echo $emptyclass;?>"><?php echo $field_value_check; ?></span>
            <?php if ($meta_line_postfix) :?><span class="wpsm_spec_meta_value_after<?php echo $emptyclass;?>"><?php echo $meta_line_postfix;?></span><?php endif;?>
        <?php elseif (!empty($value) && $meta_line_type =='acfmulti') :?>
            <?php if (function_exists('get_field')):?>
                <?php if ($meta_line_prefix) :?><span class="wpsm_spec_meta_value_pre"><?php echo $meta_line_prefix;?></span><?php endif;?> 
                <span class="wpsm_spec_meta_value_s"><?php the_field($meta_line_key, $postID); ?></span>
                <?php if ($meta_line_postfix) :?><span class="wpsm_spec_meta_value_after"><?php echo $meta_line_postfix;?></span><?php endif;?>
            <?php endif;?>
        <?php endif;?>      
        </div>
    </div>
<?php endif;?>