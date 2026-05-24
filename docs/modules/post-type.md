---
title: Post Type
parent: Modules
nav_order: 13
---

# Post Type

## Overview

The Post Type module covers custom post type registration, label and capability builders, list-table integrations, post object wrapping, and insert/update helpers.

## Types in this module

- `Lipe\Lib\Post_Type\Capabilities`
- `Lipe\Lib\Post_Type\Labels`
- `Lipe\Lib\Post_Type\Post_List_Column`
- `Lipe\Lib\Post_Type\Post_List_Filter`
- `Lipe\Lib\Post_Type\Post_Object_Trait`
- `Lipe\Lib\Post_Type\Post_Type`
- `Lipe\Lib\Post_Type\Register_Post_Status`
- `Lipe\Lib\Post_Type\Register_Post_Type`
- `Lipe\Lib\Post_Type\Wp_Insert_Post`
- `Lipe\Lib\Post_Type\Post_List_Column\Filter` (interface)
- `Lipe\Lib\Post_Type\Post_List_Column\ListColumn` (interface)

## `Post_Type`

Primary fluent wrapper for registering a custom post type and related admin behavior.

### Key public methods

- `public function __construct(string $post_type)`
- `public function labels(string $singular = '', string $plural = ''): Labels`
- `public function featured_image_labels(string $label): void`
- `public function gutenberg_template(array $template, bool|string $template_lock = false): Post_Type`
- `public function capabilities(): Capabilities`
- `public function archive_label(string $label): void`
- `public function add_support(string|array $feature): void`
- `public function remove_support(string|array $feature): void`
- `public function exclude_from_sitemaps(): void`
- `public function disable_single(): void`
- `public function rest_controllers(string $base = \WP_REST_Posts_Controller::class, string $autosave = \WP_REST_Autosaves_Controller::class, string $revisions = \WP_REST_Revisions_Controller::class, bool $late_registration = false): void`
- `public function show_in_rest(bool $show = true, ?string $base = null, string $space = 'wp/v2'): void`
- `public function show_in_menu(Dashicons|string $icon = '', ?string $parent_menu = null, int $position = 5): void`
- `public function taxonomies(array $taxonomies): void`
- `public static function get_post_type(string $post_type): ?Post_Type`

### Example

```php
<?php
use Lipe\Lib\Post_Type\Post_Type;

$books = new Post_Type('book');
$books->labels('Book', 'Books');
$books->show_in_rest(true, 'books');
$books->add_support(['title', 'editor', 'thumbnail']);
```

## `Labels`

Fluent label builder used by `Post_Type`.

### Key public methods

- `public function name(string $label): Labels`
- `public function singular_name(string $label): Labels`
- `public function add_new_item(string $label): Labels`
- `public function archive_label(string $label): Labels`
- `public function menu_name(string $label): Labels`
- `public function get_label(string $label_key): ?string`
- `public function get_labels(): array`

## `Capabilities`

Fluent capability builder used by `Post_Type`.

### Key public methods

- `public function edit_post(string $capability): Capabilities`
- `public function edit_posts(string $capability): Capabilities`
- `public function publish_posts(string $capability): Capabilities`
- `public function create_posts(string $capability): Capabilities`
- `public function get_cap(string $capability_name): ?string`
- `public function get_capabilities(): array`

## List-table integration

- `Post_List_Column` registers a custom admin column and exposes `public function maybe_render_column(string $column, int $post_id): void` and `public function add_column(array $columns): array`.
- `Post_List_Filter` connects a `Post_List_Column\Filter` implementation to the list table and exposes `public function render_filter(string $post_type): void` and `public function maybe_filter_query(\WP_Query $query): void`.
- `Post_List_Column\ListColumn` and `Post_List_Column\Filter` define the contracts used by those classes.

## Supporting types

- `Post_Object_Trait` wraps a `WP_Post` and exposes `get_object()`, `get_id()`, `exists()`, and `factory()`.
- `Register_Post_Status`, `Register_Post_Type`, and `Wp_Insert_Post` are fluent arg objects for the corresponding WordPress core functions.
