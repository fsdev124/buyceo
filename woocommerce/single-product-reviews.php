<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $product;

$review_count 		= $product->get_review_count();
$avg_rate_score 	= number_format( $product->get_average_rating(), 1 );
$rate_counts 		= WPSM_Woohelper::get_ratings_counts( $product );

if ( ! comments_open() ) {
	return;
}

?>
<div id="reviews" class="woocommerce-Reviews">
	<div class="woo-left-rev-part wpsm-one-half">
		<h2 class="woocommerce-Reviews-title"><?php
			if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' && ( $count = $product->get_review_count() ) )
				printf( _n( '%s review for %s%s%s', '%s reviews for %s%s%s', $count, 'rehub_framework' ), $count, '<span>', get_the_title(), '</span>' );
			else
				_e( 'Reviews', 'rehub_framework' );
		?></h2>
		<div class="woo-avg-rating">
			<h5><?php echo $avg_rate_score;?></h5>
		</div>
		<div class="woo-rating-bars">
			<?php for( $rating = 5; $rating > 0; $rating-- ) : ?>
			<div class="rating-bar">
				<div class="star-rating-wrap">
					<div class="star-rating" title="<?php printf( __( 'Rated %s out of 5', 'rehub_framework' ), $rating ); ?>">
						<span style="width:<?php echo ( ( $rating / 5 ) * 100 ); ?>%"></span>
					</div>				
				</div>
				<?php 
					$rating_percentage = 0;
					if ( isset( $rate_counts[$rating] ) ) {
						$rating_percentage = (round( $rate_counts[$rating] / $review_count, 2 ) * 100 );
					}
				?>
				<div class="rating-percentage-bar-wrap">
					<div class="rating-percentage-bar">
						<span style="width:<?php echo esc_attr( $rating_percentage ); ?>%" class="rating-percentage"></span>
					</div>
				</div>
				<?php if ( isset( $rate_counts[$rating] ) ) : ?>
				<div class="rating-count"><?php echo esc_html( $rate_counts[$rating] ); ?></div>
				<?php else : ?>
				<div class="rating-count zero">0</div>
				<?php endif; ?>
			</div>
			<?php endfor; ?>
		</div>				
	</div>
	<div class="woo-right-rev-part wpsm-one-half wpsm-column-last">
		<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>

			<div id="review_form_wrapper">
				<div id="review_form">
					<?php
						$commenter = wp_get_current_commenter();

						$comment_form = array(
							'title_reply'          => have_comments() ? __( 'Add a review', 'rehub_framework' ) : sprintf( __( 'Be the first to review &ldquo;%s&rdquo;', 'rehub_framework' ), get_the_title() ),
							'title_reply_to'       => __( 'Leave a Reply', 'rehub_framework' ),
							'comment_notes_after'  => '',
							'fields'               => array(
								'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name', 'rehub_framework' ) . ' <span class="required">*</span></label> ' .
								            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" required /></p>',
								'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email', 'rehub_framework' ) . ' <span class="required">*</span></label> ' .
								            '<input id="email" name="email" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-required="true" required /></p>',
							),
							'label_submit'  => __( 'Submit', 'rehub_framework' ),
							'logged_in_as'  => '',
							'comment_field' => ''
						);

						if ( $account_page_url = wc_get_page_permalink( 'myaccount' ) ) {
							$comment_form['must_log_in'] = '<p class="must-log-in">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a review.', 'rehub_framework' ), esc_url( $account_page_url ) ) . '</p>';
						}

						if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
							$usercomment = '';
							if(is_user_logged_in()){
								$currentuser = get_current_user_id();
								$usercomment = get_comments(array('user_id' => $currentuser, 'post_id' => $product->get_id()));								
							}
							else{
								$commentemail = (!empty($commenter['comment_author_email'])) ? $commenter['comment_author_email'] : '';
								if($commentemail){
									$usercomment = get_comments(array('author_email' => $commentemail, 'post_id' => $product->get_id()));				
								}								
							}
							if(empty($usercomment)){
								$comment_form['comment_field'] = '<p class="comment-form-rating"><label for="rating">' . __( 'Your Rating', 'rehub_framework' ) .'</label><select name="rating" id="rating" aria-required="true" required>
									<option value="">' . __( 'Rate&hellip;', 'rehub_framework' ) . '</option>
									<option value="5">' . __( 'Perfect', 'rehub_framework' ) . '</option>
									<option value="4">' . __( 'Good', 'rehub_framework' ) . '</option>
									<option value="3">' . __( 'Average', 'rehub_framework' ) . '</option>
									<option value="2">' . __( 'Not that bad', 'rehub_framework' ) . '</option>
									<option value="1">' . __( 'Very Poor', 'rehub_framework' ) . '</option>
								</select></p>';								
							}

						}

						$comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . __( 'Your Review', 'rehub_framework' ) . ' <span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" required></textarea></p>';

						comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
					?>
				</div>
			</div>
		<?php else : ?>
			<p class="woocommerce-verification-required"><?php _e( 'Only logged in customers who have purchased this product may leave a review.', 'rehub_framework' ); ?></p>
		<?php endif; ?>		
	</div>


	<div id="comments">

		<?php if ( have_comments() ) : ?>

			<ol class="commentlist">
				<?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
			</ol>

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
				echo '<nav class="woocommerce-pagination">';
				paginate_comments_links( apply_filters( 'woocommerce_comment_pagination_args', array(
					'prev_text' => '&larr;',
					'next_text' => '&rarr;',
					'type'      => 'list',
				) ) );
				echo '</nav>';
			endif; ?>

		<?php else : ?>

			<p class="woocommerce-noreviews"><?php _e( 'There are no reviews yet.', 'rehub_framework' ); ?></p>

		<?php endif; ?>
	</div>



	<div class="clear"></div>
</div>
