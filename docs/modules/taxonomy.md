---
title: Taxonomy
parent: Modules
nav_order: 18
---

# Taxonomy

## Overview

The Taxonomy module handles taxonomy registration, labels, capabilities, admin menu placement, custom taxonomy meta boxes, term query helpers, and object wrapping for individual terms. Legacy `store_user_terms_in_meta` behavior has been removed in v6.0 beta.

## Types in this module

- `Lipe\Lib\Taxonomy\Capabilities`
- `Lipe\Lib\Taxonomy\Get_Terms`
- `Lipe\Lib\Taxonomy\Labels`
- `Lipe\Lib\Taxonomy\Meta_Box`
- `Lipe\Lib\Taxonomy\Taxonomy`
- `Lipe\Lib\Taxonomy\Taxonomy_Trait` (trait)
- `Lipe\Lib\Taxonomy\Wp_Dropdown_Categories`
- `Lipe\Lib\Taxonomy\Wp_List_Categories`
- `Lipe\Lib\Taxonomy\Wp_Terms_Checklist`
- `Lipe\Lib\Taxonomy\Taxonomy\Menu`
- `Lipe\Lib\Taxonomy\Taxonomy\Register_Taxonomy`
- `Lipe\Lib\Taxonomy\Meta_Box\Gutenberg_Box`
- `Lipe\Lib\Taxonomy\Meta_Box\Radio_Walker`

## `Taxonomy`

Primary fluent wrapper for registering a taxonomy and its admin/rest behavior.

### Key public methods

- `public function __construct(string $taxonomy, array $post_types)`
- `public function capabilities(): Capabilities`
- `public function meta_box(string $type, bool $checked_ontop = false): void`
- `public function custom_meta_box(callable|false $callback, callable $sanitize): void`
- `public function add_initial_terms(array $terms = []): void`
- `public function remove_column(string $column): void`
- `public function show_admin_column(string $label = ''): void`
- `public function post_list_filter(bool $enabled = true): void`
- `public function default_term(string $slug, string $name, string $description = ''): void`
- `public function show_in_menu(): Menu`
- `public function show_in_rest(bool $show = true, ?string $base = null, string $space = 'wp/v2', string $controller = \WP_REST_Terms_Controller::class): void`
- `public function args(Get_Terms $query_args): void`
- `public function description(string $description): void`
- `public function hierarchical(bool $is_hierarchical): void`
- `public function public(bool $is_public): void`
- `public function publicly_queryable(bool $is_queryable): void`
- `public function query_var(bool|string $query_var): void`
- `public function rewrite(bool|array $rewrite): void`
- `public function show_in_nav_menus(bool $show): void`
- `public function show_in_quick_edit(bool $show): void`
- `public function show_tagcloud(bool $show): void`
- `public function show_ui(bool $show): void`
- `public function sort(bool $should_short): void`
- `public function update_count_callback(callable $update_cb): void`
- `public function labels(string $singular = '', string $plural = ''): Labels`
- `public function show_in_admin_bar(): void`
- `public static function get_taxonomy(string $taxonomy): ?static`

### Example

```php
<?php
use Lipe\Lib\Taxonomy\Taxonomy;

$genre = new Taxonomy('genre', ['book']);
$genre->labels('Genre', 'Genres');
$genre->show_in_rest();
$genre->show_admin_column();
```

## `Labels`

Fluent builder for taxonomy labels, obtained via `Taxonomy::labels()`.

### Key public methods

- `public function name(string $value): static`
- `public function singular_name(string $value): static`
- `public function search_items(string $value): static`
- `public function popular_items(string $value): static`
- `public function all_items(string $value): static`
- `public function parent_item(string $value): static`
- `public function parent_item_colon(string $value): static`
- `public function edit_item(string $value): static`
- `public function view_item(string $value): static`
- `public function update_item(string $value): static`
- `public function add_new_item(string $value): static`
- `public function new_item_name(string $value): static`
- `public function separate_items_with_commas(string $value): static`
- `public function add_or_remove_items(string $value): static`
- `public function choose_from_most_used(string $value): static`
- `public function not_found(string $value): static`
- `public function no_terms(string $value): static`
- `public function no_item(string $value): static`
- `public function items_list_navigation(string $value): static`
- `public function items_list(string $value): static`
- `public function most_used(string $value): static`
- `public function back_to_items(string $value): static`
- `public function menu_name(string $value): static`
- `public function desc_field_description(string $value): static`
- `public function name_admin_bar(string $value): static`
- `public function name_field_description(string $value): static`
- `public function parent_field_description(string $value): static`
- `public function single_field_description(string $value): static`
- `public function filter_by_item(string $value): static`
- `public function item_link(string $value): static`
- `public function item_link_description(string $value): static`
- `public function get_label(string $key): ?string`
- `public function get_labels(): array`

## `Capabilities`

Fluent builder for taxonomy capabilities, obtained via `Taxonomy::capabilities()`.

### Key public methods

