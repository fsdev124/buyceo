<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php

    /* Template Name: Top rating reviews */

?>
<?php 
    $module_cats = vp_metabox('rehub_top_review.top_review_cat');
    $module_tag = vp_metabox('rehub_top_review.top_review_tag');
    $module_fetch = vp_metabox('rehub_top_review.top_review_fetch');
    $module_width = vp_metabox('rehub_top_review.top_review_width');
    $module_ids = vp_metabox('rehub_top_review.manual_ids');
    $order_choose = vp_metabox('rehub_top_review.top_review_choose');
    $module_desc = vp_metabox('rehub_top_review.top_review_desc');
    $module_desc_fields = vp_metabox('rehub_top_review.top_review_custom_fields');
    $rating_circle = vp_metabox('rehub_top_review.top_review_circle');
    $module_pagination = vp_metabox('rehub_top_review.top_review_pagination');
    $module_field_sorting = vp_metabox('rehub_top_review.top_review_field_sort');
    $module_order = vp_metabox('rehub_top_review.top_review_order');
    $module_enable = vp_metabox('rehub_top_review.shortcode_review_enable');
    if ($module_fetch ==''){$module_fetch = '10';};   
    if ($module_desc ==''){$module_desc = 'post';};
    if ($rating_circle ==''){$rating_circle = '1';};         
