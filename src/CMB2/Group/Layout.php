<?php
declare( strict_types=1 );

namespace Lipe\Lib\CMB2\Group;

use Lipe\Lib\CMB2\Group;
use Lipe\Lib\Libs\Scripts;
use Lipe\Lib\Libs\Scripts\StyleHandles;
use Lipe\Lib\Theme\Class_Names;
use Lipe\Lib\Traits\Memoize;
use Lipe\Lib\Traits\Singleton;

/**
 * Custom group layouts for tables and lists.
 */
class Layout {
	use Singleton;
	use Memoize;

	public const BLOCK = 'block';
	public const TABLE = 'table';
	public const ROW   = 'row';


	/**
	 * Is this a table layout?
	 *
	 * @param \CMB2_Field $field_group - The CMB2_Field group object.
	 *
	 * @return bool
	 */
	protected function is_table( \CMB2_Field $field_group ): bool {
		return ( self::TABLE === $field_group->args( 'layout' ) );
	}


	/**
	 * Is this a repeatable group?
	 *
	 * @param \CMB2_Field $field_group - The CMB2_Field group object.
	 *
	 * @return bool
	 */
	protected function is_repeatable( \CMB2_Field $field_group ): bool {
		return (bool) $field_group->args( 'repeatable' );
	}


	/**
	 * Copied mostly from CMB2::render_group_callback()
	 *
	 * @see Group::layout()
	 * @see \CMB2::render_group_callback()
	 *
	 * @param array<string, mixed> $field_args  Array of field arguments for the group field parent.
	 * @param \CMB2_Field          $field_group The CMB2_Field group object.
	 *
	 * @return void
	 */
	public function render_group_callback( array $field_args, \CMB2_Field $field_group ): void {
		$cmb = \CMB2_Boxes::get( $field_group->cmb_id );
		// If field is requesting to be conditionally shown.
		if ( \is_bool( $cmb ) || ! $field_group->should_show() ) {
			return;
		}

		$field_group->index = 0;

		$field_group->peform_param_callback( 'before_group' );

		$desc = $field_group->args( 'description' );
		$label = $field_group->args( 'name' );
		$group_val = (array) $field_group->value();

		$classnames = new Class_Names( $field_group->row_classes(), [
			'cmb-row',
			'cmb-repeat-group-wrap',
			'cmb-group-table',
			'cmb-group-display-' . $field_group->args( 'layout' ),
			'cmb2-group-context-' . $field_group->args( 'context' ),
		], );

		echo '<div class="' . esc_attr( (string) $classnames ) . '" data-fieldtype="group"><div class="cmb-td">';

		// phpcs:ignore WordPress.Security.EscapeOutput --- Group wrap attributes are escaped in the method.
		echo '<div data-groupid="' . esc_attr( $field_group->id() ) . '" id="' . esc_attr( $field_group->id() ) . '_repeat" ' . $cmb->group_wrap_attributes( $field_group ) . '>';

		if ( \is_string( $desc ) || \is_string( $label ) ) {
			$classnames = new Class_Names( [
				'cmb-group-description' => $desc,
				'cmb-row'               => ! $this->is_table( $field_group ),
			] );
			echo '<div class="' . esc_attr( (string) $classnames ) . '">';

			if ( \is_string( $label ) && '' !== $label ) {
				echo '<h2 class="cmb-group-name cmb-layout-header">' . esc_html( $label ) . '</h2>';
			}
			if ( \is_string( $desc ) && '' !== $desc ) {
				echo '<p class="cmb2-metabox-description cmb-layout-description">' . esc_html( $desc ) . '</p>';
			}
			echo '</div>';
		}

		$classnames = new Class_Names( 'cmb-table', [
			'cmb-layout-non-repeatable' => ! $this->is_table( $field_group ) && ! $this->is_repeatable( $field_group ),
		] );

		?>
		<table class="<?= esc_attr( (string) $classnames ) ?>" cellpadding="0" cellspacing="0">
			<?php

			if ( $this->is_table( $field_group ) && (bool) $field_group->args( 'show_names' ) ) {
				$this->render_group_table_header( $field_group );
			}

			if ( [] !== $group_val ) {
				$count = \count( $group_val );
				for ( $i = 0; $i < $count; $i ++ ) {
					$this->render_group_table_row( $field_group );
					++ $field_group->index;
				}
			} else {
				$this->render_group_table_row( $field_group );
			}
			?>
		</table>
		<?php

		if ( $this->is_repeatable( $field_group ) ) {
			?>
			<div class="cmb-row">
				<div class="cmb-td">
					<p class="cmb-add-row">
						<button
							type="button"
							data-selector="<?= esc_attr( $field_group->id() ) ?>_repeat"
							data-grouptitle="{#}"
							class="cmb-add-group-row button-secondary"
						>
							<?= esc_html( $field_group->options( 'add_button' ) ) ?>
						</button>
					</p>
				</div>
			</div>
			<?php
		}

		echo '</div></div></div>';

		Scripts::in()->enqueue_style( StyleHandles::GROUP_LAYOUT );
		$field_group->peform_param_callback( 'after_group' );
	}


