<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<!-- CONTENT -->
<div class="rh-container"> 
    <div class="rh-content-wrap clearfix">
        <!-- Title area -->
        <div class="rh_post_layout_inner_image">
            <?php           
                $image_id = get_post_thumbnail_id(get_the_ID());  
                $image_url = wp_get_attachment_image_src($image_id,'full');
                $image_url = $image_url[0];
                if (function_exists('_nelioefi_url')){
                    $image_nelio_url = get_post_meta( $post->ID, _nelioefi_url(), true );
                    if (!empty($image_nelio_url)){
                        $image_url = esc_url($image_nelio_url);
                    }           
                } 
            ?>  
            <style scoped>#rh_post_layout_inimage{background-image: url(<?php echo $image_url;?>);}</style>
            <div id="rh_post_layout_inimage">
                <?php echo re_badge_create('ribbon'); ?>
                <div class="rh_post_breadcrumb_holder">
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
                </div>
                <div class="rh_post_header_holder">
                    <div class="title_single_area"> 
                        <?php rh_post_header_cat('post');?>                           
                        <h1><?php the_title(); ?></h1>                                
                        <div class="meta post-meta">
                            <?php rh_post_header_meta(true, true, true, true, false);?> 
                        </div>
                        <?php if(rehub_option('compare_btn_single') !='' && is_singular('post')) :?>
                            <?php $cmp_btn_args = array();?>
                            <?php if(rehub_option('compare_btn_cats') != '') {
                                $cmp_btn_args['cats'] = esc_html(rehub_option('compare_btn_cats'));
                            }?>
                            <?php echo wpsm_comparison_button($cmp_btn_args); ?> 
                        <?php endif;?>                            
                    </div>                     
                </div>
                <span class="rh-post-layout-image-mask"></span>
            </div>
        </div>    
	    <!-- Main Side -->
        <div class="main-side single<?php if(get_post_meta($post->ID, 'post_size', true) == 'full_post') : ?> full_width<?php endif; ?> clearfix">            
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <article class="post post-inner <?php $category = get_the_category($post->ID); if ($category) {$first_cat = $category[0]->term_id; echo 'category-'.$first_cat.'';} ?>" id="post-<?php the_ID(); ?>">
                    <?php if(rehub_option('rehub_disable_share_top') =='1' || vp_metabox('rehub_post_side.disable_parts') == '1')  : ?>
                    <?php else :?>
                        <div class="top_share">
                            <?php include(rh_locate_template('inc/parts/post_share.php')); ?>
                        </div>
                        <div class="clearfix"></div> 
                    <?php endif; ?>
                    <?php $no_featured_image_layout = 1;?>
                    <?php include(rh_locate_template('inc/parts/top_image.php')); ?>                                       

                    <?php if(rehub_option('rehub_single_before_post') && vp_metabox('rehub_post_side.show_banner_ads') != '1') : ?><div class="mediad mediad_before_content"><?php echo do_shortcode(rehub_option('rehub_single_before_post')); ?></div><?php endif; ?>

                    <?php the_content(); ?>

                </article>
                <div class="clearfix"></div>
                <?php include(rh_locate_template('inc/post_layout/single-common-footer.php')); ?>                    
            <?php endwhile; endif; ?>
            <?php comments_template(); ?>
		</div>	
        <!-- /Main Side -->  
        <!-- Sidebar -->
        <?php if(get_post_meta($post->ID, 'post_size', true) == 'full_post') : ?><?php else : ?><?php get_sidebar(); ?><?php endif; ?>
        <!-- /Sidebar -->
    </div>
</div>
<!-- /CONTENT -->     