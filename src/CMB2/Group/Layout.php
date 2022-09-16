<?php

namespace Lipe\Lib\CMB2\Group;

use Lipe\Lib\CMB2\Group;
use Lipe\Lib\Theme\Class_Names;
use Lipe\Lib\Traits\Memoize;
use Lipe\Lib\Traits\Singleton;

/**
 * Custom group layouts for tables and lists.
 */
class Layout {
	use Singleton;
	use Memoize;

	protected function is_table( \CMB2_Field $field_group ) : bool {
		return ( 'table' === $field_group->args( 'layout' ) );
	}

	protected function is_repeatable( \CMB2_Field $field_group ) : bool {
		return (bool) $field_group->args( 'repeatable' );
	}


	/**
	 * Copied mostly from CMB2::render_group_callback()
	 *
	 * @param  array       $field_args  Array of field arguments for the group field parent.
	 * @param  \CMB2_Field $field_group The CMB2_Field group object.
	 *
	 * @see Group::layout()
	 * @see \CMB2::render_group_callback()
	 *
	 * @return \CMB2_Field|null Group field object.
	 */
	public function render_group_callback( $field_args, \CMB2_Field $field_group ) : ?\CMB2_Field {
		$cmb = \CMB2_Boxes::get( $field_group->cmb_id ); // @phpstan-ignore-line
		// If field is requesting to be conditionally shown.
		if ( ! $field_group->should_show() ) {
			return null;
		}

		$field_group->index = 0;

		$field_group->peform_param_callback( 'before_group' );

		$desc      = $field_group->args( 'description' );
		$label     = $field_group->args( 'name' );
		$group_val = (array) $field_group->value();

		echo '<div class="cmb-row cmb-repeat-group-wrap cmb-group-table cmb-group-display-' . esc_attr( $field_group->args( 'layout' ) ) . ' ' . esc_attr( $field_group->row_classes() ), '" data-fieldtype="group"><div class="cmb-td"><div data-groupid="' . esc_attr( $field_group->id() ) . '" id="' . esc_attr( $field_group->id() ) . '_repeat" ' . $cmb->group_wrap_attributes( $field_group ) . '>'; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		if ( $desc || $label ) {
			$classnames = new Class_Names( [
				'cmb-group-description' => $desc,
				'cmb-row'               => ! $this->is_table( $field_group ),
			] );
			echo '<div class="' . esc_attr( $classnames ) . '">';

			if ( $label ) {
				echo '<h2 class="cmb-group-name cmb-layout-header">' . esc_html( $label ) . '</h2>';
			}
			if ( $desc ) {
				echo '<p class="cmb2-metabox-description cmb-layout-description">' . esc_html( $desc ) . '</p>';
			}
			echo '</div>';
		}

		$classnames = new Class_Names( [
			'cmb-table'                 => true,
			'cmb-layout-non-repeatable' => ! $this->is_table( $field_group ) && ! $this->is_repeatable( $field_group ),
		] );

		echo '<table class="' . esc_attr( $classnames ) . '" cellpadding="0" cellspacing="0">';

		if ( $this->is_table( $field_group ) && $field_group->args( 'show_names' ) ) {
			$this->render_group_table_header( $field_group );
		}

		if ( ! empty( $group_val ) ) {
			foreach ( $group_val as $group_key => $field_id ) {
				$this->render_group_table_row( $field_group );
				$field_group->index ++;
			}
		} else {
			$this->render_group_table_row( $field_group );
		}

		echo '</table>';

		if ( $this->is_repeatable( $field_group ) ) {
			echo '<div class="cmb-row"><div class="cmb-td"><p class="cmb-add-row"><button type="button" data-selector="' . esc_attr( $field_group->id() ) . '_repeat" data-grouptitle="{#}" class="cmb-add-group-row button-secondary">' . esc_html( $field_group->options( 'add_button' ) ) . '</button></p></div></div>';
		}

		echo '</div></div></div>';

		$this->styles();
		$field_group->peform_param_callback( 'after_group' );

		return $field_group;

	}


