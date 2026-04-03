<?php
declare( strict_types=1 );

namespace Lipe\Lib\Rest_Api;

/**
 * @author Mat Lipe
 * @since  April 2026
 *
 */
class Wp_Register_AbilityTest extends \WP_UnitTestCase {
	public function test_basic_properties(): void {
		$ability = new Wp_Register_Ability( [
			'label'         => 'Test Ability',
			'description'   => 'A test ability description',
			'category'      => 'test-category',
			'ability_class' => 'My_Custom_Ability',
		] );

		$args = $ability->get_args();

		$this->assertSame( 'Test Ability', $args['label'] );
		$this->assertSame( 'A test ability description', $args['description'] );
		$this->assertSame( 'test-category', $args['category'] );
		$this->assertSame( 'My_Custom_Ability', $args['ability_class'] );
	}


	public function test_callbacks(): void {
		$execute = fn( $input ) => 'result';
		$permission = fn( $input ) => true;

		$ability = new Wp_Register_Ability( [
			'execute_callback'    => $execute,
			'permission_callback' => $permission,
		] );

		$args = $ability->get_args();

		$this->assertSame( $execute, $args['execute_callback'] );
		$this->assertSame( $permission, $args['permission_callback'] );
		$this->assertSame( 'result', $args['execute_callback']( [] ) );
		$this->assertTrue( $args['permission_callback']( [] ) );
	}


	public function test_input_schema(): void {
		$ability = new Wp_Register_Ability( [] );
		$ability->input_schema()
		        ->title( 'Input Schema' )
		        ->type()->string();

		$args = $ability->get_args();

		$this->assertArrayHasKey( 'input_schema', $args );
		$this->assertSame( 'Input Schema', $args['input_schema']['title'] );
		$this->assertSame( 'string', $args['input_schema']['type'] );
	}


	public function test_output_schema(): void {
		$ability = new Wp_Register_Ability( [] );
		$ability->output_schema()
		        ->title( 'Output Schema' )
		        ->type()->object()
		        ->prop( 'success' )
		        ->type()->boolean();

		$args = $ability->get_args();

		$this->assertArrayHasKey( 'output_schema', $args );
		$this->assertSame( 'Output Schema', $args['output_schema']['title'] );
		$this->assertSame( 'object', $args['output_schema']['type'] );
		$this->assertArrayHasKey( 'success', $args['output_schema']['properties'] );
		$this->assertSame( 'boolean', $args['output_schema']['properties']['success']['type'] );
	}


	public function test_meta(): void {
		$meta = [
			'show_in_rest' => true,
			'annotations'  => [
				Wp_Register_Ability::ANNOTATION_READONLY => true,
			],
		];

		$ability = new Wp_Register_Ability( [
			'meta' => $meta,
		] );

		$args = $ability->get_args();

		$this->assertSame( $meta, $args['meta'] );
	}


	public function test_fluent_interface_completeness(): void {
		$execute = fn() => 'ok';
		$permission = fn() => true;

		$ability = new Wp_Register_Ability( [] );
		$ability->label = 'Fluent Label';
		$ability->description = 'Fluent Description';
		$ability->category = 'fluent-category';
		$ability->execute_callback = $execute;
		$ability->permission_callback = $permission;
		$ability->ability_class = 'My_Custom_Ability';

		$ability->input_schema()
		        ->type()->integer();

		$ability->output_schema()
		        ->type()->string();

		$ability->meta = [ 'show_in_rest' => false ];

		$args = $ability->get_args();

		$this->assertSame( 'Fluent Label', $args['label'] );
		$this->assertSame( 'Fluent Description', $args['description'] );
		$this->assertSame( 'fluent-category', $args['category'] );
		$this->assertSame( $execute, $args['execute_callback'] );
		$this->assertSame( $permission, $args['permission_callback'] );
		$this->assertSame( 'integer', $args['input_schema']['type'] );
		$this->assertSame( 'string', $args['output_schema']['type'] );
		$this->assertSame( [ 'show_in_rest' => false ], $args['meta'] );
		$this->assertSame( 'My_Custom_Ability', $args['ability_class'] );
	}
}
