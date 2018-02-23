<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<!doctype html>
<html amp <?php echo AMP_HTML_Utils::build_attributes_string( $this->get( 'html_tag_attributes' ) ); ?>>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
	<?php do_action( 'amp_post_template_head', $this ); ?>
	<style amp-custom>
		<?php $this->load_parts( array( 'style' ) ); ?>
		<?php do_action( 'amp_post_template_css', $this ); ?>
	</style>
	<script async custom-element="amp-social-share" src="https://cdn.ampproject.org/v0/amp-social-share-0.1.js"></script>
	<?php //Seo By yoast meta tags if existed		
		if(! class_exists('YoastSEO_AMP') ) {
			if ( class_exists('WPSEO_Options')) {
				$options = WPSEO_Options::get_option( 'wpseo_social' );
				if ( $options['twitter'] === true ) {
					WPSEO_Twitter::get_instance();
				}
				if ( $options['opengraph'] === true ) {
					$GLOBALS['wpseo_og'] = new WPSEO_OpenGraph;
				}
				do_action( 'wpseo_opengraph' );
			}
		}
	?>
</head>

<body class="<?php echo esc_attr( $this->get( 'body_class' ) ); ?>">

<?php $this->load_parts( array( 'header-bar' ) ); ?>

<article class="amp-wp-article">

	<?php do_action('ampforwp_post_before_design_elements') ?>
	<?php include(rh_locate_template('amp/title-section.php')); ?>

	<?php $this->load_parts( array( 'featured-image' ) ); ?>
	<div class="clearfix"></div>

	<div class="amp-wp-article-content">
		<?php do_action('ampforwp_inside_post_content_before') ?>
		<?php echo $this->get( 'post_amp_content' ); // amphtml content; no kses ?>
		<?php do_action('ampforwp_inside_post_content_after') ?>
	</div>

	<footer class="amp-wp-article-footer">
		<?php $this->load_parts( apply_filters( 'amp_post_article_footer_meta', array('rehub-amp-social', 'meta-comments-link' ) ) ); ?>	
	</footer>

</article>

<?php $this->load_parts( array( 'footer' ) ); ?>

<?php do_action( 'amp_post_template_footer', $this ); ?>

</body>
</html>