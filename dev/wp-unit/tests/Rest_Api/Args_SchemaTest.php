<?php
declare( strict_types=1 );

namespace Lipe\Lib\Rest_Api;

use Lipe\Lib\Rest_Api\Schema\Argument_Prop;
use Lipe\Lib\Rest_Api\Schema\Resource_Prop;
use Lipe\Lib\Rest_Api\Schema\StringType;

/**
 * @author Mat Lipe
 * @since  September 2024
 *
 */
class Args_SchemaTest extends \WP_UnitTestCase {

	public function test_get_args(): void {
		$schema = new Arguments_Schema( [] );
		$this->assertEmpty( $schema->get_args() );
	}


	public function test_string_type(): void {
		$schema = new Arguments_Schema( [] );
		$schema->prop( 'test' )
		       ->description( 'Test prop' )
		       ->validate_callback( 'is_string' )
		       ->sanitize_callback( 'sanitize_text_field' )
		       ->default( 'test@you.com' )
		       ->type()->string()
		       ->pattern( '/^test$/' )
		       ->max_length( 5 )
		       ->min_length( 2 )
		       ->format( StringType::FORMAT_EMAIL )
		       ->enum( [ 'test@me.com', 'test@you.com' ] );

		$this->assertSame( [
			'test' => [
				'default'           => 'test@you.com',
				'sanitize_callback' => 'sanitize_text_field',
				'validate_callback' => 'is_string',
				'description'       => 'Test prop',
				'type'              => 'string',
				'pattern'           => '/^test$/',
				'minLength'         => 2,
				'maxLength'         => 5,
				'format'            => 'email',
				'enum'              => [
					0 => 'test@me.com',
					1 => 'test@you.com',
				],
			],
		], $schema->get_args() );
	}


	public function test_number_type(): void {
		$schema = new Arguments_Schema( [] );
		$schema->prop( 'test' )
		       ->description( 'Test prop' )
		       ->validate_callback( 'is_numeric' )
		       ->sanitize_callback( 'absint' )
		       ->default( 5 )
		       ->type()->number()
		       ->minimum( 2 )
		       ->maximum( 5 )
		       ->exclusive_minimum( true )
		       ->exclusive_maximum( true );

		$this->assertSame( [
			'test' => [
				'default'           => 5,
				'sanitize_callback' => 'absint',
				'validate_callback' => 'is_numeric',
				'description'       => 'Test prop',
				'type'              => 'number',
				'minimum'           => 2,
				'maximum'           => 5,
				'exclusiveMinimum'  => true,
				'exclusiveMaximum'  => true,
			],
		], $schema->get_args() );
	}


	public function test_integar_type(): void {
		$schema = new Arguments_Schema( [] );
		$schema->prop( 'test' )
		       ->description( 'Test prop' )
		       ->validate_callback( 'is_int' )
		       ->sanitize_callback( 'absint' )
		       ->default( 5 )
		       ->type()->integer()
		       ->minimum( 2 )
		       ->maximum( 5 )
		       ->exclusive_minimum( true )
		       ->exclusive_maximum( true );

		$this->assertSame( [
			'test' => [
				'default'           => 5,
				'sanitize_callback' => 'absint',
				'validate_callback' => 'is_int',
				'description'       => 'Test prop',
				'minimum'           => 2,
				'maximum'           => 5,
				'type'              => 'integer',
				'exclusiveMinimum'  => true,
				'exclusiveMaximum'  => true,
			],
		], $schema->get_args() );
	}


