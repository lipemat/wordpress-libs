<?php
declare( strict_types=1 );

namespace Lipe\Lib\CMB2\Field;

use Lipe\Lib\CMB2\Box;

/**
 * @author Mat Lipe
 * @since  June 2024
 *
 */
class Term_Select_2Test extends \WP_Ajax_UnitTestCase {
	protected function setUp(): void {
		parent::setUp();

		set_private_property( Term_Select_2::in(), 'initialized', false );
		set_private_property( Term_Select_2::in(), 'registered', [] );
	}


	public function test_init_once(): void {
		global $wp_filter;
		$this->assertFalse( get_private_property( Term_Select_2::in(), 'initialized' ) );
		$this->assertFalse( has_action( 'cmb2_render_' . Type::TERM_SELECT_2->value ) );
		$this->get_box();
		$this->assertTrue( get_private_property( Term_Select_2::in(), 'initialized' ) );
		$this->assertTrue( has_action( 'cmb2_render_' . Type::TERM_SELECT_2->value ) );

		$this->get_box();
		$this->assertCount( 1, $wp_filter[ 'cmb2_render_' . Type::TERM_SELECT_2->value ]->callbacks[10] );

		$this->assertSame( 'lipe/lib/cmb2/field-types/term-select-2', Type::TERM_SELECT_2->value );
	}


	public function test_set_object_terms(): void {
		[ $cat_1, $cat_2, $cat_3, $cat_4, $cat_5 ] = self::factory()->category->create_many( 5 );
		$box = $this->get_box();

		// Field does not support assigning terms.
		apply_filters( 'cmb2_sanitize_' . Type::TERM_SELECT_2->value, null, [ $cat_1, $cat_2 ], 1, [ 'id' => 'ts' ] );
		$this->assertEmpty( wp_get_object_terms( 1, 'category' ) );

		$box->field( 'ts', 'TS' )
		    ->taxonomy_select_2( 'category', true );
		apply_filters( 'cmb2_sanitize_' . Type::TERM_SELECT_2->value, null, [ $cat_1, $cat_2 ], 1, [ 'id' => 'ts' ] );
		$this->assertSame( [ $cat_1, $cat_2 ], wp_get_object_terms( 1, 'category', [ 'fields' => 'ids' ] ) );

		// Empty terms.
		apply_filters( 'cmb2_sanitize_' . Type::TERM_SELECT_2->value, null, [], 1, [ 'id' => 'ts' ] );
		$this->assertEmpty( wp_get_object_terms( 1, 'category' ) );

		// Incorrect data structure. How would this happen?
		apply_filters( 'cmb2_sanitize_' . Type::TERM_SELECT_2->value, null, [ $cat_3, $cat_4, [ $cat_5 ] ], 1, [ 'id' => 'ts' ] );
		$this->assertSame( [ $cat_3, $cat_4, 1 ], wp_get_object_terms( 1, 'category', [ 'fields' => 'ids' ] ) );

		$box->field( 'ts', 'TS' )
		    ->taxonomy_select_2( 'category', true )
		    ->repeatable();
		apply_filters( 'cmb2_sanitize_' . Type::TERM_SELECT_2->value, null, [ [ $cat_1 ], [ $cat_2 ] ], 1, [ 'id' => 'ts' ] );
		$this->assertSame( [ $cat_1, $cat_2 ], wp_get_object_terms( 1, 'category', [ 'fields' => 'ids' ] ) );

		apply_filters( 'cmb2_sanitize_' . Type::TERM_SELECT_2->value, null, [ [ $cat_1 ], [ $cat_2, $cat_5 ] ], 1, [ 'id' => 'ts' ] );
		$this->assertSame( [ $cat_1, $cat_2, $cat_5 ], wp_get_object_terms( 1, 'category', [ 'fields' => 'ids' ] ) );

		// Object type does not support terms.
		set_private_property( $this->get_box(), 'object_types', [ Box::TYPE_COMMENT ] );
		apply_filters( 'cmb2_sanitize_' . Type::TERM_SELECT_2->value, null, [ [ $cat_1 ], [ $cat_4 ] ], 1, [ 'id' => 'ts' ] );
		$this->assertSame( [ $cat_1, $cat_2, $cat_5 ], wp_get_object_terms( 1, 'category', [ 'fields' => 'ids' ] ) );
	}


	public function test_esc_values(): void {
		// Field not registered.
		$this->assertNull( apply_filters( 'cmb2_types_esc_' . Type::TERM_SELECT_2->value, null, [ '1', '2' ], [ 'id' => 'ts' ] ) );

		$this->get_box();
		$this->assertSame( [ '1', '2' ], apply_filters( 'cmb2_types_esc_' . Type::TERM_SELECT_2->value, null, [ '1', '2' ], [ 'id' => 'ts' ] ) );

		$this->assertSame( [ '1', [ '2', '5' ] ], apply_filters( 'cmb2_types_esc_' . Type::TERM_SELECT_2->value, null, [ '1', [ 2, '5' ] ], [ 'id' => 'ts' ] ) );
	}


