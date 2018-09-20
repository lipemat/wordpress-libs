<?php

namespace Lipe\Lib\Post_Type\Extended_CPTS;

/**
 * Column_Shared
 *
 * @author  Mat Lipe
 * @since   7/29/2017
 *
 * @package Lipe\Lib\Post_Type\Custom_Post_Type_Extended
 */
class Column_Shared extends Shared_Abstract {
	protected $column;

	/**
	 * For possible future use
	 *
	 * @var array
	 */
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
	 *
	 * @param array $args
	 *
	 * @return \Lipe\Lib\Post_Type\Extended_CPTS\Column_Shared
	 */
	protected function return( array $args ) {
		$this->column->set( $args );
		return $this;
	}


	/**
	 * Make this column the default sort column instead
	 * of the default 'title'
	 *
	 * @param string $direction - 'ASC', 'DESC' (default 'ASC' )
	 *
	 * @return \Lipe\Lib\Post_Type\Extended_CPTS\Column_Shared
	 */
	public function set_as_default_sort_column( $direction = 'ASC' ) {
		return $this->return( [ 'default' => $direction ] );
	}


	/**
	 * Make a column sortable
	 * Most columns are by default
	 *
	 * @notice feature_image can not be sortable
	 *
	 * @param bool $is_sortable - (default to false);
	 *
	 * @return \Lipe\Lib\Post_Type\Extended_CPTS\Column_Shared
	 */
	public function sortable( $is_sortable = false ) {
		return $this->return( [ 'sortable' => $is_sortable ] );
	}


	/**
	 * Any column can be restricted so it's only shown to users
	 * with a given capability by using the cap parameter:
	 *
	 * @param  string $capability
	 *
	 * @example 'manage_options'
	 *
	 * @return \Lipe\Lib\Post_Type\Extended_CPTS\Column_Shared
	 */
	public function column_capability( $capability ) {
		return $this->return( [ 'cap' => $capability ] );
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
	 * @return \Lipe\Lib\Post_Type\Extended_CPTS\Column_Shared
	 */
	public function post_capability( $capability ) {
		return $this->return( [ 'post_cap' => $capability ] );
	}

}