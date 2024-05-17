import type {TaxonomyMetaBox} from './gutenberg/meta-boxes/Taxonomy';

type JSConfig = {
	taxonomyMetaBoxes: TaxonomyMetaBox[];
}

declare global {
	interface Window {
		LIPE_LIBS_META_BOXES?: TaxonomyMetaBox[];
	}
}
export const CONFIG: JSConfig = {
	taxonomyMetaBoxes: window.LIPE_LIBS_META_BOXES ?? [],
};
