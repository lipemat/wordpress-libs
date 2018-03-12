<?php

namespace Lipe\Lib\Util;

/**
 * Class_Names
 *
 * @author  Mat Lipe
 * @since   1.4.0
 *
 * @package Lipe\Lib\Util
 */
class Class_Names {

	private $classes = [];


	public function __construct( array $classes ) {
		if ( \array_values( $classes ) === $classes ) {
			$this->classes = $classes;
		}

		foreach ( $classes as $_class => $_active ) {
			if ( (bool) $_active ) {
				$this->classes[] = $_class;
			}
		}
	}


	public function __toString() {
		return implode( ' ', $this->classes );
	}

}
