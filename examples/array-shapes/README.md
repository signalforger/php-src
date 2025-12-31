# Array Shape Examples

This directory contains comprehensive examples demonstrating all features of PHP's array shape type syntax.

## What Are Array Shapes?

Array shapes allow you to define the structure of associative arrays with typed keys:

```php
declare(strict_arrays=1);

function getUser(): array{id: int, name: string, email?: string} {
    return ['id' => 1, 'name' => 'Alice'];
}
```

## Shape Type Aliases

The `shape` keyword lets you define reusable type aliases for array structures:

```php
declare(strict_arrays=1);

// Define a shape type alias
shape User = array{id: int, name: string, email: string};

// Use it like a type
function getUser(int $id): User {
    return ['id' => $id, 'name' => 'Alice', 'email' => 'alice@example.com'];
}

function processUser(User $user): void {
    echo "Hello, {$user['name']}!";
}

// Check if a shape exists
if (shape_exists('User')) {
    echo "User shape is defined";
}
```

Shapes can be autoloaded just like classes:

```php
spl_autoload_register(function($name) {
    $file = __DIR__ . "/shapes/$name.php";
    if (file_exists($file)) {
        require_once $file;
    }
});

// UserShape will be autoloaded from shapes/UserShape.php
function getUser(): UserShape { ... }
```

## Quick Reference

### Basic Syntax

```php
// Required keys
array{key: type}

// Optional keys (may be absent)
array{key?: type}

// Nullable values (key present, value can be null)
array{key: ?type}

// Multiple keys
array{key1: type1, key2: type2, key3?: type3}
```

### Type Options

```php
// Scalar types
array{id: int, name: string, price: float, active: bool}

// Nullable types
array{value: ?string}

// Union types
array{id: int|string, value: float|null}

// Mixed type
array{data: mixed}

// Array types
array{items: array}
array{numbers: array<int>}
array{users: array<array{id: int, name: string}>}

// Object types
array{user: User, admin: ?Admin}
```

### Where You Can Use Array Shapes

```php
// Return types
function getUser(): array{id: int, name: string} { ... }

// Parameter types
function process(array{x: int, y: int} $point): void { ... }

// Closures and arrow functions
$fn = fn(): array{value: int} => ['value' => 42];

// Class methods
class UserService {
    public function find(int $id): array{id: int, name: string} { ... }
}

// Interface methods
interface ConfigProvider {
    public function getConfig(): array{debug: bool, env: string};
}
```

## Examples Index

| File | Description |
|------|-------------|
| `01-basic-shapes.php` | Basic array shape syntax with required keys |
| `02-optional-keys.php` | Optional keys with `key?: type` syntax |
| `03-nested-shapes.php` | Nested array shapes for complex structures |
| `04-union-and-nullable-types.php` | Union types and nullable values in shapes |
| `05-shapes-with-typed-arrays.php` | Combining shapes with `array<T>` syntax |
| `06-classes-and-interfaces.php` | Using shapes in classes, interfaces, traits |
| `07-closures-and-callables.php` | Shapes with closures and arrow functions |
| `08-reflection-api.php` | Runtime inspection with Reflection API |
| `09-validation-and-errors.php` | Error handling and validation patterns |
| `10-real-world-patterns.php` | Production-ready patterns and use cases |
| `11-shape-type-aliases.php` | Defining reusable shapes with the `shape` keyword |
| `12-shape-autoloading.php` | Autoloading shapes like classes |

## Running Examples

```bash
# Run any example
./sapi/cli/php examples/array-shapes/01-basic-shapes.php

# Run all examples
for f in examples/array-shapes/*.php; do echo "=== $f ==="; ./sapi/cli/php "$f"; done
```

## Key Concepts

### Optional vs Nullable

