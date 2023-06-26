<?php

namespace Lipe\Lib\CMB2\Field;

/**
 * True/False checkbox toggle field.
 */
class True_False extends \CMB2_Type_Checkbox {

	/**
	 * Identical to the parent render except we use our own method
	 * for wrapping the input in the appropriate elements
	 *
	 * @param array $args - not actually used for anything.
	 *
	 * @return \CMB2_Type_Base|string
	 */
	public function render( $args = [] ) {
		$defaults = [
			'type'  => 'checkbox',
			'class' => 'cmb2-option cmb2-list',
			'value' => 'on',
			'desc'  => '',
		];

		$meta_value = $this->field->escaped_value(); // @phpstan-ignore-line

		$is_checked = $this->is_checked;
		if ( null === $is_checked ) {
			$is_checked = ! empty( $meta_value );
		}

		if ( (bool) $is_checked ) {
			$defaults['checked'] = 'checked';
		}

		return $this->rendered(
			sprintf(
				'%s %s',
				$this->render_toggle_field( $defaults ),
				/* @phpstan-ignore-next-line */
				$this->_desc()
			)
		);
	}

	/**
	 * Generates a CSS only driven toggle on/off field.
	 *
	 * @param array $args
	 *
	 * @return string
	 */
	protected function render_toggle_field( array $args ) : string {
		ob_start();
		$args['class'] .= ' checkbox-toggle-checkbox';
		$args = $this->parse_args( 'checkbox', $args );
		$for = $this->_id(); // @phpstan-ignore-line
		if ( ( isset( $args['readonly'] ) && ! empty( $args['readonly'] ) ) || ( isset( $args['disabled'] ) && ! empty( $args['disabled'] ) ) ) {
			// Labels not matching field id won't toggle the checkbox when clicked.
			// We set one that does not match but we can target via CSS.
			$for = 'readonly';
		}
		?>
		<div class="checkbox-toggle-wrap">
			<?= \CMB2_Type_Text::render( $args ); //phpcs:ignore  ?>
			<label class="checkbox-toggle-label" for="<?= esc_attr( $for ); ?>">
				<span class="checkbox-toggle-inner"></span>
				<span class="checkbox-toggle-switch"></span>
			</label>
		</div>
		<?php
		$this->styles();

		return ob_get_clean();
	}

	/**
	 * One-time loaded CSS to style the field
	 *
	 * @props Proto.IO which gave me the inspiration
	 *
	 * @link https://proto.io/freebies/onoff/
	 *
	 * @return void
	 */
	protected function styles() : void {
		static $displayed = false;
		if ( $displayed ) {
			return;
		}
		$displayed = true;

		?>
		<style>
			.checkbox-toggle-wrap {
				position: relative;
				width: 60px;
				box-sizing: content-box;
				-webkit-user-select: none;
				-moz-user-select: none;
				-ms-user-select: none;
			}

			.checkbox-toggle-wrap .checkbox-toggle-checkbox {
				display: none;
			}

			.checkbox-toggle-label {
				display: block;
				overflow: hidden;
				cursor: pointer;
				background: #f7f7f7;
				border-width: 1px;
				border-style: solid;
				border-color: #999;
				border-radius: 3px;
				transition: all 0.3s ease-in 0s;
			}
			.checkbox-toggle-label[for="readonly"] {
				cursor: default;
			}

			.checkbox-toggle-inner {
				display: block;
				width: 200%;
				margin-left: -100%;
				transition: margin 0.3s ease-in 0s;
			}

			.checkbox-toggle-inner:before, .checkbox-toggle-inner:after {
				display: block;
				float: left;
				width: 50%;
				height: 28px;
				padding: 0;
				line-height: 28px;
				font-size: 14px;
				color: white;
				box-sizing: border-box;
			}

			.checkbox-toggle-inner:before {
				content: "Yes";
				padding-left: 5px;
				background-color: #2A9BD8;
				color: #FFFFFF;
			}

			.checkbox-toggle-inner:after {
				content: "No";
				padding-right: 5px;
				color: #555;
				background: #f7f7f7;
				box-shadow: 0 1px 0 #cccccc;
				text-align: right;
			}

			.checkbox-toggle-switch {
				display: block;
				width: 18px;
				margin: 5px;
				background: #FFFFFF;
				position: absolute;
				top: 0;
				bottom: 0;
				right: 28px;
				border: 1px solid #999;
				border-radius: 3px;
				transition: all 0.3s ease-in 0s;
			}

			.checkbox-toggle-checkbox:checked + .checkbox-toggle-label .checkbox-toggle-inner {
				margin-left: 0;
			}

			.checkbox-toggle-checkbox:checked + .checkbox-toggle-label,
			.checkbox-toggle-checkbox:checked + .checkbox-toggle-label .checkbox-toggle-switch {
				border-color: #0073aa #006799 #006799;
				box-shadow: 0 1px 0 #006799;
				text-shadow: 0 -1px 1px #006799, 1px 0 1px #006799, 0 1px 1px #006799, -1px 0 1px #006799;
			}

			.checkbox-toggle-checkbox:checked + .checkbox-toggle-label {
				background: #0085ba;
			}

			.checkbox-toggle-checkbox:checked + .checkbox-toggle-label .checkbox-toggle-switch {
				right: 0;
			}
		</style>
		<?php
	}
}
