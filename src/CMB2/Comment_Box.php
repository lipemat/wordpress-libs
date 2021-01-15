<?php

namespace Lipe\Lib\CMB2;

/**
 * Box for comments.
 */
class Comment_Box extends Box {
	public function __construct( $id,  $title ) {
		parent::__construct( $id, [ 'comment' ], $title );
	}
}
