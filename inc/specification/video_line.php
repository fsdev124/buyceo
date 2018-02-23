<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php 
	$video_line = (!empty($row['video_line'])) ? $row['video_line'] : '';		    
?>
<?php if ($video_line):?>
	<?php $value = get_post_meta($postID, $video_line, true);?>
	<?php if (!empty($value)):?>
		<?php if (!is_array($value)) :?>
			<?php $values = explode(PHP_EOL, $value);?>
			<?php foreach ($values as $key) :?>
				<?php $key = trim($key);?>
				<div class="wpsm_spec_video_line mt20 mb20 clearfix">
					<div class="video-container"><?php echo parse_video_url($key, "embed", "765", "430");?></div>
				</div>
			<?php endforeach;?>		
		<?php elseif (is_array($value)) :?>
				<?php foreach ($value as $key) :?>
					<div class="wpsm_spec_video_line mt20 mb20 clearfix">
						<div class="video-container"><?php echo parse_video_url($key, "embed", "765", "430");?></div>
					</div>
				<?php endforeach;?>			
		<?php endif;?>	
	<?php endif;?>
<?php endif;?>