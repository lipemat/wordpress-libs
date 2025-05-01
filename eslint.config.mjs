import config from '@lipemat/eslint-config';

export default [
	...config,
	{
		rules: {
			'@wordpress/i18n-text-domain': [ 'error', {
				allowedTextDomain: [ 'lipe' ],
			} ],
		},
	}
];
