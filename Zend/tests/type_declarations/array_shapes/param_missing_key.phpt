--TEST--
Array shape as parameter type - missing required key
--FILE--
<?php
declare(strict_arrays=1);

function processPoint(array{x: int, y: int} $point): int {
    return $point['x'] + $point['y'];
}

try {
    processPoint(['x' => 10]);
} catch (TypeError $e) {
    echo "TypeError: " . $e->getMessage() . "\n";
}

?>
--EXPECT--
TypeError: Argument #1 must be of type array{y: ...}, missing required key "y"
