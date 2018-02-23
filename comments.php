<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<div id="comments" class="clearfix">
<?php if(rehub_option('rehub_widget_comments') && comments_open()) : ?><?php echo htmlspecialchars_decode( stripslashes(rehub_kses(rehub_option('rehub_widget_comments')))); ?><div style="margin-bottom:15px; clear:both"></div><?php endif; ?>
<?php if(rehub_option('rehub_disable_comments') != '1') :?>
    <div class="post-comments">
        <?php
            if ( comments_open() ) :
            echo "<div class='title_comments'>";
            $title_nocomments = (rehub_option('rehub_commenttitle_text') != '') ? rehub_option('rehub_commenttitle_text') : __('We will be happy to hear your thoughts','rehub_framework');
            comments_number($title_nocomments, __('1 Comment','rehub_framework'), '% ' . __('Comments','rehub_framework') );
            echo "</div>";
            endif;
        ?>
    <?php if ((rehub_option('type_user_review') == 'full_review' || rehub_option('type_user_review') == 'user') && vp_metabox('rehub_post.rehub_framework_post_type') == 'review' && get_comments_number() > 1) :?>
        <div id="rehub-comments-tabs" data-postid = "<?php echo get_the_ID();?>">
            <span data-tabID="1" class="active"><?php _e('Show all', 'rehub_framework'); ?></span>
            <?php if (rehub_option('enable_btn_userreview') == '1') :?><span data-tabID="2"><?php _e('Most Helpful', 'rehub_framework'); ?></span><?php endif ;?>
            <span data-tabID="3"><?php _e('Highest Rating', 'rehub_framework'); ?></span>
            <span data-tabID="4"><?php _e('Lowest Rating', 'rehub_framework'); ?></span>
            <a href="#respond" class="rehub_scroll add_user_review_link def_btn"><?php _e("Add your review", "rehub_framework"); ?></a>
        </div>
    <?php endif ;?>
    <div id="tab-1">
        <ol class="commentlist">
            <?php

                $commenter = wp_get_current_commenter();
                $comment_author_email = $commenter['comment_author_email'];
                $user_ID = get_current_user_id();

                $comment_args = array(
                  'post_id' => get_the_ID(),
                  'orderby' => 'comment_date',
                  'order'   => 'DESC',
                  'update_comment_meta_cache' => false,
                  'status'  => 'approve',                    
                );

                if ( $user_ID ) {
                    $comment_args['include_unapproved'] = array( $user_ID );
                } elseif ( ! empty( $comment_author_email ) ) {
                    $comment_args['include_unapproved'] = array( $comment_author_email );
                }                

                $comments_v = get_comments($comment_args);                

                wp_list_comments(array(
                  'avatar_size'   => 50,
                  'max_depth'     => 4,
                  'style'         => 'ul',
                  'callback'      => 'rehub_framework_comments',
                  'reverse_top_level' => (get_option('comment_order')==='asc' ? 1 : 0),
                ), $comments_v);
                unset($comments_v);
            ?>
        </ol>
        <div id='comments_pagination'>
                <?php paginate_comments_links(array('prev_text' => '&laquo;', 'next_text' => '&raquo;')); ?>
        </div>      
    </div>

    <ol id="loadcomment-list" class="commentlist">
    </ol>
        <?php
            $custom_comment_field = '<textarea id="comment" name="comment" cols="30" rows="10" aria-required="true"></textarea>';
            $commenter = wp_get_current_commenter();
            comment_form(array(
                'comment_field'         => $custom_comment_field,
                'comment_notes_after'   => '',
                'logged_in_as'          => '',
                'comment_notes_before'  => '',
                'title_reply'           => __('Leave a reply', 'rehub_framework'),
                'cancel_reply_link'     => __('Cancel reply', 'rehub_framework'),
                'label_submit'          => __('Post comment', 'rehub_framework'),
                'fields' => apply_filters( 'comment_form_default_fields', array(

                    'author' =>
                        '<div class="usr_re"><input id="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .'" name="author" placeholder="'.__('Name', 'rehub_framework').'"></div>',

                    'email' =>
                        '<div class="email_re"><input id="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .'" name="email" placeholder="'.__('E-mail', 'rehub_framework').'"></div>',

                    'url' =>
                        '<div class="site_re end"><input id="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .'" name="url" placeholder="'.__('Website', 'rehub_framework').'"></div><div class="clearfix"></div>',
                )
              ),
            ));
         ?>
    </div> <!-- end comments div -->
<?php endif;?>
</div>