<?php

namespace Lipe\Lib\CMB2;

/**
 * CMB2 comments meta box fluent interface.
 */
class Comment_Box extends Box {
	public function __construct( $id,  $title ) {
		parent::__construct( $id, [ 'comment' ], $title );
	}
}
