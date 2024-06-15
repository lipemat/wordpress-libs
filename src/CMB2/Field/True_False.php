<?php
declare( strict_types=1 );

namespace Lipe\Lib\CMB2\Field;

use Lipe\Lib\Libs\Scripts;
use Lipe\Lib\Libs\Scripts\StyleHandles;

/**
 * True/False checkbox toggle field.
 *
 */
class True_False extends \CMB2_Type_Checkbox {
	/**
	 * Identical to the parent render except we use our own method
	 * for wrapping the input in the appropriate elements
	 *
	 * @param array<mixed> $args - Not actually used for anything.
	 *
	 * @return \CMB2_Type_Base|string
	 */
	public function render( $args = [] ): \CMB2_Type_Base|string {
		$defaults = [
			'type'  => 'checkbox',
			'class' => 'cmb2-option cmb2-list',
			'value' => 'on',
			'desc'  => '',
		];

		$meta_value = $this->types->field->escaped_value();
		$is_checked = $this->is_checked;
		if ( null === $is_checked ) {
			$is_checked = '' !== $meta_value;
		}

		if ( (bool) $is_checked ) {
			$defaults['checked'] = 'checked';
		}

		return $this->rendered(
			sprintf(
				'%s %s',
				$this->render_toggle_field( $defaults ),
				$this->types->_desc()
			)
		);
	}


	/**
	 * Generates a CSS only driven toggle on/off field.
	 *
	 * @param array<mixed> $args - Field arguments.
	 *
	 * @return string
	 */
	protected function render_toggle_field( array $args ): string {
		$args['class'] .= ' lipe-lib-true-false-checkbox';
		$args = $this->parse_args( 'checkbox', $args );
		$for = $this->types->_id();
		if ( isset( $args['readonly'] ) || isset( $args['disabled'] ) ) {
			// Labels not matching field id won't toggle the checkbox when clicked.
			// This won't match, but we can target via CSS.
			$for = 'readonly';
		}

		add_action( 'admin_footer', function() {
			Scripts::in()->enqueue_style( StyleHandles::TRUE_FALSE );
		} );

		ob_start();
		?>
		<div class="lipe-lib-true-false-wrap">
			<?php
			// phpcs:ignore WordPress.Security.EscapeOutput -- Expected HTML.
			echo \CMB2_Type_Text::render( $args );
			?>
			<label class="lipe-lib-true-false-label" for="<?= esc_attr( $for ) ?>">
				<span class="lipe-lib-true-false-inner"></span>
				<span class="lipe-lib-true-false-switch"></span>
			</label>
		</div>
		<?php
		return (string) \ob_get_clean();
	}
}
