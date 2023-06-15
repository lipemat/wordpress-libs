<?php

namespace Lipe\Lib\CMB2\Box;

use Lipe\Lib\CMB2\Field;
use Lipe\Lib\Theme\Class_Names;
use Lipe\Lib\Traits\Singleton;
use Lipe\Lib\Util\Url;

/**
 * Support Tabs in meta boxes.
 *
 * @usage Assign and array of tabs to a box when registering it
 *        via the Lipe\Lib\CMB2\Box::add_tab() method.
 *        Then use the Lipe\Lib\CMB2\Field::tab() method to assign each field to a particular tab.
 *        Every field a box has must be assigned to a tab or none will display.
 */
class Tabs {
	use Singleton;

	protected const TAB_FIELD = 'lipe/lib/cmb2/box/tabs/active-tab';

	/**
	 * Current CMB2 instance
	 *
	 * @var \CMB2
	 */
	protected $cmb;

	/**
	 * @var bool
	 */
	protected $has_tabs = false;

	/**
	 * Active Panel
	 *
	 * @var string
	 */
	protected $active_panel = '';

	/**
	 * @var array
	 */
	protected $fields_output = [];


	/**
	 * Called via self::init_once() from various entry points
	 *
	 * @return void
	 */
	protected function hook() : void {
		add_action( 'cmb2_before_form', [ $this, 'opening_div' ], 10, 4 );
		add_action( 'cmb2_after_form', [ $this, 'closing_div' ], 20, 0 );

		add_action( 'cmb2_before_form', [ $this, 'render_nav' ], 20, 4 );
		add_action( 'cmb2_after_form', [ $this, 'show_panels' ], 10, 4 );

		add_filter( 'cmb2_wrap_classes', [ $this, 'add_wrap_class' ] );
	}


	/**
	 *
	 * @param string     $cmb_id
	 * @param string|int $object_id
	 * @param string     $object_type
	 * @param \CMB2      $cmb
	 *
	 * @return void
	 */
	public function opening_div( $cmb_id, $object_id, $object_type, $cmb ) : void {
		if ( ! $cmb->prop( 'tabs' ) ) {
			return;
		}
		$this->cmb = $cmb;
		$this->has_tabs = true;

		$tab_style = $cmb->prop( 'tab_style' );
		$classes = new Class_Names( [
			'cmb-tabs',
			'clearfix',
			'cmb-tabs-' . $tab_style => null !== $tab_style,
		] );

		$this->styles();

		?>
		<input name="_wp_http_referer" value="<?= esc_url( Url::in()->get_current_url() ) ?>" type="hidden" />
		<div class="<?= esc_attr( $classes ) ?>">
		<?php
	}


	public function closing_div() : void {
		if ( ! $this->has_tabs ) {
			return;
		}
		echo '</div>';

		$this->has_tabs = false;
		$this->fields_output = [];

	}


	/**
	 * @param string $cmb_id
	 * @param int    $object_id
	 * @param string $object_type
	 * @param \CMB2  $cmb
	 *
	 * @return void
	 */
	public function render_nav( $cmb_id, $object_id, $object_type, $cmb ) : void {
		$tabs = $cmb->prop( 'tabs' );

		if ( $tabs ) {
			echo '<ul class="cmb-tab-nav">';

			if ( empty( $_REQUEST[ self::TAB_FIELD ] ) ) { //phpcs:ignore
				$active_nav = key( $tabs );
			} else {
				//phpcs:ignore
				$active_nav = esc_attr( sanitize_text_field( wp_unslash( $_REQUEST[ self::TAB_FIELD ] ) ) );
			}

			foreach ( $tabs as $key => $label ) {
				$class = "cmb-tab-$key";
				if ( $key === $active_nav ) {
					$class .= ' cmb-tab-active';
					$this->active_panel = $key;
				}

				printf(
					'<li class="%s" data-panel="%s"><a href="#"><span>%s</span></a></li>',
					esc_attr( $class ),
					esc_attr( $key ),
					esc_html( $label )
				);
			}

			echo '</ul>';

		}
	}


	public function add_wrap_class( array $classes ) : array {
		if ( $this->has_tabs ) {
			$classes[] = 'cmb-tabs-panel';
			if ( ! empty( $this->fields_output ) ) {
				$classes[] = 'cmb2-wrap-tabs';
			}
		}

		return \array_unique( $classes );
	}


