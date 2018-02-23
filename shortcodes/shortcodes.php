<?php

require_once ( get_template_directory() . '/shortcodes/tinyMCE/tinyMCE.php'); 

//////////////////////////////////////////////////////////////////
// Buttons
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_shortcode_button') ) {
function wpsm_shortcode_button( $atts, $content = null ) {
        $atts = shortcode_atts(
			array(
				'color' => 'orange',
				'size' => 'medium',
				'icon' => '',
				'link' => '',				
				'target' => '',
				'border_radius' => '',
				'class' => '',
				'rel' => ''
			), $atts);
    $icon_show = (!empty($atts['icon'])) ? '<i class="fa fa-'.$atts['icon'].'"></i>' : ''; 
    $class_show = (!empty($atts['class'])) ? ' '.$atts['class'].'' : '';
    $link = (!empty($atts['link'])) ? $atts['link'] : '';    
    $border_show = (!empty($atts['border_radius'])) ? ' style="border-radius:'.$atts['border_radius'].'"' : '';
    if($link && $link == 'buddypress' && class_exists( 'BuddyPress' )){
    	if ( bp_is_active( 'messages' )){
    		global $post;
    		$author_id=$post->post_author;
    		$link = (is_user_logged_in()) ? wp_nonce_url( bp_loggedin_user_domain() . bp_get_messages_slug() . '/compose/?r=' . bp_core_get_username($author_id) .'&ref='. urlencode(get_permalink())) : '#';
			$class_show = (!is_user_logged_in() && rehub_option('userlogin_enable') == '1') ? $class_show.' act-rehub-login-popup' : '';    		
    	}
    }
	$out = '<a href="'.esc_url($link).'"';
    if ($atts['target'] !='') :
    	$out .=' target="'.$atts['target'].'"';
    endif;
    if ($atts['rel'] !='') :
    	$out .=' rel="'.$atts['rel'].'"';
    endif;    
    $out .=''.$border_show.' class="wpsm-button '.$atts['color'].' '.$atts['size'].''.$class_show.'">'.$icon_show.'' .do_shortcode($content). '</a>';
    return $out;
}
add_shortcode('wpsm_button', 'wpsm_shortcode_button');
}

//////////////////////////////////////////////////////////////////
// Column
//////////////////////////////////////////////////////////////////

if( !function_exists('wpsm_column_shortcode') ) {
	function wpsm_column_shortcode( $atts, $content = null ){
		extract( shortcode_atts( array(
			'size' => 'one-half',
			'position' =>'first'
		  ), $atts ) );
		  $out = '';
		  // Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
		  $content = do_shortcode($content);
		  $content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
		  $Old     = array( '<br />', '<br>' );
		  $New     = array( '','' );
		  $content = str_replace( $Old, $New, $content );		  
		  $out .= '<div class="wpsm-' . $size . ' wpsm-column-'.$position.'">' . $content . '</div>';
		  if($position == 'last') {
			$out .= '<div class="clearfix"></div>';
		      }
		  return $out;	  
	}
	add_shortcode('wpsm_column', 'wpsm_column_shortcode');
}


//////////////////////////////////////////////////////////////////
// Highlight
//////////////////////////////////////////////////////////////////

if ( !function_exists( 'wpsm_highlight_shortcode' ) ) {
	function wpsm_highlight_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'color' => 'yellow',
		  ),
		  $atts ) );
		  return '<span class="wpsm-highlight wpsm-highlight-'. $color .'">' . do_shortcode( $content ) . '</span>';
	
	}
	add_shortcode('wpsm_highlight', 'wpsm_highlight_shortcode');
}

//////////////////////////////////////////////////////////////////
// Color table
//////////////////////////////////////////////////////////////////
if ( !function_exists( 'wpsm_colortable_shortcode' ) ) {
	function wpsm_colortable_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'color' => 'black',
		  ),
		  $atts ) );
		  // Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
		  $content = do_shortcode($content);
		  $content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
		  $Old     = array( '<br />', '<br>' );
		  $New     = array( '','' );
		  $content = str_replace( $Old, $New, $content );		  
		  return '<div class="wpsm-table wpsm-table-'. $color .'">' . do_shortcode( $content ) . '</div>';
	
	}
	add_shortcode('wpsm_colortable', 'wpsm_colortable_shortcode');
}

//////////////////////////////////////////////////////////////////
// Quote
//////////////////////////////////////////////////////////////////	
if(!function_exists('wpsm_quote_shortcode')) {
	function wpsm_quote_shortcode($atts, $content) {   
		$out = '';
		$out .= '<blockquote class="wpsm-quote';
		if(!empty($atts['float']) && $atts['float']):
	      $out .= ' align'.$atts['float'].'';
	    endif;  
		$out .= '"';
		if(!empty($atts['width']) && $atts['width']):
	      $out .= 'style="width:'.$atts['width'].'"';
	    endif;
		$out .= '><p>'.$content.'</p>';
		if(!empty($atts['author']) && $atts['author']):
	      $out .= '<cite>'.$atts['author'].'</cite>';
	    endif;
		$out .='</blockquote>';
		return $out;
	} 
	// add the shortcode to system
	add_shortcode('wpsm_quote', 'wpsm_quote_shortcode');
}

//////////////////////////////////////////////////////////////////
// Dropcap
//////////////////////////////////////////////////////////////////	
if(!function_exists('wpsm_dropcap_shortcode')) {
function wpsm_dropcap_shortcode( $atts, $content = null ) { 
    return '<span class="wpsm_dropcap">'.$content.'</span>';  
}  
add_shortcode("wpsm_dropcap", "wpsm_dropcap_shortcode");  
}	

//////////////////////////////////////////////////////////////////
// Video
//////////////////////////////////////////////////////////////////
if(!function_exists('wpsm_shortcode_AddVideo')) {
function wpsm_shortcode_AddVideo( $atts, $content = null ) {
	$schema = $width = $height = $title = $description = '';
    @extract($atts);
    if ($schema =='yes') {
		$width  = ($width)  ? $width  :'703' ;
		$height = ($height) ? $height : '395';
    }
    else {
 		$width  = ($width)  ? $width  :'765' ;
		$height = ($height) ? $height : '430';   	
    }
	$title = ($title) ? $title : get_the_title();
	$description = ($description) ? $description : get_the_title();
	global $post;

		if ($schema =='yes') {
			$out = '<div class="media_video clearfix" itemscope itemtype="http://schema.org/VideoObject"><meta content="'.$title.'" itemprop="name"><meta itemprop="uploadDate" content="'.$post->post_date.'" /><meta itemprop="thumbnailURL" content="'.parse_video_url($content, "hqthumb").'"><div class="clearfix inner"><div class="video-container">'.parse_video_url($content, "embed", "$width", "$height").'</div><h4 itemprop="name">'.$title.'</h4><p itemprop="description">'.$description.'</p></div></div>';
		}
		else {	
		$out ='<div class="video-container">'.parse_video_url($content, "embed", "$width", "$height").'</div>';
		}
		
    return $out;
}
add_shortcode('wpsm_video', 'wpsm_shortcode_AddVideo');
}

//////////////////////////////////////////////////////////////////
// Lightbox
//////////////////////////////////////////////////////////////////
if(!function_exists('wpsm_shortcode_lightbox')) {
function wpsm_shortcode_lightbox( $atts, $content = null ) {
    wp_enqueue_script('modulobox');wp_enqueue_style('modulobox');
    @extract($atts);
	if(!isset($title)) {
		$title = '';
	}
	$out = '<span class="modulo-lightbox"><a href="'.$full.'" data-title="'.$title.'">' .do_shortcode($content). '</a></span>';
    return $out;
}
add_shortcode('wpsm_lightbox', 'wpsm_shortcode_lightbox');
}



//////////////////////////////////////////////////////////////////
// Boxes
//////////////////////////////////////////////////////////////////
if(!function_exists('wpsm_shortcode_box')) {
function wpsm_shortcode_box( $atts, $content = null ) {
        $atts = shortcode_atts(
			array(
				'type' => 'info',
				'float' => 'none',
				'textalign' => 'left',
				'width' => 'auto',
			), $atts);
	// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
	$content = do_shortcode($content);
	$content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
	$Old     = array( '<br />', '<br>' );
	$New     = array( '','' );
	$content = str_replace( $Old, $New, $content );

	$out = '<div class="wpsm_box '.$atts['type'].'_type '.$atts['float'].'float_box" style="text-align:'.$atts['textalign'].'; width:'.$atts['width'].'"><i></i><div>
			' .do_shortcode($content). '
			</div></div>';
    return $out;
}
add_shortcode('wpsm_box', 'wpsm_shortcode_box');
}


//////////////////////////////////////////////////////////////////
// Promoboxes
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_promobox_shortcode') ) {
function wpsm_promobox_shortcode( $atts, $content = null ) {
	
	extract(shortcode_atts(array(
			'background' => '#f8f8f8',
			'border_size' => '',
			'border_color' => '',
			'highligh_color' => '',
			'highlight_position' => '',
			'title' => '',
			'description' => ''
		), $atts));	

	$out = '<div class="wpsm_promobox" style="background-color:'.$background.' !important;';
	if((isset($atts['border_size']) && $atts['border_size']) && (isset($atts['border_color']) && $atts['border_color'])):
		$out .= ' border-width:'.$border_size.';border-color:'.$border_color.'!important; border-style:solid;';
	endif;
	if((isset($atts['highligh_color']) && $atts['highligh_color']) && (isset($atts['highlight_position']) && $atts['highlight_position'])):
		$out .= ' border-'.$highlight_position.'-width:3px !important;border-'.$highlight_position.'-color:'.$highligh_color.'!important;border-'.$highlight_position.'-style:solid';
	endif;
	$out .= '">';
	if((isset($atts['button_link']) && $atts['button_link']) && (isset($atts['button_text']) && $atts['button_text'])):
		$out .= '<a href="'.$atts['button_link'].'" class="wpsm-button rehub_main_btn" target="_blank" rel="nofollow"><span>'.$atts['button_text'].'</span></a>';
	endif;
	if(isset($atts['title']) && $atts['title']):
		$out .= '<div class="title_promobox">'.$atts['title'].'</div>';
	endif;
	if(isset($atts['description']) && $atts['description']):
		$out.= '<p>'.$atts['description'].'</p>';
	endif;
	$out .= '</div>';
    return $out;
}
add_shortcode('wpsm_promobox', 'wpsm_promobox_shortcode');
}

//////////////////////////////////////////////////////////////////
// Number box
//////////////////////////////////////////////////////////////////

if(!function_exists('wpsm_numbox_shortcode')) {
		function wpsm_numbox_shortcode($atts, $content) {  
			// get the optional style value
			extract(shortcode_atts( array('num' => '1', 'style' => '1'), $atts));
			// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
			$content = do_shortcode($content);
			$content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
			$Old     = array( '<br />', '<br>' );
			$New     = array( '','' );
			$content = str_replace( $Old, $New, $content );
			$styledot = ($style=='5' || $style=='6') ? '.' : '';			
			// return output
		    return "<div class=\"wpsm-numbox wpsm-style$style\"><span class=\"num\">" . $num . $styledot ."</span>" . $content . "</div>";  
		} 
		// add the shortcode to system
		add_shortcode('wpsm_numbox', 'wpsm_numbox_shortcode');
}

//////////////////////////////////////////////////////////////////
// Numbered heading
//////////////////////////////////////////////////////////////////

if(!function_exists('wpsm_numhead_shortcode')) {
		function wpsm_numhead_shortcode($atts, $content) {  
			// get the optional style value
			extract(shortcode_atts( array('num' => '1', 'style' => '1', 'heading' => '2'), $atts));
			// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
			$content = do_shortcode($content);
			$content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
			$Old     = array( '<br />', '<br>' );
			$New     = array( '','' );
			$content = str_replace( $Old, $New, $content );			
			// return output
		    return "<div class=\"wpsm-numhead wpsm-style$style\"><span>" . $num . "</span><h$heading>" . $content . "</h$heading></div>";  
		} 
		// add the shortcode to system
		add_shortcode('wpsm_numhead', 'wpsm_numhead_shortcode');
}

//////////////////////////////////////////////////////////////////
// Numbered circle
//////////////////////////////////////////////////////////////////

if(!function_exists('wpsm_numcircle_shortcode')) {
	function wpsm_numcircle_shortcode($atts, $content) {  
		// get the optional style value
		extract(shortcode_atts( array('num' => '1', 'style' => '1'), $atts));	
		// return output
	    return "<span class=\"wpsm-numcircle wpsm-style$style\">" . $num . "</span>";  
	} 
	// add the shortcode to system
	add_shortcode('wpsm_numcircle', 'wpsm_numcircle_shortcode');
}

//////////////////////////////////////////////////////////////////
// Titled box
//////////////////////////////////////////////////////////////////

if(!function_exists('wpsm_titlebox_shortcode')) {
		function wpsm_titlebox_shortcode($atts, $content) {   
			// get the optional style value
			extract(shortcode_atts( array('title' => 'Sample title', 'style' => '1'), $atts));
			// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
			$content = do_shortcode($content);
			$content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
			$Old     = array( '<br />', '<br>' );
			$New     = array( '','' );
			$content = str_replace( $Old, $New, $content );			
			// return the url
		    return '<div class="wpsm-titlebox wpsm_style_' . $style . '"><strong>' . $title . '</strong><div>'.$content.'</div></div>';  
		} 
		// add the shortcode to system
		add_shortcode('wpsm_titlebox', 'wpsm_titlebox_shortcode');
}

//////////////////////////////////////////////////////////////////
// Code box
//////////////////////////////////////////////////////////////////

if(!function_exists('wpsm_code_shortcode')) {
		function wpsm_code_shortcode($atts, $content) {   
			// get the optional style value
			extract(shortcode_atts( array('style' => '1'), $atts));
			// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
			$content = do_shortcode($content);
			$content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
			$Old     = array( '<br />', '<br>' );
			$New     = array( '','' );
			$content = str_replace( $Old, $New, $content );			
			// return the element
		    return '<pre class="wpsm-code wpsm_code_' . $style . '"><code>'. trim($content) .'</code></pre>'; 
			 
		} 
		// add the shortcode to system
		add_shortcode('wpsm_codebox', 'wpsm_code_shortcode');
}

//////////////////////////////////////////////////////////////////
// Accordition
//////////////////////////////////////////////////////////////////

// Main
if( !function_exists('wpsm_accordion_main_shortcode') ) {
	function wpsm_accordion_main_shortcode( $atts, $content = null  ) {	
		// Enque scripts
		wp_enqueue_script('jquery-ui-accordion');	
        
		// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
		$content = do_shortcode($content);
        $content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
		$Old     = array( '<br />', '<br>' );
		$New     = array( '','' );
		$content = str_replace( $Old, $New, $content );
		
		// Display the accordion	
		return '<div class="wpsm-accordion">' . do_shortcode($content) . '</div>';
	}
	add_shortcode( 'wpsm_accordion', 'wpsm_accordion_main_shortcode' );
}

// Section
if( !function_exists('wpsm_accordion_section_shortcode') ) {
	function wpsm_accordion_section_shortcode( $atts, $content = null  ) {
		extract( shortcode_atts( array(
		  'title' => 'Title',
		), $atts ) );
		
		// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
		$content = do_shortcode($content);
        $content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
		$Old     = array( '<br />', '<br>' );
		$New     = array( '','' );
		$content = str_replace( $Old, $New, $content );
		  
	   return '<h3 class="wpsm-accordion-trigger"><a href="#">'. $title .'</a></h3><div>' . do_shortcode($content) . '</div>';
	}
	add_shortcode( 'wpsm_accordion_section', 'wpsm_accordion_section_shortcode' );
}

//////////////////////////////////////////////////////////////////
// Testimonial
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_testimonial_shortcode') ) { 
	function wpsm_testimonial_shortcode( $atts, $content = null  ) {
		extract( shortcode_atts( array(
			'by' => '',
			'image' => '',
		  ), $atts ) );
		// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
		$content = do_shortcode($content);
        $content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
		$Old     = array( '<br />', '<br>' );
		$New     = array( '','' );
		$content = str_replace( $Old, $New, $content );
				  
		$out = '';
		$out .= '<div class="wpsm-testimonial"><div class="wpsm-testimonial-content">';
		$out .= $content;
		$out .= '</div><div class="wpsm-testimonial-author">';
		if (isset($image) && !empty($image)) {
			$out .= '<img src="'. $image .'" alt="'. $by .'" class="author_image">';
		}
		$out .= $by .'</div></div>';	
		return $out;
	}
	add_shortcode( 'wpsm_testimonial', 'wpsm_testimonial_shortcode' );
}


//////////////////////////////////////////////////////////////////
// Slider
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_shortcode_quick_slider') ) {
	function wpsm_shortcode_quick_slider($atts, $content = null) {
		extract(shortcode_atts(array(
				"ids" => '',
		), $atts));
		wp_enqueue_script('flexslider');
		return wpsm_get_post_slide($ids);
	}
	add_shortcode('wpsm_quick_slider', 'wpsm_shortcode_quick_slider');
}

//////////////////////////////////////////////////////////////////
// Post image attachment slider
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_post_slide') ) {
function wpsm_post_slide( $atts, $content = null ) {
		wp_enqueue_script('flexslider');
	return wpsm_get_post_slide();
}
add_shortcode('wpsm_post_images_slider', 'wpsm_post_slide');
function wpsm_get_post_slide($ids='') {
		$out = '';
		if (!empty($ids)) {
			$attachments = array_map( 'trim', explode( ",", $ids ) );
		}
		else {
			$attachments = get_posts( array(
            	'post_type' => 'attachment',
				'post_mime_type' => 'image',
            	'posts_per_page' => -1,
            	'post_parent' => get_the_ID(),
            	'exclude'     => get_post_thumbnail_id()
        	));
		}

        if ( $attachments ) {

            $out = '<div class="flexslider post_slider media_slider blog_slider loading"><ul class="slides">';
            foreach ( $attachments as $attachment ) {
            	if (!empty($ids)) {
            		$thumbimg = wp_get_attachment_image($attachment, 'full', false);
            	}
            	else {
            		$thumbimg = wp_get_attachment_image($attachment->ID, 'full', false);
            	}                      
                $out .= '<li>' . $thumbimg . '</li>';
            }
            $out .='</ul></div>';
            
        }
        return $out;
    }
}


//////////////////////////////////////////////////////////////////
// Map
//////////////////////////////////////////////////////////////////
if (! function_exists( 'wpsm_shortcode_googlemaps' ) ) :
 	function wpsm_shortcode_googlemaps($atts, $content = null) { 
	  	extract(shortcode_atts(array(
	    "title" => '',
	    "location" => '',
	    "height" => '300px',
	    "zoom" => 10,
	    "align" => '',
	    "lat" => '',
	    "lng" => '',
	    "key" => ''
	  ), $atts));
  
		// load scripts
		$fullkey = empty($key) ? 'sensor=false' : 'key='. $key;
		wp_enqueue_script('wpsm_googlemap');
		wp_enqueue_script('wpsm_googlemap_api', 'https://maps.googleapis.com/maps/api/js?'. $fullkey, array( 'jquery' ), '', true);
		$output = '';
  
	  	if ($location){
	   		$output .= '<div id="map_canvas_'.uniqid().'" class="wpsm_googlemap wpsm_gmap_loc" style="height:'.$height.';width:100%">';
	    	$output .= (!empty($title)) ? '<input class="title" type="hidden" value="'.$title.'" />' : '';
	    	$output .= '<input class="location" type="hidden" value="'.$location.'" />';
	    	$output .= '<input class="zoom" type="hidden" value="'.$zoom.'" />';
	    	$output .= '<div class="map_canvas"></div>';
	   		$output .= '</div>';   
	  	}  
  		elseif ($lat && $lng){
   			$output .= '<div id="map_canvas_'.uniqid().'" class="wpsm_googlemap wpsm_gmap_pos" style="height:'.$height.';width:100%">';
    		//$output .= (!empty($title)) ? '<input class="title" type="hidden" value="'.$title.'" />' : '';
    		$output .= '<input class="lat" type="hidden" value="'.$lat.'" />';
    		$output .= '<input class="lng" type="hidden" value="'.$lng.'" />';    
    		$output .= '<input class="zoom" type="hidden" value="'.$zoom.'" />';
    		$output .= '<div class="map_canvas"></div>';
   			$output .= '</div>';   
  		}
  	return $output;   
	}
 	add_shortcode("wpsm_googlemap", "wpsm_shortcode_googlemaps");
endif;


//////////////////////////////////////////////////////////////////
// Dividers
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_divider_shortcode') ) {
	function wpsm_divider_shortcode( $atts ) {
		extract( shortcode_atts( array(
			'style' => 'solid',
			'top' => '20px',
			'bottom' => '20px',
		  ),
		  $atts ) );
		$style_attr = '';
		if ( $top && $bottom ) {  
			$style_attr = 'style="margin-top: '. $top .';margin-bottom: '. $bottom .';"';
		} elseif( $bottom ) {
			$style_attr = 'style="margin-bottom: '. $bottom .';"';
		} elseif ( $top ) {
			$style_attr = 'style="margin-top: '. $top .';"';
		} else {
			$style_attr = NULL;
		}
	 return '<hr class="wpsm-divider '. $style .'_divider" '.$style_attr.' />';
	}
	add_shortcode( 'wpsm_divider', 'wpsm_divider_shortcode' );
}


//////////////////////////////////////////////////////////////////
// Price Table shortcode
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_price_shortcode') ) {
	function wpsm_price_shortcode( $atts, $content = null  ) {
	  // Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
	  $content = do_shortcode($content);
	  $content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
	  $Old     = array( '<br />', '<br>' );
	  $New     = array( '','' );
	  $content = str_replace( $Old, $New, $content );		
	   return '<ul class="wpsm-price clearfix">' . $content . '</ul><br class="clear" />';
	}
	add_shortcode( 'wpsm_price_table', 'wpsm_price_shortcode' );
}
/* Column of price*/
if( !function_exists('wpsm_price_column_shortcode') ) {
	function wpsm_price_column_shortcode( $atts, $content = null  ) {
		extract( shortcode_atts( array(
			'size' => '3',
			'featured' => '',
			'name' => 'Sample Name',
			'price' => '',
			'per' => '',
			'button_url' => '',
			'button_text' => 'Buy Now',
			'button_color' => 'orange',
		), $atts ) );
		
	  // Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
	  $content = do_shortcode($content);
	  $content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
	  $Old     = array( '<br />', '<br>' );
	  $New     = array( '','' );
	  $content = str_replace( $Old, $New, $content );		
		
		if($size == '2') $column_size = 'one-half';
		if($size == '3') $column_size = 'one-third';
		if($size =='4') $column_size = 'one-fourth';
		if($size =='5') $column_size = 'one-fifth';
	
		if($featured =='yes') $featured_price = 'wpsm-featured-price';
		else $featured_price = NULL;
			
		//fetch content  
		$out_price ='';
		$out_price .= '<li class="wpsm-price-column wpsm-'. $column_size .' '. $featured .' '. $featured_price .'">';
		$out_price .= '<div class="wpsm-price-header"><h4>'. $name. '</h4></div>';
		$out_price .= '<div class="wpsm-price-content"><div class="wpsm-price-cell"><span class="wpsm-price-value">'. $price .'</span>';
		if (!empty($per)) :
			$out_price .= ' /'.$per.'';
		endif;
		$out_price .='</div>';
		$out_price .= $content;
		if ($button_url){
			$out_price .= '<div class="wpsm-price-button"><a href="'. $button_url .'" class="wpsm-button '. $button_color .'"><span class="wpsm-button-inner">'. $button_text .'</span></a></div>';
		}
		$out_price .= '</div></li>';
		  
	   return $out_price;
	}
	add_shortcode( 'wpsm_price_column', 'wpsm_price_column_shortcode' );
}

//////////////////////////////////////////////////////////////////
// tab shortcode
//////////////////////////////////////////////////////////////////

