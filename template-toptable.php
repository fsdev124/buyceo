<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php
    /* Template Name: Top table constructor (NEW) */
?>
<?php 
    $module_cats = vp_metabox('rehub_top_table.top_review_cat');
    $disable_filters = vp_metabox('rehub_top_table.top_review_filter_disable');
    $module_tag = vp_metabox('rehub_top_table.top_review_tag');
    $module_fetch = intval(vp_metabox('rehub_top_table.top_review_fetch'));
    $module_width = vp_metabox('rehub_top_table.top_review_width');
    $module_ids = vp_metabox('rehub_top_table.manual_ids');
    $module_custom_post = vp_metabox('rehub_top_table.top_review_custompost');
    $catalog_tax = vp_metabox('rehub_top_table.catalog_tax');
    $catalog_tax_slug = vp_metabox('rehub_top_table.catalog_tax_slug');   
    $catalog_tax_sec = vp_metabox('rehub_top_table.catalog_tax_sec');
    $catalog_tax_slug_sec = vp_metabox('rehub_top_table.catalog_tax_slug_sec');  
    $image_width = vp_metabox('rehub_top_table.image_width');    
    $image_height = vp_metabox('rehub_top_table.image_height'); 
    $disable_crop = vp_metabox('rehub_top_table.disable_crop');             
    $order_choose = vp_metabox('rehub_top_table.top_review_choose');
    $rating_circle = vp_metabox('rehub_top_table.top_review_circle');
    $module_pagination = vp_metabox('rehub_top_table.top_review_pagination');
    $module_field_sorting = vp_metabox('rehub_top_table.top_review_field_sort');
    $module_order = vp_metabox('rehub_top_table.top_review_order');
    $first_column_enable = vp_metabox('rehub_top_table.first_column_enable');
    $first_column_rank = vp_metabox('rehub_top_table.first_column_rank');
    $last_column_enable = vp_metabox('rehub_top_table.last_column_enable');
    $first_column_name = (vp_metabox('rehub_top_table.first_column_name') !='') ? esc_html(vp_metabox('rehub_top_table.first_column_name')) : __('Product', 'rehub_framework') ;
    $last_column_name = (vp_metabox('rehub_top_table.last_column_name') !='') ? esc_html(vp_metabox('rehub_top_table.last_column_name')) : '' ;
    $affiliate_link = vp_metabox('rehub_top_table.first_column_link');
    $rows = vp_metabox('rehub_top_table.columncontents');  //Get the rows  
    if ($module_fetch ==''){$module_fetch = '10';};   
    if ($rating_circle ==''){$rating_circle = '1';};
    $module_after = vp_metabox('rehub_top_table.column_after_block');
    $module_enable = vp_metabox('rehub_top_table.shortcode_table_enable');    

