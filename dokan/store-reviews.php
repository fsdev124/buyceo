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

$widget_args = array( 'before_widget' => '<div class="rh-cartbox widget" id="dokan-contact"><div>', 'after_widget'  => '</div></div>', 'before_title'  => '<div class="widget-inner-title rehub-main-font">', 'after_title' => '</div>' );
?>

<?php get_header(); ?>
<?php dokan_get_template_part( 'store-header' ); ?>

<!-- CONTENT -->
<div class="rh-container wcvcontent woocommerce"> 
    <div class="rh-content-wrap clearfix">
        <?php do_action( 'dokan_store_profile_frame_after', $store_user, $store_info ); ?>
        <div class="rh-mini-sidebar-content-area floatright woocommerce page clearfix tabletblockdisplay">
            <article class="post" id="page-<?php the_ID(); ?>">
                <div role="tabvendor" class="tab-pane active" id="vendor-reviews">
                    <?php
                    $dokan_template_reviews = Dokan_Pro_Reviews::init();
                    $id                     = $store_user->ID;
                    $post_type              = 'product';
                    $limit                  = 20;
                    $status                 = '1';
                    $comments               = $dokan_template_reviews->comment_query( $id, $post_type, $limit, $status );
                    ?>

                    <div id="reviews">
                        <div id="comments">

                          <?php do_action( 'dokan_review_tab_before_comments' ); ?>


                            <ol class="commentlist">
                                <?php echo $dokan_template_reviews->render_store_tab_comment_list( $comments , $store_user->ID); ?>
                            </ol>

                        </div>
                    </div>
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
                
            </article>
        </div>        
        <!-- Sidebar -->
        <aside class="rh-mini-sidebar user-profile-div floatleft tabletblockdisplay">
            <?php if ( is_active_sidebar( 'wcw-storepage-sidebar' ) ) : ?>
                <?php dynamic_sidebar( 'wcw-storepage-sidebar' ); ?>
            <?php endif;?>      
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

<?php do_action( 'woocommerce_after_main_content' ); ?>

<?php get_footer(); ?>