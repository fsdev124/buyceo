<?php
/**
 * The Template for displaying all single posts.
 *
 * @package dokan
 * @package dokan - 2014 1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$store_user = get_userdata( get_query_var( 'author' ) );
$vendor_id = $store_user->ID;
$vendor_email = $store_user->user_email;
$totaldeals = count_user_posts( $vendor_id, $post_type = 'product' );
$store_info = dokan_get_store_info( $vendor_id );
$store_url = dokan_get_store_url( $vendor_id );
$social_fields = dokan_get_social_profile_fields();
$store_description = '';
$tnc_enable = dokan_get_option( 'seller_enable_terms_and_conditions', 'dokan_general', 'off' );
if ( isset($store_info['enable_tnc']) && $store_info['enable_tnc'] == 'on' && $tnc_enable == 'on' ) {
	$store_description = wpautop( wptexturize( wp_kses_post( $store_info['store_tnc'] ) ) );
}

//$map_location = isset( $store_info['location'] ) ? esc_attr( $store_info['location'] ) : '';
$store_address_arr = $store_info['address'];
$store_address = '';
if( is_array( $store_address_arr ) && !empty( $store_address_arr ) ) {
	if( !empty($store_address_arr['street_1'] )) $store_address = $store_address_arr['street_1'];
	if( !empty($store_address_arr['street_2'] )) $store_address .= ', '. $store_address_arr['street_2'];
	if( !empty($store_address_arr['city'] )) $store_address .= ', '. $store_address_arr['city'];
	if( !empty($store_address_arr['state'] )) $store_address .= ', '. $store_address_arr['state'];
	if( !empty($store_address_arr['zip'] )) $store_address .= ' '. $store_address_arr['zip'];
	if( !empty($store_address_arr['country'] )) $store_address .= ', '. $store_address_arr['country'];
}
if(function_exists('mycred_get_users_rank')){
	if(rehub_option('rh_mycred_custom_points')){
		$custompoint = rehub_option('rh_mycred_custom_points');
		$mycredrank = mycred_get_users_rank($vendor_id, $custompoint );
	}
	else{
		$mycredrank = mycred_get_users_rank($vendor_id);		
	}
}
if(function_exists('mycred_display_users_total_balance')){
    if(rehub_option('rh_mycred_custom_points')){
        $custompoint = rehub_option('rh_mycred_custom_points');
        $mycredpoint = mycred_render_shortcode_my_balance(array('type'=>$custompoint, 'user_id'=>$vendor_id, 'wrapper'=>'', 'balance_el' => '') );
        $mycredlabel = mycred_get_point_type_name($custompoint, false);
    }
    else{
        $mycredpoint = mycred_render_shortcode_my_balance(array('user_id'=>$vendor_id, 'wrapper'=>'', 'balance_el' => '') );
        $mycredlabel = mycred_get_point_type_name('', false);           
    }
}
$count_likes = ( get_user_meta( $vendor_id, 'overall_post_likes', true) ) ? get_user_meta( $vendor_id, 'overall_post_likes', true) : '0';
$widget_args = array( 'before_widget' => '<div class="rh-cartbox widget" id="dokan-contact"><div>', 'after_widget'  => '</div></div>', 'before_title'  => '<div class="widget-inner-title rehub-main-font">', 'after_title' => '</div>' );
?>

<?php get_header(); ?>
<?php dokan_get_template_part( 'store-header' ); ?>

<!-- CONTENT -->
<div class="rh-container wcvcontent woocommerce"> 
    <div class="rh-content-wrap clearfix">
    	<?php do_action( 'dokan_store_profile_frame_after', $store_user, $store_info ); ?>
	    <div class="rh-mini-sidebar-content-area floatright page clearfix tabletblockdisplay">
	        <article class="post" id="page-<?php the_ID(); ?>">
	        	<?php do_action( 'woocommerce_before_main_content' ); ?>
	        	<div role="tabvendor" class="tab-pane active" id="vendor-items">
				<?php if ( have_posts() ) : ?>
				
					<?php do_action( 'woocommerce_before_shop_loop' ); ?>
					
					<?php $classes = array(); $classes[] = 'col_wrap_three'; ?>
					<?php 
					if (rehub_option('woo_design') == 'grid') {
						$classes[] = 'rh-flex-eq-height grid_woo';
					}
					elseif (rehub_option('woo_design') == 'list') {
						$classes[] = 'list_woo';
					}
					else {
						$classes[] = 'rh-flex-eq-height column_woo';
					}
					?>					
					<div class="products <?php echo implode(' ',$classes);?>">
						<?php while ( have_posts() ) : the_post(); ?>
							<?php 
								$columns = '3_col';
							?>							
							<?php if (rehub_option('woo_design') == 'list'){
							    include(rh_locate_template('inc/parts/woolistmain.php'));
							}
							elseif (rehub_option('woo_design') == 'grid'){
							    include(rh_locate_template('inc/parts/woogridpart.php'));
							}
							else{
								$custom_col = 'yes'; 
								$custom_img_height = 284; 
								$custom_img_width = 284; 								
							    include(rh_locate_template('inc/parts/woocolumnpart.php'));
							} ?>
						<?php endwhile; // end of the loop. ?>
					</div>
					
					<?php do_action( 'woocommerce_after_shop_loop' ); ?>
				
				<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>
						<?php wc_get_template( 'loop/no-products-found.php' ); ?>
				<?php endif; ?>
				</div>
				<?php if( !empty( $store_description ) ) { ?>
				<div role="tabvendor" class="tab-pane" id="vendor-about">
					<div class="rh-cartbox widget">
						<div>
							<div class="widget-inner-title rehub-main-font"><?php _e( 'Terms and Conditions', 'rehub_framework' );?></div>
							<?php echo $store_description; ?>
						</div>
					</div>
				</div>
				<?php } ?>
				<?php if( class_exists( 'Dokan_Store_Location' ) && dokan_get_option( 'store_map', 'dokan_general', 'on' ) == 'on' ) { ?>
				<div role="tabvendor" id="vendor-location">
					<?php the_widget( 'Dokan_Store_Location', array( 'title' => __( 'Store Location', 'rehub_framework' ) ), $widget_args ); ?>
				</div>
				<?php } ?>
				
				<?php //dokan_content_nav( 'nav-below' ); ?>
				<?php do_action( 'woocommerce_after_main_content' ); ?>				
			</article>
		</div>    	
	    <!-- Sidebar -->
	    <aside class="rh-mini-sidebar user-profile-div floatleft tabletblockdisplay">
	        <?php if ( is_active_sidebar( 'wcw-storepage-sidebar' ) ) : ?>
	            <?php dynamic_sidebar( 'wcw-storepage-sidebar' ); ?>
	        <?php endif;?>	    
			<div class="rh-cartbox widget">
				<div>
					<div class="widget-inner-title rehub-main-font"><?php _e('Shop owner:', 'rehub_framework');?></div>
					<div class="profile-avatar text-center">
					<?php if ( function_exists('bp_displayed_user_avatar') ) : ?>
						<?php bp_displayed_user_avatar( 'type=full&width=110&height=110&&item_id='.$vendor_id ); ?>
					<?php else : ?>
						<?php echo get_avatar( $comment, 110 ); ?>
					<?php endif; ?>
					</div>
					<div class="profile-usertitle text-center mt20">
						<div class="profile-usertitle-name">
						<?php if ( function_exists('bp_core_get_user_domain') ) : ?>
							<a href="<?php echo bp_core_get_user_domain( $vendor_id ); ?>">
						<?php endif;?>
							<?php the_author_meta( 'nickname',$vendor_id); ?> 						
							<?php if (!empty($mycredrank) && is_object( $mycredrank)) :?>
								<span class="rh-user-rank-mc rh-user-rank-<?php echo $mycredrank->post_id; ?>">
									<?php echo $mycredrank->title ;?>
								</span>
							<?php endif;?>
							<?php if ( function_exists('bp_core_get_user_domain') ) : ?></a><?php endif;?>
						</div>
					</div>
					<div class="profile-stats">
						<div><i class="fa fa-user"></i> <?php _e( 'Registration', 'rehub_framework' );  echo ': ' . mb_substr( $store_user->user_registered, 0, 10 ); ?></div>
						<div><i class="fa fa-heartbeat"></i><?php _e( 'Product Votes', 'rehub_framework' ); echo ': ' . $count_likes; ?></div>
						<div><i class="fa fa-briefcase"></i><?php _e( 'Total submitted', 'rehub_framework' ); echo ': ' . $totaldeals; ?></div>
	                    <?php if (!empty($mycredpoint)) :?><div><i class="fa fa-bar-chart"></i><?php echo $mycredlabel;?>: <?php echo $mycredpoint;?> </div><?php endif;?>
					</div>
					<div class="profile-description">
						<div>
							<span><?php _e( 'Contacts', 'rehub_framework' ); ?></span>
							<p>
							<?php if ( isset( $store_address ) && !empty( $store_address ) ) { ?>
								<i class="fa fa-map-marker"></i> <?php echo $store_address; ?>
							<?php } ?>
							<?php if ( isset( $store_info['phone'] ) && !empty( $store_info['phone'] ) ) { ?>
								<br />
								<i class="fa fa-mobile"></i> <a href="tel:<?php echo esc_html( $store_info['phone'] ); ?>"><?php echo esc_html( $store_info['phone'] ); ?></a>
							<?php } ?>
							<?php if ( $store_user->user_url ):?>
								<br />
								<i class="fa fa-globe"></i> <a href="<?php echo esc_url( $store_user->user_url ); ?>"><?php echo $store_user->user_url; ?></a>
							<?php endif;?>
							<?php if ( isset( $store_info['show_email'] ) && $store_info['show_email'] == 'yes' ) { ?>
								<br />
								<i class="fa fa-envelope-o"></i> <a href="mailto:<?php echo antispambot( $vendor_email ); ?>"><?php echo antispambot( $vendor_email ); ?></a>
							<?php } ?>							
							</p>
						</div>
					</div>
					<?php if ( $social_fields ) { ?>
					<div class="profile-socbutton">
						<div class="social_icon small_i">
							<?php foreach( $social_fields as $key => $field ) { ?>
								<?php if ( isset( $store_info['social'][ $key ] ) && !empty( $store_info['social'][ $key ] ) ) { ?>
									  <a href="<?php echo esc_url( $store_info['social'][ $key ] ); ?>" class="author-social <?php echo esc_attr( $key ) ?>" title="<?php echo $field['title']; ?>" target="_blank"><i class="fa fa-<?php echo $field['icon']; ?>"></i></a>
								<?php } ?>
							<?php } ?>
						</div>
					</div>
					<?php } ?>
					
					<?php if ( !empty( $store_user->description ) ) { ?>
	                <div class="profile-description">
	                    <div>
	                        <span><?php _e( 'About author', 'rehub_framework' ); ?></span>
	                        <p><?php echo $store_user->description; ?></p>
	                    </div>
	                </div>
					<?php } ?>
					
					<?php if ( function_exists( 'mycred_get_users_badges' ) ) : ?>
	                <div class="profile-achievements mb15 text-center">
	                        <div>
	                            <?php rh_mycred_display_users_badges( $vendor_id ) ?>
	                        </div>
	                </div>
	            <?php endif; ?>
                <?php if ( function_exists('bp_core_get_user_domain') ) : ?>
                	<?php if ( bp_is_active( 'xprofile' ) ) : ?>
						<?php if ( bp_has_profile( array( 'profile_group_id' => 1, 'fetch_field_data' => true, 'user_id'=>$vendor_id ) ) ) : while ( bp_profile_groups() ) : bp_the_profile_group(); ?>
							<?php $numberfields = explode(',', bp_get_the_profile_field_ids());?>
							<?php $count = (!empty($numberfields)) ? count($numberfields) : '';?>
							<?php $bp_profile_description = rehub_option('rh_bp_seo_description');?>
							<?php $bp_profile_phone = rehub_option('rh_bp_phone');	?>

							<?php if ($count > 1) :?>
								<ul id="xprofile-in-wcstore">
									<?php $fieldid = 0; while ( bp_profile_fields() ) : bp_the_profile_field(); $fieldid++; ?>
										<?php if ($fieldid == 1) continue;?>
										<?php $fieldname = bp_get_the_profile_field_name();?>
										<?php if($fieldname == $bp_profile_phone) continue;?>
										<?php if($fieldname == $bp_profile_description) continue;?>
										<?php if ( bp_field_has_data() ) : ?>
											<li>
												<div class="floatleft mr5"><?php echo $fieldname ?>: </div>
												<div class="floatleft"><?php bp_the_profile_field_value() ?></div>	
											</li>
										<?php endif; ?>
									<?php endwhile; ?>
								</ul>
							<?php endif; ?>
						<?php endwhile; endif; ?>
                	<?php endif;?>
					
                    <div class="profile-usermenu mt20">
	                    <ul class="user-menu-tab" role="tablist">
	                        <li class="text-center">
	                            <a href="<?php echo bp_core_get_user_domain( $vendor_id ); ?>"><i class="fa fa-folder-open"></i><?php _e( 'Show full profile', 'rehub_framework' ); ?></a>
	                        </li>
	                    </ul>
                    </div>
					<?php endif; ?>
	            </div>	    		
			</div>
	    	<div class="rh-cartbox widget">
	            <div>
	            	<div class="widget-inner-title rehub-main-font"><?php _e('Shop categories', 'rehub_framework');?></div>
					<?php global $wpdb; $categories = $wpdb->get_results("
					    SELECT DISTINCT(terms.term_id) as ID, terms.name, terms.slug
					    FROM $wpdb->posts as posts
					    LEFT JOIN $wpdb->term_relationships as relationships ON posts.ID = relationships.object_ID
					    LEFT JOIN $wpdb->term_taxonomy as tax ON relationships.term_taxonomy_id = tax.term_taxonomy_id
					    LEFT JOIN $wpdb->terms as terms ON tax.term_id = terms.term_id
					    WHERE posts.post_status = 'publish' AND
					        posts.post_author = '$vendor_id' AND
					        posts.post_type = 'product' AND
					        tax.taxonomy = 'product_cat'
					    ORDER BY terms.name ASC
					");
					?>
					<?php $cat_string = (isset($_GET['rh_wcv_vendor_cat'])) ? esc_html($_GET['rh_wcv_vendor_cat']) : '';?>
					<ul class="category-vendormenu">
					    <?php foreach($categories as $category) : ?>
					    <?php $liclass = ($cat_string == $category->ID) ? ' class="current"' : ''; ?>
					    <li<?php echo $liclass;?>>
					    	<?php $author_posts = new WP_Query( array( 
					    		'post_type' => 'product', 
					    		'author' => $vendor_id, 
					    		'tax_query'=>array(
					    			array(
					    				'taxonomy' => 'product_cat', 
					    				'terms' => array($category->ID), 
					    				'field' => 'term_id'
					    				)
					    			)
					    		));
					    		$count = $author_posts->found_posts;
					    		wp_reset_query();
					    	?>
					        <a href="<?php echo $store_url .'section/'. $category->ID ?>" title="<?php echo $category->name ?>">
					            <?php echo $category->name.'<span>'. $count .'</span> '; ?>
					        </a>
					    </li>
					    <?php endforeach; ?>
					</ul>
	            </div>
	    	</div>
			<?php
				if ( dokan_get_option( 'contact_seller', 'dokan_general', 'on' ) == 'on' ) {
					echo '<span id="dokan-contact-anchor"></span>';
					the_widget( 'Dokan_Store_Contact_Form', array( 'title' => __( 'Contact Vendor', 'rehub_framework' ) ), $widget_args );
				}
			?>
		</aside>
		<!-- /Main Side --> 
    </div>
</div>
<!-- /CONTENT -->

<?php get_footer(); ?>