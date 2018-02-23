<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php

//////////////////////////////////////////////////////////////////
// Quick get and show video thumbnail and embed by url
//////////////////////////////////////////////////////////////////
if( !function_exists('parse_video_url') ) {
function parse_video_url($url,$return='embed',$width='',$height='',$rel=0){
    $urls = parse_url($url);

    //url is http://vimeo.com/xxxx
    if($urls['host'] == 'vimeo.com'){
        $vid = ltrim($urls['path'],'/');
    }
    //url is http://youtu.be/xxxx
    else if($urls['host'] == 'youtu.be'){
        $yid = ltrim($urls['path'],'/');
    }
    //url is http://www.youtube.com/embed/xxxx
    else if(strpos($urls['path'],'embed') == 1){
        $yid = end(explode('/',$urls['path']));
    }
     //url is xxxx only
    else if(strpos($url,'/')===false){
        $yid = $url;
    }
    //http://www.youtube.com/watch?feature=player_embedded&v=m-t4pcO99gI
    //url is http://www.youtube.com/watch?v=xxxx
    else{
        parse_str($urls['query']);
        $yid = $v;
        if(!empty($feature)){
            $yid = end(explode('v=',$urls['query']));
            $arr = explode('&',$yid);
            $yid = $arr[0];
        }
    }
  if(isset($yid)) {
    
    //return embed iframe
    if($return == 'embed'){
        return '<iframe width="'.($width?$width:765).'" height="'.($height?$height:430).'" src="https://www.youtube.com/embed/'.$yid.'?rel='.$rel.'&enablejsapi=1" frameborder="0" ebkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';

    }
    //return normal thumb
    else if($return == 'thumb' || $return == 'thumbmed'){
        return '//i1.ytimg.com/vi/'.$yid.'/default.jpg';
    }
    //return hqthumb
    else if($return == 'hqthumb' ){
        return '//i1.ytimg.com/vi/'.$yid.'/hqdefault.jpg';
    }
    // else return id
    else{
        return $yid;
    }
  }
  else if($vid) {
	$oembed_endpoint = 'http://vimeo.com/api/oembed';
	$json_url = $oembed_endpoint . '.json?url=' . rawurlencode($url) . '&width=765'; 
	$vimeoObject = json_decode(@file_get_contents($json_url), true); 	
  	//$vimeoObject = json_decode(@file_get_contents("//vimeo.com/api/v2/video/".$vid.".json"));
   if (!empty($vimeoObject) && $vimeoObject !== FALSE) {
      //return embed iframe
      if($return == 'embed'){
      return '<iframe width="'.($width?$width:$vimeoObject['width']).'" height="'.($height?$height:$vimeoObject['height']).'" src="//player.vimeo.com/video/'.$vid.'?title=0&byline=0&portrait=0" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
    }
    //return normal thumb
    else if($return == 'thumb'){
      return $vimeoObject['thumbnail_url'];
    }
    //return medium thumb
    else if($return == 'thumbmed'){
      return str_replace('_640', '_340', $vimeoObject['thumbnail_url']);
    }
    //return hqthumb
    else if($return == 'hqthumb'){
      return $vimeoObject['thumbnail_url'];
    }
    // else return id
    else{
      return $vid;
    }
   }
  }
}
}


/**
 * Class: WPSM_video_class
 * Description: Get video info from youtube and Vimeo API, show playlist, parse id from urls, etc
 * ver: 1.0
 */

class WPSM_video_class {

	static function parse_videoid_from_url($url){
		$urlparse = parse_url($url);
		//url is http://vimeo.com/xxxx
	    if($urlparse['host'] == 'vimeo.com'){
	        $vid = ltrim($urlparse['path'],'/');
	    }
	    //url is http://youtu.be/xxxx
	    else if($urlparse['host'] == 'youtu.be'){
	        $vid = ltrim($urlparse['path'],'/');
	    }
	    //url is http://www.youtube.com/embed/xxxx
	    else if(strpos($urlparse['path'],'embed') == 1){
	        $vid = end(explode('/',$urlparse['path']));
	    }
	     //url is xxxx only
	    else if(strpos($url,'/')===false){
	        $vid = $url;
	    }
	    //http://www.youtube.com/watch?feature=player_embedded&v=m-t4pcO99gI
	    //url is http://www.youtube.com/watch?v=xxxx
	    else{
	        parse_str($urlparse['query']);
	        $vid = $v;
	        if(!empty($feature)){
	            $vid = end(explode('v=',$urlparse['query']));
	            $arr = explode('&',$vid);
	            $vid = $arr[0];
	        }
	    }
	    return $vid;
	}

