<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php

/* 
 * Default size of avatar
 */
define ( 'BP_AVATAR_THUMB_WIDTH', 55 );
define ( 'BP_AVATAR_THUMB_HEIGHT', 55 );
define ( 'BP_AVATAR_FULL_WIDTH', 300 );
define ( 'BP_AVATAR_FULL_HEIGHT', 300 );
 
/*
 * BP callback for the cover image feature.
 */
 if( ! function_exists( 'rh_cover_image_callback' ) ) :
	function rh_cover_image_callback( $params = array() ) {
		if ( empty( $params ) ) {
			return;
		}

		if(!empty($params['cover_image'])){
			$cover_image = 'background-image:url(' . $params['cover_image'] . ');';
		}
		elseif(rehub_option('rehub_bpheader_image') !=''){
			$cover_image = 'background-image:url(' . esc_url(rehub_option('rehub_bpheader_image')) . ');';
		}
		else{
			$cover_image = 'background-image: url("'.get_template_directory_uri() . '/images/swirl_pattern.png"); background-repeat:  repeat;background-size: inherit;';
		}
		return '
			/* Cover image */
			#rh-header-cover-image {'. $cover_image .'}';
	}
endif;

/* Call BP cover-image styles in head */
if( ! function_exists( 'rh_cover_image_css' ) ) :
	function rh_cover_image_css( $settings = array() ) {

		// If you are using a child theme, use bp-child-css as the theme handel

		$theme_handle = (is_rtl()) ? 'bp-parent-css-rtl' : 'bp-parent-css';
 		$settings['width']  = 1400;
        $settings['height'] = 260;	 
		$settings['theme_handle'] = $theme_handle;
		$settings['callback'] = 'rh_cover_image_callback';
	 
		return $settings;
	}
	add_filter( 'bp_before_xprofile_cover_image_settings_parse_args', 'rh_cover_image_css', 10, 1 );
	add_filter( 'bp_before_groups_cover_image_settings_parse_args', 'rh_cover_image_css', 10, 1 );
endif;


