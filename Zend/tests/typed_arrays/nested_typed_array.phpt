--TEST--
Typed array: nested array<array<int>> functionality
--FILE--
<?php
declare(strict_arrays=1);

function getMatrix(): array<array<int>> {
    return [
        [1, 2, 3],
        [4, 5, 6],
        [7, 8, 9]
    ];
}

$matrix = getMatrix();
foreach ($matrix as $i => $row) {
    echo "Row $i: " . implode(", ", $row) . "\n";
}

?>
--EXPECT--
Row 0: 1, 2, 3
Row 1: 4, 5, 6
Row 2: 7, 8, 9
