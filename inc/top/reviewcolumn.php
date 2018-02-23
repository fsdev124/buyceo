<?php if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}?>
<?php 
	$rating_circle = $row['top_review_circle'];	
	if ($rating_circle ==''){$exerptvalue = '1';};	    
?>
<div class="rating_col">
<?php if ($rating_circle =='1'):?>
    <?php $rating_score_clean = rehub_get_overall_score(); ?>

    <div class="top-rating-item-circle-view">
    <div class="radial-progress" data-rating="<?php echo $rating_score_clean?>">
        <div class="circle">
            <div class="mask full">
                <div class="fill"></div>
            </div>
            <div class="mask half">
                <div class="fill"></div>
                <div class="fill fix"></div>
            </div>
            
        </div>
        <div class="inset">
            <div class="percentage"><?php echo $rating_score_clean?></div>
        </div>
    </div>
    </div>

<?php elseif ($rating_circle =='2') :?> 
    <div class="score square_score"> <span class="it_score"><?php echo rehub_get_overall_score() ?></span></div>       
<?php else :?>
    <div class="score"> <span class="it_score"><?php echo rehub_get_overall_score() ?></span></div>    
<?php endif ;?>
<a href="<?php the_permalink();?>" class="read_full" target="_blank"><?php if(rehub_option('rehub_review_text') !='') :?><?php echo rehub_option('rehub_review_text') ; ?><?php else :?><?php _e('Read review', 'rehub_framework'); ?><?php endif ;?></a>
</div>