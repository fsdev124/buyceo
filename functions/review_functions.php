<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php


/*-----------------------------------------------------------------------------------*/
# 	User rating function
/*-----------------------------------------------------------------------------------*/

add_action('wp_ajax_nopriv_rehub_rate_post', 'rehub_rate_post');
add_action('wp_ajax_rehub_rate_post', 'rehub_rate_post');
if( !function_exists('rehub_rate_post') ) {
function rehub_rate_post(){
	global $user_ID;

	if( ( !empty($user_ID) && rehub_option('allowtorate') == 'guests' ) ||	( empty($user_ID) && rehub_option('allowtorate') == 'users' ) ){
		return false ;
	}else{
		$count = $rating = $rate = 0;
		$postID = (isset($_REQUEST['post'])) ? $_REQUEST['post'] : '';
		$ratetype = (isset($_REQUEST['type'])) ? $_REQUEST['type'] : 'post';
		$rate = abs($_REQUEST['value']);
		if($rate > 5 ) $rate = 5;

		if( is_numeric( $postID ) && $ratetype=='post'){
			$rating = get_post_meta($postID, 'rehub_user_rate' , true);
			$count = get_post_meta($postID, 'rehub_users_num' , true);
			if( empty($count) || $count == '' ) $count = 0;

			$count++;
			$total_rate = (int)$rating + (int)$rate;
			$total = round($total_rate/$count , 2);
			if ( $user_ID ) {
				$user_rated = get_the_author_meta( 'rehub_rated', $user_ID  );

				if( empty($user_rated) ){
					$user_rated[$postID] = $rate;

					update_user_meta( $user_ID, 'rehub_rated', $user_rated );
					update_post_meta( $postID, 'rehub_user_rate', $total_rate );
					update_post_meta( $postID, 'rehub_users_num', $count );
					update_post_meta( $postID, '_rh_simple_u_rate_total', $total );

					echo $total;
				}
				else{
					if( !array_key_exists($postID , $user_rated) ){
						$user_rated[$postID] = $rate;
						update_user_meta( $user_ID, 'rehub_rated', $user_rated );
						update_post_meta( $postID, 'rehub_user_rate', $total_rate );
						update_post_meta( $postID, 'rehub_users_num', $count );
						update_post_meta( $postID, '_rh_simple_u_rate_total', $total );
						echo $total;
					}
				}
			}else{
				$ip = rehub_get_ip();
				$ip = str_replace('.', '', $ip);
				$get_t_id = get_transient('rh_star_rate_' . $postID);
				if( empty($get_t_id) ){
					$ips = array();
					$ips[$ip] = $rate;
					set_transient('rh_star_rate_' . $postID, $ips, 30 * DAY_IN_SECONDS);
					update_post_meta( $postID, 'rehub_user_rate', $total_rate );
					update_post_meta( $postID, 'rehub_users_num', $count );
					echo $total;
				}else{
					$ips = (array)$get_t_id;
					if (!array_key_exists($ip , $ips)){
						$ips[$ip] = $rate;
						set_transient('rh_star_rate_' . $postID, $ips, 30 * DAY_IN_SECONDS);
						update_post_meta( $postID, 'rehub_user_rate', $total_rate );
						update_post_meta( $postID, 'rehub_users_num', $count );	
						echo $total;				
					}					
				}
			}
		}
		if( is_numeric( $postID ) && $ratetype=='tax'){
			$rating = get_term_meta( $postID, 'rehub_user_rate', true );
			$count = get_term_meta( $postID, 'rehub_users_num', true );
			if( empty($count) || $count == '' ) $count = 0;

			$count++;
			$total_rate = (int)$rating + (int)$rate;
			$total = round($total_rate/$count , 2);
			if ( $user_ID ) {
				$user_rated = get_the_author_meta( 'rehub_rated', $user_ID  );

				if( empty($user_rated) ){
					$user_rated[$postID] = $rate;

					update_user_meta( $user_ID, 'rehub_rated', $user_rated );
					update_term_meta( $postID, 'rehub_user_rate', $total_rate );
					update_term_meta( $postID, 'rehub_users_num', $count );
					echo $total;
				}
				else{
					if( !array_key_exists($postID , $user_rated) ){
						$user_rated[$postID] = $rate;
						update_user_meta( $user_ID, 'rehub_rated', $user_rated );
						update_term_meta( $postID, 'rehub_user_rate', $total_rate );
						update_term_meta( $postID, 'rehub_users_num', $count );
						echo $total;
					}
				}
			}else{
				$ip = rehub_get_ip();
				$ip = str_replace('.', '', $ip);
				$get_t_id = get_transient('rh_star_rate_' . $postID);
				if( empty($get_t_id) ){
					$ips = array();
					$ips[$ip] = $rate;
					set_transient('rh_star_rate_' . $postID, $ips, 30 * DAY_IN_SECONDS);
					update_term_meta( $postID, 'rehub_user_rate', $total_rate );
					update_term_meta( $postID, 'rehub_users_num', $count );
					echo $total;
				}else{
					$ips = (array)$get_t_id;
					if (!array_key_exists($ip , $ips)){
						$ips[$ip] = $rate;
						set_transient('rh_star_rate_' . $postID, $ips, 30 * DAY_IN_SECONDS);
						update_term_meta( $postID, 'rehub_user_rate', $total_rate );
						update_term_meta( $postID, 'rehub_users_num', $count );		
						echo $total;			
					}					
				}
			}
		}
		if( is_numeric( $postID ) && $ratetype=='user'){
			$rating = get_user_meta( $postID, 'rh_total_bp_user_rating', true );
			$count = get_user_meta( $postID, 'rh_total_bp_user_rating_num', true );
			if( empty($count) || $count == '' ) $count = 0;

			$count++;
			$total_rate = (int)$rating + (int)$rate;
			$total = round($total_rate/$count , 2);
			if ( $user_ID ) {
				$user_rated = get_the_author_meta( 'rehub_rated', $user_ID  );

				if( empty($user_rated) ){
					$user_rated[$postID] = $rate;

					update_user_meta( $user_ID, 'rehub_rated', $user_rated );
					update_user_meta( $postID, 'rh_total_bp_user_rating', $total_rate );
					update_user_meta( $postID, 'rh_bp_user_rating', $total );
					update_user_meta( $postID, 'rh_total_bp_user_rating_num', $count );

					echo $total;
				}
				else{
					if( !array_key_exists($postID , $user_rated) ){
						$user_rated[$postID] = $rate;
						update_user_meta( $user_ID, 'rehub_rated', $user_rated );
						update_user_meta( $postID, 'rh_total_bp_user_rating', $total_rate );
						update_user_meta( $postID, 'rh_total_bp_user_rating_num', $count );
						update_user_meta( $postID, 'rh_bp_user_rating', $total );						
						echo $total;
					}
				}
			}else{
				$ip = rehub_get_ip();
				$ip = str_replace('.', '', $ip);
				$get_t_id = get_transient('rh_star_rate_' . $postID);
				if( empty($get_t_id) ){
					$ips = array();
					$ips[$ip] = $rate;
					set_transient('rh_star_rate_' . $postID, $ips, 30 * DAY_IN_SECONDS);
					update_user_meta( $postID, 'rh_total_bp_user_rating', $total_rate );
					update_user_meta( $postID, 'rh_total_bp_user_rating_num', $count );
					update_user_meta( $postID, 'rh_bp_user_rating', $total );
					echo $total;
				}else{
					$ips = (array)$get_t_id;
					if (!array_key_exists($ip , $ips)){
						$ips[$ip] = $rate;
						set_transient('rh_star_rate_' . $postID, $ips, 30 * DAY_IN_SECONDS);
						update_user_meta( $postID, 'rh_total_bp_user_rating', $total_rate );
						update_user_meta( $postID, 'rh_total_bp_user_rating_num', $count );
						update_user_meta( $postID, 'rh_bp_user_rating', $total );	
						echo $total;					
					}					
				}
			}
		}		
	}

    die();
}
}


