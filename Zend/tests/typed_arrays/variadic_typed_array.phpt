--TEST--
Edge case: variadic parameter with typed array
--FILE--
<?php
declare(strict_arrays=1);

function mergeArrays(array<int> ...$arrays): array<int> {
    $result = [];
    foreach ($arrays as $arr) {
        $result = array_merge($result, $arr);
    }
    return $result;
}

$merged = mergeArrays([1, 2], [3, 4], [5, 6]);
echo "Merged: " . implode(", ", $merged) . "\n";

?>
--EXPECT--
Merged: 1, 2, 3, 4, 5, 6
