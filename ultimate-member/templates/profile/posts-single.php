<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
	<?php while ($ultimatemember->shortcodes->loop->have_posts()) { $ultimatemember->shortcodes->loop->the_post(); $post_id = get_the_ID(); ?>

		<div class="um-item">			
			
			<?php if ( has_post_thumbnail( $post_id ) ) {
					$image_id = get_post_thumbnail_id( $post_id );
					$image_url = wp_get_attachment_image_src( $image_id, 'full', true );
			?>
			
			<div class="um-item-img"><a href="<?php the_permalink(); ?>"><?php echo get_the_post_thumbnail( $post_id, 'med_thumbs' ); ?></a></div>
			
			<?php } ?>

			<div class="um-item-link"><i class="um-icon-ios-paper"></i><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
			
			<div class="um-item-meta">
				<span><?php echo sprintf(__('%s ago','rehub_framework'), human_time_diff( get_the_time('U'), current_time('timestamp') ) ); ?></span>
				<?php if(get_post_type() == 'post') :?><span><?php _e('in:', 'rehub_framework');?> <?php the_category( ', ' ); ?></span><?php endif;?>
				<span class="com-right"><i class="fa fa-comments-o"></i>&nbsp;<?php comments_number( '0', '1', '%' ); ?></span>
			</div>
		</div>
		
	<?php } ?>
	
	<?php if ( isset($ultimatemember->shortcodes->modified_args) && $ultimatemember->shortcodes->loop->have_posts() && $ultimatemember->shortcodes->loop->found_posts >= 10 ) { ?>
	
		<div class="um-load-items">
			<a href="#" class="um-ajax-paginate um-button" data-hook="um_load_posts" data-args="<?php echo $ultimatemember->shortcodes->modified_args; ?>"><?php _e('load more posts','ultimatemember'); ?></a>
		</div>
		
	<?php } ?>