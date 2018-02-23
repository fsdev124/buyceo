<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php get_header(); ?>
<?php global $post;?>
<?php $rh_post_layout_style = get_post_meta($post->ID, '_post_layout', true);?>
<?php if ($rh_post_layout_style == '') {$rh_post_layout_style = rehub_option('post_layout_style');} ?>
<?php if ($rh_post_layout_style == '') :?>
    <?php       
    if (REHUB_NAME_ACTIVE_THEME == 'RECASH') {
        $rh_post_layout_style = 'meta_compact'; 
    }
    elseif (REHUB_NAME_ACTIVE_THEME == 'REPICK') {
        $rh_post_layout_style = 'corner_offer';
    }
    elseif (REHUB_NAME_ACTIVE_THEME == 'RETHING') {
        $rh_post_layout_style = 'meta_center';
    }
    elseif (REHUB_NAME_ACTIVE_THEME == 'REVENDOR') {
        $rh_post_layout_style = 'meta_outside';
    }   
    elseif (REHUB_NAME_ACTIVE_THEME == 'REDIRECT') {
        $rh_post_layout_style = 'meta_compact_dir';
    }           
    elseif (REHUB_NAME_ACTIVE_THEME == 'REWISE') {
        $rh_post_layout_style = 'default';
    }                           
    else{
        $rh_post_layout_style = 'default';       
    }?>
<?php endif;?>


<?php if($rh_post_layout_style == 'default') : ?>
    <?php include(rh_locate_template('inc/post_layout/single-default.php')); ?>
<?php elseif($rh_post_layout_style == 'default_text_opt') : ?>
    <?php include(rh_locate_template('inc/post_layout/single-default-readopt.php')); ?>    
<?php elseif($rh_post_layout_style == 'meta_outside') : ?>
    <?php include(rh_locate_template('inc/post_layout/single-meta-outside.php')); ?> 
<?php elseif($rh_post_layout_style == 'meta_center') : ?>
    <?php include(rh_locate_template('inc/post_layout/single-meta-center.php')); ?> 
<?php elseif($rh_post_layout_style == 'meta_compact') : ?>
    <?php include(rh_locate_template('inc/post_layout/single-meta-compact.php')); ?>
<?php elseif($rh_post_layout_style == 'meta_compact_dir') : ?>
    <?php include(rh_locate_template('inc/post_layout/single-meta-compact-dir.php')); ?>   
<?php elseif($rh_post_layout_style == 'corner_offer') : ?>
    <?php include(rh_locate_template('inc/post_layout/single-corner-offer.php')); ?>
<?php elseif($rh_post_layout_style == 'meta_in_image') : ?>
    <?php include(rh_locate_template('inc/post_layout/single-inimage.php')); ?>
<?php elseif($rh_post_layout_style == 'meta_in_imagefull') : ?>
    <?php include(rh_locate_template('inc/post_layout/single-inimagefull.php')); ?>
<?php elseif($rh_post_layout_style == 'meta_ce_compare') : ?>
    <?php include(rh_locate_template('inc/post_layout/single-ce-compare.php')); ?>  
<?php elseif($rh_post_layout_style == 'meta_ce_compare_full') : ?>
    <?php include(rh_locate_template('inc/post_layout/single-ce-compare-full.php')); ?>  
<?php elseif($rh_post_layout_style == 'meta_ce_compare_auto') : ?>
    <?php include(rh_locate_template('inc/post_layout/single-ce-compare-fullauto.php')); ?>
<?php elseif($rh_post_layout_style == 'big_post_offer') : ?>
    <?php include(rh_locate_template('inc/post_layout/single-big-offer.php')); ?>    
<?php elseif($rh_post_layout_style == 'meta_ce_compare_auto_sec') : ?>
    <?php include(rh_locate_template('inc/post_layout/single-ce-compare-autocontent.php')); ?>      
<?php elseif($rh_post_layout_style == 'offer_and_review') : ?>
    <?php include(rh_locate_template('inc/post_layout/single-offer-reviewscore.php')); ?>       
<?php else:?>
    <?php include(rh_locate_template('inc/post_layout/single-default.php')); ?>                               
<?php endif;?>

<!-- FOOTER -->
<?php get_footer(); ?>