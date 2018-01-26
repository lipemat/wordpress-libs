<?php

namespace Lipe\Lib\User;

use Lipe\Lib\Meta\Meta_Repo;

/**
 * Trait User_Trait
 *
 * @package Lipe\Lib\User
 * @since 1.0.0
 */
trait User_Trait {

	/**
	 * user_id
	 *
	 * @var int
	 */
	protected $user_id;

	/**
	 * user
	 *
	 * @var \WP_User
	 */
	protected $user;


	/**
	 * User_Trait constructor.
	 *
	 * @param null|int $user_id
	 */
	public function __construct( $user_id = null ) {
		if( null === $user_id ){
			$user_id = get_current_user_id();
		}
		$this->user_id = $user_id;
	}

	public function get_user_id(){
		return $this->user_id;
	}

	public function get_user() {
		if( null === $this->user ){
			$this->user = get_user_by( 'id', $this->user_id );
		}

		return $this->user;
	}


	/**
	 *
	 * @param string $key
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function get_meta( string $key ) {
		return Meta_Repo::instance()->get_meta( $this->user_id, $key, 'user' );
	}


	/**
	 *
	 * @param int $user_id
	 *
	 * @static
	 *
	 * @return static
	 */
	public static function factory( $user_id ) {
		return new static( $user_id );
	}

}
