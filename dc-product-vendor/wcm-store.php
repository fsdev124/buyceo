<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php get_header(); ?>
<?php 

global $WCMp;
$external_store_url = $verified_vendor = '';
$vendor_id = $vendor->id;
$vendor_name = $vendor->display_name;
$address = '';

if ($vendor->city) {
    $address = $vendor->city . ', ';
}
if ($vendor->state) {
    $address .= $vendor->state . ', ';
}
if ($vendor->country) {
    $address .= $vendor->country;
}
$mobile = $vendor->phone;
$email = $vendor->user_data->user_email;
$location = $address;
$vendor_hide_address = get_user_meta($vendor_id,'_vendor_hide_address', true);
$vendor_hide_phone = get_user_meta($vendor_id,'_vendor_hide_phone', true);
$vendor_hide_email = get_user_meta($vendor_id,'_vendor_hide_email', true);
$vendor_hide_description = get_user_meta($vendor_id,'_vendor_hide_description', true);
$description = stripslashes($vendor->description);
$shop_name = get_user_meta($vendor_id, '_vendor_page_title', true);
$totaldeals = count_user_posts( $vendor_id, $post_type = 'product' );
$count_likes = ( get_user_meta( $vendor_id, 'overall_post_likes', true) ) ? get_user_meta( $vendor_id, 'overall_post_likes', true) : '0';
$vendor_address = (!empty($location) && $vendor_hide_address != 'Enable') ? apply_filters( 'vendor_shop_page_location', $location, $vendor_id ) : '';
$vendor_phone = (!empty($mobile) && $vendor_hide_phone != 'Enable') ? apply_filters( 'vendor_shop_page_contact', $mobile, $vendor_id ) : '';
$vendor_email = (!empty($email) && $vendor_hide_email != 'Enable') ? apply_filters( 'vendor_shop_page_email', $email, $vendor_id ) : '';
$is_vendor_add_external_url_field = apply_filters('is_vendor_add_external_url_field', true);
$store_url = $vendor->permalink;
$queried_object = get_queried_object();

if ( $WCMp->vendor_caps->vendor_capabilities_settings('is_vendor_add_external_url') && $is_vendor_add_external_url_field ) {
	$get_external_store_url = get_user_meta( $vendor_id, '_vendor_external_store_url', true );
	$external_store_url = apply_filters( 'vendor_shop_page_external_store', esc_url_raw($get_external_store_url ), $vendor_id ); 
}

?>

