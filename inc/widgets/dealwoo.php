<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php
/**
 * Plugin Name: Deal Day Widget
 */

add_action( 'widgets_init', 'rehub_deal_daywoo_load_widget' );

function rehub_deal_daywoo_load_widget() {
	register_widget( 'rehub_deal_daywoo_widget' );
}

class rehub_deal_daywoo_widget extends WP_Widget {

    function __construct() {
        $widget_ops = array( 'classname' => 'deal_daywoo woocommerce', 'description' => __('Displays "deal of the day" (WC Product or Post Offers). Use only in sidebar!', 'rehub_framework') );
        $control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'rehub_deal_daywoo' );
        parent::__construct( 'rehub_deal_daywoo', __( 'ReHub: Deal of day', 'rehub_framework' ), $widget_ops, $control_ops );
    }

/**
 * How to display the widget on the screen.
 */
function widget( $args, $instance ) {
	extract( $args );

	/* Our variables from the widget settings. */
	$title = apply_filters( 'widget_title', $instance['title'] );
	$dealtype = ( !empty( $instance['dealtype'] ) ) ? $instance['dealtype'] : 'product';
	$dealid = (!empty($instance['dealid'])) ? (int)$instance['dealid'] : '';
	$faketimer = (!empty($instance['faketimer'])) ? $instance['faketimer'] : '';
	$fakebar = (!empty($instance['fakebar'])) ? $instance['fakebar'] : '';
	$fakebar_sold = (!empty($instance['fakebar_sold'])) ? $instance['fakebar_sold'] : 12;
	$fakebar_stock = (!empty($instance['fakebar_stock'])) ? $instance['fakebar_stock'] : 16;
	$markettext = ( !empty( $instance['markettext'] ) ) ? $instance['markettext'] : '';

	if ( $dealid ) {
		$args = array(
			'post__in' => array( $dealid ), 
			'post_status' => 'publish', 
			'ignore_sticky_posts' => 1, 
			'post_type' => $dealtype, 
			'no_found_rows'=>1
		);
	} else {
        $args = array(
            'posts_per_page'=>'1',
            'post_type'=> $dealtype,            
        );
		
		$meta_query = array();
		
		if ( 'product' == $dealtype && class_exists('woocommerce')) {
			$product_ids_on_sale = wc_get_product_ids_on_sale();
			$meta_query[] = WC()->query->visibility_meta_query();
			$meta_query[] = WC()->query->stock_status_meta_query();	
		} else {
			$product_ids_on_sale = rh_get_post_ids_on_sale();
		}

	    $meta_query = array_filter( $meta_query );
	    $args['meta_query'] = $meta_query;
	    $args['post__in'] = array_merge( array( 0 ), $product_ids_on_sale );
	    $args['no_found_rows'] = 1;        	
	}

	$loop = new WP_Query( $args );
	
	/* Before widget (defined by themes). */
	echo $before_widget;

	if ( $loop->have_posts() ) :

	/* Display the widget title if one was input (before and after defined by themes). */
	if ( $title ) : ?>
		<div class="title"><?php echo $title; ?></div>
	<?php endif; ?>
		<div class="woo_spec_widget">
		<?php while( $loop->have_posts() ) : $loop->the_post(); ?>
				<?php if ( 'product' == $dealtype && class_exists('woocommerce')):?>

					<?php global $post, $product;?>
					<?php 	
						$target_blank = ( $product->get_type() == 'external' ) ? ' target="_blank" rel="nofollow"' : '' ;
						$product_link = ( $product->get_type() == 'external' ) ? $product->add_to_cart_url() : get_the_permalink( $post->ID );
						$offer_coupon_date = get_post_meta( $post->ID, 'rehub_woo_coupon_date', true );
					?>
				    <figure class="centered_image_woo">
						<?php
							if ( $product->is_featured() ) :
								echo apply_filters( 'woocommerce_featured_flash', '<span class="onfeatured">' . __( 'Featured!', 'rehub_framework' ) . '</span>', $post, $product );
							endif; 
							if ( $product->is_on_sale() ) : 
								$percentage = 0;
								$featured = ( $product->is_featured() ) ? ' onsalefeatured' : '';
								if ( $product->get_regular_price() ) {
									$percentage = round( ( ( $product->get_regular_price() - $product->get_price() ) / $product->get_regular_price() ) * 100 );
								}
								if ( $percentage && $percentage > 0 && !$product->is_type( 'variable' ) ) {
									$sales_html = apply_filters( 'woocommerce_sale_flash', '<span class="onsale'. $featured .'"><span>- ' . $percentage . '%</span></span>', $post, $product );
								} else {
									$sales_html = apply_filters( 'woocommerce_sale_flash', '<span class="onsale'. $featured .'">' . esc_html__( 'Sale!', 'rehub_framework' ) . '</span>', $post, $product );
								}
								echo $sales_html;
							endif; 
						?>
						<a href="<?php echo $product_link ; ?>"<?php echo $target_blank;?>>
				            <?php 
				            $showimg = new WPSM_image_resizer();
				            $showimg->use_thumb = true; 
				            $showimg->no_thumb = rehub_woocommerce_placeholder_img_src('');
				            $showimg->width = '336';
				            $showimg->height = '224';                                                
				            $showimg->show_resized_image(); 
							?>
				        </a>          
				    </figure>
				    <div class="woo_loop_desc"> 
				    	<h3>      
					        <a class="<?php echo getHotIconclass($post->ID); ?>" href="<?php echo $product_link ;?>"<?php echo $target_blank; ?>>
					            	<?php echo rh_expired_or_not($post->ID, 'span');?>     
					            	<?php the_title();?>
					        </a>
				        </h3>		         
				        <?php do_action( 'rehub_vendor_show_action' ); ?>            
				    </div>	
			        <div class="woo_spec_price">
						<?php wc_get_template( 'loop/price.php' ); ?>
			        </div>
		        	<?php // stock wpsm_bar
					if ( $fakebar ) {
						$stock_sold = $fakebar_sold; 
						$stock_available = $fakebar_stock;
					} else {
						$stock_sold = ( $total_sales = get_post_meta( get_the_ID(), 'total_sales', true ) ) ? round( $total_sales ) : 0;
						$stock_available = ( $stock = get_post_meta( get_the_ID(), '_stock', true ) ) ? round( $stock ) : 0;			
					} 
					$percentage = ( $stock_available > 0 ) ? round( $stock_sold / $stock_available * 100 ) : '';	
					?>
					
		        	<?php if ( !empty($percentage) ) : ?>        
				        <div class="woo_spec_bar mt30 mb20">
				        	<div class="deal-stock mb10">
				        	<span class="stock-sold floatleft">
				        		<?php _e( 'Already Sold:', 'rehub_framework' );?> <strong><?php echo esc_html( $stock_sold ); ?></strong>
				        	</span>
				        	<span class="stock-available floatright">
				        		<?php _e( 'Available:', 'rehub_framework' );?> <strong><?php echo esc_html( $stock_available ); ?></strong>
				        	</span>
				        	</div>
				        	<?php if ( $percentage == 0 ) { $percentage = 10; }?>
				        	<?php echo wpsm_bar_shortcode(array('percentage'=>$percentage));?>
				        </div>	 
			        <?php endif;?>
					<div class="marketing-text mt15 mb15"><?php echo $markettext; ?></div>	
		        	<?php if( $faketimer ) : ?>
		        		<?php 
		        			$currenttime = current_time('mysql',0);
		        			$now = new DateTime($currenttime);
		        			$now->modify( 'tomorrow' );
		   					$month = $now->format( 'm' );
		   					$year = $now->format( 'Y' );
		   					$day = $now->format( 'd' );
		   				?>
		        	<?php else:?>
			        	<?php 
			        		$sale_price_dates_to = ( $date = get_post_meta( get_the_ID(), '_sale_price_dates_to', true ) ) ? date_i18n( 'Y-m-d', $date ) : $offer_coupon_date;
			        		if ( $sale_price_dates_to ) {
			        			$expireddate = explode('-', $sale_price_dates_to);
								$year = $expireddate[0];
								$month = $expireddate[1];
								$day  = $expireddate[2];
			        		} else {
			        			$year = '';
			        		}
						?>	        	
		        	<?php endif;?>
		        	<?php if( $year ) : ?>
		        		<div class="woo_spec_timer">
							<?php echo wpsm_countdown(array('year'=> $year, 'month'=>$month, 'day'=>$day));?>
		        		</div>
		        	<?php endif;?>								        			        				    			    									
				<?php else:?>
					<?php global $post;?>
					<?php 
						$offer_price_old = get_post_meta( $post->ID, 'rehub_offer_product_price_old', true );
						$offer_price = get_post_meta( $post->ID, 'rehub_offer_product_price', true );
						$offer_coupon_date = get_post_meta( $post->ID, 'rehub_offer_coupon_date', true );			
						$target_blank = '';
						$product_link = get_the_permalink( $post->ID );
					?>	
				    <figure class="rh_centered_image mb15">
						<?php
							echo re_badge_create('tablelabel');
						?>
						<a href="<?php echo $product_link ; ?>"<?php echo $target_blank;?>>
				            <?php 
				            $showimg = new WPSM_image_resizer();
				            $showimg->use_thumb = true; 
				            $showimg->width = '300';
				            $showimg->height = '300';                                                
				            $showimg->show_resized_image(); 
							?>
				        </a>         
				    </figure>
				    <div class="woo_loop_desc"> 
				    	<h3>      
					        <a class="<?php echo getHotIconclass($post->ID); ?>" href="<?php echo $product_link ;?>"<?php echo $target_blank; ?>>
					            	<?php echo rh_expired_or_not($post->ID, 'span');?>     
					            	<?php the_title();?>
					        </a>
				        </h3>		         
				        <?php do_action( 'rehub_vendor_show_action' ); ?>            
				    </div>	
			        <div class="woo_spec_price">
						<span class="price">
							<del><?php if ( ! empty( $offer_price_old ) ) echo $offer_price_old; ?></del> 
							<ins><?php echo $offer_price; ?></ins>
						</span>
			        </div>
		        	<?php // stock wpsm_bar
					if ( $fakebar ) {
						$stock_sold = $fakebar_sold; 
						$stock_available = $fakebar_stock;
					} else {
						$stock_sold = ( $total_sales = get_post_meta( get_the_ID(), 'total_sales', true ) ) ? round( $total_sales ) : 0;
						$stock_available = ( $stock = get_post_meta( get_the_ID(), '_stock', true ) ) ? round( $stock ) : 0;			
					} 
					$percentage = ( (int)$stock_available > 0 ) ? round( $stock_sold / $stock_available * 100 ) : '';	
					?>
					
		        	<?php if ( !empty($percentage) ) : ?>        
				        <div class="woo_spec_bar mt30 mb20">
				        	<div class="deal-stock mb10">
				        	<span class="stock-sold floatleft">
				        		<?php _e( 'Already Sold:', 'rehub_framework' );?> <strong><?php echo esc_html( $stock_sold ); ?></strong>
				        	</span>
				        	<span class="stock-available floatright">
				        		<?php _e( 'Available:', 'rehub_framework' );?> <strong><?php echo esc_html( $stock_available ); ?></strong>
				        	</span>
				        	</div>
				        	<?php if ( $percentage == 0 ) { $percentage = 10; }?>
				        	<?php echo wpsm_bar_shortcode(array('percentage'=>$percentage));?>
				        </div>	 
			        <?php endif;?>
			        <div class="marketing-text mt15 mb15"><?php echo $markettext; ?></div>
		        	<?php if( $faketimer ) : ?>
		        		<?php 
		        			$currenttime = current_time('mysql',0);
		        			$now = new DateTime($currenttime);
		        			$now->modify( 'tomorrow' );
		   					$month = $now->format( 'm' );
		   					$year = $now->format( 'Y' );
		   					$day = $now->format( 'd' );
		   				?>
		        	<?php else:?>
			        	<?php 
			        		if ( $offer_coupon_date ) {
			        			$expireddate = explode('-', $offer_coupon_date);
								$year = $expireddate[0];
								$month = $expireddate[1];
								$day  = $expireddate[2];
			        		} else {
			        			$year = '';
			        		}
						?>	        	
		        	<?php endif;?>
		        	<?php if( $year ) : ?>
		        		<div class="woo_spec_timer">
		        			<?php echo wpsm_countdown(array('year'=> $year, 'month'=>$month, 'day'=>$day));?>
		        		</div>
		        	<?php endif;?>				        				        

				<?php endif;?>

		<?php endwhile; ?>
		<?php wp_reset_query(); ?>
		</div>
	<?php else: ?>
		<?php _e( 'No products for this criteria.', 'rehub_framework' );  ?>
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
		$instance['dealtype'] = strip_tags( $new_instance['dealtype'] );
		$instance['faketimer'] = ( isset( $new_instance['faketimer'] ) ) ? strip_tags( $new_instance['faketimer'] ) : '';
		$instance['fakebar'] = ( isset( $new_instance['fakebar'] ) ) ? strip_tags( $new_instance['fakebar'] ) : '';
		$instance['fakebar_sold'] = (int)( $new_instance['fakebar_sold'] );
		$instance['fakebar_stock'] = (int)( $new_instance['fakebar_stock'] );
		$instance['markettext'] = strip_tags( $new_instance['markettext'] );
		$instance['dealid'] = strip_tags( $new_instance['dealid'] );

		return $instance;
	}


	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 
			'title' => __( 'Deal of the day', 'rehub_framework' ),
			'dealtype' => 'product', 
			'dealid' => '', 
			'faketimer' => '', 
			'fakebar' => '', 
			'fakebar_sold' => 12,
			'fakebar_stock' => 16,
			'markettext' => __( 'Hurry Up! Offer ends soon.', 'rehub_framework' )
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title of widget:', 'rehub_framework'); ?></label>
			<input  type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>"  />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'dealtype' ); ?>"><?php _e('Post type:', 'rehub_framework'); ?></label>
			<select id="<?php echo $this->get_field_id( 'dealtype' ); ?>" name="<?php echo $this->get_field_name( 'dealtype' ); ?>" style="width:100%;">
				<option value="product" <?php if ( 'product' == $instance['dealtype'] ) : echo 'selected="selected"'; endif; ?>><?php _e('Product', 'rehub_framework'); ?></option>
				<option value="post" <?php if ( 'post' == $instance['dealtype'] ) : echo 'selected="selected"'; endif; ?>><?php _e('Post', 'rehub_framework'); ?></option>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'dealid' ); ?>"><?php _e('Id of product to show:', 'rehub_framework'); ?></label>
			<input  type="text" class="widefat" id="<?php echo $this->get_field_id( 'dealid' ); ?>" name="<?php echo $this->get_field_name( 'dealid' ); ?>" value="<?php echo $instance['dealid']; ?>" size="3" />
			<small>By default, widget shows latest product which is on sale, you can specify product ID to overwrite this</small>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'faketimer' ); ?>"><?php _e('Set fake timer:', 'rehub_framework'); ?></label>
			<input id="<?php echo $this->get_field_id( 'faketimer' ); ?>" name="<?php echo $this->get_field_name( 'faketimer' ); ?>" value="true" <?php if( $instance['faketimer'] ) echo 'checked="checked"'; ?> type="checkbox" />
			<br /><small>By default, widget shows countdown base on Sale price dates of product. You can enable fake timer (always shows 12 hours)  </small>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'markettext' ); ?>"><?php _e('Add marketing text:', 'rehub_framework'); ?></label>
			<input  type="text" class="widefat" id="<?php echo $this->get_field_id( 'markettext' ); ?>" name="<?php echo $this->get_field_name( 'markettext' ); ?>" value="<?php echo $instance['markettext']; ?>"  />
		</p>		

		<p>
			<label for="<?php echo $this->get_field_id( 'fakebar' ); ?>"><?php _e('Set fake sold bar:', 'rehub_framework'); ?></label>
			<input id="<?php echo $this->get_field_id( 'fakebar' ); ?>" name="<?php echo $this->get_field_name( 'fakebar' ); ?>" value="true" <?php if( $instance['fakebar'] ) echo 'checked="checked"'; ?> type="checkbox" />
			<br>
			<label for="<?php echo $this->get_field_id( 'fakebar_sold' ); ?>"><?php _e('Sold:', 'rehub_framework'); ?></label>
			<input class="tiny-text" id="<?php echo $this->get_field_id( 'fakebar_sold' ); ?>" name="<?php echo $this->get_field_name( 'fakebar_sold' ); ?>" type="number" step="1" min="1" value="<?php echo $instance['fakebar_sold']; ?>" size="3">
			<label for="<?php echo $this->get_field_id( 'fakebar_stock' ); ?>"><?php _e('In Stock:', 'rehub_framework'); ?></label>
			<input class="tiny-text" id="<?php echo $this->get_field_id( 'fakebar_stock' ); ?>" name="<?php echo $this->get_field_name( 'fakebar_stock' ); ?>" type="number" step="1" min="1" value="<?php echo $instance['fakebar_stock']; ?>" size="3">
			<br /><small>By default, widget shows real progress bar based on stock status, you can enable fake bar</small>
		</p>			

	<?php
	}
}


?>