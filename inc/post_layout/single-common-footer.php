<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php if(rehub_option('rehub_single_code') && vp_metabox('rehub_post_side.show_banner_ads') != '1') : ?><div class="single_custom_bottom"><?php echo do_shortcode (rehub_option('rehub_single_code')); ?></div><div class="clearfix"></div><?php endif; ?>

<?php if(rehub_option('rehub_disable_share') =='1' || vp_metabox('rehub_post_side.disable_parts') == '1')  : ?>
<?php else :?>
    <?php include(rh_locate_template('inc/parts/post_share.php')); ?>  
<?php endif; ?>

<?php if(rehub_option('rehub_disable_prev') =='1' || vp_metabox('rehub_post_side.disable_parts') == '1')  : ?>
<?php else :?>
    <?php include(rh_locate_template('inc/parts/prevnext.php')); ?>                    
<?php endif; ?>                 

<?php if(rehub_option('rehub_disable_tags') =='1' || vp_metabox('rehub_post_side.disable_parts') == '1')  : ?>
<?php else :?>
    <div class="tags">
        <p><?php the_tags('<span class="tags-title-post">'.__('Tags: ', 'rehub_framework').'</span>',""); ?></p>
    </div>
<?php endif; ?>

<?php if(rehub_option('rehub_disable_author') =='1' || vp_metabox('rehub_post_side.disable_parts') == '1')  : ?>
<?php else :?>
    <?php rh_author_detail_box();?>
<?php endif; ?>               

<?php if(rehub_option('rehub_disable_relative') =='1' || vp_metabox('rehub_post_side.disable_parts') == '1')  : ?>
<?php else :?>
    <?php include(rh_locate_template('inc/parts/related_posts.php')); ?>
<?php endif; ?>  