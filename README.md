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

## Array Shapes RFC Implementation

This fork implements **Array Shapes** for PHP, providing comprehensive type safety
for array structures with three complementary syntaxes.

### Features

#### 1. Typed Arrays (`array<T>`)
Define arrays where all elements must be of a specific type:

```php
declare(strict_arrays=1);

function getIds(): array<int> {
    return [1, 2, 3];
}

function getUsers(): array<User> {
    return [new User("Alice"), new User("Bob")];
}
```

#### 2. Key-Value Typed Arrays (`array<K, V>`)
Define arrays with typed keys and values:

```php
declare(strict_arrays=1);

function getScores(): array<string, int> {
    return ['alice' => 95, 'bob' => 87];
}

function getConfig(): array<string, mixed> {
    return ['debug' => true, 'port' => 8080];
}
```

#### 3. Array Shapes (`array{key: type}`)
Define the exact structure of associative arrays:

```php
declare(strict_arrays=1);

function getUser(): array{id: int, name: string, email?: string} {
    return ['id' => 1, 'name' => 'Alice'];
}

function getPoint(): array{x: int, y: int} {
    return ['x' => 10, 'y' => 20];
}
```

#### 4. Shape Type Aliases (`shape`)
Define reusable type aliases for array structures:

```php
declare(strict_arrays=1);

// Define shape type aliases
shape User = array{id: int, name: string, email: string};
shape Point = array{x: int, y: int};
shape Config = array{debug: bool, env: string, cache_ttl?: int};

// Use them in function signatures
function getUser(int $id): User {
    return ['id' => $id, 'name' => 'Alice', 'email' => 'alice@example.com'];
}

function processUser(User $user): void {
    echo "Hello, {$user['name']}!";
}

function calculateDistance(Point $a, Point $b): float {
    return sqrt(($b['x'] - $a['x']) ** 2 + ($b['y'] - $a['y']) ** 2);
}
```

### Shape Autoloading

Shapes can be autoloaded just like classes:

```php
// Register an autoloader
spl_autoload_register(function($name) {
    $file = __DIR__ . "/shapes/$name.php";
    if (file_exists($file)) {
        require_once $file;
    }
});

// Check if a shape exists
if (shape_exists('User')) {
    echo "User shape is defined";
}

// Shapes will be autoloaded when used
function getUser(): UserShape { ... }  // Autoloads shapes/UserShape.php
```

### Quick Reference

```php
// Typed arrays
array<int>                     // All elements are int
array<string>                  // All elements are string
array<User>                    // All elements are User objects
array<int|string>              // Elements are int or string
array<array<int>>              // Nested: array of int arrays

// Key-value typed arrays
array<string, int>             // String keys, int values
array<int, User>               // Int keys, User values

// Array shapes (inline)
array{id: int, name: string}   // Required keys
array{id: int, email?: string} // Optional key (may be absent)
array{data: ?string}           // Nullable value (can be null)
array{user: array{id: int}}    // Nested shapes

// Shape type aliases
shape User = array{id: int, name: string};
shape Point = array{x: int, y: int};
shape Config = array{debug: bool, cache?: int};
```

### Error Handling

When validation fails, a `TypeError` is thrown with details:

```php
function getIds(): array<int> {
    return [1, "two", 3];  // TypeError: element at index 1 must be int, string given
}

function getUser(): array{id: int, name: string} {
    return ['id' => 1];  // TypeError: missing required key 'name'
}
```

### Implementation Status

- [x] Typed arrays: `array<T>`, `array<K, V>`
- [x] Array shapes: `array{key: type}`
- [x] Optional keys: `array{key?: type}`
- [x] Nullable values: `array{key: ?type}`
- [x] Union types: `array<int|string>`, `array{id: int|string}`
- [x] Nested structures: `array<array<int>>`, `array{user: array{id: int}}`
- [x] Shape type aliases: `shape Name = array{...}`
- [x] Shape autoloading via `spl_autoload_register()`
- [x] `shape_exists()` function
- [x] Reflection API support
- [x] Runtime validation with detailed errors

### Examples

See the `examples/array-shapes/` directory for comprehensive examples:

```bash
./sapi/cli/php examples/array-shapes/11-shape-type-aliases.php
./sapi/cli/php examples/array-shapes/12-shape-autoloading.php
```

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
