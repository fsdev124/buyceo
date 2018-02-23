<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php

// commentplus scripts
function commentplus_re_scripts() {
	wp_enqueue_script( 'commentplus_re', get_template_directory_uri().'/js/commentplus_re.js', array('jquery'), '1.0', 1 );
	wp_localize_script( 'commentplus_re', 'cplus_var', array(
			'url' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('commre-nonce'),
		)
	);
}
add_action('wp_enqueue_scripts','commentplus_re_scripts', 11);

add_action( 'wp_ajax_nopriv_commentplus', 'commentplus_re' );
add_action( 'wp_ajax_commentplus', 'commentplus_re' );

function commentplus_re() {
	$nonce = $_POST['cplusnonce'];
    if ( ! wp_verify_nonce( $nonce, 'commre-nonce' ) )
        die ( 'Nope!' );
	
	if ( isset( $_POST['comm_help'] ) ) {	
		$post_id = $_POST['post_id']; // post id
		$comm_plus = get_comment_meta( $post_id, "recomm_plus", true ); // get helpful comment count
		$comm_minus = get_comment_meta( $post_id, "recomm_minus", true ); // get unhelpful comment count				
		if ( is_user_logged_in() ) { // user is logged in
			global $current_user;
			$user_id = $current_user->ID; // current user
			$meta_POSTS = get_user_meta( $user_id, "_comm_help_posts" ); // post ids from user meta
			$meta_USERS = get_comment_meta( $post_id, "_user_comm_help" ); // user ids from post meta
			$liked_POSTS = ""; // setup array variable
			$liked_USERS = ""; // setup array variable			
			if ( count( $meta_POSTS ) != 0 ) { // meta exists, set up values
				$liked_POSTS = $meta_POSTS[0];
			}			
			if ( !is_array( $liked_POSTS ) ) // make array just in case
				$liked_POSTS = array();				
			if ( count( $meta_USERS ) != 0 ) { // meta exists, set up values
				$liked_USERS = $meta_USERS[0];
			}		
			if ( !is_array( $liked_USERS ) ) // make array just in case
				$liked_USERS = array();				
			$liked_POSTS['post-'.$post_id] = $post_id; // Add post id to user meta array
			$liked_USERS['user-'.$user_id] = $user_id; // add user id to post meta array
			$user_likes = count( $liked_POSTS ); // count user likes

			if ($_POST['comm_help'] =='plus') {				
				if ( !AlreadyCommentplus( $post_id ) ) {
					update_comment_meta( $post_id, "recomm_plus", ++$comm_plus ); // +1 count to helpful
					update_comment_meta( $post_id, "_user_comm_help", $liked_USERS ); // Add user ID to post meta
					update_user_meta( $user_id, "_comm_help_posts", $liked_POSTS ); // Add post ID to user meta
					update_user_meta( $user_id, "_comm_help_count", $user_likes ); // +1 count user meta					
				} 		
			}
			if ($_POST['comm_help'] =='minus') {
				if ( !AlreadyCommentplus( $post_id ) ) {
					update_comment_meta( $post_id, "recomm_minus", ++$comm_minus ); // +1 count to unhelpful
					update_comment_meta( $post_id, "_user_comm_help", $liked_USERS ); // Add user ID to post meta
					update_user_meta( $user_id, "_comm_help_posts", $liked_POSTS ); // Add post ID to user meta
					update_user_meta( $user_id, "_comm_help_count", $user_likes ); // +1 count user meta					
				} 									
			}			
			
		} else { // user is not logged in (anonymous)
			$ip = $_SERVER['REMOTE_ADDR']; // user IP address
			$meta_IPS = get_comment_meta( $post_id, "_user_IP_comm_help" ); // stored IP addresses
			$liked_IPS = ""; // set up array variable			
			if ( count( $meta_IPS ) != 0 ) { // meta exists, set up values
				$liked_IPS = $meta_IPS[0];
			}	
			if ( !is_array( $liked_IPS ) ) // make array just in case
				$liked_IPS = array();				
			if ( !in_array( $ip, $liked_IPS ) ) // if IP not in array
				$liked_IPS['ip-'.$ip] = $ip; // add IP to array	

			if ($_POST['comm_help'] =='plus') {				
				if ( !AlreadyCommentplus( $post_id ) ) {
					update_comment_meta( $post_id, "recomm_plus", ++$comm_plus ); // +1 count post meta
					update_comment_meta( $post_id, "_user_IP_comm_help", $liked_IPS ); // Add user IP to post meta					
				} 		
			}
			if ($_POST['comm_help'] =='minus') {
				if ( !AlreadyCommentplus( $post_id ) ) {
					update_comment_meta( $post_id, "recomm_minus", ++$comm_minus ); // +1 count to unhelpful
					update_comment_meta( $post_id, "_user_IP_comm_help", $liked_IPS ); // Add user IP to post meta					
				} 										
			}
		}
	}
	exit;
}

