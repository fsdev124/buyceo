<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php
/**
 * Plugin Name: News Widget
 */

add_action( 'widgets_init', 'rehub_sticky_on_scroll_widget' );

function rehub_sticky_on_scroll_widget() {
	register_widget( 'rehub_sticky_on_scroll' );
}

class rehub_sticky_on_scroll extends WP_Widget {

    function __construct() {
		$widget_ops = array( 'classname' => 'stickyscroll_widget', 'description' => __('Widget that sticks after sidebar scroll. Use only in sidebar!', 'rehub_framework') );
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'rehub_sticky_on_scroll' );
        parent::__construct('rehub_sticky_on_scroll', __('ReHub: Sticky on scroll', 'rehub_framework'), $widget_ops, $control_ops  );
    }

/**
 * How to display the widget on the screen.
 */
function widget( $args, $instance ) {
	extract( $args );

	/* Our variables from the widget settings. */
	$title = apply_filters('widget_title', $instance['title'] );
	if( function_exists('icl_t') )  $text_code = icl_t( 'rehub_theme' , 'widget_content_'.$this->id , $instance['text_code'] ); else $text_code = $instance['text_code'] ;

	/* Before widget (defined by themes). */
	echo $before_widget;

	/* Display the widget title if one was input (before and after defined by themes). */
	if ( $title )
		echo '<div class="title">' . $title . '</div>';
	?>
	<?php echo do_shortcode( $text_code ); wp_enqueue_script('custom_scroll'); ?>

		
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
		$instance['text_code'] = $new_instance['text_code'] ;

		if (function_exists('icl_register_string')) {
			icl_register_string( 'rehub_theme' , 'widget_content_'.$this->id, $new_instance['text_code'] );
		}		

		return $instance;
	}


	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => '', 'text_code' => '');		
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p><em style="color:red;"><?php _e('Use this widget only once and only in sidebar area!', 'rehub_framework');?></em></p>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title of widget:', 'rehub_framework'); ?></label>
			<input  type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>"  />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'text_code' ); ?>"><?php _e('Text or Html code :', 'rehub_framework'); ?></label>
			<textarea rows="10" id="<?php echo $this->get_field_id( 'text_code' ); ?>" name="<?php echo $this->get_field_name( 'text_code' ); ?>" class="widefat" ><?php echo $instance['text_code']; ?></textarea>
		</p>		


	<?php
	}
}

?>