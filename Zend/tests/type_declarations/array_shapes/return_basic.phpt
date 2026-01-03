--TEST--
Array shape as return type - basic validation
--FILE--
<?php

function getPoint(): array{x: int, y: int} {
    return ['x' => 10, 'y' => 20];
}

$point = getPoint();
echo "x={$point['x']}, y={$point['y']}\n";

?>
--EXPECT--
x=10, y=20
