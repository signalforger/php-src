--TEST--
Spread operator with typed arrays - type error
--XLEAK--
--FILE--
<?php

// Test: Spreading array with wrong types into typed array parameter
function acceptInts(array<int> $numbers): int {
    return array_sum($numbers);
}

$mixed = [1, 2, 'three', 4];

try {
    acceptInts([...$mixed]);
} catch (TypeError $e) {
    echo "TypeError: " . $e->getMessage() . "\n";
}

// Test 2: Spread creates type mismatch
$strings = ['a', 'b', 'c'];

try {
    acceptInts([...$strings]);
} catch (TypeError $e) {
    echo "TypeError: " . $e->getMessage() . "\n";
}

echo "Done\n";
?>
--EXPECT--
TypeError: acceptInts(): Argument #1 ($numbers) must be of type array<int>, array element at index 2 is string
TypeError: acceptInts(): Argument #1 ($numbers) must be of type array<int>, array element at index 0 is string
Done
