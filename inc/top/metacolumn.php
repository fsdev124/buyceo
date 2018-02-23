<?php if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}?>
<?php 
	$metavalues = $row['column_meta_fields'];	    
?>
<?php if(!empty ($metavalues[0]['column_meta_name'])) : ?>
    <div class="rehub_meta_fields">                                 
        <?php $count=1; foreach ($metavalues as $metavalue) { ?>
        <?php $field_type = $metavalue['column_meta_type'] ;?>
        <?php if ($field_type == 'wooattr'):?>
            <?php global $product; $field_value = $product->get_attribute(esc_html($metavalue['column_meta_name']));?> 
        <?php else:?>
            <?php $field_value = get_post_meta(get_the_ID(), $metavalue['column_meta_name'], true) ;?> 
        <?php endif;?>
        
        <?php $value_font_size = ($metavalue['column_meta_value_size'] !='') ? 'font-size:'.$metavalue["column_meta_value_size"].'px;' : ''; ?>
        <?php $value_font_color = ($metavalue['column_meta_value_color'] !='') ? 'color:'.$metavalue["column_meta_value_color"].';' : ''; ?>        
        <?php $label_font_size = ($metavalue['column_meta_label_size'] !='') ? 'font-size:'.$metavalue["column_meta_label_size"].'px;' : ''; ?>
        <?php $label_font_color = ($metavalue['column_meta_label_color'] !='') ? 'color:'.$metavalue["column_meta_label_color"].';' : ''; ?>
        <?php $icon_font_size = ($metavalue['column_meta_icon_size'] !='') ? 'font-size:'.$metavalue["column_meta_icon_size"].'px;' : ''; ?>
        <?php $icon_font_color = ($metavalue['column_meta_icon_color'] !='') ? 'color:'.$metavalue["column_meta_icon_color"].';' : ''; ?>        
        <?php $label_font_style = (($metavalue['column_customize'] =='' || $metavalue['column_meta_label_size'] !='') && $metavalue['column_customize'] =='1') ? ' style="'.$label_font_size.$label_font_color.'"' : ''; ?> 
        <?php $icon_font_style = (($metavalue['column_meta_icon_color'] !='' || $metavalue['column_meta_icon_size'] !='') && $metavalue['column_customize'] =='1') ? ' style="'.$icon_font_size.$icon_font_color.'"' : ''; ?> 
        <?php $value_font_style = (($metavalue['column_meta_value_color'] !='' || $metavalue['column_meta_value_size'] !='') && $metavalue['column_customize'] =='1') ? ' style="'.$value_font_size.$value_font_color.'"' : ''; ?>       
    	<?php if($field_type =='checkbox') : ?>
            <div class="rehub_meta_field rehub_field_<?php echo $count; ?>">
                <?php if ($metavalue['column_meta_icon']) : ?>
                    <?php $field_value_check = ($field_value =='1' || $field_value =='on') ? '<i class="fa '.$metavalue["column_meta_icon"].'"></i>' : '' ?>
            	<?php else :?>
                    <?php $field_value_check = ($field_value =='1' || $field_value =='on') ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>' ?>
                <?php endif; ?>
        		<?php if ($metavalue['column_meta_label']) : ?><span class="rehub_meta_field_label"<?php echo $label_font_style; ?>><?php echo esc_html ($metavalue['column_meta_label']); ?></span><?php endif ;?>
                <span class="rehub_meta_field_icon"<?php echo $icon_font_style; ?>><?php echo $field_value_check ;?></span>
                <span class="rehub_meta_field_value hidden"><?php echo $field_value; ?></span>
            </div>
    	<?php else : ?>
            <?php $field_value_exist = ($field_value =='') ? ' disabled' : '' ?>
            <div class="rehub_meta_field rehub_field_<?php echo $count; ?><?php echo $field_value_exist ; ?>">
                <span class="rehub_meta_field_title"><?php if ($metavalue['column_meta_icon']) : ?><span class="rehub_meta_field_icon"<?php echo $icon_font_style; ?>><i class="fa <?php echo $metavalue['column_meta_icon']; ?>"></i></span> <?php endif ;?><?php if ($metavalue['column_meta_label']) : ?><span class="rehub_meta_field_label"<?php echo $label_font_style; ?>><?php echo esc_html ($metavalue['column_meta_label']); ?></span><?php endif ;?></span>
                <span class="rehub_meta_field_value"<?php echo $value_font_style; ?>><?php echo $field_value; ?></span>
                <?php if (!empty($metavalue['column_meta_label_after'])) : ?><span class="rehub_meta_field_label_after"<?php echo $label_font_style; ?>><?php echo do_shortcode(wp_kses_post($metavalue['column_meta_label_after'])); ?></span><?php endif ;?>
            </div>
    	<?php endif; ?>    
        <?php $count++; ?>    
        <?php } ?>                        
    </div>
<?php endif; ?>
