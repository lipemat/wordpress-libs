import type {AjaxOptions, Options, QueryOptions, DataFormat} from 'select2';
import {ADMIN} from '../../config';

export type SelectField = {
	id: string;
	noResultsText: string;
}

type Response = {
	success: true;
	data: DataFormat[]
} | {
	success: false;
	data: string;
}

const CONFIG = ADMIN.cmb2TermSelect2;

const AJAX: AjaxOptions<DataFormat> = {
	url: CONFIG.ajaxUrl,
	dataType: 'json',
	cache: true,
	type: 'POST',
	delay: 350,
	processResults: ( response: Response ) => {
		if ( ! response.success ) {
			console.error( response.data );
			return {results: []};
		}

		return {
			results: response.data,
		};
	},
};


function loadSelects( field: SelectField, lastOnly: boolean ) {
	let inputs = $( `div:not(.empty-row) > div > [data-js="${field.id}"]` );
	if ( 0 === inputs.length ) {
		return;
	}
	if ( lastOnly ) {
		inputs = inputs.last();
	}

	inputs.each( ( _i, element ) => {
		const thisInput = $( element );
		AJAX.data = ( options: QueryOptions ) => ( {
			term: options.term,
			id: field.id,
			selected: thisInput.val(),
		} );
		const config: Options = {
			ajax: AJAX,
			minimumInputLength: 3,
			language: {
				noResults: () => field.noResultsText,
			},
		};
		thisInput.select2( config );
	} );
}

jQuery( function( $ ) {
	CONFIG.fields.forEach( function( field ) {
		loadSelects( field, false );
		$( `[data-selector="${field.id}_repeat"]` ).on( 'click', function() {
			setTimeout( () => loadSelects( field, true ), 20 );
		} );
	} );
} );