- `public function manage_terms(string $capability = 'manage_categories'): static`
- `public function edit_terms(string $capability = 'manage_categories'): static`
- `public function delete_terms(string $capability = 'manage_categories'): static`
- `public function assign_terms(string $capability = 'edit_posts'): static`
- `public function get_cap(string $capability): ?string`
- `public function get_capabilities(): array`

## `Get_Terms`

Fluent wrapper for the `get_terms()` argument array, also used as the query type for `Taxonomy::args()`.

### Key public methods

- `public function get_light_args(): array`
- `public function __construct(array $existing)`
- `public function merge(ArgsRules $overrides): void`
- `public function get_args(): array`

`Get_Terms` also implements `Query\Clause\Meta_Query_Interface`, adding the `meta_query()` factory documented in the [Query module](query.md).

### Example

```php
<?php
use Lipe\Lib\Taxonomy\Get_Terms;

$terms = new Get_Terms([]);
$terms->taxonomy = 'genre';
$terms->hide_empty = true;
$terms->orderby = Get_Terms::ORDERBY_NAME;

$results = get_terms($terms->get_args());
```

## `Meta_Box`

Renders a custom taxonomy meta box (radio, dropdown, or simple checklist) on the post editing screen, replacing the WordPress default UI.

### Key public methods

- `public function __construct(string $taxonomy, string $type, bool $checked_ontop)`
- `public function replace_default_meta_box(string $post_type, $post): void`
- `public function translate_string_term_ids_to_int(string $taxonomy, array|string $terms): array`
- `public function do_meta_box(\WP_Post $post): void`

### Example

```php
<?php
use Lipe\Lib\Taxonomy\Taxonomy;

$genre = new Taxonomy('genre', ['book']);
$genre->meta_box('radio', true);
```

## `Taxonomy_Trait` trait

Wraps a single `WP_Term` (by ID or object) so it can be read and lazily hydrated.

### Key public methods

- `public function __construct($term)`
- `public function get_object(): ?\WP_Term`
- `public function get_id(): int`
- `public function get_meta_type(): MetaType`
- `public function exists(): bool`
- `public static function factory(int|\WP_Term $term): static`

`Taxonomy_Trait` also composes `Container\Factory` and `Meta\Mutator_Trait`, which add meta-access helpers such as `get_meta()`, `update_meta()`, and `delete_meta()` — see the Meta module.

## `Wp_Dropdown_Categories`

Fluent argument object for `wp_dropdown_categories()`. Extends `Get_Terms` and adds properties such as `$show_option_all`, `$show_option_none`, `$option_none_value`, `$show_count`, `$echo`, `$depth`, `$id`, `$class`, `$selected`, `$value_field`, `$hide_if_empty`, `$required`, and `$walker`.

## `Wp_List_Categories`

Fluent argument object for `wp_list_categories()`. Extends `Get_Terms` and adds properties such as `$current_category`, `$depth`, `$echo`, `$feed`, `$feed_image`, `$feed_type`, `$hide_title_if_empty`, `$separator`, `$show_count`, `$show_option_all`, `$show_option_none`, `$style`, `$title_li`, `$use_desc_for_title`, and `$walker`.

## `Wp_Terms_Checklist`

Fluent argument object for `wp_terms_checklist()`.

### Key public methods

- `public function __construct(array $existing)`
- `public function merge(ArgsRules $overrides): void`
- `public function get_args(): array`

### Example

```php
<?php
use Lipe\Lib\Taxonomy\Wp_Terms_Checklist;

$args = new Wp_Terms_Checklist([]);
$args->taxonomy = 'genre';
$args->checked_ontop = true;

wp_terms_checklist($post_id, $args->get_args());
```

## `Taxonomy\Menu`

Custom admin menu placement for a taxonomy (WordPress does not natively support this). Obtained via `Taxonomy::show_in_menu()`.

### Key public methods

- `public function __construct(Taxonomy $taxonomy)`
- `public function sub_menu(string $parent_menu, int $position = 100): void`
- `public function parent_menu(string|Dashicons $icon = 'dashicons-category', ?int $position = null): void`

### Example

```php
<?php
use Lipe\Lib\Taxonomy\Taxonomy;

$genre = new Taxonomy('genre', ['book']);
$genre->show_in_menu()->parent_menu();
```

## `Taxonomy\Register_Taxonomy`

Fluent argument object for `register_taxonomy()`, built internally by `Taxonomy`.

### Key public methods

- `public function args(): Get_Terms`
- `public function __construct(array $existing)`
- `public function merge(ArgsRules $overrides): void`
- `public function get_args(): array`

## `Meta_Box\Gutenberg_Box`

Serializes a taxonomy meta box configuration to JSON so the block editor can render it.

### Key public methods

- `public function load_script(): void`
- `public function jsonSerialize(): array`
- `public static function get_boxes(): array`
- `public static function factory(Meta_Box $box): static`

## `Meta_Box\Radio_Walker`

Extends `\Walker_Category_Checklist` to render taxonomy terms as radio inputs instead of checkboxes.

### Key public methods

- `public function start_el(&$output, $data_object, $depth = 0, $args = [], $current_object_id = 0): void`
- `public function end_el(&$output, $data_object, $depth = 0, $args = []): void`
