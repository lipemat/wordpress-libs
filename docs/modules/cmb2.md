---
title: CMB2
parent: Modules
nav_order: 4
---

# CMB2

## Overview

The CMB2 module is one of the largest parts of the library. It provides a fluent interface for creating CMB2 boxes, fields, groups, options pages, and field variations while also integrating with the library's meta repository and REST helpers. In v6.0 beta, callback registration arguments were tightened to `\Closure` and many config properties became `protected(set)` for public read access.

## Types in this module

- `Lipe\Lib\CMB2\Box`
- `Lipe\Lib\CMB2\Field`
- `Lipe\Lib\CMB2\Group`
- `Lipe\Lib\CMB2\Options_Page`
- `Lipe\Lib\CMB2\Term_Box`
- `Lipe\Lib\CMB2\User_Box`
- `Lipe\Lib\CMB2\Comment_Box`

- `Lipe\Lib\CMB2\Box\BoxType` (enum)
- `Lipe\Lib\CMB2\Box\Tabs`
- `Lipe\Lib\CMB2\Field\Checkbox`
- `Lipe\Lib\CMB2\Field\Default_Callback`
- `Lipe\Lib\CMB2\Field\Display` (trait)
- `Lipe\Lib\CMB2\Field\Event_Callbacks`
- `Lipe\Lib\CMB2\Field\Field_Type`
- `Lipe\Lib\CMB2\Field\Term_Select_2`
- `Lipe\Lib\CMB2\Field\Term_Select_2\Select_2_Field`
- `Lipe\Lib\CMB2\Field\True_False`
- `Lipe\Lib\CMB2\Field\Type` (enum)
- `Lipe\Lib\CMB2\Group\Layout`
- `Lipe\Lib\CMB2\Group\Max_Rows`
- `Lipe\Lib\CMB2\Variation\Checkbox`
- `Lipe\Lib\CMB2\Variation\Date`
- `Lipe\Lib\CMB2\Variation\File`
- `Lipe\Lib\CMB2\Variation\Options`
- `Lipe\Lib\CMB2\Variation\Taxonomy`
- `Lipe\Lib\CMB2\Variation\Text`
- `Lipe\Lib\CMB2\Variation\TextUrl`
- `Lipe\Lib\CMB2\Variation\Wysiwyg`

## `Box`

The main CMB2 box wrapper. It collects fields, groups, REST settings, tabs, and display options before registering the underlying `\CMB2` box.

### Key public methods

- `public function __construct(string $id, array $object_types, ?string $title)`
- `public function add_field(Field $field): Field`
- `public function field(string $id, string $name): Field_Type`
- `public function group(string $id, string $name, ?string $row_title = null): Group`
- `public function priority(string $priority): void`
- `public function context(string $context): void`
- `public function description(string $description): void`
- `public function show_in_rest($methods = \WP_REST_Server::READABLE): void`
- `public function add_tab(string $id, string $label): void`
- `public function tabs_style(string $layout): void`
- `public function remove_box_wrap(bool $remove_box_wrap = true): void`
- `public function get_cmb2_box(): \CMB2`
- `public function get_box_type(): BoxType`

### Example

```php
<?php
use Lipe\Lib\CMB2\Box;

$box = new Box('book-details', ['book'], 'Book Details');
$field = $box->field('isbn', 'ISBN');
$field->description('13 digit ISBN');
$box->show_in_rest();
```

## `Field`

Represents a single CMB2 field and exposes shared field configuration for columns, defaults, REST behavior, display helpers, and save hooks.

### Key public methods

- `public function column(bool|int $position = false, string $name = '', ?\Closure $display_cb = null, bool $disable_sorting = false): static`
- `public function attributes(array $attributes): static`
- `public function default(string|array $default_value): static`
- `public function description(string $description): static`
- `public function repeatable(bool $repeatable = true, ?string $add_row_text = null): static`
- `public function show_in_rest(bool|string $methods = \WP_REST_Server::ALLMETHODS): static`
- `public function tab(string $id): static`
- `public function set_args(Type $type, array $args, DataType $data_type): static`
- `public function get_field_args(): array`
- `public static function from(Field $field, Box $box): static`
- `public static function factory(string $id, string $name, Box $box, ?Group $group = null): static`

## `Group`

A repeatable group field that behaves like both a field and a field container.

### Key public methods

- `public function field(string $id, string $name): Field_Type`
- `public function layout(string $layout): Group`
- `public function max_rows(int $max_rows): static`
- `public function repeatable(bool $repeatable = true, ?string $add_row_text = null, ?string $remove_row_text = null, ?string $remove_confirm = null): static`
- `public function sortable(bool $sortable = true): static`
- `public function closed(bool $closed = true): static`
- `public function get_field_args(): array`
- `public function add_field(Field $field): Field`

