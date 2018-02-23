<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php get_header(); ?>
<?php 
$curauth = ( get_query_var( 'author_name' ) ) ? get_user_by( 'slug', get_query_var( 'author_name' ) ) : get_userdata( get_query_var( 'author' ) );
$author_ID = $curauth->ID;
$author_name = $curauth->display_name; 
$count_comments = get_comments( array( 'user_id' => $author_ID, 'count' => true ) );
$count_likes = ( get_user_meta( $author_ID, 'overall_post_likes', true) ) ? get_user_meta( $author_ID, 'overall_post_likes', true) : '0';
$userpostslabel = (rehub_option('rehub_userposts_text') !='') ? rehub_option('rehub_userposts_text') : __( 'User Posts', 'rehub_framework' );
$userdealslabel = (rehub_option('rehub_userdeals_text') !='') ? rehub_option('rehub_userposts_text') : __( 'User Deals', 'rehub_framework' );
$totaldeals = count_user_posts( $author_ID, $post_type = 'product' );
$totalposts = count_user_posts( $author_ID, $post_type = 'post' );
$totalsubmitted = $totaldeals + $totalposts;
if(function_exists('mycred_get_users_rank')){
    if(rehub_option('rh_mycred_custom_points')){
        $custompoint = rehub_option('rh_mycred_custom_points');
        $mycredrank = mycred_get_users_rank($author_ID, $custompoint );
    }
    else{
        $mycredrank = mycred_get_users_rank($author_ID);        
    }
}
if(function_exists('mycred_display_users_total_balance')){
    if(rehub_option('rh_mycred_custom_points')){
        $custompoint = rehub_option('rh_mycred_custom_points');
        $mycredpoint = mycred_render_shortcode_my_balance(array('type'=>$custompoint, 'user_id'=>$author_ID, 'wrapper'=>'', 'balance_el' => '') );
        $mycredlabel = mycred_get_point_type_name($custompoint, false);
    }
    else{
        $mycredpoint = mycred_render_shortcode_my_balance(array('user_id'=>$author_ID, 'wrapper'=>'', 'balance_el' => '') );
        $mycredlabel = mycred_get_point_type_name('', false);           
    }
}
 ?>
