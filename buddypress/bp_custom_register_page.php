<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<!DOCTYPE html>
<!--[if IE 8]>    <html class="ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9]>    <html class="ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gt IE 9)|!(IE)] <?php language_attributes(); ?>><![endif]-->
<html <?php language_attributes(); ?>>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width" />
<!-- feeds & pingback -->
  <link rel="profile" href="http://gmpg.org/xfn/11" />
  <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]><script src="<?php echo get_template_directory_uri(); ?>/js/html5shiv.js"></script><![endif]-->    
<?php wp_head(); ?>
<?php $islogin = (!empty($_GET['type'])) ? esc_html($_GET['type']) : '';?>
<?php $membertype = (!empty($_GET['membertype'])) ? esc_html($_GET['membertype']) : '';?>
<?php $membertypelink = ($membertype) ? '&membertype='.$membertype : '';?>
<style>.buddypress-page.main-side.full_width{padding: 30px 35px 20px 35px; background: #fff;box-shadow: 0 0 50px #e3e3e3;}.rh-container{max-width:<?php echo ($islogin == 'login') ? '500px' : '900px';?>}</style>
<?php if(rehub_option('rehub_custom_css')) : ?><style><?php echo rehub_option('rehub_custom_css'); ?></style><?php endif; ?>
<?php if(rehub_option('rehub_analytics_header')) : ?><?php echo rehub_option('rehub_analytics_header'); ?><?php endif; ?>
</head>
<body <?php body_class(); ?>>
<div class="rh-outer-wrap register_wrap_type<?php echo esc_html($membertype);?>" id="rh_user_create_bp"> 
    <div class="mt30 mb20 clearfix"></div>
    <?php if(rehub_option('rehub_logo')) : ?>
    <div class="logo text-center mt30 mb35">
        <a href="<?php echo esc_url(home_url()); ?>" class="logo_image"><img src="<?php echo rehub_option('rehub_logo'); ?>" alt="<?php bloginfo( 'name' ); ?>" height="<?php echo rehub_option( 'rehub_logo_retina_height' ); ?>" width="<?php echo rehub_option( 'rehub_logo_retina_width' ); ?>" /></a>      
    </div>
    <?php endif; ?>
    <!-- CONTENT -->
    <div class="rh-container clearfix mt30 mb30"> 
        <div class="buddypress-page main-side clearfix full_width">            
            <article class="post" id="page-<?php the_ID(); ?>"> 
			    <?php if($islogin == 'login'):?>
			    	<div id="buddypress">
					 	<div class="rehub-login-popup re-user-popup-wrap">
							<form id="rehub_login_form_modal" action="<?php echo home_url( '/' ); ?>" method="post">
								<?php do_action( 'wordpress_social_login' ); ?>
								<div class="re-form-group mb20">
									<label><?php _e('Username', 'rehub_framework') ?></label>
									<input class="re-form-input required" name="rehub_user_login" type="text"/>
								</div>
								<div class="re-form-group mb20">
									<label for="rehub_user_pass"><?php _e('Password', 'rehub_framework')?></label>
									<input class="re-form-input required" name="rehub_user_pass" id="rehub_user_pass" type="password"/>
									<span class="alignright"><a href="<?php echo esc_url(bp_get_signup_page()); ?>?type=resetpass<?php echo $membertypelink;?>" class="color_link bp_resset_link_login"><?php _e('Lost Password?', 'rehub_framework');  ?></a></span>							
								</div>
								<div class="re-form-group mb20">
									<label for="rehub_remember"><input name="rehub_remember" id="rehub_remember" type="checkbox" value="forever" />
									<?php _e('Remember me', 'rehub_framework'); ?></label>
								</div>
								<div class="re-form-group mb20">
									<input type="hidden" name="action" value="rehub_login_member_popup_function"/>
									<button class="wpsm-button rehub_main_btn" type="submit"><?php _e('Login', 'rehub_framework'); ?></button>
								</div>
								<?php wp_nonce_field( 'ajax-login-nonce', 'loginsecurity' ); ?>
							</form>
							<div class="rehub-errors"></div>
							<div class="rehub-login-popup-footer"><?php _e('Don\'t have an account?', 'rehub_framework'); ?> 
								<a href="<?php echo esc_url(bp_get_signup_page()); ?>" class="color_link bp_reg_link_login"><?php _e('Sign Up', 'rehub_framework'); ?></a>
							</div>
						</div>
			        </div>   
			    <?php elseif($islogin == 'resetpass'):?>
			    	<div id="buddypress">
						<!-- Lost Password form -->
						<div id="rehub-reset-popup">
					 	<div class="rehub-reset-popup re-user-popup-wrap">
							<div class="re_title_inmodal"><?php _e('Reset Password', 'rehub_framework'); ?></div>
							<form id="rehub_reset_password_form_modal" action="<?php echo home_url( '/' ); ?>" method="post">
								<div class="re-form-group mb20">
									<label for="rehub_user_or_email"><?php _e('Username or E-mail', 'rehub_framework') ?></label>
									<input class="re-form-input required" name="rehub_user_or_email" id="rehub_user_or_email" type="text"/>
								</div>
								<div class="re-form-group mb20">
									<input type="hidden" name="action" value="rehub_reset_password_popup_function"/>
									<button class="wpsm-button rehub_main_btn" type="submit"><?php _e('Get new password', 'rehub_framework'); ?></button>
								</div>
								<?php wp_nonce_field( 'ajax-login-nonce', 'password-security' ); ?>
							</form>
							<div class="rehub-errors"></div>
							<div class="rehub-login-popup-footer"><?php _e('Already have an account?', 'rehub_framework'); ?> <a href="<?php echo esc_url(bp_get_signup_page()); ?>?type=login<?php echo $membertypelink;?>" class="color_link bp_log_link_login"><?php _e('Login', 'rehub_framework'); ?></a></div>
						</div>
						</div>
					</div>
			    <?php else:?>
			        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			            <?php the_content(); ?>
			        <?php endwhile; endif; ?>			    	
			    <?php endif;?>                        
            </article>            
        </div>    
    </div>
    <!-- /CONTENT -->    

<div class="mt15 mb30 text-center rh-container">
	<?php if($islogin == ''):?>	
		<div class="font120"><?php _e('Already have an account?', 'rehub_framework'); ?> <a href="<?php echo esc_url(bp_get_signup_page()); ?>?type=login<?php echo $membertypelink;?>" class="color_link bp_log_link_login"><?php _e('Login', 'rehub_framework'); ?></a>
		</div>
		<div class="rh-line mt20 mb20"></div>
	<?php endif;?>
	<a href="<?php echo esc_url(home_url()); ?>" class="bp_return_home"><?php _e('Return to Home', 'rehub_framework');?></a>
</div>

</div>
<?php if(rehub_option('rehub_analytics')) : ?><?php echo rehub_option('rehub_analytics'); ?><?php endif; ?>
<?php wp_footer(); ?>
</body>
</html>    