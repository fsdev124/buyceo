<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if ( ! defined( 'REHUB_ADMIN_DIR' ) ) {
	define( 'REHUB_ADMIN_DIR', get_template_directory_uri() . '/admin/' );
}

if ( ! class_exists( 'Rehub_Admin' ) ) {

	class Rehub_Admin{

		function __construct(){

			add_action( 'admin_init', array( $this, 'rehub_admin_init' ) );
			add_action( 'admin_menu', array( $this, 'rehub_admin_menu' ) );
			add_action( 'admin_head', array( $this, 'rehub_admin_scripts' ) );
			add_action( 'admin_menu', array( $this, 'edit_admin_menus' ) );
			add_action( 'after_switch_theme', array( $this, 'rehub_activation_redirect' ) );
			add_action( 'wp_ajax_rehub_update_registration', array( $this, 'rehub_update_registration' ) );

		}

		/**
		 * Add the top-level menu item to the adminbar.
		 */
		function rehub_add_wp_toolbar_menu_item( $title, $parent = FALSE, $href = '', $custom_meta = array(), $custom_id = '' ) {

			global $wp_admin_bar;

			if ( current_user_can( 'edit_theme_options' ) ) {
				if ( ! is_super_admin() || ! is_admin_bar_showing() ) {
					return;
				}

				// Set custom ID
				if ( $custom_id ) {
					$id = $custom_id;
				// Generate ID based on $title
				} else {
					$id = strtolower( str_replace( ' ', '-', $title ) );
				}

				// links from the current host will open in the current window
				$meta = strpos( $href, site_url() ) !== false ? array() : array( 'target' => '_blank' ); // external links open in new tab/window
				$meta = array_merge( $meta, $custom_meta );

				$wp_admin_bar->add_node( array(
					'parent' => $parent,
					'id'     => $id,
					'title'  => $title,
					'href'   => $href,
					'meta'   => $meta,
				) );
			}

		}

		/**
		 * Modify the menu
		 */
		function edit_admin_menus() {
			global $submenu;

			if ( current_user_can( 'edit_theme_options' ) ) {
				$submenu['rehub'][0][0] = 'Registration'; // Change Rehub to Product Registration
			}
		}

		/**
		 * Redirect to admin page on theme activation
		 */
		function rehub_activation_redirect() {
			if ( current_user_can( 'edit_theme_options' ) ) {
				header( 'Location:' . admin_url() . 'admin.php?page=rehub' );
			}
		}

		/**
		 * Actions to run on initial theme activation
		 */
		function rehub_admin_init() {

			if ( current_user_can( 'edit_theme_options' ) ) {

				if ( isset( $_GET['rehub-deactivate'] ) && $_GET['rehub-deactivate'] == 'deactivate-plugin' ) {
					check_admin_referer( 'rehub-deactivate', 'rehub-deactivate-nonce' );

					$plugins = TGM_Plugin_Activation::$instance->plugins;

					foreach( $plugins as $plugin ) {
						if ( $plugin['slug'] == $_GET['plugin'] ) {
							deactivate_plugins( $plugin['file_path'] );
						}
					}
				} if ( isset( $_GET['rehub-activate'] ) && $_GET['rehub-activate'] == 'activate-plugin' ) {
					check_admin_referer( 'rehub-activate', 'rehub-activate-nonce' );

					$plugins = TGM_Plugin_Activation::$instance->plugins;

					foreach( $plugins as $plugin ) {
						if ( $plugin['slug'] == $_GET['plugin'] ) {
							activate_plugin( $plugin['file_path'] );

							wp_redirect( admin_url( 'admin.php?page=rehub-plugins' ) );
							exit;
						}
					}
				}

				//Child theme updater
				if(!defined('PLUGIN_REPO')){
					define('PLUGIN_REPO', 'http://wpsoul.net/plugins/');
				}
		        if (REHUB_NAME_ACTIVE_THEME == 'RECASH') {
		            if(!defined('THEMESHILD_SLUG')){
						define('THEMESHILD_SLUG', 'rehub-cash');
					} 
					require_once ( locate_template( 'admin/update-checker.php' ) );					
		        }
		        elseif (REHUB_NAME_ACTIVE_THEME == 'REPICK') {
		            if(!defined('THEMESHILD_SLUG')){
						define('THEMESHILD_SLUG', 'rehub-pick');
					} 
					require_once ( locate_template( 'admin/update-checker.php' ) );					
		        }
		        elseif (REHUB_NAME_ACTIVE_THEME == 'RETHING') {
		            if(!defined('THEMESHILD_SLUG')){
						define('THEMESHILD_SLUG', 'rehub-things');
					}
					require_once ( locate_template( 'admin/update-checker.php' ) );					
		        }
		        elseif (REHUB_NAME_ACTIVE_THEME == 'REVENDOR') {
		            if(!defined('THEMESHILD_SLUG')){
						define('THEMESHILD_SLUG', 'rehub-vendor');
					} 
					require_once ( locate_template( 'admin/update-checker.php' ) );					
		        }  
		        elseif (REHUB_NAME_ACTIVE_THEME == 'REDOKAN') {
		            if(!defined('THEMESHILD_SLUG')){
						define('THEMESHILD_SLUG', 'rehub-dokan');
					} 
					require_once ( locate_template( 'admin/update-checker.php' ) );					
		        } 		         
		        elseif (REHUB_NAME_ACTIVE_THEME == 'REDIRECT') {
		            if(!defined('THEMESHILD_SLUG')){
						define('THEMESHILD_SLUG', 'rehub-direct');
					} 
					require_once ( locate_template( 'admin/update-checker.php' ) );					
		        }           
		        elseif (REHUB_NAME_ACTIVE_THEME == 'REWISE') {
		            if(!defined('THEMESHILD_SLUG')){
						define('THEMESHILD_SLUG', 'rehub-wise');
					}
					require_once ( locate_template( 'admin/update-checker.php' ) );					 
		        }

			}
		}

		function rehub_admin_menu(){

			if ( current_user_can( 'edit_theme_options' ) ) {
				// Work around for theme check
				//$rehub_menu_page_creation_method    = 'add_menu_page';
				//$rehub_submenu_page_creation_method = 'add_submenu_page';

				$welcome_screen = add_menu_page( 'ReHub', 'ReHub', 'administrator', 'rehub', array( $this, 'rehub_welcome_screen' ), 'dashicons-rehub-logo', 3 );

				$support        = add_submenu_page( 'rehub', __( 'ReHub Theme Support', 'rehub_framework' ), __( 'Support and tips', 'rehub_framework' ), 'administrator', 'rehub-support', array( $this, 'rehub_support_tab' ) );
				$plugins        = add_submenu_page( 'rehub', __( 'Plugins', 'rehub_framework' ), __( 'Plugins', 'rehub_framework' ), 'administrator', 'rehub-plugins', array( $this, 'rehub_plugins_tab' ) );
				$demos          = add_submenu_page( 'rehub', __( 'Demo stacks', 'rehub_framework' ), __( 'Demo stacks', 'rehub_framework' ), 'administrator', 'rehub-demos', array( $this, 'rehub_demos_tab' ) );				

				$theme_options  = add_submenu_page( 'rehub', __( 'Theme Options', 'rehub_framework' ), __( 'Theme Options', 'rehub_framework' ), 'administrator', 'vpt_option');

				add_action( 'admin_print_scripts-'.$welcome_screen, array( $this, 'welcome_screen_scripts' ) );
				add_action( 'admin_print_scripts-'.$support, array( $this, 'support_screen_scripts' ) );
				add_action( 'admin_print_scripts-'.$demos, array( $this, 'demos_screen_scripts' ) );
				add_action( 'admin_print_scripts-'.$plugins, array( $this, 'plugins_screen_scripts' ) );
			}
		}

		function rehub_welcome_screen() {
			require_once( 'screens/welcome.php' );
		}

		function rehub_support_tab() {
			require_once( 'screens/support.php' );
		}

		function rehub_demos_tab() {
			require_once( 'screens/demos.php' );
		}

		function rehub_plugins_tab() {
			require_once( 'screens/plugins.php' );
		}

		function rehub_update_registration() {

			global $wp_version;

			$rehub_options    = get_option( 'Rehub_Key' );
			$data             = $_POST;
			$tf_username      = isset( $data['tf_username'] ) ? $data['tf_username'] : '';
			$tf_purchase_code = isset( $data['tf_purchase_code'] ) ? $data['tf_purchase_code'] : '';

			if ( '' !== $tf_username && '' !== $tf_purchase_code ) {

				$rehub_options['tf_username'] = $tf_username;
				$tf_purchase_code = strtolower(preg_replace('#([a-z0-9]{8})-?([a-z0-9]{4})-?([a-z0-9]{4})-?([a-z0-9]{4})-?([a-z0-9]{12})#','$1-$2-$3-$4-$5',$tf_purchase_code));
				$rehub_options['tf_purchase_code'] = $tf_purchase_code;

				$prepare_request = array(
					'user-agent' => 'WordPress/'. $wp_version .'; '. home_url(),
					'sslverify'    => false,
					'timeout'     => 10,
					'headers' => array(
						'Authorization' => 'Bearer saqMlpb8QSyFGYNjNxgmWzdwqkTUMbFl',
					)
				);

				$raw_response = wp_remote_get( 'https://api.envato.com/v3/market/author/sale?code=' . $tf_purchase_code, $prepare_request );

				if ( ! is_wp_error( $raw_response ) ) {
					$response = wp_remote_retrieve_body( $raw_response );
					$response = json_decode( $response, true );
				}

				if ( ! empty( $response ) ) {

					if ( ( isset( $response['error'] ) ) || ( isset( $response['buyer'] ) && empty( $response['buyer'] ) ) ) {
						echo 'Error';
					} elseif ( isset( $response['buyer'] ) && ! empty( $response['buyer'] ) ) {
						if ($response['buyer'] == $tf_username) {
							if (!empty ($response['supported_until'])) {
								$rehub_options['tf_support_date'] = $response['supported_until'];
							}
							$result = update_option( 'Rehub_Key', $rehub_options );
							echo 'Updated';							
						}
						else {
							echo 'Errorbuyer';
						}

					}

				} else {

					echo 'Error';

				}

			} else {
				echo 'Empty';
			}

			die();

		}

		function rehub_admin_scripts() {
			if ( is_admin() && current_user_can( 'edit_theme_options' ) ) {
			?>
			<style type="text/css">
			@media screen and (max-width: 782px) {
				#wp-toolbar > ul > .rehub-menu {
					display: block;
				}

				#wpadminbar .rehub-menu > .ab-item .ab-icon {
					padding-top: 6px !important;
					height: 40px !important;
					font-size: 30px !important;
				}
			}
			#wpadminbar .rehub-menu > .ab-item .ab-icon:before,
            .dashicons-rehub-logo:before{
                content: "\f115";
                speak: none;
                font-style: normal;
                font-weight: normal;
                font-variant: normal;
                text-transform: none;
                line-height: 1;

                /* Better Font Rendering =========== */
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }
            .mce-i-footer-columns{background: url(<?php echo get_template_directory_uri();?>/shortcodes/tinyMCE/images/column.png) #eee !important;}
            .mce-i-footer-contact{background: url(<?php echo get_template_directory_uri();?>/shortcodes/tinyMCE/images/bullhorn.png) #eee !important;}           
            </style>
            <script type="text/javascript">
            	jQuery(function() {
            		if (jQuery('#sidebar-2').length > 0) { 
						jQuery( document ).on( 'tinymce-editor-setup', function( event, editor ) {
						    editor.settings.toolbar1 += ',footercolumns,footercontact';
						    editor.addButton( 'footercolumns', {
						        text: '',
						        icon: 'footer-columns',
						        onclick: function () {
						            editor.insertContent( '[wpsm_column size="one-half"]<div class="widget_recent_entries"><div class="title">For customers</div><ul><li><a href="#">First link</a></li><li><a href="#">Second Link</a></li><li><a href="#">Third link</a></li><li><a href="#">Fourth link</a></li></ul></div>[/wpsm_column][wpsm_column size="one-half" position="last"]<div class="widget_recent_entries"><div class="title">For vendors</div><ul><li><a href="#">First link</a></li><li><a href="#">Second Link</a></li><li><a href="#">Third link</a></li><li><a href="#">Fourth link</a></li></ul></div>[/wpsm_column]' );
						        }
						    });
						    editor.addButton( 'footercontact', {
						        text: '',
						        icon: 'footer-contact',
						        onclick: function () {
						            editor.insertContent( '<div class="tabledisplay footer-contact"><div class="left-ficon-contact celldisplay"></div><div class="fcontact-body celldisplay"><span class="call-us-text">Got Questions? Call us 24/7!</span> <span class="call-us-number">(800) 5000-8888</span> <span class="other-fcontact"><a href="mailto:#">test@gmail.com</a></span></div></div>' );
						        }
						    });						    
						});
					}
				});
            </script>
            <?php
			}
		}

		function welcome_screen_scripts(){
			wp_enqueue_style( 'rehub_admin_css', REHUB_ADMIN_DIR . 'screens/css/rehub-admin.css' );
			wp_enqueue_style( 'welcome_screen_css', REHUB_ADMIN_DIR . 'screens/css/rehub-welcome-screen.css' );
			wp_enqueue_script( 'rehub_welcome_screen', REHUB_ADMIN_DIR . 'screens/js/rehub-welcome-screen.js' );
		}

		function support_screen_scripts(){
			wp_enqueue_style( 'rehub_admin_css', REHUB_ADMIN_DIR . 'screens/css/rehub-admin.css' );
		}

		function demos_screen_scripts(){
			wp_enqueue_style( 'rehub_admin_css', REHUB_ADMIN_DIR . 'screens/css/rehub-admin.css' );
			wp_enqueue_script( 'rehub_admin_js', REHUB_ADMIN_DIR . 'screens/js/rehub-demo.js' );
		}

		function plugins_screen_scripts(){
			wp_enqueue_style( 'rehub_admin_css', REHUB_ADMIN_DIR . 'screens/css/rehub-admin.css' );
		}

		function plugin_link( $item ) {
			$installed_plugins = get_plugins();
			$item['sanitized_plugin'] = $item['name'];

			// We have a repo plugin
			if ( ! $item['version'] ) {
				$item['version'] = TGM_Plugin_Activation::$instance->does_plugin_have_update( $item['slug'] );
			}

			/** We need to display the 'Install' hover link */
			if ( ! isset( $installed_plugins[$item['file_path']] ) ) {
				$actions = array(
					'install' => sprintf(
						'<a href="%1$s" class="button button-primary" title="Install %2$s">Install</a>',
						esc_url( wp_nonce_url(
							add_query_arg(
								array(
									'page'          => urlencode( TGM_Plugin_Activation::$instance->menu ),
									'plugin'        => urlencode( $item['slug'] ),
									'plugin_name'   => urlencode( $item['sanitized_plugin'] ),
									'plugin_source' => urlencode( $item['source'] ),
									'tgmpa-install' => 'install-plugin',
									'return_url'    => 'rehub-plugins'
								),
								TGM_Plugin_Activation::$instance->get_tgmpa_url()
							),
							'tgmpa-install',
							'tgmpa-nonce'
						) ),
						$item['sanitized_plugin']
					),
				);
			}
			/** We need to display the 'Activate' hover link */
			elseif ( is_plugin_inactive( $item['file_path'] ) ) {
				$actions = array(
					'activate' => sprintf(
						'<a href="%1$s" class="button button-primary" title="Activate %2$s">Activate</a>',
						esc_url( add_query_arg(
							array(
								'plugin'               => urlencode( $item['slug'] ),
								'plugin_name'          => urlencode( $item['sanitized_plugin'] ),
								'plugin_source'        => urlencode( $item['source'] ),
								'rehub-activate'       => 'activate-plugin',
								'rehub-activate-nonce' => wp_create_nonce( 'rehub-activate' ),
							),
							admin_url( 'admin.php?page=rehub-plugins' )
						) ),
						$item['sanitized_plugin']
					),
				);
			}
			/** We need to display the 'Update' hover link */
			elseif ( version_compare( $installed_plugins[$item['file_path']]['Version'], $item['version'], '<' ) ) {
				$actions = array(
					'update' => sprintf(
						'<a href="%1$s" class="button button-primary" title="Install %2$s">Update</a>',
						wp_nonce_url(
							add_query_arg(
								array(
									'page'          => urlencode( TGM_Plugin_Activation::$instance->menu ),
									'plugin'        => urlencode( $item['slug'] ),
									
									'tgmpa-update'  => 'update-plugin',
									'plugin_source' => urlencode( $item['source'] ),
									'version'       => urlencode( $item['version'] ),
									'return_url'    => 'rehub-plugins'
								),
								TGM_Plugin_Activation::$instance->get_tgmpa_url()
							),
							'tgmpa-update',
							'tgmpa-nonce'
						),
						$item['sanitized_plugin']
					),
				);
			} elseif ( is_plugin_active( $item['file_path'] ) ) {
				$actions = array(
					'deactivate' => sprintf(
						'<a href="%1$s" class="button button-primary" title="Deactivate %2$s">Deactivate</a>',
						esc_url( add_query_arg(
							array(
								'plugin'                 => urlencode( $item['slug'] ),
								'plugin_name'            => urlencode( $item['sanitized_plugin'] ),
								'plugin_source'          => urlencode( $item['source'] ),
								'rehub-deactivate'       => 'deactivate-plugin',
								'rehub-deactivate-nonce' => wp_create_nonce( 'rehub-deactivate' ),
							),
							admin_url( 'admin.php?page=rehub-plugins' )
						) ),
						$item['sanitized_plugin']
					),
				);
			}

			return $actions;
		}
	}

	new Rehub_Admin;

}

// Omit closing PHP tag to avoid "Headers already sent" issues.