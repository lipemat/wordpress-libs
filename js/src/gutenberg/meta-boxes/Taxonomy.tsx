import {CONFIG} from '../../config';
import RadioTerms from './Taxonomy/RadioTerms';
import DropdownTerms from './Taxonomy/DropdownTerms';
import {type ComponentType} from 'react';
import WithTaxonomyPanel, {type FromPanel} from '../higher-order/WithTaxonomyPanel';
import SimpleTerms from './Taxonomy/SimpleTerms';


export type TaxonomyMetaBox = {
	type: 'radio' | 'dropdown' | 'simple';
	taxonomy: string;
	checkedOnTop: boolean;
};

type Props = {};


const Taxonomy = ( {}: Props ) => {
	return ( <>
		{CONFIG.taxonomyMetaBoxes?.map( ( metaBox: TaxonomyMetaBox ) => {
			let component: ComponentType<FromPanel> | null = null;
			switch ( metaBox.type ) {
				case 'radio':
					component = RadioTerms;
					break;
				case 'dropdown':
					component = DropdownTerms;
					break;
				case 'simple':
					component = SimpleTerms;
					break;
			}

			return WithTaxonomyPanel( component, {
				taxonomy: metaBox.taxonomy,
				checkedOnTop: metaBox.checkedOnTop,
			} );
		} )}
	</> );
};

export default Taxonomy;
