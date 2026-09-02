---
title: REST API
parent: Modules
nav_order: 15
---

# REST API

## Overview

The REST API module provides fluent builders for route registration, request argument schemas, resource schemas, initial-data serialization, and registering WordPress Abilities API abilities and categories. It is aimed at WordPress REST and Abilities API integrations that want typed, composable configuration objects.

## Types in this module

- `Lipe\Lib\Rest_Api\Arguments_Schema`
- `Lipe\Lib\Rest_Api\Initial_Data`
- `Lipe\Lib\Rest_Api\Register_Rest_Route`
- `Lipe\Lib\Rest_Api\Register_Rest_Route\Method`
- `Lipe\Lib\Rest_Api\Resource_Schema`
- `Lipe\Lib\Rest_Api\Wp_Register_Ability`
- `Lipe\Lib\Rest_Api\Wp_Register_Ability_Category`
- `Lipe\Lib\Rest_Api\Schema\Argument_Prop`
- `Lipe\Lib\Rest_Api\Schema\ArrayType`
- `Lipe\Lib\Rest_Api\Schema\BooleanType`
- `Lipe\Lib\Rest_Api\Schema\IntegerType`
- `Lipe\Lib\Rest_Api\Schema\NullType`
- `Lipe\Lib\Rest_Api\Schema\NumberType`
- `Lipe\Lib\Rest_Api\Schema\ObjectType`
- `Lipe\Lib\Rest_Api\Schema\Prop` (trait)
- `Lipe\Lib\Rest_Api\Schema\PropRules` (interface)
- `Lipe\Lib\Rest_Api\Schema\Resource_Prop`
- `Lipe\Lib\Rest_Api\Schema\StringType`
- `Lipe\Lib\Rest_Api\Schema\Type`
- `Lipe\Lib\Rest_Api\Schema\TypeRules` (interface)

## `Register_Rest_Route`

Fluent wrapper around `register_rest_route()` that composes one or more HTTP method definitions and an optional schema.

### Key public methods

- `public function __construct(array $do_not_use)`
- `public function method(string $methods): Method`
- `public function schema(Resource_Schema $schema): static`
- `public function get_args(): array`

### Example

```php
<?php
use Lipe\Lib\Rest_Api\Register_Rest_Route;
use WP_REST_Request;
use WP_REST_Server;

$route = new Register_Rest_Route([]);
$route->method(WP_REST_Server::READABLE)
    ->callback(function(WP_REST_Request $request): array {
        return ['ok' => true];
    })
    ->permission_callback(fn () => current_user_can('read'));

register_rest_route('acme/v1', '/books', $route->get_args());
```

## `Method`

Represents one method entry inside a REST route.

### Key public methods

- `public function args(Arguments_Schema $args): static`
- `public function callback(\Closure $callback): static`
- `public function permission_callback(\Closure $callback): static`
- `public function methods(string $methods): static`

## `Arguments_Schema`

Builds a REST endpoint `args` array.

### Key public methods

- `public function prop(string $key): Argument_Prop`
- `public function get_args(): array`

## `Resource_Schema`

Builds a public resource schema.

### Key public methods

- `public function title(string $title): static`
- `public function type(): Type`
- `public function get_args(): array`

## `Wp_Register_Ability`

Fluent wrapper around `wp_register_ability()` from the WordPress Abilities API.

### Key public methods

- `public function __construct(array $existing)`
- `public function input_schema(): Resource_Schema`
- `public function output_schema(): Resource_Schema`
- `public function get_args(): array`

### Example

```php
<?php
use Lipe\Lib\Rest_Api\Wp_Register_Ability;
use Lipe\Lib\Rest_Api\Wp_Register_Ability_Category;

$category = new Wp_Register_Ability_Category([]);
$category->label = 'Books';
$category->description = 'Abilities for working with books.';
wp_register_ability_category('acme/books', $category->get_args());

$ability = new Wp_Register_Ability([]);
$ability->label = 'List Books';
$ability->description = 'Returns a list of published books.';
$ability->category = 'acme/books';
$ability->permission_callback = fn() => current_user_can('read');
$ability->execute_callback = fn() => get_posts(['post_type' => 'book']);

wp_register_ability('acme/list-books', $ability->get_args());
```

