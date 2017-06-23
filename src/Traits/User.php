<?php

namespace Lipe\Lib\Traits;

trait User {

	/**
	 * user_id
	 *
	 * @var int
	 */
	public $user_id = null;

	/**
	 * user
	 *
	 * @var \WP_User
	 */
	private $user;


	public function __construct( $user_id = null ) {
		if( $user_id === null ){
			$user_id = get_current_user_id();
		}
		$this->user_id = $user_id;
	}


	public function get_user() {
		if( empty( $this->user ) ){
			$this->user = get_user_by( 'id', $this->user_id );
		}

		return $this->user;
	}

}