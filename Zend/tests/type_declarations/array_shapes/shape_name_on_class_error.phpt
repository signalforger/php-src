--TEST--
::shape syntax - cannot use on class
--FILE--
<?php

class MyClass {}

echo MyClass::shape;
?>
--EXPECTF--
Fatal error: Cannot use ::shape on class MyClass, use ::class instead in %s on line %d
