import type {TaxonomyMetaBox} from './gutenberg/meta-boxes/Taxonomy';
import type {SelectField} from './modules/cmb2/taxonomy-select-2';

type BlockEditorConfig = {
	taxonomyMetaBoxes: TaxonomyMetaBox[];
}

type AdminConfig = {
	cmb2BoxTabs: {
		field: string
	};
	cmb2TermSelect2: {
		ajaxUrl: string;
		fields: SelectField[];
	}
}

declare global {
	interface Window {
		LIPE_LIBS_ADMIN_CONFIG: AdminConfig;
		LIPE_LIBS_BLOCK_EDITOR_CONFIG: BlockEditorConfig;
	}
}

export const BLOCK_EDITOR: BlockEditorConfig = window.LIPE_LIBS_BLOCK_EDITOR_CONFIG;
export const ADMIN: AdminConfig = window.LIPE_LIBS_ADMIN_CONFIG;
