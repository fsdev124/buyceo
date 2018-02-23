<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php $add_badge_short = (rehub_option('rehub_homecarousel_label')=='1') ? ' add_badge="1"' : '';?>
<?php $badge_title = (rehub_option('rehub_homecarousel_label')=='1') ? ' badge_title="'.rehub_option('rehub_homecarousel_label_text').'"' : ''; ?>
<?php $badge_color = (rehub_option('rehub_label_color')!='') ? ' color_stamp="'.str_replace('def', '', rehub_option('rehub_label_color')).'"': '';?>
<?php $car_base = $data_base = '';?>
<?php if (rehub_option('rehub_homecarousel_tag') !='') {
    $carousel_tag = get_term_by('slug', rehub_option('rehub_homecarousel_tag'), 'post_tag');
    $car_base = ' tag="'.(int) $carousel_tag->term_id.'"';
    $data_base = ' data_source="cat"';
} elseif(rehub_option('rehub_homecarousel_ed') =='1'){
    $data_base = ' data_source="badge"';
    $car_base = ' badge_label="1"';
}
?>
<?php $add_car_style = (rehub_option('rehub_homecarousel_style')!='') ? ' style="'.rehub_option('rehub_homecarousel_style').'"' : '';?>
<?php echo do_shortcode ('[full_carousel '.$add_badge_short.$badge_title.$car_base.$data_base.$badge_color.$add_car_style.']');?>