# WordPress Libs — Copilot Instructions

## Commands

**PHP**

Use global executables to run the following commands from the root of the plugin:

```bash
phpcs                          # lint src/
phpstan analyse                # static analysis (level 8)
phpunit -c dev/wp-unit/phpunit.xml.dist                   # full test suite
phpunit -c dev/wp-unit/phpunit.xml.dist <path/to/Test.php> # single test file
```

Tests require the WP unit-test framework. Set `WP_UNIT_DIR` to the path of the framework or create `dev/wp-unit/local-config.php` (see `dev/wp-unit/default-local-config.php` for the template). DB credentials are read from environment variables `DB_NAME`, `DB_USER`, `DB_PASSWORD`, and `WP_LIBS_DB_PASS`.

**JS/TS/CSS**
```bash
yarn lint    # ESLint + Stylelint
yarn test    # Jest
yarn dist    # production build
```

Uses Yarn 4 (Berry). Run all JS commands with `yarn`, not `npm`.

---

## Architecture

**Namespace root:** `Lipe\Lib\` → `src/` (PSR-4)

Each top-level directory under `src/` is one module (e.g. `Api`, `Post_Type`, `Rest_Api`). Module names map to `docs/modules/<slug>.md` (Pascal_Snake_Case → kebab-case slug).

**Key layers:**

- **Fluent args wrappers** (`src/Args/`) — typed wrappers around WordPress functions. All implement `ArgsRules` and use the `Args` trait. Construct with an optional existing array, set public properties, call `->get_args()` to emit the array.
- **Singleton services** (`Traits\Singleton`) — `ClassName::in()` gets the instance; `ClassName::init()` gets the instance and calls `hook()`; `ClassName::init_once()` calls `init()` exactly once.
- **Container services** (`Container\Instance` + `Container\Hooks`) — newer classes use the DI container instead of static `$instance`. Same `::in()` / `::init()` / `::init_once()` surface, but instances are stored in `Container`.
- **Docs** (`docs/`) — Jekyll / Just the Docs site published to GitHub Pages. The `update-docs` skill (`.github/skills/update-docs/`) keeps `docs/modules/` in sync with `src/`.

---

## Key Conventions

### PHP

- Every file must begin with `declare(strict_types=1);` (enforced by PHPStan).
- Fully qualify native PHP functions with `\` (e.g. `\array_map`, `\is_string`); user-defined and WordPress functions are **not** prefixed.
- Prefer `use` imports over fully-qualified class names; do not `use`-import global functions or classes.
- PHPStan level 8 with `noExtends: true`. Only the classes listed in `phpstan.neon.dist` under `allowedToBeExtended` may be subclassed.
- All globals (hooks, functions, namespaces) must use the `lipe/lib` or `Lipe\Lib` prefix (enforced by PHPCS). Text domain is `lipe`.
- Use `isset` and `[] ===` instead of `empty`.
- Arrow functions for filter callbacks in service providers; anonymous functions (not arrow functions) for `array_map` / `array_filter`.
- Use first-class callable syntax for method callbacks (`$this->method(...)` not `[$this, 'method']`).
- `@phpstan-type` names are CONSTANT_CASE; array shapes are formatted with one key per line.

### Fluent Args

All args classes live under `src/<Module>/` and look like:

```php
$args = new Lipe\Lib\Query\Query_Args( [] );
$args->post_type      = 'book';
$args->posts_per_page = 10;
$posts = new WP_Query( $args->get_args() );
```

Sub-builders for nested clauses (date, meta, tax) are attached to the parent via `$this->clauses` and flattened on `get_args()`.

### Testing

- Test classes extend `\WP_UnitTestCase` (not `PHPUnit\Framework\TestCase`).
- The environment is multisite with two blogs pre-created.
- Use `\Lipe\WP_Unit\Utils\PrivateAccess::in()->call_private_method()` and `->get_private_property()` to access private/protected members.
- Use `tests_reset_container()` in `tearDown` when classes that use the container are modified.
- WordPress filters/actions reset automatically between tests.
- Classes that use the container are automatically reset between tests.
- Use `#[DataProvider('methodName')]` (PHP 8 attribute); provider methods are `public static` with kebab-case keyed arrays.
- Use `assertSame` over `assertEquals`.

### Documentation

When adding or modifying a class in `src/`, update the corresponding `docs/modules/<slug>.md`. The `update-docs` Copilot skill automates this. Only public methods are documented; sub-directory classes roll up into the parent module doc.

### Yarn Production Build

The `dist/` build is commited to Git so it may be consumed directly from composer.
- If any file in `src/` is modified, run `yarn dist` and commit the changed files in `dist/`.
