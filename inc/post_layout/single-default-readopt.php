<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<!-- CONTENT -->
<div class="rh-container"> 
    <div class="rh-content-wrap clearfix">
        <!-- Main Side -->
        <div class="main-side single post-readopt full_width clearfix">            
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <article class="post <?php $category = get_the_category($post->ID); if ($category) {$first_cat = $category[0]->term_id; echo 'category-'.$first_cat.'';} ?>" id="post-<?php the_ID(); ?>">               
                    <!-- Title area -->
                    <div class="rh_post_layout_metabig">
                        <div class="title_single_area">
                            <?php if(rehub_option('compare_btn_single') !='' && is_singular('post')) :?>
                                <?php $cmp_btn_args = array();?>
                                <?php if(rehub_option('compare_btn_cats') != '') {
                                    $cmp_btn_args['cats'] = esc_html(rehub_option('compare_btn_cats'));
                                }?>
                                <?php echo wpsm_comparison_button($cmp_btn_args); ?> 
                            <?php endif;?>
                            <?php 
                                $crumb = '';
                                if( function_exists( 'yoast_breadcrumb' ) ) {
                                    $crumb = yoast_breadcrumb('<div class="breadcrumb">','</div>', false);
                                }
                                if( ! is_string( $crumb ) || $crumb === '' ) {
                                    if(rehub_option('rehub_disable_breadcrumbs') == '1' || vp_metabox('rehub_post_side.disable_parts') == '1') {echo '';}
                                    elseif (function_exists('dimox_breadcrumbs')) {
                                        dimox_breadcrumbs(); 
                                    }
                                }
                                echo $crumb;  
                            ?> 
                            <?php echo re_badge_create('labelsmall'); ?><?php rh_post_header_cat('post', true);?>                        
                            <h1><?php the_title(); ?></h1>                                                           

 
                                                       
                        </div>
                    </div>
                    <?php if(rehub_option('rehub_single_after_title')) : ?><div class="mediad mediad_top"><?php echo do_shortcode(rehub_option('rehub_single_after_title')); ?></div><div class="clearfix"></div><?php endif; ?>                         
                    <div class="feature-post-section">
                        <div class="post-meta-left">
                            <?php $author_id=$post->post_author; ?>
                            <a href="<?php echo get_author_posts_url( $author_id ) ?>" class="redopt-aut-picture">
                                <?php echo get_avatar( $author_id, '100' ); ?>                   
                            </a>
                            <a href="<?php echo get_author_posts_url( $author_id ) ?>" class="redopt-aut-link">             
                                <?php the_author_meta( 'display_name', $author_id ); ?>         
                            </a>
                            <div class="date_time_post"><?php the_time(get_option( 'date_format' )); ?></div>
                            <?php if(rehub_option('rehub_disable_share_top') =='1' || vp_metabox('rehub_post_side.disable_parts') == '1')  : ?>
                            <?php else :?>
                                <div class="top_share">
                                    <?php include(rh_locate_template('inc/parts/post_share.php')); ?>
                                </div>
                                <div class="clearfix"></div> 
                            <?php endif; ?>                                     
                        </div> 
                        <?php include(rh_locate_template('inc/parts/top_image.php')); ?>  
                    </div>                                                            
                    <?php if(rehub_option('rehub_single_before_post') && vp_metabox('rehub_post_side.show_banner_ads') != '1') : ?><div class="mediad mediad_before_content"><?php echo do_shortcode(rehub_option('rehub_single_before_post')); ?></div><?php endif; ?>

                    <div class="post-inner"><?php the_content(); ?></div>


                </article>
                <div class="clearfix"></div>
                <?php include(rh_locate_template('inc/post_layout/single-common-footer.php')); ?>                    
            <?php endwhile; endif; ?>
            <?php comments_template(); ?>
        </div>  
        <!-- /Main Side -->  
    </div>
</div>
<!-- /CONTENT -->     