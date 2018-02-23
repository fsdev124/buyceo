<?php if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}?>
<?php $sticky_header = (isset ($row['sticky_header']) && $row['sticky_header'] == 1) ? ' sticky-cell': '';?>
<div class="product_image_col<?php echo $sticky_header; ?>">
    <?php if ($compareids !='') {echo '<i class="fa fa-times-circle-o re-compare-close-in-chart"></i>';}?>    
    <figure> 
        <?php echo re_badge_create('ribbonleft'); ?>    
        <?php 
        $affiliate_link_image = isset($row['image_link_affiliate']) ? $row['image_link_affiliate'] : '';
        $affiliate_link_title = isset($row['title_link_affiliate']) ? $row['title_link_affiliate'] : '';
        $link_on_thumb = ($affiliate_link_image =='1') ? rehub_create_affiliate_link() : get_the_permalink(); 
        $link_on_title = ($affiliate_link_title =='1') ? rehub_create_affiliate_link() : get_the_permalink();   
        $link_on_thumb_target = ($affiliate_link_image =='1') ? ' target="_blank" rel="nofollow"' : '';
        $link_on_title_target = ($affiliate_link_title =='1') ? ' target="_blank" rel="nofollow"' : '';   
        ?>

        <a href="<?php echo $link_on_thumb;?>"<?php echo $link_on_thumb_target;?>>
            <?php 
            $showimg = new WPSM_image_resizer();
            $showimg->use_thumb = true; 
            $showimg->no_thumb = get_template_directory_uri() . '/images/default/noimage_200_140.png' ;
            $showimg->height = '140';                     
            ?>        
            <?php $showimg->show_resized_image(); ?>
        </a>
    </figure>
    <h2>
        <a href="<?php echo $link_on_title;?>"<?php echo $link_on_title_target;?>>
            <?php echo rehub_truncate_title(65, get_the_ID());?>                                  
        </a>
    </h2>
</div>