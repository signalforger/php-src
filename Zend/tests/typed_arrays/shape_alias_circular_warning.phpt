--TEST--
Shape alias: circular reference triggers warning
--XLEAK--
--FILE--
<?php


// Define shapes that reference each other creating a cycle
// When validating, this should hit the recursion depth limit

shape Node = array{
    value: int,
    next?: Node
};

function createNode(Node $node): void {
    echo "Node value: {$node['value']}\n";
}

// Simple case - no recursion
createNode(['value' => 1]);

// Nested case - one level deep
createNode(['value' => 1, 'next' => ['value' => 2]]);

// Deeply nested - tests recursion handling
$deep = ['value' => 1];
$current = &$deep;
for ($i = 2; $i <= 10; $i++) {
    $current['next'] = ['value' => $i];
    $current = &$current['next'];
}
createNode($deep);

echo "All validations passed\n";

?>
--EXPECT--
Node value: 1
Node value: 1
Node value: 1
All validations passed
