<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php

/*compatibility for servers without math library*/

if( !function_exists( "bcdiv" ) )
{
    function bcdiv( $first, $second, $scale = 0 )
    {
        $res = $first / $second;
        return round( $res, $scale );
    }
}

/* Add inputs to comment form */

if( !function_exists('add_criteria_raitings_comment_fields') ) {
function add_criteria_raitings_comment_fields($fields) {
	$reviewType = get_post_meta(get_the_ID(), 'rehub_framework_post_type', true);
	$reviewCriteria = vp_metabox('rehub_post.review_post.0.review_post_criteria');
	$firstcriteria = $reviewCriteria[0]['review_post_name'];
	if($reviewType == 'review' && $firstcriteria !='') {
		wp_enqueue_style('jquery.nouislider'); 
		wp_enqueue_script('jquery.nouislider'); 
		$criteriaNamesArray = array();
		$criteriaInputs = '<div id="user_reviews_in_comment"><div class="user_rating_left_com">';
		for($i = 0; $i < count($reviewCriteria); $i++) {
			$criteriaNamesArray[$i] = $reviewCriteria[$i]['review_post_name'];
			$criteriaInputs .= '<label for="criteria_input_'.$i.'">'.$reviewCriteria[$i]['review_post_name'].'</label>';
			$criteriaInputs .= '<input id="criteria_input_'.$i.'" type="hidden" name="user_criteria[]" value="0" class="criteria_hidden_input'.$i.'" /><span class="criteria_visible_input'.$i.'"><span class="userstar-rating"><span></span></span></span><div class="user_rating_slider_criteria"></div>';
		};
		$criteriaInputs .= '<div class="your_total_score">'.__('Your total score','rehub_framework').' <span class="user_reviews_view_score"><span class="userstar-rating"><span></span></span></span></div></div><input type="hidden" name="criteria_names" value="'.implode(",", $criteriaNamesArray).'" />';
		$criteriaInputs .= '<div class="user_rating_right_com"><textarea id="pros_review" name="pros_review" rows="5" placeholder="'.__('PROS','rehub_framework').'"></textarea><br /><textarea id="cons_review" name="cons_review" rows="5" placeholder="'.__('CONS','rehub_framework').'"></textarea></div>';
		$criteriaInputs .= '</div>';

		// check if rated post already
		$current_user_id = get_current_user_id();
		if($current_user_id) {
			$rated_posts = get_user_meta($current_user_id, 'rated_posts', true);
			if($rated_posts) {
				$current_post_id = get_the_ID();
				if(in_array($current_post_id, $rated_posts)) {
					$criteriaInputs = '';
					wp_dequeue_style('jquery.nouislider'); 
					wp_dequeue_script('jquery.nouislider'); 
				};
			};
		}

		else {
			if (isset($_COOKIE['rated_posts'])) {
				$rated_posts = explode(',', $_COOKIE['rated_posts']);
				if($rated_posts) {
					$criteriaInputs = '';
					wp_dequeue_style('jquery.nouislider'); 
					wp_dequeue_script('jquery.nouislider'); 			
				};
			};
		};	

		if(is_user_logged_in()) {
			$fields .= $criteriaInputs;
		}
		else {
			$fields['criteria'] = $criteriaInputs;
		};
		return $fields;
	}
	else {
		return $fields;
	}

}
}

//add inputs to comment form
add_action('init', 'rh_add_review_form_to_comments');
function rh_add_review_form_to_comments(){
	if (rehub_option('allowtorate') == 'guests' ) {
		if (!is_user_logged_in()) {
			add_filter('comment_form_default_fields', 'add_criteria_raitings_comment_fields');
		}
	}
	elseif (rehub_option('allowtorate') == 'users') {
		if (is_user_logged_in()) {
			add_filter('comment_form_logged_in', 'add_criteria_raitings_comment_fields');
		}
	}
	else {
		if (!is_user_logged_in()) {
			add_filter('comment_form_default_fields', 'add_criteria_raitings_comment_fields');
		}else{
			add_filter('comment_form_logged_in', 'add_criteria_raitings_comment_fields');			
		}
	}
}

