--TEST--
Typed array: array<int> parameter type error
--FILE--
<?php
declare(strict_arrays=1);

function sumNumbers(array<int> $nums): int {
    return array_sum($nums);
}

try {
    sumNumbers([1, 2, "three"]);
} catch (TypeError $e) {
    echo "Caught: " . $e->getMessage() . "\n";
}

?>
--EXPECTF--
Caught: sumNumbers(): Argument #1 ($nums) must be of type array<int>, array element at index 2 is string
