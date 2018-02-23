<?php
/**
 * Custom - Results Page.
 * @version 1.0
 * @author Eyal Fitoussi
 */
?>
<!--  Main results wrapper - wraps the paginations, map and results -->
<div class="gmw-results-wrapper gmw-results-wrapper-<?php echo $gmw['ID']; ?> gmw-pt-results-wrapper">
	
	<?php do_action( 'gmw_search_results_start' , $gmw, $post ); ?>
	
	<?php do_action( 'gmw_before_top_pagination' , $gmw, $post ); ?>
	
	<!--  Pagination -->	
	<div class="gmw-pt-pagination-wrapper gmw-pt-bottom-pagination-wrapper">
		<div class="gmw-results-count floatleft">
			<span><?php gmw_results_message( $gmw, false ); ?></span>
		</div>	
		<!--  paginations -->
		<?php gmw_per_page( $gmw, $gmw['total_results'], 'paged' ); ?><?php gmw_pagination( $gmw, 'paged', $gmw['max_pages'] ); ?>
	</div> 
		
	 <!-- GEO my WP Map -->
    <?php 
    if ( $gmw['search_results']['display_map'] == 'results' ) {
        gmw_results_map( $gmw );
    }
    ?>
	
	<?php do_action( 'gmw_search_results_before_loop' , $gmw, $post ); ?>
	
	<!--  Results wrapper -->
	<div class="gmw-posts-wrapper woocommerce">
	
		<div class="products rh-flex-eq-height column_woo col_wrap_three">	
		<!--  this is where wp_query loop begins -->
			<?php $columns = '3_col';?>
			<?php while ( $gmw_query->have_posts() ) : $gmw_query->the_post(); ?>

				<?php include(rh_locate_template('inc/parts/woocolumnpart.php')); ?>

			<?php endwhile; ?>
		<!--  end of the loop -->
		</div>
		
	
	</div> <!--  results wrapper -->    
	
	<?php do_action( 'gmw_search_results_after_loop' , $gmw, $post ); ?>
	
	
</div> <!-- output wrapper -->
