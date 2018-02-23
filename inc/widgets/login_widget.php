<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php
/**
 * Plugin Name: News Widget
 */

add_action( 'widgets_init', 'rehub_login_widget_load_widget' );

function rehub_login_widget_load_widget() {
	register_widget( 'rehub_login_widget_widget' );
}

class rehub_login_widget_widget extends WP_Widget {

    function __construct() {
		$widget_ops = array( 'classname' => 'login_widget', 'description' => __('Widget that displays advanced meta area. Use only in sidebar!', 'rehub_framework') );
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'rehub_login_widget' );
        parent::__construct('rehub_login_widget', __('ReHub: Login', 'rehub_framework'), $widget_ops, $control_ops);
    }

/**
 * How to display the widget on the screen.
 */
function widget( $args, $instance ) {
	extract( $args );

	/* Our variables from the widget settings. */
	$title = apply_filters('widget_title', $instance['title'] );
	
	/* Before widget (defined by themes). */
	echo $before_widget;

	/* Display the widget title if one was input (before and after defined by themes). */
	if ( $title )
		echo '<div class="title">' . $title . '</div>';

	?>
	
		<?php rehub_login_form();?>	
		
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
		$defaults = array( 'title' => __('Login area', 'rehub_framework'));
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
	
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title of widget:', 'rehub_framework'); ?></label>
			<input  type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>"  />
		</p>

	<?php
	}
}

?>