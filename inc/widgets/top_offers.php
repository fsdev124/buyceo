<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php
/**
 * Plugin Name: News Widget
 */

add_action( 'widgets_init', 'rehub_top_offers_load_widget' );

function rehub_top_offers_load_widget() {
	register_widget( 'rehub_top_offers_widget' );
}

class rehub_top_offers_widget extends WP_Widget {

    function __construct() {
		$widget_ops = array( 'classname' => 'top_offers', 'description' => __('Widget displays top offers. Use only in sidebar!', 'rehub_framework') );
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'rehub_top_offers' );
        parent::__construct('rehub_top_offers', __('ReHub: Top Offers', 'rehub_framework'), $widget_ops, $control_ops );
    }

/**
 * How to display the widget on the screen.
 */
function widget( $args, $instance ) {
	extract( $args );

	/* Our variables from the widget settings. */
	$title = apply_filters('widget_title', $instance['title'] );
	$tags = (!empty($instance['tags'])) ? $instance['tags'] : '';
	$order = (!empty($instance['order'])) ? $instance['order'] : '';
	$number = (!empty($instance['number'])) ? $instance['number'] : '';
	$post_type = (!empty($instance['post_type'])) ? $instance['post_type'] : '';
	$random = (!empty($instance['random'])) ? $instance['random'] : '';
	$orderby = (!empty($instance['orderby'])) ? $instance['orderby'] : '';
	
	/* Before widget (defined by themes). */
	echo $before_widget;

	/* Display the widget title if one was input (before and after defined by themes). */
	if ( $title )
		echo '<div class="title">' . $title . '</div>';
	?>

	    <?php if ($post_type == 'post') :?>
	    	<?php rehub_top_offers_widget_block_post($tags, $number, $order, $random, $orderby);?>
	    <?php elseif ($post_type == 'woo' && class_exists('Woocommerce')):?>
	    	<?php rehub_top_offers_widget_block_woo($tags, $number, $order, $random, $orderby);?>
	    <?php else : ?> 	              
	    	<?php rehub_top_offers_widget_block_post($tags, $number, $order, $random, $orderby);?>
	    <?php endif ;?>	

			
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
		$instance['tags'] = strip_tags($new_instance['tags']);
		$instance['order'] = strip_tags($new_instance['order']);
		$instance['number'] = strip_tags( $new_instance['number'] );
		$instance['post_type'] = $new_instance['post_type'];
		$instance['random'] =  $new_instance['random'];
		$instance['orderby'] =  $new_instance['orderby'];

		return $instance;
	}


	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Top offers', 'rehub_framework'), 'number' => 5, 'tag' => '', 'post_type' => 'post', 'order' => '', 'tags' =>'', 'random' =>'', 'orderby'=> 'DESC');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title of widget:', 'rehub_framework'); ?></label>
			<input  type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>"  />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e('Number of posts to show:', 'rehub_framework'); ?></label>
			<input  type="text" class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" value="<?php echo $instance['number']; ?>" size="3" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id('post_type'); ?>"><?php _e('Widget is based on:', 'rehub_framework');?></label> 
		<select id="<?php echo $this->get_field_id('post_type'); ?>" name="<?php echo $this->get_field_name('post_type'); ?>" style="width:100%;">
			<option value="post" <?php if ( 'post' == $instance['post_type'] ) : echo 'selected="selected"'; endif; ?>><?php _e('Posts', 'rehub_framework');?></option>
			<option value="woo" <?php if ( 'woo' == $instance['post_type'] ) : echo 'selected="selected"'; endif; ?>><?php _e('Woocommerce', 'rehub_framework');?></option>			
		</select>
		</p>

		<p><em><?php _e('If you select Widget base on posts or woocommerce, enter tag slug in field below. Also, you can set name of meta key for ordering or show random products', 'rehub_framework');?></em></p>

		<p>
			<label for="<?php echo $this->get_field_id( 'tags' ); ?>"><?php _e('Enter tag slug:', 'rehub_framework'); ?></label>
			<input  type="text" class="widefat" id="<?php echo $this->get_field_id( 'tags' ); ?>" name="<?php echo $this->get_field_name( 'tags' ); ?>" value="<?php echo $instance['tags']; ?>"  />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php _e('Meta key name for ordering:', 'rehub_framework'); ?></label>
			<input  type="text" class="widefat" id="<?php echo $this->get_field_id( 'order' ); ?>" name="<?php echo $this->get_field_name( 'order' ); ?>" value="<?php echo $instance['order']; ?>"  />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id('orderby'); ?>"><?php _e('Order for field above:', 'rehub_framework');?></label> 
		<select id="<?php echo $this->get_field_id('orderby'); ?>" name="<?php echo $this->get_field_name('orderby'); ?>" style="width:100%;">
			<option value="DESC" <?php if ( 'DESC' == $instance['orderby'] ) : echo 'selected="selected"'; endif; ?>><?php _e('DESC', 'rehub_framework');?></option>		
			<option value="ASC" <?php if ( 'ASC' == $instance['orderby'] ) : echo 'selected="selected"'; endif; ?>><?php _e('ASC', 'rehub_framework');?></option>		
		</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'random' ); ?>"><?php _e('Show random?', 'rehub_framework'); ?></label>
			<input id="<?php echo $this->get_field_id( 'random' ); ?>" name="<?php echo $this->get_field_name( 'random' ); ?>" value="true" <?php if( $instance['random'] ) echo 'checked="checked"'; ?> type="checkbox" />
		</p>				

	<?php
	}
}

?>