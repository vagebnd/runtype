# Changelog

All notable changes to `runtype` will be documented in this file.

## Title: v1.0.0 — Namespace Grouping, Consistent Formatting & Laravel 13 Support - 2026-04-03

### What's New

#### Namespace Grouping

Generated TypeScript types are now wrapped in `declare namespace` blocks based on their PHP namespace, preventing naming collisions and improving organization.

```typescript
declare namespace App.Http.Resources {
    // App\Http\Resources\UserResource
    export type UserResourceType = {
        id: number;
        name: string;
        created_at: string;
    }
}

```
#### Consistent Formatting

- Properties now use `name: type;` format with proper indentation
- Inline object types use `{ key: type }` with spaces
- Resource type references are fully namespace-qualified

#### Resource Collection Array Types

Collections returning sequential arrays (e.g., `$this->collection->map(...)`) now correctly output array types like `{ id: number }[]` instead of broken numeric property keys.

#### Laravel 13 & PHP 8.5 Support

- Added support for Laravel 11, 12, and 13
- Added support for PHP 8.3, 8.4, and 8.5
- Upgraded to Pest 4 / PHPUnit 12 compatibility

#### Bug Fixes

- Fixed `instanceof` error when type replacement keys are non-string
- Fixed incorrect `Collection` type hint casing in `PersistTypescriptTypes`
- Synced `TypescriptProperty::determineType()` with `Types::determineType()` — was missing `BackedEnum` support

### Breaking Changes

The output format has changed significantly. If you reference generated types in your TypeScript code, you'll need to update your imports to use the namespaced format (e.g., `App.Http.Resources.UserResourceType`).

### Credits

Namespace concept by @rick-bongers (#14).

## Added Enum support - 2026-01-16

Added enum support by @rick-bongers.

## Ensure optional types are processed correctly - 2025-05-27

This update ensures that optional types are correctly added to the export i.e. `name?: boolean`.

## Added support for request user resolving in resources - 2025-04-01

This updated binds the user to the request when present, allowing us to do checks based on the user in resources.

## Updated PHP-parser to latest version - 2024-04-02

### What's Changed

* Update nikic/php-parser requirement from ^4.15 to ^5.0 by @dependabot in https://github.com/vagebnd/runtype/pull/9

**Full Changelog**: https://github.com/vagebnd/runtype/compare/0.2.0...0.2.1

## Added support for L10 - 2024-04-02

**Full Changelog**: https://github.com/vagebnd/runtype/compare/0.1.0...0.2.0
