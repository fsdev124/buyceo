<?php
/*
  Name: News grid
 */
?>
<?php if (isset($title) && $title): ?>
    <h3 class="cegg-shortcode-title"><?php echo esc_html($title); ?></h3>
<?php endif; ?>
<div class="col_wrap_three rh-flex-columns goonewsgrid">
    <?php foreach ($items as $item): ?>
        <?php 
            $title = (!empty($item['title'])) ? esc_html($item['title']) : '';
            $url = (!empty($item['url'])) ? esc_url($item['url']) : '';
            $img = (!empty($item['img'])) ? esc_html($item['img']) : '';
        ?>
        <div class="col_item">
            <?php if ($img): ?>
                <div class="medianews-img floatleft mr20 rtlml20">
                    <?php WPSM_image_resizer::show_static_resized_image(array('src'=> $img, 'width'=> 80, 'title' => $title));?>                     
                </div>
            <?php endif; ?>
            <div class="medianews-body floatright">
                <h5 class="rehub-main-font font90 lineheight20 mb10 mt0">
                    <?php echo wpsm_hidelink_shortcode(array('link'=>$url, 'text'=>$title));?>
                </h5>
                <div class="font70 lineheight15">
                    <?php echo date(get_option('date_format'), $item['extra']['date']); ?> -
                    <?php echo wpsm_hidelink_shortcode(array('link'=>$url, 'text'=>$item['extra']['source']));?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>