# AGENTS.md - Development Guidelines for laravel-tmdb

## Project Overview

This is a Laravel package for interacting with TMDB (The Movie Database) API. It provides Eloquent models, API clients, and facades for fetching and storing movie data.

## Build / Lint / Test Commands

### Running Tests

```bash
# Run all tests
composer test

# Run a specific test file
vendor/bin/pest tests/Unit/TmdbTest.php

# Run a specific test by name
vendor/bin/pest --filter="can use a given language"

# Run tests with coverage
composer test-coverage

# Run mutation testing (Infection)
vendor/bin/infection -j2
```

### Code Formatting & Linting

```bash
# Fix code style (Pint - primary formatter)
composer fix
vendor/bin/pint

# Check code style (dry-run)
vendor/bin/php-cs-fixer fix --using-cache=no --dry-run

# Fix code style (PHP-CS-Fixer)
vendor/bin/php-cs-fixer fix --using-cache=no
```

### Composer Scripts

```bash
# Validate and normalize composer.json
composer normalize --ansi --no-interaction

# Validate package
composer validate --strict --ansi --no-interaction
```

## Code Style Guidelines

### General Conventions

- **PHP Version**: 8.2+
- **Indentation**: 4 spaces (no tabs)
- **Line endings**: Unix (`\n`)
- **Maximum line length**: No strict limit, but prefer readable lines
- **PSR Compliance**: PSR-2 and PSR-12

### Formatting Tools

- **Primary**: Laravel Pint (`vendor/bin/pint`)
- **Secondary**: PHP-CS-Fixer with Laravel rules (`.php-cs-fixer.dist.php`)

Run `composer fix` before committing to ensure consistent formatting.

### Naming Conventions

- **Classes**: `PascalCase` (e.g., `Movie`, `TmdbServiceProvider`)
- **Methods**: `camelCase` (e.g., `getConnectionName()`, `useRegion()`)
- **Properties**: `camelCase` (e.g., `$region`, `$language`)
- **Constants**: `UPPER_CASE` (e.g., `APPEND_CREDITS`)
- **Enums**: Use Spatie Enum with `UPPER_CASE` values (see `src/Enums/MovieStatus.php`)
- **Files**: Match class name (e.g., `Movie.php` → `class Movie`)

### Type Declarations

- Use **strict type declarations** (`declare(strict_types=1);`)
- Use **return types** on all methods
- Use **property types** where applicable
- Use **nullable types** with `?` prefix (e.g., `?string`, `?int`)

```php
public function useRegion(string $region): static
public function language(): string
public function region(): ?string
```

### Imports

- Use fully qualified class names or explicit imports
- Group imports: built-in → external → local packages → project classes
- Remove unused imports (enforced by `no_unused_imports` rule)

```php
use Astrotomic\Tmdb\Models\Movie;
use Astrotomic\Tmdb\Requests\Movie\Popular;
use Illuminate\Database\Eloquent\Collection;
use Carbon\CarbonInterval;
```

### PHPDoc / DocBlocks

- Use PHPDoc for complex type hints and property definitions
- Include `@property`, `@method`, `@mixin` annotations on models
- Use `phpdoc_separation` and `phpdoc_order` rules
- Don't use docblocks for simple getters/setters (use return types instead)

### Error Handling

- Use Laravel's `rescue()` helper for graceful error handling
- Return `null` or `false` on failure rather than throwing exceptions in non-critical paths
- Use type hints to make nullability explicit

```php
$data = rescue(
    fn () => Details::request($this->id)
        ->language($locale)
        ->send()
        ->json()
);

if ($data === null) {
    return false;
}
```

### Model Conventions

- Extend `Astrotomic\Tmdb\Models\Model` (extends `Illuminate\Database\Eloquent\Model`)
- Set `$incrementing = false` for non-integer primary keys
- Define `$fillable`, `$casts`, and `$translatable` arrays
- Use enum classes for status fields (cast with `:nullable` suffix)
- Implement `updateFromTmdb()` and `fillFromTmdb()` abstract methods

```php
protected $casts = [
    'id' => 'int',
    'adult' => 'bool',
    'status' => MovieStatus::class.':nullable',
];

public array $translatable = [
    'title',
    'tagline',
    'overview',
];
```

### Testing Conventions

- Use **Pest** PHP testing framework
- Place tests in `tests/` directory: `Unit/`, `Feature/`, `Live/`
- Test files suffixed with `Test.php`
- Use `it()` function for test cases with closures
- Use `expect()` for assertions with custom matchers

```php
it('can use a given language', function (): void {
    $tmdb = new Tmdb();
    $tmdb->useLanguage('de');
    expect($tmdb->language())->toBe('de');
});
```

### Directory Structure

```
src/
├── Client/          # API connectors (Saloon)
├── Eloquent/        # Eloquent builders, relations
├── Enums/           # Spatie Enum classes
├── Facades/         # Laravel facades
├── Images/          # Image wrapper classes
├── Models/          # Eloquent models
│   └── Concerns/    # Model traits
├── Requests/        # API request classes
├── Tmdb.php         # Main class
└── TmdbServiceProvider.php
```

### Service Provider

- Register singletons in `register()` method
- Register migrations, configs, and public assets in `boot()` method
- Use `morphMap()` for polymorphic relationships

```php
public function register(): void
{
    $this->app->singleton(Tmdb::class);
}

public function boot(): void
{
    Relation::morphMap([...]);
}
```

## Additional Resources

- GitHub: https://github.com/Astrotomic/laravel-tmdb
- Issues: https://github.com/Astrotomic/laravel-tmdb/issues
