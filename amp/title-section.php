<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}?>
<header class="amp-rh-article-header">
<?php $this->load_parts( array( 'rehub-amp-header-before-title' ) ); ?>	
<?php echo rh_expired_or_not($this->ID, 'span');?><h1 class="amp-rh-title rehub-main-font"><?php echo wp_kses_data( $this->get( 'post_title' ) ); ?></h1>		
<?php $this->load_parts( apply_filters( 'amp_post_article_header_meta', array( 'rehub-amp-header-meta' ) ) ); ?>
</header>

<?php if(rehub_option('amp_custom_in_header')):?>
	<div class="amp-wp-article-content">
		<?php echo do_shortcode(rehub_option('amp_custom_in_header')); // amphtml content;  ?>
	</div>
	<div class="clearfix"></div>	
<?php endif;?>