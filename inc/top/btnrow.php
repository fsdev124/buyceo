<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}?>
<div class="btn_row_wrap">
<?php if (!empty ($row['btn_url'])) :?>
	<?php echo do_shortcode ('[rehub_affbtn btn_text="'.$row["btn_text"].'" meta_btn_url="'.$row["btn_url"].'" meta_btn_price="'.$row["btn_price"].'"]') ;?>
<?php else :?>
	<?php rehub_create_btn('yes') ;?>                                
<?php endif ;?>
</div>