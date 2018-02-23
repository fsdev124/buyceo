<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php  wp_enqueue_script('flexslider');   ?>
<?php $review_woo_link = vp_metabox('rehub_post.review_post.0.review_woo_product.0.review_woo_link'); $resizer = vp_metabox('rehub_post.review_post.0.review_woo_product.0.review_woo_slider_resize'); ?>
<?php   
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 1,
        'no_found_rows' => 1,
        'post_status' => 'publish',
        'p' => $review_woo_link,

    );
?>
<?php $products = new WP_Query( $args ); if ( $products->have_posts() ) : ?>                      
    <?php while ( $products->have_posts() ) : $products->the_post(); global $product?>
        <?php $gallery_images = $product->get_gallery_attachment_ids(); ?>
        <?php if ( $gallery_images ) { ?>
            <div class="post_slider flexslider media_slider<?php if ($resizer =='1') :?> blog_slider<?php else :?> gallery_top_slider<?php endif ;?> loading">
                <i class="fa fa-spinner fa-pulse"></i> 
                <ul class="slides">
                <?php if ( has_post_thumbnail($post->ID) ) :?>
                    <?php $image_woo_id = get_post_thumbnail_id($post->ID);  $image_woo_url = wp_get_attachment_url($image_woo_id); ?>
                    <?php if(vp_metabox('rehub_post_side.post_size') == 'full_post') : ?>
                        <li data-thumb="<?php $params = array( 'width' => 116, 'height' => 116, 'crop' => true  ); echo bfi_thumb($image_woo_url, $params); ?>">
                            <img src="<?php if ($resizer =='1') {$params = array( 'width' => 1150);} else {$params = array( 'width' => 1150, 'height' => 604, 'crop' => true    );}; echo bfi_thumb($image_woo_url, $params); ?>" />
                        </li>                                                
                    <?php else : ?>
                        <li data-thumb="<?php $params = array( 'width' => 80, 'height' => 80, 'crop' => true  ); echo bfi_thumb($image_woo_url, $params); ?>">
                            <img src="<?php if ($resizer =='1') {$params = array( 'width' => 765);} else {$params = array( 'width' => 765, 'height' => 478, 'crop' => true    );}; echo bfi_thumb($image_woo_url, $params); ?>" />
                        </li>                                                
                    <?php endif; ?> 
                <?php endif ;?>                                                 
                <?php 
                    foreach ($gallery_images as $gallery_img) {
                ?>
                <?php $thumbimg = wp_get_attachment_url($gallery_img);?>
                    <?php if(vp_metabox('rehub_post_side.post_size') == 'full_post') : ?>
                        <li data-thumb="<?php $params = array( 'width' => 116, 'height' => 116, 'crop' => true  ); echo bfi_thumb($thumbimg, $params); ?>">
                            <img src="<?php if ($resizer =='1') {$params = array( 'width' => 1150);} else {$params = array( 'width' => 1150, 'height' => 604, 'crop' => true    );}; echo bfi_thumb($thumbimg, $params); ?>" />
                        </li>                                                
                    <?php else : ?>
                        <li data-thumb="<?php $params = array( 'width' => 80, 'height' => 80, 'crop' => true  ); echo bfi_thumb($thumbimg, $params); ?>">
                            <img src="<?php if ($resizer =='1') {$params = array( 'width' => 765);} else {$params = array( 'width' => 765, 'height' => 478, 'crop' => true    );}; echo bfi_thumb($thumbimg, $params); ?>" />
                        </li>                                                
                    <?php endif; ?>
                <?php
                    }
                ?>
                </ul>
            </div> 
        <?php } ?>
<?php endwhile; endif;  wp_reset_postdata(); ?> 