## `Options_Page`

Extends `Box` for CMB2-backed settings pages, including network-aware storage behavior.

### Key public methods

- `public function __construct(string $id, ?string $title)`
- `public function capability(string $capability): void`
- `public function menu_title(string $menu_title): void`
- `public function parent_slug(string $parent_slug): void`
- `public function network(bool $is_network = true): void`
- `public function position(int $position): void`
- `public function icon(string|Dashicons $icon): void`
- `public function display_cb(\Closure $display_cb): void`
- `public function message_cb(\Closure $message_cb): void`
- `public function save_button(?string $text): void`
- `public function is_network(): bool`

### Example

```php
<?php
use Lipe\Lib\CMB2\Options_Page;

$page = new Options_Page('acme-settings', 'Acme Settings');
$page->menu_title('Acme');
$page->capability('manage_options');
$page->field('api_key', 'API Key')->description('Used for upstream requests.');
```

## `Term_Box`, `User_Box`, and `Comment_Box`

Specialized box subclasses for term, user, and comment screens.

### Key public methods

- `public function __construct(string $id, array $taxonomies, string $title)` (`Term_Box`)
- `public function __construct(string $id, string $title)` (`User_Box`)
- `public function __construct(string $id, string $title)` (`Comment_Box`)
- `public function context(string $context): void` (`Comment_Box`)
- `public function show_on_new_terms(bool $show): static` (`Term_Box`)

## `Field_Type`

Factory exposed via `Box::field()` and `Group::field()` that returns the appropriate concrete CMB2 field type. Each method corresponds to a CMB2 field type and returns either a base `Field` or the matching variation builder.

### Selected public methods

- `public function title(): Field`
- `public function text(): Text`
- `public function text_url(?array $protocols = null): TextUrl`
- `public function textarea(?int $rows = null): Text`
- `public function text_date(string $date_format = 'm/d/Y', string $timezone_meta_key = '', array $date_picker_options = []): Date`
- `public function checkbox(string $layout = Field\Checkbox::LAYOUT_BLOCK): Variation\Checkbox`
- `public function true_false(): Variation\Checkbox`
- `public function select(array|\Closure $options_or_callback, bool|string $show_option_none = true): Options`
- `public function radio(\Closure|array $options_or_callback, bool|string $show_option_none = true): Options`
- `public function multicheck(\Closure|array $options_or_callback, bool $select_all = true): Options`
- `public function taxonomy_select(string $taxonomy, ?string $no_terms_text = null, ?bool $remove_default = null): Taxonomy`
- `public function taxonomy_select_2(string $taxonomy, bool $assign_terms = false, ?string $no_terms_text = null, ?bool $remove_default = null): Taxonomy`
- `public function wysiwyg(array $mce_options = []): Wysiwyg`
- `public function file(?string $button_text = null, ?string $file_mime_type = null, ?bool $show_text_input = null, ?string $preview_size = null, ?string $select_text = null): File`
- `public function image(string $button_text = 'Add Image', ?bool $show_text_input = null, ?string $preview_size = null): File`
- `public function group(?string $title = null): Field`

Additional methods cover small/medium/email text, money/number text, hidden inputs, oEmbed, color pickers, the full date/timestamp/timezone family, taxonomy radio/multicheck variants, and `file_list`. Refer to `src/CMB2/Field/Field_Type.php` for the complete list.

Callback/config state is exposed via typed `protected(set)` properties, so consumers can inspect values directly (for example on `Box`, `Field`, `Group`, `Options_Page`, and Variation classes) without relying on `get_config()`.

`Field::default()` accepts only `string|array`; use `Field::default_cb(\Closure $callback)` for dynamic defaults.

## `Box\BoxType`

Enum of the object types a `Box` may be registered against. Returned by `Box::get_box_type()`.

### Cases

- `COMMENT = 'comment'`
- `OPTIONS = 'options-page'`
- `USER = 'user'`
- `TERM = 'term'`
- `POST = 'post'`

## `Box\Tabs`

Singleton that renders tabbed meta boxes. Hooked automatically the first time `Box::add_tab()` or `Field::tab()` is used; not normally called directly.

### Key public methods

- `public function opening_div(string $cmb_id, int|string $object_id, string $object_type, \CMB2 $cmb): void`
- `public function closing_div(): void`
- `public function render_nav(string $cmb_id, int|string $object_id, string $object_type, \CMB2 $cmb): void`
- `public function add_wrap_class(array $classes): array`
- `public function render_field(array $field_args, \CMB2_Field $field): void`
- `public function show_panels(string $cmb_id, int|string $object_id, string $object_type, \CMB2 $cmb): void`
- `public function capture_fields(string $output, array $field_args): string`

### Example