<!-- CONTENT -->
<div class="rh-container user-profile-div"> 
    <div class="rh-content-wrap clearfix">
        <!-- Sidebar -->
        <aside class="sidebar authorsidebar">
            <div class="author_widget clearfix">
                <div class="profile-avatar text-center">
                    <?php echo get_avatar( $curauth->user_email, '128' ); ?>
                </div>
                <div class="profile-usertitle text-center mt20">
                    <div class="profile-usertitle-name">
                        <?php echo $author_name; ?> <?php if (!empty($mycredrank) && is_object( $mycredrank)) :?><span class="rh-user-rank-mc rh-user-rank-<?php echo $mycredrank->post_id; ?>"><?php echo $mycredrank->title ;?></span><?php endif;?>
                        <?php   
                            if (function_exists('bp_get_member_type')){      
                                $membertype = bp_get_member_type($author_ID);
                                $membertype_object = bp_get_member_type_object($membertype);
                                $membertype_label = (!empty($membertype_object) && is_object($membertype_object)) ? $membertype_object->labels['singular_name'] : '';
                                if($membertype_label){
                                    echo '<span class="rh-user-rank-mc rh-user-rank-'.$membertype.'">'.$membertype_label.'</span>';
                                }
                            }
                        ?>
                    </div>
                </div>
                <div class="profile-stats">
                    <div><i class="fa fa-user"></i> <?php _e( 'Registration', 'rehub_framework' );  echo ': ' . mb_substr( $curauth->user_registered, 0, 10 ); ?></div>
                    <div><i class="fa fa-comment"></i><?php _e( 'Comments', 'rehub_framework' ); echo ': ' . $count_comments; ?></div>
                    <div><i class="fa fa-heartbeat"></i><?php _e( 'Votes', 'rehub_framework' ); echo ': ' . $count_likes; ?></div>
                    <div><i class="fa fa-briefcase"></i><?php _e( 'Total submitted', 'rehub_framework' ); echo ': ' . $totalsubmitted; ?></div>
                    <?php if (!empty($mycredpoint)) :?><div class="rh_mycred_point_bal"><i class="fa fa-bar-chart"></i><?php echo $mycredlabel;?>: <?php echo $mycredpoint;?></div><?php endif;?>                               
                </div>
                <div class="profile-socbutton">
                    <div class="social_icon small_i">
                        <?php if(!empty($curauth->user_url)) : ?><a href="<?php echo $curauth->user_url ?>" class="author-social hm" rel="nofollow"><i class="fa fa-home"></i></a><?php endif; ?>
                        <?php if(get_the_author_meta('facebook', $author_ID)) : ?><a href="<?php echo the_author_meta('facebook', $author_ID); ?>" class="author-social fb" rel="nofollow"><i class="fa fa-facebook"></i></a><?php endif; ?>
                        <?php if(get_the_author_meta('twitter', $author_ID)) : ?><a href="<?php echo the_author_meta('twitter', $author_ID); ?>" class="author-social tw" rel="nofollow"><i class="fa fa-twitter"></i></a><?php endif; ?>
                        <?php if(get_the_author_meta('google', $author_ID)) : ?><a href="<?php echo the_author_meta('google', $author_ID); ?>?rel=author" class="author-social gp" rel="nofollow"><i class="fa fa-google-plus"></i></a><?php endif; ?>
                        <?php if(get_the_author_meta('tumblr', $author_ID)) : ?><a href="<?php echo the_author_meta('tumblr', $author_ID); ?>" class="author-social tm" rel="nofollow"><i class="fa fa-tumblr"></i></a><?php endif; ?>
                        <?php if(get_the_author_meta('instagram', $author_ID)) : ?><a href="<?php echo the_author_meta('instagram', $author_ID); ?>" class="author-social ins" rel="nofollow"><i class="fa fa-instagram"></i></a><?php endif; ?>
                        <?php if(get_the_author_meta('vkontakte', $author_ID)) : ?><a href="<?php echo the_author_meta('vkontakte', $author_ID); ?>" class="author-social vk" rel="nofollow"><i class="fa fa-vk"></i></a><?php endif; ?>
                        <?php if(get_the_author_meta('youtube', $author_ID)) : ?><a href="<?php echo the_author_meta( 'youtube', $author_ID ); ?>" class="author-social yt" rel="nofollow"><i class="fa fa-youtube"></i></a><?php endif; ?>
                     </div>
                </div>
            <?php if ( !empty( $curauth->description ) ) : ?>
                <div class="profile-description">
                    <div>
                        <span><?php _e( 'About author', 'rehub_framework' ); ?></span>
                        <p><?php echo $curauth->description; ?></p>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ( function_exists( 'mycred_get_users_badges' ) ) : ?>
                <div class="profile-achievements mb15 text-center">
                        <div>
                            <?php rh_mycred_display_users_badges( $author_ID ) ?>
                        </div>
                </div>
            <?php endif; ?>
                <div class="profile-usermenu mt20">
                    <ul class="user-menu-tab" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#user-posts" aria-controls="user-posts" role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-pencil-square-o"></i><?php echo $userpostslabel ?></a>
                        </li>
                    <?php if ( class_exists( 'Woocommerce' ) ) : ?> 
                        <li role="presentation">
                            <a href="#user-deals" aria-controls="user-deals" role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-tags"></i><?php echo $userdealslabel ?></a>
                        </li>
                    <?php endif; ?> 
                        <li role="presentation">
                            <a href="#user-comments" aria-controls="user-comments" role="tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-comment"></i><?php _e( 'Comments', 'rehub_framework' ); ?></a>
                        </li>
                    <?php if ( function_exists('bp_core_get_user_domain') ) : ?>
                        <li>
                            <a href="<?php echo bp_core_get_user_domain( $author_ID ); ?>"><i class="fa fa-folder-open"></i><?php _e( 'Show full profile', 'rehub_framework' ); ?></a>
                        </li>
                    <?php endif; ?>
                    </ul>
                </div>
            </div>            
        </aside>
        <!-- /Sidebar --> 
        
          <!-- Main Side -->
          <div class="main-side clearfix authorcontent tab-content">
            <div role="tabpanel" class="tab-pane active" id="user-posts">
                <div class="wpsm-title middle-size-title wpsm-cat-title">
                    <h5><span><?php echo $userpostslabel ?>:</span> <?php echo $author_name; ?></h5>
                </div>          
                <?php if ( have_posts() ) : ?>
                    <?php while ( have_posts() ) : the_post(); ?>
                        <?php include(rh_locate_template('inc/parts/query_type1.php')); ?>
                    <?php endwhile; ?>
                    <?php rehub_pagination(); ?>
                <?php else : ?>     
                    <div class="no-posts"><?php _e( 'Sorry. Author have no posts yet', 'rehub_framework' ); ?></div>
                <?php endif; ?> 
                <div class="clearfix"></div>               
            </div>
        <?php if ( class_exists( 'Woocommerce' ) ) : ?> 
            <div role="tabpanel" class="tab-pane" id="user-deals">
                <div class="wpsm-title middle-size-title wpsm-cat-title">
                    <h5><span><?php echo $userdealslabel ?>:</span> <?php echo $author_name; ?></h5>
                </div>
                <?php $args = array( 'post_type' => 'product', 'author' => $author_ID ); ?>
                <?php $deals = new WP_Query( $args ); ?>
                <?php if ( $deals->have_posts() ) : ?>
                    <div class="woo_offer_list">
                    <?php while ( $deals->have_posts() ) : $deals->the_post(); ?>
                        <?php include(rh_locate_template('inc/parts/woolistpart.php')); ?>
                    <?php endwhile; ?>
                    </div>
                    <?php rehub_pagination(); ?>
                <?php else : ?>
                        <div class="no-posts"><?php _e( 'Sorry. Author have no deals yet', 'rehub_framework' ); ?></div>
                <?php endif; wp_reset_postdata(); ?>
                <div class="clearfix"></div>                
            </div>
        <?php endif; ?>     
            <div role="tabpanel" class="tab-pane" id="user-comments">
                <div class="wpsm-title middle-size-title wpsm-cat-title">
                    <h5><span><?php _e('Browsing All Comments By', 'rehub_framework'); ?>:</span> <?php echo $author_name; ?></h5>
                </div>
                <ol class="commentlist">
                    <?php
                        $comments_v = get_comments( array(
                          'user_id' => $author_ID,
                          'status'  => 'approve',
                          'orderby' => 'comment_date',
                          'order'   => 'DESC',
                        ));

                        wp_list_comments( array(
                          'avatar_size'   => 50,
                          'max_depth'     => 4,
                          'style'         => 'ul',
                          'callback'      => 'rehub_framework_comments',
                          'reverse_top_level' => ( get_option( 'comment_order' ) === 'asc' ? 1 : 0 ),
                        ), $comments_v);
                        unset( $comments_v );
                    ?>
                </ol>
                <div id='comments_pagination'>
                        <?php paginate_comments_links( array( 'prev_text' => '&laquo;', 'next_text' => '&raquo;' ) ); ?>
                </div> 
                <div class="clearfix"></div>
            </div>
        </div>  
        <!-- /Main Side -->

    </div>
</div>
<!-- /CONTENT -->     
<!-- FOOTER -->
<?php get_footer(); ?>