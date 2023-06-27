<?php

namespace Lipe\Lib\Theme;

use Lipe\Lib\Util\Arrays;

/**
 * Conditionally add CSS classes to an element
 *
 * Mirrored after npm classnames and enhanced.
 *
 * @link    https://www.npmjs.com/package/classnames
 *
 * @example new Class_Names( [ 'top' => false, 'bottom' => true ] );
 * @example new Class_Names( [ 'top', 'bottom' ] );
 * @example new Class_Names( 'top', [ 'bottom' => false ] );
 * @example $class  = new Class_Names( [ $styles['tab'] ] );
 *          // Conditionally add an active class as we go.
 *          $class[ 'active' ] = isset( $_POST['domain_list'] );
 *
 * @implements \ArrayAccess<string, array|string>
 */
class Class_Names implements \ArrayAccess {

	/**
	 * Classes to parse.
	 *
	 * @var array
	 */
	protected array $classes = [];


	/**
	 * Accepts any number of arrays or strings.
	 *
	 * @param string|array ...$classes - Classes to parse.
	 */
	public function __construct( ...$classes ) {
		\array_walk( $classes, [ $this, 'parse_classes' ] );
	}


	/**
	 * Return final list of class names.
	 *
	 * @see Class_Names::__toString
	 * @interal
	 *
	 * @return array
	 */
	public function get_classes() : array {
		$clean = Arrays::in()->clean( $this->classes );
		return \array_values( \array_map( [ Template::in(), 'sanitize_html_class' ], $clean ) );
	}


	/**
	 * Extract classes out of arrays, strings, or a combination.
	 *
	 * Allows us to pass any combination of arrays or strings
	 * and still get the appropriate classes
	 *
	 * @param string|array $classes - Classes to parse.
	 *
	 * @return void
	 */
	protected function parse_classes( $classes ) : void {
		if ( \is_string( $classes ) ) {
			$this->classes[] = $classes;
			return;
		}
		foreach ( $classes as $_class => $_state ) {
			if ( \is_array( $_state ) ) {
				$this->parse_classes( $_state );
			} elseif ( \is_string( $_class ) ) {
				if ( $_state ) {
					$this->classes[] = $_class;
				}
			} else {
				$this->classes[] = $_state;
			}
		}
	}


	/**
	 * Get the index of a class name if it exists.
	 *
	 * @param string $css_class - Class name to search for.
	 *
	 * @return int|false
	 */
	protected function get_classes_key( string $css_class ) {
		return \array_search( $css_class, $this->classes, true );
	}


	/**
	 * Generate a CSS class list to be used in an HTML element.
	 *
	 * @return string
	 */
	public function __toString() {
		return \implode( ' ', $this->get_classes() );
	}


	/**
	 * Check if a class name exists in the list.
	 *
	 * @param string $offset - Class name.
	 *
	 * @return bool
	 */
	public function offsetExists( $offset ) : bool {
		return false !== $this->get_classes_key( $offset );
	}


	/**
	 * Get a class name from the list.
	 *
	 * @param string $offset - Class name.
	 *
	 * @return string
	 */
	#[\ReturnTypeWillChange]
	public function offsetGet( $offset ) {
		return Template::in()->sanitize_html_class( $this->classes[ (int) $this->get_classes_key( $offset ) ] );
	}


	/**
	 * Add or remove a class name from the list.
	 *
	 * @param ?string           $offset - Class name.
	 * @param string|array|bool $value  - True to add class or false to remove it.
	 *
	 * @return void
	 */
	public function offsetSet( $offset, $value ) : void {
		if ( ! empty( $value ) ) {
			$this->parse_classes( $offset );
		} else {
			$this->offsetUnset( $offset );
		}
	}


	/**
	 * Remove a class name from the list.
	 *
	 * @param string $offset - Class name.
	 *
	 * @return void
	 */
	public function offsetUnset( $offset ) : void {
		if ( $this->offsetExists( $offset ) ) {
			unset( $this->classes[ (int) $this->get_classes_key( $offset ) ] );
		}
	}
}
