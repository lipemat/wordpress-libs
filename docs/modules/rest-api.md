---
title: REST API
parent: Modules
nav_order: 15
---

# REST API

## Overview

The REST API module provides fluent builders for route registration, request argument schemas, resource schemas, and initial-data serialization. It is aimed at WordPress REST integrations that want typed, composable configuration objects.

## Types in this module

- `Lipe\Lib\Rest_Api\Arguments_Schema`
- `Lipe\Lib\Rest_Api\Initial_Data`
- `Lipe\Lib\Rest_Api\Register_Rest_Route`
- `Lipe\Lib\Rest_Api\Resource_Schema`
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
- `Lipe\Lib\Rest_Api\Register_Rest_Route\Method`

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

## Schema property and type builders

- `Argument_Prop` adds `public function default(mixed $default_value): Argument_Prop`, `public function validate_callback(callable $callback): Argument_Prop`, and `public function sanitize_callback(callable $callback): Argument_Prop`.
- `Resource_Prop` adds `public function context(array $context): static` and `public function readonly(bool $is_readonly): static`.
- `Prop` provides shared `title()`, `description()`, `required()`, `type()`, and `get_args()` helpers.
- `Type` maps to concrete schema types through `string()`, `array()`, `object()`, `number()`, `integer()`, `boolean()`, `null()`, `one_of()`, `any_of()`, and `get_args()`.
- `StringType`, `ArrayType`, `ObjectType`, `NumberType`, and `IntegerType` expose the specialized validation methods shown in source, such as `enum()`, `pattern()`, `items()`, `prop()`, `minimum()`, and `maximum()`.
- `BooleanType` and `NullType` represent leaf schema types.
- `PropRules` and `TypeRules` define the common contracts.

## `Initial_Data`

Serializes posts, terms, users, comments, and attachments using the shapes provided by the WordPress REST server.

### Key public methods

- `public function is_retrieving(): bool`
- `public function get_comments_data(array $comments, bool $with_links = false, array|bool $embed = false): array`
- `public function get_post_data(?array $posts = null, bool $with_links = false, array|bool $embed = false): array`
- `public function get_user_data(array $users, bool $with_links = false, array|bool $embed = false): array`
- `public function get_term_data(array $terms, bool $with_links = false, array|bool $embed = false): array`
- `public function get_attachments_data(array $attachments, bool $with_links = false, array|bool $embed = false): array`
