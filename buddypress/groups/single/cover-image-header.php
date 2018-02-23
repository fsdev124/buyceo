<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php do_action( 'bp_before_group_home_content' ); ?>
<div class="bprh_wrap_bg mb30">
	<div id="item-header" role="complementary">
		<?php do_action( 'bp_before_group_header' ); ?>
		<div id="rh-cover-image-container">
			<div id="rh-header-cover-image">
				<div id="rh-header-bp-content-wrap">
					<div class="rh-container" id="rhbp-header-profile-cont">		
						<?php if ( ! bp_disable_group_avatar_uploads() ) : ?>		
						<div id="rh-header-bp-avatar">	
							<?php bp_group_avatar(); ?>
						</div>
						<?php endif; ?>
						<div id="rh-header-bp-content">
							<h2><?php the_title(); ?></h2>		
							<?php do_action( 'bp_before_group_header_meta' ); ?>
							<div id="item-meta">
								<span class="highlight"><?php bp_group_type(); ?></span>
								<span class="activity"><?php printf( __( 'active %s', 'buddypress' ), bp_get_group_last_active() ); ?></span>
									<?php $group_dec = bp_get_group_description();?>
                                    <?php $desc_len = strlen($group_dec);?>
                                    <?php if ($desc_len > 180) :?>                           
										<div class="r_offer_details">
											<div class="hide_dls_onclk"><?php kama_excerpt('maxchar=180&text='.$group_dec); ?></div>
											<span class="r_show_hide"><?php _e('(Show full)', 'rehub_framework');?></span>
											<div class="open_dls_onclk"><?php echo $group_dec ?></div>
										</div>                                        
                                    <?php else :?>
                                        <div><?php echo $group_dec ?></div>
                                    <?php endif;?>								
								<?php do_action( 'bp_group_header_meta' ); ?>
							</div>							
						</div>			
						<div id="rh-header-bp-content-btns">
							<div id="item-buttons">
								<?php do_action( 'bp_group_header_actions' ); ?>
							</div><!-- #item-buttons -->			
						</div>
					</div>
				</div>
				<div id="rh-item-admins">
					<?php if ( bp_group_is_visible() ) : ?>
						<div class="group-list-admins">
							<div class="admin-groups"><?php _e( 'Group Admins', 'buddypress' ); ?></div>
							<?php 
							bp_group_list_admins();
							do_action( 'bp_after_group_menu_admins' ); ?>
						</div>
					<?php if ( bp_group_has_moderators() ) : ?>
						<div class="group-list-admins group-list-mods">
							<?php do_action( 'bp_before_group_menu_mods' ); ?>
							<div class="admin-groups"><?php _e( 'Group Mods' , 'buddypress' ); ?></div>
							<?php 
							bp_group_list_mods();
							do_action( 'bp_after_group_menu_mods' ); 
							?>
						</div>
					<?php endif; endif; ?>
				</div><!-- #item-actions -->						
				<span class="header-cover-image-mask"></span>	
			</div>
		</div><!-- #cover-image-container -->

		<div id="rhbp-iconed-menu">
			<div class="rh-container">
				<div id="item-nav">
					<div class="responsive-nav-greedy item-list-tabs no-ajax rh-flex-eq-height clearfix" id="object-nav" role="navigation">
						<ul class="rhgreedylinks">
							<?php bp_get_options_nav(); ?>
							<?php do_action( 'bp_group_options_nav' ); ?>
						</ul>
						<span class="togglegreedybtn rhhidden floatright ml5"><?php _e('More', 'rehub_framework');?></span>
						<ul class='hidden-links rhhidden'></ul>							
					</div>
				</div><!-- #item-nav -->
			</div>
		</div>
	</div><!-- #item-header -->
</div>