import {CheckboxControl} from '@wordpress/components';
import type {FromPanel} from './WithTaxonomyPanel';

const SimpleTerms = ( {assigned, setAssigned, terms, tax}: FromPanel ) => {
	return ( <>
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
		<div
			style={{
				borderTop: '1px solid #eee',
				color: '#888',
				marginTop: '12px',
				paddingTop: '12px',
			}}
		>
			<CheckboxControl
				checked={0 === assigned.length}
				label={tax?.labels.no_terms ?? 'None'}
				onChange={checked => {
					if ( checked ) {
						setAssigned( [] );
					} else {
						setAssigned( terms.map( term => term.id ) );
					}
				}}
			/>
		</div>
	</> );
};

export default SimpleTerms;
