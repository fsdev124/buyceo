<!-- Logo section -->
<div class="<?php if (rehub_option('rehub_sticky_nav') !=''){echo 'rh-stickme ';}?>header_five_style logo_section_wrap header_one_row">
    <div class="rh-container">
        <div class="logo-section rh-flex-center-align tabletblockdisplay">
            <div class="logo hideontablet">
          		<?php if(rehub_option('rehub_logo')) : ?>
          			<a href="<?php echo home_url(); ?>" class="logo_image"><img src="<?php echo rehub_option('rehub_logo'); ?>" alt="<?php bloginfo( 'name' ); ?>" height="<?php echo rehub_option( 'rehub_logo_retina_height' ); ?>" width="<?php echo rehub_option( 'rehub_logo_retina_width' ); ?>" /></a>
          		<?php elseif (rehub_option('rehub_text_logo')) : ?>
                <div class="textlogo"><?php echo rehub_option('rehub_text_logo'); ?></div>
                <div class="sloganlogo">
                    <?php if(rehub_option('rehub_text_slogan')) : ?><?php echo rehub_option('rehub_text_slogan'); ?><?php else : ?><?php bloginfo( 'description' ); ?><?php endif; ?>
                </div> 
                <?php else : ?>
          			<div class="textlogo"><?php bloginfo( 'name' ); ?></div>
                    <div class="sloganlogo"><?php bloginfo( 'description' ); ?></div>
          		<?php endif; ?>       
            </div> 
            <!-- Main Navigation -->
            <div class="main-nav rh-flex-right-align<?php echo $header_menuline_style;?>">      
                <?php wp_nav_menu( array( 'container_class' => 'top_menu', 'container' => 'nav', 'theme_location' => 'primary-menu', 'fallback_cb' => 'add_menu_for_blank', 'walker' => new Rehub_Walker ) ); ?>
                <div class="responsive_nav_wrap">
                </div>
                <div class="search-header-contents"><?php get_search_form() ?></div>
            </div>
            <!-- /Main Navigation -->                                                        
        </div>
    </div>
</div>
<!-- /Logo section -->  
