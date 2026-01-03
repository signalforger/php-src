--TEST--
Abstract class: typed array in abstract method
--FILE--
<?php
declare(strict_arrays=1);

abstract class DataStore {
    abstract public function getItems(): array<string>;
    abstract public function addItem(string $item): void;
}

class InMemoryStore extends DataStore {
    private array<string> $items = [];

    public function getItems(): array<string> {
        return $this->items;
    }

    public function addItem(string $item): void {
        $this->items[] = $item;
    }
}

$store = new InMemoryStore();
$store->addItem("first");
$store->addItem("second");
echo "Items: " . implode(", ", $store->getItems()) . "\n";

?>
--EXPECT--
Items: first, second
