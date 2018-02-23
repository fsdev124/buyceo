<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php get_header(); ?>
<div id="buddypress">
<div id="bprh-full-header-image" class="mb30">
    <div id="bprh-full-header">
        <div class="rh-container text-center">
            <div class="title"><h1><?php the_title(); ?></h1></div>
                <?php bp_get_template_part( 'common/search/dir-search-form' ); ?>
                <!-- #group-dir-search -->
        </div>     
    </div>    
    <span class="header-cover-image-mask"></span>
</div>

<!-- CONTENT -->
<div class="rh-container clearfix mb30"> 

    <div id="page-<?php the_ID(); ?>"> 

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php bp_get_template_part( 'buddypress/groups/groups' ); ?>
    <?php endwhile; endif; ?>  

    </div>
	
</div>
<!-- /CONTENT --> 
</div><!-- #buddypress -->    
<!-- FOOTER -->
<?php get_footer(); ?>