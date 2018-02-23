<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php
/**
 * Plugin Name: News Widget
 */

add_action( 'widgets_init', 'rehub_tabsajax_load_widget' );

function rehub_tabsajax_load_widget() {
	register_widget( 'rehub_tabsajax_widget' );
}

class rehub_tabsajax_widget extends WP_Widget {

    function __construct() {
		$widget_ops = array( 'classname' => 'tabsajax', 'description' => __('A widget that displays 4 ajax tabs. Use only in sidebar! ', 'rehub_framework') );
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'rehub_tabsajax_widget' );
        parent::__construct('rehub_tabsajax_widget', __('ReHub: Ajax Tabs', 'rehub_framework'), $widget_ops, $control_ops  );
    }

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		if( function_exists('icl_t') )  $titlefirst = icl_t( 'Enter title for first tab' , 'widget_title_'.$this->id , $instance['titlefirst'] ); else $titlefirst = $instance['titlefirst'] ;
		if( function_exists('icl_t') )  $titlesecond = icl_t( 'Enter title for second tab' , 'widget_title_second'.$this->id , $instance['titlesecond'] ); else $titlesecond = $instance['titlesecond'] ;
		if( function_exists('icl_t') )  $titlethird = icl_t( 'Enter title for third tab' , 'widget_title_'.$this->id , $instance['titlethird'] ); else $titlethird = $instance['titlethird'] ;
		if( function_exists('icl_t') )  $titlefourth = icl_t( 'Enter title for fourth tab' , 'widget_title_fourth'.$this->id , $instance['titlefourth'] ); else $titlefourth = $instance['titlefourth'] ;		
		$metafirst = $instance['metafirst'];
		$metasecond = $instance['metasecond'];
		$metathird = $instance['metathird'];
		$metafourth = $instance['metafourth'];
		$datefirst = $instance['datefirst'];
		$datesecond = $instance['datesecond'];
		$datethird = $instance['datethird'];
		$datefourth = $instance['datefourth'];	
		
		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo '<div class="title">' . do_shortcode($title) . '</div>';		

		?>
		<?php $num_col = 0;?>
		<?php if (!empty($titlefirst)) {$num_col++;}?>
		<?php if (!empty($titlesecond)) {$num_col++;}?>
		<?php if (!empty($titlethird)) {$num_col++;}?>
		<?php if (!empty($titlefourth)) {$num_col++;}?>
		<?php 
			$prepare_filter_first = $prepare_filter_second = $prepare_filter_third = $prepare_filter_fourth = '';
			$prepare_filter = array();
			if (!empty($titlefirst)) {
				$prepare_filter_first = array(
					'filtertitle' => $titlefirst,
					'filtertype' => 'meta',
					'filterorder'=> 'DESC',
					'filterdate'=> $datefirst,	
					'filtermetakey' => $metafirst			
				);
				$prepare_filter[] = $prepare_filter_first;
			}
			if (!empty($titlesecond)) {
				$prepare_filter_second = array(
					'filtertitle' => $titlesecond,
					'filtertype' => 'meta',
					'filterorder'=> 'DESC',
					'filterdate'=> $datesecond,	
					'filtermetakey' => $metasecond			
				);
				$prepare_filter[] = $prepare_filter_second;
			}
			if (!empty($titlethird)) {
				$prepare_filter_third = array(
					'filtertitle' => $titlethird,
					'filtertype' => 'meta',
					'filterorder'=> 'DESC',
					'filterdate'=> $datethird,	
					'filtermetakey' => $metathird			
				);
				$prepare_filter[] = $prepare_filter_third;
			}
			if (!empty($titlefourth)) {
				$prepare_filter_fourth = array(
					'filtertitle' => $titlefourth,
					'filtertype' => 'meta',
					'filterorder'=> 'DESC',
					'filterdate'=> $datefourth,	
					'filtermetakey' => $metafourth			
				);
				$prepare_filter[] = $prepare_filter_fourth;
			}
			$prepare_filter = urlencode(json_encode($prepare_filter));	

		?>

	    <div class="ajaxed_post_widget rh_col_tabs_<?php echo $num_col?>">
	    <?php $args_list = array(
	    	'show_date'=> $datefirst,
	    	'show' => 6,
	    	'orderby' => 'meta_value_num',
	    	'order'=> 'DESC',
	    	'meta_key'=> $metafirst,
	    	'filterpanel' => $prepare_filter,
	    	'nometa' => 1,
	    );?>
	    <?php echo recent_posts_function($args_list);?>
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
		$instance['title'] = $new_instance['title'];
		$instance['titlefirst'] = strip_tags($new_instance['titlefirst']);
		$instance['titlesecond'] = strip_tags($new_instance['titlesecond']);
		$instance['titlethird'] = strip_tags($new_instance['titlethird']);
		$instance['titlefourth'] = strip_tags($new_instance['titlefourth']);
		$instance['metafirst'] = strip_tags($new_instance['metafirst']);
		$instance['metasecond'] = strip_tags($new_instance['metasecond']);
		$instance['metathird'] = strip_tags($new_instance['metathird']);
		$instance['metafourth'] = strip_tags($new_instance['metafourth']);
		$instance['datefirst'] = $new_instance['datefirst'];
		$instance['datesecond'] = $new_instance['datesecond'];
		$instance['datethird'] = $new_instance['datethird'];
		$instance['datefourth'] = $new_instance['datefourth'];		

		if (function_exists('icl_register_string')) {
			icl_register_string( 'Enter title for first tab' , 'widget_title_'.$this->id, $new_instance['titlefirst'] );
			icl_register_string( 'Enter title for second tab' , 'widget_title_second'.$this->id, $new_instance['titlesecond'] );
			icl_register_string( 'Enter title for third tab' , 'widget_title_'.$this->id, $new_instance['titlethird'] );
			icl_register_string( 'Enter title for fourth tab' , 'widget_title_second'.$this->id, $new_instance['titlefourth'] );			
		}		

		return $instance;
	}


	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => '', 'datefirst' => 'all', 'datesecond' => 'all', 'datethird' => 'all', 'datefourth' => 'all', 'titlefirst' => '', 'metafirst' => '','titlesecond' => '', 'metasecond' => '','titlethird' => '', 'metathird' => '','titlefourth' => '', 'metafourth' => '',);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
	
		<div>
		<p><em style="color:red;"><?php _e('Use this widget only in sidebar area!', 'rehub_framework');?></em></p>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title of widget:', 'rehub_framework'); ?></label>
			<input  type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>"  />
		</p>				
		<p>
			<label for="<?php echo $this->get_field_id( 'titlefirst' ); ?>"><?php _e('Enter title for first tab:', 'rehub_framework'); ?></label>
			<input  type="text" class="widefat" id="<?php echo $this->get_field_id( 'titlefirst' ); ?>" name="<?php echo $this->get_field_name( 'titlefirst' ); ?>" value="<?php echo $instance['titlefirst']; ?>"  />
			<span><em><?php _e('Required', 'rehub_framework');?></em></span>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('datefirst'); ?>"><?php _e('Show posts for first tab published:', 'rehub_framework');?></label> 
		<select id="<?php echo $this->get_field_id('datefirst'); ?>" name="<?php echo $this->get_field_name('datefirst'); ?>" style="width:100%;">
			<option value='all' <?php if ( 'all' == $instance['datefirst'] ) : echo 'selected="selected"'; endif; ?>><?php _e('all time', 'rehub_framework');?></option>
			<option value='day' <?php if ( 'day' == $instance['datefirst'] ) : echo 'selected="selected"'; endif; ?>><?php _e('For last 24 hours', 'rehub_framework');?></option>			
			<option value='week' <?php if ( 'week' == $instance['datefirst'] ) : echo 'selected="selected"'; endif; ?>><?php _e('For last 7 days', 'rehub_framework');?></option>
			<option value='month' <?php if ( 'month' == $instance['datefirst'] ) : echo 'selected="selected"'; endif; ?>><?php _e('For last month', 'rehub_framework');?></option>
			<option value='year' <?php if ( 'year' == $instance['datefirst'] ) : echo 'selected="selected"'; endif; ?>><?php _e('For last year', 'rehub_framework');?></option>
		</select>
		</p>		
		<p>
			<label for="<?php echo $this->get_field_id( 'metafirst' ); ?>"><?php _e('Enter meta for first tab', 'rehub_framework'); ?></label>
			<input  type="text" class="widefat" id="<?php echo $this->get_field_id( 'metafirst' ); ?>" name="<?php echo $this->get_field_name( 'metafirst' ); ?>" value="<?php echo $instance['metafirst']; ?>"  />
		</p>
		<p style="font-style: italic;">
			<?php _e('Some important meta keys: <br /><strong>rehub_review_overall_score</strong> - key for overall review score, <br /><strong>post_hot_count</strong> - hot or thumb counter, <br /><strong>post_user_average</strong> - user rating score(based on full review criterias), <br /><strong>rehub_views</strong> - post view counter, <br /><strong>rehub_views_mon, rehub_views_day, rehub_views_year</strong> - post view counter by day, month, year', 'rehub_framework')?>							
		</p>		
		<hr style="margin: 30px 0" />
		<p>
			<label for="<?php echo $this->get_field_id( 'titlesecond' ); ?>"><?php _e('Enter title for second tab', 'rehub_framework'); ?></label>
			<input  type="text" class="widefat" id="<?php echo $this->get_field_id( 'titlesecond' ); ?>" name="<?php echo $this->get_field_name( 'titlesecond' ); ?>" value="<?php echo $instance['titlesecond']; ?>"  />
			<span><em><?php _e('Required', 'rehub_framework');?></em></span>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('datesecond'); ?>"><?php _e('Show posts for second tab published:', 'rehub_framework');?></label> 
		<select id="<?php echo $this->get_field_id('datesecond'); ?>" name="<?php echo $this->get_field_name('datesecond'); ?>" style="width:100%;">
			<option value='all' <?php if ( 'all' == $instance['datesecond'] ) : echo 'selected="selected"'; endif; ?>><?php _e('all time', 'rehub_framework');?></option>
			<option value='day' <?php if ( 'day' == $instance['datesecond'] ) : echo 'selected="selected"'; endif; ?>><?php _e('For last 24 hours', 'rehub_framework');?></option>			
			<option value='week' <?php if ( 'week' == $instance['datesecond'] ) : echo 'selected="selected"'; endif; ?>><?php _e('For last 7 days', 'rehub_framework');?></option>
			<option value='month' <?php if ( 'month' == $instance['datesecond'] ) : echo 'selected="selected"'; endif; ?>><?php _e('For last month', 'rehub_framework');?></option>
			<option value='year' <?php if ( 'year' == $instance['datesecond'] ) : echo 'selected="selected"'; endif; ?>><?php _e('For last year', 'rehub_framework');?></option>
		</select>
		</p>		
		<p>
			<label for="<?php echo $this->get_field_id( 'metasecond' ); ?>"><?php _e('Enter meta for second tab', 'rehub_framework'); ?></label>
			<input  type="text" class="widefat" id="<?php echo $this->get_field_id( 'metasecond' ); ?>" name="<?php echo $this->get_field_name( 'metasecond' ); ?>" value="<?php echo $instance['metasecond']; ?>"  />			
		</p>
		<p style="font-style: italic;">
			<?php _e('Some important meta keys: <br /><strong>rehub_review_overall_score</strong> - key for overall review score, <br /><strong>post_hot_count</strong> - hot or thumb counter, <br /><strong>post_user_average</strong> - user rating score(based on full review criterias), <br /><strong>rehub_views</strong> - post view counter, <br /><strong>rehub_views_mon, rehub_views_day, rehub_views_year</strong> - post view counter by day, month, year', 'rehub_framework')?>							
		</p>		
		
		<hr style="margin: 30px 0" />
		<p>
			<label for="<?php echo $this->get_field_id( 'titlethird' ); ?>"><?php _e('Enter title for third tab', 'rehub_framework'); ?></label>
			<input  type="text" class="widefat" id="<?php echo $this->get_field_id( 'titlethird' ); ?>" name="<?php echo $this->get_field_name( 'titlethird' ); ?>" value="<?php echo $instance['titlethird']; ?>"  />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('datethird'); ?>"><?php _e('Show posts for third tab published:', 'rehub_framework');?></label> 
		<select id="<?php echo $this->get_field_id('datethird'); ?>" name="<?php echo $this->get_field_name('datethird'); ?>" style="width:100%;">
			<option value='all' <?php if ( 'all' == $instance['datethird'] ) : echo 'selected="selected"'; endif; ?>><?php _e('all time', 'rehub_framework');?></option>
			<option value='day' <?php if ( 'day' == $instance['datethird'] ) : echo 'selected="selected"'; endif; ?>><?php _e('For last 24 hours', 'rehub_framework');?></option>			
			<option value='week' <?php if ( 'week' == $instance['datethird'] ) : echo 'selected="selected"'; endif; ?>><?php _e('For last 7 days', 'rehub_framework');?></option>
			<option value='month' <?php if ( 'month' == $instance['datethird'] ) : echo 'selected="selected"'; endif; ?>><?php _e('For last month', 'rehub_framework');?></option>
			<option value='year' <?php if ( 'year' == $instance['datethird'] ) : echo 'selected="selected"'; endif; ?>><?php _e('For last year', 'rehub_framework');?></option>
		</select>
		</p>		
		<p>
			<label for="<?php echo $this->get_field_id( 'metathird' ); ?>"><?php _e('Enter meta for third tab', 'rehub_framework'); ?></label>
			<input  type="text" class="widefat" id="<?php echo $this->get_field_id( 'metathird' ); ?>" name="<?php echo $this->get_field_name( 'metathird' ); ?>" value="<?php echo $instance['metathird']; ?>"  />			
		</p>
		<p style="font-style: italic;">
			<?php _e('Some important meta keys: <br /><strong>rehub_review_overall_score</strong> - key for overall review score, <br /><strong>post_hot_count</strong> - hot or thumb counter, <br /><strong>post_user_average</strong> - user rating score(based on full review criterias), <br /><strong>rehub_views</strong> - post view counter, <br /><strong>rehub_views_mon, rehub_views_day, rehub_views_year</strong> - post view counter by day, month, year', 'rehub_framework')?>								
		</p>		
		
		<hr style="margin: 30px 0" />
		<p>
			<label for="<?php echo $this->get_field_id( 'titlefourth' ); ?>"><?php _e('Enter title for fourth tab', 'rehub_framework'); ?></label>
			<input  type="text" class="widefat" id="<?php echo $this->get_field_id( 'titlefourth' ); ?>" name="<?php echo $this->get_field_name( 'titlefourth' ); ?>" value="<?php echo $instance['titlefourth']; ?>"  />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('datefourth'); ?>"><?php _e('Show posts for fourth tab published:', 'rehub_framework');?></label> 
		<select id="<?php echo $this->get_field_id('datefourth'); ?>" name="<?php echo $this->get_field_name('datefourth'); ?>" style="width:100%;">
			<option value='all' <?php if ( 'all' == $instance['datefourth'] ) : echo 'selected="selected"'; endif; ?>><?php _e('all time', 'rehub_framework');?></option>
			<option value='day' <?php if ( 'day' == $instance['datefourth'] ) : echo 'selected="selected"'; endif; ?>><?php _e('For last 24 hours', 'rehub_framework');?></option>			
			<option value='week' <?php if ( 'week' == $instance['datefourth'] ) : echo 'selected="selected"'; endif; ?>><?php _e('For last 7 days', 'rehub_framework');?></option>
			<option value='month' <?php if ( 'month' == $instance['datefourth'] ) : echo 'selected="selected"'; endif; ?>><?php _e('For last month', 'rehub_framework');?></option>
			<option value='year' <?php if ( 'year' == $instance['datefourth'] ) : echo 'selected="selected"'; endif; ?>><?php _e('For last year', 'rehub_framework');?></option>
		</select>
		</p>		
		<p>
			<label for="<?php echo $this->get_field_id( 'metafourth' ); ?>"><?php _e('Enter meta for fourth tab', 'rehub_framework'); ?></label>
			<input  type="text" class="widefat" id="<?php echo $this->get_field_id( 'metafourth' ); ?>" name="<?php echo $this->get_field_name( 'metafourth' ); ?>" value="<?php echo $instance['metafourth']; ?>"  />			
		</p>
		<p style="font-style: italic;">
			<?php _e('Some important meta keys: <br /><strong>rehub_review_overall_score</strong> - key for overall review score, <br /><strong>post_hot_count</strong> - hot or thumb counter, <br /><strong>post_user_average</strong> - user rating score(based on full review criterias), <br /><strong>rehub_views</strong> - post view counter, <br /><strong>rehub_views_mon, rehub_views_day, rehub_views_year</strong> - post view counter by day, month, year <br />', 'rehub_framework')?>								
		</p>		
								
		
		</div>
	<?php
	}


}

?>