if (!function_exists('wpsm_tabgroup_shortcode')) {
	function wpsm_tabgroup_shortcode( $atts, $content = null ) {
		
		//Enque scripts
		wp_enqueue_script('jquery-ui-tabs');
		
		// Display Tabs
		
		$defaults = array();
		extract( shortcode_atts( $defaults, $atts ) );
		preg_match_all( '/tab title="([^\"]+)"/i', $content, $matches, PREG_OFFSET_CAPTURE );
		$tab_titles = array();
		
		// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
		$content = do_shortcode($content);
        $content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
		$Old     = array( '<br />', '<br>' );
		$New     = array( '','' );
		$content = str_replace( $Old, $New, $content );
		
		if( isset($matches[1]) ){ $tab_titles = $matches[1]; }
		$output = '';
		if( count($tab_titles) ){
		    $output .= '<div id="wpsm-tab-'. rand(1, 100) .'" class="wpsm-tabs">';
			$output .= '<ul class="ui-tabs-nav wpsm-clearfix">';
			foreach( $tab_titles as $tab ){
				$output .= '<li><a href="#wpsm-tab-'. sanitize_title( $tab[0] ) .'">' . $tab[0] . '</a></li>';
			}
		    $output .= '</ul>';
		    $output .= do_shortcode( $content );
		    $output .= '</div>';
		} else {
			$output .= do_shortcode( $content );
		}
		return $output;
	}
	add_shortcode( 'wpsm_tabgroup', 'wpsm_tabgroup_shortcode' );
}
if (!function_exists('wpsm_tab_shortcode')) {
	function wpsm_tab_shortcode( $atts, $content = null ) {
		$defaults = array( 'title' => 'Tab' );
		extract( shortcode_atts( $defaults, $atts ) );
		
		// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
		$content = do_shortcode($content);
        $content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
		$Old     = array( '<br />', '<br>' );
		$New     = array( '','' );
		$content = str_replace( $Old, $New, $content );
		
		return '<div id="wpsm-tab-'. sanitize_title( $title ) .'" class="tab-content">'. do_shortcode( $content ) .'</div>';
	}
	add_shortcode( 'wpsm_tab', 'wpsm_tab_shortcode' );
}

//////////////////////////////////////////////////////////////////
// Toggle
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_toggle_shortcode') ) {
	function wpsm_toggle_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array( 'title' => 'Toggle Title', 'class' => ''), $atts ) );
		
		// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
		$content = do_shortcode($content);
        $content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
		$Old     = array( '<br />', '<br>' );
		$New     = array( '','' );
		$content = str_replace( $Old, $New, $content );
		
		// Display the Toggle

		$opens = '';
		if ( $class == 'active' ) {  
			$opens = 'style="display:block"';
		} else {
			$opens = NULL;
		}

		return '<div class="wpsm-toggle"><h3 class="wpsm-toggle-trigger '.$class.'">'. $title .'</h3><div class="wpsm-toggle-container"'.$opens.'>' . do_shortcode($content) . '</div></div>';
	}
	add_shortcode('wpsm_toggle', 'wpsm_toggle_shortcode');
}

//////////////////////////////////////////////////////////////////
// Get feeds
//////////////////////////////////////////////////////////////////

if( !function_exists('wpsm_shortcode_feeds') ) {
function wpsm_shortcode_feeds( $atts, $content = null ) {
    @extract($atts);
	$number  = ($number)  ? $number  : '5' ;
	return wpsm_get_feeds( $url , $number );
}
add_shortcode('wpsm_feed', 'wpsm_shortcode_feeds');
}

function wpsm_get_feeds( $feed , $number ){
	include_once(ABSPATH . WPINC . '/feed.php');

	$rss = @fetch_feed( $feed );
	if (!is_wp_error( $rss ) ){
		$maxitems = $rss->get_item_quantity($number); 
		$rss_items = $rss->get_items(0, $maxitems); 
	}
	if ($maxitems == 0) {
		$out = "<ul><li>No items</li></ul>";
	}else{
		$out = "<ul>";
		
		foreach ( $rss_items as $item ) : 
			$out .= '<li><a href="'. esc_url( $item->get_permalink() ) .'" title="Posted '.$item->get_date("j F Y | g:i a").'">'. esc_html( $item->get_title() ) .'</a></li>';
		endforeach;
		$out .='</ul>';
	}
	
	return $out;
}

//////////////////////////////////////////////////////////////////
// Percent bars
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_bar_shortcode') ) {
	function wpsm_bar_shortcode( $atts  ) {		
		extract( shortcode_atts( array(
			'title' => '',
			'percentage' => '100%',
			'color' => '#6adcfa'
		), $atts ) );		

		$output = '<div class="wpsm-bar wpsm-clearfix" data-percent="'. $percentage .'%">';
			if ( $title !== '' ) $output .= '<div class="wpsm-bar-title" style="background: '. $color .';"><span>'. $title .'</span></div>';
			$output .= '<div class="wpsm-bar-bar" style="background: '. $color .';"></div>';
			$output .= '<div class="wpsm-bar-percent">'.$percentage.' %</div>';
		$output .= '</div>';
		
		return $output;
	}
	add_shortcode( 'wpsm_bar', 'wpsm_bar_shortcode' );
}

//////////////////////////////////////////////////////////////////
// List
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_list_shortcode') ) {
function wpsm_list_shortcode( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'type' => 'arrow',
			'hover' => '',
			'gap' => '',
			'darklink' => ''
		), $atts ) ); 
		// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
		$content = do_shortcode($content);
        $content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
		$Old     = array( '<br />', '<br>' );
		$New     = array( '','' );
		$content = str_replace( $Old, $New, $content );
		$gapclass = ($gap == 'small') ? ' small_gap_list' : '';	
		$hoverclass = ($hover) ? ' wpsm_pretty_hover' : '';	
		$darklinkclass = ($darklink) ? ' darklink' : '';
    return '<div class="wpsm_'.$type.'list wpsm_pretty_list'.$gapclass.$hoverclass.$darklinkclass.'">'.do_shortcode($content).'</div>';  
}  
add_shortcode("wpsm_list", "wpsm_list_shortcode");
}

//////////////////////////////////////////////////////////////////
// Pros
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_pros_shortcode') ) {
function wpsm_pros_shortcode( $atts, $content = null ) {

		@extract($atts);
		if( empty($title) ) $title = 'Positives';
		// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
		$content = do_shortcode($content);
        $content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
		$Old     = array( '<br />', '<br>' );
		$New     = array( '','' );
		$content = str_replace( $Old, $New, $content );		 	
    return '<div class="wpsm_pros"><div class="title_pros">'.$title.'</div>'.do_shortcode($content).'</div>';  
}  
add_shortcode("wpsm_pros", "wpsm_pros_shortcode");
}

//////////////////////////////////////////////////////////////////
// Cons
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_cons_shortcode') ) {
function wpsm_cons_shortcode( $atts, $content = null ) {

		@extract($atts);
		if( empty($title) ) $title = 'Negatives'; 	
    return '<div class="wpsm_cons"><div class="title_cons">'.$title.'</div>'.do_shortcode($content).'</div>';  
}  
add_shortcode("wpsm_cons", "wpsm_cons_shortcode");
}

//////////////////////////////////////////////////////////////////
// Tooltip
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_shortcode_tooltip') ) {
function wpsm_shortcode_tooltip( $atts, $content = null ) {
	wp_enqueue_script('tipsy');

    @extract($atts);
	if( empty($gravity) ) $gravity = 'sw';
	$content_true = do_shortcode($content);
	if( empty($content_true) ) return;
	$out = '';
	$out .= '<span class="wpsm-tooltip wpsm-tooltip-sw" original-title="'.$content_true.'">'.$text.'</span>';
   return $out;
}
add_shortcode('wpsm_tooltip', 'wpsm_shortcode_tooltip');
}


//////////////////////////////////////////////////////////////////
// Member block
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_member_shortcode') ) {
function wpsm_member_shortcode( $atts, $content = null ) {
	@extract($atts);
	// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
	$content = do_shortcode($content);
	$content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
	$Old     = array( '<br />', '<br>' );
	$New     = array( '','' );
	$content = str_replace( $Old, $New, $content );	
	if($guest_text == '') $guest_text = ' This content visible only for members. You can login <a href="/wp-login.php" class="act-rehub-login-popup">here</a>.';
	if (is_user_logged_in() && !is_null( $content ) && !is_feed()) {
		return '<div class="wpsm-members"><strong>'.__("Members only", "rehub_framework").'</strong>' . do_shortcode( $content ) . '</div>';
	}
	else { 

		return '<div class="wpsm-members not-logined"><strong>'.__("Members only", "rehub_framework").'</strong> '.$guest_text.'</div>';	
		 }

	}	
add_shortcode('wpsm_member', 'wpsm_member_shortcode');
}

//////////////////////////////////////////////////////////////////
// Member content
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_shortcode_is_logged_in') ) {
function wpsm_shortcode_is_logged_in( $atts, $content = null ) {
	//@extract($atts);
	// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
	$content = do_shortcode($content);
	$content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
	$Old     = array( '<br />', '<br>' );
	$New     = array( '','' );
	$content = str_replace( $Old, $New, $content );	
	if (is_user_logged_in() && !is_null( $content ) && !is_feed()) {
		return $content;
	}
	else { 
		return;	
	}

}	
add_shortcode('wpsm_is_user', 'wpsm_shortcode_is_logged_in');
}

//////////////////////////////////////////////////////////////////
// Guest content
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_shortcode_is_guest') ) {
function wpsm_shortcode_is_guest( $atts, $content = null ) {
	//@extract($atts);
	// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
	$content = do_shortcode($content);
	$content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
	$Old     = array( '<br />', '<br>' );
	$New     = array( '','' );
	$content = str_replace( $Old, $New, $content );	
	if (!is_user_logged_in() && !is_null( $content ) && !is_feed()) {
		return $content;
	}
	else { 
		return;	
	}

}	
add_shortcode('wpsm_is_guest', 'wpsm_shortcode_is_guest');
}

//////////////////////////////////////////////////////////////////
// Vendor content
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_shortcode_is_vendor') ) {
function wpsm_shortcode_is_vendor( $atts, $content = null ) {
	//@extract($atts);
	// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
	$content = do_shortcode($content);
	$content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
	$Old     = array( '<br />', '<br>' );
	$New     = array( '','' );
	$content = str_replace( $Old, $New, $content );
	$user = wp_get_current_user();
	$rolesarray = array('vendor', 'seller', 'dc_vendor');
	foreach ($rolesarray as $role) {
		if ( in_array( $role, (array) $user->roles )) {
			return $content;
		}
	}
	return;


}	
add_shortcode('wpsm_is_vendor', 'wpsm_shortcode_is_vendor');
}

//////////////////////////////////////////////////////////////////
// Vendor content
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_shortcode_is_pending_vendor') ) {
function wpsm_shortcode_is_pending_vendor( $atts, $content = null ) {
	//@extract($atts);
	// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
	$content = do_shortcode($content);
	$content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
	$Old     = array( '<br />', '<br>' );
	$New     = array( '','' );
	$content = str_replace( $Old, $New, $content );
	$user = wp_get_current_user();
	$rolesarray = array('pending_vendor', 'dc_pending_vendor');
	foreach ($rolesarray as $role) {
		if ( in_array( $role, (array) $user->roles )) {
			return $content;
		}
	}
	return;

}	
add_shortcode('wpsm_is_pending_vendor', 'wpsm_shortcode_is_pending_vendor');
}

//////////////////////////////////////////////////////////////////
// Vendor content
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_shortcode_not_vendor_logged') ) {
function wpsm_shortcode_not_vendor_logged( $atts, $content = null ) {
	//@extract($atts);
	// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
	$content = do_shortcode($content);
	$content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
	$Old     = array( '<br />', '<br>' );
	$New     = array( '','' );
	$content = str_replace( $Old, $New, $content );
	$user = wp_get_current_user();
	if ( is_user_logged_in() && !in_array( 'vendor', (array) $user->roles )  && !in_array( 'seller', (array) $user->roles ) && !in_array( 'dc_vendor', (array) $user->roles )) {
		return $content;
	}		
	else { 
		return;	
	}

}	
add_shortcode('wpsm_not_vendor_logged', 'wpsm_shortcode_not_vendor_logged');
}

//////////////////////////////////////////////////////////////////
// Vendor content
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_shortcode_customer_user') ) {
function wpsm_shortcode_customer_user( $atts, $content = null ) {
	//@extract($atts);
	// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.

	if ( is_user_logged_in() && !in_array( 'customer', (array) $user->roles )  && !is_null( $content ) && !is_feed()) {
	$content = do_shortcode($content);
	$content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
	$Old     = array( '<br />', '<br>' );
	$New     = array( '','' );
	$content = str_replace( $Old, $New, $content );
	$user = wp_get_current_user();		
		return $content;
	}		
	else { 
		return;	
	}

}	
add_shortcode('wpsm_customer_user', 'wpsm_shortcode_customer_user');
}


//////////////////////////////////////////////////////////////////
// Gallery carousel
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_gallery_carousel') ) {
function wpsm_gallery_carousel( $atts, $content = null ) {
	wp_enqueue_script('owlcarousel');
	$title='';
    @extract($atts);
    $pretty_id = rand(5, 150) ;
    $everul =''; 
	$gals = explode(',', $ids);
	$everul .='<div class="modulo-lightbox media_owl_carousel carousel-style-2 pretty_photo_'.$pretty_id.' clearfix"><h3>'.$title.'</h3><div class="re_carousel" data-showrow="4" data-auto="">';
	foreach ($gals as $gal){
		$urlgal =  wp_get_attachment_url( $gal);
		$params = array( 'width' => 200, 'crop' => false  );
		$everul .='<div class="photo-item"><a data-rel="pretty_photo_'.$pretty_id.'" href="'.$urlgal.'" data-thumb="'.$urlgal.'" data-title="'.esc_attr(get_post_field( "post_excerpt", $gal)).'"><img src="'.bfi_thumb($urlgal, $params).'" alt="" /></a></div>';
	}
	$everul .='</div></div>';
    if (isset ($prettyphoto) && $prettyphoto == 'true'){
    	wp_enqueue_script('modulobox');wp_enqueue_style('modulobox');	
    } 			
	 return $everul;
}
add_shortcode('wpsm_minigallery', 'wpsm_gallery_carousel');
}

//////////////////////////////////////////////////////////////////
// Woo Box
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_woobox_shortcode') ) {
function wpsm_woobox_shortcode( $atts, $content = null ) {
	
	extract(shortcode_atts(array(
			'id' => '',
			'wooid'=> '',
		), $atts));
		
	if(!empty($id)):
		ob_start(); 
		rehub_get_woo_offer(esc_attr($id));
		$output = ob_get_contents();
		ob_end_clean();
		return $output;	
	endif;	

}
add_shortcode('wpsm_woobox', 'wpsm_woobox_shortcode');
}

//////////////////////////////////////////////////////////////////
// Woo Compare box
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_woocompare_shortcode') ) {
function wpsm_woocompare_shortcode( $atts, $content = null ) {
	
	extract(shortcode_atts(array(
			'ids' => '',
			'notitle' => '',
			'field' => '',
			'logo' => 'vendor'
		), $atts));
		
	if($ids || $field):
		if($ids){
			$ids = array_map( 'trim', explode( ",", $ids ) );
			$args = array(
		        'post__in' => $ids,
		        'numberposts' => '-1',
		        'orderby' => 'meta_value_num', 
		        'post_type' => 'product',  
		        'meta_key' => '_price', 
		        'order' => 'ASC'        
		    );
		}elseif ($field){
			$field = esc_html($field);
			$valuekey = get_post_meta(get_the_ID(), $field, true);
			$args = array(
				'post_type' => 'product',
		        'numberposts' => '-1',
		        'orderby' => 'meta_value_num',   
		        'meta_key' => '_price', 
		        'order' => 'ASC',
				'meta_query' => array(
					array(
						'key'     => $field,
						'value'   => $valuekey,
						'compare' => 'LIKE',
					),
				),		                
		    );			
		}
		ob_start(); 
		?>

			<?php $wp_query = new WP_Query( $args ); if ( $wp_query->have_posts() ) : ?> 
			<?php wp_enqueue_style('eggrehub'); ?>
			<div class="egg_sort_list re_sort_list simple_sort_list vendor-list-container">
			    <div class="aff_offer_links">			
				<?php while ( $wp_query->have_posts() ) : $wp_query->the_post();  global $product;  ?>
					<?php $woolink = get_post_permalink($product->get_id()) ;?>  
		            <div class="rehub_feat_block table_view_block">               
		                <div class="logo_offer_thumb offer_thumb">
		                	<?php if ($logo == 'brand') :?>
		                		<?php WPSM_Woohelper::re_show_brand_tax('logo', '80'); //show brand logo?>
		                	<?php elseif ($logo == 'product') :?>
			                    <?php 
			                        $showimg = new WPSM_image_resizer();
			                        $showimg->use_thumb = true;
			                        $showimg->no_thumb = rehub_woocommerce_placeholder_img_src('');
			                        $showimg->height = 80;
			                        $showimg->crop = false;           
			                        $showimg->show_resized_image();                                    
			                    ?>			
		                	<?php else:?>  
								<?php $vendor_id = get_the_author_meta( 'ID' );?>
								<?php if (defined('wcv_plugin_dir')):?>
									<a href="<?php echo WCV_Vendors::get_vendor_shop_page( $vendor_id );?>">
										<img src="<?php echo rh_show_vendor_avatar($vendor_id, 80, 80);?>" class="vendor_store_image_single" width="80" height="80" />
									</a>
								<?php elseif ( class_exists( 'WeDevs_Dokan' ) ):?>
									<a href="<?php echo dokan_get_store_url( $vendor_id );?>">
										<img src="<?php echo rh_show_vendor_avatar($vendor_id, 80, 80);?>" class="vendor_store_image_single" width="80" height="80" />
									</a>
								<?php elseif ( class_exists('WCMp')):?>
									<?php $is_vendor = is_user_wcmp_vendor( $vendor_id ); 
									if($is_vendor) :?>         	        
									<?php $vendorobj = get_wcmp_vendor($vendor_id); $store_url = $vendorobj->permalink;?>
									<a href="<?php echo esc_url($store_url);?>">
										<img src="<?php echo rh_show_vendor_avatar($vendor_id, 80, 80);?>" class="vendor_store_image_single" width="80" height="80" />
									</a>								
									<?php else:?>
										<img src="<?php echo rh_show_vendor_avatar($vendor_id, 80, 80);?>" class="vendor_store_image_single" width="80" height="80" />
									<?php endif;?>											
								<?php endif;?>
							<?php endif;?>
		                </div>
		                <div class="desc_col desc_simple_col">
		                	<?php if (!$notitle):?>
		                        <a href="<?php echo esc_url($woolink) ?>" class="no-color-link rehub-main-font blockstyle mb10 font90 lineheight15">
		                            <?php the_title(); ?>
		                        </a>
	                    	<?php endif;?>
	                    	<?php if ($notitle):?><div class="only-vendor-title"><?php endif;?>
	                        	<?php do_action( 'rehub_vendor_show_action' ); ?> 
	                        <?php if ($notitle):?></div><?php endif;?>
		                </div>                    
		                <div class="desc_col price_simple_col"> 
		                	<span class="price_count"><?php echo $product->get_price_html(); ?></span>    
		                </div>
		                <div class="buttons_col">
		                    <div class="priced_block clearfix">
			                    <?php if ( $product->is_in_stock() &&  $product->add_to_cart_url() !='') : ?>
			                        <?php  echo apply_filters( 'woocommerce_loop_add_to_cart_link',
			                            sprintf( '<a href="%s" data-product_id="%s" data-product_sku="%s" class="re_track_btn mb5 woo_loop_btn btn_offer_block %s %s product_type_%s"%s%s>%s</a>',
			                            esc_url( $product->add_to_cart_url() ),
			                            esc_attr( $product->get_id() ),
			                            esc_attr( $product->get_sku() ),
			                            $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
			                            $product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
			                            esc_attr( $product->get_type() ),
			                            $product->get_type() =='external' ? ' target="_blank"' : '',
			                            $product->get_type() =='external' ? ' rel="nofollow"' : '',
			                            esc_html( $product->add_to_cart_text() )
			                            ),
			                        $product );?>
			                    <?php endif; ?>
		                    </div>
							<a href="<?php the_permalink();?>" class="font80"><?php _e('Details', 'rehub_framework');?></a>		                    
		                </div>                                                                         
		            </div>               					

				<?php endwhile; ?>
				</div>    
			</div>
			<?php endif; wp_reset_query(); ?> 

		<?php

		$output = ob_get_contents();
		ob_end_clean();
		return $output;	
	endif;	

}
add_shortcode('wpsm_woocompare', 'wpsm_woocompare_shortcode');
}

//////////////////////////////////////////////////////////////////
// POPUP BUTTON
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_button_popup_funtion') ) {
function wpsm_button_popup_funtion( $atts, $content = null ) {
    extract(shortcode_atts(array(
		'color' => 'orange',
		'size' => 'medium',
		'icon' => 'none',
		'btn_text' => 'Show me popup',
		'max_width' => '500',
		'enable_icon' => ''    
    ), $atts));	
    $rand = rand(1, 100) ;
    $iconshow = ($enable_icon !='') ? '<span class="'.$icon.'"></span>' : '';
    $width = ($max_width !='') ? ' style="width:'.$max_width.'px"' : '';
	$out = '<div class="csspopup" id="custom_popup_rh_'.$rand.'"><div class="csspopupinner"'.$width.'><span class="cpopupclose" href="#">×</span>'.do_shortcode($content).'</div></div>';
	$out .= '<span data-popup="custom_popup_rh_'.$rand.'" class="wpsm-button csspopuptrigger wpsm-flat-btn '.$color.' '.$size.'"><span class="wpsm-button-inner">'.$iconshow.$btn_text.'</span></span>';
    return $out;
}
add_shortcode('wpsm_button_popup', 'wpsm_button_popup_funtion');
}

//////////////////////////////////////////////////////////////////
// Countdown
//////////////////////////////////////////////////////////////////
if (! function_exists( 'wpsm_countdown' ) ) :
	function wpsm_countdown($atts, $content = null) {	
		extract(shortcode_atts(array(
				"year" => '',
				"month" => '',
				"day" => '',
				"hour" => '00',
		), $atts));
		
		// load scripts
		wp_enqueue_script('lwtCountdown');
		$rand_id = rand(1, 100);
		ob_start(); 		
		?>

		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$('#countdown_dashboard<?php echo $rand_id;?>').show();
			  	$('#countdown_dashboard<?php echo $rand_id;?>').countDown({
				  	targetDate: {
					  'day': 	<?php echo $day ?>,
					  'month': 	<?php echo $month ?>,
					  'year': 	<?php echo $year ?>,
					  'hour': 	<?php echo $hour ?>,
					  'min': 		0,
					  'sec': 		0
				  	},
				  	omitWeeks: true,
				  	onComplete: function() { $('#countdown_dashboard<?php echo $rand_id;?>').hide() }
			  	});
			});
		</script>
		<div id="countdown_dashboard<?php echo $rand_id;?>" class="countdown_dashboard"> 			  
			<div class="dash days_dash"> <span class="dash_title">days</span>
				<div class="digit">0</div>
				<div class="digit">0</div>
			</div>
			<div class="dash hours_dash"> <span class="dash_title">hours</span>
				<div class="digit">0</div>
				<div class="digit">0</div>
			</div>
			<div class="dash minutes_dash"> <span class="dash_title">minutes</span>
				<div class="digit">0</div>
				<div class="digit">0</div>
			</div>
			<div class="dash seconds_dash"> <span class="dash_title">seconds</span>
				<div class="digit">0</div>
				<div class="digit">0</div>
			</div>
		</div>
		<!-- Countdown dashboard end -->
		<div class="clearfix"></div>		

		<?php		
		$output = ob_get_contents();
		ob_end_clean();
		return $output;	
	   
	}
	add_shortcode("wpsm_countdown", "wpsm_countdown");
endif;


//////////////////////////////////////////////////////////////////
// TITLE
//////////////////////////////////////////////////////////////////
if( !function_exists('rehub_title_function') ) {
function rehub_title_function( $atts, $content = null ) {  
    extract(shortcode_atts(array(
		'link' => '',				   
    ), $atts));
    $out = '';
    if(!empty($link)) :
	    $link_source = ($link =='affiliate') ? rehub_create_affiliate_link() : get_the_permalink() ;
		$link_target = ($link =='affiliate') ? ' target="_blank" rel="nofollow"' : '' ;
		$out .='<a href="'.$link_source.'"'.$link_target.'>';
	endif;
	$out .= get_the_title();
    if(!empty($link)) :
		$out .='</a>';
	endif;	
    return $out;
}
add_shortcode('rehub_title', 'rehub_title_function');
}

//////////////////////////////////////////////////////////////////
// AFF BUTTON
//////////////////////////////////////////////////////////////////
if( !function_exists('rehub_affbtn_function') ) {
function rehub_affbtn_function( $atts, $content = null ) { 
    extract(shortcode_atts(array(
		'btn_text' => '',
		'btn_url' => '',
		'btn_price' => '',
		'meta_btn_url' => '',
		'meta_btn_price' => '',
		'button_from_review' => '',				   
    ), $atts));
    if ($button_from_review =='1') :
    	ob_start();
    	rehub_create_btn(''); 
		$out = ob_get_contents();
		ob_end_clean();
	else :	
	    $button_url = (!empty($meta_btn_url)) ? get_post_meta( get_the_ID(), esc_html($meta_btn_url), true ) : $btn_url;
		if (empty ($button_url)) {$button_url = get_the_permalink();}
		$button_price = (!empty($meta_btn_price)) ? get_post_meta( get_the_ID(), esc_html($meta_btn_price), true ) : $btn_price;    
		$out = 	'<div class="priced_block clearfix">';
		if (!empty($button_price)) :
			$out .= '<span class="rh_price_wrapper"><span class="price_count">'.esc_html($button_price).'</span></span>'; 
		endif;
		$out .='<div><a href="'.esc_url($button_url).'" class="re_track_btn btn_offer_block" target="_blank" rel="nofollow">';
		if (!empty($btn_text)) :         
			$out .= $btn_text;
		elseif (rehub_option('rehub_btn_text') !='') :
			$out .= rehub_option("rehub_btn_text");
		else :
			$out .= __("Buy this item", "rehub_framework");	
		endif;
		$out .='</a></div></div>';
	endif;            
    return $out;
}
add_shortcode('rehub_affbtn', 'rehub_affbtn_function');
}

