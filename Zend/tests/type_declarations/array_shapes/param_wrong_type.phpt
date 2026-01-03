--TEST--
Array shape as parameter type - wrong value type
--FILE--
<?php

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
TypeError: processPoint(): Argument #1 ($point) must be of type array{y: int, ...}, array key "y" is string
