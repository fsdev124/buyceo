<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php
# 	
# 	USER REGISTRATION/LOGIN MODAL
# 	========================================================================================
#   Attach this function to the footer if the user isn't logged in
# 	========================================================================================
# 		
if( !function_exists('rehub_login_register_modal') ) {
function rehub_login_register_modal() {
	// only show the registration/login form to non-logged-in members
	if(!is_user_logged_in() && rehub_option('custom_login_url') == ''){ 

		$show_terms_conditions = rehub_option('userlogin_terms_enable');
		?>
						
		<?php if(get_option('users_can_register')){ ?>
			<div id="rehub-login-popup-block">
				<?php if (rehub_option('custom_register_link') ==''):?>
					<!-- Register form -->
					<div id="rehub-register-popup">
					<div class="rehub-register-popup">	 
						<div class="re_title_inmodal"><?php _e('Register New Account', 'rehub_framework'); ?></div>
						<?php if (rehub_option('custom_msg_popup') !='') {
							echo '<div class="mb15 mt15 rh_custom_msg_popup">';
							echo do_shortcode(rehub_option('custom_msg_popup'));
							echo '</div>';
							} ?>
						<form id="rehub_registration_form_modal" action="<?php echo home_url( '/' ); ?>" method="POST">
							<?php do_action( 'wordpress_social_login' ); ?>
							<div class="re-form-group mb20">
								<label><?php _e('Username', 'rehub_framework'); ?></label>
								<input class="re-form-input required" name="rehub_user_login" type="text"/>
							</div>
							<div class="re-form-group mb20">
								<label for="rehub_user_email"><?php _e('Email', 'rehub_framework'); ?></label>
								<input class="re-form-input required" name="rehub_user_email" id="rehub_user_email" type="email"/>
							</div>
							<div class="re-form-group mb20">
								<label for="rehub_user_signonpassword"><?php _e('Password', 'rehub_framework'); ?><span class="alignright font90"><?php _e('Minimum 6 symbols', 'rehub_framework');  ?></span></label>
								<input class="re-form-input required" name="rehub_user_signonpassword" id="rehub_user_signonpassword" type="password"/>
							</div>
							<div class="re-form-group mb20">
								<label for="rehub_user_confirmpassword"><?php _e('Confirm password', 'rehub_framework'); ?></label>
								<input class="re-form-input required" name="rehub_user_confirmpassword" id="rehub_user_confirmpassword" type="password"/>
							</div>	
							<?php if ( class_exists( 'BuddyPress' ) && rehub_option('userpopup_xprofile') == 1):?>
								<?php if ( bp_is_active( 'xprofile' ) ) : ?>
									<div id="xp-woo-profile-details-section"<?php if(rehub_option('userpopup_xprofile_hidename') == 1){echo ' class="xprofile_hidename"';}?>>
										<?php if ( bp_has_profile( array( 'profile_group_id' => 1, 'fetch_field_data' => false ) ) ) : while ( bp_profile_groups() ) : bp_the_profile_group(); ?>
											<?php while ( bp_profile_fields() ) : bp_the_profile_field(); ?>
												<div<?php bp_field_css_class( 'editfield re-form-group mb20' ); ?>>
													<?php
														$field_type = bp_xprofile_create_field_type( bp_get_the_profile_field_type() );
														$field_type->edit_field_html();
													?>
												</div>
											<?php endwhile; ?>
											<input type="hidden" name="signup_profile_field_ids" id="signup_profile_field_ids" value="<?php bp_the_profile_field_ids(); ?>" />
										<?php endwhile; endif; ?>
										<?php do_action( 'bp_signup_profile_fields' ); ?>
									</div><!-- #profile-details-section -->
									<?php do_action( 'bp_after_signup_profile_fields' ); ?>
								<?php endif; ?>
							<?php endif; ?>										
							<?php

							if($show_terms_conditions){ ?>
								<div class="re-form-group mb20">
									<div class="checkbox">
										<label><input name="rehub_terms" type="checkbox"> <?php echo sprintf( __( 'I accept the <a target="_blank" href="%s">Terms & Conditions</a>', 'rehub_framework' ), esc_url(get_the_permalink(rehub_option('userlogin_term_page'))) ) ?></label>
									</div>
								</div><?php
							}

							if (defined('wcv_plugin_dir')) { ?>
								<?php do_action( 'wcvendors_apply_for_vendor_before' ); ?>
								<div class="re-form-group vendor-form-group mb20">
									<div class="checkbox">
										<label><input name="wcv_apply_as_vendor" type="checkbox"> <?php _e('Apply as vendor?', 'rehub_framework'); ?></label>
									</div>
								</div>
								<?php do_action( 'wcvendors_apply_for_vendor_after' ); ?>
								<?php
							}

							 ?>

							<div class="re-form-group mb20">
								<input type="hidden" name="action" value="rehub_register_member_popup_function"/>
								<button class="wpsm-button rehub_main_btn" type="submit"><?php _e('Sign up', 'rehub_framework'); ?></button>
							</div>
							<?php wp_nonce_field( 'ajax-login-nonce', 'register-security' ); ?>
						</form>
						<div class="rehub-errors"></div>
						<div class="rehub-login-popup-footer"><?php _e('Already have an account?', 'rehub_framework'); ?> <span class="act-rehub-login-popup color_link" data-type="login"><?php _e('Login', 'rehub_framework'); ?></span></div>
					</div>
					</div>
				<?php endif;?>

				<!-- Login form -->
				<div id="rehub-login-popup">
			 	<div class="rehub-login-popup">
					<div class="re_title_inmodal"><?php _e('Login', 'rehub_framework'); ?></div>
					<form id="rehub_login_form_modal" action="<?php echo home_url( '/' ); ?>" method="post">
						<?php do_action( 'wordpress_social_login' ); ?>
						<div class="re-form-group mb20">
							<label><?php _e('Username', 'rehub_framework') ?></label>
							<input class="re-form-input required" name="rehub_user_login" type="text"/>
						</div>
						<div class="re-form-group mb20">
							<label for="rehub_user_pass"><?php _e('Password', 'rehub_framework')?></label>
							<input class="re-form-input required" name="rehub_user_pass" id="rehub_user_pass" type="password"/>
							<?php if(function_exists('um_get_core_page')) :?>
								<a href="<?php echo um_get_core_page('password-reset'); ?>" class="alignright"><?php _e('Lost Password?', 'rehub_framework'); ?></a>
							<?php else: ?>
								<span class="act-rehub-login-popup color_link alignright" data-type="resetpass"><?php _e('Lost Password?', 'rehub_framework');  ?></span>
							<?php endif;?>							
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
					<?php if (rehub_option('custom_register_link') !=''):?>
						<span class="act-rehub-login-popup color_link" data-type="url" data-customurl="<?php echo esc_html(rehub_option('custom_register_link'));?>"><?php _e('Sign Up', 'rehub_framework'); ?></span>						
					<?php else:?>
						<span class="act-rehub-login-popup color_link" data-type="register"><?php _e('Sign Up', 'rehub_framework'); ?></span>
					<?php endif;?>
					</div>
				</div>
				</div>

				<!-- Lost Password form -->
				<div id="rehub-reset-popup">
			 	<div class="rehub-reset-popup">
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
					<div class="rehub-login-popup-footer"><?php _e('Already have an account?', 'rehub_framework'); ?> <span class="act-rehub-login-popup color_link" data-type="login"><?php _e('Login', 'rehub_framework'); ?></span></div>
				</div>
				</div>
			</div>
			<?php

		}else{
			echo '<div id="rehub-restrict-login-popup"><div class="rehub-restrict-login-popup">'.__('Login/Register access is temporary disabled', 'rehub_framework').'</div></div>';
		} ?>

		<?php
	}else{
		if (rehub_option('custom_login_url') !=''){
			echo '<span id="rehub-custom-login-url" data-customloginurl="'.rehub_option('custom_login_url').'"></span>';			
		}
	}
}
add_action('wp_footer', 'rehub_login_register_modal');
}

