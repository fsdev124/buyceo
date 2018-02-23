<?php 
if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$fullpage = is_page_template( 'template-fullwidth.php' );

if ( $sellers['users'] ) {
	?>
	<ul class="wcv_vendorslist">
	<?php
        foreach ( $sellers['users'] as $seller ) {
			$vendor_id = $seller->ID;
            $store_info = dokan_get_store_info( $vendor_id );
            $store_name = isset( $store_info['store_name'] ) ? esc_html( $store_info['store_name'] ) : __( 'N/A', 'dokan' );
            $store_url  = dokan_get_store_url( $vendor_id );
			
			$banner_id  = isset( $store_info['banner'] ) ? $store_info['banner'] : '';
			$store_banner_src = ( !empty($banner_id) ) ? wp_get_attachment_image_src( $banner_id, 'full' ) : '';
			if ( is_array( $store_banner_src ) ) { 
				$banner_url= $store_banner_src[0];
			}
			else{$banner_url='';}	
			$bg_styles = ( !empty($banner_url) ) ? ' style="background-image: url('. $banner_url .'); background-repeat: no-repeat;background-size: cover;"' : '';
            ?>
            <li class="col_item">
               <div class="member-inner-list">
					<div class="vendor-list-like"><?php echo getShopLikeButton( $vendor_id );?></div>
					<span class="cover_logo"<?php echo $bg_styles; ?>></span>
					<div class="member-details">
						<div class="item-avatar">
							<img src="<?php echo rh_show_vendor_avatar( $vendor_id, 80, 80 );?>" class="vendor_store_image_single" width=80 height=80 />
						</div>		
						<a href="<?php echo $store_url; ?>" class="wcv-grid-shop-name"><?php echo $store_info['store_name']; ?></a>
						<div class="store-desc">
							<address>
								<?php if ( isset( $store_info['address'] ) && !empty( $store_info['address'] ) ) {
									echo dokan_get_seller_address( $vendor_id );
								} ?>
								<?php if ( isset( $store_info['phone'] ) && !empty( $store_info['phone'] ) ) { ?>
									<br>
									<abbr title="<?php _e( 'Phone Number', 'dokan' ); ?>"><?php _e( 'P:', 'dokan' ); ?></abbr> <?php echo esc_html( $store_info['phone'] ); ?>
								<?php } ?>
							</address>
						</div>
					</div>
					<?php if( $fullpage ) : ?>
					<?php $totaldeals = count_user_posts( $vendor_id, $post_type = 'product' ) - 3; ?>
					<div class="last-vendor-products">
						<?php
						$args = array(
							'post_type' => 'product',
							'posts_per_page' => 3,
							'author' => $vendor_id,
							'ignore_sticky_posts'=> true,
							'no_found_rows'=> true
						);
						$looplatest = new WP_Query($args); $i = 0;
						if ( $looplatest->have_posts() ){
							while ( $looplatest->have_posts() ) : $looplatest->the_post();
								$i++;
								echo '<a href="'.get_permalink($looplatest->ID).'">';
									$showimg = new WPSM_image_resizer();
									$showimg->use_thumb = true;
									$showimg->height = 70;
									$showimg->width = 70;
									$showimg->crop = true;           
									$img = $showimg->get_resized_url();
									echo '<img src="'.$img.'" width=70 height=70 alt="'.get_the_title($looplatest->ID).'"/>';
									if ($i==3 && $totaldeals > 0){echo '<span class="product_count_in_member">+'.$totaldeals.'</span>';}
								echo '</a>';

							endwhile;
						}
						wp_reset_query();?>		
					</div>
					<?php else : ?>
						<div class="mt10 mb10"><a class="dokan-btn dokan-btn-theme" href="<?php echo $store_url; ?>"><?php _e( 'Visit Store', 'dokan' ); ?></a></div>
					<?php endif; ?>
                </div> 
            </li>
        <?php } ?>
	</ul>
    <?php
    $user_count   = $sellers['count'];
    $num_of_pages = ceil( $user_count / $limit );

    if ( $num_of_pages > 1 ) {
        echo '<div class="pagination-container clearfix">';

        $pagination_args = array(
            'current'   => $paged,
            'total'     => $num_of_pages,
            'base'      => $pagination_base,
            'type'      => 'array',
            'prev_text' => __( '&larr; Previous', 'dokan' ),
            'next_text' => __( 'Next &rarr;', 'dokan' ),
        );

        if ( ! empty( $search_query ) ) {
            $pagination_args['add_args'] = array(
                'dokan_seller_search' => $search_query,
            );
        }

        $page_links = paginate_links( $pagination_args );

        if ( $page_links ) {
            $pagination_links  = '<div class="pagination-wrap">';
            $pagination_links .= '<ul class="pagination"><li>';
            $pagination_links .= join( "</li>\n\t<li>", $page_links );
            $pagination_links .= "</li>\n</ul>\n";
            $pagination_links .= '</div>';

            echo $pagination_links;
        }

        echo '</div>';
    }
    ?>

<?php } else { ?>
    <p class="dokan-error"><?php _e( 'No vendor found!', 'dokan' ); ?></p>
<?php } ?>