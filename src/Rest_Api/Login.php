<?php

namespace Lipe\Lib\Rest_Api;

use Lipe\Lib\Traits\Singleton;

/**
 * Login to the Rest Api via standard authentication.
 *
 * @notice on fast cgi install, this must be in the .htaccess for this to work
 *
 * ## To allow our rest api authentication to work on fast cgi installs
 * <IfModule mod_fcgid.c>
 * RewriteCond %{HTTP:Authorization} .
 * RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
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
			'methods'  => 'POST',
			'callback' => [ $this, 'basic_auth_handler' ],
		] );
	}


	/**
	 * Use a token to authenticate for this request only
	 * Call the api endpoints like normal just pass this header
	 * You get the token by sending a request to $this->basic_auth_handler
	 *
	 * Authorization : Bearer $token
	 *
	 * @see $this->basic_auth_handler
	 *
	 * @param null|\WP_User $user
	 *
	 *
	 * @return \WP_User
	 */
	public function login_via_token( $user ) : ?\WP_User {
		$token = $this->get_token_from_header();
		if ( ! empty( $token ) ) {
			$user_id = Auth_Table::instance()->get_user( $token );
			if ( null !== $user_id ) {
				return new \WP_User( $user_id );
			}
		}

		return $user;
	}


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
	 * Authorization : Basic base64_encode( $username . ':' . $password )
	 *
	 *
	 * @notice For fast cgi installs this must be added to .htaccess
	 *
	 * ## To allow our rest api authentication to work on fast cgi installs
	 * <IfModule mod_fcgid.c>
	 * RewriteCond %{HTTP:Authorization} .
	 * RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
	 * </IfModule>
	 *
	 *
	 * @see    $this->login_via_token()
	 *
	 * @param \WP_REST_Request $request
	 *
	 * @return \WP_Error|\WP_REST_Response|\WP_User
	 */
	public function basic_auth_handler( \WP_REST_Request $request ) {
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
