<?php

namespace Lipe\Lib\User;

use Lipe\Lib\Meta\Mutator_Trait;

/**
 * Trait User_Trait
 *
 * @package Lipe\Lib\User
 * @since   1.0.0
 */
trait User_Trait {
	use Mutator_Trait;

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
		if ( null === $user_id ) {
			$user_id = get_current_user_id();
		}
		$this->user_id = $user_id;
	}


	public function get_id() : int {
		return (int) $this->user_id;
	}


	/**
	 * @deprecated
	 *
	 * @return int
	 */
	public function get_user_id() : int {
		\_deprecated_function( 'get_user_id', '2.5.0', 'get_id' );

		return $this->get_id();
	}


	public function get_user() {
		if ( null === $this->user ) {
			$this->user = get_user_by( 'id', $this->user_id );
		}

		return $this->user;
	}


	public function get_meta_type() : string {
		return 'user';
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
