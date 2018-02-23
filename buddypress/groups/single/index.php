<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php get_header(); ?>
<div id="buddypress">
	<?php if ( bp_has_groups() ) : while ( bp_groups() ) : bp_the_group(); ?>

		<?php include(rh_locate_template('buddypress/groups/single/cover-image-header.php'));?>	

		<!-- CONTENT -->
		<div class="rh-container clearfix mb35">
			<?php
				do_action( 'bp_after_group_header' );
				do_action( 'template_notices' ); 
			?>
			<?php if ( rehub_option('bp_group_widget_area') == 1 && is_active_sidebar( 'bprh-group-sidebar' ) ) : ?>
				<?php include(rh_locate_template('buddypress/groups/single/group-sidebar.php'));?>
			<?php endif;?>			
			<div class="<?php if ( rehub_option('bp_group_widget_area') == 1 && is_active_sidebar( 'bprh-group-sidebar' ) ) : ?>rh-mini-sidebar-content-area floatright tabletblockdisplay<?php endif;?>">
				<article class="" id="page-<?php the_ID(); ?>"> 
					<?php do_action( 'bp_before_group_home_content' ); ?>
					<div id="item-body" class="separate-item-bp-nav">
						<?php
							do_action( 'bp_before_group_body' );
							if ( bp_is_group_home() ) :
								if ( bp_group_is_visible() ) {
									bp_groups_front_template_part();
								} else {
									do_action( 'bp_before_group_status_message' ); ?>
									<div id="message" class="info">
										<p><?php bp_group_status_message(); ?></p>
									</div>
									<?php
										do_action( 'bp_after_group_status_message' );
								}
							else :
								// Group Admin
								if     ( bp_is_group_admin_page() ) : bp_get_template_part( 'groups/single/admin'        );

								// Group Activity
								elseif ( bp_is_group_activity()   ) : bp_get_template_part( 'groups/single/activity'     );

								// Group Members
								elseif ( bp_is_group_members()    ) : bp_groups_members_template_part();

								// Group Invitations
								elseif ( bp_is_group_invites()    ) : bp_get_template_part( 'groups/single/send-invites' );

								// Old group forums
								elseif ( bp_is_group_forum()      ) : bp_get_template_part( 'groups/single/forum'        );

								// Membership request
								elseif ( bp_is_group_membership_request() ) : bp_get_template_part( 'groups/single/request-membership' );

								// Anything else (plugins mostly)
								else                                : bp_get_template_part( 'groups/single/plugins'      );

								endif;

							endif;
						do_action( 'bp_after_group_body' ); ?>
					</div><!-- #item-body -->
					<?php do_action( 'bp_after_group_home_content' ); ?>
	            </article>
			</div>
		</div>
		<!-- /CONTENT --> 	
	<?php endwhile; endif; ?>
</div><!-- #buddypress -->    
<!-- FOOTER -->
<?php get_footer(); ?>