/* Custom Tabs for User`s Profile */
if( ! function_exists( 'rh_content_setup_nav_profile' ) ) :
	function rh_content_setup_nav_profile() {
		if(rehub_option('rh_bp_user_post_name') !=''){
			global $bp;
			$userid = (!empty($bp->displayed_user->id)) ? $bp->displayed_user->id : '';
			if($userid){
				$totalposts = count_user_posts( $userid, $post_type = 'post' );	
				$class    = ( 0 === $totalposts ) ? 'no-count' : 'count';
			}	
			else {
				$class = 'hiddencount';
				$totalposts = '';
			}
			$post_name = rehub_option('rh_bp_user_post_name');
			$post_slug = rehub_option('rh_bp_user_post_slug');
			$post_position = rehub_option('rh_bp_user_post_pos');
			$addnewpage = rehub_option('rh_bp_user_post_newpage');
			$editpage = rehub_option('rh_bp_user_post_editpage');
			$member_type = rehub_option('rh_bp_user_post_type');						

			$post_slug = ($post_slug) ? trim($post_slug) : 'posts';
			$post_position = ($post_position) ? trim((int)$post_position) : 40 ;
			$member_type = ($member_type) ? trim($member_type) : '';
			
			$cssid = 'posts';
			if($member_type){
				$cssid = 'hiddenposts';
				$usertype = bp_get_member_type($userid, false);
				if(!empty($usertype) && is_array($usertype)){
					$member_type = explode(',', $member_type);
					foreach ($member_type as $type) {
						$type = trim($type);
						if (in_array($type, $usertype)){
							$cssid = 'posts';
							break;
						}
					}
				}
			}

			$post_text = $post_name .'<span class="'.$class.'">'.$totalposts.'</span>'; 

			bp_core_new_nav_item( array(
				'name' => $post_text,
				'slug' => $post_slug,
				'screen_function' => 'articles_screen_link',
				'position' => $post_position,
				'default_subnav_slug' => $post_slug,
				'item_css_id' => $cssid,
			) );
			if($addnewpage){
				bp_core_new_subnav_item( array(
					'name' => __('Add new', 'rehub_framework'),
					'slug' => 'addnew',
					'parent_url' => untrailingslashit($bp->displayed_user->domain) . '/'. $post_slug.'/',
					'parent_slug' => $post_slug,
					'screen_function' => 'articles_screen_link_addnew',
					'position' => 20,
					'user_has_access' => bp_is_my_profile(),
				) );				
			}
			if($editpage){
				bp_core_new_subnav_item( array(
					'name' => __('Edit', 'rehub_framework'),
					'slug' => 'editposts',
					'parent_url' => untrailingslashit($bp->displayed_user->domain) . '/'. $post_slug.'/',
					'parent_slug' => $post_slug,
					'screen_function' => 'articles_screen_link_edit',
					'position' => 30,
					'user_has_access' => bp_is_my_profile(),
				) );				
			}						
		}	
		if(rehub_option('rh_bp_user_product_name') !=''){
			global $bp;
			$userid = (!empty($bp->displayed_user->id)) ? $bp->displayed_user->id : '';
			if($userid){
				$totalposts = count_user_posts( $userid, $post_type = 'product' );	
				$class    = ( 0 === $totalposts ) ? 'no-count' : 'count';
			}	
			else {
				$class = 'hiddencount';
				$totalposts = '';
			}			
			$post_name = rehub_option('rh_bp_user_product_name');
			$post_slug = rehub_option('rh_bp_user_product_slug');
			$post_position = rehub_option('rh_bp_user_product_pos');
			$addnewpage = rehub_option('rh_bp_user_product_newpage');
			$editpage = rehub_option('rh_bp_user_product_editpage');
			$member_type = rehub_option('rh_bp_user_product_type');						

			$post_slug = ($post_slug) ? trim($post_slug) : 'offers';
			$post_position = ($post_position) ? trim((int)$post_position) : 41 ;
			$member_type = ($member_type) ? trim($member_type) : '';

			$cssid = 'products';	
			if($member_type){
				$cssid = 'hiddenproducts';
				$usertype = bp_get_member_type($userid, false);
				if(!empty($usertype) && is_array($usertype)){
					$member_type = explode(',', $member_type);
					foreach ($member_type as $type) {
						$type = trim($type);
						if (in_array($type, $usertype)){
							$cssid = 'products';
							break;
						}
					}
				}
			}			

			$post_text = $post_name .'<span class="'.$class.'">'.$totalposts.'</span>';

			bp_core_new_nav_item( array(
				'name' => $post_text,
				'slug' => $post_slug,
				'screen_function' => 'deals_screen_link',
				'position' => $post_position,
				'default_subnav_slug' => $post_slug,
				'item_css_id' => $cssid,
			) );
			if($addnewpage){
				bp_core_new_subnav_item( array(
					'name' => __('Add new', 'rehub_framework'),
					'slug' => 'addnew',
					'parent_url' => untrailingslashit($bp->displayed_user->domain) . '/'. $post_slug.'/',
					'parent_slug' => $post_slug,
					'screen_function' => 'deals_screen_link_addnew',
					'position' => 20,
					'user_has_access' => bp_is_my_profile(),
				) );				
			}
			if($editpage){
				bp_core_new_subnav_item( array(
					'name' => __('Edit', 'rehub_framework'),
					'slug' => 'editproducts',
					'parent_url' => untrailingslashit($bp->displayed_user->domain) . '/'. $post_slug.'/',
					'parent_slug' => $post_slug,
					'screen_function' => 'deals_screen_link_edit',
					'position' => 30,
					'user_has_access' => bp_is_my_profile(),
				) );				
			}
		}		

	do_action( 'rh_content_setup_nav_profile' );
	}
	add_action( 'bp_setup_nav', 'rh_content_setup_nav_profile' );
