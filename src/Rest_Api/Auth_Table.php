<?php

namespace Lipe\Lib\Rest_Api;

use Lipe\Lib\Schema\Db;
use Lipe\Lib\Traits\Singleton;

/**
 * @link https://make.wordpress.org/core/2020/11/05/application-passwords-integration-guide/
 *
 * @deprecated in favor of native WP Rest Auth.
 *
 */
class Auth_Table extends Db {
	use Singleton;

	public const NAME = 'auth';

	public const DB_VERSION = 1;
	protected const ID_FIELD = 'id';


	/**
	 * @link https://make.wordpress.org/core/2020/11/05/application-passwords-integration-guide/
	 *
	 * @deprecated in favor of native WP Rest Auth.
	 */
	public function __construct() {
		_deprecated_constructor( __CLASS__, '2.23.3' );
		parent::__construct();
	}


	public const COLUMNS = [
		'id'      => '%d',
		'user_id' => '%d',
		'token'   => '%s',
		'expires' => '%s',
	];

	public function get_user( $token ) {
		global $wpdb;
		$expires = gmdate( 'Y-m-d H:i:s' );
		$token   = wp_hash( $token );

		$sql = "SELECT user_id FROM $this->table WHERE `token` = '$token' AND `expires` > '$expires'";

		return $wpdb->get_var( $sql ); // phpcs:ignore
	}


	public function add_token( $columns ) {
		$columns['token'] = wp_hash( $columns['token'] );
		$this->add( $columns );
		$this->clean_expired_tokens();
	}


	/**
	 * Runs when a new one is added
	 * to clean out expired tokens
	 *
	 * @see $this->add_token();
	 *
	 * @return false|int
	 */
	public function clean_expired_tokens() {
		global $wpdb;
		$expires = gmdate( 'Y-m-d H:i:s' );
		$sql     = "DELETE FROM $this->table WHERE `expires` < '$expires'";

		return $wpdb->query( $sql ); // phpcs:ignore
	}


	protected function create_table() : void {
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		dbDelta( 'CREATE TABLE IF NOT EXISTS ' . $this->table . ' (
	  id BIGINT(50) NOT NULL AUTO_INCREMENT,
	  user_id BIGINT(20) NOT NULL,
	  token VARCHAR(50) NOT NULL,
      expires TIMESTAMP NOT NULL,
      PRIMARY KEY (id),
      UNIQUE KEY auth_tokens (token, expires)
	  );' );
	}
}
