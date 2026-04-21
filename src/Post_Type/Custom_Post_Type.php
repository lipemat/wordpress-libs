<?php
declare( strict_types=1 );

namespace Lipe\Lib\Post_Type;

/**
 * Deprecated. Use `Post_Type` instead.
 *
 * @deprecated     This class is deprecated and will be removed in version 6. Use `Post_Type` instead.
 *
 * @phpstan-ignore lipemat.classExtendsNotAllowed
 */
class Custom_Post_Type extends Post_Type {
	/**
	 * Constructor.
	 *
	 * @param string                                    $post_type - The post type slug.
	 *
	 * @phpstan-param lowercase-string&non-empty-string $post_type - The post type slug.
	 */
	public function __construct( string $post_type ) {
		_deprecated_class( __CLASS__, '5.10', 'Use `Post_Type` instead.' );
		parent::__construct( $post_type );
	}
}