endif;

if(!function_exists('articles_screen_link')){
function articles_screen_link() {
	
	function articles_screen_content() {
		$displayeduser = bp_displayed_user_id();
		?>
		<div id="posts-list" class="bp-post-wrapper posts">

			<?php 
				$containerid = 'rh_dealgrid_' . uniqid();   
				$col_wrap = 'col_wrap_fourth';
				$columns = '4_col';
				$additional_vars = array();
				$additional_vars['columns'] = $columns;
				$infinitescrollwrap = ' re_aj_pag_clk_wrap';    
				$show = $ajaxoffset = 12;	
				$args = array(
					'post_type' => 'post',
					'posts_per_page' => 12,
					'author' => $displayeduser,
					);
			    $loop = new WP_Query($args);
			?>
			<?php if ( $loop->have_posts() ) : ?>
				<?php 
					$jsonargs = json_encode($args);
					$json_innerargs = json_encode($additional_vars);
				?> 	
				<div class="eq_grid post_eq_grid rh-flex-eq-height <?php echo $col_wrap; echo $infinitescrollwrap;?>" data-filterargs='<?php echo $jsonargs;?>' data-template="compact_grid" id="<?php echo $containerid;?>" data-innerargs='<?php echo $json_innerargs;?>'>

					<?php while ( $loop->have_posts() ) : $loop->the_post();  ?>
						<?php include(rh_locate_template('inc/parts/compact_grid.php')); ?>
					<?php endwhile; ?>

					<div class="re_ajax_pagination"><span data-offset="<?php echo $ajaxoffset;?>" data-containerid="<?php echo $containerid;?>" class="re_ajax_pagination_btn def_btn"><?php _e('Show next', 'rehub_framework') ?></span></div>      

				</div>
				<div class="clearfix"></div>
			<?php endif; wp_reset_query(); ?>

		</div><!--/.posts-->
	<?php
	} 
	
    add_action( 'bp_template_content', 'articles_screen_content' );
    bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
}
}

if(!function_exists('articles_screen_link_addnew')){
function articles_screen_link_addnew() {
	function articles_screen_link_addnew_content() {
		$get_pageid = rehub_option('rh_bp_user_post_newpage');
		if($get_pageid){
			$get_page = get_post((int)$get_pageid);
			$content = $get_page->post_content;
			$content = apply_filters('the_content', $content);
			echo '<div class="post">'.$content.'</div>';
		}
	} 
	
    add_action( 'bp_template_content', 'articles_screen_link_addnew_content' );	
    bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
}
}

if(!function_exists('articles_screen_link_edit')){
function articles_screen_link_edit() {
	function articles_screen_link_edit_content() {
		$get_pageid = rehub_option('rh_bp_user_post_editpage');
		if($get_pageid){
			$get_page = get_post((int)$get_pageid);
			$content = $get_page->post_content;
			$content = apply_filters('the_content', $content);
			echo '<div class="post">'.$content.'</div>';
		}
	} 
	
    add_action( 'bp_template_content', 'articles_screen_link_edit_content' );	
    bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
}
}

