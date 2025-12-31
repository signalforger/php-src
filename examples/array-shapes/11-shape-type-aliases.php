<?php
/**
 * Example 11: Shape Type Aliases
 *
 * The `shape` keyword allows you to define reusable array structure type aliases.
 * Shapes work similarly to typedefs or type aliases in other languages.
 */
declare(strict_arrays=1);

echo "=== Shape Type Aliases ===\n\n";

// ============================================================================
// DEFINING SHAPES
// ============================================================================

echo "--- Defining Shapes ---\n";

// Define a shape type alias for a User structure
shape User = array{id: int, name: string, email: string};

// Define a shape for a Point
shape Point = array{x: int, y: int};

// Define a shape with optional keys
shape Config = array{debug: bool, env: string, cache_ttl?: int};

// Shapes can include nullable types
shape ApiResponse = array{success: bool, data: mixed, error: ?string};

echo "Defined shapes: User, Point, Config, ApiResponse\n\n";

// ============================================================================
// USING SHAPES IN FUNCTION SIGNATURES
// ============================================================================

echo "--- Using Shapes in Functions ---\n";

// Use shape as return type
function createUser(int $id, string $name, string $email): User {
    return [
        'id' => $id,
        'name' => $name,
        'email' => $email
    ];
}

// Use shape as parameter type
function processUser(User $user): void {
    echo "Processing user: {$user['name']} (ID: {$user['id']})\n";
}

// Multiple shapes in signature
function calculateDistance(Point $a, Point $b): float {
    $dx = $b['x'] - $a['x'];
    $dy = $b['y'] - $a['y'];
    return sqrt($dx * $dx + $dy * $dy);
}

$user = createUser(1, 'Alice', 'alice@example.com');
processUser($user);
var_dump($user);

$pointA = ['x' => 0, 'y' => 0];
$pointB = ['x' => 3, 'y' => 4];
$distance = calculateDistance($pointA, $pointB);
echo "Distance: $distance\n\n";

// ============================================================================
// SHAPES WITH OPTIONAL KEYS
// ============================================================================

echo "--- Shapes with Optional Keys ---\n";

function getConfig(bool $useCache = false): Config {
    $config = [
        'debug' => true,
        'env' => 'development'
    ];

    if ($useCache) {
        $config['cache_ttl'] = 3600;
    }

    return $config;
}

$minimalConfig = getConfig(false);
$fullConfig = getConfig(true);

echo "Minimal config:\n";
var_dump($minimalConfig);

echo "Full config:\n";
var_dump($fullConfig);
echo "\n";

// ============================================================================
// SHAPES IN CLASSES
// ============================================================================

echo "--- Shapes in Classes ---\n";

// Define shapes for class usage
shape ProductData = array{id: int, name: string, price: float, stock?: int};

class ProductRepository {
    private array $products = [];

    public function save(ProductData $product): void {
        $this->products[$product['id']] = $product;
        echo "Saved product: {$product['name']}\n";
    }

    public function find(int $id): ?ProductData {
        return $this->products[$id] ?? null;
    }

    /** @return array<ProductData> */
    public function all(): array {
        return array_values($this->products);
    }
}

$repo = new ProductRepository();
$repo->save(['id' => 1, 'name' => 'Widget', 'price' => 29.99, 'stock' => 100]);
$repo->save(['id' => 2, 'name' => 'Gadget', 'price' => 49.99]);

$product = $repo->find(1);
if ($product) {
    echo "Found: {$product['name']} - \${$product['price']}\n";
}
echo "\n";

// ============================================================================
// NESTED SHAPES
// ============================================================================

echo "--- Nested Shapes ---\n";

// Shapes can reference other shapes
shape Address = array{street: string, city: string, zip: string};
shape Person = array{name: string, age: int, address: Address};

function describePerson(Person $person): string {
    return sprintf(
        "%s, age %d, lives at %s, %s %s",
        $person['name'],
        $person['age'],
        $person['address']['street'],
        $person['address']['city'],
        $person['address']['zip']
    );
}

$person = [
    'name' => 'Bob',
    'age' => 30,
    'address' => [
        'street' => '123 Main St',
        'city' => 'Springfield',
        'zip' => '12345'
    ]
];

echo describePerson($person) . "\n\n";

// ============================================================================
// SHAPES WITH TYPED ARRAYS
// ============================================================================

echo "--- Shapes with Typed Arrays ---\n";

// Shape containing typed arrays
shape TeamData = array{
    name: string,
    members: array<string>,
    scores: array<int>
};

function printTeam(TeamData $team): void {
    echo "Team: {$team['name']}\n";
    echo "Members: " . implode(', ', $team['members']) . "\n";
    echo "Scores: " . implode(', ', $team['scores']) . "\n";
}

$team = [
    'name' => 'Alpha Squad',
    'members' => ['Alice', 'Bob', 'Charlie'],
    'scores' => [95, 87, 92]
];

printTeam($team);
echo "\n";

// ============================================================================
// CHECKING SHAPE EXISTENCE
// ============================================================================

echo "--- Checking Shape Existence ---\n";

// Use shape_exists() to check if a shape is defined
echo "User shape exists: " . (shape_exists('User') ? 'yes' : 'no') . "\n";
echo "Point shape exists: " . (shape_exists('Point') ? 'yes' : 'no') . "\n";
echo "NonExistent shape exists: " . (shape_exists('NonExistent') ? 'yes' : 'no') . "\n";

// Case-insensitive check
echo "user (lowercase) exists: " . (shape_exists('user') ? 'yes' : 'no') . "\n";

echo "\n=== Example Complete ===\n";
