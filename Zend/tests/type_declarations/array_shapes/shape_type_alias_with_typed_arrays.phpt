--TEST--
Shape type alias with typed arrays
--FILE--
<?php
declare(strict_arrays=1);

shape Order = array{
    id: int,
    items: array<string>,
    total: float
};

function getOrder(): Order {
    return [
        "id" => 42,
        "items" => ["apple", "banana", "orange"],
        "total" => 12.99
    ];
}

$order = getOrder();
echo "Order #" . $order["id"] . " - $" . $order["total"] . "\n";
echo "Items: " . implode(", ", $order["items"]) . "\n";
?>
--EXPECT--
Order #42 - $12.99
Items: apple, banana, orange