	static function parse_videohost_from_url($url){
		$urlparse = parse_url($url);
		$videohost = '';
		if($urlparse['host'] == 'vimeo.com'){
			$videohost = 'vimeo';
		}
		elseif($urlparse['host'] == 'youtu.be' || $urlparse['host'] == 'youtube.com' || $urlparse['host'] == 'www.youtube.com' || $urlparse['host'] == 'www.youtu.be'){
			$videohost = 'youtube';
		}	
		return $videohost;

	}

	static function parse_videoid_from_urls($urls, $return = 'list'){
		$urls = array_map( 'trim', explode( ",", $urls ) );
		if (is_array($urls)){
			$returned_simple = $returned_andhosts = array();
			foreach ($urls as $url) {
				$videohost = self::parse_videohost_from_url($url);
				$id = self::parse_videoid_from_url($url);
				$returned_simple[] = $id;
				$returned_andhosts[$videohost][] = $id;
			}
			if($return =='list') {
				return implode (',', $returned_simple);
			}
			if($return =='arrayhost') {
				return $returned_andhosts;
			}			
			elseif($return =='array') {
				return $returned_simple;
			}
		}
	}

	static function embed_video_from_id($id, $host = 'youtube', $width='765', $height='430'){
		if ($host == 'youtube'){
			$embed = '<iframe width="'.$width.'" height="'.$height.'" src="https://www.youtube.com/embed/'.$id.'?enablejsapi=1" frameborder="0" ebkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
		}
		elseif( $host == 'vimeo'){
			$embed = '<iframe width="'.$width.'" height="'.$height.'" src="//player.vimeo.com/video/'.$id.'?title=1&byline=0&portrait=0" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
		} 
		return $embed;
	}	


	/**
	 * Pull information about multiple video ids
	 */
	static function api_get_videos_info( $video_ids, $list_type ) {
		switch ( $list_type ) {
			case 'youtube':
				return self::youtube_api_get_videos_info( $video_ids );
				break;
			case 'vimeo':
				return self::vimeo_api_get_videos_info( $video_ids );
				break;
		}
		return false;
	}

	/**
	 * Pull information about multiple youtube ids using just one api call to YT
	 */
	private static function youtube_api_get_videos_info( $video_ids ) {
		$video_ids_comma = implode( ',', $video_ids );
		$api_url = 'https://www.googleapis.com/youtube/v3/videos?id=' . $video_ids_comma . '&part=id,contentDetails,snippet&key=AIzaSyDO58Kz8-G4-TCxEe5D4QC-Sl68-8lbMAg';
		$json_api_response = rh_remote_http::get_page( $api_url, __CLASS__ );

		// check for a response
		if ( $json_api_response === false ) {
			return false;
		}

		// try to decode the json
		$api_response = @json_decode( $json_api_response, true );
		if ( $api_response === null and json_last_error() !== JSON_ERROR_NONE ) {
			return false;
		}
		
		$buffer_videos = array();

		if ( !empty( $api_response['items'] ) and is_array( $api_response['items'] ) ) {
			foreach ( $api_response['items'] as $video_item ) {
				// if no item id, skip
				if ( empty( $video_item['id'] ) ) {
					continue;
				}
				// duration hack for the strange youtube duration
				$duration = @$video_item['contentDetails']['duration'];
				if ( !empty( $duration ) ) {
					preg_match('/(\d+)H/', $duration, $match);
					$h = count($match) ? filter_var($match[0], FILTER_SANITIZE_NUMBER_INT) : 0;

					preg_match('/(\d+)M/', $duration, $match);
					$m = count($match) ? filter_var($match[0], FILTER_SANITIZE_NUMBER_INT) : 0;

					preg_match('/(\d+)S/', $duration, $match);
					$s = count($match) ? filter_var($match[0], FILTER_SANITIZE_NUMBER_INT) : 0;

					$duration = gmdate( "H:i:s", intval( $h * 3600 + $m * 60  + $s ) ); 

				}

				@$buffer_videos[$video_item['id']]= array( 
					'thumb' => 'http://img.youtube.com/vi/' . $video_item['id'] . '/default.jpg',
					'title' => $video_item['snippet']['title'],
					'time' => $duration,
					'host' => 'youtube',
				 );
			}
		}

		return $buffer_videos;
	}

