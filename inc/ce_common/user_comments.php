<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php foreach ($import_comments as $key => $comment): ?>
    <div class="helpful-review rh-cartbox">
        <div class="quote-top"><i class="fa fa-quote-left"></i></div>
        <div class="quote-bottom"><i class="fa fa-quote-right"></i></div>
        <div class="user-review-ae-comment">
            <span><?php echo $comment['comment']; ?></span>
        </div>
        <?php if (!empty($comment['date'])): ?>
            <span class="helpful-date"><strong class="font120"><?php echo (isset($comment['name'])) ? $comment['name'] : '';?></strong> - <?php echo gmdate("F j, Y", $comment['date']); ?></span>
        <?php endif ;?>
    </div>
<?php endforeach; ?>