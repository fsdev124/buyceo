<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<!-- CONTENT -->
<div class="rh-container"> 
    <div class="rh-content-wrap clearfix">
	    <!-- Main Side -->
        <div class="main-side single<?php if(get_post_meta($post->ID, 'post_size', true) == 'full_post') : ?> full_width<?php endif; ?> clearfix">            
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <article class="post post-inner <?php $category = get_the_category($post->ID); if ($category) {$first_cat = $category[0]->term_id; echo 'category-'.$first_cat.'';} ?>" id="post-<?php the_ID(); ?>">
                    <!-- Title area -->
                    <div class="rh_post_layout_corner">
                        <?php if(vp_metabox('rehub_post_side.disable_top_offer') != '1')  : ?>
                            <div class="right_aff">
                                <?php 
                                $amazon_search_words = vp_metabox('rehub_post_side.amazon_search_words'); 
                                $ebay_search_words = vp_metabox('rehub_post_side.ebay_search_words');
                                if (!empty($amazon_search_words)) {
                                    $rehub_amazon_btn = (rehub_option('rehub_amazon_btn') !='') ? rehub_option('rehub_amazon_btn') : __('Search on Amazon', 'rehub_framework');
                                    $rehub_amazon_surl = (rehub_option('rehub_amazon_surl') !='') ? rehub_option('rehub_amazon_surl') : 'http://www.amazon.com/gp/search?ie=UTF8&camp=1789&creative=9325&index=aps&linkCode=ur2&tag=wpsoul-20';
                                    $amazon_link = '<a href="'.$rehub_amazon_surl.'&keywords='.esc_html($amazon_search_words).'" target="_blank" rel="nofollow">'.$rehub_amazon_btn.'</a>';
                                }
                                else {
                                    $amazon_link ='';
                                }
                                if (!empty($ebay_search_words)) {
                                    $rehub_ebay_btn = (rehub_option('rehub_ebay_btn') !='') ? rehub_option('rehub_ebay_btn') : __('Search on Ebay', 'rehub_framework');
                                    $rehub_ebay_surl = (rehub_option('rehub_ebay_surl') !='') ? rehub_option('rehub_ebay_surl') : 'http://rover.ebay.com/rover/1/711-53200-19255-0/1?icep_ff3=9&pub=5575130199&toolid=10001&campid=5337712872&customid=&icep_sellerId=&icep_ex_kw=&icep_sortBy=12&icep_catId=&icep_minPrice=&icep_maxPrice=&ipn=psmain&icep_vectorid=229466&kwid=902099&mtid=824&kw=lg';
                                    $ebay_link = '<a href="'.$rehub_ebay_surl.'&icep_uq='.esc_html($ebay_search_words).'" target="_blank" rel="nofollow">'.$rehub_ebay_btn.'</a>';
                                }   
                                else {
                                    $ebay_link ='';
                                }       
                                ?>
                                <?php rehub_create_btn('', '', 1);?>
                                <div class="ameb_search"><?php echo $amazon_link; echo $ebay_link;?></div>
                            </div>
                        <?php endif; //Top offer block with button ?>
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
                            <?php echo re_badge_create('labelsmall'); ?><?php rh_post_header_cat('post', true);?>                            
                            <h1><?php the_title(); ?></h1>                                                        
                            <div class="meta post-meta">
                                <?php rh_post_header_meta(true, true, true, true, false);?>                             
                                <?php if(is_singular('post') && rehub_option('compare_btn_single') !='') :?>
                                    <?php $compare_cats = (rehub_option('compare_btn_cats') != '') ? ' cats="'.esc_html(rehub_option('compare_btn_cats')).'"' : '' ;?>
                                    <?php echo do_shortcode('[wpsm_compare_button'.$compare_cats.']'); ?> 
                                <?php endif;?>                          
                            </div>
                        </div>                                                 
                        <?php if(rehub_option('hotmeter_disable') !='1') :?><?php echo getHotLike(get_the_ID()); ?><?php endif ;?>
                    </div>
                    <?php if(rehub_option('rehub_single_after_title')) : ?><div class="mediad mediad_top"><?php echo do_shortcode(rehub_option('rehub_single_after_title')); ?></div><div class="clearfix"></div><?php endif; ?>     
                    <?php include(rh_locate_template('inc/parts/top_image.php')); ?>
                    <?php echo rh_get_post_thumbnails(array('video'=>1, 'class'=> 'mb30'));?>
                    <?php if(rehub_option('rehub_disable_share_top') !='1' && vp_metabox('rehub_post_side.disable_parts') != '1')  : ?>
                        <div class="top_share">
                            <?php include(rh_locate_template('inc/parts/post_share.php')); ?>
                        </div>
                    <?php endif; ?>                                                           

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