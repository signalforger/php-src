--TEST--
::shape syntax - basic usage
--XLEAK--
--FILE--
<?php

shape UserShape = array{id: int, name: string};

echo UserShape::shape . "\n";

$name = UserShape::shape;
echo $name . "\n";

// Use in an expression
echo "Shape name is: " . UserShape::shape . "\n";

echo "Done\n";
?>
--EXPECT--
UserShape
UserShape
Shape name is: UserShape
Done
