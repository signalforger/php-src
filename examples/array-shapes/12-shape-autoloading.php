<?php
/**
 * Example 12: Shape Autoloading
 *
 * Shapes can be autoloaded just like classes using spl_autoload_register().
 * This enables modular code organization where shapes are defined in
 * separate files and loaded on demand.
 */
declare(strict_arrays=1);

echo "=== Shape Autoloading ===\n\n";

// ============================================================================
// SETUP: Create temporary shape files for demonstration
// ============================================================================

$tempDir = sys_get_temp_dir() . '/php_shape_example_' . getmypid();
if (!is_dir($tempDir)) {
    mkdir($tempDir, 0755, true);
}

// Create shape definition files
file_put_contents($tempDir . '/UserShape.php', '<?php
declare(strict_arrays=1);
shape UserShape = array{id: int, username: string, email: string, active: bool};
');

file_put_contents($tempDir . '/OrderShape.php', '<?php
declare(strict_arrays=1);
shape OrderShape = array{
    id: int,
    user_id: int,
    items: array<array{product: string, quantity: int, price: float}>,
    total: float,
    status: string
};
');

file_put_contents($tempDir . '/ApiResponseShape.php', '<?php
declare(strict_arrays=1);
shape ApiResponseShape = array{
    success: bool,
    data: mixed,
    error: ?string,
    meta: array{timestamp: string, version: string}
};
');

echo "Created shape files in: $tempDir\n\n";

// ============================================================================
// AUTOLOADER REGISTRATION
// ============================================================================

echo "--- Registering Autoloader ---\n";

$autoloadedShapes = [];

spl_autoload_register(function($name) use ($tempDir, &$autoloadedShapes) {
    // Check if this looks like a shape (ends with 'Shape')
    $file = "$tempDir/$name.php";
    if (file_exists($file)) {
        $autoloadedShapes[] = $name;
        echo "  Autoloading: $name from $file\n";
        require_once $file;
        return true;
    }
    return false;
});

echo "Autoloader registered.\n\n";

// ============================================================================
// USING shape_exists() WITH AUTOLOADING
// ============================================================================

echo "--- Checking Shape Existence ---\n";

// Without autoload (second parameter = false)
echo "UserShape exists (no autoload): " .
    (shape_exists('UserShape', false) ? 'yes' : 'no') . "\n";

// With autoload (default behavior)
echo "UserShape exists (with autoload): " .
    (shape_exists('UserShape', true) ? 'yes' : 'no') . "\n";

// Now it's loaded, so no-autoload check returns true
echo "UserShape exists (no autoload, after load): " .
    (shape_exists('UserShape', false) ? 'yes' : 'no') . "\n\n";

// ============================================================================
// USING AUTOLOADED SHAPES
// ============================================================================

echo "--- Using Autoloaded Shapes ---\n";

// Function using autoloaded UserShape
function createUser(int $id, string $username, string $email): UserShape {
    return [
        'id' => $id,
        'username' => $username,
        'email' => $email,
        'active' => true
    ];
}

$user = createUser(1, 'alice', 'alice@example.com');
echo "Created user: {$user['username']}\n";
var_dump($user);
echo "\n";

// ============================================================================
// COMPLEX AUTOLOADED SHAPE
// ============================================================================

echo "--- Complex Autoloaded Shape (OrderShape) ---\n";

function createOrder(int $id, int $userId, array $items): OrderShape {
    $total = array_reduce($items, function($sum, $item) {
        return $sum + ($item['quantity'] * $item['price']);
    }, 0.0);

    return [
        'id' => $id,
        'user_id' => $userId,
        'items' => $items,
        'total' => $total,
        'status' => 'pending'
    ];
}

$order = createOrder(101, 1, [
    ['product' => 'Widget', 'quantity' => 2, 'price' => 29.99],
    ['product' => 'Gadget', 'quantity' => 1, 'price' => 49.99]
]);

echo "Created order #{$order['id']} for user #{$order['user_id']}\n";
echo "Total: \${$order['total']}\n";
echo "Items:\n";
foreach ($order['items'] as $item) {
    echo "  - {$item['quantity']}x {$item['product']} @ \${$item['price']}\n";
}
echo "\n";

// ============================================================================
// API RESPONSE PATTERN
// ============================================================================

echo "--- API Response Shape ---\n";

function apiSuccess(mixed $data): ApiResponseShape {
    return [
        'success' => true,
        'data' => $data,
        'error' => null,
        'meta' => [
            'timestamp' => date('c'),
            'version' => '1.0.0'
        ]
    ];
}

function apiError(string $message): ApiResponseShape {
    return [
        'success' => false,
        'data' => null,
        'error' => $message,
        'meta' => [
            'timestamp' => date('c'),
            'version' => '1.0.0'
        ]
    ];
}

$successResponse = apiSuccess(['users' => [$user]]);
$errorResponse = apiError('User not found');

echo "Success response:\n";
var_dump($successResponse['success'], $successResponse['error']);

echo "Error response:\n";
var_dump($errorResponse['success'], $errorResponse['error']);
echo "\n";

// ============================================================================
// SUMMARY
// ============================================================================

echo "--- Autoload Summary ---\n";
echo "Shapes autoloaded during this example:\n";
foreach ($autoloadedShapes as $shape) {
    echo "  - $shape\n";
}
echo "\n";

// ============================================================================
// CLEANUP
// ============================================================================

unlink($tempDir . '/UserShape.php');
unlink($tempDir . '/OrderShape.php');
unlink($tempDir . '/ApiResponseShape.php');
rmdir($tempDir);
echo "Cleaned up temporary files.\n";

echo "\n=== Example Complete ===\n";
