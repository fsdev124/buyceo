<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $content - shortcode content
 * @var $this WPBakeryShortCode_VC_Tta_Accordion|WPBakeryShortCode_VC_Tta_Tabs|WPBakeryShortCode_VC_Tta_Tour|WPBakeryShortCode_VC_Tta_Pageable
 */
$el_class = $css = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
$this->resetVariables( $atts, $content );
extract( $atts );

$this->setGlobalTtaInfo();

$this->enqueueTtaStyles();
$this->enqueueTtaScript();

// It is required to be before tabs-list-top/left/bottom/right for tabs/tours
$prepareContent = $this->getTemplateVariable( 'content' );

$class_to_filter = $this->getTtaGeneralClasses();
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

$output = '<div ' . $this->getWrapperAttributes() . '>';

if (!empty($atts['style_rehub'])) {
	if (!empty($atts['style_sec'])) {
		$output .= '<div class="wpsm-tabs n_b_tab vc_general vc_tta vc_tta-tabs vc_tta-color-grey vc_tta-style-flat vc_tta-shape-square vc_tta-spacing-1 vc_tta-o-no-fill vc_tta-tabs-position-top vc_tta-controls-align-center">';
	}
	else {
		$output .= '<div class="wpsm-tabs vc_general vc_tta vc_tta-tabs vc_tta-color-grey vc_tta-style-modern vc_tta-shape-square vc_tta-spacing-1 vc_tta-tabs-position-top vc_tta-controls-align-left">';	
	}
	$output .= $this->getTemplateVariable( 'tabs-list-top' );
	$output .= '<div class="vc_tta-panels-container">';
	$output .= '<div class="vc_tta-panels">';
	$output .= $prepareContent;
	$output .= '</div>';
	$output .= '</div>';
	$output .= '</div>';
}
else {
	$output .= $this->getTemplateVariable( 'title' );
	$output .= '<div class="' . esc_attr( $this->getTtaGeneralClasses() ) . '">';
	$output .= $this->getTemplateVariable( 'tabs-list-top' );
	$output .= $this->getTemplateVariable( 'tabs-list-left' );
	$output .= '<div class="vc_tta-panels-container">';
	$output .= $this->getTemplateVariable( 'pagination-top' );
	$output .= '<div class="vc_tta-panels">';
	$output .= $prepareContent;
	$output .= '</div>';
	$output .= $this->getTemplateVariable( 'pagination-bottom' );
	$output .= '</div>';
	$output .= $this->getTemplateVariable( 'tabs-list-bottom' );
	$output .= $this->getTemplateVariable( 'tabs-list-right' );
	$output .= '</div>';
}

$output .= '</div>';

echo $output;