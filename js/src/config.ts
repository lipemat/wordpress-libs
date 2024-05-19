import type {TaxonomyMetaBox} from './gutenberg/meta-boxes/Taxonomy';

type BlockEditorConfig = {
	taxonomyMetaBoxes: TaxonomyMetaBox[];
}

type AdminConfig = {
	cmb2BoxTabs: {
		field: string
	}
}

declare global {
	interface Window {
		LIPE_LIBS_ADMIN_CONFIG?: AdminConfig;
		LIPE_LIBS_BLOCK_EDITOR_CONFIG?: BlockEditorConfig;
	}
}

export const BLOCK_EDITOR: BlockEditorConfig = window.LIPE_LIBS_BLOCK_EDITOR_CONFIG ?? {
	taxonomyMetaBoxes: [],
};

export const ADMIN = window.LIPE_LIBS_ADMIN_CONFIG ?? {
	cmb2BoxTabs: {
		field: 'tabs',
	},
};
