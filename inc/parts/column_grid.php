<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php 
global $post;
if (isset($aff_link) && $aff_link == '1') {
    $link = rehub_create_affiliate_link ();
    $target = ' rel="nofollow" target="_blank"';
}
else {
    $link = get_the_permalink();
    $target = '';  
}
?>  
<?php
$boxed = (isset($boxed)) ? $boxed : '';
$disable_meta = (isset($disable_meta)) ? $disable_meta : '';
$exerpt_count = (isset($exerpt_count)) ? $exerpt_count : 120;
$enable_btn = (isset($enable_btn)) ? $enable_btn : '';
?>
<article class="inf_scr_item col_item column_grid rh-heading-hover-color rh-bg-hover-color<?php if($boxed):?> rh-cartbox no-padding<?php endif;?>">      
    <figure><?php echo re_badge_create('tablelabel'); ?> 
        <?php rh_post_header_cat('post', false);?>   
        <?php if(function_exists('get_favorites_button')) :?> 
            <div class="favour_in_image"><?php the_favorites_button(); ?></div> 
        <?php endif;?>            
        <a href="<?php echo $link;?>"<?php echo $target;?>><?php wpsm_thumb ('medium_news') ?></a>
    </figure>
    <?php do_action( 'rehub_after_grid_column_figure' ); ?>
    <div class="content_constructor pb10 pr20 pl20">
        <h2><a href="<?php echo $link;?>"<?php echo $target;?>><?php the_title();?></a></h2>
        <?php do_action( 'rehub_after_grid_column_title' ); ?>
        <?php if($disable_meta !='1'):?>
            <div class="meta post-meta">
                <?php rh_post_header_meta( true, false, false, true, false ); ?>                               
            </div>
            <?php do_action( 'rehub_after_grid_column_meta' ); ?>
        <?php endif?> 
        <?php if($exerpt_count !='no'):?>                      
        <div class="mb15 greycolor lineheight20 font90">                                 
            <?php kama_excerpt('maxchar='.$exerpt_count.''); ?>                       
        </div> 
        <?php endif?>
        <?php if($enable_btn):?>
            <?php rehub_create_btn('yes');?>
        <?php endif?>        
        <?php do_action( 'rehub_after_grid_column_btn' ); ?>
    </div>                           
</article>