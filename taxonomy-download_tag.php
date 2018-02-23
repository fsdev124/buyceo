<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php get_header(); ?>
<!-- CONTENT -->
<div class="rh-container"> 
    <div class="rh-content-wrap clearfix">
        <!-- Main Side -->
        <div class="main-side clearfix<?php if (rehub_option('rehub_framework_edd_layout') == 'rehub_framework_edd_gridfull') : ?> full_width<?php endif ;?>">
            <div class="wpsm-title middle-size-title wpsm-cat-title"><h5><span><?php _e('Tag:', 'rehub_framework'); ?></span> <?php single_tag_title(); ?></h5></div>
            <?php if (rehub_option('rehub_framework_edd_layout') == 'rehub_framework_edd_list') : ?>
                <div class="edd_downloads_list edd_download_columns_1">
            <?php elseif (rehub_option('rehub_framework_edd_layout') == 'rehub_framework_edd_gridfull') : ?>
                <div class="masonry_grid_fullwidth col_wrap_three">
                <?php  wp_enqueue_script('masonry'); wp_enqueue_script('imagesloaded'); wp_enqueue_script('masonry_init'); ?>                
            <?php elseif (rehub_option('rehub_framework_edd_layout') == 'rehub_framework_edd_grid') : ?>
                <div class="masonry_grid_fullwidth col_wrap_two">
                <?php  wp_enqueue_script('masonry'); wp_enqueue_script('imagesloaded'); wp_enqueue_script('masonry_init'); ?>
            <?php else :?>
                <div class="edd_downloads_list edd_download_columns_1">
            <?php endif ;?>
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?> 

            <?php if (rehub_option('rehub_framework_edd_layout') != 'rehub_framework_edd_list') : ?>
                <article class="small_post col_item edd_masonry_grid" itemtype="http://schema.org/Product" itemscope="">
                    <h2 itemprop="name"><a href="<?php the_permalink();?>"><?php the_title_attribute();?></a></h2>
                    <div class="meta post-meta"><i class="fa fa-circle"></i>
                    <?php $terms = get_the_terms($post->ID, 'download_category' );
                        if ($terms && ! is_wp_error($terms)) :
                        $term_slugs_arr = array();
                        foreach ($terms as $term) {
                            $term_slugs_arr[] = '<a href="'.get_term_link( $term->slug, 'download_category' ).'" class="cat">'.$term->name.'</a>';
                        }
                        $terms_slug_str = join("|", $term_slugs_arr);
                        endif;
                        echo $terms_slug_str; ?>       
                    </div>
                    <?php rehub_get_user_resultsedd('small') ?>                     
                    <?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
                        <figure>
                            <div class="pattern"></div>
                            <a href="<?php the_permalink();?>">
                                <?php wpsm_thumb ('grid_news') ?>
                            </a>
                        </figure>                                     
                    <?php } ?>   
                    <p itemprop="description"><?php kama_excerpt('maxchar=130'); ?></p>
                    <div class="edd_download_buy_button">
                        <?php echo edd_get_purchase_link( array( 'download_id' => get_the_ID() ) ); ?>
                    </div>
                </article>
            <?php else :?>
                <div class="edd_download" itemtype="http://schema.org/Product" itemscope="">
                    <div class="edd_download_inner">
                        <div class="edd_download_image">
                            <?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
                                <a href="<?php the_permalink();?>">
                                    <?php wpsm_thumb ('grid_news') ?>
                                </a>                                     
                        <?php } ?>
                        <?php rehub_get_user_resultsedd('small') ?>                       
                        </div>
                        <div class="edd_download_text">
                            <h3 class="edd_download_title" itemprop="name"><a href="<?php the_permalink();?>"><?php the_title_attribute();?></a></h3>
                            <div class="edd_download_excerpt" itemprop="description">
                                <p><?php kama_excerpt('maxchar=120'); ?></p>
                            </div>
                        </div>
                        <div class="edd_download_buy_button">
                            <?php echo edd_get_purchase_link( array( 'download_id' => get_the_ID() ) ); ?>
                        </div>
                    </div> 
                </div> 
                <div class="clearfix"></div>              
                
            <?php endif ;?>

            <?php endwhile; ?>
                </div>
                <div class="pagination">
                    <?php 
                        global $wp_query;
                        
                        $big = 999999999; // need an unlikely integer
                        
                        echo paginate_links( array(
                            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                            'format' => '?paged=%#%',
                            'current' => max( 1, get_query_var('paged') ),
                            'total' => $wp_query->max_num_pages,
                            'type' => 'list',                            
                        ) );
                    ?>
                

            <?php else : ?>     
                <div class="wpsm-title middle-size-title wpsm-cat-title"><h5><?php _e('Sorry. No posts in this category yet', 'rehub_framework'); ?></h5></div>                
            <?php endif; ?>
            </div>  
        </div>
        <!-- /Main Side -->
        <?php if (rehub_option('rehub_framework_edd_layout') != 'rehub_framework_edd_gridfull') : ?>
        <!-- Sidebar -->
            <?php get_sidebar(); ?>
        <!-- /Sidebar --> 
        <?php endif ;?>
    </div>
</div>
<!-- /CONTENT -->     
<!-- FOOTER -->
<?php get_footer(); ?>