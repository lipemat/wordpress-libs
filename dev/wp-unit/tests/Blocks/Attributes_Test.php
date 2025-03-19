<?php
declare( strict_types=1 );

namespace Lipe\Lib\Blocks;

use Lipe\Lib\Blocks\Args\Prop;
use PHPUnit\Framework\Attributes\DataProvider;

/**
 * @author Mat Lipe
 * @since  March 2025
 *
 */
final class Attributes_Test extends \WP_UnitTestCase {
	public function test_get_args(): void {
		$attributes = new Attributes( [] );
		$this->assertEmpty( $attributes->get_args() );

		$attributes->prop( 'url' )
		           ->type( Prop::TYPE_STRING )
		           ->default( 'https://example.com' )
		           ->enum( [ 'https://example.com', 'https://example.org' ] );

		$this->assertSame( [
			'url' => [
				'type'    => 'string',
				'enum'    => [
					0 => 'https://example.com',
					1 => 'https://example.org',
				],
				'default' => 'https://example.com',
			],
		], $attributes->get_args() );
	}


	public function test_invalid_enum_value_string(): void {
		$this->expectException( \InvalidArgumentException::class );
		$this->expectExceptionMessage( 'Enum values must be of type string.' );

		$attributes = new Attributes( [] );
		$attributes->prop( 'url' )
		           ->type( Prop::TYPE_STRING )
		           ->enum( [ 123, 'https://example.org' ] );
	}


	public function test_invalie_enum_value_number(): void {
		$this->expectException( \InvalidArgumentException::class );
		$this->expectExceptionMessage( 'Enum values must be of type number.' );

		$attributes = new Attributes( [] );
		$attributes->prop( 'url' )
		           ->type( Prop::TYPE_NUMBER )
		           ->enum( [ 'https://example.com', 123 ] );
	}


	#[DataProvider( 'provideDefaultFails' )]
	public function test_invalid_default( string $type, mixed $value ): void {
		$this->expectException( \InvalidArgumentException::class );
		$this->expectExceptionMessage( 'Default value must be of type ' . $type . '.' );

		$attributes = new Attributes( [] );
		$attributes->prop( 'url' )
		           ->type( $type )
		           ->default( $value );
	}


	public function test_with_attribute_source(): void {
		$attributes = new Attributes( [] );

		$attributes->prop( 'url' )
		           ->type( Prop::TYPE_STRING )
		           ->source()->attribute( 'img', 'src' );

		$this->assertSame( [
			'url' => [
				'type'      => 'string',
				'selector'  => 'img',
				'source'    => 'attribute',
				'attribute' => 'src',
			],
		], $attributes->get_args() );
	}


	public function test_with_query_source(): void {
		$attributes = new Attributes( [] );

		$query = [
			'url' => ( new Prop( [] ) )
				->type( Prop::TYPE_STRING )
				->source()->attribute( 'img', 'src' ),
			'alt' => ( new Prop( [] ) )
				->type( Prop::TYPE_STRING )
				->source()->attribute( 'img', 'alt' ),
		];

		$attributes->prop( 'images' )
		           ->type( Prop::TYPE_ARRAY )
		           ->source()
		           ->query( 'img', $query );

		$this->assertSame( [
			'images' => [
				'type'     => 'array',
				'selector' => 'img',
				'source'   => 'query',
				'query'    => [
					'url' => [
						'type'      => 'string',
						'source'    => 'attribute',
						'attribute' => 'src',
					],
					'alt' => [
						'type'      => 'string',
						'source'    => 'attribute',
						'attribute' => 'alt',
					],
				],
			],
		], $attributes->get_args() );
	}


	public static function provideDefaultFails(): array {
		return [
			'string'  => [
				'type'  => Prop::TYPE_STRING,
				'value' => 123,
			],
			'number'  => [
				'type'  => Prop::TYPE_NUMBER,
				'value' => 'https://example.com',
			],
			'boolean' => [
				'type'  => Prop::TYPE_BOOLEAN,
				'value' => 'https://example.com',
			],
			'integer' => [
				'type'  => Prop::TYPE_INTEGER,
				'value' => false,
			],
			'array'   => [
				'type'  => Prop::TYPE_ARRAY,
				'value' => new \stdClass(),
			],
			'object'  => [
				'type'  => Prop::TYPE_OBJECT,
				'value' => new \stdClass(),
			],
		];
	}
}
