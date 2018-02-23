<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php 
    $post_type = $data_source = $orderby = $order = $show = $ajax = $pag_pos = $tax = $sortid ='';
    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );
    if ($show =='') {$show = '9';}
    if ($order =='') {$order = 'DESC';}

    $sort_panel = ($sortid !='') ? ' panel_id='.intval($sortid).'' : '';
    $out = 'template='.$data_source.' post_type='.$post_type.' orderby='.$orderby.' order='.$order.' per_page='.$show.' pagination='.$pag_pos.' '.$tax.$sort_panel.'';
    $wooout = 'columns=3 orderby='.$orderby.' order='.$order.' per_page='.$show.' pagination='.$pag_pos.' '.$tax.'';
    if($data_source !='woocommerce') {
        if ($ajax !='') {
            echo do_shortcode('[mdf_results_by_ajax shortcode="mdf_custom '.$out.'" animate=1 animate_target=body]');
        }
        else {
            echo do_shortcode('[mdf_custom '.$out.']');
        }
    }
    else {
        if ($ajax !='') {
            echo do_shortcode('[mdf_results_by_ajax shortcode="mdf_products '.$wooout.'" animate=1 animate_target=body]');
        }
        else {
            echo do_shortcode('[mdf_products '.$wooout.']');
        }
    }
        
?>

