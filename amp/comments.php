<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php
if (!comments_open()) {
  return;
} 
?>
<div class="ampforwp-comment-wrapper">
<?php
	global $redux_builder_amp;
	// Gather comments for a specific page/post
	$postID = get_the_ID();
	$comments = get_comments(array(
			'post_id' => $postID,
			'status' => 'approve' //Change this to the type of comments to be displayed
	));
	if ( $comments ) { ?>
		<div class="rh_comments_list">
            <div class="rehub-main-font font120 fontbold mb15"><?php global $redux_builder_amp; echo $redux_builder_amp['amp-translator-view-comments-text'] ?></div>
            <ul>
					<?php
					// Display the list of comments
				function ampforwp_custom_translated_comment($comment, $args, $depth){
									$GLOBALS['comment'] = $comment;
									global $redux_builder_amp;
									?>
									<li id="li-comment-<?php comment_ID() ?>"
									<?php comment_class(); ?> >
										<article id="comment-<?php comment_ID(); ?>" class="comment-body">
											<footer class="comment-meta">
												<div class="comment-author vcard">
													 <?php
													 printf(__('<b class="fn">%s</b> <span class="says">'.$redux_builder_amp['amp-translator-says-text'].':</span>'), get_comment_author_link()) ?>
												</div>
												<!-- .comment-author -->
												<div class="comment-metadata">
													<a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
														<?php
														printf(__('%1$s '.$redux_builder_amp['amp-translator-at-text'].' %2$s'), get_comment_date(),  get_comment_time())
														?>
													</a>
													<?php edit_comment_link(__('('.$redux_builder_amp['amp-translator-Edit-text'].')'),'  ','') ?>
												</div>
												<!-- .comment-metadata -->
											</footer>
												<!-- .comment-meta -->
											<div class="comment-content">
												<p><?php echo get_comment_text(); ?></p>
											</div>

											<?php     
												$userCriteria = get_comment_meta(get_comment_ID(), 'user_criteria', true);	
												$pros_review = get_comment_meta(get_comment_ID(), 'pros_review', true);
												$cons_review = get_comment_meta(get_comment_ID(), 'cons_review', true);
											    $userAverage = get_comment_meta(get_comment_ID(), 'user_average', true);
											?>
											<?php if(is_array($userCriteria) && !empty($userCriteria)):?>

												<div class="comment-content-review">
													<?php if(isset($userAverage) && $userAverage != ''):?>
														<div class="user_reviews_average">
															<span class="floatleft">
																<?php _e('Overall:', 'rehub_framework');?>
															</span>
															<span class="floatright">
																<span><?php echo $userAverage;?></span> / 10
															</span>
														</div>
													<?php endif;?>
													<?php	
														for($i = 0; $i < count($userCriteria); $i++) {
															$value_criteria = $userCriteria[$i]['value'];		
															echo '<div class="user_reviews_view_criteria_line"><span class="user_reviews_view_criteria_name floatleft">'.$userCriteria[$i]['name'].'</span><div class="userstar-rating floatright"><strong class="rating">'.$value_criteria.'</strong> / 10</div><div class="rate-bar user-review-criteria"><div class="rate-bar-bar r_score_'.$value_criteria.'"></div></div></div>';
														};
													?>
													<?php 
													if(isset($pros_review) && $pros_review != '') {
														$pros_reviews = explode(PHP_EOL, $pros_review);
														$proscomment = '';
														foreach ($pros_reviews as $pros) {
															$proscomment .= '<li class="pros_comment_item">'.$pros.'</li>';
														}
														echo '<div class="user_reviews_view_pros"><span class="user_reviews_view_pc_title mb5">'.__('+ PROS:', 'rehub_framework').' </span><ul>'.$proscomment.'</ul></div>';
													};
													if(isset($cons_review) && $cons_review != '') {
														$cons_reviews = explode(PHP_EOL, $cons_review);
														$conscomment = '';
														foreach ($cons_reviews as $cons) {
															$conscomment .='<li class="cons_comment_item">'.$cons.'</li>';
														}			
														echo '<div class="user_reviews_view_cons"><span class="user_reviews_view_pc_title mb5">'.__('- CONS:', 'rehub_framework').'</span><ul>'.$conscomment.'</ul></div>';
													};
													?>													
												</div>

											<?php endif;?>											
												<!-- .comment-content -->
										</article>
									 <!-- .comment-body -->
									</li>
								<!-- #comment-## -->
									<?php
								}// end of ampforwp_custom_translated_comment()

				wp_list_comments( array(
				  'per_page' 			=> 10, //Allow comment pagination
				  'style' 				=> 'li',
				  'type'				=> 'comment',
				  'max_depth'   		=> 5,
				  'avatar_size'			=> 0,
					'callback'				=> 'ampforwp_custom_translated_comment',
				  'reverse_top_level' 	=> true //Show the latest comments at the top of the list
				), $comments);  ?>
		    </ul>
		</div>
		<div class="comment-button-wrapper">
		    <a href="<?php echo get_permalink().'#commentform' ?>"><?php esc_html_e( $redux_builder_amp['amp-translator-leave-a-comment-text']  ); ?></a>
		</div>
    <?php } else {
       global $redux_builder_amp ;
       if (!comments_open()) {
         return;
       } ?>
       <div class="comment-button-wrapper">
	        <a href="<?php echo get_permalink().'#commentform' ?>"><?php esc_html_e( $redux_builder_amp['amp-translator-leave-a-comment-text']  ); ?></a>
        </div>
<?php  } ?>
</div>
