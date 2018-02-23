<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<div class="meta post-meta-big">
	<?php global $post;?>
	<div class="floatleft mr15">
		<?php if(rehub_option('exclude_author_meta') != 1):?>
			<?php $author_id=$post->post_author; ?>
			<a href="<?php echo get_author_posts_url( $author_id ) ?>" class="floatleft mr10">
				<?php $author_avatar_url = get_avatar_url( $author_id, array( 'size' => 32 ) ); ?>		
				<amp-img src="<?php echo esc_url( $author_avatar_url ); ?>" width="32" height="32" layout="fixed"></amp-img>								
			</a>	
		<?php endif;?>
		<span class="floatleft authortimemeta">
			<?php if(rehub_option('exclude_author_meta') != 1):?>
				<a href="<?php echo get_author_posts_url( $author_id ) ?>">				
					<?php the_author_meta( 'display_name', $author_id ); ?>			
				</a>
			<?php endif;?>
			<?php if(rehub_option('exclude_date_meta') != 1):?>
				<div class="date_time_post"><?php the_time(get_option( 'date_format' )); ?></div>
			<?php endif;?>
		</span>	

	</div>
	<?php if(rehub_option('hotmeter_disable') !='1'):?>
		<?php $rehub_thumbs = get_post_meta ($post->ID,'post_hot_count',true);?>
		<?php if($rehub_thumbs > 0):?>
			<span class="postthumb_meta mr10 ml10 floatleft"><svg width="19" height="19" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M896 1664q-26 0-44-18l-624-602q-10-8-27.5-26t-55.5-65.5-68-97.5-53.5-121-23.5-138q0-220 127-344t351-124q62 0 126.5 21.5t120 58 95.5 68.5 76 68q36-36 76-68t95.5-68.5 120-58 126.5-21.5q224 0 351 124t127 344q0 221-229 450l-623 600q-18 18-44 18z"/></svg><strong><?php echo $rehub_thumbs; ?></strong></span>
		<?php endif;?>
	<?php endif;?>	
	<?php if(rehub_option('exclude_comments_meta') != 1):?>			
		<span class="comm_count_meta mr10 ml10 floatright"><svg width="20" height="20" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M896 384q-204 0-381.5 69.5t-282 187.5-104.5 255q0 112 71.5 213.5t201.5 175.5l87 50-27 96q-24 91-70 172 152-63 275-171l43-38 57 6q69 8 130 8 204 0 381.5-69.5t282-187.5 104.5-255-104.5-255-282-187.5-381.5-69.5zm896 512q0 174-120 321.5t-326 233-450 85.5q-70 0-145-8-198 175-460 242-49 14-114 22h-5q-15 0-27-10.5t-16-27.5v-1q-3-4-.5-12t2-10 4.5-9.5l6-9 7-8.5 8-9q7-8 31-34.5t34.5-38 31-39.5 32.5-51 27-59 26-76q-157-89-247.5-220t-90.5-281q0-174 120-321.5t326-233 450-85.5 450 85.5 326 233 120 321.5z"/></svg><strong><?php comments_popup_link( '0', '1', '%', 'comm_meta', ''); ?></strong></span>	
	<?php endif;?>				 
</div>
<div class="clearfix"></div>  