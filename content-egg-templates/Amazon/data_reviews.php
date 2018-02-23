<?php
/*
  Name: Reviews from Amazon (DEPRECATED!!!!)
 */
use ContentEgg\application\helpers\TemplateHelper;
?>

<?php
wp_enqueue_style('eggrehub');
$item = reset($items);
if (!empty($item['extra']['customerReviews'])) {$import_comments = $item['extra']['customerReviews'];}
?>
<?php if (!empty ($import_comments['reviews']) || !empty ($import_comments['HasReviews'])) :?>
    <div class="affrev">
        <?php if ($import_comments['HasReviews'] == 'true'): ?>
            <iframe src='<?php echo $import_comments['IFrameURL']; ?>' width='100%' height='500'></iframe>    
        <?php elseif (!empty($import_comments['reviews'])): ?>                     
            <?php foreach ($import_comments['reviews'] as $review): ?>
                <div class="helpful-review black">
                    <div class="quote-top"><i class="fa fa-quote-left"></i></div>
                    <div class="quote-bottom"><i class="fa fa-quote-right"></i></div>
                    <div class="text-elips">
                        <em><?php echo esc_html($review['Summary']); ?></em><br />
                        <span class="ce_rating rating_small">
                            <?php echo str_repeat("<span>&#x2605</span>", (int) $review['Rating']); ?><?php echo str_repeat("<span>☆</span>", 5 - (int) $review['Rating']); ?>
                        </span><br />                                    
                        <span><?php echo esc_html($review['Content']); ?></span>
                    </div>
                    <span class="helpful-date"><?php echo date(get_option('date_format'), $review['Date']); ?></span>
                </div>
            <?php endforeach; ?>
            <?php if (!empty($item['extra']['itemLinks'][5])): ?>
                <span class="ce_customer_reviews">
                    <a href="<?php echo $item['extra']['itemLinks'][5]['URL'];?>" rel="nofollow" target="_blank" > <?php echo $item['extra']['itemLinks'][5]['Description'];?></a>
                </span>
            <?php endif; ?>            
        <?php endif; ?>
    </div>
<?php endif ;?>
<div class="clearfix"></div>      