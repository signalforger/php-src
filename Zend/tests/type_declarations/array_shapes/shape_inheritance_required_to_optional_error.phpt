--TEST--
Shape inheritance - cannot make required property optional
--XLEAK--
--FILE--
<?php

shape Base = array{id: int, name: string};
shape Child extends Base = array{name?: string};  // Invalid: required -> optional

?>
--EXPECTF--
Fatal error: Shape Child cannot make required property 'name' optional (inherited as required from parent) in %s on line %d
