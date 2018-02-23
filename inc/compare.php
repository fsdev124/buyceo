<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php

/*-----------------------------------------------------------------------------------*/
# 	Compare functions
/*-----------------------------------------------------------------------------------*/
if(!is_admin()) add_action('init', 'rehub_compare_script');
function rehub_compare_script(){
	wp_enqueue_script('rehubcompare');	
	$trans_array = array( 
		'item_error_add' => __( 'Please, add items to this compare group or choose not empty group', 'rehub_framework' ), 
		'item_error_comp' => __( 'Please, add more items to compare', 'rehub_framework' )
	);
	wp_localize_script( 'rehubcompare', 'comparechart', $trans_array );
}


/*ADD COMPARE QUERY VAR*/
function add_query_vars_compareids( $vars ){
   $vars[] = "compareids";
   return $vars;
}
add_filter( 'query_vars', 'add_query_vars_compareids' );

if (!function_exists('rh_compare_charts_title_dynamic')){
	function rh_compare_charts_title_dynamic(){
		global $compareids;
		$separator = ' VS ';
		//$compareids = (get_query_var('compareids')) ? explode(',', get_query_var('compareids')) : '';
		if (!empty($compareids)){
			$countids = count($compareids);
			$title_compare = '';
			$i=0;
			foreach ($compareids as $compareid){
				$i++;
				$title_compare .= get_the_title($compareid);
				if ($i !=$countids){
					$title_compare .= $separator;
				}
			}
			return $title_compare;
		}
	}	
}

/* GET MULTICATS DATA */
if( !function_exists('rehub_get_compare_multicats') ) {
function rehub_get_compare_multicats(){
	$data = rehub_option('compare_multicats_textarea');
	if(empty($data))
		return;
	$array = array_map(
		function($string) {
			return explode(';', $string);
		},
		explode(PHP_EOL, $data)
	);
	return $array;
}
}


/*ADD PANEL TO FOOTER*/
function rehub_comparepanel_footer(){
	$compare_page = rehub_option('compare_page');
	$multicats_on = rehub_option('compare_multicats_toggle');
	$wraps = $tabs = '';
	$multicats_array = rehub_get_compare_multicats();
	
	if($multicats_on =='1' && !empty($multicats_array)) {
		foreach($multicats_array as $multicat) {
			$pageid = (int)$multicat[2];
			$compare_url = (get_post_type($pageid) =='page' ) ? esc_url(get_the_permalink($pageid)) : esc_url(get_the_permalink($compare_page));
			$tabs .= '<li class="re-compare-tab-'. $pageid .'" data-page="'. $pageid .'" data-url="'. $compare_url .'">'. $multicat[1] .' (<span>0</span>)</li>'; 
			$wraps .= '<div class="re-compare-wrap re-compare-wrap-'. $pageid .'"></div>';
		}
	}
	?>
		<div id="re-compare-bar" class="from-right">
			<div id="re-compare-bar-wrap">
				<div id="re-compare-bar-heading">
					<h5 class="rehub-main-color"><?php _e('Compare items', 'rehub_framework');?><i class="fa fa-times-circle closecomparepanel floatright" aria-hidden="true"></i></h5>
				</div>
				<div id="re-compare-bar-tabs">
					<?php if($multicats_on =='1') : ?>
						<ul><?php echo $tabs; ?></ul>
						<div><?php echo $wraps; ?></div>
					<?php else : ?>
						<ul class="rhhidden"><li class="re-compare-tab-<?php echo $compare_page; ?> no-multicats" data-page="<?php echo $compare_page; ?>" data-url="<?php echo esc_url(get_the_permalink($compare_page)); ?>"><?php _e('Total', 'rehub_framework');?> (<span>0</span>)</li></ul>
						<div><div class="re-compare-wrap re-compare-wrap-<?php echo $compare_page; ?>"></div></div>
					<?php endif; ?>
					<span class="re-compare-destin wpsm-button rehub_main_btn" data-compareurl=""><?php _e('Compare', 'rehub_framework');?><i class="fa fa-arrow-circle-right" aria-hidden="true"></i></span>
				</div>
			</div>
		</div>
		<?php if(rehub_option('compare_disable_button') != 1):?>
			<div id="re-compare-icon-fixed" class="rhhidden">
				<?php echo rh_compare_icon(array());?>
			</div>
		<?php endif;?>
	<?php 
}
add_action('wp_footer', 'rehub_comparepanel_footer');


