<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php global $post;?>
<?php if (rh_is_plugin_active('content-egg/content-egg.php')):?>
    <?php $module_id = get_post_meta($post->ID, '_rehub_module_ce_id', true);?>
    <?php $unique_id =  get_post_meta($post->ID, '_rehub_product_unique_id', true);?>
    <?php if($unique_id && $module_id):?>
        <?php $itemsync = \ContentEgg\application\components\ContentManager::getProductbyUniqueId($unique_id, $module_id, $post->ID);?>
    <?php endif;?>
<?php endif;?>
<?php if (rh_is_plugin_active('content-egg/content-egg.php') && !empty($itemsync)) :?>
    <!-- Title area -->
    <div class="rh-container rh_post_layout_compare_full clearfix">
        <div class="main-side single full_width clearfix"> 
            <div class="rh_post_layout_compare_full_holder">
                <div class="wpsm-one-third wpsm-column-first compare-full-images modulo-lightbox">
                    <?php wp_enqueue_script('modulobox');wp_enqueue_style('modulobox');?>             
                    <figure><?php echo re_badge_create('tablelabel'); ?>
                        <?php           
                            $image_id = get_post_thumbnail_id($post->ID);  
                            $image_url = wp_get_attachment_image_src($image_id,'full');
                            $image_url = $image_url[0]; 
                        ?> 
                        <a data-rel="rh_top_gallery" href="<?php echo $image_url;?>" target="_blank" data-thumb="<?php echo $image_url;?>">            
                            <?php WPSM_image_resizer::show_static_resized_image(array('lazy'=>true, 'thumb'=> true, 'crop'=> false, 'width'=> 350, 'no_thumb_url' => get_template_directory_uri() . '/images/default/noimage_500_500.png'));?>
                        </a>
                    </figure>
                    <?php $post_image_gallery = get_post_meta( $post->ID, 'rh_post_image_gallery', true );?>
                    <?php if(!empty($post_image_gallery)) :?>
                        <?php echo rh_get_post_thumbnails(array('video'=>1, 'columns'=>4, 'height'=>60));?>
                    <?php else :?>         
                        <?php if (!empty($itemsync['extra']['imageSet'])){
                            $ceimages = $itemsync['extra']['imageSet'];
                        }elseif (!empty($itemsync['extra']['images'])){
                            $ceimages = $itemsync['extra']['images'];
                        }
                        else {
                            $qwantimages = \ContentEgg\application\components\ContentManager::getViewData('GoogleImages', $post->ID);
                            if(!empty($qwantimages)) {
                                $ceimages = wp_list_pluck( $qwantimages, 'img' );
                            }else{
                                $ceimages = '';                                                
                            } 
                        } ?> 
                        <?php if(!empty($ceimages)):?>
                            <div class="compare-full-thumbnails rh_mini_thumbs limited-thumb-number mt15 mb15">
                                <?php foreach ($ceimages as $key => $gallery_img) :?>
                                    <?php if (isset($gallery_img['LargeImage'])){
                                        $image = $gallery_img['LargeImage'];
                                    }else{
                                        $image = $gallery_img;
                                    }?>                                               
                                    <a data-thumb="<?php echo $image?>" data-rel="rh_top_gallery" href="<?php echo $image; ?>" data-title="<?php echo  $itemsync['title'];?>"> 
                                        <?php WPSM_image_resizer::show_static_resized_image(array('src'=> $image, 'height'=> 65, 'title' => $itemsync['title'], 'no_thumb_url' => get_template_directory_uri().'/images/default/noimage_100_70.png'));?>  
                                    </a>
                                <?php endforeach;?>     
                            </div>
                        <?php endif;?>                
                    <?php endif;?>                                               
                </div>
                <div class="wpsm-two-third wpsm-column-last">
                    <div class="title_single_area">
                    <h1 class="<?php if(rehub_option('hotmeter_disable') !='1') :?><?php echo getHotIconclass($post->ID); ?><?php endif ;?>"><?php the_title(); ?></h1>
                    </div>
                    <div class="meta-in-compare-full rh-flex-center-align">
                        <?php $overall_review = rehub_get_overall_score();?>
                        <?php if($overall_review):?>
                            <?php $starscoreadmin = $overall_review*10 ;?>
                            <div class="star-big floatleft mr15">
                                <span class="stars-rate unix-star">
                                    <span style="width: <?php echo (int)$starscoreadmin;?>%;"></span>
                                </span>
                            </div>                      
                        <?php endif;?>
                        <span class="floatleft meta post-meta  mt0 mb0">
                            <?php rh_post_header_meta(false, false, true, true, true);?>
                        </span>
                        <span class="rh-flex-right-align">
                            <?php if(rehub_option('compare_btn_single') !='' && is_singular('post')) :?>
                                <?php $cmp_btn_args = array();?>
                                <?php if(rehub_option('compare_btn_cats') != '') {
                                    $cmp_btn_args['cats'] = esc_html(rehub_option('compare_btn_cats'));
                                }?>
                                <?php echo wpsm_comparison_button($cmp_btn_args); ?> 
                            <?php endif;?>                   
                        </span>
                    </div>                
                    <div class="wpsm-one-half wpsm-column-first">
                        <?php if (rehub_option('hotmeter_disable') != '1') {echo '<div class="mb20">';echo getHotThumb($post->ID, false, true);echo '</div>';}?>
                        <?php $prosvalues = vp_metabox('rehub_post.review_post.0.review_post_pros_text');?>
                        <?php if(!empty($prosvalues)):?>
                            <ul class="featured_list">        
                                <?php $prosvalues = explode(PHP_EOL, $prosvalues);?>
                                <?php foreach ($prosvalues as $prosvalue) {
                                    echo '<li>'.$prosvalue.'</li>';
                                }?>
                            </ul>                    
                        <?php else:?>
                            <?php if(!empty($itemsync['extra']['itemAttributes']['Feature'])){
                                $features = $itemsync['extra']['itemAttributes']['Feature'];
                            }
                            elseif(!empty($itemsync['extra']['keySpecs'])){
                                $features = $itemsync['extra']['keySpecs'];
                            }
                            ?>                       
                            <?php if (!empty ($features)) :?>
                                <ul class="featured_list">
                                    <?php $length = $maxlength = 0;?>
                                    <?php foreach ($features as $k => $feature): ?>
                                        <?php if(is_array($feature)){continue;}?>
                                        <?php $length = strlen($feature); $maxlength += $length; ?> 
                                        <li><?php echo $feature; ?></li>
                                        <?php if($k >= 3 || $maxlength > 150) break; ?>                             
                                    <?php endforeach; ?>
                                </ul>                                                            
                            <?php endif ;?>                     
                        <?php endif;?>

                        <div class="compare-button-holder">
                            <?php  
                                $offer_post_url = $itemsync['url'];
                                $offer_url = apply_filters('rh_post_offer_url_filter', $offer_post_url );
                            ?>
                            <?php $offer_price = (!empty($itemsync['price'])) ? $itemsync['price'] : ''; ?>
                            <?php $offer_price_old = (!empty($itemsync['priceOld'])) ? $itemsync['priceOld'] : ''; ?>
                            <?php $currency_code = (!empty($itemsync['currencyCode'])) ? $itemsync['currencyCode'] : ''; ?>
                            <?php $domain = (!empty($itemsync['domain'])) ? $itemsync['domain'] : ''; ?>
                            <?php $merchant = (!empty($itemsync['merchant'])) ? $itemsync['merchant'] : ''; ?>                                                                        
                            <?php if ($offer_url):?>
                                <?php if ($offer_price):?>
                                <div>
                                    <p class="price">
                                        <ins><?php echo \ContentEgg\application\helpers\TemplateHelper::formatPriceCurrency($offer_price, $currency_code, '', ''); ?>
                                            
                                        </ins>
                                        <?php if($offer_price_old):?>
                                        <del><?php echo \ContentEgg\application\helpers\TemplateHelper::formatPriceCurrency($offer_price_old, $currency_code, '', ''); ?> </del>
                                        <?php endif;?>
                                    </p>
                                </div>
                                <?php endif;?>
                                <?php echo rh_best_syncpost_deal($itemsync);?>
                                <?php $buy_best_text = (rehub_option('buy_best_text') !='') ? esc_html(rehub_option('buy_best_text')) : __('Buy for best price', 'rehub_framework'); ?>                        
                                <a href="<?php echo esc_url($offer_url);?>" class="re_track_btn wpsm-button rehub_main_btn btn_offer_block" target="_blank" rel="nofollow"><?php echo $buy_best_text;?></a>                        
                            <?php endif;?>                
                        </div>
                    </div>
                    <div class="wpsm-one-half wpsm-column-last"> 
                        <?php echo do_shortcode('[content-egg-block template=custom/all_merchant_widget]');?>
                        <div class="floatright mt15"><?php echo getHotThumb($post->ID, false, false, true);?></div>
                        <?php if(rehub_option('rehub_disable_share_top') =='1' || vp_metabox('rehub_post_side.disable_parts') == '1')  : ?>
                        <?php else :?>
                            <div class="top_share floatleft notextshare mt20">
                                <?php include(rh_locate_template('inc/parts/post_share.php')); ?>
                            </div>
                            <div class="clearfix"></div> 
                        <?php endif; ?>                                   
                    </div>                                                                                               
                </div> 
            </div>
        </div>
    </div>
    <!-- CONTENT -->
    <div class="rh-container"> 
    	<div class="rh-content-wrap clearfix">   
    	    <!-- Main Side -->
            <div class="main-side single<?php if(get_post_meta($post->ID, 'post_size', true) == 'full_post') : ?> full_width<?php endif; ?> clearfix">            
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <article class="post post-inner <?php $category = get_the_category($post->ID); if ($category) {$first_cat = $category[0]->term_id; echo 'category-'.$first_cat.'';} ?>" id="post-<?php the_ID(); ?>">
                            <?php
                            /****
                            TO add new tab - add next part to tab

                            <li id="wpsm_color_tab_li_deal">
                                <a href="#wpsm_spec_tab_li_deal" aria-controls="wpsm_spec_tab_li_deal" role="tab" data-toggle="tab" aria-expanded="true">
                                    <i class="fa fa-bomb" aria-hidden="true"></i>
                                    <span class="wpsm_spec_tab_title">
                                        <?php _e('All deals');?>
                                    </span>
                                </a>
                            </li>

                            And next to content 

                            <div role="wpsmtabcontent" class="tab-pane" id="wpsm_spec_tab_li_deal">
                                <?php echo do_shortcode('[content-egg-block template=custom/all_offers_list]' );?>
                            </div>

                            Change "deal" in ids and classes to own name

                            ****/
                            ?>
                            <?php $amazon_key = get_post_meta($post->ID, '_cegg_data_Amazon', true);?>
                            <?php $amazonae_key = get_post_meta($post->ID, '_cegg_data_AE__amazoncom', true);?>
                            <?php if (empty($amazonae_key)):?>
                                <?php $amazonae_key = get_post_meta($post->ID, '_cegg_data_AE__amazonin', true);?>
                            <?php endif;?>
                            <?php $infibeam_key = get_post_meta($post->ID, '_cegg_data_AE__infibeam', true);?>
                            <?php $flipkart_key = get_post_meta($post->ID, '_cegg_data_Flipkart', true);?>
                            <?php $googlebook_key = get_post_meta($post->ID, '_cegg_data_GoogleBooks', true);?>
                            <?php $youtube_key = get_post_meta($post->ID, '_cegg_data_Youtube', true);?>
                            <?php $flipkart_specification = $feedback_true = $amazon_rev = $infibeam_rev = '';?>
                            <?php if (!empty($flipkart_key)):?>
                                <?php $flipkart_key = reset($flipkart_key);?>
                                <?php $flipkart_specification = (!empty($flipkart_key['extra']['specificationList'])) ? true : false;?>
                            <?php endif;?>
                            <?php if (!empty($amazonae_key)):?>
                                <?php foreach ($amazonae_key as $key => $item) {
                                    if (!empty($item['extra']['comments'])){
                                        $feedback_true = true;
                                        $amazon_rev = true;
                                    }
                                }?>
                            <?php endif;?>
                            <?php if (!empty($infibeam_key)):?>
                                <?php foreach ($infibeam_key as $key => $item) {
                                    if (!empty($item['extra']['comments'])){
                                        $feedback_true = true;
                                        $infibeam_rev = true;
                                    }
                                }?>
                            <?php endif;?>  

                            <div class="wpsm_spec_tab_group">
                                <ul class="wpsm_spec_tab_ul">
                                    <li id="wpsm_color_tab_li_content" class="active">
                                        <a href="#wpsm_spec_tab_li_content" aria-controls="wpsm_spec_tab_li_content" role="tab" data-toggle="tab" aria-expanded="true">
                                            <i class="fa fa-building-o"></i>
                                            <span class="wpsm_spec_tab_title">
                                                <?php _e('Description');?>
                                            </span>
                                        </a>
                                    </li>
                                    <?php if( '' !== $post->post_content && $flipkart_specification):?>
                                        <li id="wpsm_color_tab_li_specs">
                                            <a href="#wpsm_spec_tab_li_specs" aria-controls="wpsm_spec_tab_li_specs" role="tab" data-toggle="tab" aria-expanded="true">
                                                <i class="fa fa-sliders" aria-hidden="true"></i>
                                                <span class="wpsm_spec_tab_title">
                                                    <?php _e('Specification');?>
                                                </span>
                                            </a>
                                        </li>                                    
                                    <?php endif;?>                     
                                    <?php if( !empty($youtube_key)):?>
                                        <li id="wpsm_color_tab_li_video">
                                            <a href="#wpsm_spec_tab_li_video" aria-controls="wpsm_spec_tab_li_video" role="tab" data-toggle="tab" aria-expanded="true">
                                                <i class="fa fa-video-camera" aria-hidden="true"></i>
                                                <span class="wpsm_spec_tab_title">
                                                    <?php _e('Videos');?>
                                                </span>
                                            </a>
                                        </li>
                                    <?php endif;?>                                
                                    <?php if( !empty($googlebook_key)):?>
                                        <li id="wpsm_color_tab_li_manual">
                                            <a href="#wpsm_spec_tab_li_manual" aria-controls="wpsm_spec_tab_li_manual" role="tab" data-toggle="tab" aria-expanded="true">
                                                <i class="fa fa-bookmark-o" aria-hidden="true"></i>
                                                <span class="wpsm_spec_tab_title">
                                                    <?php _e('Manuals');?>
                                                </span>
                                            </a>
                                        </li>
                                    <?php endif;?> 
                                    <?php if($feedback_true):?>
                                        <li id="wpsm_color_tab_li_feedback">
                                            <a href="#wpsm_spec_tab_li_feedback" aria-controls="wpsm_spec_tab_li_feedback" role="tab" data-toggle="tab" aria-expanded="true">
                                                <i class="fa fa-bullhorn" aria-hidden="true"></i>
                                                <span class="wpsm_spec_tab_title">
                                                    <?php _e('Feedback');?>
                                                </span>
                                            </a>
                                        </li>
                                    <?php endif;?>                                                               

                                </ul>
                            </div>

                            <div class="wpsm_spec_tab_wrapcont">                            
                                <div role="wpsmtabcontent" class="tab-pane active" id="wpsm_spec_tab_li_content">
                                    <?php if( '' !== $post->post_content):?>
                                    <?php if(rehub_option('rehub_single_before_post') && vp_metabox('rehub_post_side.show_banner_ads') != '1') : ?><div class="mediad mediad_before_content"><?php echo do_shortcode(rehub_option('rehub_single_before_post')); ?></div><?php endif; ?>                                    
                                        <?php the_content(); ?>
                                    <?php else:?>
                                        <?php the_content(); ?>
                                        <?php echo do_shortcode('[content-egg module=Flipkart template=custom/specification limit=1]' );?>
                                    <?php endif;?>                                
                                </div>
                                <?php if( '' !== $post->post_content && $flipkart_specification):?>
                                    <div role="wpsmtabcontent" class="tab-pane" id="wpsm_spec_tab_li_specs">
                                        <?php echo do_shortcode('[content-egg module=Flipkart template=custom/specification limit=1]' );?>                                
                                    </div>                                
                                <?php endif;?>                            
                                <?php if( !empty($youtube_key)):?>
                                    <div role="wpsmtabcontent" class="tab-pane" id="wpsm_spec_tab_li_video">
                                        <?php echo do_shortcode('[content-egg module=Youtube template=custom/slider]' );?>
                                    </div>                                 
                                <?php endif;?>  
                                <?php if( !empty($googlebook_key)):?>
                                    <div role="wpsmtabcontent" class="tab-pane" id="wpsm_spec_tab_li_manual">
                                        <?php echo do_shortcode('[content-egg module=GoogleBooks template=custom/simple]' );?>
                                    </div>                                 
                                <?php endif;?>
                                <?php if( !empty($feedback_true)):?>
                                    <div role="wpsmtabcontent" class="tab-pane" id="wpsm_spec_tab_li_feedback">
                                        <?php if ($amazon_rev):?>
                                            <?php echo do_shortcode('[content-egg module=AE__amazoncom template=custom/comments limit=2]' );?>
                                        <?php endif;?> 
                                        <?php if ($infibeam_rev):?>
                                            <?php echo do_shortcode('[content-egg module=AE__infibeam template=custom/comments]' );?>
                                        <?php endif;?>                                                                       
                                    </div>                                 
                                <?php endif;?>                   
                            </div>
                    </article>
                    <div class="clearfix"></div>
                    <?php include(rh_locate_template('inc/post_layout/single-common-footer.php')); ?>                    
                <?php endwhile; endif; ?>
                <?php comments_template(); ?>
    		</div>	
            <!-- /Main Side -->  
            <!-- Sidebar -->
            <?php if(get_post_meta($post->ID, 'post_size', true) == 'full_post') : ?><?php else : ?><?php get_sidebar(); ?><?php endif; ?>
            <!-- /Sidebar -->
        </div>
    </div>
    <!-- /CONTENT -->
<?php else:?>
    <div class="rh-container mt30 mb30"><?php echo 'This post layout requires Content Egg Plugin to be active and Product must have synchronized Content Egg offers. Enable synchronization in Theme option - affiliate';?></div>
<?php endif;?>     