```php
<?php
use Lipe\Lib\CMB2\Box;

$box = new Box('book-details', ['book'], 'Book Details');
$box->add_tab('general', 'General');
$box->field('isbn', 'ISBN')->text()->tab('general');
```

## `Field\Checkbox`

Singleton providing the compact checkbox rendering used when `Field_Type::checkbox()` is called with a non-`block` layout.

### Key public methods

- `public function render_field_callback(array $args, \CMB2_Field $field): void`

Constants: `LAYOUT_BLOCK`, `LAYOUT_COMPACT`.

## `Field\Default_Callback`

Backs `Field::default_cb()`. Hooks into the appropriate WordPress or CMB2 filter so a callback (instead of a static value) supplies the field's default.

### Key public methods

- `public function default_meta_callback(mixed $value, int|string $object_id, string $meta_key): mixed`
- `public function default_option_callback(): mixed`
- `public static function factory(Field $field, Box $box, \Closure $callback): static`

## `Field\Display`

Trait mixed into `Field` providing the shared "display" configuration parameters (render callbacks, before/after markup, labels, classes).

### Key public methods

- `public function position(int $position = 1): Field`
- `public function before(\Closure|string $before): static`
- `public function after(\Closure|string $after): static`
- `public function before_row(\Closure|string $before_row): static`
- `public function after_row(\Closure|string $after_row): static`
- `public function before_field(\Closure|string $before_field): static`
- `public function after_field(\Closure|string $after_field): static`
- `public function before_display(\Closure|string $before_display): static`
- `public function after_display(\Closure|string $after_display): static`
- `public function before_display_wrap(\Closure|string $before_display_wrap): static`
- `public function after_display_wrap(\Closure|string $after_display_wrap): static`
- `public function label_cb(\Closure $label_cb): static`
- `public function on_front(bool $on_front): static`
- `public function classes(array|string $classes): static`
- `public function classes_cb(\Closure $classes_cb): static`
- `public function description(string $description): static`
- `public function description_cb(\Closure $description_cb): static`
- `public function display_class(\CMB2_Field_Display $display_class): static`
- `public function show_names(bool $show_names): static`
- `public function show_on_cb(\Closure $func): Field`
- `public function render_row_cb(\Closure|null $render_row_cb): static`
- `public function render_class(string $render_class): static`

## `Field\Event_Callbacks`

Backs `Field::change_cb()` and `Field::delete_cb()`. Registers native WordPress action hooks (meta, taxonomy relationships, or options) so callbacks fire even when data changes outside of CMB2.

### Key public methods

- `public function taxonomy_change_hooks(): void`
- `public function options_change_hooks(): void`
- `public function options_delete_hooks(): void`
- `public function meta_change_hooks(): void`
- `public function fire_change_callback(int|string $object_id, mixed $value, string $change_type): void`
- `public function fire_delete_callback(int|string $object_id): void`
- `public static function factory(Field $field, \Closure $callback, string $cb_type): static`

### Example

```php
<?php
use Lipe\Lib\CMB2\Box;

$box = new Box('book-details', ['book'], 'Book Details');
$box->field('isbn', 'ISBN')->text()->change_cb( function( $object_id, $value, $key, $previous, $box_type, $call_type ) {
	// React to the ISBN value changing.
} );
```

## `Field\Term_Select_2`

Singleton backing the Select2-powered term selector field created by `Field_Type::taxonomy_select_2()`. Handles AJAX term search, sanitization, and escaping for the field.

### Key public methods

- `public function ajax_get_terms(): void`
- `public function render(\CMB2_Field $field, array|string $value, \CMB2_Types $field_type_object): void`
- `public function set_object_terms(mixed $filtered, mixed $meta_value, int|string $id, array $field_args): ?array`
- `public function esc_values(mixed $filtered, array|null|string $values, array $field_args): null|array|string`
- `public function get_select_2_fields(string $field_id): ?Select_2_Field`
- `public function js_config(): array`
- `public function register(Select_2_Field $field): void`

Constants: `GET_TERMS` (AJAX action), `NONCE`.

## `Field\Term_Select_2\Select_2_Field`

Implements `\JsonSerializable`. Registered automatically when `Field_Type::taxonomy_select_2()` is used; holds the taxonomy and `assign_terms` configuration for a single field.

### Key public methods

- `public function jsonSerialize(): array`
- `public static function factory(Field $field, string $taxonomy, bool $assign_terms): static`

## `Field\True_False`

Extends `\CMB2_Type_Checkbox` to render the on/off toggle switch used by `Field_Type::true_false()` / `Field_Type::toggle()`. Assigned via `Field::render_class()`; not instantiated directly.

### Key public methods

- `public function render($args = []): \CMB2_Type_Base|string`

## `Field\Type`

Enum of the CMB2 field type slugs (`checkbox`, `text`, `select`, `taxonomy_select`, `group`, etc.) used internally by `Field::type` and `Field_Type`.

