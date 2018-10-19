<?php

namespace Lipe\Lib\Util;

/**
 * Conditionally add css classes to an element
 *
 * Mirrored after npm classnames and enhanced
 * @link https://www.npmjs.com/package/classnames
 *
 * @example $class = new Class_Names( [ 'top' => false, 'bottom' => true ] ); //echo $class; outputs "bottom"
 *
 * @example $class = new Class_Names( [ 'top', 'bottom' ] ); //"echo $class; outputs top bottom"
 *
 * @example $class  = new Class_Names( [ $styles['tab'] ] );
 *          //conditionally add an active class as we go
 *          $class[ 'active' ] = isset( $_POST['domain_list'] );
 *
 *
 * @author  Mat Lipe
 * @since   1.4.0
 *
 * @package Lipe\Lib\Util
 */
class Class_Names implements \ArrayAccess {

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


	public function offsetExists( $class ) : bool {
		return isset( $this->classes[ $class ] );
	}


	public function offsetGet( $class ) {
		return $this->classes[ $class ];
	}


	public function offsetSet( $class, $active ) : void {
		if ( (bool) $active ) {
			$this->classes[] = $class;
		} else {
			unset( $this->classes[ $class ] );
		}
	}


	public function offsetUnset( $class ) : void {
		unset( $this->classes[ $class ] );
	}
}

