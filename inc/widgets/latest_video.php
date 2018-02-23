<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php
/**
 * Plugin Name: News Widget
 */

add_action( 'widgets_init', 'rehub_latest_videopost_load_widget' );

function rehub_latest_videopost_load_widget() {
	register_widget( 'rehub_latest_videopost_widget' );
}

class rehub_latest_videopost_widget extends WP_Widget {

    function __construct() {
		$widget_ops = array( 'classname' => 'video_widget', 'description' => __('Widget that displays latest video post. Use only in sidebar!', 'rehub_framework') );
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'rehub_latest_videopost' );
        parent::__construct('rehub_latest_videopost', __('ReHub: Latest Video post', 'rehub_framework'), $widget_ops, $control_ops);
    }

/**
 * How to display the widget on the screen.
 */
function widget( $args, $instance ) {
	extract( $args );

	/* Our variables from the widget settings. */
	$title = apply_filters('widget_title', $instance['title'] );

		$query = array('showposts' => 1, 'nopaging' => 0, 'post_status' => 'publish', 'ignore_sticky_posts' => 1, 'meta_key' => 'rehub_framework_post_type', 'meta_value' => 'video');
	
	$loop = new WP_Query($query);

	/* Before widget (defined by themes). */
	echo $before_widget;

	if ($loop->have_posts()) :

	/* Display the widget title if one was input (before and after defined by themes). */
	if ( $title )
		echo '<div class="title">' . $title . '</div>';

	?>		
		<?php  while ($loop->have_posts()) : $loop->the_post(); ?>
			<figure>
				<div class="pattern"></div>
				<a class="fa fa-play-circle vid_icon" href="<?php the_permalink();?>"></a><?php wpsm_thumb ('grid_news') ?>
          	</figure>
          	<h3><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>	
		<?php endwhile; ?>
		<?php wp_reset_query(); ?>
		<?php else: ?><?php _e('No posts for this criteria.', 'rehub_framework'); ?>
		<?php endif; ?>		
	<?php

	/* After widget (defined by themes). */
	echo $after_widget;
}


	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );

		return $instance;
	}


	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Latest Video', 'rehub_framework'));
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title of widget:', 'rehub_framework'); ?></label>
			<input  type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>"  />
		</p>


	<?php
	}
}

?>