<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php 
	$args = array(
		'showposts' => $fetch,
	);
	$args['tax_query'] = array(array('taxonomy' => trim($catslug), 'terms' => trim($catname), 'field' => 'name'));
	wp_enqueue_script('totemticker');
?>
<!-- NEWS SLIDER -->
<div class="top_theme">
	<h5><strong><?php echo $label;?></strong></h5>
	<div class="scrollers"> <span class="scroller down"></span> <span class="scroller up"></span> </div>
	<ul class="wpsm-news-ticker">
	<?php $pq = new WP_Query($args); 
		  if( $pq->have_posts() ) : while($pq->have_posts()) : $pq->the_post(); ?>
		<li><a href="<?php the_permalink();?>"><?php the_title();?></a></li>
	<?php endwhile; wp_reset_postdata(); endif;?>	
	</ul>
	<div class="clearfix"></div>
</div>