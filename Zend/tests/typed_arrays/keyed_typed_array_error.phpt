--TEST--
Typed array: array<string, int> key type error
--FILE--
<?php
declare(strict_arrays=1);

function getCounts(): array<string, int> {
    return [
        0 => 5,  // Error: integer key, expected string
        'oranges' => 3
    ];
}

getCounts();

?>
--EXPECTF--
Fatal error: Uncaught TypeError: getCounts(): Return value must be of type array<string, ...>, array contains int key in %s:%d
Stack trace:
#0 %s(%d): getCounts()
#1 {main}
  thrown in %s on line %d
