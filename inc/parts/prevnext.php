<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<!-- PAGER SECTION -->
<div class="float-posts-nav" id="float-posts-nav">
    <div class="postNavigation prevPostBox">
        <?php $prev_post = get_previous_post(); if (!empty( $prev_post )): ?>
            <a href="<?php echo get_permalink( $prev_post->ID ); ?>">
                <div class="inner-prevnext">
                <div class="thumbnail">
                    <?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail($prev_post->ID))  ) : ?>
                        <?php echo get_the_post_thumbnail( $prev_post->ID, array(70,70) ); ?>
                    <?php else :?>
                        <?php  $nothumb = get_template_directory_uri() . '/images/default/noimage_70_70.png';?> 
                        <img src="<?php echo $nothumb; ?>" alt="<?php the_title_attribute(); ?>" width="70" height="70" />                   
                    <?php endif; ?>
                </div>
                <div class="headline"><span><?php _e('Previous', 'rehub_framework'); ?></span><h4><?php echo $prev_post->post_title; ?></h4></div>
                </div>
            </a>                          
        <?php endif; ?>
    </div>
    <div class="postNavigation nextPostBox">
        <?php $next_post = get_next_post(); if (!empty( $next_post )): ?>
            <a href="<?php echo get_permalink( $next_post->ID ); ?>">
                <div class="inner-prevnext">
                <div class="thumbnail">
                    <?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail($next_post->ID))  ) : ?>
                        <?php echo get_the_post_thumbnail( $next_post->ID, array(70,70) ); ?>
                    <?php else :?>
                        <?php  $nothumb = get_template_directory_uri() . '/images/default/noimage_70_70.png';?> 
                        <img src="<?php echo $nothumb; ?>" alt="<?php the_title_attribute(); ?>" width="70" height="70" />                   
                    <?php endif; ?>
                </div>
                <div class="headline"><span><?php _e('Next', 'rehub_framework'); ?></span><h4><?php echo $next_post->post_title; ?></h4></div>
                </div>
            </a>                          
        <?php endif; ?>
    </div>                        
</div>
<!-- /PAGER SECTION -->