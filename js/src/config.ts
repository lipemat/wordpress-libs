type JSConfig = {
	isGutenberg: '' | '1';
}

declare global {
	interface Window {
		LIPE_LIBS_CONFIG: JSConfig;
	}
}
export const CONFIG: JSConfig = window.LIPE_LIBS_CONFIG;