# 	
# 	AJAX FUNCTION (HANDLE DATA FROM POPUP)
# 	========================================================================================	

// LOGIN
if( !function_exists('rehub_login_member_popup_function') ) {
function rehub_login_member_popup_function(){

	// Get variables
	$user_login		= sanitize_user($_POST['rehub_user_login']);	
	$user_pass		= sanitize_text_field($_POST['rehub_user_pass']);
	$remember 	= !empty($_POST['rehub_remember']) ? true : false;
	$redirect_to = rehub_option('custom_redirect_after_login');
	if($redirect_to){
		if ( stripos( $user_login, '@' ) !== false ) {
			$user = get_user_by('email', $user_login);
			if($user) {
				$user_login = $user->user_login;
			}
		}
		$redirect_to = str_replace('%%userlogin%%', $user_login, $redirect_to);
	}

	// Check CSRF token
	if( !check_ajax_referer( 'ajax-login-nonce', 'loginsecurity', false) ){
		echo json_encode(array('error' => true, 'message'=> '<div class="wpsm_box warning_type"><i></i>'.__('Session has expired, please reload the page and try again', 'rehub_framework').'</div>'));
	}
 	
 	// Check if input variables are empty
 	elseif(empty($user_login) or empty($user_pass)){
		echo json_encode(array('error' => true, 'message'=> '<div class="wpsm_box warning_type"><i></i>'.__('Please fill all form fields', 'rehub_framework').'</div>'));
 	}

 	else{
 		$secure_cookie = (!is_ssl()) ? false : '';
 		$user = wp_signon( array('user_login' => $user_login, 'user_password' => $user_pass, 'remember' => $remember ), $secure_cookie );
	    if(is_wp_error($user)){
			echo json_encode(array('error' => true, 'message'=> '<div class="wpsm_box warning_type"><i></i>'.$user->get_error_message().'</div>'));
		}
	    else{
	    	$redirect = apply_filters('rh_custom_redirect_for_login', $redirect_to, $user );
			echo json_encode(array('error' => false, 'message'=> '<div class="wpsm_box green_type">'.__('Login successful, reloading page...', 'rehub_framework').'</div>', 'redirecturl' => esc_url($redirect)));
		}
 	}
 	die();
}
add_action('wp_ajax_nopriv_rehub_login_member_popup_function', 'rehub_login_member_popup_function');
}

