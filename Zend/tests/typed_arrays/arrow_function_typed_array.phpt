--TEST--
Arrow function: typed array in arrow function parameter and return type
--FILE--
<?php


$filter = fn(array<int> $nums): array<int> => array_filter($nums, fn($n) => $n > 2);

$result = $filter([1, 2, 3, 4, 5]);
echo "Filtered: " . implode(", ", $result) . "\n";

?>
--EXPECT--
Filtered: 3, 4, 5
