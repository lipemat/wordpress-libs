<?php

namespace Lipe\Lib\CMB2;

/**
 * Comment_Box
 *
 * @author  Mat Lipe
 * @since   1.5.0
 *
 * @package Lipe\Lib\CMB2
 */
class Comment_Box extends Box {
	public function __construct( $id,  $title ) {
		parent::__construct( $id, [ 'comment' ], $title );
	}
}