/*PANEL VIEW*/
if (!function_exists('re_compare_item_in_panel')) {
	function re_compare_item_in_panel($compareid) {	
		$image_id = get_post_thumbnail_id($compareid);  
		$image_url = wp_get_attachment_image_src($image_id,'thumbnail');  
		$img = $image_url[0];				
		$nothumb = get_template_directory_uri() . '/images/default/noimage_100_70.png';
		$imgparams = array('height' => 43, 'crop' => false);
		$compare_title = get_the_title($compareid); 
		//$close_class = (rehub_option('compare_multicats_toggle') == 1) ? 're-compare-new-close' : 're-compare-close';
		$compare_title_truncate = rehub_truncate_title(55, $compareid);		
		$out = '<div class="re-compare-item compare-item-'.$compareid.'" data-compareid="'.$compareid.'">';	
			$out .= '<i class="fa fa-times-circle re-compare-new-close"></i>';
			$out .= '<div class="re-compare-img">';
				$out .= '<a href="'.get_the_permalink($compareid).'">';
                    if(!empty($img)) :
                        $out .= '<img src="'.bfi_thumb( $img, $imgparams).'" alt="'.$compare_title.'" />';
                    else :   
                        $out .= '<img src="'.$nothumb.'" alt="'.$compare_title.'" />';
                    endif; 					
				$out .= '</a>';
			$out .= '</div>';
			$out .= '<div class="re-compare-title">';
				$out .= '<a href="'.get_the_permalink($compareid).'">'; 
                    $out .= $compare_title_truncate; 					
				$out .= '</a>';
			$out .= '</div>';				
		$out .= '</div>';
		
		return $out;
	}
}

if( !function_exists('re_compare_panel') ) {
function re_compare_panel($echo=''){
	$content = $count = $post_ids_arr = $comparing = $pageids = $total_comparing_ids = array();	
	$multicats_on = rehub_option('compare_multicats_toggle');
	$multicats_array = rehub_get_compare_multicats();
	$total_count = 0;
	
	#user identity
	$ip = rehub_get_ip();
	$userid = get_current_user_id();
	$userid = empty($userid) ? $ip : $userid;
	
	if($multicats_on =='1' && !empty($multicats_array)) {
		foreach( $multicats_array as $multicat ){
			$page_id = (int)$multicat[2];
			$out = '';
			#existing posts
			$post_ids = esc_html(get_transient('re_compare_'. $page_id .'_' . $userid));
			if(empty($post_ids)) {
				continue;
			} else {
				$post_ids_arr = explode(',', $post_ids);
				$count[$page_id] = count( $post_ids_arr );
				$total_count += count( $post_ids_arr );
			}
			foreach($post_ids_arr as $compareid) {
				$out .= re_compare_item_in_panel( $compareid );
			}
			$content[$page_id] = $out;
			$comparing[$page_id] = implode(',', $post_ids_arr);
			$pageids[] = $page_id;
			$total_comparing_ids = $post_ids_arr;
		}
	} else {
		$post_ids = esc_html(get_transient('re_compare_' . $userid));
		$page_id = rehub_option('compare_page');
		$out = '';
		if(!empty($post_ids)) {
			$post_ids_arr = explode(',',$post_ids);
			$count[$page_id] = count( $post_ids_arr );
			$total_count = $count[$page_id];
		}
		foreach($post_ids_arr as $compareid) {
			$out .= re_compare_item_in_panel($compareid);
		}
		$content[$page_id] = $out;
		$comparing[$page_id] = implode(',', $post_ids_arr);
		$pageids[] = $page_id;
		$total_comparing_ids = $post_ids_arr;
	}
	$cssactive = empty($count) ? '' : 'active';
	#generate the response
	if($echo=='count'){
		return $total_count;
	}
	$response = json_encode( array( 'content' => $content, 'cssactive' => $cssactive, 'comparing' => $comparing, 'count' => $count, 'total_count' => $total_count, 'pageids' => $pageids, 'total_comparing_ids'=> $total_comparing_ids ) );
	#response output
	header( "Content-Type: application/json" );
	echo $response;
	exit;
}
}
add_action('wp_ajax_re_compare_panel', 're_compare_panel');
add_action('wp_ajax_nopriv_re_compare_panel', 're_compare_panel');

