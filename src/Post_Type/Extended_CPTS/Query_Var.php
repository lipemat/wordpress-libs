<?php

namespace Lipe\Lib\Post_Type\Extended_CPTS;

use Lipe\Lib\Post_Type\Custom_Post_Type_Extended;

/**
 * Extended CPTs provides a mechanism for registering public query vars,
 * which allow users to filter your post type archives by various fields.
 * This also works in WP_Query,
 * although the main advantage is the fact these are public query vars
 * accessible via URL parameters.
 *
 * Think of these as the front-end equivalent of list table filters in the admin area,
 * minus the UI.
 *
 * It also allows you to filter posts in WP_Query.
 *
 * @example new WP_Query(array(
 * 'post_type' => 'article',
 * $query_var    => 'bar',
 * ) );
 *
 * @example test.loc/articles/?{$query_var}=bar
 *
 * @link    https://github.com/johnbillion/extended-cpts/wiki/Query-vars-for-filtering#example
 *
 */
class Query_Var extends Argument_Abstract {
	/**
	 * @var Custom_Post_Type_Extended
	 */
	protected $object;

	/**
	 * The current query variable.
	 *
	 * @see Query_var::set()
	 * @var string
	 */
	protected $query_var;


	/**
	 * Query_var constructor.
	 *
	 * @param Custom_Post_Type_Extended $extended
	 */
	public function __construct( Custom_Post_Type_Extended $extended ) {
		$this->object = $extended;
	}


	/**
	 * Store args to cpt object
	 * This must be called from every method that is saving args,
	 * or they will go nowhere
	 *
	 * @param array $args
	 *
	 * @internal
	 *
	 * @return void
	 */
	public function set( array $args ) : void {
		if ( ! isset( $this->object->site_filters[ $this->query_var ] ) ) {
			$this->query_var = $args['query_var'];
			$this->object->site_filters[ $this->query_var ] = [];
		}

		$existing = $this->object->site_filters[ $this->query_var ];

		$existing = \array_merge( $existing, $args );
		$this->object->site_filters[ $this->query_var ] = $existing;
	}


	/**
	 * Store args to cpt object
	 * Then return the Query_Var_Shared class
	 *
	 * @param array $args
	 *
	 * @return Query_Var_Shared
	 */
	protected function return( array $args ) : Query_Var_Shared {
		$this->set( $args );
		return new Query_Var_Shared( $this, $args );
	}


	/**
	 * Allow posts to be filtered by an exact match on the value of the given meta key
	 *
	 * You can additionally specify a meta_query parameter
	 * if your query var needs to provide a complex meta query filter,
	 * rather than just a match on the value. For example:
	 * 'meta_query' => array(
	 * 'compare' => '>',
	 * 'type'    => 'NUMERIC',
	 * )
	 *
	 * @param string     $query_var
	 * @param string     $meta_key
	 * @param array|null $meta_query
	 *
	 * @return Query_Var_Shared
	 */
	public function meta( string $query_var, string $meta_key, array $meta_query = null ) : Query_Var_Shared {
		$_args = [
			'query_var' => $query_var,
			'meta_key'  => $meta_key, //phpcs:ignore
		];

		if ( null !== $meta_query ) {
			$_args['meta_query'] = $meta_query; //phpcs:ignore
		}

		return $this->return( $_args );
	}


	/**
	 * Allow posts to be filtered by a search on the value of the given meta key
	 * by using the meta_search_key parameter. Uses a LIKE '%{value}%' query in SQL.
	 *
	 * @param string $query_var
	 * @param string $meta_key
	 *
	 * @return Query_Var_Shared
	 */
	public function meta_search( string $query_var, string $meta_key ) : Query_Var_Shared {
		$_args = [
			'query_var'       => $query_var,
			'meta_search_key' => $meta_key,
		];

		return $this->return( $_args );
	}


	/**
	 * Allow posts to be filtered by posts, which contain a meta field with the given meta key,
	 * regardless of its value.
	 * More specifically, if its value isn't empty-like, such as 0 or false.
	 *
	 *
	 * @param string $query_var
	 * @param string $meta_key
	 *
	 * @return Query_Var_Shared
	 */
	public function meta_exists( string $query_var, string $meta_key ) : Query_Var_Shared {
		$_args = [
			'query_var'   => $query_var,
			'meta_exists' => $meta_key,
		];

		return $this->return( $_args );
	}


	/**
	 * Allow posts to be filtered by their taxonomy terms by using the taxonomy parameter.
	 * Note that this is just a wrapper for WordPress' built-in taxonomy term filtering,
	 * because posts can be filtered by their taxonomy terms by default.
	 *
	 *
	 * @param string $query_var
	 * @param string $taxonomy
	 *
	 * @notice Watch out for query var name clashes!
	 *
	 * @throws \RuntimeException - It taxonomy does not exist.
	 *
	 * @return Query_Var_Shared
	 */
	public function taxonomy( string $query_var, string $taxonomy ) : Query_Var_Shared {
		if ( taxonomy_exists( $query_var ) ) {
			throw new \RuntimeException( __( 'Your query var clashes with an existing taxonomy. You can probably just use default WP filtering.', 'lipe' ) );
		}
		$_args = [
			'query_var' => $query_var,
			'taxonomy'  => $taxonomy,
		];

		return $this->return( $_args );
	}

}