/*-----------------------------------------------------------------------------------*/
# 	User results generating
/*-----------------------------------------------------------------------------------*/

if( !function_exists('rehub_get_user_rate') ) {
function rehub_get_user_rate($schema='admin', $type = 'post', $customid = ''){
	if ($type == 'post') {
		global $post;
		$postid = $post->ID;
	}
	elseif($type == 'tax') {
		$postid = get_queried_object()->term_id;
	}
	elseif($type == 'user') {
		$postid = $customid;
	}	
	global $user_ID;
	$disable_rate = false ;

	if( ( !empty($user_ID) && rehub_option('allowtorate') == 'guests' ) || ( empty($user_ID) && rehub_option('allowtorate') == 'users' ) )
		$disable_rate = true ;

	if( !empty($disable_rate) ){
		$no_rate_text = __( 'No Ratings Yet!', 'rehub_framework' );
		$rate_active = false ;
	}
	else{
		$no_rate_text = __( 'Be the first one!' , 'rehub_framework' );
		$rate_active = ' user-rate-active' ;
	}

	$image_style ='stars';
	if ($type == 'post') {
		$rate = get_post_meta( $postid , 'rehub_user_rate', true );
		$count = get_post_meta( $postid , 'rehub_users_num', true );
	}
	elseif($type == 'tax') {
		$rate = get_term_meta( $postid , 'rehub_user_rate', true );
		$count = get_term_meta( $postid , 'rehub_users_num', true );
	}
	elseif($type == 'user') {
		$rate = get_user_meta( $postid , 'rh_total_bp_user_rating', true );
		$count = get_user_meta( $postid , 'rh_total_bp_user_rating_num', true );
	}	

	if( !empty($rate) && !empty($count)){
		$total = $rate/$count;
		$total_users_score = round($rate/$count,2);		
	}else{
		$total_users_score = $total = $count = 0;
	}
	$stars = '';
    for ($i = 1; $i <= 5; $i++) {
    	if ($i <= $total){
    		$active = ' active';
    	}else{
    		$active ='';
    	}
        $stars .= '<i class="starrate starrate'.$i.$active.'" data-ratecount="'.$i.'"></i>';
    }	

	if ( $user_ID ) {
		$user_rated = get_the_author_meta( 'rehub_rated' , $user_ID ) ;
		if( !empty($user_rated) && is_array($user_rated) && array_key_exists($postid , $user_rated) ){
			$user_rate = round( ($user_rated[$postid]*100)/5 , 1);
			return $output = '<div class="rh-star-ajax"><span class="title_star_ajax"><strong>'.__( "User Rating:" , "rehub_framework" ) .' </strong> <span class="userrating-score">'.$total_users_score.'</span> <small>(<span class="userrating-count">'.$count.'</span> '.__( "votes" , "rehub_framework" ) .')</small> </span><div data-rate="'. round($total) .'" data-ratetype="'.$type.'" class="rate-post-'.$postid.' user-rate rated-done"><span class="post-norsp-rate '.$image_style.'-rate-ajax-type">'.$stars.'</span></div><div class="userrating-clear"></div></div>';
		}
	}else{
		$ip = rehub_get_ip();
		$ip = str_replace('.', '', $ip);
		$get_t_id = get_transient('rh_star_rate_' . $postid);

		if( !empty($get_t_id) ){
			if (array_key_exists($ip, $get_t_id)){			
				return $output = '<div class="rh-star-ajax"><span class="title_star_ajax"><strong>'.__( "User Rating:" , "rehub_framework" ) .' </strong> <span class="userrating-score">'.$total_users_score.'</span> <small>(<span class="userrating-count">'.$count.'</span> '.__( "votes" , "rehub_framework" ) .')</small> </span><div data-rate="'. round($total) .'" class="rate-post-'.$postid.' user-rate rated-done"><span class="post-norsp-rate '.$image_style.'-rate-ajax-type">'.$stars.'</span></div><div class="userrating-clear"></div></div>';
			}
		}

	}
	if( $total == 0 && $count == 0)
		return $output = '<div class="rh-star-ajax"><span class="title_star_ajax"><strong>'.__( "User Rating:" , "rehub_framework" ) .' </strong> <span class="userrating-score"></span> <small>'.$no_rate_text.'</small> </span><div data-rate="'. $total .'" data-id="'.$postid.'" data-ratetype="'.$type.'" class="rate-post-'.$postid.' user-rate'.$rate_active.'"><span class="post-norsp-rate '.$image_style.'-rate-ajax-type">'.$stars.'</span></div><div class="userrating-clear"></div></div>';
	else
		return $output = '<div class="rh-star-ajax"><span class="title_star_ajax"><strong>'.__( "User Rating:" , "rehub_framework" ) .' </strong> <span class="userrating-score">'.$total_users_score.'</span> <small>(<span class="userrating-count">'.$count.'</span> '.__( "votes" , "rehub_framework" ) .')</small> </span><div data-rate="'. $total .'" data-id="'.$postid.'" data-ratetype="'.$type.'" class="rate-post-'.$postid.' user-rate'.$rate_active.'"><span class="post-norsp-rate '.$image_style.'-rate-ajax-type">'.$stars.'</span></div><div class="userrating-clear"></div></div>';
}
}