## `Group\Layout`

Singleton implementing the `row` and `table` custom group layouts assigned via `Group::layout()`.

### Key public methods

- `public function render_group_callback(array $field_args, \CMB2_Field $field_group): void`
- `public function render_group_table_header(\CMB2_Field $field_group): void`
- `public function render_group_table_row(\CMB2_Field $field_group): \CMB2|bool`

Constants: `BLOCK`, `TABLE`, `ROW`.

### Example

```php
<?php
use Lipe\Lib\CMB2\Box;
use Lipe\Lib\CMB2\Group\Layout;

$box = new Box('book-details', ['book'], 'Book Details');
$group = $box->group('editions', 'Editions');
$group->layout(Layout::TABLE);
```

## `Group\Max_Rows`

Container service backing `Group::max_rows()`. Enqueues the admin script and localizes the per-group row limits enforced in JS.

### Key public methods

- `public function register(Group $field): void`
- `public function js_config(): array`

## `Variation\Checkbox`

Field variation returned by `Field_Type::checkbox()` and `Field_Type::true_false()`. Overrides `default()` since checkboxes require a `default_cb` instead of a static value.

### Key public methods

- `public function default(string|array $default_value): static` — always throws `\LogicException`; use `Field::default_cb()`.

## `Variation\Date`

Field variation returned by `Field_Type::text_date()` and the related timestamp/timezone methods.

### Key public methods

- `public function date_format(string $date_format): static`
- `public function timezone(string $timezone): static`
- `public function timezone_meta_key(string $timezone_meta_key): static`
- `public function date_args(string $date_format = 'm/d/Y', string $timezone_meta_key = '', array $date_picker_options = [], array $time_picker_options = []): array`

## `Variation\File`

Field variation returned by `Field_Type::file()`, `Field_Type::image()`, and `Field_Type::file_list()`.

### Key public methods

- `public function file_query_args(Get_Posts $args): static`
- `public function file_args(?string $button_text = null, ?string $file_mime_type = null, ?bool $show_text_input = null, ?string $preview_size = null, ?string $remove_item_text = null, ?string $file_text = null, ?string $download_text = null, ?string $select_text = null): array`
- `public function required(): static`
- `public function preview_size(string $preview_size): static`

### Example

```php
<?php
use Lipe\Lib\CMB2\Box;
use Lipe\Lib\Query\Get_Posts;

$box = new Box('book-details', ['book'], 'Book Details');
$field = $box->field('cover', 'Cover Image')->image();
$args = new Get_Posts([]);
$args->post_mime_type = 'image/jpeg';
$field->file_query_args($args);
```

## `Variation\Options`

Field variation returned by `Field_Type::select()`, `radio()`, `radio_inline()`, `multicheck()`, and `multicheck_inline()`.

### Key public methods

- `public function options(array $options): static`
- `public function show_option_none(bool|string $show_option_none): static`
- `public function options_cb(\Closure $options_cb): static`
- `public function select_all_button(bool $select_all_button): static`
- `public function option_args(\Closure|array $options_or_callback, bool|string|null $show_option_none = null): array`

## `Variation\Taxonomy`

Field variation returned by the `taxonomy_*` methods on `Field_Type` (`taxonomy_select()`, `taxonomy_radio()`, `taxonomy_multicheck()`, `taxonomy_select_2()`, etc.).

### Key public methods

- `public function remove_default(bool $remove_default): static`
- `public function select_all_button(bool $select_all_button): static`
- `public function term_query_args(Get_Terms $args): static`
- `public function taxonomy_args(string $taxonomy, ?string $no_terms_text = null, ?bool $remove_default = null): array`
- `public function store_terms_in_meta(bool $use_meta = true): static`
- `public function get_taxonomy(): string`

### Example

```php
<?php
use Lipe\Lib\CMB2\Box;

$box = new Box('book-details', ['book'], 'Book Details');
$box->field('genre', 'Genre')
	->taxonomy_select('genre')
	->store_terms_in_meta();
```

## `Variation\Text`

Field variation returned by `Field_Type::text()`, `text_small()`, `text_medium()`, `text_email()`, `text_money()`, `text_number()`, `textarea()`, and `textarea_small()`.

### Key public methods

- `public function char_counter(bool $count_words = false, ?int $max = null, bool $enforce = false, array $labels = []): static`

## `Variation\TextUrl`

Extends `Variation\Text`. Returned by `Field_Type::text_url()`.

### Key public methods

- `public function protocols(array $protocols): static`

## `Variation\Wysiwyg`

Extends `Variation\Text`. Returned by `Field_Type::wysiwyg()`. Exposes the `$options` (TinyMCE options) property set via `Field_Type::wysiwyg(array $mce_options)`; no additional public methods beyond those inherited from `Field` and `Text`.