/* saving data when add comment */
add_action('comment_post', 'save_comment_criteria_raitings');	

/* Saving data from fields */
function save_comment_criteria_raitings($comment_id) {
	if((isset($_POST['user_criteria'])) && ($_POST['user_criteria'] != '')) { // if we got user ratings
		$userCriteria = $_POST['user_criteria']; $commentTotal = ''; // put user ratings in array
		for($i = 0; $i < count($userCriteria); $i++) { // get sum of ratings
			$commentTotal += $userCriteria[$i];
		};
		if($commentTotal == 0 || $commentTotal =='') { // if sum = 0
			return false; 
		}
		else { // if user set ratings
			$commentData = array();
			$criteriaNamesSerialized = sanitize_text_field($_POST['criteria_names']); // get array of criteria names
			$criteriaNames = explode(',', $criteriaNamesSerialized);
			for($i = 0; $i < count($userCriteria); $i++) {
				$commentData[$i]['name'] = $criteriaNames[$i]; // put name of criteria in variable
				$commentData[$i]['value'] = $userCriteria[$i]; // put criteria value in variable
			};
			$commentAverage = bcdiv($commentTotal, count($commentData), 1); // get average of comment ratings
		};
		$cons_review_clean = wp_kses($_POST['cons_review'], 'default'); // get cons value
		$pros_review_clean = wp_kses($_POST['pros_review'], 'default'); // get pros value
		update_comment_meta($comment_id, 'cons_review', $cons_review_clean); // put cons in meta field
		update_comment_meta($comment_id, 'pros_review', $pros_review_clean); // put pros in meta field
		update_comment_meta($comment_id, 'user_criteria', $commentData); // put array of user ratings in meta field
		update_comment_meta($comment_id, 'user_average', $commentAverage); // put average of ratings in meta field
		update_comment_meta($comment_id, 'counted', 0); // set flag approve or not user review

		/* Prevent duplicate vote */
		$current_user_id = get_current_user_id(); // get user ID
		if($current_user_id) { // if register
			$comment = get_comment($comment_id);
			$current_post_id = $comment->comment_post_ID; // get post ID
			$rated_posts_meta = get_user_meta($current_user_id , 'rated_posts', true); // get array of reviewed posts of user
			if(!$rated_posts_meta || $rated_posts_meta == '') { // if array not exist
				$rated_posts_meta = array($current_post_id); // create array
			}
			else {
				$rated_posts_meta[] = $current_post_id; // put ID of reviewed post in array of reviewed posts
			};
			update_user_meta($current_user_id , 'rated_posts', $rated_posts_meta); // update user meta field
		}
		else { // if user is not register
			$domainArray = explode('://', home_url());
			$clearDomain = $domainArray[1]; // get site domain
			$comment = get_comment($comment_id);
			$current_post_id = $comment->comment_post_ID; // get post ID			
			$clearLink = str_replace(home_url(), '', get_permalink($current_post_id)); // get post URL
			setcookie('rated_posts', 1, time()+60*60*24*366, $clearLink, $clearDomain, false); // put cookie that user reviewed this post
		};
	};
}

add_action('comment_post', 'comment_rates_change_on_post', 10, 2);  // Runs when saving new comment 
add_action('edit_comment', 'comment_rates_change');  // Runs when editing comment
add_action('delete_comment', 'comment_rates_change'); // Runs just before a comment is deleted. Action function arguments: comment ID. 
add_action('trash_comment', 'comment_rates_change'); // Runs just before a comment is trashed. Action function arguments: comment ID. 
add_action('comment_closed', 'comment_rates_change'); // Runs when the post is marked as not a spam.
add_action('wp_set_comment_status', 'comment_rates_change'); // Runs when the status of a comment changes. Action function arguments: comment ID, status string indicating the new status ("delete", "approve", "spam", "hold"). 

