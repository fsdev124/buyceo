<?php
/*
 * Name: Slider
 * 
 */
?>

<?php  wp_enqueue_script('flexslider'); ?>
<?php if (isset($title) && $title): ?>
    <h3 class="cegg-shortcode-title"><?php echo esc_html($title); ?></h3>
<?php endif; ?>
<div class="flexslider post_slider media_slider blog_slider loading"> 
    <ul class="slides">
        <?php 
            foreach ($items as $item) {
        ?>
            <li data-thumb="<?php $params = array( 'width' => 80, 'height' => 80, 'crop' => true  ); echo bfi_thumb($item['img'], $params); ?>">
                <?php if (!empty ($item['title'])) :?><div class="bigcaption"><?php echo esc_attr($item['title']); ?></div><?php endif;?>
                <img src="<?php $params = array( 'width' => 788, 'height' => 478, 'crop' => true    );echo bfi_thumb($item['img'], $params); ?>" />
            </li>                                                                                                                                        

        <?php
            }
        ?>
    </ul>
</div>