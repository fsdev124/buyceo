<?php
/*
 * Name: Slider
 * 
 */
?>


<?php if (isset($title) && $title): ?>
    <h3 class="cegg-shortcode-title"><?php echo esc_html($title); ?></h3>
<?php endif; ?>
<div class="modulo-lightbox rh-flex-eq-height compare-full-thumbnails mb20"> 
    <?php $random_key = rand(0, 50);?>
    <?php  wp_enqueue_script('modulobox'); wp_enqueue_style('modulobox');?>
    <?php 
        foreach ($items as $item) {
    ?> 
        <a href="<?php echo $item['url'];?>" data-rel="ceyoutube_gallery_<?php echo $random_key;?>" target="_blank" class="mb10 rh_videothumb_link mobileblockdisplay" data-poster="<?php echo parse_video_url($item['url'], 'hqthumb'); ?>" data-thumb="<?php echo $item['img']?>"> 
            <img src="<?php echo $item['img']?>" alt="<?php echo $item['title']?>" />
        </a>                                                                                                                  
    <?php
        }
    ?>
</div>