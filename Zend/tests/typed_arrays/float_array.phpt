--TEST--
Typed array: array<float> functionality
--FILE--
<?php

function getPrices(): array<float> {
    return [19.99, 29.99, 39.99];
}

function calculateTotal(array<float> $prices): float {
    return array_sum($prices);
}

$prices = getPrices();
echo "Prices: " . implode(", ", $prices) . "\n";
echo "Total: " . calculateTotal($prices) . "\n";

?>
--EXPECT--
Prices: 19.99, 29.99, 39.99
Total: 89.97
