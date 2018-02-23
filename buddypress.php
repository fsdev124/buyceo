<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php if (bp_is_register_page()) :?>
    <?php include(rh_locate_template('buddypress/bp_custom_register_page.php')); ?>
<?php elseif (bp_is_group_create()):?>
    <?php include(rh_locate_template('buddypress/bp_custom_create_group.php')); ?>
<?php elseif (function_exists('is_rtmedia_gallery') && (is_rtmedia_gallery() || is_rtmedia_album_gallery() || is_rtmedia_single() || is_rtmedia_album())):?>
    <?php include(rh_locate_template('rtmedia/mediaindex.php')); ?>    
<?php else:?>
    <?php get_header(); ?>
    <!-- CONTENT -->
    <div class="rh-container clearfix mt30 mb30"> 
        <div class="buddypress-page main-side clearfix full_width">            
            <article class="post" id="page-<?php the_ID(); ?>">       
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php the_content(); ?>
            <?php endwhile; endif; ?>      
            </article>            
        </div>    
    </div>
    <!-- /CONTENT --> 
    <!-- FOOTER -->
    <?php get_footer(); ?>
<?php endif;?>