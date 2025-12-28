--TEST--
Array shape as return type - missing required key
--FILE--
<?php
declare(strict_arrays=1);

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
TypeError: getPoint(): Return value must be of type array{y: ...}, missing required key "y"
