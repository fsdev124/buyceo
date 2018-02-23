<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php
/**
 * Plugin Name: News Widget
 */

add_action( 'widgets_init', 'rehub_facebook_widget_load_widget' );

function rehub_facebook_widget_load_widget() {
	register_widget( 'rehub_facebook_widget_widget' );
}

class rehub_facebook_widget_widget extends WP_Widget {

    function __construct() {
        $widget_ops = array( 'classname' => 'facebook_widget', 'description' => __('Widget that displays facebook widget. Use only in sidebar!', 'rehub_framework') );
        $control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'rehub_facebook_widget' );
        parent::__construct('rehub_facebook_widget', __('ReHub: Facebook widget', 'rehub_framework'), $widget_ops, $control_ops);
    }

/**
 * How to display the widget on the screen.
 */
function widget( $args, $instance ) {
	extract( $args );

	/* Our variables from the widget settings. */
	$color = 'light';
	if( !empty($instance['dark']) ) $color = 'dark';
	$title = apply_filters('widget_title', $instance['title'] );
	$page_url = $instance['page_url'];

	
	/* Before widget (defined by themes). */
	echo $before_widget;

	/* Display the widget title if one was input (before and after defined by themes). */
	if ( $title )
		echo '<div class="title">' . $title . '</div>';
	?>	
		<div class="facebook-box">
			<iframe src="//www.facebook.com/plugins/likebox.php?href=<?php echo $page_url ?>&amp;width=270&amp;height=250&amp;colorscheme=<?php echo $color; ?>&amp;show_faces=true&amp;header=false&amp;stream=false&amp;show_border=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:270px; height:250px;" allowTransparency="true"></iframe>
		</div>	
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
		$instance['page_url'] = strip_tags( $new_instance['page_url'] );
		$instance['dark'] = strip_tags( $new_instance['dark'] );

		return $instance;
	}


	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Find us on Facebook', 'rehub_framework'), 'dark' =>'', 'page_url' => '');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title of widget:', 'rehub_framework'); ?></label>
			<input  type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>"  />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'page_url' ); ?>"><?php _e('Page Url:', 'rehub_framework'); ?></label>
			<input id="<?php echo $this->get_field_id( 'page_url' ); ?>" name="<?php echo $this->get_field_name( 'page_url' ); ?>" value="<?php echo $instance['page_url']; ?>" class="widefat" type="text" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'dark' ); ?>"><?php _e('Dark Skin ?', 'rehub_framework'); ?></label>
			<input id="<?php echo $this->get_field_id( 'dark' ); ?>" name="<?php echo $this->get_field_name( 'dark' ); ?>" value="true" <?php if( $instance['dark'] ) echo 'checked="checked"'; ?> type="checkbox" />
		</p>


	<?php
	}
}

?>