	/**
	 * Pull information about multiple vimeo IDs but for each id it makes an api call
	 */
	private static function vimeo_api_get_videos_info( $video_ids ) {
		$buffer_videos = array();

		foreach ( $video_ids as $video_id ) {
			$api_url = 'http://vimeo.com/api/v2/video/' . $video_id . '.php';   // this is the old api vimeo maintained for thumbnail_small which should not be gotten without OAuth of the new api
			$php_serialized_api_response = rh_remote_http::get_page( $api_url, __CLASS__ );

			// check for a response
			if ( $php_serialized_api_response === false ) {
				continue; // try with the next one
			}

			// try to deserialize
			$api_response = @unserialize( $php_serialized_api_response );
			if ( $api_response === false ) {
				continue;
			}

			@$buffer_videos[$video_id]= array( 
				'thumb' => $api_response[0]['thumbnail_small'],
				'title' => $api_response[0]['title'],
				'time' => gmdate( "H:i:s", intval( $api_response[0]['duration'] ) ),
				'host' => 'vimeo',
			 );
		}


		// return false on no videos
		if ( !empty( $buffer_videos ) ) {
			return $buffer_videos;
		}
		return false;
	}

    static function render_generic( $atts, $list_type ){
 		wp_enqueue_style( 'video-pl' );
		wp_enqueue_script( 'video_playlist' );    	
        $block_uid = 'rh_uid_' . uniqid(); //update unique id on each render
        $out = ''; 
        $out .= '<div class="rh_block_wrap rh_block_video_playlist">';
	        $out .= '<div id=' . $block_uid . ' class="rh_block_inner">';
		        $out .= self::inner( $atts, $list_type );
	        $out .= '</div>';
        $out .= '</div><!-- ./block_video_playlist -->';
        return $out;
    }

	public static function get_video_data( $video_ids, $list_type ) {
		global $post;

		$list_name = 'youtube_ids'; //array key for youtube in the post meta db array

		if( $list_type != 'youtube' ) {
			$list_name = 'vimeo_ids'; //array key for vimeo in the post meta db array
		}

		// read the youtube and vimeo ids from the DB
		$rh_playlist_videos = get_post_meta( $post->ID, 'rh_playlist_video', true );

		// read the video ids from the shortcode
		if ( !empty( $video_ids ) ) {

			// get the video id's that are not in the cache
			$uncached_ids = array();
			
			foreach ( $video_ids as $video_id ) {
				if ( !isset( $rh_playlist_videos[$list_name][$video_id] ) ) {
					$uncached_ids []= $video_id;
				}
			}

			if ( !empty( $uncached_ids ) ) {
				// request data for the id's that are not in the cache
				$uncached_videos = self::api_get_videos_info( $uncached_ids, $list_type );
				
				// update the cache
				if ( $uncached_videos !== false ) {
					
					if ( empty( $rh_playlist_videos[$list_name] ) ) {
						$rh_playlist_videos[$list_name] = $uncached_videos;
					} else {
						$rh_playlist_videos[$list_name] = array_merge( $rh_playlist_videos[$list_name], $uncached_videos );
					}
					
					update_post_meta( $post->ID, 'rh_playlist_video', $rh_playlist_videos );
				}
			}

			// after we updated the cache with the missing videos (if any) we build our buffer of videos
			$buffer_array = array();
			foreach ( $video_ids as $video_id ) {
				if ( !empty( $rh_playlist_videos[$list_name][$video_id] ) ) {
					$buffer_array[$video_id] = $rh_playlist_videos[$list_name][$video_id];
				}
			}
			return $buffer_array;
		}
		return false;
	}

