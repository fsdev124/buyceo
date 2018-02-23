<?php
/*
  Name: Gallery block
 */
use ContentEgg\application\helpers\TemplateHelper;  
?>

<?php $random_key = rand(0, 50);?>
<div class="justified-gallery rh-tilled-gallery modulo-lightbox five-thumbnails" data-galleryid="rhgal_<?php echo $random_key;?>">
    <?php wp_enqueue_script('justifygallery');  wp_enqueue_script('modulobox'); wp_enqueue_style('modulobox'); ?>
    <?php foreach ($items as $item): ?>
        <?php $offer_title = (!empty($item['title'])) ? $item['title'] : ''; ?> 
        <?php $gallery_image = (!empty ($item['img'])) ? $item['img'] : ''?>
        <?php if (!empty ($gallery_image)) :?>
            <a data-rel="rhgal_<?php echo $random_key;?>" href="<?php echo esc_attr($gallery_image) ;?>" class="mb10" target="_blank" rel="nofollow" data-thumb="<?php echo esc_attr($gallery_image) ;?>" data-title="<?php echo $offer_title;?>"> 
            <img src="<?php echo esc_attr($gallery_image) ;?>" alt="<?php echo esc_attr($offer_title); ?>" height="160" />  
            </a>                   
        <?php endif ;?>      
    <?php endforeach; ?>
</div>
<div class="clearfix"></div>