<?php

/**
 * Version 2.0.3
 */

/**
 * Call protected/private method of a class.
 *
 * @param object $object     Instantiated object that we will run method on.
 * @param string $methodName Method name to call
 * @param array  $parameters Array of parameters to pass into method.
 *
 * @throws
 *
 * @return mixed Method return.
 */
function call_private_method( object $object, string $methodName, array $parameters = [] ) {
	$reflection = new \ReflectionClass( get_class( $object ) );
	$method = $reflection->getMethod( $methodName );
	$method->setAccessible( true );

	return $method->invokeArgs( $object, $parameters );
}

/**
 * Get the value of a private constant or property from an object.
 *
 * @param object $object
 * @param string $property
 *
 * @throws
 *
 * @return mixed|ReflectionProperty
 */
function get_private_property( object $object, string $property ) {
	$reflection = new \ReflectionClass( get_class( $object ) );
	if ( $reflection->hasProperty( $property ) ) {
		$reflectionProperty = $reflection->getProperty( $property );
		$reflectionProperty->setAccessible( true );
		return $reflectionProperty->getValue( $object );
	}
	return $reflection->getConstant( $property );
}

/**
 * Set the value of a private property on an object.
 *
 * @param object $object
 * @param string $property
 *
 * @param mixed  $value
 *
 * @throws
 *
 * @return void
 */
function set_private_property( object $object, string $property, $value ) : void {
	$reflection = new \ReflectionClass( get_class( $object ) );
	$reflectionProperty = $reflection->getProperty( $property );
	$reflectionProperty->setAccessible( true );
	$reflectionProperty->setValue( $object, $value );
}
