<!-- Logo section -->
<div class="logo_section_wrap<?php if (rehub_option('rehub_logo_inmenu') !='') {echo ' hideontablet';}?>">
    <div class="rh-container">
        <div class="logo-section rh-flex-center-align tabletblockdisplay header_seven_style clearfix">
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
            <div class="search head_search"><?php get_search_form(); ?></div>
            <div class=" rh-flex-right-align">
                <div class="header-actions-logo rh-flex-right-align">
                    <div class="tabledisplay">
                        <?php if(rehub_option('header_seven_more_element') != '') : ?>
                            <?php $custom_element = rehub_option('header_seven_more_element'); ?>
                            <div class="celldisplay link-add-cell">
                                <?php echo do_shortcode($custom_element);?>
                            </div>
                        <?php endif; ?>                                    
                        <div class="celldisplay login-btn-cell">
                            <?php $loginurl = (rehub_option('custom_login_url')) ? esc_url(rehub_option('custom_login_url')) : '';?>
                            <?php $rtlclass = (is_rtl()) ? 'mr10' : 'ml10'; ?>
                            <?php $classmenu = 'mobileinmenu floatright '.$rtlclass;?>
                            <?php echo wpsm_user_modal_shortcode(array('as_btn'=> 1, 'class' =>$classmenu, 'loginurl'=>$loginurl));?>                   
                        </div> 
                        <?php 
                        if (rehub_option('header_seven_compare_btn') != 1){
                            global $woocommerce;
                            if ($woocommerce){
                            echo '<div class="celldisplay rh_woocartmenu_cell"><a class="rh-flex-center-align rh_woocartmenu-link icon-in-main-menu menu-item-one-line cart-contents cart_count_'.$woocommerce->cart->cart_contents_count.'" href="'.wc_get_cart_url().'"><span class="rh_woocartmenu-icon"><strong>'.$woocommerce->cart->cart_contents_count.'</strong><span class="rh_woocartmenu-icon-handle"></span></span><span class="rh_woocartmenu-amount">'.$woocommerce->cart->get_cart_total().'</span></a></div>';
                            }                            
                        }
                        else{
                            echo '<div class="celldisplay rh_woocartmenu_cell">';
                            echo rh_compare_icon(array());
                            echo '</div>';
                        }
                        ?>
                    </div>                     
                </div>  
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