if( !function_exists('rehub_get_user_rate_criterias') ) {
function rehub_get_user_rate_criterias (){
	global $post;
	$postAverage = get_post_meta($post->ID, 'post_user_average', true);
	$userrevcount = get_post_meta($post->ID, 'post_user_raitings', true);
	if ($postAverage !='0' && $postAverage !='' ){
		$total = $postAverage*10;
		return $output = '<div class="star"><span class="title_stars"><strong>'.__( "User Rating:" , "rehub_framework" ) .' </strong> <span class="userrating-score">'.$postAverage.'/10</span> <small>(<span class="userrating-count">'.$userrevcount['criteria'][0]['count'].'</span> '.__( "votes" , "rehub_framework" ) .')</small></span><div class="user-rate"><span class="stars-rate"><span style="width: '.$total.'%;"></span></span></div></div>';
	}
	else {
		return $output = '<div class="star criterias_star"><span class="title_stars"><strong>'.__( "User Rating:" , "rehub_framework" ) .' </strong>'.__( "No Ratings Yet!" , "rehub_framework" ) .' </span><a href="#respond" class="rehub_scroll add_user_review_link color_link">'.__("Add your review", "rehub_framework").'</a></div>';
	}
}
}


//////////////////////////////////////////////////////////////////
// User get results
//////////////////////////////////////////////////////////////////

