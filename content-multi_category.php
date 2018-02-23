<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<div id="post-<?php the_ID(); ?>" class="clearfix multi_cat_artical">
	<div class="multi_cat_image">
		<?php WPSM_image_resizer::show_static_resized_image(array('thumb'=> true, 'crop'=> true, 'width'=> 60, 'height'=> 60, 'no_thumb_url' => get_template_directory_uri() . '/images/noim.png'));?>		
	</div>
	<div class="multi_cat_info">		
		<div class="multi_cat_title"><a href="<?php the_permalink(); ?>" ><?php the_title(); ?></a></div>
	    <div class="post-meta">
	  		<?php $category = get_the_category($post->ID); $first_cat = $category[0]->term_id;?>
	    	<?php meta_small( false, $first_cat, true, false );  ?>
	    </div>
	</div>
</div>
