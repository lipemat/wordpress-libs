<?php declare(strict_types = 1);

$ignoreErrors = [];
$ignoreErrors[] = [
	// identifier: empty.notAllowed
	'message' => '#^Construct empty\\(\\) is not allowed\\. Use more strict comparison\\.$#',
	'count' => 4,
	'path' => __DIR__ . '/../src/Api/Api.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Api\\\\Api\\:\\:get_url\\(\\) has parameter \\$data with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Api/Api.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Api\\\\Api\\:\\:get_versions\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Api/Api.php',
];
$ignoreErrors[] = [
	// identifier: empty.notAllowed
	'message' => '#^Construct empty\\(\\) is not allowed\\. Use more strict comparison\\.$#',
	'count' => 2,
	'path' => __DIR__ . '/../src/Api/Route.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Api\\\\Route\\:\\:add_query_var\\(\\) has parameter \\$vars with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Api/Route.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Api\\\\Route\\:\\:add_query_var\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Api/Route.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Api\\\\Route\\:\\:adjust_body_class\\(\\) has parameter \\$classes with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Api/Route.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Api\\\\Route\\:\\:adjust_body_class\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Api/Route.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Property Lipe\\\\Lib\\\\Api\\\\Route\\:\\:\\$routes type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Api/Route.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Property Lipe\\\\Lib\\\\Api\\\\Wp_Remote\\:\\:\\$body type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Api/Wp_Remote.php',
];
$ignoreErrors[] = [
	// identifier: empty.notAllowed
	'message' => '#^Construct empty\\(\\) is not allowed\\. Use more strict comparison\\.$#',
	'count' => 3,
	'path' => __DIR__ . '/../src/Api/Zip.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Api\\\\Zip\\:\\:build_zip\\(\\) has parameter \\$files with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Api/Zip.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Api\\\\Zip\\:\\:get_post_data_to_send\\(\\) has parameter \\$urls with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Api/Zip.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Api\\\\Zip\\:\\:get_post_data_to_send\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Api/Zip.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Api\\\\Zip\\:\\:set_paths\\(\\) has parameter \\$files with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Api/Zip.php',
];
$ignoreErrors[] = [
	// identifier: empty.notAllowed
	'message' => '#^Construct empty\\(\\) is not allowed\\. Use more strict comparison\\.$#',
	'count' => 5,
	'path' => __DIR__ . '/../src/CMB2/Box.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Box\\:\\:clear_single_item\\(\\) has parameter \\$args with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Box.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Box\\:\\:get_args\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Box.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Box\\:\\:get_cache_key\\(\\) has parameter \\$args with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Box.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Box\\:\\:get_meta_box_callback_args\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Box.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Box\\:\\:register_meta_on_all_types\\(\\) has parameter \\$config with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Box.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Box\\:\\:translate_rest_keys\\(\\) has parameter \\$config with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Box.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Box\\:\\:translate_rest_keys\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Box.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Property Lipe\\\\Lib\\\\CMB2\\\\Box\\:\\:\\$mb_callback_args type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Box.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Property Lipe\\\\Lib\\\\CMB2\\\\Box\\:\\:\\$memoize_cache type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Box.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Property Lipe\\\\Lib\\\\CMB2\\\\Box\\:\\:\\$tabs type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Box.php',
];
$ignoreErrors[] = [
	// identifier: empty.notAllowed
	'message' => '#^Construct empty\\(\\) is not allowed\\. Use more strict comparison\\.$#',
	'count' => 3,
	'path' => __DIR__ . '/../src/CMB2/Box/Tabs.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Box\\\\Tabs\\:\\:add_wrap_class\\(\\) has parameter \\$classes with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Box/Tabs.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Box\\\\Tabs\\:\\:add_wrap_class\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Box/Tabs.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Box\\\\Tabs\\:\\:capture_fields\\(\\) has parameter \\$field_args with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Box/Tabs.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Box\\\\Tabs\\:\\:render_field\\(\\) has parameter \\$field_args with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Box/Tabs.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Property Lipe\\\\Lib\\\\CMB2\\\\Box\\\\Tabs\\:\\:\\$fields_output type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Box/Tabs.php',
];
$ignoreErrors[] = [
	// identifier: empty.notAllowed
	'message' => '#^Construct empty\\(\\) is not allowed\\. Use more strict comparison\\.$#',
	'count' => 2,
	'path' => __DIR__ . '/../src/CMB2/Event_Callbacks.php',
];
$ignoreErrors[] = [
	// identifier: empty.notAllowed
	'message' => '#^Construct empty\\(\\) is not allowed\\. Use more strict comparison\\.$#',
	'count' => 2,
	'path' => __DIR__ . '/../src/CMB2/Field.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Field\\:\\:attributes\\(\\) has parameter \\$attributes with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Field\\:\\:char_counter\\(\\) has parameter \\$labels with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Field\\:\\:get_field_args\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Field\\:\\:query_args\\(\\) has parameter \\$args with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Property Lipe\\\\Lib\\\\CMB2\\\\Field\\:\\:\\$attributes type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Property Lipe\\\\Lib\\\\CMB2\\\\Field\\:\\:\\$column type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Property Lipe\\\\Lib\\\\CMB2\\\\Field\\:\\:\\$date_picker_options type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Property Lipe\\\\Lib\\\\CMB2\\\\Field\\:\\:\\$default type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Property Lipe\\\\Lib\\\\CMB2\\\\Field\\:\\:\\$query_args type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Property Lipe\\\\Lib\\\\CMB2\\\\Field\\:\\:\\$text type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Field\\\\Checkbox\\:\\:clear_single_item\\(\\) has parameter \\$args with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field/Checkbox.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Field\\\\Checkbox\\:\\:get_cache_key\\(\\) has parameter \\$args with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field/Checkbox.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Field\\\\Checkbox\\:\\:render_field_callback\\(\\) has parameter \\$args with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field/Checkbox.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Property Lipe\\\\Lib\\\\CMB2\\\\Field\\\\Checkbox\\:\\:\\$memoize_cache type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field/Checkbox.php',
];
$ignoreErrors[] = [
	// identifier: empty.notAllowed
	'message' => '#^Construct empty\\(\\) is not allowed\\. Use more strict comparison\\.$#',
	'count' => 7,
	'path' => __DIR__ . '/../src/CMB2/Field/Term_Select_2.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Field\\\\Term_Select_2\\:\\:assign_terms_during_save\\(\\) has parameter \\$field_args with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field/Term_Select_2.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Field\\\\Term_Select_2\\:\\:assign_terms_during_save\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field/Term_Select_2.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Field\\\\Term_Select_2\\:\\:create_terms\\(\\) has parameter \\$terms with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field/Term_Select_2.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Field\\\\Term_Select_2\\:\\:create_terms\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field/Term_Select_2.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Field\\\\Term_Select_2\\:\\:esc_repeater_values\\(\\) has parameter \\$checked with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field/Term_Select_2.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Field\\\\Term_Select_2\\:\\:esc_repeater_values\\(\\) has parameter \\$field_args with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field/Term_Select_2.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Field\\\\Term_Select_2\\:\\:esc_repeater_values\\(\\) has parameter \\$values with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field/Term_Select_2.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Field\\\\Term_Select_2\\:\\:esc_repeater_values\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field/Term_Select_2.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Field\\\\Term_Select_2\\:\\:get_multi_select_options\\(\\) has parameter \\$field_escaped_value with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field/Term_Select_2.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Field\\\\Term_Select_2\\:\\:get_taxonomy\\(\\) has parameter \\$field_args with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field/Term_Select_2.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Field\\\\Term_Select_2\\:\\:put_selected_options_first\\(\\) has parameter \\$all_options with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field/Term_Select_2.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Field\\\\Term_Select_2\\:\\:put_selected_options_first\\(\\) has parameter \\$selected_options with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field/Term_Select_2.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Field\\\\Term_Select_2\\:\\:put_selected_options_first\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field/Term_Select_2.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Field\\\\Term_Select_2\\:\\:render\\(\\) has parameter \\$value with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field/Term_Select_2.php',
];
$ignoreErrors[] = [
	// identifier: empty.notAllowed
	'message' => '#^Construct empty\\(\\) is not allowed\\. Use more strict comparison\\.$#',
	'count' => 3,
	'path' => __DIR__ . '/../src/CMB2/Field/True_False.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Field\\\\True_False\\:\\:render\\(\\) has parameter \\$args with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field/True_False.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Field\\\\True_False\\:\\:render_toggle_field\\(\\) has parameter \\$args with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field/True_False.php',
];
$ignoreErrors[] = [
	// identifier: empty.notAllowed
	'message' => '#^Construct empty\\(\\) is not allowed\\. Use more strict comparison\\.$#',
	'count' => 6,
	'path' => __DIR__ . '/../src/CMB2/Field_Type.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Field_Type\\:\\:colorpicker\\(\\) has parameter \\$iris_options with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field_Type.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Field_Type\\:\\:field_type_date\\(\\) has parameter \\$date_picker_options with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field_Type.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Field_Type\\:\\:field_type_date\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field_Type.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Field_Type\\:\\:field_type_file\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field_Type.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Field_Type\\:\\:field_type_options\\(\\) has parameter \\$options_or_callback with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field_Type.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Field_Type\\:\\:field_type_options\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field_Type.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Field_Type\\:\\:field_type_taxonomy\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field_Type.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Field_Type\\:\\:multicheck\\(\\) has parameter \\$options_or_callback with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field_Type.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Field_Type\\:\\:multicheck_inline\\(\\) has parameter \\$options_or_callback with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field_Type.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Field_Type\\:\\:radio\\(\\) has parameter \\$options_or_callback with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field_Type.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Field_Type\\:\\:radio_inline\\(\\) has parameter \\$options_or_callback with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field_Type.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Field_Type\\:\\:select\\(\\) has parameter \\$options_or_callback with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field_Type.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Field_Type\\:\\:set\\(\\) has parameter \\$args with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field_Type.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Field_Type\\:\\:text_date\\(\\) has parameter \\$date_picker_options with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field_Type.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Field_Type\\:\\:text_date_timestamp\\(\\) has parameter \\$date_picker_options with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field_Type.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Field_Type\\:\\:text_datetime_timestamp\\(\\) has parameter \\$date_picker_options with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field_Type.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Field_Type\\:\\:text_datetime_timestamp_timezone\\(\\) has parameter \\$date_picker_options with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field_Type.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Field_Type\\:\\:text_url\\(\\) has parameter \\$protocols with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field_Type.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Field_Type\\:\\:textarea_code\\(\\) has parameter \\$code_editor_arguments with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field_Type.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Field_Type\\:\\:wysiwyg\\(\\) has parameter \\$mce_options with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Field_Type.php',
];
$ignoreErrors[] = [
	// identifier: empty.notAllowed
	'message' => '#^Construct empty\\(\\) is not allowed\\. Use more strict comparison\\.$#',
	'count' => 2,
	'path' => __DIR__ . '/../src/CMB2/Group.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Group\\:\\:clear_single_item\\(\\) has parameter \\$args with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Group.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Group\\:\\:get_cache_key\\(\\) has parameter \\$args with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Group.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Group\\:\\:get_field_args\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Group.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Group\\:\\:get_object_types\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Group.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Group\\:\\:translate_rest_keys\\(\\) has parameter \\$config with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Group.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Group\\:\\:translate_rest_keys\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Group.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Group\\:\\:translate_sub_field_rest_keys\\(\\) has parameter \\$group_values with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Group.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Group\\:\\:translate_sub_field_rest_keys\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Group.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Group\\:\\:untranslate_sub_field_rest_keys\\(\\) has parameter \\$group_values with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Group.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Group\\:\\:untranslate_sub_field_rest_keys\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Group.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Property Lipe\\\\Lib\\\\CMB2\\\\Group\\:\\:\\$memoize_cache type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Group.php',
];
$ignoreErrors[] = [
	// identifier: empty.notAllowed
	'message' => '#^Construct empty\\(\\) is not allowed\\. Use more strict comparison\\.$#',
	'count' => 2,
	'path' => __DIR__ . '/../src/CMB2/Group/Layout.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Group\\\\Layout\\:\\:clear_single_item\\(\\) has parameter \\$args with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Group/Layout.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Group\\\\Layout\\:\\:get_cache_key\\(\\) has parameter \\$args with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Group/Layout.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Group\\\\Layout\\:\\:render_field\\(\\) has parameter \\$field_args with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Group/Layout.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Group\\\\Layout\\:\\:render_group_callback\\(\\) has parameter \\$field_args with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Group/Layout.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Property Lipe\\\\Lib\\\\CMB2\\\\Group\\\\Layout\\:\\:\\$memoize_cache type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Group/Layout.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\CMB2\\\\Options_Page\\:\\:register_meta_on_all_types\\(\\) has parameter \\$config with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Options_Page.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Property Lipe\\\\Lib\\\\CMB2\\\\Options_Page\\:\\:\\$default_values type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/CMB2/Options_Page.php',
];
$ignoreErrors[] = [
	// identifier: empty.notAllowed
	'message' => '#^Construct empty\\(\\) is not allowed\\. Use more strict comparison\\.$#',
	'count' => 2,
	'path' => __DIR__ . '/../src/Comment/Get_Comments.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Comment\\\\Get_Comments\\:\\:get_light_args\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Comment/Get_Comments.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Property Lipe\\\\Lib\\\\Comment\\\\Get_Comments\\:\\:\\$date_query type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Comment/Get_Comments.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Property Lipe\\\\Lib\\\\Comment\\\\Get_Comments\\:\\:\\$meta_query type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Comment/Get_Comments.php',
];
$ignoreErrors[] = [
	// identifier: empty.notAllowed
	'message' => '#^Construct empty\\(\\) is not allowed\\. Use more strict comparison\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Meta/Translate_Abstract.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Meta\\\\Translate_Abstract\\:\\:clear_single_item\\(\\) has parameter \\$args with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Meta/Translate_Abstract.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Meta\\\\Translate_Abstract\\:\\:get_cache_key\\(\\) has parameter \\$args with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Meta/Translate_Abstract.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Meta\\\\Translate_Abstract\\:\\:get_file_field_value\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Meta/Translate_Abstract.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Meta\\\\Translate_Abstract\\:\\:get_group_field_value\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Meta/Translate_Abstract.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Meta\\\\Translate_Abstract\\:\\:update_group_field_values\\(\\) has parameter \\$values with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Meta/Translate_Abstract.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Property Lipe\\\\Lib\\\\Meta\\\\Translate_Abstract\\:\\:\\$groups type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Meta/Translate_Abstract.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Property Lipe\\\\Lib\\\\Meta\\\\Translate_Abstract\\:\\:\\$memoize_cache type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Meta/Translate_Abstract.php',
];
$ignoreErrors[] = [
	// identifier: empty.notAllowed
	'message' => '#^Construct empty\\(\\) is not allowed\\. Use more strict comparison\\.$#',
	'count' => 7,
	'path' => __DIR__ . '/../src/Post_Type/Custom_Post_Type.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Post_Type\\\\Custom_Post_Type\\:\\:add_support\\(\\) has parameter \\$features with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Post_Type/Custom_Post_Type.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Post_Type\\\\Custom_Post_Type\\:\\:adjust_bulk_edit_messages\\(\\) has parameter \\$bulk_counts with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Post_Type/Custom_Post_Type.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Post_Type\\\\Custom_Post_Type\\:\\:adjust_bulk_edit_messages\\(\\) has parameter \\$bulk_messages with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Post_Type/Custom_Post_Type.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Post_Type\\\\Custom_Post_Type\\:\\:adjust_bulk_edit_messages\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Post_Type/Custom_Post_Type.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Post_Type\\\\Custom_Post_Type\\:\\:adjust_post_updated_messages\\(\\) has parameter \\$messages with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Post_Type/Custom_Post_Type.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Post_Type\\\\Custom_Post_Type\\:\\:adjust_post_updated_messages\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Post_Type/Custom_Post_Type.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Post_Type\\\\Custom_Post_Type\\:\\:gutenberg_template\\(\\) has parameter \\$template with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Post_Type/Custom_Post_Type.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Post_Type\\\\Custom_Post_Type\\:\\:post_type_args\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Post_Type/Custom_Post_Type.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Post_Type\\\\Custom_Post_Type\\:\\:post_type_labels\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Post_Type/Custom_Post_Type.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Post_Type\\\\Custom_Post_Type\\:\\:remove_support\\(\\) has parameter \\$features with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Post_Type/Custom_Post_Type.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Post_Type\\\\Custom_Post_Type\\:\\:rewrites\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Post_Type/Custom_Post_Type.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Property Lipe\\\\Lib\\\\Post_Type\\\\Custom_Post_Type\\:\\:\\$labels type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Post_Type/Custom_Post_Type.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Property Lipe\\\\Lib\\\\Post_Type\\\\Custom_Post_Type\\:\\:\\$registry type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Post_Type/Custom_Post_Type.php',
];
$ignoreErrors[] = [
	// identifier: empty.notAllowed
	'message' => '#^Construct empty\\(\\) is not allowed\\. Use more strict comparison\\.$#',
	'count' => 3,
	'path' => __DIR__ . '/../src/Query/Args.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Query\\\\Args\\:\\:get_light_args\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Query/Args.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Property Lipe\\\\Lib\\\\Query\\\\Args\\:\\:\\$date_query type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Query/Args.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Property Lipe\\\\Lib\\\\Query\\\\Args\\:\\:\\$meta_query type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Query/Args.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Property Lipe\\\\Lib\\\\Query\\\\Args\\:\\:\\$tax_query type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Query/Args.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Query\\\\Args_Interface\\:\\:get_args\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Query/Args_Interface.php',
];
$ignoreErrors[] = [
	// identifier: empty.notAllowed
	'message' => '#^Construct empty\\(\\) is not allowed\\. Use more strict comparison\\.$#',
	'count' => 2,
	'path' => __DIR__ . '/../src/Query/Clause/Clause_Abstract.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Query\\\\Clause\\\\Clause_Abstract\\:\\:extract_nested\\(\\) has parameter \\$clauses with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Query/Clause/Clause_Abstract.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Property Lipe\\\\Lib\\\\Query\\\\Clause\\\\Clause_Abstract\\:\\:\\$clauses type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Query/Clause/Clause_Abstract.php',
];
$ignoreErrors[] = [
	// identifier: empty.notAllowed
	'message' => '#^Construct empty\\(\\) is not allowed\\. Use more strict comparison\\.$#',
	'count' => 4,
	'path' => __DIR__ . '/../src/Query/Clause/Date_Query.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Query\\\\Clause\\\\Date_Query\\:\\:extract_nested\\(\\) has parameter \\$clauses with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Query/Clause/Date_Query.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Property Lipe\\\\Lib\\\\Query\\\\Clause\\\\Date_Query\\:\\:\\$clauses type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Query/Clause/Date_Query.php',
];
$ignoreErrors[] = [
	// identifier: empty.notAllowed
	'message' => '#^Construct empty\\(\\) is not allowed\\. Use more strict comparison\\.$#',
	'count' => 2,
	'path' => __DIR__ . '/../src/Query/Clause/Meta_Query.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Query\\\\Clause\\\\Meta_Query\\:\\:extract_nested\\(\\) has parameter \\$clauses with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Query/Clause/Meta_Query.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Property Lipe\\\\Lib\\\\Query\\\\Clause\\\\Meta_Query\\:\\:\\$clauses type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Query/Clause/Meta_Query.php',
];
$ignoreErrors[] = [
	// identifier: empty.notAllowed
	'message' => '#^Construct empty\\(\\) is not allowed\\. Use more strict comparison\\.$#',
	'count' => 2,
	'path' => __DIR__ . '/../src/Query/Clause/Tax_Query.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Query\\\\Clause\\\\Tax_Query\\:\\:extract_nested\\(\\) has parameter \\$clauses with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Query/Clause/Tax_Query.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Property Lipe\\\\Lib\\\\Query\\\\Clause\\\\Tax_Query\\:\\:\\$clauses type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Query/Clause/Tax_Query.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Query\\\\Utils\\:\\:get_light_query_args\\(\\) has parameter \\$args with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Query/Utils.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Query\\\\Utils\\:\\:get_light_query_args\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Query/Utils.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Rest_Api\\\\Initial_Data\\:\\:clear_single_item\\(\\) has parameter \\$args with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Rest_Api/Initial_Data.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Rest_Api\\\\Initial_Data\\:\\:get_attachments_data\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Rest_Api/Initial_Data.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Rest_Api\\\\Initial_Data\\:\\:get_cache_key\\(\\) has parameter \\$args with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Rest_Api/Initial_Data.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Rest_Api\\\\Initial_Data\\:\\:get_comments_data\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Rest_Api/Initial_Data.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Rest_Api\\\\Initial_Data\\:\\:get_post_data\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Rest_Api/Initial_Data.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Rest_Api\\\\Initial_Data\\:\\:get_request\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Rest_Api/Initial_Data.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Rest_Api\\\\Initial_Data\\:\\:get_response\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Rest_Api/Initial_Data.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Rest_Api\\\\Initial_Data\\:\\:get_term_data\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Rest_Api/Initial_Data.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Rest_Api\\\\Initial_Data\\:\\:get_user_data\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Rest_Api/Initial_Data.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Property Lipe\\\\Lib\\\\Rest_Api\\\\Initial_Data\\:\\:\\$memoize_cache type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Rest_Api/Initial_Data.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Constant Lipe\\\\Lib\\\\Schema\\\\Db\\:\\:COLUMNS type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Schema/Db.php',
];
$ignoreErrors[] = [
	// identifier: empty.notAllowed
	'message' => '#^Construct empty\\(\\) is not allowed\\. Use more strict comparison\\.$#',
	'count' => 4,
	'path' => __DIR__ . '/../src/Schema/Db.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Schema\\\\Db\\:\\:add\\(\\) has parameter \\$columns with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Schema/Db.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Schema\\\\Db\\:\\:get_formats\\(\\) has parameter \\$columns with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Schema/Db.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Schema\\\\Db\\:\\:get_formats\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Schema/Db.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Schema\\\\Db\\:\\:get_versions\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Schema/Db.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Schema\\\\Db\\:\\:replace\\(\\) has parameter \\$columns with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Schema/Db.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Schema\\\\Db\\:\\:sort_columns\\(\\) has parameter \\$columns with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Schema/Db.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Schema\\\\Db\\:\\:sort_columns\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Schema/Db.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Schema\\\\Db\\:\\:update\\(\\) has parameter \\$columns with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Schema/Db.php',
];
$ignoreErrors[] = [
	// identifier: empty.notAllowed
	'message' => '#^Construct empty\\(\\) is not allowed\\. Use more strict comparison\\.$#',
	'count' => 2,
	'path' => __DIR__ . '/../src/Schema/Meta_Box.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Schema\\\\Meta_Box\\:\\:get_callback_args\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Schema/Meta_Box.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Schema\\\\Meta_Box\\:\\:get_values\\(\\) has parameter \\$fields with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Schema/Meta_Box.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Schema\\\\Meta_Box\\:\\:get_values\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Schema/Meta_Box.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Schema\\\\Meta_Box\\:\\:register\\(\\) has parameter \\$args with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Schema/Meta_Box.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Schema\\\\Meta_Box\\:\\:register\\(\\) has parameter \\$post_type with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Schema/Meta_Box.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Schema\\\\Meta_Box\\:\\:set_callback_args\\(\\) has parameter \\$args with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Schema/Meta_Box.php',
];
$ignoreErrors[] = [
	// identifier: empty.notAllowed
	'message' => '#^Construct empty\\(\\) is not allowed\\. Use more strict comparison\\.$#',
	'count' => 8,
	'path' => __DIR__ . '/../src/Schema/Post_List_Column.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Schema\\\\Post_List_Column\\:\\:add_column\\(\\) has parameter \\$columns with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Schema/Post_List_Column.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Schema\\\\Post_List_Column\\:\\:add_column\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Schema/Post_List_Column.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Schema\\\\Post_List_Column\\:\\:set_filters\\(\\) has parameter \\$args with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Schema/Post_List_Column.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Property Lipe\\\\Lib\\\\Schema\\\\Post_List_Column\\:\\:\\$filters type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Schema/Post_List_Column.php',
];
$ignoreErrors[] = [
	// identifier: empty.notAllowed
	'message' => '#^Construct empty\\(\\) is not allowed\\. Use more strict comparison\\.$#',
	'count' => 11,
	'path' => __DIR__ . '/../src/Schema/Settings.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Property Lipe\\\\Lib\\\\Schema\\\\Settings\\:\\:\\$defaults type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Schema/Settings.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Property Lipe\\\\Lib\\\\Schema\\\\Settings\\:\\:\\$settings type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Schema/Settings.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Taxonomy\\\\Get_Terms\\:\\:get_light_args\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Taxonomy/Get_Terms.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Property Lipe\\\\Lib\\\\Taxonomy\\\\Get_Terms\\:\\:\\$meta_query type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Taxonomy/Get_Terms.php',
];
$ignoreErrors[] = [
	// identifier: empty.notAllowed
	'message' => '#^Construct empty\\(\\) is not allowed\\. Use more strict comparison\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Taxonomy/Meta_Box.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method class@anonymous/Taxonomy/Meta_Box\\.php\\:244\\:\\:start_el\\(\\) has parameter \\$args with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Taxonomy/Meta_Box.php',
];
$ignoreErrors[] = [
	// identifier: empty.notAllowed
	'message' => '#^Construct empty\\(\\) is not allowed\\. Use more strict comparison\\.$#',
	'count' => 9,
	'path' => __DIR__ . '/../src/Taxonomy/Taxonomy.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Taxonomy\\\\Taxonomy\\:\\:add_initial_terms\\(\\) has parameter \\$terms with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Taxonomy/Taxonomy.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Taxonomy\\\\Taxonomy\\:\\:rewrites\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Taxonomy/Taxonomy.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Taxonomy\\\\Taxonomy\\:\\:taxonomy_args\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Taxonomy/Taxonomy.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Taxonomy\\\\Taxonomy\\:\\:taxonomy_labels\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Taxonomy/Taxonomy.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Property Lipe\\\\Lib\\\\Taxonomy\\\\Taxonomy\\:\\:\\$initial_terms type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Taxonomy/Taxonomy.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Property Lipe\\\\Lib\\\\Taxonomy\\\\Taxonomy\\:\\:\\$meta_box_cb type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Taxonomy/Taxonomy.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Property Lipe\\\\Lib\\\\Taxonomy\\\\Taxonomy\\:\\:\\$show_in_menu type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Taxonomy/Taxonomy.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Theme\\\\CSS_Modules\\:\\:clear_single_item\\(\\) has parameter \\$args with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Theme/CSS_Modules.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Theme\\\\CSS_Modules\\:\\:get_cache_key\\(\\) has parameter \\$args with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Theme/CSS_Modules.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Theme\\\\CSS_Modules\\:\\:get_combined_css_classes\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Theme/CSS_Modules.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Theme\\\\CSS_Modules\\:\\:styles\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Theme/CSS_Modules.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Property Lipe\\\\Lib\\\\Theme\\\\CSS_Modules\\:\\:\\$memoize_cache type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Theme/CSS_Modules.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Theme\\\\Class_Names\\:\\:offsetSet\\(\\) has parameter \\$value with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Theme/Class_Names.php',
];
$ignoreErrors[] = [
	// identifier: empty.notAllowed
	'message' => '#^Construct empty\\(\\) is not allowed\\. Use more strict comparison\\.$#',
	'count' => 4,
	'path' => __DIR__ . '/../src/Theme/Resources.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Theme\\\\Resources\\:\\:clear_single_item\\(\\) has parameter \\$args with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Theme/Resources.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Theme\\\\Resources\\:\\:get_cache_key\\(\\) has parameter \\$args with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Theme/Resources.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Property Lipe\\\\Lib\\\\Theme\\\\Resources\\:\\:\\$memoize_cache type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Theme/Resources.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Property Lipe\\\\Lib\\\\User\\\\Get_Users\\:\\:\\$meta_query type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/User/Get_Users.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Util\\\\Actions\\:\\:add_action_all\\(\\) has parameter \\$actions with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Util/Actions.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Util\\\\Actions\\:\\:add_filter_all\\(\\) has parameter \\$filters with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Util/Actions.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Util\\\\Actions\\:\\:clear_single_item\\(\\) has parameter \\$args with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Util/Actions.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Util\\\\Actions\\:\\:get_cache_key\\(\\) has parameter \\$args with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Util/Actions.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Property Lipe\\\\Lib\\\\Util\\\\Actions\\:\\:\\$memoize_cache type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Util/Actions.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Util\\\\Arrays\\:\\:chunk_to_associative\\(\\) has parameter \\$array with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Util/Arrays.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Util\\\\Arrays\\:\\:chunk_to_associative\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Util/Arrays.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Util\\\\Arrays\\:\\:clean\\(\\) has parameter \\$array with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Util/Arrays.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Util\\\\Arrays\\:\\:clean\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Util/Arrays.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Util\\\\Arrays\\:\\:flatten_assoc\\(\\) has parameter \\$array with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Util/Arrays.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Util\\\\Arrays\\:\\:flatten_assoc\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Util/Arrays.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Util\\\\Arrays\\:\\:list_pluck\\(\\) has parameter \\$array with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Util/Arrays.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Util\\\\Arrays\\:\\:list_pluck\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Util/Arrays.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Util\\\\Arrays\\:\\:map_assoc\\(\\) has parameter \\$array with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Util/Arrays.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Util\\\\Arrays\\:\\:map_assoc\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Util/Arrays.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Util\\\\Arrays\\:\\:map_recursive\\(\\) has parameter \\$array with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Util/Arrays.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Util\\\\Arrays\\:\\:map_recursive\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Util/Arrays.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Util\\\\Arrays\\:\\:merge_recursive\\(\\) has parameter \\$args with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Util/Arrays.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Util\\\\Arrays\\:\\:merge_recursive\\(\\) has parameter \\$defaults with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Util/Arrays.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Util\\\\Arrays\\:\\:merge_recursive\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Util/Arrays.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Util\\\\Arrays\\:\\:recursive_unset\\(\\) has parameter \\$array with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Util/Arrays.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Util\\\\Arrays\\:\\:recursive_unset\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Util/Arrays.php',
];
$ignoreErrors[] = [
	// identifier: empty.notAllowed
	'message' => '#^Construct empty\\(\\) is not allowed\\. Use more strict comparison\\.$#',
	'count' => 2,
	'path' => __DIR__ . '/../src/Util/Cache.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Util\\\\Cache\\:\\:delete\\(\\) has parameter \\$key with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Util/Cache.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Util\\\\Cache\\:\\:filter_key\\(\\) has parameter \\$key with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Util/Cache.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Util\\\\Cache\\:\\:get\\(\\) has parameter \\$key with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Util/Cache.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Util\\\\Cache\\:\\:set\\(\\) has parameter \\$key with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Util/Cache.php',
];
$ignoreErrors[] = [
	// identifier: empty.notAllowed
	'message' => '#^Construct empty\\(\\) is not allowed\\. Use more strict comparison\\.$#',
	'count' => 2,
	'path' => __DIR__ . '/../src/Util/Colors.php',
];
$ignoreErrors[] = [
	// identifier: empty.notAllowed
	'message' => '#^Construct empty\\(\\) is not allowed\\. Use more strict comparison\\.$#',
	'count' => 27,
	'path' => __DIR__ . '/../src/Util/Image_Resize.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Util\\\\Image_Resize\\:\\:convert_image_downsize\\(\\) has parameter \\$out with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Util/Image_Resize.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Util\\\\Image_Resize\\:\\:convert_image_downsize\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Util/Image_Resize.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Util\\\\Image_Resize\\:\\:image\\(\\) has parameter \\$args with no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Util/Image_Resize.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Util\\\\Image_Resize\\:\\:image\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Util/Image_Resize.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Lipe\\\\Lib\\\\Util\\\\Url\\:\\:get_query_arg\\(\\) return type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Util/Url.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Property Lipe\\\\Lib\\\\Util\\\\Versions\\:\\:\\$once type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Util/Versions.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Property Lipe\\\\Lib\\\\Util\\\\Versions\\:\\:\\$updates type has no value type specified in iterable type array\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/../src/Util/Versions.php',
];

return ['parameters' => ['ignoreErrors' => $ignoreErrors]];
