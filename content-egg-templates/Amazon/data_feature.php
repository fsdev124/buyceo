<?php
/*
  Name: All product features
 */
use ContentEgg\application\helpers\TemplateHelper;  
?>


<?php $item = reset($items); 
    $features = (!empty($item['extra']['itemAttributes']['Feature'])) ? $item['extra']['itemAttributes']['Feature'] : ''?>
<?php if (!empty ($features)) :?>
    <div>
        <ul class="featured_list">
            <?php foreach ($features as $k => $feature): ?> 
                <li><?php echo $feature; ?></li>                                   
            <?php endforeach; ?>
        </ul>
    </div>                                 
<?php endif ;?>
<div class="clearfix"></div>