<?php
/** @noinspection PhpExpressionResultUnusedInspection, PhpUnhandledExceptionInspection */
declare( strict_types=1 );

/**
 * Version 2.6.3
 */

use Lipe\Lib\Api\Route;
use Lipe\Lib\Container\Container;
use Lipe\Lib\Meta\Repo;
use Lipe\WP_Unit\Utils\PrivateAccess;

/**
 * @deprecated
 */
function call_private_method( string|object $object, string $method_name, array $parameters = [] ): mixed {
	return PrivateAccess::in()->call_private_method( $object, $method_name, $parameters );
}

/**
 * @deprecated
 */
function get_private_property( string|object $object, string $property ): mixed {
	return PrivateAccess::in()->get_private_property( $object, $property );
}

/**
 * @deprecated
 */
function set_private_property( string|object $object, string $property, mixed $value ): void {
	PrivateAccess::in()->set_private_property( $object, $property, $value );
}

function tests_reset_container(): void {
	PrivateAccess::in()->set_private_property( Repo::in(), 'registered', [] );
	PrivateAccess::in()->set_private_property( Route::in(), 'routes', [] );
	Repo::in()->clear_memoize_cache();

	Container::reset();
}
