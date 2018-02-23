<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php
/**
 * Class: rh_remote_http
 * Description: it exports the get_page method. Is used to retrieve remote information.
 * ver: 1.0
 */

class rh_remote_http {

	const http_request_timeout = 10;
	const run_test_on_fail_after = 10; // if all channels failed, run the test again after 2 hours

	/**
	 * @var array the supported channels.
	 */
	private static $get_url_channels = array (
		'wordpress',
		'file_get_contents',
		'curl'
	);

	static function get_page( $url, $caller_id = '' ) {
		$rh_remote_http = get_option( 'rh_remote_http' );

		// see if we have a manual channel
		if ( !empty( $rh_remote_http['manual_channel'] ) ) {
			return self::get_page_via_channel( $url, $caller_id, $rh_remote_http['manual_channel'] );
		}

		// check if the test ran
		if ( isset( $rh_remote_http['test_status'] ) ) {

			if ( $rh_remote_http['test_status'] == 'all_fail' ) {
				// all the tests fail, see if the requiered time passed to run all of them again
				if ( time() - $rh_remote_http['test_time'] > self::run_test_on_fail_after ) {

					$channel_that_passed = '';
					$test_result = self::run_test( $url, $caller_id, $channel_that_passed );

					$rh_remote_http['test_time'] = time(  );
					if ( $test_result !== false ) {

						$rh_remote_http['test_status'] = $channel_that_passed;
						update_option( 'rh_remote_http', $rh_remote_http ); // save new status
						return $test_result;

					} else {

						// all tests failed
						$rh_remote_http['test_status'] = 'all_fail';
						update_option( 'rh_remote_http', $rh_remote_http ); // save new status
						return false;
					}
				} else {
					return false; // no working channels, and we have to wait more
				}
			} else {
				// we have a channel that passed in test_status
				return self::get_page_via_channel( $url, $caller_id, $rh_remote_http['test_status'] );
			}

		} else {
			// the test was not run
			$channel_that_passed = '';
			$test_result = self::run_test( $url, $caller_id, $channel_that_passed );

			$rh_remote_http['test_time'] = time();
			if ( $test_result !== false ) {
				$rh_remote_http['test_status'] = $channel_that_passed;
				update_option( 'rh_remote_http', $rh_remote_http );
				return $test_result;
			} else {
				// all tests failed
				$rh_remote_http['test_status'] = 'all_fail';
				update_option( 'rh_remote_http', $rh_remote_http );
				return false;
			}
		}
	}

	
	/**
	 * Tries to download a page by trying each chanel one by one.
	 */
	private static function run_test( $url, $caller_id = '', &$channel_that_passed ) {
		foreach ( self::$get_url_channels as $channel ) {
			$response = self::get_page_via_channel( $url, $caller_id, $channel );
			if ( $response !== false ) {
				$channel_that_passed = $channel;
				return $response;
			}
		}
		
		return false;
	}

	/**
	 * Returns a page's HTML by using a specific channel
	 */
	private static function get_page_via_channel( $url, $caller_id = '', $channel ) {
		switch ( $channel ) {
			case 'wordpress':
				return self::get_url_wordpress( $url, $caller_id );
			break;

			case 'file_get_contents':
				return self::get_url_file_get_contents( $url, $caller_id );
			break;

			case 'curl':
				return self::get_url_curl( $url, $caller_id );
			break;
		}

		return false;
	}

	/**
	 * WordPress download channel
	 */
	private static function get_url_wordpress( $url, $caller_id = '' ) {
		$response = wp_remote_get( $url, array(
			'timeout' => self::http_request_timeout,
			'sslverify' => false,
			'user-agent' => 'Mozilla/5.0 ( Windows NT 6.3; WOW64; rv:35.0 ) Gecko/20100101 Firefox/35.0'
		) );

		if ( is_wp_error( $response ) ) {
			return false;
		}

		$rh_request_result = wp_remote_retrieve_body( $response );
		if ( $rh_request_result == '' ) {
			return false;
		}
		return $rh_request_result;
	}

	/**
	 * file_get_contents download channel
	 */
	private static function get_url_file_get_contents( $url, $caller_id = '' ) {

		$opts = array(
			'http'=>array(
				'method' => "GET",
				'timeout' => self::http_request_timeout,
				'ignore_errors' => true,
				'header' => "Accept-language: en\r\n" .
				            "User-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64; rv:35.0) Gecko/20100101 Firefox/35.0\r\n"
			) );
		
		$context = stream_context_create( $opts );
		$rh_data = @file_get_contents( $url, false, $context );

		if ( $rh_data === false ) {
			return false;
		}

		if ( empty( $rh_data ) ) {
			return false;
		} else {
			return $rh_data;
		}
	}

	/**
	 * curl download channel
	 */
	private static function get_url_curl( $url, $caller_id = '' ) {
		//return false;
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
		curl_setopt( $ch, CURLOPT_MAXREDIRS, 3 );
		curl_setopt( $ch, CURLOPT_ENCODING, '' );
		curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, self::http_request_timeout ); //Fail if a web server doesn’t respond to a connection within a time limit (seconds).
		curl_setopt( $ch, CURLOPT_TIMEOUT, self::http_request_timeout ); //Fail if a web server doesn’t return the web page within a time limit (seconds).
		curl_setopt( $ch, CURLOPT_HEADER, false );
		curl_setopt( $ch, CURLOPT_AUTOREFERER, true ); //When following redirects, set this to true and CURL automatically fills in the URL of the page being redirected away from.
		curl_setopt( $ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0' );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
		$data = curl_exec( $ch );

		//error checking
		if ( $data === false ) {
			curl_close( $ch );
			return false;
		}

		curl_close( $ch );

		return $data;
	}

}