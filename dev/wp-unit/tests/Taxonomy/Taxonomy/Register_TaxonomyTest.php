<?php
declare( strict_types=1 );

namespace Lipe\Lib\Taxonomy\Taxonomy;

/**
 * @author Mat Lipe
 * @since  June 2024
 *
 */
class Register_TaxonomyTest extends \WP_UnitTestCase {

	public function test_args(): void {
		$args = new Register_Taxonomy( [
			'labels' => [
				'name'          => 'Test Taxonomy',
				'singular_name' => 'Test Taxonomy',
			],
			'public' => true,
		] );
		$this->assertSame( [
			'labels' => [
				'name'          => 'Test Taxonomy',
				'singular_name' => 'Test Taxonomy',
			],
			'public' => true,
		], $args->get_args(), 'Existing args are not being passed.' );

		$get_terms = $args->args();
		$get_terms->hierarchical = true;
		$get_terms->slug = 'test-taxonomy';
		$this->assertSame( [
			'labels' => [
				'name'          => 'Test Taxonomy',
				'singular_name' => 'Test Taxonomy',
			],
			'public' => true,
			'args'   => [
				'slug'         => 'test-taxonomy',
				'hierarchical' => true,
			],
		], $args->get_args() );
	}
}
