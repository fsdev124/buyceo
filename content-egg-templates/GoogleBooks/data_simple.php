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
        <div class="media">
            <?php if ($item['img']): ?>
                <div class="media-left">
                    <img style="max-width: 225px;" class="thumbnail" src="<?php echo $item['img']; ?>" alt="<?php echo esc_attr($item['title']); ?>" />
                </div>
            <?php endif; ?>
            <div class="media-body">
                <h4 class="media-heading">
                    <?php echo esc_html($item['title']); ?>
                </h4>
                <small class="text-meta">
                    <?php if ($item['extra']['publisher']): ?>
                        <?php echo $item['extra']['publisher']; ?>.
                    <?php endif; ?>
                    <?php if ($item['extra']['publisher']): ?>
                        <?php echo date('Y', $item['extra']['date']); ?>
                    <?php endif; ?>
                    <a target="_blank" rel="nofollow" href="<?php echo $item['url']; ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/gbs_preview.gif" /></a>

                </small>
                <p><?php echo $item['description']; ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>