	public function test_one_of(): void {
		$schema = new Arguments_Schema( [] );

		$string = ( new Resource_Prop( [] ) )
			->title( 'Stringy' )
			->description( 'Some Text' );
		$string->type()->string();
		$number = ( new Resource_Prop( [] ) )
			->title( 'Numbery' );
		$number->type()->number();

		$schema->prop( 'test' )
		       ->description( 'Test prop' )
		       ->validate_callback( 'is_string' )
		       ->sanitize_callback( 'sanitize_text_field' )
		       ->type()->one_of( [ $string, $number ] );

		$this->assertSame( [
			'test' => [
				'sanitize_callback' => 'sanitize_text_field',
				'validate_callback' => 'is_string',
				'description'       => 'Test prop',
				'oneOf'             => [
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
			],
		], $schema->get_args() );
	}


	public function test_any_of(): void {
		$schema = new Arguments_Schema( [] );

		$string = ( new Resource_Prop( [] ) )
			->title( 'Stringy' )
			->description( 'Some Text' );
		$string->type()->string();
		$number = ( new Resource_Prop( [] ) )
			->title( 'Numbery' );
		$number->type()->number();

		$schema->prop( 'test' )
		       ->description( 'Test prop' )
		       ->validate_callback( 'is_string' )
		       ->sanitize_callback( 'sanitize_text_field' )
		       ->type()->any_of( [ $string, $number ] );

		$this->assertSame( [
			'test' => [
				'sanitize_callback' => 'sanitize_text_field',
				'validate_callback' => 'is_string',
				'description'       => 'Test prop',
				'anyOf'             => [
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
			],
		], $schema->get_args() );
	}


	public function test_multiple_layer_any_of(): void {
		$schema = new Arguments_Schema( [] );

		$string = ( new Resource_Prop( [] ) )
			->title( 'Stringy' )
			->description( 'Some Text' );
		$string->type()->string();
		$object = ( new Resource_Prop( [] ) )
			->title( 'Objecty' );
		$number = ( new Resource_Prop( [] ) );
		$number->type()->number();
		$lower = ( new Resource_Prop( [] ) )
			->title( 'Even Lower' );
		$lower->type()->string();
		$even = ( new Resource_Prop( [] ) )
			->title( 'Even Lower' );
		$even->type()->string();

		$object->type()->object()
		       ->prop( 'lower' )
		       ->type()->one_of( [ $even, $number ] );

		$schema->prop( 'test' )
		       ->description( 'Test prop' )
		       ->validate_callback( 'is_string' )
		       ->sanitize_callback( 'sanitize_text_field' )
		       ->type()->any_of( [ $string, $object ] );

		$this->assertSame( [
			'test' => [
				'sanitize_callback' => 'sanitize_text_field',
				'validate_callback' => 'is_string',
				'description'       => 'Test prop',
				'anyOf'             => [
					[
						'description' => 'Some Text',
						'title'       => 'Stringy',
						'type'        => 'string',
					],
					[
						'title'      => 'Objecty',
						'type'       => 'object',
						'properties' => [
							'lower' => [
								'oneOf' => [
									[
										'title' => 'Even Lower',
										'type'  => 'string',
									],
									[
										'type' => 'number',
									],
								],
							],
						],
					],

				],
			],
		], $schema->get_args() );
	}


	public function test_throws_on_invalid_one_of(): void {
		$this->expectException( \TypeError::class );
		if ( PHP_VERSION_ID < 80400 ) {
			$this->expectExceptionMessage( 'Lipe\Lib\Rest_Api\Schema\Type::Lipe\Lib\Rest_Api\Schema\{closure}(): Argument #1 ($prop) must be of type Lipe\Lib\Rest_Api\Schema\Resource_Prop, Lipe\Lib\Rest_Api\Schema\Argument_Prop given' );
		} else {
			$this->expectExceptionMessage( 'Lipe\Lib\Rest_Api\Schema\Type::{closure:Lipe\Lib\Rest_Api\Schema\Type::get_args():171}(): Argument #1 ($prop) must be of type Lipe\Lib\Rest_Api\Schema\Resource_Prop, Lipe\Lib\Rest_Api\Schema\Argument_Prop given' );
		}

		$schema = new Arguments_Schema( [] );
		$schema->prop( 'test' )
		       ->type()->one_of( [ new Argument_Prop( [] ) ] );

		$schema->get_args();
	}


	public function test_throws_on_invalid_any_of(): void {
		$this->expectException( \TypeError::class );
		if ( PHP_VERSION_ID < 80400 ) {
			$this->expectExceptionMessage( 'Lipe\Lib\Rest_Api\Schema\Type::Lipe\Lib\Rest_Api\Schema\{closure}(): Argument #1 ($prop) must be of type Lipe\Lib\Rest_Api\Schema\Resource_Prop, Lipe\Lib\Rest_Api\Schema\Argument_Prop given' );
		} else {
			$this->expectExceptionMessage( 'Lipe\Lib\Rest_Api\Schema\Type::{closure:Lipe\Lib\Rest_Api\Schema\Type::get_args():166}(): Argument #1 ($prop) must be of type Lipe\Lib\Rest_Api\Schema\Resource_Prop, Lipe\Lib\Rest_Api\Schema\Argument_Prop given' );
		}

		$schema = new Arguments_Schema( [] );
		$schema->prop( 'test' )
		       ->type()->any_of( [ new Argument_Prop( [] ) ] );

		$schema->get_args();
	}
}
