<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php $video_schema = vp_metabox('rehub_post.video_post.0.video_post_schema');?>
<?php  if (($video_schema)=='1'): ?>
    <?php                                                                               
        $video_schema_title = vp_metabox('rehub_post.video_post.0.video_post_schema_title');
        $video_schema_desc = vp_metabox('rehub_post.video_post.0.video_post_schema_desc');
    ?>
    <?php if(vp_metabox('rehub_post.video_post.0.video_post_embed_url') !='') : ?>  
        <?php                                                                               
            $video_url = vp_metabox('rehub_post.video_post.0.video_post_embed_url');
        ?>
        <div class="media_video clearfix" itemprop="video" itemscope itemtype="http://schema.org/VideoObject">          
        <?php if(has_post_thumbnail()) : ?>
            <?php $image_id = get_post_thumbnail_id($post->ID);  $image_url = wp_get_attachment_url($image_id);?>
            <meta itemprop="thumbnail" content="<?php echo $image_url; ?>">
        <?php else :?>
            <meta itemprop="thumbnail" content="<?php echo parse_video_url($video_url, 'hqthumb');?>">    
        <?php endif ;?> 
            <div class="clearfix inner">
                <div class="video-container">
                    <?php if (vp_metabox('rehub_post_side.post_size') == 'full_post') : ?>
                        <?php echo parse_video_url($video_url, 'embed', '1068', '600');?>
                    <?php else : ?>
                        <?php echo parse_video_url($video_url, 'embed', '703', '395');?>
                    <?php endif ;?> 
                </div>
                <h4 itemprop="name">
                    <?php if (($video_schema_title) !='') :?>
                        <?php echo $video_schema_title ;?>
                    <?php else :?>
                        <?php the_title(); ?>
                    <?php endif ;?>    
                </h4>
                <p itemprop="description">
                    <?php if (($video_schema_desc) !='') :?>
                        <?php echo $video_schema_desc ;?>
                    <?php else :?>
                        <?php kama_excerpt('maxchar=250'); ?>
                    <?php endif ;?>
                </p>
            </div>
        </div>
    <?php else : ?>     
        <?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
            <?php if (vp_metabox('rehub_post_side.post_size') == 'full_post') : ?>
                <figure class="top_featured_image"><?php the_post_thumbnail('full'); ?></figure>
            <?php else : ?>
                <figure class="top_featured_image"><?php the_post_thumbnail(); ?></figure>
            <?php endif ;?>                                     
        <?php } ?>      
    <?php endif; ?>
<?php else : ?>
    <?php if(vp_metabox('rehub_post.video_post.0.video_post_embed_url') !='') : ?>
        <?php $video_url = vp_metabox('rehub_post.video_post.0.video_post_embed_url');?>
            <div class="video-container">
                <?php if (vp_metabox('rehub_post_side.post_size') == 'full_post') : ?>
                    <?php echo parse_video_url($video_url, 'embed', '1150', '635');?>
                <?php else : ?>
                    <?php echo parse_video_url($video_url, 'embed', '765', '430');?>
                <?php endif ;?> 
            </div>  
    <?php else : ?>     
        <?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
            <?php if (vp_metabox('rehub_post_side.post_size') == 'full_post') : ?>
                <figure class="top_featured_image"><?php the_post_thumbnail('full'); ?></figure>
            <?php else : ?>
                <figure class="top_featured_image"><?php the_post_thumbnail(); ?></figure>
            <?php endif ;?>                                     
        <?php } ?>      
    <?php endif; ?>     
<?php endif ?>