<?php
/*
  Name: Responsive with description
 */
?>
<?php if (isset($title) && $title): ?>
    <h3 class="cegg-shortcode-title"><?php echo esc_html($title); ?></h3>
<?php endif; ?>
<?php foreach ($items as $item): ?>
<div class="media_video clearfix">
    <div class="clearfix inner">
        <div class="video-container">
            <iframe width="703" height="395" src="https://www.youtube.com/embed/<?php echo $item['extra']['guid']; ?>" frameborder="0" allowfullscreen></iframe>            
        </div>
        <h4><?php echo esc_html($item['title']); ?></h4>
        <?php if ($item['description']): ?>
            <p><?php echo $item['description']; ?></p>
        <?php endif; ?>        
    </div>
</div>
<?php endforeach; ?>