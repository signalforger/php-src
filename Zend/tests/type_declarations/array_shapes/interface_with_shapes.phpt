--TEST--
Interfaces with array shape return types
--XLEAK--
--FILE--
<?php

// Test 1: Interface method with array shape return type
interface UserRepositoryInterface {
    public function findById(int $id): array{id: int, name: string, email: string};
    public function findAll(): array<array{id: int, name: string}>;
}

class InMemoryUserRepository implements UserRepositoryInterface {
    private array $users = [];

    public function __construct() {
        $this->users = [
            1 => ['id' => 1, 'name' => 'Alice', 'email' => 'alice@example.com'],
            2 => ['id' => 2, 'name' => 'Bob', 'email' => 'bob@example.com'],
        ];
    }

    public function findById(int $id): array{id: int, name: string, email: string} {
        return $this->users[$id];
    }

    public function findAll(): array<array{id: int, name: string}> {
        return array_values($this->users);
    }
}

$repo = new InMemoryUserRepository();
$user = $repo->findById(1);
echo "User: {$user['name']} <{$user['email']}>\n";

$all = $repo->findAll();
echo "Total users: " . count($all) . "\n";

// Test 2: Interface with typed array parameter
interface DataProcessorInterface {
    public function process(array<int> $data): int;
}

class SumProcessor implements DataProcessorInterface {
    public function process(array<int> $data): int {
        return array_sum($data);
    }
}

$processor = new SumProcessor();
echo "Sum: " . $processor->process([1, 2, 3, 4, 5]) . "\n";

// Test 3: Multiple interfaces with shapes
interface Identifiable {
    public function getIdentity(): array{id: int, type: string};
}

interface Describable {
    public function describe(): array{title: string, description: string};
}

class Product implements Identifiable, Describable {
    public function __construct(
        private int $id,
        private string $name,
        private string $desc
    ) {}

    public function getIdentity(): array{id: int, type: string} {
        return ['id' => $this->id, 'type' => 'product'];
    }

    public function describe(): array{title: string, description: string} {
        return ['title' => $this->name, 'description' => $this->desc];
    }
}

$product = new Product(42, 'Widget', 'A useful widget');
$identity = $product->getIdentity();
$desc = $product->describe();
echo "Product #{$identity['id']} ({$identity['type']}): {$desc['title']}\n";

echo "Done\n";
?>
--EXPECT--
User: Alice <alice@example.com>
Total users: 2
Sum: 15
Product #42 (product): Widget
Done
