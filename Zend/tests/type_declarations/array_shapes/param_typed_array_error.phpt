--TEST--
Typed array as parameter type - wrong element type
--FILE--
<?php

function sumNumbers(array<int> $numbers): int {
    return array_sum($numbers);
}

try {
    sumNumbers([1, 2, 'three', 4]);
} catch (TypeError $e) {
    echo "TypeError: " . $e->getMessage() . "\n";
}

?>
--EXPECT--
TypeError: sumNumbers(): Argument #1 ($numbers) must be of type array<int>, array element at index 2 is string
