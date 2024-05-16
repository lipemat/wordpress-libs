import type {TaxonomyMetaBox} from './gutenberg/meta-boxes/Taxonomy';

type JSConfig = {
	isGutenberg: '' | '1';
	taxonomyMetaBoxes?: TaxonomyMetaBox[];
}

declare global {
	interface Window {
		LIPE_LIBS_CONFIG: JSConfig;
	}
}
export const CONFIG: JSConfig = window.LIPE_LIBS_CONFIG;
