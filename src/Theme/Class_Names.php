<?php

namespace Lipe\Lib\Theme;

/**
 * Conditionally add css classes to an element
 *
 * Mirrored after npm classnames and enhanced
 *
 * @link    https://www.npmjs.com/package/classnames
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
 * @since   1.4.0 - added
 * @since   1.9.0 - support for adding/removing classes as we go
 * @since   2.3.1 - support multilayer arrays of classes
 *
 * @package Lipe\Lib\Util
 */
class Class_Names implements \ArrayAccess {

	private $classes = [];


	public function __construct( array $classes ) {
		$this->parse_classes( $classes );
	}


	/**
	 * Used for unit testing.
	 * @see Class_Names::__toString
	 * @interal
	 *
	 * @return array
	 */
	public function get_classes() : array {
		return $this->classes;
	}

	/**
	 * Extract classes out of arrays, strings, or a combination.
	 *
	 * Allows us to pass any combination of arrays or strings
	 * and still get the appropriate classes
	 *
	 * @since 2.3.1
	 *
	 * @param $classes
	 *
	 * @return void
	 */
	protected function parse_classes( $classes ) : void {
		if ( \is_string( $classes ) ) {
			$this->classes[] = $classes;
		}
		foreach ( $classes as $_class => $_state ) {
			if ( \is_array( $_state ) ) {
				$this->parse_classes( $_state );
			} elseif ( \is_string( $_class ) ) {
				if ( (bool) $_state ) {
					$this->classes[] = $_class;
				}
			} else {
				$this->classes[] = $_state;
			}
		}
	}


	/**
	 * @param string $class
	 *
	 * @return int|false
	 */
	private function get_classes_key( string $class ) {
		return array_search( $class, $this->classes, true );
	}


	public function __toString() {
		return implode( ' ', $this->classes );
	}


	public function offsetExists( $class ) : bool {
		return false !== $this->get_classes_key( $class );
	}


	public function offsetGet( $class ) {
		return $this->offsetExists( $class );
	}


	public function offsetSet( $class, $active ) : void {
		if ( (bool) $active ) {
			$this->parse_classes( $class );
		} else {
			$this->offsetUnset( $class );
		}
	}


	public function offsetUnset( $class ) : void {
		if ( $this->offsetExists( $class ) ) {
			unset( $this->classes[ (int) $this->get_classes_key( $class ) ] );
		}
	}
}

