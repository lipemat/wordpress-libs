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
- `Lipe\Lib\Post_Type\Post_Object_Trait` (trait)
- `Lipe\Lib\Post_Type\Post_Type`
- `Lipe\Lib\Post_Type\Register_Post_Status`
- `Lipe\Lib\Post_Type\Register_Post_Type`
- `Lipe\Lib\Post_Type\Wp_Insert_Post`
- `Lipe\Lib\Post_Type\Post_List_Column\Filter` (interface)
- `Lipe\Lib\Post_Type\Post_List_Column\ListColumn` (interface)

## `Post_Type`

Primary fluent wrapper for registering a custom post type and related admin behavior.

### Key public methods

- `final public function __construct(string $post_type)`
- `public function featured_image_labels(string $label): void`
- `public function labels(string $singular = '', string $plural = ''): Labels`
- `public function gutenberg_template(array $template, bool|string $template_lock = false): static`
- `public function capabilities(): Capabilities`
- `public function archive_label(string $label): void`
- `public function add_support(string|array $feature): void`
- `public function remove_support(string|array $feature): void`
- `public function remove_column(string $column): void`
- `public function exclude_from_sitemaps(): void`
- `public function disable_single(): void`
- `public function gutenberg_compatible(bool $compatible): void`
- `public function rest_controllers(string $base = \WP_REST_Posts_Controller::class, string $autosave = \WP_REST_Autosaves_Controller::class, string $revisions = \WP_REST_Revisions_Controller::class, bool $late_registration = false): void`
- `public function show_in_rest(bool $show = true, ?string $base = null, string $space = 'wp/v2'): void`
- `public function show_in_menu(Dashicons|string $icon = '', ?string $parent_menu = null, int $position = 5): void`
- `public function allow_auto_admin_caps(bool $allowed): void`
- `public function can_export(bool $can_export): void`
- `public function capability_type(array|string $capability_type): void`
- `public function delete_with_user(bool $delete_with_user): void`
- `public function description(string $description): void`
- `public function exclude_from_search(bool $is_excluded): void`
- `public function has_archive(bool|string $has_archive): void`
- `public function hierarchical(bool $is_hierarchical): void`
- `public function embeddable(bool $is_embeddable): void`
- `public function map_meta_cap(bool $use_mapping): void`
- `public function public(bool $is_public): void`
- `public function publicly_queryable(bool $is_queryable): void`
- `public function query_var(bool|string $query_var): void`
- `public function register_meta_box_cb(callable $register_cb): void`
- `public function rewrite(bool|array $rewrite): void`
- `public function show_in_admin_bar(bool $show): void`
- `public function show_in_nav_menus(bool $show): void`
- `public function show_ui(bool $show_ui): void`
- `public function taxonomies(array $taxonomies): void`
- `public static function get_post_type(string $post_type): ?static`

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

Fluent label builder used by `Post_Type`. Every setter returns `static` and stores its value under the matching label key; `get_label()`/`get_labels()` read the accumulated values back.

### Key public methods

- `public function name(string $label): static`
- `public function singular_name(string $label): static`
- `public function add_new(string $label): static`
- `public function add_new_item(string $label): static`
- `public function archive_label(string $label): static`
- `public function edit_item(string $label): static`
- `public function new_item(string $label): static`
- `public function view_item(string $label): static`
- `public function view_items(string $label): static`
- `public function search_items(string $label): static`
- `public function not_found(string $label): static`
- `public function not_found_in_trash(string $label): static`
- `public function parent_item_colon(string $label): static`
- `public function all_items(string $label): static`
- `public function archives(string $label): static`
- `public function attributes(string $label): static`
- `public function insert_into_item(string $label): static`
- `public function uploaded_to_this_item(string $label): static`
- `public function featured_image(string $label): static`
- `public function set_featured_image(string $label): static`
- `public function remove_featured_image(string $label): static`
- `public function use_featured_image(string $label): static`
- `public function menu_name(string $label): static`
- `public function filter_items_list(string $label): static`
- `public function filter_by_date(string $label): static`
- `public function items_list_navigation(string $label): static`
- `public function items_list(string $label): static`
- `public function item_published(string $label): static`
- `public function item_published_privately(string $label): static`
- `public function item_reverted_to_draft(string $label): static`
- `public function item_scheduled(string $label): static`
- `public function item_updated(string $label): static`
- `public function item_link(string $label): static`
- `public function item_link_description(string $label): static`
- `public function get_label(string $label_key): ?string`
- `public function get_labels(): array`

## `Capabilities`

Fluent capability builder used by `Post_Type`. Setting any capability also switches the post type to `map_meta_cap(true)`.

### Key public methods

- `public function __construct(protected Post_Type $post_type)`
- `public function edit_post(string $capability): static`
- `public function read_post(string $capability): static`
- `public function delete_post(string $capability): static`
- `public function edit_posts(string $capability): static`
- `public function edit_others_posts(string $capability): static`
- `public function publish_posts(string $capability): static`
- `public function read_private_posts(string $capability): static`
- `public function read(string $capability): static`
- `public function delete_posts(string $capability): static`
- `public function delete_private_posts(string $capability): static`
- `public function delete_published_posts(string $capability): static`
- `public function delete_others_posts(string $capability): static`
- `public function edit_private_posts(string $capability): static`
- `public function edit_published_posts(string $capability): static`
- `public function create_posts(string $capability): static`
- `public function get_cap(string $capability_name): ?string`
- `public function get_capabilities(): array`

## `Post_Object_Trait`

Shared base for classes that wrap a single `WP_Post`. Combines `Factory` (for `factorize()`-based instance caching) and `Mutator_Trait` (for `get_meta()`/`update_meta()`/`delete_meta()`) to give post-wrapping classes a consistent construction and meta API.

### Key public methods

- `final public function __construct(int|\WP_Post|null $post = null)`
- `public function get_object(): ?\WP_Post`
- `public function get_id(): int`
- `public function get_meta_type(): MetaType`
- `public function exists(): bool`
- `public static function factory(int|\WP_Post|null $post = null): static`

## `Post_List_Column`

Registers a custom admin column for a list of post types. A basic column implements `ListColumn`; a filterable column also implements `Post_List_Column\Filter`, in which case a `Post_List_Filter` is created automatically.

### Key public methods

- `public function __construct(protected ListColumn $column)`
- `public function maybe_render_column(string $column, int $post_id): void`
- `public function add_column(array $columns): array`

## `Post_List_Filter`

Registers a post list filter drop-down independently of `Post_List_Column`, for cases where the column itself is already handled elsewhere (e.g. by CMB2).

### Key public methods

- `public function __construct(protected Filter $filter_column, protected string $column_slug)`
- `public function render_filter(string $post_type): void`
- `public function maybe_filter_query(\WP_Query $query): void`

## `Post_List_Column\Filter`

Contract enabling a post list filter drop-down for a column.

### Methods

- `public function get_post_types(): array`
- `public function get_show_all_label(): string`
- `public function get_options(): array`
- `public function filter_query(string $value, \WP_Query $query): void`

## `Post_List_Column\ListColumn`

Contract for a basic custom post list column.

### Methods

- `public function get_post_types(): array`
- `public function get_column_position(): int`
- `public function get_column_label(): string`
- `public function render(int $post_id): void`

## Supporting types

- `Register_Post_Status`, `Register_Post_Type`, and `Wp_Insert_Post` are fluent arg objects for the corresponding WordPress core functions.
