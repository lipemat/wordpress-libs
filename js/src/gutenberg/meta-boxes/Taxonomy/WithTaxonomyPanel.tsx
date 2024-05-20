import {PluginDocumentSettingPanel} from '@wordpress/edit-post';
import {__, sprintf} from '@wordpress/i18n';
import {useEntityRecord, useEntityRecords} from '@wordpress/core-data';
import {type ComponentType, type PropsWithChildren, useEffect} from 'react';
import type {Tag, Taxonomy} from '@wordpress/core-data/entities';
import {useTerms} from '@lipemat/js-boilerplate-gutenberg';
import {dispatch} from '@wordpress/data';

export type FromPanel = {
	tax: Taxonomy<'edit'> | null;
	terms: Tag<'edit'>[]
	assigned: number[]
	setAssigned: ( ids: number[] ) => void;
}

type Props = {
	taxonomy: string;
	checkedOnTop: boolean;
};

/**
 * Remove the default taxonomy panel.
 *
 * Same as how we do this for classic meta boxes, but run within the JS
 * to make sure our JS has actually loaded before removing the default panel.
 * Thus, allowing a fallback to the default panel if our JS fails to load.
 */
function removeDefaultMetaBox( taxonomy: string ): void {
	if ( 'function' === typeof dispatch( 'core/editor' ).removeEditorPanel ) {
		dispatch( 'core/editor' ).removeEditorPanel( sprintf( 'taxonomy-panel-%1$s', taxonomy ) );
	} else {
		// @todo Remove `core/edit-post` fallback when minimum WP version is 6.5.
		// eslint-disable-next-line
		dispatch( 'core/edit-post' ).removeEditorPanel( sprintf( 'taxonomy-panel-%1$s', taxonomy ) );
	}
}


export default function WithTaxonomyPanel(
	WrappedComponent: ComponentType<FromPanel>,
	props: PropsWithChildren<Props>
) {
	const {taxonomy, checkedOnTop} = props;

	const {record: tax} = useEntityRecord( 'root', 'taxonomy', taxonomy );
	const {records: terms} = useEntityRecords( 'taxonomy', taxonomy as 'post_tag', {
		per_page: 100,
	} );
	const [ assigned, setAssigned ] = useTerms( taxonomy );

	useEffect( () => {
		removeDefaultMetaBox( taxonomy );
	}, [ taxonomy ] );


	if ( checkedOnTop && Array.isArray( terms ) ) {
		terms.sort( ( a: Tag<'edit'> ) => assigned.includes( a.id ) ? -1 : 1 );
	}

	return (
		<PluginDocumentSettingPanel
			key={taxonomy}
			name={sprintf( 'lipe/libs/meta-boxes/taxonomy/%1$s', taxonomy )}
			title={tax?.name ?? __( 'Loading…', 'lipe' )}
			icon={tax?.name === undefined ? 'download' : null}
		>
			<WrappedComponent
				tax={tax}
				terms={terms ?? []}
				assigned={assigned}
				setAssigned={setAssigned}
			/>
		</PluginDocumentSettingPanel>
	);
}
