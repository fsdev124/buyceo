<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php
/**
 * BuddyPress - Group Invites Loop
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>
<div class="left-menu">

	<div id="invite-list">

		<ul>
			<?php bp_new_group_invite_friend_list(); ?>
		</ul>

		<?php wp_nonce_field( 'groups_invite_uninvite_user', '_wpnonce_invite_uninvite_user' ); ?>

	</div>

</div><!-- .left-menu -->

<div class="main-column">

	<?php

	/**
	 * Fires before the display of the group send invites list.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_before_group_send_invites_list' ); ?>

	<?php if ( bp_group_has_invites( bp_ajax_querystring( 'invite' ) . '&per_page=10' ) ) : ?>

		<div class="rhbp-grid-loop">
		<?php /* The ID 'friend-list' is important for AJAX support. */ ?>
			<ul id="friend-list" class="item-list col_wrap_fourth rh-flex-eq-height">
			<?php while ( bp_group_invites() ) : bp_group_the_invite(); ?>

				<li id="<?php bp_group_invite_item_id(); ?>" class="col_item">
					<div class="friend-inner-list">
						<div class="item-avatar">
							<?php bp_group_invite_user_avatar(); ?>
						</div>
						<div class="member-list-content">
							<h5><?php bp_group_invite_user_link(); ?></h5>
							<span class="activity"><?php bp_group_invite_user_last_active(); ?></span>
						</div>				
						<?php do_action( 'bp_group_send_invites_item' ); ?>
						<div class="action">
							<a class="button remove" href="<?php bp_group_invite_user_remove_invite_url(); ?>" id="<?php bp_group_invite_item_id(); ?>"><?php _e( 'Remove Invite', 'buddypress' ); ?></a>
							<?php do_action( 'bp_group_send_invites_item_action' ); ?>
						</div>
					</div><!--end member-inner-list-->
				</li>
			<?php endwhile; ?>
			</ul>
		</div><!-- #friend-list -->

		<div id="pag-bottom" class="pagination">

			<div class="pag-count" id="group-invite-count-bottom">

				<?php bp_group_invite_pagination_count(); ?>

			</div>

			<div class="pagination-links" id="group-invite-pag-bottom">

				<?php bp_group_invite_pagination_links(); ?>

			</div>

		</div>

	<?php else : ?>

		<div id="message" class="info">
			<p><?php _e( 'Select friends to invite.', 'buddypress' ); ?></p>
		</div>

	<?php endif; ?>

<?php

/**
 * Fires after the display of the group send invites list.
 *
 * @since 1.1.0
 */
do_action( 'bp_after_group_send_invites_list' ); ?>

</div><!-- .main-column -->