```php
// Optional: key may not exist in array
array{name: string, email?: string}
// Valid: ['name' => 'Alice']
// Valid: ['name' => 'Alice', 'email' => 'alice@example.com']

// Nullable: key must exist but value can be null
array{name: string, email: ?string}
// Valid: ['name' => 'Alice', 'email' => null]
// Valid: ['name' => 'Alice', 'email' => 'alice@example.com']
// Invalid: ['name' => 'Alice'] - missing 'email' key

// Both: key is optional, and if present can be null
array{name: string, email?: ?string}
```

### Nested Shapes

```php
array{
    user: array{
        id: int,
        profile: array{
            name: string,
            avatar?: string
        }
    },
    settings: array{
        theme: string,
        notifications: bool
    }
}
```

### Shapes with Typed Arrays

```php
// Shape containing typed array
array{
    name: string,
    tags: array<string>,
    scores: array<int>
}

// Typed array of shapes (list of records)
array<array{id: int, name: string}>

// Keyed array of shapes (dictionary)
array<string, array{value: mixed, type: string}>
```

## Reflection API

```php
$reflection = new ReflectionFunction('getUser');
$returnType = $reflection->getReturnType();

if ($returnType instanceof ReflectionArrayShapeType) {
    echo "Element count: " . $returnType->getElementCount() . "\n";
    echo "Required count: " . $returnType->getRequiredElementCount() . "\n";

    foreach ($returnType->getElements() as $element) {
        echo $element->getName() . ": " . $element->getType();
        if ($element->isOptional()) {
            echo " (optional)";
        }
        echo "\n";
    }
}
```

## Shape Type Alias Details

### Defining Shapes

```php
// Simple shape
shape Point = array{x: int, y: int};

// Shape with optional keys
shape Config = array{debug: bool, env: string, cache_ttl?: int};

// Shape with nullable values
shape ApiResponse = array{success: bool, data: mixed, error: ?string};

// Nested shapes (shapes can reference other shapes)
shape Address = array{street: string, city: string, zip: string};
shape Person = array{name: string, address: Address};

// Shape with typed arrays
shape Team = array{name: string, members: array<string>, scores: array<int>};
```

### Using Shapes

```php
// As return type
function getUser(): User { ... }

// As parameter type
function processUser(User $user): void { ... }

// In classes
class UserRepository {
    public function find(int $id): ?User { ... }
    public function save(User $user): void { ... }
}
```

### Shape Autoloading

Shapes can be autoloaded using `spl_autoload_register()`:

```php
spl_autoload_register(function($name) {
    $file = __DIR__ . "/shapes/$name.php";
    if (file_exists($file)) {
        require_once $file;
    }
});
```

### shape_exists() Function

Check if a shape is defined:

```php
// Check without triggering autoload
if (shape_exists('User', false)) { ... }

// Check with autoloading (default)
if (shape_exists('User')) { ... }

// Case-insensitive
shape_exists('user');  // Same as shape_exists('User')
```

## Common Patterns

### API Response Wrapper

```php
function apiResponse(mixed $data, ?string $error = null): array{
    success: bool,
    data: mixed,
    error: ?string,
    timestamp: string
} {
    return [
        'success' => $error === null,
        'data' => $data,
        'error' => $error,
        'timestamp' => date('c')
    ];
}
```

### Configuration Object

```php
function getConfig(): array{
    database: array{host: string, port: int, name: string},
    cache: array{driver: string, ttl: int},
    debug?: bool
} { ... }
```

### DTO Factory

```php
function createUserDTO(
    int $id,
    string $name,
    string $email
): array{id: int, name: string, email: string, created_at: string} {
    return [
        'id' => $id,
        'name' => $name,
        'email' => $email,
        'created_at' => date('c')
    ];
}
```

### Paginated Results

```php
function paginate(array $items, int $page, int $total): array{
    data: array,
    meta: array{page: int, total: int, has_more: bool}
} {
    return [
        'data' => $items,
        'meta' => [
            'page' => $page,
            'total' => $total,
            'has_more' => count($items) < $total
        ]
    ];
}
```

## Requirements

- PHP 8.5+ with array shape support
- `declare(strict_arrays=1)` for runtime validation
