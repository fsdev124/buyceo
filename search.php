<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php get_header(); ?>
<?php $cursearch = get_search_query();?>
<!-- CONTENT -->
<div class="rh-container"> 
    <div class="rh-content-wrap clearfix">
          <!-- Main Side -->
          <div class="main-side clearfix<?php if (rehub_option('rehub_framework_search_layout') == 'rehub_framework_archive_gridfull' || rehub_option('rehub_framework_search_layout') == 'column_grid_full') : ?> full_width<?php endif ;?>">
            <div class="wpsm-title middle-size-title wpsm-cat-title"><h5><span><?php _e('Search Results', 'rehub_framework'); ?></span> <?php echo esc_html($cursearch); ?></h5></div>
            <?php if (rehub_option('rehub_framework_search_layout') == 'rehub_framework_archive_grid') : ?>
                <?php  wp_enqueue_script('masonry'); wp_enqueue_script('imagesloaded'); wp_enqueue_script('masonry_init'); ?>
                <div class="masonry_grid_fullwidth col_wrap_two">
            <?php elseif (rehub_option('rehub_framework_search_layout') == 'rehub_framework_archive_gridfull') : ?>
                <?php  wp_enqueue_script('masonry'); wp_enqueue_script('imagesloaded'); wp_enqueue_script('masonry_init'); ?>
                <div class="masonry_grid_fullwidth col_wrap_three">
            <?php elseif (rehub_option('rehub_framework_search_layout') == 'column_grid') : ?>
                <div class="columned_grid_module rh-flex-eq-height col_wrap_three">
            <?php elseif (rehub_option('rehub_framework_search_layout') == 'column_grid_full') : ?>
                <div class="columned_grid_module rh-flex-eq-height col_wrap_fourth">   
                <?php $boxed = 1;?>                              
            <?php else:?>
                <div>                     
            <?php endif ;?>                       
            <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <?php if (rehub_option('rehub_framework_search_layout') == 'rehub_framework_archive_blog') : ?>
                    <?php include(rh_locate_template('inc/parts/query_type2.php')); ?>
                <?php elseif (rehub_option('rehub_framework_search_layout') == 'rehub_framework_archive_list') : ?>
                    <?php include(rh_locate_template('inc/parts/query_type1.php')); ?>
                <?php elseif (rehub_option('rehub_framework_search_layout') == 'rehub_framework_archive_grid' || rehub_option('rehub_framework_search_layout') == 'rehub_framework_archive_gridfull') : ?>
                    <?php include(rh_locate_template('inc/parts/query_type3.php')); ?>   
                <?php elseif (rehub_option('rehub_framework_search_layout') == 'column_grid' || rehub_option('rehub_framework_search_layout') == 'column_grid_full') : ?>
                    <?php include(rh_locate_template('inc/parts/column_grid.php')); ?>
                <?php else : ?>
                    <?php include(rh_locate_template('inc/parts/query_type1.php')); ?>  
                <?php endif ;?>
            <?php endwhile; ?>
            <?php else : ?>     
            <h5><?php _e('Sorry. No search results found', 'rehub_framework'); ?></h5> 
            <?php endif; ?> 
            </div><div class="clearfix"></div>
            <?php rehub_pagination(); ?>
        </div>  
        <!-- /Main Side -->
        <?php if (rehub_option('rehub_framework_search_layout') != 'rehub_framework_archive_gridfull' && rehub_option('rehub_framework_search_layout') != 'column_grid_full') : ?>
            <!-- Sidebar -->
            <?php get_sidebar(); ?>
            <!-- /Sidebar --> 
        <?php endif ;?>
    </div>
</div>
<!-- /CONTENT -->     
<!-- FOOTER -->
<?php get_footer(); ?>