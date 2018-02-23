<?php
/*
 * Name: Image Slider
 * 
 */
?>
<?php  wp_enqueue_script('flexslider'); ?>
<div class="flexslider post_slider media_slider blog_slider loading"> 
    <ul class="slides">
        <?php foreach ($items as $item):?>
            <?php $gallery_images = (!empty ($item['extra']['imageSet'])) ? $item['extra']['imageSet'] : ''?>
            <?php if (!empty($gallery_images)):?>
                <?php foreach ($gallery_images as $gallery_img):?>
                    <?php $large_image = (!empty($gallery_img['LargeImage'])) ? $gallery_img['LargeImage'] : ''; ?>
                    <?php $small_image = (!empty($gallery_img['ThumbnailImage'])) ? $gallery_img['ThumbnailImage'] : ''; ?>
                    <?php include(rh_locate_template('inc/ce_common/data_image_slider.php')); ?>
                <?php endforeach;?>
            <?php endif;?>
        <?php endforeach;?>  
    </ul>
</div>  