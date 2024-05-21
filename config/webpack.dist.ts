import type {AtLeast} from '@lipemat/js-boilerplate/utility';
import type {Configuration, RuleSetRule} from 'webpack';

type ExtractArray<T> = T extends Array<infer U> ? Array<U> : never;

/**
 * Type narrowing functions for Webpack configuration.
 */
function isRuleSetRule( rule: undefined | null | false | '' | 0 | RuleSetRule | '...' ): rule is RuleSetRule {
	return typeof rule === 'object';
}

function isArrayOfRuleSetRule( rules: undefined | ( undefined | null | false | '' | 0 | RuleSetRule | '...' )[] ): rules is RuleSetRule[] {
	return Array.isArray( rules ) && rules.every( isRuleSetRule );
}

function isArrayOfUse( use: RuleSetRule['use'] ): use is ExtractArray<RuleSetRule['use']> {
	return Array.isArray( use );
}


/**
 * - Enable source maps for dist builds because we're not supporting start.
 * - Use style-loader instead of extracting CSS to a file.
 */
module.exports = ( config: AtLeast<Configuration, 'module'> ) => {
	config.devtool = 'source-map';

	let ruleIndex = config.module.rules?.findIndex( rule => {
		return isRuleSetRule( rule ) ? rule.test?.toString() === '/\\.pcss$/' : false;
	} ) ?? -1;

	if ( -1 !== ruleIndex && isArrayOfRuleSetRule( config.module.rules ) && 'undefined' !== typeof config.module.rules[ ruleIndex ] ) {
		const use = config.module.rules[ ruleIndex ].use as RuleSetRule['use'];
		if ( isArrayOfUse( use ) ) {
			use.shift();
			use.unshift( {
				loader: 'style-loader',
				options: {
					injectType: 'singletonStyleTag',
				}
			} );
		}
		config.module.rules[ ruleIndex ].use = use;
	}

	return config;
};
