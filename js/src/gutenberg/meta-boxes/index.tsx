import type {PluginSettings} from '@wordpress/plugins';
import Taxonomy from './Taxonomy';

export const name = 'lipe-libs-meta-boxes';

export const settings: PluginSettings = {
	render: () => (
		<Taxonomy />
	),
};
