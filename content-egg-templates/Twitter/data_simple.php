<?php
/*
  Name: Simple
 */

?>
<?php if (isset($title) && $title): ?>
    <h3 class="cegg-shortcode-title"><?php echo esc_html($title); ?></h3>
<?php endif; ?>
<div class="egg-wrap twi-wrap">
    <?php foreach ($items as $item): ?>
        <div class="twi_profile">
            <?php if ($item['profileImage']) :?>
                <img style="max-width: 30px;" class="twi-avatar" src="<?php echo $item['profileImage']; ?>" alt="<?php echo esc_html($item['extra']['author']); ?>" />
            <?php endif;?>
            <?php if ($item['extra']['author']) :?>
                <a rel="nofollow" target="_blank" href="<?php echo $item['url']; ?>">@<?php echo esc_html($item['extra']['author']); ?></a>
            <?php endif;?>
            <?php if ($item['extra']['followersCount']) :?>
                <a rel="nofollow" target="_blank" href="<?php echo $item['url']; ?>" class="twi-follow-btn" title="<?php echo esc_html($item['extra']['followersCount']); ?>"><i class="fa fa-twitter"></i> <?php _e('Follow', 'rehub_framework') ;?></a>
            <?php endif;?>                        
        </div>
        <div class="media">
            <div class="media-body">
                <p><?php echo $item['description']; ?></p>
            </div>        
            <?php if ($item['img']): ?>
                <div class="media-right">
                    <img style="max-width: 100px;" class="thumbnail" src="<?php echo $item['img']; ?>" alt="<?php echo esc_attr($item['title']); ?>" />
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>