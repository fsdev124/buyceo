<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php
/**
 * Plugin Name: News Widget
 */

add_action( 'widgets_init', 'rehub_tabs_load_widget' );

function rehub_tabs_load_widget() {
	register_widget( 'rehub_tabs_widget' );
}

class rehub_tabs_widget extends WP_Widget {

    function __construct() {
		$widget_ops = array( 'classname' => 'tabs', 'description' => __('A widget that displays 2 tabs (popular, categories, tags, latest comments). Use only in sidebar! ', 'rehub_framework') );
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'rehub_latest_tabs_widget' );
        parent::__construct('rehub_latest_tabs_widget', __('ReHub: Tabs', 'rehub_framework'), $widget_ops, $control_ops  );
    }

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$tabs1 = $instance['tabs1'];
		$tabs2 = $instance['tabs2'];
		if( function_exists('icl_t') )  $titlefirst = icl_t( 'Widget title' , 'widget_title_'.$this->id , $instance['titlefirst'] ); else $titlefirst = $instance['titlefirst'] ;
		if( function_exists('icl_t') )  $titlesecond = icl_t( 'Widget title second' , 'widget_title_second'.$this->id , $instance['titlesecond'] ); else $titlesecond = $instance['titlesecond'] ;
		$sortby = $instance['sortby'];
		$sortbysec = $instance['sortbysec'];
		if( !empty($instance['dark']) ) $color = 'dark';
		else $color = '';
		if( empty($instance['basedby']) ) {$basedby = 'comments';}
		else {$basedby = $instance['basedby'];}
		if( empty($instance['basedbysec']) ) {$basedbysec = 'views';}
		else {$basedbysec = $instance['basedbysec'];}		
		
		/* Before widget (defined by themes). */
		echo $before_widget;

		?>

		<ul class="clearfix tabs-menu">
            <li>
				<?php echo $titlefirst ;?>
            </li>
            <li>
				<?php echo $titlesecond ;?>	
            </li>
       </ul>
    <div class="color_sidebar<?php if ($color == 'dark') :?> dark_sidebar<?php endif ;?>">
       <div class="tabs-item clearfix">
   			<?php if ($tabs1 == 'popular') :?>
            	<?php rehub_most_popular_widget_block($basedby, $sortby);?>
            <?php elseif ($tabs1 == 'comments'):?>
            	<?php rehub_latest_comment_widget_block();?>
            <?php elseif ($tabs1 == 'category'):?>	
            	<?php rehub_category_widget_block();?>
            <?php else : ?>            
            	<div class="tagcloud"><?php wp_tag_cloud(); ?></div> 	            
            <?php endif ;?>	      	
       	</div>
       <div class="tabs-item">
          	<?php if ($tabs2 == 'popular') :?>
            	<?php rehub_most_popular_widget_block($basedbysec, $sortbysec);?>
            <?php elseif ($tabs2 == 'comments'):?>
            	<?php rehub_latest_comment_widget_block();?>
            <?php elseif ($tabs2 == 'category'):?>	
            	<?php rehub_category_widget_block();?>
            <?php else : ?>            
            	<div class="tagcloud"><?php wp_tag_cloud(); ?></div>	            
            <?php endif ;?>	    	
       	</div>
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
		$instance['tabs1'] = $new_instance['tabs1'];
		$instance['tabs2'] = $new_instance['tabs2'];
		$instance['sortby'] = $new_instance['sortby'];
		$instance['sortbysec'] = $new_instance['sortbysec'];
		$instance['basedby'] = $new_instance['basedby'];
		$instance['basedbysec'] = $new_instance['basedbysec'];
		$instance['dark'] =  $new_instance['dark'];
		$instance['titlefirst'] = strip_tags($new_instance['titlefirst']);
		$instance['titlesecond'] = strip_tags($new_instance['titlesecond']);

		if (function_exists('icl_register_string')) {
			icl_register_string( 'Widget title' , 'widget_title_'.$this->id, $new_instance['titlefirst'] );
			icl_register_string( 'Widget title second' , 'widget_title_second'.$this->id, $new_instance['titlesecond'] );
		}		

		return $instance;
	}


	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'tabs1' => 'popular', 'tabs2' => 'comments', 'sortby' => 'all_time', 'sortbysec' => 'all_time', 'basedby' => 'comments', 'basedbysec' => 'views', 'titlefirst' => __('Popular', 'rehub_framework'),  'titlesecond' => __('Comments', 'rehub_framework'), 'dark' =>'');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<script type="text/javascript">
			jQuery(document).ready(function($) {
				var tabsrehfirst = $('#<?php echo $this->get_field_id("tabs1"); ?>');
				var tabsrehsec = $('#<?php echo $this->get_field_id("tabs2"); ?>');
			    if( tabsrehfirst.val()==="popular"){
			    	tabsrehfirst.parent().parent().find(".tabbaserehubfirst, .tabsortrehubfirst").show()
			    }
			    else{
			    	tabsrehfirst.parent().parent().find(".tabbaserehubfirst, .tabsortrehubfirst").hide()
			    }
			    if( tabsrehsec.val()==="popular"){
			    	tabsrehsec.parent().parent().find(".tabbaserehubsecond, .tabsortrehubsec").show()
			    }
			    else{
			    	tabsrehsec.parent().parent().find(".tabbaserehubsecond, .tabsortrehubsec").hide()
			    }			    				
				tabsrehfirst.on('change',function(){
				    if( $(this).val()==="popular"){
				    $(this).parent().parent().find(".tabbaserehubfirst, .tabsortrehubfirst").show()
				    }
				    else{
				    $(this).parent().parent().find(".tabbaserehubfirst, .tabsortrehubfirst").hide()
				    }
				});
				$('#<?php echo $this->get_field_id("tabs2"); ?>').on('change',function(){
				    if( $(this).val()==="popular"){
				    $(this).parent().parent().find(".tabbaserehubsecond, .tabsortrehubsec").show()
				    }
				    else{
				    $(this).parent().parent().find(".tabbaserehubsecond, .tabsortrehubsec").hide()
				    }
				});				
			});
		</script>		
		<div>
		<p><em style="color:red;"><?php _e('Use this widget only in sidebar area!', 'rehub_framework');?></em></p>
				
		<p>
		<label for="<?php echo $this->get_field_id('tabs1'); ?>"><?php _e('Content for 1 tab', 'rehub_framework');?></label> 
		<select id="<?php echo $this->get_field_id('tabs1'); ?>" name="<?php echo $this->get_field_name('tabs1'); ?>" style="width:100%;">
			<option value='popular' <?php if ( 'popular' == $instance['tabs1'] ) : echo 'selected="selected"'; endif; ?>><?php _e('Popular posts', 'rehub_framework');?></option>
			<option value='comments' <?php if ( 'comments' == $instance['tabs1'] ) : echo 'selected="selected"'; endif; ?>><?php _e('Latest comments', 'rehub_framework');?></option>
			<option value='category' <?php if ( 'category' == $instance['tabs1'] ) : echo 'selected="selected"'; endif; ?>><?php _e('Category list', 'rehub_framework');?></option>
			<option value='tags' <?php if ( 'tags' == $instance['tabs1'] ) : echo 'selected="selected"'; endif; ?>><?php _e('Tags cloud', 'rehub_framework');?></option>
		</select>
		</p>

		<p>
		<label for="<?php echo $this->get_field_id('tabs2'); ?>"><?php _e('Content for 2 tab', 'rehub_framework');?></label> 
		<select id="<?php echo $this->get_field_id('tabs2'); ?>" name="<?php echo $this->get_field_name('tabs2'); ?>" style="width:100%;">
			<option value='popular' <?php if ( 'popular' == $instance['tabs2'] ) : echo 'selected="selected"'; endif; ?>><?php _e('Popular posts', 'rehub_framework');?></option>
			<option value='comments' <?php if ( 'comments' == $instance['tabs2'] ) : echo 'selected="selected"'; endif; ?>><?php _e('Latest comments', 'rehub_framework');?></option>
			<option value='category' <?php if ( 'category' == $instance['tabs2'] ) : echo 'selected="selected"'; endif; ?>><?php _e('Category list', 'rehub_framework');?></option>
			<option value='tags' <?php if ( 'tags' == $instance['tabs2'] ) : echo 'selected="selected"'; endif; ?>><?php _e('Tags cloud', 'rehub_framework');?></option>
		</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'titlefirst' ); ?>"><?php _e('Enter title for first tab:', 'rehub_framework'); ?></label>
			<input  type="text" class="widefat" id="<?php echo $this->get_field_id( 'titlefirst' ); ?>" name="<?php echo $this->get_field_name( 'titlefirst' ); ?>" value="<?php echo $instance['titlefirst']; ?>"  />
			<span><em><?php _e('Note, maximum 15 symbols!', 'rehub_framework');?></em></span>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'titlesecond' ); ?>"><?php _e('Enter title for second tab', 'rehub_framework'); ?></label>
			<input  type="text" class="widefat" id="<?php echo $this->get_field_id( 'titlesecond' ); ?>" name="<?php echo $this->get_field_name( 'titlesecond' ); ?>" value="<?php echo $instance['titlesecond']; ?>"  />
		</p>				

		<p class="tabsortrehubfirst">
		<label for="<?php echo $this->get_field_id('sortby'); ?>"><?php _e('Popular posts for tab 1 published by:', 'rehub_framework');?></label> 
		<select id="<?php echo $this->get_field_id('sortby'); ?>" name="<?php echo $this->get_field_name('sortby'); ?>" style="width:100%;">
			<option value='all_time' <?php if ( 'all_time' == $instance['sortby'] ) : echo 'selected="selected"'; endif; ?>><?php _e('all time', 'rehub_framework');?></option>
			<option value='this_week' <?php if ( 'this_week' == $instance['sortby'] ) : echo 'selected="selected"'; endif; ?>><?php _e('this week', 'rehub_framework');?></option>
			<option value='this_month' <?php if ( 'this_month' == $instance['sortby'] ) : echo 'selected="selected"'; endif; ?>><?php _e('this month', 'rehub_framework');?></option>
			<option value='three_month' <?php if ( 'three_month' == $instance['sortby'] ) : echo 'selected="selected"'; endif; ?>><?php _e('last 3 month', 'rehub_framework');?></option>
		</select>
		</p>
		<p class="tabbaserehubfirst">
		<label for="<?php echo $this->get_field_id('basedby'); ?>"><?php _e('Popular posts for tab 1 based on:', 'rehub_framework');?></label> 
		<select id="<?php echo $this->get_field_id('basedby'); ?>" name="<?php echo $this->get_field_name('basedby'); ?>" style="width:100%;">
			<option value='comments' <?php if ( 'comments' == $instance['basedby'] ) : echo 'selected="selected"'; endif; ?>><?php _e('Comments', 'rehub_framework');?></option>
			<option value='views' <?php if ( 'views' == $instance['basedby'] ) : echo 'selected="selected"'; endif; ?>><?php _e('Post views', 'rehub_framework');?></option>
		</select>
		<span><em><?php _e('Note, post views may not work if you use cache plugins!', 'rehub_framework');?></em></span>		
		</p>		
		<p class="tabsortrehubsec">
		<label for="<?php echo $this->get_field_id('sortbysec'); ?>"><?php _e('Popular posts for tab 2 published by:', 'rehub_framework');?></label> 
		<select id="<?php echo $this->get_field_id('sortbysec'); ?>" name="<?php echo $this->get_field_name('sortbysec'); ?>" style="width:100%;">
			<option value='all_time' <?php if ( 'all_time' == $instance['sortbysec'] ) : echo 'selected="selected"'; endif; ?>><?php _e('all time', 'rehub_framework');?></option>
			<option value='this_week' <?php if ( 'this_week' == $instance['sortbysec'] ) : echo 'selected="selected"'; endif; ?>><?php _e('this week', 'rehub_framework');?></option>
			<option value='this_month' <?php if ( 'this_month' == $instance['sortbysec'] ) : echo 'selected="selected"'; endif; ?>><?php _e('this month', 'rehub_framework');?></option>
			<option value='three_month' <?php if ( 'three_month' == $instance['sortbysec'] ) : echo 'selected="selected"'; endif; ?>><?php _e('last 3 month', 'rehub_framework');?></option>
		</select>
		</p>		
		<p class="tabbaserehubsecond">
		<label for="<?php echo $this->get_field_id('basedbysec'); ?>"><?php _e('Popular posts for tab 2 based on:', 'rehub_framework');?></label> 
		<select id="<?php echo $this->get_field_id('basedbysec'); ?>" name="<?php echo $this->get_field_name('basedbysec'); ?>" style="width:100%;">
			<option value='comments' <?php if ( 'comments' == $instance['basedbysec'] ) : echo 'selected="selected"'; endif; ?>><?php _e('Comments', 'rehub_framework');?></option>
			<option value='views' <?php if ( 'views' == $instance['basedbysec'] ) : echo 'selected="selected"'; endif; ?>><?php _e('Post views', 'rehub_framework');?></option>
		</select>
		<span><em><?php _e('Note, post views may not work if you use cache plugins!', 'rehub_framework');?></em></span>		
		</p>						
		<p>
			<label for="<?php echo $this->get_field_id( 'dark' ); ?>"><?php _e('Dark Skin ?', 'rehub_framework'); ?></label>
			<input id="<?php echo $this->get_field_id( 'dark' ); ?>" name="<?php echo $this->get_field_name( 'dark' ); ?>" value="true" <?php if( $instance['dark'] ) echo 'checked="checked"'; ?> type="checkbox" />
		</p>		
		</div>


	<?php
	}


}

?>