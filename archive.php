<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php get_header(); ?>
<!-- CONTENT -->
<div class="rh-container"> 
    <div class="rh-content-wrap clearfix">
        <!-- Main Side -->
        <div class="main-side clearfix<?php if (rehub_option('rehub_framework_archive_layout') == 'rehub_framework_archive_gridfull' || rehub_option('rehub_framework_archive_layout') == 'column_grid_full') : ?> full_width<?php endif ;?>">
            <?php
                if(isset($_GET['author_name'])) :
                $curauth = get_userdatabylogin($author_name);
            else :
                $curauth = get_userdata(intval($author));
            endif;?>

            <?php /* If this is a category archive */ if (is_category()) { ?>
            <div class="wpsm-title middle-size-title wpsm-cat-title"><h5><span><?php _e('Category:', 'rehub_framework'); ?></span> <?php single_cat_title(); ?></h5></div>
            <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
            <div class="wpsm-title middle-size-title wpsm-cat-title"><h5><span><?php _e('Tag:', 'rehub_framework'); ?></span> <?php single_tag_title(); ?></h5></div>
            <article class='top_rating_text'><?php echo tag_description(); ?></article>				
            <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
            <div class="wpsm-title middle-size-title wpsm-cat-title"><h5><span><?php _e('Archive:', 'rehub_framework'); ?></span> <?php the_time('F jS, Y'); ?></h5></div>
            <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
            <div class="wpsm-title middle-size-title wpsm-cat-title"><h5><span><?php _e('Browsing Archive', 'rehub_framework'); ?></span> <?php the_time('F, Y'); ?></h5></div>
            <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
            <div class="wpsm-title middle-size-title wpsm-cat-title"><h5><span><?php _e('Browsing Archive', 'rehub_framework'); ?></span> <?php the_time('Y'); ?></h5></div>			
            <?php } ?>  
            <?php if (rehub_option('rehub_framework_archive_layout') == 'rehub_framework_archive_grid') : ?>
                <?php  wp_enqueue_script('masonry'); wp_enqueue_script('imagesloaded'); wp_enqueue_script('masonry_init'); ?>
                <div class="masonry_grid_fullwidth col_wrap_two">
            <?php elseif (rehub_option('rehub_framework_archive_layout') == 'rehub_framework_archive_gridfull') : ?>
                <?php  wp_enqueue_script('masonry'); wp_enqueue_script('imagesloaded'); wp_enqueue_script('masonry_init'); ?>
                <div class="masonry_grid_fullwidth col_wrap_three">
            <?php elseif (rehub_option('rehub_framework_archive_layout') == 'column_grid') : ?>
                <div class="columned_grid_module rh-flex-eq-height col_wrap_three">
            <?php elseif (rehub_option('rehub_framework_archive_layout') == 'column_grid_full') : ?>
                <div class="columned_grid_module rh-flex-eq-height col_wrap_fourth">   
                <?php $boxed = 1;?>                              
            <?php else:?>
                <div>                     
            <?php endif ;?>                         
            <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <?php if (rehub_option('rehub_framework_archive_layout') == 'rehub_framework_archive_blog') : ?>
                    <?php include(rh_locate_template('inc/parts/query_type2.php')); ?>
                <?php elseif (rehub_option('rehub_framework_archive_layout') == 'rehub_framework_archive_list') : ?>
                    <?php include(rh_locate_template('inc/parts/query_type1.php')); ?>
                <?php elseif (rehub_option('rehub_framework_archive_layout') == 'rehub_framework_archive_grid' || rehub_option('rehub_framework_archive_layout') == 'rehub_framework_archive_gridfull') : ?>
                    <?php include(rh_locate_template('inc/parts/query_type3.php')); ?>   
                <?php elseif (rehub_option('rehub_framework_archive_layout') == 'column_grid' || rehub_option('rehub_framework_archive_layout') == 'column_grid_full') : ?>
                    <?php include(rh_locate_template('inc/parts/column_grid.php')); ?>
                <?php else : ?>
                    <?php include(rh_locate_template('inc/parts/query_type1.php')); ?>  
                <?php endif ;?>
            <?php endwhile; ?>
            <?php else : ?>		
            <h5><?php _e('Sorry. No posts in this category yet', 'rehub_framework'); ?></h5>	
            <?php endif; ?>	
            </div><div class="clearfix"></div>
            <?php rehub_pagination(); ?>
        </div>	
        <!-- /Main Side -->
        <?php if (rehub_option('rehub_framework_archive_layout') != 'rehub_framework_archive_gridfull' && rehub_option('rehub_framework_archive_layout') != 'column_grid_full') : ?>
            <!-- Sidebar -->
            <?php get_sidebar(); ?>
            <!-- /Sidebar --> 
        <?php endif ;?>
    </div>
</div>
<!-- /CONTENT -->     
<!-- FOOTER -->
<?php get_footer(); ?>