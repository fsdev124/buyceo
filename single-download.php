<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php get_header(); ?>
<!-- CONTENT -->
<div class="rh-container"> 
    <div class="rh-content-wrap clearfix">
	    <!-- Main Side -->
        <div class="main-side single edd_single<?php if(vp_metabox('rehub_post_side.post_size') == 'full_post') : ?> full_width<?php endif; ?> clearfix">                  
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <article class="post" id="post-<?php the_ID(); ?>" itemtype="http://schema.org/Product" itemscope="">  
                <h1 itemprop="name"><?php the_title_attribute(); ?></h1>
                <?php include(rh_locate_template('inc/parts/top_image.php')); ?>
                <?php the_content(''); ?>     
            </article>
            <div class="clearfix"></div>
            <?php if(rehub_option('rehub_disable_share') =='1' || vp_metabox('rehub_post_side.disable_parts') == '1' )  : ?>
            <?php else :?>
                <?php include(rh_locate_template('inc/parts/post_share.php')); ?>   
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