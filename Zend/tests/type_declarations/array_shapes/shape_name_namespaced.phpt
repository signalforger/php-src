--TEST--
::shape syntax - with namespaces
--XLEAK--
--FILE--
<?php

namespace App\Types;

shape UserShape = array{id: int, name: string};

// Should return fully qualified name
echo UserShape::shape . "\n";

namespace App\Other;

// Reference shape from another namespace
echo \App\Types\UserShape::shape . "\n";

echo "Done\n";
?>
--EXPECT--
App\Types\UserShape
App\Types\UserShape
Done