// REGISTER
if( !function_exists('rehub_register_member_popup_function') ) {
function rehub_register_member_popup_function(){

	// Get variables
	$user_login	= sanitize_user($_POST['rehub_user_login']);	
	$user_email	= sanitize_email($_POST['rehub_user_email']);
	$user_signonpassword = sanitize_text_field($_POST['rehub_user_signonpassword']);
	$user_confirmpassword	= sanitize_text_field($_POST['rehub_user_confirmpassword']);
	$wcv_apply_as_vendor = (!empty($_POST['wcv_apply_as_vendor'])) ? $_POST['wcv_apply_as_vendor'] : '';	
	$show_terms_conditions = rehub_option('userlogin_terms_enable');
	$redirect_to = rehub_option('custom_redirect_after_login');
	if($redirect_to){
		$redirect_to = str_replace('%%userlogin%%', $user_login, $redirect_to);
	}
	$bp_logic_popup = rehub_option('bp_deactivateemail_confirm');
	$usermeta = $user_error_req_fields = array();
	
	// Check CSRF token
	if( !check_ajax_referer( 'ajax-login-nonce', 'register-security', false) ){
		echo json_encode(array('error' => true, 'message'=> '<div class="wpsm_box warning_type">'.__('Session has expired, please reload the page and try again', 'rehub_framework').'</div>'));
		die();
	}
 	
 	// Check if input variables are empty
 	elseif(empty($user_login) or empty($user_email) or empty($user_signonpassword) or empty($user_confirmpassword)){
		echo json_encode(array('error' => true, 'message'=> '<div class="wpsm_box warning_type">'.__('Please fill all form fields', 'rehub_framework').'</div>'));
		die();
 	}

 	elseif($show_terms_conditions and !isset($_POST['rehub_terms'])){
		echo json_encode(array('error' => true, 'message'=> '<div class="wpsm_box warning_type">'.__('Please accept the terms and conditions before registering', 'rehub_framework').'</div>'));
		die();
 	}

 	elseif($user_signonpassword != $user_confirmpassword){
		echo json_encode(array('error' => true, 'message'=> '<div class="wpsm_box warning_type">'.__('Your passwords do not match. Set the same password in both fields', 'rehub_framework').'</div>'));
		die();
 	} 

 	elseif(mb_strlen($user_signonpassword) < 6){
		echo json_encode(array('error' => true, 'message'=> '<div class="wpsm_box warning_type">'.__('Your passwords must have minimum 6 symbols.', 'rehub_framework').'</div>'));
		die();
 	}  

	if (!empty($_POST['signup_profile_field_ids']) && rehub_option('userpopup_xprofile_hidename') !=1){
		$signup_profile_field_ids = explode(',', $_POST['signup_profile_field_ids']);
		foreach ((array)$signup_profile_field_ids as $field_id) {
			if ( ! isset( $_POST['field_' . $field_id] ) ) {
				if ( ! empty( $_POST['field_' . $field_id . '_day'] ) && ! empty( $_POST['field_' . $field_id . '_month'] ) && ! empty( $_POST['field_' . $field_id . '_year'] ) ) {
					// Concatenate the values.
					$date_value = $_POST['field_' . $field_id . '_day'] . ' ' . $_POST['field_' . $field_id . '_month'] . ' ' . $_POST['field_' . $field_id . '_year'];

					// Turn the concatenated value into a timestamp.
					$_POST['field_' . $field_id] = date( 'Y-m-d H:i:s', strtotime( $date_value ) );
					
				}
			}
			// Create errors for required fields without values.
			if ( xprofile_check_is_required_field( $field_id ) && empty( $_POST[ 'field_' . $field_id ] ) && ! bp_current_user_can( 'bp_moderate' ) ){
				$field_data = xprofile_get_field($field_id );
				if(is_object($field_data)){
					$user_error_req_fields[]= $field_data->name;
				}		
			}
		}
		if(!empty($user_error_req_fields)){
			echo json_encode(array('error' => true, 'message'=> '<div class="wpsm_box warning_type">'.__('Next fields are required: ', 'rehub_framework').implode(', ',$user_error_req_fields).'</div>'));
			die();				
		}
		$usermeta['profile_field_ids'] = $_POST['signup_profile_field_ids'];
	} 	

	if($bp_logic_popup == 'bp' && class_exists( 'BuddyPress' )){
		$usermeta['password'] = wp_hash_password( $_POST['signup_password'] );
		$usermeta = apply_filters( 'bp_signup_usermeta', $usermeta );
		$userid = bp_core_signup_user( $user_login, $user_signonpassword, $user_email, $usermeta );
	}	
	else{
		$userid = wp_create_user( $user_login, $user_signonpassword, $user_email );
	}

	if(is_wp_error($userid)){
		$registration_error_messages = $userid->errors;
		$display_errors = '<div class="wpsm_box warning_type">';
			foreach($registration_error_messages as $error){
				$display_errors .= '<p>'.$error[0].'</p>';
			}
		$display_errors .= '</div>';
		echo json_encode(array('error' => true, 'message' => $display_errors));
	}else{
		if (!empty($_POST['signup_profile_field_ids'])){
			$signup_profile_field_ids = explode(',', $_POST['signup_profile_field_ids']);
			foreach ((array)$signup_profile_field_ids as $field_id) {
				if ( ! isset( $_POST['field_' . $field_id] ) ) {
					if ( ! empty( $_POST['field_' . $field_id . '_day'] ) && ! empty( $_POST['field_' . $field_id . '_month'] ) && ! empty( $_POST['field_' . $field_id . '_year'] ) ) {
						// Concatenate the values.
						$date_value = $_POST['field_' . $field_id . '_day'] . ' ' . $_POST['field_' . $field_id . '_month'] . ' ' . $_POST['field_' . $field_id . '_year'];

						// Turn the concatenated value into a timestamp.
						$_POST['field_' . $field_id] = date( 'Y-m-d H:i:s', strtotime( $date_value ) );
						
					}
				}
				if(!empty($_POST['field_' . $field_id])){
					$field_val = $_POST['field_' . $field_id];
					xprofile_set_field_data($field_id, $userid, $field_val);
					$visibility_level = ! empty( $_POST['field_' . $field_id . '_visibility'] ) ? $_POST['field_' . $field_id . '_visibility'] : 'public';
					xprofile_set_field_visibility_level( $field_id, $userid, $visibility_level );
				}	
					
			}
		}	
		do_action('rh_before_wcv_register', $userid );	
		if ($wcv_apply_as_vendor){
			$secure_cookie = (!is_ssl()) ? false : '';
			$manual = WC_Vendors::$pv_options->get_option( 'manual_vendor_registration' );
			$role   = apply_filters( 'wcvendors_pending_role', ( $manual ? 'pending_vendor' : 'vendor' ) );	
			if (class_exists('WCVendors_Pro') ) {
				if ($role == 'pending_vendor'){
					$role = 'customer';
				}
			}		
			$user_id = wp_update_user( array( 'ID' => $userid, 'role' => $role ));
			do_action( 'wcvendors_application_submited', $userid );
		    if (class_exists('WCVendors_Pro') ) {
		        $redirect_to = get_permalink(WCVendors_Pro::get_option( 'dashboard_page_id' ));
		    }
		    else {
		    	$redirect_to = get_permalink(WC_Vendors::$pv_options->get_option( 'vendor_dashboard_page' ));
		    }
		    $errorshow = false;
			if ($role == 'vendor'){
				$status = 'approved';				
				$message = '<div class="wpsm_box green_type">'.__( 'Congratulations! You are now a vendor. Be sure to configure your store settings before adding products.', 'rehub_framework').'</div>';
				if($bp_logic_popup == 'bp' && class_exists( 'BuddyPress' )){
					$message .= '<div class="wpsm_box blue_type mt15">'.__( 'Before login this site you will need to activate your account via the email we have just sent to your address.', 'rehub_framework').'</div>';	
					$errorshow = true;	
				}				
			}
			elseif ($role == 'customer'){
				$status = 'customer';				
				$message = '<div class="wpsm_box green_type">'.__( 'Congratulations! Now you must add some settings before application', 'rehub_framework').'</div>';
				if($bp_logic_popup == 'bp' && class_exists( 'BuddyPress' )){
					$message .= '<div class="wpsm_box blue_type mt15">'.__( 'Before login this site you will need to activate your account via the email we have just sent to your address.', 'rehub_framework').'</div>';	
					$errorshow = true;	
				}				
			}			
			else{
                $status = 'pending';
				$message = '<div class="wpsm_box green_type">'.__( 'Your application has been received. You will be notified by email the results of your application. Currently you can use site as Pending vendor.', 'rehub_framework').'</div>';
				if($bp_logic_popup == 'bp' && class_exists( 'BuddyPress' )){
					$message .= '<div class="wpsm_box blue_type mt15">'.__( 'Before login this site you will need to activate your account via the email we have just sent to your address.', 'rehub_framework').'</div>';	
					$errorshow = true;	
				}				
			}
			if ($status != 'customer' && $status != ''){
				global $woocommerce;
	            $mails = $woocommerce->mailer()->get_emails();
	            if (!empty( $mails ) ) {
	                $mails[ 'WC_Email_Approve_Vendor' ]->trigger($userid, $status );
	            }
			}			
			wp_signon( array('user_login' => $user_login, 'user_password' => $user_signonpassword), $secure_cookie );
			$redirect = apply_filters('rh_custom_redirect_for_reg', $redirect_to, $userid );
			echo json_encode(array('error' => $errorshow, 'message' => $message, 'redirecturl' => $redirect));			
		}else{
			update_user_meta($userid, '_um_cool_but_hard_to_guess_plain_pw', $user_signonpassword);
			$secure_cookie = (!is_ssl()) ? false : '';
			do_action('rh_before_user_signon', $userid );
			wp_signon( array('user_login' => $user_login, 'user_password' => $user_signonpassword), $secure_cookie );
			$redirect = apply_filters('rh_custom_redirect_for_reg', $redirect_to, $userid );
			if($bp_logic_popup == 'bp' && class_exists( 'BuddyPress' )){
				echo json_encode(array('error' => true, 'message' => '<div class="wpsm_box green_type">'.__( 'You have successfully created your account! To begin using this site you will need to activate your account via the email we have just sent to your address.', 'rehub_framework' ).'</div>', 'redirecturl' => $redirect));
			}else{
				echo json_encode(array('error' => false, 'message' => '<div class="wpsm_box green_type">'.__( 'Registration complete. Now you can use your account. Reloading page...', 'rehub_framework').'</div>', 'redirecturl' => $redirect));
			}			
		}

	}
 	die();
}
add_action('wp_ajax_nopriv_rehub_register_member_popup_function', 'rehub_register_member_popup_function');
}


