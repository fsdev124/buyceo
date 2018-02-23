<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php get_header(); ?>
<?php 
	$author_ID = bp_displayed_user_id();
	$membertype = ($author_ID) ?  bp_get_member_type($author_ID) : '';		
?>
<div id="buddypress" class="register_wrap_type<?php echo $membertype;?>">
	<?php if($author_ID):?>
		<?php include(rh_locate_template('buddypress/members/single/cover-image-header.php'));?> 
	<?php elseif (bp_is_group()):?>
		<?php if ( bp_has_groups() ) : while ( bp_groups() ) : bp_the_group(); ?>
			<?php include(rh_locate_template('buddypress/groups/single/cover-image-header.php'));?>
	    <?php endwhile; endif;?>
	<?php endif;?>
	<!-- CONTENT -->
	<div class="rh-container clearfix mb30">
		<?php if($author_ID):?>
			<?php
				do_action( 'bp_after_member_header' );
				do_action( 'template_notices' ); 
			?>									
		<?php elseif (bp_is_group()):?>
			<?php
				do_action( 'bp_after_group_header' );
				do_action( 'template_notices' ); 
			?>
		<?php endif;?>	
		<div>
			<article> 
				<?php include(rh_locate_template('rtmedia/main.php'));?>
            </article>
		</div>
	</div>
	<!-- /CONTENT --> 
</div><!-- #buddypress -->    
<!-- FOOTER -->
<?php get_footer(); ?>