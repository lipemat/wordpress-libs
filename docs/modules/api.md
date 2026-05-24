---
title: API
parent: Modules
nav_order: 1
---

# API

## Overview

The API module provides lightweight front-end endpoints, route matching helpers, a fluent wrapper around `wp_remote_*`, and ZIP download delivery. It is useful when you want simple public endpoints without building a full REST controller.

## Types in this module

- `Lipe\Lib\Api\Api`
- `Lipe\Lib\Api\Route`
- `Lipe\Lib\Api\Wp_Remote`
- `Lipe\Lib\Api\Zip`

## `Api`

Registers a root `/api/` rewrite endpoint and dispatches route-specific WordPress actions.

### Key public methods

- `public function hook(): void`
- `public function is_doing_api(): bool`
- `public function get_action(string $endpoint): string`
- `public function get_url(?string $endpoint = null, array $data = []): string`
- `public function get_root_url(): string`

### Example

```php
<?php
use Lipe\Lib\Api\Api;

Api::init_once();

add_action(Api::in()->get_action('export'), function(array $args): void {
    wp_send_json_success($args);
});

$url = Api::in()->get_url('export', ['post_type' => 'book']);
```

## `Route`

Maps friendly URLs to a placeholder page and exposes helpers for checking and reading the current route.

### Key public methods

- `public function add(string $url, array $args): void`
- `public function get_current_route(): ?array`
- `public function is_current_route(string $route): bool`
- `public function get_url_parameter(): string`
- `public function get_title(string $title, int|\WP_Post $post): string`

### Example

```php
<?php
use Lipe\Lib\Api\Route;

Route::in()->add('account/orders', [
    'title' => 'Orders',
    'post_type' => 'page',
]);

if (Route::in()->is_current_route('account/orders')) {
    $order = Route::in()->get_url_parameter();
}
```

## `Wp_Remote`

A fluent interface for building request arguments before calling WordPress HTTP functions.

### Key public methods

- `public function header(string $key, string $value): static`
- `public function get_args(): array`

### Example

```php
<?php
use Lipe\Lib\Api\Wp_Remote;

$args = (new Wp_Remote([]))
    ->header('Accept', 'application/json')
    ->get_args();

$response = wp_remote_get('https://example.com/api/books', $args);
```

## `Zip`

Handles creation and delivery of ZIP archives from a simple POST-driven endpoint.

### Key public methods

- `public function handle_request(): void`
- `public function build_zip(array $files, ?string $zip_name = null): void`
- `public function get_post_data_to_send(array $urls, ?string $name = null): array`
- `public function get_url_for_endpoint(): string`
- `public static function init(): void`

### Example

```php
<?php
use Lipe\Lib\Api\Zip;

Zip::init();

$form = Zip::in()->get_post_data_to_send([
    content_url('uploads/report.pdf'),
    content_url('uploads/data.csv'),
], 'reports');
```
