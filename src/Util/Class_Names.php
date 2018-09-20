<?php

namespace Lipe\Lib\Util;

/**
 * Conditionally add css classes to an element
 *
 * Mirrored after npm classnames
 * @link https://www.npmjs.com/package/classnames
 *
 * @example $class = new Class_Names( [ 'top' => false, 'bottom' => true ] ); //echo $class; outputs "bottom"
 * @example $class = new Class_Names( [ 'top', 'bottom' ] ); //"echo $class; outputs top bottom"
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
