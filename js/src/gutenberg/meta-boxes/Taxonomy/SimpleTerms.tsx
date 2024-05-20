import {CheckboxControl} from '@wordpress/components';
import type {FromPanel} from './WithTaxonomyPanel';

const SimpleTerms = ( {assigned, setAssigned, terms, tax}: FromPanel ) => {
	const options = terms.map( term => ( {label: term.name, value: term.id.toString()} ) );
	options.push( {label: tax?.labels.no_terms ?? 'None', value: '0'} );

	return ( <>
		###### START HERE ######
		<br />
		- Create a "no term assigned" option <br />
		- Adjust terms as needed
		<br />

		{terms.map( term => ( <div key={term.id}>
			<CheckboxControl
				checked={assigned.includes( term.id )}
				label={term.name}
				onChange={checked => {
					if ( checked ) {
						setAssigned( [ ...assigned, term.id ] );
					} else {
						setAssigned( assigned.filter( id => id !== term.id ) );
					}
				}}
			/>
		</div> ) )}
	</> );
};

export default SimpleTerms;
