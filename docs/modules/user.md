---
title: User
parent: Modules
nav_order: 21
---

# User

## Overview

The User module wraps user objects plus common user-related APIs such as `get_users()`, `wp_insert_user()`, `wp_update_user()`, and `wp_login_form()`.

## Types in this module

- `Lipe\Lib\User\Get_Users`
- `Lipe\Lib\User\Update_User`
- `Lipe\Lib\User\User_Trait`
- `Lipe\Lib\User\Wp_Login_Form`

## `User_Trait`

Shared behavior for classes backed by a `WP_User` instance.

### Key public methods

- `public function __construct(null|\WP_User|int $user = null)`
- `public function get_id(): int`
- `public function get_meta_type(): MetaType`
- `public function get_object(): ?\WP_User`
- `public function exists(): bool`
- `public static function factory(null|\WP_User|int $user = null): static`

## `Get_Users`

Fluent builder for `get_users()` and `WP_User_Query` integration.

### Key public methods

- `public function orderby(string $orderby): void`
- `public function merge_query(\WP_User_Query $query): void`
- `public function __construct(array $existing)`
- `public function merge(ArgsRules $overrides): void`
- `public function get_args(): array`

### Example

```php
<?php
use Lipe\Lib\User\Get_Users;

$query = new Get_Users([]);
$query->role = 'editor';
$query->number = 20;

$users = get_users($query->get_args());
```

## `Update_User`

Fluent arg object for `wp_insert_user()` and `wp_update_user()`.

Populate the supported public properties, then pass `get_args()` to the relevant WordPress function.

## `Wp_Login_Form`

Fluent arg object for `wp_login_form()`.

Like other args builders, it relies on the shared `Args` trait for construction, merging, and conversion to a WordPress-ready argument array.
