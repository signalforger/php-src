# RFC: Array Shapes for PHP

* Version: 1.0
* Date: 2024-12-31
* Author: PHP Array Shapes Implementation
* Status: Implemented (Proof of Concept)

## Introduction

This RFC proposes adding comprehensive array type syntax to PHP, allowing developers
to specify the structure and types of array elements at the language level. The
implementation provides three complementary syntaxes for different use cases.

## Motivation

PHP arrays are versatile data structures used for lists, dictionaries, records, and
complex nested structures. However, the type system currently only allows declaring
a value as `array` without specifying its internal structure. This leads to:

1. **Runtime errors** - Type mismatches discovered only at runtime
2. **Poor IDE support** - Limited autocomplete and refactoring capabilities
3. **Documentation burden** - Developers must rely on PHPDoc annotations
4. **Maintenance issues** - Changing array structures requires manual updates

Static analysis tools like PHPStan and Psalm have introduced PHPDoc-based array
shape syntax, demonstrating strong community demand for this feature.

## Proposal

### 1. Typed Arrays (`array<T>`)

Specify that all elements of an array must be of a certain type:

```php
function getIds(): array<int> {
    return [1, 2, 3];
}

function getUsers(): array<User> {
    return [new User("Alice"), new User("Bob")];
}

function getValues(): array<int|string> {
    return [1, "two", 3];
}
```

### 2. Key-Value Typed Arrays (`array<K, V>`)

Specify both key and value types:

```php
function getScores(): array<string, int> {
    return ['alice' => 95, 'bob' => 87];
}

function getUsersById(): array<int, User> {
    return [1 => new User("Alice"), 2 => new User("Bob")];
}
```

### 3. Array Shapes (`array{key: type}`)

Define the exact structure of associative arrays:

```php
function getUser(): array{id: int, name: string, email: string} {
    return ['id' => 1, 'name' => 'Alice', 'email' => 'alice@example.com'];
}
```

#### Optional Keys

Use `?` after the key name to mark it as optional:

```php
function getConfig(): array{debug: bool, cache_ttl?: int} {
    return ['debug' => true];  // cache_ttl is optional
}
```

#### Nullable Values

Use `?` before the type to allow null values:

```php
function getUser(): array{name: string, email: ?string} {
    return ['name' => 'Alice', 'email' => null];  // email can be null
}
```

#### Nested Shapes

Shapes can be nested arbitrarily:

```php
function getResponse(): array{
    success: bool,
    data: array{
        user: array{id: int, name: string},
        permissions: array<string>
    },
    error: ?string
} {
    // ...
}
```

### 4. Shape Type Aliases (`shape`)

Define reusable type aliases for array structures using the `shape` keyword:

```php
shape User = array{id: int, name: string, email: string};
shape Point = array{x: int, y: int};
shape Config = array{debug: bool, env: string, cache_ttl?: int};

function getUser(int $id): User {
    return ['id' => $id, 'name' => 'Alice', 'email' => 'alice@example.com'];
}

function processUser(User $user): void {
    echo "Processing: {$user['name']}";
}
```

#### Shape Autoloading

Shapes can be autoloaded using the standard `spl_autoload_register()` mechanism:

```php
spl_autoload_register(function($name) {
    $file = __DIR__ . "/shapes/$name.php";
    if (file_exists($file)) {
        require_once $file;
    }
});

// UserShape is autoloaded when first used
function getUser(): UserShape { ... }
```

#### shape_exists() Function

Check if a shape type alias is defined:

```php
// Check without triggering autoload
if (shape_exists('User', false)) { ... }

// Check with autoloading (default)
if (shape_exists('User')) { ... }
```

## Runtime Behavior

### strict_arrays Declare

Runtime validation is enabled via the `strict_arrays` declare:

```php
declare(strict_arrays=1);

function getIds(): array<int> {
    return [1, "two", 3];  // TypeError at runtime
}
```

Without the declare, type hints are still parsed and available for reflection
but not enforced at runtime (similar to `strict_types`).

### Error Messages

Type errors provide detailed information:

```php
// For typed arrays
TypeError: Return value must be of type array<int>, array given;
  element at index 1 must be of type int, string given

// For array shapes
TypeError: Return value must be of type array{id: int, name: string},
  missing required key 'name'

TypeError: Return value must be of type array{id: int, name: string},
  element 'id' must be of type int, string given
```

