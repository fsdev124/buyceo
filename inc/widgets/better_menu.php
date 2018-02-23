<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php
/**
 * Plugin Name: News Widget
 */

add_action( 'widgets_init', 'rehub_better_menu_load_widget' );

function rehub_better_menu_load_widget() {
	register_widget( 'rehub_better_menu_widget' );
}

class rehub_better_menu_widget extends WP_Widget {

    function __construct() {
        $widget_ops = array( 'classname' => 'better_menu', 'description' => __('Widget displays menu in good way. ', 'rehub_framework') );
        $control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'rehub_better_menu' );
        parent::__construct('rehub_better_menu', __('ReHub: Better menu', 'rehub_framework'), $widget_ops, $control_ops );
    }


/**
 * How to display the widget on the screen.
 */
function widget( $args, $instance ) {
	extract( $args );

	/* Our variables from the widget settings. */
	$type = $colored = '';
	$title = apply_filters('widget_title', $instance['title'] );
	$icon = $instance['icon'];
	$type = $instance['type'];
	if ($type =='red' || $type =='red' || $type =='blue' || $type =='orange' || $type =='green' || $type =='violet') {$colored=' colored_menu_widget';}
	if ($icon =='heart') {
		$title_icon = '<i class="fa fa-heart"></i>';
	} 
	elseif ($icon =='life-ring') {
		$title_icon = '<i class="fa fa-life-ring"></i>';
	} 
	elseif ($icon =='diamond') {
		$title_icon = '<i class="fa fa-diamond"></i>';
	}
	elseif ($icon =='flash') {
		$title_icon = '<i class="fa fa-flash"></i>';
	}
	elseif ($icon =='info') {
		$title_icon = '<i class="fa fa-info-circle"></i>';
	}	
	elseif ($icon =='star') {
		$title_icon = '<i class="fa fa-star"></i>';
	}
	else {$title_icon = '';}			 
	$nav_menu = wp_get_nav_menu_object( $instance['nav_menu'] ); // Get menu
	
	/* Before widget (defined by themes). */
	echo $before_widget;

	echo '<div class="'.$type.'_menu_widget'.$colored.'">';

	/* Display the widget title if one was input (before and after defined by themes). */
	if ( $title )
		echo '<div class="title">' . $title_icon . $title . '</div>';		
	?>

	    <?php if (!empty ($nav_menu)) :?>
	    	<?php wp_nav_menu( array( 'fallback_cb' => '', 'menu' => $nav_menu, 'container' => false  ) );?>
	    <?php endif ;?>	

			
	<?php

	echo '</div>';

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
		$instance['icon'] = $new_instance['icon'];
		$instance['type'] = $new_instance['type'];
		$instance['nav_menu'] = (int) $new_instance['nav_menu'];

		return $instance;
	}


	function form( $instance ) {

		/* Set up some default widget settings. */
		$instance['title'] = isset( $instance['title'] ) ? $instance['title'] : '';
		$nav_menu = isset( $instance['nav_menu'] ) ? $instance['nav_menu'] : '';
		$instance['icon'] = isset( $instance['icon'] ) ? $instance['icon'] : 'none';
		$instance['type'] = isset( $instance['type'] ) ? $instance['type'] : 'simple';		
		
		// Get menus
		$menus = wp_get_nav_menus();

		// If no menus exists, direct the user to create some.
		if ( !$menus ) {
			echo '<p>'. sprintf( __('No menus have been created yet. <a href="%s">Create some</a>.', 'rehub_framework'), admin_url('nav-menus.php') ) .'</p>';
			return;
		}

		?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title of widget:', 'rehub_framework'); ?></label>
			<input  type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>"  />
		</p>


		<p>
		<label for="<?php echo $this->get_field_id('icon'); ?>"><?php _e('Icon before title:', 'rehub_framework');?></label> 
		<select id="<?php echo $this->get_field_id('icon'); ?>" name="<?php echo $this->get_field_name('icon'); ?>" style="width:100%;">
			<option value="none" <?php if ( 'none' == $instance['icon'] ) : echo 'selected="selected"'; endif; ?>><?php _e('No icon', 'rehub_framework');?></option>
			<option value="heart" <?php if ( 'heart' == $instance['icon'] ) : echo 'selected="selected"'; endif; ?>><?php _e('Heart', 'rehub_framework');?></option>
			<option value="life-ring" <?php if ( 'life-ring' == $instance['icon'] ) : echo 'selected="selected"'; endif; ?>><?php _e('Life Ring', 'rehub_framework');?></option>
			<option value="diamond" <?php if ( 'diamond' == $instance['icon'] ) : echo 'selected="selected"'; endif; ?>><?php _e('Diamond', 'rehub_framework');?></option>
			<option value="flash" <?php if ( 'flash' == $instance['icon'] ) : echo 'selected="selected"'; endif; ?>><?php _e('Flash', 'rehub_framework');?></option>
			<option value="info" <?php if ( 'info' == $instance['icon'] ) : echo 'selected="selected"'; endif; ?>><?php _e('Info', 'rehub_framework');?></option>
			<option value="star" <?php if ( 'star' == $instance['icon'] ) : echo 'selected="selected"'; endif; ?>><?php _e('Star', 'rehub_framework');?></option>
		</select>
		</p>

		<p>
		<label for="<?php echo $this->get_field_id('type'); ?>"><?php _e('Design of widget box:', 'rehub_framework');?></label> 
		<select id="<?php echo $this->get_field_id('type'); ?>" name="<?php echo $this->get_field_name('type'); ?>" style="width:100%;">
			<option value="simple" <?php if ( 'simple' == $instance['type'] ) : echo 'selected="selected"'; endif; ?>><?php _e('Simple', 'rehub_framework');?></option>
			<option value="bordered" <?php if ( 'bordered' == $instance['type'] ) : echo 'selected="selected"'; endif; ?>><?php _e('Bordered', 'rehub_framework');?></option>
			<option value="red" <?php if ( 'red' == $instance['type'] ) : echo 'selected="selected"'; endif; ?>><?php _e('Red', 'rehub_framework');?></option>
			<option value="green" <?php if ( 'green' == $instance['type'] ) : echo 'selected="selected"'; endif; ?>><?php _e('Green', 'rehub_framework');?></option>
			<option value="blue" <?php if ( 'blue' == $instance['type'] ) : echo 'selected="selected"'; endif; ?>><?php _e('Blue', 'rehub_framework');?></option>
			<option value="orange" <?php if ( 'orange' == $instance['type'] ) : echo 'selected="selected"'; endif; ?>><?php _e('Orange', 'rehub_framework');?></option>
			<option value="violet" <?php if ( 'star' == $instance['type'] ) : echo 'selected="selected"'; endif; ?>><?php _e('Violet', 'rehub_framework');?></option>
		</select>
		</p>

		<p><label for="<?php echo $this->get_field_id('nav_menu'); ?>"><?php _e('Select Menu:', 'rehub_framework'); ?></label>
			<select id="<?php echo $this->get_field_id('nav_menu'); ?>" name="<?php echo $this->get_field_name('nav_menu'); ?>">
				<option value="0"><?php _e( '&mdash; Select &mdash;', 'rehub_framework' ) ?></option>
		<?php
			foreach ( $menus as $menu ) {
				echo '<option value="' . $menu->term_id . '"'
					. selected( $nav_menu, $menu->term_id, false )
					. '>'. esc_html( $menu->name ) . '</option>';
			}
		?>
			</select>
		</p>				

	<?php
	}
}

?>