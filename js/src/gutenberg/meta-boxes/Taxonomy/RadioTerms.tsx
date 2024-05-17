import {PluginDocumentSettingPanel} from '@wordpress/edit-post';
import {useEntityRecord, useEntityRecords} from '@wordpress/core-data';
import {useTerms} from '@lipemat/js-boilerplate-gutenberg';
import type {Tag} from '@wordpress/core-data/entities';
import {PanelRow, RadioControl} from '@wordpress/components';
import {__} from '@wordpress/i18n';

import styles from './radio.pcss';

type Props = {
	taxonomy: string;
	checkedOnTop: boolean;
};


const RadioTerms = ( {taxonomy, checkedOnTop}: Props ) => {
	const {record: tax} = useEntityRecord( 'root', 'taxonomy', taxonomy );
	const {records: terms} = useEntityRecords( 'taxonomy', taxonomy as 'post_tag', {} );
	const [ assigned, setAssigned ] = useTerms( taxonomy );

	if ( checkedOnTop ) {
		terms?.sort( ( a: Tag<'edit'> ) => assigned.includes( a.id ) ? -1 : 1 );
	}

	return (
		<PluginDocumentSettingPanel
			name="lipe/libs/meta-boxes/radio-terms"
			title={tax?.name ?? __( 'Loading…', 'lipe' )}
			icon={tax?.name === undefined ? 'download' : null}
		>
			<PanelRow>
				<RadioControl
					className={styles.control}
					selected={assigned[ 0 ] ?? ''}
					options={terms?.map( term => ( {label: term.name, value: term.id} ) ) ?? []}
					onChange={state => {
						setAssigned( null === state ? [] : [ parseInt( state ) ] );
					}}
				/>
			</PanelRow>
		</PluginDocumentSettingPanel>
	);
};

export default RadioTerms;
