--TEST--
Class cannot extend a shape
--FILE--
<?php

shape MyShape = array{id: int, name: string};

class BadClass extends MyShape {
}

?>
--EXPECTF--
Fatal error: Class BadClass cannot extend shape MyShape in %s on line %d
