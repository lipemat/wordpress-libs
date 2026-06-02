---
title: Fluent Interfaces
nav_order: 3
---

# Fluent Interfaces

WordPress Libs ships a collection of fluent (chainable) wrappers around
common WordPress core functions. Each wrapper exposes the underlying
function's arguments as typed public properties or chainable setters, then
produces an array that can be passed straight to the WordPress function.

All wrappers implement [`ArgsRules`](modules/args/) and use the shared
[`Args`](modules/args/) trait, which provides `__construct( array $existing )`,
`merge( ArgsRules $overrides )`, and `get_args(): array`.

Some wrappers compose smaller, focused sub-builders (for example
`Blocks\Register_Block` accepts `Blocks\Attributes`, `Blocks\Args\Supports`,
and `Blocks\Args\Source`; `Post_Type\Register_Post_Type` accepts
`Post_Type\Labels` and `Post_Type\Capabilities`; `Taxonomy\Register_Taxonomy`
accepts `Taxonomy\Labels` and `Taxonomy\Capabilities`). Those sub-builders
are not listed below; see the parent module's documentation for usage.

## Wrappers around WordPress core functions

| Class | Wrapped WP function(s) | Module | Description |
| --- | --- | --- | --- |
| `Lipe\Lib\Api\Wp_Remote` | `wp_remote_get`, `wp_remote_post`, `wp_remote_request`, `wp_safe_remote_*` | [API](modules/api/) | Build and send HTTP requests with typed args for method, headers, body, timeout, and cookies. |
| `Lipe\Lib\Blocks\Attributes` | `register_block_type` (`attributes` key) | [Blocks](modules/blocks/) | Register block attributes with typed defaults and optional `source` definitions. |
| `Lipe\Lib\Blocks\Register_Block` | `register_block_type` | [Blocks](modules/blocks/) | Register a block type, including supports, attributes, variations, render callback, and asset handles. |
| `Lipe\Lib\Blocks\Register_Block_Style` | `register_block_style` | [Blocks](modules/blocks/) | Register a named style variation for a block. |
| `Lipe\Lib\Comment\Get_Comments` | `get_comments` | [Comment](modules/comment/) | Build the args for a comment query, including author, status, type, parent, and meta filters. |
| `Lipe\Lib\Comment\Update_Comment` | `wp_insert_comment`, `wp_update_comment` | [Comment](modules/comment/) | Insert or update a comment with typed args for author, content, status, parent, and meta. |
| `Lipe\Lib\Menu\Wp_Nav_Menu` | `wp_nav_menu` | [Menu](modules/menu/) | Build args for rendering a registered nav menu, including walker, container, and depth. |
| `Lipe\Lib\Meta\Register_Meta` | `register_meta`, `register_post_meta`, `register_term_meta`, `register_user_meta`, `register_comment_meta` | [Meta](modules/meta/) | Register typed meta with default, sanitize, auth, REST schema, and revisions support. |
| `Lipe\Lib\Post_Type\Register_Post_Status` | `register_post_status` | [Post Type](modules/post-type/) | Register a custom post status with labels and visibility flags. |
| `Lipe\Lib\Post_Type\Register_Post_Type` | `register_post_type` | [Post Type](modules/post-type/) | Register a custom post type with labels, capabilities, supports, REST, and admin column args. |
| `Lipe\Lib\Post_Type\Wp_Insert_Post` | `wp_insert_post`, `wp_update_post` | [Post Type](modules/post-type/) | Insert or update a post with typed args for content, status, author, taxonomies, and meta. |
| `Lipe\Lib\Query\Get_Posts` | `get_posts` | [Query](modules/query/) | Build args for `get_posts` with typed setters for post type, status, ordering, and pagination. |
| `Lipe\Lib\Query\Query_Args` | `WP_Query` | [Query](modules/query/) | Build a full `WP_Query` arg set, including date, meta, and taxonomy clause sub-builders. |
| `Lipe\Lib\Rest_Api\Arguments_Schema` | `register_rest_route` (`args` key) | [REST API](modules/rest-api/) | Build the per-argument schema for a REST route. |
| `Lipe\Lib\Rest_Api\Register_Rest_Route` | `register_rest_route` | [REST API](modules/rest-api/) | Register a REST route with namespace, methods, permission callback, args, and schema. |
| `Lipe\Lib\Rest_Api\Resource_Schema` | `register_rest_route` (`schema` key) | [REST API](modules/rest-api/) | Build the REST resource schema returned for a route. |
| `Lipe\Lib\Rest_Api\Wp_Register_Ability` | `wp_register_ability` | [REST API](modules/rest-api/) | Register an Abilities API ability with input/output schema and callback. |
| `Lipe\Lib\Rest_Api\Wp_Register_Ability_Category` | `wp_register_ability_category` | [REST API](modules/rest-api/) | Register an Abilities API category with label and description. |
| `Lipe\Lib\Settings\Register_Setting` | `register_setting` | [Settings](modules/settings/) | Register a setting with type, default, sanitize callback, and REST schema. |
| `Lipe\Lib\Settings\Settings_Page\FieldArgs` | `add_settings_field` (extra args) | [Settings](modules/settings/) | Provide the additional args array supported by `add_settings_field`. |
| `Lipe\Lib\Settings\Settings_Page\SectionArgs` | `add_settings_section` (extra args) | [Settings](modules/settings/) | Provide the additional args array supported by `add_settings_section`. |
| `Lipe\Lib\Taxonomy\Get_Terms` | `get_terms` | [Taxonomy](modules/taxonomy/) | Build args for a term query, including taxonomy, ordering, hide-empty, and meta filters. |
| `Lipe\Lib\Taxonomy\Taxonomy\Register_Taxonomy` | `register_taxonomy` | [Taxonomy](modules/taxonomy/) | Register a custom taxonomy with labels, capabilities, REST, and admin column args. |
| `Lipe\Lib\Taxonomy\Wp_Dropdown_Categories` | `wp_dropdown_categories` | [Taxonomy](modules/taxonomy/) | Build args for the categories `<select>` dropdown helper. |
| `Lipe\Lib\Taxonomy\Wp_List_Categories` | `wp_list_categories` | [Taxonomy](modules/taxonomy/) | Build args for the categories list output helper. |
| `Lipe\Lib\Taxonomy\Wp_Terms_Checklist` | `wp_terms_checklist` | [Taxonomy](modules/taxonomy/) | Build args for the term checklist UI helper. |
| `Lipe\Lib\Theme\Register_Sidebar` | `register_sidebar` | [Theme](modules/theme/) | Register a dynamic sidebar with name, description, and wrapper markup. |
| `Lipe\Lib\Theme\Wp_Enqueue_Script` | `wp_enqueue_script` | [Theme](modules/theme/) | Provide the `$args` value (`in_footer`, `strategy`, `fetchpriority`) for an enqueued script. |
| `Lipe\Lib\Theme\Wp_Enqueue_Script_Module` | `wp_enqueue_script_module` | [Theme](modules/theme/) | Provide the `$args` value (`in_footer`, `fetchpriority`) for an enqueued script module. |
| `Lipe\Lib\User\Get_Users` | `get_users` | [User](modules/user/) | Build args for a user query, including role, capability, search, ordering, and meta filters. |
| `Lipe\Lib\User\Update_User` | `wp_insert_user`, `wp_update_user` | [User](modules/user/) | Insert or update a user with typed args for login, email, role, meta, and notification. |
| `Lipe\Lib\User\Wp_Login_Form` | `wp_login_form` | [User](modules/user/) | Build args for rendering the front-end login form. |

## Usage pattern

```php
use Lipe\Lib\Query\Get_Posts;

$args = new Get_Posts( [] );
$args->post_type      = 'book';
$args->posts_per_page = 10;
$args->orderby        = 'date';
$args->order          = 'DESC';

$posts = get_posts( $args->get_args() );
```

Most wrappers expose chainable sub-builders for nested arguments (for
example date, meta, and taxonomy clauses on `Query_Args`). See each
module's documentation for the full surface area.
