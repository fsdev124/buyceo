<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php
/**
 * Plugin Name: News Widget
 */

add_action( 'widgets_init', 'rehub_featured_slider_load_widget' );

function rehub_featured_slider_load_widget() {
	register_widget( 'rehub_featured_slider_widget' );
}

class rehub_featured_slider_widget extends WP_Widget {

    function __construct() {
        $widget_ops = array( 'classname' => 'featured_slider flexslider', 'description' => __('Widget that displays custom featured slider of posts or products. Use only in sidebar!', 'rehub_framework') );
        $control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'rehub_featured_slider' );
        parent::__construct('rehub_featured_slider', __('ReHub: Featured Slider', 'rehub_framework'), $widget_ops, $control_ops);
    }

/**
 * How to display the widget on the screen.
 */
function widget( $args, $instance ) {
	extract( $args );

	/* Our variables from the widget settings. */
	$title = apply_filters('widget_title', $instance['title'] );
	$tags = (!empty($instance['tags'])) ? $instance['tags'] : '';
	$post_type = (!empty($instance['post_type'])) ? $instance['post_type'] : '';	
	$number = (int)$instance['number'];
	global $post;
	
	if ($post_type){
		$query = array('posts_per_page' => $number, 'post_type' => 'product', 'post_status' => 'publish', 'ignore_sticky_posts' => 1, 'no_found_rows'=>1);
		$query['tax_query'] = array(array(
			'taxonomy' => 'product_visibility',
			'field'    => 'name',
			'terms'    => 'featured',
			'operator' => 'IN',
		));
		if ($tags){
			$query['tax_query'] = array(array('taxonomy' => 'product_tag', 'terms' => $tag, 'field' => 'term_slug'));			
		}	    		
	}
	else{
		$query = array('posts_per_page' => $number, 'nopaging' => 0, 'post_status' => 'publish', 'ignore_sticky_posts' => 1, 'tag' => $tags, 'no_found_rows'=>1);
	}
	$loop = new WP_Query($query);
	
	/* Before widget (defined by themes). */
	echo $before_widget;

	if ($loop->have_posts()) :

	/* Display the widget title if one was input (before and after defined by themes). */
	if ( $title )
		echo '<div class="title">' . $title . '</div>';
	?>
		<?php wp_enqueue_script('flexslider');   ?>
		<div class="slides">		
		<?php  while ($loop->have_posts()) : $loop->the_post(); ?>	
			<div class="slide">
				<?php if($post_type):?>
					<?php global $post, $product;?>
					<div class="wrap woo_feat_slider woocommerce text-center mt15">
						<?php $wootarget = ($product->get_type() =='external') ? ' target="_blank" rel="nofollow"' : '' ;?>
						<?php $woolink = ($product->get_type() =='external') ? $product->add_to_cart_url() : get_post_permalink($post->ID) ;?>
					    <figure class="centered_image_woo">
					        <a href="<?php echo $woolink ;?>"<?php echo $wootarget ;?>>
					            <?php if ( $product->is_featured() ) : ?>
					                    <?php echo apply_filters( 'woocommerce_featured_flash', '<span class="onfeatured">' . __( 'Featured!', 'rehub_framework' ) . '</span>', $post, $product ); ?>
					            <?php endif; ?>        
					            <?php if ( $product->is_on_sale() ) : ?>
					                <?php 
					                $percentage=0;
					                $featured = ($product->is_featured()) ? ' onsalefeatured' : '';
					                if ($product->get_regular_price()) {
					                    $percentage = round( ( ( $product->get_regular_price() - $product->get_price() ) / $product->get_regular_price() ) * 100 );
					                }
					                if ($percentage && $percentage>0 && !$product->is_type( 'variable' )) {
        								$sales_html = apply_filters( 'woocommerce_sale_flash', '<span class="onsale'.$featured.'"><span>- ' . $percentage . '%</span></span>', $post, $product );
					                } else {
					                    $sales_html = apply_filters( 'woocommerce_sale_flash', '<span class="onsale'.$featured.'">' . esc_html__( 'Sale!', 'rehub_framework' ) . '</span>', $post, $product );
					                }
					                ?>
					                <?php echo $sales_html; ?>
					            <?php endif; ?>
					            <?php 
					            $showimg = new WPSM_image_resizer();
					            $showimg->use_thumb = true; 
					            $showimg->no_thumb = rehub_woocommerce_placeholder_img_src('');                                   
					            ?>
					            <?php $showimg->width = '336';?>
					            <?php $showimg->height = '224';?>                                                   
					            <?php $showimg->show_resized_image(); ?>
					        </a>          
					    </figure>
					    <div class="woo_loop_desc">      
					        <a href="<?php echo $woolink ;?>"<?php echo $wootarget ;?>>
					            <?php echo rh_expired_or_not($post->ID, 'span');?>     
					            <?php 
					                /**
					                 * woocommerce_shop_loop_item_title hook.
					                 *
					                 * @hooked woocommerce_template_loop_product_title - 10
					                 */     
					                do_action( 'woocommerce_shop_loop_item_title' ); 
					            ?>
					        </a>
					        <?php do_action( 'rehub_vendor_show_action' ); ?>            
					    </div>
				        <div class="woo_spec_price">
							<?php wc_get_template( 'loop/price.php' ); ?>
				        </div>							
					</div>	
				<?php else:?>
					<div class="wrap rehub-main-font">
						<a href="<?php the_permalink();?>" class="view-link">
							<span class="pattern"></span>
							<div class="image"><?php wpsm_thumb ('grid_news') ?></div>
							<?php if(vp_metabox('rehub_post.rehub_framework_post_type') == 'review') :?><span class="score"><i><?php echo rehub_get_overall_score() ?></i><?php _e('SCORE', 'rehub_framework'); ?></span><?php endif;?>
							<?php $category = get_the_category($post->ID); $first_cat = $category[0]->term_id; $cat_name = get_cat_name($first_cat);?>
							<span class="reviews"><?php echo $cat_name ;?></span>
						</a>
						<h3 class="link"><a class="rehub-main-color" href="<?php the_permalink();?>"><?php the_title();?></a></h3>
						<p><?php kama_excerpt('maxchar=100'); ?></p>
					</div>				
				<?php endif;?>
            </div>	
		<?php endwhile; ?>
		</div>
		<?php wp_reset_query(); ?>
		<?php else: ?><?php _e('No posts for this criteria.', 'rehub_framework');  ?>
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
		$instance['tags'] = strip_tags($new_instance['tags']);
		$instance['number'] = strip_tags( $new_instance['number'] );
		$instance['post_type'] = $new_instance['post_type'];

		return $instance;
	}


	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Featured', 'rehub_framework'), 'number' => 3, 'tags' => '', 'post_type' => '');
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
			<label for="<?php echo $this->get_field_id( 'tags' ); ?>"><?php _e('Enter tag slug:', 'rehub_framework'); ?></label>
			<input  type="text" class="widefat" id="<?php echo $this->get_field_id( 'tags' ); ?>" name="<?php echo $this->get_field_name( 'tags' ); ?>" value="<?php echo $instance['tags']; ?>"  />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'post_type' ); ?>"><?php _e('Show woocommerce products', 'rehub_framework'); ?></label>
			<input id="<?php echo $this->get_field_id( 'post_type' ); ?>" name="<?php echo $this->get_field_name( 'post_type' ); ?>" value="true" <?php if( $instance['post_type'] ) echo 'checked="checked"'; ?> type="checkbox" />
			<br /><small>By default, widget shows posts, but you can enable woocommerce products in slider</small>
		</p>		

	<?php
	}
}

?>