<?php
/**
 * Custom - Results Page.
 * @version 1.0
 * @author Eyal Fitoussi
 */
?>
<?php
$disable_filters = vp_metabox('rehub_top_table.top_review_filter_disable');
$image_width = vp_metabox('rehub_top_table.image_width');    
$image_height = vp_metabox('rehub_top_table.image_height'); 
$disable_crop = vp_metabox('rehub_top_table.disable_crop');             
$order_choose = vp_metabox('rehub_top_table.top_review_choose');
$rating_circle = vp_metabox('rehub_top_table.top_review_circle');
$module_width = vp_metabox('rehub_top_table.top_review_width');
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

?>
<!--  Main results wrapper - wraps the paginations, map and results -->
<div class="gmw-results-wrapper gmw-results-wrapper-<?php echo $gmw['ID']; ?> gmw-pt-results-wrapper">
	
	<?php do_action( 'gmw_search_results_start' , $gmw, $post ); ?>
	
	<?php do_action( 'gmw_before_top_pagination' , $gmw, $post ); ?>
	
	<!--  Pagination -->	
	<div class="gmw-pt-pagination-wrapper gmw-pt-bottom-pagination-wrapper">
		<div class="gmw-results-count floatleft">
			<span><?php gmw_results_message( $gmw, false ); ?></span>
		</div>	
		<!--  paginations -->
		<?php gmw_per_page( $gmw, $gmw['total_results'], 'paged' ); ?><?php gmw_pagination( $gmw, 'paged', $gmw['max_pages'] ); ?>
	</div> 
		
	 <!-- GEO my WP Map -->
    <?php 
    if ( $gmw['search_results']['display_map'] == 'results' ) {
        gmw_results_map( $gmw );
    }
    ?>
	
	<?php do_action( 'gmw_search_results_before_loop' , $gmw, $post ); ?>
	
	<!--  Results wrapper -->
	<div class="gmw-posts-wrapper">
		<div class="rh-top-table">
            <?php if ($image_width || $image_height):?>
                <style scoped>.rh-top-table .top_rating_item figure > a img{max-height: <?php echo $image_height;?>px; max-width: <?php echo $image_width;?>px;}.rh-top-table .top_rating_item figure > a, .rh-top-table .top_rating_item figure{height: auto;width: auto; border:none;}</style>
            <?php endif;?>
            <?php $sortable_col = ($disable_filters !=1) ? ' data-tablesaw-sortable-col' : '';?>
            <?php $sortable_switch = ($disable_filters !=1) ? ' data-tablesaw-sortable-switch' : '';?>
			<?php wp_enqueue_script('tablesorter'); wp_enqueue_style('tabletoggle'); ?>
	        <table data-tablesaw-sortable<?php echo $sortable_switch; ?> class="tablesaw top_table_block<?php if ($module_width =='1') : ?> full_width_rating<?php else :?> with_sidebar_rating<?php endif;?> tablesorter" cellspacing="0">	
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

				<!--  this is where wp_query loop begins -->
				<?php $i=0; while ( $gmw_query->have_posts() ) : $gmw_query->the_post();$i ++ ?>
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
				<!--  end of the loop -->

		        </tbody>
	    	</table>
    	</div>
	
	</div> <!--  results wrapper -->    
	
	<?php do_action( 'gmw_search_results_after_loop' , $gmw, $post ); ?>
	
	
</div> <!-- output wrapper -->