	public function test_render(): void {
		[ $cat_1, $cat_2, $cat_3 ] = self::factory()->category->create_many( 10 );
		$box = $this->get_box();
		$echo = function( array|string $value ) use ( $box ) {
			return get_echo( function() use ( $value, $box ) {
				$fields = call_private_method( $box, 'get_fields' );
				$field = new \CMB2_Field( [ 'field_args' => $fields['ts']->get_field_args() ] );
				do_action( 'cmb2_render_' . Type::TERM_SELECT_2->value, $field, $value, 1, 'post', new \CMB2_Types( $field ) );
			} );
		};

		$this->assertMatchesRegularExpression( "/<input type=\"hidden\" id=\"ts_nonce\" name=\"ts_nonce\" value=\"[0-9a-z]+\" \/><select multiple=\"multiple\" data-js='ts' name=\"ts\[\]\" id=\"ts\" class=\"regular-text\">	<option value=\"\d+\"\s*selected='selected'>Term \d+<\/option>\s*<\/select>/", $echo( [ $cat_1 ] ) );
		$this->assertMatchesRegularExpression( "/<select multiple=\"multiple\" data-js='ts' name=\"ts\[\]\" id=\"ts\" class=\"regular-text\">\s*<option value=\"\d+\"\s*selected='selected'>Term \d+<\/option>\s*<option value=\"\d+\"\s*selected='selected'>Term \d+<\/option>\s*<option value=\"\d+\"\s*selected='selected'>Term \d+<\/option>\s*<\/select>/", $echo( [ $cat_1, $cat_2, $cat_3 ] ) );

		$this->assertMatchesRegularExpression( "/<input type=\"hidden\" id=\"ts_nonce\" name=\"ts_nonce\" value=\"[0-9a-z]+\" \/>/", $echo( '' ) );
	}


	public function test_js_config(): void {
		$url = html_entity_decode( admin_url( 'admin-ajax.php' ) );
		$this->assertSame( [
			'ajaxUrl' => add_query_arg( [ 'action' => Term_Select_2::GET_TERMS ], $url ),
			'fields'  => [],
		], json_decode( wp_json_encode( Term_Select_2::in()->js_config() ), true ) );

		$box = $this->get_box();
		$this->assertSame( [
			'ajaxUrl' => add_query_arg( [ 'action' => Term_Select_2::GET_TERMS ], $url ),
			'fields'  => [
				[
					'id'            => 'ts',
					'noResultsText' => 'No categories found.',
				],
			],
		], json_decode( wp_json_encode( Term_Select_2::in()->js_config() ), true ) );

		$box->field( 'rs', 'RS' )
		    ->taxonomy_select_2( 'post_tag' );
		$this->assertSame( [
			'ajaxUrl' => add_query_arg( [ 'action' => Term_Select_2::GET_TERMS ], $url ),
			'fields'  => [
				[
					'id'            => 'ts',
					'noResultsText' => 'No categories found.',
				],
				[
					'id'            => 'rs',
					'noResultsText' => 'No tags found.',
				],
			],
		], json_decode( wp_json_encode( Term_Select_2::in()->js_config() ), true ) );

		$box->field( 'ts', 'TS' )
		    ->taxonomy_select_2( 'category', false, 'Nothing found.' );
		$this->assertSame( [
			'ajaxUrl' => add_query_arg( [ 'action' => Term_Select_2::GET_TERMS ], $url ),
			'fields'  => [
				[
					'id'            => 'ts',
					'noResultsText' => 'Nothing found.',
				],
				[
					'id'            => 'rs',
					'noResultsText' => 'No tags found.',
				],
			],
		], json_decode( wp_json_encode( Term_Select_2::in()->js_config() ), true ) );
	}


	public function test_ajax_get_terms(): void {
		self::factory()->category->create();
		$this->_handleAjax( Term_Select_2::GET_TERMS );
		$this->assertEmpty( $this->_last_response );

		$this->get_box();

		// No nonce.
		try {
			$this->_handleAjax( Term_Select_2::GET_TERMS );
		} catch ( \WPAjaxDieStopException $e ) {
			$this->assertSame( '-1', $e->getMessage() );
		}
		$this->assertEmpty( $this->_last_response );

		// No passed field.
		$_POST['_wpnonce'] = wp_create_nonce( Term_Select_2::NONCE );
		$this->send_request_ends_in_wp_send();
		$this->assertSame( '{"success":false,"data":"Field not found."}', $this->_last_response );

		$_POST['id'] = 'ts';
		$_POST['_wpnonce'] = wp_create_nonce( Term_Select_2::NONCE . 'ts' );
		$this->send_request_ends_in_wp_send();
		$this->assertMatchesRegularExpression( '/\{"success":true,"data":\[\{"id":\d+,"text":"Term \d+"\},\{"id":\d+,"text":"Uncategorized"\}\]\}/', $this->_last_response );

		$_POST['selected'] = [ '1' ];
		$this->send_request_ends_in_wp_send();
		$this->assertMatchesRegularExpression( '/\{"success":true,"data":\[\{"id":\d+,"text":"Term \d+"\}\]\}/', $this->_last_response );
	}


	private function get_box(): Box {
		$box = new Box( 'no-title', [ 'post' ], null );
		$box->field( 'ts', 'TS' )
		    ->taxonomy_select_2( 'category' );
		return $box;
	}


	private function send_request_ends_in_wp_send(): void {
		try {
			$this->_handleAjax( Term_Select_2::GET_TERMS );
		} catch ( \WPAjaxDieContinueException $e ) {
			$this->assertSame( '', $e->getMessage() );
		}
	}
}
