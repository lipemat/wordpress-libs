import {CONFIG} from '../../config';
import RadioTerms from './RadioTerms';

export type TaxonomyMetaBox = {
	type: 'radio' | 'dropdown' | 'simple';
	taxonomy: string;
	checkedOnTop: boolean;
};

type Props = {};

console.log( CONFIG );

const Taxonomy = ( {}: Props ) => {
	return ( <>
		{CONFIG.taxonomyMetaBoxes?.map( ( metaBox, index ) => {
			switch ( metaBox.type ) {
				case 'radio':
					return <RadioTerms
						key={index}
						taxonomy={metaBox.taxonomy}
						checkedOnTop={metaBox.checkedOnTop}
					/>;
				//	case 'dropdown':
				///		return <DropdownTerms
				//			key={index} taxonomy={metaBox.taxonomy}
				//			checkedOnTop={metaBox.checkedOnTop}
				//		/>;
				//	case 'simple':
				//		return <SimpleTerms
				//			key={index} taxonomy={metaBox.taxonomy}
				//			checkedOnTop={metaBox.checkedOnTop}
				//		/>;
			}
			return null;
		} )}
	</> );
};

export default Taxonomy;
