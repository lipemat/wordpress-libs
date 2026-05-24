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

## Variations and field helpers

The variation classes adapt a base `Field` into more specific fluent builders:

- `Variation\Date` adds `public function date_format(string $date_format): Date` and timezone helpers.
- `Variation\File` adds `public function file_query_args(Get_Posts $args): static` and `public function preview_size(string $preview_size): static`.
- `Variation\Options` adds `public function options(array $options): Options` and `public function options_cb(\Closure $options_cb): Options`.
- `Variation\Taxonomy` adds `public function taxonomy_args(string $taxonomy, ?string $no_terms_text = null, ?bool $remove_default = null): array` and `public function get_taxonomy(): string`.
- `Variation\TextUrl` adds `public function protocols(array $protocols): static`.
- `Variation\Text` adds `public function char_counter(bool $count_words = false, ?int $max = null, bool $enforce = false, array $labels = []): static`.

Use `Field::from()` internally to translate a base field into the appropriate variation wrapper.

Callback/config state is now exposed via typed `protected(set)` properties, so consumers can inspect values directly (for example on `Box`, `Field`, `Group`, `Options_Page`, and Variation classes) without relying on `get_config()`.