<div class="wcvendor_store_wrap_bg wcmp-container clearfix">
	<style scoped>#wcvendor_image_bg{<?php echo rh_show_vendor_bg( $vendor_id ); ?>}</style>
	<div id="wcvendor_image_bg">
		<div id="wcvendor_profile_wrap">
			<div class="rh-container">
				<div class="tabledisplay">
		    		<div id="wcvendor_profile_logo" class="wcvendor_profile_cell">
					<?php if( $external_store_url ) : ?><a href="<?php echo $external_store_url; ?>" rel="nofollow"><?php endif; ?>
						<img src="<?php echo rh_show_vendor_avatar($vendor_id, 140, 140); ?>" width=150 height=150 />
					<?php if( $external_store_url ) : ?></a><?php endif; ?>
		    		</div>
		    		<div id="wcvendor_profile_act_desc" class="wcvendor_profile_cell">
		    			<div class="wcvendor_store_name">
							<?php if ( $verified_vendor ) : ?>	   			
								<div class="wcv-verified-vendor">
									<i class="fa fa-check" aria-hidden="true"></i> <?php // echo $verified_vendor_label; ?>
								</div>
							<?php endif; ?>	    			
		    				<h1><?php echo esc_html( $shop_name ); ?></h1> 	    				
		    			</div>
	    				<div class="wcmvendor_store_ratings">
						<?php 
						if(get_wcmp_vendor_settings('is_sellerreview', 'general') == 'Enable') {
							
							if(isset($queried_object->term_id) && !empty($queried_object)) {		
								$rating_val_array = wcmp_get_vendor_review_info($queried_object->term_id); 
								$WCMp->template->get_template( 'review/rating.php', array('rating_val_array' => $rating_val_array)); 
							}
						}?>
						</div>
						<div class="wcvendor_store_desc">
							<?php echo $vendor_address; ?> 								
							<?php if ($vendor_phone):?>
								<a href="tel:<?php echo $vendor_phone; ?>" class="ml10 mr5"><i class="fa fa-phone"></i> <?php echo $vendor_phone; ?></a>
							<?php endif;?>
						</div>
		    		</div>
		    		<div id="wcvendor_profile_act_btns" class="wcvendor_profile_cell">
		    			<span class="wpsm-button medium red"><?php echo getShopLikeButton($vendor_id); ?></span>	    			
					    <?php if ( class_exists( 'BuddyPress' ) ) : ?>
					    	<?php if ( bp_loggedin_user_id() && bp_loggedin_user_id() != $vendor_id ) : ?>
								<?php 
									if ( function_exists( 'bp_follow_add_follow_button' ) ) {
								        bp_follow_add_follow_button( array(
								            'leader_id'   => $vendor_id,
								            'follower_id' => bp_loggedin_user_id(),
								            'link_class'  => 'wpsm-button medium green'
								        ) );
								    }
								?>				    		
							    <?php
							        if ( bp_is_active( 'messages' )){
								    $link = (is_user_logged_in()) ? wp_nonce_url( bp_loggedin_user_domain() . bp_get_messages_slug() . '/compose/?r=' . bp_core_get_username( $vendor_id)) : '#';
								    $class = (!is_user_logged_in() && rehub_option('userlogin_enable') == '1') ? ' act-rehub-login-popup' : '';
								    echo ' <a href="'.$link.'" class="wpsm-button medium white'.$class.'">'. __('Contact vendor', 'rehub_framework') .'</a>';
							    }?>
						    <?php endif;?>
						<?php endif;?>
		    		</div>	        			
				</div>
			</div>
		</div>
		<span class="wcvendor-cover-image-mask wcmvendor-cover-mask"></span>
	</div>
	<div id="wcvendor_profile_menu">
		<div class="rh-container">	
			<?php if( !$is_block ) : ?>		
			<form id="wcvendor_search_shops" role="search" action="<?php echo $shop_url;?>" method="get" class="wcvendor-search-inside search-form">
				<input type="text" name="rh_wcv_search" placeholder="<?php _e('Search in this shop', 'rehub_framework');?>" value="">
				<button type="submit" class="btnsearch"><i class="fa fa-search"></i></button>					
			</form>	
			<?php endif; ?>
			<ul class="wcvendor_profile_menu_items">		
			<li class="active"><a href="#vendor-items" aria-controls="vendor-items" role="tab" data-toggle="tab" aria-expanded="true"><?php _e('Items', 'rehub_framework');?></a></li>
			<?php if ( class_exists( 'WCVendors_Pro' ) ) :?>
				<?php $feedback_form_page =  		WCVendors_Pro::get_option( 'feedback_page_id' );?>
				<?php if ( $feedback_form_page ) :?>
					<?php $url = apply_filters( 'wcv_ratings_link_url', WCVendors_Pro_Vendor_Controller::get_vendor_store_url( $vendor_id ) . 'ratings/' ); ?>
					<li><a href="<?php echo $url;?>"><?php _e('Reviews', 'rehub_framework');?></a></li>	
				<?php endif;?>
			<?php endif;?>
			<?php if ( !$vendor_hide_description ) { ?>
			<li><a href="#vendor-about" aria-controls="vendor-about" role="tab" data-toggle="tab" aria-expanded="true" data-scrollto="#vendor-about"><?php _e('About', 'rehub_framework');?></a>
			</li>
			<li><a href="#vendor-review" aria-controls="vendor-review" role="tab" data-toggle="tab" aria-expanded="true" data-scrollto="#vendor-review"><?php _e('Reviews', 'rehub_framework');?></a>
			</li>			
			<?php } ?>
			</ul>

		</div>
	</div>
</div>
<div class="clearfix"></div>



