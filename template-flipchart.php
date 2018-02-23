<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php
    /* Template Name: Auto Comparison chart Flipkart CE (beta) */
?>
<?php  
    $compareids = (get_query_var('compareids')) ? explode(',', get_query_var('compareids')) : '';   
?>

<?php if(!empty($compareids)) add_filter( 'pre_get_document_title', 'rh_compare_charts_title_dynamic', 100 );?>
<?php get_header(); ?>
<!-- CONTENT -->
<div class="rh-container"> 
    <div class="rh-content-wrap clearfix">
	    <!-- Main Side -->
        <div class="main-side page clearfix full_width">
            <div class="title"><h1><?php the_title(); ?></h1></div>  
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <article class="top_rating_text post"><?php the_content(); ?></article>
                <div class="clearfix"></div>
            <?php endwhile; endif; ?> 


            <?php $flipids = (!empty($compareids)) ? $compareids : '';?>
            <?php $cleanspec = array();?>
            <?php if(!empty($flipids) && count($flipids) >=2):?>
                <?php 
                foreach ($flipids as $flipid): // Here we get specification data and build clean array?>
                    <?php $flipidspec = get_post_meta($flipid, '_cegg_data_Flipkart', true); ?>
                    <?php if($flipidspec){$flipidspec = reset($flipidspec);}?>
                    <?php if(!empty($flipidspec['extra']['specificationList'])):?>
                        <?php 
                        foreach($flipidspec['extra']['specificationList'] as $specarray): ?>
                            <?php if(!empty($specarray['values']) && !empty($specarray['key']) && $specarray['key'] !='Important Note'):?>
                                <?php $generalkey = $specarray['key'];?>
                                <?php foreach($specarray['values'] as $id=>$f): ?>
                                    <?php if (!empty($f['key'])):?>
                                        <?php $key = $f['key'];?>
                                            <?php foreach ($f['value'] as $value) :?>
                                                <?php $cleanspec[$flipid][$generalkey][$key] = $value;?>
                                            <?php endforeach;?>                                   
                                    <?php endif;?>
                                <?php endforeach; ?>
                            <?php endif;?>
                        <?php endforeach; ?>
                    <?php endif;?>
                <?php endforeach;?>
            <?php endif;?>

            <?php if(!empty($cleanspec) && count($cleanspec) >=2):?>  
                <?php $diff_top_keys = call_user_func_array('array_diff_key',$cleanspec);?>
                <?php foreach($diff_top_keys as $diff_top_key=>$value): // Here we clean our common array from top keys which are not existed in all items?>
                    <?php foreach ($flipids as $flipid): ?>
                        <?php if (!empty($cleanspec[$flipid][$diff_top_key])):?>
                            <?php unset ($cleanspec[$flipid][$diff_top_key]);?>
                        <?php endif;?>                        
                    <?php endforeach;?>                        
                <?php endforeach;?> 

                <?php $flipshiftids = $flipids; $getfirstkey = array_shift($flipshiftids);?>
                    <?php foreach ($flipshiftids as $flipid): ?>
                        <?php if (empty($cleanspec[$flipid])) continue;?>
                        <?php if (empty($cleanspec[$getfirstkey])) break;?>
                        <?php foreach($cleanspec[$flipid] as $key => $value):?>
                            <?php if (false === array_key_exists($key, $cleanspec[$getfirstkey])) {
                                unset($cleanspec[$flipid][$key]);
                            }
                            ?>                                
                        <?php endforeach;?>
                    <?php endforeach;?>



                <?php /*We will leave only common values* foreach($cleanspec[$getfirstkey] as $key => $value):?>
                    <?php $checkvalues = array(); foreach ($flipids as $flipid):?>
                        <?php $checkvalues[$flipid] = $cleanspec[$flipid][$key];?>
                    <?php endforeach;?>

                    <?php $diff_inner_keys = call_user_func_array('array_diff_key',$checkvalues);?>
                    
                    <?php foreach($diff_inner_keys as $diff_inner_key=>$value): // Here we clean our common array from inner keys which are not existed in all items?>
                        <?php foreach ($flipids as $flipid): ?>
                            <?php if (!empty($cleanspec[$flipid][$key][$diff_inner_key])):?>
                                <?php unset ($cleanspec[$flipid][$key][$diff_inner_key]);?>
                            <?php endif;?>                        
                        <?php endforeach;?>                        
                    <?php endforeach;?>

                    <?php if (empty($cleanspec[$getfirstkey][$key])): // Deleted empty keys?>
                        <?php unset ($cleanspec[$getfirstkey][$key]);?>
                    <?php endif;?>                        

                <?php endforeach;*/?>                

                <?php $merged_values = call_user_func_array('array_merge_recursive', $cleanspec);?>
                <?php wp_enqueue_script('carouFredSel'); wp_enqueue_script('touchswipe'); ?>         
                <div class="top_chart table_view_charts loading">
                    <div class="top_chart_controls">
                        <a href="/" class="controls prev"></a>
                        <div class="top_chart_pagination"></div>
                        <a href="/" class="controls next"></a>
                    </div>
                    <div class="top_chart_first">
                        <ul>
                            <li class="row_chart_0 image_row_chart">
                                <div class="sticky-cell"><br /><label class="diff-label"><input class="re-compare-show-diff" name="re-compare-show-diff" type="checkbox" /><?php _e('Show only differences', 'rehub_framework');?></label></div>
                            </li>
                            <?php $i = 0;foreach($merged_values as $firstkey => $firstvalue):?>
                                <?php $i++;?>
                                <li class="row_chart_<?php echo $i;?> heading_row_chart">
                                    <?php echo $firstkey;?>
                                </li>
                                <?php $k = $i;foreach($firstvalue as $key => $value):?>
                                    <?php $k++; $i++;?>
                                    <li class="row_chart_<?php echo $k;?> meta_value_row_chart">
                                        <?php echo $key;?>
                                    </li>
                                <?php endforeach;?>
                            <?php endforeach;?>
                        </ul>
                    </div>
                    <div class="top_chart_wrap"><div class="top_chart_carousel">
                        <?php foreach ($flipids as $flipid):?>
                            <?php $badge = get_post_meta($flipid, 'is_editor_choice', true);?>
                            <?php $badgeclass = ($badge) ? 'ed_choice_col badge_'.$badge.' ' : '';?>
                            <div class="<?php echo $badgeclass?>top_rating_item top_chart_item compare-item-<?php echo $flipid?>"  data-compareid="<?php echo $flipid?>">
                                <ul>
                                    <li class="row_chart_0 image_row_chart">
                                        <div class="product_image_col sticky-cell">
                                            <?php if ($badge):?>
                                                <?php $label = rehub_option('badge_label_'.$badge.''); ?>
                                                <span class="re-line-badge re-line-table-badge badge_<?php echo $badge;?>"><span><?php echo $label;?></span></span>
                                            <?php endif;?>                                            
                                            <i class="fa fa-times-circle-o re-compare-close-in-chart"></i>
                                            <figure>
                                                <a href="<?php echo get_the_permalink($flipid);?>">
                                                    <?php       
                                                        $image_id = get_post_thumbnail_id($flipid);  
                                                        $image_url = wp_get_attachment_image_src($image_id,'full');  
                                                        $img = $image_url[0];
                                                    ?>
                                                    <img src="<?php echo bfi_thumb( $img, array( 'height' => 150) ); ?>" alt="" />                              
                                                </a>
                                            </figure>
                                            <h2>
                                                <a href="<?php echo get_the_permalink($flipid);?>">
                                                    <?php echo get_the_title($flipid);?>                     
                                                </a>
                                            </h2>
                                            <div class="rev-in-compare-flip">
                                                <?php $rating_score_clean = get_post_meta($flipid, 'rehub_review_overall_score', true); ?>
                                                <?php if ($rating_score_clean):?>
                                                    <div class="radial-progress" data-rating="<?php echo $rating_score_clean?>">
                                                        <div class="circle">
                                                            <div class="mask full">
                                                                <div class="fill"></div>
                                                            </div>
                                                            <div class="mask half">
                                                                <div class="fill"></div>
                                                                <div class="fill fix"></div>
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="inset">
                                                            <div class="percentage"><?php echo $rating_score_clean?></div>
                                                        </div>
                                                    </div>                                                            
                                                <?php endif;?>                                                        
                                            </div>  
                                            <div class="price-in-compare-flip mt20">
                                                <?php $price_from = get_post_meta($flipid, 'rehub_offer_product_price', true); ?>
                                                <?php if($price_from) :?>
                                                    <?php _e('Prices start from:');?> <span class="greencolor"><?php echo $price_from;?></span>
                                                    <a href="<?php echo get_the_permalink($flipid);?>" class="btn_offer_block mt15 rh-deal-compact-btn"><?php _e('Check all prices', 'rehub_framework');?></a>
                                                <?php endif;?>                                                
                                            </div>                                              
                                        </div>
                                    </li> 
                                    <?php $i = 0;foreach($merged_values as $firstkey => $firstvalue):?>
                                        <?php $i++;?>
                                        <li class="row_chart_<?php echo $i;?> heading_row_chart">
                                        </li>
                                        <?php $k = $i;foreach($firstvalue as $key => $value):?>
                                            <?php $k++;$i++;?>
                                            <li class="row_chart_<?php echo $k;?> meta_value_row_chart meta_value_left">
                                                <?php if(!empty($cleanspec[$flipid][$firstkey][$key])):?>
                                                    <?php echo $cleanspec[$flipid][$firstkey][$key];?>
                                                <?php else:?> -
                                                <?php endif;?>
                                            </li>
                                        <?php endforeach;?>
                                    <?php endforeach;?>                                                                           
                                </ul>
                            </div>
                        <?php endforeach;?>
                    </div></div>
                    <span class="top_chart_row_found" data-rowcount="<?php echo $i + 1;?>"></span>
                </div>
            <?php endif;?>
		</div>	
    </div>
</div>
<!-- /CONTENT -->     
<!-- FOOTER -->
<?php get_footer(); ?>