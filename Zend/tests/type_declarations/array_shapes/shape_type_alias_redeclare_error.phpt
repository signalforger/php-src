--TEST--
Shape type alias redeclaration error
--FILE--
<?php

shape User = array{id: int};
shape User = array{name: string};

?>
--EXPECTF--
Fatal error: Cannot redeclare shape User in %s on line %d