<!-- CONTENT -->
<div class="rh-container wcvcontent"> 
    <div class="rh-content-wrap clearfix">
        <!-- Main Side -->
        <div class="rh-mini-sidebar-content-area floatright page clearfix tabletblockdisplay">
            <article class="post" id="page-<?php the_ID(); ?>">
                <?php do_action( 'woocommerce_before_main_content' );?>   		
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
				<?php if ( !$vendor_hide_description ) { ?>
					<div role="tabvendor" class="tab-pane" id="vendor-about">
						<?php echo $description;?>
					</div>
				<?php } ?>	
				<div role="tabvendor" class="tab-pane" id="vendor-review">
					<?php $WCMp->template->get_template('wcmp-vendor-review-form.php', array('queried_object' => $queried_object));?>
				</div>							
                <?php
                    /**
                     * woocommerce_after_main_content hook.
                     *
                     * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
                     */
                    do_action( 'woocommerce_after_main_content' );
                ?>                
    		</article>
    	</div>
		<!-- /Main Side --> 

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
						<div><i class="fa fa-user"></i> <?php _e( 'Registration', 'rehub_framework' );  echo ': ' . mb_substr( $vendor->user_data->user_registered, 0, 10 ); ?></div>
						<div><i class="fa fa-heartbeat"></i><?php _e( 'Product Votes', 'rehub_framework' ); echo ': ' . $count_likes; ?></div>
						<div><i class="fa fa-briefcase"></i><?php _e( 'Total submitted', 'rehub_framework' ); echo ': ' . $totaldeals; ?></div>
	                    <?php if (!empty($mycredpoint)) :?><div><i class="fa fa-bar-chart"></i><?php echo $mycredlabel;?>: <?php echo $mycredpoint;?> </div><?php endif;?>
					</div>
					<?php
					$vendor_fb_profile = get_user_meta($vendor_id,'_vendor_fb_profile', true);
					$vendor_twitter_profile = get_user_meta($vendor_id,'_vendor_twitter_profile', true);
					$vendor_linkdin_profile = get_user_meta($vendor_id,'_vendor_linkdin_profile', true);
					$vendor_google_plus_profile = get_user_meta($vendor_id,'_vendor_google_plus_profile', true);
					$vendor_youtube = get_user_meta($vendor_id,'_vendor_youtube', true);
					$vendor_instagram = get_user_meta($vendor_id,'_vendor_instagram', true);
					$social_icons = empty( $vendor_twitter_profile ) && empty( $vendor_instagram ) && empty( $vendor_fb_profile ) && empty( $vendor_linkdin_profile ) && empty( $vendor_youtube ) && empty( $vendor_google_plus_profile ) ? false : true;
					?>
					<?php if ($social_icons) :?>
					<div class="profile-socbutton">
						<div class="social_icon small_i">
							<?php if ( $vendor_fb_profile != '') { ?><a href="<?php echo $vendor_fb_profile; ?>" target="_blank" class="author-social fb" rel="nofollow"><i class="fa fa-facebook"></i></a><?php } ?>
							<?php if ( $vendor_instagram != '') { ?><a href="//instagram.com/<?php echo $vendor_instagram; ?>" target="_blank" class="author-social fb" rel="nofollow"><i class="fa fa-instagram"></i></a><?php } ?>
							<?php if ( $vendor_twitter_profile != '') { ?><a href="//twitter.com/<?php echo $vendor_twitter_profile; ?>" target="_blank" class="author-social tw" rel="nofollow"><i class="fa fa-twitter"></i></a><?php } ?>
							<?php if ( $vendor_google_plus_profile != '') { ?><a href="<?php echo $vendor_google_plus_profile; ?>" target="_blank" class="author-social gp" rel="nofollow"><i class="fa fa-google-plus"></i></a><?php } ?>
							<?php if ( $vendor_youtube != '') { ?><a href="<?php echo $vendor_youtube; ?>" target="_blank" class="author-social yt" rel="nofollow"><i class="fa fa-youtube"></i></a><?php } ?>
							<?php if ( $vendor_linkdin_profile != '') { ?><a href="<?php echo $vendor_linkdin_profile; ?>" target="_blank" class="author-social fb" rel="nofollow"><i class="fa fa-linkedin"></i></a><?php } ?>
						 </div>
					</div>
					<?php endif; ?>					
					<div class="profile-description">
						<div>
							<span><?php _e( 'Contacts', 'rehub_framework' ); ?></span>
							<p>
								<?php echo $vendor_address; ?>
								<?php if ($vendor_email ) : ?>
									<br />
									<i class="fa fa-envelope-o"></i> <a href="mailto:<?php echo antispambot( $vendor_email ); ?>"><?php echo antispambot( $vendor_email ); ?></a>									
								<?php endif; ?>							
								<?php if ($vendor_phone):?>
									<br />
									<a href="tel:<?php echo $vendor_phone; ?>"><i class="fa fa-phone"></i> <?php echo $vendor_phone; ?></a>
								<?php endif;?>
								<?php if ($external_store_url):?>
									<br />
									<a href="<?php echo esc_url($external_store_url); ?>"><i class="fa fa-globe"></i> <?php echo $external_store_url; ?></a>
								<?php endif;?>									
							</p>
						</div>
					</div>					
					
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
					    <?php $liclass = ($cat_string == $category->ID) ? ' class="current"' : '';?>
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
					        <a href="<?php echo $store_url;?>?rh_wcv_vendor_cat=<?php echo $category->ID;?>" title="<?php echo $category->name ?>">
					            <?php echo $category->name.'<span>'.$count.'</span> '; ?>
					        </a>
					    </li>
					    <?php endforeach; ?>
					</ul>

	            </div>	    		
	    	</div>
		</aside>	

    </div>
</div>
<!-- /CONTENT -->	

<?php get_footer(); ?>