<div align="center">
    <a href="https://www.php.net">
        <img
            alt="PHP"
            src="https://www.php.net/images/logos/new-php-logo.svg"
            width="150">
    </a>
</div>

# The PHP Interpreter

PHP is a popular general-purpose scripting language that is especially suited to
web development. Fast, flexible and pragmatic, PHP powers everything from your
blog to the most popular websites in the world. PHP is distributed under the
[PHP License v3.01](LICENSE).

---

## Typed Arrays & Array Shapes RFC Implementation

This fork implements **Typed Arrays** and **Array Shapes** for PHP—two complementary features that bring type safety to PHP's most versatile data structure.

### The Problem

PHP arrays are incredibly flexible, serving as lists, dictionaries, and structured records. But this flexibility comes at a cost: no way to express or enforce what an array should contain.

```php
function getUsers(): array {
    // What's in this array? Objects? Associative arrays? Integers?
    // The type system can't tell you.
}
```

### The Solution: Two Complementary Features

#### Typed Arrays — For Collections

When you have a **list of things of the same type**, use typed arrays:

```php
// A list of integers
function getIds(): array<int> {
    return [1, 2, 3];
}

// A list of User objects
function getActiveUsers(): array<User> {
    return $this->repository->findActive();
}

// A dictionary with string keys and integer values
function getScores(): array<string, int> {
    return ['alice' => 95, 'bob' => 87, 'charlie' => 92];
}
```

This is what you reach for when working with collections—arrays where every element is the same kind of thing.

#### Array Shapes — For Structured Data

When you have **structured data with known keys**, like records from a database or responses from an API, use array shapes:

```php
// Data from a database row
function getUser(int $id): array{id: int, name: string, email: string} {
    return $this->db->fetch("SELECT id, name, email FROM users WHERE id = ?", $id);
}

// Response from an external API
function getWeather(string $city): array{temp: float, humidity: int, conditions: string} {
    return json_decode(file_get_contents("https://api.weather.com/$city"), true);
}
```

### Real-World Examples

#### Working with Database Results

```php
// Define the shape of a user record
shape UserRecord = array{
    id: int,
    name: string,
    email: string,
    created_at: string,
    is_active?: bool
};

class UserRepository {
    // Single record
    public function find(int $id): ?UserRecord {
        return $this->db->fetch("SELECT * FROM users WHERE id = ?", $id);
    }

    // Collection of records — combining both features!
    public function findAll(): array<UserRecord> {
        return $this->db->fetchAll("SELECT * FROM users");
    }
}
```

#### Working with API Responses

```php
// Shape describing the API response structure
shape ApiResponse = array{
    success: bool,
    data: mixed,
    error?: string,
    meta?: array{page: int, total: int}
};

shape ProductData = array{
    id: int,
    name: string,
    price: float,
    tags: array<string>     // Nested typed array!
};

function fetchProduct(int $id): ProductData {
    $response = $this->http->get("/api/products/$id");
    return $response['data'];
}

function fetchProducts(): array<ProductData> {
    $response = $this->http->get("/api/products");
    return $response['data'];
}
```

#### Configuration Arrays

```php
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
    env: string,
    database: DatabaseConfig,
    cache_ttl?: int
};

function loadConfig(string $path): AppConfig {
    return require $path;
}
```

### This is NOT About DTOs

A common misconception: "Why not just use classes/DTOs?"

**These features work with arrays, not objects.** They're designed for the many situations where arrays are the right tool:

- **Database results** — PDO and other drivers return arrays
- **JSON APIs** — `json_decode()` returns arrays
- **Configuration files** — Often loaded as arrays
- **Legacy code** — Millions of lines of PHP use arrays for structured data
- **Interoperability** — Arrays are PHP's universal data interchange format

You don't have to choose between arrays and objects. Use objects when you need behavior (methods), use typed arrays when you're working with data.

```php
// Arrays for data from external sources
function getApiUser(): array{id: int, name: string} {
    return json_decode($response, true);
}

// Objects when you need behavior
class User {
    public function __construct(
        public int $id,
        public string $name
    ) {}

    public function greet(): string {
        return "Hello, {$this->name}!";
    }
}
```

### Quick Reference

```php
// Typed arrays — for collections
array<int>                     // List of integers
array<string>                  // List of strings
array<User>                    // List of User objects
array<int|string>              // List of integers or strings
array<string, int>             // Dictionary: string keys, int values
array<array<int>>              // List of integer lists

// Array shapes — for structured data
array{id: int, name: string}   // Required keys
array{id: int, email?: string} // Optional key (may be absent)
array{data: ?string}           // Nullable value (can be null)
array{user: array{id: int}}    // Nested shapes

// Shape type aliases — for reusability
shape User = array{id: int, name: string};
shape Point = array{x: int, y: int};
shape Config = array{debug: bool, cache?: int};
```

### Error Messages

When validation fails, you get clear error messages:

```php
function getIds(): array<int> {
    return [1, "two", 3];
}
// TypeError: getIds(): Return value must be of type array<int>,
//            array element at index 1 is string

function getUser(): array{id: int, name: string} {
    return ['id' => 1];
}
// TypeError: getUser(): Return value must be of type array{name: string, ...},
//            array given with missing key "name"
```

### Shape Autoloading

Shapes can be autoloaded like classes, keeping your codebase organized:

