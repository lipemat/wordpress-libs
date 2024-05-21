import {SelectControl} from '@wordpress/components';
import type {FromPanel} from './WithTaxonomyPanel';

const DropdownTerms = ( {assigned, setAssigned, terms, tax}: FromPanel ) => {
	const options = terms.map( term => ( {label: term.name, value: term.id.toString()} ) );
	options.unshift( {label: `- ${tax?.labels.no_terms ?? 'None'} -`, value: '0'} );

	return (
		<SelectControl
			value={( assigned[ 0 ] ?? 0 ).toString()}
			options={options}
			onChange={state => {
				setAssigned( '0' === state ? [] : [ parseInt( state ) ] );
			}}
		/>

	);
};

export default DropdownTerms;