## Reflection API

New reflection classes provide runtime introspection:

### ReflectionArrayShapeType

```php
$ref = new ReflectionFunction('getUser');
$type = $ref->getReturnType();

if ($type instanceof ReflectionArrayShapeType) {
    echo $type->getElementCount();          // Number of elements
    echo $type->getRequiredElementCount();  // Required elements only

    foreach ($type->getElements() as $element) {
        echo $element->getName();      // Key name
        echo $element->getType();      // Element type
        echo $element->isOptional();   // Is optional?
    }
}
```

### ReflectionTypedArrayType

```php
if ($type instanceof ReflectionTypedArrayType) {
    echo $type->getElementType();  // Element type (e.g., "int")
    echo $type->getKeyType();      // Key type for array<K,V>
}
```

## Syntax Grammar

```
array_type:
    'array' '<' type_list '>'                    // array<T> or array<K,V>
  | 'array' '{' shape_element_list '}'           // array{...}
  ;

shape_element_list:
    shape_element (',' shape_element)* ','?
  ;

shape_element:
    T_STRING '?'? ':' type                       // key?: type
  ;

shape_declaration:
    'shape' T_STRING '=' array_type ';'
  ;
```

## Comparison with Existing Solutions

### PHPDoc Annotations

```php
/** @return array{id: int, name: string} */
function getUser(): array { ... }
```

**Limitations:**
- No runtime validation
- Inconsistent syntax across tools
- Separated from actual code

### This Proposal

```php
function getUser(): array{id: int, name: string} { ... }
```

**Benefits:**
- Native language syntax
- Optional runtime validation
- IDE support via reflection
- Consistent across all tools

## Implementation Notes

### Compile-Time Optimization

The implementation uses escape analysis to optimize constant array validation
at compile time, avoiding runtime overhead where possible.

### Memory Considerations

Shape type information is stored efficiently:
- Inline shapes store structure in the type itself
- Shape aliases store a reference to a global shape table
- Shapes are interned and shared across functions

### Autoloading Integration

Shape autoloading uses the existing `spl_autoload` infrastructure:
- Same autoloader handles both classes and shapes
- Recursive autoload protection
- Thread-safe implementation

## Backward Compatibility

This proposal is fully backward compatible:

1. New syntax is opt-in via return/parameter type declarations
2. Runtime validation requires explicit `declare(strict_arrays=1)`
3. Existing code continues to work unchanged
4. `shape` is a new keyword only valid at file scope

## Future Scope

Potential future enhancements (not part of this RFC):

1. **Class property types**: `public User $user;`
2. **Readonly shapes**: Immutable array structures
3. **Shape inheritance**: `shape Admin extends User`
4. **Generic shapes**: `shape Result<T> = array{success: bool, data: T}`

## Examples

### API Response

```php
declare(strict_arrays=1);

shape ApiResponse = array{
    success: bool,
    data: mixed,
    error: ?string,
    meta: array{timestamp: string, version: string}
};

function apiSuccess(mixed $data): ApiResponse {
    return [
        'success' => true,
        'data' => $data,
        'error' => null,
        'meta' => ['timestamp' => date('c'), 'version' => '1.0']
    ];
}
```

### Configuration

```php
declare(strict_arrays=1);

shape DatabaseConfig = array{
    host: string,
    port: int,
    database: string,
    username: string,
    password: string,
    options?: array<string, mixed>
};

shape AppConfig = array{
    debug: bool,
    environment: string,
    database: DatabaseConfig,
    cache: array{driver: string, ttl: int}
};

function loadConfig(string $path): AppConfig { ... }
```

### Repository Pattern

```php
declare(strict_arrays=1);

shape UserData = array{id: int, name: string, email: string, created_at: string};

class UserRepository {
    public function find(int $id): ?UserData { ... }
    public function findAll(): array<UserData> { ... }
    public function save(UserData $user): UserData { ... }
    public function delete(int $id): bool { ... }
}
```

## Conclusion

This RFC provides a comprehensive solution for typed arrays in PHP, addressing
a long-standing limitation while maintaining backward compatibility and
providing flexibility through multiple syntax options. The implementation has
been tested and all existing PHP tests pass.
