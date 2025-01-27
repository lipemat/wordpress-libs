<?php
/** @noinspection PhpExpressionResultUnusedInspection, PhpUnhandledExceptionInspection */
declare( strict_types=1 );

/**
 * Version 2.6.3
 */

use Lipe\Lib\Api\Route;
use Lipe\Lib\Meta\Repo;

/**
 * Call protected/private method of a class.
 *
 * @param class-string|object $object      An instantiated object or class name that we will run method on.
 * @param string              $method_name Method name to call.
 * @param array               $parameters  Array of parameters to pass into method.
 *
 * @return mixed Method return.
 */
function call_private_method( string|object $object, string $method_name, array $parameters = [] ): mixed {
	$reflection = new \ReflectionClass( is_string( $object ) ? $object : get_class( $object ) );
	$method = $reflection->getMethod( $method_name );
	$method->setAccessible( true );

	return $method->invokeArgs( $object, $parameters );
}

/**
 * Get the value of a private constant or property from an object.
 *
 * @param class-string|object $object   An instantiated object or class name that we will run method on.
 * @param string              $property Property name or constant name to get.
 *
 * @return mixed
 */
function get_private_property( string|object $object, string $property ): mixed {
	$reflection = new \ReflectionClass( is_string( $object ) ? $object : get_class( $object ) );
	if ( $reflection->hasProperty( $property ) ) {
		$reflection_property = $reflection->getProperty( $property );
		$reflection_property->setAccessible( true );
		if ( $reflection_property->isStatic() ) {
			return $reflection_property->getValue();
		}
		if ( is_string( $object ) ) {
			throw new LogicException( 'Getging a non-static value from a non instantiated object is useless.' );
		}
		return $reflection_property->getValue( $object );
	}
	return $reflection->getConstant( $property );
}

/**
 * Set the value of a private property on an object.
 *
 * @param class-string|object $object   An instantiated object to set property on.
 * @param string              $property Property name to set.
 * @param mixed               $value    Value to set.
 *
 * @return void
 */
function set_private_property( string|object $object, string $property, mixed $value ): void {
	$reflection = new \ReflectionClass( is_string( $object ) ? $object : get_class( $object ) );
	$reflection_property = $reflection->getProperty( $property );
	$reflection_property->setAccessible( true );
	if ( $reflection_property->isStatic() ) {
		$reflection_property->setValue( null, $value );
	} else {
		if ( is_string( $object ) ) {
			throw new LogicException( 'Setting a non-static value on a non instantiated object is useless.' );
		}
		$reflection_property->setValue( $object, $value );
	}
}

function tests_reset_container(): void {
	set_private_property( Repo::in(), 'registered', [] );
	set_private_property( Route::in(), 'routes', [] );
	Repo::in()->clear_memoize_cache();
}
