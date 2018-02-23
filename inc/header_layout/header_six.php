<!-- Logo section -->
<div class="logo_section_wrap<?php if (rehub_option('rehub_logo_inmenu') !='') {echo ' hideontablet';}?>">
    <div class="rh-container">
        <div class="logo-section rh-flex-center-align tabletblockdisplay header_six_style clearfix">
            <div class="logo">
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
            <?php if(rehub_option('header_six_menu') != '') : ?>
                <?php $nav_menu = wp_get_nav_menu_object( rehub_option('header_six_menu') ); // Get menu
                if (!empty ($nav_menu)) :?>
                    <div id="re_menu_near_logo" class="hideontablet">
                        <?php wp_nav_menu( array( 'fallback_cb' => '', 'menu' => $nav_menu, 'container' => false  ) );?>
                    </div>
                <?php endif ;?>                                       
            <?php endif; ?>
            <div class=" rh-flex-right-align">
            <?php if(rehub_option('header_six_login') == 1) : ?>
                <?php $rtlclass = (is_rtl()) ? 'mr10' : 'ml10'; ?>
                <?php $loginurl = (rehub_option('custom_login_url')) ? esc_url(rehub_option('custom_login_url')) : '';?>
                <?php $classmenu = 'mobileinmenu floatright '.$rtlclass;?>
                <?php echo wpsm_user_modal_shortcode(array('as_btn'=> 1, 'class' =>$classmenu, 'loginurl'=>$loginurl));?>
            <?php endif; ?> 
            <?php if(rehub_option('header_six_btn') == 1) : ?>
                <?php $btnlink = rehub_option('header_six_btn_url'); ?>
                <?php $btnlabel = rehub_option('header_six_btn_txt'); ?>
                <?php $btn_color = (rehub_option('header_six_btn_color') != '') ? rehub_option('header_six_btn_color') : 'green'; ?>
                <?php $header_six_btn_login = (rehub_option('header_six_btn_login') == 1) ? 'act-rehub-login-popup' : ''; ?>
                <?php $btnclass = 'addsomebtn mobileinmenu mr5 ml5 floatright '.$header_six_btn_login;?>
                <?php echo wpsm_shortcode_button(array('icon'=>'plus', 'link'=>$btnlink, 'class'=>$btnclass, 'color'=>$btn_color), $btnlabel);?>
            <?php endif; ?>
            <?php if(rehub_option('header_six_src') == 1) : ?>
                <?php echo wpsm_searchform_shortcode(array('class'=>'head_search floatright hideontablet mr5 ml5'));?>
            <?php endif; ?>
            </div>                        
        </div>
    </div>
</div>
<!-- /Logo section -->  
<!-- Main Navigation -->
<div class="search-form-inheader main-nav<?php if (rehub_option('rehub_sticky_nav') !=''){echo ' rh-stickme';}?><?php echo $header_menuline_style;?>">  
    <div class="rh-container<?php if (rehub_option('rehub_sticky_nav') && rehub_option('rehub_logo_sticky_url') !=''){echo ' rh-flex-center-align logo_insticky_enabled';}?>"> 
	    <?php 
	        if (rehub_option('rehub_sticky_nav') && rehub_option('rehub_logo_sticky_url') !='') {
	            echo '<a href="'.get_home_url().'" class="logo_image_insticky"><img src="'.rehub_option('rehub_logo_sticky_url').'" alt="'.get_bloginfo( "name" ).'" /></a>';                
	        }             
	    ?>    
        <?php wp_nav_menu( array( 'container_class' => 'top_menu', 'container' => 'nav', 'theme_location' => 'primary-menu', 'fallback_cb' => 'add_menu_for_blank', 'walker' => new Rehub_Walker ) ); ?>
        <div class="responsive_nav_wrap">
        </div>
        <div class="search-header-contents"><?php get_search_form() ?></div>
    </div>
</div>
<!-- /Main Navigation -->