//////////////////////////////////////////////////////////////////
// EXCERPT
//////////////////////////////////////////////////////////////////
if( !function_exists('rehub_exerpt_function') ) {
function rehub_exerpt_function( $atts, $content = null ) { 
    extract(shortcode_atts(array(
		'length' => '120',
		'reviewtext' => '',
		'reviewheading'=> '',
		'reviewpros'=>'',
		'reviewcons'=>'',
    ), $atts));
    ob_start();
    if ($reviewtext =='1') :
    	echo vp_metabox('rehub_post.review_post.0.review_post_summary_text');
    elseif ($reviewheading =='1') :
    	echo vp_metabox('rehub_post.review_post.0.review_post_heading');    
	elseif ($reviewpros =='1') :
	    $prosvalues = vp_metabox('rehub_post.review_post.0.review_post_pros_text');
		if(empty($prosvalues)) return;	
	    $prosvalues = explode(PHP_EOL, $prosvalues);	    	
	    echo '<div class="wpsm_pros"><ul>';
	    foreach ($prosvalues as $prosvalue) {
	    	echo '<li>'.$prosvalue.'</li>';
	    }
	    echo '</ul></div>';	
	elseif ($reviewcons =='1') :
	    $consvalues = vp_metabox('rehub_post.review_post.0.review_post_cons_text');
		if(empty($consvalues)) return;		
	    $consvalues = explode(PHP_EOL, $consvalues);	    
	    echo '<div class="wpsm_cons"><ul>';
	    foreach ($consvalues as $consvalue) {
	    	echo '<li>'.$consvalue.'</li>';
	    }
	    echo '</ul></div>';		         
    else :
		kama_excerpt('maxchar='.$length.'');
	endif;
	$output = ob_get_contents();
	ob_end_clean();
	return $output; 
}
add_shortcode('rehub_exerpt', 'rehub_exerpt_function');
}

//////////////////////////////////////////////////////////////////
// Review and ads shortcode and functions
//////////////////////////////////////////////////////////////////

if( !function_exists('rehub_shortcode_review') ) {
function rehub_shortcode_review( $atts, $content = null ) {
	if(vp_metabox('rehub_post.review_post.0.review_post_product_shortcode') == '1') {	
		ob_start();
		rehub_get_review();
		$output = ob_get_contents();
		ob_end_clean();
		return $output; 
	}
}
}
add_shortcode('review', 'rehub_shortcode_review');


if( !function_exists('rehub_shortcode_woo_offer') ) {
function rehub_shortcode_woo_offer( $atts, $content = null ) {
	if(vp_metabox('rehub_post.review_post.0.review_woo_product.0.review_woo_offer_shortcode') == '1') {
		if (vp_metabox('rehub_post.review_post.0.review_post_schema_type') == 'review_woo_product') {
			$review_woo_link = vp_metabox('rehub_post.review_post.0.review_woo_product.0.review_woo_link');
			ob_start(); 
			rehub_get_woo_offer($review_woo_link);
			$output = ob_get_contents();
			ob_end_clean();
			return $output;
		} 
	}
}
}
add_shortcode('woo_offer_product', 'rehub_shortcode_woo_offer');

if( !function_exists('rehub_shortcode_woolist_offer') ) {
function rehub_shortcode_woolist_offer( $atts, $content = null ) {
	if(vp_metabox('rehub_post.review_post.0.review_woo_list.0.review_woo_list_shortcode') == '1') {
		if (vp_metabox('rehub_post.review_post.0.review_post_schema_type') == 'review_woo_list') {
			$review_woo_list_links = vp_metabox('rehub_post.review_post.0.review_woo_list.0.review_woo_list_links');
			if (is_array($review_woo_list_links)) { $review_woo_list_links = implode(',', $review_woo_list_links); }
			ob_start(); 
			$arg_array = array(
			    'data_source' => 'ids',
			    'ids'=> $review_woo_list_links,
			);			
			echo wpsm_woolist_shortcode($arg_array);
			$output = ob_get_contents();
			ob_end_clean();
			return $output;
		} 
	}
}
}
add_shortcode('woo_offer_list', 'rehub_shortcode_woolist_offer');

if( !function_exists('rehub_shortcode_quick_offer') ) {
function rehub_shortcode_quick_offer( $atts, $content = null ) {
        $atts = shortcode_atts(
			array(
				'id' => '',
			), $atts);	
		if (empty($atts['id'])) return false;
		ob_start(); 
		rehub_quick_offer($atts['id']);
		$output = ob_get_contents();
		ob_end_clean();
		return $output; 
}
}
add_shortcode('quick_offer', 'rehub_shortcode_quick_offer');

if(!function_exists('wpsm_shortcode_boxad')) {
function wpsm_shortcode_boxad( $atts, $content = null ) {
        $atts = shortcode_atts(
			array(
				'float' => 'none',
			), $atts);

	$out = '<div class="wpsm_boxad mediad align'.$atts['float'].'">
			' .rehub_option("rehub_shortcode_ads"). '
			</div>';
    return $out;
}
add_shortcode('wpsm_ads1', 'wpsm_shortcode_boxad');
}

if(!function_exists('wpsm_shortcode_boxad2')) {
function wpsm_shortcode_boxad2( $atts, $content = null ) {
        $atts = shortcode_atts(
			array(
				'float' => 'none',
			), $atts);

	$out = '<div class="wpsm_boxad mediad align'.$atts['float'].'">
			' .rehub_option("rehub_shortcode_ads_2"). '
			</div>';
    return $out;
}
add_shortcode('wpsm_ads2', 'wpsm_shortcode_boxad2');
}

//////////////////////////////////////////////////////////////////
// Specification for meta filter plugin
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_specification_shortcode') ) {
function wpsm_specification_shortcode($atts, $content = null ) {
extract(shortcode_atts(array(
	'id' => '',
	'title' => '',
	'product_id' => '',
), $atts));
if(class_exists('Woocommerce') && !empty($product_id)){
	$the_product = wc_get_product( $product_id );
	if(!empty($the_product)){
		ob_start();
		echo '<div class="woocommerce">';
		wc_display_product_attributes( $the_product );
		echo '</div>';
		$output = ob_get_contents();
		ob_end_clean();
		return $output;		
	}
}elseif(class_exists('MetaDataFilter')){
	global $post;
	if(!isset($atts['id']) || $atts['id'] =='') {
		$id = get_the_ID();
	}
	$title_label = (!empty($atts['title'])) ? $atts['title'] : __('Specification', 'rehub_framework');

	ob_start();
	echo '<div class="rehub_specification"><div class="title_specification">'.$title_label.'</div>';
	MetaDataFilterPage::draw_single_page_items($id, false);
	echo '</div>';
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}

}
add_shortcode('wpsm_specification', 'wpsm_specification_shortcode');
}

//////////////////////////////////////////////////////////////////
// Top rating shortcode
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_toprating_shortcode') ) {
function wpsm_toprating_shortcode( $atts, $content = null ) {
	
	extract(shortcode_atts(array(
			'id' => '',
			'postid' => '',
			'full_width' => '0',
		), $atts));
		
	if(isset($atts['id']) || isset($atts['postid'])):

		if(!empty($atts['id'])){
			$toppost = get_post($atts['id']);
			$module_cats = get_post_meta( $toppost->ID, 'top_review_cat', true ); 
	    	$module_tag = get_post_meta( $toppost->ID, 'top_review_tag', true ); 
	    	$module_fetch = get_post_meta( $toppost->ID, 'top_review_fetch', true ); 
	    	$module_ids = get_post_meta( $toppost->ID, 'manual_ids', true ); 
	    	$order_choose = get_post_meta( $toppost->ID, 'top_review_choose', true ); 
	    	$module_desc = get_post_meta( $toppost->ID, 'top_review_desc', true );
	    	$module_desc_fields = get_post_meta( $toppost->ID, 'top_review_custom_fields', true );
	    	$rating_circle = get_post_meta( $toppost->ID, 'top_review_circle', true );
	    	$module_pagination = get_post_meta( $toppost->ID, 'top_review_pagination', true );
	    	$module_field_sorting = get_post_meta( $toppost->ID, 'top_review_field_sort', true );
	    	$module_order = get_post_meta( $toppost->ID, 'top_review_order', true );    	
	    	if ($module_fetch ==''){$module_fetch = '10';}; 
	    	if ($module_desc ==''){$module_desc = 'post';};
	    	if ($rating_circle ==''){$rating_circle = '1';};
		}
		elseif(!empty($atts['postid'])){
			$module_cats = $module_tag = ''; 
	    	$module_fetch = 1; 
	    	$module_ids = explode(',', $atts['postid']); 
	    	$order_choose = 'manual_choose'; 
	    	$module_desc = 'post';
	    	$module_desc_fields = '';
	    	$rating_circle = 1;
	    	$module_field_sorting = '';
	    	$module_order = '';    				
		}
		ob_start(); 

    	?>
            <div class="clearfix"></div>
            <?php  if ( get_query_var('paged') ) { $paged = get_query_var('paged'); } else if ( get_query_var('page') ) {$paged = get_query_var('page'); } else {$paged = 1; }  ?>
            <?php if ($order_choose == 'cat_choose') :?>
                <?php $args = array( 
                    'cat' => $module_cats, 
                    'tag' => $module_tag, 
                    'posts_per_page' => $module_fetch, 
                    'paged' => $paged, 
                    'post_status' => 'publish', 
                    'ignore_sticky_posts' => 1, 
                    'meta_key' => 'rehub_review_overall_score', 
                    'orderby' => 'meta_value_num',
                    'meta_query' => array(
                        array(
                        'key' => 'rehub_framework_post_type',
                        'value' => 'review',
                        'compare' => 'LIKE',
                        )
                    )
                );
                ?> 
                <?php if(!empty ($module_field_sorting)) {$args['meta_key'] = $module_field_sorting;} ?>
                <?php if($module_order =='asc') {$args['order'] = 'ASC';} ?>	                
        	<?php elseif ($order_choose == 'manual_choose' && $module_ids !='') :?>
                <?php $args = array( 
                    'post_status' => 'publish', 
                    'ignore_sticky_posts' => 1,
                    'posts_per_page'=> -1, 
                    'orderby' => 'post__in',
                    'post_type' => 'any',
                    'post__in' => $module_ids
                );
                ?>
        	<?php else :?>
                <?php $args = array( 
                    'posts_per_page' => $module_fetch, 
                    'paged' => $paged, 
                    'post_status' => 'publish', 
                    'ignore_sticky_posts' => 1, 
                    'meta_key' => 'rehub_review_overall_score', 
                    'orderby' => 'meta_value_num',
                    'meta_query' => array(
                        array(
                        'key' => 'rehub_framework_post_type',
                        'value' => 'review',
                        'compare' => 'LIKE',
                        )
                    )
                );
                ?>
                <?php if(!empty ($module_field_sorting)) {$args['meta_key'] = $module_field_sorting;} ?>
                <?php if($module_order =='asc') {$args['order'] = 'ASC';} ?>	                             		
        	<?php endif ;?>	

	        <?php 
			    $args = apply_filters('rh_module_args_query', $args);
			    $wp_query = new WP_Query($args);
			    do_action('rh_after_module_args_query', $wp_query);
	        ?>
            <?php $i=0; if ($wp_query->have_posts()) :?>
            <div class="top_rating_block<?php if(isset($atts['full_width']) && $atts['full_width']=='1') : ?> full_width_rating<?php else :?> with_sidebar_rating<?php endif;?> list_style_rating">
            <?php while ($wp_query->have_posts()) : $wp_query->the_post(); global $post; $i ++?>     
                <div class="top_rating_item" id='rank_<?php echo $i?>'>                    
                    <div class="product_image_col">                        	
                        <figure><?php echo re_badge_create('ribbon'); ?>
                        	<span class="rank_count"><?php if (($i) == '1') :?><i class="fa fa-trophy"></i><?php else:?><?php echo $i?><?php endif ?></span>
                        	<a href="<?php the_permalink();?>">
                                <?php 
                                $showimg = new WPSM_image_resizer();
                                $showimg->use_thumb = true;
                                $width_figure_rating = apply_filters( 'wpsm_top_rating_figure_width', 120 );
                                $height_figure_rating = apply_filters( 'wpsm_top_rating_figure_height', 120 );
                                $showimg->height = $height_figure_rating;
                                $showimg->crop = true;
                                $showimg->show_resized_image();                                    
                                ?>
                        	</a>
                        </figure>
                    </div>                            
                <div class="desc_col">
                    <h2><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
                    <p>
                    	<?php if ($module_desc =='post') :?>
                    		<?php if ($full_width == 1):?>
                    			<?php kama_excerpt('maxchar=250'); ?>                        			
                    		<?php else:?>
                    			<?php kama_excerpt('maxchar=120'); ?> 
                    		<?php endif;?>
                    	<?php elseif ($module_desc =='review') :?>
                    		<?php echo wp_kses_post(vp_metabox('rehub_post.review_post.0.review_post_summary_text')); ?>
                        <?php elseif ($module_desc =='field') :?>
                            <?php if ( get_post_meta(get_the_ID(), $module_desc_fields, true) ) : ?>
                                <?php echo get_post_meta(get_the_ID(), $module_desc_fields, true) ?>
                            <?php endif; ?>                        		
                    	<?php elseif ($module_desc =='none') :?>
                    	<?php else :?>
                    		<?php if ($full_width == 1):?>
                    			<?php kama_excerpt('maxchar=250'); ?>                        			
                    		<?php else:?>
                    			<?php kama_excerpt('maxchar=120'); ?> 
                    		<?php endif;?>	
                		<?php endif;?>
                    </p>
                    <div class="star"><?php rehub_get_user_results('small', 'yes') ?></div>
                </div>
                <div class="rating_col">
            	<?php if(get_post_type($post->ID) == 'product'):?>
                	<?php $overall_review  = get_post_meta($post->ID, '_wc_average_rating', true);?>
                	<?php if ($overall_review){ $overall_review = $overall_review * 2;}?>
            	<?php else:?>	
            		<?php $overall_review  = rehub_get_overall_score();?>
            	<?php endif;?>                	
                <?php if ($rating_circle =='1'):?>
                    <div class="top-rating-item-circle-view">
                        <div class="radial-progress" data-rating="<?php echo $overall_review?>">
                            <div class="circle">
                                <div class="mask full">
                                    <div class="fill"></div>
                                </div>
                                <div class="mask half">
                                    <div class="fill"></div>
                                    <div class="fill fix"></div>
                                </div>
                                
                            </div>
                            <div class="inset">
                                <div class="percentage"><?php echo $overall_review ?></div>
                            </div>
                        </div>
                    </div>
                <?php elseif ($rating_circle =='2') :?> 
                    <div class="score square_score"> <span class="it_score"><?php echo $overall_review ?></span></div>       
                <?php else :?>
                    <div class="score"> <span class="it_score"><?php echo $overall_review ?></span></div>    
                <?php endif ;?>
                </div>
                <div class="buttons_col">
	            	<?php if(get_post_type($post->ID) == 'product'):?>
	            		<div class="priced_block">
	                        <a href="<?php the_permalink();?>" class="btn_offer_block">
	                            <?php if(rehub_option('rehub_btn_text_aff_links') !='') :?>
	                                <?php echo rehub_option('rehub_btn_text_aff_links') ; ?>
	                            <?php else :?>
	                                <?php _e('Choose offer', 'rehub_framework') ?>
	                            <?php endif ;?>
	                        </a>
                    	</div>
	            	<?php else:?>	
	            		<?php rehub_create_btn('') ;?>
	            	<?php endif;?>                 
                    <a href="<?php the_permalink();?>" class="read_full"><?php if(rehub_option('rehub_review_text') !='') :?><?php echo rehub_option('rehub_review_text') ; ?><?php else :?><?php _e('Read full review', 'rehub_framework'); ?><?php endif ;?></a>
                </div>
                </div>
            <?php endwhile; ?>
            </div>
            <?php if ($module_pagination =='1') :?><div class="pagination"><?php rehub_pagination();?></div><?php endif ;?>            
            <?php wp_reset_query(); ?>
            <?php else: ?><?php _e('No posts for this criteria.', 'rehub_framework'); ?>
            <?php endif; ?>

    	<?php 
		$output = ob_get_contents();
		ob_end_clean();
		return $output;   
	endif;	

}
add_shortcode('wpsm_top', 'wpsm_toprating_shortcode');
}

