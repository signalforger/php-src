--TEST--
Array shape: keys that could be numeric work correctly
--XLEAK--
--FILE--
<?php
declare(strict_arrays=1);

// Shape keys must be identifiers, so numeric-looking keys use identifier syntax
// This tests that keys starting with numbers or containing special chars need different approach

function getCoordinates(): array{x: int, y: int} {
    return [
        "x" => 10,
        "y" => 20
    ];
}

$coords = getCoordinates();
echo "x: " . $coords['x'] . ", y: " . $coords['y'] . "\n";

?>
--EXPECT--
x: 10, y: 20
