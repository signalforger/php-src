--TEST--
Typed array: array<mixed> accepts any values
--FILE--
<?php


function processAny(array<mixed> $items): void {
    foreach ($items as $item) {
        echo gettype($item) . ": " . (is_scalar($item) ? var_export($item, true) : gettype($item)) . "\n";
    }
}

processAny([1, 'hello', true, null, [1, 2, 3]]);

?>
--EXPECT--
integer: 1
string: 'hello'
boolean: true
NULL: NULL
array: array
