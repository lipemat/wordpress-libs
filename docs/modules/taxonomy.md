---
title: Taxonomy
parent: Modules
nav_order: 18
---

# Taxonomy

## Overview

The Taxonomy module handles taxonomy registration, labels, capabilities, admin menu placement, custom taxonomy meta boxes, term query helpers, and object wrapping for individual terms.

## Types in this module

- `Lipe\Lib\Taxonomy\Capabilities`
- `Lipe\Lib\Taxonomy\Get_Terms`
- `Lipe\Lib\Taxonomy\Labels`
- `Lipe\Lib\Taxonomy\Meta_Box`
- `Lipe\Lib\Taxonomy\Taxonomy`
- `Lipe\Lib\Taxonomy\Taxonomy_Trait`
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
- `public function show_admin_column(string $label = ''): void`
- `public function post_list_filter(bool $enabled = true): void`
- `public function default_term(string $slug, string $name, string $description = ''): void`
- `public function show_in_menu(): Menu`
- `public function show_in_rest(bool $show = true, ?string $base = null, string $space = 'wp/v2', string $controller = \WP_REST_Terms_Controller::class): void`
- `public function args(Get_Terms $query_args): void`
- `public function labels(string $singular = '', string $plural = ''): Labels`
- `public static function get_taxonomy(string $taxonomy): ?Taxonomy`

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

Fluent builder for taxonomy labels.

### Key public methods

- `public function name(string $value): Labels`
- `public function singular_name(string $value): Labels`
- `public function search_items(string $value): Labels`
- `public function menu_name(string $value): Labels`
- `public function get_label(string $key): ?string`
- `public function get_labels(): array`

## `Capabilities`

Fluent builder for taxonomy capabilities.

### Key public methods

- `public function manage_terms(string $capability = 'manage_categories'): Capabilities`
- `public function edit_terms(string $capability = 'manage_categories'): Capabilities`
- `public function delete_terms(string $capability = 'manage_categories'): Capabilities`
- `public function assign_terms(string $capability = 'edit_posts'): Capabilities`
- `public function get_cap(string $capability): ?string`
- `public function get_capabilities(): array`

## Query and object helpers

- `Get_Terms` is the fluent `get_terms()` builder and exposes `public function get_light_args(): array` plus shared `Args` behavior.
- `Taxonomy_Trait` wraps a single `WP_Term` and exposes `__construct($term)`, `get_object()`, `get_id()`, `get_meta_type()`, `exists()`, and `factory()`.
- `Wp_Dropdown_Categories`, `Wp_List_Categories`, and `Wp_Terms_Checklist` are fluent arg objects for the corresponding WordPress template functions.

## Admin menu and meta-box helpers

- `Taxonomy\Menu` manages custom admin menu placement through `public function sub_menu(string $parent_menu, int $position = 100): void` and `public function parent_menu(string|Dashicons $icon = 'dashicons-category', ?int $position = null): void`.
- `Taxonomy\Register_Taxonomy` is the fluent argument object for `register_taxonomy()` and exposes `public function args(): Get_Terms`.
- `Meta_Box` swaps the default taxonomy meta box and exposes `replace_default_meta_box()`, `translate_string_term_ids_to_int()`, and `do_meta_box()`.
- `Meta_Box\Gutenberg_Box` serializes taxonomy meta-box configuration for the block editor.
- `Meta_Box\Radio_Walker` customizes term output with radio-button markup.