## `Wp_Register_Ability_Category`

Fluent wrapper around `wp_register_ability_category()` from the WordPress Abilities API.

### Key public methods

- `public function __construct(array $existing)`
- `public function get_args(): array`

## `Type`

Proxy that maps a schema field to its concrete type class.

### Key public methods

- `public function string(): StringType`
- `public function array(): ArrayType`
- `public function object(): ObjectType`
- `public function number(): NumberType`
- `public function integer(): IntegerType`
- `public function boolean(): BooleanType`
- `public function null(): NullType`
- `public function one_of(array $types): static`
- `public function any_of(array $types): static`
- `public function get_args(): array`

## `Prop` (trait)

Shared properties for a schema property, used by `Argument_Prop` and `Resource_Prop`.

### Key public methods

- `public function title(string $title): static`
- `public function description(string $description): static`
- `public function required(bool $is_required): static`
- `public function type(): Type`
- `public function get_args(): array`

## `PropRules` (interface)

Common contract for schema property classes.

### Methods

- `public function get_args(): array`

## `TypeRules` (interface)

Common contract for schema type classes.

### Methods

- `public function get_args(): array`

## `Argument_Prop`

A property shape for a `register_rest_route()` argument schema. Uses the `Prop` trait for shared `title()`, `description()`, `required()`, `type()`, and `get_args()` methods.

### Key public methods

- `public function default(mixed $default_value): static`
- `public function validate_callback(callable $callback): static`
- `public function sanitize_callback(callable $callback): static`

## `Resource_Prop`

A property shape for a resource schema. Uses the `Prop` trait for shared `title()`, `description()`, `required()`, `type()`, and `get_args()` methods.

### Key public methods

- `public function context(array $context): static`
- `public function readonly(bool $is_readonly): static`

## `StringType`

### Key public methods

- `public function enum(array $values): static`
- `public function format(string $format): static`
- `public function max_length(int $maxLength): static`
- `public function min_length(int $minLength): static`
- `public function pattern(string $pattern): static`
- `public function get_args(): array`

## `ArrayType`

### Key public methods

- `public function items(): Type`
- `public function min_items(int $min): static`
- `public function max_items(int $max): static`
- `public function unique_items(bool $is_unique = true): static`
- `public function get_args(): array`

## `ObjectType`

### Key public methods

- `public function prop(string $key): Resource_Prop`
- `public function additional_properties(?bool $enabled = null, ?int $max = null, ?int $min = null): ?Resource_Prop`
- `public function pattern_properties(string $regex_key): Resource_Prop`
- `public function get_args(): array`

## `NumberType`

### Key public methods

- `public function exclusive_maximum(bool $is_exclusive): static`
- `public function exclusive_minimum(bool $is_exclusive): static`
- `public function multiple_of(int $multiple_of): static`
- `public function minimum(float|int $minimum): static`
- `public function maximum(float|int $maximum): static`
- `public function get_args(): array`

## `IntegerType`

### Key public methods

- `public function exclusive_maximum(bool $is_exclusive): static`
- `public function exclusive_minimum(bool $is_exclusive): static`
- `public function multiple_of(int $multiple_of): static`
- `public function minimum(int $minimum): static`
- `public function maximum(int $maximum): static`
- `public function get_args(): array`

## `BooleanType`

### Key public methods

- `public function get_args(): array`

## `NullType`

### Key public methods

- `public function get_args(): array`

## `Initial_Data`

Serializes posts, terms, users, comments, and attachments using the shapes provided by the WordPress REST server.

### Key public methods

- `public function is_retrieving(): bool`
- `public function get_comments_data(array $comments, bool $with_links = false, array|bool $embed = false): array`
- `public function get_post_data(?array $posts = null, bool $with_links = false, array|bool $embed = false): array`
- `public function get_user_data(array $users, bool $with_links = false, array|bool $embed = false): array`
- `public function get_term_data(array $terms, bool $with_links = false, array|bool $embed = false): array`
- `public function get_attachments_data(array $attachments, bool $with_links = false, array|bool $embed = false): array`
