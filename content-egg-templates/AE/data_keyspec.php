<?php
/*
  Name: Item features (beta) 
 */

?>
<?php if (isset($title) && $title): ?>
    <h3 class="cegg-shortcode-title"><?php echo esc_html($title); ?></h3>
<?php endif; ?>
<?php foreach ($items as $item): ?>
	<?php $keys = (!empty($item['extra']['keyfeatures'])) ? $item['extra']['keyfeatures'] : ''; ?>
	<?php if($keys):?>
        <ul class="featured_list">
            <?php foreach ($keys as $key) :?>
                <li><?php echo $key; ?></li>
            <?php endforeach; ?>   
        </ul>  
	<?php endif;?>
<?php endforeach; ?>     