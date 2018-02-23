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
<?php $grouptype = (!empty($_GET['grouptype'])) ? $_GET['grouptype'] : '';?>
<style>.buddypress-page.main-side.full_width{padding: 30px 35px 20px 35px; background: #fff;box-shadow: 0 0 50px #e3e3e3;}.rh-container{max-width:900px;}</style>
<?php if(rehub_option('rehub_custom_css')) : ?><style><?php echo rehub_option('rehub_custom_css'); ?></style><?php endif; ?>
<?php if(rehub_option('rehub_analytics_header')) : ?><?php echo rehub_option('rehub_analytics_header'); ?><?php endif; ?>
</head>
<body <?php body_class(); ?>>
<div class="rh-outer-wrap <?php echo esc_html($grouptype);?>" id="rh_group_create_bp"> 
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

			        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			            <?php the_content(); ?>
			        <?php endwhile; endif; ?>			    	                       
            </article>            
        </div>    
    </div>
    <!-- /CONTENT -->    

<div class="mt15 mb30 text-center rh-container">
	<a href="<?php echo esc_url(home_url()); ?>" class="bp_return_home"><?php _e('Return to Home', 'rehub_framework');?></a>
</div>

</div>
<?php if(rehub_option('rehub_analytics')) : ?><?php echo rehub_option('rehub_analytics'); ?><?php endif; ?>
<?php wp_footer(); ?>
</body>
</html>    