?>
<?php get_header(); ?>
<!-- CONTENT -->
<div class="rh-container"> 
    <div class="rh-content-wrap clearfix">
	    <!-- Main Side -->
        <div class="main-side page clearfix<?php if ($module_width =='1') : ?> full_width<?php endif;?>">
            <div class="title"><h1><?php the_title(); ?></h1></div>
            <?php if (!is_paged()) :?>
                <article class="top_rating_text post">
                    <?php if (have_posts()) : while (have_posts()) : the_post(); ?><?php the_content(); ?><?php endwhile; endif; ?>
                </article>
                <div class="clearfix"></div>
            <?php endif; ?>

            <?php if ($module_enable !='1') :?>

                <?php 
                    if ( get_query_var('paged') ) { 
                        $paged = get_query_var('paged'); 
                    } 
                    else if ( get_query_var('page') ) {
                        $paged = get_query_var('page'); 
                    } 
                    else {
                        $paged = 1; 
                    }        
                ?>
                <?php if ($order_choose == 'cat_choose') :?>
	                <?php $args = array( 
	                    'cat' => $module_cats, 
	                    'tag' => $module_tag, 
                        'posts_per_page' => $module_fetch, 
                        'paged' => $paged, 
	                    'post_status' => 'publish', 
	                    'ignore_sticky_posts' => 1, 
	                );
	                ?> 
                    <?php if(!empty ($module_field_sorting)) {$args['meta_key'] = $module_field_sorting; $args['orderby'] = 'meta_value_num';} ?>
                    <?php if($module_order =='asc') {$args['order'] = 'ASC';} ?>
            	<?php elseif ($order_choose == 'manual_choose' && $module_ids !='') :?>
	                <?php $args = array( 
	                    'post_status' => 'publish', 
	                    'ignore_sticky_posts' => 1, 
	                    'orderby' => 'post__in',
	                    'post__in' => $module_ids,
                        'posts_per_page'=> -1,

	                );
	                ?>
                <?php elseif ($order_choose == 'custom_post') :?>
                    <?php $args = array(  
                        'posts_per_page' => $module_fetch, 
                        'paged' => $paged, 
                        'post_status' => 'publish', 
                        'ignore_sticky_posts' => 1,
                        'post_type' => $module_custom_post, 
                    );
                    ?> 
                    <?php if (!empty ($catalog_tax_slug) && !empty ($catalog_tax)) : ?>
                        <?php $args['tax_query'] = array (
                            array(
                                'taxonomy' => $catalog_tax,
                                'field'    => 'slug',
                                'terms'    => $catalog_tax_slug,
                            ),
                        );?>
                    <?php endif ?>
                    <?php if (!empty ($catalog_tax_slug_sec) && !empty ($catalog_tax_sec)) : ?>
                        <?php 
                            $args['tax_query']['relation'] = 'AND';
                            $args['tax_query'][] = 
                            array(
                                'taxonomy' => $catalog_tax_sec,
                                'field'    => 'slug',
                                'terms'    => $catalog_tax_slug_sec,
                            );
                        ;?>
                    <?php endif ?>                    
                    <?php if(!empty ($module_field_sorting)) {$args['meta_key'] = $module_field_sorting; $args['orderby'] = 'meta_value_num';} ?>
                    <?php if($module_order =='asc') {$args['order'] = 'ASC';} ?>                                                            
            	<?php else :?>
	                <?php $args = array( 
                        'posts_per_page' => 10, 
	                    'paged' => $paged, 
	                    'post_status' => 'publish', 
	                    'ignore_sticky_posts' => 1, 
	                );
	                ?> 
                    <?php if(!empty ($module_field_sorting)) {$args['meta_key'] = $module_field_sorting; $args['orderby'] = 'meta_value_num';} ?>
                    <?php if($module_order =='asc') {$args['order'] = 'ASC';} ?>                                		
            	<?php endif ;?>	

                <?php 
                $args = apply_filters('rh_module_args_query', $args);
                $wp_query = new WP_Query($args);
                do_action('rh_after_module_args_query', $wp_query);   
                $i=0; if ($wp_query->have_posts()) :?>
                <?php if($disable_filters !=1):?>
                    
                <?php endif;?>
                <?php $sortable_col = ($disable_filters !=1) ? ' data-tablesaw-sortable-col' : '';?>
                <?php $sortable_switch = ($disable_filters !=1) ? ' data-tablesaw-sortable-switch' : '';?>
                <?php wp_enqueue_script('tablesorter');?><?php wp_enqueue_style('tabletoggle'); ?>
                <div class="rh-top-table">
                    <?php if ($image_width || $image_height):?>
                        <style scoped>.rh-top-table .top_rating_item figure > a img{max-height: <?php echo $image_height;?>px; max-width: <?php echo $image_width;?>px;}.rh-top-table .top_rating_item figure > a, .rh-top-table .top_rating_item figure{height: auto;width: auto; border:none;}</style>
                    <?php endif;?>
                    <table  data-tablesaw-sortable<?php echo $sortable_switch; ?> class="tablesaw top_table_block<?php if ($module_width =='1') : ?> full_width_rating<?php else :?> with_sidebar_rating<?php endif;?> tablesorter" cellspacing="0">
                        <thead> 
                        <tr class="top_rating_heading">
                            <?php if ($first_column_enable):?><th class="product_col_name" data-tablesaw-priority="persist"><?php echo $first_column_name; ?></th><?php endif;?>
                            <?php if (!empty ($rows)) {
                                $nameid=0;                       
                                foreach ($rows as $row) {                       
                                $col_name = (!empty($rows[$nameid]['column_name'])) ? $rows[$nameid]['column_name'] : '';
                                echo '<th class="col_name"'.$sortable_col.' data-tablesaw-priority="1">'.esc_html($col_name).'</th>';
                                $nameid++;
                                } 
                            }
                            ?>
                            <?php if ($last_column_enable):?><th class="buttons_col_name"<?php echo $sortable_col; ?> data-tablesaw-priority="1"><?php echo $last_column_name; ?></th><?php endif;?>                      
                        </tr>
                        </thead>
                        <tbody>
                    <?php while ($wp_query->have_posts()) : $wp_query->the_post(); $i ++?>     
                        <tr class="top_rating_item" id='rank_<?php echo $i?>'>
                            <?php if ($first_column_enable):?>
                                <td class="product_image_col"><?php echo re_badge_create('tablelabel'); ?>
                                    <figure>   
                                        <?php if (!is_paged() && $first_column_rank) :?><span class="rank_count"><?php if (($i) == '1') :?><i class="fa fa-trophy"></i><?php else:?><?php echo $i?><?php endif ?></span><?php endif ?>                                                                   
                                        <?php $link_on_thumb = ($affiliate_link =='1') ? rehub_create_affiliate_link() : get_the_permalink(); ?>
                                        <?php $link_on_thumb_target = ($affiliate_link =='1') ? ' class="re_track_btn btn_offer_block" target="_blank" rel="nofollow"' : '' ; ?>
                                        <a href="<?php echo $link_on_thumb;?>"<?php echo $link_on_thumb_target;?>>
                                            <?php 
                                            $showimg = new WPSM_image_resizer();
                                            $showimg->use_thumb = true;
                                            if(!$image_height) $image_height = 120;
                                            $showimg->height =  $image_height;
                                            if($image_width) {
                                                $showimg->width =  $image_width;
                                            }
                                            if($disable_crop) {
                                                $showimg->crop = false;
                                            }else{
                                                $showimg->crop = true;
                                            }                                        
                                            
                                            $showimg->show_resized_image();                                    
                                            ?>                                                                  
                                        </a>
                                    </figure>
                                </td>
                            <?php endif;?>
                            <?php 
                            if (!empty ($rows)) {
                                $pbid=0;                       
                                foreach ($rows as $row) {
                                $centered = ($row['column_center']== '1') ? ' centered_content' : '' ;
                                echo '<td class="column_'.$pbid.' column_content'.$centered.'">';
                                echo do_shortcode(wp_kses_post($row['column_html']));                       
                                $element = $row['column_type'];
                                    if ($element == 'meta_value') {
                                        include(rh_locate_template('inc/top/metacolumn.php'));
                                    } else if ($element == 'taxonomy_value') {
                                            include(rh_locate_template('inc/top/taxonomyrow.php'));
                                    } else if ($element == 'woo_attribute') {
                                        include(rh_locate_template('inc/top/wooattribute.php'));                 
                                    } else if ($element == 'review_function') {
                                        include(rh_locate_template('inc/top/reviewcolumn.php'));
                                    } else if ($element == 'user_review_function') {
                                        include(rh_locate_template('inc/top/userreviewcolumn.php')); 
                                    } else if ($element == 'woo_review') {
                                        include(rh_locate_template('inc/top/wooreviewrow.php'));
                                    } else if ($element == 'woo_btn') {
                                        include(rh_locate_template('inc/top/woobtn.php')); 
                                    } else if ($element == 'woo_vendor') {
                                        include(rh_locate_template('inc/top/woovendor.php'));                        
                                    } else if ($element == 'static_user_review_function') {
                                        include(rh_locate_template('inc/top/staticuserreviewcolumn.php'));
                                    } else {
                                        
                                    };
                                echo '</td>';
                                $pbid++;
                                } 
                            }
                            ?>
                            <?php if ($last_column_enable):?>
                                <td class="buttons_col">
                                    <?php if ('product' == get_post_type(get_the_ID())):?>
                                        <?php include(rh_locate_template('inc/top/woobtn.php'));?>
                                    <?php else:?>
                                	   <?php rehub_create_btn('') ;?>
                                    <?php endif ;?>                                
                                </td>
                            <?php endif ;?>
                        </tr>
                    <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?><?php _e('No posts for this criteria.', 'rehub_framework'); ?>
                <?php endif; ?>
                <?php if ($module_pagination =='1') :?><div class="pagination"><?php rehub_pagination();?></div><?php endif ;?>
                <?php wp_reset_query(); ?>
                <?php if ($module_after !=''):?>
                    <div class="clearfix"></div>
                    <article class="post after_top_module"><?php echo do_shortcode($module_after);  ?></article>
                <?php endif ;?>

            <?php endif; ?>

		</div>	
        <!-- /Main Side -->  
        <?php if ($module_width !='1') : ?>
        <!-- Sidebar -->
        <?php get_sidebar(); ?>
        <!-- /Sidebar --> 
        <?php endif;?>
    </div>
</div>
<!-- /CONTENT -->     
<!-- FOOTER -->
<?php get_footer(); ?>