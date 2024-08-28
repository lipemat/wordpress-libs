<?php
declare( strict_types=1 );

namespace Lipe\Lib\Post_Type;

/**
 * @author Mat Lipe
 * @since  August 2024
 *
 */
class Custom_Post_TypeTest extends \WP_UnitTestCase {

	public function test_labels(): void {
		$cpt = new Custom_Post_Type( 'wp-unit-testing' );
		$labels = $cpt->labels( 'Testing', 'Testings' );

		$this->assertSame( 'Testing', $labels->get_label( Labels::SINGULAR_NAME ) );
		$this->assertSame( 'Testings', $labels->get_label( Labels::NAME ) );
		$labels = $cpt->labels();
		$this->assertSame( 'Testing', $labels->get_label( Labels::SINGULAR_NAME ) );
		$this->assertSame( 'Testings', $labels->get_label( Labels::NAME ) );

		$cpt = new Custom_Post_Type( 'wp-unit-testing' );
		$labels = $cpt->labels();
		$this->assertSame( 'Wp Unit Testing', $labels->get_label( Labels::SINGULAR_NAME ) );
		$this->assertSame( 'Wp Unit Testings', $labels->get_label( Labels::NAME ) );

		$cpt = new Custom_Post_Type( 'wp_unit_testing' );
		$labels = $cpt->labels();
		$this->assertSame( 'Wp Unit Testing', $labels->get_label( Labels::SINGULAR_NAME ) );
		$this->assertSame( 'Wp Unit Testings', $labels->get_label( Labels::NAME ) );
	}


	public function test_get_get_post_type_labels(): void {
		$cpt = new Custom_Post_Type( 'wp-unit-testing' );
		$cpt->labels( 'Testing', 'Testings' );

		$generated = call_private_method( $cpt, 'get_post_type_labels' );
		$this->assertSame( 'Testing', $generated[ Labels::SINGULAR_NAME ] );
		$this->assertSame( 'Testings', $generated[ Labels::NAME ] );
		$cpt->labels();
		$generated = call_private_method( $cpt, 'get_post_type_labels' );
		$this->assertSame( 'Testing', $generated[ Labels::SINGULAR_NAME ] );
		$this->assertSame( 'Testings', $generated[ Labels::NAME ] );

		$cpt = new Custom_Post_Type( 'wp-unit-testing' );
		$cpt->labels();
		$generated = call_private_method( $cpt, 'get_post_type_labels' );
		$this->assertSame( 'Wp Unit Testing', $generated[ Labels::SINGULAR_NAME ] );
		$this->assertSame( 'Wp Unit Testings', $generated[ Labels::NAME ] );

		$cpt = new Custom_Post_Type( 'wp_unit_testing' );
		$generated = call_private_method( $cpt, 'get_post_type_labels' );
		$this->assertSame( 'Wp Unit Testing', $generated[ Labels::SINGULAR_NAME ] );
		$this->assertSame( 'Wp Unit Testings', $generated[ Labels::NAME ] );
	}
}
