---
title: CMB2
parent: Modules
nav_order: 4
---

# CMB2

## Overview

The CMB2 module is one of the largest parts of the library. It provides a fluent interface for creating CMB2 boxes, fields, groups, options pages, and field variations while also integrating with the library's meta repository and REST helpers.

## Primary types

- `Lipe\Lib\CMB2\Box`
- `Lipe\Lib\CMB2\Field`
- `Lipe\Lib\CMB2\Group`
- `Lipe\Lib\CMB2\Options_Page`
- `Lipe\Lib\CMB2\Term_Box`
- `Lipe\Lib\CMB2\User_Box`
- `Lipe\Lib\CMB2\Comment_Box`

## Supporting types

- `Lipe\Lib\CMB2\Box\BoxType` (enum)
- `Lipe\Lib\CMB2\Box\Tabs`
- `Lipe\Lib\CMB2\Field\Checkbox`
- `Lipe\Lib\CMB2\Field\Default_Callback`
- `Lipe\Lib\CMB2\Field\Display` (trait)
- `Lipe\Lib\CMB2\Field\Event_Callbacks` (trait)
- `Lipe\Lib\CMB2\Field\Field_Type`
- `Lipe\Lib\CMB2\Field\Term_Select_2`
- `Lipe\Lib\CMB2\Field\Term_Select_2\Select_2_Field`
- `Lipe\Lib\CMB2\Field\True_False`
- `Lipe\Lib\CMB2\Field\Type` (enum)
- `Lipe\Lib\CMB2\Group\Layout` (enum)
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
- `public function get_cmb2_box(): \CMB2`

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

- `public function column(bool|int $position = false, string $name = '', ?callable $display_cb = null, bool $disable_sorting = false): static`
- `public function attributes(array $attributes): static`
- `public function default(callable|string|array $default_value): static`
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
- `public function display_cb(callable $display_cb): void`
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

## Variations and field helpers

The variation classes adapt a base `Field` into more specific fluent builders:

- `Variation\Date` adds `public function date_format(string $date_format): Date` and timezone helpers.
- `Variation\File` adds `public function file_query_args(Get_Posts $args): static` and `public function preview_size(string $preview_size): static`.
- `Variation\Options` adds `public function options(array $options): Options` and `public function options_cb(callable $options_cb): Options`.
- `Variation\Taxonomy` adds `public function taxonomy_args(string $taxonomy, ?string $no_terms_text = null, ?bool $remove_default = null): array` and `public function get_taxonomy(): string`.
- `Variation\TextUrl` adds `public function protocols(array $protocols): static`.
- `Variation\Text` adds `public function char_counter(bool $count_words = false, ?int $max = null, bool $enforce = false, array $labels = []): static`.

Use `Field::from()` internally to translate a base field into the appropriate variation wrapper.