    public static function render_playlist( $atts, $list_type ) {

    	$idshosts = WPSM_video_class::parse_videoid_from_urls($atts['videolinks'], 'arrayhost');

    	if (!empty ($idshosts['youtube']) && $list_type == 'youtube') {
    		$video_ids = $idshosts['youtube'];
    	}
    	if (!empty ($idshosts['vimeo']) && $list_type == 'vimeo') {
    		$video_ids = $idshosts['vimeo'];
    	}

        if( $list_type == 'youtube' ) {
            $list_name = 'youtube_ids';
        } else {
            $list_name = 'vimeo_ids';
        }

	    // read the youtube and vimeo ids
	    $videos_meta = self::get_video_data( $video_ids, $list_type );



		if ( $videos_meta !== false ) {
	 		wp_enqueue_style( 'video-pl' );
			wp_enqueue_script( 'video_playlist' );    	
	        $block_uid = 'rh_uid_' . uniqid(); //update unique id on each render
	        $first_video_id = '';
	        $contor_first_video = 0;
	        $js_object = '';
	        $click_video_container = '';  
	        
	       	foreach( $videos_meta as $video_id => $video_data ) {

	            //take the id of first video
	            if( $contor_first_video == 0 ) { 
					$first_video_id = $video_id; 
				}
	            $contor_first_video++;

	            //add comma (,) for next value
	            if( !empty( $js_object ) ) {
					$js_object .= ',';
				}
	            $js_object .= "\n'rh_".$video_id."':{";

	            $video_data_propeties = '';

	            //get thumb
	            $playlist_structure_thumb = '';
	            if( !empty( $video_data['thumb'] ) ) {
	                $playlist_structure_thumb = '<div class="rh_video_thumb"><img src="' . $video_data['thumb'] . '" alt="" /></div>';
	            }

	            //get title
	            $playlist_structure_title = '<div class="rh_video_title_and_time">';
	            if( !empty( $video_data['title'] ) ) {
	                $playlist_structure_title .= '<div class="rh_video_title">' . mb_convert_encoding( $video_data['title'], 'UTF-8' ) . '</div>';
	                $video_data_propeties .= 'title:"' . esc_attr( mb_convert_encoding( $video_data['title'], 'UTF-8' ) ) . '",';
	            }

	            //get time
	            if( !empty( $video_data['time'] ) ){

	                $get_video_time = '';
	                if( substr( $video_data['time'], 0, 3 ) == '00:' ) {
	                    $get_video_time = substr( $video_data['time'], 3 );
	                } else {
	                    $get_video_time = $video_data['time'];
	                }

	                $playlist_structure_title .= '<div class="rh_video_time">' . $get_video_time . '</div>';
	                $video_data_propeties .= 'time:"' . $get_video_time . '"';
	            }
	            $playlist_structure_title .= '</div>';

	            $playlist_stop_control = '<div class="rh_video_stop_play_control"><span class="rh-sp-video-play rh_' . $list_type . '_control"></span></div>';

	            //creating click-able playlist video
	            $click_video_container .= '<div id="rh_' . $video_id . '" class="rh_click_video rh_click_video_' . $list_type . '"> ' . $playlist_stop_control . $playlist_structure_thumb . $playlist_structure_title . '</div>';

	            $js_object .= $video_data_propeties . "}";
	        }

	        if( !empty( $js_object ) ) {
	            $js_object = 'var rh_' . $list_type . '_list_ids = {' .$js_object. '}';
	        }

	        //creating column number classes
	        $column_number_class = 'rh_video_playlist_column_full';

	        if( !empty( $atts['playlist_width'] ) and $atts['playlist_width'] == 'stack' ) {
	            $column_number_class = 'rh_video_playlist_column_stack';
	        }

	        //autoplay
	        $rh_playlist_autoplay = 0;
	        $rh_class_autoplay_control = 'rh-sp-video-play';

	        if(  !empty( $atts['playlist_auto_play'] ) and $atts['playlist_auto_play'] == 1 ) {
	            $rh_playlist_autoplay = 1;
	        }

	        //check how many video ids we have; if there are more then 5 then add a class that is used on chrome to add the playlist scroll bar
	        $rh_class_number_video_ids = '';
	        $rh_playlist_video_count = count( $videos_meta );

	        if( intval( $rh_playlist_video_count ) > 4 ) {
	            $rh_class_number_video_ids = 'rh_add_scrollbar_to_playlist_for_mobile';
	        }

	        if( intval( $rh_playlist_video_count ) > 5 ) {
	            $rh_class_number_video_ids = 'rh_add_scrollbar_to_playlist';
	        }

	        $out = ''; 
	        $out .= '<div class="rh_block_wrap rh_block_video_playlist">';
		        $out .= '<div id=' . $block_uid . ' class="rh_block_inner">';
	            	//$js_object exists so we can take the string and parser as json to create an object in jQuery
	            	$out .= '<div class="' . $column_number_class . '">
	            				<div class="rh_wrapper_video_playlist">
	            					<div class="rh_wrapper_player rh_wrapper_playlist_player_' . $list_type . '" data-first-video="' . esc_attr( $first_video_id ) . '" data-autoplay="' . $rh_playlist_autoplay . '">
	                            		<div id="player_' . $list_type . '"></div>
	                       			</div>
	                       			<div class="rh_container_video_playlist">
	                            		<div id="rh_' . $list_type . '_playlist_video" class="rh_playlist_clickable ' . $rh_class_number_video_ids . '">' . $click_video_container . '</div>
	                        		</div>
	                    		</div>
	                    	</div>
	                    	<script>' . $js_object . '</script>';
		        $out .= '</div>';
	        $out .= '</div><!-- ./block_video_playlist -->';	    

	        return $out;
        }
        else {return '';}    
    }	

}