if(!function_exists('deals_screen_link')){
function deals_screen_link() {
	function deals_screen_content() {
		if ( class_exists( 'Woocommerce' ) ) {
			$displayeduser = bp_displayed_user_id();			
		?>	
		<div id="posts-list" class="bp-post-wrapper products">

			<?php 
				$containerid = 'rh_woocolumn_' . uniqid();  
				$infinitescrollwrap = ' re_aj_pag_clk_wrap';    
				$show = $ajaxoffset = 12;	
				$columns = '3_col';
				$additional_vars = array();
				$additional_vars['columns'] = $columns;
				$args = array(
					'post_type' => 'product',
					'posts_per_page' => 12,
					'author' => $displayeduser,
					);
			    $loop = new WP_Query($args);
			?>
			<?php if ( $loop->have_posts() ) : ?>
				<?php 
					$jsonargs = json_encode($args);
					$json_innerargs = json_encode($additional_vars);
				?> 
				<div class="woocommerce">
				<div class="rh-flex-eq-height column_woo products col_wrap_fourth <?php  echo $infinitescrollwrap;?>" data-filterargs='<?php echo $jsonargs;?>' data-template="woocolumnpart" data-innerargs='<?php echo $json_innerargs;?>' id="<?php echo $containerid;?>">

					<?php while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
						<?php include(rh_locate_template('inc/parts/woocolumnpart.php')); ?>
					<?php endwhile; ?>

					<div class="re_ajax_pagination"><span data-offset="<?php echo $ajaxoffset;?>" data-containerid="<?php echo $containerid;?>" class="re_ajax_pagination_btn def_btn"><?php _e('Show next', 'rehub_framework') ?></span></div>      

				</div>
				</div>
				<div class="clearfix"></div>
			<?php endif; wp_reset_query(); ?>

		</div><!--/.posts-->
		<?php
		}
	} 	
    add_action( 'bp_template_content', 'deals_screen_content' );	
    bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
}
}

if(!function_exists('deals_screen_link_addnew')){
function deals_screen_link_addnew() {
	function deals_screen_link_addnew_content() {
		$get_pageid = rehub_option('rh_bp_user_product_newpage');
		if($get_pageid){
			$get_page = get_post($get_pageid);
			$content = $get_page->post_content;
			$content = apply_filters('the_content', $content);
			echo '<div class="post">'.$content.'</div>';
		}
	} 	
    add_action( 'bp_template_content', 'deals_screen_link_addnew_content' );	
    bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
}
}

if(!function_exists('deals_screen_link_edit')){
function deals_screen_link_edit() {
	function deals_screen_link_edit_content() {
		$get_pageid = rehub_option('rh_bp_user_product_editpage');
		if($get_pageid){
			$get_page = get_post($get_pageid);
			$content = $get_page->post_content;
			$content = apply_filters('the_content', $content);
			echo '<div class="post">'.$content.'</div>';
		}
	} 
	
    add_action( 'bp_template_content', 'deals_screen_link_edit_content' );	
    bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
}
}

/**
Example of Group Extension API
if ( bp_is_active( 'groups' ) && rehub_option('rehub_bp_group_products') !='') :
class Group_Extension_Offers extends BP_Group_Extension {

    function __construct() {
        $args = array(
            'slug' => 'products',
            'name' => 'products',
            'nav_item_position' => 105,
            'nav_item_name' => rehub_option('rehub_bp_group_products'),
        );
        parent::init( $args );
    }
 
    function display( $group_id = NULL ) {
        $creator = bp_get_group_creator_id();
        $totaldeals = count_user_posts( $creator, $post_type = 'product' );
        if($totaldeals > 0){
        	include(rh_locate_template('buddypress/groups/single/offers.php'));
        }
    }
}
bp_register_group_extension( 'Group_Extension_Offers' );
endif;
**/

/* Get the Resized Cover Image URL otherwise Background styled URL */
if( ! function_exists( 'rh_cover_image_url' ) ) :
	function rh_cover_image_url( $object_dir, $height, $background = false ) {

		if( $object_dir == 'members' ) {
			$item_id = bp_get_member_user_id(); 
		} elseif( $object_dir == 'groups' ) {
			$item_id = bp_get_group_id();
		} else {
			$item_id = 0;
		}
		
		$get_cover_image_url = bp_attachments_get_attachment('url', array(
			'object_dir' => $object_dir,
			'item_id' => $item_id
		) );
		if(!empty($get_cover_image_url)){
		}
		elseif(rehub_option('rehub_bpheader_image') !=''){
			$get_cover_image_url = esc_url(rehub_option('rehub_bpheader_image'));
		}	
		$resized_cover_image_url = '';
		
		if( $get_cover_image_url ) {
			
 		$resized_cover_image = new WPSM_image_resizer();
		$resized_cover_image->src = $get_cover_image_url;
        $resized_cover_image->height = $height;

		$resized_cover_image_url = $resized_cover_image->get_resized_url(); 
		}
		
		if( $background && $resized_cover_image_url ) {
			$cover_image_inline_style = 'background-image:url('. $resized_cover_image_url .')';
			echo $cover_image_inline_style;
		} else {
			echo $resized_cover_image_url;
		}
	}
