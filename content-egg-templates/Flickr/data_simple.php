<?php
/*
  Name: Image with description
 */

?>
<?php if (isset($title) && $title): ?>
    <h3 class="cegg-shortcode-title"><?php echo esc_html($title); ?></h3>
<?php endif; ?>
<?php foreach ($items as $item): ?>
    <div class="text-center"><img src="<?php echo $item['img']; ?>" alt="<?php echo ($item['extra']['tags'] ? esc_attr($item['extra']['tags']) : esc_attr($item['keyword'])); ?>" class="img-thumbnail-block" /></div>
    <div class="img-descr text-center mb10">
    <p class="font80 mb10"><?php printf(__('Photo %s on Flickr', 'rehub_framework'), '<a href="' . $item['url'] . '" target="_blank" rel="nofollow">' . $item['extra']['author'] . '</a>'); ?></p>
    <h4><?php echo esc_html($item['title']); ?></h4>
    <p><?php echo $item['description']; ?></p>
    <div class="clearfix"></div>   
    </div>    
<?php endforeach; ?>