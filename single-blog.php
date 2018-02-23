<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php get_header(); ?>
<!-- CONTENT -->
<div class="rh-container"> 
    <div class="rh-content-wrap clearfix">
	    <!-- Main Side -->
        <div class="main-side single<?php if(vp_metabox('rehub_post_side.post_size') == 'full_post') : ?> full_width<?php endif; ?> clearfix">            
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <article class="post post-inner" id="post-<?php the_ID(); ?>">
                <?php include(rh_locate_template('inc/post_layout/top_title.php')); ?>
                <?php if(rehub_option('rehub_single_after_title')) : ?><div class="mediad mediad_top"><?php echo do_shortcode(rehub_option('rehub_single_after_title')); ?></div><div class="clearfix"></div><?php endif; ?>
                <?php if(rehub_option('rehub_disable_share_top') =='1' || vp_metabox('rehub_post_side.disable_parts') == '1')  : ?>
                <?php else :?>
                    <div class="top_share"><?php include(rh_locate_template('inc/parts/post_share.php')); ?></div>
                    <div class="clearfix"></div> 
                <?php endif; ?>                	
                <?php if(vp_metabox('rehub_post.rehub_framework_post_type') == 'review' && vp_metabox('rehub_post.review_post.0.review_post_schema_type') == 'review_woo_product' && vp_metabox('rehub_post.review_post.0.review_woo_product.0.review_woo_slider') =='1') :?>
                    <?php get_template_part('inc/parts/woo_slider'); ?>
            	<?php elseif(vp_metabox('rehub_post.rehub_framework_post_type') == 'review' && vp_metabox('rehub_post.review_post.0.rehub_review_slider') =='1') :?>                     
                    <?php get_template_part('inc/parts/review_slider'); ?>
                <?php else :?> 
                	<?php include(rh_locate_template('inc/parts/top_image.php')); ?>
                <?php endif; ?>

                <?php if(vp_metabox('rehub_post.rehub_framework_post_type') == 'music') : ?>
                    <?php if(vp_metabox('rehub_post.music_post.0.music_post_source') == 'music_post_soundcloud') : ?>
                        <div class="music_soundcloud mb15">
                            <?php echo vp_metabox('rehub_post.music_post.0.music_post_soundcloud_embed'); ?>
                        </div>                        
                    <?php elseif(vp_metabox('rehub_post.music_post.0.music_post_source') == 'music_post_spotify') : ?>
                        <div class="music_spotify mb15">
                            <iframe src="https://embed.spotify.com/?uri=<?php echo vp_metabox('rehub_post.music_post.0.music_post_spotify_embed'); ?>" width="100%" height="80" frameborder="0" allowtransparency="true"></iframe>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if(rehub_option('rehub_single_before_post') && vp_metabox('rehub_post_side.show_banner_ads') != '1') : ?><div class="mediad mediad_before_content"><?php echo do_shortcode(rehub_option('rehub_single_before_post')); ?></div><?php endif; ?>

                <?php the_content(); ?>                                           
            
            </article>

            <div class="clearfix"></div>
            <?php echo re_badge_create('labelbig'); ?>
            <?php if(rehub_option('rehub_single_code') && vp_metabox('rehub_post_side.show_banner_ads') != '1') : ?><div class="single_custom_bottom"><?php echo do_shortcode (rehub_option('rehub_single_code')); ?></div><div class="clearfix"></div><?php endif; ?>
           
            <?php if(rehub_option('rehub_disable_share') =='1' || vp_metabox('rehub_post_side.disable_parts') == '1')  : ?>
            <?php else :?>
                <?php include(rh_locate_template('inc/parts/post_share.php')); ?>  
            <?php endif; ?>

            <?php if(rehub_option('rehub_disable_prev') =='1' || vp_metabox('rehub_post_side.disable_parts') == '1')  : ?>
            <?php else :?>
                <?php include(rh_locate_template('inc/parts/prevnext.php')); ?>                    
            <?php endif; ?>                 

            <?php if(rehub_option('rehub_disable_tags') =='1' || vp_metabox('rehub_post_side.disable_parts') == '1')  : ?>
            <?php else :?>
                <div class="tags">
                    <p><?php echo get_the_term_list( $post->ID, 'blog_tag', '<span class="tags-title-post">'.__('Tags: ', 'rehub_framework').'</span>', ' ', '' ); ?></p>
                </div>
            <?php endif; ?>

            <?php if(rehub_option('rehub_disable_author') =='1' || vp_metabox('rehub_post_side.disable_parts') == '1')  : ?>
            <?php else :?>
                <?php rh_author_detail_box();?>
            <?php endif; ?>               

            <?php if(rehub_option('rehub_disable_relative') =='1' || vp_metabox('rehub_post_side.disable_parts') == '1')  : ?>
            <?php else :?>
                <?php include(rh_locate_template('inc/parts/blogrelated.php')); ?>
            <?php endif; ?>                               

        <?php endwhile; endif; ?>

            <?php comments_template(); ?>

		</div>	
        <!-- /Main Side -->  

        <!-- Sidebar -->
        <?php if(vp_metabox('rehub_post_side.post_size') == 'full_post') : ?><?php else : ?><?php get_sidebar(); ?><?php endif; ?>
        <!-- /Sidebar --> 

    </div>
</div>
<!-- /CONTENT -->     

<!-- FOOTER -->
<?php get_footer(); ?>