// RESET PASSWORD
if( !function_exists('rehub_reset_password_popup_function') ) {
function rehub_reset_password_popup_function(){
	// Get variables
	$username_or_email = $_POST['rehub_user_or_email'];

	// Check CSRF token
	if( !check_ajax_referer( 'ajax-login-nonce', 'password-security', false) ){
		echo json_encode(array('error' => true, 'message'=> '<div class="wpsm_box warning_type">'.__('Session has expired, please reload the page and try again', 'rehub_framework').'</div>'));
	}		

 	// Check if input variables are empty
 	elseif(empty($username_or_email)){
		echo json_encode(array('error' => true, 'message'=> '<div class="wpsm_box warning_type">'.__('Please fill all form fields', 'rehub_framework').'</div>'));
 	}

 	else{
		$username = is_email($username_or_email) ? sanitize_email($username_or_email) : sanitize_user($username_or_email);
		$user_forgotten = rehub_lostPassword_retrieve($username);	
		if(is_wp_error($user_forgotten)){	
			$lostpass_error_messages = $user_forgotten->errors;
			$display_errors = '<div class="wpsm_box warning_type">';
			foreach($lostpass_error_messages as $error){
				$display_errors .= '<p>'.$error[0].'</p>';
			}
			$display_errors .= '</div>';		
			echo json_encode(array('error' => true, 'message' => $display_errors));
		}else{
			echo json_encode(array('error' => false, 'message' => '<div class="wpsm_box green_type">'.__('Password was reset. Please check your email. Reloading page...', 'rehub_framework').'</div>'));
		}
 	}
 	die();
}	
add_action('wp_ajax_nopriv_rehub_reset_password_popup_function', 'rehub_reset_password_popup_function');
}

