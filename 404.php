<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php get_header(); ?>
<!-- CONTENT -->
<div class="rh-container"> 
    <div class="rh-content-wrap clearfix">
          <!-- Main Side -->
          <div class="main-side clearfix">
            <div class="post errorpage">				
                <span class="error-text"><?php _e('Houston, we have a problem.', 'rehub_framework'); ?></span>
                <h2>404</h2>
                <span class="error-text"><?php _e('The page you are looking for has not been found.', 'rehub_framework'); ?></span>
                <div class="clearfix"></div>
                <?php get_search_form(); ?>			
            </div>	
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