//////////////////////////////////////////////////////////////////
// Top table shortcode
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_toptable_shortcode') ) {
function wpsm_toptable_shortcode( $atts, $content = null ) {
	
	extract(shortcode_atts(array(
			'id' => '',
			'full_width' => '0',
		), $atts));
		
	if(isset($atts['id']) && $atts['id']):

		$toppost = get_post($atts['id']);
		$module_cats = get_post_meta( $toppost->ID, 'top_review_cat', true );
		$disable_filters = get_post_meta( $toppost->ID, 'top_review_filter_disable', true ); 
    	$module_tag = get_post_meta( $toppost->ID, 'top_review_tag', true ); 
    	$module_fetch = intval(get_post_meta( $toppost->ID, 'top_review_fetch', true ));  
    	$module_ids = get_post_meta( $toppost->ID, 'manual_ids', true ); 
    	$order_choose = get_post_meta( $toppost->ID, 'top_review_choose', true ); 
	    $module_custom_post = get_post_meta( $toppost->ID, 'top_review_custompost', true );
	    $catalog_tax = get_post_meta( $toppost->ID, 'catalog_tax', true );
	    $catalog_tax_slug = get_post_meta( $toppost->ID, 'catalog_tax_slug', true ); 
    	$catalog_tax_sec = get_post_meta( $toppost->ID, 'catalog_tax_sec', true );
    	$catalog_tax_slug_sec = get_post_meta( $toppost->ID, 'catalog_tax_slug_sec', true );  
    	$image_width = get_post_meta( $toppost->ID, 'image_width', true );    
    	$image_height = get_post_meta( $toppost->ID, 'image_height', true ); 
    	$disable_crop = get_post_meta( $toppost->ID, 'disable_crop', true ); 	       	
    	$module_field_sorting = get_post_meta( $toppost->ID, 'top_review_field_sort', true );
    	$module_order = get_post_meta( $toppost->ID, 'top_review_order', true );
	    $first_column_enable = get_post_meta( $toppost->ID, 'first_column_enable', true );
	    $first_column_rank = get_post_meta( $toppost->ID, 'first_column_rank', true ); 
	    $last_column_enable = get_post_meta( $toppost->ID, 'last_column_enable', true );
	    $first_column_name = (get_post_meta( $toppost->ID, 'first_column_name', true ) !='') ? esc_html(get_post_meta( $toppost->ID, 'first_column_name', true )) : __('Product', 'rehub_framework') ;
	    $last_column_name = (get_post_meta( $toppost->ID, 'last_column_name', true ) !='') ? esc_html(get_post_meta( $toppost->ID, 'last_column_name', true )) : '' ;
	    $affiliate_link = get_post_meta( $toppost->ID, 'first_column_link', true );
	    $rows = get_post_meta( $toppost->ID, 'columncontents', true ); //Get the rows     	    	
    	if ($module_fetch ==''){$module_fetch = '10';}; 
		
		ob_start(); 
    	?>
        <div class="clearfix"></div>
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
                'posts_per_page'=> -1, 
                'orderby' => 'post__in',
                'post__in' => $module_ids

            );
            ?>
	    <?php elseif ($order_choose == 'custom_post') :?>
	        <?php $args = array(  
	            'posts_per_page' => $module_fetch,  
	            'post_status' => 'publish', 
	            'ignore_sticky_posts' => 1,
	            'paged' => $paged, 
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
                'posts_per_page' => $module_fetch, 
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
        ?>
        <?php $i=0; if ($wp_query->have_posts()) :?>
        <?php wp_enqueue_script('tablesorter'); wp_enqueue_style('tabletoggle'); ?>
        <?php $sortable_col = ($disable_filters !=1) ? ' data-tablesaw-sortable-col' : '';?>
        <?php $sortable_switch = ($disable_filters !=1) ? ' data-tablesaw-sortable-switch' : '';?>
        <div class="rh-top-table">
            <?php if ($image_width || $image_height):?>
                <style scoped>.rh-top-table .top_rating_item figure > a img{max-height: <?php echo $image_height;?>px; max-width: <?php echo $image_width;?>px;}.rh-top-table .top_rating_item figure > a, .rh-top-table .top_rating_item figure{height: auto;width: auto; border:none;}</style>
            <?php endif;?>        
	        <table data-tablesaw-sortable<?php echo $sortable_switch; ?> class="tablesaw top_table_block<?php if ($full_width =='1') : ?> full_width_rating<?php else :?> with_sidebar_rating<?php endif;?> tablesorter" cellspacing="0">
	            <thead> 
	            <tr class="top_rating_heading">
	                <?php if ($first_column_enable):?><th class="product_col_name" data-tablesaw-priority="persist"><?php echo $first_column_name; ?></th><?php endif;?>
	                <?php if (!empty ($rows)) {
	                    $nameid=0;                       
	                    foreach ($rows as $row) {                       
	                    $col_name = $row['column_name'];
	                    echo '<th class="col_name"'.$sortable_col.' data-tablesaw-priority="1">'.esc_html($col_name).'</th>';
	                    $nameid++;
	                    } 
	                }
	                ?>
	                <?php if ($last_column_enable):?><th class="buttons_col_name" <?php echo $sortable_col; ?> data-tablesaw-priority="1"><?php echo $last_column_name; ?></th><?php endif;?>                      
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
	                            <?php $link_on_thumb_target = ($affiliate_link =='1') ? ' class="btn_offer_block" target="_blank" rel="nofollow"' : '' ; ?>
	                            <a href="<?php echo $link_on_thumb;?>" <?php echo $link_on_thumb_target;?>>
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
	                $pbid=0; 
	                if (!empty ($rows)) {
	                                          
	                    foreach ($rows as $row) {
	                    $centered = ($row['column_center']== '1') ? ' centered_content' : '' ;
	                    echo '<td class="column_'.$pbid.' column_content'.$centered.'">';
	                    echo do_shortcode(wp_kses_post($row['column_html']));                       
	                    $element = $row['column_type'];
	                        if ($element == 'meta_value') {
	                            include(rh_locate_template('inc/top/metacolumn.php'));
	                        } else if ($element == 'review_function') {
	                            include(rh_locate_template('inc/top/reviewcolumn.php'));
	                        } else if ($element == 'taxonomy_value') {
	                            include(rh_locate_template('inc/top/taxonomyrow.php'));                            
	                        } else if ($element == 'user_review_function') {
	                            include(rh_locate_template('inc/top/userreviewcolumn.php')); 
	                        } else if ($element == 'static_user_review_function') {
	                            include(rh_locate_template('inc/top/staticuserreviewcolumn.php'));
	                        } else if ($element == 'woo_review') {
	                            include(rh_locate_template('inc/top/wooreviewrow.php'));
	                        } else if ($element == 'woo_btn') {
	                            include(rh_locate_template('inc/top/woobtn.php')); 
	                        } else if ($element == 'woo_vendor') {
	                            include(rh_locate_template('inc/top/woovendor.php')); 
	                        } else if ($element == 'woo_attribute') {
	                            include(rh_locate_template('inc/top/wooattribute.php'));                             
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
        <?php wp_reset_query(); ?>

    	<?php 
		$output = ob_get_contents();
		ob_end_clean();
		return $output;   
	endif;	

}
add_shortcode('wpsm_toptable', 'wpsm_toptable_shortcode');
}

//////////////////////////////////////////////////////////////////
// Top charts shortcode
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_topcharts_shortcode') ) {
function wpsm_topcharts_shortcode( $atts, $content = null ) {
	
	extract(shortcode_atts(array(
			'id' => '',
		), $atts));
		
	if(isset($atts['id']) && $atts['id']):
		$topchart = get_post($atts['id']);
	    $type_chart = get_post_meta( $topchart->ID, 'top_chart_type', true );
	    $ids_chart = get_post_meta( $topchart->ID, 'top_chart_ids', true );
	    if($ids_chart) {$module_ids = explode(',', $ids_chart);}
	    $module_width = get_post_meta( $topchart->ID, 'top_chart_width', true );     
	    $rows = get_post_meta( $topchart->ID, 'columncontents', true ); //Get the rows 
	    $compareids = (get_query_var('compareids')) ? explode(',', get_query_var('compareids')) : '';    		
		ob_start(); 
    	?>
        <?php if ($compareids !='') :?>
            <?php $args = array( 
                'post_status' => 'publish', 
                'ignore_sticky_posts' => 1, 
                'orderby' => 'post__in',
                'post__in' => $compareids,
                'posts_per_page'=> -1,

            );
            ?>
    	<?php elseif (!empty($module_ids)) :?>
            <?php $args = array( 
                'post_status' => 'publish', 
                'ignore_sticky_posts' => 1, 
                'orderby' => 'post__in',
                'post__in' => $module_ids,
                'posts_per_page'=> -1,

            );
            ?>
    	<?php else :?>
            <?php $args = array( 
                'posts_per_page' => 5,  
                'post_status' => 'publish', 
                'ignore_sticky_posts' => 1, 
            );
            ?>                                		
    	<?php endif ;?>
        <?php if (post_type_exists( $type_chart )) {$args['post_type'] = $type_chart;} ?>	

        <?php 
	    $args = apply_filters('rh_module_args_query', $args);
	    $wp_query = new WP_Query($args);
	    do_action('rh_after_module_args_query', $wp_query);   
        $i=0; if ($wp_query->have_posts()) :?>
        <?php wp_enqueue_script('carouFredSel'); wp_enqueue_script('touchswipe'); ?>                                       
        <div class="top_chart table_view_charts loading">
            <div class="top_chart_controls">
                <a href="/" class="controls prev"></a>
                <div class="top_chart_pagination"></div>
                <a href="/" class="controls next"></a>
            </div>
            <div class="top_chart_first">
                <ul>
                    <?php if (!empty ($rows)) {
                        $nameid=0;                       
                        foreach ($rows as $row) {   
                        $element_type = $row['column_type']; 
                        $first_col_value = '<div';  
                        if (isset ($row['sticky_header']) && $row['sticky_header'] == 1) {$first_col_value .= ' class="sticky-cell"';} 
                        $first_col_value .= '>'.do_shortcode($row["column_name"]).'';
                        if (isset ($row['enable_diff']) && $row['enable_diff'] == 1) {$first_col_value .= '<br /><label class="diff-label"><input class="re-compare-show-diff" name="re-compare-show-diff" type="checkbox" />'.__('Show only differences', 'rehub_framework').'</label>';}                                                              
                        $first_col_value .= '</div>';                
                        echo '<li class="row_chart_'.$nameid.' '.$element_type.'_row_chart">'.$first_col_value.'</li>';
                        $nameid++;
                        } 
                    }
                    ?>
                </ul>
            </div>
        	<div class="top_chart_wrap"><div class="top_chart_carousel">
		        <?php while ($wp_query->have_posts()) : $wp_query->the_post(); $i ++?>     
		            <div class="<?php echo re_badge_create('class'); ?> top_rating_item top_chart_item compare-item-<?php echo get_the_ID();?>" id='rank_<?php echo $i?>' data-compareid="<?php echo get_the_ID();?>">
		                <ul>
		                <?php 
		                $pbid=0;
		                if (!empty ($rows)) {
		                                           
		                    foreach ($rows as $row) {                                                     
		                    $element = $row['column_type'];
		                        echo '<li class="row_chart_'.$pbid.' '.$element.'_row_chart">';
		                        if ($element == 'meta_value') {                                
		                            include(rh_locate_template('inc/top/metarow.php'));
		                        } else if ($element == 'image') {
		                            include(rh_locate_template('inc/top/imagerow.php'));
                                } else if ($element == 'imagefull') {
                                        include(rh_locate_template('inc/top/imagefullrow.php'));
		                        } else if ($element == 'title') {
		                            include(rh_locate_template('inc/top/titlerow.php'));   
		                        } else if ($element == 'taxonomy_value') {
		                            include(rh_locate_template('inc/top/taxonomyrow.php'));     
		                        } else if ($element == 'affiliate_btn') {
		                            include(rh_locate_template('inc/top/btnrow.php'));
		                        } else if ($element == 'review_link') {
		                            include(rh_locate_template('inc/top/reviewlinkrow.php'));
		                        } else if ($element == 'review_function') {
		                            include(rh_locate_template('inc/top/reviewrow.php'));          
		                        } else if ($element == 'user_review_function') {
		                            include(rh_locate_template('inc/top/userreviewcolumn.php'));
                                } else if ($element == 'static_user_review_function') {
                                    include(rh_locate_template('inc/top/staticuserreviewcolumn.php'));
                                } else if ($element == 'woo_review') {
                                    include(rh_locate_template('inc/top/wooreviewrow.php'));
                                } else if ($element == 'woo_btn') {
                                    include(rh_locate_template('inc/top/woobtn.php')); 
                                } else if ($element == 'woo_vendor') {
                                    include(rh_locate_template('inc/top/woovendor.php')); 
                                } else if ($element == 'excerpt') {
                                    include(rh_locate_template('inc/top/excerpt.php')); 
                                } else if ($element == 'woo_attribute') {
                                    include(rh_locate_template('inc/top/wooattribute.php'));                
                                } else if ($element == 'shortcode') {
                                    $shortcodevalue = (isset($row['shortcode_value'])) ? $row['shortcode_value'] : '';
                                    echo do_shortcode(wp_kses_post($shortcodevalue));                                     
		                        } else {   
		                        };
		                        echo '</li>';
		                    $pbid++;
		                    } 
		                }
		                ?>
		            </ul>
		            </div>
		        <?php endwhile; ?>
        	</div></div>
        	<span class="top_chart_row_found" data-rowcount="<?php echo $pbid;?>"></span>
        </div>
        <?php else: ?><?php _e('No posts for this criteria.', 'rehub_framework'); ?>
        <?php endif; ?>
        <?php wp_reset_query(); ?>

    	<?php 
		$output = ob_get_contents();
		ob_end_clean();
		return $output;   
	endif;	

}
add_shortcode('wpsm_charts', 'wpsm_topcharts_shortcode');
}


//////////////////////////////////////////////////////////////////
// Woo charts shortcode
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_woocharts_shortcode') ) {
function wpsm_woocharts_shortcode( $atts, $content = null ) {
	
	extract(shortcode_atts(array(
			'ids' => '',
		), $atts));
		
	if($ids):
		$compareids = explode(',', $ids);
	else :
		$compareids = (get_query_var('compareids')) ? explode(',', get_query_var('compareids')) : '';
	endif;	
	if(!empty($compareids)):
		ob_start(); 
		?>		
	        <?php $args = array( 
	            'post_status' => 'publish', 
	            'ignore_sticky_posts' => 1, 
	            'orderby' => 'post__in',
	            'post__in' => $compareids,
	            'posts_per_page'=> -1,
	            'post_type'=> 'product'

	        );
	        ?>	

	        <?php $common_attributes = array();?>
	        <?php $common = new WP_Query($args); if ($common->have_posts()) : ?>
	        <?php while ($common->have_posts()) : $common->the_post(); global $product; ?>
	        	<?php $attributes = $product->get_attributes();?>
	        	<?php foreach ($attributes as $key => $attribute) {
	        		if($attribute['is_visible'] == 1){
	        			$key = $attribute['name'];
	        			if(!empty($common_attributes) && array_key_exists($key, $common_attributes)){
	        				continue;
	        			}
	        			$common_attributes[$key] = $attribute;
	        		}
	        	}
	        	?>

	        <?php endwhile; endif; wp_reset_query(); ?>

	    	<?php $wp_query = new WP_Query($args); $ci=0; if ($wp_query->have_posts()) : ?>

	    	<?php wp_enqueue_script('carouFredSel'); wp_enqueue_script('touchswipe'); ?>
		    <div class="top_chart table_view_charts loading">
		        <div class="top_chart_controls">
		            <a href="/" class="controls prev"></a>
		            <div class="top_chart_pagination"></div>
		            <a href="/" class="controls next"></a>
		        </div>
                <div class="top_chart_first">
                    <ul>
                        <li class="row_chart_0 image_row_chart">
                            <div class="sticky-cell"><br /><label class="diff-label"><input class="re-compare-show-diff" name="re-compare-show-diff" type="checkbox" /><?php _e('Show only differences', 'rehub_framework');?></label></div>
                        </li>
                        <li class="row_chart_1 heading_row_chart">
                            <?php _e('Overview', 'rehub_framework');?>
                        </li>                        
                        <li class="row_chart_2 meta_value_row_chart">
                            <?php _e('Description', 'rehub_framework');?>
                        </li> 
                        <li class="row_chart_3 meta_value_row_chart">
                            <?php _e('Rating', 'rehub_framework');?>
                        </li>                          
                        <li class="row_chart_4 meta_value_row_chart">
                            <?php _e('SKU', 'rehub_framework');?>
                        </li> 
                        <li class="row_chart_5 meta_value_row_chart">
                            <?php _e('Brand/Store', 'rehub_framework');?>
                        </li>  
                        <li class="row_chart_6 meta_value_row_chart">
                            <?php _e('Sold by', 'rehub_framework');?>
                        </li>                                                
                        <li class="row_chart_7 meta_value_row_chart">
                            <?php _e('Availability', 'rehub_framework');?>
                        </li>    
                        <?php if(!empty($common_attributes)):?>
	                        <li class="row_chart_8 heading_row_chart">
	                            <?php _e('Attributes', 'rehub_framework');?>
	                        </li>                        
	                        <?php $i = 8; foreach($common_attributes as $attribute_value):?>
	                            <?php $i++;?>
	                            <li class="row_chart_<?php echo $i;?> meta_value_row_chart">
	                                <?php echo wc_attribute_label( $attribute_value['name'] ); ?>
	                            </li>
	                        <?php endforeach;?>
                    	<?php endif;?>
                    </ul>
                </div>
		    	<div class="top_chart_wrap woocommerce"><div class="top_chart_carousel">
			        <?php while ($wp_query->have_posts()) : $wp_query->the_post(); global $product, $post; $ci ++?>
			            <div class="top_rating_item top_chart_item compare-item-<?php echo $post->ID;?>" id='rank_<?php echo $i?>' data-compareid="<?php echo $post->ID;?>">
			                <ul>
                                <li class="row_chart_0 image_row_chart">
                                    <div class="product_image_col sticky-cell">                                  
                                        <i class="fa fa-times-circle-o re-compare-close-in-chart"></i>
                                        <figure>
								            <?php if ( $product->is_featured() ) : ?>
								                    <?php echo apply_filters( 'woocommerce_featured_flash', '<span class="onfeatured">' . __( 'Featured!', 'rehub_framework' ) . '</span>', $post, $product ); ?>
								            <?php endif; ?>        
								            <?php if ( $product->is_on_sale()) : ?>
								                <?php 
								                $percentage=0;
								                $featured = ($product->is_featured()) ? ' onsalefeatured' : '';
								                if ($product->get_regular_price()) {
								                    $percentage = round( ( ( $product->get_regular_price() - $product->get_price() ) / $product->get_regular_price() ) * 100 );
								                }
								                if ($percentage && $percentage>0 && !$product->is_type( 'variable' )) {
								                    $sales_html = apply_filters( 'woocommerce_sale_flash', '<span class="onsale'.$featured.'"><span>- ' . $percentage . '%</span></span>', $post, $product );
								                }
								                else{
								                    $sales_html = apply_filters( 'woocommerce_sale_flash', '<span class="onsale'.$featured.'">' . esc_html__( 'Sale!', 'rehub_framework' ) . '</span>', $post, $product );  
								                }                 
								                ?>
								                <?php echo $sales_html; ?>
								            <?php endif; ?>                                        
                                            <a href="<?php the_permalink();?>">
                								<?php WPSM_image_resizer::show_static_resized_image(array('lazy'=> false, 'thumb'=> true, 'crop'=> false, 'height'=> 150, 'no_thumb_url' => rehub_woocommerce_placeholder_img_src('')));?>
                                            </a>
                                        </figure>
                                        <h2>
                                            <a href="<?php the_permalink();?>">
                                                <?php echo the_title();?>                     
                                            </a>
                                        </h2>
                                        <div class="price-in-compare-flip mt20">
                                         
                                            <?php if ($product->get_price() !='') : ?>
                                                <span class="price-woo-compare-chart rehub-main-font"><?php echo $product->get_price_html(); ?></span>
                                                <div class="mb10"></div>
                                            <?php endif;?>
							                <?php if ( $product->is_in_stock() &&  $product->add_to_cart_url() !='') : ?>
							                    <?php  echo apply_filters( 'woocommerce_loop_add_to_cart_link',
							                        sprintf( '<a href="%s" data-product_id="%s" data-product_sku="%s" class="re_track_btn btn_offer_block btn-woo-compare-chart woo_loop_btn %s %s product_type_%s"%s%s>%s</a>',
							                        esc_url( $product->add_to_cart_url() ),
							                        esc_attr( $product->get_id() ),
							                        esc_attr( $product->get_sku() ),
							                        $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
							                        $product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
							                        esc_attr( $product->get_type() ),
							                        $product->get_type() =='external' ? ' target="_blank"' : '',
							                        $product->get_type() =='external' ? ' rel="nofollow"' : '',
							                        esc_html( $product->add_to_cart_text() )
							                        ),
							                    $product );?>
							                <?php endif; ?>
										    <div class="yith_woo_chart"> 
										        <?php $wishlistadd = __('Add to wishlist', 'rehub_framework');?>
										        <?php $wishlistadded = __('Added to wishlist', 'rehub_framework');?>
										        <?php $wishlistremoved = __('Removed from wishlist', 'rehub_framework');?>
										        <?php echo getHotThumb($post->ID, false, false, true, $wishlistadd, $wishlistadded, $wishlistremoved);?> 
											</div>                      
                                        </div>                                              
                                    </div>
                                </li> 
                                <li class="row_chart_1 heading_row_chart">
                                </li>                               
                                <li class="row_chart_2 meta_value_row_chart">
                                	<?php the_excerpt();?>
                                </li>
                                <li class="row_chart_3 meta_value_row_chart">
                                    <?php if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes'):?>
                                    	<?php $avg_rate_score 	= number_format( $product->get_average_rating(), 1 ) * 20 ;?>
                                    	<?php if ($avg_rate_score):?>
	                                    	<div class="rev-in-woocompare">
	                                    		<div class="star-big"><span class="stars-rate"><span style="width: <?php echo $avg_rate_score;?>%;"></span></span></div>
	                                    	</div>
                                    	<?php else:?>
                                    		-
                                    	<?php endif;?>
                                    <?php else:?>
                                    		-
                                    <?php endif;?>
                                </li>                                  
                                <li class="row_chart_4 meta_value_row_chart">
                                	<?php echo get_post_meta($post->ID, '_sku', true)?>
                                </li> 
                                <li class="row_chart_5 meta_value_row_chart">
                                	<?php WPSM_Woohelper::re_show_brand_tax(); //show brand taxonomy?>
                                </li> 
                                <li class="row_chart_6 meta_value_row_chart">
					                <?php if (class_exists('WCV_Vendor_Shop')) :?>
					                    <?php if(method_exists('WCV_Vendor_Shop', 'template_loop_sold_by')) :?>
					                        <span class="woolist_vendor"><?php WCV_Vendor_Shop::template_loop_sold_by(get_the_ID()); ?></span>
					                    <?php endif;?>
					                <?php else:?>
					                	<?php echo get_bloginfo( 'name' );?>
					                <?php endif;?>
                                </li>                                                               
                                <li class="row_chart_7 meta_value_row_chart">
                                	<?php if ( $product->is_in_stock() ):?>
										<span class="greencolor"><?php _e( 'In stock', 'rehub_framework' ) ;?></span>
									<?php else :?>
										<span class="redcolor"><?php _e( 'Out of stock', 'rehub_framework' ) ;?></span>
									<?php endif;?>
                                </li>
                                <?php if(!empty($common_attributes)):?>                                
	                                <li class="row_chart_8 heading_row_chart">
	                                </li>                                                               
			                        <?php $i = 8; foreach($common_attributes as $attkey => $attribute):?>
			                            <?php $i++;?>
			                            <li class="row_chart_<?php echo $i;?> meta_value_row_chart">
											<?php
												if ( $attribute['is_taxonomy'] ) {
													$values = wc_get_product_terms( $product->get_id(), $attribute['name'], array( 'fields' => 'names' ) );
													if(!empty($values)){
														echo apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );	
													}
												} else {	
													echo wc_implode_text_attributes( $attribute->get_options() );
												}
											?>
			                            </li>
			                        <?php endforeach;?> 
			                    <?php else:?>
			                    	<?php $i = 7;?>
		                        <?php endif;?>                                                              
			            </ul>
			            </div>
			        <?php endwhile; ?>
		    	</div></div>
		    	<span class="top_chart_row_found" data-rowcount="<?php echo ($i + 1);?>"></span>
		    </div>
		    <?php else: ?><?php _e('No posts for this criteria.', 'rehub_framework'); ?>
		    <?php endif; ?>
		    <?php wp_reset_query(); ?>

		<?php 
		$output = ob_get_contents();
		ob_end_clean();
		return $output;   
	endif;	

}
add_shortcode('wpsm_woocharts', 'wpsm_woocharts_shortcode');
}


//////////////////////////////////////////////////////////////////
// Categorizator
//////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_multi_cat', 'ajax_action_multi_cat' );
add_action( 'wp_ajax_nopriv_multi_cat', 'ajax_action_multi_cat' );
if( !function_exists('ajax_action_multi_cat') ) {
function ajax_action_multi_cat() {
	$nonce = $_POST['nonce'];
    if ( ! wp_verify_nonce( $nonce, 'ajaxed-nonce' ) )
        die ( 'Nope!' );   
		$data = $_POST;

		$page = intval($data['page']);
		$paged = ($page) ? $page : 1;
		ob_start();
		$query_args = array(
			'paged' => $paged,
			'post_type' => 'post',
			'posts_per_page' => 5,
			'tax_query' => array(
				array(
					'taxonomy' => $data['tax'],
					'field' => 'id',
					'terms' => $data['term']
				)
			),
		);
		$query = new WP_Query($query_args);
		$response = '';
		if ( $query->have_posts() ) {
			while ($query->have_posts() ) {
				$query->the_post();
				ob_start();
				get_template_part( 'content', 'multi_category' );
				$response .= ob_get_clean();
			}
			wp_reset_postdata();
		} else {
			$response = 'fail';
		}

		echo $response ;
		exit;
}
}

if( !function_exists('wpsm_categorizator_shortcode') ) {
function wpsm_categorizator_shortcode( $atts, $content = null ) {
	
	extract(shortcode_atts(array(
			'tax' => 'category',
			'exclude' => '',
			'include' => '',
			'col' => '3',
			'sorting_meta' => '',
			'order' => 'DESC'
		), $atts));
        
    $args = array(
    	'taxonomy'=> $tax,
        'orderby' => 'name',
		'exclude' => explode(',', $exclude),
		'include' => explode(',', $include),
    );
    $terms = get_terms($args );

	ob_start(); 
    ?>

    <?php
        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
            if ($col == '4') {
            	echo '<div class="col_wrap_fourth">';
            }
            elseif ($col == '2') {
            	echo '<div class="col_wrap_two">';
            }  
            elseif ($col == '1') {
            	echo '<div class="alignleft multicatleft">';
            }                       
            else {echo '<div class="col_wrap_three">'; }
            $i = 1;
            foreach ($terms as $term) {
                $query_args = array(
                    'post_type' => 'post',
                    'posts_per_page' => 5,
                    'tax_query' => array(
                        array(
                            'taxonomy' => $term->taxonomy,
                            'field' => 'id',
                            'terms' => $term->term_id
                        )
                    ),
                    'order' => $order,
                );

                if($sorting_meta){
                	$query_args['orderby'] = 'meta_value_num';
            		$query_args['meta_key'] = $sorting_meta;
                }

                $query = new WP_Query($query_args);

                if ( $query->have_posts() ) :
                    ?>

                    <div id="directory-<?php echo $term->term_id; ?>" class="multi_cat col_item"
                         data-tax="<?php echo $term->taxonomy; ?>"
                         data-term="<?php echo $term->term_id; ?>">
                        <div class="multi_cat_header">
							<div class="multi_cat_lable">
								<?php echo $term->name; ?>
							</div>
                        </div>
                        <div class="multi_cat_wrap eq_height_post">

                            <?php while ($query->have_posts() ) :
                                $query->the_post();
                                get_template_part( 'content', 'multi_category' );
                            endwhile; wp_reset_postdata(); ?>

                        </div>
                        <div class="cat-pagination multi_cat_header clearfix">

                            <?php for ($j = 1, $max_count = $query->max_num_pages; $j<= $max_count;  $j++) : ?>
                                <?php $active = ($j ===1) ? 'active' : '' ;?>
                                <a class="styled <?php echo $active; ?>" data-paginated="<?php echo $j; ?>"><?php echo $j;?></a>
                            <?php endfor; ?>

                        </div>
                    </div>

                    <?php $i++;
                    
                endif;
            }
            echo '</div>';
        }   
    ?>

	<?php 
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}
add_shortcode('wpsm_categorizator', 'wpsm_categorizator_shortcode');
}

//////////////////////////////////////////////////////////////////
// Cartbox
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_cartbox_shortcode') ) {
function wpsm_cartbox_shortcode( $atts, $content = null ) {

	extract(shortcode_atts(array(
			'title' => '',
			'link' => '',
			'description' => '',
			'image' => '',
			'bg_contain' =>'',
			'revert_image' =>'',
			'design' => '1',
		), $atts));

	if (is_numeric($image)) {$image = wp_get_attachment_url( $image);}
	$output = '';

	$url_pairs = explode( '|', $link );
	if ( ! empty( $url_pairs ) && is_array($url_pairs)) {
		$urlres = array( 'url' => '', 'title' => '', 'target' => '', 'rel' => '' );
		foreach ( $url_pairs as $pair ) {
			$param = preg_split( '/\:/', $pair );
			if ( ! empty( $param[0] ) && isset( $param[1] ) ) {
				$urlres[ $param[0] ] = rawurldecode( $param[1] );
			}
		}
	}
	else{
		$urlres = array( 'url' => $link, 'title' => '', 'target' => '_self', 'rel' => '' );
	}	

    if ($design == '2'){
    	$output .= '<div class="rh-cartbox">';
    		$output .= '<div class="rh-flex-center-align">';
    			$output .= '<div class="rh-cbox-left floatleft mr20">';
    				$output .= '<div class="lineheight20 rehub-main-font mb10">'.esc_html($title).'</div>';
					$output .= '<div class="lineheight15 font80 mb10">'.esc_html($description).'</div>';
					if(!empty($urlres['url']) && !empty($urlres['title'])){
						$output .= '<div class="lineheight15 font85 fontbold"><a target="'.esc_attr($urlres['target']).'" rel="'.esc_attr($urlres['rel']).'" href="'.esc_url($urlres['url']).'">'.esc_html($urlres['title']).'</a></div>';						
					}
    			$output .= '</div>';
    			$output .= '<div class="rh-cbox-right rh-flex-right-align text-center">';
    				if($image){
						$cardimg = new WPSM_image_resizer();
		                $cardimg->width = '100';
		                $cardimg->src = $image;
		                $thumbnail_url = $cardimg->get_resized_url();
						$output .= '<a target="'.esc_attr($urlres['target']).'" rel="'.esc_attr($urlres['rel']).'" href="'.esc_url($urlres['url']).'"><img src="'. $thumbnail_url .'" alt="'. esc_html($title) .'" /></a>';		                    					
    				}
    			$output .= '</div>';
    		$output .= '</div>';
    	$output .= '</div>';
    } else{

		$bg_contain = ($bg_contain) ? 'background-size: contain;' : '';
		$output .= '<div class="categoriesbox">';
		if ($revert_image) :
			if ($image) :
				$output .= '<div class="categoriesbox-bg" style="background-image: url('.$image.');'.$bg_contain.'">';	
				if ($link) : 
					$output .= '<a target="'.esc_attr($urlres['target']).'" rel="'.esc_attr($urlres['rel']).'" href="'.esc_url($urlres['url']).'"></a>';
				endif;
				$output .= '</div>';	
			endif;		
		endif;
		$output .='<div class="categoriesbox-content">';
		if ($title) :
			$output .= '<h3>';
			if ($link) : 
				$output .= '<a target="'.esc_attr($urlres['target']).'" rel="'.esc_attr($urlres['rel']).'" href="'.esc_url($urlres['url']).'">';
			endif;
				$output .= $title;	
			if ($link) : 
				$output .= '</a>';
			endif;
			$output .= '</h3>';		
		endif;
		if ($description) :
			$output .= '<p>'.$description.'</p>';		
		endif;	
		$output .= '</div>';
		if ($revert_image =='' || $revert_image =='0') :
			if ($image) :
				$output .= '<div class="categoriesbox-bg" style="background-image: url('.$image.');'.$bg_contain.'">';	
				if ($link) : 
					$output .= '<a href="'.esc_url($link).'"></a>';
				endif;
				$output .= '</div>';	
			endif;
		endif;
		$output .= '</div>';
	}

	return $output;
}
add_shortcode('wpsm_cartbox', 'wpsm_cartbox_shortcode');
}

