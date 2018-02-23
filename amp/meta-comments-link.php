<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php
$comments_link_url = $this->get( 'comments_link_url' );
?>
<?php if ( $comments_link_url ) : ?>
	<?php $comments_link_text = $this->get( 'comments_link_text' ); ?>
	<div class="amp-wp-meta text-center">
		<a href="<?php echo esc_url( $comments_link_url ); ?>" class="wpsm-button green medium">
			<?php echo esc_html( $comments_link_text ); ?>
		</a>
	</div>
<?php endif; ?>
