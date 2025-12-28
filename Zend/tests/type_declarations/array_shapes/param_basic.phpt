--TEST--
Array shape as parameter type - basic validation
--FILE--
<?php
declare(strict_arrays=1);

function processPoint(array{x: int, y: int} $point): int {
    return $point['x'] + $point['y'];
}

// Valid call
echo processPoint(['x' => 10, 'y' => 20]) . "\n";

// Extra keys are allowed (open shapes)
echo processPoint(['x' => 5, 'y' => 15, 'z' => 100]) . "\n";

?>
--EXPECT--
30
20