endif;


if( ! function_exists( 'rh_nologedin_add_buttons' ) ) :
	function rh_nologedin_add_buttons() {
		if( ! is_user_logged_in() && rehub_option('userlogin_enable') == '1') {
		?>
			<?php if(bp_is_active( 'friends' )) :?>
			<div class="generic-button">
				<a href="#" title="Add Friend" rel="add" class="act-rehub-login-popup friendship-button"><?php _e( 'Add Friend', 'rehub_framework' ); ?></a>
			</div>
			<?php endif;?>
			<?php if(bp_is_active( 'messages' )) :?>
			<div class="generic-button">
				<a href="#" title="Send a private message to this user." class="act-rehub-login-popup send-message"><?php echo __( 'Private Message', 'buddypress' ); ?></a>
			</div>
			<?php endif;?>
		<?php
		}
	}
	add_action( 'bp_member_header_actions', 'rh_nologedin_add_buttons', 10, 0 );
endif;

if( ! function_exists( 'rh_nologedin_add_buttons_group' ) ) :
	function rh_nologedin_add_buttons_group() {
		if( ! is_user_logged_in() && rehub_option('userlogin_enable') == '1') {
		?>
			<div class="generic-button">
				<a href="#" title="Join Group" rel="add" class="act-rehub-login-popup"><?php echo __( 'Join Group', 'rehub_framework' ); ?></a>
			</div>
		<?php
		}
	}
	add_action( 'bp_group_header_actions', 'rh_nologedin_add_buttons_group', 10, 0 );
endif;

if (rehub_option('bp_deactivateemail_confirm') != 'bp'){
	add_filter( 'bp_registration_needs_activation', '__return_false' );	
}

add_post_type_support( 'product', 'buddypress-activity' );
function rh_customize_product_tracking_args() {
    // Check if the Activity component is active before using it.
    if ( ! bp_is_active( 'activity' ) ) {
        return;
    }
 
    bp_activity_set_post_type_tracking_args( 'product', array(
        
        'action_id'                => 'new_product',
        'bp_activity_admin_filter' => __( 'Published a new product', 'rehub_framework' ),
        'bp_activity_front_filter' => __( 'Products', 'rehub_framework' ),
        'contexts'                 => array( 'activity', 'member' ),
        'activity_comment'         => true,
        'bp_activity_new_post'     => __( '%1$s posted a new <a href="%2$s">product</a>', 'rehub_framework' ),
        'bp_activity_new_post_ms'  => __( '%1$s posted a new <a href="%2$s">product</a>, on the site %3$s', 'rehub_framework' ),
        'position'                 => 100,
    ) );
}
add_action( 'bp_init', 'rh_customize_product_tracking_args' );

add_filter('bp_get_messages_content_value', 'rh_custom_message_placeholder_in_bp_message' );
function rh_custom_message_placeholder_in_bp_message(){
	if(!empty($_GET['ref'])){
		$content = __('I am interested in: ', 'rehub_framework').urldecode($_GET['ref']);
		$content = esc_html($content);
	}
	elseif(!empty( $_POST['content'] )){
		$content = $_POST['content'];
	}
	else{
		$content = '';
	}
	return $content;	
}

if (rehub_option('rh_bp_custom_message_profile') !=''){
	function rh_bp_custom_message_profile(){
		echo do_shortcode(rehub_option('rh_bp_custom_message_profile'));
		echo '<div class="mb30 clearfix"></div>';
	}
	add_action('bp_before_profile_loop_content', 'rh_bp_custom_message_profile' );
}

