<?php
declare( strict_types=1 );

namespace Lipe\Lib\Theme;

/**
 * @author Mat Lipe
 * @since  May 2023
 *
 */
class CSS_ModulesTest extends \WP_UnitTestCase {

	public function test_styles() : void {
		CSS_Modules::in()->use_combined_file( '' );
		CSS_Modules::in()->set_path( dirname( __DIR__, 2 ) . '/data/_css-modules-json', 'template-parts/' );

		$this->assertEquals( [
			'wrap'         => 'Ⓜform-login__wrap__Nc',
			'text'         => 'Ⓜform-login__text__jf',
			'icon'         => 'Ⓜform-login__icon__SY',
			'button'       => 'Ⓜform-login__button__Zg teal-button',
			'lostPassword' => 'Ⓜform-login__lostPassword__eA',
		], CSS_Modules::in()->styles( '../woocommerce/myaccount/form-login' ) );

		$this->assertEquals( [
			"wrap" => "Ⓜlined-title__wrap__Em",
		], CSS_Modules::in()->styles( 'blocks/lined-title' ) );
	}


	public function test_combined_styles() : void {
		CSS_Modules::in()->use_combined_file( 'modules.json' );
		CSS_Modules::in()->set_path( dirname( __DIR__, 2 ) . '/data', 'template-parts/' );

		$this->assertEquals( [
			'wrap'         => 'Ⓜform-login__wrap__Nc',
			'text'         => 'Ⓜform-login__text__jf',
			'icon'         => 'Ⓜform-login__icon__SY',
			'button'       => 'Ⓜform-login__button__Zg teal-button',
			'lostPassword' => 'Ⓜform-login__lostPassword__eA',
		], CSS_Modules::in()->styles( '../woocommerce/myaccount/form-login' ) );

		$this->assertEquals( [
			"wrap" => "Ⓜlined-title__wrap__Em",
		], CSS_Modules::in()->styles( 'blocks/lined-title' ) );
	}
}
