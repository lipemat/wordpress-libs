<?php

namespace Lipe\Lib\CMB2;

/**
 * User_Box
 *
 * @author  Mat Lipe
 * @since   7/28/2017
 *
 * @package Lipe\Lib\CMB2
 */
class User_Box extends Box {
	/**
	 * Will determine where fields are output in the new-user screen.
	 * Options are 'add-existing-user' and 'add-new-user'.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Box-Properties#new_user_section
	 *
	 * @default 'add-new-user'
	 * @example 'add-existing-user'
	 *
	 * @var string
	 */
	public $new_user_section;


	/**
	 * User_Box constructor.
	 *
	 * @param string $id
	 * @param string $title
	 */
	public function __construct( $id, $title ) {
		parent::__construct( $id, [ 'user' ], $title );
	}
}