function AlreadyCommentplus( $post_id ) { // test if user liked before
	
	if ( is_user_logged_in() ) { // user is logged in
		global $current_user;
		$user_id = $current_user->ID; // current user
		$meta_USERS = get_comment_meta( $post_id, "_user_comm_help" ); // user ids from post meta
		$liked_USERS = ""; // set up array variable		
		if ( count( $meta_USERS ) != 0 ) { // meta exists, set up values
			$liked_USERS = $meta_USERS[0];
		}		
		if( !is_array( $liked_USERS ) ) // make array just in case
			$liked_USERS = array();			
		if ( in_array( $user_id, $liked_USERS ) ) { // True if User ID in array
			return true;
		}
		return false;		
	} 
	else { // user is anonymous, use IP address for voting	
		$meta_IPS = get_comment_meta($post_id, "_user_IP_comm_help"); // get previously voted IP address
		$ip = $_SERVER["REMOTE_ADDR"]; // Retrieve current user IP
		$liked_IPS = ""; // set up array variable
		if ( count( $meta_IPS ) != 0 ) { // meta exists, set up values
			$liked_IPS = $meta_IPS[0];
		}
		if ( !is_array( $liked_IPS ) ) // make array just in case
			$liked_IPS = array();
		if ( in_array( $ip, $liked_IPS ) ) { // True is IP in array
			return true;
		}
		return false;
	}	
}

function getCommentLike_re( $comment_text  ) {
	$post_id = get_comment_ID();	
	$comm_plus = get_comment_meta( $post_id, "recomm_plus", true ); // get helpful comment count
	$comm_minus = get_comment_meta( $post_id, "recomm_minus", true ); // get unhelpful comment count	
	if ( ( !$comm_plus ) || ( $comm_plus && $comm_plus == "0" ) ) { // no votes, set up empty variable
		$comm_plus_count = '0';
	} elseif ( $comm_plus && $comm_plus != "0" ) { // there are votes!
		$comm_plus_count = esc_attr( $comm_plus );
	}
	if ( ( !$comm_minus ) || ( $comm_minus && $comm_minus == "0" ) ) { // no votes, set up empty variable
		$comm_minus_count = '0';
	} elseif ( $comm_minus && $comm_minus != "0" ) { // there are votes!
		$comm_minus_count = esc_attr( $comm_minus );
	}	
	$already = (AlreadyCommentplus( $post_id )) ? ' alreadycomment' : '';
	$output = '<div class="user-review-vote" id="commhelp'.$post_id.'">';
	$output .= '<span class="us-rev-vote-up'.$already.'" data-post_id="'.$post_id.'" data-informer="'.$comm_plus_count.'"><i class="fa fa-thumbs-up"></i> <span class="comm_help_title">'.__('Helpful', 'rehub_framework').'</span>(<span class="help_up_count" id="commhelpplus'.$post_id.'">'.$comm_plus_count.'</span>)</span>'; 
	$output .= '<span class="us-rev-vote-down'.$already.'" data-post_id="'.$post_id.'" data-informer="'.$comm_minus_count.'"><i class="fa fa-thumbs-down"></i> <span class="comm_help_title">'.__('Unhelpful', 'rehub_framework').'</span>(<span class="help_up_count" id="commhelpminus'.$post_id.'">'.$comm_minus_count.'</span>)</span>'; 
	$output .= '<span class="already_commhelp">'.__('You have already voted this', 'rehub_framework').'</span></div>';

		return $comment_text.$output;

}

//add_filter('comment_text', 'getCommentLike_re' );