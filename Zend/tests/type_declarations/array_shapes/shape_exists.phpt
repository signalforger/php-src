--TEST--
shape_exists() function
--FILE--
<?php
declare(strict_arrays=1);

// Before defining shape
var_dump(shape_exists('Point', false));
var_dump(shape_exists('NonExistent', false));

// Define a shape
shape Point = array{x: int, y: int};

// After defining shape
var_dump(shape_exists('Point', false));
var_dump(shape_exists('point', false));  // Case-insensitive
var_dump(shape_exists('POINT', false));  // Case-insensitive
var_dump(shape_exists('NonExistent', false));

// With autoload parameter (should still work without autoloader)
var_dump(shape_exists('Point', true));
var_dump(shape_exists('NonExistent', true));
?>
--EXPECT--
bool(true)
bool(false)
bool(true)
bool(true)
bool(true)
bool(false)
bool(true)
bool(false)
