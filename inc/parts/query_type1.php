
<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php global $post;?>
<div class="news-community news-no-columns clearfix<?php echo rh_expired_or_not($post->ID, 'class');?>">
	<div class="newscom_wrap_table">		
    <div class="featured_image_left">
    	<div>
        <figure><?php echo re_badge_create('tablelabel'); ?>
        <a href="<?php the_permalink();?>">
			<?php wpsm_thumb ('grid_thumb') ?>
        </a>
        </figure> 
        </div>         
		<?php do_action( 'rehub_after_left_list_thumb_figure' ); ?> 
                               
    </div>
    <div class="newscom_detail mb0">
    	<div class="newscom_head">
		    <?php echo rh_expired_or_not($post->ID, 'span');?><h2><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
		    <?php do_action( 'rehub_after_left_list_thumb_title' ); ?>
		    
		    <div class="post-meta">
		    	<?php rh_post_header_meta( true, true, false, false, true ); ?>
		    </div>
        </div>
	    <?php rehub_format_score('small') ?>
	    <p><?php kama_excerpt('maxchar=160'); ?></p>
	    <?php if(rehub_option('disable_btn_offer_loop')!='1')  : ?>       
		    <?php rehub_create_btn('yes') ;?>       
	    <?php endif; ?> 

    </div>   
    </div> 
</div>