	/**
	 * Replaces the render_field callback for a field, which as been
	 * assigned to a tab
	 *
	 * @param array       $field_args
	 * @param \CMB2_Field $field
	 *
	 * @see Field::tab()
	 *
	 * @return void
	 */
	public function render_field( array $field_args, \CMB2_Field $field ) : void {
		ob_start();
		if ( isset( $field_args['tab_content_cb'] ) && \is_callable( $field_args['tab_content_cb'] ) ) {
			$field_args['tab_content_cb']( $field_args, $field );
		} else {
			if ( 'group' === $field_args['type'] ) {
				$this->cmb->render_group_callback( $field_args, $field );
			} else {
				$field->render_field_callback();
			}
		}
		$output = ob_get_clean();
		echo $this->capture_fields( $output, $field_args ); //phpcs:ignore
	}


	/**
	 * @param string $cmb_id
	 * @param int    $object_id
	 * @param string $object_type
	 * @param \CMB2  $cmb
	 *
	 * @return void
	 */
	public function show_panels( $cmb_id, $object_id, $object_type, $cmb ) : void {
		if ( ! $this->has_tabs || empty( $this->fields_output ) ) {
			return;
		}

		echo '<div class="', esc_attr( $cmb->box_classes() ), '">
					<div id="cmb2-metabox-', sanitize_html_class( $cmb_id ), '" class="cmb2-metabox cmb-field-list">';

		foreach ( $this->fields_output as $tab => $fields ) {
			$active_panel = $this->active_panel === $tab ? 'show' : '';
			echo '<div class="' . esc_attr( $active_panel ) . ' cmb-tab-panel cmb2-metabox cmb-tab-panel-' . esc_attr( $tab ) . '">';
			echo implode( '', $fields ); //phpcs:ignore
			echo '</div>';
		}

		echo '</div></div>';
	}


	public function capture_fields( string $output, array $field_args ) : string {
		if ( ! $this->has_tabs || ! isset( $field_args['tab'] ) ) {
			return $output;
		}

		$tab = $field_args['tab'];

		if ( ! isset( $this->fields_output[ $tab ] ) ) {
			$this->fields_output[ $tab ] = [];
		}
		$this->fields_output[ $tab ][] = $output;

		return '';
	}