function comment_rates_change($comment_id) {
	$status = wp_get_comment_status($comment_id); // 'deleted', 'approved', 'unapproved', 'spam'
	switch($status) {
		case 'approved':
			add_comment_rates($comment_id);
			break;
		case 'unapproved':
			remove_comment_rates($comment_id);
			break;
		case 'spam':
			remove_comment_rates($comment_id);
			break;
		case 'trash':
			remove_comment_rates($comment_id);
			rehub_rewrite_user_review($comment_id);
			break;
		case 'deleted':
			remove_comment_rates($comment_id);
			rehub_rewrite_user_review($comment_id);
			break;			
		default:
	};
}

function comment_rates_change_on_post($comment_id, $comment_approved) {
	if( $comment_approved == 1 ) {
		add_comment_rates($comment_id);
	}
	else {
		return;
	}			
}

/* Saving data from fields */
function add_comment_rates($comment_id) {
	$counted = get_comment_meta($comment_id, 'counted', true); // get flag 

	if($counted == 0) { // Если значения пользовательской оценки не учтены в рейтинге
		$comment = get_comment($comment_id); // Получаем объект комментария по идентификатору
		$comment_post_id = $comment->comment_post_ID; // Получаем идентификатор комментария из объекта комментария
		$postUserRaitingsArray = get_post_meta($comment_post_id, 'post_user_raitings', false); // Получаем массив значений рейтинга из произвольного поля записи
		$postUserRaitings = (!empty($postUserRaitingsArray)) ? $postUserRaitingsArray[0] : '';
		$commentRaitingsArray = get_comment_meta($comment_id, 'user_criteria', false); // Получаем массив пользовательских оценок из произвольного поля комментария
		$commentRaitings = (!empty($commentRaitingsArray[0])) ? $commentRaitingsArray[0] : '';
		$postData = array(); // Создаем массив хранения данных
		$postCriteriaAverage = '';
		if(isset($commentRaitings) && count($commentRaitings) > 0 && is_array($commentRaitings)) {
			for($i = 0; $i < count($commentRaitings); $i++) {
				$postData['criteria'][$i]['name'] = $commentRaitings[$i]['name'];
				if(isset($postUserRaitings['criteria'][$i])) {
					$count = (int) $postUserRaitings['criteria'][$i]['count'] + 1;
					$total = (float) $commentRaitings[$i]['value'] + (float) $postUserRaitings['criteria'][$i]['value'];
					$postData['criteria'][$i]['count'] = $count;
					$postData['criteria'][$i]['value'] = $total;
					$postData['criteria'][$i]['average'] = bcdiv($total, $count, 1);
				}
				else {
					$postData['criteria'][$i]['count'] = 1;
					$postData['criteria'][$i]['value'] = (float) $commentRaitings[$i]['value'];
					$postData['criteria'][$i]['average'] = (float) $commentRaitings[$i]['value'];
				};
				$postCriteriaAverage += $postData['criteria'][$i]['average'];
			};			
			$postAverage = bcdiv($postCriteriaAverage, count($commentRaitings), 1);
			update_post_meta($comment_post_id, 'post_user_raitings', $postData);
			update_post_meta($comment_post_id, 'post_user_average', $postAverage);
			if(rehub_option('type_total_score')=='average'){
				$editorrate = get_post_meta($comment_post_id, 'rehub_review_editor_score', true);
				if($editorrate){
					$overallupdate = ($editorrate + $postAverage) / 2;
					update_post_meta($comment_post_id, 'rehub_review_overall_score', $overallupdate);
				}
			}
			elseif(rehub_option('type_total_score')=='user'){
				update_post_meta($comment_post_id, 'rehub_review_overall_score', $postAverage);
			}			
			update_comment_meta($comment_id, 'counted', 1); // Устанавливаем флаг учета значений пользовательской оценки в произвольное поле комментария
		}		
	}

	elseif($counted == '') {
		update_comment_meta($comment_id, 'counted', 1); // Устанавливаем флаг учета значений пользовательской оценки в произвольное поле комментария
	};
}