?>
<?php get_header(); ?>
<!-- CONTENT -->
<div class="rh-container"> 
    <div class="rh-content-wrap clearfix">    
	    <!-- Main Side -->
        <div class="main-side page clearfix<?php if ($module_width =='1') : ?> full_width<?php endif;?>">
            <div class="title"><h1><?php the_title(); ?></h1></div>
            <?php if (!is_paged()) :?>
                <article class="top_rating_text">
                    <?php if (have_posts()) : while (have_posts()) : the_post(); ?><?php the_content(); ?><?php endwhile; endif; ?>
                </article>
                <div class="clearfix"></div>
            <?php endif; ?>

            <?php if ($module_enable !='1') :?>

            <?php  if ( get_query_var('paged') ) { $paged = get_query_var('paged'); } else if ( get_query_var('page') ) {$paged = get_query_var('page'); } else {$paged = 1; }  ?>
            <?php if ($order_choose == 'cat_choose') :?>
                <?php $args = array( 
                    'cat' => $module_cats, 
                    'tag' => $module_tag, 
                    'posts_per_page' => $module_fetch, 
                    'paged' => $paged, 
                    'post_status' => 'publish', 
                    'ignore_sticky_posts' => 1, 
                    'meta_key' => 'rehub_review_overall_score', 
                    'orderby' => 'meta_value_num',
                    'meta_query' => array(
                        array(
                        'key' => 'rehub_framework_post_type',
                        'value' => 'review',
                        'compare' => 'LIKE',
                        )
                    )
                );
                ?> 
                <?php if(!empty ($module_field_sorting)) {$args['meta_key'] = $module_field_sorting;} ?>
                <?php if($module_order =='asc') {$args['order'] = 'ASC';} ?>
        	<?php elseif ($order_choose == 'manual_choose' && $module_ids !='') :?>
                <?php $args = array( 
                    'post_status' => 'publish', 
                    'ignore_sticky_posts' => 1, 
                    'orderby' => 'post__in',
                    'post__in' => $module_ids,
                    'posts_per_page'=> -1,

                );
                ?>
        	<?php else :?>
                <?php $args = array( 
                    'posts_per_page' => 10, 
                    'paged' => $paged, 
                    'post_status' => 'publish', 
                    'ignore_sticky_posts' => 1, 
                    'meta_key' => 'rehub_review_overall_score', 
                    'orderby' => 'meta_value_num',
                    'meta_query' => array(
                            array(
                            'key' => 'rehub_framework_post_type',
                            'value' => 'review',
                            'compare' => 'LIKE',
                            )
                    )
                );
                ?> 
                <?php if(!empty ($module_field_sorting)) {$args['meta_key'] = $module_field_sorting;} ?>
                <?php if($module_order =='asc') {$args['order'] = 'ASC';} ?>                                		
        	<?php endif ;?>	

            <?php 
            $args = apply_filters('rh_module_args_query', $args);
            $wp_query = new WP_Query($args);
            do_action('rh_after_module_args_query', $wp_query);    
            $i=0; if ($wp_query->have_posts()) :?>
            <div class="top_rating_block<?php if ($module_width =='1') : ?> full_width_rating<?php else :?> with_sidebar_rating<?php endif;?> list_style_rating">
            <?php while ($wp_query->have_posts()) : $wp_query->the_post(); $i ++?>     
                <div class="top_rating_item" id='rank_<?php echo $i?>'>                
                    <div class="product_image_col">                            
                        <figure><?php echo re_badge_create('ribbon'); ?>
                            <?php if (!is_paged()) :?><span class="rank_count"><?php if (($i) == '1') :?><i class="fa fa-trophy"></i><?php else:?><?php echo $i?><?php endif ?></span><?php endif ?>
                            <a href="<?php the_permalink();?>">
                                <?php 
                                $showimg = new WPSM_image_resizer();
                                $showimg->use_thumb = true;
                                $width_figure_rating = apply_filters( 'wpsm_top_rating_figure_width', 120 );
                                $height_figure_rating = apply_filters( 'wpsm_top_rating_figure_height', 120 );
                                $showimg->height = $height_figure_rating;
                                $showimg->crop = true;
                                $showimg->show_resized_image();                                    
                                ?>
                            </a>
                        </figure>
                    </div>                            
                    <div class="desc_col">
                        <h2><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
                        <p>
                        	<?php if ($module_desc =='post') :?>
                        		<?php kama_excerpt('maxchar=120'); ?>
                        	<?php elseif ($module_desc =='review') :?>
                        		<?php echo wp_kses_post(vp_metabox('rehub_post.review_post.0.review_post_summary_text')); ?>
                            <?php elseif ($module_desc =='field') :?>
                                <?php if ( get_post_meta($post->ID, $module_desc_fields, true) ) : ?>
                                    <?php echo get_post_meta($post->ID, $module_desc_fields, true) ?>
                                <?php endif; ?>                                                 
                        	<?php elseif ($module_desc =='none') :?>
                        	<?php else :?>	
                        		<?php kama_excerpt('maxchar=120'); ?>
                    		<?php endif;?>
                        </p>
                        <div class="star"><?php rehub_get_user_results('small', 'yes') ?></div>
                    </div>
                    <div class="rating_col">
                        <?php if ($rating_circle =='1'):?>
                        <?php $rating_score_clean = rehub_get_overall_score(); ?>

                        <div class="top-rating-item-circle-view">
                        <div class="radial-progress" data-rating="<?php echo $rating_score_clean?>">
                            <div class="circle">
                                <div class="mask full">
                                    <div class="fill"></div>
                                </div>
                                <div class="mask half">
                                    <div class="fill"></div>
                                    <div class="fill fix"></div>
                                </div>
                                
                            </div>
                            <div class="inset">
                                <div class="percentage"><?php echo $rating_score_clean?></div>
                            </div>
                        </div>
                        </div>
                        <?php elseif ($rating_circle =='2') :?> 
                            <div class="score square_score"> <span class="it_score"><?php echo rehub_get_overall_score() ?></span></div>       
                        <?php else :?>
                            <div class="score"> <span class="it_score"><?php echo rehub_get_overall_score() ?></span></div>
                        <?php endif ;?>
                    </div>
                    <div class="buttons_col">
                    	<?php rehub_create_btn('') ;?>
                        <a href="<?php the_permalink();?>" class="read_full"><?php if(rehub_option('rehub_review_text') !='') :?><?php echo rehub_option('rehub_review_text') ; ?><?php else :?><?php _e('Read full review', 'rehub_framework'); ?><?php endif ;?></a>
                    </div>
                </div>
            <?php endwhile; ?>
            </div>
            <?php if ($module_pagination =='1') :?><div class="pagination"><?php rehub_pagination();?></div><?php endif ;?>
            <?php else: ?><?php _e('No posts for this criteria.', 'rehub_framework'); ?>
            <?php endif; ?>                
            <?php wp_reset_query(); ?>

            <?php endif; ?>

		</div>	
        <!-- /Main Side -->  
        <?php if ($module_width !='1') : ?>
        <!-- Sidebar -->
        <?php get_sidebar(); ?>
        <!-- /Sidebar --> 
        <?php endif;?>
    </div>
</div>
<!-- /CONTENT -->     
<!-- FOOTER -->
<?php get_footer(); ?>