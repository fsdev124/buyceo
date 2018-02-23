<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $source
 * @var $type
 * @var $onclick
 * @var $custom_links
 * @var $custom_links_target
 * @var $img_size
 * @var $external_img_size
 * @var $images
 * @var $custom_srcs
 * @var $el_class
 * @var $interval
 * @var $css
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_gallery
 */
$output = $title = $type = $el_id = $onclick = $custom_links = $img_size = $custom_links_target = $images = $el_class = '';
$type = 'flexslider';
$onclick = 'link_image';
$img_size = 'thumbnail';
$attributes = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $attributes );
$default_src = vc_asset_url( 'vc/no_image.png' );

$autoplayclass = ($autoplay) ? ' autoplayfs' : '';
$gal_images = '';
$link_start = '';
$link_end = '';
$el_start = '';
$el_end = '';
$slides_wrap_start = '';
$slides_wrap_end = '';

$el_class = $this->getExtraClass( $el_class );
if ( 'nivo' === $type ) {
	$type = ' wpb_slider_nivo theme-default';
	wp_enqueue_script( 'nivo-slider' );
	wp_enqueue_style( 'nivo-slider-css' );
	wp_enqueue_style( 'nivo-slider-theme' );

	$slides_wrap_start = '<div class="nivoSlider">';
	$slides_wrap_end = '</div>';
} else if ( 'flexslider' === $type || 'flexslider_fade' === $type || 'flexslider_slide' === $type || 'fading' === $type ) {
	$el_start = '<li>';
	$el_end = '</li>';
	$slides_wrap_start = '<ul class="slides">';
	$slides_wrap_end = '</ul>';
	wp_enqueue_script( 'flexslider' );
} else if ( 'image_grid' === $type ) {
	wp_enqueue_script( 'vc_grid-js-imagesloaded' );
	wp_enqueue_script( 'isotope' );

	$el_start = '<li class="isotope-item">';
	$el_end = '</li>';
	$slides_wrap_start = '<ul class="wpb_image_grid_ul">';
	$slides_wrap_end = '</ul>';
}

if ( 'link_image' === $onclick ) {
	wp_enqueue_script('modulobox'); wp_enqueue_style('modulobox');
}

$flex_fx = '';
if ( $type == 'flexslider' || $type == 'flexslider_slide' ) {
	$type = ' flexslider post_slider media_slider blog_slider loading';
}  else if ( $type == 'image_grid' ) {
	$type = ' wpb_image_grid';
}

if ( '' === $images ) {
	$images = '-1,-2,-3';
}

$pretty_rel_random = ' data-rel="modsliderrel-' . get_the_ID() . '-' . rand() . '"';

if ( 'custom_link' === $onclick ) {
	$custom_links = vc_value_from_safe( $custom_links );
	$custom_links = explode( ',', $custom_links );
}

switch ( $source ) {
	case 'media_library':
		$images = explode( ',', $images );
		break;

	case 'external_link':
		$images = explode( ',', $custom_srcs );
		break;
}

foreach ( $images as $i => $image ) {
	switch ( $source ) {
		case 'media_library':
			if ( $image > 0 ) {
				$img = wpb_getImageBySize( array( 'attach_id' => $image, 'thumb_size' => $img_size ) );
				$thumbnail = $img['thumbnail'];
				$large_img_src = $img['p_img_large'][0];
			} else {
				$large_img_src = $default_src;
				$thumbnail = '<img src="' . $default_src . '" />';
			}
			break;

		case 'external_link':
			$image = esc_attr( $image );
			$dimensions = vcExtractDimensions( $external_img_size );
			$hwstring = $dimensions ? image_hwstring( $dimensions[0], $dimensions[1] ) : '';
			$thumbnail = '<img ' . $hwstring . ' src="' . $image . '" />';
			$large_img_src = $image;
			break;
	}

	$link_start = $link_end = '';

	switch ( $onclick ) {
		case 'img_link_large':
			$link_start = '<a href="' . $large_img_src . '" target="' . $custom_links_target . '">';
			$link_end = '</a>';
			break;

		case 'link_image':
			$link_start = '<a href="' . $large_img_src . '"' . $pretty_rel_random . '>';
			$link_end = '</a>';
			break;

		case 'custom_link':
			if ( ! empty( $custom_links[ $i ] ) ) {
				$link_start = '<a href="' . $custom_links[ $i ] . '"' . ( ! empty( $custom_links_target ) ? ' target="' . $custom_links_target . '"' : '' ) . '>';
				$link_end = '</a>';
			}
			break;
	}

	$gal_images .= $el_start . $link_start . $thumbnail . $link_end . $el_end;
}

$class_to_filter = 'wpb_gallery wpb_content_element vc_clearfix';
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );
$wrapper_attributes = array();
if ( ! empty( $el_id ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}

$output = '';
$output .= '<div class="' . $css_class . '" ' . implode( ' ', $wrapper_attributes ) . '>';
$output .= '<div class="wpb_wrapper">';
$output .= wpb_widget_title( array( 'title' => $title, 'extraclass' => 'wpb_gallery_heading' ) );
$output .= '<div class="modulo-lightbox wpb_gallery_slides' . $type . $autoplayclass .'">' . $slides_wrap_start . $gal_images . $slides_wrap_end . '</div>';
$output .= '</div>';
$output .= '</div>';

echo $output;