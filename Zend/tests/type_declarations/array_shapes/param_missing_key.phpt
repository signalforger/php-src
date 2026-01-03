--TEST--
Array shape as parameter type - missing required key
--FILE--
<?php

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
TypeError: processPoint(): Argument #1 ($point) must be of type array{y: int, ...}, array given with missing key "y"
