<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<!-- Title area -->
<div class="rh_post_layout_default">
<div class="title_single_area">
    <?php if(is_singular('post') && rehub_option('compare_btn_single') !='') :?>
        <?php $compare_cats = (rehub_option('compare_btn_cats') != '') ? ' cats="'.esc_html(rehub_option('compare_btn_cats')).'"' : '' ;?>
        <?php echo do_shortcode('[wpsm_compare_button'.$compare_cats.']'); ?> 
    <?php endif;?>
    <?php 
        $crumb = '';
        if( function_exists( 'yoast_breadcrumb' ) ) {
            $crumb = yoast_breadcrumb('<div class="breadcrumb">','</div>', false);
        }
        if( ! is_string( $crumb ) || $crumb === '' ) {
            if(rehub_option('rehub_disable_breadcrumbs') == '1' || vp_metabox('rehub_post_side.disable_parts') == '1') {echo '';}
            elseif (function_exists('dimox_breadcrumbs')) {
                dimox_breadcrumbs(); 
            }
        }
        echo $crumb;  
    ?> 
    <?php echo re_badge_create('labelsmall'); ?><?php rh_post_header_cat('post');?>                        
    <h1><?php the_title(); ?></h1>                                
    <div class="meta post-meta">
        <?php rh_post_header_meta(true, true, true, true, false);?> 
    </div>   
</div>
</div>