<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php
/**
 * BuddyPress - Groups Members
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>

<?php if ( bp_group_has_members( bp_ajax_querystring( 'group_members' ) ) ) : ?>

	<?php do_action( 'bp_before_group_members_content' ); ?>

	<?php do_action( 'bp_before_group_members_list' ); ?>

	<div class="rhbp-grid-loop mt15">
		<ul id="member-list" class="item-list col_wrap_fourth rh-flex-eq-height">
			<?php while ( bp_group_members() ) : bp_group_the_member(); ?>
				<li class="col_item">
					<div class="member-inner-list">
						<div class="item-avatar">
							<a href="<?php bp_group_member_domain(); ?>"><?php bp_group_member_avatar_thumb(); ?></a>
						</div>
						<div class="member-list-content">
							<h5><?php bp_group_member_link(); ?></h5>
							<?php $userrating = get_user_meta(bp_get_group_member_id(), 'rh_bp_user_rating', true);?>
							<?php if ($userrating):?>
								<div class="star-small mb10"><span class="stars-rate"><span style="width: <?php echo $userrating * 20;?>%;"></span></span></div>
							<?php endif;?>							
							<span class="activity"><?php bp_group_member_joined_since(); ?></span>
						</div>
						
						<?php do_action( 'bp_group_members_list_item' ); ?>
						<?php if ( bp_is_active( 'friends' ) ) : ?>
						<div class="action">
							<?php 
								bp_add_friend_button( bp_get_group_member_id(), bp_get_group_member_is_friend() ); 
								do_action( 'bp_group_members_list_item_action' ); 
							?>
						</div>
						<?php endif; ?>
					</div><!--end member-inner-list-->
				</li>
			<?php endwhile; ?>
		</ul>
	</div>

	<?php do_action( 'bp_after_group_members_list' ); ?>

	<div id="pag-bottom" class="pagination">
		<div class="pag-count" id="member-count-bottom">
			<?php bp_members_pagination_count(); ?>
		</div>

		<div class="pagination-links" id="member-pag-bottom">
			<?php bp_members_pagination_links(); ?>
		</div>
	</div>

	<?php do_action( 'bp_after_group_members_content' ); ?>

<?php else: ?>

	<div id="message" class="info">
		<p><?php _e( 'No members were found.', 'buddypress' ); ?></p>
	</div>

<?php endif; ?>