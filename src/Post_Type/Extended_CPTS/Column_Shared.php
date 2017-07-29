<?php

namespace Lipe\Lib\Post_Type\Extended_CPTS;

/**
 * Column_Shared
 *
 * @author  Mat Lipe
 * @since   7/29/2017
 *
 * @package Lipe\Lib\Post_Type\Extended_CPTS
 */
class Column_Shared {
	protected $column;

	protected $args;


	/**
	 * Column_Shared constructor.
	 *
	 * @param \Lipe\Lib\Post_Type\Extended_CPTS\Column $column
	 * @param array                                    $args
	 */
	function __construct( Column $column, array $args ) {
		$this->args = $args;
		$this->column = $column;
	}


	/**
	 * Make this column the default sort column instead
	 * of the default 'title'
	 *
	 * @param string $direction - 'ASC', 'DESC' (default 'ASC' )
	 *
	 * @return void
	 */
	public function set_as_default_sort_column( $direction = 'ASC' ) {
		$this->column->set( [ 'default' => $direction ] );
	}


	/**
	 * Any column can be restricted so it's only shown to users
	 * with a given capability by using the cap parameter:
	 *
	 * @param  string $capability
	 *
	 * @example 'manage_options'
	 *
	 * @return void
	 */
	public function column_capability( $capability ) {
		$this->column->set( [ 'cap' => $capability ] );
	}


	/**
	 * Additionally, just the output of any column can be restricted so
	 * it's only shown to users with a given capability for the current row's post
	 * by using the post_cap parameter.
	 *
	 * The column will be shown to all users,
	 * but the value for each row will only be shown to users with the capability
	 * when applied to the row's post.
	 *
	 * @param string $capability
	 *
	 * @example 'edit_post'
	 *
	 * @return void
	 */
	public function post_capability( $capability ) {
		$this->column->set( [ 'post_cap' => $capability ] );
	}

}