function rehub_lostPassword_retrieve( $user_data ) {
	
	global $wpdb, $current_site, $wp_hasher;
	$errors = new WP_Error();

	if(empty($user_data)){
		$errors->add( 'empty_username', __( 'Please enter a username or e-mail address.', 'rehub_framework' ) );
	}elseif(strpos($user_data, '@')){
		$user_data = get_user_by( 'email', trim( $user_data ) );
		if(empty($user_data)){
			$errors->add( 'invalid_email', __( 'There is no user registered with that email address.', 'rehub_framework'  ) );
		}
	}else{
		$login = trim( $user_data );
		$user_data = get_user_by('login', $login);
	}
	if($errors->get_error_code()){
		return $errors;
	}
	if(!$user_data){
		$errors->add('invalidcombo', __('Invalid username or e-mail.', 'rehub_framework'));
		return $errors;
	}
	$user_login = $user_data->user_login;
	$user_email = $user_data->user_email;
	do_action('retrieve_password', $user_login);
	$allow = apply_filters('allow_password_reset', true, $user_data->ID);
	if(!$allow){
		return new WP_Error( 'no_password_reset', __( 'Password reset is not allowed for this user', 'rehub_framework' ) );
	}
	elseif(is_wp_error($allow)){
		return $allow;
	}
	$key = wp_generate_password(20, false);
	do_action('retrieve_password_key', $user_login, $key);
	if(empty($wp_hasher)){
		require_once ABSPATH.'wp-includes/class-phpass.php';
		$wp_hasher = new PasswordHash(8, true);
	}
	$hashed = $wp_hasher->HashPassword($key);
	$wpdb->update($wpdb->users, array('user_activation_key' => $hashed), array('user_login' => $user_login));
	$message = __('Someone requested password reset for the following account:', 'rehub_framework' ) . "\r\n\r\n";
	$message .= network_home_url( '/' ) . "\r\n\r\n";
	$message .= sprintf( __( 'Username: %s', 'rehub_framework' ), $user_login ) . "\r\n\r\n";
	$message .= __('If this was a mistake, just ignore this email and nothing will happen.', 'rehub_framework' ) . "\r\n\r\n";
	$message .= __('To reset your password, visit the following address:', 'rehub_framework' ) . "\r\n\r\n";
	$message .= '<' . network_site_url( "wp-login.php?action=rp&key=$key&login=" . rawurlencode( $user_login ), 'login' ) . ">\r\n\r\n";
	
	if ( is_multisite() ) {
		$blogname = esc_html( get_site_option( 'site_name' ) );
	} else {
		$blogname = esc_html( get_site_option( 'blogname' ) );
	}
	$from_name = $blogname == '' ? 'WordPress' : $blogname;
	$title   = sprintf( __( '[%s] Password Reset', 'rehub_framework' ), $from_name );
	$title   = apply_filters( 'retrieve_password_title', $title );
	$message = apply_filters( 'retrieve_password_message', $message, $key, $user_login, $user_data );
	
	$admin_email = get_site_option( 'admin_email' );
	if ( $admin_email == '' )
		$admin_email = 'support@' . $_SERVER['SERVER_NAME'];
	$message_headers = "From: \"{$from_name}\" <{$admin_email}>\n" . "Content-Type: text/plain; charset=\"" . get_option('blog_charset') . "\"\n";
	
	if ( $message && ! wp_mail( $user_email, wp_specialchars_decode( $title ), $message, $message_headers ) ) {
		$errors->add( 'noemail', __( 'The e-mail could not be sent.<br />Possible reason: your host may have disabled the mail() function.', 'rehub_framework' ) );
		return $errors;
		wp_die();
	}
	return true;
}	