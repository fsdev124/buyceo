<?php
/**
 * Group Locator "default" search results template file. 
 * 
 * The information on this file will be displayed as the groups search results.
 * 
 * The function pass 1 args for you to use:
 * $gmw  - the form being used ( array )
 * 
 * You could but It is not recomemnded to edit this file directly as your changes will be overridden on the next update of the plugin.
 * Instead you can copy-paste this template ( the "default" folder contains this file and the "css" folder ) 
 * into the theme's or child theme's folder of your site and apply your changes from there. 
 * 
 * The template folder will need to be placed under:
 * your-theme's-or-child-theme's-folder/geo-my-wp/groups/search-results/
 * 
 * Once the template folder is in the theme's folder you will be able to choose it when editing the Groups locator form.
 * It will show in the "Search results" dropdown menu as "Custom: default".
 */
?>
<!--  Main results wrapper - wraps the paginations, map and results -->
<div class="gmw-results-wrapper gmw-results-wrapper-<?php echo $gmw['ID']; ?> gmw-gl-default-results-wrapper mt20">
<div id="buddypress">
	<?php do_action( 'gmw_search_results_start', $gmw ); ?>

    <!-- GEO my WP Map -->
	<?php gmw_results_map( $gmw ); ?>

	<div id="pag-top" class="geo-pagination mb30">

	<div class="mb20" id="group-dir-count-top">
		<?php bp_groups_pagination_count(); ?><?php gmw_results_message( $gmw, false ); ?>
	</div>

		<div class="pag-order floatleft" >
			<?php gmw_gl_orderby_dropdown( $gmw, '', '' ); ?>
		</div>
		
		<?php gmw_per_page( $gmw, $gmw['total_results'], 'paged' ); ?>
			
		<div class="pagination-links" id="group-dir-pag-top">
			<?php gmw_pagination( $gmw, 'paged', $gmw['max_pages'] ); ?>
		</div>
	</div>
	
	<?php do_action( 'bp_before_directory_groups_list' ); ?>	

	<div class="rhbp-grid-loop">

	<ul id="groups-list" class="item-list col_wrap_fourth rh-flex-eq-height">
        
    <?php do_action( 'bp_before_directory_groups_list' ); ?>
		
	<?php do_action( 'gmw_search_results_before_loop', $gmw ); ?>
		
	<!-- groups loop  -->
    <?php while ( bp_groups() ) : bp_the_group(); ?>
				
		<!-- do not remove this line -->
		<?php $group = $groups_template->group; ?>
	
		<li <?php bp_group_class( array('col_item') ); ?>>
			<div class="group-inner-list" style="<?php rh_cover_image_url( 'groups', 120, true ); ?>">
                    
            <!-- do not remove this line -->
            <?php do_action( 'gmw_search_results_loop_item_start', $gmw, $group ); ?>
                    		                
            <!-- avatar -->
				<div class="item-avatar">
					<a href="<?php bp_group_permalink(); ?>"><?php bp_group_avatar( 'type=full&width='.$gmw['search_results']['avatar']['width'].'&height='.$gmw['search_results']['avatar']['height'] ); ?></a>
					<?php global $groups_template;
							$count = (int) $groups_template->group->total_member_count; ?>
					<span class="member-count"><?php echo $count; ?></span>
				</div>

			<div class="item">
				<div class="item-title"><a href="<?php bp_group_permalink(); ?>"><?php bp_group_name(); ?></a></div>
				<div class="item-meta"><span class="activity"><?php printf( __( 'active %s', 'rehub_framework' ), bp_get_group_last_active() ); ?></span></div>
				<div class="gmw-gl-radius-wrapper mb10"><?php gmw_distance_to_location( $group, $gmw ); ?></div>
				<!-- address -->
				<div class="gmw-gl-address-wrapper font90 lineheight20 mb10">       	
	            	<span><?php echo $gmw['labels']['search_results']['address'] ?>:</span>
	            	<?php gmw_location_address( $group, $gmw ); ?>
	            </div>
	                        
	            <!--  Driving Distance -->
				<?php if ( isset( $gmw['search_results']['by_driving'] ) ) { ?>
	    			<?php gmw_driving_distance( $group, $gmw, false ); ?>
	    		<?php } ?>				
					<?php do_action( 'bp_directory_groups_item' ); ?>
			</div>    	

			<div class="action">
				<?php do_action( 'bp_directory_groups_actions' ); ?>
				<div class="meta">
					<?php bp_group_type(); ?>
				</div>
			</div>

			<div class="clear"></div>
                        
             <?php do_action( 'gmw_search_results_loop_item_end', $gmw, $group ); ?>
                        
		</div>
		</li>
		
	<?php endwhile; ?>
                
	</ul>

	</div>
	
    <?php do_action( 'gmw_search_results_after_loop', $gmw ); ?>
        
	<?php do_action( 'bp_after_directory_groups_list' ); ?>

	<div id="pag-bottom" class="pagination">

		<div class="pag-count" id="group-dir-count-bottom">
			<?php bp_groups_pagination_count(); ?><?php gmw_results_message( $gmw, false ); ?>
		</div>
		
		<div class="pagination-links" id="group-dir-pag-bottom">
			<?php gmw_pagination( $gmw, 'paged', $gmw['max_pages'] ); ?>
		</div>

	</div>
</div>
</div>