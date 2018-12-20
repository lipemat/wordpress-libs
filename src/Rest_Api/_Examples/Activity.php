<?php

namespace Lipe\Project\Rest_Api;

use Lipe\Lib\Rest_Api\Post_Abstract;
use Lipe\Project\Post_Types\Activities;
use Lipe\Project\Taxonomies\ActivityCategories;
use Lipe\Project\Taxonomies\AgeRange;
use Lipe\Project\Taxonomies\Type;

class Activity extends Post_Abstract {

	const POST_TYPE = Lipe\Project\Post_Types\Activity::NAME;

	protected $taxonomies = [
		'category',
		'post_tag',
		ActivityCategories::NAME,
		Type::NAME,
		AgeRange::NAME,
	];

	protected $allowed_meta_keys = [
		Activities::COST_META_KEY,
		Activities::SEASONS_META_KEY,
		Activities::HANDICAP_META_KEY,
		Activities::FEATURED_META_KEY,
	];

}
