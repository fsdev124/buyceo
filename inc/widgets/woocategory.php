<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php
/**
 * Plugin Name: News Widget
 */

add_action( 'widgets_init', 'rehub_better_woocat_load_widget' );

function rehub_better_woocat_load_widget() {
	register_widget( 'rehub_better_woocat_widget' );
}

class rehub_better_woocat_widget extends WP_Widget {

    function __construct() {
        $widget_ops = array( 'classname' => 'better_woocat', 'description' => __('Better categories (woocommerce). Use only in sidebar!', 'rehub_framework') );
        $control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'rehub_better_woocat' );
        parent::__construct('rehub_better_woocat', __('ReHub: Better woocommerce categories', 'rehub_framework'), $widget_ops, $control_ops);
    }

/**
 * How to display the widget on the screen.
 */
function widget( $args, $instance ) {

	/* Our variables from the widget settings. */
	$hideempty = (!empty($instance['hideempty'])) ? $instance['hideempty'] : '';
	$woocount = (!empty($instance['woocount'])) ? $instance['woocount'] : '';
	$showAllLabel = (!empty($instance['showAllLabel'])) ? esc_html($instance['showAllLabel']) : __( 'Show All Categories', 'rehub_framework' );
	$browseAllLabel = (!empty($instance['browseAllLabel'])) ? esc_html($instance['browseAllLabel']) : __( 'Browse Categories', 'rehub_framework' );
	$el_class = '';		
	global $wp_query, $post;

	$list_args	= array(
		'show_count' => $woocount,
		'taxonomy' => 'product_cat',
		'orderby' => 'id',
		'echo' => false,
		'hide_empty' => $hideempty
	);

	$current_category   = false;
	$current_parent_category = false;

	if ( is_tax( 'product_cat' ) ) {

		$current_category   = $wp_query->queried_object;
		$current_parent_category = $current_category->parent;

	} elseif ( is_singular( 'product' ) ) {

		$current_page_id = $wp_query->get_queried_object_id();
		$product_category = wc_get_product_terms( $current_page_id, 'product_cat', array( 'orderby' => 'parent' ) );

		if ( $product_category ) {
			$current_category   = end( $product_category );
			$current_parent_category = $current_category->parent;
		}

	}

	if ( $current_category ) {

		$el_class = 'category-single';

		// Top level is needed
		$top_level = wp_list_categories( array(
			'title_li'     => sprintf( '<span class="show-all-toggle">%1$s</span>', $showAllLabel ),
			'taxonomy'     => 'product_cat',
			'parent'       => 0,
			'hierarchical' => true,
			'hide_empty'   => false,
			'exclude'      => $current_category->term_id,
			'show_count'   => $woocount,
			'hide_empty'   => $hideempty,
			'echo'         => false
		) );

		$list_args['title_li'] = '<ul class="show-all-cat closed-woo-catlist">' . $top_level . '</ul>';

		// Direct children are wanted
		$direct_children = get_terms(
			'product_cat',
			array(
				'fields'       => 'ids',
				'child_of'     => $current_category->term_id,
				'hierarchical' => true,
				'hide_empty'   => false
			)
		);

		$siblings = array();
		if( $current_parent_category ) {
			// Siblings are wanted
			$siblings = get_terms(
				'product_cat',
				array(
					'fields'       => 'ids',
					'child_of'     => $current_parent_category,
					'hierarchical' => true,
					'hide_empty'   => false
				)
			);
		}

		$include = array_merge( array( $current_category->term_id, $current_parent_category ), $direct_children, $siblings );

		$list_args['include']     = implode( ',', $include );
		$list_args['depth']       = 3;

		if ( empty( $include ) ) {
			return;
		}

	} else {
		$list_args['title_li']         = sprintf( '<span class="browse-categories-label">%1$s</span>', $browseAllLabel );
		$list_args['depth']            = 2;
		$list_args['child_of']         = 0;
		$list_args['hierarchical']     = 1;
	}

	$list_args['pad_counts']                 = 1;
	$list_args['show_option_none']           = __('No product categories exist.', 'rehub_framework' );
	$list_args['current_category']           = ( $current_category ) ? $current_category->term_id : '';

	echo $args['before_widget'];

	$output = wp_list_categories( $list_args );
	$output = str_replace('</a> (', '</a> <span class="count">(', $output);
	$output = str_replace(')', ')</span>', $output);

	echo '<ul class="product-categories ' . esc_attr( $el_class ) . '">';

	echo $output;

	echo '</ul>';

	echo $args['after_widget'];
}


	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['showAllLabel'] = strip_tags( $new_instance['showAllLabel'] );
		$instance['hideempty'] = strip_tags($new_instance['hideempty']);
		$instance['woocount'] = strip_tags($new_instance['woocount']);
		$instance['browseAllLabel'] = strip_tags($new_instance['browseAllLabel']);

		return $instance;
	}


	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'showAllLabel' => 'Show all categories', 'hideempty' => '','woocount' => '','browseAllLabel' => 'Browse Categories');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		

		<p>
			<label for="<?php echo $this->get_field_id( 'showAllLabel' ); ?>"><?php _e('Label for show all category text:', 'rehub_framework'); ?></label>
			<input  type="text" class="widefat" id="<?php echo $this->get_field_id( 'showAllLabel' ); ?>" name="<?php echo $this->get_field_name( 'showAllLabel' ); ?>" value="<?php echo $instance['showAllLabel']; ?>"  />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'browseAllLabel' ); ?>"><?php _e('Label for browse categories text:', 'rehub_framework'); ?></label>
			<input  type="text" class="widefat" id="<?php echo $this->get_field_id( 'browseAllLabel' ); ?>" name="<?php echo $this->get_field_name( 'browseAllLabel' ); ?>" value="<?php echo $instance['browseAllLabel']; ?>"  />
		</p>		

		<p>
			<label for="<?php echo $this->get_field_id( 'hideempty' ); ?>"><?php _e('Hide empty categories', 'rehub_framework'); ?></label>
			<input id="<?php echo $this->get_field_id( 'hideempty' ); ?>" name="<?php echo $this->get_field_name( 'hideempty' ); ?>" value="true" <?php if( $instance['hideempty'] ) echo 'checked="checked"'; ?> type="checkbox" />
		</p>		

		<p>
			<label for="<?php echo $this->get_field_id( 'woocount' ); ?>"><?php _e('Show count of products', 'rehub_framework'); ?></label>
			<input id="<?php echo $this->get_field_id( 'woocount' ); ?>" name="<?php echo $this->get_field_name( 'woocount' ); ?>" value="true" <?php if( $instance['woocount'] ) echo 'checked="checked"'; ?> type="checkbox" />
		</p>			

	<?php
	}
}

?>