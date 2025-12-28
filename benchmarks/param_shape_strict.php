<?php
/**
 * Benchmark: Array Shape Parameter Type with strict_arrays=1
 */
declare(strict_arrays=1);

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
// FUNCTIONS WITH ARRAY SHAPES
// ============================================================================

function processPointShape(array{x: int, y: int} $point): int {
    return $point['x'] + $point['y'];
}

function processUserShape(array{id: int, name: string, email: string, active: bool} $user): string {
    return $user['name'] . ' <' . $user['email'] . '>';
}

function processConfigShape(array{host: string, port: int, database: string, username: string, password: string} $config): string {
    return $config['host'] . ':' . $config['port'];
}

// ============================================================================
// BENCHMARKS
// ============================================================================

echo "=== Array Shape Parameter with strict_arrays=1 ===\n";
echo "Iterations: " . number_format($iterations) . "\n\n";

// Warm up
for ($i = 0; $i < 1000; $i++) {
    processPointShape($point);
    processUserShape($user);
    processConfigShape($config);
}

// Benchmark 1: Simple point (2 keys)
echo "--- Simple Shape (2 keys: x, y) ---\n";

$start = hrtime(true);
for ($i = 0; $i < $iterations; $i++) {
    processPointShape($point);
}
$shapeTime = (hrtime(true) - $start) / 1_000_000;
echo "Array shape:        " . number_format($shapeTime, 2) . " ms\n";

// Benchmark 2: User (4 keys)
echo "\n--- Medium Shape (4 keys: id, name, email, active) ---\n";

$start = hrtime(true);
for ($i = 0; $i < $iterations; $i++) {
    processUserShape($user);
}
$shapeTime = (hrtime(true) - $start) / 1_000_000;
echo "Array shape:        " . number_format($shapeTime, 2) . " ms\n";

// Benchmark 3: Config (5 keys)
echo "\n--- Larger Shape (5 keys: host, port, database, username, password) ---\n";

$start = hrtime(true);
for ($i = 0; $i < $iterations; $i++) {
    processConfigShape($config);
}
$shapeTime = (hrtime(true) - $start) / 1_000_000;
echo "Array shape:        " . number_format($shapeTime, 2) . " ms\n";

echo "\n=== Strict arrays benchmark complete ===\n";
