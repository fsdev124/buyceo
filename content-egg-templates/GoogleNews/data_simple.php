<?php
/*
  Name: Simple
 */
?>
<?php if (isset($title) && $title): ?>
    <h3 class="cegg-shortcode-title"><?php echo esc_html($title); ?></h3>
<?php endif; ?>
<div class="egg-wrap">
    <?php foreach ($items as $item): ?>
        <?php 
            $title = (!empty($item['title'])) ? esc_html($item['title']) : '';
            $url = (!empty($item['url'])) ? esc_html($item['url']) : '';
            $img = (!empty($item['img'])) ? esc_html($item['img']) : '';
        ?>
        <div class="media">
            <?php if ($item['img']): ?>
                <div class="media-left">
                    <img style="max-width: 225px;" class="media-object thumbnail" src="<?php echo $item['img']; ?>" alt="<?php echo esc_attr($item['title']); ?>" />
                </div>
            <?php endif; ?>
            <div class="media-body">
                <h4 class="media-heading">
                    <?php echo wpsm_hidelink_shortcode(array('link'=>$url, 'text'=>$title));?>
                </h4>
                <small class="text-meta">
                    <?php echo date(get_option('date_format'), $item['extra']['date']); ?> -
                    <?php echo wpsm_hidelink_shortcode(array('link'=>$url, 'text'=>$item['extra']['source']));?>
                </small>
                <p><?php echo $item['description']; ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>