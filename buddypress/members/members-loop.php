<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php
/**
 * BuddyPress - Members Loop
 *
 * Querystring is set via AJAX in _inc/ajax.php - bp_legacy_theme_object_filter()
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

do_action( 'bp_before_members_loop' ); ?>

<?php if ( bp_get_current_member_type() ) : ?>
	<p class="current-member-type"><?php bp_current_member_type_message() ?></p>
<?php endif; ?>

<?php if ( bp_has_members( bp_ajax_querystring( 'members' ) ) ) : ?>

	<?php do_action( 'bp_before_directory_members_list' ); ?>

	<div class="rhbp-grid-loop">
	<ul id="members-list" class="item-list col_wrap_fourth rh-flex-eq-height">
	<?php while ( bp_members() ) : bp_the_member(); ?>

		<li <?php bp_member_class( array('col_item') ); ?>>
			<?php 
				$author_ID = bp_get_member_user_id();
			?>
			<div class="member-inner-list" style="<?php rh_cover_image_url( 'members', 120, true ); ?>">
				<?php 				
					$membertype = bp_get_member_type($author_ID);
					$membertype_object = bp_get_member_type_object($membertype);
					$membertype_label = (!empty($membertype_object) && is_object($membertype_object)) ? $membertype_object->labels['singular_name'] : '';
					?>		
				<?php if($membertype_label) :?>
        			<span class="rh-user-m-type rh-user-m-type-<?php echo $membertype;?>"><?php echo $membertype_label;?></span>				
				<?php endif;?>
				<div class="item-avatar">
					<a href="<?php bp_member_permalink(); ?>"><?php bp_member_avatar(); ?></a>
					<?php // <i class="online-status fa fa-circle"></i> ?>
				</div>

				<div class="item">
					<div class="item-title mb5">
						<a href="<?php bp_member_permalink(); ?>">
							<?php the_author_meta( 'display_name',$author_ID); ?>							
						</a>
					</div>
					<?php $userrating = get_user_meta($author_ID, 'rh_bp_user_rating', true);?>
					<?php if ($userrating):?>
						<div class="star-small mb10"><span class="stars-rate"><span style="width: <?php echo $userrating * 20;?>%;"></span></span></div>
					<?php endif;?>					
					<div class="item-meta"><span class="activity"><?php bp_member_last_active(); ?></span></div>
					<?php if ( bp_get_member_latest_update() ) : ?>
					<span class="update"> <?php bp_member_latest_update( array( 'view_link' => false ) ); ?></span>
					<?php endif; ?>
                    <?php echo rh_bp_show_vendor_in_loop($author_ID);?>					
					<?php do_action( 'bp_directory_members_item' ); ?>

					<?php
					 /***
					  * If you want to show specific profile fields here you can,
					  * but it'll add an extra query for each member in the loop
					  * (only one regardless of the number of fields you show):
					  *
					  * bp_member_profile_data( 'field=the field name' );
					  */
					?>
				</div>

				<div class="action">
					<?php do_action( 'bp_directory_members_actions' ); ?>
				</div>

			</div>
		</li>
	<?php endwhile; ?>
	</ul>
	</div>
	
	<?php 
		do_action( 'bp_after_directory_members_list' ); 
		bp_member_hidden_fields(); 
	?>

	<div id="pag-bottom" class="pagination">
		<div class="pag-count" id="member-dir-count-bottom">
			<?php bp_members_pagination_count(); ?>
		</div>
		<div class="pagination-links" id="member-dir-pag-bottom">
			<?php bp_members_pagination_links(); ?>
		</div>
	</div>

<?php else: ?>

	<div id="message" class="info">
		<p><?php _e( "Sorry, no members were found.", 'buddypress' ); ?></p>
	</div>

<?php endif; ?>
<?php do_action( 'bp_after_members_loop' ); ?>