if( !function_exists('rehub_get_user_results') ) {
function rehub_get_user_results( $size = 'small', $words = 'no' ){
	global $post ;
	$rate = get_post_meta( $post->ID , 'rehub_user_rate', true );
	$count = get_post_meta( $post->ID , 'rehub_users_num', true );
	$postAverage = get_post_meta($post->ID, 'post_user_average', true);

	if ((rehub_option('type_user_review') == 'full_review') && ($postAverage !='0' && $postAverage !='' )){
		$total = $postAverage*10;
		?>
		<?php if ($words == 'yes') :?><strong><?php _e('User rating', 'rehub_framework'); ?>: </strong><?php endif ;?><div class="star-<?php echo $size ?>"><span class="stars-rate"><span style="width: <?php echo $total ?>%;"></span></span></div>
		<?php
	}
	elseif( rehub_option('type_user_review') == 'simple' && !empty($rate) && !empty($count)){
		$total = (($rate/$count)/5)*100;
		?>
		<?php if ($words == 'yes') :?><strong><?php _e('User rating', 'rehub_framework'); ?>: </strong><?php endif ;?><div class="star-<?php echo $size ?>"><span class="stars-rate"><span style="width: <?php echo $total ?>%;"></span></span></div>
		<?php
	}
	else{}
}
}

if( !function_exists('rehub_get_user_resultsedd') ) {
function rehub_get_user_resultsedd( $size = 'small' ){
	global $post ;
	$rate = get_post_meta( $post->ID , 'rehub_user_rate', true );
	$count = get_post_meta( $post->ID , 'rehub_users_num', true );
	if( !empty($rate) && !empty($count)){
		$total = (($rate/$count)/5)*100;
		?>
		<div class="star-<?php echo $size ?>"><span class="stars-rate"><span style="width: <?php echo $total ?>%;"></span></span></div>
		<?php
	}
	else{}
}
}

if( !function_exists('rehub_get_overall_score') ) {
function rehub_get_overall_score($criterias='', $manual=''){
	if(!empty($criterias)){
		$thecriteria = $criterias;
	}
	else{
		$thecriteria = vp_metabox('rehub_post.review_post.0.review_post_criteria');
	}
	if(!empty($manual)){
		$manual_score = $manual;
	}
	else{
		$manual_score = vp_metabox('rehub_post.review_post.0.review_post_score_manual');
	}
	$score = 0; $total_counter = 0;

	if (!empty($thecriteria))  {
	    foreach ($thecriteria as $criteria) {
	    	$score += $criteria['review_post_score']; $total_counter ++;
	    }
	}
    if (!empty($manual_score))  {
    	$total_score = $manual_score;
    	return $total_score;
    }
    else {
		if( !empty( $score ) && !empty( $total_counter ) ) $total_score =  $score / $total_counter ;
		if( empty($total_score) ) $total_score = 0;
		$total_score = round($total_score,1);
		if (rehub_option('type_user_review') == 'full_review' && rehub_option('type_total_score') == 'average') {
			$userAverage = get_post_meta(get_the_ID(), 'post_user_average', true);
			if ($userAverage !='0' && $userAverage !='' ) {
				$total_score = ((int)$total_score + (int)$userAverage) / 2;
				$total_score = round($total_score,1);
			}
		}
		if (rehub_option('type_user_review') == 'full_review' && rehub_option('type_total_score') == 'user') {
			$total_score = 0;
			$userAverage = get_post_meta(get_the_ID(), 'post_user_average', true);
			if ($userAverage !='0' && $userAverage !='' ) {
				$total_score = $userAverage;
				$total_score = round($total_score,1);
			}
		}		
		elseif (rehub_option('type_user_review') == 'simple' && rehub_option('type_total_score') == 'average') {
			$rate = get_post_meta(get_the_ID(), 'rehub_user_rate', true );
			$count = get_post_meta(get_the_ID(), 'rehub_users_num', true );
			if( !empty($rate) && !empty($count)){
				$userAverage = (($rate/$count)/5)*10;
				$total_score = ((int)$total_score + (int)$userAverage) / 2;
				$total_score = round($total_score,1);
			}
		}	
		elseif (rehub_option('type_user_review') == 'simple' && rehub_option('type_total_score') == 'user') {
			$rate = get_post_meta(get_the_ID(), 'rehub_user_rate', true );
			$count = get_post_meta(get_the_ID(), 'rehub_users_num', true );
			if( !empty($rate) && !empty($count)){
				$userAverage = (($rate/$count)/5)*10;
				$total_score = $userAverage;
				$total_score = round($total_score,1);
			}
		}			
		return $total_score;
	}
}
}

