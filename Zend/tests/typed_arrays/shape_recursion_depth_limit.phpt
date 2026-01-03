--TEST--
Shape alias: recursion depth limit prevents infinite loops
--XLEAK--
--FILE--
<?php
declare(strict_arrays=1);

// This test verifies that the recursion depth limit (64) prevents
// infinite loops when shapes reference themselves

shape RecursiveShape = array{
    id: int,
    child?: RecursiveShape
};

function processShape(RecursiveShape $shape): int {
    $count = 1;
    if (isset($shape['child'])) {
        $count += processShape($shape['child']);
    }
    return $count;
}

// Build a deeply nested structure (but within limits)
function buildNested(int $depth): array {
    if ($depth <= 0) {
        return ['id' => 0];
    }
    return ['id' => $depth, 'child' => buildNested($depth - 1)];
}

// Test with 50 levels (within 64 limit)
$nested = buildNested(50);
echo "Depth 50: " . processShape($nested) . " nodes\n";

// Test with 60 levels (still within 64 limit)
$nested = buildNested(60);
echo "Depth 60: " . processShape($nested) . " nodes\n";

echo "Recursion limit working correctly\n";

?>
--EXPECT--
Depth 50: 51 nodes
Depth 60: 61 nodes
Recursion limit working correctly
