--TEST--
Array shape as parameter type - wrong value type
--FILE--
<?php
declare(strict_arrays=1);

function processPoint(array{x: int, y: int} $point): int {
    return $point['x'] + $point['y'];
}

try {
    processPoint(['x' => 10, 'y' => 'not an int']);
} catch (TypeError $e) {
    echo "TypeError: " . $e->getMessage() . "\n";
}

?>
--EXPECT--
TypeError: Argument #1 key "y" must be of type int, string given
