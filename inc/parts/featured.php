<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php 
	$feat_tagid = rehub_option('rehub_featured_tag');
	$rehub_featured_type = (rehub_option('rehub_featured_type')) ? rehub_option('rehub_featured_type') : '1';
	$rehub_featured_number = (rehub_option('rehub_featured_number')) ? rehub_option('rehub_featured_number') : '5';

	?>
	<?php 
    	$feat_type = ' feat_type="'.(int) $rehub_featured_type.'"';
    	$feat_number = ' show="'.(int) $rehub_featured_number.'"';
	?>	
	<?php $feat_base = ''; if (rehub_option('rehub_featured_tag') !='') {    
		$feat_tag = get_term_by('slug', $feat_tagid, 'post_tag');
		$feat_tag_id = (!empty($feat_tag)) ? (int) $feat_tag->term_id : '';
    	$feat_base = ' tag="'.$feat_tag_id.'"';
    } ?>

<?php echo do_shortcode ('[wpsm_featured '.$feat_base.$feat_type.$feat_number.']');?>    