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
	$reviewCriteria = rehub_option('rehub_user_rev_criterias');
	$reviewCriteria = explode(',', $reviewCriteria);
	$reviewType = get_post_meta(get_the_ID(), 'rehub_framework_post_type', true);
	if($reviewType == 'review' && $reviewCriteria[0] !='') {
		wp_enqueue_style('jquery.nouislider'); 
		wp_enqueue_script('jquery.nouislider'); 
		$criteriaNamesArray = array();
		$criteriaInputs = '<div id="user_reviews_in_comment"><div class="user_rating_left_com">';
		for($i = 0; $i < count($reviewCriteria); $i++) {
			$criteriaNamesArray[$i] = $reviewCriteria[$i];
			$criteriaInputs .= '<label for="criteria_input_'.$i.'">'.$reviewCriteria[$i].'</label>';
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


if( !function_exists('rehub_get_overall_score') ) {
function rehub_get_overall_score(){
	$total_score = 0;
	$userAverage = get_post_meta(get_the_ID(), 'post_user_average', true);
	if ($userAverage !='0' && $userAverage !='' ) {
		$total_score = $userAverage;
	}
	return $total_score;
}
}


if( !function_exists('rehub_get_review') ) {
function rehub_get_review(){
    ?>
    <?php $postAverage = get_post_meta(get_the_ID(), 'post_user_average', true); ?>
    <?php $user_rates = get_post_meta(get_the_ID(), 'post_user_raitings', true); if (!empty ($user_rates)) {$usercriterias = $user_rates['criteria'];}  ?>
    <?php if ($postAverage !='0' && $postAverage !='') :?>	
	<div class="rate_bar_wrap only_user_reviews<?php if (rehub_option('color_type_review') == 'multicolor') {echo ' colored_rate_bar';} ?>">	
		<span class="user-reviews-title"><?php the_title () ;?></span>
		<div class="total-score-users-head">				
			<div class="review-top">		
				<div class="overall-score">
					<span>	
						<span class="overall r_score_<?php echo round($postAverage); ?>"><?php echo round($postAverage, 1) ?></span>
						<span class="overall-text"><?php _e('Total Score', 'rehub_framework'); ?></span>
					</span>
				</div>
				<div class="overall-votes"><span><?php echo $user_rates['criteria'][0]['count'] ;?></span> <?php _e('reviews', 'rehub_framework'); ?></div>	
				<a href="#respond" class="rehub_scroll add_user_review_link"><?php _e("Add your review", "rehub_framework"); ?></a>					
			</div>
		</div>	
		<div class="review-criteria user-review-criteria">
			<div class="r_criteria">
				<?php foreach ($usercriterias as $usercriteria) { ?>
				<?php $perc_criteria = $usercriteria['average']*10; ?>
				<div class="rate-bar user-rate-bar clearfix" data-percent="<?php echo $perc_criteria; ?>%">
					<div class="rate-bar-title"><span><?php echo $usercriteria['name']; ?></span></div>
					<div class="rate-bar-bar r_score_<?php echo round($usercriteria['average']); ?>"></div>
					<div class="rate-bar-percent"><?php echo $usercriteria['average']; ?></div>
				</div>
				<?php } ?>
			</div>
		</div>	
	</div>
	<?php endif ;?>						  					

<?php
}
}



?>