import {CheckboxControl} from '@wordpress/components';
import type {FromPanel} from './WithTaxonomyPanel';

import styles from './simple.pcss';

const SimpleTerms = ( {assigned, setAssigned, terms, tax}: FromPanel ) => {
	return ( <>
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
				__nextHasNoMarginBottom
			/>
		</div> ) )}
		<div className={styles.none}>
			<CheckboxControl
				className={styles.control}
				checked={0 === assigned.length}
				label={tax?.labels.no_terms ?? 'None'}
				onChange={checked => {
					if ( checked ) {
						setAssigned( [] );
					} else {
						setAssigned( terms.map( term => term.id ) );
					}
				}}
				__nextHasNoMarginBottom
			/>
		</div>
	</> );
};

export default SimpleTerms;
