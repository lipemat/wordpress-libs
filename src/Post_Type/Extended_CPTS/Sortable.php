<?php

namespace Lipe\Lib\Post_Type\Extended_CPTS;

use Lipe\Lib\Post_Type\Custom_Post_Type_Extended;

/**
 * Extended CPTs provides a mechanism for registering values for the public orderby query var,
 * which allows users to sort your post type archives by various fields.
 * This also works in WP_Query, which makes ordering custom post type listings very powerful and dead easy.
 *
 * Think of these as the front-end equivalent of sortable columns in the admin area, minus the UI.
 *
 * The array keys in the site_sortables array are used for the orderby value
 *
 * @link    https://github.com/johnbillion/extended-cpts/wiki/Query-vars-for-sorting#example
 *
 * @example
 * new WP_Query( array(
 * 'post_type' => 'article',
 * 'orderby'   => $sort_key,
 * 'order'     => 'DESC',
 * ) );
 */
class Sortable extends Argument_Abstract {
	/**
	 * @var Custom_Post_Type_Extended
	 */
	protected Custom_Post_Type_Extended $cpts;

	/**
	 * @see Sortable::set
	 * @var string
	 */
	protected $sortables_array_key;


	/**
	 * Sortable constructor.
	 *
	 * @param Custom_Post_Type_Extended $cpts
	 */
	public function __construct( Custom_Post_Type_Extended $cpts ) {
		$this->cpts = $cpts;
	}


	/**
	 * Store args to cpt object.
	 *
	 * This must be called from every method that is saving args
	 * or they will go nowhere.
	 *
	 * @param array $args
	 *
	 * @internal
	 *
	 * @return void
	 */
	public function set( array $args ) : void {
		if ( ! isset( $this->cpts->site_sortables[ $this->sortables_array_key ] ) ) {
			$this->sortables_array_key = $args['sort_key'];
			$this->cpts->site_sortables[ $this->sortables_array_key ] = [];
			unset( $args['sort_key'] );
		}

		$existing = $this->cpts->site_sortables[ $this->sortables_array_key ];

		$existing = array_merge( $existing, $args );
		$this->cpts->site_sortables[ $this->sortables_array_key ] = $existing;
	}


	/**
	 * Store args to cpt object
	 * Then return the Sortable_Shared class
	 *
	 * @param array $args
	 *
	 * @return Sortable_Shared
	 */
	protected function return( array $args ) : Sortable_Shared {
		$this->set( $args );
		return new Sortable_Shared( $this, $args );
	}


	/**
	 * Sort posts by their meta value by using the meta_key parameter:
	 *
	 * @param string $sort_key
	 * @param string $meta_key
	 *
	 * @return Sortable_Shared
	 */
	public function meta( string $sort_key, string $meta_key ) : Sortable_Shared {
		return $this->return( compact( 'sort_key', 'meta_key' ) );
	}


	/**
	 * Sort posts by their taxonomy term(s) by using the taxonomy parameter:
	 *
	 * @param string $sort_key
	 * @param string $taxonomy
	 *
	 * @return Sortable_Shared
	 */
	public function taxonomy( string $sort_key, string $taxonomy ) : Sortable_Shared {
		return $this->return( compact( 'sort_key', 'taxonomy' ) );
	}


	/**
	 * Sort posts by any available post field by using the post_field parameter:
	 *
	 * @param string $sort_key
	 * @param string $post_field
	 *
	 * @return Sortable_Shared
	 */
	public function post_field( string $sort_key, string $post_field ) : Sortable_Shared {
		return $this->return( compact( 'sort_key', 'post_field' ) );
	}

}
