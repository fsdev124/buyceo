<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php $post_type_show = (rehub_option('post_type_for_uu')) ? rehub_option('post_type_for_uu') : 'post';?>
<?php $ultimatemember->shortcodes->loop = $ultimatemember->query->make('post_type='.$post_type_show.'&posts_per_page=10&offset=0&author=' . um_user('ID') ); ?>

<?php if ( $ultimatemember->shortcodes->loop->have_posts()) { ?>
			
	<?php $ultimatemember->shortcodes->load_template('profile/posts-single'); ?>
	
	<div class="um-ajax-items">
	
		<!--Ajax output-->
		
		<?php if ( $ultimatemember->shortcodes->loop->found_posts >= 10 ) { ?>
		
		<div class="um-load-items">
			<a href="#" class="um-ajax-paginate um-button" data-hook="um_load_posts" data-args="<?php echo $post_type_show; ?>,10,10,<?php echo um_user('ID'); ?>"><?php _e('load more posts','rehub_framework'); ?></a>
		</div>
		
		<?php } ?>
		
	</div>
		
<?php } else { ?>

	<div class="um-profile-note"><span><?php echo ( um_profile_id() == get_current_user_id() ) ? __('You have not created any posts.','rehub_framework') : __('This user has not created any posts.','rehub_framework'); ?></span></div>
	
<?php } wp_reset_postdata(); ?>