/* remove coment data on comment remove */

function remove_comment_rates($comment_id) {
	$counted = get_comment_meta($comment_id, 'counted', true); // Получаем значение флага учета значений пользовательской оценки в рейтинге
	if($counted == 1 || $counted == '') { // Если значения пользовательской оценки не учтены в рейтинге
		$comment = get_comment($comment_id); // Получаем объект комментария по идентификатору
		$comment_post_id = $comment->comment_post_ID; // Получаем идентификатор комментария из объекта комментария
		$postUserRaitingsArray = get_post_meta($comment_post_id, 'post_user_raitings', false); // Получаем массив значений рейтинга из произвольного поля записи
		$postUserRaitings = $postUserRaitingsArray[0];
		$commentRaitingsArray = get_comment_meta($comment_id, 'user_criteria', false); // Получаем массив пользовательских оценок из произвольного поля комментария
		$commentRaitings = $commentRaitingsArray[0];
		$postData = array(); // Создаем массив хранения данных
		for($i = 0; $i < count($commentRaitings); $i++) {
			$postData['criteria'][$i]['name'] = $commentRaitings[$i]['name'];
			if(isset($postUserRaitings['criteria'][$i])) {
				$count = (int) $postUserRaitings['criteria'][$i]['count'] - 1;
				$total = (float) $postUserRaitings['criteria'][$i]['value'] - (float) $commentRaitings[$i]['value'];
				$postData['criteria'][$i]['count'] = $count;
				$postData['criteria'][$i]['value'] = $total;
				if ($count =='0') {
					$postData['criteria'][$i]['average'] = '';
				}
				else {
					$postData['criteria'][$i]['average'] = bcdiv($total, $count, 1);
				}
			};
			$postCriteriaAverage += $postData['criteria'][$i]['average'];
		};
		if(isset($commentRaitings) && count($commentRaitings) > 0) {
			$postAverage = bcdiv($postCriteriaAverage, count($commentRaitings), 1);
			update_post_meta($comment_post_id, 'post_user_raitings', $postData);
			update_post_meta($comment_post_id, 'post_user_average', $postAverage);
			if(rehub_option('type_total_score')=='average'){
				$editorrate = get_post_meta($comment_post_id, 'rehub_review_editor_score', true);
				if($editorrate){
					$overallupdate = ($editorrate + $postAverage) / 2;
					update_post_meta($comment_post_id, 'rehub_review_overall_score', $overallupdate);
				}
			}
			elseif(rehub_option('type_total_score')=='user'){
				update_post_meta($comment_post_id, 'rehub_review_overall_score', $postAverage);
			}
			update_comment_meta($comment_id, 'counted', 0); // Устанавливаем флаг учета значений пользовательской оценки в произвольное поле комментария
		}
	};
};

/* Ability to write new review after deleting comment */
function rehub_rewrite_user_review($comment_id) {	
	$comment = get_comment($comment_id);	
	$current_user_id = $comment->user_id; // get user ID
	$current_post_id = $comment->comment_post_ID; // get post ID	
	if($current_user_id) { // if register
		$rated_posts_meta = get_user_meta($current_user_id, 'rated_posts', false); // get array of reviewed posts of user
		if(($key = array_search($current_post_id, $rated_posts_meta)) !== false) {
			unset($rated_posts_meta[$key]);
			update_user_meta($current_user_id , 'rated_posts', $rated_posts_meta); // update user meta field			
		}
		
	}
}