//////////////////////////////////////////////////////////////////
// Score box
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_scorebox_shortcode') ) {
function wpsm_scorebox_shortcode( $atts, $content = null ) {

	extract(shortcode_atts(array(
			'criterias' => 'editor',
			'simplestar' => '',
			'offerbtn' => 'yes',
			'id' => '',
			'title'=> '',
			'proscons' => '',
			'prostitle' => 'PROS:',
			'constitle' => 'CONS:',
			'ce_enable'=> '',
		), $atts));

	ob_start(); 
    ?>

	<?php if(isset($atts['id']) && $atts['id']) :?>		
		<?php $revid = $atts['id'];?>
	<?php else :?>   
		<?php if (!is_single() || is_front_page()) {return; } ?>
    	<?php $revid = get_the_ID();?>
    <?php endif ;?>  
	<?php if(isset($atts['title']) && $atts['title']) :?>		
		<?php $title = $atts['title'];?>
	<?php else :?>   
    	<?php $title = __('Average Score', 'rehub_framework');?>
    <?php endif ;?>


    <?php $args = array('no_found_rows' => 1,'p' => $revid); $query = new WP_Query($args);?>
    <?php if ($query->have_posts()) : ?>
    <?php while ($query->have_posts()) : $query->the_post(); global $post; ?>
    	<div class="wpsm_score_box">    
			<?php if(vp_metabox('rehub_post.rehub_framework_post_type') == 'review') :?>
		    	<?php $overal_score = rehub_get_overall_score(); 
		    	if($overal_score !='0') :?>	    	
		    		<div class="wpsm_score_title rehub-main-font">
		    			<span class="overall-text"><?php echo $title; ?></span>
		    			<span class="overall-score"><?php echo round($overal_score, 1) ?></span>
		    		</div>
		    		<div class="wpsm_inside_scorebox">
		    			<?php if ($simplestar == 'yes') :?><div class="rating_bar"><?php echo rehub_get_user_rate() ; ?></div><?php endif ;?>
			    		<?php if ($criterias == 'editor' || $criterias == 'both') :?>
			    			<?php $thecriteria = vp_metabox('rehub_post.review_post.0.review_post_criteria'); $firstcriteria = $thecriteria[0]['review_post_name']; ?>
				    		<?php if($firstcriteria) : ?>
				    		<div class="rate_bar_wrap">
								<div class="review-criteria">
									<?php foreach ($thecriteria as $criteria) { ?>
										<?php $perc_criteria = $criteria['review_post_score']*10; ?>
										<div class="rate-bar clearfix" data-percent="<?php echo $perc_criteria; ?>%">
											<div class="rate-bar-title"><span><?php echo $criteria['review_post_name']; ?></span></div>
											<div class="rate-bar-bar r_score_<?php echo round($criteria['review_post_score']); ?>"></div>
											<div class="rate-bar-percent"><?php echo $criteria['review_post_score']; ?></div>
										</div>
									<?php } ?>
								</div>
							</div>
							<?php endif; ?>
			    		<?php endif ;?>	
			    		<?php if ($criterias == 'user' || $criterias == 'both') :?>
			    			<?php $postAverage = get_post_meta(get_the_ID(), 'post_user_average', true); ?>
				    		<?php if($postAverage !='0' && $postAverage !='') : ?>
							<div class="rate_bar_wrap">	
								<?php $user_rates = get_post_meta(get_the_ID(), 'post_user_raitings', true); $usercriterias = $user_rates['criteria'];  ?>
								<div class="review-criteria user-review-criteria">
									<div class="r_criteria">
										<?php foreach ($usercriterias as $usercriteria) { ?>
										<?php $perc_criteria = $usercriteria['average']*10; ?>
										<div class="rate-bar user-rate-bar clearfix" data-percent="<?php echo $perc_criteria; ?>%">
											<div class="rate-bar-title"><span><?php echo $usercriteria['name']; ?></span></div>
											<div class="rate-bar-bar r_score_<?php echo round($usercriteria['average']); ?>"></div>
											<div class="rate-bar-percent"><?php echo $usercriteria['average']; ?></div>
										</div>
										<?php } ?>
									</div>
								</div>
							</div>
							<?php endif; ?>
			    		<?php endif ;?>	
						<?php if($proscons):?>
							<?php 	
						    	$prosvalues = vp_metabox('rehub_post.review_post.0.review_post_pros_text');	
								$consvalues = vp_metabox('rehub_post.review_post.0.review_post_cons_text');
							?> 
							<!-- PROS CONS BLOCK-->
							<div class="prosconswidget">
							<?php if(!empty($prosvalues)):?>
								<div class="wpsm_pros mb30 mt10">
									<div class="title_pros"><?php echo $prostitle;?></div>
									<ul>		
										<?php $prosvalues = explode(PHP_EOL, $prosvalues);?>
										<?php foreach ($prosvalues as $prosvalue) {
											echo '<li>'.$prosvalue.'</li>';
										}?>
									</ul>
								</div>
							<?php endif;?>	
							<?php if(!empty($consvalues)):?>
								<div class="wpsm_cons">
									<div class="title_cons"><?php echo $constitle;?></div>
									<ul>
										<?php $consvalues = explode(PHP_EOL, $consvalues);?>
										<?php foreach ($consvalues as $consvalue) {
											echo '<li>'.$consvalue.'</li>';
										}?>
									</ul>
								</div>
							<?php endif;?>
							</div>	
							<!-- PROS CONS BLOCK END-->
						<?php endif;?>		    		    		
		    		</div>
		    	<?php endif;?>	    	
		    <?php endif;?>
    		<?php if ($offerbtn=="yes") :?>
    			<div class="btn_score_btm">
    				<?php rehub_create_btn('no')?>
    				<div class="centered_brand_logo">
    				<?php WPSM_Postfilters::re_show_brand_tax('logo'); //show brand logo?>
    				</div>
    			</div>
    		<?php endif ;?>		    
    		<?php if ($ce_enable && rh_is_plugin_active('content-egg/content-egg.php')) :?>

    			<div class="wpsm_inside_scorebox_ce">
	                <?php
	                    $cegg_field_array = rehub_option('save_meta_for_ce');
	                    $cegg_fields = array();
	                    if (!empty($cegg_field_array) && is_array($cegg_field_array)) {
	                        foreach ($cegg_field_array as $cegg_field) {
	        					if ($cegg_field == 'none' || $cegg_field == ''){ continue;}	                        	
                                $cegg_field_value = \ContentEgg\application\components\ContentManager::getViewData($cegg_field, $post->ID);
	                            if (!empty ($cegg_field_value) && is_array($cegg_field_value)) {
	                                $cegg_fields[$cegg_field]= $cegg_field_value;
	                            }       
	                        }		                        
	                        if (!empty($cegg_fields) && is_array($cegg_fields)) {
								$all_items = array(); 
							    foreach ($cegg_fields as $module_id => $items) {
							        foreach ($items as $item_ar) {
							            $item_ar['module_id'] = $module_id;
							            $all_items[] = $item_ar;

							        }       
							    }		                        	
	                        	?>
				    			<div class="btn_score_btm rh_deal_block">		                        	
		                        	<?php foreach ($all_items as $key => $item) :?>
		                        		<?php                             
		                        			$currency_code = (!empty($item['currencyCode'])) ? $item['currencyCode'] : '';                                
	                        				$offer_price = (!empty($item['price'])) ? \ContentEgg\application\helpers\TemplateHelper::formatPriceCurrency($item['price'], $currency_code) : '';
	                        				$offer_price_old = (!empty($item['priceOld'])) ? \ContentEgg\application\helpers\TemplateHelper::formatPriceCurrency($item['priceOld'], $currency_code) : '';    
	                        				$offer_title = (!empty($item['title'])) ? $item['title'] : '';
	                        				$offer_post_url = (!empty($item['url'])) ? $item['url'] : '';
	                        				$offer_url = apply_filters('rh_post_offer_url_filter', $offer_post_url );
	                        			?>
								        <?php if (!empty($item['domain'])):?>
								            <?php $domain = $item['domain'];?>
								        <?php elseif (!empty($item['extra']['domain'])):?>
								            <?php $domain = $item['extra']['domain'];?>
								        <?php else:?>
								            <?php $domain = '';?>        
								        <?php endif;?>  	                            			
	                        			<?php $merchant = (!empty($item['merchant'])) ? $item['merchant'] : ''; ?>
	                        			<?php $logo = \ContentEgg\application\helpers\TemplateHelper::getMerhantLogoUrl($item, true);?>
										<div class="deal_block_row">									
											<div class="rh-deal-pricetable">
												<div class="rh-deal-left">
													<div class="rh-deal-name">
														<h5><a href="<?php echo esc_url($offer_url); ?>" class="no-color-link"><?php echo $offer_title;?></a></h5>
													</div>
									                <?php if ($logo):?>
									                	<div class="rh-deal-brandlogo">
									                        <?php if($logo) :?>
	            												<?php WPSM_image_resizer::show_static_resized_image(array('lazy'=> false, 'src'=> $logo, 'crop'=> false, 'width'=> 70, 'height'=> 70));?>
									                        <?php endif ;?>	            											
	        											</div>
	        										<?php elseif ($merchant):?>
	        											<div class="rh-deal-tag">
	        												<span><?php echo $merchant;?></span>
	        											</div>
									                <?php endif;?>
												</div>
												<div class="rh-deal-right">
													<?php if(!empty($offer_price)) : ?>
							                            <div class="rh-deal-price">
							                                <ins><?php echo $offer_price ?></ins>
							                                <?php if(!empty($offer_price_old)) : ?>
								                                <del>
								                                    <?php echo $offer_price_old ?>
								                                </del>
							                                <?php endif ;?>                                
							                            </div>
							                        <?php endif ;?>
													<div class="rh-deal-btn">
										                <a href="<?php echo $offer_url ?>" class="re_track_btn rh-deal-compact-btn btn_offer_block" target="_blank" rel="nofollow">
										                    <?php if(rehub_option('rehub_btn_text') !='') :?>
										                        <?php echo rehub_option('rehub_btn_text') ; ?>
										                    <?php else :?>
										                        <?php _e('Buy Now', 'rehub_framework') ?>
										                    <?php endif ;?>
										                </a>	            					
													</div>						
												</div>					
											</div>
										</div>                             			
		                        	<?php endforeach;?>
		                        </div>
	                        	<?php
	                        }
	                    }
	                ?>	    		
				</div>

			<?php endif ;?>		    
	    </div>
    <?php endwhile; endif; wp_reset_postdata(); ?>

    <?php 
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}
add_shortcode('wpsm_scorebox', 'wpsm_scorebox_shortcode');
}

//////////////////////////////////////////////////////////////////
// Reveal shortcode
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_reveal_shortcode') ) {
function wpsm_reveal_shortcode( $atts, $content = null ) {
extract(shortcode_atts(array(
		'textcode' => '',
		'btntext' => '',
		'url' => '',
	), $atts));
wp_enqueue_script('affegg_coupons');
wp_enqueue_script('zeroclipboard');

$output = '<div class="rehub_offer_coupon free_coupon_width masked_coupon" data-clipboard-text="'.rawurlencode(esc_html($textcode)).'" data-codetext="'.rawurlencode(esc_html($textcode)).'" data-dest="'.esc_url($url).'">';
if($btntext !='') :
	$output .=esc_html($btntext);
else :
	$output .= __('Reveal', 'rehub_framework');
endif;
	$output .='<i class="fa fa-external-link-square"></i></div>';
return $output;
}
add_shortcode('wpsm_reveal', 'wpsm_reveal_shortcode');
} 


//////////////////////////////////////////////////////////////////
// User login/register link with popup
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_user_modal_shortcode') ) {
function wpsm_user_modal_shortcode( $atts, $content = null ) {
extract(shortcode_atts(array(
	'wrap' => 'span',
	'as_btn' => '',
	'class' => '',
	'loginurl' => '',		
), $atts));
$as_button = (!empty($as_btn)) ? ' wpsm-button white medium ' : '';
$class_show = (!empty($class)) ? ' '.$class.'' : '';
$output='';
if (is_user_logged_in()) {
	global $current_user;
	$notice_bp_number = $notification_bp_item = '';
	$user_id  = get_current_user_id();
	$current_user = wp_get_current_user();
	$profile_url  = rehub_option('userlogin_profile_page');
	$sumbit_url = rehub_option('userlogin_submit_page');
	$edit_url = rehub_option('userlogin_edit_page');
	if(function_exists('mycred_display_users_total_balance')){
	    if(rehub_option('rh_mycred_custom_points')){
	        $custompoint = rehub_option('rh_mycred_custom_points');
	        $mycredpoint = mycred_render_shortcode_my_balance(array('type'=>$custompoint, 'user_id'=>$user_id, 'wrapper'=>'', 'balance_el' => '') );
	        $mycredlabel = mycred_get_point_type_name($custompoint, false);
	    }
	    else{
	        $mycredpoint = mycred_render_shortcode_my_balance(array('user_id'=>$user_id, 'wrapper'=>'', 'balance_el' => '') );
	        $mycredlabel = mycred_get_point_type_name('', false);           
	    }
	}   
	if ( function_exists('bp_notifications_get_notifications_for_user')) {
		$notifications = bp_notifications_get_notifications_for_user($user_id, 'object');
		$notification_bp_item .='<li class="bp-profile-edit-menu-item menu-item"><a href="'.bp_core_get_user_domain( $user_id ).'"><i class="fa fa-cogs"></i></i><span>'. __("Edit Profile", "rehub_framework") .'</span></a></li>';		
		if (!empty($notifications)){
			$notice_bp_number = count($notifications);
			$notice_number = 0;
			foreach ((array)$notifications as $notification) {
				$notice_number ++;
				$notification_bp_item .= '<li id="bp-profile-menu-note-'.$notification->id.'" class="bp-profile-menu-item menu-item bppmi_'.$notice_number.' bp-profile-menu-'.$notification->component_action.'"><a href="'.$notification->href.'">'.$notification->content.'</a></li>';
			}			
		}
	}	

	$output .= '<div class="user-dropdown-intop'.$class_show.'">';
	if (!empty($notice_bp_number)){
		$output .='<span class="rh_bp_notice_profile">'.$notice_bp_number.'</span>';
	}
    $output .= '<span class="user-ava-intop">'.get_avatar( $user_id, 22 ).'</span>';
    $output .= '<ul class="user-dropdown-intop-menu">';
        $output .= '<li class="user-name-and-badges-intop"><span class="user-image-in-name">'.get_avatar( $user_id, 35 ).'</span>';
        $output .=$current_user->display_name;
        if(function_exists('bp_get_member_type')){
			$membertype = bp_get_member_type($user_id);
			$membertype_object = bp_get_member_type_object($membertype);
			$membertype_label = (!empty($membertype_object) && is_object($membertype_object)) ? $membertype_object->labels['singular_name'] : '';        	
        	$output .='<br /><span class="rh_user_s2_label">'.$membertype_label.'</span>';
        }        
        if (!empty($mycredpoint)){
        	$output .='<br />'.$mycredlabel.': '.$mycredpoint.'';
        }
        $output .= '</li>';
        if ($profile_url) :
        	$output .= '<li class="user-profile-link-intop menu-item"><a href="'. esc_url(get_the_permalink($profile_url)) .'"><i class="fa fa-user"></i><span>'. __("My profile", "rehub_framework") .'</span></a></li>';
        endif;
        if ($sumbit_url) :
        	$output .= '<li class="user-addsome-link-intop menu-item"><a href="'. esc_url(get_the_permalink($sumbit_url)) .'"><i class="fa fa-cloud-upload"></i><span>'. __("Submit a Post", "rehub_framework") .'</span></a></li>';
        endif; 
        if ($edit_url) :
        	$output .= '<li class="user-editposts-link-intop menu-item"><a href="'. esc_url(get_the_permalink($edit_url)) .'"><i class="fa fa-pencil"></i><span>'. __("Edit My Posts", "rehub_framework") .'</span></a></li>';
        endif;  
        if (defined('wcv_plugin_dir')) :
		    if (class_exists('WCV_Vendors') && class_exists('WCVendors_Pro') && WCV_Vendors::is_vendor($user_id) ) {
		        $redirect_to = get_permalink(WCVendors_Pro::get_option( 'dashboard_page_id' ));
		    }
		    elseif (class_exists('WCV_Vendors') && WCV_Vendors::is_vendor($user_id) ) {
		    	$redirect_to = get_permalink(WC_Vendors::$pv_options->get_option( 'vendor_dashboard_page' ));
		    }
        	if (!empty($redirect_to)){
	        	$output .= '<li class="user-editshop-link-intop menu-item"><a href="'. esc_url($redirect_to) .'"><i class="fa fa-shopping-bag" aria-hidden="true"></i><span>'. __("Manage Your Shop", "rehub_framework") .'</span></a></li>';        	
        	}
        endif; 
        if( class_exists( 'WeDevs_Dokan' ) ) :
        	$is_vendor = dokan_is_user_seller( $user_id );
        	if($is_vendor) :
	        $output .= '<li class="user-editshop-link-intop menu-item"><a href="'. dokan_get_navigation_url() .'"><i class="fa fa-shopping-bag" aria-hidden="true"></i><span>'. __("Manage Your Shop", "rehub_framework") .'</span></a></li>'; 
	        endif; 
        endif; 
        if( class_exists('WCMp')) :
        	$is_vendor = is_user_wcmp_vendor( $user_id );        
        	if($is_vendor) :
				$wcmp_option = get_option("wcmp_vendor_general_settings_name");
				$dashlink = (!empty($wcmp_option['wcmp_vendor'])) ? $wcmp_option['wcmp_vendor'] : '';        		
        		if ($dashlink > 0):
	        		$output .= '<li class="user-editshop-link-intop menu-item"><a href="'. get_permalink($dashlink) .'"><i class="fa fa-shopping-bag" aria-hidden="true"></i><span>'. __("Manage Your Shop", "rehub_framework") .'</span></a></li>'; 
	        	endif;         		
    		endif;

        endif;                                  
        if(has_nav_menu('user_logged_in_menu')):
        	$output .= wp_nav_menu( array( 'theme_location' => 'user_logged_in_menu','menu_class' => '','container' => false,'depth' => 1,'items_wrap'=> '%3$s', 'echo' => false ) );
        endif;
        $output .=$notification_bp_item;
        $output .= '<li class="user-logout-link-intop menu-item"><a href="'. wp_logout_url( home_url()) .'"><i class="fa fa-lock"></i><span>'. __("Log out", "rehub_framework") .'</span></a></li>';
$output .= '</ul></div>';
} else {
	if(get_option('users_can_register')) :
		if (empty ($loginurl)):
			if ($wrap =='a'):
				$output .= '<a class="act-rehub-login-popup menu-item-one-line'.$as_button.$class_show.'" data-type="login" href="#"><i class="fa fa-sign-in"></i><span>'.__("Login / Register", "rehub_framework").'</span></a>';
			else:
				$output .= '<span class="act-rehub-login-popup'.$as_button.$class_show.'" data-type="login"><i class="fa fa-sign-in"></i><span>'.__("Login / Register", "rehub_framework").'</span></span>';
			endif;
		else:
			$output .= '<span class="act-rehub-login-popup'.$as_button.$class_show.'" data-type="url" data-customurl="'.esc_url($loginurl).'"><i class="fa fa-sign-in"></i><span>'.__("Login / Register", "rehub_framework").'</span></span>';
		endif;
	else:
		$output .= '<a class="act-rehub-login-popup'.$as_button.$class_show.'" data-type="restrict" href="#"><i class="fa fa-sign-in"></i><span>'.__("Login / Register is disabled", "rehub_framework").'</span></a>';
	endif;	
	
}

return $output;

}
add_shortcode('wpsm_user_modal', 'wpsm_user_modal_shortcode');
}

//////////////////////////////////////////////////////////////////
// Search form
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_searchform_shortcode') ) {
function wpsm_searchform_shortcode( $atts, $content = null ) {
extract(shortcode_atts(array(
	'class' => '',		
), $atts));

return '<div class="'.$class.'">'.get_search_form(false).'</div>';

}
add_shortcode('wpsm_searchform', 'wpsm_searchform_shortcode');
}

//////////////////////////////////////////////////////////////////
// Link hide
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_hidelink_shortcode') ) {
function wpsm_hidelink_shortcode( $atts, $content = null ) {

	extract(shortcode_atts(array(
			'text' => 'Click here',
			'link' => '',
	), $atts));

	$output = '<span class="ext-source" data-dest="'.$link.'">'.$text.'</span>';
	return $output;
}
add_shortcode('wpsm_hidelink', 'wpsm_hidelink_shortcode');
}


//////////////////////////////////////////////////////////////////
// Compare Buttons
//////////////////////////////////////////////////////////////////

if( !function_exists('wpsm_comparison_button') ) {
function wpsm_comparison_button( $atts, $content = null ) {
        $atts = shortcode_atts(
			array(
				'color' => 'white',
				'size' => 'small',
				'cats' => '',
				'class' => '',
				'id' => '',
			), $atts);
	$postid = (!empty($atts['id'])) ? $atts['id'] : get_the_ID(); 
	$multicats_on = rehub_option('compare_multicats_toggle');
	$singlecat_on = rehub_option('compare_page');
	if($multicats_on == '' && $singlecat_on == '') return;	
	if (isset ($atts['cats']) && !empty($atts['cats'])) : //Check if button is not in category
		$cats_array = explode (',', $atts['cats']);
		if (!in_category ($cats_array, $postid)) return;
	endif;     
    $class_show = (!empty($atts['class'])) ? ' '.$atts['class'].'' : '';
	$ip = rehub_get_ip();
	$userid = get_current_user_id();
	$userid = empty($userid) ? $ip : $userid;

	if ($multicats_on =='1'){
		$multicats_array = rehub_get_compare_multicats();
	}
	$post_ids_arr = array();
	
	if($multicats_on =='1' && !empty($multicats_array)) {
		foreach( $multicats_array as $multicat ){
			$page_id = (int)$multicat[2];
			$post_ids_arr[] = get_transient('re_compare_'. $page_id .'_' . $userid);
		}
		$post_ids = implode(',', $post_ids_arr);
	} else {
		$post_ids = get_transient('re_compare_' . $userid);
	}
	
	if(!empty($post_ids)) {
		$post_ids_arr = explode(',', $post_ids);
	}

	$compare_active = ( in_array( $postid, $post_ids_arr ) ) ? ' comparing' : ' not-incompare';
	
	$out = '<span';   
    $out .=' class="wpsm-button wpsm-button-new-compare addcompare-id-'.$postid.' '.$atts['color'].' '.$atts['size'].''.$compare_active.$class_show.'" data-addcompare-id="'.$postid.'"><i class="fa re-icon-compare"></i><span class="comparelabel">'.__("Add to compare", "rehub_framework").'</span></span>';
    return $out;
}
add_shortcode('wpsm_compare_button', 'wpsm_comparison_button');
}


//////////////////////////////////////////////////////////////////
// Get custom value shortcode
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_get_custom_value') ) {
function wpsm_get_custom_value($atts){
	extract(shortcode_atts(array(
	    'post_id' => NULL,
	    'field' => NULL,
	    'type' => 'custom',
	    'show_empty' => '',
	    'label' => '',
	    'posttext' => ''
	), $atts));
  	if(!isset($atts['field'])) return;
  	$result = $out = '';
    $field = esc_attr($atts['field']);
    global $post;
    $post_id = (NULL === $post_id) ? $post->ID : $post_id;
    if ($type=='custom'){
    	$result = get_post_meta($post_id, $field, true);
    }else if($type=='attribute'){
        global $product;
        $woo_attr = $product->get_attribute(esc_html($field));
        if(!is_wp_error($woo_attr)){
            $result = $woo_attr;
        }    	
    }
    if($result){
    	if ($label){
    		$out .= '<span class="meta_v_label">'.esc_attr($label).'</span> ';
    	}
    	$out .= $result;
    	if ($posttext){
    		$out .= '<span class="meta_v_posttext">'.esc_attr($posttext).'</span> ';
    	}    	
    } 
    else{
    	if($show_empty){
	    	if ($label){
	    		$out .= '<span class="meta_v_label">'.esc_attr($label).'</span> ';
	    	}
	    	$out .= '-';    		
    	}
    }  
    return $out; 

}
add_shortcode('wpsm_custom_meta', 'wpsm_get_custom_value');
}

