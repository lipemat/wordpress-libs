<?php
declare( strict_types=1 );

namespace Lipe\Lib\Rest_Api\Schema;

use Lipe\Lib\Rest_Api\Arguments_Schema;

/**
 * @author Mat Lipe
 * @since  September 2024
 *
 */
class ObjectTypeTest extends \WP_UnitTestCase {

	public function test_default(): void {
		$default = new \stdClass();
		$default->yes = 'Yes';
		$default->no = 'No';

		$schema = new Arguments_Schema( [] );
		$object = $schema->prop( 'first' )
		                 ->default( $default )
		                 ->type()->object();
		$object->prop( 'yes' )->type()->string()->enum( [ 'Yes', 'Si' ] );
		$object->prop( 'no' )->type()->string()->enum( [ 'No', 'Nada' ] );

		$request = new \WP_REST_Request( 'GET',
			'/wp/v2/foo', [ 'args' => $schema->get_args() ] );

		foreach ( $schema->get_args() as $arg => $options ) {
			if ( isset( $options['default'] ) ) {
				$defaults[ $arg ] = $options['default'];
			}
		}
		$request->set_default_params( $defaults ?? [] );
		$this->assertEquals( $default, $request->get_param( 'first' ) );
	}


	public function test_validate_type(): void {
		$value = new \stdClass();
		$value->yes = 'Yes';
		$value->no = 'No';

		$schema = new Arguments_Schema( [] );
		$object = $schema->prop( 'first' )
		                 ->default( $value )
		                 ->type()->object();
		$object->prop( 'yes' )->type()->string()->enum( [ 'Yes', 'Si' ] );
		$object->prop( 'no' )->type()->string()->enum( [ 'No', 'Nada' ] );

		$request = new \WP_REST_Request( 'GET',
			'/wp/v2/foo', [ 'args' => $schema->get_args() ] );

		$this->assertTrue( rest_validate_request_arg( (array) $value, $request, 'first' ) );
		$this->assertTrue( rest_validate_request_arg( $value, $request, 'first' ) );

		$this->assertEmpty( $request->get_param( 'first' ) );
		$request->set_query_params( [ 'first' => $value ] );
		$this->assertEquals( $value, $request->get_param( 'first' ) );
		$this->assertTrue( $request->sanitize_params() );

		$value->yes = 'Nada';
		$this->assertWPError( rest_validate_request_arg( (array) $value, $request, 'first' ) );
		$request->set_query_params( [ 'first' => $value ] );
		$this->assertEquals( $value, $request->get_param( 'first' ) );
		$this->assertWPError( $request->sanitize_params() );
	}


	public function test_additional_properties(): void {
		$schema = new Arguments_Schema( [] );
		$object = $schema->prop( 'first' )
		                 ->type()->object();
		$object->additional_properties()
		       ->title( 'Stringy' )
		       ->description( 'Some Text' )
		       ->type()->string()->pattern( '/^a/' );

		$this->assertSame( [
			'first' => [
				'type'                 => 'object',
				'additionalProperties' => [
					'description' => 'Some Text',
					'title'       => 'Stringy',
					'type'        => 'string',
					'pattern'     => '/^a/',
				],
				'properties'           => [],
			],
		], $schema->get_args() );

		$schema = new Arguments_Schema( [] );
		$object = $schema->prop( 'first' )
		                 ->type()->object();
		$this->assertNull( $object->additional_properties( false ) );
		$this->assertSame( [
			'first' => [
				'type'                 => 'object',
				'additionalProperties' => false,
				'properties'           => [],
			],
		], $schema->get_args() );

		$schema = new Arguments_Schema( [] );
		$prop = $schema->prop( 'first' )
		               ->type()->object()->additional_properties( true, 4, 6 );
		$this->assertNull( $prop );
		$this->assertSame( [
			'first' => [
				'type'                 => 'object',
				'additionalProperties' => true,
				'minProperties'        => 6,
				'maxProperties'        => 4,
				'properties'           => [],
			],
		], $schema->get_args() );
	}


	public function test_pattern_properties(): void {
		$schema = new Arguments_Schema( [] );
		$object = $schema->prop( 'first' )
		                 ->type()->object();
		$object->pattern_properties( '/^a/' )
		       ->title( 'Stringy' )
		       ->description( 'Some Text' )
		       ->type()->string()->pattern( '/^a/' );

		$this->assertSame( [
			'first' => [
				'type'              => 'object',
				'patternProperties' => [
					'/^a/' => [
						'description' => 'Some Text',
						'title'       => 'Stringy',
						'type'        => 'string',
						'pattern'     => '/^a/',
					],
				],
				'properties'        => [],
			],
		], $schema->get_args() );

		$schema = new Arguments_Schema( [] );
		$object = $schema->prop( 'first' )
		                 ->type()->object();
		$object->pattern_properties( '/^a/' )
		       ->type()->string()->pattern( '/^a/' );

		$this->assertSame( [
			'first' => [
				'type'              => 'object',
				'patternProperties' => [
					'/^a/' => [
						'type'    => 'string',
						'pattern' => '/^a/',
					],
				],
				'properties'        => [],
			],
		], $schema->get_args() );

		$schema = new Arguments_Schema( [] );
		$object = $schema->prop( 'first' )
		                 ->type()->object();
		$object->pattern_properties( '/^a/' )
		       ->type()->string();

		$this->assertSame( [
			'first' => [
				'type'              => 'object',
				'patternProperties' => [
					'/^a/' => [
						'type' => 'string',
					],
				],
				'properties'        => [],
			],
		], $schema->get_args() );
	}
}
