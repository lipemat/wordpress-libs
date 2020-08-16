<?php

namespace Lipe\Lib\Rest_Api;

use Lipe\Lib\Traits\Singleton;

/**
 * Login to the Rest Api via standard authentication.
 *
 * @notice on fast cgi install, this must be in the .htaccess for this to work
 * ### HTTP Basic Authorization for REST api
 * <IfModule mod_fcgid.c>
 * CGIPassAuth on
 * </IfModule>
 *
 * @notice DO NOT use this if you are not on https!
 *
 * @see    Auth_Table
 * @see    _Login.md
 */
class Login {
	use Singleton;


	public function hook() : void {
		add_filter( 'determine_current_user', [ $this, 'login_via_token' ], 20 );
		add_action( 'rest_api_init', [ $this, 'register_routes' ], 10 );
	}


	public function register_routes() : void {
		register_rest_route( 'auth/v1', '/login/', [
			'methods'             => 'POST',
			'callback'            => [ $this, 'basic_auth_handler' ],
			'permission_callback' => '__return_true',
		] );
	}


	/**
	 * Use a token to authenticate for this request only
	 * Call the api endpoints like normal just pass this header
	 * You get the token by sending a request to $this->basic_auth_handler
	 *
	 * @param false|\WP_User $user
	 *
	 * @see $this->basic_auth_handler
	 *
	 * @return false|\WP_User
	 */
	public function login_via_token( $user ) {
		$token = $this->get_token_from_header();
		if ( ! empty( $token ) ) {
			$user_id = Auth_Table::instance()->get_user( $token );
			if ( null !== $user_id ) {
				return new \WP_User( $user_id );
			}
		}

		return $user;
	}


	/**
	 * Get token from Bearer header.
	 *
	 * Authorization : Bearer $token
	 *
	 * @return mixed|null
	 */
	private function get_token_from_header() {
		$headers = null;
		// phpcs:disable
		if ( isset( $_SERVER['Authorization'] ) ) {
			$headers = trim( $_SERVER['Authorization'] );
		} elseif ( isset( $_SERVER['HTTP_AUTHORIZATION'] ) ) {
			$headers = trim( $_SERVER['HTTP_AUTHORIZATION'] );
		} elseif ( function_exists( 'apache_request_headers' ) ) {
			$apache_headers = apache_request_headers();
			$apache_headers = array_combine( array_map( 'ucwords', array_keys( $apache_headers ) ), array_values( $apache_headers ) );
			if ( isset( $apache_headers['Authorization'] ) ) {
				$headers = trim( $apache_headers['Authorization'] );
			}
		}
		// phpcs:enable

		if ( null !== $headers && preg_match( '/Bearer\s(\S+)/', $headers, $matches ) ) {
			return $matches[1];
		}

		return null;
	}


	/**
	 * Get a token for a user using basic auth
	 * Then use it against $this->login_via_token()
	 *
	 * /wp-json/auth/v1/login
	 *
	 * Headers required to login:
	 * PHP -> Authorization : Basic base64_encode( $username . ':' . $password )
	 * JS -> Authorization: 'Basic ' + btoa( auth.user + ':' + auth.password )
	 *
	 * @notice For fast cgi installs this must be added to .htaccess
	 * ### HTTP Basic Authorization for REST api
	 * <IfModule mod_fcgid.c>
	 * CGIPassAuth on
	 * </IfModule>
	 *
	 * @see    $this->login_via_token()
	 *
	 * @return \WP_Error|\WP_REST_Response|\WP_User
	 */
	public function basic_auth_handler() {
		//!! if this is not set @see this methods php docs for fastcgi !!
		if ( ! isset( $_SERVER['PHP_AUTH_USER'] ) ) {
			return new \WP_Error( 'no_user', __( 'No User Passed', 'lipe' ), [ 'status' => 201 ] );
		}

		$user = wp_authenticate( $_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'] ); //phpcs:ignore

		if ( is_wp_error( $user ) ) {
			return $user;
		}

		return $this->get_valid_authenticated_response( $user );
	}


	/**
	 * If we have a valid use vid an authentication method
	 * add a token to the DB and setup return data
	 *
	 * @param \WP_User $user
	 *
	 * @return \WP_REST_Response
	 */
	private function get_valid_authenticated_response( $user ) : \WP_REST_Response {
		$columns = [
			'user_id' => $user->ID,
			'token'   => wp_hash_password( $user->user_email . time() ),
			'expires' => gmdate( 'Y-m-d H:i:s', strtotime( '+1 week' ) ),
		];
		Auth_Table::instance()->add_token( $columns );

		$response = new \WP_REST_Response( $columns );
		$response->set_status( 200 );

		return $response;
	}

}