//////////////////////////////////////////////////////////////////
// Alphabet Catalog Shortcode
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_tax_archive_shortcode') ) {
function wpsm_tax_archive_shortcode( $atts, $content = null ) {
	// Attributes
	extract( shortcode_atts(
		array(
			'type' => 'alpha',
			'taxonomy' => 'store',
			'show_images' => 1,
			'limit' =>'',
			'random' => '',
		), $atts, 'wpsm_tax_archive' )
	);

	if($random){
		$number = '';
	}else{
		$number = $limit;
	}

	$args = array( 'hide_empty' => false, 'order' => 'ASC', 'taxonomy'=> $taxonomy, 'number'=> $number);
	 
	$terms = get_terms($args );

	if(is_wp_error($terms)) return;

	if($random){
		shuffle($terms);
		if ($limit){
			$terms = array_slice($terms, 0, $limit);
		}
	}

	$letter_keyed_terms = array();

	$term_letter_links = '';
	$term_titles = '';

	if($type == 'alpha') {
		if( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
			foreach( $terms as $term ) {
				$first_letter = mb_substr( $term->name, 0, 1, 'UTF-8' );
				
				if( is_numeric( $first_letter ) ) {
					$first_letter = '0-9';
				} else {
					$first_letter = mb_strtoupper( $first_letter, 'UTF-8' );
				}
				
				if ( !array_key_exists( $first_letter, $letter_keyed_terms ) ) {
					$letter_keyed_terms[ $first_letter ] = array();
				}
				
				$letter_keyed_terms[ $first_letter ][] = $term;
			}
			
			foreach( $letter_keyed_terms as $letter => $terms ) {
				$term_letter_links .= '<li><a href="#'.$letter.'" class="rehub_scroll">'.$letter.'</a></li>';

				$term_titles .= '<div class="single-letter"><a href="#" name="'.$letter.'"></a><div class="letter_tag">'.$letter.'<div class="return_to_letters"><span class="rehub_scroll" data-scrollto="#top_ankor"><i class="fa fa-angle-up"></i></span></div></div></div> <!-- single-letter -->';
				$term_titles .= '<div class="tax-wrap rh-flex-eq-height">';
										
				foreach( $terms as $term ) {

					$thumbnail = $thumbnail_url = '';
					
					if ( $taxonomy == 'product_tag' && $show_images == 1 ) {
						  	$term_tag_array = get_option( 'taxonomy_term_'. $term->term_id ); 
						  	if (!empty ($term_tag_array['brand_image'])) {
							  	$showbrandimg = new WPSM_image_resizer();
				                $showbrandimg->height = '50';
				                $showbrandimg->src = $term_tag_array['brand_image'];
				                $thumbnail_url = $showbrandimg->get_resized_url();					  		
						  	}					  
						if ( $thumbnail_url ) {
							$thumbnail = '<img src="'. $thumbnail_url .'" alt="'. $term->name .'" />';
						}
					}
					elseif ( $taxonomy == 'store' && $show_images == 1 ) {
							$brandimage = get_term_meta( $term->term_id, 'brandimage', true ); 
						  	if (!empty ($brandimage)) {
							  	$showbrandimg = new WPSM_image_resizer();
				                $showbrandimg->height = '50';
				                $showbrandimg->src = $brandimage;
				                $thumbnail_url = $showbrandimg->get_resized_url();					  		
						  	}					  
						if ( $thumbnail_url ) {
							$thumbnail = '<img src="'. $thumbnail_url .'" alt="'. $term->name .'" />';
						}
					}
					elseif ( $taxonomy == 'dealstore' && $show_images == 1 ) {
							$brandimage = get_term_meta( $term->term_id, 'brandimage', true ); 
						  	if (!empty ($brandimage)) {
							  	$showbrandimg = new WPSM_image_resizer();
				                $showbrandimg->height = '50';
				                $showbrandimg->src = $brandimage;
				                $thumbnail_url = $showbrandimg->get_resized_url();					  		
						  	}					  
						if ( $thumbnail_url ) {
							$thumbnail = '<img src="'. $thumbnail_url .'" alt="'. $term->name .'" />';
						}
					}					
					
					$term_titles .= '<div id="taxonomy-'. $term->term_id .'" class="tax-item"><a class="single-letter-link" href="' . esc_url( get_term_link( $term ) ) . '" title="' . esc_attr( sprintf( __( 'View all post filed under %s', 'rehub_framework' ), $term->name ) ) . '">' . $thumbnail . '<h5>'. $term->name . '</h5></a></div>';
				}
				
				$term_titles .= '</div>';		
			}
		}
		
		return	'<div class="alphabet-filter">
						<div class="head-wrapper clearfix">
							<ul class="list-inline">
								'. $term_letter_links .'
							</ul>
						</div>
						<div class="body-wrapper clearfix">
								'. $term_titles .'
						</div>
					</div>';		
	}
	elseif ($type == 'compact') {
		if( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
			foreach( $terms as $term ) {
				$term_titles .= '<div id="taxonomy-'. $term->term_id .'" class="tax-item"><a class="mini-tax-link" href="' . esc_url( get_term_link( $term ) ) . '" title="' . esc_attr( sprintf( __( 'View all post filed under %s', 'rehub_framework' ), $term->name ) ) . '"><h5>'. $term->name . '</h5></a></div>';
			}
			return '<div class="alphabet-filter">'.$term_titles.'</div>';	
		}
	}
	elseif ($type == 'logo') {
		if( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
			foreach( $terms as $term ) {
				$thumbnail = $thumbnail_url = '';
				
				if ( $taxonomy == 'product_tag' && $show_images == 1 ) {
					  	$term_tag_array = get_option( 'taxonomy_term_'. $term->term_id ); 
					  	if (!empty ($term_tag_array['brand_image'])) {
						  	$showbrandimg = new WPSM_image_resizer();
			                $showbrandimg->height = '50';
			                $showbrandimg->src = $term_tag_array['brand_image'];
			                $thumbnail_url = $showbrandimg->get_resized_url();					  		
					  	}					  
					if ( $thumbnail_url ) {
						$thumbnail = '<img src="'. $thumbnail_url .'" alt="'. $term->name .'" />';
					}
				}
				elseif ( $taxonomy == 'store' && $show_images == 1 ) {
						$brandimage = get_term_meta( $term->term_id, 'brandimage', true ); 
					  	if (!empty ($brandimage)) {
						  	$showbrandimg = new WPSM_image_resizer();
			                $showbrandimg->height = '50';
			                $showbrandimg->src = $brandimage;
			                $thumbnail_url = $showbrandimg->get_resized_url();					  		
					  	}					  
					if ( $thumbnail_url ) {
						$thumbnail = '<img src="'. $thumbnail_url .'" alt="'. $term->name .'" />';
					}
				}
				elseif ( $taxonomy == 'dealstore' && $show_images == 1 ) {
						$brandimage = get_term_meta( $term->term_id, 'brandimage', true ); 
					  	if (!empty ($brandimage)) {
						  	$showbrandimg = new WPSM_image_resizer();
			                $showbrandimg->height = '50';
			                $showbrandimg->src = $brandimage;
			                $thumbnail_url = $showbrandimg->get_resized_url();					  		
					  	}					  
					if ( $thumbnail_url ) {
						$thumbnail = '<img src="'. $thumbnail_url .'" alt="'. $term->name .'" />';
					}
				}
				if ($thumbnail){
					$term_titles .= '<div id="taxonomy-'. $term->term_id .'" class="tax-item"><a class="logo-tax-link" href="' . esc_url( get_term_link( $term ) ) . '" title="' . esc_attr( sprintf( __( 'View all post filed under %s', 'rehub_framework' ), $term->name ) ) . '">'. $thumbnail . '</a></div>';					
				}
			}
			return '<div class="alphabet-filter">'.$term_titles.'</div>';	
		}
	}	
}
}
add_shortcode( 'wpsm_tax_archive', 'wpsm_tax_archive_shortcode' );


//////////////////////////////////////////////////////////////////
// USER REVIEWS BASED ON FULL REVIEWS
//////////////////////////////////////////////////////////////////
if( !function_exists('re_user_rating_shortcode') ) {
function re_user_rating_shortcode( $atts, $content = null ) {
    $atts = shortcode_atts(
	array(
		'size' => 'big',
	), $atts);

    $postAverage = get_post_meta(get_the_ID(), 'post_user_average', true);
    if(!empty($postAverage)){
    	$starscore = $postAverage*10 ;
    	$output = '<div class="star-'.$atts['size'].'"><span class="stars-rate"><span style="width: '.$starscore.'%;"></span></span></div>';
    	return $output;
    }
}
add_shortcode('wpsm_user_rating_stars', 're_user_rating_shortcode');
}

//////////////////////////////////////////////////////////////////
// UPDATE BLOCK
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_update_shortcode') ) {
function wpsm_update_shortcode( $atts, $content = null ) {
    $atts = shortcode_atts(
	array(
		'date' => '',
		'label' => '',
	), $atts);
	$date = (!empty($atts['date'])) ? ' - '.$atts['date'].'' : '';
	$label = (!empty($atts['label'])) ? $atts['label'] : __('Update', 'rehub_framework');
	$content = do_shortcode($content);	
	$output = '<div class="wpsm_update"><span class="label-info">'.$label.$date.'</span>'.$content.'</div>';
	return $output;
}
add_shortcode('wpsm_update', 'wpsm_update_shortcode');
}


//////////////////////////////////////////////////////////////////
// SPECIFICATION BUILDER
//////////////////////////////////////////////////////////////////
if ( !function_exists( 'wpsm_spec_builders_shortcode' ) ) {
	function wpsm_spec_builders_shortcode( $atts, $content = null ) {
		
		extract(shortcode_atts( array(
				'id' => '',
				'postid' => '',
			), $atts));
			
		if( !empty($id) ) :

			$rows = get_post_meta( $id, '_wpsm_spec_line', true );
			if(empty($rows)) return;

			ob_start(); 
			?>

                <?php 
                	$postID = (!empty($postid)) ? $postid : get_the_ID();
                    $pbid=0;                       
                    foreach ($rows as $row) {
                    echo '<div class="wpsm_spec_row_'.$id.'_'.$pbid.'">';                       
                    $element = $row['column_type'];
                        if ($element == 'heading_line') {
                            include(rh_locate_template('inc/specification/heading_line.php'));
                        } else if ($element == 'meta_line') {
                            include(rh_locate_template('inc/specification/meta_line.php'));                          
                        } else if ($element == 'divider_line') {
                            include(rh_locate_template('inc/specification/divider_line.php'));                            
                        } else if ($element == 'tax_line') {
                            include(rh_locate_template('inc/specification/tax_line.php'));                            
                        } else if ($element == 'shortcode_line') {
                            include(rh_locate_template('inc/specification/shortcode_line.php')); 
                        } else if ($element == 'photo_line') {
                            include(rh_locate_template('inc/specification/photo_line.php'));
                        } else if ($element == 'video_line') {
                            include(rh_locate_template('inc/specification/video_line.php'));
                        } else if ($element == 'mdtf_line') {
                            include(rh_locate_template('inc/specification/mdtf_line.php'));   
                        } else if ($element == 'proscons_line') {
                            include(rh_locate_template('inc/specification/proscons_line.php'));  
                        } else if ($element == 'map_line') {
                            include(rh_locate_template('inc/specification/map_line.php'));
                        } else {
                            
                        };
                    echo '</div>';
                    $pbid++;
                    } 
                ?>

			<?php 
			$output = ob_get_contents();
			ob_end_clean();
			return $output;   
		endif;	

	}
add_shortcode( 'wpsm_specification_builder', 'wpsm_spec_builders_shortcode' );
}

//////////////////////////////////////////////////////////////////
// Category box
//////////////////////////////////////////////////////////////////
if ( !function_exists('wpsm_catbox_shortcode') ) {
function wpsm_catbox_shortcode( $atts, $content = null ) {

	extract( shortcode_atts( array(
			'category' => '', // one ID
			'title' => '', // if empty - original title
			'disablelink' => '', // 1 or 0
			'disablechild' => '', // 1 or 0
			'image' => '', // URL or post_id in media library
			'size_img' => '' // % or px ('width' or 'width height')
		), $atts ) );

	if ( empty( $category ) || $category == 0 )
		return;

	$term = get_term( (int) $category );
	
 	if ( is_wp_error( $term ) ) {
		$error_string = $term->get_error_message();
		return '<div id="message" class="error"><p><b>Error</b>: Category ID '. $category .' - '. $error_string .'</p></div>';
 	}

	if ( is_numeric( $image ) ) {
		$image = wp_get_attachment_url( $image );
	}
	
	$bg_size = ( $size_img ) ? ' background-size:'. $size_img .'; height:'. $size_img .'' : '';
	$termchildren = get_terms( array(
		'taxonomy' => $term->taxonomy,
		'orderby' => 'name',
		'hide_empty' => true,
		'child_of' => $term->term_id
	) );
	$count = $term->count;
	foreach ($termchildren as $tax_term_child) {
        $count +=$tax_term_child->count;
    }		
	
	// HTML output
	$output = '<div class="rh-cartbox catbox mb20">';
		
		if ( $image ){
			$title = ( $title && $title !='' ) ? $title : $term->name;
			$output .= '<div class="rh-transition-box">';					
				if ( $disablelink != 1 ) {
					$output .= '<a href="'. get_term_link( $term->term_id ) .'" rel="nofollow">';
				}
				
				if ( $disablelink != 1 ) {
					$output .= '</a>';
				}
				$output .= '<div class="categoriesbox-bg" style="background-image:url('. $image .');'. $bg_size .'"></div>';	
				$output .= '<h3>'. $title .'<mark class="catcount">('.$count.')</mark></h3>';					
			$output .= '</div>';
		}

		if($disablechild !=1){
			$output .='<div class="catbox-content r_offer_details">';
				
				if ( is_wp_error( $termchildren ) ) {
					$error_string = $termchildren->get_error_message();
					return '<div id="message" class="error"><p><b>Error</b>: Category ID '. $category .' - '. $error_string .'</p></div>';
				}

				
				$term_count = count( $termchildren ); 
				if($term_count > 0) {
					$output .= '<ul class="catbox-child-list">';
					$i = 0;
					foreach ( $termchildren as $termchild ) {

						if ( $i == 3 )
							$output .= '<div class="open_dls_onclk">';
						$output .= '<li><a href="'. get_term_link( (int) $termchild->term_id ) .'">'. $termchild->name .'</a> ('. (int) $termchild->count .')</li>';
						
						if ( $i == $term_count )
							$output .= '</div>';
						$i++;
					}
					$output .= '</ul>';
				}

				
				if ( $term_count > 3 )
					$output .= '<span class="r_show_hide rehub-sec-color mt5 inlinestyle font90">'.__('See all', 'rehub_framework').'</span>';

				$output .= '</div>';
				
		}	

	$output .= '</div>';

	return $output;
}
add_shortcode('wpsm_catbox', 'wpsm_catbox_shortcode');
}

if (!function_exists('rh_wcv_vendorslist_flat')) {
function rh_wcv_vendorslist_flat( $atts ) {

		$html = ''; 
		
	  	extract( shortcode_atts( array(
	  			'orderby' => 'registered',
	  			'order'	=> 'ASC',
				'per_page' => '12',
				'show_products' => 'yes',
				'search_form' => 0,
				'user_id' => '' 
			), $atts ) );

	  	$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;   
	  	$offset = ( $paged - 1 ) * $per_page;
		
		// Search query fom the form
		$search_sellers = isset($_GET['search_sellers']) ? esc_attr($_GET['search_sellers']) : '';
		
		// Sort filter and data from the form change parametres of the WP user query
		$alphabet = $mostpopular = $mostposts = $mostresent = '';
		$selected = ' selected="selected"';
		if (defined('wcv_plugin_dir')){
			$role = 'vendor';
			$meta_key = 'pv_shop_name';
		}
		elseif ( class_exists( 'WeDevs_Dokan' ) ){
			$role = 'seller';
			$meta_key = 'dokan_enable_selling';			
		}
        elseif( class_exists('WCMp')) {
			$role = 'dc_vendor';
			$meta_key = '_vendor_page_title';
        }		
		
		if( isset($_GET['orderby_sellers']) ) {
			$orderby_sellers = $_GET['orderby_sellers'];
			switch ($orderby_sellers) {
				case 'alphabet':
					$orderby = 'display_name';
					$order = 'ASC';
					$alphabet = $selected;
					break;
				case 'mostpopular':
					$orderby = 'meta_value';
					$order = 'DESC';
					$meta_key = '_rh_user_favorite_shop_count';
					$mostpopular = $selected;
					break;
				case 'mostposts': // omitted
					$mostposts = $selected;
					break;
				default;
					$mostresent = $selected;
			}
		} else {
			$mostresent = $selected;
		}

	  	// Hook into the user query to modify the query to return users that have at least one product 
	  	if ($show_products == 'yes') add_action( 'pre_user_query', 'rh_vendors_with_products' );

	  	// Get all vendors 
	  	$vendor_total_args = array ( 
	  		'role' 			=> $role, 
			'meta_key' 	=> $meta_key, 
			'meta_value'   	=> '',
			'meta_compare'	=> '>',
			'orderby' 		=> $orderby,
  			'order'			=> $order,
	  	);

	  	if ($show_products == 'yes') $vendor_total_args['query_id'] = 'vendors_with_products'; 

	  	$vendor_query = New WP_User_Query( $vendor_total_args ); 
	  	$all_vendors =$vendor_query->get_results(); 

	  	// Get the paged vendors 
	  	$vendor_paged_args = array ( 
	  		'role' 			=> $role, 
			'meta_key' 	=> $meta_key, 
			'meta_value'   	=> '',
			'meta_compare'	=> '>',
			'search'		=> $search_sellers,
			'orderby' 		=> $orderby,
  			'order'			=> $order,
	  		'offset' 		=> $offset, 
	  		'number' 		=> $per_page, 
	  	);

	  	if ($show_products == 'yes' ) $vendor_paged_args['query_id'] = 'vendors_with_products'; 

	  	if ($user_id){
	  		$user_ids = array_map( 'trim', explode( ",", $user_id ) );
		  	$vendor_paged_args = array ( 
		  		'role' 			=> $role, 
				'meta_key' 	=> $meta_key, 
				'meta_value'   	=> '',
				'meta_compare'	=> '>',
				'include' 		=> $user_ids,
		  	);	  		
	  	}	  	

	  	$vendor_paged_query = New WP_User_Query( $vendor_paged_args ); 
	  	$paged_vendors = $vendor_paged_query->get_results(); 

	  	// Pagination calcs 
		$total_vendors = count( $all_vendors );  
		$total_vendors_paged = count($paged_vendors);  
		$total_pages = ceil( $total_vendors / $per_page );
	    
	   	ob_start();
		
		if($search_form ==1){
		$html .='
		<div class="tabledisplay mb20">
			<form id="search-sellers" role="search" method="get" class="celldisplay search-form floatleft mb10">
				<input type="text" name="search_sellers" placeholder="'. __('Search sellers', 'rehub_framework') .'" value="">
				<button type="submit" alt="'. __('Search', 'rehub_framework') .'" value="'. __('Search', 'rehub_framework') .'" class="btnsearch"><i class="fa fa-search"></i></button>
			</form>
			<form id="filter-sellers" method="get" class="celldisplay floatright mb10 ml10">
				<label>'. __('Sort by:', 'rehub_framework') .'</label>
				<select name="orderby_sellers" class="orderby">
					<option value="alphabet"'. $alphabet .'>'. __('Alphabetical', 'rehub_framework') .'</option>
					<option value="mostpopular"'. $mostpopular .'>'. __('Most popular', 'rehub_framework') .'</option>
					<option value="mostresent"'. $mostresent .'>'. __('Most recent', 'rehub_framework') .'</option>
				</select>
			</form>
			<script>jQuery( function( $ ) {
				$( "#filter-sellers" ).on( "change", "select.orderby", function() {
					$( this ).closest( "form" ).submit();
				});
			});
			</script>
		</div>';
		}

	    // Loop through all vendors and output a simple link to their vendor pages
	    foreach ($paged_vendors as $vendor) {
			if (defined('wcv_plugin_dir')){
				$shop_link = WCV_Vendors::get_vendor_shop_page($vendor->ID);
	    		$shop_name = $vendor->pv_shop_name;
			}
			elseif ( class_exists( 'WeDevs_Dokan' ) ){
	    	    $shop_link = dokan_get_store_url($vendor->ID);		
            	$store_info = dokan_get_store_info( $vendor->ID );
            	$shop_name = isset( $store_info['store_name'] ) ? esc_html( $store_info['store_name'] ) : __( 'Noname Shop', 'rehub_framework' );	    				
			}	    	
	    	$vendor_id= $vendor->ID;
	    	include(rh_locate_template('inc/wcvendor/vendorlist.php'));

	    } // End foreach 
	   	
	   	$html .= '<div class="rh_vendors_listflat">' . ob_get_clean() . '</div>';

	    if ( $total_vendors > $total_vendors_paged ) {  
			$html .= '<nav class="woocommerce-pagination">';  
			  $current_page = max( 1, get_query_var('paged') );  
			  $html .= paginate_links( 	array(  
			        'base' => get_pagenum_link() . '%_%',
			        'format' => 'page/%#%/',  
			        'current' => $current_page,  
			        'total' => $total_pages,  
			        'prev_next' => false,  
			        'type' => 'list',  
			    ));  
			$html .= '</nav>'; 
		}

	    return $html; 
	}
add_shortcode('wpsm_vendorlist', 'rh_wcv_vendorslist_flat');
}

if (!function_exists('rh_vendors_with_products')) {
function rh_vendors_with_products( $query ) {
	global $wpdb; 
    if ( isset( $query->query_vars['query_id'] ) && 'vendors_with_products' == $query->query_vars['query_id'] ) {  
        $query->query_from = $query->query_from . ' LEFT OUTER JOIN (
                SELECT post_author, COUNT(*) as post_count
                FROM '.$wpdb->prefix.'posts
                WHERE post_type = "product" AND (post_status = "publish" OR post_status = "private")
                GROUP BY post_author
            ) p ON ('.$wpdb->prefix.'users.ID = p.post_author)';
        $query->query_where = $query->query_where . ' AND post_count  > 0 ' ;  
    } 
}
}

//GMW SHORTCODE MAP
function rh_add_map_gmw($atts=array(), $content = null ) {
	extract( shortcode_atts( array(
			'user_id' => '', // one ID
		), $atts ) );	
	if ( class_exists( 'GMW_Members_Locator_Component' ) ) {
		include (locate_template( 'geo-my-wp/customform/gmw-fl-location-tab.php' ));
		$user_id = (!empty($user_id)) ? $user_id : get_current_user_id();
		if (is_user_logged_in()){
			ob_start(); 
			$mapform = new RH_GMW_FL_Location_Page($user_id);
			echo '<div id="buddypress">';
			$mapform->display_location_form( $mapform->location, $user_id );
			echo '</div>';
			$output = ob_get_contents();
			ob_end_clean();
			return $output; 
		}else{
			ob_start(); 
			_e('Please, login to set location', 'rehub_framework');
			$output = ob_get_contents();
			ob_end_clean();
			return $output;		
		}		
	}
}
add_shortcode('rh_add_map_gmw', 'rh_add_map_gmw');

function rh_compare_icon($atts, $content = null ) {
	if (rehub_option('compare_page') != '' || rehub_option('compare_multicats_toggle') == 1) {	
		$output = '<span class="re-compare-icon-toggle">';
			$output .= '<i class="fa fa-balance-scale" aria-hidden="true"></i>';
			$totalcompared = re_compare_panel('count');
			if ($totalcompared == '') {$totalcompared = 0;}
			$output .= '<span class="re-compare-notice">'.$totalcompared.'</span>';		
		$output .= '</span>';
		return $output;
	}
}
add_shortcode('rh_compare_icon', 'rh_compare_icon');

//VC SHORTCODES
include ( get_template_directory() . '/shortcodes/module_shortcodes.php'); 

