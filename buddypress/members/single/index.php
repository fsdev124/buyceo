<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php get_header(); ?>
<?php 
	$author_ID = bp_displayed_user_id();		
?>
<div id="buddypress" class="register_wrap_type<?php echo bp_get_member_type($author_ID);?>">
	<?php include(rh_locate_template('buddypress/members/single/cover-image-header.php'));?> 
	<!-- CONTENT -->
	<div class="rh-container clearfix mb30">
		<?php
			do_action( 'bp_after_member_header' );
			do_action( 'template_notices' ); 
		?>	
		<?php if ( rehub_option('bp_profile_widget_area') == 1) : ?>
			<?php include(rh_locate_template('buddypress/members/single/profile-sidebar.php'));?>
		<?php endif;?>
		<div class="<?php if ( rehub_option('bp_profile_widget_area') == 1) : ?>rh-mini-sidebar-content-area floatright tabletblockdisplay<?php endif;?>">
			<article> 
				<?php do_action( 'bp_before_member_home_content' ); ?>
				<div id="item-body" class="separate-item-bp-nav">
					<?php
					do_action( 'bp_before_member_body' );

					if ( bp_is_user_activity() || !bp_current_component() ) :
						bp_get_template_part( 'members/single/activity' );

					elseif ( bp_is_user_blogs() ) :
						bp_get_template_part( 'members/single/blogs'    );

					elseif ( bp_is_user_friends() ) :
						bp_get_template_part( 'members/single/friends'  );

					elseif ( bp_is_user_groups() ) :
						bp_get_template_part( 'members/single/groups'   );

					elseif ( bp_is_user_messages() ) :
						bp_get_template_part( 'members/single/messages' );

					elseif ( bp_is_user_profile() ) :
						bp_get_template_part( 'members/single/profile'  );

					elseif ( bp_is_user_forums() ) :
						bp_get_template_part( 'members/single/forums'   );

					elseif ( bp_is_user_notifications() ) :
						bp_get_template_part( 'members/single/notifications' );

					elseif ( bp_is_user_settings() ) :
						bp_get_template_part( 'members/single/settings' );

					// If nothing sticks, load a generic template
					else :
						bp_get_template_part( 'members/single/plugins'  );

					endif;

					do_action( 'bp_after_member_body' ); ?>
				</div><!-- #item-body -->
				<?php do_action( 'bp_after_member_home_content' ); ?>
            </article>
		</div>
	</div>
	<!-- /CONTENT --> 
</div><!-- #buddypress -->    
<!-- FOOTER -->
<?php get_footer(); ?>