/* function that show review in comment */
if( !function_exists('attach_comment_criteria_raitings') ) {
function attach_comment_criteria_raitings($text='') {
    $userCriteria = get_comment_meta(get_comment_ID(), 'user_criteria', true);	
	$pros_review = get_comment_meta(get_comment_ID(), 'pros_review', true);
	$cons_review = get_comment_meta(get_comment_ID(), 'cons_review', true);
    $userAverage = get_comment_meta(get_comment_ID(), 'user_average', true);
		if(is_array($userCriteria) && !empty($userCriteria)) {
			if (rehub_option('color_type_review') == 'simple') {$color_type = ' simple_color';} else {$color_type = ' multi_color';}
			if (is_singular('post') && rehub_option('rehub_replace_color') =='1' && rehub_option('color_type_review') =='simple') {$category = get_the_category($post->ID); $first_cat = $category[0]->term_id; $cat_sustom = ' category-'.$first_cat.'';} else {$cat_sustom = '';}			
			$text ='<div class="user_reviews_view'.$color_type.''.$cat_sustom.'"><div class="user_reviews_view_box">';			
		if(isset($userAverage) && $userAverage != '' && count($userCriteria) >=2) {
			$userAverages = $userAverage * 10;
			$userstartitle = $userAverage / 2;
			$text .= '<div class="user_reviews_view_score"><div class="userstar-rating" title="'.__('Rated', 'rehub_framework').' '.$userstartitle.' '.__('out of', 'rehub_framework').' 5"><span style="width:'.$userAverages.'%"><strong class="rating">'.$userstartitle.'</strong></span></div></div>';
		};		
		for($i = 0; $i < count($userCriteria); $i++) {
			$value_criteria = $userCriteria[$i]['value'] * 10;		
			$text .= '<div class="user_reviews_view_criteria_line"><span class="user_reviews_view_criteria_name">'.$userCriteria[$i]['name'].'</span><div class="userstar-rating"><span style="width:'.$value_criteria.'%"><strong class="rating">'.$value_criteria.'</strong></span></div></div>';
		};
		$text .= '</div>';
		///
		$textsec = '';
		if(isset($pros_review) && $pros_review != '') {
			$pros_reviews = explode(PHP_EOL, $pros_review);
			$proscomment = '';
			foreach ($pros_reviews as $pros) {
				$proscomment .='<span class="pros_comment_item">'.$pros.'</span>';
			}
			$textsec .= '<div class="user_reviews_view_pros"><span class="user_reviews_view_pc_title mb5">'.__('+ PROS:', 'rehub_framework').' </span><span> '.$proscomment.'</span></div>';
		};
		if(isset($cons_review) && $cons_review != '') {
			$cons_reviews = explode(PHP_EOL, $cons_review);
			$conscomment = '';
			foreach ($cons_reviews as $cons) {
				$conscomment .='<span class="cons_comment_item">'.$cons.'</span>';
			}			
			$textsec .= '<div class="user_reviews_view_cons"><span class="user_reviews_view_pc_title mb5">'.__('- CONS:', 'rehub_framework').'</span><span> '.$conscomment.'</span></div>';
		};	
		if (rehub_option('enable_btn_userreview') == '1') {
			$textsec .= getCommentLike_re('');	
		}
		$textsec .= '</div></div>';
		};	
    echo $text;
    echo '<div class="user_reviews_view_proscons"><div class="comm_text_from_review">'; comment_text(); echo '</div>';
    echo $textsec;
}
}

// ADD THE COMMENTS META FIELDS TO THE COMMENTS ADMIN PAGE

function rehub_comment_columns( $columns )
{
	$columns['my_custom_column'] = __( 'User review', 'rehub_framework' );
	return $columns;
}
add_filter( 'manage_edit-comments_columns', 'rehub_comment_columns' );

