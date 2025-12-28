--TEST--
Typed array as parameter type - array<T>
--FILE--
<?php
declare(strict_arrays=1);

function sumNumbers(array<int> $numbers): int {
    return array_sum($numbers);
}

function joinStrings(array<string> $strings): string {
    return implode(', ', $strings);
}

echo sumNumbers([1, 2, 3, 4, 5]) . "\n";
echo joinStrings(['a', 'b', 'c']) . "\n";

?>
--EXPECT--
15
a, b, c
