import type {PluginSettings} from '@wordpress/plugins';
import RadioTerms from './RadioTerms';

export const name = 'lipe-libs-meta-boxes';

export const settings: PluginSettings = {
	render: () => (
		<RadioTerms taxonomy={'custom-ui'} />
	),
};
