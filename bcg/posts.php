<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
	<?php
	/*
	This page is used for group blog home page/categories archives*/
	?>
	<?php $q = new WP_Query( bcg_get_query() );?>
	<?php if ($q->have_posts() ) : ?>
	<?php do_action( 'bp_before_group_blog_content' ) ?>
	<div class="pagination no-ajax">
		<div id="posts-count" class="pag-count">
			<?php bcg_posts_pagination_count( $q ) ?>
		</div>

		<div id="posts-pagination" class="pagination-links">
			<?php bcg_pagination( $q ) ?>
		</div>
	</div>

	<?php do_action( 'bp_before_group_blog_list' ) ?>
<?php
	global $post;
	bcg_loop_start();//please do not remove it
	while( $q->have_posts() ):$q->the_post();
 ?>
 	<?php include(rh_locate_template('inc/parts/query_type1.php')); ?>

	<?php endwhile;?>
	<?php 
        do_action( 'bp_after_group_blog_content' ) ;
        bcg_loop_end();//please do not remove it
	?>
	<div class="pagination no-ajax">
		<div id="posts-count" class="pag-count">
			<?php bcg_posts_pagination_count( $q ) ?>
		</div>

		<div id="posts-pagination" class="pagination-links">
			<?php bcg_pagination( $q ) ?>
		</div>
	</div>

<?php else: ?>

	<div id="message" class="info">
		<p><?php _e( 'This group has no Blog posts.', 'bcg' ); ?></p>
	</div>

<?php endif; ?>