if( !function_exists('rehub_get_overall_score_editor') ) {
function rehub_get_overall_score_editor($criterias='', $manual=''){
	if(!empty($criterias)){
		$thecriteria = $criterias;
	}
	else{
		$thecriteria = vp_metabox('rehub_post.review_post.0.review_post_criteria');
	}
	if(!empty($manual)){
		$manual_score = $manual;
	}
	else{
		$manual_score = vp_metabox('rehub_post.review_post.0.review_post_score_manual');
	}
	$score = 0; $total_counter = 0;

	if (!empty($manual_score))  {
    	$total_score = $manual_score;
    	return $total_score;
    }

    foreach ($thecriteria as $criteria) {

    	$score += $criteria['review_post_score']; $total_counter ++;
    }
		if( !empty( $score ) && !empty( $total_counter ) ) $total_score =  $score / $total_counter ;
		if( empty($total_score) ) $total_score = 0;
		$total_score = round($total_score,1);
		return $total_score;
}
}

add_action('save_post', 'rehub_save_post', 13);
if( !function_exists('rehub_save_post') ) {
function rehub_save_post( $post_id ){
	global $post;

	$rehub_meta_id = 'rehub_post';

	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;

	// make sure data came from our meta box, verify nonce
	$nonce = isset($_POST[$rehub_meta_id.'_nonce']) ? $_POST[$rehub_meta_id.'_nonce'] : NULL ;
	if (!wp_verify_nonce($nonce, $rehub_meta_id)) return $post_id;

	// check user permissions
	if ($_POST['post_type'] == 'page')
	{
		if (!current_user_can('edit_page', $post_id)) return $post_id;
	}
	else
	{
		if (!current_user_can('edit_post', $post_id)) return $post_id;
	}

	// authentication passed, process data
	$meta_data = isset( $_POST[$rehub_meta_id] ) ? $_POST[$rehub_meta_id] : NULL ;

	if ( !wp_is_post_revision( $post_id ) ) {
		// if is review post, save data
		if( $meta_data['rehub_framework_post_type'] === 'review' )
		{
			$thecriteria = $meta_data['review_post'][0]['review_post_criteria'];
			array_pop($thecriteria);
			$manual_score = $meta_data['review_post'][0]['review_post_score_manual'];
			$total_scores = rehub_get_overall_score($thecriteria, $manual_score);
			update_post_meta($post_id, 'rehub_review_overall_score', $total_scores); // save total score of review
			$editor_score = rehub_get_overall_score_editor($thecriteria, $manual_score);
			update_post_meta($post_id, 'rehub_review_editor_score', $editor_score); // save editor score of review
	 
			$firstcriteria = (!empty($thecriteria[0]['review_post_name'])) ? $thecriteria[0]['review_post_name'] : ''; 
			if($firstcriteria) :
				foreach ($thecriteria as $key=>$criteria) { 
					$key = $key + 1;
					$metakey = '_review_score_criteria_'.$key;
					update_post_meta($post_id, $metakey, $criteria['review_post_score']);
				}
			endif;
		}
		// if is video post, save thumbnail
		if( $meta_data['rehub_framework_post_type'] === 'video' ) {
			$post_thumbnail = get_post_meta( $post_id, '_thumbnail_id', true );	
			if( $meta_data['video_post'][0]['video_post_schema_thumb']=='1' && empty($post_thumbnail) && !empty($meta_data['video_post'][0]['video_post_embed_url'])){								
				$img_video_url = esc_url($meta_data['video_post'][0]['video_post_embed_url']); 
				$image_url = parse_video_url($img_video_url, 'hqthumb');	
				if (!empty($image_url)) {
					$att_id = rehub_import_to_media_library($image_url);				
					if (!empty($att_id)){
						update_post_meta( $post_id, $meta_key = '_thumbnail_id', $meta_value = $att_id );
					}					
				}
				
			}
		}
	}
}
}


