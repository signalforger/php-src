--TEST--
Typed array: array<int> type error when returning wrong type
--FILE--
<?php

function getNumbers(): array<int> {
    return [1, 2, "three", 4];
}

try {
    getNumbers();
} catch (TypeError $e) {
    echo "Caught: " . $e->getMessage() . "\n";
}

?>
--EXPECTF--
Caught: getNumbers(): Return value must be of type array<int>, array containing string given
