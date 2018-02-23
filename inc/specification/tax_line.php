<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php 
$tax_line_label = (!empty($row['tax_line_label'])) ? $row['tax_line_label'] : '';
$tax_line_name = (!empty($row['tax_line_name'])) ? $row['tax_line_name'] : '';
$tax_line_type = (!empty($row['tax_line_type'])) ? $row['tax_line_type'] : '';
?>

<?php if ($tax_line_name):?>
    <div class="wpsm_spec_meta_row">
        <div class="wpsm_spec_meta_label">
            <?php echo $tax_line_label;?>
        </div>
        <div class="wpsm_spec_meta_value">
            <span class="wpsm_spec_meta_value_s">
                <?php 
                if ($tax_line_type){
                    $term_list = get_the_term_list($postID, $tax_line_name, '<span class="wpsm_tax_line_link">', ', ', '</span>' );
                    if(!is_wp_error($term_list)){
                        echo '<span class="tag_post_store_meta">'.$term_list.'</span>';
                    }
                }
                else {
                    $terms = get_the_terms($postID, $tax_line_name );
                    if ($terms && ! is_wp_error($terms)) :
                        $term_slugs_arr = array();
                        foreach ($terms as $term) {
                            $term_slugs_arr[] = ''.$term->name.'';
                        }
                        $terms_slug_str = join(", ", $term_slugs_arr);
                        echo $terms_slug_str;
                    endif;                    
                }
                ?>
            </span>    
        </div>
    </div>
<?php endif;?>