<?php

namespace Lipe\Lib\Post_Type\Extended_CPTS;

use Lipe\Lib\Post_Type\Custom_Post_Type_Extended;

/**
 * Base class for an Extended CPT column.
 */
class Column extends Argument_Abstract {

	protected $cpts;

	/**
	 * @see self::set()
	 * @var string
	 */
	protected $cols_array_key;


	/**
	 * Column constructor.
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
	 * @internal
	 *
	 * @param array $args
	 *
	 * @return void
	 */
	public function set( array $args ) : void {
		if ( ! isset( $this->cols_array_key ) ) {
			$this->cols_array_key = sanitize_title_with_dashes( $args['title'] );
			$this->cpts->admin_cols[ $this->cols_array_key ] = [];
		}
		$existing = $this->cpts->admin_cols[ $this->cols_array_key ];

		$existing = array_merge( $existing, $args );
		$this->cpts->admin_cols[ $this->cols_array_key ] = $existing;
	}


	/**
	 * Store args to cpt object
	 * Then return the Column_Shared class
	 *
	 * @param array $args
	 *
	 * @return Column_Shared
	 */
	protected function return( array $args ) : Column_Shared {
		$this->set( $args );
		return new Column_Shared( $this, $args );
	}


	/**
	 * If you don't want to use one of Extended CPT's built-in column types,
	 * you can use a callback function to output your column value by using the function parameter.
	 * Anything callable can be passed as the value, such as a function name or a closure.
	 *
	 * @param string   $title
	 * @param callable $callback
	 *
	 * @return Column_Shared
	 */
	public function custom( string $title, callable $callback ) : Column_Shared {
		$_args = [
			'title'    => $title,
			'function' => $callback,
		];
		return $this->return( $_args );
	}


	/**
	 * Posts 2 Posts connections can be output using the connection_type parameter:
	 *
	 * If you set the meta_field and meta_value this will only display the connected
	 * items which have that connection_type meta key and value
	 *
	 * You can control where each connection_type links to with the link_to parameter,
	 * which accepts view, edit, or list as its value.
	 *
	 * 'view' links to the connected post permalink.
	 * 'edit' links to the edit screen for the connected post.
	 * 'list' links to the post type list screen for the connection_type.
	 *
	 * @param string $title
	 * @param string $connection_type
	 * @param string $link_to - 'view', 'edit', 'list' (default 'edit')
	 * @param null|string   $meta_field
	 * @param null|string   $meta_value
	 *
	 * @return Column_Shared
	 */
	public function p2p( string $title, string $connection_type, $link_to = 'edit', $meta_field = null, $meta_value = null ) : Column_Shared {
		$_args = [
			'title'      => $title,
			'connection' => $connection_type,
			'link'       => $link_to,
		];

		if ( null !== $meta_field ) {
			$_args['field'] = $meta_field;
		}

		if ( null !== $meta_value ) {
			$_args['value'] = $meta_value;
		}

		return $this->return( $_args );

	}


	/**
	 * Any of the standard post fields (in the wp_posts table)
	 * can be output by using the post_field parameter:
	 *
	 * Date fields (post_date, post_date_gmt, post_modified, and post_modified_gmt)
	 * will be formatted as dates. Other fields will also be formatted where appropriate.
	 *
	 * @param string $title
	 * @param string $field - any \WP_Post field
	 *
	 * @return Column_Shared
	 */
	public function post_field( string $title, string $field ) : Column_Shared {
		$_args = [
			'title'      => $title,
			'post_field' => $field,
		];

		return $this->return( $_args );
	}


	/**
	 * Output the post's featured image at the size specified by using the featured_image parameter:
	 *
	 * If necessary, you can set the image's width and/or height
	 * in pixels if you need to scale down the image in the browser.
	 *
	 * @param string $title
	 * @param string $image_size
	 * @param null|int   $width
	 * @param null|int   $height
	 *
	 * @return Column_Shared
	 */
	public function featured_image( string $title, $image_size = 'thumbnail', ?int $width = null, ?int $height = null ) : Column_Shared {
		$_args = [
			'title'          => $title,
			'featured_image' => $image_size,
			'width'          => $width,
			'height'         => $height,
		];

		return $this->return( $_args );
	}


	/**
	 * Display a taxonomy's terms by using the taxonomy parameter:
	 * Multiple terms will be comma separated.
	 *
	 * You can control where each term links to with the link_to parameter,
	 * which accepts view, edit, or list as its value.
	 *
	 * 'view' links to the term archive on the front end.
	 * 'edit' links to the edit screen for the term.
	 * 'list' links to the post type list screen for that term.
	 *
	 * @param string $title
	 * @param string $taxonomy
	 * @param string $link_to - 'view', 'edit', 'list' (Default 'edit' )
	 *
	 * @return Column_Shared
	 */
	public function taxonomy( string $title, string $taxonomy, $link_to = 'edit' ) : Column_Shared {
		$_args = [
			'title'    => $title,
			'taxonomy' => $taxonomy,
			'link'     => $link_to,
		];

		return $this->return( $_args );
	}


	/**
	 * Display the value of a meta field by using the meta_key parameter:
	 *
	 * If the meta field represents a Unix or MySQL timestamp,
	 * you can format the output as such using the date_format parameter.
	 * The value gets passed to PHP's date() function,
	 * so any standard date format is accepted.
	 *
	 *
	 * @param string $title
	 * @param string $meta_key
	 * @param null   $date_format
	 *
	 * @return Column_Shared
	 */
	public function meta( string $title, string $meta_key, $date_format = null ) : Column_Shared {
		$_args = compact( 'title', 'meta_key' );
		if ( null !== $date_format ) {
			$_args['date_format'] = $date_format;
		}

		return $this->return( $_args );
	}

}