/*COMPARE AJAX*/
if(!function_exists('re_add_compare')) {	
#compare toggling
function re_add_compare() {
	$post_ids_arr = array();	
	$multicats_on = rehub_option('compare_multicats_toggle');
	$multicats_array = rehub_get_compare_multicats();
	$out = '';
	$compareid = (int)$_POST['compareID'];
	$perform = $_POST['perform'];
	
	#user identity
	$ip = rehub_get_ip();
	$userid = get_current_user_id();
	$userid = empty($userid) ? $ip : $userid;
	
	if($multicats_on =='1' && !empty($multicats_array)) {
		foreach( $multicats_array as $multicat ){
			$cat_ids = $multicat[0];
			$cat_ids_arr = explode(',', $cat_ids);
			
			if( isset($multicat[3]) ) {
				$term_slug = $multicat[3];
			} else {
				$term_slug = 'category';
			}
			#check if post belongs to listed terms / categories
			if(isset($checkterm) && $checkterm == $term_slug){
			  //do nothing 
			}else{
			  $post_terms = wp_get_post_terms($compareid, $term_slug, array("fields" => "ids"));
			}
			$checkterm = $term_slug;
			$post_in_cat = array_intersect($post_terms, $cat_ids_arr);
			
			if(array_filter($post_in_cat)) {
				$page_id = (int)$multicat[2];
				#existing posts
				$post_ids = get_transient('re_compare_'. $page_id .'_' . $userid);
				switch($perform) {
					case 'add':
						if(empty($post_ids)) {
							$post_ids_arr[] = $compareid;
							set_transient('re_compare_'. $page_id .'_' . $userid, $compareid, 30 * DAY_IN_SECONDS);
						} else {
							$post_ids_arr = explode(',', $post_ids);
							if (($key = array_search($compareid, $post_ids_arr)) === false){
								$post_ids_arr[] = $compareid;
								$newvalue = implode(',', $post_ids_arr);
								set_transient('re_compare_'. $page_id .'_' . $userid, $newvalue, 30 * DAY_IN_SECONDS);
							}
						}
					break;
					case 'remove':
						$post_ids_arr = explode(',', $post_ids);
						if(($key = array_search($compareid, $post_ids_arr)) !== false) {
							unset($post_ids_arr[$key]);
						}
						$newvalue = implode(',', $post_ids_arr);
						if (empty($newvalue)) {
							delete_transient('re_compare_'. $page_id .'_' . $userid);
						} else {
							set_transient('re_compare_'. $page_id .'_' . $userid, $newvalue, 30 * DAY_IN_SECONDS);
						}
					break;	
				}
				#html output
				$out = re_compare_item_in_panel($compareid);
				$count = count($post_ids_arr);
				$comparing_string = implode(',', $post_ids_arr);
			}
		}
	} else {
		$post_ids = get_transient('re_compare_' . $userid);
		switch($perform) {
			case 'add':
				if(empty($post_ids)) {
					$post_ids_arr[] = $compareid;
					set_transient('re_compare_' . $userid, $compareid, 30 * DAY_IN_SECONDS);
				} else {
					$post_ids_arr = explode(',',$post_ids);
					if (($key = array_search($compareid, $post_ids_arr)) === false){
						$post_ids_arr[] = $compareid;
						$newvalue = implode(',', $post_ids_arr);
						set_transient('re_compare_' . $userid, $newvalue, 30 * DAY_IN_SECONDS);
					}
				}
			break;
			case 'remove':
				$post_ids_arr = explode(',', $post_ids);
				if(($key = array_search($compareid, $post_ids_arr)) !== false) {
					unset($post_ids_arr[$key]);
				}
				$newvalue = implode(',',$post_ids_arr);
				if (empty($newvalue)) {
					delete_transient('re_compare_' . $userid);
				}
				else {
					set_transient('re_compare_' . $userid, $newvalue, 30 * DAY_IN_SECONDS);
				}
			break;	
		}
		#html output
		$out = re_compare_item_in_panel($compareid);
		$count = count($post_ids_arr);
		$comparing_string = implode(',', $post_ids_arr);
		$page_id = rehub_option('compare_page');
	}
		
	#generate the response
	$response = json_encode( array( 'content' => $out, 'comparing' => $comparing_string, 'count' => $count, 'pageid' => $page_id ) );

	#response output
	header( "Content-Type: application/json" );
	echo $response;
	exit;
}
}
add_action('wp_ajax_re_add_compare', 're_add_compare');
add_action('wp_ajax_nopriv_re_add_compare', 're_add_compare');