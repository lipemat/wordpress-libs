import {CheckboxControl} from '@wordpress/components';
import type {FromPanel} from './WithTaxonomyPanel';

import styles from './simple-terms.pcss';


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
				className={styles.control}
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
