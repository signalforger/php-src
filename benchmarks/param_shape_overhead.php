<?php
/**
 * Benchmark: Array Shape Parameter Type Overhead
 *
 * Compares performance of:
 * 1. Regular array parameter (no validation)
 * 2. Array shape parameter with strict_arrays=1
 */

// Number of iterations
$iterations = 1_000_000;

// Test data
$point = ['x' => 10, 'y' => 20];
$user = ['id' => 1, 'name' => 'Alice', 'email' => 'alice@example.com', 'active' => true];
$config = [
    'host' => 'localhost',
    'port' => 3306,
    'database' => 'myapp',
    'username' => 'root',
    'password' => 'secret'
];

// ============================================================================
// FUNCTIONS WITHOUT STRICT ARRAYS (baseline)
// ============================================================================

function processPointPlain(array $point): int {
    return $point['x'] + $point['y'];
}

function processUserPlain(array $user): string {
    return $user['name'] . ' <' . $user['email'] . '>';
}

function processConfigPlain(array $config): string {
    return $config['host'] . ':' . $config['port'];
}

// ============================================================================
// BENCHMARKS
// ============================================================================

echo "=== Array Shape Parameter Overhead Benchmark ===\n";
echo "Iterations: " . number_format($iterations) . "\n\n";

// Warm up
for ($i = 0; $i < 1000; $i++) {
    processPointPlain($point);
    processUserPlain($user);
    processConfigPlain($config);
}

// Benchmark 1: Simple point (2 keys)
echo "--- Simple Shape (2 keys: x, y) ---\n";

$start = hrtime(true);
for ($i = 0; $i < $iterations; $i++) {
    processPointPlain($point);
}
$plainTime = (hrtime(true) - $start) / 1_000_000;
echo "Plain array:        " . number_format($plainTime, 2) . " ms\n";

// Benchmark 2: User (4 keys)
echo "\n--- Medium Shape (4 keys: id, name, email, active) ---\n";

$start = hrtime(true);
for ($i = 0; $i < $iterations; $i++) {
    processUserPlain($user);
}
$plainTime = (hrtime(true) - $start) / 1_000_000;
echo "Plain array:        " . number_format($plainTime, 2) . " ms\n";

// Benchmark 3: Config (5 keys)
echo "\n--- Larger Shape (5 keys: host, port, database, username, password) ---\n";

$start = hrtime(true);
for ($i = 0; $i < $iterations; $i++) {
    processConfigPlain($config);
}
$plainTime = (hrtime(true) - $start) / 1_000_000;
echo "Plain array:        " . number_format($plainTime, 2) . " ms\n";

echo "\n=== Baseline complete. Now run with strict_arrays... ===\n";
