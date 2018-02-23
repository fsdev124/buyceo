<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php get_header(); ?>
<?php $catID = get_query_var( 'cat' );?>
<?php if ( get_query_var('paged') ) { $paged = get_query_var('paged'); } else if ( get_query_var('page') ) {$paged = get_query_var('page'); } else {$paged = 1; } ?>
<?php $show = get_option('posts_per_page');?>
<?php $args = array(
    'posts_per_page' => $show,
    'cat' => $catID,
    'paged' => $paged,
);?>
<!-- CONTENT -->
<div class="rh-container"> 
    <div class="rh-content-wrap clearfix">
        <!-- Main Side -->
        <div class="main-side clearfix<?php if (rehub_option('rehub_framework_category_layout') == 'rehub_framework_category_gridfull' || rehub_option('rehub_framework_category_layout') == 'column_grid_full') : ?> full_width<?php endif ;?>">
            <div class="wpsm-title middle-size-title wpsm-cat-title"><h5><span><?php _e('Category:', 'rehub_framework'); ?></span> <?php single_cat_title(); ?></h5></div>
            <?php if( !is_paged()) : ?><article class='top_rating_text post'><?php echo category_description(); ?></article><?php endif ;?>
                <?php if (rehub_option('rehub_framework_category_layout') == 'rehub_framework_category_grid') : ?>
                    <?php  wp_enqueue_script('masonry'); wp_enqueue_script('imagesloaded'); wp_enqueue_script('masonry_init'); ?>
                    <div class="masonry_grid_fullwidth col_wrap_two">
                <?php elseif (rehub_option('rehub_framework_category_layout') == 'rehub_framework_category_gridfull') : ?>
                    <?php  wp_enqueue_script('masonry'); wp_enqueue_script('imagesloaded'); wp_enqueue_script('masonry_init'); ?>
                    <div class="masonry_grid_fullwidth col_wrap_three">
                <?php elseif (rehub_option('rehub_framework_category_layout') == 'column_grid') : ?>
                    <div class="columned_grid_module rh-flex-eq-height col_wrap_three">
                <?php elseif (rehub_option('rehub_framework_category_layout') == 'column_grid_full') : ?>
                    <div class="columned_grid_module rh-flex-eq-height col_wrap_fourth">   
                    <?php $boxed = 1;?>                              
                <?php else:?>
                    <div>                     
                <?php endif ;?>             
                <?php 
                $args = apply_filters('rh_category_args_query', $args);
                $wp_query = new WP_Query($args);
                do_action('rh_after_category_args_query', $wp_query);
                if ( $wp_query->have_posts() ) : ?>            
                <?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
                    <?php if (rehub_option('rehub_framework_category_layout') == 'rehub_framework_category_blog') : ?>
                        <?php include(rh_locate_template('inc/parts/query_type2.php')); ?>
                    <?php elseif (rehub_option('rehub_framework_category_layout') == 'rehub_framework_category_list') : ?>
                        <?php include(rh_locate_template('inc/parts/query_type1.php')); ?>
                    <?php elseif (rehub_option('rehub_framework_category_layout') == 'rehub_framework_category_grid' || rehub_option('rehub_framework_category_layout') == 'rehub_framework_category_gridfull') : ?>
                        <?php include(rh_locate_template('inc/parts/query_type3.php')); ?>
                    <?php elseif (rehub_option('rehub_framework_category_layout') == 'column_grid' || rehub_option('rehub_framework_category_layout') == 'column_grid_full') : ?>
                        <?php include(rh_locate_template('inc/parts/column_grid.php')); ?>                          
                    <?php else : ?>
                        <?php include(rh_locate_template('inc/parts/query_type1.php')); ?>	
                    <?php endif ;?>
                <?php endwhile; ?>

                <?php else : ?>		
                    <h5><?php _e('Sorry. No posts in this category yet', 'rehub_framework'); ?></h5>			   
                <?php endif; ?>
            </div><div class="clearfix"></div>                    
            <?php rehub_pagination();?> 
            <?php  $cat_data = get_option("category_$catID");?> 
            <?php if(!empty($cat_data['cat_second_description'])):?>
                <?php $cat_seo_description = $cat_data['cat_second_description'];?>
                <article class="cat_seo_description post"><?php echo do_shortcode($cat_seo_description);?></article>
            <?php endif;?>              	
        </div>	
        <!-- /Main Side -->
        <?php if (rehub_option('rehub_framework_category_layout') != 'rehub_framework_category_gridfull' && rehub_option('rehub_framework_category_layout') != 'column_grid_full') : ?>
            <!-- Sidebar -->
            <?php get_sidebar(); ?>
            <!-- /Sidebar --> 
        <?php endif ;?>
    </div>
</div>
<!-- /CONTENT -->     
<!-- FOOTER -->
<?php get_footer(); ?>