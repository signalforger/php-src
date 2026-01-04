--TEST--
Shape cannot extend a class
--FILE--
<?php

class MyClass {}
shape BadShape extends MyClass = array{id: int};

?>
--EXPECTF--
Fatal error: Shape BadShape cannot extend class MyClass in %s on line %d
