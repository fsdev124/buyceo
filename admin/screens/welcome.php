<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php
$rehub_theme = wp_get_theme();
if($rehub_theme->parent_theme) {
    $template_dir =  basename(get_template_directory());
    $rehub_theme = wp_get_theme($template_dir);
}
$rehub_version = $rehub_theme->get( 'Version' );
$rehub_options = get_option( 'Rehub_Key' );
$registration_complete = false;
$tf_username = isset( $rehub_options[ 'tf_username' ] ) ? $rehub_options[ 'tf_username' ] : '';
$tf_support_date = isset( $rehub_options[ 'tf_support_date' ] ) ? $rehub_options[ 'tf_support_date' ] : '';
$tf_purchase_code = isset( $rehub_options[ 'tf_purchase_code' ] ) ? $rehub_options[ 'tf_purchase_code' ] : '';
if( $tf_username !== "" && $tf_purchase_code !== "" ) {
	$registration_complete = true;
}
?>
<div class="wrap about-wrap rehub-wrap">
	<h1><?php echo __( "Welcome to ReHub Theme!", "rehub_framework" ); ?></h1>
	<div class="updated registration-notice-1" style="display: none;">
		<p><strong><?php echo __( "Thanks for registering your purchase. You have now access to demo stacks, support and additional bonuses. ", "rehub_framework" ); ?> </strong></p>
		<?php if ( ! function_exists( 'envato_market' ) ) :?>
			<?php echo __( "If you need automatic theme updates, install Envato Market plugin from ", "rehub_framework" ); ?>
			<a href="<?php echo admin_url( 'admin.php?page=rehub-plugins' );?>"><?php echo __( "Plugins Tab", "rehub_framework" ); ?></a>
		<?php endif;?>
	</div>
	<div class="updated error registration-notice-2" style="display: none;"><p><strong><?php echo __( "Please provide all details for registering your copy of ReHub Theme.", "rehub_framework" ); ?>.</strong></p></div>
	<div class="updated error registration-notice-3" style="display: none;"><p><strong><?php echo __( "Something went wrong. Please try again.", "rehub_framework" ); ?></strong></p></div>
	<div class="updated error registration-notice-4" style="display: none;"><p><strong><?php echo __( "You used not correct name. Please, use your official login name on Envato", "rehub_framework" ); ?></strong></p></div>
	
	<?php if( $registration_complete ) :?>
	<div class="about-text">
		<?php echo __( "Theme is registered on your site! ", "rehub_framework" ); ?>
		<?php echo __( "You have support until: ", "rehub_framework" ); ?><?php $date = date_create($tf_support_date); echo date_format($date, 'Y-m-d');?>
		<a href="http://themeforest.net/item/rehub-directory-shop-coupon-affiliate-theme/7646339" target="_blank"><?php echo __( "(extend support)", "rehub_framework" ); ?></a><br />
		<?php if ( ! function_exists( 'envato_market' ) ) :?>
			<?php echo __( "If you need automatic theme updates, install Envato Market plugin from ", "rehub_framework" ); ?>
			<a href="<?php echo admin_url( 'admin.php?page=rehub-plugins' );?>"><?php echo __( "Plugins Tab", "rehub_framework" ); ?></a>
		<?php endif;?>	
	</div>
	<?php else :?>
	<div class="about-text"><?php echo __( "ReHub Theme is now installed and ready to use! Please register your purchase to get support, automatic theme updates, demo stacks, bonuses.", "rehub_framework" ); ?></div>	
	<?php endif;?>
	
    <div class="rehub-logo"><span class="rehub-version"><?php echo __( "Version", "rehub_framework" ); ?> <?php echo $rehub_version; ?></span></div>
	<h2 class="nav-tab-wrapper">
    	<?php
		printf( '<a href="#" class="nav-tab nav-tab-active">%s</a>', __( "Registration", "rehub_framework" ) );
		printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=rehub-support' ), __( "Support and tips", "rehub_framework" ) );
        printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=rehub-plugins' ), __( "Plugins", "rehub_framework" ) );
		printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=rehub-demos' ), __( "Demo stacks", "rehub_framework" ) );
		?>
	</h2>
    <div class="feature-section">
		<div class="rehub-important-notice registration-form-container">
			<?php
			if( $registration_complete ) {
				echo '<p class="about-description"><span class="dashicons dashicons-yes"></span>'.__("Registration Complete! You have full access to theme data now.", "rehub_framework").'</p>';
			} else {
			?>
			<p class="about-description"><?php echo __( "Enter your credentials below to complete product registration.", "rehub_framework" ); ?></p>
			<div class="rehub-registration-steps">
		    	<div class="feature-section col three-col">
		            <div class="col">
		            	<?php add_thickbox(); ?>
						<h4><?php echo __( "Step 1 - Get your purchase code", "rehub_framework" ); ?></h4>
						<p><?php echo __( 'Please, get your purchase key in download section of theme. View a tutorial&nbsp;', 'rehub_framework' );
						printf( '<a href="%s" class="thickbox" target="_blank">%s</a>.', REHUB_ADMIN_DIR . 'screens/images/api_key.jpg?rel=0&TB_iframe=true&height=792&width=1024',  __('here', "rehub_framework" ) ); ?></p>
		            </div>
		        	<div class="col">
						<h4><?php echo __( "Step 2 - Purchase Validation", "rehub_framework" ); ?></h4>
						<p><?php echo __( "Enter your ThemeForest username, purchase code into the fields below. This will give you access to automatic theme updates, demo stacks, support, etc.", "rehub_framework" ); ?></p>
		            </div>               	
		            <div class="col last-feature">
						<h4><?php echo __( "Step 3 - Next Steps", "rehub_framework" ); ?></h4>
						<p><?php echo __( "After activating of theme, you can install bundled plugins, get access to demo stacks, tips, support, bonuses", "rehub_framework" ); ?></p>
		            </div>
		        </div>
		    </div>						
			<?php } ?>
			<div class="rehub-registration-form">
				<form id="rehub_product_registration">
					<input type="hidden" name="action" value="rehub_update_registration" />
					<input type="text" name="tf_username" id="tf_username" placeholder="<?php echo __( "Themeforest Username", "rehub_framework" ); ?>" value="<?php echo $tf_username; ?>" />
					<input type="text" name="tf_purchase_code" id="tf_purchase_code" placeholder="<?php echo __( "Enter Themeforest Purchase Code", "rehub_framework" ); ?>" value="<?php echo $tf_purchase_code; ?>" />					
				</form>
			</div>
			<button class="button button-large button-primary rehub-large-button rehub-register"><?php echo __( "Submit", "rehub_framework" ); ?></button>
			<span class="rehub-loader"><i class="dashicons dashicons-update loader-icon"></i><span></span></span>			
		</div>
	</div>
    <div class="feature-section">
        <strong>Some important tutorials to make your site better:</strong>
        <ul>
			<li><a href="https://wpsoul.com/make-smart-profitable-deal-affiliate-comparison-site-woocommerce/" target="_blank" rel="noopener">Step by step guide to create affiliate profitable price comparison site on woocommerce</a></li>        	
 			<li><a href="https://wpsoul.com/guide-creating-profitable/" target="_blank">Step by step guide for affiliate websites</a></li>        
            <li><a href="https://wpsoul.com/how-optimize-speed-of-wordpress/" target="_blank">How to optimize speed of site</a></li>
            <li><a href="https://wpsoul.com/optimize-seo-wordpress/" target="_blank">How to make the best SEO optimization on site</a></li>
            <li><a href="https://wpsoul.com/creating-social-business-advanced-membership-site-buddypress-and-s2member/" target="_blank">Set extended Membership on your site</a></li>
            <li><a href="https://wpsoul.com/creating-business-directory-site-with-search-filters/" target="_blank">Creating Directory site with Rehub</a></li>    
            <li><a href="https://wpsoul.com/how-to-create-multi-vendor-shop-on-wordpress/" target="_blank">Creating Multivendor site with Rehub</a></li> 

        </ul>
    </div>	
</div>
