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


	public function test_automatic_rewrite_disabled(): void {
		$cpt = new Custom_Post_Type( 'wp-unit-testing' );
		$cpt->public( false );
		$this->assertFalse( $cpt->register_args->rewrite );

		$cpt = new Custom_Post_Type( 'wp-unit-testing' );
		$cpt->publicly_queryable( false );
		$this->assertFalse( $cpt->register_args->rewrite );

		$cpt = new Custom_Post_Type( 'wp-unit-testing' );
		$cpt->rewrite( true );
		$cpt->public( false );
		$this->assertTrue( $cpt->register_args->rewrite );
		$cpt->publicly_queryable( false );
		$this->assertFalse( $cpt->register_args->rewrite );
	}


	public function test_add_support(): void {
		$cpt = new Custom_Post_Type( 'wp-unit-testing' );
		$cpt->add_support( Register_Post_Type::SUPPORTS_TRACKBACKS );
		$this->assertSame( [
			...Post_Type::DEFAULT_SUPPORTS,
			Register_Post_Type::SUPPORTS_TRACKBACKS,
		], $cpt->register_args->supports );

		$cpt->add_support( Register_Post_Type::SUPPORTS_POST_FORMATS );
		$this->assertSame( [
			...Post_Type::DEFAULT_SUPPORTS,
			Register_Post_Type::SUPPORTS_TRACKBACKS,
			Register_Post_Type::SUPPORTS_POST_FORMATS,
		], $cpt->register_args->supports );

		$cpt->add_support( Register_Post_Type::SUPPORTS_EDITOR_NOTES );
		$this->assertSame( [
			...Post_Type::DEFAULT_SUPPORTS,
			Register_Post_Type::SUPPORTS_TRACKBACKS,
			Register_Post_Type::SUPPORTS_POST_FORMATS,
			'editor' => [
				'notes' => true,
			],
		], $cpt->register_args->supports );

		$cpt->add_support( [ 'editor' => [ 'default-mode' => 'template-locked' ] ] );
		$this->assertEqualSets( [
			...Post_Type::DEFAULT_SUPPORTS,
			Register_Post_Type::SUPPORTS_TRACKBACKS,
			Register_Post_Type::SUPPORTS_POST_FORMATS,
			'editor' => [
				'notes'        => true,
				'default-mode' => 'template-locked',
			],
		], $cpt->register_args->supports );
	}


	public function test_remove_support(): void {
		$cpt = new Custom_Post_Type( 'wp-unit-testing' );
		$cpt->add_support( Register_Post_Type::SUPPORTS_TRACKBACKS );
		$cpt->add_support( Register_Post_Type::SUPPORTS_POST_FORMATS );
		$cpt->add_support( Register_Post_Type::SUPPORTS_EDITOR_NOTES );
		$cpt->add_support( [ 'editor' => [ 'default-mode' => 'template-locked' ] ] );
		$this->assertSame( [
			...Post_Type::DEFAULT_SUPPORTS,
			Register_Post_Type::SUPPORTS_TRACKBACKS,
			Register_Post_Type::SUPPORTS_POST_FORMATS,
			'editor' => [
				'notes'        => true,
				'default-mode' => 'template-locked',
			],
		], $cpt->register_args->supports );

		$cpt->remove_support( Register_Post_Type::SUPPORTS_TRACKBACKS );
		$this->assertEqualSets( [
			...Post_Type::DEFAULT_SUPPORTS,
			Register_Post_Type::SUPPORTS_POST_FORMATS,
			'editor' => [
				'notes'        => true,
				'default-mode' => 'template-locked',
			],
		], $cpt->register_args->supports );

		$cpt->remove_support( Register_Post_Type::SUPPORTS_EDITOR_NOTES );
		$this->assertEqualSets( [
			...Post_Type::DEFAULT_SUPPORTS,
			Register_Post_Type::SUPPORTS_POST_FORMATS,
			'editor' => [
				'default-mode' => 'template-locked',
			],
		], $cpt->register_args->supports );
	}
}
