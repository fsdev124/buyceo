<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<!-- CONTENT -->
<div class="rh-container"> 
    <div class="rh-content-wrap clearfix">
	    <!-- Main Side -->
        <div class="main-side single<?php if(get_post_meta($post->ID, 'post_size', true) == 'full_post') : ?> full_width<?php endif; ?> clearfix">            
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <article class="post post-inner <?php $category = get_the_category($post->ID); if ($category) {$first_cat = $category[0]->term_id; echo 'category-'.$first_cat.'';} ?><?php echo rh_expired_or_not($post->ID, 'class');?>" id="post-<?php the_ID(); ?>">
                    <!-- Title area -->
                    <div class="rh_post_layout_compact">
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
                        <div class="title_single_area">
                            <?php if(vp_metabox('rehub_post_side.show_featured_image') != '1' && has_post_thumbnail())  : ?>
                                <div class="featured_single_left">
                                    <figure><?php echo re_badge_create('tablelabel'); ?>
                                    <?php 
                                        $showimg = new WPSM_image_resizer();
                                        $showimg->use_thumb = true;
                                        $height_figure_single = apply_filters( 're_single_figure_height', 123 );
                                        $showimg->height = $height_figure_single;
                                        $showimg->crop = false;
                                        $showimg->show_resized_image();                                    
                                    ?>
                                    </figure>                             
                                </div>
                            <?php endif;?>
                            <div class="single_top_main">                                     
                                <?php echo rh_expired_or_not($post->ID, 'span');?><h1 class="<?php if(rehub_option('hotmeter_disable') !='1') :?><?php echo getHotIconclass($post->ID); ?><?php endif ;?>"><?php the_title(); ?></h1>                                                        
                                <div class="meta post-meta">
                                    <?php meta_all(true, false, 'full', true);?><span class="more-from-store-a"><?php WPSM_Postfilters::re_show_brand_tax('list');?></span>                           
                                </div>  
                                <?php if(rehub_option('rehub_disable_share_top') =='1' || vp_metabox('rehub_post_side.disable_parts') == '1')  : ?>
                                <?php else :?>
                                    <div class="top_share"><?php include(rh_locate_template('inc/parts/post_share.php')); ?></div>
                                    <div class="clearfix"></div> 
                                <?php endif; ?>                                                                                          
                            </div> 
                            <div class="single_top_corner">
                                <?php if(rehub_option('compare_btn_single') !='' && is_singular('post')) :?>
                                    <?php $cmp_btn_args = array();?>
                                    <?php if(rehub_option('compare_btn_cats') != '') {
                                        $cmp_btn_args['cats'] = esc_html(rehub_option('compare_btn_cats'));
                                    }?>
                                    <?php echo wpsm_comparison_button($cmp_btn_args); ?> 
                                <?php endif;?>                              
                                <div class="brand_logo_small floatright">       
                                    <?php WPSM_Postfilters::re_show_brand_tax('logo'); //show brand logo?>
                                </div>                                                           
                            </div> 
                        </div>                                                 
                        <?php if(rehub_option('rehub_single_after_title')) : ?><div class="mediad mediad_top"><?php echo do_shortcode(rehub_option('rehub_single_after_title')); ?></div><div class="clearfix"></div><?php endif; ?> 

                        <?php if(vp_metabox('rehub_post_side.disable_cta') != '1' && is_singular('post'))  : ?>      
                            <div class="single_top_postproduct">
                                <div class="left_st_postproduct">
                                    <?php if(rehub_option('hotmeter_disable') !='1') :?><?php echo getHotThumb($post->ID, false, true); ?><?php endif ;?>
                                    <div class="meta post-meta"><?php meta_small(false, false, true, true);?> </div>
                                </div>
                                <div class="right_st_postproduct">
                                    <?php echo rehub_create_btn_post('');?>
                                </div>                                                                     
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php $no_featured_image_layout = 1;?>
                    <?php include(rh_locate_template('inc/parts/top_image.php')); ?>                                       

                    <?php if(rehub_option('rehub_single_before_post') && vp_metabox('rehub_post_side.show_banner_ads') != '1') : ?><div class="mediad mediad_before_content"><?php echo do_shortcode(rehub_option('rehub_single_before_post')); ?></div><?php endif; ?>

                    <?php the_content(); ?>

                </article>
                <div class="clearfix"></div>
                <?php include(rh_locate_template('inc/post_layout/single-common-footer.php')); ?>                    
            <?php endwhile; endif; ?>
            <?php comments_template(); ?>
		</div>	
        <!-- /Main Side -->  
        <!-- Sidebar -->
        <?php if(get_post_meta($post->ID, 'post_size', true) == 'full_post') : ?><?php else : ?><?php get_sidebar(); ?><?php endif; ?>
        <!-- /Sidebar -->
    </div>
</div>
<!-- /CONTENT -->     