function myplugin_comment_column( $column, $comment_ID )
{
	if ( 'my_custom_column' == $column ) {
		
	$comment_meta = get_comment_meta($comment_ID);
	$userCriteria = get_comment_meta($comment_ID, 'user_criteria', true);	
	$pros_review = get_comment_meta($comment_ID, 'pros_review', true);
	$cons_review = get_comment_meta($comment_ID, 'cons_review', true);
	if(is_array($userCriteria) && !empty($userCriteria)) {
		if(isset($pros_review) && $pros_review != '') {
			echo ''.__('+ PROS:', 'rehub_framework').' '.$pros_review.'<br />';
		};
		if(isset($cons_review) && $cons_review != '') {
			echo ''.__('- CONS:', 'rehub_framework').' '.$cons_review.'<br /><br />';
		};		
		for($i = 0; $i < count($userCriteria); $i++) {		
			echo ''.$userCriteria[$i]['name'].': <strong class="rating">'.$userCriteria[$i]['value'].'</strong><br />';
		};		
	};
	echo '<br /></p>';
	}
}
add_filter( 'manage_comments_custom_column', 'myplugin_comment_column', 10, 2 );


/* Save Admin Review Comment fields */
function rehub_admin_save_comment( $location, $comment_id ) {
    // Not allowed, return regular value without updating meta
    if ( !check_admin_referer('update-comment_' . $comment_id) ) 
		return $location;

    // Update meta
    update_comment_meta( 
        $comment_id, 
        'pros_review', 
        sanitize_text_field( $_POST['pros_review'] ) 
    );
    update_comment_meta( 
        $comment_id, 
        'cons_review', 
        sanitize_text_field( $_POST['cons_review'] ) 
    );
    update_comment_meta( 
        $comment_id, 
        'user_criteria', 
        ( $_POST['user_criteria'] ) 
    );
	
	// Run update Post rating
	rh_update_post_rating( $comment_id );
	
    // Return regular value after updating  
    return $location;
}
add_filter( 'comment_edit_redirect',  'rehub_admin_save_comment', 10, 2 );

/* Add Admin Comment Review meta box */
function rh_review_add_custom_box() {
	add_meta_box( 
		'rh_review_section',
		__( 'Review Data' ),
		'rh_review_inner_custom_box',
		'comment',
		'normal'
	);	
}
add_action( 'add_meta_boxes', 'rh_review_add_custom_box' );

/* Render meta box with Review fields */
if( !function_exists('rh_review_inner_custom_box') ) {
	function rh_review_inner_custom_box( $comment ) {
 		if ( !isset( $comment->comment_ID ) ) return;
 		if ( !isset( $comment->comment_post_ID ) ) return;		
		$reviewType = get_post_meta( $comment->comment_post_ID, 'rehub_framework_post_type', true );
		if ($reviewType && $reviewType == 'review') {
			$userCriteria = get_comment_meta( $comment->comment_ID, 'user_criteria', true );
			$pros_review = get_comment_meta( $comment->comment_ID, 'pros_review', true );
			$cons_review = get_comment_meta( $comment->comment_ID, 'cons_review', true );
			$prosconsRow = $criteriaRow = '';
			
			if( !empty($pros_review) || !empty($cons_review) ) {
				$prosconsRow .= '<tr><td colspan="2"><label for="pros_review">';
				$prosconsRow .= __('+ PROS:', 'rehub_framework');
				$prosconsRow .= '</label><br /><textarea id="pros_review" name="pros_review" rows="5" cols="50">';
				$prosconsRow .= esc_attr( $pros_review );
				$prosconsRow .= '</textarea></td><td colspan="2"><label for="cons_review">';
				$prosconsRow .= __('- CONS:', 'rehub_framework');
				$prosconsRow .= '</label><br /><textarea id="cons_review" name="cons_review" rows="5" cols="50">';
				$prosconsRow .= esc_attr( $cons_review );
				$prosconsRow .= '</textarea></td></tr>';
			}
			
			if( is_array($userCriteria) && !empty($userCriteria) ) {
				$criteriaRow = '<tr>';
				for( $i = 0; $i < count($userCriteria); $i++ ) {
					$criteriaRow .= '<td><label for="criteria_input_'. $i .'">'. $userCriteria[$i]['name'] .':</label><br />';
					$criteriaRow .= '<input type="hidden" name="user_criteria['.$i.'][name]" value="'. $userCriteria[$i]['name'] .'">';
					$criteriaRow .= '<input type="number" id="criteria_input_'. $i .'" name="user_criteria['.$i.'][value]" value="'. $userCriteria[$i]['value'] .'" min="1" max="10"></td>';
					$criteriaRow .= (is_int(($i+1)/4)) ? '</tr><tr>' : '';
				}
				$criteriaRow .= '</tr>';
			} 

			if(!empty($userCriteria) || !empty($pros_review) || !empty($cons_review)){
				echo '<fieldset>',
					'<table class="form-table editcomment">',
						'<tbody>',
							$prosconsRow,
							$criteriaRow,
						'</tbody></table><br>',
					'</fieldset>';	
			}	
		}


	}
}