if( !function_exists('wpsm_get_bigoffer') ) {
function wpsm_get_bigoffer($atts){
	extract(shortcode_atts(array(
		'title' => NULL,
        'post_id' => NULL,
        'offset' => NULL,
        'limit' => NULL,
    ), $atts));

	if($post_id && is_numeric($post_id)){
		$title = (!empty($title)) ? $title : get_the_title($post_id);
		ob_start();
		?>
        <div class="rh-tabletext-block">
            <div class="rh-tabletext-block-heading"><h4><a href="<?php echo get_the_permalink($post_id) ?>"><?php echo $title; ?></a></h4> </div>		
	        <div class="rh-tabletext-block-wrapper flowhidden"> 
	            <div class="featured_compare_left">
	                <figure>                                                                    
	                    <a href="<?php echo get_the_permalink($post_id) ?>">
	                        <?php           
                    			$image_id = get_post_thumbnail_id($post_id);  
                    			$image_url = wp_get_attachment_image_src($image_id,'full');
                    			$image_url = $image_url[0]; 
                			?> 
	                        <?php WPSM_image_resizer::show_static_resized_image(array('lazy'=> true, 'src'=> $image_url, 'crop'=> false, 'height'=> 350, 'width'=> 350));?>
	                    </a>
	                </figure>                             
	            </div>
	            <div class="single_compare_right">
	            	<?php if(get_post_type($post_id) == 'product'):?>
                    	<?php $overall_review  = get_post_meta($post_id, '_wc_average_rating', true);?>
                    	<?php if ($overall_review){ $overall_review = $overall_review * 2;}?>
	            	<?php else:?>	
	            		<?php $overall_review  = get_post_meta($post_id, 'rehub_review_overall_score', true);?>
	            	<?php endif;?>

                    <?php if($overall_review):?>
                    	<?php $overall_review_100 = $overall_review * 10;?>                  	
                    	<?php 
                    	if($overall_review<=2){
                    		$color = "#940000";
                    	}    
                    	elseif($overall_review<=4){
                    		$color = "#cc0000";
                    	}   
                    	elseif($overall_review<=6){
                    		$color = "#9c0";
                    	}  
                    	elseif ($overall_review <=8){
                    		$color = "#ffac00";
                    	}                    	                  	                  	                 	
                    	elseif ($overall_review <=10) {
                    		$color = "#ffac00";
                    	}
                    	?>                    	                   	
                        <div class="bigoffer-overall-score mb20">
                        	<div class="text-overal-score mb10 flowhidden">
                            <span class="overall floatleft"><?php echo $overall_review;?>/10 </span>
                            <span class="text-read-review floatright"><a href="<?php echo get_the_permalink($post_id) ?>"><?php _e('Read review', 'rehub_framework');?></a></span>
                            </div>
                            <?php echo do_shortcode('[wpsm_bar percentage="'.$overall_review_100.'" color="'.$color.'"]' );?>
                        </div>                         
                    <?php endif;?>
	                <?php echo do_shortcode('[content-egg-block template=custom/all_merchant_widget post_id="'.$post_id.'" offset="'.$offset.'"  limit="'.$limit.'"]');?>
	            </div> 
			</div>
		</div>

		<?php
		$output = ob_get_contents();
		ob_end_clean();
		return $output; 

	}

}
add_shortcode('wpsm_bigoffer', 'wpsm_get_bigoffer');
}


if( !function_exists('wpsm_get_add_deal_popup') ) {
function wpsm_get_add_deal_popup($atts, $content = NULL){
	extract(shortcode_atts(array(
        'postid' => NULL,
        'role' => 'contributor',
    ), $atts));

   	global $post;
   	$post_id = (NULL === $postid) ? $post->ID : $postid;	

	if($post_id && is_numeric($post_id)){
		ob_start();
		$rand = uniqid();
		?>		
		<a class="btn_offer_block csspopuptrigger rh-deal-compact-btn act-rehub-addoffer-popup act-rehub-login-popup" data-popup="addfrontdeal_<?php echo $rand;?>"><?php _e('Add your deal', 'rehub_framework') ?></a>

		<?php if (is_user_logged_in()): 
			$current_user = wp_get_current_user();
		?>
			<div class="csspopup" id="addfrontdeal_<?php echo $rand;?>">
				<div class="csspopupinner addfrontdeal-popup">
					<span class="cpopupclose" href="#">×</span> 
					<?php if ( in_array( $role, (array) $current_user->roles )):?>
						<?php $offer_group_array = get_post_meta( $post_id, 'rehub_multioffer_group', true );?>
						<?php 
						$multioffer_names = array();
						if (!empty($offer_group_array)){
							$multioffer_names = wp_list_pluck( $offer_group_array, 'multioffer_user' );
						}?>
						<?php if (false === in_array($current_user->ID, $multioffer_names)):?>
							<div class="rehub-offer-popup">
								<div class="re_title_inmodal"><?php _e('Add an Offer', 'rehub_framework'); ?></div>
								<form id="rehub_add_offer_form_modal" action="<?php echo home_url( '/' ); ?>" method="post">
									<div class="re-form-group mb20">
										<label for="rehub_product_name"><?php _e('Name of product', 'rehub_framework') ?><span>*</span></label>
										<input class="re-form-input required" name="rehub_product_name" id="rehub_product_name" type="text" />
									</div>
									<div class="re-form-group mb20">
										<label for="rehub_product_url"><?php _e('Offer url', 'rehub_framework') ?><span>*</span></label>
										<input class="re-form-input required" name="rehub_product_url" id="rehub_product_url" type="url" required />
									</div>
									<div class="re-form-group mb20">
										<label for="rehub_product_price"><?php _e('Offer sale price (example, $55)', 'rehub_framework') ?><span>*</span></label>
										<input class="re-form-input required" name="rehub_product_price" id="rehub_product_price" type="text" />
									</div>
									<div class="re-form-group mb20">
										<label for="rehub_product_desc"><?php _e('Short description', 'rehub_framework') ?><span></span></label>
										<input class="re-form-input" name="rehub_product_desc" id="rehub_product_desc" type="text" />
									</div>									
									<div class="re-form-group mb20">
										<input type="hidden" name="action" value="rh_ajax_action_send_offer" />
										<input type="hidden" name="from_user" value="<?php echo $current_user->ID; ?>" />
										<input type="hidden" name="post_id" value="<?php echo $post_id; ?>" />
										<?php wp_nonce_field( 'rh_ajax_action_send_offer', 'offer_nonce' ); ?>
										<button class="wpsm-button rehub_main_btn" type="submit" name="send"><?php _e('Send', 'rehub_framework'); ?></button>
									</div>
								</form>
								<div class="rehub-errors"></div>
							</div>
						<?php else:?>
							<?php _e('You already added your deal to this post', 'rehub_framework');?>
						<?php endif;?>
					<?php else:?>
						<?php $content = do_shortcode($content);?>
						<?php if($content):?>
							<?php echo $content;?>
						<?php else:?>
							<?php  echo sprintf( 'Only users with role <span class="greencolor">%s</span> are allowed to post deals', $role);?>
						<?php endif;?>
					<?php endif;?>
					<div class="rehub-offer-popup-ok font110 rhhidden">
						<div class="re_title_inmodal"><?php _e('Send Offer', 'rehub_framework'); ?></div>
							<?php printf( __('<strong>Thank you, %s!</strong> Your offer has been sent', 'rehub_framework'), $current_user->display_name ); ?>
					</div>
				</div>				
			</div>
		<?php endif;?>
		
		<?php
		$output = ob_get_contents();
		ob_end_clean();
		return $output; 
	}
}
add_shortcode('wpsm_add_deal_popup', 'wpsm_get_add_deal_popup');
}


if( !function_exists('rh_get_post_thumbnails') ) {
function rh_get_post_thumbnails($atts, $content = NULL){
	extract(shortcode_atts(array(
        'postid' => NULL,
        'video' => '',
        'height' => '100',
        'columns' => 5,
        'class' => '',
        'justify' => '',
        'disableimages'=> '',
        'galleryids' => ''
    ), $atts));	
	global $post;
   	$post_id = (NULL === $postid) ? $post->ID : $postid;
   	if($galleryids){
   		$post_image_gallery = $galleryids;
   	}else{
    	$post_image_gallery = get_post_meta( $post_id, 'rh_post_image_gallery', true );   		
   	}

    $post_image_videos = get_post_meta( $post_id, 'rh_post_image_videos', true );
    $countimages = '';
    $columnclass = ($columns==5) ? ' five-thumbnails' : '';
    $justifyclass = ($justify) ? 'modulo-lightbox justified-gallery rh-tilled-gallery ' : 'modulo-lightbox rh-flex-eq-height compare-full-thumbnails mt15 ';
	ob_start();
	?>    
    <?php if(!empty($post_image_gallery) || (!empty($post_image_videos) && $video == 1) ) :?>
    	<?php $random_key = rand(0, 50);?>
        <?php $post_image_gallery = explode(',', $post_image_gallery);?>
        <?php if($post_image_videos):?>
        	<?php $post_image_videos = array_map('trim', explode(PHP_EOL, $post_image_videos));?>
        <?php endif;?> 
        <div class="<?php echo $justifyclass; echo $class; echo $columnclass;?> mb20" data-galleryid="rhgal_<?php echo $random_key;?>">
            <?php foreach($post_image_gallery as $key=>$image_gallery):?>
            	<?php if($image_gallery && $disableimages !=1):?>
	                <a href="<?php echo wp_get_attachment_url($image_gallery);?>" target="_blank" class="mb10" data-thumb="<?php echo wp_get_attachment_url($image_gallery);?>" data-rel="rehub_postthumb_gallery_<?php echo $random_key;?>" data-title="<?php echo esc_attr(get_post_field( 'post_excerpt', $image_gallery));?>">
	                    <?php WPSM_image_resizer::show_static_resized_image(array('lazy'=>false, 'src'=> wp_get_attachment_url($image_gallery), 'crop'=> false, 'height'=> $height, 'title' => esc_attr(get_post_meta( $image_gallery, '_wp_attachment_image_alt', true))));?>                                                     
	                    </a> 
                <?php endif;?>                              
            <?php endforeach;?>  
            <?php if($video == 1 && !empty($post_image_videos)):?>   
	            <?php foreach($post_image_videos as $key=>$video):?>
	                <a href="<?php echo esc_url($video);?>" data-rel="rehub_postthumb_gallery_<?php echo $random_key;?>" target="_blank" class="mb10 rh_videothumb_link" data-poster="<?php echo parse_video_url(esc_url($video), 'hqthumb'); ?>" data-thumb="<?php echo parse_video_url(esc_url($video), 'hqthumb'); ?>"> 
						<img src="<?php echo parse_video_url(esc_url($video), 'hqthumb'); ?>" width="<?php echo $height;?>" alt="" />
	                </a>                               
	            <?php endforeach;?> 
            <?php endif;?>                       
        </div>
        <?php  wp_enqueue_script('modulobox'); wp_enqueue_style('modulobox');?>
        <?php if($justify):?>
        	<?php wp_enqueue_script('justifygallery');?>        	
        <?php endif;?>
        
    <?php endif;?>   
	<?php
	$output = ob_get_contents();
	ob_end_clean();
	return $output; 
}
add_shortcode('rh_get_post_thumbnails', 'rh_get_post_thumbnails');
}

if( !function_exists('rh_get_profile_data') ) {
function rh_get_profile_data($atts, $content = NULL){
	extract(shortcode_atts(array(
        'name' => '',
        'type' => 'text',
        'userid' =>'',
        'usermeta' => '',
    ), $atts));	
    if($usermeta){
    	if($userid == 'author'){
    		global $post;
    		$userid=$post->post_author; 
    	}
    	elseif($userid == 'current'){
			$userid = get_current_user_id();
    	}
    	if(!userid) return;
    	return esc_html(get_user_meta($userid, $usermeta, true));
    }
	if(!$name || !bp_is_active( 'xprofile' )) return;
	if(bp_get_profile_field_data('field='.$name.'&user_id='.$userid.'')){
		$data = bp_get_profile_field_data('field='.$name.'');
		if($type == 'text'){
			$data = esc_html($data);
		}
		elseif ($type=='link'){
			$data = esc_url($data);
		}
		return $data;
	}

}
add_shortcode('rh_get_profile_data', 'rh_get_profile_data');
}


if( !function_exists('rh_is_bpmember_type') ) {
function rh_is_bpmember_type($atts, $content = NULL){
	extract(shortcode_atts(array(
        'type' => '',
        'current' => '',
    ), $atts));	

	if(!$type || !function_exists('bp_get_member_type')) return;
	if($current){
		$userid = get_current_user_id();
		if(!$userid) return;
	}
	else{
		$userid = bp_displayed_user_id();
		if(!$userid) return;
	}
	$usertype = bp_get_member_type($userid);
	if(($usertype == $type) && !is_null( $content )){		
		$content = do_shortcode($content);
		$content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
		$Old     = array( '<br />', '<br>' );
		$New     = array( '','' );
		$content = str_replace( $Old, $New, $content );
		return $content;
	}
	else{
		return false;
	}
}
add_shortcode('rh_is_bpmember_type', 'rh_is_bpmember_type');
}

if( !function_exists('rh_bpmember_type') ) {
function rh_bpmember_type($atts, $content = NULL){
	extract(shortcode_atts(array(
        'bp_user' => '',
    ), $atts));	

	if(!function_exists('bp_get_member_type')) return;
	if($bp_user){
		$userid = bp_displayed_user_id();
		if(!$userid) return;
	}
	else{
		$userid = get_current_user_id();
		if(!$userid) return;
	}
	$usertype = bp_get_member_type($userid);
	$membertype_object = bp_get_member_type_object($usertype);
	$membertype_label = (!empty($membertype_object) && is_object($membertype_object)) ? $membertype_object->labels['singular_name'] : '';	
	return $membertype_label;

}
add_shortcode('rh_bpmember_type', 'rh_bpmember_type');
}

if( !function_exists('rh_is_bpmember_role') ) {
function rh_is_bpmember_role($atts, $content = NULL){
	extract(shortcode_atts(array(
        'role' => '',
    ), $atts));	

	if(!$role || !function_exists('bp_displayed_user_id')) return;
	$userid = bp_displayed_user_id();
	$user = get_userdata($userid);
	if (!empty($user)){
		if(in_array( $role, (array)$user->roles) && !is_null( $content )){		
			$content = do_shortcode($content);
			$content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
			$Old     = array( '<br />', '<br>' );
			$New     = array( '','' );
			$content = str_replace( $Old, $New, $content );
			return $content;
		}
		else{
			return false;
		}		
	}
	else{
		return false;
	}
}
add_shortcode('rh_is_bpmember_role', 'rh_is_bpmember_role');
}

if( !function_exists('rh_is_bpmember_profile') ) {
function rh_is_bpmember_profile($atts, $content = NULL){	
	if(!function_exists('bp_is_my_profile')) return;
	if (bp_is_my_profile()){		
		$content = do_shortcode($content);
		return $content;	
	}
	else{
		return false;
	}
}
add_shortcode('rh_is_bpmember_profile', 'rh_is_bpmember_profile');
}


if( !function_exists('rh_get_group_admins') ) {
function rh_get_group_admins($atts, $content = NULL){
	extract(shortcode_atts(array(
        'text' => '',
    ), $atts));	
    if(!bp_is_group_single()) return;
	global $groups_template;
	$output = '';
	if ( empty( $group ) ) {
		$group =& $groups_template->group;
	}
	$txt = ($text) ? $text : __('Write message', 'rehub_framework') ;
	if ( ! empty( $group->admins ) ) { 
		$output .= '<ul class="buddypress widget">';
			foreach( (array) $group->admins as $admin ) {
				$output .= '<li class="vcard mb15">';
					$output .= '<div class="item-avatar"><a href="'.bp_core_get_user_domain( $admin->user_id, $admin->user_nicename, $admin->user_login ).'">'.bp_core_fetch_avatar( array( 'item_id' => $admin->user_id, 'email' => $admin->user_email, 'alt' => sprintf( __( 'Profile picture of %s', 'rehub_framework' ), bp_core_get_user_displayname( $admin->user_id ) ) ) ).'</a></div>';
					$link = (is_user_logged_in()) ? wp_nonce_url( bp_loggedin_user_domain() . bp_get_messages_slug() . '/compose/?r=' . bp_core_get_username( $admin->user_id) .'&ref='. urlencode(get_permalink())) : '#';
					$class = (!is_user_logged_in() && rehub_option('userlogin_enable') == '1') ? ' act-rehub-login-popup' : '';
					$output .='<div class="item"><div class="item-title-bpadmin"><a href="'.bp_core_get_user_domain( $admin->user_id, $admin->user_nicename, $admin->user_login ).'">'.$admin->user_nicename.'</a></div><a href="'.$link.'" class="vendor_store_owner_contactlink'.$class.'"><i class="fa fa-envelope-o" aria-hidden="true"></i> <span>'. $txt .'</span></a></div>';					
				$output .= '</li>';
			} 
		$output .= '</ul>';
	}
	return $output; 
}
add_shortcode('rh_get_group_admins', 'rh_get_group_admins');
}


//////////////////////////////////////////////////////////////////
// AMP Button to mobile version
//////////////////////////////////////////////////////////////////
if( !function_exists('rh_get_permalink') ) {
function rh_get_permalink( $atts, $content = null ) {
    return get_the_permalink();
}
add_shortcode('rh_permalink', 'rh_get_permalink');
}

//////////////////////////////////////////////////////////////////
// SEARCH CE BIG
//////////////////////////////////////////////////////////////////
if( !function_exists('rh_ce_search_form') ) {
function rh_ce_search_form( $atts=array(), $content = null ) {
	$build_args =shortcode_atts(array(
		'placeholder' => __('Search Products...', 'rehub_framework'),
		'label' => __('Search', 'rehub_framework'),		
	), $atts, 'rh_ce_search_form'); 
	extract( $build_args ); 
	ob_start(); 
	?>
	<style scope> 
.cssProgress{opacity: 0; visibility: hidden;    -webkit-transform: translate3d(0, 25px, 0);transform: translate3d(0, 25px, 0);    -webkit-transition: all .4s ease-out;transition: all .4s ease-out;}.cssProgress.active{opacity: 1; visibility:visible ;-webkit-transform: translate3d(0, 0, 0);transform: translate3d(0, 0, 0);}.progress2{position: relative;overflow: hidden;width: 100%;    background-color: #EEE;box-shadow: inset 0px 1px 3px rgba(0, 0, 0, 0.2);}.progress2 .cssProgress-bar {height: 14px;}.cssProgress .cssProgress-active {-webkit-animation: cssProgressActive 2s linear infinite;-ms-animation: cssProgressActive 2s linear infinite;animation: cssProgressActive 2s linear infinite;}.cssProgress .cssProgress-stripes, .cssProgress .cssProgress-active, .cssProgress .cssProgress-active-right {background-image: -webkit-linear-gradient(135deg, rgba(255, 255, 255, 0.125) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.125) 50%, rgba(255, 255, 255, 0.125) 75%, transparent 75%, transparent);background-image: linear-gradient(-45deg, rgba(255, 255, 255, 0.125) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.125) 50%, rgba(255, 255, 255, 0.125) 75%, transparent 75%, transparent);background-size: 35px 35px;}.cssProgress .cssProgress-success {background-color: #41bc03 !important;}.cssProgress .cssProgress-bar {display: block;float: left;width: 0%;box-shadow: inset 0px -1px 2px rgba(0, 0, 0, 0.1);}@-webkit-keyframes cssProgressActive {0% {background-position: 0 0;}100% {background-position: 35px 35px;}}@-ms-keyframes cssProgressActive {0% {background-position: 0 0;}100% {background-position: 35px 35px;}}@keyframes cssProgressActive {0% {background-position: 0 0;}100% {background-position: 35px 35px;}}@-webkit-keyframes cssProgressActiveRight {0% {background-position: 0 0;}100% {background-position: -35px -35px;}}@-ms-keyframes cssProgressActiveRight {0% {background-position: 0 0;}100% {background-position: -35px -35px;}}@keyframes cssProgressActiveRight {0% {background-position: 0 0;}100% {background-position: -35px -35px;}}</style>	
	<div class="progress-animate-onclick custom_search_box flat_style_form">
		<div class="cssProgress mb10">
          <div class="progress2">
            <div class="cssProgress-bar cssProgress-success cssProgress-active" style="width: 20%; transition: none;">
            </div>
          </div>
	    </div>
		<form  role="search" method="get" id="searchform" action="<?php echo \ContentEgg\application\ProductSearchWidget::getSearchFormUri(); ?>">
		  	<input type="text" name="s" placeholder="<?php echo esc_attr($placeholder)?>">
		  	<button type="submit" class="wpsm-button rehub_main_btn trigger-progress-bar"><?php echo esc_attr($label)?></button>
		</form>
	</div>

	<?php
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}
add_shortcode('rh_ce_search_form', 'rh_ce_search_form');
}

//////////////////////////////////////////////////////////////////
// Is Post type shortcode
//////////////////////////////////////////////////////////////////
if( !function_exists('rh_is_singular') ) {
function rh_is_singular( $atts, $content = null ) {
	extract(shortcode_atts(array(
        'type' => '',
    ), $atts, 'rh_is_singular'));	
	// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
	$content = do_shortcode($content);
	$content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
	$Old     = array( '<br />', '<br>' );
	$New     = array( '','' );
	$content = str_replace( $Old, $New, $content );
	if ( is_singular($type)) {
		return $content;
	}		
	else { 
		return;	
	}
}	
add_shortcode('rh_is_singular', 'rh_is_singular');
}

//////////////////////////////////////////////////////////////////
// Is Woo category
//////////////////////////////////////////////////////////////////


if( !function_exists('rh_is_category') ) {
function rh_is_category( $atts, $content = null ) {
	extract(shortcode_atts(array(
        'ids' => '',
        'tax' => 'product_cat',
    ), $atts, 'rh_is_category'));	
    $postid = get_the_ID();
    $post_terms = wp_get_post_terms($postid, $tax, array("fields" => "ids"));
	$ids = array_map( 'trim', explode( ",", $ids ) );
	$post_in_cat = array_intersect($post_terms, $ids);
	if(array_filter($post_in_cat)) {
		// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
		$content = do_shortcode($content);
		$content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
		$Old     = array( '<br />', '<br>' );
		$New     = array( '','' );
		$content = str_replace( $Old, $New, $content );		
		return $content;
	}		
	else { 
		return;	
	}
}	
add_shortcode('rh_is_category', 'rh_is_category');
}


if( !function_exists( 'rh_mailchimp_shortcode' ) ) {
	function rh_mailchimp_shortcode( $atts ) {
		$atts = shortcode_atts(
			array(
				'action' => '',
				'title' => '',
				'placeholder' => 'email address',
				'inputname' => '',
				'button' => 'Subscribe',
				'subtitle' => '',
				'class' => '',
				'flat' => '',
			),
			$atts,
			'rh_mailchimp'
		);

		if ( $atts['action'] == '' OR $atts['inputname'] == ''  ) {
			$output = '';
		} else {
			$flat = ($atts['flat'] == 1) ? ' rehub_chimp_flat' : ' rehub_chimp';
			$title = ($atts['title'] != '') ? '<h3 class="chimp_title">'.$atts['title'].'</h3>' : '';
			$subtitle = ($atts['subtitle'] != '') ? '<p class="chimp_subtitle">'.$atts['subtitle'].'</p>' : '';
			$output = '
			<div class="centered_form '.$atts['class'].$flat.'">
			'.$title.'
			<!-- Begin MailChimp Signup Form -->
			<div id="mc_embed_signup">
			<form action="'. esc_url($atts['action']) .'" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
				<div id="mc_embed_signup_scroll">
				<input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="'. $atts['placeholder'] .'" required>
				<div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="'. esc_html($atts['inputname']) .'" tabindex="-1" value=""></div>
				<div class="clear"><input type="submit" value="'. $atts['button'] .'" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
				</div>
			</form>
			</div>
			<!--End mc_embed_signup-->
			'.$subtitle.'
			</div>';		
		}
		return $output;
	}
	add_shortcode( 'rh_mailchimp', 'rh_mailchimp_shortcode' );
}

//////////////////////////////////////////////////////////////////
// Review box
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_reviewbox') ) {
function wpsm_reviewbox( $atts, $content = null ) {
        $atts = shortcode_atts(
			array(
				'title' => '',
				'description' => '',
				'criterias' => '',
				'score' => '',
				'pros' => '',
				'prostitle' => __('PROS', 'rehub_framework'),				
				'cons' => '',
				'constitle' => __('CONS', 'rehub_framework'),
				'id' => '',
				'compact' =>'',															
			), $atts, 'wpsm_reviewbox');
        extract($atts);

    if($compact && $id){
    	$score = get_post_meta((int)$id, 'rehub_review_editor_score', true);
    	$title = (!empty($title)) ? $title : __('Editor\'s score', 'rehub_framework');
    	$description = (!empty($description)) ? $description : __('Read review', 'rehub_framework');
    	$link = get_the_permalink((int)$id);
    	$out = '<div class="mb15 compact-reviewbox colored_rate_bar rh-flex-center-align border-lightgrey">';
    		$out .= '<div class="score-compact r_score_'. round($score).'">'.$score.'</div>';
    		$out .= '<div class="rev-comp-text lineheight20 ml15 mr15"><span class="rev-comp-title rehub-main-font">'.$title.'</span>';
    		$out .= '<span class="rev-comp-link font90"><a href="'.$link.'" target="_blank">'.$description.'</a></span>';    		
    		$out .= '</div>';
    	$out .= '</div>';
    }
	else{
	    $scoretotal = 0; $total_counter = 0;
		$out = '<div class="rate_bar_wrap"><div class="review-top"><div class="overall-score">';
			if (!empty($criterias))  {
				$thecriteria = explode(';', $criterias);
			    foreach ($thecriteria as $criteria) {
			    	if(!empty($criteria)){
			    		$criteriaflat = explode(':', $criteria);
			    		$scoretotal += $criteriaflat[1]; $total_counter ++;
			    	}
			    }
			    if( !empty( $scoretotal ) && !empty( $total_counter ) ) $total_score =  $scoretotal / $total_counter ;
			    $total_score = round($total_score,1);
			}
		    if (!empty($score))  {
		    	$total_score = $score;
		    }
			$out .= '<span class="overall">'.$total_score.'</span><span class="overall-text">'.__('Total Score', 'rehub_framework').'</span></div>';
			$out .='<div class="review-text"><span class="review-header">'.$title.'</span><p>'.esc_html($description).'</p></div></div>';
			if (!empty($criterias))  {
				$out .='<div class="review-criteria">';
				    foreach ($thecriteria as $criteria) {
				    	if(!empty($criteria)){
					    	$criteriaflat = explode(':', $criteria);
					    	$perc_criteria = $criteriaflat[1]*10;
					    	$out .='<div class="rate-bar clearfix" data-percent="'.$perc_criteria.'%">
								<div class="rate-bar-title"><span>'.$criteriaflat[0].'</span></div>
								<div class="rate-bar-bar"></div>
								<div class="rate-bar-percent">'.$criteriaflat[1].'</div>
							</div>';
						}
				    }	
				$out .='</div>';	
			}
			$pros_cons_wrap = (!empty($pros) || !empty($cons) ) ? ' class="pros_cons_values_in_rev"' : '';
			$out .='<div'.$pros_cons_wrap.'>';
				if(!empty($pros)):
					$out .='<div';
					if(!empty($pros) && !empty($cons)):
						$out .=' class="wpsm-one-half wpsm-column-first"';
					endif;
					$out .='>';
					$out .='<div class="wpsm_pros"><div class="title_pros">'.$prostitle.'</div><ul>';		
					$prosvalues = explode(';', $pros);
					foreach ($prosvalues as $prosvalue) {
						if(!empty($prosvalue)){
							$out .='<li>'.$prosvalue.'</li>';						
						}
					}
					$out .='</ul></div></div>';
				endif;
				if(!empty($cons)):
					$out .='<div';
					$out .=' class="wpsm-one-half wpsm-column-last"';
					$out .='>';
					$out .='<div class="wpsm_cons"><div class="title_cons">'.$constitle.'</div><ul>';
					$consvalues = explode(';', $cons);
					foreach ($consvalues as $consvalue) {
						if(!empty($consvalue)){
							$out .='<li>'.$consvalue.'</li>';
						}
					}
					$out .='</ul></div></div>';
				endif;			
			$out .='</div>';	

		$out .='</div>';		
	}


    return $out;
}
add_shortcode('wpsm_reviewbox', 'wpsm_reviewbox');
}

