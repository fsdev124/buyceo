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
global $wp_version;
$prepare_request = array(
	'user-agent' => 'Wpsoul',
	'sslverify'    => false,
	'timeout'     => 10,
);
$demos_json = wp_remote_get( PLUGIN_REPO.'demosdata/rehubdemos.json', $prepare_request);
$demos = '';
if ( ! is_wp_error( $demos_json ) ) {
	$demos = wp_remote_retrieve_body( $demos_json );
	$demos = json_decode( $demos, true );
}

?>
<div class="wrap about-wrap rehub-wrap">
	<?php add_thickbox(); ?>
	<h1><?php echo __( "Welcome to ReHub Theme!", "rehub_framework" ); ?></h1>
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
		printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=rehub' ),  __( "Registration", "rehub_framework" ) );
		printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=rehub-support' ), __( "Support and tips", "rehub_framework" ) );
		printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=rehub-plugins' ), __( "Plugins", "rehub_framework" ) );
		printf( '<a href="#" class="nav-tab nav-tab-active">%s</a>', __( "Demo stacks", "rehub_framework" ) );
		?>
	</h2>
	<div class="rehub-important-notice spoil-re">
	<?php if( $registration_complete ) :?>
		<p class="about-description">
			To easily install demo clones with all posts, pages, installed plugins and settings, use plugin
			<a href="https://wordpress.org/plugins/all-in-one-wp-migration/" target="_blank"><?php echo __( "All-in-one WP migration", "rehub_framework" ); ?></a>. 
			Choose demo stack and click on Link button to see direct link of clone file. Click on link in Popup and download file on your computer. Then, go to Plugins - Add new and Type All-in-one WP migration. After activating plugin, choose All-in-one-migration - Import and choose "Import from file" in dropbox. Upload file of demo stack from your computer which you downloaded in previous step. It can have some time. This is temporary solution for demo stackы while we fix our main demo plugin to make better way.
			<br /><br />
			<strong style="color:red; font-size: 16px"><?php echo __( "Note, after installing, use login:rehubdemo, pass: RehubPass999777 to get access to admin page. YOUR EXISTED CONTENT WILL BE DELETED AND YOU WILL HAVE TOTAL COPY OF DEMO SITE", "rehub_framework" ); ?></strong> 
			<br />
			<strong style="color:red; font-size: 16px">After installing demo clone - delete rehubdemo account.</strong>
			<br /><br />
			For this, create new account in Users - Add new, make it as administrator. Log out from rehubdemo and login as new account. Delete rehubdemo account in Users - all users. <strong>Assign all content to your new account while deleting when wordpress ask you. Sometimes you will see notice that you don't have rights to access to wp-admin page when you use demo account. Just go to homepage and click on any link in Top admin bar to get access to wp-admin, then, create new admin as described above. After demo import, don't forget to change name of site in settings - general, email of site. If you use woocommerce, change also main email in woocommerce - settings - emails</strong>
			<br /><br />
			<span class="re-show-hide"><?php echo __( "Common issues - read before install!!!!!!", "rehub_framework" ); ?></span>		
			<span class="open-re-onclk">
			<br />
			If, while uploading file, process is stoped, try to upload file with ftp to folder /wp-content/ai1wm-backups, then, you can restore site from All-in-One-Migration - Backups.		
			</span>


		</p>
	<?php else :?>
		<p class="about-description">
			<?php echo __( "To get access to demo stacks, you first must register your purchase.<br />
See the", "rehub_framework" ); ?> <?php printf( '<a href="%s">%1s</a> %2s', admin_url( 'admin.php?page=rehub' ), __( "Product Registration", "rehub_framework" ), __("tab for instructions on how to complete registration.", "rehub_framework" ) ); ?></p>
		</p>
	<?php endif ;?>	
	 
		
	</div>
	<div class="rehub-demo-themes">
		<div class="feature-section theme-browser rendered">
			<?php
			if (!empty ($demos)) {
				// Loop through all demos
				foreach ( $demos as $demo => $demo_details ) { ?>
					<div class="theme">
						<div class="theme-screenshot">
							<img src="<?php echo REHUB_ADMIN_DIR . 'screens/images/' . $demo . '_preview.jpg'; ?>" />
						</div>
						<h3 class="theme-name"><?php echo $demo_details['name']; ?></h3>
						<div id="linkdemo-<?php echo $demo; ?>" style="display:none;">
	     					<p><?php echo $demo_details['zip']; ?></p>
						</div>
						<div class="theme-actions">
							<?php if( $registration_complete ) { ?>
							<?php printf( '<a class="button button-primary button-install-demo thickbox" href="#TB_inline?width=600&height=100&inlineId=linkdemo-%s">%s</a>', $demo, __( "Link", "rehub_framework" ) ); ?>
							<?php printf( '<a class="button button-primary" target="_blank" href="%1s">%2s</a>', $demo_details["link"], __( "Preview", "rehub_framework" ) ); ?>
							<?php } else { ?>
							<?php printf( '<a class="button button-primary disabled button-install-demo">%s</a>', __( "Link", "rehub_framework" ) ); ?>
							<?php printf( '<a class="button button-primary" target="_blank" href="%1s">%2s</a>', $demo_details["link"], __( "Preview", "rehub_framework" ) ); ?>
							<?php } ?>
						</div>
						<?php if( isset( $demo_details['new'] ) && $demo_details['new'] == true ): ?>
						<div class="plugin-required">
							<?php _e( 'New', 'rehub_framework' ); ?>
						</div>
						<?php endif; ?>
					</div>
				<?php } 
				echo '<div class="theme"><div class="theme-screenshot"><img src="'.REHUB_ADMIN_DIR . 'screens/images/soon.jpg" /></div></div>';
			}
			?>
		</div>
	</div>
</div>