/*-----------------------------------------------------------------------------------*/
# 	Review box generating
/*-----------------------------------------------------------------------------------*/

if( !function_exists('rehub_get_review') ) {
function rehub_get_review(){

    ?>
    <?php $overal_score = rehub_get_overall_score(); $postAverage = get_post_meta(get_the_ID(), 'post_user_average', true); ?>
	<div class="rate_bar_wrap<?php if ((rehub_option('type_user_review') == 'full_review') && ($postAverage !='0' && $postAverage !='' )) {echo ' two_rev';} ?><?php if (rehub_option('color_type_review') == 'multicolor') {echo ' colored_rate_bar';} ?>">		
		<?php if ($overal_score !='0') :?>
			<div class="review-top">								
				<div class="overall-score">
					<span class="overall r_score_<?php echo round($overal_score); ?>"><?php echo round($overal_score, 1) ?></span>
					<span class="overall-text"><?php _e('Total Score', 'rehub_framework'); ?></span>
					<?php if (rehub_option('type_schema_review') == 'user' && rehub_option('type_user_review') == 'full_review' && get_post_meta(get_the_ID(), 'post_user_raitings', true) !='') :?>						
					<div class="overall-user-votes"><span><?php $user_rates = get_post_meta(get_the_ID(), 'post_user_raitings', true); echo $user_rates['criteria'][0]['count'] ;?></span> <?php _e('reviews', 'rehub_framework'); ?></div>
					<?php endif;?>				
				</div>				
				<div class="review-text">
					<span class="review-header"><?php echo vp_metabox('rehub_post.review_post.0.review_post_heading'); ?></span>
					<p>
						<?php echo wp_kses_post(vp_metabox('rehub_post.review_post.0.review_post_summary_text')); ?>
					</p>
				</div>
			</div>
		<?php endif ;?>

		<?php $thecriteria = vp_metabox('rehub_post.review_post.0.review_post_criteria'); $firstcriteria = $thecriteria[0]['review_post_name']; ?>

		<?php if ((rehub_option('type_user_review') == 'full_review') && ($postAverage !='0' && $postAverage !='' )) :?>
			<div class="rate_bar_wrap_two_reviews">
				<?php if($firstcriteria) : ?>
				<div class="review-criteria">
					<div class="l_criteria"><span class="score_val r_score_<?php echo round(rehub_get_overall_score_editor()); ?>"><?php echo round(rehub_get_overall_score_editor(), 1); ?></span><span class="score_tit"><?php _e('Editor\'s score', 'rehub_framework'); ?></span></div>
					<div class="r_criteria">
						<?php foreach ($thecriteria as $criteria) { ?>
						<?php $perc_criteria = $criteria['review_post_score']*10; ?>
						<div class="rate-bar clearfix" data-percent="<?php echo $perc_criteria; ?>%">
							<div class="rate-bar-title"><span><?php echo $criteria['review_post_name']; ?></span></div>
							<div class="rate-bar-bar r_score_<?php echo round($criteria['review_post_score']); ?>"></div>
							<div class="rate-bar-percent"><?php echo round($criteria['review_post_score'], 1) ?></div>
						</div>
						<?php } ?>
					</div>
				</div>
				<?php endif; ?>
				<?php $user_rates = get_post_meta(get_the_ID(), 'post_user_raitings', true); $usercriterias = $user_rates['criteria'];  ?>
				<div class="review-criteria user-review-criteria">
					<div class="l_criteria"><span class="score_val r_score_<?php echo round($postAverage); ?>"><?php echo round($postAverage, 1) ?></span><span class="score_tit"><?php _e('User\'s score', 'rehub_framework'); ?></span></div>
					<div class="r_criteria">
						<?php foreach ($usercriterias as $usercriteria) { ?>
						<?php $perc_criteria = $usercriteria['average']*10; ?>
						<div class="rate-bar user-rate-bar clearfix" data-percent="<?php echo $perc_criteria; ?>%">
							<div class="rate-bar-title"><span><?php echo $usercriteria['name']; ?></span></div>
							<div class="rate-bar-bar r_score_<?php echo round($usercriteria['average']); ?>"></div>
							<div class="rate-bar-percent"><?php echo round($usercriteria['average'], 1) ?></div>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
		<?php else :?>

			<?php if($firstcriteria) : ?>
				<div class="review-criteria">
					<?php foreach ($thecriteria as $criteria) { ?>
						<?php $perc_criteria = $criteria['review_post_score']*10; ?>
						<div class="rate-bar clearfix" data-percent="<?php echo $perc_criteria; ?>%">
							<div class="rate-bar-title"><span><?php echo $criteria['review_post_name']; ?></span></div>
							<div class="rate-bar-bar r_score_<?php echo round($criteria['review_post_score']); ?>"></div>
							<div class="rate-bar-percent"><?php echo $criteria['review_post_score']; ?></div>
						</div>
					<?php } ?>
				</div>
			<?php endif; ?>
		<?php endif ;?>

	    <?php 	
	    	$prosvalues = vp_metabox('rehub_post.review_post.0.review_post_pros_text');	
			$consvalues = vp_metabox('rehub_post.review_post.0.review_post_cons_text');
		?> 
		<?php $pros_cons_wrap = (!empty($prosvalues) || !empty($consvalues) ) ? ' class="pros_cons_values_in_rev"' : ''?>
		<!-- PROS CONS BLOCK-->
		<div<?php echo $pros_cons_wrap;?>>
		<?php if(!empty($prosvalues)):?>
		<div <?php if(!empty($prosvalues) && !empty($consvalues)):?>class="wpsm-one-half wpsm-column-first"<?php endif;?>>
			<div class="wpsm_pros">
				<div class="title_pros"><?php _e('PROS', 'rehub_framework');?></div>
				<ul>		
					<?php $prosvalues = explode(PHP_EOL, $prosvalues);?>
					<?php foreach ($prosvalues as $prosvalue) {
						echo '<li>'.$prosvalue.'</li>';
					}?>
				</ul>
			</div>
		</div>
		<?php endif;?>
	
		<?php if(!empty($consvalues)):?>
		<div class="wpsm-one-half wpsm-column-last">
			<div class="wpsm_cons">
				<div class="title_cons"><?php _e('CONS', 'rehub_framework');?></div>
				<ul>
					<?php $consvalues = explode(PHP_EOL, $consvalues);?>
					<?php foreach ($consvalues as $consvalue) {
						echo '<li>'.$consvalue.'</li>';
					}?>
				</ul>
			</div>
		</div>
		<?php endif;?>
		</div>	
		<!-- PROS CONS BLOCK END-->	

		<?php if (rehub_option('type_user_review') == 'simple') :?>
			<?php if ($overal_score !='0') :?>
				<div class="rating_bar"><?php echo rehub_get_user_rate() ; ?></div>
			<?php else :?>
				<div class="rating_bar no_rev"><?php echo rehub_get_user_rate() ; ?></div>
			<?php endif; ?>
		<?php elseif (rehub_option('type_user_review') == 'full_review' && comments_open()) :?>
			<a href="#respond" class="rehub_scroll add_user_review_link"><?php _e("Add your review", "rehub_framework"); ?></a> <?php $comments_count = wp_count_comments(get_the_ID()); if ($comments_count->total_comments !='') :?><span class="add_user_review_link"> &nbsp;|&nbsp; </span><a href="#comments" class="rehub_scroll add_user_review_link"><?php _e("Read reviews and comments", "rehub_framework"); ?></a><?php endif;?>
		<?php endif; ?>

	</div>


<?php

}
}

//COMMENT SORT FUNCTIONS
add_action('wp_ajax_nopriv_show_tab', 'show_tab_ajax');
add_action('wp_ajax_show_tab', 'show_tab_ajax');
function show_tab_ajax() {
  	if (!isset($_POST['rating_tabs_id']) || !wp_verify_nonce($_POST['rating_tabs_id'], 'rating_tabs_nonce'))
    die(sha1(microtime())); // return some random trash :)

  	if (!isset($_POST['post_id']) || !isset($_POST['tab_number']))
    	die(sha1(microtime())); // return some random trash :)

  	$post_id = (int)$_POST['post_id'];
  	$tab_number = (int)$_POST['tab_number'];
  	if (empty($post_id) || empty($tab_number) || $post_id<1 || $tab_number<1 || $tab_number>4)
    	die(sha1(microtime())); // return some random trash :)

  	$comments_count = wp_count_comments($post_id);
  	if (empty($comments_count->approved))
    	die('No comments on this post');
  	unset($comments_count);

	$comments_v = get_comments(array(
		'post_id' => $post_id,
		'status'  => 'approve',
		'orderby' => 'comment_date',
		'order'   => 'DESC',
	));

  	foreach($comments_v as $key=>$comment) {
    	$meta = get_comment_meta($comment->comment_ID);
    	$comment->user_average = isset($meta['user_average'][0]) ? $meta['user_average'][0] : 0;
    	$comment->recomm_plus  = isset($meta['recomm_plus'][0]) ? $meta['recomm_plus'][0] : 0;
    	$comment->recomm_minus = isset($meta['recomm_minus'][0]) ? $meta['recomm_minus'][0] : 0;
    	$comments_and_meta_v[$key] = $comment;
  	}
  	unset($comments_v);

  	switch ($tab_number) {
    	case 1 : $sorted_comments_v = show_tab_get_newest($comments_and_meta_v); break;
    	case 2 : $sorted_comments_v = show_tab_get_most_helpful($comments_and_meta_v); break;
    	case 3 : $sorted_comments_v = show_tab_get_highest_rating($comments_and_meta_v); break;
    	case 4 : $sorted_comments_v = show_tab_get_lowest_rating($comments_and_meta_v); break;
    default: die(sha1(microtime())); // not needed, but...
  	}
  	unset($comments_and_meta_v);

  	show_tab_print_comments($sorted_comments_v);
  	exit;
}
// ----------------------------------------------
function show_tab_get_newest($comments_v) {
  	return $comments_v; // it already sorted as we need
}
// ----------------------------------------------
function show_tab_get_most_helpful_sort ($a, $b) {
    if ($a->recomm_plus > $b->recomm_plus)
      	return -1;
    elseif ($a->recomm_plus < $b->recomm_plus)
      	return 1;
    elseif ($a->comment_ID > $b->comment_ID)
      	return -1;
    else
      	return 1;
}
function show_tab_get_most_helpful($comments_v) {
  	$comments_v = show_tab_delete_unlikes_comments($comments_v);
  	usort($comments_v, 'show_tab_get_most_helpful_sort');
  	return $comments_v;
}
// ----------------------------------------------
function show_tab_get_highest_rating_sort ($a, $b) {
    if ($a->user_average > $b->user_average)
      	return -1;
    elseif ($a->user_average < $b->user_average)
      	return 1;
    elseif ($a->comment_ID > $b->comment_ID)
      	return -1;
    else
      return 1;
}
function show_tab_get_highest_rating($comments_v) {
  	$comments_v = show_tab_delete_unrated_comments($comments_v);
  	usort($comments_v, 'show_tab_get_highest_rating_sort');
  	return $comments_v;
}
// ----------------------------------------------

function show_tab_get_lowest_rating_sort ($a, $b) {
   if ($a->user_average > $b->user_average)
      	return 1;
    elseif ($a->user_average < $b->user_average)
      	return -1;
    elseif ($a->comment_ID > $b->comment_ID)
      	return 1;
    else
      	return -1;
}
function show_tab_get_lowest_rating($comments_v) {
  	$comments_v = show_tab_delete_unrated_comments($comments_v);
  	usort($comments_v, 'show_tab_get_lowest_rating_sort');
  	return $comments_v;
}
// ----------------------------------------------
function show_tab_delete_unrated_comments($comments_v) {
  	$result_v = array();
  	foreach($comments_v as $comment) {
    if (empty($comment->user_average)) continue;
    	$result_v[] = $comment;
  	}
  	return $result_v;
}
// ----------------------------------------------
function show_tab_delete_unlikes_comments($comments_v) {
  	$result_v = array();
  	foreach($comments_v as $comment) {
    	if (empty($comment->recomm_plus)) continue;
    	$result_v[] = $comment;
  	}
  	return $result_v;
}
// ----------------------------------------------
function show_tab_print_comments($sorted_comments_v) {
  	wp_list_comments(array(
    	'avatar_size'   => 50,
    	'max_depth'     => 4,
    	'style'         => 'ul',
    	'reverse_top_level' => 0,
    	'callback'      => 'rehub_framework_comments',
    	'echo'          => 'true'
  	), $sorted_comments_v);
}

?>