	/**
	 * Render a repeatable group row table header
	 *
	 * @param \CMB2_Field $field_group CMB2_Field group field object.
	 */
	public function render_group_table_header( \CMB2_Field $field_group ): void {
		?>
		<tr class="cmb-row">
			<?php
			if ( $this->is_repeatable( $field_group ) ) {
				?>
				<th></th>
				<?php
			}
			foreach ( $field_group->args( 'fields' ) as $_field ) {
				echo '<th>' . esc_html( $_field['name'] ) . '</th>';
			}
			if ( $this->is_repeatable( $field_group ) ) {
				?>
				<th></th>
				<?php
			}
			?>
		</tr>
		<?php
	}


	/**
	 * Render a repeatable group row as a table.
	 *
	 * Used when a group is given the 'display_as_table' property.
	 *
	 * @param \CMB2_Field $field_group CMB2_Field group field object.
	 *
	 * @return \CMB2|bool
	 */
	public function render_group_table_row( \CMB2_Field $field_group ): \CMB2|bool {
		$field_group->peform_param_callback( 'before_group_row' );
		$remove_confirm = $field_group->options( 'remove_confirm' );
		$classes = new Class_Names( [
			'cmb-row',
			'cmb-repeatable-grouping',
			'closed' => (bool) $field_group->options( 'closed' ),
		] );

		?>
		<tr
			id="cmb-group-<?= esc_attr( $field_group->id() ) ?>-<?= esc_attr( $field_group->index ) ?>"
			class="<?= esc_attr( (string) $classes ) ?>"
			data-iterator="<?= esc_attr( $field_group->index ) ?>"
		>
			<?php
			if ( $this->is_repeatable( $field_group ) ) {
				?>
				<td class="cmb-group-table-control">
					<h3 class="cmb-group-title cmbhandle-title">
						<span><?= esc_html( $field_group->replace_hash( '{#}' ) ) ?></span>
					</h3>
				</td>
				<?php
			}

			if ( $this->is_table( $field_group ) ) {
				foreach ( $field_group->args( 'fields' ) as $field_args ) {
					?>
					<td class="inside cmb-nested cmb-field-list">
						<?php $this->render_field( $field_args, $field_group ); ?>
					</td>
					<?php
				}
			} else {
				?>
				<td class="cmb-group-row-fields">
					<table>
						<?php
						foreach ( $field_group->args( 'fields' ) as $field_args ) {
							?>
							<tr>
								<th>
									<?= esc_html( $field_args['name'] ) ?>
								</th>
								<td>
									<?php $this->render_field( $field_args, $field_group ); ?>
								</td>
							</tr>
							<?php
						}
						?>
					</table>
				</td>
				<?php
			}

			if ( $this->is_repeatable( $field_group ) ) {
				?>
				<td class="cmb-remove-field-row cmb-group-table-control">
					<div class="cmb-remove-row">
						<a
							href="javascript:void(0)"
							type="button"
							data-selector="<?= esc_attr( $field_group->id() ) ?>_repeat"
							class="cmb-remove-group-row cmb-remove-group-row-button button-secondary cmb-shift-rows"
							data-confirm="<?= esc_attr( \is_string( $remove_confirm ) ? $remove_confirm : '' ) ?>"
							title="<?= esc_attr( $field_group->options( 'remove_button' ) ) ?>"
						>
							<span class="dashicons dashicons-no-alt" />
						</a>
					</div>
				</td>
				<?php
			}
			?>
		</tr>
		<?php

		$field_group->peform_param_callback( 'after_group_row' );

		return \CMB2_Boxes::get( $field_group->cmb_id );
	}


	/**
	 * Render a single field.
	 *
	 * @param array{type: string} $field_args  Array of field arguments.
	 * @param \CMB2_Field         $field_group CMB2_Field group field object.
	 */
	protected function render_field( array $field_args, \CMB2_Field $field_group ): void {
		$cmb = \CMB2_Boxes::get( $field_group->cmb_id );
		if ( \is_bool( $cmb ) ) {
			return;
		}
		if ( 'hidden' === $field_args['type'] ) {
			// Save rendering for after the metabox.
			$cmb->add_hidden_field( $field_args, $field_group );
		} else {
			$field_args['show_names'] = false;
			$field = $cmb->get_field( $field_args, $field_group );
			if ( false !== $field ) {
				$field->render_field();
			}
		}
	}
}