	protected function styles() : void {
		static $displayed = false;
		if ( $displayed ) {
			return;
		}
		$displayed = true;
		?>
		<script>
			jQuery( function( $ ){
				'use strict';
				$( '.cmb-tab-nav' ).on( 'click', 'a', function( e ){
					e.preventDefault();
					var $li = $( this ).parent(),
						panel = $li.data( 'panel' ),
						$wrapper = $li.parents( '.cmb-tabs' ).find( '.cmb2-wrap-tabs' ),
						$panel = $wrapper.find( '[class*="cmb-tab-panel-' + panel + '"]' );

					try {
						var $redirect = $('[name="_wp_http_referer"]'),
						url = new URL( $redirect.val() );
						url.searchParams.set( '<?= esc_js( static::TAB_FIELD ) ?>', panel );
						$redirect.val( url.toString() );
					} catch( e ) {
						console.error( e );
					}

					$li.addClass( 'cmb-tab-active' ).siblings().removeClass( 'cmb-tab-active' );
					$wrapper.find( '.cmb-tab-panel' ).removeClass( 'show' );
					$panel.addClass( 'show' );
				} );
			} );
		</script>
		<style>
			/* <?= __FILE__ ?> */
			.clearfix:after {
				visibility: hidden;
				display: block;
				font-size: 0;
				content: " ";
				clear: both;
				height: 0;
			}

			.clearfix {
				display: inline-block;
			}

			/* start commented backslash hack \*/
			* html .clearfix {
				height: 1%;
			}

			.clearfix {
				display: block;
			}

			/* close commented backslash hack */

			/*--------------------------------------------------------------
			Base style
			--------------------------------------------------------------*/
			.cmb-tabs {
				background: #fff;
			}

			.cmb-tabs .cmb-th {
				width: 150px !important;
			}

			.cmb-tabs .cmb-th label {
				color: #555;
				font-size: 13px;
				padding: 0;
			}

			.cmb2-options-page .cmb-tabs .cmb-th label {
				color: #222222;
				font-size: 14px;
				font-weight: 600;
			}

			.cmb-tabs .cmb-type-group .cmb-row,
			.cmb-tabs .cmb2-postbox .cmb-row {
				margin: 0 0 0.8em !important;
				padding: 0 0 0.8em !important;
			}

			.cmb-tabs span.cmb2-metabox-description {
				display: block;
			}

			.cmb-tabs .cmb-repeat-row {
				position: relative;
			}

			.cmb-tabs .cmb-remove-row {
				display: inline;
				margin: 0;
				padding: 0;
			}

			.cmb-tabs .cmb-repeat-row .cmb-td {
				display: inline-block;
			}

			.cmb-tab-panel .checkbox-compact {
				padding: 10px 2% 10px !important;
			}

			.cmb-tabs .cmb-add-row {
				margin: 0;
			}

			/*--------------------------------------------------------------
			CMB2 Tabs
			--------------------------------------------------------------*/
			.cmb-tabs {
				border: 1px solid #e9e9e9;
				overflow: hidden;
			}

			.cmb-tabs ul.cmb-tab-nav:after {
				background-color: #fafafa;
				border-right: 1px solid #eee;
				bottom: -9999em;
				content: "";
				display: block;
				height: 9999em;
				left: 0;
				position: absolute;
				width: calc(100% - 1px);
			}

			.cmb-tabs ul.cmb-tab-nav {
				background-color: #fafafa;
				-webkit-box-sizing: border-box;
				box-sizing: border-box;
				display: block;
				line-height: 1em;
				margin: 0;
				padding: 0;
				position: relative;
				width: 20%;
				float: left;
			}

			.cmb2-options-page .cmb-tabs-vertical ul.cmb-tab-nav {
				margin-right: -1px
			}

			.cmb-tabs ul.cmb-tab-nav li {
				display: block;
				margin: 0;
				padding: 0;
				position: relative;
			}

			.cmb-tabs i,
			.cmb-tabs i:before {
				font-size: 16px;
				vertical-align: middle;
			}

			.cmb-tabs ul.cmb-tab-nav li a {
				border-right: 1px solid #eee;
				border-left: 2px solid #fafafa;
				-webkit-box-shadow: none;
				box-shadow: none;
				display: block;
				line-height: 20px;
				margin: 0;
				padding: 10px;
				text-decoration: none;
				display: -webkit-box;
				display: -ms-flexbox;
				display: flex;
				-webkit-box-align: center;
				-ms-flex-align: center;
				align-items: center;
				font-weight: 600;
			}

			.cmb-tabs ul.cmb-tab-nav li i {
				display: -webkit-box;
				display: -ms-flexbox;
				display: flex;
				-webkit-box-align: center;
				-ms-flex-align: center;
				align-items: center;
			}

			.cmb-tabs ul.cmb-tab-nav li i,
			.cmb-tabs ul.cmb-tab-nav li img {
				padding: 0 5px 0 0px;
			}

			.cmb-tabs ul.cmb-tab-nav li a {
				color: #555;
				border: 1px solid transparent;
			}

			.cmb-tabs ul.cmb-tab-nav li.cmb-tab-active a {
				background-color: #fff;
				position: relative;
				border: 1px solid #eee;
				border-left: 3px solid #00a0d2;
				border-right-color: #fff;
			}

			.cmb-tabs ul.cmb-tab-nav li:first-of-type.cmb-tab-active a {
				border-top: none;
			}

			.cmb-tabs .cmb-tabs-panel {
				-webkit-box-sizing: border-box;
				box-sizing: border-box;
				color: #555;
				display: none !important;
				width: 80%;
				padding: 0;
			}

			.cmb-tabs .cmb-tabs-panel.cmb2-wrap-tabs {
				display: inline-flex !important;
				padding: 0;
			}

			.cmb-tabs .cmb2-metabox {
				display: block;
				width: 100%;
			}

			.cmb2-options-page .cmb-tabs-vertical.cmb-tabs .cmb-row {
				padding: 1.5em;
			}

			.cmb2-options-page .cmb-tabs .cmb-repeatable-group .cmb-group-name {
				margin: 0 0 10px;
			}

			.cmb-tabs .cmb-th,
			.cmb-tabs .cmb-td {
				padding: 10px 2%;
				-webkit-box-sizing: border-box;
				box-sizing: border-box;
			}

			.cmb2-options-page .cmb-tabs .cmb-td {
				padding: 10px 0;
			}

			.cmb-tabs .cmb-th {
				width: 18%;
			}

			.cmb-tabs .cmb-th + .cmb-td,
			.cmb-tabs .cmb-th + .cmb-td {
				float: right;
				width: calc( 100% - 175px );
			}

			.cmb2-wrap-tabs .cmb-tab-panel {
				display: none;
			}

			.cmb2-wrap-tabs .cmb-tab-panel.show {
				display: block;
			}

			/*--------------------------------------------------------------
			Horizontal Tabs
			--------------------------------------------------------------*/
			.cmb-tabs.cmb-tabs-horizontal ul.cmb-tab-nav {
				width: 100%;
				float: none;
				background-color: #fafafa;
				border-right: medium none;
				padding: 0;
			}

			.cmb2-options-page .cmb-tabs .cmb2-metabox > .cmb-row {
				border: none !important;
			}

			.cmb2-options-page .cmb-tabs.cmb-tabs-horizontal ul.cmb-tab-nav {
				margin-bottom: -8px;
				padding: 0 0 0 0;
				border-bottom: none;
			}

			.cmb-tabs.cmb-tabs-horizontal .cmb-tab-nav li {
				background: #ebebeb none repeat scroll 0 0;
				margin: 0 5px -1px 5px;
				display: inline-block;
			}

			.cmb-tabs.cmb-tabs-horizontal .cmb-tab-nav li:first-of-type {
				margin-left: 18px;
			}

			.cmb2-options-page .cmb-tabs.cmb-tabs-horizontal ul.cmb-tab-nav li:first-of-type {
				margin-left: 0;
			}

			.cmb-tabs.cmb-tabs-horizontal ul.cmb-tab-nav::after {
				display: none;
			}

			.cmb-tabs.cmb-tabs-horizontal .cmb-tabs-panel {
				width: 100%;
			}

			.cmb-tabs.cmb-tabs-horizontal .cmb-tab-panel {
				padding-top: 10px;
			}

			.cmb-tabs.cmb-tabs-horizontal ul.cmb-tab-nav li a {
				padding: 8px 12px;
				background-color: #fafafa;
				border: none;
				border-bottom: 1px solid #dedede;
			}

			.cmb2-options-page .cmb-tabs.cmb-tabs-horizontal ul.cmb-tab-nav li a {
				border: none;
			}

			.cmb-tabs.cmb-tabs-horizontal ul.cmb-tab-nav li.cmb-tab-active a {
				background-color: #fff;
				border-color: #fff;
				border: none;
				border-top: 2px solid #00a0d2;
				border-bottom: 1px solid #fff;
			}

			.cmb2-options-page .cmb-tabs.cmb-tabs-horizontal ul.cmb-tab-nav li.cmb-tab-active a {
				border-bottom: 2px solid #fff;
				margin-bottom: -1px;
			}

			.cmb2-options-page .cmb-tabs .cmb2-metabox > .cmb-row > .cmb-th + .cmb-td {
				margin-left: 175px;
			}

			/*--------------------------------------------------------------
			Media Query
			--------------------------------------------------------------*/
			@media (max-width: 750px) {
				.cmb-tabs ul.cmb-tab-nav {
					width: 10%;
				}

				.cmb-tabs .cmb-tabs-panel {
					width: 90%;
				}

				.cmb-tabs ul.cmb-tab-nav li i,
				.cmb-tabs ul.cmb-tab-nav li img {
					padding: 0;
					margin: 0 auto;
					text-align: center;
					display: block;
					max-width: 25px;
				}

				.cmb-tabs ul.cmb-tab-nav li span {
					padding: 10px;
					position: relative;
					text-indent: -999px;
					display: none;
				}
			}

			@media (max-width: 500px) {
				.cmb-tabs .cmb-th,
				.cmb-tabs .cmb-th + .cmb-td,
				.cmb-tabs .cmb-th + .cmb-td {
					float: none;
					width: 96%;
				}

				.cmb-tabs .cmb-repeat-row .cmb-td {
					width: auto;
				}
			}
		</style>
		<?php

	}

}
