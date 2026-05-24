---
title: Cron
parent: Modules
nav_order: 7
---

# Cron

## Overview

The Cron module defines contracts for recurring and one-off jobs, plus runner classes that schedule and execute them while tracking next and last run times.

## Types in this module

- `Lipe\Lib\Cron\Cron` (interface)
- `Lipe\Lib\Cron\One_Time`
- `Lipe\Lib\Cron\Runner`
- `Lipe\Lib\Cron\SingleCron` (interface)

## `Cron`

Interface for recurring cron tasks.

### Methods

- `public function get_name(): string`
- `public function run(): void`
- `public function get_recurrence()`

## `SingleCron`

Interface for one-time cron tasks.

### Methods

- `public function get_name(): string`
- `public function run(mixed $data): void`

## `Runner`

Schedules and runs recurring cron implementations.

### Key public methods

- `public function init(): void`
- `public function get_next_run(): int|false`
- `public function get_last_run(): int|false`
- `public static function factory(Cron $event): static`

## `One_Time`

Schedules and runs one-time cron implementations with arbitrary payload data.

### Key public methods

- `public function init(): void`
- `public function schedule(mixed $data, ?int $timestamp = null): bool|\WP_Error`
- `public function get_next_run(mixed $data): int|false`
- `public function get_last_run(): int|false`
- `public static function factory(SingleCron $cron): static`

### Example

```php
<?php
use Lipe\Lib\Cron\One_Time;
use Lipe\Lib\Cron\SingleCron;

final class Send_Report implements SingleCron {
    public function get_name(): string { return 'acme/send-report'; }
    public function run(mixed $data): void {}
}

One_Time::factory(new Send_Report())->schedule(['report' => 15]);
```
