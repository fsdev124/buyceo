<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php global $post;?>
<?php
$columns = (isset($columns)) ? $columns : '';
$aff_link = (isset($aff_link)) ? $aff_link : '';
$disable_btn = (isset($disable_btn)) ? $disable_btn : '';
$disable_act = (isset($disable_act)) ? $disable_act : '';
$price_meta = (isset($price_meta)) ? $price_meta : 'admin';
?>
<?php $comparebtn_enable = '';?>
<?php if(rehub_option('compare_btn_single') !='') :?>           
    <?php $comparebtn_enable = true; ?>
    <?php if(rehub_option('compare_btn_cats') != '') {
        $cats_array = esc_html(rehub_option('compare_btn_cats'));
        $cats_array = explode (',', $cats_array);
        if (!in_category ($cats_array, $post->ID)) $comparebtn_enable = false;
    }?> 

<?php endif;?>
<?php 
if ($aff_link == '1') {
    $link = rehub_create_affiliate_link ();
    $target = ' rel="nofollow" target="_blank"';
}
else {
    $link = get_the_permalink();
    $target = '';  
}
?>
<article class="col_item offer_grid mobile_compact_grid offer_grid_com<?php if ($disable_act != 1) :?> offer_act_enabled<?php endif;?><?php if ($disable_btn == 1) :?> no_btn_enabled<?php endif;?><?php echo rh_expired_or_not($post->ID, 'class');?>"> 
    <div class="info_in_dealgrid">
        <?php echo re_badge_create('ribbonleft'); ?>        
        <figure class="mb15">
            <?php 
                $offer_price_old = get_post_meta($post->ID, 'rehub_offer_product_price_old', true );
                $offer_price_old = apply_filters('rehub_create_btn_price_old', $offer_price_old);
                if(!empty($offer_price_old)){
                    $offer_price = get_post_meta($post->ID, 'rehub_offer_product_price', true );
                    $offer_price = apply_filters('rehub_create_btn_price', $offer_price);                    
                    if ( !empty($offer_price)) {
                        $offer_pricesale = rehub_price_clean($offer_price); //Clean price from currence symbols
                        $offer_priceold = rehub_price_clean($offer_price_old); //Clean price from currence symbols
                        if ((int)$offer_priceold !='0' && is_numeric($offer_priceold) && (int)$offer_priceold > (int)$offer_pricesale) {
                            $off_proc = 0 -(100 - ((int)$offer_pricesale / (int)$offer_priceold) * 100);
                            $off_proc = round($off_proc);
                            echo '<span class="grid_onsale">'.$off_proc.'%</span>';
                        }
                    }
                }

            ?>         
            <a class="img-centered-flex rh-flex-center-align rh-flex-justify-center" href="<?php echo $link;?>"<?php echo $target;?>>
                <?php 
                $showimg = new WPSM_image_resizer();
                $showimg->use_thumb = true;   
                $showimg->no_thumb = get_template_directory_uri() . '/images/default/noimage_250_180.png';                                 
                ?>
                <?php if(isset($custom_col)) : ?>
                    <?php $showimg->width = (int)$custom_img_width;?>
                    <?php $showimg->height = (int)$custom_img_height;?>                                 
                <?php else : ?>
                    <?php $showimg->width = '250';?> 
                    <?php $showimg->height = '180';?>   
                    <?php $showimg->crop = false;?>                                   
                <?php endif ; ?>           
                <?php $showimg->show_resized_image(); ?>
            </a>
        </figure>
        <?php do_action( 'rehub_after_compact_grid_figure' ); ?>
        <div class="grid_desc_and_btn">
            <div class="grid_row_info">
                <div class="price_row_grid">
                    <div class="price_for_grid floatleft">
                        <?php rehub_create_btn('no', 'price') ;?>
                    </div>
                    <div class="floatright vendor_for_grid">
                        <?php if ($price_meta == 'admin'):?>
                            <?php $author_id=$post->post_author;?>
                            <a class="admin" href="<?php echo get_author_posts_url( $author_id ) ?>" title="<?php the_author_meta( 'display_name', $author_id ); ?>">
                            <?php echo get_avatar( $author_id, '22' ); ?>
                            </a>
                        <?php elseif ($price_meta == 'store'):?>
                            <div class="brand_logo_small">       
                                <?php WPSM_Postfilters::re_show_brand_tax('logo'); //show brand logo?>
                            </div>                    
                        <?php endif;?>
                    </div>
                </div>     
                <?php do_action( 'rehub_after_compact_grid_price' ); ?>        
                <h3 class="<?php if(rehub_option('hotmeter_disable') !='1') :?><?php echo getHotIconclass($post->ID); ?><?php endif ;?>"><?php echo rh_expired_or_not($post->ID, 'span');?><a href="<?php echo $link;?>"<?php echo $target;?>><?php the_title();?></a></h3> 
                <?php do_action( 'rehub_after_compact_grid_title' ); ?>
            </div>
            <?php if ($disable_btn != 1) :?>
                <?php rehub_create_btn('no', 'button') ;?>
            <?php endif;?>   
        </div>                                       
    </div>
    <div class="meta_for_grid">
        <div class="cat_store_for_grid floatleft">
            <div class="cat_for_grid">
                <?php if ('post' == get_post_type($post->ID) && rehub_option('exclude_cat_meta') != 1) :?>
                    <?php $category = get_the_category($post->ID);  ?>
                    <?php if ($category) {$first_cat = $category[0]->term_id; meta_small( false, $first_cat, false, false );} ?>            
                <?php endif; ?>             
            </div>
            <?php do_action( 'rehub_after_compact_grid_cat' ); ?> 
            <div class="store_for_grid">
                <?php WPSM_Postfilters::re_show_brand_tax('list');?>
            </div>            
        </div>
        <div class="date_for_grid floatright">
            <span class="date_ago">
                <i class="fa fa-clock-o"></i><?php printf( __( '%s ago', 'rehub_framework' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) ); ?>
            </span>        
        </div>   
    </div>
    <?php do_action( 'rehub_after_compact_grid_meta' ); ?>
    <?php if ($disable_act != 1) :?>  
    <div class="re_actions_for_grid <?php if(!$comparebtn_enable) :?>two_col_btn_for_grid<?php endif;?>">
        <div class="btn_act_for_grid">
            <?php echo getHotThumb($post->ID, false);?>
        </div>
        <?php if($comparebtn_enable) :?>
            <div class="btn_act_for_grid">
                <span class="compare_for_grid">            
                    <?php $cmp_btn_args = array(); $cmp_btn_args['class']= 'comparecompact';?>
                    <?php if(rehub_option('compare_btn_cats') != '') {
                        $cmp_btn_args['cats'] = esc_html(rehub_option('compare_btn_cats'));
                    }?>
                    <?php echo wpsm_comparison_button($cmp_btn_args); ?> 
                </span>
            </div>
        <?php endif;?>         
        <div class="btn_act_for_grid">
            <span class="comm_number_for_grid"><?php echo get_comments_number(); ?></span>
        </div>       
    </div> 
    <?php do_action( 'rehub_after_compact_grid_actions' ); ?>
    <?php endif;?>      
</article>