if (rehub_option('rh_bp_custom_register_vendor') == 1 && defined('wcv_plugin_dir')){

	function rh_bp_custom_register_fields_action($user_id) {
		$wcv_apply_as_vendor = (!empty($_POST['wcv_apply_as_vendor'])) ? $_POST['wcv_apply_as_vendor'] : '';
		if ($wcv_apply_as_vendor){
			$manual = WC_Vendors::$pv_options->get_option( 'manual_vendor_registration' );
			$role   = apply_filters( 'wcvendors_pending_role', ( $manual ? 'pending_vendor' : 'vendor' ) );	
			if (class_exists('WCVendors_Pro') ) {
				if ($role == 'pending_vendor'){
					$role = 'customer';
				}
			}			
			add_user_meta( $user_id, '_rh_wc_bp_vendor_register', $role);				
		}
	}

	function rh_bp_custom_register_fields_action_on_approve($user_id, $key, $user){	
		$role = get_user_meta( $user_id, '_rh_wc_bp_vendor_register', true);
		if($role){
			wp_update_user( array( 'ID' => $user_id, 'role' => $role ));
			if ($role == 'vendor'){
				$status = 'approved';							
			}
			elseif ($role == 'customer'){
				$status = 'customer';							
			}			
			else{
		        $status = 'pending';			
			}
			if ($status != 'customer' && $status != ''){
				global $woocommerce;
		        $mails = $woocommerce->mailer()->get_emails();
		        if (!empty( $mails ) ) {
		            $mails[ 'WC_Email_Approve_Vendor' ]->trigger($user_id, $status );
		        }
			}
		}
	}

	function rh_bp_custom_register_fields(){
		?>
		<?php do_action( 'wcvendors_apply_for_vendor_before' ); ?>
		<fieldset class="checkbox">
			<legend><?php _e('Apply as vendor?', 'rehub_framework'); ?></legend>
			<div class="input-options checkbox-options">
				<input name="wcv_apply_as_vendor" type="checkbox">
			</div>
		</fieldset>
		<?php do_action( 'wcvendors_apply_for_vendor_after' ); ?>
		<?php
	}

	add_action( 'bp_core_signup_user', 'rh_bp_custom_register_fields_action', 20, 1);
	add_action('bp_core_activated_user', 'rh_bp_custom_register_fields_action_on_approve',10 , 3);
	add_action('bp_signup_profile_fields', 'rh_bp_custom_register_fields' );
}

function rh_bp_custom_register_membertype(){
	?>
		<?php $membertype = (!empty($_GET['membertype'])) ? esc_html($_GET['membertype']) : '';?>
		<?php if ($membertype):?>
			<input name="activate_membertype_on_reg" type="hidden" value="<?php echo $membertype;?>">
		<?php endif;?>
	<?php
}
function rh_bp_custom_register_membertype_action($user_id){
	$activate_membertype_on_reg = (!empty($_POST['activate_membertype_on_reg'])) ? esc_html($_POST['activate_membertype_on_reg']) : '';
	if($activate_membertype_on_reg){
		$all_membertypes = bp_get_member_types( array(), 'names' );
		if(is_array($all_membertypes) and array_key_exists($activate_membertype_on_reg, $all_membertypes)){
			add_user_meta( $user_id, '_rh_activate_membertype_on_reg', $activate_membertype_on_reg);
		}
	}

}
function rh_bp_custom_register_membertype_on_approve($user_id, $key, $user){	
	$membertype = get_user_meta( $user_id, '_rh_activate_membertype_on_reg', true);
	if($membertype){
		bp_set_member_type($user_id, $membertype, true );
	}
}
add_action('bp_signup_profile_fields', 'rh_bp_custom_register_membertype' );
add_action('bp_core_activated_user', 'rh_bp_custom_register_membertype_on_approve',10 , 3);
add_action( 'bp_core_signup_user', 'rh_bp_custom_register_membertype_action', 20, 1);