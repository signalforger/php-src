--TEST--
Closure: typed array in closure parameter and return type
--FILE--
<?php
declare(strict_arrays=1);

$transform = function(array<int> $numbers): array<int> {
    return array_map(fn($n) => $n * 2, $numbers);
};

$numbers = [1, 2, 3, 4, 5];
$doubled = $transform($numbers);
echo "Doubled: " . implode(", ", $doubled) . "\n";

?>
--EXPECT--
Doubled: 2, 4, 6, 8, 10
