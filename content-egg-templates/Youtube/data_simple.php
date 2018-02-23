<?php
/*
  Name: Responsive simple
 */
?>
<?php if (isset($title) && $title): ?>
    <h3 class="cegg-shortcode-title"><?php echo esc_html($title); ?></h3>
<?php endif; ?>
<?php foreach ($items as $item): ?>
    <div class="video-container">
        <iframe width="703" height="395" src="https://www.youtube.com/embed/<?php echo $item['extra']['guid']; ?>" frameborder="0" allowfullscreen></iframe>           
    </div>
<?php endforeach; ?>