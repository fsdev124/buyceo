<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php
    /* Template Name: Favorites list (Only for Favorites plugin) */
?>
<?php get_header(); ?>
<!-- CONTENT -->
<div class="rh-container"> 
    <div class="rh-content-wrap clearfix">
          <!-- Main Side -->
          <div class="main-side page clearfix">
            <div class="title"><h1><?php the_title(); ?></h1></div>
            <article class="post" id="page-<?php the_ID(); ?>">       
                
                 <?php RhGetUserFavorites();?>

                <?php if(function_exists('get_user_favorites')):?>
                    <?php $favorites = get_user_favorites();
                if ( isset($favorites) && !empty($favorites) ) :
                    echo '<ul class="re-favorites-posts">';
                    foreach ( $favorites as $favorite ) :
                        echo '<li>';
                            echo '<a href="'.get_the_permalink($favorite).'" target="_blank">';
                                echo get_the_post_thumbnail($favorite, array( 50, 50));
                                echo get_the_title($favorite);
                            echo '</a>';
                        echo '</li>';                
                    endforeach; 
                    echo '</ul>';
                endif; ?>
                <?php endif;?>                     
            </article>
        </div>	
        <!-- /Main Side -->  
        <!-- Sidebar -->
        <?php get_sidebar(); ?>
        <!-- /Sidebar --> 
    </div>
</div>
<!-- /CONTENT -->     
<!-- FOOTER -->
<?php get_footer(); ?>