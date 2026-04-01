<?php
declare( strict_types=1 );

namespace Lipe\Lib\CMB2\Group;

use Lipe\Lib\CMB2\Group;
use Lipe\Lib\Container\Instance;
use Lipe\Lib\Libs\Scripts;
use Lipe\Lib\Libs\Scripts\ScriptHandles;
use Lipe\Lib\Meta\Registered;
use Lipe\Lib\Traits\Memoize;

/**
 * Support a max rows limit for groups.
 *
 * @author Mat Lipe
 * @since  5.10.0
 */
class Max_Rows {
	use Instance;
	use Memoize;

	/**
	 * Fields that have been registered.
	 *
	 * - Only fields with a max_rows config should be registered.
	 *
	 * @var Group[]
	 */
	protected array $registered = [];


	/**
	 * Register a group to be included with the max rows limit.
	 *
	 * - Only fields with a max_rows config should be registered.
	 *
	 * @param Group $field - The field to register.
	 */
	public function register( Group $field ): void {
		$this->registered[ $field->id ] = $field;

		$field->after_group( $this->load_scripts( ... ) );
	}


	/**
	 * Enqueue the admin script and include the JS configurations.
	 *
	 * @return void
	 */
	protected function load_scripts(): void {
		$this->once( function() {
			$config = $this->js_config();
			if ( [] !== $config ) {
				Scripts::in()->enqueue_script( ScriptHandles::ADMIN );
				wp_localize_script( ScriptHandles::ADMIN->value, 'LIPE_LIBS_CMB2_GROUP_LIMIT', $config );
			}
		}, __METHOD__ );
	}


	/**
	 * JS configuration for all registered groups with a max rows limit.
	 *
	 * - Only fields with a `max_rows` config and that are repeatable will be included in the JS configuration.
	 *
	 * @return list<array{groupId:string, limit:int}>
	 */
	public function js_config(): array {
		$groups = [];
		foreach ( $this->registered as $id => $group ) {
			$registerd = Registered::factory( $group );

			if ( ! isset( $registerd->get_config()['max_rows'] ) || ! $registerd->is_repeatable() ) {
				continue;
			}
			$groups[] = [
				'groupId' => $id,
				'limit'   => $registerd->get_config()['max_rows'],
			];
		}
		return $groups;
	}
}
