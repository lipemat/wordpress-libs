<?php
declare( strict_types=1 );

namespace Lipe\Lib\Rest_Api;

use Lipe\Lib\Rest_Api\Schema\Resource_Prop;
use Lipe\Lib\Rest_Api\Schema\StringType;

/**
 * @author Mat Lipe
 * @since  September 2024
 *
 */
class Resource_SchemaTest extends \WP_UnitTestCase {

	public function test_string_only(): void {
		$schema = new Resource_Schema( [] );
		$schema
			->title( 'String Schema' )
			->type()->string();

		$this->assertSame( [
			'title'   => 'String Schema',
			'$schema' => 'http://json-schema.org/draft-04/schema#',
			'type'    => 'string',
		], $schema->get_args() );
	}


	public function test_nested_objects(): void {
		$schema = new Resource_Schema( [] );
		$props_object = $schema
			->title( 'Nested Schema' )
			->type()->object();
		$top = $props_object->prop( 'top' )
		                    ->description( 'Test prop' )
		                    ->readonly( true )
		                    ->type()->object();
		$second = $top->prop( 'nested' )
		              ->description( 'Nested prop' )
		              ->type()->object();
		$second->prop( 'nested_string' )
		       ->description( 'Second level' )
		       ->type()->string()
		       ->pattern( '/^test$/' );
		$second->prop( 'another_string' )
		       ->description( 'Another' )
		       ->readonly( true )
		       ->required( false )
		       ->type()->string()
		       ->pattern( '/^nest$/' );

		$this->assertSame( [
			'title'      => 'Nested Schema',
			'$schema'    => 'http://json-schema.org/draft-04/schema#',
			'type'       => 'object',
			'properties' => [
				'top' => [
					'readonly'    => true,
					'description' => 'Test prop',
					'type'        => 'object',
					'properties'  => [
						'nested' => [
							'description' => 'Nested prop',
							'type'        => 'object',
							'properties'  => [
								'nested_string'  => [
									'description' => 'Second level',
									'type'        => 'string',
									'pattern'     => '/^test$/',
								],
								'another_string' => [
									'readonly'    => true,
									'required'    => false,
									'description' => 'Another',
									'type'        => 'string',
									'pattern'     => '/^nest$/',
								],
							],
						],
					],
				],
			],
		], $schema->get_args() );
	}


	public function test_string_type(): void {
		$schema = new Resource_Schema( [] );
		$props_object = $schema
			->title( 'Resource Schema' )
			->type()->object();
		$test = $props_object->prop( 'test' )
		                     ->description( 'Test prop' )
		                     ->readonly( true )
		                     ->type()->string();
		$test->pattern( '/^test$/' )
		     ->max_length( 5 )
		     ->min_length( 2 )
		     ->format( StringType::FORMAT_EMAIL )
		     ->enum( [ 'test@me.com', 'test@you.com' ] );

		$next = $props_object->prop( 'next' )
		                     ->description( 'Next prop' )
		                     ->readonly( false )
		                     ->type()->string();
		$next->pattern( '/^next$/' );

		$this->assertSame( [
			'title'      => 'Resource Schema',
			'$schema'    => 'http://json-schema.org/draft-04/schema#',
			'type'       => 'object',
			'properties' => [
				'test' => [
					'readonly'    => true,
					'description' => 'Test prop',
					'type'        => 'string',
					'pattern'     => '/^test$/',
					'minLength'   => 2,
					'maxLength'   => 5,
					'format'      => 'email',
					'enum'        => [
						0 => 'test@me.com',
						1 => 'test@you.com',
					],
				],
				'next' => [
					'readonly'    => false,
					'description' => 'Next prop',
					'type'        => 'string',
					'pattern'     => '/^next$/',
				],
			],
		], $schema->get_args() );
	}


	public function test_one_of(): void {
		$schema = new Resource_Schema( [] );
		$type = $schema
			->title( 'One Of Schema' )
			->type();
		$string = ( new Resource_Prop( [] ) )
			->title( 'Stringy' )
			->description( 'Some Text' );
		$string->type()->string();
		$number = ( new Resource_Prop( [] ) )
			->title( 'Numbery' );
		$number->type()->number();
		$type->one_of( [ $string, $number ] );

		$this->assertSame( [
			'title'   => 'One Of Schema',
			'$schema' => 'http://json-schema.org/draft-04/schema#',
			'oneOf'   => [
				[
					'description' => 'Some Text',
					'title'       => 'Stringy',
					'type'        => 'string',
				],
				[
					'title' => 'Numbery',
					'type'  => 'number',
				],
			],
		], $schema->get_args() );
	}


	public function test_any_of(): void {
		$schema = new Resource_Schema( [] );
		$type = $schema
			->title( 'Any Of Schema' )
			->type();

		$string = ( new Resource_Prop( [] ) )
			->title( 'Stringy' )
			->description( 'Some Text' );
		$string->type()->string();
		$number = ( new Resource_Prop( [] ) )
			->title( 'Numbery' );
		$number->type()->number();

		$type->any_of( [ $string, $number ] );

		$this->assertSame( [
			'title'   => 'Any Of Schema',
			'$schema' => 'http://json-schema.org/draft-04/schema#',
			'anyOf'   => [
				[
					'description' => 'Some Text',
					'title'       => 'Stringy',
					'type'        => 'string',
				],
				[
					'title' => 'Numbery',
					'type'  => 'number',
				],
			],
		], $schema->get_args() );
	}
}
