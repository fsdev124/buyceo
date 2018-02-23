<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php  wp_enqueue_script('flexslider');  ?>
<?php $gallery_images = vp_metabox('rehub_post.gallery_post.0.gallery_post_images'); $resizer = vp_metabox('rehub_post.gallery_post.0.gallery_post_images_resize');?>
<div class="flexslider post_slider media_slider<?php if ($resizer =='1') :?> blog_slider<?php else :?> gallery_top_slider<?php endif ;?> loading"> 
    <i class="fa fa-spinner fa-pulse"></i>
    <ul class="slides">     
        <?php 
            foreach ($gallery_images as $gallery_img) {
        ?>
            <?php if(vp_metabox('rehub_post_side.post_size') == 'full_post') : ?>
                <?php if (!empty ($gallery_img['gallery_post_video'])) :?>
                    <li data-thumb="<?php echo parse_video_url($gallery_img['gallery_post_video'], 'hqthumb'); ?>" class="play3">
                        <?php echo parse_video_url($gallery_img['gallery_post_video'], 'embed', '1150', '604');?>
                    </li>                                            
                <?php else : ?>
                    <li data-thumb="<?php $params = array( 'width' => 116, 'height' => 116, 'crop' => true  ); echo bfi_thumb($gallery_img['gallery_post_image'], $params); ?>">
                        <?php if (!empty ($gallery_img['gallery_post_image_caption'])) :?><div class="bigcaption"><?php echo $gallery_img['gallery_post_image_caption']; ?></div><?php endif;?>
                        <img src="<?php if ($resizer =='1') {$params = array( 'width' => 1150);} else {$params = array( 'width' => 1150, 'height' => 604,  'crop' => true );}; echo bfi_thumb($gallery_img['gallery_post_image'], $params); ?>" />
                    </li>                                           
                <?php endif; ?>                                                                    
            <?php else : ?>
                <?php if (!empty ($gallery_img['gallery_post_video'])) :?>
                    <li data-thumb="<?php echo parse_video_url($gallery_img['gallery_post_video'], 'hqthumb'); ?>" class="play3">
                        <?php echo parse_video_url($gallery_img['gallery_post_video'], 'embed', '788', '478');?>
                    </li>                                            
                <?php else : ?>
                    <li data-thumb="<?php $params = array( 'width' => 80, 'height' => 80, 'crop' => true ); echo bfi_thumb($gallery_img['gallery_post_image'], $params); ?>">
                        <?php if (!empty ($gallery_img['gallery_post_image_caption'])) :?><div class="bigcaption"><?php echo $gallery_img['gallery_post_image_caption']; ?></div><?php endif;?>
                        <img src="<?php if ($resizer =='1') {$params = array( 'width' => 788);} else {$params = array( 'width' => 788, 'height' => 478, 'crop' => true   );}; echo bfi_thumb($gallery_img['gallery_post_image'], $params); ?>" />
                    </li>                                            
                <?php endif; ?>                                                                         
            <?php endif; ?>
        <?php
            }
        ?>
    </ul>
</div>