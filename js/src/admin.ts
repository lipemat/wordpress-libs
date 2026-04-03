import './modules/cmb2/box-tabs';
import './modules/taxonomy/terms-checklist';

if ( 'undefined' !== typeof window.LIPE_LIBS_CMB2_TERM_SELECT2 ) {
	require( './modules/cmb2/taxonomy-select-2' );
}
if ( undefined !== window.LIPE_LIBS_CMB2_GROUP_MAX_ROWS ) {
	require( './modules/cmb2/group-max-rows' );
}
