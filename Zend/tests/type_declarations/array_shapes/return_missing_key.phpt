--TEST--
Array shape as return type - missing required key
--FILE--
<?php

function getPoint(): array{x: int, y: int} {
    return ['x' => 10];
}

try {
    getPoint();
} catch (TypeError $e) {
    echo "TypeError: " . $e->getMessage() . "\n";
}

?>
--EXPECT--
TypeError: getPoint(): Return value must be of type array{y: int, ...}, array given with missing key "y"
