import {RadioControl} from '@wordpress/components';
import type {FromPanel} from '../../higher-order/WithTaxonomyPanel';

import styles from './radio.pcss';

const RadioTerms = ( {assigned, setAssigned, terms}: FromPanel ) => {
	return (
		<RadioControl
			className={styles.control}
			selected={assigned[ 0 ] ?? ''}
			options={terms.map( term => ( {label: term.name, value: term.id} ) )}
			onChange={state => {
				setAssigned( null === state ? [] : [ parseInt( state ) ] );
			}}
		/>
	);
};

export default RadioTerms;
