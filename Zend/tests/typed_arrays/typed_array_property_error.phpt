--TEST--
Typed array: property assignment type error
--XLEAK--
--FILE--
<?php


class Counter {
    public array<int> $counts = [];
}

$c = new Counter();

// Valid assignment
$c->counts = [1, 2, 3];
echo "Valid assignment: OK\n";

// Invalid assignment - string in int array
try {
    $c->counts = [1, 'two', 3];
} catch (TypeError $e) {
    echo "Invalid assignment: " . $e->getMessage() . "\n";
}

?>
--EXPECTF--
Valid assignment: OK
Invalid assignment: Cannot assign to property Counter::$counts of type array<int>, array element at index 1 is string
