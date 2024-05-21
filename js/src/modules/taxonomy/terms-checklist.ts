/**
 * Simple handling for the custom Taxonomy terms checklist.
 *
 * - If the "No terms" checkbox is checked, all other checkboxes are unchecked.
 * - If any other checkbox is checked, the "No terms" checkbox is unchecked.
 */
jQuery( function( $ ) {
	const lists = $( '[data-js="lipe/lib/taxonomy/terms-checklist"]' );
	lists.on( 'click', 'input[value="0"]', function() {
		const $this = $( this );
		if ( true === $this.prop( 'checked' ) ) {
			$this.closest( 'ul' ).find( 'input[type="checkbox"]' ).not( $this ).prop( 'checked', false );
		}
	} );
	lists.on( 'click', 'input', function() {
		const $this = $( this );
		if ( parseInt( $this.val() ) > 0 ) {
			$this.closest( 'ul' ).find( 'input[value="0"]' ).prop( 'checked', false );
		}
	} );
} );
