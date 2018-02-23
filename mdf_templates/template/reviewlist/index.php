<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<?php global $mdf_loop; MDTF_SORT_PANEL::mdtf_catalog_ordering();?>
<div class="clearfix"></div>
<div class="top_rating_block full_width_rating list_style_rating">
<?php $i=0; while ($mdf_loop->have_posts()) : $mdf_loop->the_post(); ?>
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
                <?php kama_excerpt('maxchar=120'); ?>
            </p>
            <div class="star"><?php rehub_get_user_results('small', 'yes') ?></div>
        </div>
        <div class="rating_col">
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
        </div>
        <div class="buttons_col">
            <?php rehub_create_btn('') ;?>
            <a href="<?php the_permalink();?>" class="read_full"><?php if(rehub_option('rehub_review_text') !='') :?><?php echo rehub_option('rehub_review_text') ; ?><?php else :?><?php _e('Read full review', 'rehub_framework'); ?><?php endif ;?></a>
        </div>
    </div>
<?php $i++; endwhile; // end of the loop.    ?> 
</div>
<div class="clearfix"></div>