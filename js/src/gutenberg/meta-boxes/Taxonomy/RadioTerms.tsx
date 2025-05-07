import {RadioControl} from '@wordpress/components';
import type {FromPanel} from './WithTaxonomyPanel';

import styles from './radio.pcss';

const RadioTerms = ( {assigned, setAssigned, terms, tax}: FromPanel ) => {
	const options = terms.map( term => ( {label: term.name, value: term.id.toString()} ) );
	options.push( {label: tax?.labels.no_item ?? 'None', value: '0'} );

	return (
		<RadioControl
			className={styles.control}
			selected={( assigned[ 0 ] ?? 0 ).toString()}
			options={options}
			onChange={state => {
				setAssigned( '0' === state ? [] : [ parseInt( state ) ] );
			}}
		/>
	);
};

export default RadioTerms;