	/**
	 * Render a repeatable group row table header
	 *
	 * @param  \CMB2_Field $field_group CMB2_Field group field object.
	 *
	 */
	public function render_group_table_header( $field_group ) : void {
		?>
		<tr class="cmb-row">
			<?php
			if ( $this->is_repeatable( $field_group ) ) {
				?>
				<th> </th>
				<?php
			}
			foreach ( $field_group->args( 'fields' ) as $_field ) {
				echo '<th>' . esc_html( $_field['name'] ) . '</th>';
			}
			if ( $this->is_repeatable( $field_group ) ) {
				?>
				<th> </th>
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
	 * @return \CMB2
	 */
	public function render_group_table_row( \CMB2_Field $field_group ) : \CMB2 {
		$field_group->peform_param_callback( 'before_group_row' );
		$closed_class     = $field_group->options( 'closed' ) ? ' closed' : '';
		$confirm_deletion = $field_group->options( 'remove_confirm' );
		$confirm_deletion = ! empty( $confirm_deletion ) ? $confirm_deletion : '';

		?>
		<tr
			id="cmb-group-<?= esc_attr( $field_group->id() ) ?>-<?= esc_attr( $field_group->index ) ?>"
		    class="cmb-row cmb-repeatable-grouping<?= esc_attr( $closed_class ) ?>"
		    data-iterator="<?= esc_attr( $field_group->index ) ?>">
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
									<?= esc_html( $field_args['name'] ); ?>
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
							data-confirm="<?= esc_attr( $confirm_deletion ) ?>"
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

		return \CMB2_Boxes::get( $field_group->cmb_id ); // @phpstan-ignore-line
	}


	protected function render_field( array $field_args, \CMB2_Field $field_group ) : void {
		$cmb = \CMB2_Boxes::get( $field_group->cmb_id ); // @phpstan-ignore-line
		if ( 'hidden' === $field_args['type'] ) {
			// Save rendering for after the metabox.
			$cmb->add_hidden_field( $field_args, $field_group );
		} else {
			$field_args['show_names'] = false;
			$cmb->get_field( $field_args, $field_group )->render_field();
		}
	}


	protected function styles() : void {
		$this->once( function () {
			?>
			<style>
				.cmb-group-table table {
					width: 100%;
				}

				.cmb-layout-non-repeatable,
				.cmb-group-table th {
					border-top: #DFDFDF solid 1px;
				}

				.cmb-group-table tr {
					background: #fff;
				}

				.cmb-group-table td:last-child,
				.cmb-group-table th:last-child {
					border-right: #DFDFDF solid 1px;
				}

				.cmb-group-table th,
				.cmb-group-table td {
					border-left: #DFDFDF solid 1px;
					border-bottom: #DFDFDF solid 1px;
					padding: 8px !important;
					vertical-align: top;
					text-align: left;
				}

				.cmb-group-table.cmb-group-display-row td {
					padding-bottom: 0 !important;
				}

				.cmb-group-table .cmb-th {
					width: 50%;
					padding: 0 10px;
					margin: 0 0 -10px 0;
					border-bottom: 1px solid #e9e9e9
				}

				.cmb-group-table .cmb-group-row-fields {
					padding: 0 !important;
					margin: 0 !important;
				}

				.cmb-group-row-fields td,
				.cmb-group-row-fields th {
					border: none !important;
					border-bottom: #EEEEEE solid 1px !important;
				}

				.cmb-group-row-fields tr:last-of-type td {
					border-bottom: none !important;
				}

				.cmb-group-row-fields th {
					width: 20%;
					vertical-align: top;
					background: #F9F9F9;
					border-right: 1px solid #E1E1E1 !important;
				}

				.cmb-group-table-control {
					width: 16px;
					padding: 0 !important;
					vertical-align: middle !important;
					text-align: center !important;
					background: #f4f4f4;
					text-shadow: #fff 0 1px 0;
				}

				.cmb-group-table .cmb-group-table-control a {
					float: none !important;
					display: block !important;
					margin: 5px 0 !important;
					text-align: center !important;
				}

				.cmb-group-table-control a,
				.cmb-group-table-control h3 {
					color: #aaa !important;
				}

				.cmb-group-table-control a:hover,
				.cmb-group-table-control:hover h3 {
					color: #23282d !important;
				}

				.cmb-group-table .cmb-group-table-control .cmb-remove-group-row {

					margin-top: 12px !important;
				}

				.cmb-group-table .cmb-group-table-control .cmb-remove-group-row span {
					color: #F55E4F !important;
					font-size: 23px;
					margin: 3px 0 0 -1px;
				}

				.cmb-repeatable-group.sortable .cmb-group-table-control:first-child {
					cursor: move;
				}

				.cmb-group-table .ui-sortable-helper {
					border-top: 1px solid #e9e9e9;
				}

				.cmb-group-table .cmb-group-title {
					position: relative;
					background: none;
					margin: 0 !important;
					padding: 0 !important;
				}

				.cmb-group-table th {
					width: auto;
				}

				.cmb-group-table .cmb-repeat-group-field {
					padding: 0 !important;
					margin: 0 0 0.5em !important;
				}

				.cmb2-options-page .cmb-repeatable-group .cmb-group-name,
				#poststuff .cmb-repeatable-group h2.cmb-group-name {
					font-size: 18px;
					font-weight: 500;
					margin: -10px 0 0 -10px;
				}

				.cmb-layout-description {
					margin: -10px 0 0 0 !important;
					padding: 0 0 3px 3px !important;
				}
			</style>
			<?php
		}, __METHOD__ );

	}
}