```php
// shapes/UserRecord.php
<?php
shape UserRecord = array{id: int, name: string, email: string};

// Somewhere else in your code
spl_autoload_register(function($name) {
    $file = __DIR__ . "/shapes/$name.php";
    if (file_exists($file)) require_once $file;
});

// UserRecord is autoloaded when first used
function getUser(): UserRecord { ... }
```

### Implementation Status

- [x] Typed arrays: `array<T>`, `array<K, V>`
- [x] Array shapes: `array{key: type}`
- [x] Optional keys: `array{key?: type}`
- [x] Nullable values: `array{key: ?type}`
- [x] Union types: `array<int|string>`
- [x] Nested structures: `array<array<int>>`, `array{user: array{id: int}}`
- [x] Shape type aliases: `shape Name = array{...}`
- [x] Shape autoloading via `spl_autoload_register()`
- [x] Reflection API support (`ReflectionArrayType`, `ReflectionArrayShapeType`)
- [x] Runtime validation with detailed error messages

---

[![Push](https://github.com/php/php-src/actions/workflows/push.yml/badge.svg)](https://github.com/php/php-src/actions/workflows/push.yml)
[![Fuzzing Status](https://oss-fuzz-build-logs.storage.googleapis.com/badges/php.svg)](https://issues.oss-fuzz.com/issues?q=project:php)

## Documentation

The PHP manual is available at [php.net/docs](https://www.php.net/docs).

## Installation

### Prebuilt packages and binaries

Prebuilt packages and binaries can be used to get up and running fast with PHP.

For Windows, the PHP binaries can be obtained from
[windows.php.net](https://windows.php.net). After extracting the archive the
`*.exe` files are ready to use.

For other systems, see the [installation chapter](https://www.php.net/install).

### Building PHP source code

*For Windows, see [Build your own PHP on Windows](https://wiki.php.net/internals/windows/stepbystepbuild_sdk_2).*

For a minimal PHP build from Git, you will need autoconf, bison, and re2c. For
a default build, you will additionally need libxml2 and libsqlite3.

On Ubuntu, you can install these using:

```shell
sudo apt install -y pkg-config build-essential autoconf bison re2c libxml2-dev libsqlite3-dev
```

On Fedora, you can install these using:

```shell
sudo dnf install re2c bison autoconf make libtool ccache libxml2-devel sqlite-devel
```

On MacOS, you can install these using `brew`:

```shell
brew install autoconf bison re2c libiconv libxml2 sqlite
```

or with `MacPorts`:

```shell
sudo port install autoconf bison re2c libiconv libxml2 sqlite3
```

Generate configure:

```shell
./buildconf
```

Configure your build. `--enable-debug` is recommended for development, see
`./configure --help` for a full list of options.

```shell
# For development
./configure --enable-debug
# For production
./configure
```

Build PHP. To speed up the build, specify the maximum number of jobs using the
`-j` argument:

```shell
make -j4
```

The number of jobs should usually match the number of available cores, which
can be determined using `nproc`.

## Testing PHP source code

PHP ships with an extensive test suite, the command `make test` is used after
successful compilation of the sources to run this test suite.

It is possible to run tests using multiple cores by setting `-jN` in
`TEST_PHP_ARGS` or `TESTS`:

```shell
make TEST_PHP_ARGS=-j4 test
```

Shall run `make test` with a maximum of 4 concurrent jobs: Generally the maximum
number of jobs should not exceed the number of cores available.

Use the `TEST_PHP_ARGS` or `TESTS` variable to test only specific directories:

```shell
make TESTS=tests/lang/ test
```

The [qa.php.net](https://qa.php.net) site provides more detailed info about
testing and quality assurance.

## Installing PHP built from source

After a successful build (and test), PHP may be installed with:

```shell
make install
```

Depending on your permissions and prefix, `make install` may need superuser
permissions.

## PHP extensions

Extensions provide additional functionality on top of PHP. PHP consists of many
essential bundled extensions. Additional extensions can be found in the PHP
Extension Community Library - [PECL](https://pecl.php.net).

## Contributing

The PHP source code is located in the Git repository at
[github.com/php/php-src](https://github.com/php/php-src). Contributions are most
welcome by forking the repository and sending a pull request.

Discussions are done on GitHub, but depending on the topic can also be relayed
to the official PHP developer mailing list internals@lists.php.net.

New features require an RFC and must be accepted by the developers. See
[Request for comments - RFC](https://wiki.php.net/rfc) and
[Voting on PHP features](https://wiki.php.net/rfc/voting) for more information
on the process.

Bug fixes don't require an RFC. If the bug has a GitHub issue, reference it in
the commit message using `GH-NNNNNN`. Use `#NNNNNN` for tickets in the old
[bugs.php.net](https://bugs.php.net) bug tracker.

    Fix GH-7815: php_uname doesn't recognise latest Windows versions
    Fix #55371: get_magic_quotes_gpc() throws deprecation warning

See [Git workflow](https://wiki.php.net/vcs/gitworkflow) for details on how pull
requests are merged.

### Guidelines for contributors

See further documents in the repository for more information on how to
contribute:

- [Contributing to PHP](/CONTRIBUTING.md)
- [PHP coding standards](/CODING_STANDARDS.md)
- [Internal documentation](https://php.github.io/php-src/)
- [Mailing list rules](/docs/mailinglist-rules.md)
- [PHP release process](/docs/release-process.md)

## Credits

For the list of people who've put work into PHP, please see the
[PHP credits page](https://www.php.net/credits.php).
