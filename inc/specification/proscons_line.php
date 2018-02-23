<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php 
	$proscons_line_pros_label = (!empty($row['proscons_line_pros_label'])) ? $row['proscons_line_pros_label'] : '';	
	$proscons_line_pros_field = (!empty($row['proscons_line_pros_field'])) ? $row['proscons_line_pros_field'] : '';	
	$proscons_line_cons_label = (!empty($row['proscons_line_cons_label'])) ? $row['proscons_line_cons_label'] : '';	
	$proscons_line_cons_field = (!empty($row['proscons_line_cons_field'])) ? $row['proscons_line_cons_field'] : '';	
	$prosvalues = (!empty($proscons_line_pros_field)) ? get_post_meta($postID, $proscons_line_pros_field, true) : '';	
	$consvalues = (!empty($proscons_line_cons_field)) ? get_post_meta($postID, $proscons_line_cons_field, true) : '';   
?>

<div class="mt20 mb20 clearfix">

	<?php if(!empty($prosvalues)):?>
	<div <?php if(!empty($prosvalues) && !empty($consvalues)):?>class="wpsm-one-half wpsm-column-first"<?php endif;?>>
		<div class="wpsm_pros">
			<div class="title_pros"><?php echo $proscons_line_pros_label;?></div>
			<ul>		
				<?php $prosvalues = explode(PHP_EOL, $prosvalues);?>
				<?php foreach ($prosvalues as $prosvalue) {
					echo '<li>'.$prosvalue.'</li>';
				}?>
			</ul>
		</div>
	</div>
	<?php endif;?>

	
	<?php if(!empty($consvalues)):?>
	<div class="wpsm-one-half wpsm-column-last">
		<div class="wpsm_cons">
			<div class="title_cons"><?php echo $proscons_line_cons_label;?></div>
			<ul>
				<?php $consvalues = explode(PHP_EOL, $consvalues);?>
				<?php foreach ($consvalues as $consvalue) {
					echo '<li>'.$consvalue.'</li>';
				}?>
			</ul>
		</div>
	</div>
	<?php endif;?>

</div>