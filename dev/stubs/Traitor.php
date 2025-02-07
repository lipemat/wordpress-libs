<?php
declare( strict_types=1 );

namespace stubs;

use Lipe\Lib\Comment\Comment_Trait;
use Lipe\Lib\Menu\Menu_Item_Trait;
use Lipe\Lib\Network\Network_Trait;
use Lipe\Lib\Post_Type\Post_Object_Trait;
use Lipe\Lib\Settings\Settings_Trait;
use Lipe\Lib\Site\Site_Trait;
use Lipe\Lib\Taxonomy\Taxonomy_Trait;
use Lipe\Lib\User\User_Trait;

/**
 * Stub class which includes all traits, so they may
 * be analyzed by PHPStan.
 *
 */
class Traitor {
	//@phpstan-ignore missingType.generics
	use User_Trait {
		User_Trait::get_extended_properties as get_user_extended_properties;
	}

	//@phpstan-ignore missingType.generics
	use Taxonomy_Trait;

	//@phpstan-ignore missingType.generics
	use Site_Trait {
		Site_Trait::get_extended_properties as get_site_extended_properties;
	}

	//@phpstan-ignore missingType.generics
	use Settings_Trait;

	//@phpstan-ignore missingType.generics
	use Network_Trait;

	//@phpstan-ignore missingType.generics
	use Post_Object_Trait;

	//@phpstan-ignore missingType.generics
	use Menu_Item_Trait;

	//@phpstan-ignore missingType.generics
	use Comment_Trait;
}
