--TEST--
Interface implementation with covariant array shape return types
--XLEAK--
--FILE--
<?php

// Test 1: Implementation returns more specific shape (valid covariance)
interface BaseDataProvider {
    public function getData(): array{id: int};
}

class ExtendedDataProvider implements BaseDataProvider {
    // Returns more specific type - adds extra fields (covariant)
    public function getData(): array{id: int, name: string, email: string} {
        return ['id' => 1, 'name' => 'Test', 'email' => 'test@example.com'];
    }
}

$provider = new ExtendedDataProvider();
$data = $provider->getData();
echo "Got data with id={$data['id']}, name={$data['name']}\n";

// Test 2: Child class narrows parent's interface implementation
interface ConfigProvider {
    public function getConfig(): array{debug: bool, options?: array<string>};
}

class ProductionConfig implements ConfigProvider {
    public function getConfig(): array{debug: bool, options: array<string>} {
        // Makes optional field required (valid narrowing)
        return ['debug' => false, 'options' => ['cache', 'minify']];
    }
}

$config = new ProductionConfig();
$cfg = $config->getConfig();
echo "Debug: " . ($cfg['debug'] ? 'yes' : 'no') . ", Options: " . count($cfg['options']) . "\n";

// Test 3: Abstract class with shape, concrete implementation
abstract class AbstractRepository {
    abstract public function find(int $id): array{id: int, created_at: string};
}

class ConcreteRepository extends AbstractRepository {
    public function find(int $id): array{id: int, created_at: string, updated_at: string} {
        return [
            'id' => $id,
            'created_at' => '2024-01-01',
            'updated_at' => '2024-06-15'
        ];
    }
}

$repo = new ConcreteRepository();
$item = $repo->find(5);
echo "Item {$item['id']} created: {$item['created_at']}\n";

echo "Done\n";
?>
--EXPECT--
Got data with id=1, name=Test
Debug: no, Options: 2
Item 5 created: 2024-01-01
Done
