<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php
/**
 * BuddyPress - Groups Loop
 *
 * Querystring is set via AJAX in _inc/ajax.php - bp_legacy_theme_object_filter().
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>

<?php do_action( 'bp_before_groups_loop' ); ?>

<?php if ( bp_get_current_group_directory_type() ) : ?>
	<?php bp_current_group_directory_type_message() ?>
<?php endif; ?>

<?php if ( bp_has_groups( bp_ajax_querystring( 'groups' ) ) ) : ?>

	<?php do_action( 'bp_before_directory_groups_list' ); ?>

	<div class="rhbp-grid-loop">
		<ul id="groups-list" class="item-list col_wrap_fourth rh-flex-eq-height">	
		<?php while ( bp_groups() ) : bp_the_group(); ?>
			<li <?php bp_group_class( array('col_item') ); ?>>
				<div class="group-inner-list" style="<?php rh_cover_image_url( 'groups', 120, true ); ?>">
				<?php if ( ! bp_disable_group_avatar_uploads() ) : ?>
					<div class="item-avatar">
						<a href="<?php bp_group_permalink(); ?>"><?php bp_group_avatar( 'type=thumb&width=76&height=76' ); ?></a>
						<?php global $groups_template;
								$count = (int) $groups_template->group->total_member_count; ?>
						<span class="member-count"><?php echo $count; ?></span>
					</div>
				<?php endif; ?>

				<div class="item">
					<div class="item-title"><a href="<?php bp_group_permalink(); ?>"><?php bp_group_name(); ?></a></div>
					<div class="item-meta"><span class="activity"><?php printf( __( 'active %s', 'rehub_framework' ), bp_get_group_last_active() ); ?></span></div>
					<div class="item-desc"><?php bp_group_description_excerpt(); ?></div>
					<?php do_action( 'bp_directory_groups_item' ); ?>
				</div>

				<div class="action">
					<?php do_action( 'bp_directory_groups_actions' ); ?>
					<div class="meta">
						<?php bp_group_type(); ?>
					</div>
				</div>
				</div>
			</li>	
		<?php endwhile; ?>
		</ul>
	</div>

	<?php do_action( 'bp_after_directory_groups_list' ); ?>

	<div id="pag-bottom" class="pagination">
		<div class="pag-count" id="group-dir-count-bottom">
			<?php bp_groups_pagination_count(); ?>
		</div>
		<div class="pagination-links" id="group-dir-pag-bottom">
			<?php bp_groups_pagination_links(); ?>
		</div>
	</div>

<?php else: ?>

	<div id="message" class="info">
		<p><?php _e( 'There were no groups found.', 'buddypress' ); ?></p>
	</div>

<?php endif; ?>

<?php do_action( 'bp_after_groups_loop' ); ?>
