--TEST--
Shape inheritance - invalid covariance (widening type error)
--XLEAK--
--FILE--
<?php

shape Base = array{id: int, value: string};
shape Child extends Base = array{value: int};  // Invalid: string -> int is not covariant

?>
--EXPECTF--
Fatal error: Shape Child property 'value' type int is not compatible with parent type string in %s on line %d
