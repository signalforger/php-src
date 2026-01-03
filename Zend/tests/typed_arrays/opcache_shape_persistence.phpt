--TEST--
OPcache: shape types persist correctly in cache
--EXTENSIONS--
opcache
--INI--
opcache.enable=1
opcache.enable_cli=1
opcache.jit=off
--FILE--
<?php
declare(strict_arrays=1);

// This test verifies that typed arrays and shapes work correctly
// when scripts are cached by OPcache

function getUsers(): array<array{id: int, name: string}> {
    return [
        ['id' => 1, 'name' => 'Alice'],
        ['id' => 2, 'name' => 'Bob'],
    ];
}

function getNumbers(): array<int> {
    return [1, 2, 3, 4, 5];
}

class Config {
    public array{host: string, port: int} $database = [
        'host' => 'localhost',
        'port' => 3306
    ];
}

// Test typed arrays
$numbers = getNumbers();
echo "Numbers: " . implode(", ", $numbers) . "\n";

// Test array shapes
$users = getUsers();
foreach ($users as $user) {
    echo "User: {$user['name']} (ID: {$user['id']})\n";
}

// Test property shapes
$config = new Config();
echo "Database: {$config->database['host']}:{$config->database['port']}\n";

// Verify opcache is active
if (function_exists('opcache_get_status')) {
    $status = opcache_get_status();
    echo "OPcache enabled: " . ($status['opcache_enabled'] ? 'yes' : 'no') . "\n";
}

?>
--EXPECT--
Numbers: 1, 2, 3, 4, 5
User: Alice (ID: 1)
User: Bob (ID: 2)
Database: localhost:3306
OPcache enabled: yes