/* Update Total score of the Post and the Comment */
if( !function_exists('rh_update_post_rating') ) {
	function rh_update_post_rating( $comment_id ) {
		$comment = get_comment( $comment_id );
		$comment_id = $comment->comment_ID;
		$comment_post_id = $comment->comment_post_ID;
		$postUserRaitingsArray = get_post_meta($comment_post_id, 'post_user_raitings', false);
		$postUserRaitings = $postUserRaitingsArray[0];
		$commentRaitingsArray = get_comment_meta($comment_id, 'user_criteria', false);
		$commentRaitings = $commentRaitingsArray[0];
		$postData = array();
		$postCriteriaAverage = $postAverage = $commentTotal = '';
		
		for($i = 0; $i < count($commentRaitings); $i++) {
			$postData['criteria'][$i]['name'] = $commentRaitings[$i]['name'];
			if(isset($postUserRaitings['criteria'][$i])) {
				$count = (int) $postUserRaitings['criteria'][$i]['count'] + 1;
				$total = (float) $commentRaitings[$i]['value'] + (float) $postUserRaitings['criteria'][$i]['value'];
				$postData['criteria'][$i]['count'] = $count;
				$postData['criteria'][$i]['value'] = $total;
				$postData['criteria'][$i]['average'] = bcdiv($total, $count, 1);
			}
			else {
				$postData['criteria'][$i]['count'] = 1;
				$postData['criteria'][$i]['value'] = (float) $commentRaitings[$i]['value'];
				$postData['criteria'][$i]['average'] = (float) $commentRaitings[$i]['value'];
			};
			$postCriteriaAverage += $postData['criteria'][$i]['average'];
			$commentTotal += $commentRaitings[$i]['value'];
		};

		if( isset($commentRaitings) && count($commentRaitings) > 0 ) {
			$postAverage = bcdiv($postCriteriaAverage, count($commentRaitings), 1);
			$commentAverage = bcdiv($commentTotal, count($commentRaitings), 1); 
			update_post_meta($comment_post_id, 'post_user_raitings', $postData);
			update_post_meta($comment_post_id, 'post_user_average', $postAverage);
			update_comment_meta($comment_id, 'user_average', $commentAverage);
			update_comment_meta($comment_id, 'counted', 1);
			if(rehub_option('type_total_score')=='average'){
				$editorrate = get_post_meta($comment_post_id, 'rehub_review_editor_score', true);
				if($editorrate){
					$overallupdate = ($editorrate + $postAverage) / 2;
					update_post_meta($comment_post_id, 'rehub_review_overall_score', $overallupdate);
				}
			}
			elseif(rehub_option('type_total_score')=='user'){
				update_post_meta($comment_post_id, 'rehub_review_overall_score', $postAverage);
			}			
		}
	}
}

?>