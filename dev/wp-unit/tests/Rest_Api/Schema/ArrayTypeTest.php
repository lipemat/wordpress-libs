<?php
declare( strict_types=1 );

namespace Lipe\Lib\Rest_Api\Schema;

use Lipe\Lib\Rest_Api\Arguments_Schema;
use Lipe\Lib\Rest_Api\Resource_Schema;

/**
 * @author Mat Lipe
 * @since  September 2024
 *
 */
class ArrayTypeTest extends \WP_UnitTestCase {

	public function test_items(): void {
		$schema = new Arguments_Schema( [] );
		$schema->prop( 'first' )->description( 'I like IKE' )
		       ->type()->array()
		       ->items()->string()
		       ->enum( [ 'one', 'two', 'three' ] );

		$this->assertEquals( [
			'first' => [
				'type'        => 'array',
				'description' => 'I like IKE',
				'items'       => [
					'type' => 'string',
					'enum' => [ 'one', 'two', 'three' ],
				],
			],
		], $schema->get_args() );

		$schema = new Resource_Schema( [] );
		$schema->type()->array()
		       ->min_items( 1 )
		       ->max_items( 10 )
		       ->unique_items( true )
		       ->items()->object()
		       ->prop( 'first' )->description( 'I like IKE' )
		       ->type()->string()
		       ->enum( [ 'one', 'two', 'three' ] );

		$this->assertEquals( [
			'type'        => 'array',
			'minItems'    => 1,
			'maxItems'    => 10,
			'uniqueItems' => true,
			'items'       => [
				'type'       => 'object',
				'properties' => [
					'first' => [
						'type'        => 'string',
						'description' => 'I like IKE',
						'enum'        => [ 'one', 'two', 'three' ],
					],
				],
			],
			'$schema'     => 'http://json-schema.org/draft-04/schema#',
		], $schema->get_args() );
	}

}