//////////////////////////////////////////////////////////////////
// LATEST COMMENTS WITH REVIEW
//////////////////////////////////////////////////////////////////
if( !function_exists('rh_latest_comments') ) {
	function rh_latest_comments( $atts=array(), $content = null ) {
		$build_args =shortcode_atts(array(
			'number' => 5,
			'user_id' => '',
			'ids' => '',
			'postids' => '',
			'post_type' => 'post',
			'only_review' => '',
			'best' => '',
			'img_height' => 50,
			'img_width' => 50,
			'offset' => ''
		), $atts, 'rh_latest_comments'); 
		extract( $build_args ); 
		ob_start(); 
		?>
		
		<?php
		$args = array(
			'number'=> $number,
			'post_type' => $post_type,
		);
		$meta_key = 'user_average';
		if ( $post_type == 'product' && class_exists('Woocommerce') ) {
			$meta_key = 'rating';
		}
		if( $only_review ) {
			$args['meta_key'] = $meta_key;
			if($best){
				$args['orderby'] = 'meta_value_num';
				if($best == 'helpful'){
					$args['meta_key'] = 'recomm_plus';
				}
			}
		}
		if( $user_id ) {
			$args['user_id'] = $user_id;
		}
		if( $ids ) {
			$idsArr = explode( ',', $ids );
			$args['comment__in'] = $idsArr;
		}
		if( $postids ) {
			$postidsArr = explode( ',', $postids );
			$args['post__in'] = $postidsArr;
		}		
		if( rehub_option('color_type_review') == 'simple' ) {
			$color_type = ' simple_color';
		} else {
			$color_type = ' multi_color';
		}
		if($offset){
			$args['offset'] = $offset;
		}

		$comments_query = new WP_Comment_Query();
		$comments = $comments_query->query( $args );
		?>
		<ol class="rh_reviewlist">
		<?php 
		if ( $comments ) : foreach ( $comments as $comment ) :
			$author_id = $comment->user_id;
			$comment_ID = $comment->comment_ID;
			$comment_post_ID = $comment->comment_post_ID;
			$userCriteria = get_comment_meta( $comment_ID, 'user_criteria', true );
			$userAverage = get_comment_meta( $comment_ID, 'user_average', true );
			$pros_review = get_comment_meta( $comment_ID, 'pros_review', true );
			$cons_review = get_comment_meta( $comment_ID, 'cons_review', true );
			$offer_price_old = get_post_meta( $comment_post_ID, 'rehub_offer_product_price_old', true );
			$offer_price = get_post_meta( $comment_post_ID, 'rehub_offer_product_price', true );
			//$offer_currency = get_post_meta( $comment_post_ID, 'rehub_main_product_currency', true );
			$offer_thumb = get_post_meta( $comment_post_ID, 'rehub_offer_product_thumb', true );
			$offer_url = get_post_meta( $comment_post_ID, 'rehub_offer_product_url', true );
			$post_url = get_permalink( $comment_post_ID );
			
			if ( $post_type == 'product' && class_exists('Woocommerce') ) {
				$_product = wc_get_product( $comment_post_ID );
				$product_price = $_product->get_price_html();
				$userAverage = get_comment_meta( $comment_ID, 'rating', true );
			}
			$text = $textsec = '';
		?>
		<li class="mb15 ml0 commid-<?php echo $comment_ID; ?>">
			<div class="commbox">
				<div class="commheader clearfix">			
					<figure style="width:<?php echo $img_width; ?>px" class="floatleft <?php echo (is_rtl()) ? 'ml20' : 'mr20';?>">                                                                  
						<a href="<?php echo $post_url; ?>">
							<?php if ( empty( $offer_thumb ) ) :?>
								<?php echo get_the_post_thumbnail( $comment_post_ID, array($img_width, $img_height) ); ?>
							<?php else :?>
								<?php WPSM_image_resizer::show_static_resized_image(array('lazy'=> true, 'src'=> $offer_thumb, 'crop'=> true, 'height'=> $img_height, 'width'=> $img_width));?>
							<?php endif ;?>
						</a>
					</figure>
					<?php $img_width_2 = $img_width + 20;?>
					<div class="commwrap floatleft" style="width:calc(100% - <?php echo $img_width_2; ?>px)">
						<h4 class="mt0 mb10"><a href="<?php echo $post_url; ?>"><?php echo esc_html( get_the_title( $comment_post_ID ) ); ?></a>
							<?php if(!empty($product_price)):?>
								- <span class="fontnormal rehub-main-color product_price_in_comm"><?php echo $product_price;?></span>
							<?php elseif($offer_price):?>
								<span class="fontnormal"> - <span class="product_price_in_comm rehub-main-color"><?php echo $offer_price;?></span>
								<?php if($offer_price_old):?> 
									<del class="product_price_in_comm lightgreycolor font80"><?php echo $offer_price_old;?></del>
								<?php endif;?>
								</span>
							<?php endif;?>
						</h4>			
						<span class="commmeta font80">
						<?php 
							if( isset( $userAverage ) && $userAverage != '' ) {
								$userAverages = ($post_type == 'product') ? ($userAverage * 20) : ($userAverage * 10); 
								$userstartitle = ($post_type == 'product') ? $userAverage : ($userAverage / 2);
								echo '<div class="user_reviews_view_score mb0"><div class="userstar-rating" title="'. __('Rated', 'rehub_framework') .' '. $userstartitle .' '. __('out of', 'rehub_framework') .' 5"><span style="width:'. $userAverages .'%"><strong class="rating">'. $userstartitle .'</strong></span></div></div>';
							}
							printf( __( 'Reviewed on <span class="date greycolor">%s</span> by', 'rehub_framework' ), get_comment_date( get_option( 'date_format' ), $comment_ID ) );
							echo ' <a href="'. get_comment_link( $comment_ID ) .'" class="author-'. $author_id .'">' . get_comment_author( $comment_ID ) .'</a>'; 
						?>
						</span>
					</div>				
				</div>
				<div class="commcontent">
				<?php 
					if( is_singular('post') && rehub_option('rehub_replace_color') == '1' && rehub_option('color_type_review') =='simple' ) {
						$category = get_the_category( $comment_post_ID ); 
						$first_cat = $category[0]->term_id; 
						$cat_sustom = ' category-'. $first_cat .'';
					} else {
							$cat_sustom = '';
					}
		
					if( is_array( $userCriteria ) && !empty( $userCriteria ) ) {
						$text ='<div class="user_reviews_view_box mt20">';
						for( $i = 0; $i < count($userCriteria); $i++ ) {
							$value_criteria = $userCriteria[$i]['value'] * 10;		
							$text .= '<div class="user_reviews_view_criteria_line"><span class="user_reviews_view_criteria_name">'. $userCriteria[$i]['name'] .'</span><div class="userstar-rating"><span style="width:'. $value_criteria .'%"><strong class="rating">'. $value_criteria .'</strong></span></div></div>';
						}
						$text .= '</div>';
						
						if( isset($pros_review) && $pros_review != '' ) {
							$pros_reviews = explode(PHP_EOL, $pros_review);
							$proscomment = '';
							foreach ($pros_reviews as $pros) {
								$proscomment .='<span class="pros_comment_item">'. $pros .'</span>';
							}
							$textsec .= '<div class="wpsm-one-half wpsm-column-first user_reviews_view_pros"><span class="user_reviews_view_pc_title mb5">'.__('+ PROS:', 'rehub_framework').' </span><span> '. $proscomment .'</span></div>';
						}
					
						if( isset($cons_review) && $cons_review != '' ) {
							$cons_reviews = explode(PHP_EOL, $cons_review);
							$conscomment = '';
							foreach ($cons_reviews as $cons) {
								$conscomment .='<span class="cons_comment_item">'. $cons .'</span>';
							}		
							$textsec .= '<div class="wpsm-one-half wpsm-column-last user_reviews_view_cons"><span class="user_reviews_view_pc_title mb5">'.__('- CONS:', 'rehub_framework').'</span><span> '. $conscomment .'</span></div>';
						}
						
						if( rehub_option('enable_btn_userreview') == '1' ) {
							$textsec .= getCommentLike_re('');	
						}
						echo '<div class="user_reviews_view'. $color_type .''. $cat_sustom .'">';
						comment_text($comment_ID);
						echo $text;
						echo '<div class="user_reviews_view_proscons mt20">';
							echo $textsec;
						echo '</div></div>';
					} else {
						echo '<div class="user_reviews_view'. $color_type .''. $cat_sustom .'">';
						comment_text($comment_ID);
						echo '</div>';
					}
				?>
				</div>
			</div>
		</li>
		<?php endforeach; endif; ?>
		</ol>
		<?php
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
	add_shortcode('rh_latest_comments', 'rh_latest_comments');
}

// WPSM Banner
function wpsm_banner_shortcode( $atts, $content = null ) {
	$atts = shortcode_atts(
		array(
			'title' => 'Title',
			'subtitle' => 'Subtitle',
			'image_id' => '',
			'enable_icon' => '',
			'icon' => 'fa fa-gift',
			'color' => '',
			'colortext' => '#111',			
			'padding' => 40,
			'height' => '',
			'align' => '',
			'overlay' => '',
			'url' => '',
			'firstsize' => '',
			'secondsize' => '',
			'vertical' => 'middle',
			'bg' => '#cecece',
			'image_url' => ''
		),
		$atts,
		'wpsm_hover_banner'
	);
	extract( $atts );

	if ($image_id) {
		$image_url = wp_get_attachment_image_src($image_id, 'full');
		$image_url = $image_url[0];
	}
	$b_style = empty($image_url) ? '' : 'background-image:url('.$image_url.');';
	$h_style = empty($height) ? '' : 'height:'.$height.'px';
	$c_pad = 'padding: '.$padding.'px';
	$b_pad = $padding / 2 .'px';
	$main_color = rehub_option('rehub_custom_color');
	$color = empty($color) ? $main_color : $color;

	$rand_id = uniqid().time();
	
	$icon = $enable_icon ? '<i class="'. $icon .'" aria-hidden="true"></i> ' : '';
	
	if($align == 'right'){
		$text_align = ' text-right-align';
	}else if($align == 'center'){
		$text_align = ' text-center';
	}else{
		$text_align = '';
	}
	
	if($overlay == 1){
		$overlay_class = ' wpsm-banner-overlay';
		$mask_div = '<div class="wpsm-banner-mask"></div>';
	}else{
		$overlay_class = '';
		$mask_div = '';
	}
	$colortext = empty($colortext) ? '' : '#wpsm_banner_'.$rand_id.' h4, #wpsm_banner_'.$rand_id.' h6{color:'.$colortext.'}';
	$firstsize = empty($firstsize) ? '' : '#wpsm_banner_'.$rand_id.' h4{font-size:'.$firstsize.'}';	
	$secondsize = empty($secondsize) ? '' : '#wpsm_banner_'.$rand_id.' h6{font-size:'.$secondsize.'}';
	$vertical = ($vertical =='middle') ? '' : '#wpsm_banner_'.$rand_id.' .celldisplay{vertical-align:'.$vertical.'}';
	$output = '';
	$output .= '<div id="wpsm_banner_'.$rand_id.'" class="wpsm-banner-wrapper mb20 rh-transition-box'.$overlay_class.'">';
	$output .= '<style scope>#wpsm_banner_'.$rand_id.' .wpsm-banner-image{background-color:'.$bg.';'.$b_style.''.$h_style.'}#wpsm_banner_'.$rand_id.' .wpsm-banner-text i{color:'.$color.'}#wpsm_banner_'.$rand_id.' .wpsm-banner-text:before, #wpsm_banner_'.$rand_id.' .wpsm-banner-text:after{border-color:'.$color.';top:'.$b_pad.';right:'.$b_pad.';bottom:'.$b_pad.';left:'.$b_pad.';}#wpsm_banner_'.$rand_id.' .celldisplay{'.$c_pad.'}'.$colortext.$firstsize.$secondsize.$vertical.'</style>';	
		if (!empty($url)) { $output .= '<a href="'.$url.'" target="_blank" title="'.$title.'">'; }
			$output .= '<div class="wpsm-banner-image categoriesbox-bg">'.$mask_div.'</div>';
			$output .= '<div class="wpsm-banner-text"><div class="tabledisplay">';
				$output .= '<div class="celldisplay'. $text_align .'">';
					$output .= sprintf( '%s<h4>%s</h4><h6>%s</h6>', $icon, $title, $subtitle );
				$output .='</div>';
			$output .= '</div></div>';
		if (!empty($url)) { $output .= '</a>'; }
	$output .= '</div>';
	
	return $output;
}
add_shortcode( 'wpsm_hover_banner', 'wpsm_banner_shortcode' );


//////////////////////////////////////////////////////////////////
// Itinerary shortcode
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_itinerary_shortcode') ) {
	function wpsm_itinerary_shortcode( $atts, $content = null  ) {	
		$content = do_shortcode($content);
        $content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
		$old     = array( '<br />', '<br>' );
		$new     = array( '','' );
		$content = str_replace( $old, $new, $content );
		return '<div class="wpsm-itinerary">'. $content .'</div>';
	}
	add_shortcode( 'wpsm_itinerary', 'wpsm_itinerary_shortcode' );
}
if( !function_exists('wpsm_itinerary_item_shortcode') ) {
	function wpsm_itinerary_item_shortcode( $atts , $content = null ) {
		$atts = shortcode_atts(
			array(
				'icon' => '',
				'color' => ''
			),
			$atts,
			'wpsm_itinerary_item'
		);
		extract($atts);
		$color = empty($color) ? '#409cd1' : $color;
		$icon = empty($icon) ? 'fa-circle' : $icon;
		$content = do_shortcode($content);
		$output = '<div class="wpsm-itinerary-item">';
			$output .= '<div class="wpsm-itinerary-icon"><span style="background-color:'. $color .'"><i class="fa '. $icon .'" aria-hidden="true"></i></span></div>';
			$output .= '<div class="wpsm-itinerary-content">'. $content .'</div>';
		$output .= '</div>';
		return $output;
	}
	add_shortcode( 'wpsm_itinerary_item', 'wpsm_itinerary_item_shortcode' );
}

//////////////////////////////////////////////////////////////////
// Versus shortcode
//////////////////////////////////////////////////////////////////

if( !function_exists('wpsm_versus_shortcode') ) {
	function wpsm_versus_shortcode( $atts , $content = null ) {
		$atts = shortcode_atts(
			array(
				'heading' => '',
				'subheading' => '',
				'type' => 'two',
				'bg' => '',
				'color' => '',
				'firstcolumntype' => '',
				'secondcolumntype' => '',
				'thirdcolumntype' => '',		
				'firstcolumngrey' => '',
				'secondcolumngrey' => '',
				'thirdcolumngrey' => '',
				'firstcolumncont' => '',
				'secondcolumncont' => '',
				'thirdcolumncont' => '',
				'firstcolumnimg' => '',
				'secondcolumnimg' => '',
				'thirdcolumnimg' => '',								
			),
			$atts,
			'wpsm_versus'
		);
		extract($atts);
		$fclass = $sclass = $tclass = array();
		$fclass[] = 'vs-1-col';
		$sclass[] = 'vs-2-col';
		$tclass[] = 'vs-3-col';
		$rand_id = uniqid().'vers';
		$output = '<div class="wpsm-versus-item" id="wpsm-vs-'.$rand_id .'">';

			if($bg || $color){
				$colorstyle = empty($color) ? '' : '#wpsm-vs-'.$rand_id.', #wpsm-vs-'.$rand_id.' .vs-conttext{color:'.$color.'}';
				$bgstyle = empty($bg) ? '' : '#wpsm-vs-'.$rand_id.'{background-color:'.$bg.'; margin-bottom:6px}';				
				$output .= '<style scope>'.$colorstyle.$bgstyle.'</style>';	
			}

			$output .= '<div class="title-versus rehub-main-font"><span class="vs-heading">'.$heading.'</span><span class="vs-subheading">'.$subheading.'</span></div>';
			$output .= '<div class="wpsm-versus-cont">';

				if($firstcolumntype == 'tick'){
					$fclass[] = 'vs-tick';
				}
				elseif($firstcolumntype == 'times'){
					$fclass[] = 'vs-times';
				}	
				elseif($firstcolumntype == 'image'){
					$fclass[] = 'vs-img-col';
				}					
				else{
					$fclass[] = 'vs-conttext';						
				}				
				if($firstcolumngrey){
					$fclass[] = 'vs-greyscale';
				}						
				$output .= '<div class="'.implode(' ', $fclass).'">';
					if($firstcolumntype == 'tick'){
						$output .= '<i class="fa fa-check-circle" aria-hidden="true"></i>';
					}
					elseif($firstcolumntype == 'times'){
						$output .= '<i class="fa fa-times" aria-hidden="true"></i>';
					}		
					elseif($firstcolumntype == 'image'){
						$image_url = wp_get_attachment_image_url($firstcolumnimg, 'full');						
						$output .=  '<img src="'.$image_url.'" class="vs-image" />';
					}	
					else{
						$output .=  do_shortcode($firstcolumncont);
					}																	
				$output .= '</div>';
				$output .= '<div class="vs-circle-col"><div class="vs-circle">VS</div></div>';

				if($secondcolumntype == 'tick'){
					$sclass[] = 'vs-tick';
				}
				elseif($secondcolumntype == 'times'){
					$sclass[] = 'vs-times';
				}	
				elseif($secondcolumntype == 'image'){
					$sclass[] = 'vs-img-col';
				}					
				else{
					$sclass[] = 'vs-conttext';						
				}				
				if($secondcolumngrey){
					$sclass[] = 'vs-greyscale';
				}						
				$output .= '<div class="'.implode(' ', $sclass).'">';
					if($secondcolumntype == 'tick'){
						$output .= '<i class="fa fa-check-circle" aria-hidden="true"></i>';
					}
					elseif($secondcolumntype == 'times'){
						$output .= '<i class="fa fa-times" aria-hidden="true"></i>';
					}	
					elseif($secondcolumntype == 'image'){
						$image_url = wp_get_attachment_image_url($secondcolumnimg, 'full');					
						$output .=  '<img src="'.$image_url.'" class="vs-image" />';
					}
					else{
						$output .=  do_shortcode($secondcolumncont);
					}																		
				$output .= '</div>';	

				if($type=='three'){
					$output .= '<div class="vs-circle-col"><div class="vs-circle">VS</div></div>';
					if($thirdcolumntype == 'tick'){
						$tclass[] = 'vs-tick';
					}
					elseif($thirdcolumntype == 'times'){
						$tclass[] = 'vs-times';
					}
					elseif($thirdcolumntype == 'image'){
						$tclass[] = 'vs-img-col';
					}					
					else{
						$tclass[] = 'vs-conttext';						
					}	
					if($thirdcolumngrey){
						$tclass[] = 'vs-greyscale';
					}						
					$output .= '<div class="'.implode(' ', $tclass).'">';
						if($thirdcolumntype == 'tick'){
							$output .= '<i class="fa fa-check-circle" aria-hidden="true"></i>';
						}
						elseif($thirdcolumntype == 'times'){
							$output .= '<i class="fa fa-times" aria-hidden="true"></i>';
						}		
						elseif($thirdcolumntype == 'image'){
							$image_url = wp_get_attachment_image_url($thirdcolumnimg, 'full');					
							$output .=  '<img src="'.$image_url.'" class="vs-image" />';
						}
						else{
							$output .=  do_shortcode($thirdcolumncont);
						}																			
					$output .= '</div>';					
				}


			$output .= '</div>';
		$output .= '</div>';
		return $output;
	}
	add_shortcode( 'wpsm_versus', 'wpsm_versus_shortcode' );
}

//////////////////////////////////////////////////////////////////
// Compare Bar
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_compare_bar_shortcode') ) {
	function wpsm_compare_bar_shortcode( $atts  ) {		
		extract( shortcode_atts( array(
			'max' => '',
			'lines' => '',
			'color' => '',
			'unit' => '',
			'marktype' => 'max',
			'markcolor' => ''
		), $atts ) );	

		$output = '';
		if (empty($lines) || empty($max)) return;

		$lines =  explode('@@', $lines);

		$bar_array = array();
		$value_array = array();

		foreach ($lines as $key => $bars) {
			if(empty($bars)) continue;
			$bars = explode('::', $bars);
			if(empty($bars[1]) || empty($bars[0])) continue;
			$bar_array[$key]['title'] = esc_html($bars[0]);
			$bar_array[$key]['value'] = $value_array[] = (int)$bars[1];
			$bar_array[$key]['link'] = (!empty($bars[2])) ? esc_url($bars[2]) : '';
			$perc_value = (int)$bars[1] / $max * 100;
			if($perc_value >100) $perc_value = 100;
			$bar_array[$key]['percentage'] = $perc_value;
		}	

		if($marktype == 'min'){
			$minvalue = min($value_array);
			$bestkey = array_search($minvalue, $value_array);
		}else{
			$maxvalue = max($value_array);
			$bestkey = array_search($maxvalue, $value_array);			
		}

		$output .= '<div class="wpsm-bar-compare mb25">';		

		foreach ($bar_array as $index => $barline) {
			
			if($index == $bestkey){
				if($markcolor) {
					$bg = $markcolor;
				}
				else{
					$bg = '#f07a00';
				}
			}
			elseif(!empty($color)){
				$bg = $color;
			}
			else{
				$bg='';
			}


			$percentage = $barline['percentage'];
			$title = $barline['title'];
			$value = $barline['value'];
			$link = (!empty($barline['link'])) ? '<a href="'.$barline["link"].'">' : '';
			$linkclose = (!empty($link)) ? ' <i class="fa fa-external-link" aria-hidden="true"></i></a>' : '';

			$stylebg = ($bg) ? ' style="background: '. $bg .'"' : '';
			$output .= '<div class="wpsm-bar wpsm-clearfix wpsm-bar-compare" data-percent="'. $percentage .'%">';
				$output .= '<div class="wpsm-bar-title"><span>'.$link. $title .$linkclose.'</span></div>';
				$output .= '<div class="wpsm-bar-bar"'.$stylebg.'></div>';
				$output .= '<div class="wpsm-bar-percent">'.$value.$unit.'</div>';
			$output .= '</div>';			

		}

		$output .= '</div>';
		
		return $output;
	}
	add_shortcode( 'wpsm_compare_bar', 'wpsm_compare_bar_shortcode' );
}
