<?php
/**
 * Members locator "default" search results template file. 
 * 
 * The information on this file will be displayed as the search results.
 * 
 * The function pass 2 args for you to use:
 * $gmw    - the form being used ( array )
 * $member - each member in the loop
 * 
 * You could but It is not recomemnded to edit this file directly as your changes will be overridden on the next update of the plugin.
 * Instead you can copy-paste this template ( the "default" folder contains this file and the "css" folder ) 
 * into the theme's or child theme's folder of your site and apply your changes from there. 
 * 
 * The template folder will need to be placed under:
 * your-theme's-or-child-theme's-folder/geo-my-wp/friends/search-results/
 * 
 * Once the template folder is in the theme's folder you will be able to choose it when editing the Members locator form.
 * It will show in the "Search results" dropdown menu as "Custom: default".
 */
?>	
<!--  Main results wrapper - wraps the paginations, map and results -->
<div class="gmw-results-wrapper gmw-results-wrapper-<?php echo $gmw['ID']; ?> gmw-fl-default-results-wrapper">
	<?php do_action( 'gmw_search_results_start' , $gmw ); ?>
    <div class="clear"></div>

    <!-- GEO my WP Map -->
    <?php 
    if ( $gmw['search_results']['display_map'] == 'results' ) {
        echo '<div class="mt15">'; gmw_results_map( $gmw );echo '</div>';
    }
    ?>

    <div id="pag-top" class="geo-pagination">

        <!-- results message -->
        <div class="pag-count floatleft" id="member-dir-count-top">
            <?php bp_members_pagination_count(); ?><?php gmw_results_message( $gmw, false ); ?>
        </div>
        
        <!-- per page -->
        <?php gmw_per_page( $gmw, $gmw['total_results'], 'paged' ); ?>
        
        <!-- pagination -->
        <div class="pagination-links" id="member-dir-pag-top">
            <?php gmw_pagination( $gmw, 'paged', $gmw['max_pages'] ); ?>
        </div>
    </div>    
    
    <?php do_action( 'bp_before_directory_members_list' ); ?>

    <div class="rh_vendors_listflat mt20">
    <?php while ( bp_members() ) : bp_the_member(); ?>
        <?php $vendor_id = bp_get_member_user_id();?>
        <?php $shop_link = (class_exists('WCV_Vendors')) ? WCV_Vendors::get_vendor_shop_page( $vendor_id ) : '';?>
        <?php $member = $members_template->member; ?>
        <?php do_action( 'gmw_search_results_loop_item_start', $gmw, $member ); ?>
        <div class="vendor_store_in_bp">
            <div class="vendor_store_in_bp_image">
                <a href="<?php bp_member_permalink(); ?>">
                    <?php bp_member_avatar( 'type=full&height=70&width=70' ); ?>
                </a>
            </div>
            <div class="vendor_store_in_bp_single">
                <div class="vendor_user_meta">
                    <h5>
                        <a href="<?php bp_member_permalink(); ?>" class="wcvendors_cart_sold_by_meta">
                            <?php the_author_meta( 'display_name',$vendor_id); ?>
                        </a>
                    </h5>
                    <div class="seller-adress-gmw">
                        <?php do_action( 'gmw_search_results_before_distance', $gmw, $member); ?>                        
                        <!-- distance -->
                        <div class="distance-to-user-geo">
                            <i class="fa fa-map-marker" aria-hidden="true"></i> <?php gmw_distance_to_location( $members_template->member, $gmw ); ?>
                            <?php do_action( 'gmw_search_results_before_address', $gmw, $member ); ?>                                  
                            <!-- Get directions -->     
                            <?php if ( isset( $gmw['search_results']['get_directions'] ) ) { ?>
                                <?php global $members_template; ?>
                                <div class="get-directions-link">
                                    <?php gmw_directions_link( $members_template->member, $gmw, $gmw['labels']['search_results']['directions'] ); ?>
                                </div>
                            <?php } ?>
                        </div> 
                        <?php do_action( 'gmw_fl_search_results_member_items', $gmw, $member ); ?>                                      
                    </div>


                </div>

            </div>
            <?php if (class_exists('WCV_Vendors')):?>
                <?php $shop_name = WCV_Vendors::is_vendor( $vendor_id ) ? WCV_Vendors::get_vendor_sold_by( $vendor_id ) : get_bloginfo( 'name' );?>
                <div class="vendor_store_in_bp_shopname">
                    <div class="tabledisplay">
                        <div class="celldisplay shop_avatar_v_store">
                            <div class="vendor-list-like"><?php echo getShopLikeButton( $vendor_id ); ?></div>
                            <a href="<?php echo $shop_link; ?>" class="wcvendors_cart_sold_by_meta">
                                <img src="<?php echo rh_show_vendor_avatar( $vendor_id, 50, 50 ) ?>" class="vendor_store_image_single"
                                 width=50 height=50/>
                            </a>
                        </div>
                        <div class="celldisplay vendor_storelist_name">
                            <span><?php _e( 'Shop', 'rehub_framework' ); ?></span>

                            <a href="<?php echo $shop_link; ?>"><?php echo $shop_name; ?></a>
                        </div>
                    </div>
                </div>
            <?php endif;?>
            <div class="vendor_store_in_bp_last_products">
                <?php
                $totaldeals = count_user_posts( $vendor_id, $post_type = 'product' );
                $totaldeals = $totaldeals - 4;
                $args       = array(
                    'post_type'           => 'product',
                    'posts_per_page'      => 4,
                    'author'              => $vendor_id,
                    'ignore_sticky_posts' => true,
                    'no_found_rows'       => true
                );
                $looplatest = new WP_Query( $args );
                if ( $looplatest->have_posts() ) {
                    while ( $looplatest->have_posts() ) : $looplatest->the_post();
                        echo '<a href="' . get_permalink( $looplatest->ID ) . '">';
                        $showimg            = new WPSM_image_resizer();
                        $showimg->use_thumb = true;
                        $showimg->height    = 70;
                        $showimg->width     = 70;
                        $showimg->crop      = true;
                        $showimg->no_thumb = rehub_woocommerce_placeholder_img_src('');
                        $img                = $showimg->get_resized_url();
                        echo '<img src="' . $img . '" width=70 height=70 alt="' . get_the_title( $looplatest->ID ) . '"/>';
                        echo '</a>';
                    endwhile;
                    if ( $totaldeals > 0 ) {
                        echo '<a class="vendor_store_in_bp_count_pr" href="' . $shop_link . '"><span>+' . $totaldeals . '</span></a>';
                    }

                }
                wp_reset_query(); ?>
            </div>
        <?php do_action( 'gmw_search_results_loop_item_end', $gmw, $member ); ?>    
        </div>
    <?php endwhile; ?>
    </div>

    <?php do_action( 'bp_after_directory_members_list' ); ?>

    <?php bp_member_hidden_fields(); ?>
	
	<?php do_action( 'gmw_search_results_end', $gmw ); ?>	
</div>