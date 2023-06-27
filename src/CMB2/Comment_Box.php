<?php

namespace Lipe\Lib\CMB2;

/**
 * CMB2 comments meta box fluent interface.
 */
class Comment_Box extends Box {
	/**
	 * CMB2 comments meta box constructor.
	 *
	 * @param string $id    Metabox ID.
	 * @param string $title Metabox title.
	 */
	public function __construct( $id, $title ) {
		parent::__construct( $id, [ 'comment' ], $title );
	}
}
