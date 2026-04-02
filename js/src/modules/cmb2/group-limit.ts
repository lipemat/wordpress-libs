const CONFIG = window.LIPE_LIBS_CMB2_GROUP_LIMIT;
if ( ! CONFIG ) {
	throw new Error( 'LIPE_LIBS_CMB2_GROUP_LIMIT is not defined' );
}


function countRows( table: HTMLElement ): number {
	return table.querySelectorAll( '.cmb-row.cmb-repeatable-grouping' ).length;
}

/**
 * - Phase 1: Update {#} placeholder with the current number of rows.
 * - Phase 2: Update the button label with the current number of rows.
 *
 * Using `<span>` to wrap the number to give us something to target.
 */
function updateAddGroupButton( table: HTMLElement, addButton: HTMLButtonElement, limit: number ): void {
	// eslint-disable-next-line @lipemat/security/html-executing-assignment
	addButton.innerHTML = addButton.innerHTML.replace( /\{#}|<span>\d+<\/span>/, '<span>' + countRows( table ).toString() + '</span>' );

	if ( countRows( table ) >= limit ) {
		addButton.setAttribute( 'disabled', '' );
	} else {
		addButton.removeAttribute( 'disabled' );
	}
}


/**
 * Disable the "Add Group" button when a groups max_rows is reached.
 *
 * @link @link https://github.com/CMB2/CMB2-Snippet-Library/blob/master/javascript/limit-number-of-multiple-repeat-groups.php
 *
 * @see \Lipe\Lib\CMB2\Group\Max_Rows
 */
function limitFieldGroup( fieldGroupId: string, limit: number ): void {
	const table: HTMLElement | null = document.getElementById( fieldGroupId + '_repeat' );
	if ( null === table ) {
		return;
	}
	const addButton = table.querySelector<HTMLButtonElement>( '.cmb-add-group-row.button-secondary' );
	if ( null === addButton ) {
		return;
	}
	updateAddGroupButton( table, addButton, limit );

	$( table )
		.on( 'cmb2_add_row', function() {
			updateAddGroupButton( table, addButton, limit );
		} )
		.on( 'cmb2_remove_row', function() {
			updateAddGroupButton( table, addButton, limit );
		} );
}

jQuery( function() {
	CONFIG.forEach( function( field ) {
		limitFieldGroup( field.groupId, field.limit );
	} );
} );
