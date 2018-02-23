<?php
/*
 * Name: Small gallery
 * 
 */
?>
<?php if (isset($title) && $title): ?>
    <h3 class="cegg-shortcode-title"><?php echo esc_html($title); ?></h3>
<?php endif; ?>
<?php $random_key = rand(0, 500);?>
<div class="pretty_woo modulo-lightbox">
    <?php wp_enqueue_script('modulobox'); wp_enqueue_style('modulobox');
        foreach ($items as $item) {
            ?> 
            <a data-rel="rhbing_<?php echo $random_key;?>" href="<?php echo esc_attr($item['img']) ;?>" data-thumb="<?php echo esc_attr($item['img']) ;?>"> 
                <img src="<?php echo esc_attr($item['img']) ;?>" alt="<?php echo esc_attr($item['title']); ?>" />  
            </a>
            <?php
        }
    ?>
</div>