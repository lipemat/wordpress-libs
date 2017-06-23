<?php

namespace Lipe\Lib\Traits;

use Lipe\Lib\Schema\Custom_Post_Type;

trait Cpt {

	/**
	 * @var \Lipe\Lib\Schema\Custom_Post_Type $cpt
	 */
	private static $cpt;

	public $post_id;

	/**
	 * post
	 *
	 * @var \WP_Post
	 */
	private $post;


	public function __construct( $id ) {
		$this->post_id = $id;
	}


	/**
	 * register_post_type
	 *
	 * @static
	 *
	 * @uses \MVC\Custom_Post_Type
	 *
	 * @return void
	 */
	public static function register_post_type() {
		self::$cpt = new Custom_Post_Type( self::NAME );
	}


	/**
	 *
	 * @param int $post_id
	 *
	 * @static
	 *
	 * @return self()
	 */
	public static function factory( $post_id ) {
		return new self( $post_id );
	}


	/********* static *******************/

	public function __get( $name ) {
		return $this->{$name} = $this->get_post()->{$name};
	}


	/**
	 * Get the WP post from current context
	 *
	 * @return null|\WP_Post
	 */
	public function get_post() {
		if( empty( $this->post ) ){
			$this->post = get_post( $this->post_id );
		}

		return $this->post;
	}


	public function get_id() {
		return $this->post_id;
	}

}