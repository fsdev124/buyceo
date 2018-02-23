<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php 

$base_post = $post;
global $post;
$relatives = (rehub_option('rehub_enable_tag_relative') == '1') ? get_the_tags($post->ID) : get_the_category($post->ID);
if ($relatives) {
	$relative_ids = array();
	foreach($relatives as $individual_relative) $relative_ids[] = $individual_relative->term_id;	
	$args = array(
		'post__not_in'     => array($post->ID),
		'posts_per_page'   => 6,
		'ignore_sticky_posts' => 1
	);
	if (rehub_option('rehub_enable_tag_relative') == '1') {
		$args['tag__in'] = $relative_ids;
	}
	else {
		$args['category__in'] = $relative_ids;
	}
	$my_query = new wp_query( $args );
	if( $my_query->have_posts() ) { ?>
		<div class="related_articles clearfix">
		<div class="related_title">
			<?php if (rehub_option('rehub_related_text') !='') :?>
				<?php echo rehub_option('rehub_related_text');?>
			<?php else :?>
				<?php _e('Related Articles', 'rehub_framework'); ?>
			<?php endif;?>
		</div>
		<ul>
		<?php while( $my_query->have_posts() ) {
			$my_query->the_post();?>
			<li>				
				<a href="<?php echo get_permalink() ?>" class="rh_related_link_image">
				<figure>
				<?php WPSM_image_resizer::show_static_resized_image(array('lazy'=> true, 'thumb'=> true, 'crop'=> false, 'height'=> 130));?>
				</figure>
				</a>			
				<a href="<?php echo get_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>" class="rh_related_link"><?php the_title(); ?></a>
				<?php do_action('rh_related_after_title');?>	
	            <?php if(rehub_option('compare_btn_single') !='' && is_singular('post')) :?>
	                <?php $cmp_btn_args = array(); $cmp_btn_args['class']='mb25';?>
	                <?php if(rehub_option('compare_btn_cats') != '') {
	                    $cmp_btn_args['cats'] = esc_html(rehub_option('compare_btn_cats'));
	                }?>
	                <?php echo wpsm_comparison_button($cmp_btn_args); ?> 
	            <?php endif;?>	
			</li>
		<?php
		}
		echo '</ul></div>';
	}
}
$post = $base_post;
wp_reset_query();
?>