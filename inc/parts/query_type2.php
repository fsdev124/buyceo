<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php global $post;?>
<article class="blog_string rh-cartbox clearfix<?php if(is_sticky()) {echo " sticky";} ?>"> 
    <div class="blog_string_container">
        <h2><?php if(is_sticky()) {echo "<i class='fa fa-thumb-tack'></i>";} ?><a href="<?php the_permalink();?>"><?php the_title();?></a>
        </h2>
        <div class="meta post-meta-big">
            <?php rh_post_header_meta_big();?> 
        </div> 
    </div>         
    <figure>
        <?php rh_post_header_cat('post', false);?>
        <a href="<?php the_permalink();?>"><?php WPSM_image_resizer::show_static_resized_image(array('thumb'=> true, 'crop'=> true, 'width'=> 800, 'height'=> 400, 'no_thumb_url' => get_template_directory_uri() . '/images/default/noimage_765_460.jpg'));?></a> 
        <div class="rev-in-blog-circle">
            <?php $rating_score_clean = get_post_meta($post->ID, 'rehub_review_overall_score', true); ?>
            <?php if ($rating_score_clean):?>
                <div class="radial-progress" data-rating="<?php echo $rating_score_clean?>">
                    <div class="circle">
                        <div class="mask full" style="border-spacing:<?php echo $rating_score_clean * 18;?>px; transform: rotate(<?php echo $rating_score_clean * 18;?>deg);">
                            <div class="fill" style="border-spacing:<?php echo $rating_score_clean * 18;?>px;transform: rotate(<?php echo $rating_score_clean * 18;?>deg);"></div>
                        </div>
                        <div class="mask half">
                            <div class="fill" style="border-spacing:<?php echo $rating_score_clean * 18;?>px;transform: rotate(<?php echo $rating_score_clean * 18;?>deg);"></div>
                            <div class="fill fix" style="border-spacing:<?php echo $rating_score_clean * 36;?>px;transform: rotate(<?php echo $rating_score_clean * 36;?>deg);"></div>
                        </div>
                        
                    </div>
                    <div class="inset">
                        <div class="percentage"><?php echo $rating_score_clean?></div>
                    </div>
                </div>                                                            
            <?php endif;?>                                                        
        </div>               
    </figure>
    <div class="blog_string_info">
        <div class="blog_string_holder">  
            <p><?php kama_excerpt('maxchar=300'); ?></p>
            <?php do_action( 'rehub_after_blog_list_text' ); ?>
            <?php if(rehub_option('disable_btn_offer_loop')!='1')  : ?><?php rehub_create_btn('yes') ;?><?php endif; ?>
            <?php do_action( 'rehub_after_blog_list' ); ?>                        
        </div>
    </div>                                     
</article>